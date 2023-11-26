<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\v1\BaseController;
use App\Models\ExcelData;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Person;
use DateTime;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadController extends BaseController
{
    public function index()
    {
        // $menu = $this->getMenuKeys(5);
        return view('upload.index'); // ->with('menuleft', $menu);
    }

    public function uploadExcel(Request $request)
    {
        // 1. Validar que se haya cargado un archivo Excel con una extensión válida
        $request->validate([
            'excel_file' => ['required', function ($attribute, $value, $fail) {
                if (!in_array($value->getClientOriginalExtension(), ['xlsx', 'xls'])) {
                    $fail('El archivo subido no es un archivo Excel válido.');
                }
            }],
        ]);

        // 2. Obtener el archivo Excel del request
        $file = $request->file('excel_file');

        // 3. Validar si el archivo es válido
        if (!$file || !$file->isValid()) {
            return $this->sendError('El archivo subido no es válido.', [], 400);
        }

        // 4. Generar un nombre de archivo único basado en la marca de tiempo
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // 5. Mover el archivo a la ubicación de almacenamiento (en este caso, la carpeta 'uploads')
        $path = public_path('uploads') . '/' . $filename;
        $file->move(public_path('uploads'), $filename);

        $excelData = [];

        try {
            // 6. Cargar el archivo Excel utilizando la biblioteca PhpSpreadsheet
            $spreadsheet = IOFactory::load($path);
        } catch (\Exception $e) {
            return $this->sendError('El archivo subido no es un archivo Excel válido.', [], 400);
        }

        // 7. Obtener la hoja de cálculo activa y convertirla en un array
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $headers = $rows[0];

        // 8. Validar que las cabeceras coincidan con lo esperado
        if ($headers[0] !== 'AC-No.' || $headers[1] !== 'Nombre' || $headers[2] !== 'Horario' || $headers[3] !== 'Estado') {
            return $this->sendError('Las cabeceras del archivo no son las esperadas.', [], 400);
        }

        // 9. Procesar y transformar los datos del archivo Excel
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            $acno = $row[0];
            $nombre = $row[1];
            $horarioOriginal = $row[2];
            $horario = DateTime::createFromFormat('d/m/Y h:i a', $horarioOriginal)->format('Y-m-d H:i:s');
            $estado = $row[3];

            $excelData[] = [
                'ACNo' => $acno,
                'Nombre' => $nombre,
                'Horario' => $horario,
                'Estado' => $estado,
            ];
        }

        // 10. Eliminar el archivo temporal
        unlink($path);

        // 11. Guardar los datos procesados en la base de datos(Esto puede ser opcional)
        // foreach ($excelData as $data) {
        //     $model = new ExcelData();
        //     $model->acno = $data['AC-No.'];
        //     $model->nombre = $data['Nombre'];
        //     $model->horario = $data['Horario'];
        //     $model->estado = $data['Estado'];
        //     $model->save();
        // }
        $model = new ExcelData();
        $model->excel_json = json_encode($excelData); // Almacena los datos procesados como JSON
        $model->save();

        // 12. Preparar una respuesta JSON que contiene los datos procesados y sin procesar
        // $response = array(
        //     'message' => 'Archivo subido correctamente',
        //     'total' => count($rows),
        //     'rows' => $rows,
        //     'excelData' => $excelData,
        // );

        // 13. Devolver la respuesta JSON al cliente
        return response()->json($excelData);
    }

    public function saveAttendancesOfExcel(Request $request) {
        $dataExcel = $request->input('dataExcel');

        foreach ($dataExcel as $key => $value) {
            $nombreCompleto = $value['Nombre'];

            $employee = Employee::select(
                'employees.id',
                'people.PerNameMarker',
                'people.PerName',
                'people.PerLastName',
                'people.PerMotherLastName'
            )
            ->join('people', 'employees.PersonId', '=', 'people.id')
            ->whereRaw("people.PerNameMarker LIKE ?", ["%$nombreCompleto%"])
            ->first();

            if (!$employee) {
                //Si no existe el trabajador entonces se creará
                $partes = explode(" ", $value['Nombre']);

                // Asigna las partes a variables individuales
                $PerLastName = $partes[0];
                $PerMotherLastName = $partes[1];
                $PerName = $partes[2];

                // Crea un nuevo registro de empleado en la base de datos
                $newPerson = new Person();
                $newPerson->PerNameMarker =  $value['Nombre'];
                $newPerson->PerName = $PerName;
                $newPerson->PerLastName = $PerLastName;
                $newPerson->PerMotherLastName = $PerMotherLastName;
                $newPerson->save();

                $newEmployee = new Employee();
                $newEmployee->PersonId = $newPerson->id;
                $newEmployee->save();

                $employee = $newEmployee;
            }

            if ($value['Estado'] == 'M/Ent') {
                //Se crea una nueva asistencia
                $newAttendance = new Attendance();
                $newAttendance->EmpId = $employee->id;
                $newAttendance->date_assistent = date("Y-m-d", strtotime($value['Horario']));
                $newAttendance->start_marking_time = date("H:i:s", strtotime($value['Horario']));
                $newAttendance->save();
            }else{
                //Se agrega la hora de salida a la asistencia
                $attendance = Attendance::select()
                    ->where('EmpId', '=', $employee->id)
                    ->whereDate('date_assistent', '=', date("Y-m-d", strtotime($value['Horario'])))
                    ->first();

                if ($attendance) {
                    // Actualizar el campo end_date
                    $attendance->end_marking_time = date("H:i:s", strtotime($value['Horario']));
                    $attendance->save();
                }
            }
        }
        return response()->json("Ok");

    }
}

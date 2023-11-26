<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\v1\BaseController;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Person;
use Illuminate\Http\Request;

class AttendanceController extends BaseController
{
    public function index()
    {
        // $menu = $this->getMenuKeys(5);
        return view('attendance.index');
            // ->with('menuleft', $menu);
    }

    public function dataAttendance()
    {
        $attendances = Attendance::select(
            'attendance.id',
            'attendance.date_assistent',
            'attendance.start_marking_time',
            'attendance.edited_time',
            'attendance.justified_time',
            'attendance.justified',
            'attendance.end_marking_time',
            'attendance.EmpId',
            // 'employees.id',
            // 'people.id',
            'people.PerName',
            'people.PerLastName',
            'people.PerMotherLastName',
        )->join('employees', 'attendance.EmpId', '=', 'employees.id')
        ->join('people', 'employees.PersonId', '=', 'people.id')
        ->get();

        return response()->json($attendances);
    }

    public function createAttendance()
    {
        $employees = Employee::select(
            'employees.id',
            // 'people.id',
            'people.PerName',
            'people.PerLastName',
            'people.PerMotherLastName',
        )->join('people', 'employees.PersonId', '=', 'people.id')
        ->get();
        // $person = Person::all();
        return view('attendance.create-attendance')
                // ->with('person', $person)
                ->with('employees', $employees);
    }

    public function saveAttendance(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'date_assistent' => 'required',
            'start_marking_time' => 'required',
            'end_marking_time' => 'required',
            // 'edited_time' => 'required',
            // 'justified_time' => 'required',
            // 'justified' => 'required',
            'EmpId' => 'required',
        ]);

        // Crea un nuevo registro de área en la base de datos
        $attendance = new Attendance;
        $attendance->date_assistent = $request->input('date_assistent');
        $attendance->start_marking_time = $request->input('start_marking_time');
        $attendance->end_marking_time = $request->input('end_marking_time');
        $attendance->edited_time = $request->input('edited_time');
        $attendance->justified_time = $request->input('justified_time');
        $attendance->justified = $request->input('justified');
        $attendance->EmpId = $request->input('EmpId');
        $attendance->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Asistencia creada con éxito']);
    }

    public function editAttendance($id)
    {
        // $attendances = Attendance::find($id);
        $employees = Employee::select(
            'employees.id',
            // 'people.id',
            'people.PerName',
            'people.PerLastName',
            'people.PerMotherLastName',
        )->join('people', 'employees.PersonId', '=', 'people.id')
        ->get();

        $attendances = Attendance::select(
            'attendance.id',
            'attendance.date_assistent',
            'attendance.start_marking_time',
            'attendance.edited_time',
            'attendance.justified_time',
            'attendance.justified',
            'attendance.end_marking_time',
            'attendance.EmpId',
            // 'employees.id',
            // 'people.id',
            'people.PerName',
            'people.PerLastName',
            'people.PerMotherLastName',
        )->join('employees', 'attendance.EmpId', '=', 'employees.id')
        ->join('people', 'employees.PersonId', '=', 'people.id')
        ->find($id);

        if (!$attendances) {
            // Cronograma no encontrado, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Cronograma no encontrado'], 404);
        }

        // Devuelve una vista con los detalles del área si se encuentra
        return view('attendance.edit-attendance')
                ->with('attendances', $attendances)
                ->with('employees', $employees);
    }

    public function updateAttendance(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'date_assistent' => 'required',
            'start_marking_time' => 'required',
            'end_marking_time' => 'required',
            // 'edited_time' => 'required',
            // 'justified_time' => 'required',
            // 'justified' => 'required',
            'EmpId' => 'required',
        ]);

        // Encuentra el área por su ID
        $attendance = Attendance::find($id);

        if (!$attendance) {
            // Maneja el caso en el que el área no se encuentra
            return response()->json(['error' => 'Asistencia no encontrada'], 404);
        }

        // Actualiza los datos del área
        $attendance->date_assistent = $request->input('date_assistent');
        $attendance->start_marking_time = $request->input('start_marking_time');
        $attendance->end_marking_time = $request->input('end_marking_time');
        $attendance->edited_time = $request->input('edited_time');
        $attendance->justified_time = $request->input('justified_time');
        $attendance->justified = $request->input('justified');
        $attendance->EmpId = $request->input('EmpId');
        $attendance->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Asistencia actualizada con éxito']);
    }

    public function deleteAttendance($id)
    {
        $attendance = Attendance::find($id);
        if (!$attendance) {
            // Área no encontrada, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Asistencia no encontrada'], 404);
        }

        // Realiza una eliminación suave del área
        $attendance->delete();

        // Devuelve una respuesta JSON de éxito
        return response()->json(['success' => 'Asistencia desactivada con éxito']);
    }
}

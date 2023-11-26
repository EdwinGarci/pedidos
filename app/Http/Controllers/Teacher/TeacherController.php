<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\v1\BaseController;
use App\Models\Area;
use App\Models\Teacher;
use App\Models\Person;
use App\Models\Schedule;
use Illuminate\Http\Request;

class TeacherController extends BaseController
{
    public function index()
    {
        return view('teacher.index');
    }

    public function dataTeacher()
    {
        $teacher = Teacher::select(
            'teachers.id', 'email', 'civil_status',
            'faculty', 'faculty_department', 'category',
            'codality', 'job_title', 'condition_teacher',
            'professional_grade', 'person.name', 'lastname',
            'address', 'dni', 'birthdate',
            'phone'
        )
        ->join('person', 'person.id', '=', 'teachers.person_id')
        ->get();
        return response()->json($teacher);
    }

    public function createTeacher()
    {
        $person = Person::all();
        return view('teacher.create-teacher')
                ->with('person', $person);
    }

    // public function saveTeacher(Request $request)
    // {
    //     // Valida los datos del formulario
    //     $request->validate([
    //         // 'AreaId' => 'required',
    //         // 'ScheduleId' => 'required',
    //         'name' => 'required',
    //         'lastname_p' => 'required',
    //         'lastname_m' => 'required',
    //         // 'dni' => 'required',
    //         // 'type_teacher' => 'required',
    //     ]);

    //     // Crea un nuevo registro de empleado en la base de datos
    //     $person = new Person();
    //     $person->PerName = $request->input('name');
    //     $person->PerLastName = $request->input('lastname_p');
    //     $person->PerMotherLastName = $request->input('lastname_m');
    //     $person->PerDni = $request->input('dni');
    //     $person->PerNameMarker = strtoupper($person->PerName . ' ' . $person->PerLastName . ' ' . $person->PerMotherLastName);
    //     $person->save();

    //     $teacher = new Teacher;
    //     $teacher->EmpType = $request->input('EmpType');
    //     $teacher->AreaId = $request->input('AreaId');
    //     $teacher->ScheduleId = $request->input('ScheduleId');
    //     $teacher->PersonId = $person->id;
    //     $teacher->save();

    //     // Devuelve una respuesta JSON con un mensaje de éxito
    //     return response()->json(['success' => 'Empleado creado con éxito']);
    // }

    // public function editTeacher($id)
    // {
    //     $areas = Area::all();
    //     $person = Person::all();
    //     $schedule = Schedule::select(
    //         'id',
    //         'type_teacher',
    //         'start_time',
    //         'end_time'
    //     )->get();
    //     // $teacher = Teacher::find($id);

    //     $teacher = Teacher::select(
    //         'areas.AreaName',
    //         'teacher.id',
    //         'teacher.EmpType',
    //         'teacher.AreaId',
    //         'teacher.ScheduleId',
    //         'teacher.PersonId',
    //         'people.PerName',
    //         'people.PerLastName',
    //         'people.PerMotherLastName',
    //         'people.PerDni',
    //         'schedules.type_teacher',
    //         'schedules.start_time',
    //         'schedules.end_time',
    //     )->leftjoin('areas', 'teacher.AreaId', '=', 'areas.id')
    //     ->leftjoin('schedules', 'teacher.ScheduleId', '=', 'schedules.id')
    //     ->join('people', 'teacher.PersonId', '=', 'people.id')
    //     ->find($id);

    //     if (!$teacher) {
    //         // Devuelve una respuesta JSON de error
    //         return response()->json(['error' => 'Empleado no encontrado'], 404);
    //     }

    //     // Devuelve una vista con los detalles del empleado si se encuentra
    //     return view('teacher.edit-teacher')
    //         ->with('teacher', $teacher)
    //         ->with('areas', $areas)
    //         ->with('person', $person)
    //         ->with('schedule', $schedule);
    // }

    // public function updateTeacher(Request $request, $id)
    // {
    //     // Valida los datos del formulario
    //     $request->validate([
    //         'AreaId' => 'required',
    //         'ScheduleId' => 'required',
    //         'name' => 'required',
    //         'lastname_p' => 'required',
    //         'lastname_m' => 'required',
    //         // 'dni' => 'required',
    //         // 'type_teacher' => 'required',
    //     ]);

    //     // Encuentra el empleado por su ID
    //     $teacher = Teacher::find($id);

    //     if (!$teacher) {
    //         // Devuelve una respuesta JSON de error
    //         return response()->json(['error' => 'Empleado no encontrado'], 404);
    //     }

    //     // Obtiene el valor de PersonId desde el empleado
    //     $personId = $teacher->PersonId;

    //     // Encuentra la persona por su ID
    //     $person = Person::find($personId);

    //     if (!$person) {
    //         // Devuelve una respuesta JSON de error
    //         return response()->json(['error' => 'Persona no encontrada'], 404);
    //     }

    //     // Actualiza los datos del empleado
    //     $person->PerName = $request->input('name');
    //     $person->PerLastName = $request->input('lastname_p');
    //     $person->PerMotherLastName = $request->input('lastname_m');
    //     $person->PerDni = $request->input('dni');
    //     $person->save();

    //     $teacher->EmpType = $request->input('EmpType');
    //     $teacher->AreaId = $request->input('AreaId');
    //     $teacher->ScheduleId = $request->input('ScheduleId');
    //     $teacher->PersonId = $person->id;
    //     $teacher->save();

    //     // Devuelve una respuesta JSON con un mensaje de éxito
    //     return response()->json(['success' => 'Área actualizada con éxito']);
    // }

    // public function deleteTeacher($id)
    // {
    //     $teacher = Teacher::find($id);

    //     if (!$teacher) {
    //         // Área no encontrada, devuelve una respuesta JSON de error
    //         return response()->json(['error' => 'Empleado no encontrado'], 404);
    //     }

    //     // Realiza una eliminación suave del área
    //     $teacher->delete();

    //     // Devuelve una respuesta JSON de éxito
    //     return response()->json(['success' => 'Empleado desactivado con éxito']);
    // }
}

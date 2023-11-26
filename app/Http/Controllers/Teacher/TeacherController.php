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
            'professional_grade', 'date_of_admission', 'person.name', 'lastname',
            'address', 'dni', 'birthdate',
            'teacher_status', 'phone'
        )
        //Codality es modalidad
        ->join('person', 'person.id', '=', 'teachers.person_id')
        ->get();
        return response()->json($teacher);
    }

    public function createTeacher()
    {
        $person = Person::all();
        $civilStatusOptions = ['Soltero', 'Casado', 'Viudo', 'Divorciado'];
        $teacherStatusOptions = ['Activo', 'Renuncio', 'Fallecido'];
        return view('teacher.create-teacher')
                ->with('person', $person)
                ->with('civilStatusOptions', $civilStatusOptions)
                ->with('teacherStatusOptions', $teacherStatusOptions);
    }

    public function saveTeacher(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            // 'AreaId' => 'required',
            // 'ScheduleId' => 'required',
            // 'name' => 'required',
            // 'lastname_p' => 'required',
            // 'lastname_m' => 'required',
            // 'dni' => 'required',
            // 'type_teacher' => 'required',
        ]);

        // Crea un nuevo registro de empleado en la base de datos
        $person = new Person();
        $person->name = $request->input('name');
        $person->lastname = $request->input('lastname');
        $person->address = $request->input('address');
        $person->dni = $request->input('dni');
        $person->sex = $request->input('sex');
        $person->birthdate = $request->input('birthdate');
        $person->phone = $request->input('phone');
        $person->save();

        $teacher = new Teacher;
        $teacher->email = $request->input('email');
        $teacher->civil_status = $request->input('civilStatus');
        $teacher->faculty = $request->input('faculty');
        $teacher->faculty_deparment = $request->input('facultyDepartment');
        $teacher->category = $request->input('category');
        $teacher->codality = $request->input('codality');
        $teacher->job_title = $request->input('jobTitle');
        $teacher->condition_teacher = $request->input('condition');
        $teacher->professional_grade = $request->input('professionalGrade');
        $teacher->date_of_admission = $request->input('dateAdmission');
        $teacher->teacher_status = $request->input('teacherStatus');
        $teacher->person_id = $person->id;
        $teacher->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Maestro creado con éxito']);
    }

    public function editTeacher($id)
    {
        $person = Person::all();
        $teacher = Teacher::select(
            'teachers.id', 'email', 'civil_status',
            'faculty', 'faculty_department', 'category',
            'codality', 'job_title', 'condition_teacher',
            'professional_grade', 'date_of_admission', 'person.name', 'lastname',
            'address', 'dni', 'birthdate',
            'teacher_status', 'phone'
        )
        //Codality es modalidad
        ->join('person', 'person.id', '=', 'teachers.person_id')
        ->find($id);

        if (!$teacher) {
            // Devuelve una respuesta JSON de error
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }

        // Devuelve una vista con los detalles del empleado si se encuentra
        return view('teacher.edit-teacher')
            ->with('teacher', $teacher)
            ->with('person', $person);
    }

    public function updateTeacher(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            // 'AreaId' => 'required',
            // 'ScheduleId' => 'required',
            // 'name' => 'required',
            // 'lastname_p' => 'required',
            // 'lastname_m' => 'required',
            // 'dni' => 'required',
            // 'type_teacher' => 'required',
        ]);

        // Encuentra el empleado por su ID
        $teacher = Teacher::find($id);

        if (!$teacher) {
            // Devuelve una respuesta JSON de error
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }

        // Obtiene el valor de PersonId desde el empleado
        $personId = $teacher->PersonId;

        // Encuentra la persona por su ID
        $person = Person::find($personId);

        if (!$person) {
            // Devuelve una respuesta JSON de error
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }

        // Actualiza los datos del empleado
        $person->name = $request->input('name');
        $person->lastname = $request->input('lastname');
        $person->address = $request->input('address');
        $person->dni = $request->input('dni');
        $person->sex = $request->input('sex');
        $person->birthdate = $request->input('birthdate');
        $person->phone = $request->input('phone');
        $person->save();

        $teacher->email = $request->input('email');
        $teacher->civil_status = $request->input('civilStatus');
        $teacher->faculty = $request->input('faculty');
        $teacher->faculty_deparment = $request->input('facultyDepartment');
        $teacher->category = $request->input('category');
        $teacher->codality = $request->input('codality');
        $teacher->job_title = $request->input('jobTitle');
        $teacher->condition_teacher = $request->input('condition');
        $teacher->professional_grade = $request->input('professionalGrade');
        $teacher->date_of_admission = $request->input('dateAdmission');
        $teacher->teacher_status = $request->input('teacherStatus');
        $teacher->person_id = $person->id;
        $teacher->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Área actualizada con éxito']);
    }

    public function deleteTeacher($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            // Área no encontrada, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }

        // Realiza una eliminación suave del área
        $teacher->delete();

        // Devuelve una respuesta JSON de éxito
        return response()->json(['success' => 'Empleado desactivado con éxito']);
    }
}

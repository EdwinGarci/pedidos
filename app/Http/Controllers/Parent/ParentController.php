<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\v1\BaseController;
use App\Models\Parents;
use App\Models\Person;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ParentController extends BaseController
{
    public function index()
    {
        // $menu = $this->getMenuKeys(5);
        return view('parent.index');
            // ->with('menuleft', $menu);
    }

    public function dataParent()
    {
        $parents = Parents::select(
            'parent.id',
            'relationship',
            'parent_person.name AS parent_name',
            'parent_person.lastname AS parent_lastname',
            'parent_person.sex AS parent_sex',
            'parent_person.birthdate AS parent_birthdate',
            'teacher_person.name AS teacher_name',
            'teacher_person.lastname AS teacher_lastname',
        )->join('person AS parent_person', 'parent_person.id', '=', 'parent.person_id')
        ->leftJoin('teachers', 'teachers.id', '=', 'parent.teacher_id')
        ->leftJoin('person AS teacher_person', 'teacher_person.id', '=', 'teachers.person_id')
        ->get();
        return response()->json($parents);
    }

    public function createParent()
    {
        $person = Person::all();
        $teacher = Teacher::all();
        return view('parent.create-parent')
                ->with('teacher', $teacher)
                ->with('person', $person);
    }

    public function saveParent(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            // 'type_employee' => 'required|string|max:255',
            // 'start_time' => 'required',
            // 'end_time' => 'required',
        ]);

        $person = new Person();
        $person->name = $request->input('parent_name');
        $person->lastname = $request->input('parent_lastname');
        $person->sex = $request->input('parent_sex');
        $person->birthdate = $request->input('parent_birthdate');
        $person->save();

        $parent = new Parents;
        $parent->relationship = $request->input('type_parent');
        $parent->teacher_id = $request->input('teacherType');
        $parent->person_id = $person->id;
        $parent->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Pariente creado con éxito']);
    }

    public function editParent($id)
    {
        $parent = Parents::find($id);

        if (!$parent) {
            // Cronograma no encontrado, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Pariente no encontrado'], 404);
        }

        // Devuelve una vista con los detalles del área si se encuentra
        return view('parent.edit-parent')
                ->with('parent', $parent)
                ->with('parent', $parent);
    }

    public function updateParent(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'type_employee' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Encuentra el área por su ID
        $parent = Parents::find($id);

        if (!$parent) {
            // Maneja el caso en el que el área no se encuentra
            return response()->json(['error' => 'Pariente no encontrado'], 404);
        }

        // Actualiza los datos del área
        $parent->type_employee = $request->input('type_employee');
        $parent->start_time = $request->input('start_time');
        $parent->end_time = $request->input('end_time');
        $parent->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Pariente actualizado con éxito']);
    }

    public function deleteParent($id)
    {
        $parent = Parents::find($id);

        if (!$parent) {
            // Área no encontrada, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Pariente no encontrado'], 404);
        }

        // Realiza una eliminación suave del área
        $parent->delete();

        // Devuelve una respuesta JSON de éxito
        return response()->json(['success' => 'Pariente desactivado con éxito']);
    }
}

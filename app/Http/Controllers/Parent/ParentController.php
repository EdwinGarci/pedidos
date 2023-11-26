<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\v1\BaseController;
use App\Models\Parents;
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
        $parents = Parents::all();

        return response()->json($parents);
    }

    public function createParent()
    {
        return view('parent.create-parent');
    }

    public function saveParent(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'type_employee' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);


        // Crea un nuevo registro de área en la base de datos
        $parent = new Parents;
        $parent->type_employee = $request->input('type_employee');
        $parent->start_time = $request->input('start_time');
        $parent->end_time = $request->input('end_time');
        $parent->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Cronograma creado con éxito']);
    }

    public function editParent($id)
    {
        $parent = Parents::find($id);

        if (!$parent) {
            // Cronograma no encontrado, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Cronograma no encontrado'], 404);
        }

        // Devuelve una vista con los detalles del área si se encuentra
        return view('parent.edit-parent')->with('parent', $parent);
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
            return response()->json(['error' => 'Cronograma no encontrado'], 404);
        }

        // Actualiza los datos del área
        $parent->type_employee = $request->input('type_employee');
        $parent->start_time = $request->input('start_time');
        $parent->end_time = $request->input('end_time');
        $parent->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Cronograma actualizado con éxito']);
    }

    public function deleteParent($id)
    {
        $parent = Parents::find($id);

        if (!$parent) {
            // Área no encontrada, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Cronograma no encontrado'], 404);
        }

        // Realiza una eliminación suave del área
        $parent->delete();

        // Devuelve una respuesta JSON de éxito
        return response()->json(['success' => 'Cronograma desactivado con éxito']);
    }
}

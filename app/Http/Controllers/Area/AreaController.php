<?php

namespace App\Http\Controllers\Area;

use App\Http\Controllers\v1\BaseController;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends BaseController
{
    public function index()
    {
        // $menu = $this->getMenuKeys(5);
        return view('area.index');
            // ->with('menuleft', $menu);
    }

    public function dataArea()
    {
        $areas = Area::select(
            'areas.id',
            'areas.AreaName'
        )->get();

        return response()->json($areas);
    }

    public function createArea()
    {
        return view('area.create-area');
    }

    public function saveArea(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'nombreArea' => 'required|string|max:255',
        ]);

        // Crea un nuevo registro de área en la base de datos
        $area = new Area;
        $area->AreaName = $request->input('nombreArea');
        $area->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Área creada con éxito']);
    }

    public function editArea($id)
    {
        $area = Area::find($id);

        if (!$area) {
            // Área no encontrada, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Área no encontrada'], 404);
        }

        // Devuelve una vista con los detalles del área si se encuentra
        return view('area.edit-area')->with('area', $area);
    }

    public function updateArea(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'NombreArea' => 'required|string|max:255',
        ]);

        // Encuentra el área por su ID
        $area = Area::find($id);

        if (!$area) {
            // Maneja el caso en el que el área no se encuentra
            return response()->json(['error' => 'Área no encontrada'], 404);
        }

        // Actualiza los datos del área
        $area->AreaName = $request->input('NombreArea');
        $area->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Área actualizada con éxito']);
    }

    public function deleteArea($id)
    {
        $area = Area::find($id);

        if (!$area) {
            // Área no encontrada, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Área no encontrada'], 404);
        }

        // Realiza una eliminación suave del área
        $area->delete();

        // Devuelve una respuesta JSON de éxito
        return response()->json(['success' => 'Área desactivada con éxito']);
    }
}

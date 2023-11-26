<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\v1\BaseController;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends BaseController
{
    public function index()
    {
        // $menu = $this->getMenuKeys(5);
        return view('schedule.index');
            // ->with('menuleft', $menu);
    }

    public function dataSchedule()
    {
        $schedules = Schedule::all();

        return response()->json($schedules);
    }

    public function createSchedule()
    {
        return view('schedule.create-schedule');
    }

    public function saveSchedule(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'type_employee' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);


        // Crea un nuevo registro de área en la base de datos
        $schedule = new Schedule;
        $schedule->type_employee = $request->input('type_employee');
        $schedule->start_time = $request->input('start_time');
        $schedule->end_time = $request->input('end_time');
        $schedule->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Cronograma creado con éxito']);
    }

    public function editSchedule($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            // Cronograma no encontrado, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Cronograma no encontrado'], 404);
        }

        // Devuelve una vista con los detalles del área si se encuentra
        return view('schedule.edit-schedule')->with('schedule', $schedule);
    }

    public function updateSchedule(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'type_employee' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Encuentra el área por su ID
        $schedule = Schedule::find($id);

        if (!$schedule) {
            // Maneja el caso en el que el área no se encuentra
            return response()->json(['error' => 'Cronograma no encontrado'], 404);
        }

        // Actualiza los datos del área
        $schedule->type_employee = $request->input('type_employee');
        $schedule->start_time = $request->input('start_time');
        $schedule->end_time = $request->input('end_time');
        $schedule->save();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Cronograma actualizado con éxito']);
    }

    public function deleteSchedule($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            // Área no encontrada, devuelve una respuesta JSON de error
            return response()->json(['error' => 'Cronograma no encontrado'], 404);
        }

        // Realiza una eliminación suave del área
        $schedule->delete();

        // Devuelve una respuesta JSON de éxito
        return response()->json(['success' => 'Cronograma desactivado con éxito']);
    }
}

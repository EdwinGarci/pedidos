<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\v1\BaseController;
use App\Models\Area;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends BaseController
{
    public function index()
    {
        $areas = Area::all();
        $employees = Employee::select(
            'employees.id',
            // 'people.id',
            'people.PerName',
            'people.PerLastName',
            'people.PerMotherLastName',
        )->join('people', 'employees.PersonId', '=', 'people.id')
        ->get();
        return view('reports.index')
                ->with('areas', $areas)
                ->with('employees', $employees);
    }

    public function generatePdf(Request $request)
    {
        $request->validate([
            // 'employee_id' => 'required|numeric',
            // 'area_id => 'required',
            // 'date' => 'required'
        ]);
        $selectedEmployeeId = $request->input('employee_id');
        $selectedAreaId = $request->input('area_id');
        $selectedDate = $request->input('date');

        $data = Attendance::join('employees', 'attendance.EmpId', '=', 'employees.id')
        // ->join('people', 'employees.PersonId', '=', 'people.id')
        ->leftjoin('areas', 'employees.AreaId', '=', 'areas.id')
        ->where('EmpId', $selectedEmployeeId)
        ->where('AreaId', $selectedAreaId)
        ->where('date_assistent', $selectedDate)
        ->get();

        // Genera el informe en PDF
        $pdf = Pdf::loadView('reports.report', compact('data'));

        // return $pdf->stream('informe.pdf');
        return $pdf->download('informe.pdf');
    }
}

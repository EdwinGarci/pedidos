@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <span class=" p-0 m-0 sourcesans h4">Reportes - Filtros</span>
    </div>
</div>
@stop

@section('content')
<nav class="w-100 sourcesans fs-14">
    <div class="nav nav-tabs" id="user-tab" role="tablist">
        <a class="nav-item nav-link active" id="user-list-tab" data-toggle="tab" href="#user-list-desc" role="tab" aria-controls="user-list-desc" aria-selected="true">
            <i class="fas fa-list mr-1"></i>
            Lista
        </a>
    </div>
</nav>

<div class="tab-content p-3 border rounded bg-white position-relative" id="nav-tabContent">
    <div class="tab-pane fade active show" id="user-list-desc" role="tabpanel" aria-labelledby="user-list-tab">
        <div id="toolbar">
            <!-- <div class="form-group" id="persona-filter">
                <label for="persona">Seleccionar Empleado:</label>
                <select class="form-control" id="employeeAttendance" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">
                            {{ $employee->PerName }} {{ $employee->PerLastName }} {{ $employee->PerMotherLastName }}
                        </option>
                    @endforeach
                </select>
            </div> -->
            <div class="form-group" id="persona-filter">
                <label for="persona">Seleccionar o Ingresar Empleado:</label>
                <input list="employees" class="form-control" id="employeeReport" aria-label="Default select example" name="employee">
                <datalist id="employees">
                    <option value="Seleccionar" disabled selected>Seleccionar</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->PerName }} {{ $employee->PerLastName }} {{ $employee->PerMotherLastName }}">
                    @endforeach
                </datalist>
            </div>
            <div class="form-group" id="area-filter">
                <label for="area">Seleccionar Área:</label>
                <select class="form-control" id="areaReport" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->AreaName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="fecha-filter">
                <label for="fecha">Seleccionar Fecha (Mes):</label>
                <div class="input-group">
                    <input type="date" id="dateReport" value="" class="form-control form-control-sm rounded-0" />
                </div>
            </div>
            <button id="generateReportButton" class="btn btn-primary">Generar Informe</button>
        </div>
    </div>
</div>
<br><br>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Configuracion de encabezados
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            async: true
        });

        // Funcion General
        async function httpMyRequest(url, data) {
            let uri = "{!! url('') !!}";
            var result = await $.ajax({
                url: uri + url,
                type: 'POST',
                data: data,
                headers: {
                    'Content-Type': 'application/json'
                },
            });
            return result;
        }

        // Validación de empleado al cambiar el input
        $('#employeeReport').on('change', function() {
            var input = $(this).val();
            var datalist = $('#employees');
            var options = datalist.find('option');

            var isValid = Array.from(options).some(function(option) {
                return option.value === input;
            });

            if (!isValid) {
                alert('Por favor, selecciona un empleado válido.');
                $(this).val(''); // Limpiar el valor del input si no es válido
            }
        });

        // function downloadFile(response) {
        //     var blob = new Blob([response], {type: 'application/pdf'})
        //     var url = URL.createObjectURL(blob);
        //     // Abre la URL en una nueva pestaña
        //     window.open(url, '_blank');
        // }

        $('#generateReportButton').click(async function() {
            console.log('Botón de generar informe clickeado.');
            try {
                const selectedEmployeeId = $('#employeeReport').val();
                const selectedAreaId = $('#areaReport').val();
                const selectedDate = $('#dateReport').val();

                console.log("dselectedEmployeeId: " + selectedEmployeeId);
                console.log("selectedAreaId: " + selectedAreaId);
                console.log("selectedDate: " + selectedDate);

                let uri = "{!! url('') !!}";
                const response = await $.ajax({
                    url: uri + '/api/report-generate',
                    method: 'POST',
                    data: {
                        employee_id: selectedEmployeeId,
                        area_id: selectedAreaId,
                        date: selectedDate
                    },
                    headers: {
                        'Accept': 'application/pdf',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        responseType: 'blob' // Esto es importante para indicar que la respuesta es un archivo binario
                    },
                });
                const blob = new Blob([response], {
                    type: 'application/pdf'
                });
                // const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'informe.pdf';
                a.click();
                window.URL.revokeObjectURL(url);
                alert('Informe generado con éxito.');
            } catch (error) {
                console.error('Error al intentar generar el reporte:', error);
                alert('Error al generar el informe. Por favor, inténtalo de nuevo.');
            }
        });

    });
</script>
@stop

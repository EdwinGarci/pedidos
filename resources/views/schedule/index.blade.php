@extends('adminlte::page')

@section('title', 'Cronograma')

@section('content_header')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <span class="p-0 m-0 sourcesans h4">Cronograma</span>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Cronograma</h5>
        <button id="createScheduleButton" class="btn btn-primary btn-sm">Crear cronograma</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="schedule-table" class="table table-bordered table-hover" data-page-size="25" data-toggle="table" data-pagination="true" data-search="true">
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="crearScheduleModal" tabindex="-1" role="dialog" aria-labelledby="crearScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>

<div class="modal fade" id="updateScheduleModal" tabindex="-1" role="dialog" aria-labelledby="updateScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>
@stop

@section('js')
<script>
    // Función para editar una fila
    function editRow(index) {
        const row = $('#schedule-table').bootstrapTable('getData')[index];
        const editUrl = "{!! url('/api/edit-schedule/') !!}" + "/" + row.id;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: editUrl,
            type: 'POST',
            success: function(response) {
                if (response) {
                    $('#updateNombreSchedule').val(response.type_employee);
                    $('#updateStartTimeSchedule').val(response.start_time);
                    $('#updateEndTimeSchedule').val(response.end_time);
                    $('#updateScheduleModal .modal-dialog').html(response);
                    $('#updateScheduleModal').modal('show');
                } else {
                    alert('Error al cargar los detalles del cronograma.');
                }
            },
            error: function() {
                alert('Error al cargar los detalles del cronograma2.');
            }
        });
    }

    // Función para eliminar una fila
    function deleteRow(index) {
        const row = $('#schedule-table').bootstrapTable('getData')[index];

        // Mostrar una alerta de confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará el cronograma de forma permanente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const deleteUrl = "{!! url('/api/delete-schedule/') !!}" + "/" + row.id;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: deleteUrl,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Eliminado', response.success, 'success');
                            loadData();
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo eliminar el cronograma.', 'error');
                    }
                });
            }
        });
    }

    let loadData;
    $(document).ready(function() {
        var $table = $('#schedule-table');

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
                data: data
            });
            return result;
        }

        // Función para cargar datos en la tabla
        loadData = async function() {
            $table.bootstrapTable('showLoading', {
                text: 'Cargando...',
            });
            try {
                const response = await httpMyRequest('/api/data-schedule');
                $table.bootstrapTable('refreshOptions', {
                    data: response
                });
            } catch (error) {
                console.error(error);
            }
        }

        // Cargar datos de tabla al cargar la página y recibir respuesta de create-area
        loadData();
        $(document).on('scheduleSaved', function() {
            loadData();
        });
        $(document).on('scheduleUpdateSaved', function() {
            loadData();
        });

        // Abrir modal de crear
        $('#createScheduleButton').click(async function() {
            try {
                const response = await httpMyRequest('/api/create-schedule', {});
                $('#crearScheduleModal .modal-dialog').html(response);
                $('#crearScheduleModal').modal('show');
            } catch (error) {
                console.error('Error al intentar acceder a la página de creación del cronograma:', error);
            }
        });

        // Configuración de la tabla
        $table.bootstrapTable('destroy');
        $table.bootstrapTable({
            data: [],
            pagination: true,
            height: 720,
            locale: 'es-ES',
            formatNoMatches: function() {
                return "No se encontraron registros coincidentes.";
            },
            columns: [{
                    field: 'numero',
                    title: 'N°',
                    align: 'center',
                    formatter: function(value, row, index) {
                        return index + 1;
                    },
                },
                {
                    field: 'type_employee',
                    title: 'Tipo de Empleado',
                    align: 'center',
                },
                {
                    field: 'start_time',
                    title: 'Hora de inicio',
                    align: 'center',
                },
                {
                    field: 'end_time',
                    title: 'Hora de salida',
                    align: 'center',
                },
                {
                    title: 'Acciones',
                    align: 'center',
                    formatter: function(value, row, index) {
                        return `
                        <button class="btn btn-primary" onclick="editRow(${index})">Editar</button>
                        <button class="btn btn-danger" onclick="deleteRow(${index})">Eliminar</button>
                        `;
                    }
                },
            ]
        });
    });
</script>
@stop

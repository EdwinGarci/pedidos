@extends('adminlte::page')

@section('title', 'Asistencia')

@section('content_header')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <span class="p-0 m-0 sourcesans h4">Asistencias</span>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Lista de Asistencia</h5>
        <button id="createAttendanceButton" class="btn btn-primary btn-sm">Crear asistencia</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="attendance-table" class="table table-bordered table-hover" data-page-size="25" data-toggle="table" data-pagination="true" data-search="true">
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="crearAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="crearAttendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>

<div class="modal fade" id="updateAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="updateAttendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>
@stop

@section('js')
<script>
    // Función para editar una fila
    function editRow(index) {
        const row = $('#attendance-table').bootstrapTable('getData')[index];
        const editUrl = "{!! url('/api/edit-attendance/') !!}" + "/" + row.id;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: editUrl,
            type: 'POST',
            success: function(response) {
                if (response) {
                    $('#updateNombreAttendance').val(response.type_employee);
                    $('#updateStartTimeAttendance').val(response.start_time);
                    $('#updateEndTimeAttendance').val(response.end_time);
                    $('#updateAttendanceModal .modal-dialog').html(response);
                    $('#updateAttendanceModal').modal('show');
                } else {
                    alert('Error al cargar los detalles de la asistencia.');
                }
            },
            error: function() {
                alert('Error al cargar los detalles de la asistencia.');
            }
        });
    }

    // Función para eliminar una fila
    function deleteRow(index) {
        const row = $('#attendance-table').bootstrapTable('getData')[index];
        console.log(row)
        // Mostrar una alerta de confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará la asistencia de forma permanente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const deleteUrl = "{!! url('/api/delete-attendance/') !!}" + "/" + row.id;
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
                        Swal.fire('Error', 'No se pudo eliminar la asistencia.', 'error');
                    }
                });
            }
        });
    }

    let loadData;
    $(document).ready(function() {
        var $table = $('#attendance-table');

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
                const response = await httpMyRequest('/api/data-attendance');
                $table.bootstrapTable('refreshOptions', {
                    data: response
                });
            } catch (error) {
                console.error(error);
            }
        }

        // Cargar datos de tabla al cargar la página y recibir respuesta de create-area
        loadData();
        $(document).on('attendanceSaved', function() {
            loadData();
        });
        $(document).on('attendanceUpdateSaved', function() {
            loadData();
        });

        // Abrir modal de crear
        $('#createAttendanceButton').click(async function() {
            try {
                const response = await httpMyRequest('/api/create-attendance', {});
                $('#crearAttendanceModal .modal-dialog').html(response);
                $('#crearAttendanceModal').modal('show');
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
                    field: 'start_marking_time',
                    title: 'Hora de Entrada',
                    align: 'center',
                    formatter: function(value, row, index) {
                        // Verifica si el valor es nulo
                        if (value === null) {
                            // Si es nulo, muestra "Sin asignar"
                            return '<span class="text-muted">Sin asignar</span>';
                        } else {
                            // Si no es nulo, muestra el valor real
                            return value;
                        }
                    },
                },
                {
                    field: 'end_marking_time',
                    title: 'Hora de Salida',
                    align: 'center',
                    formatter: function(value, row, index) {
                        // Verifica si el valor es nulo
                        if (value === null) {
                            // Si es nulo, muestra "Sin asignar"
                            // return 'Sin asignar';
                            return '<span class="text-muted">Sin asignar</span>';
                        } else {
                            // Si no es nulo, muestra el valor real
                            return value;
                        }
                    },
                },
                {
                    title: 'Diferencia de horas',
                    align: 'center',
                    formatter: function(value, row, index) {
                        // Verifica si ambos valores son diferentes de nulo
                        if (row.start_marking_time !== null && row.end_marking_time !== null) {
                            // Convierte las cadenas de tiempo a objetos Date
                            var startTime = new Date('1970-01-01T' + row.start_marking_time + 'Z');
                            var endTime = new Date('1970-01-01T' + row.end_marking_time + 'Z');

                            // Calcula la diferencia de tiempo en milisegundos
                            var timeDiff = endTime - startTime;

                            // Convierte la diferencia de tiempo a horas, minutos y segundos
                            var hours = Math.floor(timeDiff / (1000 * 60 * 60));
                            var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                            // Formatea el resultado
                            return hours + ':' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
                        } else {
                            // Si alguno de los valores es nulo, muestra "Sin asignar"
                            return '<span class="text-muted">Sin asignar</span>';
                        }
                    },
                },
                {
                    field: 'justified',
                    title: 'Justificado',
                    align: 'center',
                    formatter: function (value, row) {
                        // return value === 1 ? 'Justificado' : 'Sin justificar';
                        if (value === 1) {
                            // Si justified es 1, muestra "Justificado" con color de texto verde
                            return '<span class="text-success">Justificado</span>';
                        } else {
                            // Si justified no es 1, muestra "Sin justificar" con color de texto rojo
                            return '<span class="text-muted">Sin justificar</span>';
                        }
                    }
                },
                {
                    field: 'date_assistent',
                    title: 'Fecha de asistencia',
                    align: 'center',
                },
                {
                    field: 'edited_time',
                    title: 'Hora de Justificación',
                    align: 'center',
                    formatter: function(value, row, index) {
                        // Verifica si el valor es nulo
                        if (value === null) {
                            // Si es nulo, muestra "Sin asignar"
                            return '<span class="text-muted">Sin asignar</span>';
                        } else {
                            // Si no es nulo, muestra el valor real
                            return value;
                        }
                    },
                },
                {
                    field: 'justified_time',
                    title: 'Hora Justificada',
                    align: 'center',
                    formatter: function(value, row, index) {
                        // Verifica si el valor es nulo
                        if (value === null) {
                            // Si es nulo, muestra "Sin asignar"
                            return '<span class="text-muted">Sin asignar</span>';
                        } else {
                            // Si no es nulo, muestra el valor real
                            return value;
                        }
                    },
                },
                {
                    field: 'Trabajador',
                    title: 'Trabajador',
                    align: 'center',
                    formatter: function (value, row) {
                        return row.PerName + ' ' + row.PerLastName + ' ' + row.PerMotherLastName;
                    }
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

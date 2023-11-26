@extends('adminlte::page')

@section('title', 'Docentes')

@section('content_header')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <span class="p-0 m-0 sourcesans h4">Docentes</span>
        <!-- <small>Lista de maestros</small> -->
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Lista de Docentes</h5>
        <button id="createTeacherButton" class="btn btn-primary btn-sm">Crear maestros</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="teacher-table" class="table table-bordered table-hover" data-page-size="25" data-toggle="table" data-pagination="true" data-search="true">
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="crearTeacherModal" tabindex="-1" role="dialog" aria-labelledby="crearEmpleayeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>

<div class="modal fade" id="updateTeacherModal" tabindex="-1" role="dialog" aria-labelledby="updateEmpleayeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>
@stop

@section('js')
<script>
    //Función para editar una fila
    function editRow(index) {
        const row = $('#teacher-table').bootstrapTable('getData')[index];
        const editUrl = "{!! url('/api/edit-teacher/') !!}" + "/" + row.id;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: editUrl,
            type: 'POST',
            success: function(response) {
                if (response) {
                    $('#updateTeacherName').val(response.PerName);
                    $('#updateTeacherLastNameP').val(response.PerLastName);
                    $('#updateTeacherLastNameM').val(response.PerMotherLastName);
                    $('#updateTeacherDni').val(response.PerDni);
                    $('#updateTeacherModal .modal-dialog').html(response);
                    $('#updateTeacherModal').modal('show');
                } else {
                    alert('Error al cargar los detalles del empleado.');
                }
            },
            error: function() {
                alert('Error al cargar los detalles del empleado.');
            }
        });
    }

    // Función para eliminar una fila
    function deleteRow(index) {
        const row = $('#teacher-table').bootstrapTable('getData')[index];

        // Mostrar una alerta de confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará el empleado de forma permanente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const deleteUrl = "{!! url('/api/delete-teacher/') !!}" + "/" + row.id;
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
                        Swal.fire('Error', 'No se pudo eliminar el empleado.', 'error');
                    }
                });
            }
        });
    }

    let loadData;
    $(document).ready(function() {
        var $table = $('#teacher-table');

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
                const response = await httpMyRequest('/api/data-teacher');
                $table.bootstrapTable('refreshOptions', {
                    data: response
                });
            } catch (error) {
                console.error(error);
            }
        }

        // Cargar datos de tabla al cargar la página y recibir respuesta de create-teacher
        loadData();
        $(document).on('teacherSaved', function() {
            loadData();
        });
        $(document).on('teacherUpdateSaved', function() {
            loadData();
        });

        // Abrir modal de crear
        $('#createTeacherButton').click(async function() {
            try {
                const response = await httpMyRequest('/api/create-teacher', {});
                $('#crearTeacherModal .modal-dialog').html(response);
                $('#crearTeacherModal').modal('show');
            } catch (error) {
                console.error('Error al intentar acceder a la página de creación del empleado:', error);
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
                    field: 'name',
                    title: 'Nombres',
                    align: 'center',
                },
                {
                    field: 'lastname',
                    title: 'Apellidos',
                    align: 'center',
                },
                {
                    field: 'email',
                    title: 'Correo electrónico',
                    align: 'center',
                },
                {
                    field: 'civil_status',
                    title: 'Estado Civil',
                    align: 'center',
                },
                {
                    field: 'faculty',
                    title: 'Facultad',
                    align: 'center',
                },
                {
                    field: 'faculty_department',
                    title: 'Departamento de Facultad',
                    align: 'center',
                },
                {
                    field: 'category',
                    title: 'Categoría',
                    align: 'center',
                },
                {
                    field: 'codality',
                    title: 'Modalidad',
                    align: 'center',
                },
                {
                    field: 'job_title',
                    title: 'Título Profesional',
                    align: 'center',
                },
                ////////////////////////
                {
                    field: 'condition_teacher',
                    title: 'Condición del Docente',
                    align: 'center',
                },
                {
                    field: 'professional_grade',
                    title: 'Grado Profesional',
                    align: 'center',
                },
                {
                    field: 'date_of_admission',
                    title: 'Fecha de admisión',
                    align: 'center',
                },
                {
                    field: 'teacher_status',
                    title: 'Estado del Docente',
                    align: 'center',
                },
                {
                    field: 'address',
                    title: 'Dirección',
                    align: 'center',
                },
                {
                    field: 'birthdate',
                    title: 'Fecha de Nacimiento',
                    align: 'center',
                },
                {
                    field: 'phone',
                    title: 'Teléfono',
                    align: 'center',
                },
                ///////////////////////
                // {
                //     field: 'EmpType',
                //     title: 'Tipo de empleado',
                //     align: 'center',
                //     formatter: function(value, row, index) {
                //         // Verifica si el valor es nulo
                //         if (value === null) {
                //             // Si es nulo, muestra "Sin asignar"
                //             return '<span class="text-muted">Sin asignar</span>';
                //         } else {
                //             // Si no es nulo, muestra el valor real
                //             return value;
                //         }
                //     },
                // },
                // {
                //     field: 'AreaName',
                //     title: 'Nombre de Área',
                //     align: 'center',
                //     formatter: function(value, row, index) {
                //         // Verifica si el valor es nulo
                //         if (value === null) {
                //             // Si es nulo, muestra "Sin asignar"
                //             return '<span class="text-muted">Sin asignar</span>';
                //         } else {
                //             // Si no es nulo, muestra el valor real
                //             return value;
                //         }
                //     },
                // },
                {
                    field: 'dni',
                    title: 'DNI',
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
                // {
                //     field: 'horario',
                //     title: 'Horario',
                //     align: 'center',
                //     formatter: function(value, row, index) {
                //         // Verifica si tanto start_time como end_time son nulos
                //         if (row.start_time === null && row.end_time === null) {
                //             // Si ambos son nulos, muestra "Sin asignar"
                //             return '<span class="text-muted">Sin asignar</span>';
                //         } else {
                //             // Si no son nulos, muestra el horario en el formato deseado
                //             return row.start_time + ' - ' + row.end_time;
                //         }
                //     }
                // },
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

@extends('adminlte::page')

@section('title', 'Pariente')

@section('content_header')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <span class="p-0 m-0 sourcesans h4">Pariente</span>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Pariente</h5>
        <button id="createParentButton" class="btn btn-primary btn-sm">Crear pariente</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="parent-table" class="table table-bordered table-hover" data-page-size="25" data-toggle="table" data-pagination="true" data-search="true">
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="crearParentModal" tabindex="-1" role="dialog" aria-labelledby="crearParentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>

<div class="modal fade" id="updateParentModal" tabindex="-1" role="dialog" aria-labelledby="updateParentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>
@stop

@section('js')
<script>
    // Función para editar una fila
    function editRow(index) {
        const row = $('#parent-table').bootstrapTable('getData')[index];
        const editUrl = "{!! url('/api/edit-parent/') !!}" + "/" + row.id;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: editUrl,
            type: 'POST',
            success: function(response) {
                if (response) {
                    $('#updateNombreParent').val(response.type_employee);
                    $('#updateStartTimeParent').val(response.start_time);
                    $('#updateEndTimeParent').val(response.end_time);
                    $('#updateParentModal .modal-dialog').html(response);
                    $('#updateParentModal').modal('show');
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
        const row = $('#parent-table').bootstrapTable('getData')[index];

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
                const deleteUrl = "{!! url('/api/delete-parent/') !!}" + "/" + row.id;
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
        var $table = $('#parent-table');

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
                const response = await httpMyRequest('/api/data-parent');
                $table.bootstrapTable('refreshOptions', {
                    data: response
                });
            } catch (error) {
                console.error(error);
            }
        }

        // Cargar datos de tabla al cargar la página y recibir respuesta de create-area
        loadData();
        $(document).on('parentSaved', function() {
            loadData();
        });
        $(document).on('parentUpdateSaved', function() {
            loadData();
        });

        // Abrir modal de crear
        $('#createParentButton').click(async function() {
            try {
                const response = await httpMyRequest('/api/create-parent', {});
                $('#crearParentModal .modal-dialog').html(response);
                $('#crearParentModal').modal('show');
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
                    field: 'relationship',
                    title: 'Relación familiar',
                    align: 'center',
                },
                {
                    field: 'parent_name',
                    title: 'Nombres',
                    align: 'center',
                },
                {
                    field: 'parent_lastname',
                    title: 'Apellidos',
                    align: 'center',
                },
                {
                    field: 'parent_sex',
                    title: 'Sexo',
                    align: 'center',
                },
                {
                    field: 'parent_birthdate',
                    title: 'Fecha de nacimiento',
                    align: 'center',
                },
                {
                    field: 'Trabajador',
                    title: 'Trabajador',
                    align: 'center',
                    formatter: function (value, row) {
                        return row.teacher_name + ' ' + row.teacher_lastname;
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

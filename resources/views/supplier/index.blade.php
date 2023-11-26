@extends('adminlte::page')

@section('title', 'Suppliers')

@section('content_header')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <span class="p-0 m-0 sourcesans h4">Proveedores</span>
        <!-- <small>Lista de áreas</small> -->
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Lista de proveedores</h5>
        <button id="createSupplierButton" class="btn btn-primary btn-sm">Crear proveedor</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="supplier-table" class="table table-bordered table-hover" data-page-size="25" data-toggle="table" data-pagination="true" data-search="true">
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="crearSupplierModal" tabindex="-1" role="dialog" aria-labelledby="crearSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>

<div class="modal fade" id="updateSupplierModal" tabindex="-1" role="dialog" aria-labelledby="updateSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- El contenido del modal se cargará aquí -->
    </div>
</div>
@stop

@section('js')
<script>
    // Función para editar una fila
    function editRow(index) {
        const row = $('#supplier-table').bootstrapTable('getData')[index];
        const editUrl = "{!! url('/api/edit-supplier/') !!}" + "/" + row.id;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: editUrl,
            type: 'POST',
            success: function(response) {
                if (response) {
                    $('#updateNombreSupplier').val(response.SupplierName);
                    $('#updateSupplierModal .modal-dialog').html(response);
                    $('#updateSupplierModal').modal('show');
                } else {
                    alert('Error al cargar los detalles del proveedor.');
                }
            },
            error: function() {
                alert('Error al cargar los detalles del proveedor.');
            }
        });
    }

    // Función para eliminar una fila
    function deleteRow(index) {
        const row = $('#supplier-table').bootstrapTable('getData')[index];

        // Mostrar una alerta de confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará el área de forma permanente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const deleteUrl = "{!! url('/api/delete-supplier/') !!}" + "/" + row.id;
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
                        Swal.fire('Error', 'No se pudo eliminar el proveedor.', 'error');
                    }
                });
            }
        });
    }

    let loadData;
    $(document).ready(function() {
        var $table = $('#supplier-table');

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
                const response = await httpMyRequest('/api/data-supplier');
                $table.bootstrapTable('refreshOptions', {
                    data: response
                });
            } catch (error) {
                console.error(error);
            }
        }

        // Cargar datos de tabla al cargar la página y recibir respuesta de create-supplier
        loadData();
        $(document).on('supplierSaved', function() {
            loadData();
        });
        $(document).on('supplierUpdateSaved', function() {
            loadData();
        });

        // Abrir modal de crear
        $('#createSupplierButton').click(async function() {
            try {
                const response = await httpMyRequest('/api/create-supplier', {});
                $('#crearSupplierModal .modal-dialog').html(response);
                $('#crearSupplierModal').modal('show');
            } catch (error) {
                console.error('Error al intentar acceder a la página de creación del proveedor:', error);
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
                    field: 'business_name',
                    title: 'Nombre del Negocio',
                    align: 'center',
                },
                {
                    field: 'ruc',
                    title: 'RUC',
                    align: 'center',
                },
                {
                    field: 'phone',
                    title: 'Teléfono',
                    align: 'center',
                },
                {
                    field: 'direccion',
                    title: 'Dirección',
                    align: 'center',
                },
                {
                    field: 'product_amount',
                    title: 'Importe de producto',
                    align: 'center',
                },
                {
                    field: 'manager',
                    title: 'Gerente',
                    align: 'center',
                },
                {
                    field: 'agreement_date',
                    title: 'Fecha de Acuerdo',
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

@section('css')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    th {
        text-align: center;
    }

    .actions {
        text-align: center;
    }
</style>
@stop

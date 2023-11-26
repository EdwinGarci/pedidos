@extends('adminlte::page')

@section('title', 'Upload')

@section('content_header')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <span class="p-0 m-0 sourcesans h4">Upload - Subida de documento</span>
    </div>
</div>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Subir Documento</h5><br>
                    <form id="upload-form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @csrf
                        <div class="form-group">
                            <label for="file">Seleccionar archivo:</label>
                            <input type="file" class="form-control-file" id="file" name="excel_file">
                        </div>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div id="excel-data-container"></div> -->
<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <div class="toolbar">
                <button class="btn btn-success" disabled id="btn-save">GRABAR ASISTENCIAS</button>
            </div>

            <table id="excel-table" class="table table-bordered table-hover" data-page-size="25" data-toggle="table" data-pagination="true" data-search="true" data-search-align="right" data-toolbar=".toolbar" data-toolbar-align="left">
                <thead>
                    <tr>
                        <th data-field="ACNo">AC-No.</th>
                        <th data-field="Nombre">Nombre</th>
                        <th data-field="Horario">Horario</th>
                        <th data-field="Estado">Estado</th>
                        <th data-formatter="accionesFormatter">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    var response;
    var table = $('#excel-table');

    $('#excel-table').bootstrapTable({
        locale: 'es-ES',
        formatNoMatches: function() {
            return "No se encontraron registros coincidentes.";
        },
    });

    function accionesFormatter(value, row, index) {
        // Retorna el HTML del botón de eliminar para cada fila
        return '<button class="btn btn-danger" id="' + row.ACNo + '">Eliminar</button>';
    }

    $(document).ready(function() {
        $('#btn-save').on('click', function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{!! url('api/save-attendances') !!}",
                data: {
                    dataExcel: table.bootstrapTable('getData')
                },
                dataType: 'json',
                success: function(resp) {
                    if (resp) {
                        console.log(resp);
                    } else {
                        // Muestra un mensaje si no hay datos disponibles
                        console.log('Error.');
                    }
                },
                error: function(error) {
                    console.error(error);
                    console.log('Hubo un error al subir el archivo.');
                }
            });

        });

        $('#upload-form').submit(function(e) {
            e.preventDefault(); // Evitar la acción predeterminada del formulario
            var formData = new FormData(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{!! url('api/upload-excel') !!}",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(resp) {
                    if (resp && resp.length > 0) {
                        $('#btn-save').prop("disabled", false);
                        response = resp;
                        table.bootstrapTable('load', response)
                    } else {
                        // Muestra un mensaje si no hay datos disponibles
                        console.log('Error.');
                    }
                },
                error: function(error) {
                    console.error(error);
                    console.log('Hubo un error al subir el archivo.');
                }
            });
        });

        // Delegación de eventos para manejar clics en los botones "Eliminar"
        $('#excel-table').on('click', '.btn-danger', function() {
            var row = $(this).closest('tr');
            var dataIndex = row.data('index');
            console.log('Índice de la fila a eliminar:', dataIndex);
            table.bootstrapTable('remove', {
                field: '$index',
                values: [dataIndex]
            })
        });
    });

    // Delegación de eventos para manejar clics en los botones "Eliminar"
    // $('#excel-table').on('click', '.btn-danger', function() {
    //     var id = $(this).data('ACNo');
    //     console.log('gaaaaaaaaaa', id)

    //     // Encuentra la fila más cercana (el <tr> que contiene el botón)
    //     var row = $(this).closest('tr');
    //     console.log('awa', row)

    //     // Obtiene el valor del atributo "data-index" de la fila
    //     var dataIndex = row.data('index');
    //     console.log('Índice de la fila a eliminar:', dataIndex);

    //     table.bootstrapTable('removeByUniqueId', dataIndex)
    // });
</script>
@stop

@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <span class="p-0 m-0 sourcesans h4">Roles de usuario</span>       
    </div>
</div>
@stop

@section('content')
<div class="p-3 bg-white rounded">
    <div class="table-responsive">
        <table 
            id="tb-rol" 
            class="table table-striped" 
            data-page-size="25" 
            data-toggle="table" 
            data-pagination="true" 
            data-search="true">
        </table>
        <thead class="">

        </thead>
    </div>
</div>
@stop

@section('js')
<script>
    $tbrol = $("#tb-rol");

    $tbrol.bootstrapTable('destroy');
    $tbrol.bootstrapTable({
        data: [],
        pagination: true,
        // height: 720,
        locale: 'es-ES',
        columns: [
            {                
                title: 'N°',
                align: 'center',
                formatter: function(value, row, index) {
                    return index + 1;
                },
            },
            {
                field: 'RolName',
                title: 'Nombre',                
            },
            {
                field: 'RolDescription',
                title: 'Nombre',                
            },
            {
                field: 'RolStatus',
                title: 'Estado',
                align: 'center',
                formatter: function(value, row, index) {
                    if( value == '1' ) {
                        return '<span style="font-size: 12px" class="px-2 bg-success rounded text-bold">ACTIVO</span>';
                    }
                },
            },
        ]
    });

    $(document).ready( function() {
        get_rols();
    })

    async function get_rols() {        
        $tbrol.bootstrapTable('showLoading', { text: 'Cargando...', } );
        try {
            const rols = await request_post('/api/get-rols', {});  
            console.log(rols);
            $tbrol.bootstrapTable('refreshOptions', {
                data: rols
            });
        } catch (error) {
            console.error(error);
        }
    }

    async function request_post(url, data) {
            let uri = "{!! url('') !!}";
            var result = await $.ajax({
                url: uri + url,
                type: 'POST',
                data: data
            });
            return result;
        }

</script>
@stop
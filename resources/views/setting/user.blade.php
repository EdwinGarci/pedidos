@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="p-0 m-0 h1 sourcesans font-weight-normal text-muted">Usuarios</h1>       
    </div>
</div>
@stop

@section('content')
<div>
    <div class="card elevation-0 border">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-muted "><i class="fas fa-users mr-1"></i>LISTA DE USUARIOS</h5>
                <button class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1 text-white-50 fs-14"></i>Nuevo</button>
            </div> 
        </div>
        <div class="card-body" id="card-body">

        </div>
    </div>
</div>
@stop
@section('js')

<script>
    async function request_post(url, data) {
        let uri = "{!! url('') !!}";
        var result = await $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: uri + url,
            type: 'POST',
            data: data,
        })
        return result
    }

    async function request_component(url, data, id) {
        let uri = "{!! url('') !!}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: uri + url,
            type: 'POST',
            data: data,
        }).done(function(component) {
            $("#" + id).html(component)
        })
    }
</script>

@stop
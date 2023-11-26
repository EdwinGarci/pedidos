<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="updateAreaModalLabel">Actualizar Área</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            @csrf
            <div class="form-group">
                <label for="nombreArea">Nombre del Área</label>
                <input type="text" class="form-control" id="updateNombreArea" placeholder="Escribe el nombre del área" value="{{ $area->AreaName }}">
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="updateAreaButton">Actualizar Área</button>
    </div>
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>

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
        async function httpMyRequest(url, data, id) {
            let uri = "{!! url('') !!}";
            var result = await $.ajax({
                url: uri + url + id,
                type: 'PATCH',
                data: data
            });
            return result;
        }

        $('#updateAreaButton').click(async function() {
            // Recoge los datos del formulario
            var nombreArea = $('#updateNombreArea').val();
            var areaId = "{{ $area->id }}";
            try {
                const response = await httpMyRequest('/api/update-area/', {
                    NombreArea: nombreArea
                }, areaId);

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#updateAreaModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#updateAreaModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('areaUpdateSaved');
                }
            } catch (error) {
                alert('Error al guardar el área.');
            }
        });
    });
</script>

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="updateParentModalLabel">Actualizar Cronograma</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            @csrf
            <div class="form-group">
                <label for="updateTypeParent">Nombre del tipo de cronograma</label>
                <input type="text" class="form-control" id="updateTypeParent" placeholder="Escribe el nombre del tipo de empleado" value="{{ $parent->type_employee }}">
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="updateStartTimeParent">Hora de entrada</label>
                        <input type="time" class="form-control" id="updateStartTimeParent" value="{{ $parent->start_time }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="updateEndTimeParent">Hora de salida</label>
                        <input type="time" class="form-control" id="updateEndTimeParent" value="{{ $parent->end_time }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="updateParentButton">Actualizar Cronograma</button>
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

        $('#updateParentButton').click(async function() {
            // Recoge los datos del formulario
            var typeParent = $('#updateTypeParent').val();
            var start_time = $('#updateStartTimeParent').val();
            var end_time = $('#updateEndTimeParent').val();
            var parentId = "{{ $parent->id }}";
            try {
                const response = await httpMyRequest('/api/update-parent/', {
                    type_employee: typeParent,
                    start_time: start_time,
                    end_time: end_time
                }, parentId);

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#updateParentModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#updateParentModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('parentUpdateSaved');
                }
            } catch (error) {
                alert('Error al actualizar el cronograma.');
            }
        });
    });
</script>

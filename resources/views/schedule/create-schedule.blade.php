<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="crearScheduleModalLabel">Crear Cronograma</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            @csrf
            <div class="form-group">
                <label for="typeSchedule">Nombre del tipo de cronograma</label>
                <input type="text" class="form-control" id="typeSchedule" placeholder="Escribe el nombre del tipo de empleado">
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="startTimeSchedule">Hora de entrada</label>
                        <input type="time" class="form-control" id="startTimeSchedule">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="endTimeSchedule">Hora de salida</label>
                        <input type="time" class="form-control" id="endTimeSchedule">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarScheduleButton">Crear Cronograma</button>
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
        async function httpMyRequest(url, data) {
            let uri = "{!! url('') !!}";
            var result = await $.ajax({
                url: uri + url,
                type: 'POST',
                data: data
            });
            return result;
        }

        $('#guardarScheduleButton').click(async function() {
            // Recoge los datos del formulario
            var typeSchedule = $('#typeSchedule').val();
            var start_time = $('#startTimeSchedule').val();
            var end_time = $('#endTimeSchedule').val();
            try {
                const response = await httpMyRequest('/api/save-schedule', {
                    type_employee: typeSchedule,
                    start_time: start_time,
                    end_time: end_time
                });

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#crearScheduleModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#crearScheduleModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('scheduleSaved');
                }
            } catch (error) {
                alert('Error al guardar el cronograma.');
            }
        });
    });
</script>

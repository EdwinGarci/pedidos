<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="updateScheduleModalLabel">Actualizar Cronograma</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            @csrf
            <div class="form-group">
                <label for="updateTypeSchedule">Nombre del tipo de cronograma</label>
                <input type="text" class="form-control" id="updateTypeSchedule" placeholder="Escribe el nombre del tipo de empleado" value="{{ $schedule->type_employee }}">
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="updateStartTimeSchedule">Hora de entrada</label>
                        <input type="time" class="form-control" id="updateStartTimeSchedule" value="{{ $schedule->start_time }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="updateEndTimeSchedule">Hora de salida</label>
                        <input type="time" class="form-control" id="updateEndTimeSchedule" value="{{ $schedule->end_time }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="updateScheduleButton">Actualizar Cronograma</button>
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

        $('#updateScheduleButton').click(async function() {
            // Recoge los datos del formulario
            var typeSchedule = $('#updateTypeSchedule').val();
            var start_time = $('#updateStartTimeSchedule').val();
            var end_time = $('#updateEndTimeSchedule').val();
            var scheduleId = "{{ $schedule->id }}";
            try {
                const response = await httpMyRequest('/api/update-schedule/', {
                    type_employee: typeSchedule,
                    start_time: start_time,
                    end_time: end_time
                }, scheduleId);

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#updateScheduleModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#updateScheduleModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('scheduleUpdateSaved');
                }
            } catch (error) {
                alert('Error al actualizar el cronograma.');
            }
        });
    });
</script>

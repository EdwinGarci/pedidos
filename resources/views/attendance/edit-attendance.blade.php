<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="updateAttendanceModalLabel">Editar Asistencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            @csrf
            <div class="form-group">
                <label for="updateDateAssistentAttendance">Fecha de Asistencia</label>
                <div class="input-group">
                    <input type="date" id="updateDateAssistentAttendance" value="{{ $attendances->date_assistent }}" class="form-control form-control-sm rounded-0" />
                </div>
            </div>
            <div class="form-group">
                <label for="updateEmployeeAttendance">Empleado</label>
                <select class="form-control" id="updateEmployeeAttendance" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ $employee->id == $attendances->EmpId ? 'selected' : '' }}>
                            {{ $employee->PerName }} {{ $employee->PerLastName }} {{ $employee->PerMotherLastName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="updateStartMarkingTimeAttendance">Hora de entrada</label>
                        <input type="time" class="form-control" value="{{ $attendances->start_marking_time }}" id="updateStartMarkingTimeAttendance">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="updateEndMarkingTimeAttendance">Hora de salida</label>
                        <input type="time" class="form-control" value="{{ $attendances->end_marking_time }}" id="updateEndMarkingTimeAttendance">
                    </div>
                </div>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" value="{{ $attendances->justified }}" id="updateJustifiedAttendance">
                <label class="form-check-label" for="updateJustifiedAttendance">¿El empleado justifico su tardanza?</label>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="updateEditedTimeAttendance" id="updateEditedTimeAttendanceLabel">Tiempo editado</label>
                        <input type="time" class="form-control" value="{{ $attendances->edited_time }}" id="updateEditedTimeAttendance">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="updateJustifiedTimeAttendance" id="updateJustifiedTimeAttendanceLabel">Hora de Justificación</label>
                        <input type="time" class="form-control" value="{{ $attendances->justified_time }}" id="updateJustifiedTimeAttendance">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="updateAttendanceButton">Actualizar Empleado</button>
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

        // Oculta los campos y labels al cargar la página
        $('#updateEditedTimeAttendance, #updateJustifiedTimeAttendance, #updateEditedTimeAttendanceLabel, #updateJustifiedTimeAttendanceLabel').hide();

        // Agrega un evento al cambio del checkbox
        $('#updateJustifiedAttendance').change(function () {
            // Si el checkbox está marcado, muestra los campos y labels, de lo contrario, los oculta
            if ($(this).is(':checked')) {
                $('#updateEditedTimeAttendance, #updateJustifiedTimeAttendance, #updateEditedTimeAttendanceLabel, #updateJustifiedTimeAttendanceLabel').show();
            } else {
                $('#updateEditedTimeAttendance, #updateJustifiedTimeAttendance, #updateEditedTimeAttendanceLabel, #updateJustifiedTimeAttendanceLabel').hide();
            }
        });

        $('#updateAttendanceButton').click(async function() {
            // Recoge los datos del formulario
            var date_assistent = $('#updateDateAssistentAttendance').val();
            var start_marking_time = $('#updateStartMarkingTimeAttendance').val();
            var end_marking_time = $('#updateEndMarkingTimeAttendance').val();

            // Obtén el valor correcto para 'justified' (0 o 1) según el estado del checkbox
            var justified = $('#updateJustifiedAttendance').is(':checked') ? 1 : 0;
            // var justified = $('#justifiedAttendance').val();

            var edited_time = $('#updateEditedTimeAttendance').val();
            var justified_time = $('#updateJustifiedTimeAttendance').val();
            var EmpId = $('#updateEmployeeAttendance').val();
            var attendanceId = "{{ $attendances->id }}";

            console.log("date_assistent: " + date_assistent);
            console.log("start_marking_time: " + start_marking_time);
            console.log("end_marking_time: " + end_marking_time);
            console.log("justified: " + justified);
            console.log("edited_time: " + edited_time);
            console.log("justified_time: " + justified_time);
            console.log("employeeId: " + EmpId);
            console.log("attendanceId: " + attendanceId);
            try {
                const response = await httpMyRequest('/api/update-attendance/', {
                    date_assistent: date_assistent,
                    start_marking_time: start_marking_time,
                    end_marking_time: end_marking_time,
                    justified: justified,
                    edited_time: edited_time,
                    justified_time: justified_time,
                    EmpId: EmpId
                }, attendanceId);

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#updateAttendanceModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#updateAttendanceModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('attendanceUpdateSaved');
                }
            } catch (error) {
                alert('Error al guardar la asistencia.');
            }
        });
    });
</script>

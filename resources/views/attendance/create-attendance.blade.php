<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="crearAttendanceModalLabel">Crear Asistencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            @csrf
            <div class="form-group">
                <label for="dateAssistentAttendance">Fecha de Asistencia</label>
                <div class="input-group">
                    <input type="date" id="dateAssistentAttendance" value="" class="form-control form-control-sm rounded-0" />
                </div>
            </div>
            <div class="form-group">
                <label for="employeeAttendance">Empleado</label>
                <select class="form-control" id="employeeAttendance" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">
                            {{ $employee->PerName }} {{ $employee->PerLastName }} {{ $employee->PerMotherLastName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="startMarkingTimeAttendance">Hora de entrada</label>
                        <input type="time" class="form-control" id="startMarkingTimeAttendance">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="endMarkingTimeAttendance">Hora de salida</label>
                        <input type="time" class="form-control" id="endMarkingTimeAttendance">
                    </div>
                </div>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="justifiedAttendance">
                <label class="form-check-label" for="justifiedAttendance">¿El empleado justifico su tardanza?</label>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="editedTimeAttendance" id="editedTimeAttendanceLabel">Tiempo editado</label>
                        <input type="time" class="form-control" id="editedTimeAttendance">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="justifiedTimeAttendance" id="justifiedTimeAttendanceLabel">Hora de Justificación</label>
                        <input type="time" class="form-control" id="justifiedTimeAttendance">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarAttendanceButton">Crear Empleado</button>
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

        // Oculta los campos y labels al cargar la página
        $('#editedTimeAttendance, #justifiedTimeAttendance, #editedTimeAttendanceLabel, #justifiedTimeAttendanceLabel').hide();

        // Agrega un evento al cambio del checkbox
        $('#justifiedAttendance').change(function () {
            // Si el checkbox está marcado, muestra los campos y labels, de lo contrario, los oculta
            if ($(this).is(':checked')) {
                $('#editedTimeAttendance, #justifiedTimeAttendance, #editedTimeAttendanceLabel, #justifiedTimeAttendanceLabel').show();
            } else {
                $('#editedTimeAttendance, #justifiedTimeAttendance, #editedTimeAttendanceLabel, #justifiedTimeAttendanceLabel').hide();
            }
        });

        $('#guardarAttendanceButton').click(async function() {
            // Recoge los datos del formulario
            var date_assistent = $('#dateAssistentAttendance').val();
            var start_marking_time = $('#startMarkingTimeAttendance').val();
            var end_marking_time = $('#endMarkingTimeAttendance').val();

            // Obtén el valor correcto para 'justified' (0 o 1) según el estado del checkbox
            var justified = $('#justifiedAttendance').is(':checked') ? 1 : 0;
            // var justified = $('#justifiedAttendance').val();

            var edited_time = $('#editedTimeAttendance').val();
            var justified_time = $('#justifiedTimeAttendance').val();
            var EmpId = $('#employeeAttendance').val();
            console.log("date_assistent: " + date_assistent);
            console.log("start_marking_time: " + start_marking_time);
            console.log("end_marking_time: " + end_marking_time);
            console.log("justified: " + justified);
            console.log("edited_time: " + edited_time);
            console.log("justified_time: " + justified_time);
            console.log("employeeId: " + EmpId);
            try {
                const response = await httpMyRequest('/api/save-attendance', {
                    date_assistent: date_assistent,
                    start_marking_time: start_marking_time,
                    end_marking_time: end_marking_time,
                    justified: justified,
                    edited_time: edited_time,
                    justified_time: justified_time,
                    EmpId: EmpId
                });

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#crearAttendanceModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#crearAttendanceModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('attendanceSaved');
                }
            } catch (error) {
                alert('Error al guardar la asistencia.');
            }
        });
    });
</script>

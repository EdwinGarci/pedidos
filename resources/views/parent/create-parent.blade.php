<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="crearParentModalLabel">Crear Pariente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            @csrf
            <div class="form-group">
                <label for="typeParent">Nombre de la relación familiar</label>
                <input type="text" class="form-control" id="typeParent" placeholder="Escribe el nombre del tipo de empleado">
            </div>
            <div class="row">
                <div class="col-sm-6">
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
                </div>
                <div class="col-sm-6">
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
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarParentButton">Crear Cronograma</button>
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

        $('#guardarParentButton').click(async function() {
            // Recoge los datos del formulario
            var typeParent = $('#typeParent').val();
            var start_time = $('#startTimeParent').val();
            var end_time = $('#endTimeParent').val();
            try {
                const response = await httpMyRequest('/api/save-parent', {
                    type_employee: typeParent,
                    start_time: start_time,
                    end_time: end_time
                });

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#crearParentModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#crearParentModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('parentSaved');
                }
            } catch (error) {
                alert('Error al guardar el cronograma.');
            }
        });
    });
</script>

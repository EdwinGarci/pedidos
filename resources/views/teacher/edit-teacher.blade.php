<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="updateEmployeeModalLabel">Actualizar Empleado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            @csrf
            <div class="form-group">
                <label for="typeEmployee">Tipo de Empleado</label>
                <select class="form-control" id="updateTypeEmployee" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($schedule as $cronograma)
                        <option value="{{ $cronograma->id }}" {{ $cronograma->id == $employee->ScheduleId ? 'selected' : '' }}>
                            {{ $cronograma->type_employee }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="employeeArea">Nombre de Área</label>
                <select class="form-control" id="updateEmployeeArea" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ $area->id == $employee->AreaId ? 'selected' : '' }}>
                            {{ $area->AreaName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="employeeName">Nombres</label>
                        <input type="text" class="form-control" id="updateEmployeeName" placeholder="Nombre del empleado" value="{{ $employee->PerName }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="employeeLastnameP">Apellido Paterno</label>
                        <input type="text" class="form-control" id="updateEmployeeLastNameP" placeholder="Apellido paterno del empleado" value="{{ $employee->PerLastName }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="employeeLastnameM">Apellido Materno</label>
                        <input type="text" class="form-control" id="updateEmployeeLastNameM" placeholder="Apellido materno del empleado" value="{{ $employee->PerMotherLastName }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="employeeDni">DNI</label>
                        <input type="text" class="form-control" id="updateEmployeeDni" placeholder="Dni del empleado" value="{{ $employee->PerDni }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="employeeSchedule">Horario</label>
                <select class="form-control" id="updateEmployeeSchedule" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($schedule as $cronograma)
                        <option value="{{ $cronograma->id }}" {{ $cronograma->id == $employee->ScheduleId ? 'selected' : '' }}>
                            {{ $cronograma->start_time }} - {{ $cronograma->end_time }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="updateEmployeeButton">Actualizar Empleado</button>
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

        // Manejar el cambio en el primer select
        $('#updateTypeEmployee').change(function() {
            var selectedType = $(this).val();
            console.log(selectedType);
            // $('#updateEmployeeSchedule').val(selectedType);
            $('#updateEmployeeSchedule').val(selectedType).change();
            $('#updateEmployeeSchedule').prop('disabled', true);
        });

        $('#updateEmployeeButton').click(async function() {
            // Recoge los datos del formulario
            var empType = $('#updateTypeEmployee option:selected').text();
            var areaId = $('#updateEmployeeArea').val();
            var scheduleId = $('#updateEmployeeSchedule').val();
            var name = $('#updateEmployeeName').val();
            var lastname_p = $('#updateEmployeeLastNameP').val();
            var lastname_m = $('#updateEmployeeLastNameM').val();
            var dni = $('#updateEmployeeDni').val();
            var employeeId = "{{ $employee->id }}";

            console.log("EmpType: " + empType);
            console.log("AreaId: " + areaId);
            console.log("ScheduleId: " + scheduleId);
            console.log("name: " + name);
            console.log("lastname_p: " + lastname_p);
            console.log("lastname_m: " + lastname_m);
            console.log("dni: " + dni);
            console.log("employeeId: " + employeeId);

            try {
                const response = await httpMyRequest('/api/update-employee/', {
                    EmpType: empType,
                    AreaId: areaId,
                    ScheduleId: scheduleId,
                    name: name,
                    lastname_p: lastname_p,
                    lastname_m: lastname_m,
                    dni: dni,
                }, employeeId);

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#updateEmployeeModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#updateEmployeeModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('employeeUpdateSaved');
                }
            } catch (error) {
                alert('Error al guardar el empleado.');
            }
        });
    });
</script>

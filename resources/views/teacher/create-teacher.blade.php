<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="crearTeacherModalLabel">Crear Maestro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            @csrf
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherName">Nombres</label>
                        <input type="text" class="form-control" id="teacherName" placeholder="Nombre del empleado">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherLastnameP">Apellidos</label>
                        <input type="text" class="form-control" id="teacherLastnameP" placeholder="Apellido paterno del empleado">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherDni">DNI</label>
                        <input type="text" class="form-control" id="teacherDni" placeholder="Dni del empleado">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="teacherLastnameM">Apellido Materno</label>
                        <input type="text" class="form-control" id="teacherLastnameM" placeholder="Apellido materno del empleado">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="typeTeacher">Tipo de Maestro</label>
                <select class="form-control" id="typeTeacher" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($schedule as $cronograma)
                        <option value="{{ $cronograma->id }}">
                            {{ $cronograma->type_teacher }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="teacherArea">Nombre de Área</label>
                <select class="form-control" id="teacherArea" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->AreaName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="teacherSchedule">Horario</label>
                <select class="form-control" id="teacherSchedule" aria-label="Default select example">
                    <option selected>Seleccionar</option>
                    @foreach ($schedule as $cronograma)
                        <option value="{{ $cronograma->id }}">
                            {{ $cronograma->start_time }} - {{ $cronograma->end_time }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarTeacherButton">Crear Maestro</button>
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

        // Manejar el cambio en el primer select
        $('#typeTeacher').change(function() {
            var selectedType = $(this).val();
            console.log(selectedType);
            // $('#teacherSchedule').val(selectedType);
            $('#teacherSchedule').val(selectedType).change();
            $('#teacherSchedule').prop('disabled', true);
        });

        $('#guardarTeacherButton').click(async function() {
            // Recoge los datos del formulario
            var empType = $('#typeTeacher option:selected').text();
            var areaId = $('#teacherArea').val();
            var scheduleId = $('#teacherSchedule').val();
            var name = $('#teacherName').val();
            var lastname_p = $('#teacherLastnameP').val();
            var lastname_m = $('#teacherLastnameM').val();
            var dni = $('#teacherDni').val();

            console.log("EmpType: " + empType);
            console.log("AreaId: " + areaId);
            console.log("ScheduleId: " + scheduleId);
            console.log("name: " + name);
            console.log("lastname_p: " + lastname_p);
            console.log("lastname_m: " + lastname_m);
            console.log("dni: " + dni);

            try {
                const response = await httpMyRequest('/api/save-teacher', {
                    EmpType: empType,
                    AreaId: areaId,
                    ScheduleId: scheduleId,
                    name: name,
                    lastname_p: lastname_p,
                    lastname_m: lastname_m,
                    dni: dni,
                });

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#crearTeacherModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#crearTeacherModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('teacherSaved');
                }
            } catch (error) {
                alert('Error al guardar el empleado.');
            }
        });
    });
</script>

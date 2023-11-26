<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="crearTeacherModalLabel">Crear Docente</h5>
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
                        <input type="text" class="form-control" id="teacherName" placeholder="Nombres">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherLastname">Apellidos</label>
                        <input type="text" class="form-control" id="teacherLastname" placeholder="Apellidos">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherDni">DNI</label>
                        <input type="text" class="form-control" id="teacherDni" placeholder="DNI">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherAddress">Dirección</label>
                        <input type="text" class="form-control" id="teacherAddress" placeholder="Dirección">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherBirhtDate">Fecha de Nacimiento</label>
                        <input type="date" id="teacherBirhtDate" value="" class="form-control form-control-sm rounded-0"/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherPhone">Teléfono</label>
                        <input type="text" class="form-control" id="teacherPhone" placeholder="Teléfono">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherEmail">Correo Electrónico</label>
                        <input type="text" class="form-control" id="teacherEmail" placeholder="Correo Electrónico">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherFaculty">Facultad</label>
                        <input type="text" class="form-control" id="teacherFaculty" placeholder="Facultad">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherFacultyDepartment">Departamento de Facultad</label>
                        <input type="text" class="form-control" id="teacherFacultyDepartment" placeholder="Departamento de Facultad">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="teacherCodality">Modalidad</label>
                        <input type="text" class="form-control" id="teacherCodality" placeholder="Modalidad">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="teacherCategory">Categoría</label>
                        <input type="text" class="form-control" id="teacherCategory" placeholder="Categoría">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="teacherJobTitle">Titulo Profesional</label>
                        <input type="text" class="form-control" id="teacherJobTitle" placeholder="Título">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="teacherDateAdmission">Fecha de Admisión</label>
                        <input type="date" id="teacherDateAdmission" value="" class="form-control form-control-sm rounded-0"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherCivilStatus">Estado Civil</label>
                        <select class="form-control" id="teacherCivilStatus" aria-label="Default select example">
                            <option selected>Seleccionar</option>
                            @foreach ($civilStatusOptions as $civilStatus)
                                <option value="{{ $civilStatus }}">
                                    {{ $civilStatus }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="teacherStatus">Estado del Docente</label>
                        <select class="form-control" id="teacherStatus" aria-label="Default select example">
                            <option selected>Seleccionar</option>
                            @foreach ($teacherStatusOptions as $teacherStatus)
                                <option value="{{ $teacherStatus }}">
                                    {{ $teacherStatus }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="teacherProfessionalGrade">Grado Profesional</label>
                        <input type="text" class="form-control" id="teacherProfessionalGrade" placeholder="Grado Profesional">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="teacherCondition">Condición</label>
                        <input type="text" class="form-control" id="teacherCondition" placeholder="Condición">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarTeacherButton">Crear Docente</button>
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
            var name = $('#teacherName').val();
            var lastname = $('#teacherLastname').val();
            var dni = $('#teacherDni').val();
            var address = $('#teacherAddress').val();
            var birthDate = $('#teacherBirhtDate').val();
            var phone = $('#teacherPhone').val();
            var email = $('#teacherEmail').val();
            var faculty = $('#teacherFaculty').val();
            var facultyDepartment = $('#teacherFacultyDepartment').val();
            var codality = $('#teacherCodality').val();
            var category = $('#teacherCategory').val();
            var jobTitle = $('#teacherJobTitle').val();
            var civilStatus = $('#teacherCivilStatus').val();
            var teacherStatus = $('#teacherStatus').val();
            var professionalGrade = $('#teacherProfessionalGrade').val();
            var condition = $('#teacherCondition').val();
            var dateAdmission = $('#teacherDateAdmission').val();

            try {
                const response = await httpMyRequest('/api/save-teacher', {
                    name: name,
                    lastname: lastname,
                    dni: dni,
                    address: address,
                    birthDate: birthDate,
                    phone: phone,
                    email: email,
                    faculty: faculty,
                    facultyDepartment: facultyDepartment,
                    codality: codality,
                    category: category,
                    jobTitle: jobTitle,
                    civilStatus: civilStatus,
                    teacherStatus: teacherStatus,
                    professionalGrade: professionalGrade,
                    condition: condition,
                    dateAdmission: dateAdmission
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

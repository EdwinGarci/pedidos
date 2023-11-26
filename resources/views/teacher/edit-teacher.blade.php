<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="updateTeacherModalLabel">Actualizar Maestro</h5>
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
                        <label for="updateTeacherName">Nombres</label>
                        <input type="text" class="form-control" id="updateTeacherName" placeholder="Nombres" value="{{ $teacher->name }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateTeacherLastname">Apellidos</label>
                        <input type="text" class="form-control" id="updateTeacherLastname" placeholder="Apellidos" value="{{ $teacher->lastname }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateTeacherDni">DNI</label>
                        <input type="text" class="form-control" id="updateTeacherDni" placeholder="DNI" value="{{ $teacher->dni }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateTeacherAddress">Dirección</label>
                        <input type="text" class="form-control" id="updateTeacherAddress" placeholder="Dirección" value="{{ $teacher->address }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateTeacherBirhtDate">Fecha de Nacimiento</label>
                        <input type="date" id="updateTeacherBirhtDate" value="{{ $teacher->birthdate }}" class="form-control form-control-sm rounded-0" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateTeacherPhone">Teléfono</label>
                        <input type="text" class="form-control" id="updateTeacherPhone" placeholder="Teléfono" value="{{ $teacher->phone }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateTeacherEmail">Correo Electrónico</label>
                        <input type="text" class="form-control" id="updateTeacherEmail" placeholder="Correo Electrónico" value="{{ $teacher->email }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateTeacherFaculty">Facultad</label>
                        <input type="text" class="form-control" id="updateTeacherFaculty" placeholder="Facultad" value="{{ $teacher->faculty }}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateTeacherFacultyDepartment">Departamento de Facultad</label>
                        <input type="text" class="form-control" id="updateTeacherFacultyDepartment" placeholder="Departamento de Facultad" value="{{ $teacher->faculty_department }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="updateTeacherCodality">Modalidad</label>
                        <input type="text" class="form-control" id="updateTeacherCodality" placeholder="Modalidad" value="{{ $teacher->codality }}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="updateTeacherCategory">Categoría</label>
                        <input type="text" class="form-control" id="updateTeacherCategory" placeholder="Categoría" value="{{ $teacher->category }}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="updateTeacherJobTitle">Titulo Profesional</label>
                        <input type="text" class="form-control" id="updateTeacherJobTitle" placeholder="Título" value="{{ $teacher->job_title }}">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="updateTeacherDateAdmission">Fecha de Admisión</label>
                        <input type="date" id="updateTeacherDateAdmission" value="{{ $teacher->date_of_admission }}" class="form-control form-control-sm rounded-0" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateTeacherCivilStatus">Estado Civil</label>
                        <select class="form-control" id="updateTeacherCivilStatus" aria-label="Default select example">
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
                        <label for="updateTeacherStatus">Estado del Maestro</label>
                        <select class="form-control" id="updateTeacherStatus" aria-label="Default select example">
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
                        <label for="updateTeacherProfessionalGrade">Grado Profesional</label>
                        <input type="text" class="form-control" id="updateTeacherProfessionalGrade" placeholder="Grado Profesional" value="{{ $teacher->professional_grade }}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="updateTeacherCondition">Condición</label>
                        <input type="text" class="form-control" id="updateTeacherCondition" placeholder="Condición" value="{{ $teacher->condition_teacher }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="updateTeacherButton">Actualizar Maestro</button>
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
        $('#updateTypeTeacher').change(function() {
            var selectedType = $(this).val();
            console.log(selectedType);
            // $('#updateTeacherSchedule').val(selectedType);
            $('#updateTeacherSchedule').val(selectedType).change();
            $('#updateTeacherSchedule').prop('disabled', true);
        });

        $('#updateTeacherButton').click(async function() {
            // Recoge los datos del formulario
            var name = $('#updateTeacherName').val();
            var lastname = $('#updateTeacherLastname').val();
            var dni = $('#updateTeacherDni').val();
            var address = $('#updateTeacherAddress').val();
            var birthDate = $('#updateTeacherBirhtDate').val();
            var phone = $('#updateTeacherPhone').val();
            var email = $('#updateTeacherEmail').val();
            var faculty = $('#updateTeacherFaculty').val();
            var facultyDepartment = $('#updateTeacherFacultyDepartment').val();
            var codality = $('#updateTeacherCodality').val();
            var category = $('#updateTeacherCategory').val();
            var jobTitle = $('#updateTeacherJobTitle').val();
            var civilStatus = $('#updateTeacherCivilStatus').val();
            var teacherStatus = $('#updateTeacherStatus').val();
            var professionalGrade = $('#updateTeacherProfessionalGrade').val();
            var condition = $('#updateTeacherCondition').val();
            var dateAdmission = $('#updateTeacherDateAdmission').val();
            var teacherId = "{{ $teacher->id }}";

            try {
                const response = await httpMyRequest('/api/update-teacher/', {
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
                }, teacherId);

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#updateTeacherModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#updateTeacherModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('teacherUpdateSaved');
                }
            } catch (error) {
                alert('Error al guardar el maestro.');
            }
        });
    });
</script>

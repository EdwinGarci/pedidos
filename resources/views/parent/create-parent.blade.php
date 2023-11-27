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
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="parentName">Nombres</label>
                        <input type="text" class="form-control" id="parentName" placeholder="Nombres">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="parentLastname">Apellidos</label>
                        <input type="text" class="form-control" id="parentLastname" placeholder="Apellidos">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="parentSex">Sexo</label>
                        <input type="text" class="form-control" id="parentSex" placeholder="Apellidos">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="parentBirhtDate">Fecha de Nacimiento</label>
                        <input type="date" id="parentBirhtDate" value="" class="form-control form-control-sm rounded-0"/>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="teacherType">Docente relacionado</label>
                        <select class="form-control" id="teacherType" aria-label="Default select example">
                            <option selected>Seleccionar</option>
                            @foreach ($teacher as $teach)
                                <option value="{{ $teach->id }}">
                                    {{ $teach->name . ' ' . $teach->lastname }}
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
            var parentName = $('#parentName').val();
            var parentLastname = $('#parentLastname').val();
            var parentSex = $('#parentSex').val();
            var parentBirthDate = $('#parentBirhtDate').val();
            var teacherType = $('#teacherType').val();
            try {
                const response = await httpMyRequest('/api/save-parent', {
                    type_parent: typeParent,
                    parent_name: parentName,
                    parent_lastname: parentLastname,
                    parent_sex: parentSex,
                    parent_birthdate: parentBirthDate,
                    teacher_type: teacherType,
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

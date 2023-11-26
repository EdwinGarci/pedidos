<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="crearAreaModalLabel">Crear Área</h5>
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
                        <label for="businessName">Nombre de empresa</label>
                        <input type="text" class="form-control" id="businessName" placeholder="Nombre de empresa">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="ruc">Ruc</label>
                        <input type="text" class="form-control" id="ruc" placeholder="Ruc">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <input type="text" class="form-control" id="phone" placeholder="Teléfono">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="direccion">direccion</label>
                        <input type="text" class="form-control" id="direccion" placeholder="direccion">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="productAmount">Cantidad de Producto</label>
                        <input type="text" class="form-control" id="productAmount" placeholder="Cantidad de Producto">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="manager">Gerente</label>
                        <input type="text" class="form-control" id="manager" placeholder="Gerente">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="agreementDate">Fecha de Acuerdo</label>
                <input type="date" id="agreementDate" value="" class="form-control form-control-sm rounded-0"/>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarAreaButton">Crear Área</button>
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

        $('#guardarAreaButton').click(async function() {
            // Recoge los datos del formulario
            var businessName = $('#businessName').val();
            var ruc = $('#ruc').val();
            var phone = $('#phone').val();
            var direccion = $('#direccion').val();
            var productAmount = $('#productAmount').val();
            var manager = $('#manager').val();
            var agreementDate = $('#agreementDate').val();
            try {
                const response = await httpMyRequest('/api/save-area', {
                    businessName: businessName,
                    ruc: ruc,
                    phone: phone,
                    direccion: direccion,
                    productAmount: productAmount,
                    manager: manager,
                    agreementDate: agreementDate
                });

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#crearAreaModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#crearAreaModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('areaSaved');
                }
            } catch (error) {
                alert('Error al guardar el área.');
            }
        });
    });
</script>

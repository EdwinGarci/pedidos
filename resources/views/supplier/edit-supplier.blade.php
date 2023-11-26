<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="updateSupplierModalLabel">Actualizar Área</h5>
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
                        <label for="updateBusinessName">Nombre de empresa</label>
                        <input type="text" class="form-control" id="updateBusinessName" value="{{ $supplier->business_name }}" placeholder="Nombre de empresa">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateRuc">Ruc</label>
                        <input type="text" class="form-control" id="updateRuc" value="{{ $supplier->ruc }}" placeholder="Ruc">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updatePhone">Teléfono</label>
                        <input type="text" class="form-control" id="updatePhone" value="{{ $supplier->phone }}" placeholder="Teléfono">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateDireccion">Direccion</label>
                        <input type="text" class="form-control" id="updateDireccion" value="{{ $supplier->direccion }}" placeholder="Direccion">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateProductAmount">Cantidad de Producto</label>
                        <input type="text" class="form-control" id="updateProductAmount" value="{{ $supplier->product_amount }}" placeholder="Cantidad de Producto">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="updateManager">Gerente</label>
                        <input type="text" class="form-control" id="updateManager" value="{{ $supplier->manager }}" placeholder="Gerente">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="updateAgreementDate">Fecha de Acuerdo</label>
                <input type="date" id="updateAgreementDate" value="{{ $supplier->agreement_date }}" class="form-control form-control-sm rounded-0"/>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="updateSupplierButton">Actualizar Área</button>
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

        $('#updateSupplierButton').click(async function() {
            // Recoge los datos del formulario
            var businessName = $('#updateBusinessName').val();
            var ruc = $('#updateRuc').val();
            var phone = $('#updatephone').val();
            var direccion = $('#updatedireccion').val();
            var productAmount = $('#updateproductAmount').val();
            var manager = $('#updatemanager').val();
            var agreementDate = $('#updateagreementDate').val();
            var supplierId = "{{ $supplier->id }}";
            try {
                const response = await httpMyRequest('/api/update-supplier/', {
                    businessName: businessName,
                    ruc: ruc,
                    phone: phone,
                    direccion: direccion,
                    productAmount: productAmount,
                    manager: manager,
                    agreementDate: agreementDate
                }, supplierId);

                if (response.success) {
                    // Muestra un mensaje de éxito en el modal
                    $('#updateSupplierModal .modal-dialog').html('<p>' + response.success + '</p>');
                    $('#updateSupplierModal').modal('hide');
                    // Disparar un evento personalizado para notificar la grabación exitosa
                    $(document).trigger('supplierUpdateSaved');
                }
            } catch (error) {
                alert('Error al guardar el área.');
            }
        });
    });
</script>

<div class="table-responsive">
    <table id="tb-user"
        class="table table-striped"
        data-page-size="25"
        data-toggle="table"
        data-pagination="true"
        data-search="true">
    </table>
    <thead class="">

    </thead>
</div>

<script>
    $tbuser = $("#tb-user");

    $tbuser.bootstrapTable('destroy');
    $tbuser.bootstrapTable({
        data: [],
        pagination: true,
        // height: 720,
        locale: 'es-ES',
        columns: [
            {
                title: 'N°',
                align: 'center',
                formatter: function(value, row, index) {
                    return index + 1;
                },
            },
            {
                field: 'dni',
                title: 'DNI',
            },
            {
                field: 'lastname',
                title: 'Apellidos',
            },
            {
                field: 'email',
                title: 'Correo',
            },
            // {
            //     field: 'RolName',
            //     title: 'Rol',
            // },
            // {
            //     field: 'PerStatus',
            //     title: 'Estado',
            //     align: 'center',
            //     formatter: function(value, row, index) {
            //         if( value == '1' ) {
            //             return '<span style="font-size: 12px" class="px-2 bg-success rounded text-bold">ACTIVO</span>';
            //         }
            //     },
            // },
        ]
    });

    $(document).ready( async function() {
        const response = await request_post('/api/get-users', {});
        console.log(response)
    })
</script>

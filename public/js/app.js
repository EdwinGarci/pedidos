var base_url = "http://127.0.0.1:8000/";

var url = base_url + getSegment(1);
var controller = getSegment(1);

console.log(controller);

function init_menu() {
    var url = window.location;
    //console.log(url)
    $("ul.nav-sidebar a.only")
        .filter(function () {
            /* console.log(this.href)
            console.log(this.href == url || url.href.indexOf(this.href) == 0) */
            return this.href == url || url.href.indexOf(this.href) == 0;
        })
        .addClass("active");
    $("ul.nav-treeview a.only")
        .filter(function () {
            console.log(this.href);
            console.log(this.href == url || url.href.indexOf(this.href) == 0);
            return this.href == url || url.href.indexOf(this.href) == 0;
        })
        .parentsUntil(".nav-sidebar > .nav-treeview")
        .addClass("menu-open")
        .prev("a")
        .addClass("active");
    console.log("init_menu");
}

async function init_usuario() {
    if (typeof controller === "undefined") {
        return;
    }

    if (controller != "usuario") {
        return;
    }

    loading_page('Cargando <b>Usuarios</b> ...');
    await request_component("/api/component-user-table", {}, "card-body");
    loading_close()
}

function getSegment(x) {
    var segment = window.location.pathname.split("/");
    return segment[x];
}

function loading_page(message) {
    Swal.fire({
        html: message,
        width: "15rem",
        timerProgressBar: true,
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();            
        },
        customClass:{
            'popup': 'fs-14'
        }
    });
}

function loading_close() {
    Swal.close();
}

$(document).ready(function () {
    init_menu();
    init_usuario();
});

/* async function requestPOST(url, data) {    
    var result = await $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: 'POST',
        data: data,
    });
    return result;
} */

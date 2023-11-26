<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedidos | SigIn</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/izitoast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" type="image/png" href="{!! url('img/favicon.png') !!}" />
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <!-- <div id="loading" class="loader"></div> -->
            <div class="card-header text-center">
                <img src="{!! url('img/favicon.png') !!}" width="70" /><br>
                <a href="./" class="h6 app-font"><b>Universidad Nacional de Piura</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Iniciar Sesión</p>

                <form id="login-form" method="POST">
                    @csrf
                    <div class="input-group mb-2">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email" autocomplete="off" required>
                        <div class="input-group-append">
                            <div class="input-group-text bg-white">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('email')
                    <div class="text-danger text-bold sourcesans fs-14 mb-2"><i class="fas fa-info-circle"></i> {{ $message }}</div>
                    @enderror

                    <div class="input-group mb-2">
                        <input id="password" name="password" type="password" class="form-control" placeholder="Contraseña" autocomplete="off" required>
                        <div class="input-group-append">
                            <div class="input-group-text bg-white">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-7">
                            <div class="icheck-primary app-font">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Recuerdame
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-5">
                            <button id="btn-login" type="submit" class="btn btn-block bg-gradient-primary btn-sm app-font-button">
                                <i class="fas fa-sign-in-alt mr-1 text-white-50"></i>
                                Ingresar
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        // $("#loading").hide();
        var messageAccess = '<div id="access-msg" class="alert bg-gradient-green">'+
                                '<h6 class="m-0 p-0">'+
                                    '<img src="./img/loading-gif.gif" width="15px" class="mr-1"/>'+
                                    'Redireccionando...'+
                                '</h6>'+
                            '</div>';
        let uri = "{!! url('') !!}";
        // iziToast.success({
        //     message: 'Success'
        // });
        // iziToast.error({
        //     title: 'Error',
        //     message: 'Cuerpo de error'
        // });

        // iziToast.info({
        //     title: 'Hello',
        //     message: 'Welcome!',
        // });
    </script>

</body>

</html>

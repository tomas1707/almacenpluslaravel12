<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema Almacén</title>

    {{--*********************************--}}
    {{--Zona para registrar archivos CSS --}}
    {{--*********************************--}}
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    {{--*********************************--}}
    {{--Zona para registrar archivos CSS --}}
    {{--*********************************--}}

</head>
<body class="hold-transition login-page">
<div class="login-box">

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <p class="h1"><b>Almacén</b>PLUS</p>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Ingresa para iniciar sesión</p>

            <form id="registroForm" action="{{route('login.post')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <!-- Entrada para el nombre de usuario -->
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre de Usuario">

                    <!-- Inicia div para que se coloque el mensaje de validación del nombre de usuario-->
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <!-- Termina div para que se coloque el mensaje de validación -->
                </div>

                <div class="input-group mb-3">
                    <!-- Entrada para la contraseña -->
                    <input type="password" id="contrasennia" name="contrasennia" class="form-control"
                           placeholder="Contraseña">

                    <!-- Inicia div para que se coloque el mensaje de validación de la contraseña-->
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <!-- Termina div para que se coloque el mensaje de validación de la contraseña-->
                </div>

                <!-- Inicia div para acomodar el botón Ingresar-->
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            &nbsp;<!-- Esto es un espacio en HTML-->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- Termina div para acomodar el botón Ingresar-->
            </form>

            <p class="mb-1">
                <a href="{{route('password.request')}}">Recupera tu contraseña</a>
            </p>
            <p class="mb-0">
                <a href="{{route('register.create')}}" class="text-center">Crea un nuevo registro</a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

{{--*******************************************--}}
{{--Zona para registrar archivos JS de Jascript--}}
{{--*******************************************--}}
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>

{{--*************************************************--}}
{{--Zona para cargar mensajes de error de Sweetalert2--}}
{{--*************************************************--}}
<script>
    $(document).ready(function () {

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        @if (session('sessionInsertado') == 'true')
        Toast.fire({
            icon: 'success',
            title: '{{session('mensaje')}}'
        })
        @endif

        @if (session('loginCorecto') == 'false')
        Toast.fire({
            icon: 'error',
            title: '{{session('mensaje')}}'
        })
        @endif

        @if (session('sessionRecuperarContrasennia') == 'true')
        Toast.fire({
            icon: 'success',
            title: '{{session('mensaje')}}'
        })
        @endif

        @if (session('sessionCambiarContrasennia') == 'false')
        Toast.fire({
            icon: 'error',
            title: '{{session('mensaje')}}'
        })
        @endif

        @if (session('sessionCambiarContrasennia') == 'true')
        Toast.fire({
            icon: 'success',
            title: '{{session('mensaje')}}'
        })
        @endif

        $(function () {
            $.validator.setDefaults({
                submitHandler: function () {
                    $('#preloader').css('display', 'flex'); // Muestra el preloader
                    $('#registroForm').submit();
                }
            });

            $('#registroForm').validate({
                rules: {
                    usuario: {
                        required: true,
                        minlength: 3
                    },
                    contrasennia: {
                        required: true,
                        minlength: 5,
                        regexContrasennia: true
                    },
                },
                messages: {
                    usuario: {
                        required: "Ingresa tu nombre de usuario",
                        minlength: "El nombre de usuario debe tener al meno 3 caracteres"
                    },
                    contrasennia: {
                        required: "Ingresar tu contraseña",
                    },
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    });
</script>
</body>
</html>

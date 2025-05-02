<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema Almacén</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>

</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="index2.html" class="h1"><b>Almacen</b>PLUS</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Registrar una nueva membresía</p>

            <form id="registroForm" action="{{route('register.store')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre Completo">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="correo" placeholder="Correo Electrónico">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="usuario" placeholder="Nombre de Usuario">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="contrasennia" id="contrasennia"
                           placeholder="Contraseña, min 8 [a-z|0-9|@#$%&]">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="recontrasennia"
                           placeholder="Confirma tu Contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary input-group">
                            <input type="checkbox" id="agreeTerms" name="terminos" value="agree">
                            <label for="agreeTerms">
                                Acepto los <a href="#">terminos</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" id="enviarFormulario" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <br>
            <div class="social-auth-links text-center">
                <a href="{{route('login')}}" class="text-center">Iniciar Sesion</a><br>
            </div>

        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<div id="preloader">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden"> </span>
    </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>


{{--<script>--}}

{{--    const formulario = document.getElementById('registroForm');--}}

{{--    function comparaContrasennias(){--}}
{{--        console.log("Verificando contraseñas");--}}
{{--    }--}}

{{--    //Este evento se invoca en cuanto termine de cargar la página html--}}
{{--    document.addEventListener('DOMContentLoaded', function() {--}}
{{--        console.log('El documento ha sido cargado y parseado.');--}}

{{--        comparaContrasennias();--}}
{{--    });--}}
{{--</script>--}}

<script>
    $(document).ready(function () {
        const regex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
        //El diccionario Toast guarda algunas confiuraciones para los mensajes toast
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        //Arroba if es una sentencia de laravel y verifica la existencia de la session flash
        //que proviene de la función store del RegisterController
        @if (session('sessionInsertado') == 'false')
        //Código Java Script para activar el mensaje Toast
        Toast.fire({
            icon: 'error',
            title: '{{session('mensaje')}}'
        })
        @endif


        $.validator.addMethod(
            //En jQuery Validation, un campo se considera opcional si no tiene el atributo required
            // o si se cumple alguna otra condición que lo haga opcional.
            "regexContrasennia",
            function (value, element) {
                //si optional es true indica que elcomponente contiene un required y el JS de la librearía se encargara de la validación
                //por otro lado regex se encargará
                return this.optional(element) || regex.test(value);
            }
        );

        $.validator.addMethod(
            "compararContrasennias",
            function (value, element) {
                return value == $("#contrasennia").val();
            }
        );

        $(function () {
            $.validator.setDefaults({
                submitHandler: function () {
                    $('#preloader').css('display', 'flex'); // Muestra el preloader
                    $('#registroForm').submit();
                }
            });

            $('#registroForm').validate({
                rules: {
                    nombre: {
                        required: true
                    },
                    correo: {
                        required: true,
                        email: true,
                    },
                    usuario: {
                        required: true,
                        minlength: 3
                    },
                    contrasennia: {
                        required: true,
                        minlength: 5,
                        regexContrasennia: true
                    },
                    recontrasennia: {
                        required: true,
                        minlength: 5,
                        compararContrasennias: true,
                    },
                    terminos: {
                        required: true
                    },
                },
                messages: {
                    nombre: {
                        required: "Ingresa tu nombre completo",
                    },
                    correo: {
                        required: "Ingresar tu correo electrónico",
                        email: "Correo electrónico no válido"
                    },
                    usuario: {
                        required: "Ingresar tu nombre de usuario",
                        minlength: "El nombre de usuario debe tener al meno 3 caracteres"
                    },
                    contrasennia: {
                        required: "Ingresar una contraseña",
                        minlength: "La contraseña debe tener al menos 5 caracteres",
                        regexContrasennia: "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.",
                    },
                    recontrasennia: {
                        required: "Ingresa la misma contraseña",
                        minlength: "La contraseña debe tener al menos 5 caracteres",
                        compararContrasennias: "Las contraseñas no coinciden."
                    },
                    terminos: "Debes aceptar los términos"
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

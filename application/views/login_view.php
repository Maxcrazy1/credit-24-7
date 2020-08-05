<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Iniciar Sesión</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=_R_?>css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=_R_?>AdminLTE.min.css">
    <link rel="stylesheet" href="<?=_R_?>css/AdminLTE.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=_R_?>plugins/iCheck/square/blue.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="text-center">
            <img class="login-logo" src="<?=_R_?>/img/blackLogo.png" alt="">
        </div>
        <div id="login-select">
            <p class="lead text-center">Ingresar como:</p>
            <div class="btn-group btn-group-justified" role="group" aria-label="">
                <div class="btn-group" role="group">
                    <a type="button" class="btn btn-lg btn-primary" href="#"
                        onclick="toggleAdminLogin(1);return false;">
                        <span class="pull-left glyphicon glyphicon-user"></span> Administrador</a>
                </div>
                <div class="btn-group" role="group">
                    <a class="btn btn-lg btn-default" href="<?=_App_?>cobros">
                        <span class="pull-left glyphicon glyphicon-phone"></span> Colaborador</a>
                </div>
            </div>
        </div>
        <div id="adminLogin" class="login-box-body hidden">
            <form action="<?=_App_?>login" method="post">
                <input type="hidden" name="ref" value="<?=$ref?>">
                <div class="modal-header">
                    <button type="button" class="close" onclick="toggleAdminLogin(0);return false;"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Inicio de <strong>Administradores</strong></h4>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" name="username" class="form-control" placeholder="Usuario">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            <span class="pull-left glyphicon glyphicon-log-in"></span>
                            Ingresar</button>
                    </div><!-- /.col -->
                </div>
            </form>
            <hr>
            <div class="text-center">
                <a href="" data-toggle="modal" data-target="#modal-fpwd">He olvidado mi contraseña</a>
            </div>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <?php if (uri_string() == 'error'): ?>
    <div class="container">
        <div id="alert" class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-danger">
                    <h4><i class="icon fa fa-ban"></i>Datos incorrectos</h4>
                    El nombre de usuario o contraseña son inválidos
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>


    <div class="modal modal-success fade" id="modal-fpwd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Solicitar una contraseña nueva</h4>
                </div>
                <form class="form-horizontal" action="<?=_App_?>usuarios/restaurar" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Usuario</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" placeholder="Nombre de usuario">
                            </div>
                        </div>
                        <p class="text-block text-center">En breve recibirás un correo electrónico con instrucciones
                            sobre cómo continuar.</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-outline">Solicitar contraseña</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=_R_?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=_R_?>js/main.js"></script>
    <script src="<?=_R_?>js/bootstrap.min.js"></script>
    <script type="text/javascript">
    function toggleAdminLogin(flag) {
        if (flag) {
            $("#adminLogin").removeClass("hidden");
            $("#login-select").addClass("hidden");
        } else {
            $("#adminLogin").addClass("hidden");
            $("#login-select").removeClass("hidden");
        };
    }
    </script>
</body>

</html>

<div class="modal modal-success fade" id="modal-reset-ok">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva contraseña solicitada.</h4>
            </div>
            <div class="modal-body">
                <p class="text-block text-center">En breve recibirás un correo electrónico con instrucciones sobre cómo
                    continuar.</p>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <a href="<?=_App_?>logout" class="btn btn-outline">Salir</a>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
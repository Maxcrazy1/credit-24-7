<?php if ($this->session->log_status !== 'mobile'): redirect(_App_.'cobros'.'?ref='.uri_string()); endif; ?>
  <?php $name = ucfirst($this->session->log_name); ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Credit 24/7</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=_R_?>css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=_R_?>css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=_R_?>css/AdminLTE.css">
    <!-- AdminLTE Skin. -->
    <link rel="stylesheet" href="<?=_R_?>css/skin-blue-light.min.css">
    <!-- Custom Styles. -->
    <link rel="stylesheet" href="<?=_R_?>css/styles.css">
    <link rel="shortcut icon" href="<?=_R_?>img/favicon.ico">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- jQuery 2.1.4 -->
        <script src="<?=_R_?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script type="text/javascript">
        // Wait for window load
        $(window).load(function() {
          // Animate loader off screen
          $(".se-pre-con").fadeOut("slow");;
        });
      </script>
    </head>
    <body class="hold-transition skin-blue-light sidebar-mini">
      <div class="wrapper">
        <header class="main-header">
          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top" role="navigation">
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu" style="width:100%">
              <ul class="nav navbar-nav" style="width:100%">
                <li class="bg-red pull-right">
                  <a href="<?=_App_?>logout?ref=cobros"><i class="fa fa-power-off"></i></a>
                </li>
                <li class="pull-right user user-menu">
                  <a><span class=""><?=$name?></span></a>
                </li>
              </ul>
            </div>
          </nav>
        </header>
        <div class="se-pre-con"></div>

        <div class="login-box">
          <div class="login-logo">
            Cambio de <strong>Contraseña</strong>
          </div><!-- /.login-logo -->
          <div class="login-box-body">
            <form action="<?=_App_?>cobros/restaurar" method="get" enctype="multipart/form-data">
            <input type="hidden" name="source" value="mobile">
              <div class="form-group has-feedback">
                <input type="password" name="password1" class="form-control" placeholder="Nueva Contraseña" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" name="password2" class="form-control" placeholder="Confirmar Contraseña" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <button type="submit" class="btn btn-success btn-block btn-flat">
                    <span class="pull-left glyphicon glyphicon-log-in"></span>
                    Actualizar</button>
                  </div><!-- /.col -->
              </div>
            </form>
          </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->


        <?php if ($error): ?>
          <div class="container">
            <div id="alert" class="row">
              <div class="col-md-4 col-md-offset-4">
               <div class="alert alert-danger">
                <h4><i class="icon fa fa-ban"></i>Datos incorrectos</h4>
                Las contraseñas no coinciden o son iguales a la clave temporal.
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- jQuery 2.1.4 -->
      <script src="<?=_R_?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
      <!-- Bootstrap 3.3.5 -->
      <script src="<?=_R_?>js/bootstrap.min.js"></script>
    </body>
    </html>

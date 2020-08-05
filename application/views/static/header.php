<?php 
if ( strpos($_SERVER['REQUEST_URI'],'consulta')!==false ||strpos($_SERVER['REQUEST_URI'],'cobros')!==false ){ 
}elseif($this->session->log_status !== 'success'){
  redirect(_App_.'?ref='.uri_string());} ?>
  <?php $name = ucfirst($this->session->log_name); ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$title?> | Credit 24/7</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
j   <link rel="stylesheet" href="<?=_R_?>css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=_R_?>css/font-awesome.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?=_R_?>plugins/select2/select2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=_R_?>plugins/datatables/dataTables.bootstrap.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?=_R_?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=_R_?>css/AdminLTE.css">
    <!-- AdminLTE Skin. -->
    <link rel="stylesheet" href="<?=_R_?>css/skin-blue-light.min.css">
    <!-- Custom Styles. -->
    <link rel="stylesheet" href="<?=_R_?>css/styles.css">

    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">  -->

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

    <body class="hold-transition fixed skin-blue-light sidebar-mini">
      <div class="wrapper">
        <header class="main-header">
          <!-- Logo -->
          <a href="<?=_App_?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">H&M</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?=_R_?>/img/whiteLogo1.png" alt=""> Credit 24-7</span>
          </a>

          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <!-- Navbar Right Menu -->
            <?php if(in_array($this->session->log_role,['C','A','M'])){?>
            
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?=_R_?>/img/user.png" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?=$name?></span>
                    </a>
                    <div class="list-group dropdown-menu">
                    <a class="list-group-item" href="" data-toggle="modal" data-target="#modal-fpwd">Cambiar Contraseña</a>
                    <a class="list-group-item" href="<?=_App_?>logout">Cerrar Sesión</a>                    
                    </div>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li class="bg-red">
                    <a href="<?=_App_?>logout"><i class="fa fa-power-off"></i></a>
                    </li>
              </ul>
            </div>
            
            <?php }else{?>

<div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                    <li>
                    <a href="<?=_App_?>"><i class="fa fa-key"></i></a>
                    </li>
              </ul>
            </div>
            <?php }?>
          </nav>
        </header>
        <div class="se-pre-con"></div>



        <div class="modal modal-success fade" id="modal-fpwd">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                  <p class="text-block text-center">En breve recibirás un correo electrónico con instrucciones sobre cómo continuar.</p>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-outline">Solicitar contraseña</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal modal-success fade" id="modal-reset-ok">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva contraseña solicitada.</h4>
              </div>
              <div class="modal-body">
                <p class="text-block text-center">En breve recibirás un correo electrónico con instrucciones sobre cómo continuar.</p>
              </div>
              <div class="modal-footer">
                <div class="text-center">
                <a href="<?=_App_?>logout" class="btn btn-outline">Salir</a>
                </div>        
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
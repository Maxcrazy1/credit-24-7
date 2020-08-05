<?php 
if ( !in_array($_SERVER['REQUEST_URI'],['consulta','cobros','perfil','prestamos'])){ 
}elseif($this->session->log_status !== 'success'){
  redirect(_App_.'?ref='.uri_string());} ?>
<?php $name = ucfirst($this->session->log_name); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Credit 24-7</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=_R_?>css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=_R_?>css/font-awesome.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?=_R_?>plugins/select2/select2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=_R_?>plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=_R_?>css/AdminLTE.css">
    <!-- AdminLTE Skin. -->
    <link rel="stylesheet" href="<?=_R_?>css/skin-blue-light.min.css">
    <!-- Custom Styles. -->

    <link rel="stylesheet" href="<?=_R_?>css/styles.css">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">  -->

    <script src="<?=_R_?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript">

    $(window).load(function() {
        $(".se-pre-con").fadeOut("slow");
    });
    </script>
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
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
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu" style="width:100%">
                    <ul class="nav navbar-nav" style="width:100%">
                        <li>
                            <!-- Sidebar toggle button-->
                            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" rol="button">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                            </a>
                        </li>
                        <li class="bg-red pull-right">
                            <a href="<?=_App_?>logout?ref=cobros"><i class="fa fa-power-off"></i></a>
                        </li>
                        <li class="pull-right user user-menu">
                            <a><img src="<?=_R_?>/img/user.png" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?=$name ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="se-pre-con"></div>
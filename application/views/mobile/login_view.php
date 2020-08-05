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
		<link rel="stylesheet" href="<?=_R_?>css/font-awesome.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?=_R_?>css/AdminLTE.min.css">
		<link rel="stylesheet" href="<?=_R_?>css/AdminLTE.css">
		<link rel="stylesheet" href="<?=_R_?>css/skin-blue-light.min.css">
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
			<!-- /.login-logo -->
				<div class="login-box-body">
					<form action="<?=_App_?>mlogin" method="get">
						<input type="hidden" name="ref" value="<?=$ref?>">
						<div class="modal-header">
							<a href="<?=_App_?>" type="button" class="close"><span aria-hidden="true">&times;</span></a>
							<h4 class="modal-title">Inicio de <strong>Colaboradores</strong></h4>
						</div>
						<div class="form-group has-feedback">
							<input type="text" name="username" class="form-control" placeholder="Usuario">
							<span class="glyphicon glyphicon-user form-control-feedback"></span>
						</div>
						<div class="form-group has-feedback">
							<input type="password" name="password" class="form-control" placeholder="Contraseña" required>
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
					</div><!-- /.login-box-body -->
					</div><!-- /.login-box -->
					
					<?php if (uri_string() == 'cobros/error'): ?>
					<div class="container">
					<div id="alert" class="row">
					<div class="col-md-4 col-md-offset-4">
					<div class="alert alert-danger">
					<h4><i class="icon fa fa-ban"></i>Datos incorrectos</h4>
					El número de teléfono o contraseña son inválidos.
					</div>
					</div>
					</div>
					</div>
					<?php endif; ?>
					
					<?php if (uri_string() == 'cobros/errorI'): ?>
					<div class="container">
					<div id="alert" class="row">
					<div class="col-md-4 col-md-offset-4">
					<div class="alert alert-danger">
					<h4><i class="icon fa fa-ban"></i>Cuenta inactiva</h4>
					Su cuenta está temporalmente desactivada.
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
										
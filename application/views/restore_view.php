        <div class="login-box">
          <div class="login-logo">
            Cambio de <strong>Contraseña</strong>
          </div><!-- /.login-logo -->
          <div class="login-box-body">
            <form action="<?=_App_?>usuarios/cambiar" method="get" enctype="multipart/form-data">
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
        

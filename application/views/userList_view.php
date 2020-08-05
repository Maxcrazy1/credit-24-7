      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Usuarios <small>Módulo de Control</small></h1>
          <div class="breadcrumb pull-right">
            <a  data-toggle="modal" data-target="#modal-add" class="btn btn-sm bg-light-blue" href=""><i class="fa fa-plus"></i>&nbsp; Agregar Nuevo Usuario</a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row hidden">
            <div class="col-md-6 col-md-offset-3">
              <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Busqueda...">
                  <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
                </div>
              </form>
            </div>
          </div>
          <hr>

          <div class="row">
            <?php foreach ($userList as $user) : ?>
              <?php if ($user->usr_id != 0): ?>
                <?php 
                  #===============================================================================
                $background = 'bg-olive' ;
                  #===============================================================================
                ?>
                <div class="col-md-4">
                  <div class="info-box">
                    <a class="" href="<?=_App_.'usuarios/'.$user->usr_id?>">
                      <span class="info-box-icon <?=$background?>"><i class="fa fa- fa-user"></i></span>
                    </a>
                    <div class="info-box-content">
                      <span class="info-box-number"><?=$user->usr_name?></span>
                      <span class="info-box-text">Correo:  <?=$user->usr_email?></span>
                    </div><!-- /.info-box-content -->
                  </div><!-- /.info-box -->
                </div><!-- /.col -->
              <?php endif ?>
            <?php   endforeach; ?> 
          </div><!-- /.row -->

          <div class="modal fade" id="modal-add">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Agregar nuevo usuario</h4>
                </div>
                <form class="form-horizontal" action="<?=_App_?>usuarios/agregar" method="POST">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre completo" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Usuario</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="usuario" placeholder="Nombre de usuario" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPhone" class="col-sm-2 control-label">Clave</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputExperience" class="col-sm-2 control-label">Teléfono</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" name="telefono" placeholder="Teléfono" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputExperience" class="col-sm-2 control-label">Correo</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="correo" placeholder="Correo" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputExperience" class="col-sm-2 control-label">Notas</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" name="notas" placeholder="Notas"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                  </div>
                </form>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->



      <div class="modal modal-danger fade" id="modal-error">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title">Datos inválidos</h3>
            </div>
            <div class="modal-body">
              El nombre de usuario no coincide con ningún registro.
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
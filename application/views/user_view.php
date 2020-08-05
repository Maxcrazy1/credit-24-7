      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Perfil de usuario</h1>
          <div class="breadcrumb pull-right">
            <a data-toggle="modal" data-target="#modal-disable-user" class="btn btn-sm bg-yellow" href=""><i class="fa fa-ban"></i>&nbsp;Eliminar Administrador</a>
            <a data-toggle="modal" data-target="#modal-remove-user" class="btn btn-sm bg-red" href=""><i class="fa fa-trash"></i>&nbsp; Eliminar Usuario</a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">
              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <h3 class="profile-username text-center"><?=$userInfo->usr_name?></h3>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Rol</b> <span class="pull-right"><?=($userInfo->usr_role == "A")? 'Administrador' : 'Sistema';?></span>
                    </li>
                    <li class="list-group-item">
                      <b>Recaudado hoy</b> <span class="pull-right">₡ <span class="masked"><?=$revenueColab?></span></span>
                    </li>
                  </ul>

                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Datos Personales</h3>
                  <a href="" data-toggle="modal" data-target="#modal-edit-user" class="pull-right">editar</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-envelope margin-r-5"></i> Correo</strong>
                  <p class="text-muted"><?=$userInfo->usr_email ?></p>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#recent-activity" data-toggle="tab">Cobros del día</a></li>
                    <li><a href="#timeline" data-toggle="tab">Préstamos del día</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="recent-activity">
                      <div class="table-responsive no-padding">
                        <?php if ($paymentList): ?>
                        <table class="table table-hover">
                         <thead>
                          <tr>
                            <th># Préstamo</th>
                            <th>Cliente</th>
                            <th>Fecha del abono</th>
                            <th>Monto del abono</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($paymentList as $payment): ?>
                            <?php #===============================================================================
                            $timestamp = human_to_unix($payment->abn_fecha); # Covertir la fecha a timestamp
                            $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                            #=============================================================================== ?>
                            <tr>
                              <td>
                                <span><i class="fa fa-barcode"></i> <?=$payment->prt_id?></span>
                                <a class="pull-right" href="<?=_App_.'prestamos/'.$payment->prt_id?>">Detalle</a>
                              </td>
                              <td><?=$payment->cli_nombre?></td>
                              <td><?=$date?></td>
                              <td>₡ <span class="masked"><?=$payment->abn_monto?></span></td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>
                    <?php else: ?>
                    <p class="lead text-center">No hay cobros registrados.</p>
                  <?php endif ?>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="text-muted">Mostrando las 10 entradas más recientes.</div>
                </div>
              </div><!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <div class="box-body table-responsive no-padding">
                  <?php if ($loanList): ?>
                  <table class="table table-hover">
                   <thead>
                    <tr>
                      <th># Préstamo</th>
                      <th>Fecha del Préstamo</th>
                      <th>Nombre del Cliente</th>
                      <th>Monto del Préstamo</th>
                      <th>Tipo de pago</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($loanList as $loan): ?>
                            <?php #===============================================================================
                            $timestamp = human_to_unix($loan->prt_fecha); # Covertir la fecha a timestamp
                            $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                            #=============================================================================== ?>
                            <tr>
                              <td>
                                <span><i class="fa fa-barcode"></i> <?=$loan->prt_id?></span>
                                <a class="pull-right" href="<?=_App_.'prestamos/'.$loan->prt_id?>" target="_blank">Detalle</a>
                              </td>
                              <td><?=$date?></td>
                              <td><?=$loan->cli_nombre?></td>
                              <td>₡ <span class="masked"><?=$loan->prt_monto?></span></td>
                              <td><?=$loan->prt_tipo?></td>
                            </tr>
                          <?php endforeach ?>
                        </tbody>
                      </table>  
                    <?php else: ?>
                    <p class="lead text-center">No hay préstamos registrados.</p>
                  <?php endif ?>
                </div>
              </div><!-- /.tab-pane -->

            </div><!-- /.tab-content -->
          </div><!-- /.nav-tabs-custom -->
        </div>
      </div><!-- /.col -->
    </div><!-- /.row -->

  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div class="modal fade" id="modal-edit-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar datos del usuario</h4>
      </div>
      <form class="form-horizontal" action="<?=_App_?>usuarios/actualizar" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nombre" value="<?=$userInfo->usr_name?>" placeholder="Nombre completo">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPhone" class="col-sm-2 control-label">Correo</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="correo" value="<?=$userInfo->usr_email?>" placeholder="Correo">
            </div>
          </div>
          <input type="hidden" name="usuario" value="<?=$userInfo->usr_id?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal modal-danger fade" id="modal-remove-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Eliminar Usuario</h3>
      </div>
      <form class="form-horizontal" action="<?=_App_?>usuarios/borrar" method="POST">
        <div class="modal-body">
          <h3 class="text-block text-center">¿Esta seguro desea eliminar este usuario?</h3>
          <h4 class="text-block text-center">Esta opcion es irreversible</h4>
          <h4 class="text-block text-center">Se eliminará toda la información relacionada con este usuario</h4>
          <input type="hidden" name="usuario" value="<?=$userInfo->usr_id?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline">Continuar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal modal-warning fade" id="modal-disable-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Eliminar Administrador</h3>
      </div>
      <form class="form-horizontal" action="<?=_App_?>usuarios/eliminar" method="POST">
        <div class="modal-body">
          <h3 class="text-block text-center">¿Esta seguro desea eliminar este administrador?</h3>
          <h4 class="text-block text-center">Esta opción es irreversible</h4>
          <input type="hidden" name="usuario" value="<?=$userInfo->usr_id?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline">Continuar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal modal-success fade" id="modal-reset">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Contraseña Restaurada</h4>
      </div>
      <div class="modal-body">
        <p class="lead text-center">La clave temporal es <strong>"1234"</strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
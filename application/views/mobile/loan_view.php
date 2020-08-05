      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>Detalle de Préstamo </h1>
              <h4><?=$dataClient->cli_nombre ?> <small>Doc. de identidad #<?=$dataClient->cli_cedula?></small></h4>
              
          </section>
          <?php
          #===============================================================================
          $timestamp = human_to_unix($loanInfo->prt_fecha); # Covertir la fecha a timestamp
          $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
          #===============================================================================
          ?>

          <section class="content">
              <!-- Main content -->
            <?php if(in_array($this->session->log_role,['C','A','M'])):?>
              <div class="row">
                  <div class="col-md-4 col-xs-12">
                      <!-- Profile Image -->
                      <div class="box box-primary">
                          <div class="box-body box-profile">

                              <?php if ($loanInfo->prt_saldo > 0): ?>
                              <h1 class="profile-username text-center"> ₡ <span
                                      class="masked"><?=$loanInfo->prt_saldo?></span></h1>
                              <p class="text-muted text-center">Saldo restante</p>
                              <?php else: ?>
                              <h1 class="profile-username text-center">CANCELADO</h1>
                              <p class="text-muted text-center">Préstamo cancelado.</p>
                              <?php endif ?>

                              <ul class="list-group list-group-unbordered">
                                  <li class="list-group-item">
                                      <b>Tipo de préstamo</b>
                                      <span class="pull-right">
                                          <?php switch ($loanInfo->prt_tipo):
                        case 'D': echo $loanInfo->prt_tipo = "Diario"; break;
                        case 'S': echo $loanInfo->prt_tipo = "Semanal"; break;
                        case 'Q': echo $loanInfo->prt_tipo = "Quincenal"; break;
                        endswitch; ?>
                                      </span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Monto del préstamo</b>
                                      <span class="pull-right">
                                          ₡ <span class="masked"><?=$loanInfo->prt_monto?></span>
                                      </span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Total a pagar</b>
                                      <span class="pull-right">
                                          ₡ <span class="masked"><?=$loanInfo->prt_total?></span>
                                      </span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Monto de la cuota</b>
                                      <span class="pull-right">
                                          ₡ <span class="masked"><?=$loanInfo->prt_cuota?></span>
                                      </span>
                                  </li>
                              </ul>
                              <?php if ($loanInfo->prt_estado): ?>
                              <a href="#" data-toggle="modal" data-target="#modal-add-payment"
                                  class="btn btn-primary btn-block"><b>Registrar Pago</b></a>
                              <?php endif ?>
                          </div><!-- /.box-body -->
                      </div><!-- /.box -->
                      <?php if ($lastPayment): ?>
                      <?php #===============================================================================
                $timestamp = human_to_unix($lastPayment->abn_fecha); # Covertir la fecha a timestamp
                $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                #=============================================================================== ?>
                      <div class="box box-primary">
                          <div class="box-header">
                              <h3 class="box-title">Último abono</h3>
                          </div>
                          <div class="box-body box-profile">
                              <ul class="list-group list-group-unbordered">
                                  <li class="list-group-item">
                                      <b>Fecha del abono</b>
                                      <span class="pull-right"><?=$date?></span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Monto del abono</b>
                                      <span class="pull-right">₡ <span
                                              class="masked"><?=$lastPayment->abn_monto?></span></span>
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <?php endif ?>
                      <?php if ($loanInfo->prt_estado): ?>
                      <a href="#" data-toggle="modal" data-target="#modal-add-loan"
                          class="btn btn-warning btn-block"><b>Renovar Préstamo</b></a>
                      <?php endif ?>
                  </div><!-- /.col -->
                  <div class="col-md-8 col-xs-12">
                      <div class="box">
                          <div class="box-header with-border">
                              <h3 class="box-title">Historial de pagos</h3>
                             <p>
                             <small><?=$dataClient->cli_nombre?> -</small><small>Doc. de identidad #<?=$dataClient->cli_cedula?></small> 
                             </p> 
                              <div class="box-tools">
                              </div>
                          </div><!-- /.box-header -->
                          <div class="box-body">
                              <?php if ($paymentList): ?>
                              <div class="table-responsive  no-padding">
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>Fecha del abono</th>
                                              <th>Monto</th>
                                              <th>Cobrador</th>
                                              <th>Comentarios</th>
                                              <th></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php foreach ($paymentList as $payment): ?>
                                          <?php
                                  #===============================================================================
                                  $timestamp = human_to_unix($payment->abn_fecha); # Covertir la fecha a timestamp
                                  $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                                  if ($payment->clb_id == 0) {
                                    $payment->clb_nombre = 'Sistema: '. ucfirst($payment->usr_name);
                                  }
                                  #===============================================================================
                                  ?>
                                          <tr>
                                              <td><?=$date?></td>
                                              <td class="<?=$payment->abn_status?>">₡ <span
                                                      class="masked"><?=$payment->abn_monto?></span></td>
                                              <td><?=$payment->clb_nombre?></td>
                                              <td><?=$payment->abn_nota?></td>
                                              <td><a href="<?=_App_.'abonos/confirmarBorrar/'.$payment->abn_id  ?>"><i
                                                          class="fa fa-undo"></i></a></td>
                                          </tr>
                                          <?php endforeach ?>
                                      </tbody>
                                  </table>
                              </div>
                              <?php else: ?>
                              <p class="lead text-center">No hay pagos registrados.</p>
                              <?php endif ?>
                          </div><!-- /.box-body -->
                      </div><!-- /.box -->
                  </div>
              </div>
          </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <div class="modal nofade" id="modal-add-payment">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                              aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Registrar un pago</h4>
                  </div>
                  <form class="form-horizontal" action="<?=_App_?>prestamos/pagar" method="GET">
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="inputMonto" class="col-sm-2 control-label">Monto</label>
                              <div class="col-sm-4">
                                  <div class="input-group">
                                      <span class="input-group-addon">₡</span>
                                      <input type="number" name="monto" class="form-control no-masked"
                                          value="<?=$loanInfo->prt_cuota?>" required>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="inputDireccion" class="col-sm-2 control-label">Comentarios</label>
                              <div class="col-sm-10">
                                  <textarea class="form-control" rows="4" name="notas"
                                      placeholder="Comentarios (Opcional)"></textarea>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <input type="hidden" name="prestamo" value="<?=$loanInfo->prt_id?>">
                          <input type="hidden" name="cliente" value="<?=$loanInfo->prt_cliente?>">
                          <input type="hidden" name="saldo" value="<?=$loanInfo->prt_saldo?>">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-primary">Registrar</button>
                      </div>
                  </form>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div>
      <div class="modal nofade" id="modal-add-loan">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                              aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Renovar un préstamo</h4>
                  </div>
                  <form class="form-horizontal" action="confirmarRenovar" method="GET">
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="inputMonto" class="col-sm-2 control-label">Monto</label>
                              <div class="col-sm-4">
                                  <div class="input-group">
                                      <span class="input-group-addon">₡</span>
                                      <input type="number" name="n_monto" class="form-control"
                                          value="<?=$loanInfo->prt_monto?>" min="<?=$loanInfo->prt_saldo?>" required>
                                  </div>
                              </div>
                              <label for="inputMonto" class="col-sm-2 control-label">Cuotas</label>
                              <div class="col-sm-4">
                                  <div class="input-group">
                                      <span class="input-group-addon">₡</span>
                                      <input type="number" name="n_cuotas" class="form-control"
                                          value="<?=$loanInfo->prt_cuota?>" required>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 control-label">Notas</label>
                              <div class="col-sm-10">
                                  <textarea class="form-control" name="n_notas"
                                      placeholder="Comentarios (Opcional)"> Préstamo renovado.</textarea>
                              </div>
                          </div>

                          <input type="hidden" name="cliente" value="<?=$loanInfo->prt_cliente?>">

                          <input type="hidden" name="o_prestamo" value="<?=$loanInfo->prt_id?>">
                          <input type="hidden" name="o_saldo" value="<?=$loanInfo->prt_saldo?>">

                          <input type="hidden" name="n_tipo" value="<?=$loanInfo->prt_tipo?>">
                          <input type="hidden" name="n_dia" value="<?=$hoy?>">

                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-primary">Guardar</button>
                      </div>
                  </form>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div>
      

      <script src="<?=_R_?>plugins/input-mask/jquery.inputmask.js"></script>
      <script src="<?=_R_?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
      <script src="<?=_R_?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
                              <?php else: ?>
<div class="row">
                  <div class="col-md-4 col-xs-12">
                      <!-- Profile Image -->
                      <div class="box box-primary">
                          <div class="box-body box-profile">

                              <?php if ($loanInfo->prt_saldo > 0): ?>
                              <h1 class="profile-username text-center"> ₡ <span
                                      class="masked"><?=$loanInfo->prt_saldo?></span></h1>
                              <p class="text-muted text-center">Saldo restante</p>
                              <?php else: ?>
                              <h1 class="profile-username text-center">CANCELADO</h1>
                              <p class="text-muted text-center">Préstamo cancelado.</p>
                              <?php endif ?>

                              <ul class="list-group list-group-unbordered">
                                  <li class="list-group-item">
                                      <b>Tipo de préstamo</b>
                                      <span class="pull-right">
                                          <?php switch ($loanInfo->prt_tipo):
                        case 'D': echo $loanInfo->prt_tipo = "Diario"; break;
                        case 'S': echo $loanInfo->prt_tipo = "Semanal"; break;
                        case 'Q': echo $loanInfo->prt_tipo = "Quincenal"; break;
                        endswitch; ?>
                                      </span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Monto del préstamo</b>
                                      <span class="pull-right">
                                          ₡ <span class="masked"><?=$loanInfo->prt_monto?></span>
                                      </span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Total a pagar</b>
                                      <span class="pull-right">
                                          ₡ <span class="masked"><?=$loanInfo->prt_total?></span>
                                      </span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Monto de la cuota</b>
                                      <span class="pull-right">
                                          ₡ <span class="masked"><?=$loanInfo->prt_cuota?></span>
                                      </span>
                                  </li>
                              </ul>
                          </div><!-- /.box-body -->
                      </div><!-- /.box -->

                  </div><!-- /.col -->
                  <div class="col-md-8 col-xs-12">
                      <div class="box">
                          <div class="box-header with-border">
                              <h3 class="box-title">Historial de pagos</h3>
                             <p>
                             <small><?=$dataClient->cli_nombre?> -</small><small>Doc. de identidad #<?=$dataClient->cli_cedula?></small> 
                             </p> 
                              <div class="box-tools">
                              </div>
                          </div><!-- /.box-header -->
                          <div class="box-body">
                              <?php if ($paymentList): ?>
                              <div class="table-responsive  no-padding">
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>Fecha del abono</th>
                                              <th>Monto</th>
                                              <th>Cobrador</th>
                                              <th>Comentarios</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php foreach ($paymentList as $payment): ?>
                                          <?php
                                  #===============================================================================
                                  $timestamp = human_to_unix($payment->abn_fecha); # Covertir la fecha a timestamp
                                  $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                                  if ($payment->clb_id == 0) {
                                    $payment->clb_nombre = 'Sistema: '. ucfirst($payment->usr_name);
                                  }
                                  #===============================================================================
                                  ?>
                                          <tr>
                                              <td><?=$date?></td>
                                              <td class="<?=$payment->abn_status?>">₡ <span
                                                      class="masked"><?=$payment->abn_monto?></span></td>
                                              <td><?=$payment->clb_nombre?></td>
                                              <td><?=$payment->abn_nota?></td>
                                          </tr>
                                          <?php endforeach ?>
                                      </tbody>
                                  </table>
                              </div>
                              <?php else: ?>
                              <p class="lead text-center">No hay pagos registrados.</p>
                              <?php endif ?>
                          </div><!-- /.box-body -->
                      </div><!-- /.box -->
                  </div>

              </div>
<div class="row">
<div class="col-md-12">
      <?php if ($lastPayment): ?>
                      <?php #===============================================================================
                $timestamp = human_to_unix($lastPayment->abn_fecha); # Covertir la fecha a timestamp
                $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                #=============================================================================== ?>
                      <div class="box box-primary">
                          <div class="box-header">
                              <h3 class="box-title">Último abono</h3>
                          </div>
                          <div class="box-body box-profile">
                              <ul class="list-group list-group-unbordered">
                                  <li class="list-group-item">
                                      <b>Fecha del abono</b>
                                      <span class="pull-right"><?=$date?></span>
                                  </li>
                                  <li class="list-group-item">
                                      <b>Monto del abono</b>
                                      <span class="pull-right">₡ <span
                                              class="masked"><?=$lastPayment->abn_monto?></span></span>
                                  </li>
                              </ul>
                          </div>
                      </div>
                      <?php endif ?>
                 
</div>
</div>                              
      </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php endif ?>
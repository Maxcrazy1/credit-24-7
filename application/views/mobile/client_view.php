<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Perfil del Cliente</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php if($this->session->log_role === 'C'){?>
        <div class="row">
            <div class="col-md-3">
                <?php
                  #===============================================================================
                  $timestamp = human_to_unix($clientInfo->cli_registro); # Covertir la fecha a timestamp
                  $date = date('d-m-Y', $timestamp); # Formatear la fecha al formato local
                  #===============================================================================
                  $reg = "Región";
                      foreach ($regionList as $region) :
                        if ($region->reg_id == $clientInfo->cli_region) :
                            $reg = $region->reg_nombre;
                            $regid = $region->reg_id;
                        endif;
                      endforeach;
                ?>
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center"><?=$clientInfo->cli_nombre ?></h3>
                        <p class="muted-text text-center">Doc. de identidad #<?=$clientInfo->cli_cedula?></p>
                        <p class="muted-text text-center"><span><?=$reg?></span></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Cliente desde</b> <span class="pull-right"><?=$date?></span>
                            </li>
                        </ul>
                        <a href="#" data-toggle="modal" data-target="#modal-add-loan"
                            class="btn btn-primary btn-block"><b>Nuevo
                                Préstamo</b></a>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos Personales</h3>
                        <a href="" data-toggle="modal" data-target="#modal-edit-client" class="pull-right">editar</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Cédula</strong>
                        <p><?=$clientInfo->cli_cedula ?></p>
                        <hr>
                        <strong><i class="fa fa-phone margin-r-5"></i> Teléfono de Contacto</strong>
                        <?php if (($this->session->log_user == '73')||($this->session->log_user == '78')): ?>
                        <a class="btn btn-success btn-block" href="tel:<?=$clientInfo->cli_telefono ?>">Llamar
                            <?=$clientInfo->cli_telefono ?></a>
                        <?php else: ?>
                        <p class="text-muted"><?=$clientInfo->cli_telefono ?></p>
                        <?php endif ?>

                        <hr>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Dirección Exacta</strong>
                        <p class="text-muted"><?=$clientInfo->cli_direccion?></p>
                        <hr>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Dirección GPS</strong>
                        <p class="text-muted"><?=$clientInfo->cli_direccion_gps?></p>
                        <hr>
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Comentarios</strong>
                        <p><?=$clientInfo->cli_notas ?></p>
                    </div><!-- /.box-body -->
                </div>
            </div><!-- /.col -->

            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#active-loans" data-toggle="tab">Créditos Activos</a></li>
                            <li><a href="#recent-activity" data-toggle="tab">Pagos Recientes</a></li>
                            <li><a href="#archived-loans" data-toggle="tab">Créditos Pasados</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="active-loans">
                                <?php if ($loanList): ?>
                                <div class="row">
                                    <?php foreach ($loanList as $loan) : ?>
                                    <?php
                                    #===============================================================================
                                    $timestamp = human_to_unix($loan->prt_fecha); # Covertir la fecha a timestamp
                                    $date = date('d-m-Y', $timestamp); # Formatear la fecha al formato local
                                    #===============================================================================
                                    $payed = $loan->prt_total - $loan->prt_saldo; # Calcular el monto total pagado
                                    $progress = ($payed * 100) / $loan->prt_total; # Calcular el porcentaje pagado
                                    #===============================================================================
                                    ?>
                                    <div class="col-md-12">
                                        <div class="info-box bg-yellow">
                                            <a class="" href="<?=_App_.'cobros/prestamos/'.$loan->prt_id?>"
                                                style="color:white !important;">
                                                <span class="info-box-icon"><i class="fa fa-credit-card"></i></span>
                                            </a>
                                            <div class="info-box-content">
                                                <span class="info-box-text"><?=$date?> </span>
                                                <span class="info-box-number">₡ <span
                                                        class="masked"><?=$loan->prt_monto?>
                                                    </span>
                                                </span>

                                                <div class="progress">
                                                    <div class="progress-bar" style="width: <?=$progress?>%"></div>
                                                </div>
                                                <span class="progress-description">₡ <span
                                                        class='masked'><?=$loan->prt_saldo?></span> por pagar.</span>
                                            </div>
                                        </div>
                                    </div><!-- /.info-box -->
                                    <?php endforeach;?>
                                </div><!-- /.row -->
                                <?php else: ?>
                                <p class="lead text-center">No hay créditos activos.</p>
                                <?php endif ?>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="recent-activity">
                                <?php if ($paymentList): ?>
                                <div class="table-responsive  no-padding">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th># Préstamo</th>
                                                <th>Fecha del registro</th>
                                                <th>Monto del abono</th>
                                                <th>Cobrador</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($paymentList as $payment): ?>
                                            <?php #=========================================================================
                                        $timestamp = human_to_unix($payment->abn_fecha); # Covertir la fecha a timestamp
                                        $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                                        #===============================================================================?>
                                            <tr>
                                                <td>
                                                    <span><i class="fa fa-barcode"></i> <?=$payment->prt_id?></span>
                                                </td>
                                                <td><?=$date?></td>
                                                <td>₡ <span class="masked"><?=$payment->abn_monto?></span></td>
                                                <td><?=$payment->clb_nombre?></td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>


                                <?php else: ?>
                                <p class="lead text-center">No hay pagos registrados.</p>
                                <?php endif ?>
                            </div><!-- /.tab-pane-->
                            <div class="tab-pane" id="archived-loans">
                                <?php if ($loanHistory): ?>
                                <div class="row">
                                    <?php foreach ($loanHistory as $loan) : ?>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="info-box bg-gray">
                                            <?php #=========================================================================
                                            $timestamp = human_to_unix($loan->prt_fecha); # Covertir la fecha a timestamp
                                            $date = date('d-m-Y', $timestamp); # Formatear la fecha al formato local
                                            #===============================================================================
                                            $payed = $loan->prt_total - $loan->prt_saldo; # Calcular el monto total pagado
                                            $progress = ($payed * 100) / $loan->prt_total; # Calcular el porcentaje pagado
                                            #===============================================================================?>


                                            <div class="info-box">
                                                <span class="info-box-icon"><i class="fa fa-credit-card"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"><?=$date?></span>
                                                    <span class="info-box-number">₡ <span
                                                            class="masked"><?=$loan->prt_monto?></span></span>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?=$progress?>%"></div>
                                                    </div>
                                                    <span class="progress-description">Cancelado</span>
                                                </div>
                                            </div>
                                        </div><!-- /.info-box -->
                                    </div>
                                    <?php endforeach;?>
                                </div><!-- /.row -->
                            </div><!-- /.box-body -->
                            <?php else: ?>
                            <p class="lead text-center">No hay créditos archivados.</p>
                            <?php endif ?>
                        </div><!-- /.tab-content -->
                    </div><!-- /.nav-tabs-custom -->
                </div>
            </div>
        </div>
        <?php }else{ ?>

        <div class="row">
            <div class="col-md-3">
                <?php
                  #===============================================================================
                  $timestamp = human_to_unix($clientInfo->cli_registro); # Covertir la fecha a timestamp
                  $date = date('d-m-Y', $timestamp); # Formatear la fecha al formato local
                  #===============================================================================
                  $reg = "Región";
                ?>
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center"><?=$clientInfo->cli_nombre ?></h3>
                        <p class="muted-text text-center">Doc. de identidad #<?=$clientInfo->cli_cedula?></p>
                        <p class="muted-text text-center"><span><?=$reg?></span></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Cliente desde</b> <span class="pull-right"><?=$date?></span>
                            </li>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col -->


            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#active-loans" data-toggle="tab">Créditos Activos</a></li>
                            <li><a href="#recent-activity" data-toggle="tab">Pagos Recientes</a></li>
                            <li><a href="#archived-loans" data-toggle="tab">Créditos Pasados</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="active-loans">
                                <?php if ($loanList): ?>
                                <div class="row">
                                    <?php foreach ($loanList as $loan) : ?>
                                    <?php
                                    #===============================================================================
                                    $timestamp = human_to_unix($loan->prt_fecha); # Covertir la fecha a timestamp
                                    $date = date('d-m-Y', $timestamp); # Formatear la fecha al formato local
                                    #===============================================================================
                                    $payed = $loan->prt_total - $loan->prt_saldo; # Calcular el monto total pagado
                                    $progress = ($payed * 100) / $loan->prt_total; # Calcular el porcentaje pagado
                                    #===============================================================================
                                    ?>
                                    <div class="col-md-12">
                                        <div class="info-box bg-yellow">
                                            <a class="" href="<?=_App_.'cobros/prestamos/'.encrypt($loan->prt_id)?>"
                                                style="color:white !important;">
                                                <span class="info-box-icon"><i class="fa fa-credit-card"></i></span>
                                            </a>
                                            <div class="info-box-content">
                                                <span class="info-box-text"><?=$date?> | Presiona el
                                                    ícono para ver más información del crédito</span>
                                                <span class="info-box-number">₡ <span
                                                        class="masked"><?=$loan->prt_monto?>
                                                    </span>
                                                </span>

                                                <div class="progress">
                                                    <div class="progress-bar" style="width: <?=$progress?>%"></div>
                                                </div>
                                                <span class="progress-description">₡ <span
                                                        class='masked'><?=$loan->prt_saldo?></span> por pagar.
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- /.info-box -->
                                    <?php endforeach;?>
                                </div><!-- /.row -->
                                <?php else: ?>
                                <p class="lead text-center">No hay créditos activos.</p>
                                <?php endif ?>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="recent-activity">
                                <?php if ($paymentList): ?>
                                <div class="table-responsive  no-padding">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th># Préstamo</th>
                                                <th>Fecha del registro</th>
                                                <th>Monto del abono</th>
                                                <th>Cobrador</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($paymentList as $payment): ?>
                                            <?php #=========================================================================
                                        $timestamp = human_to_unix($payment->abn_fecha); # Covertir la fecha a timestamp
                                        $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                                        #===============================================================================?>
                                            <tr>
                                                <td>
                                                    <span><i class="fa fa-barcode"></i> <?=$payment->prt_id?></span>
                                                </td>
                                                <td><?=$date?></td>
                                                <td>₡ <span class="masked"><?=$payment->abn_monto?></span></td>
                                                <td><?=$payment->clb_nombre?></td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                <p class="lead text-center">No hay pagos registrados.</p>
                                <?php endif ?>
                            </div><!-- /.tab-pane-->
                            <div class="tab-pane" id="archived-loans">
                                <?php if ($loanHistory): ?>
                                <div class="row">
                                    <?php foreach ($loanHistory as $loan) : ?>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="info-box bg-gray">
                                            <?php #=========================================================================
                                            $timestamp = human_to_unix($loan->prt_fecha); # Covertir la fecha a timestamp
                                            $date = date('d-m-Y', $timestamp); # Formatear la fecha al formato local
                                            #===============================================================================
                                            $payed = $loan->prt_total - $loan->prt_saldo; # Calcular el monto total pagado
                                            $progress = ($payed * 100) / $loan->prt_total; # Calcular el porcentaje pagado
                                            #===============================================================================?>


                                            <div class="info-box">
                                                <a class="" href="<?=_App_.'cobros/prestamos/'.$loan->prt_id?>"
                                                    style="color:white !important;">
                                                    <span class="info-box-icon"><i class="fa fa-credit-card"></i></span>
                                                </a>
                                                <div class="info-box-content">
                                                    <span class="info-box-text"><?=$date?></span>
                                                    <span class="info-box-number">₡ <span
                                                            class="masked"><?=$loan->prt_monto?></span></span>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?=$progress?>%"></div>
                                                    </div>
                                                    <span class="progress-description">Cancelado</span>
                                                </div>
                                            </div>
                                        </div><!-- /.info-box -->
                                    </div>
                                    <?php endforeach;?>
                                </div><!-- /.row -->
                            </div><!-- /.box-body -->
                            <?php else: ?>
                            <p class="lead text-center">No hay créditos archivados.</p>
                            <?php endif ?>
                        </div><!-- /.tab-content -->
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos Personales</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Cédula</strong>
                        <p><?=$clientInfo->cli_cedula ?></p>
                        <hr>
                        <strong><i class="fa fa-phone margin-r-5"></i> Teléfono de Contacto</strong>
                        <p class="text-muted"><?=$clientInfo->cli_telefono ?></p>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>

        <?php } ?>
        <!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- Modales -->
<!-- Modal Editar Cliente -->
<?php if($this->session->log_role === 'C'){?>
<div class="modal fade" id="modal-edit-client">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar datos del cliente</h4>
            </div>
            <!--readonly="readonly" sirve para que no puedan escribir en un unput y disabled="disabled" para bloquear todo el input-->
            <form class="form-horizontal" action="<?=_App_?>clientes/actualizar" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nombre" value="<?=$clientInfo->cli_nombre?>"
                                placeholder="Nombre completo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputCedula" class="col-sm-2 control-label">Cédula</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="cedula" value="<?=$clientInfo->cli_cedula?>"
                                placeholder="Cédula">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPhone" class="col-sm-2 control-label">Teléfono</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="telefono"
                                value="<?=$clientInfo->cli_telefono?>" placeholder="Teléfono">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputMonto" class="col-sm-2 control-label">Región</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="region" style="width: 100%;" required>
                                <?php foreach ($regionList as $region) : ?>
                                <?php if ($region->reg_id == $clientInfo->cli_region) {?>
                                <option value="<?=$region->reg_id?>" selected><?=$region->reg_nombre?></option>
                                <?php } ?>
                                <?php if ($region->reg_id != $clientInfo->cli_region) { ?>
                                <option value="<?=$region->reg_id?>"><?=$region->reg_nombre?></option>
                                <?php } ?>
                                <?php  endforeach; ?>
                            </select>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="inputMonto" class="col-sm-2 control-label">2da Región</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="region2" style="width: 100%;" required>
                                <option>Selecciona una Región</option>
                                <?php foreach ($regionList as $region2) : ?>
                                <?php if ($region2->reg_id == $clientInfo->cli_region2) {?>
                                <option value="<?=$region2->reg_id?>" selected><?=$region2->reg_nombre?></option>
                                <?php } ?>
                                <?php if ($region2->reg_id != $clientInfo->cli_region2) { ?>
                                <option value="<?=$region2->reg_id?>"><?=$region2->reg_nombre?></option>
                                <?php } ?>
                                <?php  endforeach; ?>
                            </select>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="inputMonto" class="col-sm-2 control-label">3ra Región</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="region3" style="width: 100%;" required>
                                <option>Selecciona una Región</option>
                                <?php foreach ($regionList as $region3) : ?>
                                <?php if ($region3->reg_id == $clientInfo->cli_region3) {?>
                                <option value="<?=$region3->reg_id?>" selected><?=$region3->reg_nombre?></option>
                                <?php } ?>
                                <?php if ($region3->reg_id != $clientInfo->cli_region3) { ?>
                                <option value="<?=$region3->reg_id?>"><?=$region3->reg_nombre?></option>
                                <?php } ?>
                                <?php  endforeach; ?>
                            </select>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="inputDireccion" class="col-sm-2 control-label">Dirección</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="direccion"
                                placeholder="Direccion exacta"><?=$clientInfo->cli_direccion?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccionGps" class="col-sm-2 control-label">Dirección GPS</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="direccionGps"
                                placeholder="Dirección GPS"><?=$clientInfo->cli_direccion_gps?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDireccion" class="col-sm-2 control-label">Notas</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="notas"
                                placeholder="Notas"><?=$clientInfo->cli_notas?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="clientID" value="<?=$clientInfo->cli_id?>">
                    <input type="hidden" name="mobile" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-add-loan">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registrar un nuevo préstamo</h4>
              </div>
              <form class="form-horizontal" action="<?=_App_?>prestamos/agregar" method="get">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputMonto" class="col-sm-2 control-label">Cliente</label>
                    <div class="col-sm-8">
                      <input type="hidden" name="cliente" class="form-control" value="<?=$clientInfo->cli_id?>" readonly>
                      <input type="text" name="nombreCliente" class="form-control" value="<?=$clientInfo->cli_nombre?>" readonly>
                    </div>
                    <div class="col-sm-2">
                      <a class="btn btn-primary" href="" data-toggle="modal" data-target="#modal-add-client">
                      <i class="fa fa-plus"></i>
                      <i class="fa fa-user"></i>
                      </a>
                    </div>
                  </div><!-- /.form-group -->
                  <div class="form-group">
                    <label for="monto" class="col-sm-2 control-label">Monto</label>
                    <div class="col-sm-4">
                      <div class="input-group">
                        <span class="input-group-addon">₡</span>
                        <input type="text" name="monto" class="form-control masked" required>
                      </div>
                    </div>
                    <label for="cuotas" class="col-sm-2 control-label">Cuotas</label>
                    <div class="col-sm-4">
                      <div class="input-group">
                      <span class="input-group-addon">₡</span>
                        <input type="text" name="cuotas" class="form-control masked" required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputInteres" class="col-sm-2 control-label">Tasa de interés</label>
                    <div class="col-sm-6">
                      <div class="input-group">
                      <span class="input-group-addon">%</span>
                        <input type="text" name="interes" value="20" class="form-control masked" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputDireccion" class="col-sm-2 control-label">Notas</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="notas" placeholder="Comentarios (Opcional)"></textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Tipo</label>
                    <div class="radio">
                      <label class="col-sm-3 text-center"> <input type="radio" name="tipo" value="D" onchange="mostrar(this.value);" required> Diario </label>
                      <label class="col-sm-3 text-center"> <input type="radio" name="tipo" value="S" onchange="mostrar(this.value);" required> Semanal </label>
                      <label class="col-sm-3 text-center"> <input type="radio" name="tipo" value="Q" onchange="mostrar(this.value);" required> Quincenal </label>
                    </div>
                  </div>

                  <div id="RadioDia" class="form-group hidden">
                    <label class="col-sm-2 control-label">Día</label>
                    <div class="list-group-horizontal">
                      <label class="list-group-item"> <input type="radio" name="dia" value="L" checked required> Lun. </label>
                      <label class="list-group-item"> <input type="radio" name="dia" value="K" required> Mar.</label>
                      <label class="list-group-item"> <input type="radio" name="dia" value="M" required> Mie. </label>
                      <label class="list-group-item"> <input type="radio" name="dia" value="J" required> Jue. </label>
                      <label class="list-group-item"> <input type="radio" name="dia" value="V" required> Vie. </label>
                      <label class="list-group-item"> <input type="radio" name="dia" value="S" required> Sáb. </label>
                      <label class="list-group-item"> <input type="radio" name="dia" value="D" required> Dom. </label>
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
        </div>
<?php }?>
<?php if($this->session->log_role === 'C'){?>
<!-- Modal Nuevo Préstamo -->
<div class="modal fade" id="modal-add-loan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registrar un nuevo préstamo</h4>
            </div>
            <form class="form-horizontal" action="<?=_App_?>prestamos/agregar" method="get">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputMonto" class="col-sm-2 control-label">Cliente</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="mobile" value="1">
                            <input type="hidden" name="cliente" class="form-control" value="<?=$clientInfo->cli_id ?>"
                                readonly>
                            <input type="text" name="nombreCliente" class="form-control"
                                value="<?=$clientInfo->cli_nombre ?>" readonly>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-primary" href="" data-toggle="modal" data-target="#modal-add-client">
                                <i class="fa fa-plus"></i>
                                <i class="fa fa-user"></i>
                            </a>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="inputMonto" class="col-sm-2 control-label">Monto</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">₡</span>
                                <input type="text" name="monto" class="form-control masked" required>
                            </div>
                        </div>
                        <label for="inputMonto" class="col-sm-2 control-label">Cuotas</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">₡</span>
                                <input type="text" name="cuotas" class="form-control masked" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDireccion" class="col-sm-2 control-label">Notas</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="notas" placeholder="Comentarios (Opcional)"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tipo</label>
                        <div class="radio">
                            <label class="col-sm-3 text-center"> <input type="radio" name="tipo" value="D"
                                    onchange="mostrar(this.value);" required> Diario </label>
                            <label class="col-sm-3 text-center"> <input type="radio" name="tipo" value="S"
                                    onchange="mostrar(this.value);" required> Semanal </label>
                            <label class="col-sm-3 text-center"> <input type="radio" name="tipo" value="Q"
                                    onchange="mostrar(this.value);" required> Quincenal </label>
                        </div>
                    </div>

                    <div id="RadioDia" class="form-group hidden">
                        <label class="col-sm-2 control-label">Día</label>
                        <div class="list-group-horizontal">
                            <label class="list-group-item"> <input type="radio" name="dia" value="L" checked required>
                                Lun. </label>
                            <label class="list-group-item"> <input type="radio" name="dia" value="K" required>
                                Mar.</label>
                            <label class="list-group-item"> <input type="radio" name="dia" value="M" required> Mie.
                            </label>
                            <label class="list-group-item"> <input type="radio" name="dia" value="J" required> Jue.
                            </label>
                            <label class="list-group-item"> <input type="radio" name="dia" value="V" required> Vie.
                            </label>
                            <label class="list-group-item"> <input type="radio" name="dia" value="S" required> Sáb.
                            </label>
                            <label class="list-group-item"> <input type="radio" name="dia" value="D" required> Dom.
                            </label>
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

<?php }?>
<!-- Select2 -->
<div class="modal modal-success" id="modal-success">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title">Abono registrado</h4>
                  </div>
                  <div class="modal-body">
                      <p class="lead text-center">¡La operación finalizó con éxito! <strong>:)</strong></p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-outline" data-dismiss="modal">Cerrar</button>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div>
<script src="<?=_R_?>plugins/select2/select2.full.min.js"></script>
<!-- Page script -->
<script>
$(function() {
    //Initialize Select2 Elements
    $(".select2").select2();
});
</script>
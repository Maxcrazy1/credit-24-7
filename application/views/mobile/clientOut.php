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
                <p class="muted-text text-center"><span><?=$reg?></span></p>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Cliente desde</b> <span class="pull-right"><?=$date?></span>
                    </li>
                </ul>
                <a href="#" data-toggle="modal" data-target="#modal-add-loan" class="btn btn-primary btn-block"><b>Nuevo
                        Préstamo</b></a>
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
                                <div class="info-box bg-aqua">
                                    <a class="" href="<?=_App_.'cobros/prestamos/'.$loan->prt_id?>"
                                        style="color:white !important;">
                                        <span class="info-box-icon"><i class="fa fa-credit-card"></i></span>
                                    </a>
                                    <div class="info-box-content">
                                        <span class="info-box-text"><?=$date?> | Presiona el
                                            ícono para ver más información del crédito</span>
                                        <span class="info-box-number">₡ <span class="masked"><?=$loan->prt_monto?>
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
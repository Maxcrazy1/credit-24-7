<?php $name = ucfirst($this->session->log_name); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?=date('d-m-y h:i A');?>
            <small>Usuario: <?=$name?></small>
        </h1>
        <div class="breadcrumb pull-right">
            <a data-toggle="modal" data-target="#modal-add-client" class="btn btn-sm bg-light-blue" href=""><i class="fa fa-plus"></i>&nbsp;  Agregar Nuevo Préstamo</a>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
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
                                      <th></th>
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
                                            <a class="pull-right" href="<?=_App_.'prestamos/'.$payment->prt_id?>" target="_blank">Detalle</a>
                                        </td>
                                        <td><?=$payment->cli_nombre?></td>
                                        <td><?=$date?></td>
                                        <td class="<?=$payment->abn_status?>">₡ <span class="masked"><?=$payment->abn_monto?></span></td>
                                        <td><a data-toggle="tooltip" data-title="Reembolso" href="<?=_App_.'abonos/confirmarBorrar/'.$payment->abn_id  ?>"><i class="fa fa-undo"></i></a></td>
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
    </section><!-- content -->
</div><!-- wrapper -->
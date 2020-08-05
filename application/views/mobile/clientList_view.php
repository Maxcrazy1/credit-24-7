<?php $name = ucfirst($this->session->log_name); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php if ($regionList): ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?=date('d-m-y h:i A');?>
            <small>Usuario: <?=$name?></small>
        </h1>
        <div class="breadcrumb pull-right">
            <a data-toggle="modal" data-target="#modal-add-client" class="btn btn-sm bg-light-blue" href=""><i
                    class="fa fa-plus"></i>&nbsp; Agregar Nuevo Cliente</a>
        </div>
    </section>
    <!-- Main content -->
    <section class="content pt-50">
        <?php foreach ($regionList as $region): ?>
        <?php if (($region->clientList) or ($region->clientListwithoutloan)): ?>
        <div class="box box-primary">
            <div class="box-header with-border bg-gray">
                <i class="fa fa-map"></i>
                <?php switch ($region->prt_tipo) {
                      case 'D': $region->prt_tipo = 'Diario'; break;
                      case 'S': $region->prt_tipo = 'Semanal'; break;
                      case 'Q': $region->prt_tipo = 'Quincenal'; break;
                    }?>
                <h3 class="box-title"><?=$region->reg_nombre?>: <?=$region->prt_tipo?></h3>
                <!-- tools box -->

                <div class="pull-right box-tools">
                    <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div><!-- /. tools -->
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#withloan<?=$region->reg_id?>" data-toggle="tab">Con Prestamos</a></li>
                    <li><a href="#withoutloan<?=$region->reg_id?>" data-toggle="tab">Sin Préstamos</a></li>
                </ul>
            </div>
            <div class="tab-content">
                
                
                <div class="tab-pane active" id="withloan<?=$region->reg_id?>">
                    <table id="dataTable<?=$region->reg_id?>" class="table table-bordered table-hover data-table">
                        <thead>
                            <tr>
                                <th>Nombre del Cliente</th>
                                <th>Cédula</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($region->clientList): ?>
                            <?php foreach ($region->clientList as $clientDetail): ?>
                            <tr class="<?=$clientDetail->status?> text-white">
                                <th class="align-middle">
                                    <a href="<?=_App_.'cobros/clientes/'.$clientDetail->cli_id?>" class="">
                                        <h4><?=$clientDetail->cli_nombre?></h4>
                                    </a>
                                </th>
                                <th class="align-middle">
                                    <a href="<?=_App_.'cobros/clientes/'.$clientDetail->cli_id?>">
                                        <h4 class="list-group-item-heading"><?=$clientDetail->cli_cedula?></h4>
                                    </a>
                                </th>
                                <th class="align-middle">
                                    <a href="<?=_App_.'cobros/clientes/'.$clientDetail->cli_id?>">
                                        <h4 class="list-group-item-heading"><?=$clientDetail->cli_telefono?></h4>
                                    </a>
                                </th>
                            </tr>
                            <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>

                </div>
                <div class="tab-pane" id="withoutloan<?=$region->reg_id?>">
                    <table id="dataTable2<?=$region->reg_id?>" class="table table-bordered table-hover data-table">
                        <thead>
                            <tr>
                                <th>Nombre del Cliente</th>
                                <th>Cédula</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($region->clientListwithoutloan): ?>
                            <?php foreach ($region->clientListwithoutloan as $clientDetail): ?>
                            <tr>
                                <th class="align-middle">
                                    <a href="<?=_App_.'cobros/clientes/'.$clientDetail->cli_id?>" class="">
                                        <h4><?=$clientDetail->cli_nombre?></h4>
                                    </a>
                                </th>
                                <th class="align-middle">
                                    <a href="<?=_App_.'cobros/clientes/'.$clientDetail->cli_id?>">
                                        <h4 class="list-group-item-heading"><?=$clientDetail->cli_cedula?></h4>
                                    </a>
                                </th>
                                <th class="align-middle">
                                    <a href="<?=_App_.'cobros/clientes/'.$clientDetail->cli_id?>">
                                        <h4 class="list-group-item-heading"><?=$clientDetail->cli_telefono?></h4>
                                    </a>
                                </th>
                            </tr>
                            <?php endforeach ?>
                            <?php endif ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.box -->
        <?php endif ?>
        <?php endforeach ?>
    </section><!-- /.content -->
    <?php else: ?>

    <section class="content">
        <div class="box">
            <div class="box-header with-border text-center">
                <h3 class="box-title">No tiene asignaciones para hoy.</h3>
                <hr>
                <h5><?=date('d-m-Y | h:i A');?></h5>
            </div><!-- /.box -->
    </section><!-- /.content -->
    <?php endif ?>
</div><!-- /.content-wrapper -->
<div class="modal fade" id="modal-add-client">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar nuevo cliente</h4>
            </div>
            <form class="form-horizontal" action="<?=_App_?>clientes/agregar" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre completo"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputCedula" class="col-sm-2 control-label">Cédula</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="cedula" placeholder="Cédula" maxlength="16"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPhone" class="col-sm-2 control-label">Teléfono</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="telefono" placeholder="Teléfono" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputMonto" class="col-sm-2 control-label">Región</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="region" style="width: 100%;" required>
                                <?php foreach ($regionList as $region) : ?>
                                <option value="<?=$region->reg_id?>"><?=$region->reg_nombre?></option>
                                <?php  endforeach; ?>
                            </select>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="inputMonto" class="col-sm-2 control-label">2da Región</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="region2" style="width: 100%;" required>
                                <option>Selecciona una Región</option>
                                <?php foreach ($regionList as $region) : ?>
                                <option value="<?=$region->reg_id?>"><?=$region->reg_nombre?></option>
                                <?php  endforeach; ?>
                            </select>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="inputMonto" class="col-sm-2 control-label">3ra Región</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="region3" style="width: 100%;" required>
                                <option>Selecciona una Región</option>
                                <?php foreach ($regionList as $region) : ?>
                                <option value="<?=$region->reg_id?>"><?=$region->reg_nombre?></option>
                                <?php  endforeach; ?>
                            </select>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="inputDireccion" class="col-sm-2 control-label">Dirección</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="direccion" placeholder="Direccion exacta"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccionGps" class="col-sm-2 control-label">Dirección GPS</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="direccionGps" placeholder="Dirección GPS"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDireccion" class="col-sm-2 control-label">Notas</label>
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
<!-- Select2 -->
<script src="<?=_R_?>plugins/select2/select2.full.min.js"></script>
<!-- Page script -->
<script>
$(function() {
    //Initialize Select2 Elements
    $(".select2").select2();
});

$(function() {
    $('.data-table').DataTable({
        "ordering": false,
        "searching": true,
        "paging": false,
        "language": {
            "emptyTable": "No Hay Resultados"
        }
    });
});

$(".data-table").on('click-row.bs.table', function(e, row, $element) {
    window.location = $element.data('href');
});
</script>
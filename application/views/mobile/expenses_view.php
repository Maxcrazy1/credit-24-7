<?php $name = ucfirst($this->session->log_name); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?=date('d-m-y h:i A');?>
            <small>Usuario: <?=$name?></small>
        </h1>
        <div class="breadcrumb pull-right">
            <a data-toggle="modal" data-target="#modal-add-expense" class="btn btn-sm bg-light-blue" href=""><i class="fa fa-plus"></i>&nbsp;  Agregar Nuevo Gasto</a>
        </div>
    </section>
    <!-- Main content -->
    <section class="content pt-50">
        <div class="box box-primary">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#recent-activity" data-toggle="tab">Gastos del día</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="recent-activity">
                        <div class="table-responsive no-padding">
                            <?php if ($expenseList): ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th># Gasto</th>
                                      <th>Descripción</th>
                                      <th>Región</th>
                                      <th>Monto del gasto</th>
                                      <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($expenseList as $expense): ?>
                                    <tr>
                                        <td>
                                            <span><i class="fa fa-barcode"></i> <?=$expense->gas_id?></span>
                                        </td>
                                        <td><?=$expense->gas_descripcion?></td>
                                        <td><?=$expense->reg_nombre?></td>
                                        <td>₡ <span class="masked"><?=$expense->gas_monto?></span></td>
                                        <td><a data-toggle="tooltip" data-title="Cancelar" href="<?=_App_.'cobros/gastos/confirmarBorrar/'.$expense->gas_id  ?>"><i class="fa fa-undo"></i></a></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                                <?php else: ?>
                                <p class="lead text-center">No hay gastos registrados.</p>
                                <?php endif ?>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <div class="text-muted">Mostrando las 10 entradas más recientes.</div>
                        </div>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div>
    </section><!-- content -->
</div><!-- wrapper -->

<!-- Modal Nuevo Gasto -->
<div class="modal fade" id="modal-add-expense">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registrar un nuevo gasto</h4>
            </div>
            <form class="form-horizontal" action="<?=_App_?>cobros/gastos/agregar" method="get">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputMonto" class="col-sm-2 control-label">Monto</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon">₡</span>
                                <input type="text" name="monto" class="form-control masked" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="region" class="col-sm-2 control-label">Region</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" style="width: 100%;" id="region" name="region" required>
                                <?php foreach ($regionList as $region) : ?>
                                <option value="<?=$region->reg_id?>"><?=$region->reg_nombre?></option>
                                <?php  endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDireccion" class="col-sm-2 control-label">Notas</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="descripcion" placeholder="Descripción del Gasto"></textarea>
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
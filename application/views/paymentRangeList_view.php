      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Préstamos <small>Módulo de control</small></h1>
          <div class="breadcrumb pull-right">
            <a  class="btn btn- bg-green" data-toggle="modal" data-target="#modal-range-payment-date"><i class="fa fa-book"></i>&nbsp; Consultar abonos por fechas</a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header with-border">
                  <?php if ($intervalo == 'todo'): ?>
                    <h3 class="box-title">Reporte completo de abonos</h3>
                  <?php else: ?>
                    <h3 class="box-title">Reporte de abonos del <strong><?=$fecha_1?></strong> al <strong><?=$fecha_2?></strong></h3>
                  <?php endif ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <?php if ($paymentList): ?>
                  <table id="dataTable1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th># Préstamo</th>
                        <th>Fecha del abono</th>
                        <th>Nombre del Cliente</th>
                        <th>Cobrador</th>
                        <th>Monto</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($paymentList as $payment) : ?>
                    <?php
                      #===============================================================================
                      $timestamp = human_to_unix($payment->abn_fecha); # Covertir la fecha a timestamp
                      $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                      #===============================================================================
                     ?>
                      <tr>
                        <td>
                        <span><i class="fa fa-barcode"></i> <?=$payment->prt_id?></span>
                        <a class="pull-right" href="<?=_App_.'prestamos/'.$payment->prt_id?>">Detalle</a>
                        </td>
                        <td><?=$date?></td>
                        <td><a href="<?=_App_?>clientes/<?=$payment->cli_id?>"><?=$payment->cli_nombre?></a></td>
                        <td><a href="<?=_App_?>colaboradores/<?=$payment->clb_id?>"><?=$payment->clb_nombre?></a></td>
                        <td>₡ <span class="masked"><?=$payment->abn_monto?></span></td>
                        </td>
                      </tr>
                    <?php endforeach;?>
                    </tbody>
      
                  </table>
				  <h3><b>Total de Monto de Abonos:</b></h3><h3 class="description-header"> ₡ <span class="masked"><?=$sumaAbono[0]->abn_monto ?></span></h3>
                  <?php else: ?>
                  <h3>No hay abonos en el rango de fechas seleccionadas.</h3>
                  <?php endif ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

         <div class="modal fade" id="modal-range-payment-date">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Consultar abonos por rango de fechas</h4>
              </div>
              <form class="form-horizontal" action="<?=_App_?>abonos/reportes/rango" method="POST">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Fecha inicial</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="fecha_Inicial" value="<?php echo date("Y-m-01");?>" step="1" min="2016-01-01" max="<?php echo date("Y-m-d");?>" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">Fecha final</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="fecha_Final" value="<?php echo date("Y-m-d");?>" step="1" min="2016-01-01" max="<?php echo date("Y-m-d");?>">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                  <a class="btn btn-success" href="<?=_App_?>abonos/reportes">Consultar Todo</a>
                  <button type="submit" class="btn btn-primary">Consultar Rango</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    <!-- Select2 -->
    <script src="<?=_R_?>plugins/select2/select2.full.min.js"></script>

    <!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
      });
    </script>
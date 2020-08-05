      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Préstamos <small>Módulo de control</small></h1>
          <div class="breadcrumb pull-right">
            <a  class="btn btn- bg-yellow" data-toggle="modal" data-target="#modal-range-loan-date"><i class="fa fa-calendar"></i>&nbsp; Consultar préstamos por fechas</a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Reporte de préstamos del <strong><?=$fecha_1?></strong> al <strong><?=$fecha_2?></strong></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <?php if ($loanList != null): ?>
                  <table id="dataTable1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th># Préstamo</th>
                        <th>Fecha del Préstamo</th>
                        <th>Nombre del Cliente</th>
                        <th>Monto del Préstamo</th>
                        <th>Tipo de pago</th>
                        <th class="hidden-xs">Progreso</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($loanList as $loan) : ?>
                    <?php switch ($loan->prt_tipo) {
                      case 'D': $loan->prt_tipo = "Diario"; break;
                      case 'S': $loan->prt_tipo = "Semanal"; break;
                      case 'Q': $loan->prt_tipo = "Quincenal"; break;
                    }?>
                    <?php
                      #===============================================================================
                      $timestamp = human_to_unix($loan->prt_fecha); # Covertir la fecha a timestamp
                      $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                      #===============================================================================
                      $payed = $loan->prt_total - $loan->prt_saldo; # Calcular el monto total pagado
                      $progress = ($payed * 100) / $loan->prt_total; # Calcular el porcentaje pagado
                      #===============================================================================
                     ?>
                      <tr>
                        <td>
                        <span><i class="fa fa-barcode"></i> <?=$loan->prt_id?></span>
                        <a class="pull-right" href="<?=_App_.'prestamos/'.$loan->prt_id?>">Detalle</a>
                        </td>
                        <td><?=$date?></td>
                        <td><a href="<?=_App_?>clientes/<?=$loan->cli_id?>"><?=$loan->cli_nombre?></a></td>
                        <td>₡ <span class="masked"><?=$loan->prt_monto?></span></td>
                        <td><?=$loan->prt_tipo?></td>
                        <td class="hidden-xs" data-toggle="tooltip" title="Pendiente: ₡<?=$loan->prt_saldo?>">
							<div class="progress progress-xs">

                          <div class="progress-bar progress-bar-success" style="width: <?=$progress?>%"></div>
                        </div>
                        </td>
                      </tr>
                    <?php endforeach;?>
                    </tbody>
      
                  </table>
				  <h3><b>Total de Monto de Prestamos:</b></h3><h3 class="description-header"> ₡ <span class="masked"><?=$sumaReport[0]->prt_monto ?></span></h3>
                  <?php else: ?>
                  <h3>No hay préstamos activos para el rango de fechas seleccionadas.</h3>
                  <?php endif ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

        <div class="modal fade" id="modal-range-loan-date">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Consultar por rango de fechas</h4>
              </div>
              <form class="form-horizontal" action="<?=_App_?>prestamos/reportes" method="POST">
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
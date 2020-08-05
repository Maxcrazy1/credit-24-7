      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Préstamos del Día<small>Módulo de control</small></h1>
          <div class="breadcrumb pull-right">
            <a  data-toggle="modal" data-target="#modal-add-loan" class="btn btn- bg-light-blue" href=""><i class="fa fa-plus"></i>&nbsp; Agregar Nuevo Préstamos</a>
            <a  class="btn btn- bg-green" data-toggle="modal" data-target="#modal-range-payment-date"><i class="fa fa-book"></i>&nbsp; Consultar abonos por fechas</a>
            <a  class="btn btn- bg-yellow" data-toggle="modal" data-target="#modal-range-loan-date"><i class="fa fa-calendar"></i>&nbsp; Consultar préstamos por fechas</a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Reporte de préstamos activos</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php if ($loanList): ?>
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
                      if($loan->prt_total != 0) {
                        $progress = ($payed * 100) / $loan->prt_total; # Calcular el porcentaje pagado
                      } 
                      else {
                        $progress = ($payed * 100) / 1; # Calcular el porcentaje pagado
                      }
					  $datediff = time() - $timestamp; # Calcula la diferencia de tiempo 
                      $datediff = floor($datediff/(60*60*24)); # Convertir la diferencia a dias
                      #===============================================================================
                     ?>
					 <?php if ($datediff <= 0) {?>
                      <tr>
                        <td>
                        <span><i class="fa fa-barcode"></i> <?=$loan->prt_id?></span>
                        <a class="pull-right" target="_blank" href="<?=_App_.'prestamos/'.$loan->prt_id?>">Detalle</a>
                        </td>
                        <td><?=$date?></td>
                        <td><a href="<?=_App_?>clientes/<?=$loan->cli_id?>" target="_blank"><?=$loan->cli_nombre?></a></td>
                        <td>₡ <span class="masked"><?=$loan->prt_monto?></span></td>
                        <td><?=$loan->prt_tipo?></td>
                        <td class="hidden-xs" data-toggle="tooltip" title="Pendiente: ₡<?=$loan->prt_saldo?>">
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-success" style="width: <?=$progress?>%"></div>
                        </div>
                        </td>
                      </tr>
					  <?php }?>
                    <?php endforeach;?>
                    </tbody>
                  </table>
                <?php else: ?>
                  <p class="lead text-center">No hay prestamos activos.</p>
                <?php endif ?>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

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
                      <select class="form-control select2" name="cliente" style="width: 100%;" required>
                        <?php foreach ($clientList as $client) : ?>
                        <option value="<?=$client->cli_id?>"><?=$client->cli_nombre?></option>
                        <?php  endforeach; ?>
                      </select>
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
        </div><!-- /.modal -->

        <div class="modal fade" id="modal-add-client">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar nuevo cliente</h4>
              </div>
              <form class="form-horizontal" action="<?=_App_?>clientes/agregar" method="POST">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="nombre" placeholder="Nombre completo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPhone" class="col-sm-2 control-label">Teléfono</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="telefono" placeholder="Teléfono" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="region" class="col-sm-2 control-label">Región</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" style="width: 100%;" name="region" required>
                        <?php foreach ($regionList as $region) : ?>
                        <option value="<?=$region->reg_id?>"><?=$region->reg_nombre?></option>
                        <?php  endforeach; ?>
                      </select>
                    </div>
                  </div><!-- /.form-group -->
                  <div class="form-group">
                    <label for="inputDireccion" class="col-sm-2 control-label">Dirección</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="direccion" placeholder="Direccion exacta" required></textarea>
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

    <script>
    function mostrar(dato){
      
        if(dato=="S"){
          $('#RadioDia').removeClass('hidden');
        } else {
          $('#RadioDia').addClass('hidden');
        }
        /*if(dato=="S"){
            document.getElementById("RadioDia").style.display = "block";
        }
        if(dato!="S"){
            document.getElementById("RadioDia").style.display = "none";
        }*/
    }
    </script>

    <!-- Page script -->
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
      });
    </script>
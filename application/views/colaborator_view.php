      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Perfil del colaborador</h1>
          <div class="breadcrumb pull-right">
            <a data-toggle="modal" data-target="#modal-remove-colaborator" class="btn btn-sm bg-red" href=""><i class="fa fa-trash"></i>&nbsp; Eliminar Colaborador</a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">
              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <h3 class="profile-username text-center"><?=$colaboratorInfo->clb_nombre?></h3>
                  <p class="text-muted text-center">#<?=$colaboratorInfo->clb_telefono?></p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Estado</b> <span class="pull-right"><?=($colaboratorInfo->clb_estado)? 'Activo' : 'Inactivo';?></span>
                    </li>
                    <li class="list-group-item">
                      <b>Recaudado hoy</b> <span class="pull-right">₡ <span class="masked"><?=$revenueColab?></span></span>
                    </li>
                    <li class="list-group-item">
                      <b>Disponible</b> <span class="pull-right">₡ <span class="masked"><?=$colaboratorInfo->clb_disponible?></span></span>
                    </li>
                  </ul>
                  <?php if ($colaboratorInfo->clb_estado): ?>
                    <a href="<?=_App_."colaboradores/alternar/$colaboratorInfo->clb_id"?>/0" class="btn btn-danger btn-block"><b>Desactivar</b></a>
                  <?php else: ?>
                    <a href="<?=_App_."colaboradores/alternar/$colaboratorInfo->clb_id"?>/1" class="btn btn-success btn-block"><b>Activar</b></a>
                  <?php endif ?>

                  <?php if ($colaboratorInfo->clb_role == 'C'): ?>
                    <a href="<?=_App_."usuarios/restaurar/$colaboratorInfo->clb_id"?>" class="btn btn-warning btn-block"><b>Restaurar Clave</b></a>
                    <a data-toggle="modal" data-target="#modal-edit-available" href="" class="btn btn-info btn-block"><b>Cambiar Disponible</b></a>
                  <?php endif ?>

                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Datos Personales</h3>
                  <a href="" data-toggle="modal" data-target="#modal-edit-colaborator" class="pull-right">editar</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-phone margin-r-5"></i> Teléfono de Contacto</strong>
                  <p class="text-muted"><?=$colaboratorInfo->clb_telefono ?></p>
                  <hr>
                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Comentarios</strong>
                  <p><?=$colaboratorInfo->clb_notas ?></p>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#recent-activity" data-toggle="tab">Cobros del día</a></li>
                    <li><a href="#timeline" data-toggle="tab">Préstamos del día</a></li>
                    <li><a href="#clients" data-toggle="tab">Clientes</a></li>
                    <li><a href="#expenses" data-toggle="tab">Gastos</a></li>
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
                    <div class="tab-pane" id="clients">
                      
                      <?php if ($regionList): ?>
                          <!-- Main content -->
                          <section class="content">
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
                                                            <a href="<?=_App_.'clientes/'.$clientDetail->cli_id?>" class="">
                                                                <h4><?=$clientDetail->cli_nombre?></h4>
                                                            </a>
                                                        </th>
                                                        <th class="align-middle">
                                                            <a href="<?=_App_.'clientes/'.$clientDetail->cli_id?>">
                                                                <h4 class="list-group-item-heading"><?=$clientDetail->cli_cedula?></h4>
                                                            </a>
                                                        </th>
                                                        <th class="align-middle">
                                                            <a href="<?=_App_.'clientes/'.$clientDetail->cli_id?>">
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
                                                <?php if ($region->clientList): ?>
                                                    <?php foreach ($region->clientListwithoutloan as $clientDetail): ?>
                                                        <tr>
                                                            <th class="align-middle">
                                                                <a href="<?=_App_.'clientes/'.$clientDetail->cli_id?>" class="">
                                                                    <h4><?=$clientDetail->cli_nombre?></h4>
                                                                </a>
                                                            </th>
                                                            <th class="align-middle">
                                                                <a href="<?=_App_.'clientes/'.$clientDetail->cli_id?>">
                                                                    <h4 class="list-group-item-heading"><?=$clientDetail->cli_cedula?></h4>
                                                                </a>
                                                            </th>
                                                            <th class="align-middle">
                                                                <a href="<?=_App_.'clientes/'.$clientDetail->cli_id?>">
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
                      
                    </div>
                    <!-- Pestaña Gastos -->
                    <div class="tab-pane" id="expenses">
                        <div class="table-responsive no-padding">
                            <?php if ($expenseList): ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th># Gasto</th>
                                      <th>Descripción</th>
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
                                        <td>₡ <span class="masked"><?=$expense->gas_monto?></span></td>
                                        <td><a data-toggle="tooltip" data-title="Cancelar" href="<?=_App_.'colaboradores/gastos/confirmarBorrar/'.$expense->gas_id.'/'.$colaboratorInfo->clb_id  ?>"><i class="fa fa-undo"></i></a></td>
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
          <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?=$loanTotal?></h3>
                        <p>Créditos Nuevos</p>
                    </div>
                    <a href="<?=_App_?>prestamos/hoy">
                        <div class="icon">
                            <i class="ion ion-card"></i>
                        </div>
                    </a>
                    <a href="" class="small-box-footer"> <i class="fa fa-info-circle"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?=$expensesTotal?></h3>
                        <p>Gastos</p>
                    </div>
                    <a href="<?=_App_?>cobros/gastos">
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                    </a>
                    <a href="" class="small-box-footer"> <i class="fa fa-info-circle"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?=$raisedTotal?></h3>
                        <p>Recaudado</p>
                    </div>
                    <a href="#">
                        <div class="icon">
                        </div>
                    </a>
                    <a href="" class="small-box-footer"> <i class="fa fa-info-circle"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?=$availableTotal?></h3>
                        <p>Disponible</p>
                    </div>
                    <a href="#">
                        <div class="icon">
                        </div>
                    </a>
                    <a href="" class="small-box-footer"> <i class="fa fa-check-circle"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-gray">
                    <div class="inner">
                        <h3><?=$total?></h3>
                        <p>Total Restante</p>
                    </div>
                    <a href="#">
                        <div class="icon">
                        </div>
                    </a>
                    <a href="" class="small-box-footer"> <i class="fa fa-info-circle"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        </div><!-- /.col -->
      </div><!-- /.row -->

    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

  <div class="modal fade" id="modal-edit-colaborator">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Editar datos del colaborador</h4>
        </div>
        <form class="form-horizontal" action="<?=_App_?>colaboradores/actualizar" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="inputName" class="col-sm-2 control-label">Nombre</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="nombre" value="<?=$colaboratorInfo->clb_nombre?>" placeholder="Nombre completo">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPhone" class="col-sm-2 control-label">Teléfono</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" name="telefono" value="<?=$colaboratorInfo->clb_telefono?>" placeholder="Teléfono">
              </div>
            </div>
            <div class="form-group">
              <label for="inputDireccion" class="col-sm-2 control-label">Notas</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="notas" placeholder="Notas"><?=$colaboratorInfo->clb_notas?></textarea>
              </div>
            </div>
            <input type="hidden" name="colaboratorID" value="<?=$colaboratorInfo->clb_id?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal modal-danger fade" id="modal-remove-colaborator">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Eliminar Colaborador</h3>
        </div>
        <form class="form-horizontal" action="<?=_App_?>colaboradores/borrar" method="POST">
          <div class="modal-body">
            <h3 class="text-block text-center">¿Esta seguro desea eliminar este colaborador y todos sus datos asociados?</h3>
            <h4 class="text-block text-center">Esta opción es irreversible</h4>
            <input type="hidden" name="colaborador" value="<?=$colaboratorInfo->clb_id?>">
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
  
  <!-- modal modificar disponible -->
  <div class="modal fade" id="modal-edit-available">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Editar el disponible del colaborador</h4>
        </div>
        <form class="form-horizontal" action="<?=_App_?>colaboradores/actualizar-disponible" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="inputName" class="col-sm-2 control-label">Disponible</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="disponible" value="<?=$colaboratorInfo->clb_disponible?>" placeholder="Nombre completo">
              </div>
            </div>
            <input type="hidden" name="colaboratorID" value="<?=$colaboratorInfo->clb_id?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
  <script>
      $(function () {
        $('.data-table').DataTable({
          "ordering": false,
          "searching": true,
          "paging": false,
          "language": {
              "emptyTable": "No Hay Resultados"
            }
        });
      });
      
      $(".data-table").on('click-row.bs.table', function (e, row, $element) {
        window.location = $element.data('href');
      });
    </script>
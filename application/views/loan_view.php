      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Detalle de Préstamo <small>Código #<?=$loanInfo->prt_id?></small></h1>
          <div class="breadcrumb pull-right">
            <a data-toggle="modal" data-target="#modal-remove-loan" class="btn btn-sm bg-red" href=""><i class="fa fa-trash"></i>&nbsp; Eliminar Préstamo</a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <?php
          #===============================================================================
          $timestamp = human_to_unix($loanInfo->prt_fecha); # Covertir la fecha a timestamp
          $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
          #===============================================================================
          ?>
          <div class="row">
            <div class="col-md-4">
              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                <form action="<?=_App_?>prestamos/actualizar-monto" method="POST">
                  <?php if ($loanInfo->prt_saldo > 0): ?>
                    <h1 class="profile-username text-center"> ₡ <span class="masked"><?=$loanInfo->prt_saldo?></span></h1>
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
                        endswitch;?>
						<select name="tipo" class="btn btn-primary">
							<option name="tipo" value="<?=$loanInfo->prt_tipo?>">Cambiar A</option>
							<option name="tipo" value="D">Diario</option>
							<option name="tipo" value="S">Semanal</option>
							<option name="tipo" value="Q">Quincenal</option>
					    </select>
                      </span>
                    </li>
                    
                      <li class="list-group-item">
                        <b>Día de abono</b>
                        <span class="pull-right">
                          <?php switch ($loanInfo->prt_dia):
                          case 'L': echo $loanInfo->prt_dia = "Lunes"; break;
                          case 'K': echo $loanInfo->prt_dia = "Martes"; break;
                          case 'M': echo $loanInfo->prt_dia = "Miércoles"; break;
                          case 'J': echo $loanInfo->prt_dia = "Jueves"; break;
                          case 'V': echo $loanInfo->prt_dia = "Viernes"; break;
                          case 'S': echo $loanInfo->prt_dia = "Sábado"; break;
                          case 'D': echo $loanInfo->prt_dia = "Domingo"; break;
                          endswitch; ?>
						  <select name="dia" class="btn btn-primary">
						    <option name="dia" value="<?=$loanInfo->prt_dia?>">Cambiar A</option>
							<option name="dia" value="L" >Lunes</option>
							<option name="dia" value="K" >Martes</option>
							<option name="dia" value="M" >Miércoles</option>
							<option name="dia" value="J" >Jueves</option>
							<option name="dia" value="V" >Viernes</option>
							<option name="dia" value="S" >Sábado</option>
							<option name="dia" value="D" >Domingo</option>
					    </select>
                        </span>
                      </li>
                    <li class="list-group-item">
                      <b>Monto del préstamo</b>
					  <div class="input-group">
                      <span class="input-group-addon">₡</span>
                        <input type="text" name="monto" value="<?=$loanInfo->prt_monto?>" class="form-control masked"><br>
					  </div>
                    </li>
                    <li class="list-group-item">
                      <b>Tasa de préstamo</b>
					  <div class="input-group">
                      <span class="input-group-addon">%</span>
                        <input type="text" name="interes" value="<?=$loanInfo->prt_rate_interes?>" class="form-control masked"><br>
					  </div>
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
					<input type="hidden" name="prestamoID" value="<?=$loanInfo->prt_id?>">
                  </ul>
				  <button type="submit" class="btn btn-primary btn-block"><b>Guardar</b></button><br>
				  </form>
                  <?php if ($loanInfo->prt_estado): ?>
                    <a href="#" data-toggle="modal" data-target="#modal-add-payment" class="btn btn-primary btn-block"><b>Registrar Pago</b></a>  
                  <?php endif ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Datos Adicionales</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-user margin-r-5"></i>Nombre Cliente</strong>
                  <a class="pull-right" target="_blank" href="<?=_App_.'clientes/'.$clientInfo->cli_id?>"><?=$clientInfo->cli_nombre?></a>
                  <hr>
                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Cédula</strong>
                  <a class="pull-right" target="_blank" href="<?=_App_.'clientes/'.$clientInfo->cli_id?>"><?=$clientInfo->cli_cedula?></a>
				  <hr>
                  <strong><i class="fa fa-edit margin-r-5"></i>Registrado por</strong>
                  <a class="pull-right" target="_blank" href="<?=_App_.'colaboradores/'.$loanInfo->prt_autor?>"><?=$loanInfo->clb_nombre?></a>
                  <hr>
                  <strong><i class="fa fa-calendar margin-r-5"></i>Fecha de Registro</strong>
                  <span class="pull-right text-muted"><?=$date?></span>
                  <hr>
                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Comentarios</strong>
                  <p><?=$loanInfo->prt_notas?></p>
                  <?php if ($this->session->log_role == 'M'): ?>
                    <a href="#" data-toggle="modal" data-target="#modal-edit-loan" class="btn btn-primary btn-block"><b>Modificar Préstamo</b></a>
                  <?php endif ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="col-md-8">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Historial de pagos</h3>
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
                        <td class="<?=$payment->abn_status?>">₡ <span class="masked"><?=$payment->abn_monto?></span></td>
                        <td><?=$payment->clb_nombre?></td>
                        <td><?=$payment->abn_nota?></td>
                        <td>
                            <?php if ($this->session->log_role == 'M'): ?>
                                <a href="#" id="edit-payment-<?=$payment->abn_id?>" class="edit-payment" data-id="<?=$payment->abn_id?>" data-monto="<?=$payment->abn_monto?>" data-autor="<?=$payment->abn_autor?>" data-nota="<?=$payment->abn_nota?>" data-fecha="<?=$payment->abn_fecha?>" data-contable="<?=$payment->abn_contable?>" data-status="<?=$payment->abn_status?>"><i class="fa fa-edit"></i> </a>
                            <?php endif ?>
                            <a href="<?=_App_.'abonos/confirmarBorrar/'.$payment->abn_id  ?>"><i class="fa fa-undo"></i></a>
                        </td>
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

<div class="modal fade" id="modal-add-payment">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Registrar un pago</h4>
      </div>
      <form class="form-horizontal" action="<?=_App_?>prestamos/pagar" method="GET">
        <div class="modal-body">
          <div class="form-group">
            <label for="inputMonto" class="col-sm-2 control-label">Monto</label>
            <div class="col-sm-4">
              <div class="input-group">
                <span class="input-group-addon">₡</span>
                <input type="text" name="monto" class="form-control masked" value="<?=$loanInfo->prt_cuota?>" required>
              </div>
            </div>
            <!-- Date mm/dd/yyyy -->
            <?php $date = date('d-m-Y', time()); ?>
            <label for="fecha" class="col-sm-2 control-label">Fecha</label>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                <?php if ($this->session->log_role == 'M'): ?>
                    <input type="datetime" class="form-control" id="fechahora" name="fechahora" value="<?php echo date("Y-m-d");?>T12:00Z" step="1" min="2016-01-01T00:00Z" max="<?php echo date("Y-m-d");?>T12:00Z" >
                <?php else: ?>
                    <input type="text" name="fecha" class="form-control" value="<?=$date?>" disabled>
                <?php endif ?>
              </div><!-- /.input group -->
            </div>
          </div>
          <?php if ($this->session->log_role == 'M'): ?>
          <div class="form-group">
                <label for="selectcolaborador" class="col-sm-2 control-label">Colaborador</label>
                <div class="col-sm-10">
                    <select id="selectColaborador" name="colaborador" class="selectColaborador form-control" style="width: 100%">
                        <option value="-1"></option>
                        <?php foreach ($colaboratorList as $colaborator): ?>
                            <?php if ($colaborator->clb_id == $this->session->log_user): ?>
                                <option value="<?=$colaborator->clb_id?>" selected><?=$colaborator->clb_nombre?></option>
                             <?php else: ?>
                                <option value="<?=$colaborator->clb_id?>"><?=$colaborator->clb_nombre?></option>
                             <?php endif ?>
                        <?php endforeach ?>
                        <?php foreach ($userList as $user): ?>
                            <?php if ($user->clb_id == $this->session->log_user): ?>
                                <option value="<?=$user->usr_id?>" selected><?=$user->usr_name?></option>
                             <?php else: ?>
                                <option value="<?=$user->usr_id?>"><?=$user->usr_name?></option>
                             <?php endif ?>
                        <?php endforeach ?>
                    </select>
                </div>
          </div>
          <?php endif ?>
          <div class="form-group">
            <label for="inputDireccion" class="col-sm-2 control-label">Notas</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="4" name="notas" placeholder="Notas"></textarea>
            </div>
          </div>

          <input type="hidden" name="cobrador" value="0">
          <input type="hidden" name="rdr" value="">
          <input type="hidden" name="saldo" value="<?=$loanInfo->prt_saldo?>">
          <input type="hidden" name="prestamo" value="<?=$loanInfo->prt_id?>">
          <input type="hidden" name="cliente" value="<?=$loanInfo->prt_cliente?>">
          <input type="hidden" name="contable" value="0">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-update-payment">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Actualizar un pago</h4>
      </div>
      <form id="update-form" class="form-horizontal" action="" method="POST">
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-6">
                        <label for="inputMonto" class="control-label">Monto</label>
                        <div class="input-group">
                            <span class="input-group-addon">₡</span>
                            <input type="text" id="monto" name="monto" class="form-control masked" value="<?=$loanInfo->prt_cuota?>" required>
                        </div>
                    </div>
                    <!-- Date mm/dd/yyyy -->
                    <?php $date = date('d-m-Y', time()); ?>
                    <div class="col-sm-6">
                        <label for="fecha" class="control-label">Fecha</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="datetime" class="form-control" id="fecha" name="fecha" value="" step="1" min="2016-01-01T00:00Z" max="<?php echo date("Y-m-d");?>T12:00Z" >
                        </div><!-- /.input group -->
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-8">
                        <label for="selectcolaborador" class="control-label">Colaborador</label>
                        <select id="selectColaborador" name="colaborador" class="selectColaborador form-control" style="width: 100%">
                            <?php foreach ($colaboratorList as $colaborator): ?>
                                <option value="<?=$colaborator->clb_id?>"><?=$colaborator->clb_nombre?></option>
                            <?php endforeach ?>
                            <?php foreach ($userList as $user): ?>
                                <option value="<?=$user->usr_id?>"><?=$user->usr_name?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="selectContable" class="control-label">Contable</label>
                        <select id="selectContable" name="contable" class="selectColaborador form-control" style="width: 100%">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <label for="nota" class="control-label">Notas</label>
                        <textarea class="form-control" rows="4" id="nota" name="nota" placeholder="Notas"></textarea>
                    </div>
                </div>
                <input type="hidden" id="cobrador" name="cobrador" value="0">
                <input type="hidden" id="rdr" name="rdr" value="">
                <input type="hidden" id="saldo" name="saldo" value="<?=$loanInfo->prt_saldo?>">
                <input type="hidden" id="prestamo" name="prestamo" value="<?=$loanInfo->prt_id?>">
                <input type="hidden" id="cliente" name="cliente" value="<?=$loanInfo->prt_cliente?>">
                <input type="hidden" id="monto_pagado" name="monto_pagado" value="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-edit-loan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Actualizar datos del préstamo</h4>
      </div>
      <form id="updateLoan-form" class="form-horizontal" action="<?=_App_?>prestamos/actualizar-info/<?=$loanInfo->prt_id?>" method="POST">
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <label for="selectCliente" class="control-label">Cliente</label>
                        <select id="selectCliente" name="cliente" class="selectColaborador form-control" style="width: 100%">
                            <?php foreach ($clientList as $client):
                                if ($clientInfo->cli_id == $client->cli_id){
                                    echo '<option value="'.$client->cli_id.'" selected>'.$client->cli_nombre.'</option>';
                                }else{
                                    echo '<option value="'.$client->cli_id.'">'.$client->cli_nombre.'</option>';
                                }
                            endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-8">
                        <label for="selectCreador" class="control-label">Registrado por</label>
                        <select id="selectCreador" name="colaborador" class="selectColaborador form-control" style="width: 100%">
                            <?php foreach ($colaboratorList as $colaborator): 
                                if ($loanInfo->prt_autor == $colaborator->clb_id){
                                    echo '<option value="'.$colaborator->clb_id.'" selected>'.$colaborator->clb_nombre.'</option>';
                                }else{
                                    echo '<option value="'.$colaborator->clb_id.'">'.$colaborator->clb_nombre.'</option>';
                                }
                                endforeach ?>
                            <?php foreach ($userList as $user):
                                if ($loanInfo->prt_autor == $user->usr_id){
                                    echo '<option value="'.$user->usr_id.'" selected>'.$user->usr_name.'</option>';
                                }else{
                                    echo '<option value="'.$user->usr_id.'">'.$user->usr_name.'</option>';
                                }
                                endforeach ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="fecha" class="control-label">Fecha de registro</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="datetime" class="form-control" id="fecha" name="fecha" value="<?=$loanInfo->prt_fecha?>" step="1" min="2016-01-01T00:00Z" max="<?php echo date("Y-m-d");?>T12:00Z" >
                        </div><!-- /.input group -->
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <label for="notas" class="control-label">Comentarios</label>
                        <textarea class="form-control" rows="4" id="notas" name="notas" placeholder="Comentarios"><?=$loanInfo->prt_notas?></textarea>
                    </div>
                </div>
                <input type="hidden" id="rdr" name="rdr" value="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal modal-danger fade" id="modal-remove-loan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Eliminar Prestamo</h3>
      </div>
      <form class="form-horizontal" action="<?=_App_?>prestamos/borrar" method="POST">
        <div class="modal-body">
        <h3 class="text-block text-center">¿Esta seguro desea eliminar este prestamo y todos sus datos asociados?</h3>
          <h4 class="text-block text-center">Esta opcion es irreversible</h4>
          <input type="hidden" name="prestamo" value="<?=$loanInfo->prt_id?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-outline">Continuar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- InputMask -->
<script src="<?=_R_?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=_R_?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=_R_?>plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <script>
        $(".edit-payment").click( function()
           {
             var Idabn = $(this).data("id");
             var monto = $(this).data("monto");
             var fecha = $(this).data("fecha");
             var nota = $(this).data("nota");
             var autor = $(this).data("autor");
             var status = $(this).data("status");
             //$("#selectColaborador option[value='"+autor+"'").attr("selected",true);
             $('#selectColaborador').val(autor);
             $('#update-form').attr("action", "<?=_App_?>abonos/actualizar/"+Idabn);
             $('#monto').val($(this).data("monto"));
             $('#fecha').val($(this).data("fecha"));
             $('#nota').val($(this).data("nota"));
             $('#monto_pagado').val($(this).data("monto"));
             $("#selectContable").val($(this).data("contable"));
             //$('#status').val($(this).data("status"));
             $("#modal-update-payment").modal("show");
           }
        );
    </script>

      <!--script>
        $(function () {
          //Datemask dd/mm/yyyy
          $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
          //Money Euro
          $("[data-mask]").inputmask();
        });
      </script-->

        <div class="modal modal-success fade" id="modal-reset-ok">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva contraseña solicitada.</h4>
              </div>
              <div class="modal-body">
              <p class="text-block text-center">En breve recibirás un correo electrónico con instrucciones sobre cómo continuar.</p>
              </div>
               <div class="modal-footer">
                  <a href="<?=$_App_?>logout" class="btn btn-outline">Salir</button>
                </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Clientes <small>Módulo de Control</small></h1>
          <div class="breadcrumb pull-right">
            <a data-toggle="modal" data-target="#modal-add-client" class="btn btn-sm bg-light-blue" href=""><i class="fa fa-plus"></i>&nbsp;  Agregar Nuevo Cliente</a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Lista clientes</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php if ($clientList): ?>
                  <table id="dataTable2" class="table table-bordered table-hover">
                    <thead>
                      <tr> 
                        <th>Nombre del Cliente</th>
						<th>Cédula</th>
                        <th>Telefono</th>
                        <th>Región</th>
                        <th>Dirección</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($clientList as $client) : ?>
                      <?php 
                      $client->reg_nombre = "Región";
                      foreach ($regionList as $region) :
                        if ($region->reg_id == $client->cli_region) :
                          $client->reg_nombre = $region->reg_nombre;
                          break;
                        endif;
                      endforeach;
                      ?>
                      <tr>
                        <td><a target="_blank" href="<?=_App_.'clientes/'.$client->cli_id?>"><?=$client->cli_nombre?></a></td>
                        <td><?=$client->cli_cedula?></td>
						<td><?=$client->cli_telefono?></td>
                        <td><?=$client->reg_nombre?></td>
                        <td><?=$client->cli_direccion?></td>
                      </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <?php else: ?>
                  <p class="lead text-center">No hay clientes registrados.</p>
                <?php endif ?>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
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
                      <input type="text" class="form-control" name="nombre" placeholder="Nombre completo" required>
                    </div>
                  </div>
				  <div class="form-group">
                    <label for="inputCedula" class="col-sm-2 control-label">Cédula</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="cedula" placeholder="Cédula" maxlength="16" required>
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
                      <textarea class="form-control" name="direccion" placeholder="Direccion exacta" required></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="direccionGps" class="col-sm-2 control-label">Dirección GPS</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="direccionGps" placeholder="Dirección GPS" required></textarea>
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
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
      });
    </script>
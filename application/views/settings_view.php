      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Configuracion <small>Modulo de control</small></h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Parámetros Generales</h3>
                </div>
                <form class="form-horizontal" action="<?=_App_?>configuracion/actualizar" method="POST">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputMonto" class="col-sm-4 control-label">Intereses</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <input type="number" name="intereses" class="form-control text-center" value="<?=$intereses?>">
                          <span class="input-group-addon">%</span>
                        </div>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button style="width:100%;" type="submit" class="btn btn-primary">Actualizar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


      <div class="modal modal-success fade" id="modal-update">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Parametros actualizados</h4>
            </div>
            <div class="modal-body">
              <p class="lead text-center">¡La operación finalizó con éxito! <strong>:)</strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline" data-dismiss="modal">Cerrar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
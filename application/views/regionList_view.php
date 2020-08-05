      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Regiones <small>Módulo de Control</small></h1>
          <div class="breadcrumb pull-right">
            <a  data-toggle="modal" data-target="#modal-add" class="btn btn-sm bg-light-blue" href=""><i class="fa fa-plus"></i>&nbsp;  Agregar Nueva Región</a>
          </div>
        </section>
        <hr>
        <!-- Main content -->
        <section class="content">
         <div class="row">
          <?php foreach ($regionList as $region) : ?>
            <div class="col-md-4">
              <div class="info-box">
              <?php if ($region->cli_count > 0): ?>
                <a href="<?=_App_.'regiones/'.$region->reg_id?>">
                  <span class="info-box-icon bg-purple"><i class="fa fa- fa-map-o"></i></span>
                </a>                
              <?php else: ?>
                <span class="info-box-icon bg-gray"><i class="fa fa- fa-map-o"></i></span>
              <?php endif ?>
                <div class="info-box-content">
                  <?php if ($region->cli_count ==0): ?>
                    <a href="<?=_App_?>regiones/borrar/<?=$region->reg_id?>" class="close"><i class="fa fa-trash"></i></a>
                  <?php endif ?>
                  <span class="info-box-number"><?=$region->reg_nombre?></span>
                  <span class="info-box-text"><b><?=$region->cli_count?></b> clientes en esta región</span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          <?php   endforeach; ?> 
        </div><!-- /.row -->



        <div class="modal fade" id="modal-add">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar nueva región</h4>
              </div>
              <form class="form-horizontal" action="<?=_App_?>regiones/agregar" method="POST">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="inputRegion" class="col-sm-2 control-label">Región</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" placeholder="Nombre" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
              </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


      </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
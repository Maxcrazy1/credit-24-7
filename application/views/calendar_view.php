<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Horarios
      <small>Módulo de Control</small>
    </h1>
    <ol class="breadcrumb">

    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-8">
        <!-- Default box -->
        <div class="nav-tabs-custom">
          <ul class="nav nav-pills">
            <li class="active"> <a href="#tab-L" data-toggle="tab">Lunes</a></li>
            <li><a href="#tab-K" data-toggle="tab">Martes</a></li>
            <li><a href="#tab-M" data-toggle="tab">Miércoles</a></li>
            <li><a href="#tab-J" data-toggle="tab">Jueves</a></li>
            <li><a href="#tab-V" data-toggle="tab">Viernes</a></li>
            <li><a href="#tab-S" data-toggle="tab">Sábado</a></li>
            <li><a href="#tab-D" data-toggle="tab">Domingo</a></li>
          </ul>
        </div><!-- /.nav-tabs-custom -->
        <div class="nav-tabs-custom">
          <div class="tab-content">
            <!-- Tab Panes Start ---------------------------------------------------------------->
            <?php $weekday =array('L','K','M','J','V','S','D',); ?>
            <?php foreach ($weekday as $day): ?>
              <div class="tab-pane <?=$day == 'L' ? 'active' : false?>" id="tab-<?=$day?>">
                <div class="box box-primary">
                  <div class="box-body">
                    <?php if ($scheduleList): ?>
                      <?php # ========================================
                      $tScheduleList = array();
                      foreach ($scheduleList as $schedule) {
                        if ($schedule->hro_dia == $day) {
                          $tScheduleList[] = $schedule;
                        }
                      }
                      $empty = count($tScheduleList) == 0 ? TRUE : FALSE;
                      # ============================================= ?>
                      <?php if ($empty): ?>
                        <p class="lead text-center">No hay asignaciones para este día (<?=$day?>).</p>  
                      <?php else: #empty is false?>
                        <div class="table-responsive no-padding">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>Nombre</th>
                                <th>Zona Asignada</th>
                                <th>Tipo</th>
                                <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($tScheduleList as $tSchedule): ?>
                                <tr>
                                  <td><?=$tSchedule->clb_nombre?></td>
                                  <td><?=$tSchedule->reg_nombre?></td>
                                  <td>
                                    <?php switch ($tSchedule->prt_tipo):
                                    case 'D': echo "Diarios"; break;
                                    case 'S': echo "Semanales"; break;
                                    case 'Q': echo "Quincenales"; break;
                                    endswitch; ?>
                                  </td>
                                  <td><a href="<?=_App_."horarios/eliminar/$tSchedule->hro_id?tab=$day"?>">Eliminar</a></td>
                                </tr>
                              <?php endforeach ?>
                            </tbody>
                          </table>
                        </div><!-- /. -->
                      <?php endif #empty?>
                    <?php else: #schedule is false?>
                      <p class="lead text-center">No hay asignaciones.</p>
                    <?php endif #schedule?>
                  </div>
                </div>
              </div><!-- /.tab-pane -->
            <?php endforeach ?>
          </div><!-- /.tab-content --> 
        </div><!-- /.nav-tabs-custom -->
      </div>

      <div class="col-md-4">
        <form class="form-vertical" action="<?=_App_?>horarios/agregar  " method="POST">
          <div class="form-group">
            <label class="control-label">Seleccione un Colaborador</label>
            <select class="form-control select2" name="colaborador" style="width: 100%;" required>
              <?php foreach ($colaboratorList as $colaborator) : ?>
                <?php if ($colaborator->clb_estado): ?>
                  <option value="<?=$colaborator->clb_id?>"><?=$colaborator->clb_nombre?></option>  
                <?php endif ?>
              <?php  endforeach; ?>
            </select> 
          </div><!-- /.form-group -->

          <div class="form-group">
            <label class="control-label">Seleccione una Región</label>
            <select class="form-control select2" name="region" style="width: 100%;" required>
              <?php foreach ($regionList as $region) : ?>
                <option value="<?=$region->reg_id?>"><?=$region->reg_nombre?></option>
              <?php  endforeach; ?>
            </select>  
          </div><!-- /.form-group -->

          <div class="form-group">
            <label class="col-sm-2 control-label">Tipo</label>
            <div class="radio">
              <label class="col-sm-3 text-center"> <input type="radio" name="tipo" value="D" checked> Diario </label>
              <label class="col-sm-3 text-center"> <input type="radio" name="tipo" value="S" > Semanal </label>
              <label class="col-sm-3 text-center"> <input type="radio" name="tipo" value="Q" > Quincenal </label>
            </div>
          </div><!-- /.form-group -->
          <br>
          <br>
          <div class="form-group">
            <label class="control-label">Seleccione los días de la Semana</label>
            <select class="form-control select2" multiple="multiple" data-placeholder="Puede Seleccionar más de uno" name="dia[]" style="width: 100%;" required>
              <option value="L">Lunes</option>
              <option value="K">Martes</option>
              <option value="M">Miércoles</option>
              <option value="J">Jueves</option>
              <option value="V">Viernes</option>
              <option value="S">Sábado</option>
              <option value="D">Domingo</option>
            </select>  
          </div><!-- /.form-group -->

          <button type="submit" class="btn btn-primary" style="width:100%">Guardar</button>

        </form>
      </div>

    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->



<!-- Select2 -->
<script src="<?=_R_?>plugins/select2/select2.full.min.js"></script>

<!-- Page script -->
<script>
  $(function () {
//Initialize Select2 Elements
$(".select2").select2();
});
</script>
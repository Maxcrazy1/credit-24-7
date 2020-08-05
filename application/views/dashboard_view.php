<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Página Principal
      <small>Credit 24/7</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><?=$loanTotal?></h3>

            <p>Prestamos activos</p>
          </div>
          <a href="<?=_App_?>prestamos/">
          <div class="icon">
            <i class="ion ion-card"></i>
          </div>
          </a>
          <a href="<?=_App_?>prestamos/" class="small-box-footer">Detalle <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?=$colabTotal?></h3>

            <p>Colaboradores activos</p>
          </div>
          <a href="<?=_App_?>colaboradores/">
          <div class="icon">
            <i class="ion ion-person-stalker"></i>
          </div>
          </a>
          <a href="<?=_App_?>colaboradores/" class="small-box-footer">Detalle <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?=$clientTotal?></h3>

            <p>Clientes registrados</p>
          </div>
          <a href="<?=_App_?>clientes/">
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          </a>
          <a href="<?=_App_?>clientes/" class="small-box-footer">Detalle <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?=$regionTotal?></h3>

            <p>Regiones abarcadas</p>
          </div>
          <a href="<?=_App_?>regiones/">
          <div class="icon">
            <i class="ion ion-ios-location"></i>
          </div>
          </a>
          <a href="<?=_App_?>regiones/" class="small-box-footer">Detalle <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>

    <?php if ($this->session->log_role == 'M'){ ?>
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Reporte de ingresos</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                <div class="col-sm-4 col-xs-12">
                  <div class="description-block border-right">
                    <h1 class="text-green"><i class="fa fa-line-chart "></i></h1>
                    <h5 class="description-header">₡ <span class="masked"><?=$revenueToday[0]->abn_monto ?></span></h5>
                    <span class="description-text">INGRESOS DEL DIA</span>
                    <p><a href="<?=_App_.'abonos/reportes/hoy'?>">Ver detalle</a></p>
                  </div>
                  <!-- /.description-block -->
                  <div class="description-block border-right">
                      <h1 class="text-green"><i class="fa fa-line-chart "></i></h1>
                      <h5 class="description-header">₡ <span class="masked"><?=$expensesToday[0]->prt_monto ?></span></h5>
                      <span class="description-text">EGRESOS DEL DIA</span>
                   </div>
                  <!-- /.description-block -->
                  <div class="description-block border-right">
                          <h1 class="text-green"><i class="fa fa-line-chart "></i></h1>
                      <?php if($revenueToday[0]->abn_monto >= $expensesToday[0]->prt_monto){ $expensesNeto = $revenueToday[0]->abn_monto - $expensesToday[0]->prt_monto?>
                            <h5 class="description-header">₡ <span class="masked"><?=$expensesNeto ?></span></h5>
                      <?}?>
                      <?php if($revenueToday[0]->abn_monto < $expensesToday[0]->prt_monto){ $expensesNeto = $expensesToday[0]->prt_monto - $revenueToday[0]->abn_monto?>
                            <h5 class="description-header">₡ -<span class="masked"><?=$expensesNeto ?></span></h5>
                      <?}?>
                            <span class="description-text">INGRESOS NETO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-xs-12">
                  <div class="description-block border-right">
                      <h1 class="text-green"><i class="fa fa-bar-chart "></i></h1>
                      <h5 class="description-header">₡ <span class="masked"><?=$revenueWeek[0]->abn_monto ?></span></h5>
                      <span class="description-text">INGRESOS DE LA SEMANA</span>
                      <p><a href="<?=_App_.'abonos/reportes/semana'?>">Ver detalle</a></p>
                  </div>
                   <div class="description-block border-right">
                          <h1 class="text-green"><i class="fa fa-bar-chart "></i></h1>
                    <h5 class="description-header">₡ <span class="masked"><?=$expensesWeek[0]->prt_monto ?></span></h5>
                          <span class="description-text">EGRESOS DE LA SEMANA</span>
                  </div>
                  <!-- /.description-block -->
                 <div class="description-block border-right">
                          <h1 class="text-green"><i class="fa fa-bar-chart "></i></h1>
                    <?php if($revenueWeek[0]->abn_monto >= $expensesWeek[0]->prt_monto){ $expensesNeto = $revenueWeek[0]->abn_monto - $expensesWeek[0]->prt_monto?>
                          <h5 class="description-header">₡ <span class="masked"><?=$expensesNeto ?></span></h5>
                    <?}?>
                    <?php if($revenueWeek[0]->abn_monto < $expensesWeek[0]->prt_monto){ $expensesNeto = $expensesWeek[0]->prt_monto - $revenueWeek[0]->abn_monto?>
                          <h5 class="description-header">₡ -<span class="masked"><?=$expensesNeto ?></span></h5>
                    <?}?>
                          <span class="description-text">INGRESOS NETO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-xs-12">
                          <div class="description-block">
                            <h1 class="text-green"><i class="fa fa-area-chart "></i></h1>
                            <h5 class="description-header">₡ <span class="masked"><?=$revenueMonth[0]->abn_monto ?></span></h5>
                            <span class="description-text">INGRESOS DEL MES</span>
                            <p><a href="<?=_App_.'abonos/reportes/mes'?>">Ver detalle</a></p>
                          </div>
                          <!-- /.description-block -->
                    <div class="description-block">
                            <h1 class="text-green"><i class="fa fa-area-chart "></i></h1>
                      <h5 class="description-header">₡ <span class="masked"><?=$expensesMonth[0]->prt_monto ?></span></h5>
                            <span class="description-text">EGRESOS DEL MES</span>
                    </div>
                          <!-- /.description-block -->
                    <div class="description-block border-right">
                            <h1 class="text-green"><i class="fa fa-area-chart "></i></h1>
                          <?php if($revenueMonth[0]->abn_monto >= $expensesMonth[0]->prt_monto){ $expensesNeto = $revenueMonth[0]->abn_monto - $expensesMonth[0]->prt_monto?>
                                <h5 class="description-header">₡ <span class="masked"><?=$expensesNeto ?></span></h5>
                          <?}?>
                          <?php if($revenueMonth[0]->abn_monto < $expensesMonth[0]->prt_monto){ $expensesNeto = $expensesMonth[0]->prt_monto - $revenueMonth[0]->abn_monto?>
                                <h5 class="description-header">₡ -<span class="masked"><?=$expensesNeto ?></span></h5>
                          <?}?>
                                <span class="description-text">INGRESOS NETO</span>
                    </div>
                          <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
          </div>
       <?php } ?>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
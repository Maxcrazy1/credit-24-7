
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
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
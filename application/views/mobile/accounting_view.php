<?php $name = ucfirst($this->session->log_name); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?=date('d-m-y h:i A');?>
            <small>Usuario: <?=$name?></small>
        </h1>
    </section>
    <section class="content-header">
        <h1>Contabilidad del día</h1>
    </section>
    <!-- Main content -->
    <section class="content">
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
                    <a href="<?=_App_?>prestamos/hoy" class="small-box-footer">Detalle <i class="fa fa-arrow-circle-right"></i></a>
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
                    <a href="<?=_App_?>cobros/gastos" class="small-box-footer">Detalle <i class="fa fa-arrow-circle-right"></i></a>
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
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
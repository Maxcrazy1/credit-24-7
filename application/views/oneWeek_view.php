<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Lista de la 1ra Semana <small><?//=$RegionInfo->reg_nombre?></small></h1>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#d-loans" data-toggle="tab">Préstamos Diarios</a></li>
              <li><a href="#s-loans" data-toggle="tab">Préstamos Semanales</a></li>
              <li><a href="#q-loans" data-toggle="tab">Préstamos Quincenales</a></li>
            </ul>
            <div class="tab-content">

              <div class="tab-pane active" id="d-loans">
                <?php if ($loanListD): ?>
                  <table id="dataTable-D" class="table table-bordered table-hover dataTable3">
                    <thead>
                      <tr>
                        <th># Préstamo</th>
                        <th>Nombre del Cliente</th>
                        <th>Último pago</th>
                        <th>Morosidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($loanListD as $loan) : ?>
                        <?php
                  #===============================================================================
                        if ($loan->abn_fecha == NULL) {
                    $timestamp = human_to_unix($loan->prt_fecha); # Covertir la fecha a timestamp
                    $date = "No hay pagos registrados";
                  } else {
                    $timestamp = human_to_unix($loan->abn_fecha); # Covertir la fecha a timestamp
                    $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                  }
                  $datediff = time() - $timestamp; # Calcula la diferencia de tiempo 
                  $datediff = floor($datediff/(60*60*24)); # Convertir la diferencia a dias
                  #===============================================================================
                  ?>
				  <?php if ($datediff == 7) {?>
                  <tr>
                    <td>
                      <span><i class="fa fa-barcode"></i> <?=$loan->prt_id?></span>
                      <a class="pull-right" target="newtab" href="<?=_App_.'prestamos/'.$loan->prt_id?>">Detalle</a>
                    </td>
                    <td><a href="<?=_App_?>clientes/<?=$loan->cli_id?>"><?=$loan->cli_nombre?></a></td>
                    <td><?=$date?></td>
                    <?php if ($datediff >= 3): ?>
                      <td class="bg-red"><?=$datediff?> Día(s)
                      <?php elseif ($datediff >= 1): ?>
                        <td class="bg-yellow"><?=$datediff?> Día(s)
                        <?php else: ?>
                          <td>Sin Pendientes
                          <?php endif ?>
                        </td>
                      </tr>
					  <?php }?>
                    <?php endforeach;?>
                  </tbody>
                </table>
              <?php endif ?>
            </div><!-- /.tab-pane-->

            <div class="tab-pane" id="s-loans">
              <?php if ($loanListS): ?>
                <table id="dataTable-S" class="table table-bordered table-hover dataTable3">
                  <thead>
                    <tr>
                      <th># Préstamo</th>
                      <th>Nombre del Cliente</th>
                      <th>Último pago</th>
                      <th>Morosidad</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($loanListS as $loan) : ?>
                      <?php
                  #===============================================================================
                      if ($loan->abn_fecha == NULL) {
                    $timestamp = human_to_unix($loan->prt_fecha); # Covertir la fecha a timestamp
                    $date = "No hay pagos registrados";
                  } else {
                    $timestamp = human_to_unix($loan->abn_fecha); # Covertir la fecha a timestamp
                    $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                  }
                  $datediff = time() - $timestamp; # Calcula la diferencia de tiempo 
                  $datediff = floor($datediff/(60*60*24)); # Convertir la diferencia a dias
                  $day = date('N');
                  switch ($day) {
                    case 1: $day = 'L'; break;
                    case 2: $day = 'K'; break;
                    case 3: $day = 'M'; break;
                    case 4: $day = 'J'; break;
                    case 5: $day = 'V'; break;
                    case 6: $day = 'S'; break;
                    case 7: $day = 'D'; break;
                  }
                  #===============================================================================
                  ?>
				  <?php if ($datediff == 7) {?>
                  <tr>
                    <td>
                      <span><i class="fa fa-barcode"></i> <?=$loan->prt_id?></span>
                      <a class="pull-right" target="newtab" href="<?=_App_.'prestamos/'.$loan->prt_id?>">Detalle</a>
                    </td>
                    <td><a href="<?=_App_?>clientes/<?=$loan->cli_id?>"><?=$loan->cli_nombre?></a></td>
                    <td><?=$date?></td>
                    <?php if ($datediff > 7+3): ?>
                      <td class="bg-red"><?=$datediff?> Día(s)
                    <?php elseif ($datediff == 7 AND $loan->prt_dia == $day): ?>
                        <td class="bg-light-blue">Debe pagar hoy.
                        <?php elseif ($datediff > 7): ?>
                          <td class="bg-yellow"><?=$datediff?> Día(s)
                          <?php else: ?>
                            <td>Sin Pendientes.
                            <?php endif ?>
                          </td>
                        </tr>
						<?php }?>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                <?php endif ?>
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="q-loans">
                <?php if ($loanListQ): ?>
                  <table id="dataTable-Q" class="table table-bordered table-hover dataTable3">
                    <thead>
                      <tr>
                        <th># Préstamo</th>
                        <th>Nombre del Cliente</th>
                        <th>Último pago</th>
                        <th>Morosidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($loanListQ as $loan) : ?>
                        <?php
                  #===============================================================================
                        if ($loan->abn_fecha == NULL) {
                    $timestamp = human_to_unix($loan->prt_fecha); # Covertir la fecha a timestamp
                    $date = "No hay pagos registrados";
                  } else {
                    $timestamp = human_to_unix($loan->abn_fecha); # Covertir la fecha a timestamp
                    $date = date('d-m-Y | h:i:A', $timestamp); # Formatear la fecha al formato local
                  }
                  $datediff = time() - $timestamp; # Calcula la diferencia de tiempo 
                  $datediff = floor($datediff/(60*60*24)); # Convertir la diferencia a dias
                  #===============================================================================
                  ?>
				  <?php if ($datediff == 7) {?>
                  <tr>
                    <td>
                      <span><i class="fa fa-barcode"></i> <?=$loan->prt_id?></span>
                      <a class="pull-right" target="newtab" href="<?=_App_.'prestamos/'.$loan->prt_id?>">Detalle</a>
                    </td>
                    <td><a href="<?=_App_?>clientes/<?=$loan->cli_id?>"><?=$loan->cli_nombre?></a></td>
                    <td><?=$date?></td>
                    <?php if ($datediff >= 14+3):?>
                      <td class="bg-red"><?=$datediff?> Día(s)
                      <?php elseif ($datediff > 14): ?>
                        <td class="bg-yellow"><?=$datediff?> Día(s)
                        <?php else: ?>
                          <td> Sin Pendientes.
                          <?php endif ?>
                        </td>
                      </tr>
					  <?php }?>
                    <?php endforeach;?>
                  </tbody>
                </table>
              <?php endif ?>
            </div><!-- /.tab-pane -->

          </div><!-- /.tab-content -->
        </div><!-- /.nav-tabs-custom -->
      </div><!-- /.box -->
    </div><!-- /.col -->

  </div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
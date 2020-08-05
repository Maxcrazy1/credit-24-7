      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Detalle de Préstamo <small>CANCELADO</small></h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">

                    <h1 class="profile-username text-center">CANCELADO</h1>
                    <p class="text-muted text-center">Préstamo cancelado.</p>
                  
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Tipo de préstamo</b>
                      <span class="pull-right">
                        Cancelado
                      </span>
                    </li>
                    <li class="list-group-item">
                      <b>Monto del préstamo</b>
                      <span class="pull-right">
                        ₡ <span class="masked">0</span>
                      </span>
                    </li>
                    <li class="list-group-item">
                      <b>Total a pagar</b>
                      <span class="pull-right">
                        ₡ <span class="masked">0</span>
                      </span>
                    </li>
                    <li class="list-group-item">
                      <b>Monto de la cuota</b>
                      <span class="pull-right">
                        ₡ <span class="masked">0</span>
                      </span>
                    </li>
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
                <div class="box box-primary">
                  <div class="box-header">
                    <h3 class="box-title">Último abono</h3>
                  </div>
                  <div class="box-body box-profile">
                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item">
                        <b>Fecha del abono</b>
                        <span class="pull-right">Cancelado</span>
                      </li>
                      <li class="list-group-item">
                        <b>Monto del abono</b>
                        <span class="pull-right">₡ <span class="masked">0</span></span>
                      </li>
                    </ul>                
                  </div>
                </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


      <!-- InputMask -->
      <script src="<?=_R_?>plugins/input-mask/jquery.inputmask.js"></script>
      <script src="<?=_R_?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
      <script src="<?=_R_?>plugins/input-mask/jquery.inputmask.extensions.js"></script>

      <!--script>
        $(function () {
          //Datemask dd/mm/yyyy
          $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
          //Money Euro
          $("[data-mask]").inputmask();
        });
      </script-->
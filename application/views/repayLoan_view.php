<?php $request = $_SERVER['HTTP_REFERER']; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="modal-warning in" id="modal-confirm">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Confirmar Reembolso</h4>
          </div>
          <form class="form-horizontal" action="<?=_App_.'abonos/borrar/'.$abono?>" method="GET">
            <div class="modal-body">
              <p class="lead">¿ Esta seguro/a que desea procesar esta acción?
              </p>
              <p>El saldo del abono se sumará al saldo total del préstamo.</p>
            </div>
            <div class="modal-footer">
              <a href="<?=$request?>" class="btn btn-outline pull-left">Cancelar</a>
              <button type="submit" class="btn btn-outline">Aceptar</button>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

  </section>
</div><!-- /.content-wrapper -->
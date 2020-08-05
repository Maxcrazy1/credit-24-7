<div class="modal-warning in" id="modal-confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmar el Pago</h4>
      </div>
      <form class="form-horizontal" action="<?=_App_?>cobros/prestamos/pagar" method="GET">
        <input type="hidden" name="cobrador" value="<?=$colaborador?>">
        <input type="hidden" name="rdr" value="cobros/">

        <input type="hidden" name="prestamo" value="<?=$prestamo?>">
        <input type="hidden" name="cliente" value="<?=$cliente?>">
        <input type="hidden" name="saldo" value="<?=$saldo?>">

        <input type="hidden" name="monto" value="<?=$monto?>">
        <input type="hidden" name="notas" value="<?=$notas?>">
  
        <div class="modal-body">
          <p class="lead">¿ Esta seguro/a que desea registrar un abono por el monto de 
          <strong>₡ <span class="masked"><?=$monto?></span></strong> al préstamo #<?=$prestamo?>?
          </p>
        </div>
        <div class="modal-footer">
          <a href="<?=_App_.'cobros/prestamos/'.$prestamo?>" class="btn btn-outline pull-left">Cancelar</a>
          <button type="submit" class="btn btn-outline">Registrar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
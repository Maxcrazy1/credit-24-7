<div class="modal-warning in" id="modal-confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmar Renovacion</h4>
      </div>
      <form class="form-horizontal" action="<?=_App_?>cobros/prestamos/renovar" method="GET">

        <input type="hidden" name="cliente" value="<?=$cliente?>">

        <input type="hidden" name="prestamo" value="<?=$prestamo?>">
        <input type="hidden" name="saldo" value="<?=$saldo?>">
        

        <input type="hidden" name="monto" value="<?=$monto?>">
        <input type="hidden" name="cuotas" value="<?=$cuotas?>">
        <input type="hidden" name="notas" value="<?=$notas?>">
        <input type="hidden" name="tipo" value="<?=$tipo?>">
        <input type="hidden" name="dia" value="<?=$dia?>">

        <div class="modal-body">
          <p class="lead">¿ Esta seguro/a que desea renovar el préstamo #<?=$prestamo?> por el monto de 
            <strong>₡ <span class="masked"><?=$monto?></span></strong>?
          </p>
          <p>El saldo restante se descontará automaticamente: <br>₡<span class="masked"><?=$saldo?></span></p>
        </div>
        <div class="modal-footer">
          <a href="<?=_App_.'cobros/prestamos/'.$prestamo?>" class="btn btn-outline pull-left">Cancelar</a>
          <button type="submit" class="btn btn-outline">Registrar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
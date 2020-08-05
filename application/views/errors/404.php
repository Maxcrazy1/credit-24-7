<?php if ($this->session->log_status !== 'success'): redirect(_App_); endif; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Página de Error 404
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="error-page">
      <h2 class="headline text-yellow"> 404</h2>
      <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Oops! Página no encontrada.</h3>
        <p>La página que estas buscando ya no esta disponible o <b>no existe</b>.</p>
        <p>Puedes regresar a la <a href="<?=_App_?>">Página Principal</a>.</p>
      </div><!-- /.error-content -->
    </div><!-- /.error-page -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
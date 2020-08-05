<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Colaboradores <small>Módulo de Control</small></h1>
		<div class="breadcrumb pull-right">
            <a  data-toggle="modal" data-target="#modal-add" class="btn btn-sm bg-light-blue" href=""><i class="fa fa-plus"></i>&nbsp; Agregar Nuevo Colaborador</a>
            <a  class="btn btn-sm bg-primary" href="<?=_App_?>colaboradores/alternar/todo/1"><i class="fa fa-unlock"></i>&nbsp; Activar Colaboradores</a>
            <a  class="btn btn-sm bg-yellow" href="<?=_App_?>colaboradores/alternar/todo/0"><i class="fa fa-lock"></i>&nbsp; Desactivar Colaboradores</a>
		</div>
	</section>
	
	<!-- Main content -->
	<section class="content">
		<div class="row hidden">
            <div class="col-md-6 col-md-offset-3">
				<form action="#" method="get" class="sidebar-form">
					<div class="input-group">
						<input type="text" name="q" class="form-control" placeholder="Busqueda...">
						<span class="input-group-btn">
							<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form>
			</div>
		</div>
		<hr>
		
		<div class="row">
            <?php foreach ($colaboratorList as $colaborator) : ?>
			<?php if ($colaborator->clb_id != 0): ?>
			<?php 
				#===============================================================================
				$background = ($colaborator->clb_estado) ? 'bg-olive' : 'bg-gray';
				$icon = ($colaborator->clb_role == 'C') ? 'fa-mobile' : 'fa-desktop';
				#===============================================================================
			?>
			<div class="col-md-3">
                <div class="info-box">
					<a class="" href="<?=_App_.'colaboradores/'.$colaborator->clb_id?>">
						<span class="info-box-icon <?=$background?>"><i class="fa <?=$icon?>"></i></span>
					</a>
					<div class="info-box-content">
						<?php if ($colaborator->clb_estado): ?>
						<a href='<?=_App_."colaboradores/alternar/$colaborator->clb_id"?>/0?rdr=list' class="close fa fa-toggle-off" data-toggle="tooltip" title="Desactivar"></a>
						<?php else: ?>
						<a href='<?=_App_."colaboradores/alternar/$colaborator->clb_id"?>/1?rdr=list' class="close fa fa-toggle-on" data-toggle="tooltip" title="Activar"></a>
						<?php endif ?>
						
						<span class="info-box-number"><?=$colaborator->clb_nombre?></span>
						<span class="info-box-text">Tel. <?=$colaborator->clb_telefono?></span>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
			</div><!-- /.col -->
			<?php endif ?>
			<?php   endforeach; ?> 
		</div><!-- /.row -->
		
        <div class="modal fade" id="modal-add">
            <div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Agregar nuevo colaborador</h4>
					</div>
					<form class="form-horizontal" action="<?=_App_?>colaboradores/agregar" method="POST">
						<div class="modal-body">
							<div class="form-group">
								<label for="inputName" class="col-sm-2 control-label">Nombre</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="nombre" placeholder="Nombre completo" required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputName" class="col-sm-2 control-label">Usuario</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="usuario" placeholder="Nombre de usuario" required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPhone" class="col-sm-2 control-label">Teléfono</label>
								<div class="col-sm-10">
									<input type="number" class="form-control" name="telefono" placeholder="Teléfono" required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPhone" class="col-sm-2 control-label">Contraseña</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" name="password" placeholder="Contraseña" required>
								</div>
							</div>
							<div class="form-group">
								<label for="inputExperience" class="col-sm-2 control-label">Notas</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="notas" placeholder="Notas"></textarea>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->
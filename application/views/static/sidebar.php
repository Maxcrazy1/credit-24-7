      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <?php if ($this->session->log_status === 'success') {?>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form hidden">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Buscar...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Página Principal</li>
            <li><a href="<?=_App_?>"><i class="fa fa-th"></i> <span>Inicio</span></a></li>
          </ul>

          <ul class="sidebar-menu">
            <li class="header">Menú de Contenido</li>
            <li><a href="<?=_App_?>clientes/"><i class="fa fa-user"></i> <span>Clientes</span></a></li>
			<li class="subMenu"><a href="#"><i class="fa fa-user-times"></i> <span>Clientes Morosos</span></a>
				<ul id="sub-menu" class="sidebar-menu">
					<li><a href="<?=_App_?>primer-semana/"><i class="fa fa-indent"></i> <span>1er semana</span></a></li>
					<li><a href="<?=_App_?>segunda-semana/"><i class="fa fa-indent"></i> <span>2da semana</span></a></li>
					<li><a href="<?=_App_?>tercer-semana/"><i class="fa fa-indent"></i> <span>3er semana</span></a></li>
					<li><a href="<?=_App_?>cuarta-semana/"><i class="fa fa-indent"></i> <span>4ta semana</span></a></li>
					<li><a href="<?=_App_?>quinta-semana/"><i class="fa fa-indent"></i> <span>5ta semana</span></a></li>
				</ul>
			</li>
            <li><a href="<?=_App_?>prestamos/"><i class="fa fa-credit-card"></i> <span>Préstamos</span><span class="hidden label pull-right bg-green">6</span></a></li>
			<li><a href="<?=_App_?>prestamos-dia/"><i class="fa fa-credit-card"></i> <span>Préstamos del Día</span><span class="hidden label pull-right bg-green">6</span></a></li>
            <li><a href="<?=_App_?>colaboradores/"><i class="fa fa-group"></i> <span>Colaboradores</span></a></li>
			<li><a href="<?=_App_?>lista-negra/"><i class="fa fa-list-alt"></i> <span>Lista Negra</span><span class="hidden label pull-right bg-green">6</span></a></li>
          </ul>

          <ul class="sidebar-menu">
            <li class="header">Menú de Administración</li>
            <li><a href="<?=_App_?>horarios"><i class="fa fa-calendar"></i> <span>Horarios</span></a></li>
            <li><a href="<?=_App_?>regiones"><i class="fa fa-map"></i> <span>Regiones</span></a></li>
          </ul>

          <ul class="sidebar-menu">
            <li class="header">Menú de Configuración</li>
            <li><a href="<?=_App_?>usuarios"><i class="fa fa-user"></i><span>Usuarios</span></a></li>
            <li><a href="<?=_App_?>configuracion"><i class="fa fa-gear"></i><span>Configuración</span></a></li>
          </ul>
            <?php } else {?>
            <ul class="sidebar-menu">
            <li class="header">Créditos</li>
            <li><a href="<?=_App_?>consulta"><i class="fa fa-search"></i> <span>Consultas</span></a></li>
          </ul>
            <?php }?>

        </section>
        <!-- /.sidebar -->
      </aside>
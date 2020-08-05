      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <?php if ($this->session->log_role === 'C'): ?>
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
            <li><a href="<?=_App_?>cobros"><i class="fa fa-th"></i> <span>Inicio</span></a></li>
          </ul>
          
          <ul class="sidebar-menu">
            <li class="header">Menú de Contenido</li>
            <li><a href="<?=_App_?>cobros/clientes"><i class="fa fa-user"></i><span>Clientes</span></a>
            </li>
			<li><a href="<?=_App_?>prestamos/hoy/"><i class="fa fa-credit-card"></i> <span>Préstamos del Día</span></a></li>
			<li><a href="<?=_App_?>cobros/gastos"><i class="fa fa-credit-card"></i> <span>Gastos</span></a></li>
			<li><a href="<?=_App_?>cobros/contabilidad"><i class="fa fa-credit-card"></i> <span>Contabilidad del Día</span></a></li>
          </ul>
          
          <ul class="sidebar-menu">
            <li class="header">Menú de Configuración</li>
            <li><a href="<?=_App_?>perfil"><i class="fa fa-user"></i><span>Mis Datos</span></a></li>
          </ul>
          <?php  else: ?>
<ul class="sidebar-menu">
            <li class="header">Créditos</li>
            <li><a href="<?=_App_?>consulta"><i class="fa fa-search"></i> <span>Consultas</span></a></li>
          </ul>
            <?php  endif ?>
        </section>
        <!-- /.sidebar -->
      </aside>
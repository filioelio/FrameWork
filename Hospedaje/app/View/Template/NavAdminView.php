  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= $usuario->getFoto(true) != NULL ? $usuario->getFoto(true) : $helper->base_url().'/img/users/template.jpg' ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Filio Carrasco</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!--  -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">PANEL DE NAVEGACION</li>
        <li class="active"><a href="<?=$helper->url('index', 'index');?>"><i class="fa fa-home"></i> <span>INICIO</span></a></li>
        <li><a href="<?= $helper->url('producto', 'lista');?>"><i class="fa fa-barcode text-red"></i> <span>PRODUCTOS</span></a></li>
        <li><a href="<?= $helper->url('gastos', 'nuevo');?>"><i class="fa fa-money text-red"></i> <span>REGISTRO DE GASTOS</span></a></li>
        <li><a href="<?=$helper->url('venta', 'ingreso');?>"><i class="fa fa-money text-yellow"></i> <span>HISTORIAL VENTA </span></a></li>
        <li><a href="<?=$helper->url('hospedaje', 'ingreso');?>"><i class="fa fa-money text-yellow"></i> <span>INGRESO HOSTAL</span></a></li>
        <li>
          <a href="<?= $helper->url('huesped', 'registro');?>">
            <i class="fa fa-file-text text-aqua"></i> <span>HUESPED</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-blue">
                <?php foreach ($cantidad as $key => $value): ?>
                  <?=$value->cantidad?>
                <?php endforeach ?>
              </small>
            </span>
          </a>
        </li>       
        <li>
          <a href="<?= $helper->url('hospedaje', 'historial');?>">
            <i class="fa fa-calendar text-success"></i> <span>HISTORIAL HOSPEDAJE</span>
          </a>
        </li>
        <li>
          <a href="<?= $helper->url('reservacion', 'historial');?>">
            <i class="fa fa-calendar text-yellow"></i> <span>HISTORIAL RESERVACION</span>
          </a>
        </li>
        <li>
          <a href="<?= $helper->url('personal', 'eventos');?>">
            <i class="fa fa-book text-yellow"></i> <span>CONTROL DE AGENDA</span>
          </a>
        </li>
        
        <li class="treeview">
            <a href="#"><i class="fa fa-university text-blue"></i> <span>HABITACIONES</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu menu-open" style="display: block;;">
              <li><a href="<?= $helper->url('habitacion', 'disponible');?>"><i class="fa fa-circle-o text-red"></i> <span>DISPONIBLES</span><span class="pull-right-container"><small class="label pull-right bg-red"><?=$estado->disponible?></small></span></a></li>
              <li><a href="<?= $helper->url('habitacion', 'ocupado');?>"><i class="fa fa-circle-o text-yellow"></i> <span>OCUPADAS</span><span class="pull-right-container"><small class="label pull-right bg-yellow"><?=$estado->ocupado?></small></span></a></li>
              <li><a href="<?= $helper->url('reservacion', 'reservado');?>"><i class="fa fa-circle-o text-aqua"></i> <span>RESERVADAS</span><span class="pull-right-container"><small class="label pull-right bg-aqua"><?=$estado->reservado?></small></span></a></li>
            </ul>
        </li>
        <?php if($usuario->getTipo() == "Admin"): ?>
          <li class="treeview">
            <a href="#"><i class="fa  fa-briefcase"></i> <span>ADMINISTRAR</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="<?= $helper->url('usuario', 'usuario');?>">USUARIO</a></li>
              <li><a href="<?= $helper->url('habitacion', 'habitacion');?>">HABITACIONES</a></li>
              <li><a href="<?= $helper->url('producto', 'registro');?>">PRODUCTOS</a></li>
              <li><a href="<?= $helper->url('reporte', 'reporte');?>">REPORTES</a></li>
            </ul>
          </li>
           <li class="treeview">
            <a href="#"><i class="fa  fa-users text-blue"></i> <span>PERSONAL</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="<?= $helper->url('personal', 'registro');?>">NUEVO PERSONAL</a></li>
              <li><a href="<?= $helper->url('personal', 'eventos');?>">CONTROL DE AGENDA</a></li>
              <li><a href="<?= $helper->url('personal', 'pago');?>">CONTROL DE PAGOS</a></li>
              <li><a href="<?= $helper->url('personal', 'permiso');?>">CONTROL DE PERMISO</a></li>
            </ul>
          </li>
        <?php endif; ?>
          
      </ul>
    </section>
  </aside>
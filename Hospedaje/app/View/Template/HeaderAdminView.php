<header class="main-header">

    <!-- Logo -->
    <a href="<?= $helper->url('index', 'index');?>" class="logo">
      <span class="logo-mini"><b>HEA</b></span>
      <span class="logo-lg"><b>Hostal</b> EA</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?=$estado->reservado?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tiene <?=$estado->reservado?> Mensajes de Reservacion</li>
              <?php if (isset($mensaje) && $mensaje != 1): ?>                
                <?php foreach ($mensaje as $key => $item): ?>
                  <li>
                    <ul class="menu">
                      <li>
                        <a href="<?= $helper->url('reservacion', 'reservado');?>">
                          <div class="pull-left">
                            <img src="<?=$helper->base_url().'/img/Habitacion/'.$item->foto ?>" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            <?=$item->huesped?>
                            <small><i class="fa fa-clock-o"></i> <?=$item->tiempo?></small>
                          </h4>
                          <p><?=$helper->FormatDate($item->fecha_ingreso)?></p>
                        </a>
                      </li>
                    </ul>
                  </li>
                <?php endforeach ?>
              <?php endif ?>
              
              <li class="footer"><a href="<?= $helper->url('reservacion', 'reservado');?>">Ver Todas las Reservciones</a></li>
            </ul>
          </li>
          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">
                <?php if (isset($agenda) && $agenda != 1): ?>
                  <?=$agenda[0]->cant != ""? $agenda[0]->cant : "0" ?>
                <?php else: ?>
                  0
                <?php endif ?>
                  
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tiene 
                <?php if (isset($agenda) && $agenda != 1): ?>
                  <?=$agenda[0]->cant != ""? $agenda[0]->cant : "0" ?>
                <?php else: ?>
                  0
                <?php endif ?> Notificaciones</li>
              <li>
                <?php if (isset($agenda) && $agenda != 1): ?>
                <ul class="menu">
                  <?php foreach ($agenda as $key => $item): ?>
                    <li>
                      <a href="<?= $helper->url('personal', 'eventos');?>">
                        <i class="fa fa-opencart text-red"></i>  <?=$item->titulo?>
                      </a>
                    </li>
                  <?php endforeach ?>
                </ul>
                <?php endif ?>
              </li>
              <li class="footer"><a href="<?= $helper->url('personal', 'eventos');?>">Abrir Agenda</a></li>
            </ul>
          </li>
          <!-- Tasks Menu -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">
                <?php if (isset($permiso) && $permiso != 1): ?>
                  <?=$permiso[0]->cant != ""? $permiso[0]->cant : "0" ?>
                <?php else: ?>
                  0
                <?php endif ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Permisos al Personal</li>
              <li>
                <?php if (isset($permiso) && $permiso != 1): ?>
                <ul class="menu">
                  <?php foreach ($permiso as $key => $item): ?>
                    <li>
                      <a href="<?= $helper->url('personal', 'permiso');?>">
                          <i class="fa fa-user text-blue"></i>  <?=$item->personal?>
                      </a>
                    </li>
                  <?php endforeach ?>
                </ul>
                <?php endif ?>
              </li>
              <li class="footer">
                <a href="<?= $helper->url('personal', 'permiso');?>">Ver Agenda de Permisos</a>
              </li>
            </ul>
          </li>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= $usuario->getFoto(true) != NULL ? $usuario->getFoto(true) : $helper->base_url().'/img/users/template.jpg' ?>" class="user-image" alt="user <?=$usuario->getNombre()?>">
              <span class="hidden-xs"><?=$usuario->getNombre()?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?=$usuario->getFoto(true) != NULL ? $usuario->getFoto(true) : $helper->base_url().'/img/ampay.jpg' ?>" class="img-circle" alt="User Image">
                <p>
                  <?=$usuario->getNombre()?> <?=$usuario->getApellido()?>
                  <small>
                    <?php if ($usuario->getTipo()=="Admin"): ?>
                      Administrador
                    <?php else: ?>
                      Usuario del Sistema
                    <?php endif ?>
                  </small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= $helper->url('usuario', 'editar');?>" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="<?= $helper->url('index', 'logout');?>" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
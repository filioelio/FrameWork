<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Habitacion - Disponible</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?=$helper->css('ed-grid')?>
	<?=$helper->css('header')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>
	<?=$helper->css('Habitacion')?>
	<?=$helper->css('sweetalert')?>

</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<?=$this->view('Template/HeaderAdmin',$datos_template)?>
		<?=$this->view('Template/NavAdmin', $datos_template)?>
		<div class="content-wrapper">
		    <section class="content">	
				<div id="form_habitacion" class="grupo">
					<div class="grupo menu-nav centro-contenido">
						<div class="grupo menu-nav centro-contenido">
							<a href="<?= $helper->url('habitacion', 'disponible');?>" class="mnav_item caja base-1-3 icon-aceptar espacio">
								<span class="menu_nav_item desde-movil">Disponible</span>
							</a>
							<a href="<?= $helper->url('habitacion', 'ocupado');?>" class="mnav_item caja base-1-3 icon-cerrar espacio ">
								<span class="menu_nav_item desde-movil">Ocupada</span>
							</a>
							<a href="<?= $helper->url('reservacion', 'reservado');?>" class="mnav_item caja base-1-3 icon-portafolio espacio">
								<span class="menu_nav_item desde-movil">Reservada</span>
							</a>
						</div>
					</div>
						<!-- inicio formulario -->
					<?php if (isset($habitaciones)): ?>
						<?php foreach ($habitaciones as $key => $habitacion): ?>
							<?php if ($habitacion->getEstado() == 'Disponible'): ?>		
								<div id="from_menu" class="grupo">
									<div class="form_info caja menu_titulo total centro-contenido">
										<h2>Habitación Nº: <span><?=$habitacion->getIdHabitacion()?></span>
										<?php if (isset($habitacion->getAlert()->mensaje) && $habitacion->getAlert()->mensaje == 1): ?>
										    <a href="<?=$helper->url('reservacion','reservado',$habitacion->getAlert()->id)?>" class="dropdown-toggle label label-warning pull-right" >
										        <i class="fa fa-envelope-o"></i>
										    </a>
										<?php endif ?>
										</h2>
									</div>
									<div class="form_info caja menu_img movil-25">
										<img class="" src="<?= $habitacion->getFoto(true) != NULL ? $habitacion->getFoto(true) : $helper->base_url().'/img/Habitacion/template.jpg' ?>" alt="">
									</div>
									<div class="form_info caja menu_descripcion movil-55">
										<h3 class="text-center" >Características de la Habitación</h3>				
										<h4>Tipo Habitacion: <span class="espacio"><?=$habitacion->getTipo()?></span></h4>
										<h4>Descripcion: <span class="espacio"><?=$habitacion->getDescripcion()?></span></h4>
										<h4>Estado: <span class="espacio"><?=$habitacion->getEstado()?></span></h4>
										<h4>Precio: s/: <span class="espacio"><?=$habitacion->getPrecio()?></span> Nuevos Soles.</h4>
									</div>
									<div class="caja movil-20">
										<?= $helper->Disponible($habitacion->getIdHabitacion())?>					
									</div>
								</div>
							<?php endif ?>	
						<?php endforeach ?>
					<?php endif ?>
				</div>
			</section>	
		</div>
		
		<?=$this->view('Template/FooterAdmin')?>
	 	<?=$this->view('Template/Asidebar')?>
	</div>
	<?=$helper->js('jQuery-2.2.0.min')?>
	<?=$helper->js('bootstrap.min')?>
	<?=$helper->js('app.min')?>	
	<?=$helper->js('variables-globales')?>
	<?=$helper->js('NewEvento')?>
	<?=$helper->js('sweetalert.min')?>
</body>
</html>
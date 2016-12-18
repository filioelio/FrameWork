<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Habitacion - Reservacion</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?=$helper->css('ed-grid')?>
	<?=$helper->css('header')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>
	<?=$helper->css('Habitacion')?>
	<?=$helper->css('ocupado')?>
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
							<a href="<?= $helper->url('habitacion', 'ocupado');?>" class="mnav_item caja base-1-3 icon-cerrar espacio">
								<span class="menu_nav_item desde-movil">Ocupada</span>
							</a>
							<a href="<?= $helper->url('reservacion', 'reservado');?>" class="mnav_item caja base-1-3 icon-portafolio espacio">
								<span class="menu_nav_item desde-movil">Reservada</span>
							</a>
						</div>
					</div>

						<!-- inicio formulario -->
					<?php if (isset($habitaciones) && $habitaciones != '1'): ?>
						<?php foreach ($habitaciones as $key => $habitacion): ?>
							<?php if (TRUE): ?>	
								<div id="from_menu" class="grupo">
									<div class="caja menu_img base-1-6">
										<img src="<?= $helper->base_url().'/img/Habitacion/'.$habitacion->foto?>" alt="">
										<span>habitacion Nº: <?=$habitacion->id_habi?></span>
										<<span class="fa fa-home"> <?=$habitacion->tipo?></span>
									</div>
									<div class="caja base-1-3">				
										<h4 class="fa  fa-user-secret text-blue"> Huesped: <span class="espacio"><?=$habitacion->huesped?></span></h4>
										<h4><i class="fa fa-phone text-green"></i> Telefono: <span class="espacio text-blue"><?=$habitacion->telefono?></span></h4>									
										<h4><i class="fa fa-money text-yellow"></i>  Precio : <span class="text-blue"><?=$habitacion->precio?></span></h4>
										<h4><i class="fa fa-money text-yellow"></i> Adelanto : <span class="text-blue"><?=$habitacion->adelanto?></span></h4>
										
									</div>
									<div class="caja base-1-3">
										<h4 class="fa fa-calendar-check-o text-green">fecha reserva: <span class="espacio"><?=$habitacion->fecha_reser?></span></h4>
										<h4 class="fa fa-calendar text-blue"> ingreso: <span class="espacio"><?=$helper->FormatDate($habitacion->fecha_ingreso)?></span></h4>
										<h4 class="fa fa-calendar-o text-blue"> salida: <span class="espacio"><?=$helper->FormatDate($habitacion->fecha_salida)?></span></h4>
										<h4 class="fa fa-file-text text-red"> descripcion: <span class="espacio"><?=$habitacion->descripcion?></span></h4>
									</div>
									<div class="caja movil-1-6">
										<?= $helper->Reservado($habitacion->id_habi, $habitacion->dni."*".$habitacion->adelanto, $habitacion->id_reservacion)?>											
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
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Habitacion - Ocupado</title>
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
					<?php if (isset($seleccionado) && $seleccionado != '1'): ?>
						<?php foreach ($seleccionado as $key => $habitacion): ?>
								<div id="from_menu" class="grupo">
									<div class="caja menu_img base-1-6">
										<img class="" src="<?=$helper->base_url().'/img/Habitacion/'.$habitacion->foto?>" alt="">
										<span>Habitacion Nº <?=$habitacion->hab?></span>
										<span class="fa fa-home"> <?=$habitacion->tipo?></span>
									</div>
									<div class="caja base-1-3">
										<p class="fa fa-user-secret text-blue user"> <?=$habitacion->huesped?></p><br>
										<p class="fa fa-phone text-green"> <span ><?=$habitacion->telefono?></span>.</p> <br>
										<p class="fa  fa-calendar text-green"> Ingre<span> <?=$helper->FormatDateTime($habitacion->fecha_ingreso) ?></span>.</p><br>
										<p class="fa  fa-calendar text-blue"> salida<span> <?=$helper->FormatDateTime($habitacion->fecha_salida)?></span>.</p><br>		
									</div>
									<div class="caja base-1-3">
										<p class="fa fa-clock-o text-red"> <span> <?=$habitacion->horas?></span>.</p><br>	
										<p class="fa fa-money text-yellow"> precio Habitacion: <span><?=$habitacion->precio?></span>.</p><br>
										<p class="fa fa-money text-orange"> Adelanto : <span><?=$habitacion->adelanto?></span>.</p><br>
										<p class="fa fa-money text-orange"> Deuda : <span><?=$habitacion->deuda?></span>.</p><br>
										<p class="fa fa-money text-orange"> Total a Cancelar : <span><?=$habitacion->total?></span>.</p><br>
									</div> 
									<div class="caja base-1-6">
										<?= $helper->Ocupado($habitacion->hab)?>											
									</div>
								</div>
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
</body>
</html>
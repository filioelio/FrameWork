<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Home</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?=$helper->css('ed-grid')?>
	<?=$helper->css('header')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>
	<?=$helper->css('Habitacion')?>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<?=$this->view('Template/HeaderAdmin',$datos_template)?>
		<?=$this->view('Template/NavAdmin', $datos_template)?>
		<div class="content-wrapper">
		    <section class="content">
				<div  class="form_admin grupo centro-contenido">
					<div class="caja base-100">
						<span class="form_titulo">Administracion General</span>
					</div>
					<div id="menu_lista" class="caja ">
						<ul>
							<li class="display">
								<div class="menu_nav">
									<a class="menu_nav_item icon-usuario espacio" href="<?= $helper->url('usuario', 'usuario');?>">
										<span class="desde-tablet">Usuario</span>
									</a>
								</div>
							</li>
							<li class="display">
								<div class="menu_nav">
									<a class="menu_nav_item icon-portafolio espacio" href="<?= $helper->url('habitacion', 'habitacion');?>">
										<span class="desde-tablet">Habitacion</span>
									</a>
								</div>
							</li>
							<li class="display">
								<div class="menu_nav">
									<a class="menu_nav_item icon-carrito espacio" href="<?= $helper->url('producto', 'registro');?>">
										<span class="desde-tablet">Producto</span>
									</a>
								</div>
							</li>
							<li class="display">
								<div class="menu_nav">
									<a class="menu_nav_item icon-usuario espacio" href="<?= $helper->url('reporte', 'reporte');?>">
										<span class="desde-tablet">Reportes</span>
									</a>
								</div>
							</li>					
						</ul> 
					</div> 

					<div class="caja base-100">
						<span class="form_titulo">administracion del personal</span>
					</div>
					<div id="menu_lista" class="caja ">
						<ul>
							<li class="display">
								<div class="menu_nav">
									<a class="menu_nav_item icon-usuario espacio" href="<?= $helper->url('personal', 'registro');?>">
										<span class="desde-tablet">Nuevo Personal</span>
									</a>
								</div>
							</li>
							<li class="display">
								<div class="menu_nav">
									<a class="menu_nav_item icon-usuario espacio" href="<?= $helper->url('personal', 'eventos');?>">
										<span class="desde-tablet">Control de Agenga</span>
									</a>
								</div>
							</li>	
							<li class="display">
								<div class="menu_nav">
									<a class="menu_nav_item icon-usuario espacio" href="<?= $helper->url('personal', 'pago');?>">
										<span class="desde-tablet">Control de Pagos</span>
									</a>
								</div>
							</li>	
							<li class="display">
								<div class="menu_nav">
									<a class="menu_nav_item icon-usuario espacio" href="<?= $helper->url('personal', 'permiso');?>">
										<span class="desde-tablet">Control de Permiso</span>
									</a>
								</div>
							</li>						
						</ul> 
					</div> 
				</div>
			</section>	
		</div>
		
		<?=$this->view('Template/FooterAdmin')?>
	 	<?=$this->view('Template/Asidebar')?>
	</div>
	<?=$helper->js('jQuery-2.2.0.min')?>
	<?=$helper->js('bootstrap.min')?>
	<?=$helper->js('app.min')?>	

</body>
</html>
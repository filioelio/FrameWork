<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Nuevo - Personal</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<?=$helper->css('ed-grid')?>
  	<?=$helper->css('header')?>
    <?=$helper->css('ExitoError')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  	<?=$helper->css('select2.min')?>
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>
	<?=$helper->css('sweetalert')?>

</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<?=$this->view('Template/HeaderAdmin',$datos_template)?>
	    <?=$this->view('Template/NavAdmin', $datos_template)?>

	    <div class="content-wrapper">
	    	<section class="content-header">
      			<h1>Formulario de Personal</h1>
    		</section>
    		<section class="content">
				<div class="row">
					<div class="col-md-4">
						<div class="box box-primary">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Formulario de Registro</h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			            	<form id="url_personal" action="<?= $helper->url('personal', 'registro');?>" method="post">
				              	<div class="box-body">
				                	<div id="exitoerror" class="form-group text-center">
					                    <span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>      
					                </div>
					                <div class="form-group">
					                    <label for="dni">Nº DNI</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-user text-blue"></i>
							                </span>
							                <input id="dni" name="dni" type="text" class="form-control" placeholder="Ingrese DNI" maxlength="8" minlength="8" value="<?=$dni?>" required>
							            </div>
					                </div>
					                <div class="form-group">
					                    <label for="nombre">Nombre</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-user text-blue"></i>
							                </span>
							                <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" value="<?=$nombre?>" required>
							            </div>
					                </div>
					                <div class="form-group">
					                    <label for="apellido">Apellido</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-user text-blue"></i>
							                </span>
							                <input id="apellido" name="apellido" type="text" class="form-control" placeholder="Apellido" value="<?=$apellido?>" required>
							            </div>
					                </div>
					                <div class="form-group">
					                    <label for="celular">Nº Celular</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-user text-blue"></i>
							                </span>
							                <input id="celular" name="celular" type="text" class="form-control" placeholder="Nº Celular" value="<?=$celular?>" maxlength="9" minlength="9" required>
							            </div>
					                </div>
					                <div class="form-group">
					                    <label for="direccion">Direccion</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-user text-blue"></i>
							                </span>
							                <input id="direccion" name="direccion" type="text" class="form-control" placeholder="Direccion" value="<?=$direccion?>" required>
							            </div>
					                </div>
					                <div class="form-group">
					                    <label for="labor">Trabajo del Personal</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-user text-blue"></i>
							                </span>
							                <input id="labor" name="labor" type="text" class="form-control" placeholder="Labor" value="<?=$labor?>" required>
							            </div>
					                </div>
					                <div class="row">
					                	<div class="col-md-6">
					                		<div class="form-group">
							                    <label for="salario">Salario</label>
							                    <div class="input-group">
									                <span class="input-group-addon">
									                    <i class="fa fa-money text-yellow"></i>
									                </span>
									                <input id="salario" name="salario" type="text" class="form-control" placeholder="Ingrese Monto" value="<?=$salario?>" required>
									            </div>
							                </div>
					                	</div>
					                	<div class="col-md-6">
					                		<div class="form-group">
							                    <label for="estado">Estado</label>
							                    <div class="input-group">
									                <span class="input-group-addon">
									                    <i class="fa fa-user text-blue"></i>
									                </span>
									                <select id="estado" class="form-control" style="width: 100%;" tabindex="-1" name="estado" value="<?=$estado?>" aria-hidden="true">
														<option value="Activo">Activo</option>
						                       			<option value="Inactivo">Inactivo</option>
									                </select>
									            </div>
							                </div>
					                	</div>
					                </div>
					                <div class="form-group">
					                    <label for="fecha">Ingrese una Fecha Inicio</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-calendar text-blue"></i>
							                </span>
							                <input id="fecha" type="date" name="fecha" value="<?=$fecha?>" class="form-control" required>
							            </div>
					                </div>
				                </div>
				                <div class="box-footer">
			                		<span id="cancelar" class="btn btn-sm btn-default btn-flat pull-left">Cancelar</span>
			                      	<button id="submit" type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Registrar Personal</button>
			                    </div>
		                    </form> 
			            </div>
					</div>
					<div class="col-md-8">
						<div class="box box-info">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Lista de Personal</h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			              	<div class="box-body">
			                	<div class="table-responsive"> 
			                	<table class="table table-bordered">
			                		<thead>
			                			<th>Nº DNI</th>
			                			<th>NOMBRE</th>
			                			<th>APELLIDO</th>
			                			<th>CELULAR</th>
			                			<th>DIRECCION</th>
			                			<th>LABOR</th>
			                			<th>SALARIO</th>
			                			<th>FECHA INGRESO</th>
			                			<th>ESTADO</th>
			                		</thead>
			                		<tbody>
			                			<?php if (isset($personal)): ?>
			                				<?php foreach ($personal as $key => $item): ?>
			                					<tr>
			                						<td data-id = "<?=$item->getIdPersonal()?>" class="id_personal"><a><?=$item->getIdPersonal()?></a></td>
			                						<td><?=$item->getNombre()?></td>
			                						<td><?=$item->getApellido()?></td>
			                						<td><?=$item->getTelefono()?></td>
			                						<td><?=$item->getDireccion()?></td>
			                						<td><?=$item->getLabor()?></td>
			                						<td><?=$item->getSalario()?></td>
			                						<td><?=$helper->FormatDate($item->getFechaInicio())?></td>
			                						<td><?=$item->getEstado()?></td>
			                					</tr>
			                				<?php endforeach ?>
			                			<?php endif ?>
			                			
			                		</tbody>
			                	</table> 
			                	</div>
			                </div>
			                <div class="box-footer text-center">
			                  <a href="javascript:void(0)" class="uppercase">Exportar Reporte DomPDF</a>
			                </div>
			            </div>
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
	<?=$helper->js('variables-globales')?>	
	<?=$helper->js('EventoPersonal')?>
	<?=$helper->js('sweetalert.min')?>
</body>
</html>
 <!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Nuevo - Gasto</title>
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

</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<?=$this->view('Template/HeaderAdmin',$datos_template)?>
	    <?=$this->view('Template/NavAdmin', $datos_template)?>

	    <div class="content-wrapper">
	    	<section class="content-header">
      			<h1>Formulario Gastos</h1>
    		</section>
    		<section class="content">
				<div class="row">
					<div class="col-md-4">
						<div class="box box-primary">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Nuevo Registro de Gastos</h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			            	<form id="url_gasto" action="<?= $helper->url('gastos', 'nuevo');?>" method="post">
				              	<div class="box-body">
				                	<div id="exitoerror" class="form-group text-center">
					                    <span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>      
					                </div>
					                 <div class="form-group">
					                    <label for="recibe">Persona quien Recive</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-user text-blue"></i>
							                </span>
							                <input id="recibe" type="text" name="recibe" class="form-control" placeholder="Nombre de quien Recibe" value="<?=$recibe?>"  required>
							            </div>
					                </div>
					                <div class="form-group">
					                    <label for="monto">ingrese el monto</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-money text-yellow"></i>
							                </span>
							                <input id="monto" name="monto" type="text" class="form-control" placeholder="Ingrese Monto" value="<?=$monto?>" required>
							            </div>
					                </div>
					                <div class="form-group">
					                    <label for="descripcion">Ingrese una Descripcion de Gasto</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-file text-green"></i>
							                </span>
							                <input id="descripcion" name="descripcion" type="text" class="form-control" placeholder="Descripcion" value="<?=$descripcion?>" required>
							            </div>
					                </div>
				                </div>
				                <div class="box-footer">
			                		<span id="cancelar" class="btn btn-sm btn-default btn-flat pull-left">Cancelar</span>
			                      	<button id="submit" type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Registrar</button>
			                    </div>
		                    </form> 
			            </div>
			            <div class="box box-primary">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Formulario de Reportes</h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			            	<form action="<?= $helper->url('gastos', 'ReportDay');?>" method="post">
				              	<div class="box-body">
					                <div class="form-group">
					                    <label for="fecha">Ingrese una fecha de Gasto</label>
					                    <div class="input-group">
							                <span class="input-group-addon">
							                    <i class="fa fa-calendar text-green"></i>
							                </span>
							                <input id="fecha" name="fecha" type="date" class="form-control" required>
							            </div>
					                </div>
				                </div>
				                <div class="box-footer">
				                	<a href="<?= $helper->url('gastos', 'ReportDay');?>" class="btn btn-sm btn-default btn-flat pull-left">REPORTE DEL DIA</a>
			                      	<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">EXPORTAR REPORTE</button>
			                    </div>
		                    </form> 
			            </div>
					</div>
					<div class="col-md-8">
						<div class="box box-info">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Lista de gastos</h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			              	<div class="box-body">
			                	<div class="table-responsive">  
			                		<table class="table table-bordered">
			                			<thead>
			                				<th>Nº</th>
			                				<th>RECIBE</th>
			                				<th>MONTO</th>
			                				<th>DESCRIPCION</th>
			                				<th>FECHA</th>
			                				<th>USUARIO</th>
			                			</thead>
			                			<tbody>
			                			<?php if (isset($gastos)): ?>
			                				<?php foreach ($gastos as $key => $item): ?>
			                					<tr>
				                					<td class="id_gasto" data-id="<?=$item->getIdGasto()?>"><a><?=$item->getIdGasto()?></a></td>
				                					<td><?=$item->getRecibe()?></td>
				                					<td><?=$item->getMonto()?></td>
				                					<td><?=$item->getDescripcion()?></td>
				                					<td><?=$helper->FormatDateTime($item->getFecha())?></td>
				                					<td><?=$item->getPerfilUsuario()->getNombre()?></td>
				                				</tr>
			                				<?php endforeach ?>
			                			<?php endif ?>
			                			</tbody>
			                		</table>
			                	</div>
			                </div>
			                <div class="box-footer text-center">
			                  <a href="<?= $helper->url('gastos', 'ReportDay','true');?>" class="uppercase">Exportar Reporte DomPDF</a>
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
	<?=$helper->js('eventos')?>

</body>
</html>
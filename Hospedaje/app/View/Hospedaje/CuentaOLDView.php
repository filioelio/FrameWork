<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Hospedaje - Cuenta</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<?=$helper->css('ed-grid')?>
  	<?=$helper->css('header')?>
    <?=$helper->css('ExitoError')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  	<?=$helper->css('dataTables.bootstrap')?>
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
      			<h1>Ultimas Actividades del Hospedaje</h1>
    		</section>
    		<section class="content">
				<div class="row">
	    			<div class="col-md-8"> 
	    				<div class="box box-info">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">TABLA DE RESULTADOS DE HOSPEDAJE</h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			              	<div class="box-body">
					            <table id="example1" class="table table table-bordered table-striped no-margin">
					                <thead>
						                    <tr>
							                    <th>Hab</th>
							                    <th>DNI</th>
							                    <th>Huesped</th>
							                    <th>Fecha</th>
							                    <th>Monto</th>
							                    <th>Usuario</th>			                    
						                    </tr>
					                </thead>
					                <tbody>
						                    <?php if (isset($ingresotoday) && $ingresotoday != 1): ?>
						 						<?php foreach ($ingresotoday as $key => $detalle): ?>
						 							<tr>
						 								<td><a><?=$detalle->hab?></a></td>
						 								<td><?=$detalle->dni?></td>
						 								<td><?=$detalle->huesped?></td>
						 								<td><?=$helper->FormatDateTime($detalle->fecha)?></td>
						 								<td><?=$detalle->monto?></td>
						 								<td><?=$detalle->usuario?></td>
								                    </tr>
						 						<?php endforeach ?>
						                    <?php endif ?>
					                </tbody>
					            </table>
			              	</div>
			              	<div class="box-footer text-center">
		                      	<button id="Opcionturno" class="btn btn-sm btn-default btn-flat">FINALIZAR TURNO</button>
		                    </div> 
			            </div>
	    			</div>
	    			<div class="col-md-4">
			            <div class="box box-success">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Ingreso del <?=$helper->FDToday()?></h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			              	<div class="box-body">
			              		<table class="table table-bordered">
			                    	<thead>
			                    		<th>Tipo de Ingresoo</th>
			                    		<th>Monto</th>
			                    		<th>Reportes</th>
			                    	</thead>
					                <tbody>
							            <tr>
								            <td>Ingreso Hostal:</td>
								            <td><i>s/: <?=$ingreso->hospedaje != NULL? $ingreso->hospedaje : "0.00"?> Soles</i></td>
								            <td><a class="fa fa-file-text text-orange" href="<?=$helper->url('reporte', 'RIngresoToday','hospedaje');?>"> Exportar</a></td>
							            </tr> 
							             <tr>
								            <td>Ingreso Ventas:</td>
								            <td><i>s/: <?=$ingreso->ventas != NULL? $ingreso->ventas : "0.00"?> Soles</i></td>
								            <td><a class="fa fa-file-text text-orange" href="<?=$helper->url('reporte', 'RIngresoToday','ventas');?>"> Exportar</a></td>
							            </tr> 
							            <tr>
								            <td>Ingreso Reservacion:</td>
								            <td><i>s/: <?=$ingreso->reservacion!= NULL? $ingreso->reservacion : "0.00" ?> Soles</i></td>
								            <td><a class="fa fa-file-text text-orange"  href="<?=$helper->url('reporte', 'RIngresoToday','reservacion');?>"> Exportar</a></td>
							            </tr> 
							            <tr>
								            <td>Gastos del Dia:</td>
								            <td><i>s/: <?=$ingreso->gasto != NULL? $ingreso->gasto : "0.00"?> Soles</i></td>
								            <td><a class="fa fa-file-text text-orange"  href="<?=$helper->url('reporte', 'RIngresoToday','gastos');?>"> Exportar</a></td>
							            </tr> 
							            <tr>
							            	<th>Ingreso Total</th>
							            	<th colspan="2" >s/: <span id="total"><?=$total?> </span>  <i>Nuevos Soles</i></th>
							            </tr>               
					              	</tbody>
					            </table>	
			              	</div>
			              	<div class="box-footer text-center">
			              		<a href="<?=$helper->url('reporte', 'RIngresoToday','general');?>" class="btn btn-sm btn-primary btn-flat">Exportar Reporte del Dia</a>
			                    </div> 
			            	</div>

			            <div class="box box-success">
			            	<div class="box-header with-border text-center">
			                	<h3 class="box-title text-red">Buscar Pagos del Huesped!</h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			            	<form action="<?= $helper->url('hospedaje', 'ingreso');?>" method="post">
					           	<div class="box-body">
									<div class="form-group">
										<label for="">Ingrese Nº Habitacion</label>
										<input type="text" class="form-control" placeholder="Ingrese Nº Habitacíon" maxlength="3" minlength="3" name="id_habi" required>
									</div>						
					            </div>
					            <div class="box-footer text-center">
					            	<button type="submit" class="btn btn-sm btn-primary btn-flat">Buqueda Inteligente</button>
				            	</div>
			            	</form>
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
	<?=$helper->js('jquery.dataTables.min')?> 
	<?=$helper->js('dataTables.bootstrap.min')?>
	<?=$helper->js('jquery.slimscroll.min')?>
	<?=$helper->js('variables-globales')?>
	<?=$helper->js('EventoPersonal')?>
	<?=$helper->js('sweetalert.min')?>

	<script>
		$(document).ready(function(){
		  $("#example1").DataTable();
		  $(".slimScrollDiv").css('height', '70px');
		});
	</script>

</body>
</html>
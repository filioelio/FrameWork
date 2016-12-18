<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Producto - Consumo</title>
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
</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<?=$this->view('Template/HeaderAdmin',$datos_template)?>
	    <?=$this->view('Template/NavAdmin', $datos_template)?>

	    <div class="content-wrapper">
	    	<section class="content-header">
      			<h1>Historial de Consumo Huesped</h1>
    		</section>
    		<section class="content">				
				<div class="row">
	    			<div class="col-md-8">  
			            <div class="box box-info">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Lista de Ventas de Productos</h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			              	<div class="box-body">
			                	<div class="table-responsive">          
			                  		<table id="example1" class="table table-bordered table-striped no-margin">
					                    <thead>
						                    <tr>
						                    	<th>Nº</th>
							                    <th>Huesped</th>
							                    <th>Fecha</th>
							                    <th>Total</th>
							                    <th>Deuda</th>
							                    <th>Usuario</th>
							                    <th>Detalle</th>
						                    </tr>
					                    </thead>
					                    <tbody>
						                    <?php if (isset($ventas) && $ventas != '1'): ?>
						 						<?php foreach ($ventas as $key => $venta): ?>
						 							<tr>
						 								<td class="update_venta" data-id="<?=$venta->idventa?>"><a><?=$venta->id_habitacion?></a></td>
								                        <td><?=$venta->huesped != " " ? $venta->huesped : "Venta Libre" ?></td>
								                        <td><?=$helper->FormatDateTime($venta->fecha)?></td>
								                        <td><?=$venta->total?></td>
								                        <td><?=$venta->deuda?></td>
								                        <td><?=$venta->usuario?></td>
								                        <td><span data-id="<?=$venta->idventa?>" data-toggle="modal" data-target=".ListaHuesped" class="btn bg-olive  detalle_venta">Ver Detalle</span></td>
								                    </tr>
						 						<?php endforeach ?>
						                    <?php endif ?>
					                    </tbody>
					                </table>
			                	</div>
			              	</div>
			            </div>
			        </div>
			        <div class="col-md-4">
			        	<div class="box box-primary text-center">
			                <div class="box-header with-border">
			                  	<h3 class="box-title">Formulario</h3>
			                </div>
			                <form action="<?= $helper->url('venta', 'ingreso',$_hab);?>" method="post">
			                  	<div class="box-body">
			                    	<div id="exitoerror" class="form-group">
			                      		<span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>			                      		
			                    	</div>
			                    	<div class="form-group input-group">
			                    		<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				                      	<input id="id_venta" type="text" name="id_venta" class="form-control" placeholder="Id Venta">
				                    </div>
			                    	<div class="form-group input-group">
				                    	<span class="input-group-addon"><i class="fa fa-home"></i></span>
					                      <input id="id_habitacion" type="text" class="form-control" placeholder="Habitacion" required>
					                </div>
			                    	
			                    	<div class="form-group input-group ">
			                    		<span class="input-group-addon"><i class="fa fa-user"></i></span>
				                      	<input id="huesped" type="text" class="form-control" placeholder="Datos Huesped">
				                    </div>		                    
				                    				                  
				                    <div class="form-group input-group">
				                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                        <input id="fecha_venta" type="text" placeholder="Fecha de Venta" class="form-control" required>                    
				                    </div>
				                    <div class="row ">
				                    	<div class="col-md-6">
				                    		<div class="form-group input-group">
					                      		<span class="input-group-addon"><i class="fa fa-money"></i></span>
					                      		<input id="total" type="text" class="form-control" placeholder="Total Cuenta" required>
					                      	</div>
				                    	</div>
				                    	<div class="col-md-6">
				                    		<div class="form-group input-group">
				                    			<span class="input-group-addon"><i class="fa fa-money"></i></span>
					                      		<input id="deuda" type="text" class="form-control" name="deuda" placeholder="Deuda">
					                      	</div>
				                    	</div>
				                    </div>				                      	
				                    
				                    <div class="form-group input-group">
				                    	<span class="input-group-addon"><i class="fa fa-user"></i></span>
				                     	<input id="usuario" type="text" class="form-control" placeholder="usuario venta" required>
				                    </div>
				                </div>
				                <div class="box-footer">
				                	<span id="cancelar" class="btn btn-sm btn-default btn-flat pull-left">Cancelar</span>
				                    <button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Modificar Registro</button>
				                </div>
			                </form>
			            </div>
			            <div class="box box-success">
			                <div class="box-header with-border text-center">
			                  	<h3 class="box-title">Formulario de Reportes de Venta</h3>
			                </div>
			                <form role="form" action="<?= $helper->url('reporte', 'RPVenta');?>" method="post">   
				                <div class="box-body">
				                    <div class="form-group">
				                    	<label for="">Ingrese la Fecha</label>
				                    	<div class="input-group">
						                    <span class="input-group-addon">
						                    	<i class="fa fa-calendar"></i>
						                    </span>
						                    <input type="date" class="form-control" name="fecha_reporte" placeholder="Fecha de Venta" required>
						                </div>
				                    </div>
				                </div>
					            <div class="box-footer">
					            	<a href="<?= $helper->url('reporte', 'RPVenta');?>" class="btn btn-sm btn-success btn-flat pull-left">Exportar Reporte del Dia</a>
					                <button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Generar Reporte Personalizado</button>
					            </div>
			                </form>
			            </div>
			        </div>
			    </div>
			</section>
		</div>

		<div class="modal modal-warning fade ListaHuesped" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content primary">
		            <div class="modal-header">
		               	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">×</span></button>
		                <h4 class="modal-title">DETALLE DE VENTA</h4>
		            </div>
		            <div class="modal-body">
		            	<h4 id="mensaje" class="text-center">Lista de productos</h4>		            	
		            	<div class="box-body">
		                    <table class="table table-bordered">
		                    	<thead>
		                    		<th>#</th>
		                    		<th>Nombre</th>
		                    		<th>Descripcion</th>
		                    		<th>medida</th>
		                    		<th>Precio</th>
		                    		<th>Cantidad</th>
		                    		<th>SubTotal</th>
		                    	</thead>
				                <tbody id="colum_lista">
						            		                
				              	</tbody>
				            </table>
				        </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Salir</button>
		                <button type="button" class="btn btn-outline" data-dismiss="modal">Salir</button>
		            </div>
				</div>
				
			</div>
		</div>

		<?=$this->view('Template/FooterAdmin')?>
 		<?=$this->view('Template/Asidebar')?>
	</div>	
	<?=$helper->js('jQuery-2.2.0.min')?>
	<?=$helper->js('bootstrap.min')?>
	<?=$helper->js('jquery.dataTables.min')?> 
  	<?=$helper->js('dataTables.bootstrap.min')?>
  	<?=$helper->js('jquery.slimscroll.min')?>
  	<?=$helper->js('fastclick.min')?>
	<?=$helper->js('app.min')?>	
	<?=$helper->js('variables-globales')?>	
	<?=$helper->js('NewEvento')?>

	<script>
	  $(function () {
	    $("#ventalibre").DataTable();
	    $("#example1").DataTable();
	    $(".slimScrollDiv").css('height', '70px');

	  });
	  
	</script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Producto - Lista</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<?=$helper->css('ed-grid')?>
  	<?=$helper->css('header')?>
	<?=$helper->css('bootstrap.min')?>
    <?=$helper->css('ExitoError')?>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  	<?=$helper->css('select2.min')?>
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>
	<?=$helper->css('sweetalert')?>
	<?=$helper->css('checkbox')?>
	
	<style>
		.content-header>.breadcrumb{
			border: 1px solid #000;
			border-radius: 2px;
			font-size: 1em;
		}
	}
	</style>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<?=$this->view('Template/HeaderAdmin',$datos_template)?>
	    <?=$this->view('Template/NavAdmin', $datos_template)?>

	    <div class="content-wrapper">
	    	<section class="content-header">
      			<h1>Lista de Productos <small></small></h1>
      			<ol class="breadcrumb" data-toggle="modal" data-target=".bs-example-modal-lg">
      				<li><a><i class="fa fa-cart-plus"></i> Ver Carrito</a></li>
      			</ol>
    		</section>
    		<section class="content">
			  <!-- Info boxes -->
		      <div class="row">
		      	<?php if (isset($productos)): ?>		      	
			      	<?php foreach ($productos as $key => $producto): ?>
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box bg-<?=@$helper->color()?>">
				            <span class="info-box-icon "><img src="<?= $producto->getFoto(true) != NULL ? $producto->getFoto(true) : $helper->base_url().'/img/logo.png' ?>" alt=""></span>
				            <div class="info-box-content">
				              <span class="info-box-number"><?=$producto->getNombre()?> <span class="label label-warning pull-right">$<?=$producto->getPrecio()?></span></span>
				              <span class="info-box-text"><?=$producto->getDescripcion()?> - <small><?=$producto->getMedida()?></small></span>
				              <span>Cantida: <?=$producto->getStock()?></span>
				              <a data-id='<?=$producto->getIdProducto()?>' class="agregar btn btn-block btn-default btn-xs fa fa-cart-plus"> Añadir al carrito</a>
				            </div>
				          </div>
				        </div>
					<?php endforeach ?>
		      	<?php endif ?>
		      </div>
			</section>
		</div>
		<div class="modal modal-primary fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content primary">
		            <div class="modal-header">
		               	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">×</span></button>
		                <h4 class="modal-title">Carrito de Compras</h4>
		            </div>
		            <div class="modal-body">
		            	<div class="col-md-12 no-padding"> 
				        	<div class="box box-primary">
			                	<div class="box-header with-border bg-blue text-center">
			                  		<h3 id="mensaje" class="box-title">Opciones de Venta</h3>
			                  		<div class="box-tools pull-right">
			                    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			                    		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			                  		</div>
			                	</div>
			                	<div class="box-body bg-blue">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<div class="row">
									      			<div class="col-md-6 no-padding-left">
														<div class="input-group">
													      	<input id="id_habitacion"  type="text" class="form-control" placeholder="Nro Habitacion" maxlength="3" minlength="3">
												      	</div>
									      			</div>
									      			<div class="col-md-6">
									      				<div class="input-group">
													      	<input  id="monto" readonly type="text" class="form-control" placeholder="00.00 Soles">
												      	</div>
									      			</div>
									      		</div>
												
									      	</div>
									      	<div id="checkbox" class="form-group no-padding text-center">
									      		<input type="checkbox" id="check">
												<label for="check"></label>
									      	</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<span class="btn bg-orange">Nombre: <i id="huesped"></i></span>
											</div>
											<div class="form-group">
												<span class="btn bg-maroon">Deuda Anterios : <i id="deuda_anterior"></i></span>
											</div>
			
										</div>
										<div class="col-md-4">											
											<div class="form-group">
												<span id="fecha_ingreso" class="btn bg-olive">Fecha Ingreso</span>
											</div>
											<div class="form-group">
												<span id="fecha_salida" class="btn bg-purple">Fecha salida</span>
											</div>
										</div>
									</div>
			                	</div>
			                </div>            
				        </div>
		            	<div class="box-body">
		                    <table id="tabla_carrito" class="table table-bordered">
		                    	<thead>
		                    		<th>#</th>
		                    		<th>id</th>
		                    		<th>Nombre</th>
		                    		<th>Descripcion</th>
		                    		<th>Precio</th>
		                    		<th>Cantidad</th>
		                    		<th>SubTotal</th>
		                    		<th>Opcion</th>
		                    	</thead>
				                <tbody id="colum_lista">
						            		                
				              	</tbody>

				            </table>
				            <h4 class="text-center" >Total a Cobrar s/: <span id="total"></span> soles</h4>
				        </div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Salir</button>
		                <button id="registrar" type="button" class="btn btn-outline">Registrar Venta</button>
		            </div>
				</div>
				
			</div>
		</div>

		<!-- <button onclick="setTimeout('saludo()',3000);">Saludo a los 3 segundos</button> -->

		<?=$this->view('Template/FooterAdmin')?>
 		<?=$this->view('Template/Asidebar')?>
	</div>	
	<?=$helper->js('jQuery-2.2.0.min')?>
	<?=$helper->js('bootstrap.min')?>	
	<?=$helper->js('app.min')?>	
	<?=$helper->js('sweetalert.min')?>
	<?=$helper->js('variables-globales')?>	
	<?=$helper->js('Producto')?>
	<?=$helper->js('carrito')?>	
	<!-- <script>
		$("#Salir").on('click', function(){
			setTimeout(saludo,3000);
		});

		function saludo(){
			 alert("has hecho click en salir");
			}
	</script> -->


</body>
</html>
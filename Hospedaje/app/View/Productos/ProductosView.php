<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Producto</title>
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
      			<h1>Formulario <small>Registrar, modificar Productos</small></h1>
    		</section>

    		<section class="content">
    			<div class="row">
	    			<div class="col-md-8">  
			            <div class="box box-info">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Productos</h3>
				                <div class="box-tools pull-right">
				                  	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				                  	<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				                </div>
			            	</div>
			              	<div class="box-body">
			                	<div class="table-responsive">          
			                  		<table id="example1" class="table table table-bordered table-striped no-margin">
					                    <thead>
						                    <tr>
							                    <th>ID.</th>
							                    <th>Nombre</th>
							                    <th>Descripcion</th>
							                    <th>Medida</th>
							                    <th>Precio</th>
							                    <th>Stock</th>
							                    <th>Foto</th>
						                    </tr>
					                    </thead>
					                    <tbody>
						                    <?php if (isset($productos)): ?>
						 						<?php foreach ($productos as $key => $producto): ?>
						 							<tr>
								                        <td class="id_producto" data-id="<?=$producto->getIdProducto()?>"><a><?=$producto->getIdProducto()?></a></td>
								                        <td><?=$producto->getNombre()?></td>
								                        <td><?=$producto->getDescripcion()?></td>
								                        <td><?=$producto->getMedida()?></td>
								                        <td><?=$producto->getPrecio()?></td>
								                        <td><?=$producto->getStock()?></td>
								                        <td><?=$producto->getFoto()?></td>
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
			                  	<h3 class="box-title">Formulario de Registro</h3>
			                </div>
			                <form id="url_producto" role="form" action="<?= $helper->url('producto', 'registro');?>" method="post"  enctype="multipart/form-data">
			                  	<div class="box-body">
			                    	<div id="exitoerror" class="form-group">
			                      		<span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>
			                    	</div>
			                    	<div class="form-group">
				                      	<input id="id" type="text" class="form-control" name="id_producto" readonly>
				                    </div>
				                    <div class="form-group">
				                      	<input id="nombre" type="text" class="form-control" value="<?=$nombre?>" name="nombre" placeholder="Nombre" required>
				                    </div>
				                    <div class="form-group">
				                      	<textarea id="descripcion" type="text" class="form-control" name="descripcion" placeholder="Descripcion de las Carracteristicas" required><?=$descripcion?></textarea>
				                    </div>
				                    <div class="form-group">
				                     	<select id="medida" class="form-control" value="<?=$medida?>" name="medida" style="width: 100%;">
						                	<option value="Unidad">Unidad</option>
						                  	<option value="Litros">Litros</option>
						                  	<option value="ML">ML</option>
						                </select>
				                    </div>

				                    <div class="form-group input-group">
				                        <span class="input-group-addon"><i class="fa fa-money text-yellow"></i></span>
				                        <input id="precio" type="text" class="form-control" name="precio" placeholder="Ingrese el precio del producto" value="<?=$precio?>" required>
				                        <span class="input-group-addon"><i class="fa fa-ambulance"></i></span>
				                    </div>
				                    <div class="form-group">
				                      	<input id="stock" type="text" class="form-control" value="<?=$stock?>" name="stock" placeholder="Ingrese la cantidad" required>
				                    </div>
				                    <div class="form-group">
				                      	<span id="file_class" class="btn btn-primary btn-file">
				                          Seleccione Imagen  producto<input id="file" name="foto" type="file">
				                        </span>
				                    </div>
				                    <img id="foto_producto" src="" alt="">
				                </div>
				                <div class="box-footer">
				                	<span id="cancelar" class="btn btn-sm btn-default btn-flat pull-left">Cancelar</span>
				                    <button id="submit" type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Registrar</button>
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
  	<?=$helper->js('fastclick.min')?>
	<?=$helper->js('app.min')?>	

	<?=$helper->js('variables-globales')?>	
	<?=$helper->js('eventos')?>	
	<script>
	$(function () {
		$(".slimScrollDiv").css('height', '70px');
		$('#file').on('change', function(){
	        if($(this).val()!= ""){ 
	          	$( "#file_class" ).removeClass().addClass( "btn btn-success btn-file" );
	        } else {
	        	$( "#file_class" ).removeClass().addClass( "btn btn-default btn-file" ); 
	        }
	    });
	});

	</script>

</body>
</html>
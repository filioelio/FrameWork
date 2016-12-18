<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Lista Huesped</title>
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
      			<h1>Formulario Huesped<small>Registrar, modificar Huesped</small></h1>
    		</section>

    		<section class="content">
    			<div class="row">
	    			<div class="col-md-8">  
			            <div class="box box-info">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Lista de Huesped</h3>
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
							                    <th>Apellido</th>
							                    <th>Origen</th>
							                    <th>Telefono</th>
							                    <th>Conducta</th>
						                    </tr>
					                    </thead>
					                    <tbody>
						                    <?php if (isset($huespeds)): ?>
						 						<?php foreach ($huespeds as $key => $huesped): ?>
						 							<tr>
								                        <td class="id_huesped" data-id="<?=$huesped->getIdHuesped()?>"><a><?=$huesped->getIdHuesped()?></a></td>
								                        <td><?=$huesped->getNombre()?></td>
								                        <td><?=$huesped->getApellido()?></td>
								                        <td><?=$huesped->getProcedencia()?></td>
								                        <td><?=$huesped->getTelefono()?></td>
								                        <td><?=$huesped->getConducta()?></td>
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
			                <form id="url_huesped" role="form" action="<?= $helper->url('huesped', 'registro');?>" method="post"  enctype="multipart/form-data">
			                  	<div class="box-body">
			                    	<div id="exitoerror" class="form-group">
			                      		<span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>
			                    	</div>
			                    	<div class="form-group">
				                      	<input id="dni" type="text" class="form-control" value="<?=$id?>" placeholder="Nº DNI" name="id" maxlength="8" minlength="8" required>
				                    </div>
				                    <div class="form-group">
				                      	<input id="nombre" type="text" class="form-control" value="<?=$nombre?>" name="nombre" placeholder="Nombre" required>
				                    </div>
				                    <div class="form-group">
				                      	<input id="apellido" type="text" class="form-control" value="<?=$apellido?>" name="apellido" placeholder="Apellido" required>
				                    </div>
				                    <div class="form-group">
				                      	<input id="origen" type="text" class="form-control" value="<?=$procedencia?>" name="procedencia" placeholder="Procedencia" required>
				                    </div>
				                    <div class="form-group input-group">
					                  	<div class="input-group-addon">
					                    	<i class="fa fa-phone"></i>
					                  	</div>
					                  	<input id="telefono" type="text" class="form-control" name="telefono" placeholder="Nº Telefono" value="<?=$telefono?>" maxlength="9" minlength="9" >
					                </div>

				                    <div class="form-group">
				                      	<select id="conducta" class="form-control"  value="<?=$conducta?>" style="width: 100%;" name="conducta">
						                	<option value="Agradable">Agradable</option>
						                	<option value="Desagradable">Desagradable</option> 	
						                </select>
				                    </div>
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
	    $("#example1").DataTable();
	    $(".slimScrollDiv").css('height', '70px');
	  });

	  $('#cancelar').on('click', function(){
		   document.getElementById("dni").readOnly = false;
		});
	</script>

</body>
</html>
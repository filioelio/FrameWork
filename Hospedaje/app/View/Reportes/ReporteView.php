<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Reporte</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<?=$helper->css('ed-grid')?>
  	<?=$helper->css('header')?>
    <?=$helper->css('ExitoError')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  	<?=$helper->css('dataTables.bootstrap')?>
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
      			<h1>Formulario de Reportes</h1>
    		</section>
    		<section class="content">
				<div class="row">
			        <div class="col-md-9">
			            <div class="box box-info">
			                <div class="box-header with-border">
			                  	<h3 class="box-title">Lista de Resultados</h3>
			                  	<div class="box-tools pull-right">
				                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
				                    </button>
				                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
				                    </button>
			                  	</div>
			                </div>
			                <div class="box-body">
			                  <table id="example1" class="table table-bordered table-striped no-margin">
			                  	<thead>
				                  	<?php foreach($cabezeras as $cabezera): ?>
						    			<th><?=$cabezera?></th>
									<?php endforeach; ?>
			                  	</thead>
			                  	<tbody>
			                  		<?php if (isset($reporte) && $reporte != 1): ?>
				                  		<?php foreach($reporte as $item_reporte): ?>
						    				<tr>
									      		<?php foreach($cabezeras as $cabezera): ?>
									      			<?php if ($cabezera == 'fecha' || $cabezera == 'fecha_ingreso' || $cabezera == 'fecha_salida'): ?>
									      				<td><?=$helper->FormatDateTime($item_reporte->$cabezera)?></td>
									      			<?php else: ?>
														<td><?=$item_reporte->$cabezera != " " ? $item_reporte->$cabezera : "Venta Libre"?></td>
													<?php endif ?>												
												<?php endforeach; ?>
						    				</tr>
										<?php endforeach; ?>
			                  		<?php endif ?>
			                  		
			                  	</tbody>
			                  </table>
			                </div>
			                <div class="box-footer text-center">
			                	<?php if (isset($reporte[0]->total)): ?>
			                	  	<h4 class="uppercase">Total : <?=$reporte[0]->total?> 
			                	<?php endif ?>
			                  	&copy; <i><?php if (isset($reporte[0]->ingresoneto)): ?>
			                  		Ingreso neto : <?=$reporte[0]->ingresoneto?>
			                  	<?php endif ?> </i></h4>
			                </div>
			            </div>
			        </div>
			          <!-- /.col -->
			        <div class="col-md-3">
			            <div class="box box-primary">
			                <div class="box-header with-border text-center">
			                  <h3 class="box-title">Opciones de Generar Reporte</h3>
			                </div>
			                <form id="url" role="form" action="<?= $helper->url('reporte', 'reporte');?>" method="post" name="registro" enctype="multipart/form-data">
			                  	<div class="box-body">
			                    	<div id="exitoerror" class="form-group text-center">
			                      		<span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>
			                    	</div>
			                    	<div class="form-group">
						                <label>Opciones de Generar Reporte</label>
						                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" name="opcion" aria-hidden="true">
											<option value="hostal">Reporte de Hospedaje</option>
			                       			<option value="productos">Reporte de Venta</option>
			                       			<option value="dventa">Reporte de Detalle Venta</option>
						                </select>
						            </div> 
						            <div class="form-group">
						                <label>Usuario</label>
						                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" name="usuario" tabindex="-1" aria-hidden="true">
						                	<option value="">Busqueda Libre</option>
						                	<?php foreach ($usuarios as $key => $item): ?>
						                		<?php if ($item->getEstado()!='Inactivo'): ?>        	
						                			<option value="<?=$item->getIdUsuario()?>"><?=$item->getNombre()." ". $item->getApellido()?></option>
						                		<?php endif ?>
						                	<?php endforeach ?>						                  	
						                </select>
						            </div>   
			                    	<div class="form-group">
								      	<label>Fecha Inicio</label>
								      	<div class="input-group">
									      	<div class="input-group-addon">
						                        <i class="fa fa-calendar"></i>
						                     </div>
									      	<input  type="date" class="form-control"  name="inicio" required>
								      	</div>
								    </div> 
								    <div class="form-group">
								      	<label>Fecha Fin</label>
								      	<div class="input-group">
									      	<div class="input-group-addon">
						                        <i class="fa fa-calendar"></i>
						                     </div>
									      	<input type="date" class="form-control"  name="fin" required>
								      	</div>
								    </div> 			             			                    	   
			                  	</div>
			                  	<div class="box-footer">
			                  		<a class="btn btn-sm btn-default btn-flat pull-left" href="<?=$helper->url('reporte', 'renderPDF')?>">Generar DomPDF</a>
	
			                    	<button id="submit" type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Generar Reporte</button>
			                    </div>
			                </form>
			            </div>
			            <div class="box box-primary">
			                <div class="box-header with-border text-center">
			                  <h3 class="box-title">Generar Reportes Completos</h3>
			                </div>
			                <div class="box-body">
			                	<div class="row">
			                		<div class="col-md-6">
			                			<div class="form-group">
			                				<a href="<?=$helper->url('reporte','RGenral','Hospedaje')?>" class="btn bg-orange btn-flat">Rep Hospedaje</a>
										</div> 
			                		</div>
			                		<div class="col-md-6">
			                			<div class="form-group">
			                				<a href="<?=$helper->url('reporte','RGenral','venta')?>" class="btn bg-navy btn-flat">Rep Productos</a>
										</div> 
			                		</div>
			                	</div>
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
	<?=$helper->js('jquery.dataTables.min')?> 
  	<?=$helper->js('dataTables.bootstrap.min')?>
	<?=$helper->js('select2.full.min')?>
	<?=$helper->js('app.min')?>	

	<script>
	  $(function () {
	    $("#example1").DataTable();
	    $(".select2").select2();
	    $(".slimScrollDiv").css('height', '70px');
	  });
	  
	</script>
</body>
</html>
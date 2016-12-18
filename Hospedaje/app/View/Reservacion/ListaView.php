<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Historial-Reservacion</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?=$helper->css('ed-grid')?>
  	<?=$helper->css('header')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">	
  	<?=$helper->css('dataTables.bootstrap')?>
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>
	<!-- <?=$helper->css('_all-skins.min')?> -->

</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<?=$this->view('Template/HeaderAdmin',$datos_template)?>
	    <?=$this->view('Template/NavAdmin', $datos_template)?>

	    <div class="content-wrapper">
	    	<section class="content-header">
      			<h1>Historial <small>de Reservaciones</small></h1>
    		</section>

    		<section class="content">
    			<div class="row">
	    			<div class="col-md-12">  
			            <div class="box box-info">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Lista de Reservaciones</h3>
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
							                    <?php foreach ($cabezeras as $key => $cabezera): ?>
							                    	<th><?=$cabezera?></th>
							                    <?php endforeach ?>	
						                    </tr>
					                    </thead>
					                    <tbody>
						                    <?php if (isset($reservacion) && $reservacion != 1): ?>
						 						<?php foreach ($reservacion as $key => $detalle): ?>
						 							<tr>
								                        <?php foreach ($cabezeras as $key => $cabezera): ?>
						 									<?php if ($cabezera == "fecha_ingreso" || $cabezera == "fecha_salida" ): ?>
						 										<td><?=$helper->FormatDate($detalle->$cabezera)?></td>	
						 									<?php elseif ($cabezera == "fecha_reserva"): ?>
						 										<td><?=$helper->FormatDateTime($detalle->$cabezera)?></td></td>
						 									<?php else: ?>
						 										<td><?=$detalle->$cabezera?></td>	
						 									<?php endif ?>	
						 								<?php endforeach ?> 
								                    </tr>
						 						<?php endforeach ?>
						                    <?php endif ?>
					                    </tbody>
					                </table>
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
  	<?=$helper->js('jquery.slimscroll.min')?>
  	<?=$helper->js('fastclick.min')?>
	<?=$helper->js('app.min')?>	

	<script>
	  $(function () {
	    $("#example1").DataTable();
	   	$(".slimScrollDiv").css('height', '70px');
	  });
	</script>

</body>
</html>
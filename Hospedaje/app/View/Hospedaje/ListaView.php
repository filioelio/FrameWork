<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Historial-Hospedaje</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?=$helper->css('ed-grid')?>
  	<?=$helper->css('header')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  	
  	<?=$helper->css('dataTables.bootstrap')?>
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>
	<style>
		#img_habi{
			width: 70%;
		}
		.cabeceramio{

			box-shadow: 0px 0px 15px rgba(0,0,0,.9);
			padding: 5px;
			margin-bottom: .5em;
		}
		.cabeceramio h4{
			font-family: "Times New Roman", Times, serif;
			font-weight: bold;
			font-variant: small-caps;
			color: #000 !important;
		}
		.cabeceramio h4 span{
			font-weight: bold;
  			font-style: normal;
		}

	</style>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
	<div class="wrapper">
		<?=$this->view('Template/HeaderAdmin',$datos_template)?>
	    <?=$this->view('Template/NavAdmin', $datos_template)?>

	    <div class="content-wrapper">
	    	<section class="content-header">
      			<h1>Formulario de Hospedaje <small>lista de  Hospedados</small></h1>
    		</section>

    		<section class="content">
    			<div class="row">
	    			<div class="col-md-12">  
			            <div class="box box-info">
			            	<div class="box-header with-border">
			                	<h3 class="box-title">Lista</h3>
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
							                    <th>Hab</th>
							                    <th>DNI</th>
							                    <th>Huesped</th>
							                    <th>Origen</th>
							                    <th>Motivo</th>
							                    <th>Fecha Ingreso</th>
							                    <th>Fecha Salida</th>
							                    <th>Usuario</th>
							                    <th>Ver</th>				                    
						                    </tr>
					                    </thead>
					                    <tbody>
						                    <?php if (isset($hospedaje) && $hospedaje != 1): ?>
						 						<?php foreach ($hospedaje as $key => $detalle): ?>
						 							<tr>
						 								<td><?=$detalle->hab?></td>
						 								<td><?=$detalle->dni?></td>
						 								<td><?=$detalle->huesped?></td>
						 								<td><?=$detalle->origen?></td>
						 								<td><?=$detalle->motivo?></td>
						 								<td><?=$helper->FormatDateTime($detalle->fecha_ingreso)?></td>
						 								<td><?=$helper->FormatDateTime($detalle->fecha_salida)?></td>
						 								<td><?=$detalle->usuario?></td>
						 								<?=$helper->EstadoHospedaje($detalle->id_hosp, $detalle->fecha_salida)?>
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

		<div class="modal modal-warning fade DatosHuesped" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content primary">
		            <div class="modal-header">
		               	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">×</span></button>
		                <h4 class="modal-title">Datos del Hospedaje</h4>
		            </div>
		            <div class="modal-body">
		            	<div class="box-body">
			            	<div class="row cabeceramio">
				                <div class="col-md-12 text-center cabeceramio">
									<div class="col-md-4">
										<img id="img_habi"  class="img-responsive img-rounded" alt="Responsive image">
									</div> 
									<div class="colm-md-8">
										<h4><i>Datos del Hospedaje - Enacnto del Ampay</i></h4>
										<h4>Usuario : <i id="usuario"></i></h4>
										<h4><i><?=$helper-> FDTToday()?></i></h4>
									</div>
								</div> 
								<div class="col-md-6 ">
									<h4>Señor (es) <i id="huesped"></i></h4>
									<h4>Procedencia : <i id="procedencia"></i></h4>
									<h4>Fecha Ingreso : <i id="f_ingreso"></i> </h4>
									<h4>Nº Habitacion : <i id="n_habi"></i></h4>
									<h4>Costo Habitacion : <i id="cos_habi"></i></h4>
									<h4>Adelanto : <i id="adelanto"></i></h4>
									<h4>Total a Cancelado : <i id="total"></i></h4>
								</div> 
								<div class="col-md-6 ">
									<h4>DNI : <i id="dni"></i></h4>
									<h4>Telefono : <i id="telefono"></i></h4>
									<h4>Fecha Salida : <i id="f_salida"></i></h4>
									<h4>Tipo Habitacion : <i id="tipo"></i></h4>
									<h4>Total Dias : <i id="cant_dias"></i></h4>
									<h4>Deuda : <i id="deuda"></i></h4>
								</div> 
							
							</div>
		                </div>
		            	
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Salir</button>
		                 <button type="button" class="btn btn-outline">Generar Factura</button>
		                <button type="button" class="btn btn-outline">Generar Boleta</button>
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
  	<?=$helper->js('eventos')?> 	

	<script>
	  $(function () {
	    $("#example1").DataTable();
	     $(".slimScrollDiv").css('height', '70px');
	  });
	</script>

</body>
</html>
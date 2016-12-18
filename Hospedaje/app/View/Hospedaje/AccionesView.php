<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Hospedaje - Accion</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<?=$helper->css('ed-grid')?>
  	<?=$helper->css('header')?>
    <?=$helper->css('ExitoError')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>

	<style>
		#img_habi{
			width: 70%;
		}
		.box-style{
			background: rgba(60, 141, 188, 0.14);
		}
		.cabeceramio{
			margin: 5px auto;
			box-shadow: 0px 0px 15px rgba(0,0,0,9) inset;
			padding: 5px;
			margin-bottom: .5em;
			background: #3c8dbc;
		}
		.cabeceramio h4{
			font-family: "Times New Roman", Times, serif;
			font-weight: bold;
			font-variant: small-caps;
			color: #fff !important;
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
      			<h1>Cuesta Hospedaje</h1>
    		</section>
    		<section class="content">
				<div class="row">
					<div class="col-md-8"> 
						<div class="box box-primary">
							<div class="box-header with-border">
		                  		<h3 class="box-title">Datos de Hospedaje &copy; Datos Huesped</h3>
		                  		<div class="box-tools pull-right">
		                    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                    		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		                  		</div>
		                	</div>
		                	<div class="box-body box-style">
		                		<div class="row cabeceramio">
				                <div class="col-md-12 text-center cabeceramio">
									<div class="col-md-4">
										<img src="<?=$helper->Foto($hospedaje->foto)?>" class="img-responsive img-rounded" alt="Responsive image">
									</div> 
									<div class="colm-md-8">
										<h4><i>Datos del Hospedaje</i></h4>
										<h4><i>Enacnto del Ampay</i></h4>
										<h4><i>Abancay <?=$helper-> FDToday()?></i></h4>
									</div>
								</div> 
								<div class="col-md-6 ">

								    <h4>Señor (es) <i><?=$hospedaje->huesped?></i></h4>
									<h4>Procedencia : <i><?=$hospedaje->procedencia?></i></h4>
								    <h4>Fecha Ingreso : <i><?=$helper->FormatDateTime($hospedaje->fecha_ingreso)?></i></h4>
								    <h4>Nº Habitacion : <i><?=$hospedaje->id_habitacion?></i></h4>
								    <h4>Costo Habitacion : <i><?=$hospedaje->precio?></i></h4>
									<h4>Adelanto : <i><?=$hospedaje->adelanto?></i></h4>
									<h4>Total a Cancelado : <i id="total"><?=$hospedaje->total?></i></h4>
								</div> 
								<div class="col-md-6 ">
									<h4>DNI : <i><?=$hospedaje->dni?></i></h4>
									<h4>Telefono : <i><?=$hospedaje->telefono?></i></h4>
									<h4>Tipo Habitacion : <i><?=$hospedaje->tipo?></i></h4>
									<h4>Total Dias : <i><?=$hospedaje->cant_dias?></i></h4>
									<h4>Deuda : <i><?=$hospedaje->deuda?></i></h4>
								</div> 
							
							</div>
							</div>
							<div class="box-footer">
		                		<span id="cancelar" class="btn btn-sm btn-default btn-flat pull-left">Cancelar</span>
		                      	<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">GENERAR REPORTE</button>
		                    </div> 
						</div>
					</div>
					<div class="col-md-4"> 
						<div class="box box-solid">
							<div class="box-header with-border">
				              	<h3 class="box-title">Cuenta del Huesped</h3>
				            </div>
				            <div class="box-body">
				            	<div id="exitoerror" class="form-group text-center">
			                      	<span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>
			                    </div>
				            	<div class="row">
									<div class="col-md-6">
										<div class="form-group">
										    <label for="dh">Deuda de Hospedaje</label>
										    <div class="input-group">
										     	<div class="input-group-addon">
								                    <i class="fa fa-money text-yellow"></i>
								                </div>
											    <button type="button" class="btn bg-orange btn-flat">S/: <?=$hospedaje->deuda?> Soles</button>
										    </div>
										</div>
									</div>
									<div class="col-md-6">
										<form action="<?= $helper->url('hospedaje', 'accion', $hospedaje->id_habitacion)?>" method="post">
											<div class="form-group">
												<label for="deuda_hosp">Ingrese Monto</label>	
								              	<div class="input-group">
								                	<input id="deuda_hosp" name="deuda_hosp" type="text" class="form-control" placeholder=" s/: Monto">
								                	<div class="input-group-btn">
								                		<button type="submit" class="btn btn-primary btn-flat">Agregar</button>
								                	</div>
								              	</div>
											</div>
									    </form>
									</div>
								</div>
				              	<div class="row">
				              		<div class="col-md-6">
										<div class="form-group">
										    <label for="dh">Deuda de Productos</label>
										    <div class="input-group">
										     	<div class="input-group-addon">
								                    <i class="fa fa-money text-yellow"></i>
								                </div>
											    <button type="button" class="btn bg-orange btn-flat">S/: <?=$venta_pro->deuda?> Soles</button>
										    </div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
										    <label for="dp">Ir a Venta de Productos</label>
										    <div class="input-group">
												<div class="input-group-addon">
								                    <i class="fa fa-tripadvisor text-red"></i>
								                </div>
											    <a href="<?= $helper->url('venta', 'ingreso',$hospedaje->id_habitacion)?>" class="btn bg-orange btn-flat">Ir a Cancelar</a>
										    </div>
										</div>
									</div>
				              	</div>
				            </div>
				            <form action="<?= $helper->url('hospedaje', 'accion', $hospedaje->id_habitacion)?>" method="post">
					            <div class="box-footer text-center">
			                      	<button type="submit" name="finalizar" value="finalizar" class="btn btn-sm btn-danger btn-flat">Finalizar Hospedaje Ahora</button>
			                    </div> 
				            </form>
				        </div>
		                <div class="box box-primary">
		                	<div class="box-header with-border">
		                  		<h3 class="box-title">Formulario de Negociacion</h3>
		                  		<div class="box-tools pull-right">
		                    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                    		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		                  		</div>
		                	</div>
		                	<div class="box-body">
		                		<div class="row">
									<div class="col-md-6">
										<div class="form-group">
									      	<label>Generar Boleta</label>
									      	<div class="input-group">
										      	<div class="input-group-addon">
							                        <i class="fa fa-file-text text-yellow"></i>
							                    </div>
										      	<button type="button" class="btn bg-purple btn-flat"> Generar  Boleta</button>
									      	</div>
									    </div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
									      	<label for="ad">Agregar Detalle Consumo</label>
									      	<div class="input-group">
												<div class="input-group-addon">
							                        <i class="fa fa-tripadvisor text-purple"></i>
							                    </div>
										      	<button id="ap" type="button" class="btn bg-olive btn-flat">Agregar Detalle</button>
									      	</div>
									    </div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
									      	<label>Generar Factura</label>
									      	<div class="input-group">
										      	<div class="input-group-addon">
							                        <i class="fa fa-file-text text-yellow"></i>
							                    </div>
										      	<button type="button" class="btn bg-navy btn-flat">Generar Factura</button>
									      	</div>
									    </div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
									      	<label for="qd">Quitar Detalle Consumo</label>
									      	<div class="input-group">
												<div class="input-group-addon">
							                        <i class="fa fa-tripadvisor text-red"></i>
							                    </div>
										      	<button id="qd" type="button" class="btn bg-orange btn-flat">Eliminar Detalle</button>
									      	</div>
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
	<?=$helper->js('app.min')?>	
</body>
</html>
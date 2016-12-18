<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Registrar Reservacion</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?=$helper->css('ed-grid')?>
	<?=$helper->css('header')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<?=$helper->css('select2.min')?>
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>
	<?=$helper->css('ExitoError')?>
	<?=$helper->css('sweetalert')?>

</head>
<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">
	<?=$this->view('Template/HeaderAdmin',$datos_template)?>
	<?=$this->view('Template/NavAdmin', $datos_template)?>
	<div class="content-wrapper">
		<section class="content-header">
      		<h1>Formulario<small>Registro de Reservaciones</small></h1>
    	</section>

    <section class="content">
    	<div class="row">
    	  <form action="<?= $helper->url('reservacion', 'registro',$nro);?>" method="post">
	    	<div class="col-md-4"> 
	    		<div class="box box-primary">
                	<div class="box-header with-border">
                  		<h3 class="box-title">Datos de Habitacion</h3>
                  		<div class="box-tools pull-right">
                    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  		</div>
                	</div>
                	<div class="box-body">
						<div class="form-group">
				            <label>Nº Habitacion</label>
				            <input id="search_habitacion" class="form-control" type="text" name="id_habi" value="<?=$nro?>" >
				        </div>
						<div class="form-group">
							<img id="imagen" src="<?=$room->getFoto(true) != NULL ? $room->getFoto(true) : $helper->base_url().'/img/Habitacion/template.jpg' ?>" alt="">
						</div>
						<div class="form-group">
							<h4 class="text-center">CARACTERISTICAS</h4>		
							<h4>tipo: <span id="tipo" class="label pull-right bg-yellow"><?=$room->getTipo()?></span></h4>
							<h4>descr: <span id="descripcion" class="label pull-right bg-blue"><?=$room->getDescripcion()?></span></h4>
							<h4>estado: <span id="estado" class="label pull-right bg-green"><?=$room->getEStado()?></span></h4>
							<h4>precio: <span id="precio" class="label pull-right bg-red"><?=$room->getPrecio()?></span></h4>
						</div>
                	</div>
                </div>               
            </div> 

	        <div class="col-md-4"> 
	        	<div class="box box-primary">
                	<div class="box-header with-border">
                  		<h3 class="box-title">Perfil Huesped</h3>
                  		<div class="box-tools pull-right">
                    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  		</div>
                	</div>
                	<div class="box-body">
						<div class="form-group">
						    <label>Ingrese Dni</label>
						 	<input id="dni" type="text" class="form-control" placeholder="Nº DNI" value="<?=$dni?>" name="dni" minlength="8" maxlength="8" required >
						</div>
					    <div class="form-group">
						    <label>Nombre</label>
						    <input id="nombre" type="text" class="form-control" placeholder="Nombre" value="<?=$nombre?>" name="nombre" required >
					    </div>
					    <div class="form-group">
						    <label>Apellido</label>
						    <input id="apellido" type="text" class="form-control" placeholder="Apellido" value="<?=$apellido?>" name="apellido" required>
						</div>
						<div class="form-group">
						    <label>Procedencia</label>
						    <input id="origen" type="text" class="form-control" placeholder="Procedencia" value="<?=$origen?>" name="origen" required>
						</div>
                		<div class="form-group">
						    <label>Telefono</label>
						    <div class="input-group">
		                      	<div class="input-group-addon">
		                        	<i class="fa fa-phone text-green"></i>
		                      	</div>
						    	<input id="telefono" type="text" class="form-control" placeholder="Telefono" value="<?=$telefono?>" name="telefono" minlength="6" maxlength="9" required>
						    </div>
						</div>
						<div class="form-group">
						    <label>Conducta Huesped</label>
						    <select id="conducta" class="form-control" value="<?=$conducta?>" style="width: 100%;" name="conducta">
						        <option value="Agradable">Agradable</option>
						        <option value="Desagradable">Desagradable</option> 	
						    </select>
						</div> 
                	</div>
                </div>            
	        </div>

	        <div class="col-md-4">	
	        	<div class="box box-primary">
                	<div class="box-header with-border">
                  		<h3 class="box-title">Condiciones Reservacion</h3>
                  		<div class="box-tools pull-right">
                    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    		<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  		</div>
                	</div>
                	<div class="box-body">
                		<div id="exitoerror" class="form_grupo text-center">
			          		<span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>
			        	</div>
                		<div class="form-group">
						 	<label>Descripcion de Reserva</label>
						 	<input id="descripcion" type="text" class="form-control" name="descripcion" placeholder="Descripción" value="<?=$descripcion?>" required>
						</div> 
						<div class="form-group">
					      	<label>Fecha Ingreso</label>
					      	<div class="input-group">
						      	<div class="input-group-addon">
			                        <i class="fa fa-calendar text-blue"></i>
			                     </div>
						      	<input id="ingreso" type="date" class="form-control" value="<?=$ingreso?>" name="ingreso" required>
					      	</div>
					    </div> 
					    <div class="form-group">
					      	<label>Fecha Salida</label>
					      	<div class="input-group">
						      	<div class="input-group-addon">
			                        <i class="fa fa-calendar text-red"></i>
			                    </div>
						      	<input id="salida_reserva" type="date" class="form-control" value="<?=$salida?>"  name="salida" required>
					      	</div>
					    </div> 
					    <div class="row">
							<div class="col-md-6">
								<div class="form-group">
							      	<label>Costo Reservación</label>
							      	<div class="input-group">
								      	<div class="input-group-addon">
					                        <i class="fa fa-money text-yellow"></i>
					                     </div>
								      	<input id="total_pagar" type="text" class="form-control" placeholder="Total a Cobrar" name="costo_total" required>
							      	</div>
							    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
							      	<label>Total Dias</label>
							      	<div class="input-group">
								      	<div class="input-group-addon">
					                        <i class="fa fa-tripadvisor text-orange"></i>
					                     </div>
								      	<input id="total_dias"  type="text" class="form-control" placeholder="Total Dias">
							      	</div>
							    </div>
							</div>
						</div>					     					    
						<div class="row">
							<div class="col-md-6 form-group">
								<input type="checkbox" id="check">
								<label for="check">¿Adelanto Reservación?</label>
							</div>
							<div class="col-md-6 form-group">
								<div class="input-group">
									<div class="input-group-addon">
				                        <i class="fa fa-money text-yellow"></i>
				                     </div>
									<input id="saldo" name="adelanto" readonly type="text" class="form-control" placeholder="00.00 Soles">
								</div>								
							</div>
						</div>	
                	</div>
                	<div class="box-footer">
                		<span id="cancelar" class="btn btn-sm btn-default btn-flat pull-left">Cancelar</span>
                      	<button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Registrar</button>
                    </div>  
                </div>                             
	        </div> 
	      </form>             
        </div>
    </section>
   </div>
   <!-- /.content-wrapper -->
  <?=$this->view('Template/FooterAdmin')?>
 <?=$this->view('Template/Asidebar')?>
 </div>

	<?=$helper->js('jQuery-2.2.0.min')?>
	<?=$helper->js('bootstrap.min')?>
	<?=$helper->js('app.min')?>	
	<?=$helper->js('select2.full.min')?>
	<?=$helper->js('sweetalert.min')?>
	<?=$helper->js('variables-globales')?>
	<?=$helper->js('NewEvento')?>	
	<script>
  		$(".select2").select2();
	</script>

</body>
</html>
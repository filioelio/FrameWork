<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Agenda</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?=$helper->css('ed-grid')?>
  	<?=$helper->css('header')?>
	<?=$helper->css('bootstrap.min')?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

	<?=$helper->css('fullcalendar.min')?>
	<link rel='stylesheet' href="<?=$helper->base_url()?>/css/fullcalendar.print.css" media="print">
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
      			<h1>Agenda del Hostal</h1>
    		</section>
    		 <section class="content">
			    <div class="row">
			        <div class="col-md-3">
			          <div class="box box-solid">
			            <div class="box-header with-border">
			              <h4 class="box-title">Lista de Events</h4>
			            </div>
			            <div class="box-body">
			              <!-- the events -->
			              <div id="external-events">
			                <div class="external-event bg-light-blue">Falta Entregar</div>
                      		<div class="external-event bg-purple">LLega Pedido</div>
			                <div class="external-event bg-green">Entrega de</div>
			                <div class="external-event bg-yellow">Pedido de</div>
			                <div class="external-event bg-aqua">Entregue a</div>
			                <div class="external-event bg-red">Falto</div>
			                <div class="checkbox">
			                  <label for="drop-remove">
			                    <input type="checkbox" id="drop-remove">
			                    Eliminar Evento
			                  </label>
			                </div>
			              </div>
			            </div>
			            <!-- /.box-body -->
			          </div>
			          <!-- /. box -->
			          <div class="box box-solid">
			            <div class="box-header with-border">
			              <h3 class="box-title">Crear Nuevo Evento</h3>
			            </div>
			            <div class="box-body">
			              <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
			                <ul class="fc-color-picker" id="color-chooser">
			                  <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
			                  <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
			                  <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
			                  <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
			                  <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
			                  <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
			                  <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
			                  <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
			                </ul>
			              </div>
			              <!-- /btn-group -->
			              <div class="input-group">
			                <input id="new-event" type="text" class="form-control" placeholder="Titulo Evento">

			                <div class="input-group-btn">
			                  <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
			                </div>
			                <!-- /btn-group -->
			              </div>
			              <!-- /input-group -->
			            </div>
			          </div>
			        </div>
			        <!-- /.col -->
			        <div class="col-md-9">
			          <div class="box box-primary">
			            <div class="box-body no-padding">
			              <div id="calendar"></div>
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

	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<?=$helper->js('jquery.slimscroll.min')?>	
	<?=$helper->js('fastclick')?>	
	<?=$helper->js('app.min')?>	
	<?=$helper->js('demo')?>	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<?=$helper->js('fullcalendar.min')?>	
	<?=$helper->js('variables-globales')?>
	<?=$helper->js('EventosAgenda')?>
	<?=$helper->js('sweetalert.min')?>
	<script>
		$(function (){
			$(".slimScrollDiv").css('height', '70px');
		});
	</script>
	
</body>
</html>
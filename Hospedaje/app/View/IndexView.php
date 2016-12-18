<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?=$helper->favicon();?>
	<title>Index</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<?=$helper->css('bootstrap.min')?>
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('index')?>
	<?=$helper->css('ExitoError')?>

</head>
<body id="header">	
	<div class="login-box">

  		<div class="login-box-body">
    		<h3 class="text-center">INICIAR SESION</h3>
		    <form action="<?= $helper->url('index', 'login');?>" method="post">
		    	<div id="exitoerror" class="form-group text-center">
                      <span class=" formulario_<?=@$class_mensaje?> "><?=@$mensaje?></span>
                    </div>
		      	<div class="form-group has-feedback">
		        	<input name="email" type="email" value="<?=$email?>" class="form-control" placeholder="Email">
		        	<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		      	</div>
		      	<div class="form-group has-feedback">
		        	<input name="contrasena" type="password" class="form-control" placeholder="Password">
		        	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		      	</div>
		      	<div class="row">
			        <div class="col-xs-12">
			          	<button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
			        </div>
		      	</div>
		    </form>
  		</div>
	</div>
</html>
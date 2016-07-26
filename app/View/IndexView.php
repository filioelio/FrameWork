<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?=$helper->favicon();?>
	<title>Framework MVC</title>
	<?=$helper->css('ed-grid')?>
	<?=$helper->css('header')?>
	<?=$helper->css('Formulario')?>
</head>
<body>
	<?=$this->view('Template/Header')?>
	<?=$this->view('Template/Nav')?>
	<div class="grupo centrar-contenido">
		<form id="formulario" action="<?= $helper->url('index', 'index');?>" method="post">
			<div class="form_grupo">
		    	<span class="form_titulo">Iniciar sesión</span>
		  	</div>
			<div class="form_grupo">
		    	<span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>
		  	</div>
			<div class="form_grupo">
		    	<input type="email" class="form-control" placeholder="Email">
		  	</div>
		  	<div class="form_grupo">
		    	<input type="password" class="form-control" placeholder="Password">
		  	</div>
		  	<div class="form_grupo">
		    	<input type="submit" class="form-boton" value="Ingresar">
		  	</div>		  	
		</form>
	</div>	
	<?=$this->view('Template/Footer')?>
	<?=$helper->js('jquery')?>
	<?=$helper->js('variables-globales')?>
	<?=$helper->js('eventos')?>
</body>
</html>
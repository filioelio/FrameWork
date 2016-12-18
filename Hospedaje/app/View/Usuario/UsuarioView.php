<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?=$helper->favicon();?>
  <title>Usuarios</title>
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
 @media all and (min-width:1201px) 
  {
    .users-list>li img 
    {
        border-radius: 50%;
        max-width: 100%;
        height: 130px;
        width: 130px;
    }

  }
  @media all and (max-width:1200px)
  {
    .users-list>li img 
    {
        border-radius: 50%;
        max-width: 100%;
        height: 120px;
        width: 120px;
    }

  }

  @media all and (max-width:1000px)
  {
    .users-list>li img 
    {
        border-radius: 50%;
        max-width: 100%;
        height: 115px;
        width: 115px;
    }

  }

  @media all and (max-width:800px)
  {
    .users-list>li img 
    {
        border-radius: 50%;
        max-width: 100%;
        height: 100px;
        width: 100px;
    }
  }
  @media all and (max-width:600px)
  {
    .users-list>li img 
    {
        border-radius: 50%;
        max-width: 100%;
        height: 80px;
        width: 80px;
    }
  }
  @media all and (max-width:400px)
  {
    .users-list>li img 
    {
        border-radius: 50%;
        max-width: 100%;
        height: 60px;
        width: 60px;
    }
  }
  @media all and (max-width:300px)
  {
    .users-list>li img 
      {
          border-radius: 50%;
          max-width: 100%;
          height: 50px;
          width: 50px;
      }
  }

    
  </style>
  
</head>
<body class="hold-transition skin-yellow sidebar-mini">
  <div class="wrapper">
    <?=$this->view('Template/HeaderAdmin',$datos_template)?>
    <?=$this->view('Template/NavAdmin', $datos_template)?>

    <div class="content-wrapper">
      <section class="content-header">
        <h1>Formulario Usuario <small>Registro, Modificar Datos del Usuario</small></h1>
      </section>

    <section class="content">
      <div class="row">
        <div class="col-md-8">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Lista de usuarios</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger"><?php foreach ($cantidad as $key => $value): ?>
                      <?=$value->cantidad?>
                    <?php endforeach ?> Usuarios</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    <?php foreach ($usuarios as $key => $user): ?>                   
                      <li class="user_perfil" data-id="<?=$user->getIdUsuario()?>">
                        <img  src="<?=$user->getFoto(true)!=NULL ? $user->getFoto(true) : $helper->base_url().'/img/users/template.jpg'?>" class="img-circle" alt="User Image">
                        <a  class="users-list-name"><?=$user->getNombre()?></a>
                        <span class="users-list-date"><?=$user->getApellido()?></span>
                      </li>
                    <?php endforeach ?>
                  </ul>
                </div>
                <div class="box-footer text-center">
                  <a href="javascript:void(0)" class="uppercase">Formulario de Usuarios</a>
                </div>
              </div>
            </div>
          <!-- /.col -->
          <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border text-center">
                  <h3 class="box-title">Formulario de Registro</h3>
                </div>
                <form id="url_usuario" role="form" action="<?= $helper->url('usuario', 'registro');?>" method="post" name="registro" enctype="multipart/form-data">
                  <div class="box-body">
                    <div id="exitoerror" class="form-group text-center">
                      <span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>
                    </div>
                    <div class="form-group">
                      <input id="id" type="text" class="form-control" value="<?=$dni?>" name="dni" placeholder="Nº DNI" maxlength="8" minlength="8" required>
                    </div>
                    <div class="form-group">
                      <input id="nombre" type="text" class="form-control" value="<?=$nombre?>" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                      <input id="apellido" type="text" class="form-control" value="<?=$apellido?>" name="apellido" placeholder="Apellido" required>
                    </div>
                    <div class="form-group input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input id="telefono" type="text" class="form-control" value="<?=$telefono?>" name="telefono" placeholder="Telefono" minlength="6" maxlength="9"  required>
                    </div>
                    <div class="form-group input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                      <input id="email" type="email" class="form-control" value="<?=$email?>" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                      <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                      <select id="tipo" class="form-control" name="tipo">
                        <option value="Normal">Normal</option>
                        <option value="Admin">Administrador</option>
                      </select> 
                    </div>
                    <div class="form-group">
                      <select id="estado" class="form-control" name="estado">
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                      </select> 
                    </div>
                    <div class="form-group text-center">
                      <span id="file_class" class="btn btn-primary btn-file">
                        Seleccione Foto del Usuario <input id="file" name="foto" type="file">
                      </span>
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
	<?=$helper->js('app.min')?>	
  <?=$helper->js('variables-globales')?>
  <?=$helper->js('eventos')?> 

  <script>
    $(document).ready(function(){
      $('#cancelar').on('click', function(){
        $('#file').val("");
        $( "#file_class" ).removeClass().addClass("btn btn-primary btn-file"); 
      });
      $('#cancelar').on('click', function(){
         document.getElementById("password").readOnly = false;
         document.getElementById("id").readOnly = false;
      });
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
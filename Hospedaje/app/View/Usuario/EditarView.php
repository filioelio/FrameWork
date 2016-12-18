<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?=$helper->favicon();?>
  <title>Editar Usuario</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?=$helper->css('ed-grid')?>
    <?=$helper->css('header')?>
    <?=$helper->css('ExitoError')?>
  <?=$helper->css('bootstrap.min')?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <?=$helper->css('AdminLTE.min')?>
  <?=$helper->css('skin-yellow.min')?>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
  <div class="wrapper">
    <?=$this->view('Template/HeaderAdmin',$datos_template)?>
      <?=$this->view('Template/NavAdmin', $datos_template)?>

      <div class="content-wrapper">
        <section class="content-header">
            <h1>Formulario Usuario <small>Administración de Perfil de Usuario </small></h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="centro-contenido col-md-4">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Foto del Perfil del Usuario</h3>
                </div>
                <form role="form" action="<?= $helper->url('usuario', 'editar');?>" method="post" name="update_profile" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="form-group">
                       <img src="<?=$user_foto ?>" class="img-circle" style = "width: 50%;" alt="User Image">
                    </div>
                        
                  </div>
                  <div class="box-footer">
                    <span id="file_class" class="btn btn-primary btn-file">
                        Seleccione Foto <input id="file" name="foto" type="file">
                    </span>
                  </div>
                </div>
              </div>

            <div class="centro-contenido col-md-4">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Datos del Usuario</h3>
                </div>
                  <div class="box-body">
                    <div id="exitoerror" class="form-group">
                      <span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="dni" value="<?=$dni?>" readonly>
                    </div>
                    <div class="form-group input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                      <input type="email" class="form-control" name="email" value="<?=$email?>" readonly>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="nombre" value="<?=$nombre?>" required>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="apellido" value="<?=$apellido?>"  required>
                    </div>
                    <div class="form-group input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control" name="telefono" value="<?=$telefono?>" minlength="6" maxlength="9"  required>
                    </div>
                        
                    <div class="form-group">
                      <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                    </div> 
                    
                  </div>
                  <div class="box-footer">
                    <span id="cancelar" class="btn btn-sm btn-default btn-flat pull-left">Cancelar</span>
                    <button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Guardar Cambios</button>
                  </div>
                </form>
              </div>
            </div>


            <div class="centro-contenido col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Cambio Contraseña</h3>
                    </div>
                    <form role="form" action="<?= $helper->url('usuario', 'password');?>" method="post">
                      <div class="box-body">
                        <div id="exitoerror" class="form-group">
                          <span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje_pass?></span>
                        </div>
                        <div class="form-group">
                          <input id="pass_act" type="password" class="form-control" name="pass_act" placeholder="Contraseña Actual" required>
                        </div>
                        <div class="form-group">
                          <input id="pass_new" type="password" name="pass_new" class="form-control" placeholder="Nueva Contraseña" required>
                        </div>
                        <div class="form-group">
                          <input id="pass_new_conf" type="password" name="pass_new_conf" class="form-control" placeholder="Vuelve a escribir contraseña" required>
                        </div>                                     
                        </div>
                         <div class="box-footer">
                            <span id="cancelar_pass" class="btn btn-sm btn-default btn-flat pull-left">Cancelar</span>
                            <button type="submit" class="btn btn-sm btn-primary btn-flat pull-right">Guardar Cambios</button>
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
  <script>
    $(document).ready(function(){
      $('#cancelar').on('click', function(){
        $('#file').val("");
        $('#password').val("");
        $("#file_class" ).removeClass().addClass("btn btn-primary btn-file"); 
      });
      $('#cancelar_pass').on('click', function(){
        $('#pass_act').val("");
        $('#pass_new').val("");
        $('#pass_new_conf').val("");
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


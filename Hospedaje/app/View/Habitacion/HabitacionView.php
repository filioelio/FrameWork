<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?=$helper->favicon();?>
  <title>Habitaciones</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?=$helper->css('ed-grid')?>
  <?=$helper->css('header')?>
  <?=$helper->css('ExitoError')?>
	<?=$helper->css('bootstrap.min')?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <?=$helper->css('select2.min')?>
  <?=$helper->css('dataTables.bootstrap')?>
	<?=$helper->css('AdminLTE.min')?>
	<?=$helper->css('skin-yellow.min')?>
  
</head>
<body class="hold-transition skin-yellow sidebar-mini">
  <div class="wrapper">
    <?=$this->view('Template/HeaderAdmin',$datos_template)?>
    <?=$this->view('Template/NavAdmin', $datos_template)?>

    <div class="content-wrapper">
      <section class="content-header">
        <h1>Formulario<small>Habitaciones</small></h1>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-8">      
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Lista de Habitaciones</h3>
                <div class="box-tools ">
                  <div class="pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>                   
                </div>

                  
                </div>
                <div class="box-body">
                  <div class="table-responsive">          
                    <table id="example1" class="table table table-bordered table-striped no-margin">
                      <thead>
                      <tr>
                        <th>ID.</th>
                        <th>Tipo</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Precio</th>
                        <th>Foto</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($habitaciones as $key => $habitacion): ?>  
                           <tr>
                              <td class="id_habitacion" data-id="<?=$habitacion->getIdHabitacion()?>"><a href="#"><?=$habitacion->getIdHabitacion()?></a></td>
                              <td><?=$habitacion->getTipo()?></td>
                              <td><?=$habitacion->getDescripcion()?></td>
                              <td><?=$habitacion->getEstado()?></td>
                              <td><?=$habitacion->getPrecio()?></td>
                              <td><?=$habitacion->getfoto()?></td>
                            </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <!-- /.col -->
            <div class="col-md-4">
              <div class="box box-primary text-center">
                  <div class="box-header with-border">
                    <h3 class="box-title">Formulario de Registro</h3>
                  </div>
                  <form id="url_habitacion" role="form" action="<?= $helper->url('habitacion', 'registro');?>" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                      <div id="exitoerror" class="form-group">
                        <span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>
                      </div>
                      <div class="form-group">
                        <input id="id" type="text" class="form-control" name="id" placeholder="Nº Habitacion" value="<?=$id?>" required>
                      </div>
                      <div class="form-group">
                        <select id="tipo_habi" class="form-control" name="tipo" value="<?=$tipo?>">
                          <option value="Individual">Indivual Simple</option>
                          <option value="Familiar">Familiar</option>
                          <option value="Doble">Doble Cama</option>
                          <option value="Matrimonial">Matrimonial</option>
                        </select> 
                      </div>
                      <div class="form-group">
                        <textarea id="descripcion" type="text" class="form-control" name="descripcion" placeholder="Describe sus Caracteristicas" value="<?=$descripcion?>" required></textarea>
                      </div>
                      <div class="form-group">
                        <select id="estado_habi" class="form-control" name="estado" value="<?=$estado?>">
                          <option value="Disponible">Disponible</option>
                          <option value="Ocupado">Ocupado</option>
                          <option value="Mantenimiento">Mantenimiento</option>
                        </select> 
                      </div>

                      <div class="form-group input-group">
                        <span class="input-group-addon">$</i></span>
                        <input id="precio" type="text" class="form-control" name="precio" placeholder="Ingrese el precio de la habitacion" value="<?=$precio?>" required>
                        <span class="input-group-addon"><i class="fa fa-ambulance"></i></span>
                      </div>
                      <div class="form-group">
                        <span id="file_class" class="btn btn-primary btn-file">
                          Seleccione Foto de Habitacion <input id="file" name="foto" type="file">
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
  <?=$helper->js('jquery.dataTables.min')?> 
  <?=$helper->js('dataTables.bootstrap.min')?>
  <?=$helper->js('jquery.slimscroll.min')?>
  <?=$helper->js('fastclick.min')?>
  <?=$helper->js('app.min')?> 

  <?=$helper->js('select2.full.min')?>
  <?=$helper->js('variables-globales')?>
  <?=$helper->js('eventos')?>
  <script>
   $(document).ready(function(){
      $("#example1").DataTable();
      $(".select2").select2();
      $(".slimScrollDiv").css('height', '70px');
      $('#file').on('change', function(){
        if($(this).val()!= ""){ 
          $( "#file_class" ).removeClass().addClass( "btn btn-success btn-file" ); 
        } else {
          $( "#file_class" ).removeClass().addClass( "btn btn-default btn-file" ); 
        }
      });
      $('#cancelar').on('click', function(){
        document.getElementById("id").readOnly = false;
      });
    });
  </script>
</body>
</html>


	

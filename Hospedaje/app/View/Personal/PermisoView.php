<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?=$helper->favicon();?>
  <title>Nuevo - Permiso</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?=$helper->css('ed-grid')?>
    <?=$helper->css('header')?>
    <?=$helper->css('ExitoError')?>
  <?=$helper->css('bootstrap.min')?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <?=$helper->css('fullcalendar.min')?>
  <link rel='stylesheet' href="<?=$helper->base_url()?>/css/fullcalendar.print.css" media="print">
  <?=$helper->css('AdminLTE.min')?>
  <?=$helper->css('skin-yellow.min')?>

</head>
<body class="hold-transition skin-yellow sidebar-mini">
  <div class="wrapper">
    <?=$this->view('Template/HeaderAdmin',$datos_template)?>
    <?=$this->view('Template/NavAdmin', $datos_template)?>

      <div class="content-wrapper">
        <section class="content-header">
            <h1>FORMULARIO DE PERMISO</h1>
        </section>
         <section class="content">
          <div class="row">
              <div class="col-md-3">
                <form action="<?= $helper->url('personal', 'permiso');?>" method="post">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">PERMISOS AL PERSONAL</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                      <div class="box-body">
                        <div id="exitoerror" class="form-group text-center">
                            <span class="formulario_<?=@$class_mensaje?>"><?=@$mensaje?></span>      
                        </div>
                        <div class="form-group">
                           <label for="fecha_inicio">ELIJA UN COLOR PARA EL PERMISO</label>
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
                        </div>
                        <div class="form-group">
                          <label for="fecha_inicio">FECHA INICIO</label>
                          <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user text-blue"></i>
                            </span>
                            <input id="fecha_inicio" name="fecha_inicio" type="date" class="form-control" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="fecha_fin">FECHA FIN</label>
                          <div class="input-group">
                            <span class="input-group-addon">
                              <i class="fa fa-money text-yellow"></i>
                            </span>
                            <input id="fecha_fin" name="fecha_fin" type="date" class="form-control" required>
                          </div>
                        </div>
                          
                        <div class="form-group">
                          <label for="descripcion">Ingrese una Descripcion</label>
                          <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-file text-green"></i>
                            </span>
                            <input id="descripcion" name="descripcion" type="text" class="form-control" placeholder="Descripcion" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="id_personal">PERSONAL QUIEN RECIVE</label>
                          <div class="input-group">
                            <span class="input-group-addon">
                              <i class="fa fa-user text-blue"></i>
                            </span>
                            <select id="id_personal" name="id_personal" class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true">
                              <?php if (isset($ListPersonal)): ?>
                                <?php foreach ($ListPersonal as $key => $item): ?>
                                  <?php if ($item->getEstado()=="Activo"): ?>
                                    <option value="<?=$item->getIdPersonal()?>"><?=$item->getNombre()." ".$item->getApellido()?></option>
                                  <?php endif ?>
                                <?php endforeach ?>
                              <?php endif ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="box-footer">
                        <button id="add-new-event"  name="color" type="submit" class="btn btn-sm btn-primary btn-flat pull-right">REGISTRAR PERMISO</button>
                      </div> 
                  </div>
                </form>
              </div>
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

  <script>
    $(document).ready(function(){
      $(".slimScrollDiv").css('height', '70px');

      var date = new Date();
      var d = date.getDate(),
          m = date.getMonth(),
          y = date.getFullYear();

      $.ajax({
        url : root + '/personal/getDataPermiso',
        data: {},
        type : 'POST',
        dataType : 'json',
        success : function(json)
        {
          if (json.exito) 
          {
            $('#calendar').fullCalendar({
              header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
              },
              buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
              },
              //Random default events
              events:json.result,
              // events: $.parseJSON(dataSalario),
              editable: true,
              droppable: true, // this allows things to be dropped onto the calendar !!!
              eventDrop: function(event, delta, revertFunct)
              {
                UpdatePermiso(event.id_permiso, event.start.format(),event.end.format());
              }
            });
          }
        },
        error : function(jqXHR, status, error)
        {
          console.dir(error);
          console.dir(status);
          console.dir(jqXHR);
        },
        complete: function () {
          return false;
        }   
    }); 
    
    function UpdatePermiso(id, fecha1, fecha2)
    {
      $.ajax({
        url : root + '/personal/setUpdatePermiso',
        data: {id_permiso : id, f_ini : fecha1, f_fin : fecha2},
        type : 'POST',
        dataType : 'json',
        success : function(json)
        {
          if (json.exito) 
          {
            console.log("se modifico correctamente");
          }
        },
        error : function(jqXHR, status, error)
        {
          console.dir(error);
          console.dir(status);
          console.dir(jqXHR);
        },
        complete: function () {
          return false;
        }   
      }); 
    }

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').attr('value',currColor);
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
  });
  </script>

</body>
</html>
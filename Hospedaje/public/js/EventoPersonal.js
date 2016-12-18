
 var jornada = new Jornada();
$(document).ready(function(){

  $.ajax({
    url : root + '/hospedaje/getJornada',
    data: {},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.exito) 
      {
        jornada.setFechaIngreso(json.fecha_ingreso);
        jornada.setFechaSalida(json.fecha_salida);

        if (jornada.getFechaIngreso() == jornada.getFechaSalida() || jornada.getFechaSalida() == "") 
        {
          $("#Opcionturno").text("FINALIZAR TURNO");
          $("#Opcionturno").removeClass().addClass('btn btn-sm btn-danger btn-flat');
        } else if(jornada.getFechaIngreso() <= jornada.getFechaSalida() && jornada.getFechaSalida() != "") {
          $("#Opcionturno").text("INICIAR TURNO");
          $("#Opcionturno").removeClass().addClass('btn btn-sm btn-success btn-flat'); 
        }
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

  $('#cancelar').on('click', function(){
    Cancelar();
  });

	$('.id_personal').on('click', function(){
      CargarPersonal(this, $(this).data('id'));
  	});

  $("#Opcionturno").on('click', function(){
    $turno = $(this).text();
    if ($turno == 'INICIAR TURNO') 
    {
        swal({
          title: "INICIAR?",
          text: "Quiere Iniciar de Verdad!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, Iniciar!",
          closeOnConfirm: false
        },
        function(){
          $.ajax({
            url: root + '/hospedaje/IniciarTurno',
            dataType : 'json',
          }).done(function(json) {
            if (json.exito) {
              swal("Exito!", "Usted Inicio Correctamente.", "success");
              $("#Opcionturno").text("FINALIZAR TURNO");
              $("#Opcionturno").removeClass().addClass('btn btn-sm btn-danger btn-flat');
            } else {
              swal("Error!", "Usted No Inicio Correctamente.", "warning");
            }  
          });
        });
    } else if($turno == 'FINALIZAR TURNO') {
      swal({
        title: "Finalizar Turno?",
        text: "Usted realmente quiere Finalizar!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Finalizar!",
        closeOnConfirm: false
      },
      function(){
        $.ajax({
          url: root + '/hospedaje/FinalizarTurno',
          data: {monto :jornada.getMonto()},
          type : 'POST',
          dataType : 'json',
        }).done(function(json) {
           console.log(json.mensaje);
          if (json.exito) {
            console.log(json.mensaje);
            swal("Exito!", "Usted Finalizo Correctamente.", "success");
              $("#Opcionturno").text("INICIAR TURNO");
              $("#Opcionturno").removeClass().addClass('btn btn-sm btn-success btn-flat');
          } else {
            swal("Error!", "Usted No  Puede Finalizar, Contacte al Administrador.", "error");
          }  
        });
      });
    }
  });
});

function Cancelar()
{
  $("#dni").val("");
  $("#nombre").val("");
  $("#apellido").val("");
  $("#celular").val("");
  $("#direccion").val("");
  $("#estado").val("Activo");
  $("#labor").val("");
  $("#salario").val("");
  $("#fecha").val("");
  $("#submit").text("Registrar Personal");
  $('#url_personal').attr("action", root+"/personal/registro/");
  document.getElementById("dni").readOnly = false;
}

function CargarPersonal(object, id)
{
  $.ajax({
    url : root + '/personal/getData',
    data: {id_personal : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.dni) 
      {
        $('#url_personal').attr("action", root+"/personal/update/");
        document.getElementById("dni").readOnly = true;
        $("#dni").val(json.dni);
        $("#nombre").val(json.nombre);
        $("#apellido").val(json.apellido);
        $("#celular").val(json.celular);
        $("#direccion").val(json.direccion);
        $("#estado").val(json.estado);
        $("#labor").val(json.labor);
        $("#salario").val(json.salario);
        $("#fecha").val(json.fecha);
        $("#submit").text("Modificar Personal");
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

function Jornada()
{

  var FechaIngreso = "";
  var FechaSalida = "";

  this.setFechaIngreso=function(fecha_ingreso)
  {
    FechaIngreso = fecha_ingreso;
    return FechaIngreso;
  }
  this.getFechaIngreso=function() {
    return FechaIngreso;
  }

  this.setFechaSalida=function(fecha_salida)
  {
    FechaSalida = fecha_salida;
    return FechaSalida;
  }
  this.getFechaSalida=function() {
    return FechaSalida;
  }

  this.getMonto=function() {
    Monto = $("#total").text();
    return Monto;
  }
}
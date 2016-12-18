$(document).ready(function(){

  $('#check').on('change', function(e){
    
    if (e.target.checked) 
      {
        document.getElementById("saldo").readOnly = false;
      } else {
        $('#saldo').val('');
        document.getElementById("saldo").readOnly = true;
      }
  });
  $('#new_precio').dblclick(function(){
      document.getElementById("new_precio").readOnly = false;
  });

  $('#cancelar').on('click', function(){
    Cancelar();
  });

  $('#alquilar').on('click', function(){
    CargarDatosHabitacion(this, $(this).data('id'))
  });

  $('.link_formalizar').on('click', function(){
        PasarDNI(this, $(this).data('id'))
  });

  $('.link_finalizar').on('click', function(){
    var object = this;
    var id = $(this).data('id');
    swal({
      title: "Cancelar?",
      text: "Realmente desea Cancelar Reservacion!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, Cancelar!",
      cancelButtonText: "Abordar ¡",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
        FinalizarReservacion(object, id);
        swal("Exito!", "Reservacion Cancelado Correctamente.", "success");
      } else {
        swal("Cancelado", " Usted Elegio Bien :)", "error");
      }
    });
  });

  $('.update_venta').on('click', function(){
    CargarVenta(this, $(this).data('id'))
  });

  $('.detalle_venta').on('click', function(){
    CargarDetalleVenta(this, $(this).data('id'))
  });

  $("#dni").keyup( function(e)
  {
      d = $(this).val();
      if(d.length == 8)
      {
        CargarDatosHuesped(this, d);
      }
  });

  $("#search_habitacion").keyup( function(e)
  {
      d = $(this).val();

      if(d.length == 3)
      {
        console.log(d);
        CargarDatosHabitacion(this, d);  
      }
  });

  $("#ingreso").on('change', function(){
    var f_entrada = document.getElementById("ingreso").value;
    var fecha = new Date(f_entrada);
    var day = fecha.getDate();
    fecha.setDate(day+1); 
    var fecha_actual = new Date();     
      
    var fecha1 = new Date(fecha_actual);
    var fecha2 = new Date(fecha);
    var diasDif = fecha2.getTime() - fecha1.getTime();
    var dias = Math.round(diasDif/(1000 * 60 * 60 * 24));
    
    if (dias<0) 
    {
      sweetAlert("Oops...", "FECHA DE INGRESO ES MENOR QUE FECHA ACTUAL!", "error");
      document.getElementById("ingreso").value = '';
    }
  });

  $('#salida_reserva').on('change',function(){
      var f_entrada = document.getElementById("ingreso").value;
      var f_salida= document.getElementById("salida_reserva").value;
      var fecha1 = new Date(f_entrada);
      var fecha2 = new Date(f_salida);
      var diasDif = fecha2.getTime() - fecha1.getTime();
      var dias = Math.round(diasDif/(1000 * 60 * 60 * 24));
      var precio = $('#precio').text();
      if (dias<= 0) 
      {
        sweetAlert("Oops...", "FECHA DE INGRESO ES MAYOR QUE FECHA DE SALIDA!", "error");
        var f_salida= document.getElementById("salida_reserva").value = '';
        $('#total_pagar').val('');
        $('#total_dias').val('');
      }
      else
      {        
        $('#total_pagar').val(dias*precio);
        $('#total_dias').val(dias);
      }
      
  });

  $('#salida').on('change',function(){
      var f_input= document.getElementById("salida").value;
      var fecha_actual = new Date();

      var fecha = new Date(f_input);
      var day = fecha.getDate();
      fecha.setDate(day+1);      
      
      var fecha1 = new Date(fecha_actual);
      var fecha2 = new Date(fecha);
      var diasDif = fecha2.getTime() - fecha1.getTime();
      var dias = Math.round(diasDif/(1000 * 60 * 60 * 24));
      var precio = $('#precio').text();

      if (dias<=0)
      {
        sweetAlert("Oops...", "INGRESE UNA FECHA MAYOR QUE LA ACTUAL!", "error");
        var f_input= document.getElementById("salida").value = '';
        $('#total_pagar').val('');
        $('#total_dias').val('');
      } else {
        $('#total_pagar').val(dias*precio);
        $('#total_dias').val(dias);
      }  
  });

  $('.hab_mantemiento').on('click', function(){
      var id_habitacion = $(this).data('id');
      var object =  $(this);
      swal({
        title: "Mantenimiento?",
        text: "Esta Seguro de Poner en Mantenimiento esta Habitacion!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Estoy Seguro!",
        closeOnConfirm: false
      },
      function(){
        MantenimientoHabitacion(object, id_habitacion);
        swal("Exito!", "Habitacion Puesto en Mantenimiento.", "success");
      });
  });
});

function Cancelar()
{
  $("#dni").val("");
  $("#nombre").val("");
  $("#apellido").val("");
  $("#telefono").val("");
  $("#conducta").val("");
  $("#descripcion").val("");
  $("#origen").val("");
  $("#motivo").val("");
  $("#ingreso").val("");
  $("#salida").val("");
  $('#id_venta').val("");
  $('#id_habitacion').val("");
  $('#huesped').val("");
  $('#fecha_venta').val("");
  $('#total').val("");
  $('#deuda').val("");
  $('#usuario').val("");   
}

function MantenimientoHabitacion(object, id)
{
  $.ajax({
    url : root + '/habitacion/Mantenimiento',
    data: {id_habitacion : id },
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.exito) {
        console.log("Se Realizo con Exito");
        $(object).parent().parent().parent().parent().parent().remove();
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

function  FinalizarReservacion(object, id)
{
  $.ajax({
    url : root + '/reservacion/finalizar',
    data: {id_reservacion : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.exito) 
      {
        $(object).parent().parent().parent().parent().remove();
        console.log("se finalizo la reservacion");
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

function PasarDNI(object, id)
{
  $.ajax({
    url : root + '/hospedaje/AjaxRecibirDNI',
    data: {id_huesped : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.exito) {
        console.log("se logro el objetivo");
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
var deuda_server = 0;
function CargarVenta(object, id)
{
  $.ajax({
    url : root + '/venta/getVenta',
    data: {id_venta : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.estado) {
        $('#id_venta').val(json.id_venta);
        $('#id_habitacion').val('Nº Habitacion : '+json.id_habitacion);
        $('#huesped').val(json.huesped);
        $('#fecha_venta').val(json.fecha);
        $('#total').val(json.total);
        $('#deuda').val(json.deuda);
        $('#usuario').val(json.usuario);
      } else {
        console.log("No se encontro venta"); 
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

function CargarDetalleVenta(object, id)
{
  $.ajax({
    url : root + '/venta/getDetalleVenta',
    data: {id_venta : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.estado) 
      {
        var array = json.array;
        document.getElementById('colum_lista').innerHTML = "";
        array.forEach(function (item, index, array_dv) 
        {
          var array = [];
          array = [index+1,item['nombre'],item['descripcion'],item['medida'],item['precio'],item['cantidad'],item['subtotal']];
          addRow(array,'colum_lista');
        });     
      } else {
        console.log("no se encontro detalle de venta"); 
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

function CargarDatosHabitacion(object, id)
{
  $.ajax({
    url : root + '/habitacion/getData',
    data: {id_habitacion : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.idhabitacion) 
      {
        $('#imagen').attr("src",root+"/img/Habitacion/"+json.foto);
        $("#tipo").text(json.tipo);
        $("#new_precio").val(json.precio);
        $("#descripcion").text(json.descripcion);
        $("#estado").text(json.estado);
        $("#precio").text(json.precio);
        
      } else {
        $("#alert").text("El usuario no existe ingrese nuevo");
        $('#alert').css('color', '#000');
        $('#alert').css('background', '#EDEF51');
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

function CargarDatosHuesped(object, id)
{
  $.ajax({
    url : root + '/huesped/getData',
    data: {id_huesped : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.dni) 
      {
        $("#dni").val(json.dni);
        $("#nombre").val(json.nombre);
        $("#apellido").val(json.apellido);
        $("#origen").val(json.origen);
        $("#telefono").val(json.telefono);
        $("#conducta").val(json.conducta);
      } else {
        $("#nombre").val("");
        $("#apellido").val("");
        $("#origen").val("");
        $("#telefono").val("");
        $("#conducta").val("");
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

function addRow(dataArr,tabla)
{
  var tr=document.createElement('tr');
  var len=dataArr.length;
  for(var i=0;i<len;i++){
    var td=document.createElement('td');
    td.appendChild(document.createTextNode(dataArr[i]));
    tr.appendChild(td);
  }
  document.getElementById(tabla).appendChild(tr);
  return true;  
}


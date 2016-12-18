$(document).ready(function(){

  $('#cancelar').on('click', function(){
    Cancelar();
  });
  $('.LinkVerH').on('click', function(){
    CargarHospedajeSelect($(this).data('id'));
  });
  $('.id_huesped').on('click', function(){
    CargarDatosHuesped(this, $(this).data('id'));
  });

	$('.id_producto').on('click', function(){
		CargarDatosProducto(this, $(this).data('id'));
	});

	$('.id_habitacion').on('click', function(){
    	CargarDatosHabitacion(this, $(this).data('id'))
  	});

  $('.user_perfil').on('click', function(){
		CargarDatosUsuario(this, $(this).data('id'));
	});
  $('.id_gasto').on('click', function(){
      console.log(this +" " + $(this).data('id'));
      CargarGasto($(this).data('id'));
    });

  $("#dni").keyup( function(e)
  {
      d = $(this).val();
      if(d.length == 8){
        Cargar_DatosHuesped(this, d);
      }
  });

  $("#id").keyup( function(e)
  {
      d = $(this).val();
      if(d.length == 3){
        Cargar_DatosHabitacion(this, d);
      } 
  });
});
function Cancelar()
{
  $("#id").val("");
  $("#dni").val("");
  $("#stock").val("");
  $("#email").val("");
  $("#monto").val("");
  $("#nombre").val("");
  $("#origen").val("");
  $("#medida").val("");
  $("#precio").val("");
  $("#recibe").val("");
  $("#apellido").val("");
  $("#telefono").val("");
  $("#conducta").val("");
  $("#password").val("");
  $("#procedencia").val("");
  $("#descripcion").val("");
  $("#tipo").val("Normal");
  $("#estado").val("Activo");
  $("#submit").text("Registrar");
  $("#tipo_habi").val("Individual");
  $("#estado_habi").val("Disponible");
  $('#url_gasto').attr("action", root+"/gastos/nuevo/");
  $('#url_usuario').attr("action", root+"/usuario/registro/");
  $('#url_huesped').attr("action", root+"/huesped/registro/");
  $('#url_producto').attr("action", root+"/producto/registro/");
  $('#url_habitacion').attr("action", root+"/habitacion/registro/");
}

function CargarHospedajeSelect(id)
{
  console.log(id);
  $.ajax({
    url : root + '/hospedaje/getHospedajeSelect',
    data: {id_hospedaje : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.exito){
        $("#img_habi").attr('src',root+'/img/Habitacion/'+json.img);
        $("#dni").text(json.dni);
        $("#huesped").text(json.huesped);
        $("#procedencia").text(json.procedencia);
        $("#telefono").text(json.telefono);
        $("#f_ingreso").text(json.f_ingreso);
        $("#f_salida").text(json.f_salida);
        $("#n_habi").text(json.n_habi);
        $("#tipo").text(json.tipo);
        $("#cos_habi").text(json.cos_habi);
        $("#cant_dias").text(json.cant_dias);
        $("#total").text(json.total);
        $("#adelanto").text(json.adelanto);
        $("#deuda").text(json.deuda);
        $("#usuario").text(json.usuario);
      } else {
        console.log("no se encontro objeto");
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

function CargarGasto(id)
{
  console.log(id);
  $.ajax({
    url : root + '/gastos/getData',
    data: {id_gasto : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.exito){
        $('#url_gasto').attr("action", root+"/gastos/update/"+id);
        $("#recibe").val(json.recibe);
        $("#monto").val(json.monto);
        $("#descripcion").val(json.descri);
        $("#submit").text("Modificar");
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

function Cargar_DatosHuesped(object, id)
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
        $('#url_huesped').attr("action", root+"/huesped/update/");
        document.getElementById("dni").readOnly = true;
        $("#dni").val(json.dni);
        $("#nombre").val(json.nombre);
        $("#apellido").val(json.apellido);
        $("#origen").val(json.origen);
        $("#telefono").val(json.telefono);
        $("#conducta").val(json.conducta);
        $("#submit").text("Modificar Huesped");
      }
      else
      {
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

function CargarDatosProducto(object, id)
{
  $.ajax({
    url : root + '/producto/getData',
    data: {id_producto : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.idproducto) 
      {
      	$('#url_producto').attr("action", root+"/producto/update/");
      	$("#id").val(json.idproducto);
      	$("#nombre").val(json.nombre);
        $("#descripcion").val(json.descripcion);
        $("#medida").val(json.medida);
        $("#precio").val(json.precio);
        $("#stock").val(json.stock);
        $("#submit").text("Modificar Producto");        
      }  else {
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

function Cargar_DatosHabitacion(object, id)
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
        $("#id").val(json.idhabitacion);
        $("#tipo_habi").val(json.tipo);
        $("#descripcion").val(json.descripcion);
        $("#estado_habi").val(json.estado);
        $("#precio").val(json.precio);        
      }
      else
      {
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
      	$('#url_habitacion').attr("action", root+"/habitacion/update/");
        document.getElementById("id").readOnly = true;
      	$("#id").val(json.idhabitacion);
        $("#tipo_habi").val(json.tipo);
        $("#descripcion").val(json.descripcion);
        $("#estado_habi").val(json.estado);
        $("#precio").val(json.precio);
        $("#submit").text("Modificar Habitacion");        
      }
      else
      {
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

function CargarDatosUsuario(object, id)
{
	$.ajax({
		url : root + '/usuario/getData',
		data: {id_us : id},
		type : 'POST',
		dataType : 'json',
		success : function(json)
		{
			if (json.dni) 
			{
				$('#url_usuario').attr("action", root+"/usuario/update/");
        document.getElementById("id").readOnly = true;
				$("#id").val(json.dni);
				$("#nombre").val(json.nombre);
				$("#apellido").val(json.apellido);
				$("#telefono").val(json.telefono);
				$("#email").val(json.email);
        $('#password').attr('readonly','true');
				$("#password").val(json.password);
				$("#tipo").val(json.tipo);
				$("#estado").val(json.estado);
				$("#submit").text("Modificar Usuario");
			}
			else
			{
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
var opcion_venta = false;
$(document).ready(function(){
  $('#check').on('change', function(e){
     if (e.target.checked) 
      {
        opcion_venta = true;
        document.getElementById("monto").readOnly = false;
        
      } else {
        opcion_venta = false;
        $('#monto').val('');
        document.getElementById("monto").readOnly = true;
      }
  });
  $('.agregar').on('click', function(){
    agregar_al_carrito(this, $(this).data('id'));
  });

  $('#registrar').on('click', function(){
    // , 
    Registrar_Venta(this, $('#id_habitacion').val(), $('#monto').val());
  });

  $("#id_habitacion").keyup( function(e)
  {
      d = $(this).val();
      if(d.length == 3)
      {
        CargarDatosHuesped(this, d);
      }
      else
      {
        $('#huesped').text("");
        $('#estado').text("");
        $('#fecha_ingreso').text("");
        $('#fecha_salida').text("");
      }
  });

});

var pro = new Producto();

function Registrar_Venta(object, id, monto)
{ 
  var saldo = 0.00;
  if (id == '')
  {
    saldo = 0.00;
    id_hos = pro.getIdHospedaje();
  } else {
    if (id !='' &&  opcion_venta)
    {
      saldo = pro.getTotalVenta() - monto;  
      id_hos = pro.getIdHospedaje();    
    } else {
      saldo = 0.00;
      id_hos = pro.getIdHospedaje();  
    }  
  }
  if (pro.getTotalVenta()>0)
  {
    $.ajax({
      url : root + '/venta/RegistrarVenta',
      data: {id_hospedaje : id_hos, deuda : saldo, total : pro.getTotalVenta(), array : pro.getArrayList()},
      type : 'POST',
      dataType : 'json',
      success : function(json)
      {
        if (json.codigo) 
        {
          setTimeout(finalizarventa,3000);
          console.log(json.mensaje);
          $('#mensaje').text(json.mensaje);
          $('#mensaje').css({'color': '#5AE40F'});
        }
        else
        {
          console.log(json.mensaje);
          $('#mensaje').text(json.mensaje);
          $('#mensaje').css({'color': 'red'});
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
  else{
    sweetAlert("Oops...", "Vende un Producto para poder Registrar!", "error");
  }
}

function CargarDatosHuesped(object, id)
{
  $.ajax({
    url : root + '/hospedaje/getData',
    data: {id_habitacion : id},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.idhabitacion) 
      {
        pro.setIdHospedaje(json.idhospedaje);
        $('#huesped').text(json.huesped);
        $('#deuda_anterior').text(json.deuda);
        $('#fecha_ingreso').text(json.fecha_ingreso);
        $('#fecha_salida').text(json.fecha_salida);
      } else {
        $('#huesped').text("");
        $('#estado').text("");
        $('#fecha_ingreso').text("");
        $('#fecha_salida').text("");
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

function update_carrito(array, id)
{
  array.forEach(function (item, index, array) 
  {
     if (item[1]==id) 
     {
      if (item[5]>=2)
      {
        pro.setDescontar(item[4])
        pro.setCantidad(item[5]-=1)
        pro.setPrecio(item[4]);
        item[5] = pro.getCantidad();
        item[6]=pro.getSubtotal(); 
      }
      else
      {
          delete array[index];
          pro.setDescontar(item[6]); 
      }      
     }
  });

 $('#total').text(pro.getTotalVenta());
  mostrar(pro.getArrayList());
}

function agregar_al_carrito(object, id)
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
        pro.setId(json.idproducto);
        pro.setNombre(json.nombre);
        pro.setDescripcion(json.descripcion);
        pro.setPrecio(json.precio);
        pro.setCantidad(1);

        var array = [];

        if (pro.getArrayList().length != 0) 
        {
          array = pro.getArrayList();
          var estado = false;
          array.forEach(function (item, index, array) 
          {
            if (item[1]==id) 
            {
              pro.setDescontar(item[6]);
              pro.setCantidad(item[5]+=1)
              item[5] = pro.getCantidad();
              estado = true;
              item[6]=pro.getSubtotal();

            }
          });
          if (estado == false) 
          {
            array = [pro.getContador(),pro.getId(),pro.getNombre(),pro.getDescripcion(),pro.getPrecio(),pro.getCantidad(),pro.getSubtotal(),pro.getOpcion()];
            pro.setArrayList(array);
          }
        }
        else
        {
          array = [pro.getContador(),pro.getId(),pro.getNombre(),pro.getDescripcion(),pro.getPrecio(),pro.getCantidad(),pro.getSubtotal(),pro.getOpcion()];
          pro.setArrayList(array);
        }
        mostrar(pro.getArrayList());        
        $('#total').text(pro.getTotal());
        
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

function mostrar(array)
{
  document.getElementById('colum_lista').innerHTML = "";
  
  array.forEach(function (item, index, array) 
  {
    var tr=document.createElement('tr'); 
    
    item.forEach(function(iten, inde, array)
    {
      var td=document.createElement('td');
      if(inde==7)
      {
        elm = document.createElement("span");
        elm.innerText= iten;
        elm.setAttribute("class", "Eliminar_fila"); 
        elm.setAttribute("data-id", item[1]);  
        td.appendChild(elm);
      }
      else
        td.appendChild(document.createTextNode(iten));
      tr.appendChild(td);
    }); 
    document.getElementById('colum_lista').appendChild(tr);
    return true; 
  });
  $('.Eliminar_fila').on('click', function(){
      update_carrito(pro.getArrayList(), $(this).data('id'));
  }); 
}

function finalizarventa()
{
  window.location.reload();
}



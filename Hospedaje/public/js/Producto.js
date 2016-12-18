function Producto()
{
  var arraylist = [];
  var Id = 0;
  var IdHospedaje  = 3;
  var Nombre = '';
  var Descripcion = '';
  var Precio = 0.0;
  var Cantindad = 0;
  var Subtotal = 0.0;
  var Total = 0;
  var Opcion = '';
  var Contador = 0;
  
  this.setArrayList= function(array)
  {
    arraylist.push(array);
    return arraylist;
  }
  this.getArrayList= function(){
    return arraylist;
  }

  this.setIdHospedaje=function(idHospedaje)
  {
    IdHospedaje = idHospedaje;
    return IdHospedaje;
  }
  this.getIdHospedaje=function() {
    return IdHospedaje;
  }

  this.setId=function(id)
  {
    Id = id;
    return Id;
  }
  this.getId=function() {
    return Id;
  }

  this.setNombre=function(nombre) {
    Nombre = nombre;
    return Nombre;
  }
  this.getNombre=function() {
    return Nombre;
  }

  this.setDescripcion=function(descripcion) {
    Descripcion = descripcion;
    return Descripcion;
  }
  this.getDescripcion=function() {
    return Descripcion;
  }

  this.setPrecio=function(precio) {
    Precio = precio;
    return Precio;
  }
  this.getPrecio=function() {
    return Precio;
  }
  
  this.setCantidad=function(cantindad) {
    Cantindad = cantindad;
    return Cantindad;
  }

  this.getCantidad=function() {
    return Cantindad;
  }


  this.getSubtotal=function() {
    Subtotal = Precio*Cantindad;
    return Subtotal;
  }
  
  this.getTotal=function() {
    Total +=Subtotal; 
    return Total;
  }

  this.setDescontar=function(descontar) {
    Total -=descontar;
    return Total;
  }
  this.getTotalVenta=function() {
    return Total;
  }

  this.getContador=function() {
    Contador +=1;
    return Contador;
  }

  this.getOpcion=function() {

    if (Cantindad == 1) 
    {
      Opcion = "Eliminar";
    } else {
      Opcion = "Quitar";
    }
    
    return Opcion;
  }

}
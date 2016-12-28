$(document).ready(function()
{
 	function ini_events(ele) {
      	ele.each(function () {
        	var eventObject = {
          		title: $.trim($(this).text()) 
        	};
        	$(this).data('eventObject', eventObject);
	        $(this).draggable({ 
	          	zIndex: 1070,
	          	revert: true, 
	          	revertDuration: 0  
	        });
    	});
    }
    ini_events($('#external-events div.external-event'));

 	var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
        
	$.ajax({
	    url : root + '/personal/getDataEvento',
	    type : 'GET',
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
		      	selectable: true,
		      	selectHelper: true,
		      	editable: true,
		      	eventLimit: true,
		      	droppable: true,
		      	events: json.result,
	      		// events: $.parseJSON(data),
		      	select: function(start, end){
		        	var copiedEventObject = $.extend({});
		      		swal({
					  	title: "Agenda!",
					  	text: "Nueva Nota Agenda:",
					  	type: "input",
					 	showCancelButton: true,
					  	closeOnConfirm: false,
					  	animation: "slide-from-top",
					  	inputPlaceholder: "Ingrese Atividad"
					},
					function(inputValue){
					  	if (inputValue === false) return false;
					  
					  	if (inputValue === "") {
					    	swal.showInputError("Es Necesario Ingresar Una Accion!");
					    	return false
					 	}
					 	copiedEventObject.title = inputValue;
				  		copiedEventObject.start = start;
			        	copiedEventObject.end = end;
			        	copiedEventObject.allDay = true;

			        	RegistarEvento(copiedEventObject.title, start.format(), end.format(),"#0073b7", "Agenda");

			        	$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
					  
					  	swal("Nota!", "" + inputValue, "success");
					});
	      		},
		      	eventDrop: function(event, delta, revertFunct)
		      	{
		      		console.log(event.title+ " "+event.start.format());
		      		UpdateEvento()
		      	},
			    drop: function (date, allDay) { 
			        var originalEventObject = $(this).data('eventObject');
			        var copiedEventObject = $.extend({}, originalEventObject);
			        var color = $(this).css("background-color");
			        var border = $(this).css("border-color");

			      	swal({
					  	title: copiedEventObject.title+"!",
					  	text: "Seleccione Personal:",
					  	type: "input",
					  	showCancelButton: true,
					  	closeOnConfirm: false,
					  	animation: "slide-from-top",
					  	inputPlaceholder: "Nombre Personal"
					},
					function(inputValue){
					  	if (inputValue === false) return false;
					  
					  	if (inputValue === "") {
					    	swal.showInputError("Ingrese el nombre de un personal!");
					    	return false
					  	}
					  	var title = copiedEventObject.title;
					  	copiedEventObject.title =copiedEventObject.title +" "+ inputValue;
					  	copiedEventObject.start = date;
				        copiedEventObject.end = date;
				        copiedEventObject.allDay = allDay;
				        copiedEventObject.backgroundColor = color;
				        copiedEventObject.borderColor = border;
				        RegistarEvento(title, copiedEventObject.start.format(), copiedEventObject.end.format(),color, inputValue);

				        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
					  	swal("Exito!", "Se Registro: " + inputValue, "success");

					});

			        if ($('#drop-remove').is(':checked')) {
			          $(this).remove();
			        }
			    }
	   		});
      	}
    }
  }); 


    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; 
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      	e.preventDefault();
      	 currColor = $(this).css("color");
      	$('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });

    $("#add-new-event").click(function (e) {
      	e.preventDefault();
      	var val = $("#new-event").val();
      	if (val.length == 0) {
        	return;
      	}
      	var event = $("<div />");
      	event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      	event.html(val);
      	$('#external-events').prepend(event);
      	ini_events(event);
      	$("#new-event").val("");
    });

 });

function RegistarEvento(title, start, end, color, usuario)
{
  $.ajax({
    url : root + '/personal/prueba',
    data: {title : title, f_inicio : start, f_fin : end, color : color, user : usuario},
    type : 'POST',
    dataType : 'json',
    success : function(json)
    {
      if (json.exito) 
      {
      	console.log("Se registro correctmete");
      } else {
      	console.log("Ucorrio un Error Inesperado");
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


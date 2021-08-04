// JavaScript Document
var destrito = $('#destrito');
var concelho = $('#concelho');
var freguesia = $('#freguesia');

$(destrito).change(function() {
  
  pedido(destrito.val(), concelho);
  
  if(destrito.val()==0){concelho.attr("disabled",'disabled');}else{concelho.removeAttr( "disabled" );}
  if(freguesia.val()>=0){freguesia.attr("disabled",'disabled').empty();}
   
});

$(concelho).change(function() {
  pedido(concelho.val(), freguesia);
  if(concelho.val()==0){freguesia.attr("disabled",'disabled');}else{freguesia.removeAttr( "disabled" );}
  freguesia.removeAttr( "disabled" )
});


var destrito_editar = $('#destrito_editar');
var concelho_editar = $('#concelho_editar');
var freguesia_editar = $('#freguesia_editar');

$(destrito_editar).change(function() {
  
  pedido(destrito_editar.val(), concelho_editar);
  
  if(destrito_editar.val()==0){concelho_editar.attr("disabled",'disabled');}else{concelho_editar.removeAttr( "disabled" );}
  if(freguesia_editar.val()>=0){freguesia_editar.attr("disabled",'disabled').empty();}
   
});

$(concelho_editar).change(function() {
  pedido(concelho_editar.val(), freguesia_editar);
  if(concelho_editar.val()==0){freguesia_editar.attr("disabled",'disabled');}else{freguesia_editar.removeAttr( "disabled" );}
  freguesia_editar.removeAttr( "disabled" )
});

var destrito_escondido = $('#destrito_escondido');
var concelho_escondido = $('#concelho_escondido');
var freguesia_escondido = $('#freguesia_escondido');

$(destrito_escondido).change(function() {
  
  pedido(destrito_escondido.val(), concelho_escondido);
  
  if(destrito_escondido.val()==0){concelho_escondido.hide();}else{concelho_escondido.show();}
  if(freguesia_escondido.val()>=0){freguesia_escondido.hide().empty();}
   
});

$(concelho_escondido).change(function() {
  pedido(concelho_escondido.val(), freguesia_escondido);
  if(concelho_escondido.val()==0){freguesia_escondido.hide();}else{freguesia_escondido.show();}
  freguesia_escondido.show();
});



function pedido(id, select_html) {
  // do stuff


	$.ajax({
	  url: baseurl+'zonas/get_zona_by_parent',
	  type: 'GET',
	  data: 'parent='+id,
	  success: function(data) {
		//called when successful
		//$('#ajaxphp-results').html(data);
		//alert('data');
		var obj = jQuery.parseJSON(data);
		select_html.empty();
		select_html.append('<option value>--Escolha--</option>');
			for (var i = 0; i < obj.length; i++) { 
				select_html.append('<option value="'+obj[i].id_zona+'">'+obj[i].zona+'</option>');
			}	
	  },
	  error: function(e) {
		//called when there is an error
		//console.log(e.message);
	  }
	});


}
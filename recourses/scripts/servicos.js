
var grid = new Datatable();
var id_familia;
var timer=null;


var TableDatatablesManaged = function () {

	
	var servicos = function() {
        

        grid.init({
            src: $("#datatable_projetos"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
				"language": {
                	"url": baseurl+"recourses/plugins/datatables/lingua/Portuguese.json"
            	},
				/*
				  buttons: [
                { extend: 'print', className: 'button-print', exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]}, title:'Movimentos' },
                { extend: 'copy', className: 'button-copiar', exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]} },
                { extend: 'pdf', className: 'button-pdf', exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]} , title:'Movimentos'},
                { extend: 'excel', className: 'button-excel', exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},title:'Movimentos' },
               
                {
                    text: 'Atualiza',
                    className: 'button-atualiza',
                    action: function ( e, dt, node, config ) {
                        //dt.ajax.reload();
                        alert('Custom Button');
                    }
                }
            ],*/

           
                "pageLength": 10, // default record count per page
               
       			
				"serverSide": true,
                "bStateSave": true,
				"ajax": {
                    "url": baseurl+'servicos/get_servicos_table/', // ajax source
                    "type": 'GET',
                  /* "data": function ( d ) {
                        return $.extend( {}, d, {
                          "concluido": $('#concluido_estado').val()
                        } );
                      }*/
                },
				
				
				"drawCallback": function( settings ) {
					$(".remove_servico").confirmation({singleton: true, popout: true});
        			UIConfirmations.init();
                },
                
				 "columnDefs": [ 
                    { "name": "estado",  "targets": 0, "orderable": true },
                    { "name": "cor",  "targets": 1, "orderable": true },
                    { "name": "ordem",  "targets": 2, "orderable": true },
					
					
				],
				
				"lengthMenu": [
                    [10, 20, 50, 100, 150,-1],
                    [10, 20, 50, 100, 150,'Todos'] // change per page values here 
                ],
                "order": [
                    [1, "asc"]
                ], // set first column as a default sort by asc
            
			}
        });
		$('.ferramentas > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            grid.getDataTable().button(action).trigger();
        });
		
		 $('.ferramentas > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            grid.getDataTable().button(action).trigger();
        });
         // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });
    }
	
	

 	

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            
            servicos();
            
            //initTable3();
        }

    };

}();

var novo = function() {
    // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        //alert("NOVO");
        var form1 = $('#form_novo_servico');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        var valid = $('.alert-info', form1);
        var error_bd = $('.erro', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                select_multi: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                }
            },
        
            rules: {
                tipo: {
                  
                    required: true,
                    
                },
                cor: {
                   
                    required: true,
                   
                },
              
                ordem: {
                    
                    required: true,
                    number:true,
                    
                },
                
            },

               invalidHandler:function(event, validator){ //display error alert on form submit              
                valid.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },

            highlight:function(element){ // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight:function(element){ // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success:function(label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler:function(form){
              
                error1.hide();
                valid.show();	
                //form.preventDefault();
                //this.preventDefault();
                
                /*var content = $('#summernote_1').code();
                 var formData = new FormData($(form1)[0]);
                    formData.append("noticia", content);*/
                
                
                $.ajax({
                     
                    url: baseurl+'servicos/novo_servico/',
                    type: "POST",
                    data:  new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false, 
                    
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);
                        grid.getDataTable().ajax.reload(null,true);
                        valid.hide();
                        App.scrollTo(success1, -200);
                        $('#novo_servico').modal('hide');
                        form.reset();    
                       
                        
                        //location.reload();
                        //alert('ok');
                        
                    }            
                });
                
                
                
                
            }
        });
}




function visivel_servico(estado, elemento, id){
	//var id = $(this).attr('categoria');
	//var tabela= $(elemento).parent('td').parent('tr');
	//alert(td_tabela);
	//var id_pergunta = tabela.children('td:eq(1)').html();
	var campo_atualizar = $(elemento).parent('td');
	
	var campo;
	
	
	$.ajax({
		
		url: baseurl+'servicos/muda_estado/?id_servico='+id+'&estado='+estado,
		type: "GET",
		//data: new FormData(form),
    	contentType: false,
        cache: false,
        processData:false, 
		success: function(response) {
		
			var obj = jQuery.parseJSON(response);
							//alert('ok');
			if(obj){
				
				if(estado==1){
					
					campo='<a class="btn btn-sm green" onclick="visivel_servico(0, this, '+id+');"><i class="fa fa-eye"></i> Ativo</a>';
					
				}else{
					
					campo='<a class="btn btn-sm yellow" onclick="visivel_servico(1, this, '+id+');"><i class="fa fa-eye-slash"></i> Inativo</a>';
					
					}
				
				campo_atualizar.html(campo);	
				}				
		}            
	});
}
var id_servico=null;	
function editar(id){
	
	
	id_servico=id;
	
	$.ajax({
		url: baseurl+'servicos/servico_id',
		type: 'GET',
		data: 'id='+id,
		success: function(data) {
			
			var obj = jQuery.parseJSON(data);
			
			//console.log(obj);
			
			$('#edita_tipo').val(obj.tipo);
			$('#edita_cor').val(obj.cor);
			$("#edita_ordem").val(obj.ordem);
			
           
			
			var span_ativo = $('#ativo').parents('span');
			var span_inativo = $('#inativo').parents('span');
				
			span_ativo.removeClass( "checked" );
			span_inativo.removeClass( "checked" );
				
			if (obj.ativo=="1"){
				$('#ativo').prop('checked', 'checked');
				span_ativo.addClass( "checked" );
				$('#ativo').attr('checked', 'checked'); 
			}else{
				$('#inativo').prop('checked', 'checked');
				span_inativo.addClass( "checked" );	
			}
			
			
						
		
		atualiza();
	
		$('#edita_servico').modal('show');				
			
		
		},
		error: function(e) {
					
		}
});
}	



var atualiza = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation
			//alert(linha);
            var form1 = $('#form_edita_servico');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);
			var valid = $('.alert-info', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                messages: {
                    select_multi: {
                        maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                        minlength: jQuery.validator.format("At least {0} items must be selected")
                    }
                },
                rules: {
                    tipo: {
                      
                        required: true,
                        
                    },
                    cor: {
                       
                        required: true,
                       
                    },
                  
                    ordem: {
                        
                        required: true,
                        number:true,
                        
                    },
                    
                },


               	invalidHandler:function(event, validator){ //display error alert on form submit              
                    valid.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                highlight:function(element){ // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight:function(element){ // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success:function(label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler:function(form){
                    valid.show();
                    error1.hide();
					
					$.ajax({
						 
						url: baseurl+'servicos/edita_servico/?id='+id_servico,
						
            			
						type: "POST",
						data: new FormData(form),
    					contentType: false,
        				cache: false,
        				processData:false, 
						
						success: function(response) {
							var obj = jQuery.parseJSON(response);
                                grid.getDataTable().ajax.reload(null,true);
								$('#edita_servico').modal('hide');
                                valid.hide();
                                form.reset();
								
							
							//}
						}            
					});
					
                }
            });
	}
var ComponentsBootstrapSelect = function () {
    
        var handleBootstrapSelect = function() {
            
            
            
             $('.marcas').selectpicker({
                iconBase: 'fa',
                tickIcon: 'fa-check',
                noneSelectedText: 'Escolha as Marca',
                selectAllText:'<i class="fa fa-check-square-o"></i>',
                deselectAllText:'<i class="fa fa-square-o"></i>',
                noneResultsText:'Não foi encontrado nenhuma correspondência',
                countSelectedText:'{0} Itens Selecionados',
            });
        
            
        }
    
        return {
            //main function to initiate the module
            init: function () {      
                handleBootstrapSelect();
            }
        };
    
    }();



    var UIConfirmations = function () {

        var handleSample = function () {
            $('.remove_servico').on('confirmed.bs.confirmation', function (e) {
              
               var id = $(this).attr('servico');
               tipo=$(this).parents('tr').find('td:eq(0)').html();
              
               $.ajax({
                    url: baseurl+'servicos/remove_servico',
                    type: 'GET',
                    data: 'id='+id,
                    success: function(data) {
                     //alert('ENTROU');
                     
                     
                        $('#servico_apagado').html('<b>'+tipo+'</b>');
                        esconde($('.alert_apaga_servico'));
                        
                        $('.alert_servico_removido').show();
                        grid.getDataTable().ajax.reload();
                        if (timer) {
                            clearTimeout(timer); //cancel the previous timer.
                            timer = null;
                        }
                        
                        timer = setTimeout(function(){esconde($('.alert_servico_removido'))}, 8000); 
                      
                        
                    },
                    error: function(e) {
                      
                    }
                  });
               
            });
              
            $(".remove_servico").on('show.bs.confirmation', function () {
              
              tipo=$(this).parents('tr').find('td:eq(0)').html();
             
              
              
              if (timer) {
                  clearTimeout(timer); //cancel the previous timer.
                  timer = null;
              }
              
              $('#servico_apagar').html('<b>'+tipo+'</b>');
              
              $(".alert_apaga_servico").show();
              if (timer) {
                  clearTimeout(timer); //cancel the previous timer.
                  timer = null;
              }
              timer = setTimeout(function(){esconde($('.alert_apaga_servico'))}, 8000);
              
              App.scrollTo($(".alert_apaga_servico"), 0);
            
                  
  
  
          });   
          $(".remove_servico").on('hide.bs.confirmation', function () {
               /*$(".alert_apaga_equipamento").hide();*/
          });   
      }
  
  
      return {
          //main function to initiate the module
          init: function () {
  
             handleSample();
  
          }
  
      };
  
  }();

  var esconde = function(elemento){

	elemento.hide();
}


var ComponentsColorPickers = function() {

    var handleColorPicker = function () {
        if (!jQuery().colorpicker) {
            return;
        }
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
        $('.colorpicker-rgba').colorpicker();
    }

    var handleMiniColors = function() {
        $('.demo').each(function() {
            //
            // Dear reader, it's actually very easy to initialize MiniColors. For example:
            //
            //  $(selector).minicolors();
            //
            // The way I've done it below is just for the demo, so don't get confused
            // by it. Also, data- attributes aren't supported at this time...they're
            // only used for this demo.
            //
            $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                defaultValue: $(this).attr('data-defaultValue') || '',
                inline: $(this).attr('data-inline') === 'true',
                letterCase: $(this).attr('data-letterCase') || 'lowercase',
                opacity: $(this).attr('data-opacity'),
                position: $(this).attr('data-position') || 'bottom left',
                change: function(hex, opacity) {
                    if (!hex) return;
                    if (opacity) hex += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(hex);
                    }
                },
                theme: 'bootstrap'
            });

        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleMiniColors();
            handleColorPicker();
        }
    };

}();


if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {       
        
        TableDatatablesManaged.init(); // CARREGA TABELA DOS MOVIMENTOS
        ComponentsColorPickers.init();
        novo();
        //ComponentsBootstrapSelect.init();
        //ComponentsDateTimePickers.init();
        //novo();
        //UIConfirmations.init();
        
    });
}

var grid = new Datatable();
var id_familia;
var timer=null;

$('.js-example-basic-multiple').select2();


var TableDatatablesManaged = function () {

	
	var stocks_equipamentos = function() {
        

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
				buttons: [
                { extend: 'print', className: 'button-print', 
				
					exportOptions: {
                    	columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ],
                	},
					
					title: 'Adjudicações ',
                	
				},
                { extend: 'copy', className: 'button-copiar' , 
				
					exportOptions: {
                    	columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ],
                		}, 
					title: 'Adjudicações ',	
				},
                { extend: 'pdf', className: 'button-pdf', 
				
					exportOptions: {
                    	columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ],
                		}, 
					extend: 'pdfHtml5',	
					title: 'Adjudicações ',
				},
                { extend: 'excel', className: 'button-excel', 
				
					exportOptions: {
                    	columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ],
                		}, 
					title: 'Adjudicações ',
				},
                /*{ extend: 'csv', className: 'btn default' },*/
                {
                    text: 'Atualiza',
                    className: 'button-atualiza',
                    action: function ( e, dt, node, config ) {
                        //dt.ajax.reload();
                        alert('Custom Button');
                    }
                }
            ],

           
                "pageLength": 10, // default record count per page
               
       			
				"serverSide": true,
                "bStateSave": true,
				"ajax": {
                    "url": baseurl+'projetos/get_projetos_table/?concluido='+$('#concluido_estado').val(), // ajax source
                    "type": 'POST',
                  /* "data": function ( d ) {
                        return $.extend( {}, d, {
                          "concluido": $('#concluido_estado').val()
                        } );
                      }*/
                },
				
				
				"drawCallback": function( settings ) {
					$(".remove_projeto").confirmation({singleton: true, popout: true});
        			UIConfirmations.init();
                },
                
				 "columnDefs": [ 
                    { "name": "concluido",  "targets": 0, "orderable": true },
                    { "name": "id_estado",  "targets": 1, "orderable": true },
                    { "name": "id_tipo",  "targets": 2, "orderable": true },
                    { "name": "cliente", "targets": 3, "orderable": true },
                    { "name": "instalacao", "targets": 4, "orderable": true },
                    { "name": "projeto", "targets": 5, "orderable": true},
                    { "name": "total", "targets": 6, "orderable": true},
                    { "name": "data_inicio", "targets": 7, "orderable": true  },
                    { "name": "data_conclusao", "targets": 8, "orderable": true  },
                    { "name": "data_concluido", "targets": 9, "orderable": true  },
                    { "name": "valor_fatura", "targets": 10, "orderable": true  },
                    { "name": "criado_por", "targets": 11, "orderable": true  },
                    { "name": "ativo", "targets": 12, "orderable": true  },
					{ "name": "actions", "targets": 13, "orderable": false, "searchble":false },
					
				],
				
				"lengthMenu": [
                    [10, 20, 50, 100, 150,-1],
                    [10, 20, 50, 100, 150,'Todos'] // change per page values here 
                ],
                "order": [
                    [2, "asc"]
                ], // set first column as a default sort by asc
            
			}
        });


        $("#filtrar").on('click', function(){
            grid.getDataTable().ajax.reload();
        })
		
		
		
		
		
		
		
		$('#equipamentos_instalacao_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            $("#datatable_projetos").DataTable().button(action).trigger();
        });
		
		 $('#equipamentos_instalacao > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            $("#datatable_projetos").DataTable().button(action).trigger();
        });
         // handle group actionsubmit button click
        /*grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
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
        });*/
    }
	
	

 	

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            
            stocks_equipamentos();
            
            //initTable3();
        }

    };

}();

var novo = function() {
    // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        //alert("NOVO");
        var form1 = $('#form_novo_projeto');
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
                estado: {
                  
                    required: true,

                    
                },
                tipo: {
                   
                    required: true,
                   
                },
              
                cliente: {
              
                    required: true,
                    
                    
                },
                instalacao: {
               
                    required: true,
                    
                    
                },
                projeto: {
                    required: true,
                    
                },
                total: {
                    number: true,
                    
                },
                data_conclusao: {
                    required: true,
                    
                },
                ativo: {
                    required: true,
                    minlength: 1
                }
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
                    let formData = new FormData(form);
                    formData.append("nome_instalacao", $("#loops_instalacao option:selected").text()) 
                    formData.append("nome_cliente", $("#dropdown_cliente option:selected").text())
                
                
                $.ajax({
                     
                    url: baseurl+'projetos/novo_projeto/',
                    type: "POST",
                    data:  formData,
                    contentType: false,
                    cache: false,
                    processData:false, 
                    
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);
                        grid.getDataTable().ajax.reload(null,true);
                        valid.hide();
                        App.scrollTo(success1, -200);
                        $('#novo_projeto').modal('hide');
                        form.reset();      
                       
                        
                        //location.reload();
                        //alert('ok');
                        
                    }            
                });
                
                
                
                
            }
        });
}

var concluir_ajax = function() {
    // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

        var form1 = $('#form_concluir_projeto');
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
                estado: {
                  
                    required: true,
                    
                },
                concluir: {
                   
                    required: true,
                   
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
                
                
                
                $.ajax({
                     
                    url: baseurl+'projetos/concluir_projeto/?id='+id_projeto,
                    type: "POST",
                    data:  new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false, 
                    
                    success: function(response) {
                        var obj = jQuery.parseJSON(response);
                        grid.getDataTable().ajax.reload(null,true);
                        valid.hide();
                        $('#concluir_projeto').modal('hide');
                            
                       
                        
                        //location.reload();
                        //alert('ok');
                        
                    }            
                });
                
                
                
                
            }
        });
}


function visivel_projeto(estado, elemento, id){
	var campo_atualizar = $(elemento).parent('td');
	
	var campo;
	
	
	$.ajax({
		
		url: baseurl+'projetos/muda_estado/?id_projeto='+id+'&estado='+estado,
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
					
					campo='<a class="btn btn-sm green" onclick="visivel_projeto(0, this, '+id+');"><i class="fa fa-eye"></i> Ativo</a>';
					
				}else{
					
					campo='<a class="btn btn-sm yellow" onclick="visivel_projeto(1, this, '+id+');"><i class="fa fa-eye-slash"></i> Inativo</a>';
					
					}
				
				campo_atualizar.html(campo);	
				}				
		}            
	});
}
var id_projeto=null;	
function editar(id){
	
	
	id_projeto=id;
	
	$.ajax({
		url: baseurl+'projetos/projeto_id',
		type: 'GET',
		data: 'id='+id,
		success: function(data) {
			
			var obj = jQuery.parseJSON(data);
			
			//console.log(obj);
			
            $('#edita_cliente').val(obj.cliente);
            $('#edita_instalacao').val(obj.instalacao);
			$('#edita_projeto').val(obj.projeto);
            $("#edita_obs").val(obj.obs);
            $("#edita_total").val(obj.total);
			
            $('#edita_estado').val(obj.id_estado);
            $('#edita_tipo').val(obj.id_tipo);
			
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
			
			
			 $("#edita_estado").change(() => {
                if ($("#edita_estado").val() == "28") {

                    $("#estado_planeado").html(`
                        <div class="form-group">
                            <label class="col-md-2 control-label">Data Planeado</label>
                            <div class="col-md-10" onmouseenter="datetime()">
                                <input class="form-control form-filter form-control-inline date-picker" required id="date_picker_" type="text" value="" name="data_planeado" />
                            </div>
                        </div>
                    `)
                } else {
                    $("#estado_planeado").html('')
                }

            })

            $("#edita_estado").change(() => {
                if ($("#edita_estado").val() == "12") {

                    $("#estado_faturacao").html(`
                        <div class="form-group">
                            <label class="col-md-2 control-label">Data Concluido</label>
                            <div class="col-md-10" onmouseenter="datetime()">
                                <input class="form-control form-filter form-control-inline date-picker" required id="date_picker_" type="text" value="" name="data_faturacao" />
                            </div>
                        </div>

                        <div class="form-group" onmouseenter="total_()">
                            <label class="col-md-2 control-label">Valor Fatura</label>
                            <div class="col-md-10">
                            <input type="text" class="form-control form-filter total" required name="valor_fatura"/>
                            </div>
                        </div>
                    `)
                } else {
                    $("#estado_faturacao").html('')
                }

            })


             /* ----------------------------------------------------------------------------------------------------------------- */
            
            
             $("#edita_cliente").html('')
             $('#edita_cliente').selectpicker('refresh');
             $("#edita_cliente").html('<option value="'+ obj.id_cliente +'">'+ obj.cliente +'</option>')
             $('#edita_cliente').selectpicker('val', obj.id_cliente);
             /* ----------------------------------------------------------------------------------------------------------------- */
             
             
             $.ajax({
                 url: baseurl+'clientes/instalacao_cliente',
                 type: 'get',
                 data:{cliente: $("#edita_cliente").val()},
                 success: function(dados){
                     let instalacoes = $.parseJSON(dados);
                     //console.log(instalacoes)
                     $("#loops_instalacao_edit").html('')
                     
                     for(let i = 0; instalacoes.length > i; i++){
                   
                             $("#loops_instalacao_edit").append('<option value="'+ instalacoes[i].id_instalacao +'">'+ instalacoes[i].instalacao +'</option>')
                             
                     }
                     $("#loops_instalacao_edit").html('')
                     $('#loops_instalacao_edit').selectpicker('refresh');
                     $("#loops_instalacao_edit").html('<option value="'+ obj.id_instalacao +'">'+ obj.instalacao +'</option>')
                     $('#loops_instalacao_edit').selectpicker('val', obj.id_instalacao);
                     
                 
                 }
         
             })
 
             /* ----------------------------------------------------------------------------------------------------------------- */
	
		$('#editar_projeto').modal('show');				
			
		
		},
		error: function(e) {
					
		}
});
}	

function concluir(id){
    id_projeto=id;
    $.ajax({
		url: baseurl+'projetos/projeto_id',
		type: 'GET',
		data: 'id='+id,
		success: function(data) {
			
			var obj = jQuery.parseJSON(data);
			
            $('#concluir_estado').val(obj.id_estado);
            
            if(obj.concluido==1){
                $('#concluir_check').bootstrapSwitch('state', true);
               
            }else{
                $('#concluir_check').bootstrapSwitch('state', false);
            }
            
            
		$('#concluir_projeto').modal('show');				
		concluir_ajax();	
		
		},
		error: function(e) {
					
		}
});

}

var atualiza = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation
			//alert(linha);
            var form1 = $('#form_editar_projeto');
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
                    estado: {
                      
                        required: true,
                        
                    },
                    tipo: {
                       
                        required: true,
                       
                    },
                  
                    id_cliente: {
                        required: true,

                    },
                    id_instalacao: {
                        required: true,
  
                    },
                    projeto: {
                        required: true,
                        
                    },
                    total: {
                        number: true,
                        
                    },
                    ativo: {
                        required: true,
                        minlength: 1
                    }
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

                    let formData = new FormData(form);
                    formData.append("nome_instalacao", $("#loops_instalacao_edit option:selected").text()) 
                    formData.append("nome_cliente", $("#edita_cliente option:selected").text())
					
					$.ajax({
						 
						url: baseurl+'projetos/edita_projeto/?id='+id_projeto,
						
            			
						type: "POST",
						data: formData,
    					contentType: false,
        				cache: false,
        				processData:false, 
						
						success: function(response) {
							var obj = jQuery.parseJSON(response);
                                grid.getDataTable().ajax.reload(null,true);
								$('#editar_projeto').modal('hide');
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
            $('.remove_projeto').on('confirmed.bs.confirmation', function (e) {
              
               var id = $(this).attr('projeto');
               cliente=$(this).parents('tr').find('td:eq(3)').html();
               projeto=$(this).parents('tr').find('td:eq(4)').text();
               $.ajax({
                    url: baseurl+'projetos/remove_projeto',
                    type: 'GET',
                    data: 'id='+id,
                    success: function(data) {
                     //alert('ENTROU');
                     
                     
                        $('#projeto_apagado').html('<b>'+cliente+'-'+projeto+'</b>');
                        esconde($('.alert_apaga_projeto'));
                        
                        $('.alert_projeto_removido').show();
                        grid.getDataTable().ajax.reload();
                        if (timer) {
                            clearTimeout(timer); //cancel the previous timer.
                            timer = null;
                        }
                        
                        timer = setTimeout(function(){esconde($('.alert_projeto_removido'))}, 8000); 
                      
                        
                    },
                    error: function(e) {
                      
                    }
                  });
               
            });
              
            $(".remove_projeto").on('show.bs.confirmation', function () {
              
              cliente=$(this).parents('tr').find('td:eq(3)').html();
              projeto=$(this).parents('tr').find('td:eq(4)').text();
              
              
              if (timer) {
                  clearTimeout(timer); //cancel the previous timer.
                  timer = null;
              }
              
              $('#projeto_apagar').html('<b>'+cliente+'-'+projeto+'</b>');
              
              $(".alert_apaga_projeto").show();
              if (timer) {
                  clearTimeout(timer); //cancel the previous timer.
                  timer = null;
              }
              timer = setTimeout(function(){esconde($('.alert_apaga_projeto'))}, 8000);
              
              App.scrollTo($(".alert_apaga_artigo"), 0);
            
                  
  
  
          });   
          $(".remove_projeto").on('hide.bs.confirmation', function () {
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
var ComponentsDateTimePickers = function () {

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true, 
                language:"pt",
                todayBtn: true,
                format: "yyyy-mm-dd",
            });
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */
    
        // Workaround to fix datepicker position on window scroll
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
    }

  
    return {
        //main function to initiate the module
        init: function () {
            handleDatePickers();
           
        }
    };

}();

var ComponentsBootstrapTouchSpin = function() {

    var handleDemo = function() {

        $(".total").TouchSpin({
            min: 0.00,
            max: 999999999,
            step: 0.01,
            decimals: 2,
            stepinterval: 50,
            postfix: '€',
            maxboostedstep: 100,
            forcestepdivisibility:'round',
          
        });
    }
    return {
        //main function to initiate the module
        init: function() {
            handleDemo();
        },
        
    };

}();


if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {       
        
        TableDatatablesManaged.init(); // CARREGA TABELA DOS MOVIMENTOS
        ComponentsBootstrapSelect.init();
        ComponentsDateTimePickers.init();
        ComponentsBootstrapTouchSpin.init();
        novo();
        
        //UIConfirmations.init();
        
    });
}

function datetime() {
    $("#date_picker_").datepicker({
        orientation: "left",
        autoclose: true,
        language: "pt",
        todayBtn: true,
        format: "yyyy-mm-dd",


    });

}
function total_() {
    $(".total").TouchSpin({
        min: 0.00,
        max: 999999999,
        step: 0.01,
        decimals: 2,
        stepinterval: 50,
        postfix: '€',
        maxboostedstep: 100,
        forcestepdivisibility: 'round',

    });
}


function historico(id_projeto) {

    $.ajax({
        url: baseurl + "projetos/get_historico",
        type: "post",
        data: { id_projeto: id_projeto },
        success: function (resposta) {


            let resultado = $.parseJSON(resposta);
            let table = document.getElementById("h_projeto");
			
		$("#h_projeto").html(
             `<tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>`)

            for (let i = 0; resultado.length > i; i++) {

                let row = table.insertRow(0);
				
				let data_insercao = row.insertCell(0);
                let estado = row.insertCell(1);
                let tipo = row.insertCell(2);
                let cliente = row.insertCell(3);
                let instalacao = row.insertCell(4);
                let projeto = row.insertCell(5);
                let obs = row.insertCell(6);
				let valor = row.insertCell(7);
                let valor_fatura = row.insertCell(8);
                let nome = row.insertCell(9);
                let ativo = row.insertCell(10);

				data_insercao.innerHTML += resultado[i].data_insercao;
                estado.innerHTML += resultado[i].estado;
                tipo.innerHTML += resultado[i].tipo;
                cliente.innerHTML += resultado[i].cliente;
                instalacao.innerHTML += resultado[i].instalacao;
                projeto.innerHTML += resultado[i].projeto;
				obs.innerHTML += resultado[i].obs ? resultado[i].obs : "";
                valor.innerHTML += resultado[i].total;
                valor_fatura.innerHTML += resultado[i].valor_fatura ? resultado[i].valor_fatura += "€"  : "Sem Valor";
                nome.innerHTML += resultado[i].nome;
                ativo.innerHTML += resultado[i].ativo ? "Sim" : "Não";
            }

            $('#historico_proj').modal('show');
        }
    })

}

$(document).on('keyup', '.search_clientes .bs-searchbox input', function (e) {
    $("#dropdown_cliente").html('')
    let nome_cliente = e.target.value;
    if(nome_cliente.length > 2){
        $.ajax({
            url: baseurl + "clientes/clientes_ativos_agendar",
            type: "get",
            data: {q: nome_cliente },
            success: function(clientes_bruto){
                $("#dropdown_cliente").html('')
                let clientes = $.parseJSON(clientes_bruto);
                console.log(clientes)
                for(let i = 0; clientes.length > i; i++){
                    $("#dropdown_cliente").append('<option value="'+ clientes[i].id +'">'+ clientes[i].text +'</option>')
                }
                $('#dropdown_cliente').selectpicker('refresh');
            }
        })
    }
    $('#dropdown_cliente').selectpicker('refresh');
});



$("#dropdown_cliente").on('change', function(){
    

    $("#loops_instalacao").html('')

    $.ajax({
        url: baseurl+'clientes/instalacao_cliente',
        type: 'get',
        data:{cliente: $("#dropdown_cliente").val()},
        success: function(dados){
            let instalacoes = $.parseJSON(dados);
            console.log(instalacoes)
           
            
            for(let i = 0; instalacoes.length > i; i++){
          
                    $("#loops_instalacao").append('<option value="'+ instalacoes[i].id_instalacao +'">'+ instalacoes[i].instalacao +'</option>')
                    
            }
            $('#loops_instalacao').selectpicker('refresh');
            
        
        }

    })
    
})

/* ------------------------------------------------------------------------------------------------------------------ */
$("#edita_cliente").change( function(){
    

    $("#loops_instalacao_edit").html('')

    $.ajax({
        url: baseurl+'clientes/instalacao_cliente',
        type: 'get',
        data:{cliente: $("#edita_cliente").val()},
        success: function(dados){
            let instalacoes = $.parseJSON(dados);
            console.log(instalacoes)
            $("#loops_instalacao_edit").html('')
            
            for(let i = 0; instalacoes.length > i; i++){
          
                    $("#loops_instalacao_edit").append('<option value="'+ instalacoes[i].id_instalacao +'">'+ instalacoes[i].instalacao +'</option>')
                    
            }
            $('#loops_instalacao_edit').selectpicker('refresh');
            
        
        }

    })
    $('#loops_instalacao_edit').selectpicker('refresh');
})

/* ------------------------------------------------------------------------------------------------------------------ */

$(document).on('keyup', '.search_clientes_edit .bs-searchbox input', function (e) {
    $("#edita_cliente").html('')
    let nome_cliente = e.target.value;
    

    if(nome_cliente.length > 2){
        
        $.ajax({
            url: baseurl + "clientes/clientes_ativos_agendar",
            type: "get",
            data: {q: nome_cliente },
            success: function(clientes_bruto){
                $("#edita_cliente").html('')
               
                let clientes = $.parseJSON(clientes_bruto);
                console.log(clientes)
    
    
                for(let i = 0; clientes.length > i; i++){
            
                    $("#edita_cliente").append('<option value="'+ clientes[i].id +'">'+ clientes[i].text +'</option>')
                    
                }
                $('#edita_cliente').selectpicker('refresh');

    
            }
        })

    }
    $('#edita_cliente').selectpicker('refresh');
    
})

function fornecimento(id_projeto, id_instalacao){
    if(!id_instalacao){
        Swal.fire('Coloque cliente e instalação na adjudicação', '', 'error')
    }else{
        location.href = baseurl+"fornecimento/armazens_disponiveis/"+id_projeto; 
    }
    
    
}
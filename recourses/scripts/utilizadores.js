var UIConfirmations = function () {

    var handleSample = function () {
		
		
        
        $(".remove_utilizador").on('confirmed.bs.confirmation', function (e) {
			
 			var id = $(this).attr('utilizador');
			var tr_tabela= $(this).parents('tr');
			
			//console.log(tr_tabela);
			 $.ajax({
				  url: baseurl+'utilizadores/remove_utilizador/',
				  type: 'GET',
				  data: 'id_utilizador='+id,
				  success: function(data) {
					
					tr_tabela.remove();
					
					$(".alert_utilizador_apagada").show();
					$(".alert_apaga_utilizador").hide();
					
				  },
				  error: function(e) {
					
				  }
				});
			 
        	});
		 $(".remove_utilizador").on('show.bs.confirmation', function () {
            $(".alert_apaga_utilizador").show();
        });   
        $(".remove_utilizador").on('canceled.bs.confirmation', function () {
             $(".alert_apaga_utilizador").hide();
        });   
    }


    return {
        //main function to initiate the module
        init: function () {

           handleSample();

        }

    };

}();


	

var TableDatatablesManaged = function () {

    var initTable1 = function () {

        var table = $('#sample_1');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
           

            // Or you can use remote translation file
           "language": {
               url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
			   //url: baserul+'admin_assets/global/plugins/datatables/Portuguese.json'
            },

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "columnDefs": [ {
                "targets": 0,
                "orderable": false,
                "searchable": false
            }],

            "lengthMenu": [
                [ 15, 20, -1],
                [ 15, 20, "Todas"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,            
            "pagingType": "bootstrap_full_number",
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "desc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sample_1_wrapper');

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
            jQuery.uniform.update(set);
        });

        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });
    }

   

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            initTable1();
            
        }

    };

}();

var novo = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_novo_utilizador');
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
                    tipo_utilizador: {
                      
                        required: true,
						
                    },
					email: {
                        email:true,
						required: true,
						remote: baseurl+'utilizadores/verify_email'
                    },
                  
                    password: {
						minlength: 8,
                        required: true,
                        
						
                    },
                    nome: {
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
					
					
					$.ajax({
						 
						url: baseurl+'utilizadores/novo_utilizador/',
						type: "POST",
						data:  new FormData(form),
    					contentType: false,
        				cache: false,
        				processData:false, 
						
						success: function(response) {
							var obj = jQuery.parseJSON(response);
							
							if(obj.erro==1){
								valid.hide();
								error_bd.find("span").text(obj.texto);
								error_bd.show();
								App.scrollTo(success1, -200);
								
							}else{
								
								  $('#novo_utilizador').modal('hide');
								 location.reload();	
							}
							
							//location.reload();
							//alert('ok');
							
						}            
					});
					
					
					
					
                }
            });
	}
var id_utilizador=null;	
var atualiza = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation
			//alert(linha);
            var form1 = $('#form_editar_utilizador');
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
                /*
                rules: {
                    titulo: {
                        minlength: 2,
                        required: true,
						
						remote: {
                			url:  baseurl+'admin/noticias/verifica_url/',
							cache: false,
                			data: {
								 id: function(){
								 return id_noticia;
								}                                
							} 
							
            			},
					
                    },
					noticia: {
                        minlength: 2,
                        required: true
                    },
                  primeira_pagina: {
                        required: true,
                        minlength: 1
                    },
					ativo: {
                        required: true,
                        minlength: 1
                    }
                },

                */

               rules: {
                tipo_utilizador: {
                  
                    required: true,
                    
                },
                email: {
                    email:true,
                    required: true,
                    remote: baseurl+'utilizadores/verify_email_update/?utilizador='+id_utilizador
                },
              
                password: {
                    minlength: 8,
                    required: false,
                    
                    
                },
                nome: {
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
                    valid.show();
                    error1.hide();
					//var content = $('#summernote_editar').code();
				    //var formData = new FormData($(form1)[0]);
					//formData.append("noticia", content);
					$.ajax({
						url: baseurl+'utilizadores/edita_utilizador/?id_utilizador='+id_utilizador,
						type: "POST",
						data:  new FormData(form),
    					contentType: false,
        				cache: false,
        				processData:false, 
						
						success: function(response) {
							var obj = jQuery.parseJSON(response);
						
								valid.hide();
								
							
								form.reset();
								//$('#editar_pergunta').modal('hide');
								location.reload();
							
							//}
						}            
					});
					
                }
            });
	}	

function visivel(estado, elemento, id){
	//var id = $(this).attr('categoria');
	//var tabela= $(elemento).parent('td').parent('tr');
	//alert(td_tabela);
	//var id_pergunta = tabela.children('td:eq(1)').html();
	var campo_atualizar = $(elemento).parent('td');
	
	var campo;
	
	
	$.ajax({
		
		url: baseurl+'utilizadores/muda_estado/?id_utilizador='+id+'&estado='+estado,
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
					
					campo='<a class="btn btn-sm green" onclick="visivel(0, this, '+id+');"><i class="fa fa-eye"></i> Ativo</a>';
					
				}else{
					
					campo='<a class="btn btn-sm yellow" onclick="visivel(1, this, '+id+');"><i class="fa fa-eye-slash"></i> Inativo</a>';
					
					}
				
				campo_atualizar.html(campo);	
				}				
		}            
	});
					
					
					
	
	}
	

function editar(id){
	
	
	id_utilizador=id;
	//alert(id);
	$.ajax({
		url: baseurl+'utilizadores/utilizador_id',
		type: 'GET',
		data: 'id='+id,
		success: function(data) {
			
			var obj = jQuery.parseJSON(data);
			
			console.log(obj);
			
            $("#tipo_utilizador_edita").val(obj.id_tipo).change();
            $('#email_edita').val(obj.email);
            $('#nome_edita').val(obj.nome);


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

		
	
		$('#editar_utilizador').modal('show');				
		atualiza();	
		
		},
		error: function(e) {
					
		}
});
}		

var handleWysihtml5 = function() {
        if (!jQuery().wysihtml5) {
            
            return;
        }

        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5({
                "stylesheets": [baseurl+"assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
            });
        }
    }

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
         TableDatatablesManaged.init();
		 UIConfirmations.init();
		 handleWysihtml5();
         //handleSummernote();
		 novo();
		 
		 
    });
}
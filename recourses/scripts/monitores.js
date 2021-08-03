var grid = new Datatable();
var id_familia;
var timer=null;



var TableDatatablesManaged = function () {

	
	var monitores = function() {
        

        grid.init({
            src: $("#datatable_monitor"),
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

           
                "pageLength": 8, // default record count per page
               
       			
				"serverSide": true,
               
				"ajax": {
                    "url": baseurl+'projetos/get_monitores',
                    "type": 'GET',
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                          "id_estado": $('#estado_filtro').val(),
                          "id_tipo": $('#tipo_filtro').val(),
                        } );
                      }
                },
               /* "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                        //console.log(aData);
                        $('td', nRow).css('background-color', aData[7]);
                   
                     
                },*/
				
				"initComplete": function(settings, json) {
					/*$(".remove_projeto").confirmation({singleton: true, popout: true});
                    UIConfirmations.init();*/
                    primeira_vez();
                    //alert('muda_pagina');
                },
                
				 "columnDefs": [ 
                    
                    { "name": "id_estado",  "targets": 0, "orderable": true },
                    { "name": "id_tipo",  "targets": 1, "orderable": true },
                    { "name": "cliente", "targets": 2, "orderable": true },
                    { "name": "instalacao", "targets": 3, "orderable": true },
                    { "name": "projeto", "targets": 4, "orderable": true  },
                    { "name": "total", "targets": 5, "orderable": true  },
                    { "name": "data_inicio", "targets": 6, "orderable": true  },
                    { "name": "data_conclusao", "targets": 7, "orderable": true  },
                    //{ "name": "data_concluido", "targets": 7, "orderable": true  },
                    //{ "name": "criado_por", "targets": 6, "orderable": true  },
                   // { "name": "cor_estado", "targets": 7, "orderable": false, "visible":false  },
                    
					
				],
                "bSortClasses": false,
				"lengthMenu": [
                    [8,11, 20, 50, 100, 150,-1],
                    [8,11, 20, 50, 100, 150,'Todos'] // change per page values here 
                ],
                /*"order": [
                    [1, "asc"]
                ], */// set first column as a default sort by asc
            
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
            
            monitores();
            
            //initTable3();
        }

    };

}();

$( "#estado_filtro, #tipo_filtro" ).change(function() {

    grid.getDataTable().ajax.reload(null, true);
    //alert( "Handler for .change() called." );
  });
//var table = grid.getDataTable();
var pagina_atual=1;

function pageInfo(){
   // console.log(grid.getDataTable().page.info());
   //grid.getDataTable().ajax.reload();
    return  grid.getDataTable().page.info();
}
function primeira_vez(){
    var interval = setInterval(function(){
       
        muda_pagina();
        
       // clearInterval(interval);
    }, 10000);
    //30 SEGUNDOS
    // 5000
}
function muda_pagina(){
    //pageInfo
    //console.log(pageInfo());
    
    if(pagina_atual===pageInfo().pages){
        grid.getDataTable().page( 'first' ).draw( 'page' );
        pagina_atual=1;
    }else{
        //console.log('ENTROU');
        pagina_atual=pagina_atual+1;
        grid.getDataTable().page( 'next' ).draw( 'page' );
       
    }
    //console.log(pagina_atual);
        
    
}

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {       
        
        TableDatatablesManaged.init(); // CARREGA TABELA DOS MOVIMENTOS
        
        
    });
}
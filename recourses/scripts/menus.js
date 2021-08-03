

var Menus = function () {

    var urlName = function () {
		
		//alert('ENTROU');
		var url=$(location).attr('href');
		//alert(url);
		
		var encontrou=$('.page-sidebar .page-sidebar-menu a[href$="'+url+'"]').parents();
		//console.log(encontrou.html());
		  if (encontrou.hasClass("nav-item")) {
			  
			 // alert("ok");
			  adicionaClass(encontrou);
		  }else{
			  
			 // alert("Não tem");
		  }
		
    }
	
	var adicionaClass=function (elemento){
		
		
		//open
		$( elemento, ".page-sidebar-menu .nav-item").addClass("start active");
		
		
		
	}

    return {
        //main function to initiate the module
        init: function () {

        urlName();

        }

    };

}();

/*if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
        TableDatatablesManaged2.init();
		 ComponentsBootstrapSelect.init(); 
		
		UIConfirmations.init();
		
    });
}*/

Menus.init();
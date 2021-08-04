let table_aceitar_movimento = $("#table_aceitar_movimento").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "armazens/get_tabela_aceitar_movimento",
		type: "POST",
		data: function (d) {
			d.id_armazem = $("#id_armazem_saida").val();
			d.id_movimento = $("#id_movimento").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
	drawCallback: function (oSettings, json) {

		//$(".movimentar_quantidade").inputSpinner()
		
	},
});

function aceitar_artigo(id_artigo_movimento, id_movimento, id_artigo, quantidade){
	$.ajax({
		url: baseurl+"armazens/aceitar_artigo",
		type:"get",
		data: {id_artigo_movimento: id_artigo_movimento, id_movimento: id_movimento, id_artigo:id_artigo, quantidade:quantidade, armazem_entrada: $("#id_armazem_entrada").val()},
		success: function(d){
			table_aceitar_movimento.ajax.reload()
		}
	})
}

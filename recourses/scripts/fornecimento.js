let tabela_armazens_fornecimento = $("#table_armazens_fornecimento").DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
    },
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "fornecimento/get_tabela_armazens_disponiveis/"+$("#id_projeto").val(),
        type: "POST",
       /*  data: function(d){
            d.id_cliente = $("#id_cliente").val();
        } */
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});


let table_artigos_armazem = $("#table_artigos_armazem").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "fornecimento/get_tabela_stock_armazem",
		type: "POST",
		data: function (d) {
			d.id_armazem = $("#id_armazem").val();
			d.id_cliente = $("#id_cliente").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
    ],
    drawCallback: function (oSettings, json) {

        $(".quantidade_fornecimento").inputSpinner()
	},
});

function fornecer_artigo_cliente(id_artigo, preco) {

    console.log(preco)

	if ($("#id_artigo" + id_artigo).val() == "") {
		Swal.fire("Insira quantidade", "", "error");
		return;
    }

    if (preco == undefined) {
		Swal.fire("Insira preço na tabela de preços do cliente", "", "error");
		return;
    }

	$.ajax({
		url: baseurl + "fornecimento/adicionar_fornecimento_artigo",
		type: "post",
		data: {
			id_fornecimento: $("#id_fornecimento").val(),
			id_artigo: id_artigo,
            quantidade: $("#id_artigo" + id_artigo).val(),
            preco: preco,
            id_armazem:$("#id_armazem").val()
		},
		success: function (d) {
			console.log(d);
			table_artigos_armazem.ajax.reload();
			table_fornecimento_cliente.ajax.reload();
			$("#id_artigo" + id_artigo).val("");
			toastr.success("Artigo Adicionado");
		},
	});
}

let table_fornecimento_cliente = $("#table_fornecimento_cliente").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "fornecimento/get_tabela_fornecimento_cliente",
		type: "POST",
		data: function (d) {
			d.id_fornecimento = $("#id_fornecimento").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
    ],
});

function apagar_fornecimento_material(id_artigo_fornecido, id_artigo, quantidade){

	Swal.fire({
		title: "Tem a certeza que quer apagar?",
		text: "",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sim, apaga!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: baseurl + "fornecimento/apagar_artigo_fornecido",
				type: "POST",
				data: { 
					id_artigo_fornecido: id_artigo_fornecido,
					id_artigo: id_artigo,
					id_armazem: $("#id_armazem").val(),
					quantidade: quantidade
				},
				success: function () {
					Swal.fire("Material Apagado!", "", "success");
					table_fornecimento_cliente.ajax.reload();
				},
			});
		}
	});
	
}

function fechar_fornecimento(id_fornecimento, fechar){
	Swal.fire({
		title: "Pretende fechar?",
		text: "Após fechar não será possível voltar a abrir para adicionar mais material",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Sim, fechar!",
	}).then((result) => {
		if (result.value) {
			$.ajax({
				url: baseurl + "fornecimento/fechar_artigo_fornecido",
				type: "POST",
				data: { 
					id_fornecimento: id_fornecimento,
					
				},
				success: function () {
					Swal.fire("Fornecimento fechado!", "", "success");
					location.reload();
				},
			});
		}
	});
}


$("#artigos_selecionados" ).load(baseurl+'armazens/load_div_artigos/'+$("#id_movimento").val(), function() {
	console.log("Carregado");
  });
  
let tabela_armazens = $("#table_armazens").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "armazens/get_tabela_armazens",
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

let tabela_entrada_stock = $("#table_entrada_stock").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "armazens/get_tabela_entrada_stock",
		type: "POST",
		data: function (d) {
			d.id_armazem = $("#id_armazem").val();
			d.estado = $("#estado").val();
			d.nr_fatura = $("#nr_fatura").val();
			d.data_fatura = $("#data_fatura").val();
			d.valor = $("#valor").val();
			d.criado_por = $("#criado_por").val();
			d.fechado_por = $("#fechado_por").val();
			d.observacoes = $("#observacoes_entrada").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});

$("#pesquisar_entradas").on("click", function () {
	tabela_entrada_stock.ajax.reload();
});

$("#limpar_entradas").on("click", function () {
	$("#estado").val("");
	$("#nr_fatura").val("");
	$("#data_fatura").val("");
	$("#valor").val("");
	$("#criado_por").val("");
	$("#fechado_por").val("");
	$("#observacoes_entrada").val("");

	tabela_entrada_stock.ajax.reload();
});

$("#form_nova_entrada").submit(function (e) {
	e.preventDefault();
	let formData = new FormData(this);
	$.ajax({
		url: baseurl + "armazens/adicionarEntrada",
		type: "post",
		contentType: false,
		cache: false,
		processData: false,
		data: formData,
		success: function (d) {
            console.log(d);
            let id = $.parseJSON(d)

			if (d) {
				$("#nova_entrada").modal("hide");
				tabela_entrada_stock.ajax.reload();
				$("#form_nova_entrada").trigger("reset");
                //Swal.fire("Entrada de Stocks!", "", "success");
                window.location.href=baseurl+"armazens/entrada/"+id
			} else {
				Swal.fire(
					"Erro",
					"Não foi possível registar entrada de stock",
					"error"
				);
			}
		},
	});
});

function editar_entrada_stock(id) {
	$.ajax({
		url: baseurl + "armazens/get_entrada_stock/" + id,
		type: "get",
		success: function (d) {
			if (d) {
				let dados = $.parseJSON(d);
				console.log(dados);
				$("#editar_fatura").val(dados.nr_fatura);
				$("#editar_fornecedor").val(dados.fornecedor);
				$("#editar_data").val(dados.data_fatura);
				$("#editar_valor").val(dados.valor);
				$("#editar_observacoes_entradas").val(dados.observacoes);

				$("#entrada_selecionada").val(dados.id_entrada);
			}
		},
	});
	$("#editar_entrada_stock").modal("show");
}

$("#form_editar_entrada_stock").submit(function (e) {
	e.preventDefault();
	let formData = new FormData(this);
	$.ajax({
		url: baseurl + "armazens/editarEntradaStock",
		type: "post",
		contentType: false,
		cache: false,
		processData: false,
		data: formData,
		success: function (d) {
			console.log(d);

			if (d) {
				$("#editar_entrada_stock").modal("hide");
				$("#form_editar_entrada_stock").trigger("reset");
				tabela_entrada_stock.ajax.reload();
				Swal.fire("Armazem editado!", "", "success");
			} else {
				Swal.fire("Erro", "Não foi possível editar o armazem", "error");
			}
		},
	});
});

function apagar_entrada_stock(id) {
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
				url: baseurl + "armazens/apagar_entrada_stock",
				type: "POST",
				data: { id_entrada: id },
				success: function () {
					Swal.fire("Entrada Stock Apagada!", "", "success");
					tabela_entrada_stock.ajax.reload();
				},
			});
		}
	});
}

let table_entrada_stock_artigo = $("#table_entrada_stock_artigo").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "armazens/get_tabela_entrada_artigos",
		type: "POST",
		data: function (d) {
			d.id_entrada = $("#id_entrada").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});

let tabela_artigos = $("#table_artigos").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "armazens/get_tabela_artigos",
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
	fnInitComplete: function (oSettings, json) {
		$(".quantidade").TouchSpin({
			min: 1,
			max: 999999,
			step: 1,
		});
	},
});

function adicionar_artigo_stock(id_artigo) {
	if ($("#id_artigo" + id_artigo).val() == "") {
		Swal.fire("Insira quantidade", "", "error");
		return;
	}
	$.ajax({
		url: baseurl + "armazens/adicionar_artigo_stock",
		type: "post",
		data: {
			id_entrada: $("#id_entrada").val(),
			id_artigo: id_artigo,
			quantidade: $("#id_artigo" + id_artigo).val(),
		},
		success: function (d) {
			console.log(d);
			table_entrada_stock_artigo.ajax.reload();
			$("#id_artigo" + id_artigo).val("");
			toastr.success("Artigo Adicionado");
		},
	});
}

function lancar_artigo(id_entrada_artigo, valor, id_artigo) {
	$.ajax({
		url: baseurl + "armazens/lancar_artigo",
		type: "post",
		data: {
			id_entrada_artigo: id_entrada_artigo,
			fechado: valor,
			id_armazem: $("#id_armazem").val(),
			id_artigo: id_artigo,
		},
		success: function (d) {
			console.log(d);
			table_entrada_stock_artigo.ajax.reload();
		},
	});
}

function apagar_entrada_artigo(id) {
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
				url: baseurl + "armazens/apagarentradaartigo",
				type: "POST",
				data: { id_entrada_artigo: id },
				success: function (d) {
					Swal.fire("Artigo Apagado!", "", "success");
					table_entrada_stock_artigo.ajax.reload();
				},
			});
		}
	});
}

let table_stock_armazem = $("#table_stock_armazem").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "armazens/get_tabela_stock_armazem",
		type: "POST",
		data: function (d) {
			d.id_armazem = $("#id_armazem").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});

function fechar_entrada(id_entrada, fechado){

	$.ajax({
		url: baseurl+"armazens/fechar_entrada",
		type:'POST',
		data:{id_entrada: id_entrada, fechado: fechado},
		success:function(d){
			if(d == '"naolancado"'){
				Swal.fire('Artigo pendentes', 'Tem que lançar ou apagar os artigos da tabela', 'error')
				return
			}

			location.reload()
		}
	})

}


let tabela_movimentos = $("#table_movimentos").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "armazens/get_movimentos",
		type: "POST",
		data: function (d) {
			d.id_armazem = $("#id_armazem").val();
			d.estado = $("#estado").val();
			d.id_armazem_saida = $("#armazem_saida").val();
			d.id_armazem_entrada = $("#armazem_entrada").val();
			d.data_criado = $("#data_criado").val();
			d.data_fechado = $("#data_fechado").val();
			d.criado_por = $("#criado_por").val();
			d.fechado_por = $("#fechado_por").val();
			d.observacoes = $("#observacoes_movimentos").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});

$("#pesquisar_movimentos").on("click", function () {
	tabela_movimentos.ajax.reload();
});

$("#limpar_movimentos").on("click", function () {
	$("#estado").val("");
	$("#armazem_saida").val("");
	$("#armazem_entrada").val("");
	$("#data_criado").val("");
	$("#criado_por").val("");
	$("#data_fechado").val("");
	$("#fechado_por").val("");
	$("#observacoes_movimentos").val("");

	tabela_movimentos.ajax.reload();
});

$("#form_novo_movimento").submit(function (e) {
	e.preventDefault();
	let formData = new FormData(this);
	$.ajax({
		url: baseurl + "armazens/novo_movimento",
		type: "post",
		contentType: false,
		cache: false,
		processData: false,
		data: formData,
		success: function (d) {
            console.log(d);
            let id = $.parseJSON(d)

			if (d) {
				$("#novo_movimento").modal("hide");
				tabela_movimentos.ajax.reload();
				$("#form_novo_movimento").trigger("reset");
                //Swal.fire("Entrada de Stocks!", "", "success");
                window.location.href=baseurl+"armazens/movimento/"+id
			} else {
				Swal.fire(
					"Erro",
					"Não foi possível registar novo movimento",
					"error"
				);
			}
		},
	});
});


let table_movimentar_artigos = $("#table_movimentar_artigos").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "armazens/get_tabela_movimentar_artigos",
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

		$(".movimentar_quantidade").inputSpinner()
		
	},
});

function artigos_selecionados(id_artigo){
	if($("#artigo"+id_artigo).val() == ""){
		Swal.fire('Insira quantidade', '', 'error')
		return
	}
	console.log($("#artigo"+id_artigo).val())


	$.ajax({
		url:baseurl+"armazens/adicionar_movimento_artigo",
		type:'post',
		data:{id_movimento:$("#id_movimento").val(), id_artigo: id_artigo, quantidade:$("#artigo"+id_artigo).val(), id_armazem_saida:$("#id_armazem_saida").val()},
		success: function(d){
			if(d != "false"){
				$("#artigos_selecionados" ).load(baseurl+'armazens/load_div_artigos/'+$("#id_movimento").val(), function() {
					console.log("Carregado");
				});
				table_movimentar_artigos.ajax.reload()
			}else{
				Swal.fire('Error ao adicionar artigo', '', 'error')
			}
		}
	})
}

function apagar_artigo_movimentado(id_artigo_movimento, id_movimento, id_artigo, quantidade, id_armazem_saida){
	$.ajax({
		url:baseurl+"armazens/remover_movimento_artigo",
		type:'post',
		data:{id_artigo_movimento:id_artigo_movimento, id_movimento:id_movimento, id_artigo: id_artigo, quantidade:quantidade, id_armazem_saida:id_armazem_saida},
		success: function(d){
			if(d != "false"){

				$("#artigos_selecionados" ).load(baseurl+'armazens/load_div_artigos/'+id_movimento, function() {
					console.log("Carregado");
				});

				table_movimentar_artigos.ajax.reload()
			}else{
				Swal.fire('Error ao remover artigo', '', 'error')
			}
		}
	})
}

function fechar_movimento(id_movimento, fechar){
	$.ajax({
		url: baseurl+"armazens/fechar_movimento",
		type:'get',
		data:{id_movimento:id_movimento, fechar:fechar},
		success:function(d){
			if(d == "true"){
				location.reload()
			}else{
				Swal.fire('Error ao fechar movimento', '', 'error')
			}
		}
	})
}


let tabela_movimentos_pendentes = $("#table_movimentos_pendentes").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "armazens/get_movimentos_pendentes",
		type: "POST",
		data: function (d) {
			d.id_armazem = $("#id_armazem").val();
			d.estado = $("#estado").val();
			d.id_armazem_saida = $("#armazem_saida").val();
			d.id_armazem_entrada = $("#armazem_entrada").val();
			d.data_criado = $("#data_criado").val();
			d.data_fechado = $("#data_fechado").val();
			d.criado_por = $("#criado_por").val();
			d.fechado_por = $("#fechado_por").val();
			d.observacoes = $("#observacoes_movimentos").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});

$("#pesquisar_movimentos_pendentes").on("click", function () {
	tabela_movimentos_pendentes.ajax.reload();
});

$("#limpar_movimentos_pendentes").on("click", function () {
	$("#estado").val("");
	$("#armazem_saida").val("");
	$("#armazem_entrada").val("");
	$("#data_criado").val("");
	$("#criado_por").val("");
	$("#data_fechado").val("");
	$("#fechado_por").val("");
	$("#observacoes_movimentos").val("");

	tabela_movimentos_pendentes.ajax.reload();
});


function editar_stock_artigo(id_artigo, id_armazem, quantidade){	
	
	$('#editar_stock_quantidade').val(quantidade)
	$('#editar_stock_id_armazem').val(id_armazem)
	$('#editar_stock_id_artigo').val(id_artigo)
	$("#edit_stock_artigo").modal('show')

}

$("#form_editar_quantidade_artigo").submit(function(e){
	
	e.preventDefault();
	let formData = new FormData(this);
	$.ajax({
		url: baseurl + "armazens/editar_quantidade_artigo",
		type: "post",
		contentType: false,
		cache: false,
		processData: false,
		data: formData,
		success: function (d) {
            console.log(d);
        
			if (d) {
				$("#edit_stock_artigo").modal("hide");
				table_stock_armazem.ajax.reload();
				$("#form_novo_movimento").trigger("reset");
                Swal.fire("Editado", "", "success");
               
			} else {
				Swal.fire(
					"Erro",
					"Não foi possível editar quantidade do artigo",
					"error"
				);
			}
		},
	});

})


$(".touchspin_1").TouchSpin({
	min: 0,
	max: 999999999,
	step: 0.01,
	decimals: 2,
	stepinterval: 50,
	maxboostedstep: 100,
	forcestepdivisibility: "ceil",
	postfix: "€",
});

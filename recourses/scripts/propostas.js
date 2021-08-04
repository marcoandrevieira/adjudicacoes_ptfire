let tabela_propostas = $("#table_propostas").DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
    },
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "propostas/get_tabela_propostas",
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

$("#form_nova_proposta").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url:baseurl+"propostas/adicionarProposta",
        type:"post",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success:function(d){
            console.log(d)
            let id = $.parseJSON(d)

            if(d){
                $("#novo_artigo").modal('hide');
                tabela_propostas.ajax.reload();
                $("#form_nova_proposta").trigger("reset");
                location.href = baseurl+"propostas/proposta/"+id
            }else{
                Swal.fire("Erro", "Não foi possível criar o artigo", "error");
            }
        }
    })
})

let table_artigos_armazem = $("#table_artigos_armazem").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "propostas/get_tabela_single_proposta",
		type: "POST",
		data: function (d) {
			d.id_cliente = $("#id_cliente").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
    ],
    drawCallback: function (oSettings, json) {

        //$(".quantidade_fornecimento").inputSpinner()
        $(".preco_artigo").TouchSpin({
            min: 0,
            max: 999999999,
            step: 0.01,
            decimals: 2,
            stepinterval: 50,
            maxboostedstep: 100,
            forcestepdivisibility: "ceil",
            postfix: "€",
        });
	},
});

function adicionar_artigo_proposta(id_artigo) {

   
	if ($("#quantidade" + id_artigo).val() == "") {
		Swal.fire("Insira quantidade", "", "error");
		return;
    }

    console.log($("#quantidade" + id_artigo).val())

    if ($("#preco" + id_artigo).val() == "") {
		Swal.fire("Insira preço", "", "error");
		return;
    }


	$.ajax({
		url: baseurl + "propostas/adicionar_artigos_proposta",
		type: "post",
		data: {
			id_proposta: $("#id_proposta").val(),
			id_artigo: id_artigo,
            quantidade: $("#quantidade" + id_artigo).val(),
            preco: $("#preco" + id_artigo).val(),
		},
		success: function (d) {
			console.log(d);
			table_artigos_proposta.ajax.reload();
			$("#quantidade" + id_artigo).val("");
			toastr.success("Artigo Adicionado");
		},
	});
}

let table_artigos_proposta = $("#table_artigos_proposta").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "propostas/table_artigos_proposta",
		type: "POST",
		data: function (d) {
			d.id_proposta = $("#id_proposta").val();
		},
	},
	columsDefs: [
		{
			orderable: true,
		},
    ],
    drawCallback: function (oSettings, json) {

        //$(".quantidade_fornecimento").inputSpinner()
        $(".preco_artigo").TouchSpin({
            min: 0,
            max: 999999999,
            step: 0.01,
            decimals: 2,
            stepinterval: 50,
            maxboostedstep: 100,
            forcestepdivisibility: "ceil",
            postfix: "€",
        });
	},
});

function remover_artigo_proposta(id_artigo_proposta){
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
				url: baseurl + "propostas/apagar_artigo_proposta",
				type: "POST",
				data: { 
					id_artigo_proposta: id_artigo_proposta,
				},
				success: function () {
					Swal.fire("Artigo Apagado da proposta!", "", "success");
					table_artigos_proposta.ajax.reload();
				},
			});
		}
	});
}

function apagar_proposta(id_proposta){

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
				url: baseurl + "propostas/apagar_proposta",
				type: "POST",
				data: { 
					id_proposta: id_proposta,
				},
				success: function () {
					Swal.fire("Proposta Apagada!", "", "success");
					tabela_propostas.ajax.reload();
				},
			});
		}
	});
}

$("#enviar_proposta_cliente").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url:baseurl+"propostas/enviar_proposta_cliente",
        type:"post",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success:function(d){
            console.log(d)
           /*  let id = $.parseJSON(d)

            if(d){
                $("#novo_artigo").modal('hide');
                tabela_propostas.ajax.reload();
                $("#form_nova_proposta").trigger("reset");
                location.href = baseurl+"propostas/proposta/"+id
            }else{
                Swal.fire("Erro", "Não foi possível criar o artigo", "error");
            } */
        }
    })
})
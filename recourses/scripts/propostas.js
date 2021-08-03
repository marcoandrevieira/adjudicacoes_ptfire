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

            if(d){
                $("#novo_artigo").modal('hide');
                tabela_artigos.ajax.reload();
                $("#form_novo_artigo").trigger("reset");
                Swal.fire("Artigo Criado!", "", "success");
            }else{
                Swal.fire("Erro", "Não foi possível criar o artigo", "error");
            }
        }
    })
})
let tabela_instlacoes = $("#table_instalacoes").DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
    },
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "instalacoes/get_tabela_instalacoes",
        type: "POST",
        data: function(d){
            d.id_cliente = $("#id_cliente").val();
        }
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});

$("#novaInstalacao").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url:baseurl+"instalacoes/adicionarInstalacao",
        type:"post",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success:function(d){
            console.log(d)

            if(d){
                $("#nova_instalacao").modal('hide');
                tabela_instlacoes.ajax.reload();
                Swal.fire("Instalação Criado!", "", "success");
            }else{
                Swal.fire("Erro", "Não foi possível criar o instação", "error");
            }
        }
    })
})

function editar_instalacao(id) {

    $.ajax({
        url: baseurl+"instalacoes/get_instalacao/"+id,
        type:'get',
        success:function(d){
            if(d){
                let dados = $.parseJSON(d)

                console.log(dados)

                $("#editarInstalacao_nome").val(dados.instalacao)
                $("#editar_nif").val(dados.nif)
                $("#editar_morada").val(dados.morada)
                $("#editar_telefone").val(dados.telefone)
                $("#editar_email").val(dados.email)
                $("#editar_codigo_postal").val(dados.cp)
                $("#instalacao_selecionada").val(dados.id_instalacao)

                $('.editar_destrito').empty();
                $('.editar_concelho').removeAttr("disabled");
                $('.editar_freguesia').removeAttr("disabled");

                for (var i = 0; i < dados.destritos.length; i++) {
                    if (dados.destritos[i].id_zona != dados.parent_id_destritos) {
                        $('.editar_destrito').append('<option value="' + dados.destritos[i].id_zona + '">' + dados.destritos[i].zona + '</option>');
                    } else {
                        $('.editar_destrito').append('<option value="' + dados.destritos[i].id_zona + '" selected="selected">' + dados.destritos[i].zona + '</option>');
                    }
                }
                for (var i = 0; i < dados.concelhos.length; i++) {
                    if (dados.concelhos[i].id_zona != dados.parent_id_concelhos) {
                        $('.editar_concelho').append('<option value="' + dados.concelhos[i].id_zona + '">' + dados.concelhos[i].zona + '</option>');
                    } else {
                        $('.editar_concelho').append('<option value="' + dados.concelhos[i].id_zona + '" selected="selected">' + dados.concelhos[i].zona + '</option>');
                    }
                }
                for (var i = 0; i < dados.freguesias.length; i++) {
                    if (dados.freguesias[i].id_zona != dados.parent_id_freguesia) {
                        $('.editar_freguesia').append('<option value="' + dados.freguesias[i].id_zona + '">' + dados.freguesias[i].zona + '</option>');
                    } else {
                        $('.editar_freguesia').append('<option value="' + dados.freguesias[i].id_zona + '" selected="selected">' + dados.freguesias[i].zona + '</option>');
                    }
                }
                
            }
        }
    })
    $("#editar_instalacao").modal('show')

}

$("#editarInstalacao").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url:baseurl+"instalacoes/editarInstalacao",
        type:"post",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success:function(d){
            console.log(d)

            if(d){
                $("#editar_instalacao").modal('hide');
                tabela_instlacoes.ajax.reload();
                Swal.fire("Instalação Editada!", "", "success");
            }else{
                Swal.fire("Erro", "Não foi possível editar o instação", "error");
            }
        }
    })
})

function apagar_instalacao(id) {

    Swal.fire({
        title: "Tem a certeza que quer apagar?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, apaga!"
      }).then(result => {
        if (result.value) {
          $.ajax({
            url: baseurl + "instalacoes/apagar_instalacao",
            type: "POST",
            data: { id_instalacao: id },
            success: function () {
              Swal.fire("Instalação Apagada!", "", "success");
              tabela_instlacoes.ajax.reload()
              
            }
          });
        }
      });
}

let table_historico_fornecimento = $("#table_historico_fornecimento").DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
    },
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "instalacoes/get_tabela_historico_fornecimento",
        type: "POST",
        data: function(d){
            d.id_instalacao = $("#id_instalacao").val();
        }
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});

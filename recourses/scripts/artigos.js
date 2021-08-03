let tabela_artigos = $("#table_artigos").DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
    },
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "artigos/get_tabela_artigos",
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

$("#form_novo_artigo").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url:baseurl+"artigos/adicionarArtigo",
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

function editar_artigo(id) {
    $.ajax({
        url: baseurl+"artigos/get_artigo/"+id,
        type:'get',
        success:function(d){
            if(d){
                let dados = $.parseJSON(d)
                console.log(dados)
                $("#editar_artigo_nome").val(dados.artigo)
                $("#editar_artigo_nome_en").val(dados.artigo_en)
                $("#editar_artigo_nome_fr").val(dados.artigo_fr)
                $("#editar_referencia").val(dados.referencia)
                $("#editar_familia_artigo").val(dados.id_familia)
                $("#editar_marca").val(dados.marca)
                $("#editar_ano_fabrico").val(dados.ano_fabrico)
                $("#editar_foto1").attr("src", baseurl + "recourses/images/products/" +dados.fotografia1)
                $("#editar_foto2").attr("src", baseurl + "recourses/images/products/" +dados.fotografia2)
                $("#editar_detalhes").val(dados.detalhes)

                $("#artigo_selecionado").val(dados.id_artigo)
            }
        }
    })
    $("#editar_artigo").modal('show')
}


$("#form_editar_artigo").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url:baseurl+"artigos/editarArtigo",
        type:"post",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success:function(d){
            console.log(d)

            if(d){
                $("#editar_artigo").modal('hide');
                $("#form_editar_artigo").trigger("reset");
                tabela_artigos.ajax.reload();
                Swal.fire("Artigo editado!", "", "success");
            }else{
                Swal.fire("Erro", "Não foi possível editar o artigo", "error");
            }
        }
    })
})

function apagar_artigo(id) {

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
            url: baseurl + "artigos/apagar_artigo",
            type: "POST",
            data: { id_artigo: id },
            success: function () {
              Swal.fire("Artigo Apagado!", "", "success");
              tabela_artigos.ajax.reload()
            }
          });
        }
      });
}
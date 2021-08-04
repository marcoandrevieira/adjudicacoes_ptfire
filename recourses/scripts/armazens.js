let tabela_armazens = $("#table_armazens").DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
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

$("#form_novo_armazem").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url:baseurl+"armazens/adicionarArmazem",
        type:"post",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success:function(d){
            console.log(d)

            if(d){
                $("#novo_armazem").modal('hide');
                tabela_armazens.ajax.reload();
                $("#form_novo_armazem").trigger("reset");
                Swal.fire("Armazem Criado!", "", "success");
            }else{
                Swal.fire("Erro", "Não foi possível criar o armazem", "error");
            }
        }
    })
})

function editar_armazem(id) {
    $.ajax({
        url: baseurl+"armazens/get_armazem/"+id,
        type:'get',
        success:function(d){
            if(d){
                let dados = $.parseJSON(d)
                console.log(dados)
                $("#editar_armazem_nome").val(dados.armazem)
                $("#editar_morada").val(dados.morada)
                $("#editar_notas").val(dados.notas)
               
                $("#armazem_selecionado").val(dados.id_armazem)
            }
        }
    })
    $("#editar_armazem").modal('show')
}


$("#form_editar_armazem").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url:baseurl+"armazens/editarArmazem",
        type:"post",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success:function(d){
            console.log(d)

            if(d){
                $("#editar_armazem").modal('hide');
                $("#form_editar_armazem").trigger("reset");
                tabela_armazens.ajax.reload();
                Swal.fire("Armazem editado!", "", "success");
            }else{
                Swal.fire("Erro", "Não foi possível editar o armazem", "error");
            }
        }
    })
})

function apagar_armazem(id) {

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
            url: baseurl + "armazens/apagar_armazem",
            type: "POST",
            data: { id_armazem: id },
            success: function () {
              Swal.fire("Armazem Apagado!", "", "success");
              tabela_armazens.ajax.reload()
            }
          });
        }
      });
}

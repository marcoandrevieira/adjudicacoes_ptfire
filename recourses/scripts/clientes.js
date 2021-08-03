let tabela_clientes = $("#table_clientes").DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
    },
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "clientes/get_tabela_clientes",
		type: "POST",
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});

function editar_cliente(id) {

    $.ajax({
        url: baseurl+"clientes/get_cliente/"+id,
        type:'get',
        success:function(d){
            if(d){
                let dados = $.parseJSON(d)

                $("#editar_nomecliente").val(dados.cliente)
                $("#editar_nif").val(dados.nif)
                $("#editar_morada").val(dados.morada)
                $("#editar_telefone").val(dados.telefone)
                $("#editar_email").val(dados.email)
                $("#cliente_selecionado").val(dados.id_cliente)
                
                console.log(dados)
            }
        }
    })
    $("#editar_cliente").modal('show')

}

function apagar_cliente(id) {

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
            url: baseurl + "clientes/apagar_cliente",
            type: "POST",
            data: { id_cliente: id },
            success: function () {
              Swal.fire("Cliente Apagado!", "", "success");
              tabela_clientes.ajax.reload()
              
            }
          });
        }
      });

}

$("#form_novo_cliente").submit(function(e){
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        url:baseurl+"clientes/adicionarCliente",
        type:"post",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success:function(d){
            console.log(d)

            if(d == '"duplicado"'){
                $("#novo_cliente").modal('hide');
                Swal.fire("O cliente já existe", "O NIF já existe na base de dados", "info");
                return;
            }

            if(d){
                $("#novo_cliente").modal('hide');
                tabela_clientes.ajax.reload();
                Swal.fire("Cliente Criado!", "", "success");
            }else{
                Swal.fire("Erro", "Não foi possível criar o cliente", "error");
            }
        }
    })
})

$("#form_editar_cliente").submit(function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url:baseurl+"clientes/editarCliente",
        type:"post",
        contentType: false,
        cache: false,
        processData: false,
        data: formData,
        success:function(d){
            console.log(d)

            if(d){
                $("#editar_cliente").modal('hide');
                tabela_clientes.ajax.reload();
                Swal.fire("Cliente Editado!", "", "success");
            }else{
                Swal.fire("Erro", "Não foi possível editar o cliente", "error");
            }
        }
    })
    
})
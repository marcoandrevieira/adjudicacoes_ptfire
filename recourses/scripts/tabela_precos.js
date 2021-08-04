let tabela_tabela_precos = $("#table_tabela_precos").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json",
	},
	responsive: false,
	serverSide: true,
	order: [],
	ajax: {
		url: baseurl + "clientes/get_tabela_precos",
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
		$(".preco_artigo").TouchSpin({
			min: 0.01,
			max: 999999,
			step: 0.01,
			decimals: 2,
			stepinterval: 50,
            maxboostedstep: 100,
         
		});
		$(".preco_artigo").on("touchspin.on.stopspin", function () {
			/* if (this.value == "") {
				return;
			} */

			$.ajax({
				url: baseurl + "clientes/edit_tabela_precos",
				type: "post",
				data: {
					id_artigo: this.getAttribute("id_artigo"),
					id_cliente: this.getAttribute("id_cliente"),
					preco: this.value,
				},
				success: function (d) {
					tabela_tabela_precos.ajax.reload();
				},
			});
		});
        $(".preco_artigo").focusout(function () {
            
        
            $.ajax({
                url: baseurl + "clientes/edit_tabela_precos",
                type: "post",
                data: {
                    id_artigo: this.getAttribute("id_artigo"),
                    id_cliente: this.getAttribute("id_cliente"),
                    preco: this.value,
                },
                success: function (d) {
                    tabela_tabela_precos.ajax.reload();
                },
            });
        });
		
	},
});


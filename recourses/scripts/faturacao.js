
moment.locale('pt');
var start = moment().subtract(29, 'days');
var end = moment();
var startDate;
var endDate;

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    startDate = start;
    endDate = end;    
}

$('#reportrange').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
        'Hoje': [moment(), moment()],
        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
        'Este mês': [moment().startOf('month'), moment().endOf('month')],
        'Mês passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

cb(start, end);


let table_faturacao = $("#table_faturacao").DataTable({
    language: {
        url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
    },
	responsive: false,
	serverSide: true,
    searching: false,
	order: [],
	ajax: {
		url: baseurl + "faturacao/get_table_faturacao",
        type: "POST",
        data: function(d){
            d.projeto = $("#projeto").val();
            d.cliente = $("#cliente").val();
            d.instalacao = $("#instalacao").val();
            d.armazem_saida = $("#armazem_saida").val();
            d.data_fecho_start = startDate.format('YYYY-MM-DD 00:00:01');
            d.data_fecho_end = endDate.format('YYYY-MM-DD 23:59:59');
            d.fechado_por = $("#fechado_por").val();
            d.valor_total = $("#valor_total").val();
            d.fatura = $("#fatura").val();
            d.valor_fatura = $("#valor_fatura").val();
        }
	},
	columsDefs: [
		{
			orderable: true,
		},
	],
});

$("#pesquisar_fatura").on('click', function(){
    table_faturacao.ajax.reload()
})

$("#limpar_fatura").on('click', function(){

    $("#projeto").val('');
    $("#cliente").val('');
    $("#instalacao").val('');
    $("#armazem_saida").val('');
    $("#fechado_por").val('');
    $("#valor_total").val('');
    $("#fatura").val('');
    $("#valor_fatura").val('');
    table_faturacao.ajax.reload()
})

function adicionar_fatura(id_fornecimento){

    $("#form_nova_fatura").trigger("reset");
    $("#mostrar_fatura").html('')
    $.ajax({
        url:baseurl+"faturacao/get_fatura",
        type:"post",
        data:{id_fornecimento: id_fornecimento},
        success:function(d){
            let dados = $.parseJSON(d)

            console.log(dados)
            $("#edita_fatura").val(dados[0].nr_fatura)
            $("#edita_valor_fatura").val(dados[0].valor_fatura)
            $("#edita_observacoes").val(dados[0].observacoes)
            if(dados[0].imagem1){
                $("#mostrar_fatura").html('<a target="_blank" href="'+baseurl+'recourses/images/invoices/'+dados[0].imagem1+'" class="btn btn-outline btn-xs yellow-gold"> Ver Fatura</a>')
            }
        }
    })
    $("#id_forncecimento_adicionar_fatura").val(id_fornecimento)
    $("#nova_fatura").modal('show')
}

$("#form_nova_fatura").submit(function(e){
   
    e.preventDefault();
	let formData = new FormData(this);
	$.ajax({
		url: baseurl + "faturacao/adicionar_fatura",
		type: "post",
		contentType: false,
		cache: false,
		processData: false,
		data: formData,
		success: function (d) {
            console.log(d);
    
			if (d) {
				$("#nova_fatura").modal("hide");
				table_faturacao.ajax.reload();
				$("#form_nova_fatura").trigger("reset");
                Swal.fire("OK!", "", "success");
			} else {
				Swal.fire(
					"Erro",
					"Não foi possível registar fatura",
					"error"
				);
			}
		},
	});
})

function analisesKPI(){

    if($("#data_inicio_analise").val() == "" || $("#data_fim_analise").val() == ""){
        Swal.fire('Insira as duas datas', '', 'error')
        return;
    }

    if($("#data_inicio_analise").val() > $("#data_fim_analise").val()){
        Swal.fire('Data inicio inferior à data de fim', 'A data de fim tem que ser maior que a data de inicio', 'error')
        return;
    }

    console.log($("#data_inicio_analise").val())
    console.log($("#data_fim_analise").val())

    let data_inicio = $("#data_inicio_analise").val();
    let data_fim = $("#data_fim_analise").val();

    $.ajax({
        url:baseurl+"faturacao/exportar_excel",
        type:"post",
        data: {data_inicio: data_inicio+" 00:00:01", data_fim: data_fim+" 23:59:59"},
        success: function(e){
            let dados = $.parseJSON(e)
            var ws = XLSX.utils.json_to_sheet(dados);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "People");
            XLSX.writeFile(wb, "kpi_fornecimentos.xlsx");    
        }
    })

    
} 

$(".valor_fatura").TouchSpin({
	min: 0,
	max: 999999999,
	step: 0.01,
	decimals: 2,
	stepinterval: 50,
	maxboostedstep: 100,
	forcestepdivisibility: "ceil",
	postfix: "€",
});
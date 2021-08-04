<style>
    .center-screen {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        min-height: 60vh;
    }
</style>


<div class="center-screen">
    <p>Defina data de inicio e fim:</p>


    <div class="row" style="margin-bottom: 2%;">
        <div class="col-md-6">
            <input class="form-control" type="date" name="" id="data_inicio_analise">
        </div>
        <div class="col-md-6">
            <input class="form-control" type="date" name="" id="data_fim_analise">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button onclick="analisesKPI()" class="btn btn-outline btn-success"><i class="fa fa-table" aria-hidden="true"></i> Exportar Excel</button>
        </div>
    </div>
</div>
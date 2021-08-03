<style>
    .dataTables_filter {
        text-align: end;
    }

    .dataTables_paginate.paging_bootstrap_number {
        text-align: end;
    }
</style>
<input type="hidden" id="id_armazem" value="<?php echo $armazem['id_armazem']; ?>">
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>armazens">Armazens</a>
            <i class="fa fa-circle"></i>
        </li>

    </ul>

</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Armazem | <?php echo $armazem['armazem']; ?>

</h3>

<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-2">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">


                <div class="profile-usermenu">
                    <ul class="nav">
                        <li>
                            <a href="<?php echo base_url(); ?>armazens/stock/<?php echo $armazem['id_armazem']; ?>">
                                <i class="fa fa-cubes"></i> Stocks </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>armazens/entrada_stock/<?php echo $armazem['id_armazem']; ?>">
                                <i class="fa fa-file-text-o"></i> Entrada de Stock </a>
                        </li>
                        <li class="active">
                            <a href="<?php echo base_url(); ?>armazens/movimentar_stock/<?php echo $armazem['id_armazem']; ?>">
                                <i class="fa fa-share-square-o"></i> Movimentos/Saídas Stock </a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>

        </div>
    </div>

    <div class="col-md-10">
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Movimentar Stock Entre Armazens</span>
                            </div>
                            <ul class="nav nav-tabs">

                                <li class="active">
                                    <a href="#tab_1_2" data-toggle="tab">Movimentos de Artigos</a>
                                </li>

                            </ul>
                        </div>

                        <div class="portlet-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1_2">

                                    <div class="btn-group">
                                        <a href="#nova_movimento" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Novo Movimento de Stock
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                    <br><br>

                                    <table class="table table-striped table-bordered table-hover order-column" id="table_movimentos">
                                        <thead>
                                            <tr>
                                                <th>Estado</th>
                                                <th>Armazem Saída</th>
                                                <th>Armazem Entrada</th>
                                                <th>Data Criado</th>
                                                <th>Criado por</th>
                                                <th>Data Fechado</th>
                                                <th>Fechado por</th>
                                                <th>Observações</th>
                                                <th width="10%"></th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th>
                                                    <select class="form-control" id="estado">
                                                        <option value="">Todos</option>
                                                        <option selected value="2">Pendentes</option>
                                                        <option value="1">Concluidos</option>
                                                    </select>
                                                </th>
                                                <th>
                                                    <select class="form-control" id="armazem_saida">
                                                        <option selected value="">Todos</option>
                                                        <?php foreach ($armazens as $armz) : ?>
                                                            <option value="<?= $armz['id_armazem'] ?>"><?= $armz['armazem'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <select class="form-control" id="armazem_entrada">
                                                        <option selected value="">Todos</option>
                                                        <?php foreach ($armazens as $armz_s) : ?>
                                                            <option value="<?= $armz_s['id_armazem'] ?>"><?= $armz_s['armazem'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input type="date" class="form-control" id="data_criado">
                                                </th>
                                                <th>
                                                    <select class="form-control" id="criado_por">
                                                        <option selected value="">Todos</option>
                                                        <?php foreach ($utilizadores as $utilizador) : ?>
                                                            <option value="<?= $utilizador['id_utilizador'] ?>"><?= $utilizador['nome'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input type="date" class="form-control" id="data_fechado">
                                                </th>
                                                <th>
                                                    <select class="form-control" id="fechado_por">
                                                        <option selected value="">Todos</option>
                                                        <?php foreach ($utilizadores as $utilizador) : ?>
                                                            <option value="<?= $utilizador['id_utilizador'] ?>"><?= $utilizador['nome'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" id="observacoes_movimentos">
                                                </th>
                                                <th>
                                                    <button id="pesquisar_movimentos" class="btn btn-outline green-jungle btn-sm"><i class="fa fa-search"></i> Pesquisar</button>
                                                    <button id="limpar_movimentos" class="btn btn-outline red btn-sm"><i class="fa fa-times"></i> Limpar</button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                        </tbody>
                                    </table>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>



<div id="nova_movimento" class="modal  fade in" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Movimentar entre armazens</h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-horizontal" id="form_novo_movimento" method="post" enctype="multipart/form-data">


                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Armazem Saída</label>
                            <div class="col-md-9">
                                <select class="form-control" name="armazem_saida" id="">
                                    <option value="<?= $armazem['id_armazem'] ?>"><?= $armazem['armazem'] ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Armazem Entrada</label>
                            <div class="col-md-9">
                                <select class="form-control" name="armazem_entrada" id="">
                                    <?php foreach ($armazens as $armazem_e) : ?>
                                        <option value="<?= $armazem_e['id_armazem'] ?>"><?= $armazem_e['armazem'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Observações</label>
                            <div class="col-md-9">

                                <textarea class="form-control" name="observacoes" id="" cols="30" rows="3"></textarea>

                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">

                <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                <button type="submit" class="btn green">Criar</button>

                </form>
            </div>
        </div>
    </div>
</div>

<div id="editar_entrada_stock" class="modal  fade in" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Editar Entrada Stock</h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-horizontal" id="form_editar_entrada_stock" method="post" enctype="multipart/form-data">

                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nº Fatura</label>
                            <div class="col-md-9">
                                <input type="text" id="editar_fatura" name="fatura" class="form-control" placeholder="Nº da fatura" required>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">Fornecedor</label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <i class="fa fa-shopping-cart"></i>
                                    <input type="text" name="fornecedor" id="editar_fornecedor" placeholder="Fornecedor" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Data </label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <i class="fa fa-calendar"></i>
                                    <input type="date" name="data" placeholder="Data fatura" id="editar_data" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Valor Fatura</label>
                            <div class="col-md-9">
                                <input type="text" name="valor" id="editar_valor" class="form-control touchspin_1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Observações</label>
                            <div class="col-md-9">

                                <textarea class="form-control" name="observacoes" id="editar_observacoes_entradas" cols="30" rows="3"></textarea>

                            </div>
                        </div>
                        <input type="hidden" id="entrada_selecionada" name="id_entrada">

                    </div>
                    <div class="modal-footer">

                        <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                        <button type="submit" class="btn green">Editar</button>

                </form>
            </div>
        </div>
    </div>
</div>
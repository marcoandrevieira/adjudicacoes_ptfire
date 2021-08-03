<style>
    .dataTables_filter {
        text-align: end;
    }

    .dataTables_paginate.paging_bootstrap_number {
        text-align: end;
    }
</style>

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>">Movimentos Pendentes</a>
            <i class="fa fa-circle"></i>
        </li>

    </ul>

</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Movimentos pendentes entre armazens</h3>

<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    
    <div class="col-md-12">
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Movimentos Pendentes</span>
                            </div>
                            <ul class="nav nav-tabs">

                                <li class="active">
                                    <a href="#tab_1_2" data-toggle="tab">Pendentes</a>
                                </li>

                            </ul>
                        </div>

                        <div class="portlet-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1_2">

                                    <table class="table table-striped table-bordered table-hover order-column" id="table_movimentos_pendentes">
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
                                                        <option value="todos">Todos</option>
                                                        <option selected value="naoaceitado">Pendentes</option>
                                                        <option value="aceitado">Concluidos</option>
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
                                                    <button id="pesquisar_movimentos_pendentes" class="btn btn-outline green-jungle btn-sm"><i class="fa fa-search"></i> Pesquisar</button>
                                                    <button id="limpar_movimentos_pendentes" class="btn btn-outline red btn-sm"><i class="fa fa-times"></i> Limpar</button>
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
                <h4 class="modal-title">Nova Fatura</h4>
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
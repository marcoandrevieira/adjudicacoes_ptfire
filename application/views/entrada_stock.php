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
                        <li class="active">
                            <a href="<?php echo base_url(); ?>armazens/stock/<?php echo $armazem['id_armazem']; ?>">
                                <i class="fa fa-cubes"></i> Stocks </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>armazens/entrada_stock/<?php echo $armazem['id_armazem']; ?>">
                                <i class="fa fa-file-text-o"></i> Entrada de Stock </a>
                        </li>
                        <li>
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
                                <span class="caption-subject font-blue-madison bold uppercase">Entrada de Stock</span>
                            </div>
                            <ul class="nav nav-tabs">

                                <li class="active">
                                    <a href="#tab_1_2" data-toggle="tab">Entrada de Artigos</a>
                                </li>

                            </ul>
                        </div>

                        <div class="portlet-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1_2">

                                    <div class="btn-group">
                                        <a href="#nova_entrada" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Nova Entrada de Stock/Fatura
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                    <br><br>

                                    <table class="table table-striped table-bordered table-hover order-column" id="table_entrada_stock">
                                        <thead>
                                            <tr>
                                                <th>Estado</th>
                                                <th>Fatura</th>
                                                <th>Data Fatura</th>
                                                <th>Valor</th>
                                                <th>Criado por</th>
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
                                                        <option value="1">Aberto</option>
                                                        <option value="2">Fechado</option>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" id="nr_fatura">
                                                </th>
                                                <th>
                                                    <input type="date" class="form-control" id="data_fatura">
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" id="valor">
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
                                                    <select class="form-control" id="fechado_por">
                                                        <option selected value="">Todos</option>
                                                        <?php foreach ($utilizadores as $utilizador) : ?>
                                                            <option value="<?= $utilizador['id_utilizador'] ?>"><?= $utilizador['nome'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" id="observacoes_entrada">
                                                </th>
                                                <th>
                                                    <button id="pesquisar_entradas" class="btn btn-outline green-jungle btn-sm"><i class="fa fa-search"></i> Pesquisar</button>
                                                    <button id="limpar_entradas" class="btn btn-outline red btn-sm"><i class="fa fa-times"></i> Limpar</button>
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

<div id="nova_entrada" class="modal  fade in" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Nova Fatura</h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-horizontal" id="form_nova_entrada" method="post" enctype="multipart/form-data">


                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nº Fatura</label>
                            <div class="col-md-9">
                                <input type="text" name="fatura" data-required="1" class="form-control" placeholder="Nº da fatura" required>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">Fornecedor</label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <i class="fa fa-shopping-cart"></i>
                                    <input type="text" name="fornecedor" placeholder="Fornecedor" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Data </label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <i class="fa fa-calendar"></i>
                                    <input type="date" name="data" placeholder="Data fatura" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Valor Fatura</label>
                            <div class="col-md-9">
                                <input id="touchspin_1" type="text" name="valor" class="form-control touchspin_1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Observações</label>
                            <div class="col-md-9">

                                <textarea class="form-control" name="observacoes" id="" cols="30" rows="3"></textarea>

                            </div>
                        </div>




                        <input type="hidden" name="id_armazem" value="<?php echo $armazem['id_armazem']; ?>">

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
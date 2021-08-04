<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="<?php echo plugins_url(); ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
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
            <a href="<?php echo base_url(); ?>">Propostas</a>
            <i class="fa fa-circle"></i>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Propostas enviadas a clientes</h3>

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
                                <span class="caption-subject font-blue-madison bold uppercase">Proposta</span>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="btn-group">
                                <a href="#nova_proposta" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Nova Proposta
                                    <i class="fa fa-plus"></i>
                                </a>

                            </div>

                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_2" data-toggle="tab">Proposta</a>
                                </li>
                            </ul>
                        </div>

                        <div class="portlet-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_2">
                                    <table class="table table-striped table-bordered table-hover order-column" id="table_propostas">
                                        <thead>
                                            <tr>
                                                <th>Proposta</th>
                                                <th>Cliente</th>
                                                <th>Instalação</th>
                                                <th>Data Envio</th>
                                                <th>Criador</th>
                                                <th>Link</th>
                                                <th width="10%"></th>
                                            </tr>
                                        </thead>
                                        <!-- <thead>
                                            <tr>
                                                <th>
                                                    <input type="text" class="form-control" id="projeto">
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" id="cliente">
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" id="instalacao">
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" id="pdf_entrega">
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" id="valor_total">
                                                </th>
                                                <th>
                                                    <input type="text" class="form-control" id="fatura">
                                                </th>

                                                <th>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button id="pesquisar_fatura" class="btn btn-outline green-jungle btn-sm"><i class="fa fa-search"></i> Pesquisar</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button id="limpar_fatura" class="btn btn-outline red btn-sm"><i class="fa fa-times"></i> Limpar</button>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead> -->
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


<div id="nova_proposta" class="modal  fade in" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Nova Proposta</h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-horizontal" id="form_nova_proposta" method="post" enctype="multipart/form-data">


                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Proposta</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" required name="proposta" placeholder="Designação Proposta">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Cliente</label>
                            <div class="col-md-9 search_clientes">
                                <select required id="dropdown_cliente" class="form-control selectpicker" name="cliente" data-live-search="true" title="Nada Selecionado">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Instalação</label>
                            <div class="col-md-9">
                                <select class="form-control selectpicker1" name="instalacao" id="loops_instalacao" data-live-search="true" title="Nada Selecionado">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Observações</label>
                            <div class="col-md-9">

                                <textarea class="form-control" name="observacoes" id="edita_observacoes" cols="30" rows="3"></textarea>

                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">

                <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                <button type="submit" class="btn green">Adicionar</button>

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
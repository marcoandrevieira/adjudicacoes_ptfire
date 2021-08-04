<link rel="stylesheet" href="<?= base_url('recourses/plugins/bootstrap-toastr/toastr.min.css') ?>">
<input type="hidden" id="id_armazem" value="<?= $armazem['id_armazem'] ?>">
<input type="hidden" id="id_fornecimento" value="<?= $dados_cliente['id_fornecimento'] ?>">
<input type="hidden" id="id_cliente" value="<?= $dados_cliente['id_cliente'] ?>">
<style>
    .dataTables_filter {
        text-align: end;
    }

    .dataTables_paginate.paging_bootstrap_number {
        text-align: end;
    }

    .swal2-container {
        z-index: 100000;
    }

    .input-group {
        display: flex;
    }
</style>

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>armazens">Adjudicação para fornecimento de stock </a>
            <i class="fa fa-circle"></i>
        </li>

    </ul>

</div>

<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Fornecimentos de material

</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-2" style="border: 1px solid #ECECEC;">

        <div class="profile-sidebar">

            <div class="portlet light profile-sidebar-portlet ">

                <p>Armazem saída de material: <b><?= $armazem['armazem'] ?></b></p>
                <p>Cliente: <b><?= $dados_cliente['cliente'] ?></b></p>
                <p>Instalação: <b><?= $dados_cliente['instalacao'] ?></b></p>
                <p>Data Criado: <b><?= $dados_cliente['data_insercao'] ?></b></p>
                <p>Criado por: <b><?= $dados_cliente['criado_nome'] ?></b></p>
                <p>Data Fechado: <b><?= $dados_cliente['data_fecho'] ?></b></p>
                <p>Fechado por: <b><?= $dados_cliente['fechado_nome'] ?></b></p>


            </div>

        </div>
    </div>

    <div class="col-md-10">
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <?php if (empty($dados_cliente['fechado_nome'])) : ?>
                            <button onclick="fechar_fornecimento(<?= $dados_cliente['id_fornecimento'] ?>, 1)" class="btn green-jungle"><i class="fa fa-lock"></i> Fechar</button>
                        <?php endif; ?>

                    </div>
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>

                                <span class="caption-subject font-blue-madison bold uppercase">Fornecer Stock</span>

                            </div>

                            <ul class="nav nav-tabs">

                                <li class="active">
                                    <a href="#tab_1_2" data-toggle="tab">Fornecimento de Artigos</a>
                                </li>

                            </ul>
                        </div>

                        <div class="portlet-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1_2">
                                    <?php if (empty($dados_cliente['fechado_nome'])) : ?>
                                        <div class="btn-group">
                                            <a href="#nova_artigo_stock" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Adicionar Stock
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                        <br><br>
                                    <?php endif; ?>
                                    <table class="table table-striped table-bordered table-hover order-column" id="table_fornecimento_cliente">
                                        <thead>
                                            <tr>
                                                <th>Referência</th>
                                                <th>Artigo</th>
                                                <th>Familia</th>
                                                <th>Marca</th>
                                                <th width="10%">Fotografia</th>
                                                <th>Quantidade </th>
                                                <th>Valor Total </th>
                                                <th width="10%"> </th>
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

<div id="nova_artigo_stock" class="modal  fade in" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Fornecer Artigos</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover order-column" id="table_artigos_armazem">
                    <thead>
                        <tr>
                            <th> Referência </th>
                            <th> Artigo </th>
                            <th> Familia </th>
                            <th> Marca </th>
                            <th width="10%"> Fotografia</th>
                            <th> Quantidade </th>
                            <th> Preço</th>
                            <th> </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
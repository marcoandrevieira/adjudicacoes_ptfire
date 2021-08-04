<link rel="stylesheet" href="<?= base_url('recourses/plugins/bootstrap-toastr/toastr.min.css') ?>">
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
</style>
<input type="hidden" id="id_entrada" value="<?php echo $entrada_stock['id_entrada']; ?>">
<input type="hidden" id="id_armazem" value="<?php echo $entrada_stock['id_armazem']; ?>">
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>armazens">Fatura/Entrada Stock</a>
            <i class="fa fa-circle"></i>
        </li>

    </ul>

</div>

<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Fatura | <?php echo $entrada_stock['nr_fatura']; ?>

</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-2" style="border: 1px solid #ECECEC;">

        <div class="profile-sidebar">

            <div class="portlet light profile-sidebar-portlet ">

                <p>Nº Fatura: <b><?= $entrada_stock['nr_fatura'] ?></b></p>
                <p>Data Fatura: <b><?= $entrada_stock['data_fatura'] ?></b></p>
                <p>Valor: <b><?= $entrada_stock['valor'] ?></b></p>
                <p>Criado por: <b><?= $entrada_stock['criado_nome'] ?></b></p>
                <p>Fechado por: <b><?= $entrada_stock['fechado_nome'] ?></b></p>
                <p>Observações: <b><?= $entrada_stock['observacoes'] ?></b></p>

            </div>

        </div>
    </div>

    <div class="col-md-10">
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <?php if (empty($entrada_stock['fechado_nome'])) : ?>
                            <button onclick="fechar_entrada(<?= $entrada_stock['id_entrada'] ?>, 1)" class="btn green-jungle"><i class="fa fa-lock"></i> Fechar</button>
                        <?php else : ?>
                            <button onclick="fechar_entrada(<?= $entrada_stock['id_entrada'] ?>, 0)" class="btn red"><i class="fa fa-unlock"></i> Abrir</button>
                        <?php endif; ?>


                    </div>
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>

                                <span class="caption-subject font-blue-madison bold uppercase">Adicionar Stock</span>

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
                                    <?php if (empty($entrada_stock['fechado_nome'])) : ?>
                                        <div class="btn-group">
                                            <a href="#nova_artigo_stock" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Adicionar Stock
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                        <br><br>
                                    <?php endif; ?>
                                    <table class="table table-striped table-bordered table-hover order-column" id="table_entrada_stock_artigo">
                                        <thead>
                                            <tr>
                                                <th>Referência</th>
                                                <th>Artigo</th>
                                                <th>Familia</th>
                                                <th>Marca</th>
                                                <th width="10%">Fotografia</th>
                                                <th>Quantidade </th>
                                                <th>Fechado </th>
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
                <h4 class="modal-title">Adicionar Artigos</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover order-column" id="table_artigos">
                    <thead>
                        <tr>
                            <th> Referência </th>
                            <th> Artigo </th>
                            <th> Familia </th>
                            <th> Marca </th>
                            <th> Ano Fabrico</th>
                            <th width="10%"> Fotografia</th>
                            <th> Quantidade </th>
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

<!-- <div id="editar_instalacao" class="modal  fade in" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Editar Instalação - <?php echo $cliente['cliente']; ?></h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-horizontal" id="editarInstalacao" method="post" enctype="multipart/form-data">


                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Instalação</label>
                            <div class="col-md-9">
                                <input type="text" name="instalacao" id="editarInstalacao_nome" data-required="1" class="form-control" placeholder="Instalação" required>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">Telefone</label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <i class="fa fa-phone"></i>
                                    <input type="text" name="telefone" id="editar_telefone" placeholder="Telefone" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <i class="fa fa-envelope-o"></i>
                                    <input type="email" name="email" id="editar_email" placeholder="Email" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Morada</label>
                            <div class="col-md-9">
                                <input type="text" name="morada" id="editar_morada" class="form-control" placeholder="Morada">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Código-Postal</label>
                            <div class="col-md-9">

                                <input type="text" name="codigo_postal" id="editar_codigo_postal" class="form-control" placeholder="Código Postal">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Distrito</label>
                            <div class="col-md-9">
                                <select class="form-control editar_destrito" name="destrito" id="destrito_editar">
                                    <option value>--Distrito--</option>
                                    <?php
                                    foreach ($distritos as $d) {
                                        echo '<option value="' . $d->id_zona . '">' . $d->zona . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Concelho</label>
                            <div class="col-md-9">
                                <select class="form-control editar_concelho" name="concelho" id="concelho_editar" disabled>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label ">Freguesia</label>
                            <div class="col-md-9">
                                <select class="form-control editar_freguesia" name="freguesia" id="freguesia_editar" disabled>

                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id_instalacao" value="" id="instalacao_selecionada">
                    </div>

            </div>
            <div class="modal-footer">

                <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                <button type="submit" class="btn green">Editar</button>

                </form>
            </div>
        </div>
    </div>
</div> -->
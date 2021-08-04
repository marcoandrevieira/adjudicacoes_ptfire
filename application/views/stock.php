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
                                <span class="caption-subject font-blue-madison bold uppercase">Stock dos Artigos</span>
                            </div>
                            <ul class="nav nav-tabs">

                                <li class="active">
                                    <a href="#tab_1_2" data-toggle="tab">Artigos</a>
                                </li>

                            </ul>
                        </div>

                        <div class="portlet-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1_2">

                                    <!-- <div class="btn-group">
                                        <a href="#nova_instalacao" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Nova Instalação
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div> -->

                                    <table class="table table-striped table-bordered table-hover order-column" id="table_stock_armazem">
                                        <thead>
                                            <tr>
                                                <th> Referência </th>
                                                <th> Artigo </th>
                                                <th> Familia </th>
                                                <th> Marca </th>
                                                <th width="15%"> Fotografia</th>
                                                <th>Quantidade </th>
                                                <?php if ($_SESSION['id_tipo'] == 1) : ?>
                                                    <th></th>
                                                <?php endif; ?>
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

<div id="nova_instalacao" class="modal  fade in" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Nova Instalação - <?php echo $cliente['cliente']; ?></h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-horizontal" id="novaInstalacao" method="post" enctype="multipart/form-data">


                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Instalação</label>
                            <div class="col-md-9">
                                <input type="text" name="instalacao" data-required="1" class="form-control" placeholder="Instalação" required>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">Telefone</label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <i class="fa fa-phone"></i>
                                    <input type="text" name="telefone" placeholder="Telefone" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <i class="fa fa-envelope-o"></i>
                                    <input type="email" name="email" placeholder="Email" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Morada</label>
                            <div class="col-md-9">
                                <input type="text" name="morada" class="form-control" placeholder="Morada">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Código-Postal</label>
                            <div class="col-md-9">

                                <input type="text" name="codigo_postal" class="form-control" placeholder="Código Postal">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Distrito</label>
                            <div class="col-md-9">
                                <select class="form-control" name="destrito" id="destrito" required>
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
                                <select class="form-control" name="concelho" id="concelho" disabled required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Freguesia</label>
                            <div class="col-md-9">
                                <select class="form-control" name="freguesia" id="freguesia" disabled required>

                                </select>
                            </div>

                        </div>

                        <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">

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

<div id="editar_instalacao" class="modal  fade in" role="dialog" aria-hidden="true">
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
</div>

<div id="edit_stock_artigo" class="modal fade in" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Editar Quantidade</h4>
            </div>
            <form action="#" class="form-horizontal" id="form_editar_quantidade_artigo" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Armazem Saída</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="quantidade" min="0" required id="editar_stock_quantidade">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                        <button type="submit" class="btn green">Editar</button>
                    </div>
                </div>
                <input type="hidden" id="editar_stock_id_armazem" name="editar_stock_id_armazem">
                <input type="hidden" id="editar_stock_id_artigo" name="editar_stock_id_artigo">
            </form>

        </div>
    </div>
</div>
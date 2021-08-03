<style>
    .dataTables_filter {
        text-align: end;
    }

    .dataTables_paginate.paging_bootstrap_number {
        text-align: end;
    }
</style>
<input type="hidden" id="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>clientes">Clientes</a>
            <i class="fa fa-circle"></i>
        </li>

    </ul>

</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Vista Geral | <?php echo $cliente['cliente']; ?>

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
                            <a href="<?php echo base_url(); ?>instalacoes/instalacoes_cliente/<?php echo $cliente['id_cliente']; ?>">
                                <i class="icon-home"></i> Instalações </a>
                        </li>
                        <li class="active">
                            <a href="<?php echo base_url(); ?>clientes/tabela_precos/<?php echo $cliente['id_cliente']; ?>">
                                <i class="fa fa-book"></i> Tabela de Preços </a>
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
                                <span class="caption-subject font-blue-madison bold uppercase">Tabela de Preços</span>
                            </div>
                            <ul class="nav nav-tabs">

                                <li class="active">
                                    <a href="#tab_1_2" data-toggle="tab">Tabela de Preços</a>
                                </li>

                            </ul>
                        </div>

                        <div class="portlet-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1_2">

                                    <table class="table table-striped table-bordered table-hover order-column" id="table_tabela_precos">
                                        <thead>
                                            <tr>
                                                <th> Referência </th>
                                                <th> Artigo </th>
                                                <th> Familia </th>
                                                <th> Marca </th>
                                                <th> Ano Fabrico</th>
                                                <th width="10%"> Fotografia</th>
                                                <th> Detalhes </th>
                                                <th width="18%"> </th>
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
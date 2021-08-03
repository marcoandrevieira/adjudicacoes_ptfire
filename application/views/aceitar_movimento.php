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

    .input-group {
        display: flex;
    }

    ul {
        list-style-type: none;
    }
</style>
<input type="hidden" id="id_armazem_saida" value="<?php echo $movimento['id_armazem_saida']; ?>">
<input type="hidden" id="id_armazem_entrada" value="<?php echo $movimento['id_armazem_entrada']; ?>">
<input type="hidden" id="id_movimento" value="<?php echo $movimento['id_movimento']; ?>">


<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>armazens/movimentar_stock/<?= $movimento['id_armazem_saida'] ?>">Aceitar Stock</a>
            <i class="fa fa-circle"></i>
        </li>

    </ul>

</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title"> Aceitar Stock</h3>
    </div>
</div>

<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12" style="border: 1px solid #ECECEC;">
        <div class="profile-sidebar">
            <div class="portlet light profile-sidebar-portlet ">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-arrows-h font-dark"></i>
                            <span class="caption-subject font-dark sbold uppercase"> Movimento</span>
                        </div>
                    </div>

                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->

                        <div class="form-body">

                            <!--<h2 class="margin-bottom-20"> Fatura - <span class="numero_fatura"></span> </h2>-->
                            <h3 class="form-section">Info</h3>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Armazém de Saída:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static "><b><?= $movimento['armazem_saida'] ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Armazém de Entrada:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><b><?= $movimento['armazem_entrada'] ?></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Criado Por:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?= $movimento['criado_nome'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Data Criado:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"> <?= $movimento['data_insercao'] ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- END FORM-->
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>

                            <span class="caption-subject font-blue-madison bold uppercase">Artigos em Stock</span>

                        </div>

                        <ul class="nav nav-tabs">

                            <li class="active">
                                <a href="#tab_1_2" data-toggle="tab">Artigos em Stock</a>
                            </li>

                        </ul>
                    </div>

                    <div class="portlet-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab_1_2">

                                <table class="table table-striped table-bordered table-hover order-column" id="table_aceitar_movimento">
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
</div>
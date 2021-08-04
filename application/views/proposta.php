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

    /* .input-group {
        display: flex;
    } */

    ul {
        list-style-type: none;
    }
</style>

<input type="hidden" id="id_cliente" value="<?php echo $proposta['id_cliente']; ?>">
<input type="hidden" id="id_proposta" value="<?php echo $proposta['id_proposta']; ?>">


<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo base_url(); ?>propostas">Propostas</a>
            <i class="fa fa-circle"></i>
        </li>

    </ul>

</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<div class="row">
    <div class="col-md-8">
        <h3 class="page-title"> Proposta Nº: <?= $proposta['id_proposta'] ?></h3>
    </div>
    <div class="col md-4">
        <h3 class="page-title"> Dados envio</h3>
    </div>
</div>

<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-8" style="border: 1px solid #ECECEC; padding:1%">
        <div class="profile-sidebar">
            <div class="">

                <!--  <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-arrows-h font-dark"></i>
                            <span class="caption-subject font-dark sbold uppercase"> Proposta Nº: <?= $proposta['id_proposta'] ?></span>
                        </div>

                        <div class="page-toolbar">
                            <div class="pull-right">
                                <?php if (empty($proposta['data_envio'])) : ?>
                                    <a href="#" class="btn btn-outline green-jungle" onclick="fechar_movimento(<?= $proposta['id_proposta'] ?>, 1);"><i class="fa fa-unlock"></i> Fechar</a>
                                <?php else : ?>
                                    <a href="#" class="btn btn-outline red" onclick="fechar_movimento(<?= $movimento['id_proposta'] ?>, 0);"><i class="fa fa-unlock"></i> Abrir</a>

                                <?php endif; ?>

                            </div>
                        </div>

                    </div> -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <a href="#nova_artigo_proposta" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Artigos Proposta
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>

                                    <span class="caption-subject font-blue-madison bold uppercase">Artigos para Proposta</span>

                                </div>

                                <ul class="nav nav-tabs">

                                    <li class="active">
                                        <a href="#tab_1_2" data-toggle="tab">Artigos Proposta</a>
                                    </li>

                                </ul>
                            </div>

                            <div class="portlet-body">
                                <div class="tab-content">

                                    <div class="tab-pane active" id="tab_1_2">

                                        <table class="table table-striped table-bordered table-hover order-column" id="table_artigos_proposta">
                                            <thead>
                                                <tr>
                                                    <th> Referência </th>
                                                    <th> Artigo </th>
                                                    <th> Familia </th>
                                                    <th> Marca </th>
                                                    <th width="15%"> Fotografia</th>
                                                    <th> Qnt. </th>
                                                    <?php if ($_SESSION['id_tipo']) : ?>
                                                        <th>Preço</th>
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

                <!-- <div class="portlet-body form">
              

                        <div class="form-body">

                 
                            <h3 class="form-section"><?= $proposta['proposta'] ?></h3>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Cliente:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static "><b><?= $proposta['cliente'] ?></b></p>
                                        </div>
                                    </div>
                                </div>
                      
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Instalação:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><b><?= $proposta['instalacao'] ?></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Criado Por:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?= $proposta['nome'] ?></p>
                                        </div>
                                    </div>
                                </div>
                          

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Data Criado:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"> <?= $proposta['data_insercao'] ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    
                    </div> -->


            </div>
        </div>


    </div>


    <div class="col-md-4" style="border: 1px solid #ECECEC; padding:1%">
        <div class="profile-content">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" id="enviar_proposta_cliente" method="post">
                    <div class="form-body">

                        <!--<h2 class="margin-bottom-20"> Fatura - <span class="numero_fatura"></span> </h2>-->
                        <h3 class="form-section"><?= $proposta['proposta'] ?></h3>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-md-3">Lingua Proposta:</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="idioma" id="" required>
                                                <option hidden value="">--Selecione Idioma da Proposta</option>
                                                <option value="pt">Português</option>
                                                <option value="en">Inglês</option>
                                                <option value="fr">Francês</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-md-3">Cliente:</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" required name="cliente" value="<?= $proposta['cliente'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-md-3">Data Proposta:</label>
                                        <div class="col-md-9">
                                            <input type="date" required class="form-control" name="data_envio" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-md-3">Email:</label>
                                        <div class="col-md-9">
                                            <input type="email" required class="form-control" name="email" value="<?= $proposta['email'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-md-3">Criado por:</label>
                                        <div class="col-md-9">
                                            <input type="text" required class="form-control" name="enviado_por" value="<?= $proposta['nome'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-md-3">Observações p/ cliente:</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="obs_cliente" id="" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_proposta" value="<?php echo $proposta['id_proposta']; ?>">
                        <br>
                        <br>
                        <button type="submit" class="btn btn-outline green-jungle btn-block">Enviar Proposta ao Cliente</button>

                    </div>
                    <!-- END FORM-->
                </form>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>

</div>

<div id="nova_artigo_proposta" class="modal  fade in" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"> Artigos Proposta</h4>
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
                            <th> Preço Proposta</th>
                            <th> Quantidade</th>
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
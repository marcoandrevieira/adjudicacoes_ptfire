<input type="hidden" id="id_instalacao" value="<?= $this->uri->segment(3); ?>">
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
            <a >Histórico dos fornecimentos de material </a>
            <i class="fa fa-circle"></i>
        </li>
    </ul>
</div>

<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Histórico Fornecimentos de material

</h3>
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

                                <span class="caption-subject font-blue-madison bold uppercase">Lista de fornecimentos</span>

                            </div>

                            <ul class="nav nav-tabs">

                                <li class="active">
                                    <a href="#tab_1_2" data-toggle="tab">Histórico Fornecimento</a>
                                </li>

                            </ul>
                        </div>

                        <div class="portlet-body">
                            <div class="tab-content">

                                    <table class="table table-striped table-bordered table-hover order-column" id="table_historico_fornecimento">
                                        <thead>
                                            <tr>
                                                <th>Projeto/Adjudicação</th>
                                                <th>Armazem de Saída</th>
                                                <th>Criado Por</th>
                                                <th>Data Criado</th>
                                                <th>Fechado Por</th>
                                                <th>Data Fecho </th>
                                                <th></th>
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
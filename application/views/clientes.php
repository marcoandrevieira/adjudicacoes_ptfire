  <!-- BEGIN PAGE BAR -->

  <link href="<?php echo plugins_url(); ?>datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
  <div class="page-bar">
      <ul class="page-breadcrumb">
          <li>
              <i class="fa fa-circle"></i>
          </li>

          <li>
              <span>Clientes</span>
          </li>
      </ul>

  </div>
  <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h3 class="page-title"> Clientes
      <small>disponiveis</small>
  </h3>
  <div class="row">
      <div class="col-md-12">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bordered ">
              <div class="portlet-title">
                  <div class="caption bold font-yellow-saffron">
                      <i class="fa fa-newspaper-o font-blue-steel"></i>
                      <span class="caption-subject uppercase font-blue-steel"> Clientes</span>
                  </div>

              </div>
              <div class="portlet-body">
                  <div class="table-toolbar">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="btn-group">
                                  <a href="#novo_cliente" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Novo Cliente
                                      <i class="fa fa-plus"></i>
                                  </a>

                              </div>
                          </div>

                      </div>
                  </div>

                  <table class="table table-striped table-bordered table-hover order-column" id="table_clientes">
                      <thead>
                          <tr>

                              <th class="center"> Cliente </th>
                              <th> NIF </th>
                              <th> Morada </th>
                              <th> Telefone</th>
                              <th> </th>
                          </tr>
                      </thead>
                      <tbody>

                      </tbody>
                  </table>
              </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET-->
      </div>
  </div>
  <link href="<?php echo base_url(); ?>admin_assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
  
  <div id="novo_cliente" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Novo Cliente</h4>
              </div>

              <div class="modal-body">
                  <form action="#" class="form-horizontal" id="form_novo_cliente" method="post" enctype="multipart/form-data">

                      <div class="portlet-body">
                          <div class="form-body">

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Cliente</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" required name="cliente" placeholder="Designação Cliente">


                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-2 control-label">NIF</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" required name="nif" placeholder="NIF">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Morada</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" name="morada" placeholder="Morada Completa">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Telefone</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" required name="telefone" placeholder="Telefone">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Email</label>
                                  <div class="col-md-10">
                                      <input type="email" class="form-control" name="email" placeholder="Email">

                                  </div>
                              </div>
                          </div>
                      </div>





              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                  <button type="submit" class="btn green">Criar</button>
              </div>
              </form>
          </div>
      </div>
  </div>


  <div id="editar_cliente" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Editar Cliente</h4>
              </div>

              <div class="modal-body">
                  <form action="#" class="form-horizontal" id="form_editar_cliente" method="post" enctype="multipart/form-data">


                      <div class="portlet-body">
                          <div class="form-body">

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Cliente</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" required name="cliente" id="editar_nomecliente" placeholder="Designação Cliente">


                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-2 control-label">NIF</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" required name="nif" id="editar_nif" placeholder="NIF">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Morada</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" name="morada" id="editar_morada" placeholder="Morada Completa">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Telefone</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" required name="telefone" id="editar_telefone" placeholder="Telefone">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Email</label>
                                  <div class="col-md-10">
                                      <input type="email" class="form-control" name="email" id="editar_email" placeholder="Email">

                                  </div>
                              </div>
                          </div>
                      </div>


                      <input type="hidden" name="id_cliente" value="" id="cliente_selecionado">


              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                  <button type="submit" class="btn green">Atualizar</button>
              </div>
              </form>
          </div>
      </div>
  </div>
  <!-- BEGIN PAGE BAR -->

  <link href="<?php echo plugins_url(); ?>datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
  <div class="page-bar">
      <ul class="page-breadcrumb">
          <li>
              <i class="fa fa-circle"></i>
          </li>

          <li>
              <span>Armazens</span>
          </li>
      </ul>

  </div>
  <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h3 class="page-title"> Armazens
      <small>disponiveis</small>
  </h3>
  <div class="row">
      <div class="col-md-12">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bordered ">
              <div class="portlet-title">
                  <div class="caption bold font-yellow-saffron">
                      <i class="fa fa-newspaper-o font-blue-steel"></i>
                      <span class="caption-subject uppercase font-blue-steel"> Armazens</span>
                  </div>

              </div>
              <div class="portlet-body">
                <?php if($_SESSION['id_tipo'] == 1):?>
                  <div class="table-toolbar">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="btn-group">
                                  <a href="#novo_armazem" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Novo Armazem
                                      <i class="fa fa-plus"></i>
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
                  <?php endif;?>

                  <table class="table table-striped table-bordered table-hover order-column" id="table_armazens">
                      <thead>
                          <tr>
                              <th> Armazens </th>
                              <th> Morada </th>
                              <th> Notas </th>
                              <th width="10%"> </th>
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
  <div id="novo_armazem" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Novo Armazem</h4>
              </div>

              <div class="modal-body">
                  <form action="#" class="form-horizontal" id="form_novo_armazem" method="post" enctype="multipart/form-data">

                      <div class="portlet-body">
                          <div class="form-body">

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Armazem</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" name="armazem" placeholder="Designação Armazem" required>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Morada</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" name="morada" placeholder="Morada">
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Detalhes/Notas</label>
                                  <div class="col-md-10">
                                      <textarea class="form-control" name="notas" id="" cols="30" rows="3"></textarea>

                                  </div>
                              </div>

                          </div>
                      </div>

              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                  <button type="submit" class="btn green">Criar Armazem</button>
              </div>
              </form>
          </div>
      </div>
  </div>


  <div id="editar_armazem" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Editar Cliente</h4>
              </div>

              <div class="modal-body">
                  <form action="#" class="form-horizontal" id="form_editar_armazem" method="post" enctype="multipart/form-data">


                      <div class="portlet-body">
                          <div class="form-body">

                          <div class="form-group">
                                  <label class="col-md-2 control-label">Armazem</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" name="armazem" id="editar_armazem_nome" placeholder="Designação Armazem" required>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Morada</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" name="morada" id="editar_morada" placeholder="Morada">
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Detalhes/Notas</label>
                                  <div class="col-md-10">
                                      <textarea class="form-control" name="notas" id="editar_notas" cols="30" rows="3"></textarea>

                                  </div>
                              </div>

                          </div>
                      </div>


                      <input type="hidden" name="id_armazem" value="" id="armazem_selecionado">


              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                  <button type="submit" class="btn green">Atualizar</button>
              </div>
              </form>
          </div>
      </div>
  </div>
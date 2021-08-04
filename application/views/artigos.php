  <!-- BEGIN PAGE BAR -->

  <link href="<?php echo plugins_url(); ?>datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
  <div class="page-bar">
      <ul class="page-breadcrumb">
          <li>
              <i class="fa fa-circle"></i>
          </li>

          <li>
              <span>Artigos</span>
          </li>
      </ul>

  </div>
  <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <h3 class="page-title"> Artigos
      <small>disponiveis</small>
  </h3>
  <div class="row">
      <div class="col-md-12">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light bordered ">
              <div class="portlet-title">
                  <div class="caption bold font-yellow-saffron">
                      <i class="fa fa-newspaper-o font-blue-steel"></i>
                      <span class="caption-subject uppercase font-blue-steel"> Artigos</span>
                  </div>

              </div>
              <div class="portlet-body">
                  <div class="table-toolbar">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="btn-group">
                                  <a href="#novo_artigo" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Novo Artigo
                                      <i class="fa fa-plus"></i>
                                  </a>

                              </div>
                          </div>

                      </div>
                  </div>

                  <table class="table table-striped table-bordered table-hover order-column" id="table_artigos">
                      <thead>
                          <tr>
                              <th> Referência </th>
                              <th> Artigo </th>
                              <th> Familia </th>
                              <th> Marca </th>
                              <th> Ano Fabrico</th>
                              <th width="10%"> Fotografia</th>
                              <th> Detalhes </th>
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
  <div id="novo_artigo" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Novo Artigo</h4>
              </div>

              <div class="modal-body">
                  <form action="#" class="form-horizontal" id="form_novo_artigo" method="post" enctype="multipart/form-data">

                      <div class="portlet-body">
                          <div class="form-body">

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Nome Artigo PT</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" name="artigo" placeholder="Designação Artigo" required>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Nome Artigo EN</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" name="artigo_en" placeholder="Designação Artigo EN" required>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Nome Artigo FR</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" name="artigo_fr" placeholder="Designação Artigo FR" required>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Referência</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" name="referencia" placeholder="Referencia/Código Barras">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Familia Artigo</label>
                                  <div class="col-md-10">
                                      <select class="form-control" name="familia_artigo" id="" required>
                                          <option value="" selected disabled hidden>--Selecione Familia Artigo</option>
                                          <?php foreach ($familias as $familia) : ?>
                                              <option value="<?= $familia['id_familia'] ?>"><?= $familia['familia'] ?></option>
                                          <?php endforeach; ?>
                                      </select>

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Marca</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" name="marca" placeholder="Marca do Artigo">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Ano de Fabrico</label>
                                  <div class="col-md-10">
                                      <input type="date" class="form-control" name="ano_fabrico" placeholder="Ano de fabrico (se aplicável)">

                                  </div>
                              </div>

                              <div class="form-group">

                                  <label class="col-md-2 control-label">Fotografias do Artigo</label>
                                  <div class="col-md-5">
                                      <input type="file" class="form-control" name="foto1" placeholder="Fotografia 1">
                                  </div>
                                  <div class="col-md-5">
                                      <input type="file" class="form-control" name="foto2" placeholder="Fotografia 2">
                                  </div>
                              </div>



                              <div class="form-group">
                                  <label class="col-md-2 control-label">Detalhes/Notas</label>
                                  <div class="col-md-10">
                                      <textarea class="form-control" name="detalhes" id="" cols="30" rows="3"></textarea>

                                  </div>
                              </div>

                          </div>
                      </div>





              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                  <button type="submit" class="btn green">Criar Artigo</button>
              </div>
              </form>
          </div>
      </div>
  </div>


  <div id="editar_artigo" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Editar Cliente</h4>
              </div>

              <div class="modal-body">
                  <form action="#" class="form-horizontal" id="form_editar_artigo" method="post" enctype="multipart/form-data">


                      <div class="portlet-body">
                          <div class="form-body">

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Artigo</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" name="artigo" id="editar_artigo_nome" placeholder="Designação Artigo PT" required>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Nome Artigo EN</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" name="artigo_en" id="editar_artigo_nome_en" placeholder="Designação Artigo EN" required>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-md-2 control-label">Nome Artigo FR</label>
                                  <div class="col-md-10">
                                      <input class="form-control" type="text" name="artigo_fr" id="editar_artigo_nome_fr" placeholder="Designação Artigo FR" required>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Referência</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" name="referencia" id="editar_referencia" placeholder="Referencia/Código Barras">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Familia Artigo</label>
                                  <div class="col-md-10">
                                      <select class="form-control" name="familia_artigo" id="editar_familia_artigo" required>
                                          <option value="" selected disabled hidden>--Selecione Familia Artigo</option>
                                          <?php foreach ($familias as $familia) : ?>
                                              <option value="<?= $familia['id_familia'] ?>"><?= $familia['familia'] ?></option>
                                          <?php endforeach; ?>
                                      </select>

                                  </div>
                              </div>



                              <div class="form-group">
                                  <label class="col-md-2 control-label">Marca</label>
                                  <div class="col-md-10">
                                      <input type="text" class="form-control" name="marca" id="editar_marca" placeholder="Marca do Artigo">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Ano de Fabrico</label>
                                  <div class="col-md-10">
                                      <input type="date" class="form-control" name="ano_fabrico" id="editar_ano_fabrico" placeholder="Ano de fabrico (se aplicável)">

                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">Fotos</label>
                                  <div class="col-md-5">
                                      <img src="" id="editar_foto1" width="100%" alt="">
                                  </div>
                                  <div class="col-md-5">
                                      <img src="" id="editar_foto2" width="100%" alt="">
                                  </div>
                              </div>

                              <div class="form-group">

                                  <label class="col-md-2 control-label">Fotografias do Artigo</label>
                                  <div class="col-md-5">
                                      <input type="file" class="form-control" name="foto1" placeholder="Fotografia 1">
                                  </div>
                                  <div class="col-md-5">
                                      <input type="file" class="form-control" name="foto2" placeholder="Fotografia 2">
                                  </div>
                              </div>



                              <div class="form-group">
                                  <label class="col-md-2 control-label">Detalhes/Notas</label>
                                  <div class="col-md-10">
                                      <textarea class="form-control" name="detalhes" id="editar_detalhes" cols="30" rows="3"></textarea>

                                  </div>
                              </div>

                          </div>
                      </div>


                      <input type="hidden" name="id_artigo" value="" id="artigo_selecionado">


              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                  <button type="submit" class="btn green">Atualizar</button>
              </div>
              </form>
          </div>
      </div>
  </div>
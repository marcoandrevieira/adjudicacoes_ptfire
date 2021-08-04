  <!-- BEGIN PAGE BAR -->
  <input type="hidden" id="id_projeto" value="<?= $this->uri->segment(3) ?>">
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
                      <span class="caption-subject uppercase font-blue-steel">Selecione armazem de onde irá ser fornecido o material </span>
                  </div>

              </div>
              <div class="portlet-body">
                  
                  <table class="table table-striped table-bordered table-hover order-column" id="table_armazens_fornecimento">
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

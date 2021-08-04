<!DOCTYPE html>

<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Adjudicações</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for basic datatable samples" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo plugins_url(); ?>datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo plugins_url(); ?>bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo css_url(); ?>components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo css_url(); ?>plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo layout_url(); ?>css/layout.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo layout_url(); ?>css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo layout_url(); ?>css/custom.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" page-content-white page-sidebar-closed">
        <div class="page-wrapper">
           
          
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
               
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                       
                        <div class="row">
                            <div class="col-md-12">
                                
                               
                                <!-- Begin: Demo Datatable 2 -->
                                
                                <div class="table-actions-wrapper pull-right">
                                                <span> </span>
                                                <select class="table-group-action-input form-control input-inline input-small input-sm" name="tipo" id="tipo_filtro">
                                                    <option value="">Seleciona...</option>
                                                    <?php 
                                                        for($i=0;$i<count($tipo);$i++){
                                                            echo '<option value="'.$tipo[$i]['id_tipo_servico'].'">'.$tipo[$i]['tipo'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <select class="table-group-action-input form-control input-inline input-small input-sm" name="estado" id="estado_filtro">
                                                    <option value="">Seleciona...</option>
                                                    <?php 
                                                        for($i=0;$i<count($estado);$i++){
                                                            echo '<option value="'.$estado[$i]['id_estado'].'">'.$estado[$i]['estado'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                               
                                            </div>
                                    <div class="portlet-body">
                                        <div class="table-container">
                                            
                                            <table class="table table-hover monitores " id="datatable_monitor">
                                                <thead>
                                                    <tr role="row" class="heading">
                                                        
                                                        <th> Estado</th>
                                                        <th> Tipo</th>
                                                        <th> Cliente </th>
                                                        <th> Instalação </th>
                                                        <th> Projeto </th>
                                                        <th> Total </th>
                                                        <th> Data Inicio </th>
                                                        <th> Data Conclusão</th>
                                                        <!--<th> Data Concluido </th>-->
                                                        <!--<th> Criado Por </th>-->
                                                       
                                                    </tr>
                                                    <!--<tr role="row" class="filter">
                                                        <td> </td>
                                                        <td>
                                                            <input type="text" class="form-control form-filter input-sm" name="order_id"> </td>
                                                        <td>
                                                            <div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
                                                                <input type="text" class="form-control form-filter input-sm" readonly name="order_date_from" placeholder="From">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-sm default" type="button">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                                                                <input type="text" class="form-control form-filter input-sm" readonly name="order_date_to" placeholder="To">
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-sm default" type="button">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-filter input-sm" name="order_customer_name"> </td>
                                                        <td>
                                                            <input type="text" class="form-control form-filter input-sm" name="order_ship_to"> </td>
                                                        <td>
                                                            <div class="margin-bottom-5">
                                                                <input type="text" class="form-control form-filter input-sm" name="order_price_from" placeholder="From" /> </div>
                                                            <input type="text" class="form-control form-filter input-sm" name="order_price_to" placeholder="To" /> </td>
                                                        <td>
                                                            <div class="margin-bottom-5">
                                                                <input type="text" class="form-control form-filter input-sm margin-bottom-5 clearfix" name="order_quantity_from" placeholder="From" /> </div>
                                                            <input type="text" class="form-control form-filter input-sm" name="order_quantity_to" placeholder="To" /> </td>
                                                        <td>
                                                            <select name="order_status" class="form-control form-filter input-sm">
                                                                <option value="">Select...</option>
                                                                <option value="pending">Pending</option>
                                                                <option value="closed">Closed</option>
                                                                <option value="hold">On Hold</option>
                                                                <option value="fraud">Fraud</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="margin-bottom-5">
                                                                <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                                    <i class="fa fa-search"></i> Search</button>
                                                            </div>
                                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                                <i class="fa fa-times"></i> Reset</button>
                                                        </td>
                                                    </tr>-->
                                                </thead>
                                                <tbody> </tbody>
                                            </table>
                                        </div>
                                    </div>
                               
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                
            </div>
            <!-- END CONTAINER -->
           
        </div>
        
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script> var baseurl='<?php echo base_url(); ?>';</script>
        <script src="<?php echo plugins_url(); ?>jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo scripts_url(); ?>datatable.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo plugins_url(); ?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo scripts_url(); ?>app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo scripts_url(); ?>monitores.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo layout_url(); ?>scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo layout_url(); ?>scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo layout_url(); ?>scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo layout_url(); ?>scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
    </body>

</html>
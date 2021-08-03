   </div>
   <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
   </div>
   <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
   <div class="page-footer">
       <div class="page-footer-inner"> <?php echo date('Y'); ?> &copy; Grupo Safety por
           <a href="http://www.oficinacriativa.pt" title="Oficina Criativa" target="_blank">Oficina Criativa</a>.
       </div>
       <div class="scroll-to-top">
           <i class="icon-arrow-up"></i>
       </div>
   </div>
   <!-- END FOOTER -->
   <!--[if lt IE 9]>
<script src="../admin_assets/global/plugins/respond.min.js"></script>
<script src="../admin_assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
   <!-- BEGIN CORE PLUGINS -->
   <script type="text/javascript">
       var baseurl = "<?php echo base_url(); ?>";
   </script>
   <script src="<?php echo plugins_url(); ?>jquery.min.js" type="text/javascript"></script>
   <script src="<?php echo scripts_url(); ?>menus.js" type="text/javascript"></script>
   <script src="<?php echo plugins_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
   <script src="<?php echo plugins_url(); ?>js.cookie.min.js" type="text/javascript"></script>
   <script src="<?php echo plugins_url(); ?>bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
   <script src="<?php echo plugins_url(); ?>jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
   <script src="<?php echo plugins_url(); ?>jquery.blockui.min.js" type="text/javascript"></script>
   <script src="<?php echo plugins_url(); ?>uniform/jquery.uniform.min.js" type="text/javascript"></script>
   <script src="<?php echo plugins_url(); ?>bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
   <!-- END CORE PLUGINS -->
   <!-- BEGIN PAGE LEVEL PLUGINS -->

   <?php
    //print_r($scripts);
    if (!empty($scripts['page_level_plugins'])) {
        foreach ($scripts['page_level_plugins'] as $plugin) {
            echo $plugin . "\n";
        }
    }
    ?>
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN THEME GLOBAL SCRIPTS -->
   <script src="<?php echo scripts_url(); ?>app.min.js" type="text/javascript"></script>
   <!-- END THEME GLOBAL SCRIPTS -->
   <!-- BEGIN PAGE LEVEL SCRIPTS -->

   <?php
    /*print_r($scripts);*/
    if (!empty($scripts['page_level_scripts'])) {
        foreach ($scripts['page_level_scripts'] as $script) {
            echo $script . "\n";
        }
    }

    ?>

   <!-- END PAGE LEVEL SCRIPTS -->
   <!-- BEGIN THEME LAYOUT SCRIPTS -->
   <script src="<?php echo layout_url(); ?>scripts/layout.min.js" type="text/javascript"></script>
   <script src="<?php echo layout_url(); ?>scripts/demo.min.js" type="text/javascript"></script>
   <script src="<?php echo layout_url(); ?>scripts/quick-sidebar.min.js" type="text/javascript"></script>

   <!-- END THEME LAYOUT SCRIPTS -->

   <script>
       $.ajax({
           url: '<?= base_url() ?>armazens/span_movimentos_pendentes',
           type: 'get',
           success: function(d) {
               let valor = $.parseJSON(d)
               console.log(valor)
               $("#movimentos_nao_aceites").html('<span class="badge badge-danger">' + valor + '</span>')
           }
       })
   </script>



   </body>

   </html>
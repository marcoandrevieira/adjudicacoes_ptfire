 <!-- BEGIN SIDEBAR -->
 <div class="page-sidebar-wrapper">
     <!-- BEGIN SIDEBAR -->
     <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
     <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
     <div class="page-sidebar navbar-collapse collapse">
         <!-- BEGIN SIDEBAR MENU -->
         <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
         <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
         <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
         <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
         <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
         <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
         <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
             <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
             <li class="sidebar-toggler-wrapper hide">
                 <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                 <div class="sidebar-toggler"> </div>
                 <!-- END SIDEBAR TOGGLER BUTTON -->
             </li>
             <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
             <li class="sidebar-search-wrapper">
                 <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                 <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                 <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                 <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                     <a href="javascript:;" class="remove">
                         <i class="icon-close"></i>
                     </a>

                 </form>
                 <!-- END RESPONSIVE QUICK SEARCH FORM -->
             </li>

             <?php if ($_SESSION['id_tipo'] != 3) : ?>
                 <li class="nav-item">
                     <a href="<?php echo base_url(); ?>clientes" class="nav-link">
                         <i class="icon-users"></i>
                         <span class="title">Clientes</span>
                     </a>
                 </li>
             <?php endif; ?>
             <?php if ($_SESSION['id_tipo'] != 3) : ?>
                 <li class="nav-item">
                     <a href="<?php echo base_url(); ?>artigos" class="nav-link">
                         <i class="fa fa-cubes"></i>
                         <span class="title">Artigos</span>
                     </a>
                 </li>
             <?php endif; ?>
             <li class="nav-item">
                 <a href="<?php echo base_url(); ?>armazens" class="nav-link">
                     <i class="fa fa-industry"></i>
                     <span class="title">Armazens</span>
                 </a>
             </li>
             <li class="nav-item">
                 <a href="<?php echo base_url(); ?>armazens/movimentos_pendentes" class="nav-link">
                     <i class="fa fa-exchange"></i>
                     <span class="title">Movimentos Pendentes <div id="movimentos_nao_aceites"></div></span>
                 </a>
             </li>

             <li class="nav-item">
                 <a href="<?php echo base_url(); ?>monitores/" class="nav-link" target="_blank">
                     <i class="fa fa-desktop"></i>
                     <span class="title">Monitor</span>
                 </a>

             </li>
             <li class="nav-item">
                 <a href="<?php echo base_url(); ?>admin/adjudicacoes" class="nav-link">
                     <i class="fa fa fa-diamond"></i>
                     <span class="title">Adjudicações</span>
                 </a>

             </li>
             <?php if ($_SESSION['id_tipo'] != 3) : ?>
                 <li class="nav-item">
                     <a href="<?php echo base_url(); ?>faturacao" class="nav-link">
                         <i class="fa fa-file-text-o"></i>
                         <span class="title">Faturação</span>
                     </a>

                 </li>
             <?php endif; ?>
             <?php if ($_SESSION['id_tipo'] != 3) : ?>
                 <li class="nav-item">
                     <a href="<?php echo base_url(); ?>faturacao/analises_KPI" class="nav-link">
                     <i class="fa fa-table" aria-hidden="true"></i>
                         <span class="title">Análises KPI</span>
                     </a>

                 </li>
             <?php endif; ?>
             <?php if ($this->session->userdata('id_tipo') == 1) { ?>
                 <li class="nav-item">
                     <a href="<?php echo base_url(); ?>admin/servicos/" class="nav-link">
                         <i class="fa fa-th-list"></i>
                         <span class="title">Tipo Serviço</span>
                     </a>

                 </li>
             <?php } ?>
             <?php if ($this->session->userdata('master') == 1) { ?>
                 <li class="nav-item">
                     <a href="<?php echo base_url(); ?>admin/estado/" class="nav-link">
                         <i class="fa fa-list-alt"></i>
                         <span class="title">Estado</span>
                     </a>

                 </li>
             <?php } ?>
             <?php if ($this->session->userdata('id_tipo') == 1) { ?>
                 <li class="nav-item">
                     <a href="<?php echo base_url(); ?>admin/utilizadores/" class="nav-link">
                         <i class="fa fa-users"></i>
                         <span class="title">Utilizadores</span>
                     </a>

                 </li>
             <?php } ?>






         </ul>

         <!-- END SIDEBAR MENU -->
         <!-- END SIDEBAR MENU -->
     </div>
     <!-- END SIDEBAR -->
 </div>
 <!-- END SIDEBAR -->

 <div class="page-content-wrapper">
     <!-- BEGIN CONTENT BODY -->
     <div class="page-content">
         <!-- BEGIN PAGE HEADER-->
<link href="<?php echo plugins_url();?>bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugins_url();?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" /> 
<link href="<?php echo plugins_url();?>bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />  
<link href="<?php echo plugins_url();?>bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />

 <link href="<?php echo plugins_url();?>bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" /> 
 

 <link href="<?php echo plugins_url();?>jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
 <?php //print_r($_SESSION); ?>
 <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="#">Serviços</a>
                                
                            </li>
                            
                           
                             <!--<li>
                            	
                                <a href="#"><?php //echo $intervencao['instalacao']['instalacao']; ?></a>
                                 <i class="fa fa-circle"></i>
                            </li>
                            
                            <li>
                                <a href="#">Relatórios</a>
                               
                            </li>-->
                            
                        </ul>
                      </div>  
                    
                     <!-- BEGIN PAGE TITLE-->
                     
                    
                    <h3 class="page-title">Serviços
                        <small>Tipo</small>
                    </h3>
                    
                    
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-grey-gallery">
                                <i class="fa fa-barcode font-grey-gallery"></i>
                                <span class="caption-subject bold uppercase">Serviços </span>
                            </div>
                        </div>
                        
                        <div class="portlet-body">
                            
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="#novo_servico" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Novo Serviço
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                           
                                </div>
                            </div>

                            <div class="table-container">
                                <span> </span>
                                <!--<div class="alert alert-success display-hide alert_movimento_inserido"><button class="close" data-close="alert"></button> <span>O movimento foi inserido, consulte a tabela abaixo.</span> </div>
                                <div class="alert alert-success display-hide alert_movimento_editado"><button class="close" data-close="alert"></button> <span>O movimento foi editado com sucesso!</span> </div>
                                <div class="alert alert-success display-hide alert_movimento_removido"><button class="close" data-close="alert"></button> <span>O movimento foi eliminado com sucesso!</span> </div>
                                -->
                                <div class="alert alert-danger display-hide alert_apaga_servico"><button class="close" data-close="alert"></button> <span>O serviço <span id="servico_apagar"></span> irá ser apagado! Deseja continuar?</span> </div>
                                <div class="alert alert-success display-hide alert_servico_removido"><button class="close" data-close="alert"></button> <span>O serviço <span id="servico_apagado"></span> foi eliminado com sucesso!</span> </div>
                                <table class="table table-striped table-bordered table-hover" id="datatable_projetos">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th>Tipo</th>
                                            <th>Cor</th>
                                            <th>Ordem</th>
                                            <th>Estado</th>
                                            <th>Actions</th>
                                        </tr>
                                        
                                        <tr role="row" class="filter">
                                        

                                        <td>
                                            <input class="form-control form-filter" name="tipo" />
                                        </td>
                                    
                                        <td>
                                            <input class="form-control form-filter" name="cor" />
                                        </td>
                                        
                                        <td>
                                            <input class="form-control form-filter" name="ordem" />
                                        </td>
                                        <td>
                                            <select class="form-control form-filter" name="ativo">
                                                <option value=""></option>
                                                <option value="ativo">Ativo</option>
                                                <option value="inativo">Inativo</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="col-md-12">            
                                                <div class="margin-bottom-5">
                                                    <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                        <i class="fa fa-search"></i> Pesquisar</button>
                                                </div>
                                                <button class="btn btn-sm btn-default btn-outline filter-cancel red"><i class="fa fa-times"></i> Limpar</button>
                                            </div>   
                                        </td>  
                                           
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div id="novo_servico" class="modal fade" role="dialog" aria-hidden="true">
                   	        <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                            	    <div class="modal-header">
                                	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Novo Serviço</h4>
                                    </div>
                                
                                <div class="modal-body">
                                    <form action="#" class="form-horizontal" id="form_novo_servico" method="post" enctype="multipart/form-data" >
                                        <div class="alert alert-danger display-hide">
                                        	<button class="close" data-close="alert"></button> Tem alguns erros. Por favor verifique abaixo. </div>
                                     	<div class="alert alert-success display-hide">
                                        	<button class="close" data-close="alert"></button> O serviço foi inserido com sucesso! </div>
                                     	<div class="alert alert-info display-hide">
                                        	<button class="close" data-close="alert"></button> A validação do formulário foi um sucesso! Espere até a janela fechar. </div>
                                     
                                	<div class="portlet-body">
                                        <div class="form-body">
                                            
                                            

                                            <div class="form-group">
                                       		    <label class="control-label col-md-2">Tipo</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="tipo" placeholder="Tipo">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Cor</label>
                                                <div class="col-md-10">
                                                <input type="text" id="hue-demo" class="form-control demo" data-control="hue" value="" name="cor">
                                                   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Ordem</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="ordem" placeholder="Ordem">
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Ativo</label>
                                                <div class="col-md-10">
                                                    <div class="radio-list">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="ativo" id="optionsRadios25" value="1" checked> Sim </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="ativo" id="optionsRadios26" value="0" > Não </label>
                                                       
                                                    </div>
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





                        <div id="edita_servico" class="modal fade" role="dialog" aria-hidden="true">
                   	        <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                            	    <div class="modal-header">
                                	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Editar Serviço</h4>
                                    </div>
                                
                                <div class="modal-body">
                                    <form action="#" class="form-horizontal" id="form_edita_servico" method="post" enctype="multipart/form-data" >
                                        <div class="alert alert-danger display-hide">
                                        	<button class="close" data-close="alert"></button> Tem alguns erros. Por favor verifique abaixo. </div>
                                     	<div class="alert alert-success display-hide">
                                        	<button class="close" data-close="alert"></button> O serviço foi inserido com sucesso! </div>
                                     	<div class="alert alert-info display-hide">
                                        	<button class="close" data-close="alert"></button> A validação do formulário foi um sucesso! Espere até a janela fechar. </div>
                                     
                                	<div class="portlet-body">
                                        <div class="form-body">
                                            
                                            

                                            <div class="form-group">
                                       		    <label class="control-label col-md-2">Tipo</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="tipo" placeholder="Tipo" id="edita_tipo">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Cor</label>
                                                <div class="col-md-10">
                                                <input type="text" class="form-control demo" data-control="hue"  name="cor" id="edita_cor">
                                                   
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Ordem</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="ordem" placeholder="Ordem" id="edita_ordem">
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Ativo</label>
                                                <div class="col-md-10">
                                                    <div class="radio-list">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="ativo" id="ativo" value="1" checked> Sim </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="ativo" id="inativo" value="0" > Não </label>
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>	
                                </div>
                                <div class="modal-footer">
                                	<button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                                    <button type="submit" class="btn green">Atualizar</button>
                               	</div>  
                            </form>                   
                            </div>  
                        </div>
                    </div>
                 
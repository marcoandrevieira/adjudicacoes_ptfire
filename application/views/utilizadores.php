  <!-- BEGIN PAGE BAR -->

        <link href="<?php echo plugins_url(); ?>datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.html">ADMIN</a>
                                <i class="fa fa-circle"></i>
                            </li>
                           
                            <li>
                                <span>Utilizadores</span>
                            </li>
                        </ul>
                      
                    </div>
                    <!-- END PAGE BAR -->
                     <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Utilizadores
                        <small>disponiveis</small>
                    </h3>
 					<div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered ">
                                <div class="portlet-title">
                                    <div class="caption bold font-yellow-saffron">
                                        <i class="fa fa-newspaper-o font-blue-steel"></i>
                                        <span class="caption-subject uppercase font-blue-steel"> Utilizadores</span>
                                    </div>
                                   
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn-group">
                                                	<a href="#novo_utilizador" id="sample_editable_1_new" data-toggle="modal"  class="btn sbold green-jungle">Novo Utilizador
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                   
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="alert alert-danger display-hide alert_apaga_utilizador"><button class="close" data-close="alert"></button> <span>O utilizador será apagado. Deseja Continuar?<span> </div>
                                    <div class="alert alert-success display-hide alert_utilizador_apagada"><button class="close" data-close="alert"></button> Utilizador apagado com sucesso!</div>
                                    <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                                        <thead>
                                            <tr>
                                               
                                              	<th class="center"> Email</th>
                                                <th> Nome </th>
                                                <th> Tipo </th>
                                                <th> Ativo</th>
                                                <th>  </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
											if(!empty($utilizadores)){	
												for ($i=0; $i<count($utilizadores); $i++){ ?>
                                            <tr class="odd gradeX">
                                              
                                               
                                                <td class="center">
                                                    <?php echo $utilizadores[$i]['email']; ?>
                                                </td>
                                                <td> <?php echo $utilizadores[$i]['nome']; ?> </td>
                                                <td class="center"> <?php echo $utilizadores[$i]['tipo']; ?> </td>
                                                <td class="center"> <?php echo $utilizadores[$i]['ativo']==1 ? '<a class="btn btn-sm green" onclick="visivel(0, this, '.$utilizadores[$i]['id_utilizador'].');">
                                                    <i class="fa fa-eye"></i> Ativo</a>' : '<a class="btn btn-sm yellow" onclick="visivel(1, this, '.$utilizadores[$i]['id_utilizador'].');">
                                                    <i class="fa fa-eye-slash"></i> Inativo</a>'; ?> </td>
                                               <td><a onclick="editar(<?php echo $utilizadores[$i]['id_utilizador']; ?>);" class="btn btn-sm green btn-outline"><i class="fa fa-edit"></i> Editar </a><button name="remove_utilizador" class="btn btn-sm red btn-outline remove_utilizador" data-toggle="confirmation" data-target="<?php echo  $utilizadores[$i]['id_utilizador']; ?>" data-placement="bottom" data-original-title="" title="" utilizador="<?php echo  $utilizadores[$i]['id_utilizador'] ?>"><i class="fa fa-remove"></i> Remover</button></td>
                                            </tr>
                                            <?php }
											}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <link href="<?php echo base_url(); ?>admin_assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
                    <div id="novo_utilizador" class="modal fade" role="dialog" aria-hidden="true">
                   		<div class="modal-dialog modal-lg">
                        	<div class="modal-content">
                            	<div class="modal-header">
                                	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Novo Utilizador</h4>
                                </div>
                                
                                <div class="modal-body">
                                	<form action="#" class="form-horizontal" id="form_novo_utilizador" method="post" enctype="multipart/form-data" >
                                    	
                        				<div class="alert alert-danger display-hide">
                                        	<button class="close" data-close="alert"></button> Tem alguns erros. Por favor verifique abaixo. </div>
                                     	<div class="alert alert-success display-hide">
                                        	<button class="close" data-close="alert"></button> O instalação inserida com sucesso! </div>
                                     	<div class="alert alert-info display-hide">
                                        	<button class="close" data-close="alert"></button> A validação do formulário foi um sucesso! Espere até a janela fechar. </div>
                                     
                                	<div class="portlet-body">
                                    	
                                       
                                  
                                        <div class="form-body">

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Tipo utilizador</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" name="tipo_utilizador">
                                                        <option value="">--Escolha--</option>
                                                        <?php 
                                                            for ($i=0; $i<count($tipo); $i++){ 
                                                                echo '<option value="'.$tipo[$i]['id_tipo_utilizador'].'">'.$tipo[$i]['tipo'].'</option>';   
                                                            }    
                                                        ?>
                                                       
                                                    <select>
                                                    
                                                   
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Email</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="email" placeholder="Email">
                                                   
                                                </div>
                                            </div>

                                           <div class="form-group">
                                       		<label class="control-label col-md-2">Password</label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <div class="input-icon">
                                                        <i class="fa fa-lock fa-fw"></i>
                                                        <input id="nova_password" class="form-control" type="password" name="password" placeholder="Password"> 
                                                    </div>
                                                    <span class="input-group-btn">
                                                    	<button id="genpassword" class="btn btn-success" type="button" onClick="javascript:generate(8, $('#nova_password'));">
                                                        <i class="fa fa-arrow-left fa-fw"></i> Random</button>
                                                    </span>
                                              	</div>
                                          	</div>
                                        </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Nome</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="nome" placeholder="Nome">
                                                   
                                                </div>
                                            </div>
                                            
                                          
                                           
                                          
                                           	
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Ativo</label>
                                                <div class="col-md-10">
                                                    <div class="radio-list">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="ativo" id="optionsRadios25" value="1" checked> Sim </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="ativo" id="optionsRadios26" value="0" checked> Não </label>
                                                       
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
                   
                   
                   <div id="editar_utilizador" class="modal fade" role="dialog" aria-hidden="true">
                   		<div class="modal-dialog modal-lg">
                        	<div class="modal-content">
                            	<div class="modal-header">
                                	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Editar Utilizador</h4>
                                </div>
                                
                                <div class="modal-body">
                                	<form action="#" class="form-horizontal" id="form_editar_utilizador" method="post" enctype="multipart/form-data" >
                                    	
                        				<div class="alert alert-danger display-hide">
                                        	<button class="close" data-close="alert"></button> Tem alguns erros. Por favor verifique abaixo. </div>
                                     	<div class="alert alert-success display-hide">
                                        	<button class="close" data-close="alert"></button> O instalação inserida com sucesso! </div>
                                     	<div class="alert alert-info display-hide">
                                        	<button class="close" data-close="alert"></button> A validação do formulário foi um sucesso! Espere até a janela fechar. </div>
                                     
                                	<div class="portlet-body">
                                    	
                                       
                                  
                                        <div class="form-body">

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Tipo utilizador</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" name="tipo_utilizador" id="tipo_utilizador_edita">
                                                        <option value="">--Escolha--</option>
                                                        <?php 
                                                            for ($i=0; $i<count($tipo); $i++){ 
                                                                echo '<option value="'.$tipo[$i]['id_tipo_utilizador'].'">'.$tipo[$i]['tipo'].'</option>';   
                                                            }    
                                                        ?>
                                                       
                                                    <select>
                                                    
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Email</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="email" id="email_edita" placeholder="Email">
                                                   
                                                </div>
                                            </div>

                                            
                                            <div class="form-group">
                                       		<label class="control-label col-md-2">Password</label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <div class="input-icon">
                                                        <i class="fa fa-lock fa-fw"></i>
                                                        <input id="password_edita" class="form-control" type="password" name="password" placeholder="Password"> 
                                                    </div>
                                                    <span class="input-group-btn">
                                                    	<button  class="btn btn-success" type="button" onClick="javascript:generate(8, $('#password_edita'));">
                                                        <i class="fa fa-arrow-left fa-fw"></i> Random</button>
                                                    </span>
                                              	</div>
                                          	</div>
                                        </div>
                                           
                                        <div class="form-group">
                                                <label class="col-md-2 control-label">Nome</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="nome" placeholder="Nome" id="nome_edita">
                                                   
                                                </div>
                                            </div>
                                           
                                           	
                                            
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Ativo</label>
                                                <div class="col-md-10">
                                                    <div class="radio-list">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="ativo" id="ativo" value="1" > Sim </label>
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
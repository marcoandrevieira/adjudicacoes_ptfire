<link href="<?php echo plugins_url(); ?>bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugins_url(); ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugins_url(); ?>bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo plugins_url(); ?>bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo plugins_url(); ?>bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />


<link href="<?php echo plugins_url(); ?>bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<?php //print_r($_SESSION); 
?>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="#">Stocks</a>
			<i class="fa fa-circle"></i>
		</li>

		<li>


			<a href="#">Projetos</a>
			<!--<i class="fa fa-circle"></i>-->
		</li>
		<!--<li>
                            	
                                <a href="#"><?php //echo $intervencao['instalacao']['instalacao']; 
											?></a>
                                 <i class="fa fa-circle"></i>
                            </li>
                            
                            <li>
                                <a href="#">Relatórios</a>
                               
                            </li>-->

	</ul>
</div>

<!-- BEGIN PAGE TITLE-->


<h3 class="page-title">Projetos
	<small>Adjudicados</small>
</h3>


<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-grey-gallery">
			<i class="fa fa-barcode font-grey-gallery"></i>
			<span class="caption-subject bold uppercase">Projetos </span>
		</div>

		<div class="actions">
			<div class="btn-group">
				<a class="btn red btn-circle" href="javascript:;" data-toggle="dropdown">
					<i class="fa fa-share"></i>
					<span class="hidden-xs"> Ferramentas </span>
					<i class="fa fa-angle-down"></i>
				</a>

				<ul class="dropdown-menu pull-right" id="equipamentos_instalacao_tools">
					<li>
						<a href="javascript:;" data-action="0" class="tool-action button-print"><i class="icon-printer"></i> Imprimir</a>
					</li>
					<li>
						<a href="javascript:;" data-action="1" class="tool-action button-copiar"><i class="fa fa-copy"></i> Copiar </a>
					</li>
					<li>
						<a href="javascript:;" data-action="2" class="tool-action button-pdf"><i class="fa fa-file-pdf-o"></i> PDF </a>
					</li>
					<li>
						<a href="javascript:;" data-action="3" class="tool-action button-excel"><i class="fa fa-file-excel-o"></i> EXCEL </a>
					</li>
				</ul>
			</div>
		</div>




	</div>



	<div class="portlet-body">

		<div class="table-toolbar">
			<div class="row">
				<div class="col-md-6">
					<div class="btn-group">
						<a href="#novo_projeto" id="sample_editable_1_new" data-toggle="modal" class="btn sbold green-jungle">Novo Projeto
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
			<div class="alert alert-danger display-hide alert_apaga_projeto"><button class="close" data-close="alert"></button> <span>O projeto <span id="projeto_apagar"></span> irá ser apagado! Deseja continuar?</span> </div>
			<div class="alert alert-success display-hide alert_projeto_removido"><button class="close" data-close="alert"></button> <span>O projeto <span id="projeto_apagado"></span> foi eliminado com sucesso!</span> </div>
			<div class="large-table-container-2">

				<table class="table table-striped table-bordered table-hover" id="datatable_projetos">
					<thead>
						<tr class="heading">
							<th></th>
							<th>Estado</th>
							<th>Tipo</th>
							<th width="20%">Cliente</th>
							<th width="20%">Instalação</th>
							<th width="20%">Projeto</th>
							<th>Valor</th>
							<th>Data Inicio</th>
							<th>Data Conclusão</th>
							<th>Data Concluido</th>
							<th>Valor Fatura</th>
							<th>Criado Por</th>
							<th>Ativo</th>
							<th>Actions</th>
						</tr>

						<trclass="filter">
							<td>
								<select class="form-control form-filter" name="concluido" id="concluido_estado">
									<option value="">Todos</option>
									<option value="aberto" selected="selected">Aberto</option>
									<option value="concluido">Concluido</option>
								</select>
							</td>
							<td>
								<select class="form-filter js-example-basic-multiple" title="Nada Selecionado" multiple="multiple" name="estado">
									<!-- <option value="">--Selecione Estado</option> -->
									<?php
									if (!empty($estados)) {

										for ($i = 0; $i < count($estados); $i++) {
											echo '<option value="' . $estados[$i]['id_estado'] . '">' . $estados[$i]['estado'] . '</option>';
										}
									} else {
										echo '<option value="">VAZIO</option>';
									}
									?>
								</select>
							</td>
							<td>
								<select class="form-filter js-example-basic-multiple" title="Nada Selecionado" multiple="multiple" e name="tipo">
									<!--   <option value=""></option> -->
									<?php
									if (!empty($servicos)) {
										for ($i = 0; $i < count($servicos); $i++) {
											echo '<option value="' . $servicos[$i]['id_tipo_servico'] . '">' . $servicos[$i]['tipo'] . '</option>';
										}
									} else {
										echo '<option value="">VAZIO</option>';
									}
									?>
								</select>
							</td>

							<td>
								<input class="form-control form-filter" name="cliente" />
							</td>
							<td>
								<input class="form-control form-filter" name="instalacao" />
							</td>

							<td>
								<input class="form-control form-filter" name="projeto" />
							</td>
							<td>
								<input type="text" class="form-control form-filter total" name="total" />
							</td>
							<td>
								<input class="form-control form-filter form-control-inline  date-picker" type="text" value="" name="data_inicio" />
							</td>
							<td>
								<input class="form-control form-filter form-control-inline  date-picker" type="text" value="" name="data_conclusao" />
							</td>
							<td>
								<input class="form-control form-filter form-control-inline  date-picker" type="text" value="" name="data_concluido" />
							</td>
							<td>
								<input class="form-control form-filter" name="valor_fatura" />
							</td>
							<td>
								<select name="criado_por[]" class="bs-select form-control form-filter marcas" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" data-container="body" id="marcas_select">


									<?php
									for ($i = 0; $i < count($users); $i++) {

										echo '<option value=' . $users[$i]['id_utilizador'] . '>' . $users[$i]['nome'] . '</option>';
									}
									?>
								</select>
							</td>
							<td>
								<select class="form-control form-filter" name="ativo">
									<option value="">--Estado--</option>
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
	</div>

	<div id="novo_projeto" class="modal fade" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Novo Projeto</h4>
				</div>

				<div class="modal-body">
					<form action="#" class="form-horizontal" id="form_novo_projeto" method="post" enctype="multipart/form-data">
						<div class="alert alert-danger display-hide">
							<button class="close" data-close="alert"></button> Tem alguns erros. Por favor verifique abaixo.
						</div>
						<div class="alert alert-success display-hide">
							<button class="close" data-close="alert"></button> O instalação inserida com sucesso!
						</div>
						<div class="alert alert-info display-hide">
							<button class="close" data-close="alert"></button> A validação do formulário foi um sucesso! Espere até a janela fechar.
						</div>

						<div class="portlet-body">
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-2 control-label">Estado</label>
									<div class="col-md-10">
										<select class="form-control form-filter input-sm" name="estado">
											<option value=""></option>
											<?php
											if (!empty($estados)) {

												for ($i = 0; $i < count($estados); $i++) {
													echo '<option value="' . $estados[$i]['id_estado'] . '">' . $estados[$i]['estado'] . '</option>';
												}
											} else {
												echo '<option value="">VAZIO</option>';
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Tipo</label>
									<div class="col-md-10">
										<select class="form-control form-filter input-sm" name="tipo">
											<option value=""></option>
											<?php
											if (!empty($servicos)) {
												for ($i = 0; $i < count($servicos); $i++) {
													echo '<option value="' . $servicos[$i]['id_tipo_servico'] . '">' . $servicos[$i]['tipo'] . '</option>';
												}
											} else {
												echo '<option value="">VAZIO</option>';
											}
											?>
										</select>

									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-2">Cliente</label>
									<div class="col-md-10 search_clientes">

										<select id="dropdown_cliente" class="form-control selectpicker" name="cliente" data-live-search="true" title="Nada Selecionado">

										</select>

									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-2">Instalação</label>
									<div class="col-md-10">
										<select class="form-control selectpicker1" name="instalacao" id="loops_instalacao" data-live-search="true" title="Nada Selecionado">
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Projeto</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="projeto" placeholder="Projeto">

									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Total</label>
									<div class="col-md-10">
										<input type="text" class="form-control form-filter total" name="total" placeholder="Total" />

									</div>
								</div>
								<!--<div class="form-group">
                                                <label class="col-md-2 control-label">Data Conclusão</label>
                                                <div class="col-md-10">
                                                    <input class="form-control form-filter form-control-inline  date-picker"  type="text" value="" name="data_conclusao" />
                                                   
                                                </div>
                                            </div>-->



								<div class="form-group">
									<label class="col-md-2 control-label">Observações</label>
									<div class="col-md-10">
										<textarea class="form-control" row="8" name="obs"></textarea>

									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Ativo</label>
									<div class="col-md-10">
										<div class="radio-list">
											<label class="radio-inline">
												<input type="radio" name="ativo" id="optionsRadios25" value="1" checked> Sim </label>
											<label class="radio-inline">
												<input type="radio" name="ativo" id="optionsRadios26" value="0"> Não </label>

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





	<div id="editar_projeto" class="modal fade" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Editar Projeto</h4>
				</div>

				<div class="modal-body">
					<form action="#" class="form-horizontal" id="form_editar_projeto" method="post" enctype="multipart/form-data">
						<div class="alert alert-danger display-hide">
							<button class="close" data-close="alert"></button> Tem alguns erros. Por favor verifique abaixo.
						</div>
						<div class="alert alert-success display-hide">
							<button class="close" data-close="alert"></button> O instalação inserida com sucesso!
						</div>
						<div class="alert alert-info display-hide">
							<button class="close" data-close="alert"></button> A validação do formulário foi um sucesso! Espere até a janela fechar.
						</div>

						<div class="portlet-body">
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-2 control-label">Estado</label>
									<div class="col-md-10">
										<select class="form-control form-filter input-sm" name="estado" id="edita_estado">
											<option value=""></option>
											<?php
											if (!empty($estados)) {

												for ($i = 0; $i < count($estados); $i++) {
													echo '<option value="' . $estados[$i]['id_estado'] . '">' . $estados[$i]['estado'] . '</option>';
												}
											} else {
												echo '<option value="">VAZIO</option>';
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Tipo</label>
									<div class="col-md-10">
										<select class="form-control form-filter input-sm" name="tipo" id="edita_tipo">
											<option value=""></option>
											<?php
											if (!empty($servicos)) {
												for ($i = 0; $i < count($servicos); $i++) {
													echo '<option value="' . $servicos[$i]['id_tipo_servico'] . '">' . $servicos[$i]['tipo'] . '</option>';
												}
											} else {
												echo '<option value="">VAZIO</option>';
											}
											?>
										</select>

									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-2">Cliente </label>
									<div class="col-md-10 search_clientes_edit">
										<!-- <input type="text" class="form-control" name="cliente" placeholder="Cliente" id="edita_cliente" readonly> -->
										<select id="edita_cliente" class="form-control selectpicker" name="id_cliente" data-live-search="true" title="Nada Selecionado">

										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Instalação</label>
									<div class="col-md-10">
										<!-- <input type="text" class="form-control" name="instalacao" placeholder="Instalação" id="edita_instalacao" readonly> -->
										<select class="form-control" name="id_instalacao" id="loops_instalacao_edit" data-live-search="true" title="Nada Selecionado">
											<!-- fazer o if -->
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label">Projeto</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="projeto" placeholder="Projeto" id="edita_projeto">

									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Total</label>
									<div class="col-md-10">
										<input type="text" class="form-control form-filter total" name="total" id="edita_total" />

									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Observações</label>
									<div class="col-md-10">
										<textarea class="form-control" row="8" name="obs" id="edita_obs"></textarea>

									</div>
								</div>

								<div id="estado_planeado"></div>
								<div id="estado_faturacao"></div>

								<div class="form-group">
									<label class="col-md-2 control-label">Ativo</label>
									<div class="col-md-10">
										<div class="radio-list">
											<label class="radio-inline">
												<input type="radio" name="ativo" id="ativo" value="1" checked> Sim </label>
											<label class="radio-inline">
												<input type="radio" name="ativo" id="inativo" value="0"> Não </label>

										</div>
									</div>
								</div>

							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn default">Cancel</button>
					<button type="submit" class="btn green">Atualiza</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<div id="concluir_projeto" class="modal fade" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Editar Projeto</h4>
				</div>

				<div class="modal-body">
					<form action="#" class="form-horizontal" id="form_concluir_projeto" method="post" enctype="multipart/form-data">
						<div class="alert alert-danger display-hide">
							<button class="close" data-close="alert"></button> Tem alguns erros. Por favor verifique abaixo.
						</div>
						<div class="alert alert-success display-hide">
							<button class="close" data-close="alert"></button> O instalação inserida com sucesso!
						</div>
						<div class="alert alert-info display-hide">
							<button class="close" data-close="alert"></button> A validação do formulário foi um sucesso! Espere até a janela fechar.
						</div>

						<div class="portlet-body">
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-2 control-label">Estado</label>
									<div class="col-md-10">
										<select class="form-control form-filter input-sm" name="estado" id="concluir_estado">
											<option value=""></option>
											<?php
											if (!empty($estados)) {

												for ($i = 0; $i < count($estados); $i++) {
													echo '<option value="' . $estados[$i]['id_estado'] . '">' . $estados[$i]['estado'] . '</option>';
												}
											} else {
												echo '<option value="">VAZIO</option>';
											}
											?>
										</select>
									</div>
								</div>


								<div class="form-group">
									<label class="control-label col-md-2">Concluir</label>
									<div class="col-md-10">
										<input type="checkbox" class="make-switch" data-on-text="&nbsp;Concluido&nbsp;" data-off-text="&nbsp;Concluir&nbsp;" name="concluido" id="concluir_check">
									</div>
								</div>







							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn default">Cancel</button>
					<button type="submit" class="btn green">Concluir</button>
				</div>
				</form>
			</div>
		</div>
	</div>


	<!-- ======================================================================= -->
	<div id="historico_proj" class="modal fade" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" id="teste_modal">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Histórico Projeto</h4>
				</div>
				<div class="modal-body">

					<table class="table table-striped table-bordered table-hover" id="datatable_projetos">
						<thead>
							<tr role="row" class="heading">
								<th>Data Inserção</th>
								<th>Estado</th>
								<th>Tipo</th>
								<th>Cliente</th>
								<th>Instalação</th>
								<th>Projeto</th>
								<th>Obs</th>
								<th>Valor</th>
								<th>Valor Fatura</th>
								<th>Criado Por</th>
								<th>Ativo</th>
							</tr>
						</thead>
						<tbody id="h_projeto">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<style>
		#teste_modal {
			width: 100%
		}

		.large-table-container-2 {

			transform: rotateX(180deg);
		}

		.large-table-container-2 table {
			transform: rotateX(180deg);
		}


		td {
			border: 1px solid gray;
		}

		th {
			text-align: left;
		}

		#datatable_projetos_paginate {
			transform: rotateX(180deg);
		}

		#datatable_projetos_length {
			transform: rotateX(180deg);
		}

		#datatable_projetos_info {
			transform: rotateX(180deg);
		}

		.paging_bootstrap_extended {
			transform: rotateX(180deg);
		}

		.dataTables_length {
			transform: rotateX(180deg);
		}

		.dataTables_info {
			transform: rotateX(180deg);
		}
	</style>
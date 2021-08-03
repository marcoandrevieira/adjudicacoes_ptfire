<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projetos extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->is_logged_in();
		
		$this->load->model('projetos_model');
	}
	function is_logged_in(){
		
		$in = $this->session->userdata('is_logged_in');
		$email = $this->session->userdata('email');
		//$this->session->sess_destroy();
		//print_r($this->session->userdata());
		if(!isset($in, $email) || $in !=true || $email !=true){
			
			redirect(base_url().'admin/login');
			
			}
		
		}

		/* function is_monitor(){
			if($this->session->userdata('id_tipo')==2){
				redirect(base_url().'monitores');
			}
			
		} */

	function get_projetos_table(){
		
		$projetos=$this->projetos_model->get_projetos_table();
		
		$records["draw"] = $projetos['sEcho'];
		$records["recordsTotal"] = $projetos['iTotalRecords'];
		$records["recordsFiltered"] = $projetos['iTotalDisplayRecords'];
					
					if(!empty($projetos['aaData'])){
					
						foreach ($projetos['aaData'] as $prj){

							if($prj['ativo']==1){
					
								$estado='<a class="btn btn-sm green" onclick="visivel_projeto(0, this, '.$prj['id_projeto'].');"><i class="fa fa-eye"></i> Ativo</a>';
								
																  
							}else{
								$estado='<a class="btn btn-sm yellow" onclick="visivel_projeto(1, this, '.$prj['id_projeto'].');"><i class="fa fa-eye-slash"></i> Inativo</a>';
																		
							}
						
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
							//foi alterado para ocultar ou mostrar o concluído
							
								$concluido = "";
								$btn_concluido = "";
							
							if ($prj['concluido'] == 1) {
										$concluido = '<a href="#"><span class="badge bg-green-jungle bg-font-green-jungle" onclick="historico(' . $prj['id_projeto'] . ')"><i class="fa fa-check"></i></span></a>';
									} else {
										$concluido = '<a href="#"><span class="badge bg-red-thunderbird  bg-font-red-thunderbird" onclick="historico(' . $prj['id_projeto'] . ')"><i class="fa fa-remove"></i></span></a>';
									}
							
								if ($prj['estado'] == "Planeado" || $prj['estado'] == "Em Execução") {
									$btn_concluido = '<a href="#" class="btn btn-sm btn-outline green-jungle" onclick="concluir(' . $prj['id_projeto'] . ');"><i class="fa fa-check"></i> Concluir</a>';
								}
							
								//fim de foi alterado para ocultar ou mostrar o concluído
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

							$valor='0,00 €';
							if(!empty($prj['total'])){
								$valor=$prj['total'].' €';	
							}
						
					 $records["data"][] = array(
						$concluido,
						'<span class="badge" style="background-color:'.$prj['cor_estado'].'; font-size:14px !important; height:22px; font-height:bold;">'.$prj['estado'].'</span>', 
						'<span class="badge" style="background-color:'.$prj['cor_tipo'].'; font-size:14px !important; height:22px; font-height:bold;">'.$prj['tipo'].'</span>', 
						$prj['cliente'], 
						$prj['instalacao'], 
						$prj['projeto'],
						$valor,
						$prj['data_inicio'],
						$prj['data_conclusao'],
						$prj['data_concluido'],
						$prj['valor_fatura'],
						$prj['criado_por'],
						$estado,
						'<a href="#" class="btn btn-sm btn-outline purple" onclick="editar('.$prj['id_projeto'].');"><i class="fa fa-edit"></i> Editar</a>
						<button class="btn btn-sm btn-outline red-mint remove_projeto" projeto="'.$prj['id_projeto'].'" data-toggle="confirmation" data-placement="left" data-btn-ok-class="btn btn-sm btn-success" data-btn-cancel-class="btn btn-sm btn-danger" data-original-title="" title="Tem a Certeza?" data-btn-ok-label="Sim" data-btn-cancel-label="Não"><i class="fa fa-remove"></i> Remover</button>
						<a href="#" class="btn btn-sm btn-outline yellow-gold" onclick="fornecimento('.$prj['id_projeto'].', '.$prj['id_instalacao'].');"><i class="fa fa-share-square"></i> Fornecimento </a>
						'.$btn_concluido,
						);		
								
					}
					
				}else{
						 $records["data"] = array();
						
					}
				
				
					
				  echo json_encode($records);
			
		
		
	}
	function get_monitores(){
		
		$projetos=$this->projetos_model->get_monitores_table();
		
		$records["draw"] = $projetos['sEcho'];;
		$records["recordsTotal"] = $projetos['iTotalRecords'];
		$records["recordsFiltered"] = $projetos['iTotalDisplayRecords'];
					
					if(!empty($projetos['aaData'])){
					
						foreach ($projetos['aaData'] as $prj){
							
							$valor='0,00 €';
							if(!empty($prj['total'])){
								$valor=$prj['total'].' €';	
							}
							
						
						$tamanho_letra=16;
						$tamanho_label=$tamanho_letra+4;

						$tamanho_letra.='px';
						$tamanho_label.='px';
					 $records["data"][] = array(
						/*$concluido,
						'<span class="badge" style="background-color:'.$prj['cor_estado'].'; font-size:14px !important; height:22px; font-height:bold;">'.$prj['estado'].'</span>', 
						'<span class="badge" style="background-color:'.$prj['cor_tipo'].'; font-size:14px !important; height:22px; font-height:bold;">'.$prj['tipo'].'</span>', 
						$prj['cliente'], 
						$prj['projeto'],
						$prj['data_inicio'],
						$prj['data_concluido'],
						$prj['criado_por'],
						$estado,
						'<a href="#" class="btn btn-sm btn-outline purple" onclick="editar('.$prj['id_projeto'].');"><i class="fa fa-edit"></i> Editar</a>
						<button class="btn btn-sm btn-outline red-mint remove_projeto" projeto="'.$prj['id_projeto'].'" data-toggle="confirmation" data-placement="left" data-btn-ok-class="btn btn-sm btn-success" data-btn-cancel-class="btn btn-sm btn-danger" data-original-title="" title="Tem a Certeza?" data-btn-ok-label="Sim" data-btn-cancel-label="Não"><i class="fa fa-remove"></i> Remover</button>
						'.$btn_concluido,*/
						//$prj['estado'],
						'<span class="badge" style="background-color:'.$prj['cor_estado'].'; font-size:20px !important; height:'.$tamanho_label.'; font-height:bold;">'.$prj['estado'].'</span>', 
						//$prj['tipo'],
						'<span class="badge" style="background-color:'.$prj['cor_tipo'].'; font-size:20px !important; height:'.$tamanho_label.'; font-height:bold;">'.$prj['tipo'].'</span>', 
						'<span style="font-size:'.$tamanho_letra.'">'.$prj['cliente'].'</span>',
						'<span style="font-size:'.$tamanho_letra.'">'.$prj['instalacao'].'</span>',
						'<span style="font-size:'.$tamanho_letra.'">'.$prj['projeto'].'</span>',
						'<span style="font-size:'.$tamanho_letra.'">'.$valor.'</span>',
						'<span style="font-size:'.$tamanho_letra.'">'.$prj['data_inicio'].'</span>',
						'<span style="font-size:'.$tamanho_letra.'">'.$prj['data_conclusao'].'</span>',
						//'<span style="font-size:'.$tamanho_letra.'">'.$prj['data_concluido'].'</span>',
						//'<span style="font-size:'.$tamanho_letra.'">'.$prj['criado_por'].'</span>',

						//$prj['cor_estado'],
						);		
								
					}
					
				}else{
						 $records["data"] = array();
						
					}
				
				
					
				  echo json_encode($records);
			
		
		
	}
	function muda_estado(){
		
		$muda = $this->projetos_model->muda_estado($this->input->get('id_projeto'), $this->input->get('estado'));
		echo json_encode($muda);
	}
	

		function novo_projeto(){
			
			$inseriu=$this->projetos_model->novo_projeto($this->input->post(NULL, TRUE));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}
		function edita_projeto(){
			
			$inseriu=$this->projetos_model->edita_projeto($this->input->get('id'),$this->input->post(NULL, TRUE));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}
		function concluir_projeto(){
			
			$inseriu=$this->projetos_model->concluir_projeto($this->input->get('id'),$this->input->post(NULL, TRUE));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}
		function remove_projeto(){
			
			$inseriu=$this->projetos_model->remove_projeto($this->input->get('id'));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}

		function projeto_id(){
		
			$equipa=$this->projetos_model->projeto_id($this->input->get('id'));
			
			echo json_encode($equipa);
		}
	
	public function get_historico()
	{

		$historico = $this->projetos_model->get_historico();
		echo json_encode($historico);
	}
}

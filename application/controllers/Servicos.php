<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class servicos extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->is_logged_in();
		
		$this->load->model('servicos_model');
	}

	function is_logged_in(){
		
		$in = $this->session->userdata('is_logged_in');
		$email = $this->session->userdata('email');
		
		if(!isset($in, $email) || $in !=true || $email !=true){
			redirect(base_url().'admin/login');
			
		}
	}

	/* function is_monitor(){
		if($this->session->userdata('id_tipo')==2){
			redirect(base_url().'monitores');
		}
			
	} */

	function get_servicos_table(){
		
		$servicos=$this->servicos_model->get_servicos_table();
		
		$records["draw"] = $servicos['sEcho'];;
		$records["recordsTotal"] = $servicos['iTotalRecords'];
		$records["recordsFiltered"] = $servicos['iTotalDisplayRecords'];
					
					if(!empty($servicos['aaData'])){
					
						foreach ($servicos['aaData'] as $srv){

							if($srv['ativo']==1){
					
								$estado='<a class="btn btn-sm green" onclick="visivel_servico(0, this, '.$srv['id_tipo_servico'].');"><i class="fa fa-eye"></i> Ativo</a>';
								
																  
							}else{
								$estado='<a class="btn btn-sm yellow" onclick="visivel_servico(1, this, '.$srv['id_tipo_servico'].');"><i class="fa fa-eye-slash"></i> Inativo</a>';
																		
							}
							//$btn_concluido='';
							/*
							if($prj['concluido']==1){
								$concluido='<span class="badge bg-green-jungle bg-font-green-jungle "><i class="fa fa-check"></i></span>';
								
							}else{
								$concluido='<span class="badge bg-red-thunderbird  bg-font-red-thunderbird  "><i class="fa fa-remove"></i></span>';
								
							}

							$btn_concluido='<a href="#" class="btn btn-sm btn-outline green-jungle" onclick="concluir('.$prj['id_projeto'].');"><i class="fa fa-check"></i> Concluir</a>';
							*//*$botoes='<a href="'.base_url().'tecnica/movimentos/'.$mov['id_movimentar'].'" class="btn btn-sm btn-outline grey-cascade"><i class="fa fa-barcode"></i> Artigos</a>';
							if($mov['confirmado']==$mov['total']){
								$fechado='<span class="badge bg-green-jungle"> <i class="fa fa-check"></i> </span> ';
							}else{
								$fechado='<span class="badge bg-red-thunderbird"> <i class="fa fa-warning"></i> </span> ';
							}*/
						
						
					 $records["data"][] = array(
						$srv['tipo'],
						'<span class="label" style="background-color:'.$srv['cor'].'">'.$srv['cor'].'</span>',
						$srv['ordem'],
						$estado,
						'<a href="#" class="btn btn-sm btn-outline purple" onclick="editar('.$srv['id_tipo_servico'].');"><i class="fa fa-edit"></i> Editar</a>
						<button class="btn btn-sm btn-outline red-mint remove_servico" servico="'.$srv['id_tipo_servico'].'" data-toggle="confirmation" data-placement="left" data-btn-ok-class="btn btn-sm btn-success" data-btn-cancel-class="btn btn-sm btn-danger" data-original-title="" title="Tem a Certeza?" data-btn-ok-label="Sim" data-btn-cancel-label="Não"><i class="fa fa-remove"></i> Remover</button>
						',
						);		
								
					}
					
				}else{
						 $records["data"] = array();
						
					}
				
				
					
				  echo json_encode($records);
			
		
		
	}
	
	function muda_estado(){
		
		$muda = $this->servicos_model->muda_estado($this->input->get('id_servico'), $this->input->get('estado'));
		echo json_encode($muda);
	}
	

		function novo_servico(){
			
			$inseriu=$this->servicos_model->novo_servico($this->input->post(NULL, TRUE));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}
		function edita_servico(){
			
			$inseriu=$this->servicos_model->edita_servico($this->input->get('id'),$this->input->post(NULL, TRUE));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}
		
		function remove_servico(){
			
			$inseriu=$this->servicos_model->remove_servico($this->input->get('id'));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}

		function servico_id(){
		
			$equipa=$this->servicos_model->servico_id($this->input->get('id'));
			
			echo json_encode($equipa);
		}
}

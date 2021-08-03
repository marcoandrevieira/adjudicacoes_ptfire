<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class estados extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->is_logged_in();
		
		$this->load->model('estados_model');
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

	function get_estados_table(){
		
		$estados=$this->estados_model->get_estados_table();
		
		$records["draw"] = $estados['sEcho'];;
		$records["recordsTotal"] = $estados['iTotalRecords'];
		$records["recordsFiltered"] = $estados['iTotalDisplayRecords'];
					
					if(!empty($estados['aaData'])){
					
						foreach ($estados['aaData'] as $est){

							if($est['ativo']==1){
					
								$estado='<a class="btn btn-sm green" onclick="visivel_estado(0, this, '.$est['id_estado'].');"><i class="fa fa-eye"></i> Ativo</a>';
								
																  
							}else{
								$estado='<a class="btn btn-sm yellow" onclick="visivel_estado(1, this, '.$est['id_estado'].');"><i class="fa fa-eye-slash"></i> Inativo</a>';
																		
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
						$est['estado'],
						'<span class="label" style="background-color:'.$est['cor'].'">'.$est['cor'].'</span>',
						$est['ordem'],
						$estado,
						'<a href="#" class="btn btn-sm btn-outline purple" onclick="editar('.$est['id_estado'].');"><i class="fa fa-edit"></i> Editar</a>
						<button class="btn btn-sm btn-outline red-mint remove_estado" estado="'.$est['id_estado'].'" data-toggle="confirmation" data-placement="left" data-btn-ok-class="btn btn-sm btn-success" data-btn-cancel-class="btn btn-sm btn-danger" data-original-title="" title="Tem a Certeza?" data-btn-ok-label="Sim" data-btn-cancel-label="Não"><i class="fa fa-remove"></i> Remover</button>
						',
						);		
								
					}
					
				}else{
						 $records["data"] = array();
						
					}
				
				
					
				  echo json_encode($records);
			
		
		
	}
	
	function muda_estado(){
		
		$muda = $this->estados_model->muda_estado($this->input->get('id_estado'), $this->input->get('estado'));
		echo json_encode($muda);
	}
	

		function novo_estado(){
			
			$inseriu=$this->estados_model->novo_estado($this->input->post(NULL, TRUE));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}
		function edita_estado(){
			
			$inseriu=$this->estados_model->edita_estado($this->input->get('id'),$this->input->post(NULL, TRUE));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}
		
		function remove_estado(){
			
			$inseriu=$this->estados_model->remove_estado($this->input->get('id'));
			if ($inseriu){
				echo json_encode($inseriu);
			}else{
				echo json_encode($inseriu);
			}
		}

		function estado_id(){
		
			$equipa=$this->estados_model->estado_id($this->input->get('id'));
			
			echo json_encode($equipa);
		}
}

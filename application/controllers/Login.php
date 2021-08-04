<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	//var $pasta='cliente/';
function index(){
	
		//echo "entrou";
		//print_r($this->session->userdata());
		$in = $this->session->userdata('is_logged_in');
		$admin = $this->session->userdata('id_tipo');
		
		if(isset($in, $admin) && $in==true && $admin==1){
			
			//redirect(base_url().'admin/dashboard/');
			
		}else{
		
			$this->load->view('login');
			
		}
		
		//$this->load->view($this->pasta.'login');
		
		}
		
function validate_credentials(){
		$this->load->model('login_model');
		$data=$this->login_model->validate();
		
		if(isset($data['email'], $data['nome']) && $data['is_logged_in'] == true ){
			echo json_encode($data);
		}else{
			echo json_encode($data);
		}		
	}

	function recuperar_password(){
		
		$this->load->model('login_model');
		$feed=$this->login_model->recuperar_password();
		echo json_encode($feed);
	
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url().'login');
	}
}

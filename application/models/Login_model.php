<?php
class Login_model extends CI_Model {
	
	function validate()
	{


		$query = $this->db->select('*')
			->from('utilizadores')
			->where('email', $this->input->post('email'))
			->where('password', md5($this->input->post('password')))
			->where('ativo', "1")
			->where('apagado', "0")
			->get();

		//echo $this->db->last_query();

		if ($query->num_rows() == 0) {

			return false;
		} else {

			//$this->load->model('clientes_model');

			$utilizador = $query->row();

			//$instalacoes=$this->clientes_model->cliente_utilizador_instalacoes($cliente['id_cliente_utilizador']);

			//print_r($intalacoes);

			$data = array(
				'is_logged_in' => true,
				'id_utilizador' => $utilizador->id_utilizador,
				'id_tipo' => $utilizador->id_tipo,
				'email' => $utilizador->email,
				'nome' => $utilizador->nome,
				'master' => $utilizador->master,


			);

			$this->session->set_userdata('is_logged_in', true);
			$this->session->set_userdata('id_utilizador', $utilizador->id_utilizador);
			$this->session->set_userdata('email', $utilizador->email);
			$this->session->set_userdata('nome', $utilizador->nome);
			$this->session->set_userdata('id_tipo', $utilizador->id_tipo);
			$this->session->set_userdata('master', $utilizador->master);

			return $data;
		}
	}
	
	/* function is_monitor(){
		if($this->session->userdata('id_tipo')==2){
			redirect(base_url().'monitores/monitores');
		}
		
	} */
	function recuperar_password(){
		//echo "oi".$this->input->post('email');
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('ativo', 1);
		$this->db->where('apagado', 0);
		$query = $this->db->get('utilizadores');
		
		if($query->num_rows()==1){
			$utilizador = $query->row_array();
			$this->load->helper('generate_helper');
			$nova_password=gerar_string(8, false);
			$data = array(
				'password'=>md5($nova_password),
			);
		
			$this->db->where('id_utilizador', $utilizador['id_utilizador']);
    		$atualizado=$this->db->update('utilizadores' ,$data);
			
			if($atualizado==true){
				$this->load->model('email_model');
				$this->email_model->configura($utilizador['email'], 'Recuperação da Password - Cliente '.$utilizador['nome']);
				$this->email_model->estrutura('recuperar_password_cliente',array('nome'=>$utilizador['nome'], 'email'=>$utilizador['email'], 'password'=>$nova_password));
				$this->email_model->envia();
				return true;
			}else{
				return false;	
			}
				
		}else{
		
			return false;
			
		}
	
		
	}
	
	
}

?>
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utilizadores extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->is_logged_in();
		//$this->is_monitor();
		$this->load->model('utilizadores_model');
	}
	function is_logged_in()
	{

		$in = $this->session->userdata('is_logged_in');
		$email = $this->session->userdata('email');
		//$this->session->sess_destroy();
		//print_r($this->session->userdata());
		if (!isset($in, $email) || $in != true || $email != true) {

			redirect(base_url() . 'admin/login');
		}
	}
	/* function is_monitor(){
			if($this->session->userdata('id_tipo')==2){
				redirect(base_url().'monitores');
			}
			
		} */
	function muda_estado()
	{

		$muda = $this->utilizadores_model->muda_estado($this->input->get('id_utilizador'), $this->input->get('estado'));
		echo json_encode($muda);
	}
	function remove_utilizador()
	{

		$muda = $this->utilizadores_model->remove_utilizador($this->input->get('id_utilizador'));
		echo json_encode($muda);
	}

	function verify_email()
	{

		$email = $this->utilizadores_model->verify_email($this->input->get('email'));

		if ($email !== true) {

			echo json_encode("Este Email já se encontra registado.");
		} else {

			echo json_encode(true);
		}
	}

	function verify_email_update()
	{

		$email = $this->utilizadores_model->verify_email($this->input->get('email'), $this->input->get('utilizador'));

		if ($email !== true) {

			echo json_encode("Este Email já se encontra registado.");
		} else {

			echo json_encode(true);
		}
	}

	function novo_utilizador()
	{

		$inseriu = $this->utilizadores_model->novo_utilizador($this->input->post(NULL, TRUE));
		if ($inseriu) {
			echo json_encode($inseriu);
		} else {
			echo json_encode($inseriu);
		}
	}

	function edita_utilizador()
	{

		$inseriu = $this->utilizadores_model->edita_utilizador($this->input->post(NULL, TRUE), $this->input->get('id_utilizador'));
		if ($inseriu) {
			echo json_encode($inseriu);
		} else {
			echo json_encode($inseriu);
		}
	}

	function utilizador_id()
	{

		$equipa = $this->utilizadores_model->utilizador_id($this->input->get('id'));

		echo json_encode($equipa);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitores extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('projetos_model');
		$tipo=$this->projetos_model->get_servicos_ativos();
		$estado=$this->projetos_model->get_estados_ativos();
		$data=array('tipo'=>$tipo, 'estado'=>$estado);
		$this->load->view('monitores',$data);
	}
}

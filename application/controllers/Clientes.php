<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Clientes extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_logged_in') !== TRUE) {
			redirect('login');
		}
		$this->load->model('clientes_model');
	}

	public function index()
	{
		$this->scripts = array(
			'page_level_plugins' => array(

				'<script src="' . scripts_url() . 'datatable.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/datatables.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-summernote/summernote.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>',
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>'
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'clientes.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/localization/messages_pt_PT.min.js" type="text/javascript"></script>',


			),
		);


		$data = array('content' => 'clientes', 'scripts' => $this->scripts);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_clientes()
	{

		$clientes = $this->clientes_model->make_tabela_clientes();
		$data = array();
		foreach ($clientes as $row) {
			$sub_array = array();
			$sub_array[] = $row->cliente;
			$sub_array[] = $row->nif;
			$sub_array[] = $row->morada;
			$sub_array[] = $row->telefone;
			$sub_array[] = '<a href="' . base_url('instalacoes/instalacoes_cliente/') . $row->id_cliente . '"><button class="btn green-jungle btn-outline"><i class="fa fa-arrow-right"></i> Entrar </button></a>
			<button onclick="editar_cliente(' . $row->id_cliente . ')" class="btn yellow-gold btn-outline"><i class="fa fa-edit"></i> Editar </button>
			<button onclick="apagar_cliente(' . $row->id_cliente . ')" class="btn red-thunderbird btn-outline"><i class="fa fa-times"></i> Apagar </button>
     						';
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->clientes_model->get_all_clientes(),
			'recordsFiltered' => $this->clientes_model->get_filtered_clientes(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function get_cliente($idCliente=null){

		$cliente = $this->clientes_model->get_cliente($idCliente);
		echo json_encode($cliente);

	}

	public function adicionarCliente(){
		$cliente = $this->clientes_model->adicionarCliente($_POST);
		echo json_encode($cliente);
	}

	public function editarCliente(){
		$cliente = $this->clientes_model->editarCliente($_POST);
		echo json_encode($cliente);
	}

	public function apagar_cliente(){
		$cliente = $this->clientes_model->apagarCliente($_POST);
		echo json_encode($cliente);
	}

	/* --------------------------------------------------------------------------------------------------------------------------------------------- */
	public function tabela_precos($id_cliente){

		$this->scripts = array(
			'page_level_plugins' => array(

				
				'<script src="' . scripts_url() . 'datatable.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/datatables.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-touchspin/bootstrap.touchspin.min.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-summernote/summernote.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>',
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>',
				

			),

			'page_level_scripts' => array(
			
				'<script src="' . scripts_url() . 'tabela_precos.js" type="text/javascript"></script>',
			),
		);

		$cliente = $this->clientes_model->get_cliente($id_cliente);
		$data = array(
			'content' => 'tabela_precos', 
			'cliente' => $cliente,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);

	}

	public function get_tabela_precos(){

		$clientes = $this->clientes_model->make_tabela_precos();
		$data = array();
		foreach ($clientes as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = $row->ano_fabrico;
			$sub_array[] = "<img src='".base_url()."recourses/images/products/".$row->fotografia1."' width='100%' alt='".$row->artigo."'>";
			$sub_array[] = $row->detalhes;
			$sub_array[] = '<input id_artigo="'.$row->id_artigo.'" id_cliente="'.$this->input->post('id_cliente').'" type="text" id="id_artigo' . $row->id_artigo . '" class="form-control preco_artigo" value="'.$this->clientes_model->get_precos_artigos($row->id_artigo, $this->input->post('id_cliente')).'">'; 
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->clientes_model->get_all_precos(),
			'recordsFiltered' => $this->clientes_model->get_filtered_precos(),
			'data' => $data
		);

		echo json_encode($output);

	}

	public function edit_tabela_precos(){
		$editar = $this->clientes_model->edit_tabela_precos($_POST);
		echo json_encode($editar);
	}

	public function clientes_ativos_agendar(){
		
		$clientes=$this->clientes_model->selecionar_clientes_pesquisa($this->input->get('q'));
		$results = array();
		for($i = 0; $i <count($clientes); $i++) {
			$results[] = array(
				"id"=>$clientes[$i]['id_cliente'],
				"text" => $clientes[$i]['cliente'],
			);
		}
		echo json_encode($results);

	}

	public function instalacao_cliente(){
		$executou=$this->clientes_model->get_instalacao_cliente_ativas($this->input->get('cliente'));
		if($executou){
			echo json_encode($executou);
		}else{
			return false;
		}
				 
				
	}
}

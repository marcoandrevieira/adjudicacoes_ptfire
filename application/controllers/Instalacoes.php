<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Instalacoes extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_logged_in') !== TRUE) {
			redirect('login');
		}
		$this->load->model('instalacoes_model');
	}

	public function instalacoes_cliente($id_cliente)
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
				'<script src="' . scripts_url() . 'zonas.js" type="text/javascript"></script>',
				'<script src="' . scripts_url() . 'instalacoes.js" type="text/javascript"></script>',
			),
		);

		$this->load->model('clientes_model');
		$cliente = $this->clientes_model->get_cliente($id_cliente);

		$this->load->model('zonas_model');
		$destritos=$this->zonas_model->destritos();

		$data = array(
			'content' => 'instalacoes', 
			'cliente'=> $cliente,
			'distritos'=>$destritos,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_instalacoes()
	{

		$clientes = $this->instalacoes_model->make_tabela_instalacoes();
		$data = array();
		foreach ($clientes as $row) {
			$sub_array = array();
			$sub_array[] = $row->instalacao;
			$sub_array[] = $row->morada;
			$sub_array[] = $row->cp;
			$sub_array[] = $row->distrito . "/" . $row->concelho;
			$sub_array[] = $row->email;
			$sub_array[] = $row->telefone;
			$sub_array[] = '<a href="' . base_url('instalacoes/entregas_material/') . $row->id_instalacao . '"><button class="btn green-jungle btn-outline"><i class="fa fa-arrow-right"></i> Ver Entregas </button></a>
			<button onclick="editar_instalacao(' . $row->id_instalacao . ')" class="btn yellow-gold btn-outline"><i class="fa fa-edit"></i> Editar </button>
			<button onclick="apagar_instalacao(' . $row->id_instalacao . ')" class="btn red-thunderbird btn-outline"><i class="fa fa-times"></i> Apagar </button>
     						';
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->instalacoes_model->get_all_instalacoes(),
			'recordsFiltered' => $this->instalacoes_model->get_filtered_instalacoes(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function adicionarInstalacao(){
		$instalacoes = $this->instalacoes_model->adicionarInstalacao($_POST);
		echo json_encode($instalacoes);
	}

	public function get_instalacao($id_instalacao=null){

		$instalacao = $this->instalacoes_model->get_instalacao($id_instalacao);
		echo json_encode($instalacao);

	}

	public function editarInstalacao(){
		$instalacoes = $this->instalacoes_model->editarInstalacao($_POST);
		echo json_encode($instalacoes);
	}

	public function apagar_instalacao(){
		$instalacoes = $this->instalacoes_model->apagarInstalacao($_POST);
		echo json_encode($instalacoes);
	}

	public function entregas_material($id_instalacao)
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
				'<script src="' . scripts_url() . 'zonas.js" type="text/javascript"></script>',
				'<script src="' . scripts_url() . 'instalacoes.js" type="text/javascript"></script>',
			),
		);

		//$fornecimento = $this->instalacoes_model->get_fornecimento_material($id_instalacao);

		$data = array(
			'content' => 'entregas_material', 
			//'fornecimento'=> $fornecimento,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_historico_fornecimento()
	{

		$fornecimento = $this->instalacoes_model->make_tabela_historico_fornecimento();
		$data = array();
		foreach ($fornecimento as $row) {
			$sub_array = array();
			$sub_array[] = $row->projeto;
			$sub_array[] = $row->armazem;
			$sub_array[] = $row->criado_nome;
			$sub_array[] = $row->data_insercao;
			$sub_array[] = $row->fechado_nome;
			$sub_array[] = $row->data_fecho;
			$sub_array[] = '<a target="_blank" href="'.base_url('comprovativopdf/fornecimento_material/').$row->id_fornecimento.'" class="btn btn-outline blue"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Ver PDF</a>';
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->instalacoes_model->get_all_historico_fornecimento(),
			'recordsFiltered' => $this->instalacoes_model->get_filtered_historico_fornecimento(),
			'data' => $data
		);

		echo json_encode($output);
	}
	
}

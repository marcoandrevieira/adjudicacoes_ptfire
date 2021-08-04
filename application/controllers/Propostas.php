<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Propostas extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_logged_in') !== TRUE) {
			redirect('login');
		}
		$this->load->model('propostas_model');
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
				'<script src="' . plugins_url() . 'bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-summernote/summernote.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>',
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>'
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'propostas.js" type="text/javascript"></script>',
			),
		);

		$data = array(
			'content' => 'propostas',
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_propostas()
	{

		$propostas = $this->propostas_model->make_tabela_propostas();
		$data = array();
		foreach ($propostas as $row) {
			$sub_array = array();
			$sub_array[] = $row->proposta;
			$sub_array[] = $row->cliente;
			$sub_array[] = $row->instalacao;
			$sub_array[] = $row->data_envio;
			$sub_array[] = $row->nome;
			$sub_array[] = $row->id_proposta;
			$sub_array[] = '<div class="col-md-12">
				<a href="'.base_url('propostas/proposta/'.$row->id_proposta).'" class="btn btn-outline btn-block blue"><i class="fa fa-share-square-o" aria-hidden="true"></i> Proposta</a>
			</div>
			<div class="col-md-12">
				<button onclick="apagar_proposta('.$row->id_proposta.')" class="btn btn-outline btn-block red"><i class="fa fa-times" aria-hidden="true"></i> Apagar</button>
			</div>';
		
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->propostas_model->get_all_propostas(),
			'recordsFiltered' => $this->propostas_model->get_filtered_propostas(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function adicionarProposta()
	{
		$proposta = $this->propostas_model->adicionarProposta($_POST);
		echo json_encode($proposta);
	}

	public function proposta($id){
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
				'<script src="' . plugins_url() . 'bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'input_number/src/input-spinner.js"></script>',
				'<script src="' . plugins_url() . 'bootstrap-touchspin/bootstrap.touchspin.min.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-summernote/summernote.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-toastr/toastr.min.js" type="text/javascript"></script>',
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>'
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'propostas.js" type="text/javascript"></script>',
			),
		);

		$proposta = $this->propostas_model->get_proposta($id);
		$data = array(
			'content' => 'proposta',
			'proposta' => $proposta,
			'scripts' => $this->scripts
		);
		$this->load->view('includes/template', $data);
	}

	public function get_tabela_single_proposta()
	{
		$artigos = $this->propostas_model->make_tabela_single_proposta();
		$data = array();
		foreach ($artigos as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = "<img src='" . base_url() . "recourses/images/products/" . $row->fotografia1 . "' width='70%' alt='" . $row->artigo . "'>";
			$sub_array[] = '<input type="text" class="form-control preco_artigo" id="preco'.$row->id_artigo.'" value="'.$row->preco.' €">';
			$sub_array[] = '<input type="number" min="1" step="1" id="quantidade' . $row->id_artigo . '" class="form-control quantidade_fornecimento">';
			$sub_array[] = '<button onclick="adicionar_artigo_proposta(' . $row->id_artigo . ')" class="btn green-jungle btn-outline"><i class="fa fa-arrow-right"></i> Adicionar </button>';

			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->propostas_model->get_all_single_proposta(),
			'recordsFiltered' => $this->propostas_model->get_filtered_single_proposta(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function adicionar_artigos_proposta(){
		$artigo = $this->propostas_model->adicionar_artigos_proposta($_POST);
		echo json_encode($artigo);
	}

	public function table_artigos_proposta()
	{

		$propostas = $this->propostas_model->make_tabela_artigos_proposta();
		$data = array();
		foreach ($propostas as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = "<img src='" . base_url() . "recourses/images/products/" . $row->fotografia1 . "' width='70%' alt='" . $row->artigo . "'>";
			$sub_array[] = $row->quantidade;
			$sub_array[] = $row->preco . " €";
			$sub_array[] = '<button onclick="remover_artigo_proposta('.$row->id_artigo_proposta.')" class="btn btn-outline btn-sm red"><i class="fa fa-times" aria-hidden="true"></i> Remover</button>';
		
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->propostas_model->get_all_artigos_proposta(),
			'recordsFiltered' => $this->propostas_model->get_filtered_artigos_proposta(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function apagar_artigo_proposta(){
		$remover = $this->propostas_model->apagar_artigo_proposta($_POST);
		echo json_encode($remover);
	}

	public function apagar_proposta(){
		$remover = $this->propostas_model->apagar_proposta($_POST);
		echo json_encode($remover);
	}

	public function enviar_proposta_cliente(){
		$remover = $this->propostas_model->enviar_proposta_cliente($_POST);
		echo json_encode($remover);
	}
	
}

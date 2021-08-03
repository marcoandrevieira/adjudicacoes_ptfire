<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Fornecimento extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_logged_in') !== TRUE) {
			redirect('login');
		}
		$this->load->model('fornecimento_model');
	}

	public function armazens_disponiveis()
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
				'<script src="' . scripts_url() . 'fornecimento.js" type="text/javascript"></script>',
			),
		);

		$data = array(
			'content' => 'armazens_disponiveis',
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_armazens_disponiveis($id_projeto)
	{

		$this->load->model('armazens_model');
		$clientes = $this->armazens_model->make_tabela_armazens();
		$data = array();
		foreach ($clientes as $row) {
			$sub_array = array();
			$sub_array[] = $row->armazem;
			$sub_array[] = $row->morada;
			$sub_array[] = $row->notas;
			$sub_array[] = '<a href="' . base_url('fornecimento/stock/'. $row->id_armazem .'/' .$id_projeto) . '"><button class="btn green-jungle btn-outline"><i class="fa fa-arrow-right"></i> Fornecer Stock </button></a>';
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->armazens_model->get_all_armazens(),
			'recordsFiltered' => $this->armazens_model->get_filtered_armazens(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function stock($id_armazem, $id_projeto)
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
				'<script src="' . plugins_url() . 'input_number/src/input-spinner.js"></script>',
				'<script src="' . plugins_url() . 'bootstrap-summernote/summernote.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-toastr/toastr.min.js" type="text/javascript"></script>',
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>'
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'fornecimento.js" type="text/javascript"></script>',
			),
		);

		$id_fornecimento = $this->fornecimento_model->novo_fornecimento($id_armazem, $id_projeto);

		$this->load->model('armazens_model');
		$armazem = $this->armazens_model->get_armazem($id_armazem);
		$dados_cliente = $this->fornecimento_model->get_cliente_fornecimento($id_fornecimento);

		$data = array(
			'content' => 'fornecimento_stock',
			'armazem' => $armazem,
			'dados_cliente' =>$dados_cliente,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_stock_armazem()
	{
		$artigos = $this->fornecimento_model->make_tabela_stock_armazem();
		$data = array();
		foreach ($artigos as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = "<img src='" . base_url() . "recourses/images/products/" . $row->fotografia1 . "' width='70%' alt='" . $row->artigo . "'>";
			$sub_array[] = $row->quantidade;
			$sub_array[] = '<input type="text" readonly class="form-control" value="'.$row->preco.' €">';
			$sub_array[] = '<input type="number" min="1" max="' . $row->quantidade . '" step="1" id="id_artigo' . $row->id_artigo . '" class="form-control quantidade_fornecimento">';
			$sub_array[] = '<button id="botaoidartigo' . $row->id_artigo . '" onclick="fornecer_artigo_cliente(' . $row->id_artigo . ', '. $row->preco .')" class="btn green-jungle btn-outline"><i class="fa fa-arrow-right"></i> Adicionar </button>';

			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->fornecimento_model->get_all_stock_armazem(),
			'recordsFiltered' => $this->fornecimento_model->get_filtered_stock_armazem(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function adicionar_fornecimento_artigo(){
		$adicionar = $this->fornecimento_model->adicionar_fornecimento_artigo($_POST);
		echo json_encode($adicionar);
	}

	public function get_tabela_fornecimento_cliente(){

		$artigos = $this->fornecimento_model->make_tabela_fornecimento_cliente();
		$data = array();
		foreach ($artigos as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = "<img src='" . base_url() . "recourses/images/products/" . $row->fotografia1 . "' width='70%' alt='" . $row->artigo . "'>";
			$sub_array[] = $row->quantidade;
			$sub_array[] = $row->preco*$row->quantidade . " €";
			if(empty($row->fechado_por)){
				$sub_array[] = '<button onclick="apagar_fornecimento_material('.$row->id_artigo_fornecido.', '.$row->id_artigo.', '.$row->quantidade.')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Remover</button>';
			}else{
				$sub_array[] = 'OK';
			}
	
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->fornecimento_model->get_all_fornecimento_cliente(),
			'recordsFiltered' => $this->fornecimento_model->get_filtered_fornecimento_cliente(),
			'data' => $data
		);
		echo json_encode($output);

	}
	public function apagar_artigo_fornecido(){
		$apagar = $this->fornecimento_model->apagar_artigo_fornecido($_POST);
		echo json_encode($apagar);
	}

	public function fechar_artigo_fornecido(){
		$fechar = $this->fornecimento_model->fechar_artigo_fornecido($_POST);
		echo json_encode($fechar);
	}
	
	
}

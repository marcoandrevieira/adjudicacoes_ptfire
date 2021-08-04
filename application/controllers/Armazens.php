<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Armazens extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_logged_in') !== TRUE) {
			redirect('login');
		}
		$this->load->model('armazens_model');
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
				'<script src="' . scripts_url() . 'armazens.js" type="text/javascript"></script>',
			),
		);

		$data = array(
			'content' => 'armazens',
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_armazens()
	{

		$clientes = $this->armazens_model->make_tabela_armazens();
		$data = array();
		foreach ($clientes as $row) {
			$sub_array = array();
			$sub_array[] = $row->armazem;
			$sub_array[] = $row->morada;
			$sub_array[] = $row->notas;
			$sub_array[] = '<a href="' . base_url('armazens/stock/') . $row->id_armazem . '"><button class="btn green-jungle btn-outline"><i class="fa fa-arrow-right"></i> Ver Stock </button></a>
			<button onclick="editar_armazem(' . $row->id_armazem . ')" class="btn yellow-gold btn-outline"><i class="fa fa-edit"></i> Editar </button>
			<button onclick="apagar_armazem(' . $row->id_armazem . ')" class="btn red-thunderbird btn-outline"><i class="fa fa-times"></i> Apagar </button>
     						';
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

	public function adicionarArmazem()
	{

		$armazem = $this->armazens_model->adicionarArmazem($_POST);
		echo json_encode($armazem);
	}

	public function get_armazem($id_armazem = null)
	{

		$armazem = $this->armazens_model->get_armazem($id_armazem);
		echo json_encode($armazem);
	}

	public function editarArmazem()
	{

		$armazem = $this->armazens_model->editarArmazem($_POST);
		echo json_encode($armazem);
	}

	public function apagar_armazem()
	{
		$armazem = $this->armazens_model->apagarArmazem($_POST);
		echo json_encode($armazem);
	}
	/* ---------------------------------------------------------------------------------------------------------------------------------------- */

	public function stock($id_armazem)
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
				'<script src="' . scripts_url() . 'stock.js" type="text/javascript"></script>',
			),
		);
		$armazem = $this->armazens_model->get_armazem($id_armazem);
		$data = array(
			'content' => 'stock',
			'armazem' => $armazem,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_stock_armazem()
	{
		$this->load->model('artigos_model');
		$artigos = $this->armazens_model->make_tabela_stock_armazem();
		$data = array();
		foreach ($artigos as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = "<img src='" . base_url() . "recourses/images/products/" . $row->fotografia1 . "' width='70%' alt='" . $row->artigo . "'>";
			$sub_array[] = $row->quantidade;
			if ($_SESSION['id_tipo'] == 1) {
				$sub_array[] = '<button onclick="editar_stock_artigo(' . $row->id_artigo . ', ' . $row->id_armazem . ', ' . $row->quantidade . ')" class="btn btn-outline yellow-gold"><i class="fa fa-edit"></i> Editar</button>';
			}

			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->armazens_model->get_all_stock_armazem(),
			'recordsFiltered' => $this->armazens_model->get_filtered_stock_armazem(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function editar_quantidade_artigo()
	{
		$edit = $this->armazens_model->editar_quantidade_artigo($_POST);
		echo json_encode($edit);
	}

	/* ---------------------------------------------------------------------------------------------------------------------------------------- */
	public function entrada_stock($id_armazem)
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
				'<script src="' . plugins_url() . 'bootstrap-touchspin/bootstrap.touchspin.min.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-summernote/summernote.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>',
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>'
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'stock.js" type="text/javascript"></script>',
			),
		);
		$armazem = $this->armazens_model->get_armazem($id_armazem);

		$this->load->model('utilizadores_model');
		$utilizadores = $this->utilizadores_model->todos_utilizadores();

		$data = array(
			'content' => 'entrada_stock',
			'armazem' => $armazem,
			'utilizadores' => $utilizadores,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_entrada_stock()
	{

		$entradas = $this->armazens_model->make_tabela_entrada_stock();
		$data = array();
		foreach ($entradas as $row) {
			$sub_array = array();
			$sub_array[] = $row->fechado_nome == "" ? '<span class="badge badge-success"><i class="fa fa-unlock"></i></span>' : '<span class="badge badge-danger"><i class="fa fa-lock"></i></span>';
			$sub_array[] = $row->nr_fatura;
			$sub_array[] = $row->data_fatura;
			$sub_array[] = $row->valor;
			$sub_array[] = $row->criado_nome;
			$sub_array[] = $row->fechado_nome;
			$sub_array[] = $row->observacoes;
			$sub_array[] = '
			<div class="btn-group">
				<a class="btn green" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
					<i class="fa fa-wrench"></i> Ações
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a style="padding:0px" href="' . base_url('armazens/entrada/') . $row->id_entrada . '"><button class="btn green-jungle btn-outline btn-block"><i class="fa fa-arrow-right"></i> Entrar </button></a>
					</li>
					<li>
						<button onclick="editar_entrada_stock(' . $row->id_entrada . ')" class="btn yellow-gold btn-outline btn-block"><i class="fa fa-edit"></i> Editar </button>
					</li>
					<li>
						<button onclick="apagar_entrada_stock(' . $row->id_entrada . ')" class="btn red-thunderbird btn-outline btn-block"><i class="fa fa-times"></i> Apagar </button>
					</li>
					<li class="divider"> </li>
					
				</ul>
			</div>
			';
			$data[] = $sub_array;
		}



		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->armazens_model->get_all_entrada_stock(),
			'recordsFiltered' => $this->armazens_model->get_filtered_entrada_stock(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function adicionarEntrada()
	{
		$entrada = $this->armazens_model->adicionarEntrada($_POST);
		echo json_encode($entrada);
	}

	public function get_entrada_stock($id_armazem = null)
	{
		$entrada = $this->armazens_model->get_entrada_stock($id_armazem);
		echo json_encode($entrada);
	}

	public function editarEntradaStock()
	{
		$entrada = $this->armazens_model->editarEntradaStock($_POST);
		echo json_encode($entrada);
	}

	public function apagar_entrada_stock()
	{
		$entrada = $this->armazens_model->apagarEntradaStock($_POST);
		echo json_encode($entrada);
	}

	/* ---------------------------------------------------------------------------------------------------------------------------------------- */
	public function movimentar_stock($id_armazem)
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
				'<script src="' . scripts_url() . 'stock.js" type="text/javascript"></script>',
			),
		);
		$armazem = $this->armazens_model->get_armazem($id_armazem);
		$armazens = $this->armazens_model->get_armazens();
		$this->load->model('utilizadores_model');
		$utilizadores = $this->utilizadores_model->todos_utilizadores();

		$data = array(
			'content' => 'movimentar_stock',
			'armazem' => $armazem,
			'armazens' => $armazens,
			'utilizadores' => $utilizadores,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_movimentos()
	{

		$entradas = $this->armazens_model->make_tabela_movimentos();
		$data = array();
		foreach ($entradas as $row) {
			$sub_array = array();
			$sub_array[] = $row->fechado == 0 ? '<span class="badge badge-danger"><i class="fa fa-unlock"></i></span>' : '<span class="badge badge-success"><i class="fa fa-lock"></i></span>';
			$sub_array[] = $row->armazem_saida;
			$sub_array[] = $row->armazem_entrada;
			$sub_array[] = $row->data_insercao;
			$sub_array[] = $row->criado_nome;
			$sub_array[] = $row->data_concluido;
			$sub_array[] = $row->fechado_nome;
			$sub_array[] = $row->observacoes;
			$sub_array[] = '<a style="padding:0px" href="' . base_url('armazens/movimento/') . $row->id_movimento . '"><button class="btn green-jungle btn-outline btn-block"><i class="fa fa-arrow-right"></i> Entrar </button></a>';
			$data[] = $sub_array;
		}



		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->armazens_model->get_all_movimentos(),
			'recordsFiltered' => $this->armazens_model->get_filtered_movimentos(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function novo_movimento()
	{
		$movimento = $this->armazens_model->novo_movimento($_POST);
		echo json_encode($movimento);
	}

	/* ------------------------------------------------------------------------------------------------------------------------------------------------------- */

	public function entrada($id_entrada)
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
				'<script src="' . plugins_url() . 'bootstrap-touchspin/bootstrap.touchspin.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-toastr/toastr.min.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-summernote/summernote.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>',
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>'
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'stock.js" type="text/javascript"></script>',
			),
		);
		$entrada_stock = $this->armazens_model->get_entrada_stock($id_entrada);

		$this->load->model('utilizadores_model');
		$utilizadores = $this->utilizadores_model->todos_utilizadores();

		$data = array(
			'content' => 'entrada',
			'entrada_stock' => $entrada_stock,
			'utilizadores' => $utilizadores,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_entrada_artigos()
	{

		$entrada_artigos = $this->armazens_model->make_tabela_entrada_artigos();
		$data = array();
		foreach ($entrada_artigos as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = "<img src='" . base_url() . "recourses/images/products/" . $row->fotografia1 . "' width='70%' alt='" . $row->artigo . "'>";
			$sub_array[] = $row->quantidade;
			if ($row->fechado_por != null) {
				$sub_array[] =  '<button disabled class="btn blue"><i class="fa fa-eye-slash"></i> Lançado</button>';
			} else {
				$sub_array[] = $row->fechado == 0 ? '<button onclick="lancar_artigo(' . $row->id_entrada_artigo . ', 1, ' . $row->id_artigo . ')" class="btn yellow-gold"><i class="fa fa-eye"></i> Por lançar</button>' : '<button onclick="lancar_artigo(' . $row->id_entrada_artigo . ', 0,  ' . $row->id_artigo . ')" class="btn blue"><i class="fa fa-eye-slash"></i> Lançado</button>';
			}
			$sub_array[] = $row->fechado == 0 ? '<button onclick="apagar_entrada_artigo(' . $row->id_entrada_artigo . ')" class="btn red-thunderbird btn-outline"><i class="fa fa-times"></i> Apagar </button>' : "";
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->armazens_model->get_all_entrada_artigos(),
			'recordsFiltered' => $this->armazens_model->get_filtered_entrada_artigos(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function get_tabela_artigos()
	{
		$this->load->model('artigos_model');
		$artigos = $this->artigos_model->make_tabela_artigos();
		$data = array();
		foreach ($artigos as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = $row->ano_fabrico;
			$sub_array[] = "<img src='" . base_url() . "recourses/images/products/" . $row->fotografia1 . "' width='70%' alt='" . $row->artigo . "'>";
			$sub_array[] = '<input type="text" id="id_artigo' . $row->id_artigo . '" class="form-control quantidade">';
			$sub_array[] = '<button id="botaoidartigo' . $row->id_artigo . '" onclick="adicionar_artigo_stock(' . $row->id_artigo . ')" class="btn green-jungle btn-outline"><i class="fa fa-arrow-right"></i> Adicionar </button>
			
     						';
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->artigos_model->get_all_artigos(),
			'recordsFiltered' => $this->artigos_model->get_filtered_artigos(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function adicionar_artigo_stock()
	{
		$adicionar = $this->armazens_model->adicionar_artigo_stock($_POST);
		echo json_encode($adicionar);
	}

	public function lancar_artigo()
	{
		$adicionar = $this->armazens_model->lancar_artigo($_POST);
		echo json_encode($adicionar);
	}

	public function apagarentradaartigo()
	{
		$apagar = $this->armazens_model->apagarentradaartigo($_POST);
		echo json_encode($apagar);
	}

	public function fechar_entrada()
	{
		$fechar = $this->armazens_model->fechar_entrada($_POST);
		echo json_encode($fechar);
	}

	/* ------------------------------------------------------------------------------------------------------------------------------------------------------- */

	public function movimento($id_movimento)
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
				'<script src="' . plugins_url() . 'bootstrap-touchspin/bootstrap.touchspin.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-toastr/toastr.min.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-summernote/summernote.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'input_number/src/input-spinner.js"></script>',
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>'
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'stock.js" type="text/javascript"></script>',
			),
		);

		$movimento = $this->armazens_model->get_movimento($id_movimento);
		$fechado = $this->armazens_model->movimento_fechado($id_movimento);

		$data = array(
			'content' => 'movimento',
			'movimento' => $movimento,
			'fechado' => $fechado,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_movimentar_artigos()
	{
		$this->load->model('artigos_model');
		$artigos = $this->armazens_model->make_tabela_stock_armazem();
		$data = array();
		foreach ($artigos as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = "<img src='" . base_url() . "recourses/images/products/" . $row->fotografia1 . "' width='70%' alt='" . $row->artigo . "'>";
			$sub_array[] = $row->quantidade;
			if ($_SESSION['id_tipo'] == 1) {
				if (!empty($this->armazens_model->movimento_fechado($_POST['id_movimento']))) {
					$sub_array[] = '<input readonly class="form-control-sm movimentar_quantidade" id="artigo' . $row->id_artigo . '" type="number" min="1" max="' . $row->quantidade . '" step="1"/>';
					$sub_array[] = '<button disabled onclick="artigos_selecionados(' . $row->id_artigo . ')" class="btn green-jungle"><i class="fa fa-plus"></i> Adicionar</button>';
				} else {
					$sub_array[] = '<input class="form-control-sm movimentar_quantidade" id="artigo' . $row->id_artigo . '" type="number" min="1" max="' . $row->quantidade . '" step="1"/>';
					$sub_array[] = '<button onclick="artigos_selecionados(' . $row->id_artigo . ')" class="btn green-jungle"><i class="fa fa-plus"></i>Adicionar</button>';
				}
			}

			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->armazens_model->get_all_stock_armazem(),
			'recordsFiltered' => $this->armazens_model->get_filtered_stock_armazem(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function adicionar_movimento_artigo()
	{
		$adicionar = $this->armazens_model->adicionar_movimento_artigo($_POST);
		echo json_encode($adicionar);
	}

	public function fechar_movimento()
	{
		$fechar = $this->armazens_model->fechar_movimento($_GET);
		echo json_encode($fechar);
	}

	public function remover_movimento_artigo()
	{
		$remover = $this->armazens_model->remover_movimento_artigo($_POST);
		echo json_encode($remover);
	}

	public function load_div_artigos($id_movimento)
	{

		$artigos = $this->armazens_model->load_div_artigos($id_movimento);

		foreach ($artigos as $artigo) {
			$html =  '<div class="portlet light bordered row">
		<div class="portlet-body">
			<ul>
				<li>
					<div class="col-md-1">';
			if (!empty($artigo['aceitado_por'])) {
				$html .= '<div class="label label-sm label-success"><i class="fa fa-thumbs-up"></i></div>';
			} else {
				$html .= '<div class="label label-sm label-warning"><i class="fa fa-thumbs-down"></i></div>';
			}

			$html .= '</div>
					<div class="col-md-7">
						<h4 style="margin:0px">' . $artigo['artigo'] . '</h4>
					</div>
					<div class="col-md-3">
						Qnt:<br>
						<h4><b>' . $artigo['quantidade'] . '</b></h4>
					</div>
					<div class="col-md-1">';

			if (!empty($artigo['aceitado_por'])) {
				$html .= '';
			} else {
				$html .= '<div class="label label-sm label-danger">
				<a href="#/" style="color:white"><i onclick="apagar_artigo_movimentado(' . $artigo['id_artigo_movimento'] . ',' . $artigo['id_movimento'] . ',' . $artigo['id_artigo'] . ', ' . $artigo['quantidade'] . ', ' . $artigo['id_armazem_saida'] . ')" class="fa fa-times"></i></a>
			</div>';
			}


			$html .= '</div>
				</li>
			</ul>
		</div>
		</div>';
			echo $html;
		}
	}


	/* ---------------------------------------------------------------------------------------------------------------------------------------- */
	public function movimentos_pendentes()
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
				'<script src="' . scripts_url() . 'stock.js" type="text/javascript"></script>',
			),
		);

		$armazens = $this->armazens_model->get_armazens();
		$this->load->model('utilizadores_model');
		$utilizadores = $this->utilizadores_model->todos_utilizadores();

		$data = array(
			'content' => 'movimentos_pendentes',

			'armazens' => $armazens,
			'utilizadores' => $utilizadores,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function span_movimentos_pendentes()
	{
		$movimentos = $this->armazens_model->span_movimentos_pendentes();
		echo json_encode($movimentos);
	}

	public function get_movimentos_pendentes()
	{
		$entradas = $this->armazens_model->make_tabela_movimentos();
		$data = array();
		foreach ($entradas as $row) {
			$sub_array = array();
			$sub_array[] = $row->aceite == 0 ? '<span class="badge badge-danger"><i class="fa fa-unlock"></i></span>' : '<span class="badge badge-success"><i class="fa fa-lock"></i></span>';
			$sub_array[] = $row->armazem_saida;
			$sub_array[] = $row->armazem_entrada;
			$sub_array[] = $row->data_insercao;
			$sub_array[] = $row->criado_nome;
			$sub_array[] = $row->data_aceite;
			$sub_array[] = $row->fechado_nome;
			$sub_array[] = $row->observacoes;
			$sub_array[] = '<a style="padding:0px" href="' . base_url('armazens/aceitar_movimento/') . $row->id_movimento . '"><button class="btn green-jungle btn-outline btn-block"><i class="fa fa-arrow-right"></i> Entrar </button></a>';
			$data[] = $sub_array;
		}
		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->armazens_model->get_all_movimentos(),
			'recordsFiltered' => $this->armazens_model->get_filtered_movimentos(),
			'data' => $data
		);
		echo json_encode($output);
	}

	/* ---------------------------------------------------------------------------------------------------------------------------------------- */
	public function aceitar_movimento($id_movimento)
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
				'<script src="' . scripts_url() . 'movimento.js" type="text/javascript"></script>',
			),
		);

		$movimento = $this->armazens_model->get_movimento($id_movimento);
		$armazens = $this->armazens_model->get_armazens();
		$this->load->model('utilizadores_model');
		$utilizadores = $this->utilizadores_model->todos_utilizadores();

		$data = array(
			'content' => 'aceitar_movimento',
			'movimento' => $movimento,
			'armazens' => $armazens,
			'utilizadores' => $utilizadores,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_aceitar_movimento()
	{
		$this->load->model('artigos_model');
		$artigos = $this->armazens_model->make_tabela_aceitar_movimento();
		$data = array();
		foreach ($artigos as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = "<img src='" . base_url() . "recourses/images/products/" . $row->fotografia1 . "' width='70%' alt='" . $row->artigo . "'>";
			$sub_array[] = $row->quantidade;
			if ($_SESSION['id_tipo'] == 1) {
				if (!$row->aceitado_por) {
					$sub_array[] = '<button onclick="aceitar_artigo(' . $row->id_artigo_movimento . ',' . $row->id_movimento . ',' . $row->id_artigo . ',' . $row->quantidade . ')" class="btn green-jungle"> <i class="fa fa-plus"></i> Aceitar &nbsp </button>';
				} else {
					$sub_array[] = "<span class='label bg-green'><i class='fa fa-check'></i> Confirmado</span>";
				}
			}
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->armazens_model->get_all_aceitar_movimento(),
			'recordsFiltered' => $this->armazens_model->get_filtered_aceitar_movimento(),
			'data' => $data
		);
		echo json_encode($output);
	}

	public function aceitar_artigo()
	{
		$aceitar = $this->armazens_model->aceitar_artigo($_GET);
		echo json_encode($aceitar);
	}
}

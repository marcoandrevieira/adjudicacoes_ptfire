<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Faturacao extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_logged_in') !== TRUE) {
			redirect('login');
		}
		$this->load->model('faturacao_model');
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
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>',
				'<script type="text/javascript" src="' . plugins_url() . 'moment/moment.min.js"></script>',
				'<script type="text/javascript" src="' . plugins_url() . 'bootstrap-daterangepicker/daterangepicker.min.js"></script>',
				'<script src="'.plugins_url().'bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>'
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'faturacao.js" type="text/javascript"></script>',
			),
		);
		$this->load->model('armazens_model');
		$armazens = $this->armazens_model->get_armazens();
		$this->load->model('utilizadores_model');
		$utilizadores = $this->utilizadores_model->todos_utilizadores();

		$data = array(
			'content' => 'faturacao',
			'armazens' => $armazens,
			'utilizadores'=> $utilizadores,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_table_faturacao()
	{

		$clientes = $this->faturacao_model->make_tabela_faturacao();
		$data = array();
		foreach ($clientes as $row) {
			$sub_array = array();
			$sub_array[] = $row->projeto;
			$sub_array[] = $row->cliente;
			$sub_array[] = $row->instalacao;
			$sub_array[] = '<a target="_blank" class="btn btn-outline btn-xs blue" href="'.base_url('comprovativopdf/fornecimento_material/'.$row->id_fornecimento).'"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Ver PDF</a>';
			$sub_array[] = $row->armazem;
			$sub_array[] = $row->data_fecho;
			$sub_array[] = $row->nome;
			$sub_array[] = $this->faturacao_model->get_valor_total_forncecimento($row->id_fornecimento) . " €";
			$sub_array[] = $row->nr_fatura;
			$sub_array[] = empty($row->valor_fatura) ? "":$row->valor_fatura . " €";
			$sub_array[] = '<button onclick="adicionar_fatura('.$row->id_fornecimento.')" class="btn btn-outline yellow-gold"><i class="fa fa-file-text-o" aria-hidden="true"></i> Fatura</button>';
			
			$data[] = $sub_array;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->faturacao_model->get_all_faturacao(),
			'recordsFiltered' => $this->faturacao_model->get_filtered_faturacao(),
			'data' => $data
		);

		echo json_encode($output);
	}

	public function adicionar_fatura(){
		$imagem_fatura = null;

		if (isset($_FILES['imagem_fatura']['name']) && $_FILES['imagem_fatura']['name'] != "") {

            /* definir isto  */
            $config['upload_path']          = './recourses/images/invoices';
            $config['allowed_types']        = 'jpg|png|gif|jpeg|tiff|zip|pdf';
            $config['max_size']             = 9999;
            $config['max_width']            = 0;
            $config['max_height']           = 0;

            /* carregar a livraria */
            $this->load->library('upload', $config);
            $this->load->helper('file');

            if ($_FILES['imagem_fatura']['name'] != "") {


                $this->upload->do_upload('imagem_fatura');

                $imagem_fatura = $this->upload->data('file_name');
                //verifica se existe data, se tem algo no data do upload
                $data = array('upload_data' => $this->upload->data());
            } else {
                $imagem_fatura = 0;
            }
		}

		$fatura = $this->faturacao_model->adicionarFatura($_POST, $imagem_fatura);
		echo json_encode($fatura);
	}

	public function get_fatura(){
		$fatura = $this->faturacao_model->get_fatura($_POST);
		echo json_encode($fatura);
	}

	public function analises_KPI(){
		$this->scripts = array(
			'page_level_plugins' => array(
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>',
				'<script type="text/javascript" src="' . plugins_url() . 'xlsx/xlsx.full.min.js"></script>',
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'faturacao.js" type="text/javascript"></script>',
			),
		);

		$data = array(
			'content' => 'analisesKPI',
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function exportar_excel(){
		$export = $this->faturacao_model->exportar_excel($_POST);
		echo json_encode($export);
	}

}

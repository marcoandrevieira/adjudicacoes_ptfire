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
			$sub_array[] = $row->proposta;
			$sub_array[] = $row->proposta;
			$sub_array[] = $row->proposta;
			$sub_array[] = $row->proposta;
			$sub_array[] = $row->proposta;
			$sub_array[] = $row->proposta;
		
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

	
}

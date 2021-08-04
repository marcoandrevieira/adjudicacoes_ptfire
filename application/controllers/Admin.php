<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{
	//var $pasta='cliente/';
	function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		//$this->is_monitor();
	}
	function index()
	{
		//echo "entrou";
		$this->load->view('login');
	}

	function is_logged_in()
	{



		$in = $this->session->userdata('is_logged_in');
		$email = $this->session->userdata('email');

		if (!isset($in, $email) || $in != true || $email != true) {
			redirect('login');
			//die();
		}
	}

	/* function is_monitor()
	{
		if ($this->session->userdata('id_tipo') == 2) {
			redirect(base_url() . 'monitores');
		}
	} */

	public function dashboard()
	{

		$this->scripts = array(
			'page_level_plugins' => array(),

			'page_level_scripts' => array()
		);

		$this->scripts['page_level_scripts'] = array();

		$data = array('content' => 'dashboard', 'scripts' => $this->scripts);
		$this->load->view('includes/template', $data);
	}
	function utilizadores()
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
			),

			'page_level_scripts' => array(
				'<script src="' . scripts_url() . 'generate_password.js" type="text/javascript"></script>',
				'<script src="' . scripts_url() . 'utilizadores.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/localization/messages_pt_PT.min.js" type="text/javascript"></script>',


			),
		);

		$this->load->model('utilizadores_model');
		$utilizadores = $this->utilizadores_model->todos_utilizadores();
		$tipo = $this->utilizadores_model->tipo_utilizadores_ativos();

		$data = array('content' => 'utilizadores', 'scripts' => $this->scripts, 'utilizadores' => $utilizadores, 'tipo' => $tipo);

		$this->load->view('includes/template', $data);
	}

	function adjudicacoes()
	{
		$this->scripts = array(
			'page_level_plugins' => array(

				'<script src="' . plugins_url() . 'jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/localization/messages_pt_PT.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'jquery.sparkline.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt.js" type="text/javascript"></script>',

				'<script src="' . scripts_url() . 'datatable.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/datatables.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'moment.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-datepicker/locales/bootstrap-datepicker.pt.min.js" charset="UTF-8"></script>',
				'<script src="' . plugins_url() . 'bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>',

				'<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>',
				'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>',
			),

			'page_level_scripts' => array(

				'<script src="' . scripts_url() . 'projetos.js" type="text/javascript"></script>',


			)
		);


		$this->load->model('projetos_model');
		$this->load->model('utilizadores_model');
		$estados = $this->projetos_model->get_estados_ativos();
		$servicos = $this->projetos_model->get_servicos_ativos();
		$utilizadores = $this->utilizadores_model->utilizadores_ativos();

		$data = array('content' => 'projetos', 'scripts' => $this->scripts, 'estados' => $estados, 'servicos' => $servicos, 'users' => $utilizadores);
		$this->load->view('includes/template', $data);
	}

	function servicos()
	{


		$this->scripts = array(
			'page_level_plugins' => array(

				'<script src="' . plugins_url() . 'jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/localization/messages_pt_PT.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'jquery.sparkline.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt.js" type="text/javascript"></script>',

				'<script src="' . scripts_url() . 'datatable.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/datatables.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'moment.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>',


			),

			'page_level_scripts' => array(

				'<script src="' . scripts_url() . 'servicos.js" type="text/javascript"></script>',


			)
		);


		/*$this->load->model('projetos_model');
		$this->load->model('utilizadores_model');
		$estados=$this->projetos_model->get_estados_ativos();
		$servicos=$this->projetos_model->get_servicos_ativos();
		$utilizadores=$this->utilizadores_model->utilizadores_ativos();*/

		$data = array('content' => 'servicos', 'scripts' => $this->scripts, /*'estados'=>$estados,'servicos'=>$servicos, 'users'=>$utilizadores*/);
		$this->load->view('includes/template', $data);
	}


	function estado()
	{


		$this->scripts = array(
			'page_level_plugins' => array(

				'<script src="' . plugins_url() . 'jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-validation/js/localization/messages_pt_PT.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'jquery.sparkline.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt.js" type="text/javascript"></script>',

				'<script src="' . scripts_url() . 'datatable.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/datatables.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>',

				'<script src="' . plugins_url() . 'moment.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>',
				'<script src="' . plugins_url() . 'jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>',


			),

			'page_level_scripts' => array(

				'<script src="' . scripts_url() . 'estados.js" type="text/javascript"></script>',


			)
		);


		/*$this->load->model('projetos_model');
		$this->load->model('utilizadores_model');
		$estados=$this->projetos_model->get_estados_ativos();
		$servicos=$this->projetos_model->get_servicos_ativos();
		$utilizadores=$this->utilizadores_model->utilizadores_ativos();*/

		$data = array('content' => 'estados', 'scripts' => $this->scripts, /*'estados'=>$estados,'servicos'=>$servicos, 'users'=>$utilizadores*/);
		$this->load->view('includes/template', $data);
	}
}

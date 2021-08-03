<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Artigos extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_logged_in') !== TRUE) {
			redirect('login');
		}
		$this->load->model('artigos_model');
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
				'<script src="' . scripts_url() . 'zonas.js" type="text/javascript"></script>',
				'<script src="' . scripts_url() . 'artigos.js" type="text/javascript"></script>',
			),
		);

		$familias = $this->artigos_model->get_familia_artigos(); 
		$data = array(
			'content' => 'artigos', 
			'familias' => $familias,
			'scripts' => $this->scripts
		);

		$this->load->view('includes/template', $data);
	}

	public function get_tabela_artigos()
	{

		$clientes = $this->artigos_model->make_tabela_artigos();
		$data = array();
		foreach ($clientes as $row) {
			$sub_array = array();
			$sub_array[] = $row->referencia;
			$sub_array[] = $row->artigo;
			$sub_array[] = $row->familia;
			$sub_array[] = $row->marca;
			$sub_array[] = $row->ano_fabrico;
			$sub_array[] = "<img src='./recourses/images/products/".$row->fotografia1."' width='100%' alt='".$row->artigo."'>";
			$sub_array[] = $row->detalhes;
			$sub_array[] = '<button onclick="editar_artigo(' . $row->id_artigo . ')" class="btn yellow-gold btn-outline"><i class="fa fa-edit"></i> Editar </button>
			<button onclick="apagar_artigo(' . $row->id_artigo . ')" class="btn red-thunderbird btn-outline"><i class="fa fa-times"></i> Apagar </button>';
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

	public function adicionarArtigo(){

		$foto1 = null;
		$foto2 = null;

		if (isset($_FILES['foto1']['name']) && $_FILES['foto1']['name'] != "") {

            /* definir isto  */
            $config['upload_path']          = './recourses/images/products';
            $config['allowed_types']        = 'jpg|png|gif|jpeg|tiff';
            $config['max_size']             = 9999;
            $config['max_width']            = 0;
            $config['max_height']           = 0;

            /* carregar a livraria */
            $this->load->library('upload', $config);
            $this->load->helper('file');

            if ($_FILES['foto1']['name'] != "") {


                $this->upload->do_upload('foto1');

                $foto1 = $this->upload->data('file_name');
                //verifica se existe data, se tem algo no data do upload
                $data = array('upload_data' => $this->upload->data());
            } else {
                $foto1 = 0;
            }
		}
		
		if (isset($_FILES['foto2']['name']) && $_FILES['foto2']['name'] != "") {

            // definir isto 
            $config['upload_path']          = './recourses/images/products';
            $config['allowed_types']        = 'jpg|png|gif|jpeg|tiff';
            $config['max_size']             = 9999;
            $config['max_width']            = 0;
            $config['max_height']           = 0;

            // carregar a livraria
            $this->load->library('upload', $config);
            $this->load->helper('file');

            if ($_FILES['foto2']['name'] != "") {


                $this->upload->do_upload('foto2');

                $foto2 = $this->upload->data('file_name');
                //verifica se existe data, se tem algo no data do upload
                $data = array('upload_data' => $this->upload->data());
            } else {
                $foto2 = 0;
            }
        }
		
		$artigo = $this->artigos_model->adicionarArtigo($_POST, $foto1, $foto2);
		echo json_encode($artigo);
	}

	public function get_artigo($id_artigo=null){

		$artigo = $this->artigos_model->get_artigo($id_artigo);
		echo json_encode($artigo);

	}

	public function editarArtigo(){

		$foto1 = null;
		$foto2 = null;

		if (isset($_FILES['foto1']['name']) && $_FILES['foto1']['name'] != "") {

			$fotoantiga1 = $this->artigos_model->fotoantiga1();

			if($fotoantiga1){
				@unlink("./recourses/images/products/".$fotoantiga1); 
			}

            /* definir isto  */
            $config['upload_path']          = './recourses/images/products';
            $config['allowed_types']        = 'jpg|png|gif|jpeg|tiff';
            $config['max_size']             = 9999;
            $config['max_width']            = 0;
            $config['max_height']           = 0;

            /* carregar a livraria */
            $this->load->library('upload', $config);
            $this->load->helper('file');

            if ($_FILES['foto1']['name'] != "") {


                $this->upload->do_upload('foto1');

                $foto1 = $this->upload->data('file_name');
                //verifica se existe data, se tem algo no data do upload
                $data = array('upload_data' => $this->upload->data());
            } else {
                $foto1 = 0;
            }
		}
		
		if (isset($_FILES['foto2']['name']) && $_FILES['foto2']['name'] != "") {

			$fotoantiga2 = $this->artigos_model->fotoantiga2();
			if($fotoantiga2){
				@unlink("./recourses/images/products/".$fotoantiga2); 
			}

            // definir isto 
            $config['upload_path']          = './recourses/images/products';
            $config['allowed_types']        = 'jpg|png|gif|jpeg|tiff';
            $config['max_size']             = 9999;
            $config['max_width']            = 3024;
            $config['max_height']           = 3024;

            // carregar a livraria
            $this->load->library('upload', $config);
            $this->load->helper('file');

            if ($_FILES['foto2']['name'] != "") {

                $this->upload->do_upload('foto2');
                $foto2 = $this->upload->data('file_name');
                //verifica se existe data, se tem algo no data do upload
                $data = array('upload_data' => $this->upload->data());
            } else {
                $foto2 = 0;
            }
        }

		$artigos = $this->artigos_model->editarArtigo($_POST, $foto1, $foto2);
		echo json_encode($artigos);
	}

	public function apagar_artigo(){
		$artigo = $this->artigos_model->apagarArtigo($_POST);
		echo json_encode($artigo);
	}

	/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */

	
	
}

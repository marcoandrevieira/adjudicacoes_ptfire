<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zonas extends CI_Controller {

	public function get_zona_by_parent(){
		$this->load->model('zonas_model');
		$zonas=$this->zonas_model->get_by_parent($this->input->get('parent'));
		echo json_encode($zonas);
		}
		
	}

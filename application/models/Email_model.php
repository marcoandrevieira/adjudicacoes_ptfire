<?php
class Email_model extends CI_Model {
	
	private $para=array();
	private $de;
	private $assunto;
	private $cc=array();
	private $bcc=array();
	
	private $cabecalho;
	private $rodape;
	private $html;
	
	function __construct(){


		$config['protocol'] = 'mail';
		$config['wordwrap'] = TRUE;
		$config['smtp_host'] = 'ssl://ptfire.com.pt';
		$config['charset'] = 'UTF-8';
		$config['smtp_port'] = '465';
		$config['smtp_user'] = 'noreply@ptfire.com.pt';
		$config['smtp_pass'] = 'Nb@8mb68';
		//fazer o load da livraria e enviar o config
		$this->load->library('email', $config);

		$this->email->set_newline("\r\n");
		$this->email->set_mailtype("html");
		$this->email->initialize($config);

		
		
		/* $this->email->message($observacoes);

		$this->email->send(); */

			
		/* $this->load->library('email');
		$config['bcc_batch_mode'] = TRUE;
		$config['protocol'] = 'smtp';
		//$config['smtp_host'] = 'ssl://smtp.gruposafety.pt'; //change this
		$config['smtp_host'] = 'ssl://adnconsulting.pt'; //change this
		//$config['smtp_port'] = '465';
		$config['smtp_port'] = '25';
    	$config['smtp_user'] = 'geral@safetymarket.pt'; //change this
    	$config['smtp_pass'] = 'SafMar@19'; //change this	
		$this->email->initialize($config);
	//	$this->email->initialize('email_noreply');
	//	$this->email->bcc_batch_mode(true);	
		
		$this->email->set_mailtype("html"); */
		
	}
	
	function configura($para=NULL, /*$de,*/ $assunto, $cc=NULL, $bcc=NULL){
		
		$this->para = $para;
		//$this->de = $de;
		$this->assunto = $assunto;
		$this->cc=$cc;
		$this->bcc=$bcc; 
		$this->cabecalho = $this->load->view('email/header', NULL, TRUE);
		$this->rodape = $this->load->view('email/footer', NULL, TRUE);
			
	
	}
			
	function estrutura($ficheiro, $data=NULL){ // RELATÒRIO DA MANUTENCAO PARA O CLIENTE
		$this->html.=$this->cabecalho;
		$this->html.=$this->load->view('email/'.$ficheiro, $data, TRUE);
		$this->html.=$this->rodape;
	}				
			
	function envia(){
		
		$this->email->from('noreply@ptfire.com.pt', 'PTFIRE');
		if(!empty($this->para)){
			$this->email->to($this->para);
		}
		if(!empty($this->cc)){
			$this->email->cc($this->cc);
		}
		if(!empty($this->bcc)){
			$this->email->bcc($this->bcc);
		}
		$this->email->subject($this->assunto);
		$this->email->message($this->html);
		$this->email->send();
		/*echo $this->email->print_debugger(array('headers'));
		if(!$this->email->send()){
			
			//echo 'ERRO';	
			echo $this->para.'<br>';
			echo $this->assunto.'<br>';
			echo $this->html.'<br>';
		}*/
		
			
	}			

}

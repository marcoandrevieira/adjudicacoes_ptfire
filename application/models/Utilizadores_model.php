<?php
class utilizadores_model extends CI_Model {
	
	function tipo_utilizadores_ativos(){
		//$this->db->where('apagado', 0);
		//$this->db->order_by('nome', 'ASC');
		//$query=$this->db->get('utilizadores');
		$sql="
			SELECT * FROM tipo_utilizador
			WHERE ativo=1;
		";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				
				$tipo_utilizadores[] = array('id_tipo_utilizador'=>$row->id_tipo_utilizador, 'tipo'=>$row->tipo, 'master'=>$row->master, 'ativo'=>$row->ativo);
				
				}
				
				return $tipo_utilizadores;
		}else{
			return false;	
		}
		
		
	}

	function verify_email($email, $id_utilizador=NULL){
		$this->db->select('id_utilizador, email');
		$this->db->where('email', $email);
		$this->db->where('apagado', 0);

		$query = $this->db->get('utilizadores');
		$utilizadores = $query->result();
		//print_r($utilizadores);
		if($query->num_rows()==0 || ($utilizadores[0]->id_utilizador==$id_utilizador && $utilizadores[0]->email==$email)){
			return true;
			}else{
				return false;
				}
		}

	function todos_utilizadores(){
		//$this->db->where('apagado', 0);
		//$this->db->order_by('nome', 'ASC');
		//$query=$this->db->get('utilizadores');
		$sql="
			SELECT u.*, tu.tipo
			FROM `utilizadores` AS u
			INNER JOIN tipo_utilizador AS tu ON u.id_tipo=tu.id_tipo_utilizador
			WHERE `apagado` = 0
			ORDER BY `nome` ASC
		";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				
				$utilizadores[] = array('id_utilizador'=>$row->id_utilizador, 'id_tipo'=>$row->id_tipo,'email'=>$row->email, 'nome'=>$row->nome, 'tipo'=>$row->tipo, 'ativo'=>$row->ativo);
				
				}
				
				return $utilizadores;
		}else{
			return false;	
		}
		
		
	}
	function utilizadores_ativos(){
		//$this->db->where('apagado', 0);
		//$this->db->order_by('nome', 'ASC');
		//$query=$this->db->get('utilizadores');
		$sql="
			SELECT u.*, tu.tipo
			FROM `utilizadores` AS u
			INNER JOIN tipo_utilizador AS tu ON u.id_tipo=tu.id_tipo_utilizador
			WHERE apagado=0 AND u.ativo=1
			ORDER BY `nome` ASC
		";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				
				$utilizadores[] = array('id_utilizador'=>$row->id_utilizador, 'id_tipo'=>$row->id_tipo,'email'=>$row->email, 'nome'=>$row->nome, 'tipo'=>$row->tipo, 'ativo'=>$row->ativo);
				
				}
				
				return $utilizadores;
		}else{
			return false;	
		}
		
		
	}
	function utilizador_id($id){
		$this->db->where('id_utilizador', $id);
		$query=$this->db->get('utilizadores');
		//print_r($query);
		//echo($this->db->last_query());
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				
				$utilizador=array('id_utilizador'=>$row->id_utilizador, 'id_tipo'=>$row->id_tipo,'email'=>$row->email, 'nome'=>$row->nome,  'ativo'=>$row->ativo);
				
			}
				
			return $utilizador;
		}else{
			
			return false;	
		}
		
	
		}		
	function muda_estado($id, $estado){
	
		//$this->db->where('id_categorias_perguntas', $id);
		//$query=$this->db->delete('categorias_perguntas');	
		
		$data = array(
               'ativo' => $estado,
              );

			$this->db->where('id_utilizador', $id);
			$query=$this->db->update('utilizadores', $data); 
		
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	function remove_utilizador($id){
		$data = array(
			'apagado' => '1',
		   );

		$this->db->where('id_utilizador', $id);
		$query=$this->db->update('utilizadores',$data); 
		
		if($query){
			return true;
		}else{
			return false;
		}
	}

	function novo_utilizador($post){
		
		$data = array(
				'id_utilizador'=>'NULL',	
				'id_tipo'=>$post['tipo_utilizador'],
				'email'=>$post['email'],
				'nome'=>$post['nome'],
				'password'=>md5($post['password']),
				'ativo'=>$post['ativo'],
				'apagado'=>'0',
			);
		
		$query=$this->db->insert('utilizadores', $data);
		
		if($query){
			return true;
		}else{
			return false;		
		}
	}


	function edita_utilizador($post,$id_utilizador){
		
		$data = array(
				
				'id_tipo'=>$post['tipo_utilizador'],
				'email'=>$post['email'],
				'nome'=>$post['nome'],
		);
			
		
		if(!empty($post['password'])){
			$data['password']=md5($post['password']);
		}
		$data['ativo']=	$post['ativo'];
		//print_r($data);
		
		$this->db->where('id_utilizador', $id_utilizador);
		$query=$this->db->update('utilizadores', $data); 
		if($query){
			return true;
		}else{
			return false;		
		}
	}



}

?>
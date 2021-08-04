<?php
class estados_model extends CI_Model {
	
	function get_estados_table(){ // DATATABLES
		
		$sIndexColumn='id_estado';
		$aColumns = array('id_estado','estado','cor','ordem', 'ativo','apagado');
		// AJAX TABLE CLIENTES ->CLIENTES
		
		
		/* 
		 * Paging
		 */
		//FILTRA POR BD QUANDO NÂO EXISTE UM FAMILIA SELECIONADA
		$sLimit = "";
		if ( isset( $_GET['start'] ) && $_GET['length'] != '-1')
		{
			$sLimit = "LIMIT ".$_GET['start'].", ".
				 $_GET['length'];
		}
		
		
		/*
		 * Ordering
		 */
		// $_GET['columns']
		$sOrder = "";
		if ( isset( $_GET['order'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['order'] ) ; $i++ )
			{
				if ( $_GET['columns'][$_GET['order'][$i]['column']]['orderable'] == "true" )
				{
					$sOrder .=  $_GET['columns'][$_GET['order'][$i]['column']]['name']."
						".$_GET['order'][$i]['dir'] .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "";
		if ( !empty($_GET['search']['value']) )
		{
			$sWhere = "HAVING (";
			for ( $i=0 ; $i<=count($_GET['columns']) ; $i++ )
			{
				//echo $aColumns[$i];
				if(!empty($_GET['columns'][$i]['name'])){	
					$sWhere .= $_GET['columns'][$i]['name']." LIKE '%".$_GET['search']['value']."%' OR ";
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		//$ids_armazem=$this->armazem_model->listagem_armazem_ids();
		//$ids_armazem[]=$this->session->id_armazem;
		
		

		$sWhere= "WHERE apagado=0";

			/*if(!empty($_GET['concluido'])){


				if( $_GET['concluido']==="aberto"){
					$sWhere .=" AND concluido ='0'";
				}else if($_GET['concluido']==="concluido"){

				
					$sWhere .=" AND concluido='1'";
				}
				
			}
			*/
			if(!empty($_GET['estado'])  && !empty($_GET['estado'][0])){
				$sWhere .=" AND estado LIKE '%".$_GET['estado']."%' ";

			}
			if(!empty($_GET['cor'])  && !empty($_GET['cor'][0])){
				$sWhere .=" AND cor LIKE '%".$_GET['cor']."%' ";

			}
			if(!empty($_GET['ordem'])  && !empty($_GET['ordem'][0])){
				$sWhere .=" AND ordem LIKE '%".$_GET['ordem']."%' ";

			}
/*
			if(!empty($_GET['tipo'])  && !empty($_GET['tipo'][0])){
				$sWhere .=" AND p.id_tipo='".$_GET['tipo']."'";

			}

			if(!empty($_GET['cliente']) && !empty($_GET['cliente'][0])){
			
				$sWhere.=" AND p.cliente LIKE '%".$_GET['cliente']."%' ";
			}
			if(!empty($_GET['projeto']) && !empty($_GET['projeto'][0])){
			
				$sWhere.=" AND p.projeto LIKE '%".$_GET['projeto']."%' ";
			}

			if(!empty($_GET['data_inicio']) && !empty($_GET['data_inicio'][0])){
			
				$sWhere.=" AND p.data_inicio LIKE '%".$_GET['data_inicio']."%' ";
			}
			if(!empty($_GET['data_concluido']) && !empty($_GET['data_concluido'][0])){
			
				$sWhere.=" AND p.data_concluido LIKE '%".$_GET['data_concluido']."%' ";
			}

			if(!empty($_GET['criado_por']) && !empty($_GET['criado_por'][0])){
			
				$sWhere.=" AND p.criado_por IN (".implode(',',$_GET['criado_por']).") ";
			}
			*/
			if(!empty($_GET['ativo'])){
				if($_GET['ativo']==='ativo'){
					$sWhere.=" AND ativo='1' ";
				}else if($_GET['ativo']==='inativo'){
					$sWhere.=" AND ativo='0' ";
				}
				
				
			}
		$sHaving='';
		
		
		
		 
		$query = $this->db->query( "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM estado
			$sWhere
			$sOrder
			$sLimit
		");
		//echo $this->db->last_query();
		//echo $this->db->last_query();
		//$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		
		/* Data set length after filtering */
		$sQuery = $this->db->query( "
			SELECT FOUND_ROWS() AS total
			
		");
		
		//echo $this->db->last_query();
		
		//$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		//$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
		$aResultFilterTotal = $sQuery->result_array();
		$iFilteredTotal = $aResultFilterTotal[0]['total'];
		
		/* Total data set length */
		$sQuery=$this->db->query( "
			SELECT COUNT(".$sIndexColumn.") AS total
			FROM estado
			WHERE apagado=0
			
		");
		//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		$aResultTotal = $sQuery->result_array();
		//print_r($aResultTotal);
		$iTotal = $aResultTotal[0]['total'];
		
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['draw']),
			"iTotalRecords" =>$iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		
		
		if($query->num_rows()>0){
			
			
			foreach($query->result() as $row){
				
				$output['aaData'][]=array('id_estado'=>$row->id_estado, 'estado'=>$row->estado, 'cor'=>$row->cor, 'ordem'=>$row->ordem,'ativo'=>$row->ativo);
			} 
		
		
			
		

		return $output;
		}
		
	
		
		
	}


	function novo_estado($post){
		$this->load->helper('data_helper');
		$data = array(
			'id_estado'=>'NULL',	
			'estado'=>$post['estado'],
			'cor'=>$post['cor'],
			'ordem'=>$post['ordem'],
			'ativo'=>$post['ativo'],
			'apagado'=>'0',
			
			
		);
	
		$query=$this->db->insert('estado', $data);
		
		if($query){
			return true;
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

			$this->db->where('id_estado', $id);
			$query=$this->db->update('estado', $data); 
		
		if($query){
			return true;
		}else{
			return false;
		}
	}

	function estado_id($id){
		$this->db->where('id_estado', $id);
		$query=$this->db->get('estado');
		
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				
				$projeto=array('id_estado'=>$row->id_estado, 'estado'=>$row->estado, 'cor'=>$row->cor, 'ordem'=>$row->ordem, 'ativo'=>$row->ativo);
				
			}
				
			return $projeto;
		}else{
			
			return false;	
		}
	}

	function edita_estado($id_estado,$post){
		
		$data = array(
			'estado'=>$post['estado'],
			'cor'=>$post['cor'],
			'ordem'=>$post['ordem'],
			'ativo'=>$post['ativo'],
		);
		$this->db->where('id_estado', $id_estado);
		$query=$this->db->update('estado', $data);
		
		if($query){
			
			return true;
		
		}else{
			
			return false;		
			
		}

	}

	
	function remove_estado($id_estado){
		$this->load->helper('data_helper');
		$data = array(
			
			'apagado'=>'1',
		);
		$this->db->where('id_estado', $id_estado);
		$query=$this->db->update('estado', $data);
		
		if($query){
			
			return true;
		
		}else{
			
			return false;		
			
		}

	}
	

	

}

?>

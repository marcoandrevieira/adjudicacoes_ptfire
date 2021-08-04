<?php
class servicos_model extends CI_Model {
	
	function get_servicos_table(){ // DATATABLES
		
		$sIndexColumn='id_tipo_servico';
		$aColumns = array('id_tipo_servico','tipo','cor','ordem', 'apagado','ativo');
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

		if(!empty($_GET['tipo'])  && !empty($_GET['tipo'][0])){
			$sWhere .=" AND tipo LIKE '%".$_GET['tipo']."%' ";

		}
		if(!empty($_GET['cor'])  && !empty($_GET['cor'][0])){
			$sWhere .=" AND cor LIKE '%".$_GET['cor']."%' ";

		}
		if(!empty($_GET['ordem'])  && !empty($_GET['ordem'][0])){
			$sWhere .=" AND ordem LIKE '%".$_GET['ordem']."%' ";

		}
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
			FROM tipo_servico
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
			FROM tipo_servico
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
				
				$output['aaData'][]=array('id_tipo_servico'=>$row->id_tipo_servico, 'tipo'=>$row->tipo, 'cor'=>$row->cor, 'ordem'=>$row->ordem,'ativo'=>$row->ativo);
			} 
		
		
			
		

		return $output;
		}
		
	
		
		
	}


	function novo_servico($post){
		$this->load->helper('data_helper');
		$data = array(
			'id_tipo_servico'=>'NULL',	
			'tipo'=>$post['tipo'],
			'cor'=>$post['cor'],
			'ordem'=>$post['ordem'],
			'apagado'=>'0',
			'ativo'=>$post['ativo'],
			
		);
		$query=$this->db->insert('tipo_servico', $data);
		
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

			$this->db->where('id_tipo_servico', $id);
			$query=$this->db->update('tipo_servico', $data); 
		
		if($query){
			return true;
		}else{
			return false;
		}
	}

	function servico_id($id){
		$this->db->where('id_tipo_servico', $id);
		$query=$this->db->get('tipo_servico');
		
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				
				$projeto=array('id_tipo_servico'=>$row->id_tipo_servico, 'tipo'=>$row->tipo, 'cor'=>$row->cor, 'ordem'=>$row->ordem, 'ativo'=>$row->ativo);
				
			}
				
			return $projeto;
		}else{
			
			return false;	
		}
	}

	function edita_servico($id_servico,$post){
		$this->load->helper('data_helper');
		$data = array(
			
			'tipo'=>$post['tipo'],
			'cor'=>$post['cor'],
			'ordem'=>$post['ordem'],
			'ativo'=>$post['ativo'],
		);
		$this->db->where('id_tipo_servico', $id_servico);
		$query=$this->db->update('tipo_servico', $data);
		
		if($query){
			
			return true;
		
		}else{
			
			return false;		
			
		}

	}

	
	function remove_servico($id_servico){
		$this->load->helper('data_helper');
		$data = array(
			
			'apagado'=>'1',
		);
		$this->db->where('id_tipo_servico', $id_servico);
		$query=$this->db->update('tipo_servico', $data);
		
		if($query){
			
			return true;
		
		}else{
			
			return false;		
			
		}

	}
	

	

}

?>

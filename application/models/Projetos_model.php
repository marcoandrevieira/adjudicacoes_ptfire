<?php
class projetos_model extends CI_Model {
	
	function get_projetos_table(){ // DATATABLES
		
		$sIndexColumn='p.id_projeto';
		$aColumns = array('p.*', 'ts.tipo, ts.cor AS cor_tipo','e.estado', 'e.cor AS cor_estado', 'u.nome');
		// AJAX TABLE CLIENTES ->CLIENTES
		
		
		/* 
		 * Paging
		 */
		//FILTRA POR BD QUANDO NÂO EXISTE UM FAMILIA SELECIONADA
		$sLimit = "";
		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1')
		{
			$sLimit = "LIMIT ".$_POST['start'].", ".
				 $_POST['length'];
		}
		
		
		/*
		 * Ordering
		 */
		// $_POST['columns']
		$sOrder = "";
		if ( isset( $_POST['order'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_POST['order'] ) ; $i++ )
			{
				if ( $_POST['columns'][$_POST['order'][$i]['column']]['orderable'] == "true" )
				{
					$sOrder .=  $_POST['columns'][$_POST['order'][$i]['column']]['name']."
						".$_POST['order'][$i]['dir'] .", ";
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
		if ( !empty($_POST['search']['value']) )
		{
			$sWhere = "HAVING (";
			for ( $i=0 ; $i<=count($_POST['columns']) ; $i++ )
			{
				//echo $aColumns[$i];
				if(!empty($_POST['columns'][$i]['name'])){	
					$sWhere .= $_POST['columns'][$i]['name']." LIKE '%".$_POST['search']['value']."%' OR ";
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		//$ids_armazem=$this->armazem_model->listagem_armazem_ids();
		//$ids_armazem[]=$this->session->id_armazem;
		
		

		$sWhere= "WHERE p.apagado=0";

			if(!empty($_POST['concluido'])){


				if( $_POST['concluido']==="aberto"){
					$sWhere .=" AND concluido ='0'";
				}else if($_POST['concluido']==="concluido"){

				
					$sWhere .=" AND concluido='1'";
				}
				
			}
			
			if(!empty($_POST['estado'])  && !empty($_POST['estado'][0])){
				$sWhere .=" AND p.id_estado IN (" . implode(',', $_POST['estado']).")";

			}

			if(!empty($_POST['tipo'])  && !empty($_POST['tipo'][0])){
				$sWhere .=" AND p.id_tipo IN (" . implode(',', $_POST['tipo']).")";

			}

			if(!empty($_POST['cliente']) && !empty($_POST['cliente'][0])){
			
				$sWhere.=" AND p.cliente LIKE '%".$_POST['cliente']."%' ";
			}
			if(!empty($_POST['instalacao']) && !empty($_POST['instalacao'][0])){
			
				$sWhere.=" AND p.instalacao LIKE '%".$_POST['instalacao']."%' ";
			}
			if(!empty($_POST['projeto']) && !empty($_POST['projeto'][0])){
			
				$sWhere.=" AND p.projeto LIKE '%".$_POST['projeto']."%' ";
			}

			if(!empty($_POST['data_inicio']) && !empty($_POST['data_inicio'][0])){
			
				$sWhere.=" AND p.data_inicio LIKE '%".$_POST['data_inicio']."%' ";
			}
			if(!empty($_POST['data_conclusao']) && !empty($_POST['data_conclusao'][0])){
			
				$sWhere.=" AND p.data_conclusao LIKE '%".$_POST['data_conclusao']."%' ";
			}
			if(!empty($_POST['data_concluido']) && !empty($_POST['data_concluido'][0])){
			
				$sWhere.=" AND p.data_concluido LIKE '%".$_POST['data_concluido']."%' ";
			}
			if(!empty($_POST['valor_fatura']) && !empty($_POST['valor_fatura'][0])){
			
				$sWhere.=" AND p.valor_fatura LIKE '%".$_POST['valor_fatura']."%' ";
			}

			if(!empty($_POST['criado_por']) && !empty($_POST['criado_por'][0])){
			
				$sWhere.=" AND p.criado_por IN (".implode(',',$_POST['criado_por']).") OR p.criado_por IS NULL  ";
			}
			if(!empty($_POST['ativo'])){
				if($_POST['ativo']==='ativo'){
					$sWhere.=" AND p.ativo='1' ";
				}else if($_POST['ativo']==='inativo'){
					$sWhere.=" AND p.ativo='0' ";
				}
				
				
			}
		$sHaving='';
		
		$sql="
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM projeto AS p
		INNER JOIN tipo_servico AS ts ON p.id_tipo=ts.id_tipo_servico
		INNER JOIN estado AS e ON p.id_estado=e.id_estado
		LEFT JOIN utilizadores AS u ON p.criado_por=u.id_utilizador
		$sWhere
		$sOrder
		$sLimit
	";
		//echo $sql;
		$query = $this->db->query($sql);


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
			FROM projeto AS p
			INNER JOIN tipo_servico AS ts ON p.id_tipo=ts.id_tipo_servico
			INNER JOIN estado AS e ON p.id_estado=e.id_estado
			INNER JOIN utilizadores AS u ON p.criado_por=u.id_utilizador
			WHERE p.apagado=0
			
		");
		//$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		$aResultTotal = $sQuery->result_array();
		//print_r($aResultTotal);
		$iTotal = $aResultTotal[0]['total'];
		
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_POST['draw']),
			"iTotalRecords" =>$iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		

		
		if($query->num_rows()>0){
		
			foreach($query->result() as $row){
				
				$output['aaData'][]=array(
					'id_projeto'=>$row->id_projeto, 
					'projeto'=>$row->projeto, 
					'total'=>$row->total, 
					'cliente'=>$row->cliente, 
					'instalacao'=>$row->instalacao, 
					'id_instalacao'=>$row->id_instalacao, 
					'data_inicio'=>$row->data_inicio, 
					'data_conclusao'=>$row->data_conclusao, 
					'data_concluido'=>$row->data_concluido, 
					'concluido'=>$row->concluido, 
					'tipo'=>$row->tipo, 
					'valor_fatura'=>$row->valor_fatura, 
					'criado_por'=>$row->nome, 
					'cor_tipo'=>$row->cor_tipo, 
					'estado'=>$row->estado, 
					'cor_estado'=>$row->cor_estado, 
					'ativo'=>$row->ativo
				);
			} 
		
		
			
		

		return $output;
		}
		
	
		
		
	}

	function get_monitores_table(){ // DATATABLES
		
		$sIndexColumn='p.id_projeto';
		$aColumns = array('p.*', 'ts.tipo, ts.cor AS cor_tipo','e.estado', 'e.cor AS cor_estado', 'u.nome');
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
		
		$data=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( date("Y-m-d")) ) ));
		//echo $data;
		$sWhere= "WHERE p.apagado=0 AND (p.data_concluido>'".$data."' OR p.data_concluido IS NULL)";

		if(!empty($_GET['id_estado'])  && !empty($_GET['id_estado'][0])){
			$sWhere .=" AND p.id_estado='".$_GET['id_estado']."'";

		}
		if(!empty($_GET['id_tipo'])  && !empty($_GET['id_tipo'][0])){
			$sWhere .=" AND p.id_tipo='".$_GET['id_tipo']."'";

		}
		
		$sHaving='';
		
		
		$query = $this->db->query( "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM projeto AS p
			INNER JOIN tipo_servico AS ts ON p.id_tipo=ts.id_tipo_servico
			INNER JOIN estado AS e ON p.id_estado=e.id_estado
			INNER JOIN utilizadores AS u ON p.criado_por=u.id_utilizador
			$sWhere
			$sOrder
			$sLimit
		");
		
	
		$sQuery = $this->db->query( "
			SELECT FOUND_ROWS() AS total
			
		");
	
		$aResultFilterTotal = $sQuery->result_array();
		$iFilteredTotal = $aResultFilterTotal[0]['total'];
		
		/* Total data set length */
		$sQuery=$this->db->query( "
			SELECT COUNT(".$sIndexColumn.") AS total
			FROM projeto AS p
			INNER JOIN tipo_servico AS ts ON p.id_tipo=ts.id_tipo_servico
			INNER JOIN estado AS e ON p.id_estado=e.id_estado
			INNER JOIN utilizadores AS u ON p.criado_por=u.id_utilizador
			WHERE p.apagado=0
			
		");

		$aResultTotal = $sQuery->result_array();
		$iTotal = $aResultTotal[0]['total'];
		
	
		$output = array(
			"sEcho" => intval($_GET['draw']),
			"iTotalRecords" =>$iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		
		if($query->num_rows()>0){
			
			foreach($query->result() as $row){
				
				$output['aaData'][]=array('id_projeto'=>$row->id_projeto, 'projeto'=>$row->projeto, 'cliente'=>$row->cliente, 'instalacao'=>$row->instalacao, 'total'=>$row->total, 'data_inicio'=>$row->data_inicio, 'data_conclusao'=>$row->data_conclusao,  'data_concluido'=>$row->data_concluido, 'concluido'=>$row->concluido, 'tipo'=>$row->tipo, 'criado_por'=>$row->nome, 'cor_tipo'=>$row->cor_tipo, 'estado'=>$row->estado, 'cor_estado'=>$row->cor_estado, 'ativo'=>$row->ativo);
			} 

		return $output;
		}
		
	
		
		
	}

	function novo_projeto($post)
	{
		$this->load->helper('data_helper');
		$data = array(
			'id_projeto' => 'NULL',
			'id_tipo' => $post['tipo'],
			'id_estado' => $post['estado'],
			'id_cliente' => $post['cliente'],
			'id_instalacao' => $post['instalacao'],
			'cliente' => $post['nome_cliente'],
			'instalacao' => $post['nome_instalacao'],
			'projeto' => $post['projeto'],
			'total' => $post['total'],
			'obs' => !empty($post['obs']) ? $post['obs'] : NULL,
			'data_inicio' => data(),
			'data_concluido' => NULL,
			'concluido' => '0',
			'criado_por' => $this->session->userdata('id_utilizador'),
			'ativo' => $post['ativo'],
			'apagado' => '0',
		);

		$query = $this->db->insert('projeto', $data);
		$insert_id = $this->db->insert_id();

		if ($query) {

			/* ============================================================================================================================================== */
			$dados_insert = [

				'id_tipo' => $post['tipo'],
				'id_estado' => $post['estado'],
				'id_projeto' => $insert_id,
				'id_cliente' => $post['cliente'],
				'id_instalacao' => $post['instalacao'],
				'cliente' => $post['nome_cliente'],
				'instalacao' => $post['nome_instalacao'],
				'projeto' => $post['projeto'],
				'total' => $post['total'],
				'obs' => !empty($post['obs']) ? $post['obs'] : NULL,
				'ativo' => $post['ativo'],
				'id_utilizador' => $_SESSION['id_utilizador']
			];

			$this->db->insert('historico_projeto', $dados_insert);
			/* ============================================================================================================================================== */

			return true;
		} else {
			return false;
		}
	}

	function muda_estado($id, $estado){
	
		//$this->db->where('id_categorias_perguntas', $id);
		//$query=$this->db->delete('categorias_perguntas');	
		
		$data = array(
               'ativo' => $estado,
              );

			$this->db->where('id_projeto', $id);
			$query=$this->db->update('projeto', $data); 
		
		if($query){
			return true;
		}else{
			return false;
		}
	}

	function projeto_id($id){
		$this->db->where('id_projeto', $id);
		$query=$this->db->get('projeto');
		
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				
				$projeto=array(
					'id_projeto'=>$row->id_projeto, 
					'id_tipo'=>$row->id_tipo, 
					'id_estado'=>$row->id_estado, 
					'cliente'=>$row->cliente, 
					'instalacao'=>$row->instalacao, 
					'projeto'=>$row->projeto,
					'total'=>$row->total, 
					'obs'=>$row->obs, 
					'concluido'=>$row->concluido, 
					'ativo'=>$row->ativo,
					'id_cliente' =>$row->id_cliente,
					'id_instalacao'=>$row->id_instalacao
				);
				
			}
				
			return $projeto;
		}else{
			
			return false;	
		}
	}

	function edita_projeto($id_projeto, $post)
	{

		$this->load->helper('data_helper');
		/* ============================================================================================================================================== */

		if (isset($post['data_planeado'])) {

			$data = array(

				'id_tipo' => $post['tipo'],
				'id_estado' => $post['estado'],
				'id_cliente' => $post['id_cliente'],
				'cliente' => $post['nome_cliente'],
				'id_instalacao' => $post['id_instalacao'],
				'instalacao' => $post['nome_instalacao'],
				'data_conclusao' => $post['data_planeado'],
				'projeto' => $post['projeto'],
				'total' => $post['total'],
				'obs' => !empty($post['obs']) ? $post['obs'] : NULL,
				'ativo' => $post['ativo'],
			);
		} else if (isset($post['data_faturacao']) && isset($post['valor_fatura'])) {

			$data = array(

				'id_tipo' => $post['tipo'],
				'id_estado' => $post['estado'],
				'id_cliente' => $post['id_cliente'],
				'cliente' => $post['nome_cliente'],
				'id_instalacao' => $post['id_instalacao'],
				'instalacao' => $post['nome_instalacao'],
				'data_concluido' => $post['data_faturacao'],
				'valor_fatura' => $post['valor_fatura'],
				'projeto' => $post['projeto'],
				'total' => $post['total'],
				'obs' => !empty($post['obs']) ? $post['obs'] : NULL,
				'ativo' => $post['ativo'],
			);
		} else {
			$data = array(

				'id_tipo' => $post['tipo'],
				'id_estado' => $post['estado'],
				'id_cliente' => $post['id_cliente'],
				'cliente' => $post['nome_cliente'],
				'id_instalacao' => $post['id_instalacao'],
				'instalacao' => $post['nome_instalacao'],
				'projeto' => $post['projeto'],
				'total' => $post['total'],
				'obs' => !empty($post['obs']) ? $post['obs'] : NULL,
				'ativo' => $post['ativo'],
			);
		}


		/* ============================================================================================================================================== */


		$this->db->where('id_projeto', $id_projeto);
		$query = $this->db->update('projeto', $data);

		if ($query) {

			/* ============================================================================================================================================== */
			$dados_insert = [

				'id_tipo' => $post['tipo'],
				'id_estado' => $post['estado'],
				'id_projeto' => $id_projeto,
				'id_cliente' => $post['id_cliente'],
				'cliente' => $post['nome_cliente'],
				'id_instalacao' => $post['id_instalacao'],
				'instalacao' => $post['nome_instalacao'],
				'projeto' => $post['projeto'],
				'total' => $post['total'],
				'valor_fatura' => isset($post['valor_fatura']) ? $post['valor_fatura'] : NULL,
				'obs' => !empty($post['obs']) ? $post['obs'] : NULL,
				'ativo' => $post['ativo'],
				'id_utilizador' => $_SESSION['id_utilizador']
			];

			$this->db->insert('historico_projeto', $dados_insert);
			/* ============================================================================================================================================== */

			return true;
		} else {

			return false;
		}
	}

	function concluir_projeto($id_projeto,$post){
		$this->load->helper('data_helper');
		if (isset($post['concluido'])) {
			$data = array(
				'data_concluido' => data(),
				'concluido' => '1',
			);
		} else {
			$data = array(
				'data_concluido' => data(),
				'concluido' => '0',
			);
		}

		$this->db->where('id_projeto', $id_projeto);
		$query = $this->db->update('projeto', $data);

		$dados_projeto = $this->db->from('projeto')
			->where('id_projeto', $id_projeto)
			->get()->result_array()[0];

		$dados_historico = [
			'id_projeto' => $id_projeto,
			'cliente' => $dados_projeto['cliente'],
			'id_cliente' => $dados_projeto['id_cliente'],
			'instalacao' => $dados_projeto['instalacao'],
			'id_instalacao' => $dados_projeto['id_instalacao'],
			'projeto' => $dados_projeto['projeto'],
			'total' => $dados_projeto['total'],
			'obs' => $dados_projeto['obs'],
			'concluido' => $data['concluido'],
			'ativo' => 1,
			'apagado' => 0,
			'id_utilizador' => $_SESSION['id_utilizador']
		];

		$this->db->insert('historico_projeto', $dados_historico);


		if ($query) {
			return true;
		} else {

			return false;
		}

	}
	function remove_projeto($id_projeto){
		$dados_projeto = $this->db->from('projeto')
			->where('id_projeto', $id_projeto)
			->get()->result_array()[0];

		$dados_historico = [
			'id_projeto' => $id_projeto,
			'cliente' => $dados_projeto['cliente'],
			'id_cliente' => $dados_projeto['id_cliente'],
			'id_instalacao' => $dados_projeto['id_indtalacao'],
			'instalacao' => $dados_projeto['indtalacao'],
			'projeto' => $dados_projeto['projeto'],
			'total' => $dados_projeto['total'],
			'obs' => $dados_projeto['obs'],
			'ativo' => 1,
			'apagado' => 1,
			'id_utilizador' => $_SESSION['id_utilizador']
		];

		$this->db->insert('historico_projeto', $dados_historico);

		$this->load->helper('data_helper');
		$data = array(

			'apagado' => '1',
		);
		$this->db->where('id_projeto', $id_projeto);
		$query = $this->db->update('projeto', $data);

		if ($query) {

			return true;
		} else {

			return false;
		}

	}
	function get_estados_ativos(){
		$sql="
			SELECT *
			FROM estado
			WHERE ativo = 1 AND apagado = 0
			ORDER BY ordem ASC
		";
		$query=$this->db->query($sql);
		
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$estados[] = array('id_estado'=>$row->id_estado, 'estado'=>$row->estado,'cor'=>$row->cor);
			}
			return $estados;
		}else{
				return false;	
		}
	}

	function get_servicos_ativos(){
		$sql="
			SELECT *
			FROM tipo_servico
			WHERE ativo = 1 AND apagado=0
			ORDER BY ordem ASC
		";
		$query=$this->db->query($sql);
		
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$servicos[] = array('id_tipo_servico'=>$row->id_tipo_servico, 'tipo'=>$row->tipo,'cor'=>$row->cor);
			}
			return $servicos;
		}else{
				return false;	
		}
	}
	
	public function get_historico()
	{
		return $this->db->select('historico_projeto.id_projeto, historico_projeto.id_tipo, historico_projeto.id_estado, historico_projeto.cliente, historico_projeto.instalacao, historico_projeto.projeto, historico_projeto.total, historico_projeto.obs, historico_projeto.data_insercao, historico_projeto.valor_fatura, historico_projeto.ativo, historico_projeto.id_utilizador, projeto.cliente, estado.estado, tipo_servico.tipo, utilizadores.nome')
			->from('historico_projeto')
			->join('projeto', 'historico_projeto.id_projeto = projeto.id_projeto')
			->join('estado', 'historico_projeto.id_estado = estado.id_estado')
			->join('tipo_servico', 'historico_projeto.id_tipo = tipo_servico.id_tipo_servico')
			->join('utilizadores', 'historico_projeto.id_utilizador = utilizadores.id_utilizador')
			->where('historico_projeto.id_projeto', $_POST['id_projeto'])
			->order_by('historico_projeto.id_projeto', 'DESC')
			->get()->result_array();
	}

}

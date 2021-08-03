<?php
class Zonas_model extends CI_Model {
	
	function destritos(){
		
		$this->db->where('parent_id','0');
		$this->db->order_by('zona', 'ASC');
		$query = $this->db->get('zonas');
		
		if($query->num_rows()>0){
			//echo "LOOOL";
			//print_r($query->result());
			return($query->result());
			//return $query->row_array();
			/*foreach ($query->result() as $linha){
				$data[] = $linha;
				}
				//print_r($data);*/
			//return $data;
			
			}
		
		}
	
	function get_by_parent($parent){
		
		$this->db->where('parent_id',$parent);
		$this->db->order_by('zona', 'ASC');
		$query = $this->db->get('zonas');
		
		if($query->num_rows()>0){
		
			return($query->result());
			
			
			}
		
		}
	 function seleciona_por_zona($id){
		
		$this->db->where('id_zona',$id);
		$this->db->order_by('zona', 'ASC');
		$query = $this->db->get('zonas');
		
		if($query->num_rows()>0){
		
			foreach ($query->result() as $row)
			{
        		$zonas=array('id_zona'=>$row->id_zona, 'parent_id'=>$row->parent_id, 'zona'=>$row->zona);
			}
		return $zonas;	

		}
		
		
	}
	
	function seleciona_por_freguesia($ids){
		$sql = "SELECT *, f.zona AS freguesia, f.parent_id AS id_concelho, f.id_zona AS id_freguesia, c.zona AS concelho, c.parent_id AS id_destrito, c.id_zona, d.zona AS destrito, d.parent_id, d.id_zona
		
		FROM zonas f
		
			LEFT JOIN zonas c ON f.parent_id = c.id_zona
			LEFT JOIN zonas d ON c.parent_id = d.id_zona
		
		WHERE f.id_zona IN ";
		
		$sql.= "('".implode("','",array_values($ids))."')";
		
		$query = $this->db->query($sql);
		
		//echo $sql;
		
		if($query->num_rows()>0){
		
			foreach ($query->result() as $row)
			{
				$zonas[$row->id_freguesia]=array('id_freguesia'=>$row->id_freguesia, 'id_concelho'=>$row->id_concelho, 'id_destrito'=>$row->id_destrito, 'freguesia'=>$row->freguesia, 'concelho'=>$row->concelho, 'destrito'=>$row->destrito);
				
			}
				return $zonas;
			
		}else{
			
			return false;	
		}
	}
	
}
?>
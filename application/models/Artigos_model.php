<?php
class Artigos_model extends CI_Model
{
    var $order_artigos = array('artigo', 'referencia', 'familia', 'marca', 'ano_fabrico', 'fotografia1', 'detalhes', null);

    public function get_familia_artigos()
    {
       return $this->db->select('familia_artigos.*')->from('familia_artigos')->get()->result_array();
    }

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_artigos()
    {
        $this->db->select('artigos.*, familia_artigos.familia, familia_artigos.id_familia');
        $this->db->from('artigos');
        $this->db->join('familia_artigos', 'artigos.id_familia = familia_artigos.id_familia');
        $this->db->having('ativo', true);

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("artigo", $dados);
            $this->db->or_like("referencia", $dados);
            $this->db->or_like("familia", $dados);
            $this->db->or_like("marca", $dados);
            $this->db->or_like("ano_fabrico", $dados);
            $this->db->or_like("detalhes", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_artigos[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referencia', 'ASC');
        }
    }

    public function make_tabela_artigos()
    {
        $this->make_query_tabela_artigos();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_artigos()
    {

        $this->make_query_tabela_artigos();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_artigos()
    {
        $this->db->from('artigos');
        $this->db->where('ativo', true);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function get_artigo($id = null)
    {
        $artigos = $this->db->select('artigos.*')
            ->from('artigos')
            ->where('artigos.id_artigo', $id)
            ->get()->result_array()[0];
        return $artigos;
    }

    public function adicionarArtigo($post = null, $foto1 = null, $foto2 = null)
    {
        $dados = [
            'referencia' => $post['referencia'],
            'artigo' => $post['artigo'],
            'artigo_en' => $post['artigo_en'],
            'artigo_fr' => $post['artigo_fr'],
            'id_familia' => $post['familia_artigo'],
            'marca' => $post['marca'],
            'ano_fabrico' => $post['ano_fabrico'],
            'detalhes' => $post['detalhes'],
            'fotografia1' => $foto1,
            'fotografia2' => $foto2,
            'id_utilizador' => $_SESSION['id_utilizador'],
        ];

        if ($this->db->insert('artigos', $dados)) {
            return true;
        } else {
            return false;
        };
    }

    public function editarArtigo($post = null, $foto1 = null, $foto2 = null)
    {   

        if($foto1 == "" && $foto2 == ""){
            $dados = [
                'referencia' => $post['referencia'],
                'artigo' => $post['artigo'],
                'artigo_en' => $post['artigo_en'],
                'artigo_fr' => $post['artigo_fr'],
                'id_familia' => $post['familia_artigo'],
                'marca' => $post['marca'],
                'ano_fabrico' => $post['ano_fabrico'],
                'detalhes' => $post['detalhes'],
                'id_utilizador' => $_SESSION['id_utilizador'],
            ];
        } else if($foto1 == ""){
            $dados = [
                'referencia' => $post['referencia'],
                'artigo' => $post['artigo'],
                'artigo_en' => $post['artigo_en'],
                'artigo_fr' => $post['artigo_fr'],
                'id_familia' => $post['familia_artigo'],
                'marca' => $post['marca'],
                'ano_fabrico' => $post['ano_fabrico'],
                'detalhes' => $post['detalhes'],
                'fotografia2' => $foto2,
                'id_utilizador' => $_SESSION['id_utilizador'],
            ];
        } else if($foto2 == ""){
            $dados = [
                'referencia' => $post['referencia'],
                'artigo' => $post['artigo'],
                'artigo_en' => $post['artigo_en'],
                'artigo_fr' => $post['artigo_fr'],
                'id_familia' => $post['familia_artigo'],
                'marca' => $post['marca'],
                'ano_fabrico' => $post['ano_fabrico'],
                'detalhes' => $post['detalhes'],
                'fotografia1' => $foto1,
                'id_utilizador' => $_SESSION['id_utilizador'],
            ];
        } else if($foto1 != "" && $foto2 != ""){
            $dados = [
                'referencia' => $post['referencia'],
                'artigo' => $post['artigo'],
                'artigo_en' => $post['artigo_en'],
                'artigo_fr' => $post['artigo_fr'],
                'id_familia' => $post['familia_artigo'],
                'marca' => $post['marca'],
                'ano_fabrico' => $post['ano_fabrico'],
                'detalhes' => $post['detalhes'],
                'fotografia1' => $foto1,
                'fotografia2' => $foto2,
                'id_utilizador' => $_SESSION['id_utilizador'],
            ];
        }
        
        $update = $this->db->where('id_artigo', $post['id_artigo'])
            ->update('artigos', $dados);

        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function fotoantiga1(){
        return $this->db->select('fotografia1')->from('artigos')->where('id_artigo', $this->input->post('id_artigo'))->get()->result_array();
    }

    public function fotoantiga2(){
        return $this->db->select('fotografia2')->from('artigos')->where('id_artigo', $this->input->post('id_artigo'))->get()->result_array();
    }

    public function apagarArtigo($id){
        $dados = [
            'data_insercao' => date("Y-m-d H:i"),
            'id_utilizador' =>$_SESSION['id_utilizador'],
            'ativo' => 0
        ];
        $apagar = $this->db->where('id_artigo', $id['id_artigo'])
                ->update('artigos', $dados);
        if($apagar){
            return true;
        }else{
            return false;
        }
    }
}

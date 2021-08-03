<?php
class Propostas_model extends CI_Model
{
    var $order_propostas = array('proposta', 'cliente', 'instalacao', 'data_insercao', 'nome', 'id_proposta', null);

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_propostas()
    {
        $this->db->select('propostas.*, cliente.id_cliente, cliente.cliente, instalacoes.id_instalacao, instalacoes.instalacao, utilizadores.id_utilizador, utilizadores.nome');
        $this->db->from('propostas');
        $this->db->join('cliente', 'propostas.id_cliente = cliente.id_cliente');
        $this->db->join('instalacoes', 'propostas.id_instalacao = instalacoes.id_instalacao');
        $this->db->join('utilizadores', 'propostas.id_utilizador = utilizadores.id_utilizador');
        $this->db->having('ativo', true);

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("proposta", $dados);
            $this->db->or_like("cliente", $dados);
            $this->db->or_like("instalacao", $dados);
            $this->db->or_like("propostas.data_insercao", $dados);
            $this->db->or_like("nome", $dados);
            $this->db->or_like("id_proposta", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_propostas[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('propostas.data_insercao', 'ASC');
        }
    }

    public function make_tabela_propostas()
    {
        $this->make_query_tabela_propostas();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_propostas()
    {

        $this->make_query_tabela_propostas();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_propostas()
    {
        $this->db->from('propostas');
        $this->db->where('ativo', true);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function adicionarProposta($post){
        
        $dados = [
            'proposta' => $post['proposta'],
            'id_cliente' => $post['cliente'],
            'id_instalacao' => $post['instalacao'],
            'observacoes' => $post['observacoes'],
            'id_utilizador' => $_SESSION['id_utilizador']
        ];

        if($this->db->insert('propostas', $dados)){
            return true;
        }else{
            return false;
        }
    }
}

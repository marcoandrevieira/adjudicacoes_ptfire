<?php
class Propostas_model extends CI_Model
{
    var $order_propostas = array('proposta', 'cliente', 'instalacao', 'data_insercao', 'nome', 'id_proposta', null);
    var $order_single_proposta = array('referencia', 'artigo', 'familia', 'marca', 'fotografia1', null, null, null);
    var $order_artigos_proposta = array('referencia', 'artigo', 'familia', 'marca', 'fotografia1', null, null, null);

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_propostas()
    {
        $this->db->select('propostas.*, cliente.id_cliente, cliente.cliente, instalacoes.id_instalacao, instalacoes.instalacao, utilizadores.id_utilizador, utilizadores.nome');
        $this->db->from('propostas');
        $this->db->join('cliente', 'propostas.id_cliente = cliente.id_cliente');
        $this->db->join('instalacoes', 'propostas.id_instalacao = instalacoes.id_instalacao', 'left');
        $this->db->join('utilizadores', 'propostas.id_utilizador = utilizadores.id_utilizador');
        $this->db->having('propostas.ativo', true);

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

    public function adicionarProposta($post)
    {

        $dados = [
            'proposta' => $post['proposta'],
            'id_cliente' => $post['cliente'],
            'id_instalacao' => !empty($post['instalacao']) ? $post['instalacao'] : NULL,
            'observacoes' => $post['observacoes'],
            'id_utilizador' => $_SESSION['id_utilizador']
        ];

        if ($this->db->insert('propostas', $dados)) {
            $id = $this->db->insert_id();
            return $id;
        } else {
            return false;
        }
    }

    public function get_proposta($id)
    {
        return $this->db->select('propostas.*, cliente.cliente, cliente.email, instalacoes.instalacao, utilizadores.nome')
            ->from('propostas')
            ->join('cliente', 'propostas.id_cliente = cliente.id_cliente')
            ->join('instalacoes', 'propostas.id_instalacao = instalacoes.id_instalacao', 'left')
            ->join('utilizadores', 'propostas.id_utilizador = utilizadores.id_utilizador')
            ->where('propostas.id_proposta', $id)
            ->get()->result_array()[0];
    }

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_single_proposta()
    {
        $id_cliente = $this->input->post('id_cliente');

        $this->db->select('artigos.*, familia_artigos.familia, familia_artigos.id_familia, tabela_precos.preco, tabela_precos.id_cliente');
        $this->db->from('artigos');
        $this->db->join('familia_artigos', 'artigos.id_familia = familia_artigos.id_familia');
        $this->db->join('tabela_precos', 'artigos.id_artigo = tabela_precos.id_artigo', 'left');
        $this->db->having('tabela_precos.id_cliente', $id_cliente);
        $this->db->having('artigos.ativo', true);

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("artigo", $dados);
            $this->db->or_like("referencia", $dados);
            $this->db->or_like("familia", $dados);
            $this->db->or_like("marca", $dados);
            $this->db->or_like("detalhes", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_single_proposta[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referencia', 'ASC');
        }
    }

    public function make_tabela_single_proposta()
    {
        $this->make_query_tabela_single_proposta();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_single_proposta()
    {

        $this->make_query_tabela_single_proposta();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_single_proposta()
    {
        $id_cliente = $this->input->post('id_cliente');

        $this->db->from('artigos');
        $this->db->join('tabela_precos', 'artigos.id_artigo = tabela_precos.id_artigo', 'left');
        $this->db->where('tabela_precos.id_cliente', $id_cliente);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function adicionar_artigos_proposta($post)
    {
        $check = $this->db->select('id_artigo_proposta, quantidade')
            ->from('artigos_proposta')
            ->where('id_proposta', $post['id_proposta'])
            ->where('id_artigo', $post['id_artigo'])
            ->get()->result_array();

        if (empty($check)) {
            $dados_insert = [
                'id_proposta' => $post['id_proposta'],
                'id_artigo' => $post['id_artigo'],
                'quantidade' => $post['quantidade'],
                'preco' => $post['preco'],
                'id_utilizador' => $_SESSION['id_utilizador'],
            ];

            if ($this->db->insert('artigos_proposta', $dados_insert)) {
                return true;
            } else {
                return false;
            }
        } else {

            $sql_art_proposta = "UPDATE artigos_proposta
                SET quantidade = quantidade + " . $post['quantidade'] . ", preco = " . $post['preco'] . "
                WHERE id_artigo_proposta = " . $check[0]['id_artigo_proposta'];

            if ($this->db->query($sql_art_proposta)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_artigos_proposta()
    {
        $this->db->select('artigos_proposta.*, artigos.*, familia_artigos.familia, familia_artigos.id_familia');
        $this->db->from('artigos_proposta');
        $this->db->join('artigos', 'artigos_proposta.id_artigo = artigos.id_artigo');
        $this->db->join('familia_artigos', 'artigos.id_familia = familia_artigos.id_familia');
        $this->db->having('artigos_proposta.id_proposta', $this->input->post('id_proposta'));

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("referencia", $dados);
            $this->db->or_like("artigo", $dados);
            $this->db->or_like("familia", $dados);
            $this->db->or_like("marca", $dados);
            $this->db->or_like("quantidade", $dados);
            $this->db->or_like("preco", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_artigos_proposta[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('artigos_proposta.data_insercao', 'DESC');
        }
    }

    public function make_tabela_artigos_proposta()
    {
        $this->make_query_tabela_artigos_proposta();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_artigos_proposta()
    {

        $this->make_query_tabela_artigos_proposta();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_artigos_proposta()
    {
        $this->db->from('artigos_proposta');
        $this->db->where('artigos_proposta.id_proposta', $this->input->post('id_proposta'));
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function apagar_artigo_proposta($post)
    {
        $apagar = $this->db->where('id_artigo_proposta', $post['id_artigo_proposta'])
            ->delete('artigos_proposta');

        if ($apagar) {
            return true;
        } else {
            return false;
        }
    }

    public function apagar_proposta($post)
    {
        $apagar = $this->db->where('id_proposta', $post['id_proposta'])
            ->update('propostas', array('ativo' => 0));

        if ($apagar) {
            return true;
        } else {
            return false;
        }
    }

    public function enviar_proposta_cliente($post){
        
        $dados = [
            'idioma' => $post['idioma'],
            'data_envio' => $post['data_envio'],
            'email_envio' => $post['email'],
            'enviado_por' => $post['enviado_por'],
            'obs_cliente' => $post['obs_cliente'],
        ];

        $envio = $this->db->where('id_proposta', $post['id_proposta'])
                ->update('propostas', $dados);

        if($envio){
            return true;
        }else{
            return false;
        }
    }
    
}

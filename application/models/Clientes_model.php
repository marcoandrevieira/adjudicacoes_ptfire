<?php
class Clientes_model extends CI_Model
{

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_clientes()
    {

        $this->db->select('id_cliente, cliente, nif, morada, telefone, email, ativo');
        $this->db->from('cliente');
        $this->db->having('ativo', true);

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("cliente", $dados);
            $this->db->or_like("nif", $dados);
            $this->db->or_like("morada", $dados);
            $this->db->or_like("telefone", $dados);
            $this->db->or_like("email", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_cliente[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('cliente', 'ASC');
        }
    }

    public function make_tabela_clientes()
    {
        $this->make_query_tabela_clientes();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_clientes()
    {

        $this->make_query_tabela_clientes();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_clientes()
    {
        $this->db->from('cliente');
        $this->db->where('ativo', true);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function get_cliente($id = null)
    {
        return $this->db->select('cliente.*')
            ->from('cliente')
            ->where('cliente.id_cliente', $id)
            ->get()->result_array()[0];
    }

    public function adicionarCliente($post = null)
    {

        if ($this->db->select('nif')->from('cliente')->where('nif', $post['nif'])->where('ativo', true)->get()->result_array()) {
            return "duplicado";
        };

        $dados = [
            'cliente' => $post['cliente'],
            'nif' => $post['nif'],
            'morada' => $post['morada'],
            'telefone' => $post['telefone'],
            'email' => $post['email'],
            'id_utilizador' => $_SESSION['id_utilizador']
        ];

        if ($this->db->insert('cliente', $dados)) {
            return true;
        } else {
            return false;
        };
    }

    public function editarCliente($post = null)
    {

        $dados = [
            'cliente' => $post['cliente'],
            'nif' => $post['nif'],
            'morada' => $post['morada'],
            'telefone' => $post['telefone'],
            'email' => $post['email'],
        ];

        $update = $this->db->where('id_cliente', $post['id_cliente'])
            ->update('cliente', $dados);

        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function apagarCliente($id)
    {

        $dados = [
            'data_insercao' => date("Y-m-d H:i"),
            'id_utilizador' => $_SESSION['id_utilizador'],
            'ativo' => 0
        ];

        $apagar = $this->db->where('id_cliente', $id['id_cliente'])
            ->update('cliente', $dados);

        if ($apagar) {
            return true;
        } else {
            return false;
        }
    }


    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_precos()
    {
        $this->db->select('artigos.*, familia_artigos.familia, familia_artigos.id_familia');
        $this->db->from('artigos');
        $this->db->join('familia_artigos', 'artigos.id_familia = familia_artigos.id_familia');
        //$this->db->join('tabela_precos', 'artigos.id_artigo = tabela_precos.id_artigo', 'left');
        //$this->db->having('tabela_precos.id_cliente', $this->input->post('id_cliente'));
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

    public function make_tabela_precos()
    {
        $this->make_query_tabela_precos();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_precos()
    {

        $this->make_query_tabela_precos();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_precos()
    {
        $this->db->from('artigos');
        $this->db->where('ativo', true);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function get_precos_artigos($id_artigo, $id_cliente)
    {

        $preco =  $this->db->select('preco')
            ->from('tabela_precos')
            ->where('id_artigo', $id_artigo)
            ->where('id_cliente', $id_cliente)
            ->get()->result_array();
        if (!empty($preco)) {
            return $preco[0]['preco'];
        }

        return;
    }

    public function edit_tabela_precos($post)
    {

        $check = $this->db->select('id_preco')
            ->from('tabela_precos')
            ->where('id_cliente', $post['id_cliente'])
            ->where('id_artigo', $post['id_artigo'])
            ->get()->result_array();

        if (empty($check)) {
            $dados = [
                'preco' => $post['preco'],
                'id_artigo' => $post['id_artigo'],
                'id_cliente' => $post['id_cliente'],
                'id_utilizador' => $_SESSION['id_utilizador'],
            ];

            $this->db->insert('tabela_precos', $dados);
        } else {
            $dados = [
                'preco' => $post['preco'] == null ? NULL : $post['preco'],
                'id_utilizador' => $_SESSION['id_utilizador'],
                'data_insercao' => date('Y-m-d H:i:s')
            ];

            $this->db->where('id_cliente', $post['id_cliente'])
                ->where('id_artigo', $post['id_artigo'])
                ->update('tabela_precos', $dados);
        }
    }

    function selecionar_clientes_pesquisa($query)
    {
        $this->db->like('cliente', $query);
        $query = $this->db->get('cliente');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $cliente[] = array(
                    'id_cliente' => $row->id_cliente,
                    'nif' => $row->nif,
                    'cliente' => $row->cliente,
                    'morada' => $row->morada,
                    'telefone' => $row->telefone
                );
            }
            return $cliente;
        }
    }

    function get_instalacao_cliente_ativas($id_cliente)
    {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->where('ativo', 1);
        $query = $this->db->get('instalacoes');
        if ($query->num_rows() > 0) {
            return ($query->result());
        } else {
            return NULL;
        }
    }
}

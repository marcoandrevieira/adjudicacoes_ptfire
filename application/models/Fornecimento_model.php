<?php
class Fornecimento_model extends CI_Model
{

    var $order_stock_armazem = array('referencia', 'artigo', 'familia', 'marca', 'fotografia1', 'quantidade', 'preco', null, null);
    var $order_fornecimento_cliente = array('referencia', 'artigo', 'familia', 'marca', 'fotografia1', 'quantidade', 'preco', null);
    

    public function novo_fornecimento($id_armazem, $id_projeto)
    {
        $id_fornecimento = $this->db->select('id_fornecimento')
            ->from('fornecimento_cliente')
            ->where('id_projeto', $id_projeto)
            ->where('id_armazem_saida', $id_armazem)
            ->get()->result_array();

        if (!empty($id_fornecimento)) {
            return $id_fornecimento[0]['id_fornecimento'];
        } else {
            $dados = [
                'id_projeto' => $id_projeto,
                'id_armazem_saida' => $id_armazem,
                'criado_por' => $_SESSION['id_utilizador']
            ];

            $this->db->insert('fornecimento_cliente', $dados);
            $id = $this->db->insert_id();
            return $id;
        }
    }

    public function get_cliente_fornecimento($id_fornecimento)
    {

        return $this->db->select('cliente.cliente, cliente.id_cliente, instalacoes.instalacao, fornecimento_cliente.id_fornecimento, fornecimento_cliente.data_insercao,fornecimento_cliente.data_fecho, user_criado.nome as criado_nome, user_fechado.nome as fechado_nome')
            ->from('fornecimento_cliente')
            ->join('projeto', 'fornecimento_cliente.id_projeto = projeto.id_projeto')
            ->join('cliente', 'projeto.id_cliente = cliente.id_cliente')
            ->join('instalacoes', 'projeto.id_instalacao = instalacoes.id_instalacao')
            ->join('utilizadores as user_criado', 'fornecimento_cliente.criado_por = user_criado.id_utilizador')
            ->join('utilizadores as user_fechado', 'fornecimento_cliente.fechado_por = user_fechado.id_utilizador', 'left')
            ->where('id_fornecimento', $id_fornecimento)
            ->get()->result_array()[0];
    }


    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_stock_armazem()
    {
        $id_armazem = $this->input->post('id_armazem');
        $id_cliente = $this->input->post('id_cliente');

        $this->db->select('artigos.*, familia_artigos.familia, familia_artigos.id_familia, stocks.quantidade, stocks.id_armazem, tabela_precos.preco, tabela_precos.id_cliente');
        $this->db->from('stocks');
        $this->db->join('artigos', 'stocks.id_artigo = artigos.id_artigo');
        $this->db->join('familia_artigos', 'artigos.id_familia = familia_artigos.id_familia');
        $this->db->join('tabela_precos', 'stocks.id_artigo = tabela_precos.id_artigo', 'left');
        $this->db->having('tabela_precos.id_cliente', $id_cliente);
        $this->db->having('artigos.ativo', true);
        $this->db->having('stocks.id_armazem', $id_armazem);
        $this->db->having('stocks.quantidade > 0');

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
            $this->db->order_by($this->order_stock_armazem[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referencia', 'ASC');
        }
    }

    public function make_tabela_stock_armazem()
    {
        $this->make_query_tabela_stock_armazem();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_stock_armazem()
    {

        $this->make_query_tabela_stock_armazem();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_stock_armazem()
    {
        $id_armazem = $this->input->post('id_armazem');
        $id_cliente = $this->input->post('id_cliente');

        $this->db->from('stocks');
        $this->db->where('stocks.id_armazem', $id_armazem);
        $this->db->join('tabela_precos', 'stocks.id_artigo = tabela_precos.id_artigo', 'left');
        $this->db->where('tabela_precos.id_cliente', $id_cliente);
        $this->db->where('stocks.quantidade > 0');
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */


    public function adicionar_fornecimento_artigo($post)
    {
        $id_artigo_fornecido = $this->db->select('id_artigo_fornecido')
                ->from('artigos_fornecidos')
                ->where('id_fornecimento', $post['id_fornecimento'])
                ->where('id_artigo', $post['id_artigo'])
                ->get()->result_array();

        if(!empty($id_artigo_fornecido)){

            $sql = "UPDATE artigos_fornecidos
            SET quantidade = quantidade + " . $post['quantidade'] . "
            WHERE id_artigo = " . $post['id_artigo'] . " AND id_fornecimento = " . $post['id_fornecimento'];
            if($this->db->query($sql)){

                $sql_stocks = "UPDATE stocks
                SET quantidade = quantidade - " . $post['quantidade'] . "
                WHERE id_artigo = " . $post['id_artigo'] . " AND id_armazem = " . $post['id_armazem'];

                if($this->db->query($sql_stocks)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }else{
            $dados = [
                'id_fornecimento' => $post['id_fornecimento'],
                'id_artigo' => $post['id_artigo'],
                'quantidade' => $post['quantidade'],
                'preco' => $post['preco'],
                'id_utilizador' => $_SESSION['id_utilizador']
            ];
    
            if($this->db->insert('artigos_fornecidos', $dados)){
                $sql_stocks = "UPDATE stocks
                SET quantidade = quantidade - " . $post['quantidade'] . "
                WHERE id_artigo = " . $post['id_artigo'] . " AND id_armazem = " . $post['id_armazem'];

                if($this->db->query($sql_stocks)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_fornecimento_cliente()
    {
        $id_fornecimento = $this->input->post('id_fornecimento');

        $this->db->select('artigos.*, familia_artigos.familia, familia_artigos.id_familia, fornecimento_cliente.id_fornecimento, artigos_fornecidos.quantidade, artigos_fornecidos.preco, artigos_fornecidos.id_fornecimento, fornecimento_cliente.fechado_por, artigos_fornecidos.id_artigo_fornecido');
        $this->db->from('fornecimento_cliente');
        $this->db->join('artigos_fornecidos', 'fornecimento_cliente.id_fornecimento = artigos_fornecidos.id_fornecimento');
        $this->db->join('artigos', 'artigos_fornecidos.id_artigo = artigos.id_artigo');
        $this->db->join('familia_artigos', 'artigos.id_familia = familia_artigos.id_familia');
        $this->db->having('artigos.ativo', true);
        $this->db->having('artigos_fornecidos.id_fornecimento', $id_fornecimento);
        $this->db->having('artigos_fornecidos.quantidade > 0');

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("artigo", $dados);
            $this->db->or_like("referencia", $dados);
            $this->db->or_like("familia", $dados);
            $this->db->or_like("marca", $dados);
            $this->db->or_like("quantidade", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_fornecimento_cliente[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referencia', 'ASC');
        }
    }

    public function make_tabela_fornecimento_cliente()
    {
        $this->make_query_tabela_fornecimento_cliente();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_fornecimento_cliente()
    {

        $this->make_query_tabela_fornecimento_cliente();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_fornecimento_cliente()
    {
        $id_fornecimento = $this->input->post('id_fornecimento');

        $this->db->from('fornecimento_cliente');
        $this->db->join('artigos_fornecidos', 'fornecimento_cliente.id_fornecimento = artigos_fornecidos.id_fornecimento');
        $this->db->where('artigos_fornecidos.id_fornecimento', $id_fornecimento);
        $this->db->where('artigos_fornecidos.quantidade > 0');
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function apagar_artigo_fornecido($post){
        $apagar = $this->db->where('id_artigo_fornecido', $post['id_artigo_fornecido'])
                ->delete('artigos_fornecidos');
        if($apagar){
            
            $sql_stocks = "UPDATE stocks
                SET quantidade = quantidade + " . $post['quantidade'] . "
                WHERE id_artigo = " . $post['id_artigo'] . " AND id_armazem = " . $post['id_armazem'];

                if($this->db->query($sql_stocks)){
                    return true;
                }else{
                    return false;
                }

        }else{
            return false;
        }
    }

    public function fechar_artigo_fornecido($post){

        $dados = [
            'data_fecho' => date('Y-m-d H:i:s'),
            'fechado_por' => $_SESSION['id_utilizador']
        ];

        $fechar = $this->db->where('id_fornecimento', $post['id_fornecimento'])
                    ->update('fornecimento_cliente', $dados);

        if($fechar){
            return true;
        }else{
            return false;
        }
    }

    public function get_fornecimento_instalacao($id_fornecimento){

        return $this->db->select('fornecimento_cliente.*, user_criado.nome as criado_nome, user_fechado.nome as fechado_nome, armazens.armazem, armazens.morada as morada_armazem, cliente.cliente, instalacoes.instalacao, instalacoes.morada, instalacoes.cp, cliente.telefone, cliente.nif')
        ->from('fornecimento_cliente')
        ->join('armazens', 'fornecimento_cliente.id_armazem_saida = armazens.id_armazem')
        ->join('projeto', 'fornecimento_cliente.id_projeto = projeto.id_projeto')
        ->join('instalacoes', 'projeto.id_instalacao = instalacoes.id_instalacao')
        ->join('cliente', 'projeto.id_cliente = cliente.id_cliente')
        ->join('utilizadores as user_criado', 'fornecimento_cliente.criado_por = user_criado.id_utilizador')
        ->join('utilizadores as user_fechado', 'fornecimento_cliente.fechado_por = user_fechado.id_utilizador')
        ->where('fornecimento_cliente.id_fornecimento', $id_fornecimento)
        ->get()->result_array()[0];

    }

    public function get_fornecimento_artigos($id_fornecimento){
        return $this->db->select('artigos_fornecidos.*, artigos.artigo, artigos.fotografia1, artigos.referencia')
                        ->from('artigos_fornecidos')
                        ->join('artigos', 'artigos_fornecidos.id_artigo = artigos.id_artigo')
                        ->where('artigos_fornecidos.id_fornecimento', $id_fornecimento)
                        ->get()->result_array();
    }
}

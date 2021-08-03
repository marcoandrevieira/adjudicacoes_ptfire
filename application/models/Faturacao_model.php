<?php
class Faturacao_model extends CI_Model
{
    var $order_faturacao = array('projeto', 'cliente', 'instalacao', 'id_armazem_saida', 'data_fecho', 'nome', null, 'nr_fatura', 'valor_fatura', null);

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_faturacao()
    {
        $this->db->select('faturacao.*, projeto.id_projeto, projeto.id_cliente, projeto.projeto, projeto.id_instalacao, cliente.cliente, instalacoes.instalacao, fornecimento_cliente.id_fornecimento, fornecimento_cliente.id_armazem_saida, fornecimento_cliente.data_fecho, fornecimento_cliente.fechado_por, utilizadores.nome, armazens.armazem');
        $this->db->from('fornecimento_cliente');
        $this->db->join('faturacao', 'fornecimento_cliente.id_fornecimento = faturacao.id_fornecimento', 'left');
        $this->db->join('projeto', 'fornecimento_cliente.id_projeto = projeto.id_projeto');
        $this->db->join('cliente', 'projeto.id_cliente = cliente.id_cliente');
        $this->db->join('instalacoes', 'projeto.id_instalacao = instalacoes.id_instalacao');
        $this->db->join('armazens', 'fornecimento_cliente.id_armazem_saida = armazens.id_armazem');
        $this->db->join('utilizadores', 'fornecimento_cliente.fechado_por = utilizadores.id_utilizador');
        // $this->db->having('ativo', true);

        if (!empty($_POST['fatura'])) {

            $this->db->like("nr_fatura", $_POST['fatura'], 'both');
        }
        if (!empty($_POST['data_fecho_start'])) {

            $this->db->having("(data_fecho > '" . $_POST['data_fecho_start'] . "' AND data_fecho < '" . $_POST['data_fecho_end'] . "')");
        }
        if (!empty($_POST['projeto'])) {

            $this->db->like("projeto", $_POST['projeto'], 'both');
        }
        if (!empty($_POST['cliente'])) {

            $this->db->like("cliente.cliente", $_POST['cliente'], 'both');
        }
        if (!empty($_POST['instalacao'])) {

            $this->db->like("instalacao", $_POST['instalacao'], 'both');
        }
        if (!empty($_POST['armazem_saida'])) {

            $this->db->having("id_armazem_saida", $_POST['armazem_saida']);
        }
        if (!empty($_POST['fechado_por'])) {

            $this->db->having("fechado_por", $_POST['fechado_por']);
        }
        if (!empty($_POST['fatura'])) {

            $this->db->like("nr_fatura", $_POST['fatura'], 'both');
        }
        if (!empty($_POST['valor_fatura'])) {

            $this->db->like("faturacao.valor_fatura", $_POST['valor_fatura'], 'both');
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_faturacao[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('fornecimento_cliente.id_fornecimento', 'DESC');
        }
    }

    public function make_tabela_faturacao()
    {
        $this->make_query_tabela_faturacao();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_faturacao()
    {

        $this->make_query_tabela_faturacao();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_faturacao()
    {
        $this->db->select('faturacao.*, projeto.id_projeto, projeto.id_cliente, projeto.projeto, projeto.id_instalacao, cliente.cliente, instalacoes.instalacao, fornecimento_cliente.id_fornecimento, fornecimento_cliente.id_armazem_saida, fornecimento_cliente.data_fecho, fornecimento_cliente.fechado_por, utilizadores.nome, armazens.armazem');
        $this->db->from('fornecimento_cliente');
        $this->db->join('faturacao', 'fornecimento_cliente.id_fornecimento = faturacao.id_fornecimento', 'left');
        $this->db->join('projeto', 'fornecimento_cliente.id_projeto = projeto.id_projeto');
        $this->db->join('cliente', 'projeto.id_cliente = cliente.id_cliente');
        $this->db->join('instalacoes', 'projeto.id_instalacao = instalacoes.id_instalacao');
        $this->db->join('armazens', 'fornecimento_cliente.id_armazem_saida = armazens.id_armazem');
        $this->db->join('utilizadores', 'fornecimento_cliente.fechado_por = utilizadores.id_utilizador');
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function get_valor_total_forncecimento($id_fornecimento)
    {
        $dados = $this->db->select('SUM(quantidade * preco) as total')
            ->from('artigos_fornecidos')
            ->where('id_fornecimento', $id_fornecimento)
            ->get()->result_array();

        return $dados[0]['total'];
    }

    public function adicionarFatura($post, $imagem = null)
    {
        if ($imagem != null) {

            $check = $this->db->select('id_fornecimento')
                ->from('faturacao')
                ->where('id_fornecimento', $post['id_fornecimento'])
                ->get()->result_array();

            if (empty($check)) {
                $dados = [
                    'id_fornecimento' => $post['id_fornecimento'],
                    'nr_fatura' => $post['fatura'],
                    'valor_fatura' => $post['valor_fatura'],
                    'imagem1' => $imagem,
                    'observacoes' => $post['observacoes'],
                    'id_utilizador' => $_SESSION['id_utilizador']
                ];

                if ($this->db->insert('faturacao', $dados)) {
                    return true;
                } else {
                    return false;
                }
            } else {

                $dados_edit = [
                    'nr_fatura' => $post['fatura'],
                    'valor_fatura' => $post['valor_fatura'],
                    'imagem1' => $imagem,
                    'observacoes' => $post['observacoes'],
                    'id_utilizador' => $_SESSION['id_utilizador']
                ];

                $edit = $this->db->where('id_fornecimento', $post['id_fornecimento'])
                    ->update('faturacao', $dados_edit);
                if ($edit) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {

            $check = $this->db->select('id_fornecimento')
                ->from('faturacao')
                ->where('id_fornecimento', $post['id_fornecimento'])
                ->get()->result_array();

            if (empty($check)) {
                $dados = [
                    'id_fornecimento' => $post['id_fornecimento'],
                    'nr_fatura' => $post['fatura'],
                    'valor_fatura' => $post['valor_fatura'],
                    'observacoes' => $post['observacoes'],
                    'id_utilizador' => $_SESSION['id_utilizador']
                ];
                if ($this->db->insert('faturacao', $dados)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $dados_edit = [
                    'nr_fatura' => $post['fatura'],
                    'valor_fatura' => $post['valor_fatura'],
                    'observacoes' => $post['observacoes'],
                    'id_utilizador' => $_SESSION['id_utilizador']
                ];

                $edit = $this->db->where('id_fornecimento', $post['id_fornecimento'])
                    ->update('faturacao', $dados_edit);
                if ($edit) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function get_fatura($post)
    {
        return $this->db->select('faturacao.*')
            ->from('faturacao')
            ->where('id_fornecimento', $post['id_fornecimento'])
            ->get()->result_array();
    }

    public function exportar_excel($post)
    {
        return $this->db->select('fornecimento_cliente.data_fecho as data, fornecimento_cliente.id_fornecimento as doc_nr, cliente.cliente, instalacoes.instalacao, armazens.armazem, projeto.projeto, artigos.artigo, artigos_fornecidos.quantidade, artigos_fornecidos.preco as preco_unitario, (artigos_fornecidos.preco*artigos_fornecidos.quantidade) as preco_total, utilizadores.nome as por')
            ->from('fornecimento_cliente')
            ->join('artigos_fornecidos', 'fornecimento_cliente.id_fornecimento = artigos_fornecidos.id_fornecimento')
            ->join('utilizadores', 'fornecimento_cliente.fechado_por = utilizadores.id_utilizador')
            ->join('artigos', 'artigos_fornecidos.id_artigo = artigos.id_artigo')
            ->join('projeto', 'fornecimento_cliente.id_projeto = projeto.id_projeto')
            ->join('cliente', 'projeto.id_cliente = cliente.id_cliente')
            ->join('instalacoes', 'projeto.id_instalacao = instalacoes.id_instalacao')
            ->join('armazens', 'fornecimento_cliente.id_armazem_saida = armazens.id_armazem')
            ->where('fornecimento_cliente.data_fecho > "' . $post['data_inicio'] .'"')
            ->where('fornecimento_cliente.data_fecho < "' . $post['data_fim'] .'"')
            ->get()->result_array();
    }
}

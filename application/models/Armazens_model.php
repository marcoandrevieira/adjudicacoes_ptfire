<?php
class Armazens_model extends CI_Model
{
    var $order_armazens = array('armazem', 'morada', 'notas',  null);
    var $order_entradas = array(null, 'nr_fatura', 'data_fatura', 'valor', 'criado_nome', 'fechado_nome', 'observacoes',  null);
    var $order_movimentos = array(null, 'armazem_saida', 'armazem_entrada', 'data_insercao', 'criado_nome', 'fechado_nome', 'observacoes',  null);
    var $order_entrada_artigos = array('referencia', 'artigo', 'familia', 'marca', 'fotografia1', 'quantidade', 'fechado',  null);
    var $order_stock_armazem = array('referencia', 'artigo', 'familia', 'marca', 'fotografia1', 'quantidade');
    var $order_aceitar_movimento = array('referencia', 'artigo', 'familia', 'marca', 'fotografia1', 'quantidade', null);

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_armazens()
    {
        $this->db->select('armazens.*');
        $this->db->from('armazens');
        $this->db->having('ativo', true);

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("armazem", $dados);
            $this->db->or_like("morada", $dados);
            $this->db->or_like("notas", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_armazens[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('armazem', 'ASC');
        }
    }

    public function make_tabela_armazens()
    {
        $this->make_query_tabela_armazens();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_armazens()
    {

        $this->make_query_tabela_armazens();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_armazens()
    {
        $this->db->from('armazens');
        $this->db->where('ativo', true);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function get_armazem($id = null)
    {
        $artigos = $this->db->select('armazens.*')
            ->from('armazens')
            ->where('armazens.id_armazem', $id)
            ->get()->result_array()[0];
        return $artigos;
    }

    public function adicionarArmazem($post = null)
    {
        $dados = [
            'armazem' => $post['armazem'],
            'morada' => $post['morada'],
            'notas' => $post['notas'],
            'id_utilizador' => $_SESSION['id_utilizador'],
        ];

        if ($this->db->insert('armazens', $dados)) {
            return true;
        } else {
            return false;
        };
    }

    public function editarArmazem($post = null)
    {
        $dados = [
            'armazem' => $post['armazem'],
            'morada' => $post['morada'],
            'notas' => $post['notas'],
            'id_utilizador' => $_SESSION['id_utilizador'],
        ];

        $update = $this->db->where('id_armazem', $post['id_armazem'])
            ->update('armazens', $dados);

        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function apagarArmazem($id)
    {
        $dados = [
            'data_insercao' => date("Y-m-d H:i"),
            'id_utilizador' => $_SESSION['id_utilizador'],
            'ativo' => 0
        ];
        $apagar = $this->db->where('id_armazem', $id['id_armazem'])
            ->update('armazens', $dados);
        if ($apagar) {
            return true;
        } else {
            return false;
        }
    }

    public function adicionarEntrada($post = null)
    {
        $dados = [
            'id_armazem' => $post['id_armazem'],
            'nr_fatura' => $post['fatura'],
            'fornecedor' => $post['fornecedor'],
            'data_fatura' => $post['data'],
            'valor' => $post['valor'],
            'observacoes' => $post['observacoes'],
            'id_utilizador' => $_SESSION['id_utilizador'],
        ];

        if ($this->db->insert('entrada_stock', $dados)) {
            $id_entrada = $this->db->insert_id();
            return $id_entrada;
        } else {
            return false;
        };
    }

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_entrada_stock()
    {
        $id_armazem = $this->input->post('id_armazem');

        $this->db->select('entrada_stock.*, user_criado.nome as criado_nome, user_fechado.nome as fechado_nome');
        $this->db->from('entrada_stock');
        $this->db->join('utilizadores as user_criado', 'entrada_stock.id_utilizador = user_criado.id_utilizador');
        $this->db->join('utilizadores as user_fechado', 'entrada_stock.fechado_por = user_fechado.id_utilizador', 'left');
        $this->db->having('entrada_stock.ativo', true);
        $this->db->having('entrada_stock.id_armazem', $id_armazem);


        if (!empty($_POST['estado'])) {
            if ($_POST['estado'] == "1") {
                $this->db->having("fechado_nome = ''");
            } else if ($_POST['estado'] == "2") {
                $this->db->having("fechado_nome <> ''");
            }
        }
        if (!empty($_POST['nr_fatura'])) {

            $this->db->having("nr_fatura", $_POST['nr_fatura']);
        }
        if (!empty($_POST['data_fatura'])) {

            $this->db->having("data_fatura", $_POST['data_fatura']);
        }
        if (!empty($_POST['valor'])) {

            $this->db->having("valor", $_POST['valor']);
        }
        if (!empty($_POST['criado_por'])) {

            $this->db->having("id_utilizador", $_POST['criado_por']);
        }
        if (!empty($_POST['fechado_por'])) {

            $this->db->having("fechado_por", $_POST['fechado_por']);
        }
        if (!empty($_POST['observacoes'])) {

            $this->db->having("observacoes", $_POST['observacoes']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_entradas[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_entrada', 'DESC');
        }
    }

    public function make_tabela_entrada_stock()
    {
        $this->make_query_tabela_entrada_stock();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_entrada_stock()
    {

        $this->make_query_tabela_entrada_stock();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_entrada_stock()
    {
        $id_armazem = $this->input->post('id_armazem');

        $this->db->from('entrada_stock');
        $this->db->where('ativo', true);
        $this->db->where('entrada_stock.id_armazem', $id_armazem);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function get_entrada_stock($id = null)
    {
        $artigos = $this->db->select('entrada_stock.*, user_criado.nome as criado_nome, user_fechado.nome as fechado_nome')
            ->from('entrada_stock')
            ->join('utilizadores as user_criado', 'entrada_stock.id_utilizador = user_criado.id_utilizador')
            ->join('utilizadores as user_fechado', 'entrada_stock.fechado_por = user_fechado.id_utilizador', 'left')
            ->where('entrada_stock.id_entrada', $id)
            ->get()->result_array()[0];
        return $artigos;
    }

    public function editarEntradaStock($post = null)
    {
        $dados = [
            'nr_fatura' => $post['fatura'],
            'fornecedor' => $post['fornecedor'],
            'data_fatura' => $post['data'],
            'valor' => $post['valor'],
            'observacoes' => $post['observacoes'],
            'id_utilizador' => $_SESSION['id_utilizador'],
        ];

        $update = $this->db->where('id_entrada', $post['id_entrada'])
            ->update('entrada_stock', $dados);

        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function apagarEntradaStock($id)
    {
        $dados = [
            'data_insercao' => date("Y-m-d H:i"),
            'id_utilizador' => $_SESSION['id_utilizador'],
            'ativo' => 0
        ];
        $apagar = $this->db->where('id_entrada', $id['id_entrada'])
            ->update('entrada_stock', $dados);
        if ($apagar) {
            return true;
        } else {
            return false;
        }
    }

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_entrada_artigos()
    {
        $id_entrada = $this->input->post('id_entrada');

        $this->db->select('entrada_artigos.*, artigos.referencia, artigos.artigo, artigos.id_familia, familia_artigos.familia, artigos.marca, artigos.fotografia1, entrada_artigos.id_entrada, entrada_stock.ativo, entrada_stock.fechado_por');
        $this->db->from('entrada_artigos');
        $this->db->join('artigos', 'entrada_artigos.id_artigo = artigos.id_artigo');
        $this->db->join('familia_artigos', 'artigos.id_familia = familia_artigos.id_familia');
        $this->db->join('entrada_stock', 'entrada_artigos.id_entrada = entrada_stock.id_entrada');
        $this->db->having('entrada_artigos.id_entrada', $id_entrada);
        $this->db->having('entrada_artigos.ativo', 1);
        $this->db->having('entrada_stock.ativo', 1);

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("referencia", $dados);
            $this->db->or_like("artigo", $dados);
            $this->db->or_like("familia", $dados);
            $this->db->or_like("marca", $dados);
            $this->db->or_like("quantidade", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_entrada_artigos[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referencia', 'ASC');
        }
    }

    public function make_tabela_entrada_artigos()
    {
        $this->make_query_tabela_entrada_artigos();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_entrada_artigos()
    {

        $this->make_query_tabela_entrada_artigos();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_entrada_artigos()
    {
        $id_entrada = $this->input->post('id_entrada');

        $this->db->from('entrada_artigos');
        $this->db->where('entrada_artigos.id_entrada', $id_entrada);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function adicionar_artigo_stock($post)
    {
        $check = $this->db->select('quantidade, id_artigo, id_entrada')
            ->from('entrada_artigos')
            ->where('id_artigo', $post['id_artigo'])
            ->where('id_entrada', $post['id_entrada'])
            ->get()->result_array();

        if (!empty($check[0])) {
            $dados_check = [
                'quantidade' => $post['quantidade'] + $check[0]['quantidade'],
                'ativo' => 1
            ];
            $this->db->where('id_artigo', $post['id_artigo'])
                ->where('id_entrada', $post['id_entrada'])
                ->update('entrada_artigos', $dados_check);

            return true;
        }

        $dados = [
            'id_entrada' => $post['id_entrada'],
            'id_artigo' => $post['id_artigo'],
            'quantidade' => $post['quantidade'],
            'fechado' => 0,
            'id_utilizador' => $_SESSION['id_utilizador'],
        ];

        if ($this->db->insert('entrada_artigos', $dados)) {
            return true;
        } else {
            return false;
        }
    }

    public function lancar_artigo($post)
    {
        $dados = [
            'fechado' => $post['fechado']
        ];
        $sucesso = $this->db->where('id_entrada_artigo', $post['id_entrada_artigo'])
            ->update('entrada_artigos', $dados);
        if ($sucesso) {

            $quantidade = $this->db->select('quantidade')
                ->from('entrada_artigos')
                ->where('id_entrada_artigo', $post['id_entrada_artigo'])
                ->get()->result_array()[0];

            if ($post['fechado'] == 1) {
                // adiciona ao armazem
                $artigo = $this->db->select('stocks.*')
                    ->from('stocks')
                    ->where('id_armazem', $post['id_armazem'])
                    ->where('id_artigo', $post['id_artigo'])
                    ->get()->result_array();

                if (!empty($artigo)) {
                    $this->db->where('id_armazem', $post['id_armazem'])
                        ->where('id_artigo', $post['id_artigo'])
                        ->update('stocks', array('quantidade' => $artigo[0]['quantidade'] + $quantidade['quantidade']));
                } else {

                    $dados_artigo = [
                        'id_artigo' => $post['id_artigo'],
                        'id_armazem' => $post['id_armazem'],
                        'quantidade' => $quantidade['quantidade'],
                    ];

                    $this->db->insert('stocks', $dados_artigo);
                }
            } else {
                //remove do armazem

                $artigo = $this->db->select('stocks.*')
                    ->from('stocks')
                    ->where('id_armazem', $post['id_armazem'])
                    ->where('id_artigo', $post['id_artigo'])
                    ->get()->result_array();

                $this->db->where('id_armazem', $post['id_armazem'])
                    ->where('id_artigo', $post['id_artigo'])
                    ->update('stocks', array('quantidade' => $artigo[0]['quantidade'] - $quantidade['quantidade']));
            }
        } else {
            return false;
        }
    }

    public function apagarentradaartigo($post)
    {
        $apagar = $this->db->where('id_entrada_artigo', $post['id_entrada_artigo'])
            ->update('entrada_artigos', array('ativo' => 0, 'quantidade' => 0));
        if ($apagar) {
            return true;
        } else {
            return false;
        }
    }

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_stock_armazem()
    {
        $id_armazem = $this->input->post('id_armazem');

        $this->db->select('artigos.*, familia_artigos.familia, familia_artigos.id_familia, stocks.quantidade, stocks.id_armazem');
        $this->db->from('stocks');
        $this->db->join('artigos', 'stocks.id_artigo = artigos.id_artigo');
        $this->db->join('familia_artigos', 'artigos.id_familia = familia_artigos.id_familia');
        $this->db->having('artigos.ativo', true);
        $this->db->having('stocks.id_armazem', $id_armazem);
        //$this->db->having('stocks.quantidade > 0');

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

        $this->db->from('stocks');
        $this->db->where('stocks.id_armazem', $id_armazem);
        $this->db->where('stocks.quantidade > 0');
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function fechar_entrada($post)
    {
        if ($post['fechado'] == 0) {
            $dados = [
                'fechado_por' => NULL
            ];

            $update = $this->db->where('id_entrada', $post['id_entrada'])
                ->update('entrada_stock', $dados);
        } else {

            $check = $this->db->select('fechado')
                ->from('entrada_artigos')
                ->where('fechado', 0)
                ->where('ativo', 1)
                ->where('id_entrada', $post['id_entrada'])
                ->get()->result_array();



            if (!empty($check)) {

                return "naolancado";
            }

            $dados = [
                'fechado_por' => $_SESSION['id_utilizador']
            ];

            $update = $this->db->where('id_entrada', $post['id_entrada'])
                ->update('entrada_stock', $dados);
        }

        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function get_armazens()
    {
        return $this->db->select('armazens.*')
            ->from('armazens')
            ->where('ativo', 1)
            ->get()->result_array();
    }

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_movimentos()
    {


        $this->db->select('movimentos.*, user_criado.nome as criado_nome, user_fechado.nome as fechado_nome, armazem_saida.armazem as armazem_saida, armazem_entrada.armazem as armazem_entrada');
        $this->db->from('movimentos');
        $this->db->join('utilizadores as user_criado', 'movimentos.criado_por = user_criado.id_utilizador');
        $this->db->join('utilizadores as user_fechado', 'movimentos.aceite_por = user_fechado.id_utilizador', 'left');
        $this->db->join('armazens as armazem_saida', 'movimentos.id_armazem_saida = armazem_saida.id_armazem');
        $this->db->join('armazens as armazem_entrada', 'movimentos.id_armazem_entrada = armazem_entrada.id_armazem');
        if (!empty($this->input->post('id_armazem'))) {
            $id_armazem = $this->input->post('id_armazem');
            $this->db->having('(movimentos.id_armazem_saida = ' . $id_armazem . ')');
        }


        if (!empty($_POST['estado'])) {
            if ($_POST['estado'] == "2") {
                $this->db->having("fechado = 0");
            } else if ($_POST['estado'] == "1") {
                $this->db->having("fechado = 1");
            }

            if ($_POST['estado'] == "aceitado") {
                $this->db->having("aceite = 1");
                $this->db->having("fechado = 1");
            } else if ($_POST['estado'] == "naoaceitado") {
                $this->db->having("aceite = 0");
                $this->db->having("fechado = 1");
            }
        }
        if ($_POST['estado'] == "todos") {
            $this->db->having("fechado = 1");
        }
        if (!empty($_POST['id_armazem_saida'])) {

            $this->db->having("id_armazem_saida", $_POST['id_armazem_saida']);
        }
        if (!empty($_POST['id_armazem_entrada'])) {

            $this->db->having("id_armazem_entrada", $_POST['id_armazem_entrada']);
        }
        if (!empty($_POST['data_criado'])) {

            $this->db->having("(data_insercao > '" . $_POST['data_criado'] . " 00:01:01' AND data_insercao < '" . $_POST['data_criado'] . " 23:59:59')");
        }
        if (!empty($_POST['criado_por'])) {

            $this->db->having("criado_por", $_POST['criado_por']);
        }
        if (!empty($_POST['fechado_por'])) {

            $this->db->having("concluido_por", $_POST['fechado_por']);
        }
        if (!empty($_POST['data_fechado'])) {

            $this->db->having("(data_concluido > '" . $_POST['data_fechado'] . " 00:01:01' AND data_concluido < '" . $_POST['data_fechado'] . " 23:59:59')");
        }
        if (!empty($_POST['observacoes'])) {

            $this->db->having("observacoes", $_POST['observacoes']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_movimentos[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_movimento', 'DESC');
        }
    }

    public function make_tabela_movimentos()
    {
        $this->make_query_tabela_movimentos();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_movimentos()
    {

        $this->make_query_tabela_movimentos();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_movimentos()
    {
        $this->db->from('movimentos');
        if (!empty($this->input->post('id_armazem'))) {
            $id_armazem = $this->input->post('id_armazem');
            $this->db->where('(movimentos.id_armazem_saida = ' . $id_armazem . ')');
        }
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function novo_movimento($post)
    {
        $dados = [
            'id_armazem_saida' => $post['armazem_saida'],
            'id_armazem_entrada' => $post['armazem_entrada'],
            'criado_por' => $_SESSION['id_utilizador'],
            'observacoes' => $post['observacoes']
        ];

        $this->db->insert('movimentos', $dados);
        $id = $this->db->insert_id();

        return $id;
    }
    public function get_movimento($id_movimento)
    {

        $this->db->select('movimentos.*, user_criado.nome as criado_nome, user_fechado.nome as fechado_nome, armazem_saida.armazem as armazem_saida, armazem_entrada.armazem as armazem_entrada');
        $this->db->from('movimentos');
        $this->db->join('utilizadores as user_criado', 'movimentos.criado_por = user_criado.id_utilizador');
        $this->db->join('utilizadores as user_fechado', 'movimentos.concluido_por = user_fechado.id_utilizador', 'left');
        $this->db->join('armazens as armazem_saida', 'movimentos.id_armazem_saida = armazem_saida.id_armazem');
        $this->db->join('armazens as armazem_entrada', 'movimentos.id_armazem_entrada = armazem_entrada.id_armazem');
        $this->db->where('movimentos.id_movimento', $id_movimento);
        $movimento = $this->db->get()->result_array();
        return $movimento[0];
    }

    public function adicionar_movimento_artigo($post)
    {
        $check = $this->db->select('artigos_movimentos.id_artigo_movimento, artigos_movimentos.quantidade')
            ->from('artigos_movimentos')
            ->where('artigos_movimentos.id_movimento', $post['id_movimento'])
            ->where('artigos_movimentos.id_artigo', $post['id_artigo'])
            ->get()->result_array();

        if (!empty($check)) {

            $dados = [
                'quantidade' => $check[0]['quantidade'] +  $post['quantidade'],
                'criado_por' => $_SESSION['id_utilizador'],
                'data_insercao' => date("Y-m-d H:i:s")
            ];

            $update = $this->db->where('artigos_movimentos.id_movimento', $post['id_movimento'])
                ->where('artigos_movimentos.id_artigo', $post['id_artigo'])
                ->update('artigos_movimentos', $dados);

            if ($update) {

                $sql = "UPDATE stocks
                        SET quantidade = quantidade - " . $post['quantidade'] . "
                        WHERE id_artigo = " . $post['id_artigo'] . " AND id_armazem = " . $post['id_armazem_saida'];

                if ($this->db->query($sql)) {
                    return $this->db->select('artigo')->from('artigos')->where('id_artigo', $post['id_artigo'])->get()->result_array()[0];
                } else {
                    return false;
                };
            } else {
                return false;
            }
        } else {

            $dados = [
                'id_movimento' => $post['id_movimento'],
                'id_artigo' => $post['id_artigo'],
                'quantidade' => $post['quantidade'],
                'criado_por' => $_SESSION['id_utilizador']
            ];

            if ($this->db->insert('artigos_movimentos', $dados)) {

                $sql = "UPDATE stocks
                        SET quantidade = quantidade - " . $post['quantidade'] . "
                        WHERE id_artigo = " . $post['id_artigo'] . " AND id_armazem = " . $post['id_armazem_saida'];

                if ($this->db->query($sql)) {
                    return $this->db->select('artigo')->from('artigos')->where('id_artigo', $post['id_artigo'])->get()->result_array()[0];
                } else {
                    return false;
                };
            } else {
                return false;
            }
        }
    }

    public function remover_movimento_artigo($post)
    {

        $apagar = $this->db->where('id_artigo_movimento', $post['id_artigo_movimento'])
            ->delete('artigos_movimentos');

        if ($apagar) {

            $sql = "UPDATE stocks
                        SET quantidade = quantidade + " . $post['quantidade'] . "
                        WHERE id_artigo = " . $post['id_artigo'] . " AND id_armazem = " . $post['id_armazem_saida'];

            if ($this->db->query($sql)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function load_div_artigos($id_movimento)
    {
        return $this->db->select('artigos_movimentos.*, artigos.artigo, movimentos.id_armazem_saida')
            ->from('artigos_movimentos')
            ->join('artigos', 'artigos_movimentos.id_artigo=artigos.id_artigo')
            ->join('movimentos', 'artigos_movimentos.id_movimento=movimentos.id_movimento')
            ->where('artigos_movimentos.id_movimento', $id_movimento)
            ->get()->result_array();
    }

    public function span_movimentos_pendentes()
    {
        return $this->db->select('id_movimento')
            ->from('movimentos')
            ->where('aceite', 0)
            ->where('fechado', 1)
            ->count_all_results();
    }

    public function fechar_movimento($get)
    {

        $fechar = $this->db->where('id_movimento', $get['id_movimento'])
            ->update('movimentos', array('fechado' => $get['fechar']));
        if ($fechar) {
            return true;
        } else {
            return false;
        }
    }

    public function movimento_fechado($id_movimento)
    {
        return $this->db->select('id_movimento')
            ->from('movimentos')
            ->where('id_movimento', $id_movimento)
            ->where('fechado', 1)
            ->get()->result_array();
    }

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_aceitar_movimento()
    {
        $id_movimento = $this->input->post('id_movimento');

        $this->db->select('artigos.*, familia_artigos.familia, familia_artigos.id_familia, artigos_movimentos.quantidade, artigos_movimentos.id_artigo_movimento, artigos_movimentos.id_movimento, artigos_movimentos.aceitado_por');
        $this->db->from('artigos_movimentos');
        $this->db->join('artigos', 'artigos_movimentos.id_artigo = artigos.id_artigo');
        $this->db->join('familia_artigos', 'artigos.id_familia = familia_artigos.id_familia');
        $this->db->having('artigos.ativo', true);
        $this->db->having('artigos_movimentos.id_movimento', $id_movimento);

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
            $this->db->order_by($this->order_aceitar_movimento[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('referencia', 'ASC');
        }
    }

    public function make_tabela_aceitar_movimento()
    {
        $this->make_query_tabela_aceitar_movimento();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_aceitar_movimento()
    {

        $this->make_query_tabela_aceitar_movimento();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_aceitar_movimento()
    {
        $id_armazem = $this->input->post('id_armazem');

        $this->db->from('stocks');
        $this->db->where('stocks.id_armazem', $id_armazem);
        $this->db->where('stocks.quantidade > 0');
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function aceitar_artigo($get)
    {

        $aceitado = $this->db->where('id_artigo_movimento', $get['id_artigo_movimento'])
            ->update('artigos_movimentos', array(
                'aceitado_por' => $_SESSION['id_utilizador'],
                'data_aceitado' => date('Y-m-d H:i:s'),
            ));

        if ($aceitado) {

            $linhacriada = $this->db->select('id_stock')
                ->from('stocks')
                ->where('id_artigo', $get['id_artigo'])
                ->where('id_armazem', $get['armazem_entrada'])
                ->get()->result_array();

            if (empty($linhacriada)) {
                $insert_stock = [
                    'id_artigo' => $get['id_artigo'],
                    'id_armazem' => $get['armazem_entrada'],
                    'quantidade' => $get['quantidade']
                ];
                $this->db->insert('stocks', $insert_stock);
            } else {
                $sql = "UPDATE stocks
                SET quantidade = quantidade + " . intval($get['quantidade']) . "
                WHERE id_artigo = " . $get['id_artigo'] . " AND id_armazem = " . $get['armazem_entrada'];

                $this->db->query($sql);
            }

            $check = $this->db->select('id_movimento')
                ->from('artigos_movimentos')
                ->where('id_movimento', $get['id_movimento'])
                ->where('aceitado_por IS NULL')
                ->get()->result_array();


            if (empty($check)) {
                $this->db->where('id_movimento', $get['id_movimento'])
                    ->update('movimentos', array(
                        "aceite" => 1,
                        "aceite_por" => $_SESSION['id_utilizador'],
                        "data_aceite" => date("Y-m-d H:i:s"),
                    ));
            }
        }
    }

    public function editar_quantidade_artigo($post){

       $edit = $this->db->where('id_artigo', $post['editar_stock_id_artigo'])
                ->where('id_armazem', $post['editar_stock_id_armazem'])
                ->update('stocks', array('quantidade' => $post['quantidade']));

        if($edit){
            return true;
        }else{
            return false;
        }
    }
}

<?php
class Instalacoes_model extends CI_Model
{

    var $order_fornecimento_cliente = array('projeto', 'armazem', 'criado_nome', 'data_insercao', 'fechado_nome', 'data_fecho', null);
    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_instalacoes()
    {
        $id_cliente = $this->input->post('id_cliente');

        $this->db->select('instalacoes.id_cliente, instalacoes.id_instalacao, instalacoes.instalacao, instalacoes.morada, instalacoes.cp,  instalacoes.email, instalacoes.telefone, distrito.zona as distrito, concelho.zona as concelho, instalacoes.ativo');
        $this->db->from('instalacoes');
        $this->db->join('zonas as distrito', 'instalacoes.distrito = distrito.id_zona');
        $this->db->join('zonas as concelho', 'instalacoes.concelho = concelho.id_zona');
        $this->db->having('ativo', true);
        $this->db->having('instalacoes.id_cliente', $id_cliente);

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("instalacao", $dados);
            $this->db->or_like("distrito", $dados);
            $this->db->or_like("morada", $dados);
            $this->db->or_like("telefone", $dados);
            $this->db->or_like("email", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_cliente[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('instalacao', 'ASC');
        }
    }

    public function make_tabela_instalacoes()
    {
        $this->make_query_tabela_instalacoes();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_instalacoes()
    {

        $this->make_query_tabela_instalacoes();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_instalacoes()
    {
        $id_cliente = $this->input->post('id_cliente');
        $this->db->from('instalacoes');
        $this->db->where('ativo', true);
        $this->db->where('id_cliente', $id_cliente);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */

    public function get_instalacao($id = null)
    {

        $instalacao = $this->db->select('instalacoes.*')
            ->from('instalacoes')
            ->where('instalacoes.id_instalacao', $id)
            ->get()->result_array()[0];


        $this->load->model('zonas_model');

        if (!empty($instalacao['freguesia'])) {


            $seleciona = $this->zonas_model->seleciona_por_zona($instalacao['freguesia']);
            $id_concelho = $this->zonas_model->seleciona_por_zona($seleciona['parent_id']);
            $id_destrito = $this->zonas_model->seleciona_por_zona($id_concelho['parent_id']);

            $freguesia = $this->zonas_model->get_by_parent($seleciona['parent_id']);
            $concelhos = $this->zonas_model->get_by_parent($id_concelho['parent_id']);
            $destritos = $this->zonas_model->get_by_parent($id_destrito['parent_id']);
        } else {

            $destritos = $this->zonas_model->destritos();
            $id_concelho = NULL;
            $id_destrito = NULL;
            $freguesia = NULL;
            $concelhos = NULL;
        }

        $instalacao['destritos'] = $destritos;
        $instalacao['freguesias'] = $freguesia;

        $instalacao['concelhos'] = $concelhos;
        $instalacao['parent_id_concelhos'] = $id_concelho['id_zona'];
        $instalacao['parent_id_destritos'] = $id_destrito['id_zona'];
        $instalacao['parent_id_freguesia'] = $instalacao['freguesia'];


        return $instalacao;
    }

    public function adicionarInstalacao($post = null)
    {

        $dados = [
            'id_cliente' => $post['id_cliente'],
            'instalacao' => $post['instalacao'],
            'morada' => $post['morada'],
            'telefone' => $post['telefone'],
            'email' => $post['email'],
            'cp' => $post['codigo_postal'],
            'distrito' => $post['destrito'],
            'concelho' => $post['concelho'],
            'freguesia' => $post['freguesia'],
            'id_utilizador' => $_SESSION['id_utilizador'],
        ];

        if ($this->db->insert('instalacoes', $dados)) {
            return true;
        } else {
            return false;
        };
    }

    public function editarInstalacao($post = null)
    {

        $dados = [
            'instalacao' => $post['instalacao'],
            'distrito' => $post['destrito'],
            'concelho' => $post['concelho'],
            'freguesia' => $post['freguesia'],
            'morada' => $post['morada'],
            'telefone' => $post['telefone'],
            'email' => $post['email'],
            'cp' => $post['codigo_postal'],
            'data_insercao' => date("Y-m-d H:i:s"),
            'id_utilizador' => $_SESSION['id_utilizador']
        ];

        $update = $this->db->where('id_instalacao', $post['id_instalacao'])
            ->update('instalacoes', $dados);

        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function apagarInstalacao($id)
    {
        $dados = [
            'data_insercao' => date("Y-m-d H:i"),
            'id_utilizador' => $_SESSION['id_utilizador'],
            'ativo' => 0
        ];
        $apagar = $this->db->where('id_instalacao', $id['id_instalacao'])
            ->update('instalacoes', $dados);
        if ($apagar) {
            return true;
        } else {
            return false;
        }
    }

    /* public function get_fornecimento_material($id_instalacao){

        return $this->db->select('fornecimento_cliente.id_fornecimento, armazens.armazem')
                        ->from('fornecimento_cliente')
                        ->join('projeto', 'fornecimento_cliente.id_projeto = projeto.id_projeto')
                        ->join('instalacoes', 'projeto.id_instalacao = instalacoes.id_instalacao')
                        ->where('instalacoes.id_instalacao', $id_instalacao)
                        ->get()->result_array();

    } */

    /* ============================================================DATATABLE====================================================================== */

    public function make_query_tabela_historico_fornecimento()
    {

        $id_instalacao = $this->input->post('id_instalacao');

        $this->db->select('projeto.projeto, projeto.id_projeto, projeto.id_instalacao, fornecimento_cliente.*, user_criado.nome as criado_nome, user_fechado.nome as fechado_nome, armazens.armazem');
        $this->db->from('projeto');
        $this->db->join('fornecimento_cliente', 'projeto.id_projeto = fornecimento_cliente.id_projeto');
        $this->db->join('armazens', 'fornecimento_cliente.id_armazem_saida = armazens.id_armazem');
        $this->db->join('utilizadores as user_criado', 'fornecimento_cliente.criado_por = user_criado.id_utilizador');
        $this->db->join('utilizadores as user_fechado', 'fornecimento_cliente.fechado_por = user_fechado.id_utilizador');
        $this->db->having('projeto.id_instalacao', $id_instalacao);

        if (isset($_POST['search']['value'])) {

            $dados = $_POST['search']['value'];

            $this->db->like("projeto", $dados);
            $this->db->or_like("armazem", $dados);
            $this->db->or_like("user_criado.nome", $dados);
            $this->db->or_like("fornecimento_cliente.data_insercao", $dados);
            $this->db->or_like("user_fechado.nome", $dados);
            $this->db->or_like("fornecimento_cliente.data_fecho", $dados);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_fornecimento_cliente[$_POST['order'][0]['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('data_fecho', 'DESC');
        }
    }

    public function make_tabela_historico_fornecimento()
    {
        $this->make_query_tabela_historico_fornecimento();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_historico_fornecimento()
    {

        $this->make_query_tabela_historico_fornecimento();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_historico_fornecimento()
    {
        $id_instalacao = $this->input->post('id_instalacao');
        $this->db->from('projeto');
        $this->db->join('fornecimento_cliente', 'projeto.id_projeto = fornecimento_cliente.id_projeto');
        $this->db->join('armazens', 'fornecimento_cliente.id_armazem_saida = armazens.id_armazem');
        $this->db->join('utilizadores as user_criado', 'fornecimento_cliente.criado_por = user_criado.id_utilizador');
        $this->db->join('utilizadores as user_fechado', 'fornecimento_cliente.fechado_por = user_fechado.id_utilizador');
        $this->db->where('projeto.id_instalacao', $id_instalacao);
        $query = $this->db->count_all_results();
        return $query;
    }
    /* ============================================================DATATABLE====================================================================== */
}

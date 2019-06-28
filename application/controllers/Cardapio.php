<?php
/**
 * Created by PhpStorm.
 * User: jessi
 * Date: 26/06/2019
 * Time: 09:43
 */

class Cardapio extends CI_Controller
{

    public function validaLogin() {
        $this->load->model('Cliente_model', 'CM');
        if ($this->CM->logged() == false) {
            redirect($this->config->base_url() . 'Cliente/Login');
        }
    }

    public function index() {
        $this->validaLogin();
        $this->load->model('Produto_model', 'PM');
        $data['produtos'] = $this->PM->get_all();
        $this->load->view('Cardapio', $data);
    }

    public function Cadastrar() {
        if($_POST) {
            $this->form_validation->set_rules('nome', 'nome', 'required');
            $this->form_validation->set_rules('valor', 'valor', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data = array(
                    'r' => false,
                    'txt' => 'form validation'
                );
            } else {
                $this->load->model('Produto_model', 'PM');
                date_default_timezone_set('Brazil/East');

                $dados = array(
                    'nome' => $this->input->post('nome'),
                    'valor' => $this->input->post('valor'),
                    'valorPromocional' => $this->input->post('valorPromo'),
                    'estoque' => $this->input->post('estoque'),
                    'descricao' => $this->input->post('descricao')
                );

                if ($this->PM->insert($dados)) {
                    $data = array(
                        'r' => true,
                    );
                } else {
                    $data = array(
                        'r' => false
                    );
                }
            }
            return json_encode($data);

        } else {
            $this->load->view('CadastroProduto');
        }
    }

    public function Carrinho($codigo) {
        $carrinho = $this->session->userdata('carrinho');
        if($carrinho == 0) {
            $carrinho = array($codigo);
        } else {
            array_push($carrinho, $codigo);
        }
        print_r($carrinho);
        $this->session->userdata('carrinho', $carrinho);
    }

    public function Pedido() {
        if($_POST) {
            $this->form_validation->set_rules('formaPtgo', 'formaPtgo', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data = array(
                    'r' => false,
                    'txt' => 'form validation'
                );
            } else {
                $this->load->model('Produto_model', 'PM');
                date_default_timezone_set('Brazil/East');
                $datahora = date('Y-m-d H:i:s');

                $produto = $this->PM->get_one($this->input->post('produto'));
                $valorTotal = $produto->valor*$this->input->post('qtd');

                $dados = array(
                    'formaPgto' => $this->input->post('formaPgto'),
                    'valorTotal' => $valorTotal,
                    'produto' => $this->input->post('produto'),
                    'codigoEndereco' => $this->input->post('endereco'),
                    'codigoCliente' => $this->session->userdata('idUsuario'),
                    'datahora' => $datahora
                );

                if ($this->PM->insert_pedido($dados)) {
                    $data = array(
                        'r' => true,
                    );
                } else {
                    $data = array(
                        'r' => false
                    );
                }
            }
            return json_encode($data);
        } else {
            $this->load->model('Produto_model', 'PM');
            $this->load->model('Cliente_model', 'CM');
            $data['enderecos'] = $this->CM->get_all_endereco($this->session->userdata('idUsuario'));
            $data['produtos'] = $this->PM->get_all();
            $this->load->view('Pedido', $data);
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: jessi
 * Date: 26/06/2019
 * Time: 09:56
 */

class Cliente extends CI_Controller {
    public function index() {

    }

    public function Cadastro() {
        if($_POST) {
            $this->form_validation->set_rules('nome', 'nome', 'required');
            $this->form_validation->set_rules('email', 'email', 'required');
            $this->form_validation->set_rules('telefone', 'telefone', 'required');
            $this->form_validation->set_rules('senha', 'senha', 'required');

            if ($this->form_validation->run() == FALSE) {
                $data = array(
                    'r' => false,
                    'txt' => 'form validation'
                );
            } else {
                $this->load->model('Cliente_model', 'CM');
                date_default_timezone_set('Brazil/East');
                $datahora = date('Y-m-d H:i:s');

                $dados = array(
                    'nome' => $this->input->post('nome'),
                    'email' => $this->input->post('email'),
                    'telefone' => $this->input->post('telefone'),
                    'senha' => $this->input->post('senha')
                );
                $id = $this->CM->insert($dados);
                if ($id) {
                    $dados = array (
                        'codigoCliente' => $id,
                        'rua' => $this->input->post('endereco'),
                        'numero' => $this->input->post('numero'),
                        'complemento' => $this->input->post('complemento'),
                        'bairro' => $this->input->post('bairro'),
                        'cidade' => $this->input->post('cidade'),
                        'estado' => $this->input->post('estado')
                    );
                    if($this->CM->insert_endereco($dados)) {
                        $data = array(
                            'r' => true,
                        );
                    } else {
                        $data = array(
                            'r' => false,
                        );
                    }
                } else {
                    $data = array(
                        'r' => false
                    );
                }
            }
            return json_encode($data);

        } else {
            $this->load->view('Cadastro');
        }
    }

    public function Login(){
        if($_POST) {
            $this->form_validation->set_rules('email', 'email', 'required');
            $this->form_validation->set_rules('senha', 'senha', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('msg_login', 'Usuário e Senha incorretos!');
            } else {
                $this->load->model('Cliente_model', 'CM');
                $query = $this->CM->get_one_login($this->input->post('email'), $this->input->post('senha'));
                if ($query) {
                        $data = array(
                            'idUsuario' => $query->codigo,
                            'permissao' => $query->permissao,
                            'email' => $query->email,
                            'carrinho' => 0,
                            'logged' => TRUE,
                        );
                        $this->session->set_userdata($data); //para usar $this->session->userdata('email');
                        redirect('Cardapio');
                } else {
                    $this->session->set_flashdata('msg_login', 'Usuário e Senha incorretos!');
                    redirect($this->config->base_url() . 'Cliente/Login');
                }
            }
        } else {
            $this->load->view('Login');
        }
    }

    public function sair() {
        $this->session->sess_destroy();
        $this->session->set_userdata(array(
            'idUsuario' => '',
            'permissao' => '',
            'carrinho' => 0,
            'email' => '',
            'logged' => false));
        redirect('/cardapio/');
    }
}

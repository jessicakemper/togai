<?php
/**
 * Created by PhpStorm.
 * User: jessi
 * Date: 26/06/2019
 * Time: 10:44
 */

class Cliente_model extends CI_Model
{
    public function insert($data = array()) {
        $this->db->insert('cliente',$data);
        return $this->db->insert_id();
    }

    public function insert_endereco($data = array()) {
        $this->db->insert('endereco',$data);
        return $this->db->insert_id();
    }

    public function get_all() {
        $data = $this->db->get('cliente');
        return $data->result();
    }

    public function get_one($id) {
        $this->db->where('codigo', $id);
        $query = $this->db->get('cliente');
        return $query->row(0);
    }

    public function get_all_endereco($idCliente) {
        $this->db->where('codigoCliente', $idCliente);
        $query = $this->db->get('endereco');
        return $query->result();
    }

    public function get_one_login($email, $senha) {
        $this->db->where('email', $email);
//        $this->db->where('cliente.senha', sha1($senha));
        $this->db->where('senha', $senha);
        $query = $this->db->get('cliente');
        return $query->row(0);
    }

    public function logged() {
        $logged = $this->session->userdata('logged');
        if (!isset($logged) || $logged != TRUE) {
            return false;
        } else {
            return true;
        }
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: jessi
 * Date: 27/06/2019
 * Time: 02:08
 */

class Produto_model extends CI_Model
{
    public function insert($data = array()) {
        $this->db->insert('produto',$data);
        return $this->db->insert_id();
    }

    public function get_all() {
        $data = $this->db->get('produto');
        return $data->result();
    }

    public function get_one($id) {
        $this->db->where('codigo', $id);
        $query = $this->db->get('produto');
        return $query->row(0);
    }

    public function insert_pedido($data = array()) {
        $this->db->insert('pedido',$data);
        return $this->db->insert_id();
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: jessi
 * Date: 27/06/2019
 * Time: 03:32
 */

class Relatorio_model extends CI_Model
{

    public function get_relatorio1() {
        $this->db->select('nome, telefone, idade');
        $this->db->from('cliente');
        $this->db->join('pedido', 'pedido.codigoCliente = cliente.codigo');
        $this->db->join('endereco', 'endereco ON endereco.codigoCliente = cliente.codigo');
        $this->db->where('endereco.bairro = "Agostini"');
        $this->db->or_where('endereco.bairro = "São Jorge"');
        $this->db->or_where('endereco.bairro = "Jardim Peperi"');
        $this->db->order_by('cliente.idade', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

/*SELECT codigo, nome, salario FROM funcionario
WHERE horasSemanais > 20 AND horasSemanais < 35 AND anoAdmissao >= 2018*/

}

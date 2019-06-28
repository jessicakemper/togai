<?php
/**
 * Created by PhpStorm.
 * User: jessi
 * Date: 27/06/2019
 * Time: 03:30
 */

class Relatorio extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Relatorio_model', 'RM');
    }

    public function Relatorio1() {
        $data['dados'] = $this->RM->get_relatorio1();
         $this->load->view('Relatorio1', $data);
     }

    public function Relatorio2() {
        $data['dados'] = $this->RM->get_relatorio2();
        $this->load->view('Relatorio2', $data);
    }

    public function Relatorio3() {
        $data['dados'] = $this->RM->get_relatorio3();
        $this->load->view('Relatorio3', $data);
    }

    public function Relatorio4() {
        $data['dados'] = $this->RM->get_relatorio4();
        $this->load->view('Relatorio4', $data);
    }
}

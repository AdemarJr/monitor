<?php

/**
 * Description of Relatoris
 *
 * @author Galileu
 */
class Relatorios extends CI_Controller {

    public function tela() {
        if (!isset($_SESSION['loginUsuario'])) {
            redirect();
        }
       
        if (!empty($this->session->userdata('idUsuario'))) {
            $clientes = null;
            if (@count($clientes) == 0 and $this->session->userdata('perfilUsuario') == 'ROLE_ADM') {
                $clientes = $this->ComumModelo->getClienteTodos()->result_array();
            } else {
                $clientes = $this->ComumModelo->getClientes($this->session->userdata('listaCliente'))->result_array();
            }
//            $this->session->set_userdata('novo-sistema', 1);
            $resultado['lista_cliente'] = $clientes;
            $this->load->view('modulos/publico/alerta/relatorios', $resultado);
        } else {
            redirect('alerta');
        }
    }

    public function rela() {
        if (!isset($_SESSION['loginUsuario'])) {
            redirect();
        }
        $data = [];
        $header = $this->session->userdata();
        $header['notificacoes'] = $this->NotificacaoModelo->getNotificacaoUsuario($this->session->userdata('idUsuario'));
        $this->load->view('modulos/template/cabecalho_privado', $header);
        $this->load->view('modulos/publico/alerta/relatorios_tela', $data);
        $this->load->view('modulos/template/rodape_privado');
    }

    public function apaga() {
        $this->session->unset_userdata('novo-sistema');
    }

    public function sempermissao() {
        $this->load->view('modulos/template/403', NULL);
    }

}

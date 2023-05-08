<?php

/**
 * Description of Clipping
 *
 * @author Galileu
 */
class Clipping extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('notificacaoModelo', 'NotificacaoModelo');
        $this->load->model('AuditoriaModelo', 'auditoria');
        $this->load->model('materiaModelo', 'MateriaModelo');
    }

    public function tela() {
        if (!isset($_SESSION['perfilUsuario'])) {
            redirect('');
        }
        $chave = $this->uri->segment(2);

        if (empty($chave)) {
            extract($this->input->post());

            $resultado['dataInicio'] = !empty($dataInicio) ? $dataInicio : date('Y-m-d');
            $resultado['dataFim'] = !empty($dataFim) ? $dataFim : date('Y-m-d');
            $resultado['lista_alertas'] = $this->NotificacaoModelo->listaNotificacaoPeriodo($resultado['dataInicio'], $resultado['dataFim']);
            $resultado['lista_alertas_agg'] = $this->NotificacaoModelo->listaNotificacaoAgg(str_replace('-', '', $resultado['dataInicio']));
            $this->load->view('modulos/publico/alerta/includes/topo');
            $this->load->view('modulos/publico/alerta/clipping', $resultado);
        } else {
            $this->detalhes($chave);
        }
    }

    public function detalhes($chave) {
        if (!isset($_SESSION['perfilUsuario'])) {
            redirect('');
        }
        $dadosNota = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $chave))->row();

        $dados = [
            'dataNota' => $dadosNota,
            'total' => count($this->MateriaModelo->getConsulta($chave))
        ];
        $this->load->view('modulos/publico/alerta/includes/topo');
        $this->load->view('modulos/publico/alerta/clippingdetalhes', $dados);
    }

    public function excluir($id) {

        $this->inserirAuditoria('EXCLUIR-ALERTA', 'E', 'Idnota: ' . $id);

        if ($this->NotificacaoModelo->deletar($id)) {
            $class = 'success';
            $mensagem = "<script>alertify.set('notifier','position', 'bottom-center'); alertify.success('ALERTA EXLUIDO');</script>";
            $this->session->set_flashdata('flash_message', $mensagem);
        } else {
            $class = 'error';
            $mensagem = "<script>alertify.set('notifier','position', 'bottom-center'); alertify.error('OCORREU UM ERRO AO EXCLUIR A MATÉRIA');</script>";
            $this->session->set_flashdata('flash_message', $mensagem);
        }

        redirect('clipping');
    }

    public function inserirAuditoria($operacao = NULL, $tipo = NULL, $obs = NULL) {
        $data = $this->session->userdata();
        $tb_auditoria = array(
            'SEQ_USUARIO' => $data['idUsuario'],
            'TIPO_AUDITORIA' => $tipo,
            'OPER_AUDITORIA' => $operacao,
            'OBS_AUDITORIA' => $obs,
            'SESSION_ID' => session_id()
        );
        $this->auditoria->inserir($tb_auditoria);
    }

    public function clipping_detalhes() {
        if (!isset($_SESSION['perfilUsuario'])) {
            redirect('');
        }
        $txt_wpp = $this->input->post('wpp');
        $this->session->set_userdata('txt-wpp', $txt_wpp);

        redirect('clipping/' . $this->input->post('chave'));
    }
    
    private function dados($chave) {
        $perPage = 20;

        $dadosNota = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $chave))->row();
        
        if (!empty($dadosNota)) {
            $idCliente = $dadosNota->SEQ_CLIENTE;
            $flagModelo = $dadosNota->IND_MODELO;
            $flagTema = $dadosNota->TIPO_NOTA;

            $this->session->set_userdata('idClienteSessaoAlerta', $idCliente);

            $header['chave'] = $chave;
            $this->load->model('materiaModelo', 'MateriaModelo');
            $header['total'] = count($this->MateriaModelo->getConsulta($chave));

            $this->MateriaModelo->alteraNota($chave, array('QTD_MATERIA' => $header['total']));
            $resultado['flagModelo'] = $flagModelo;
            $resultado['flagTema'] = $flagTema;
            $resultado['chaveNota'] = $chave;
            $resultado['totpagina'] = $perPage;
            $resultado['total'] = $header['total'];
            $resultado['flagEleicao'] = ($idCliente == 59
                    or $idCliente == 60
                    or $idCliente == 61
                    or $idCliente == 62
                    or $idCliente == 63
                    or $idCliente == 64
                    ) ? true : false;
            $config = array("base_url" => base_url('alerta/' . $chave), "per_page" => $perPage, "num_links" => 3, "uri_segment" => 3, "total_rows" => $header['total'], "full_tag_open" => "<ul class= 'pagination'>", "full_tag_close" => "</ul>", "first_link" => FALSE, "last_link" => FALSE, "first_tag_open" => "<li>", "first_tag_close" => "</li>", "prev_link" => "<i class='material-icons'>chevron_left</i>", "prev_tag_open" => "<li class='next'>", "prev_tag_close" => "</li>", "next_link" => "<i class='material-icons'>chevron_right</i>", "next_tag_open" => "<li class='next'>", "next_tag_close" => "</li>", "last_tag_open" => "<li>", "last_tag_close" => "</li>", "cur_tag_open" => "<li class= 'active'><a href=''>", "cur_tag_close" => "</a></li>", "num_tag_open" => "<li>", "num_tag_close" => "</li>");
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $resultado['paginacao'] = $this->pagination->create_links();
            $resultado['lista_dias'] = $this->MateriaModelo->getConsulta($chave, null, null);

            return array($resultado, $header);
        } else {
            return null;
        }
    }
    
    public function clipping_pdf($chave) {
        
        $this->load->library('pdf');
        $dados = $this->dados($chave);
        $htm = $this->load->view('modulos/publico/alerta/includes/pdf/alerta', $dados[0], true);
        echo $htm;
        die();
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($htm);
        $pdf->charset_in = 'UTF-8';
        $pdf->Output((date('dmY')) . 'alertaArquivo' . rand(10000, 999999). '.pdf', 'D');
    }

}

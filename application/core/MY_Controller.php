<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 19/05/2017
 * Time: 19:43
 */
class MY_Controller extends CI_Controller
{
    public function __contruct()
    {
        parent::__construct();
        	$logado = $this->session->userdata('logado');
        	if (!isset($logado) || $logado != true) {
        		redirect('login');
        	}
    }

    public function feedBack($tipo, $msg,$target)
    {
        $this->session->set_flashdata('flash_message', $this->ComumModelo->flash_message($tipo, $msg));
        redirect($target);
    }
    public function feedBackData($tipo, $msg,$url,$data=NULL)
    {
        $this->session->set_flashdata('flash_message', $this->ComumModelo->flash_message($tipo, $msg));
        $this->loadUrl($url,$data);
    }

    public function loadUrl($url, $data = NULL)
    {
        $header = $this->session->userdata();
        $header['notificacoes'] = $this->NotificacaoModelo->getNotificacaoUsuario($this->session->userdata('idUsuario'));
        $this->load->view('modulos/template/cabecalho_privado', $header);
        $this->load->view($url, $data);
        $this->load->view('modulos/template/rodape_privado');
    }

    public function inserirAuditoria($operacao = NULL, $tipo = NULL, $obs = NULL)
    {
        $data = $this->session->userdata();
        $tb_auditoria = array(
            'SEQ_USUARIO' => $data['idUsuario'],
            'TIPO_AUDITORIA' => $tipo,
            'OPER_AUDITORIA' => $operacao,
            'OBS_AUDITORIA' => $obs,
            'SESSION_ID'=>session_id(),
            'DATA_NUMERO' => date('Ymd')
        );
        $this->AuditoriaModelo->inserir($tb_auditoria);
    }
    public function inserirAuditoriaKlipbox($operacao = NULL, $tipo = NULL, $obs = NULL)
    {
        $data = $this->session->userdata();
        $tb_auditoria = array(
            'SEQ_USUARIO' => $data['idUsuario'],
            'TIPO_AUDITORIA' => $tipo,
            'OPER_AUDITORIA' => $operacao,
            'OBS_AUDITORIA' => $obs,
            'SESSION_ID'=>session_id()
        );
        $this->AuditoriaModelo->inserirKlipbox($tb_auditoria);
    }

    public function notificar($destino, $titulo, $mensagem, $arquivo = NULL,$modulo='Sistema',$idModulo=NULL,$deleteFile=false,$copia=NULL)
    {
        $mensagem = str_replace('<br>','<br/>',$mensagem);
        $this->load->library('email');
        $this->email->clear(TRUE);
//        $this->email->from($this->session->userdata('emailUsuario'), $this->session->userdata('nomeUsuario'));
        $this->email->from('noreply@XXX.com.br', $this->session->userdata('nomeUsuario'));
        $this->email->to($destino);
        $this->email->set_mailtype("html");
        if (!empty($copia)) {
            $this->email->cc($copia);
        }
        $this->email->subject(htmlspecialchars($titulo));
        $this->email->set_newline("\r\n");
        $this->email->message($mensagem);

        if (!empty($arquivo)) {
            foreach ($arquivo as $item) {
                $this->email->attach($item);
            }
        }
        $this->inserirEmailLog($idModulo,$titulo,$mensagem,$destino,$copia,$modulo);
        $r = $this->email->send();
        if (!$r) {
            $this->inserirAuditoria('ERRO-ENVIO-EMAIL','E',json_encode($this->email->print_debugger()));
        }
        if (!empty($arquivo) and $deleteFile==true) {
            foreach ($arquivo as $item) {
                unlink($item);
            }
        }
        return true;
    }
    public function inserirEmailLog($idModulo=NULL,$assunto = NULL, $mensagem = NULL, $listaTo_str = NULL,$emailCc_str=NULL,$modulo='Sistema')
    {
         $this->session->userdata();
        $data = array(
            'SEQ_USUARIO'=>$this->session->userdata('idUsuario'),
            'TIT_EMAIL'=>$assunto,
            'HTM_EMAIL'=>$mensagem,
            'DEST_EMAIL'=>$listaTo_str,
            'CC_EMAIL'=>$emailCc_str,
            'SEQ_MODULO'=>$idModulo,
            'MODULO_EMAIL' => $modulo
        );
        $this->EmailModelo->inserir($data);
    }
}
?>
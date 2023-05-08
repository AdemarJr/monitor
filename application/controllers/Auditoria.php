<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auditoria extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());
    }

    public function index()
    {
        $this->inserirAuditoria('CONSULTAR-OPERACAO','C','Listar Todos');
        $resultado['lista_operacao'] = $this->AuditoriaModelo->lista();
        $resultado['lista_usuario'] = $this->UsuarioModelo->listaUsuarioSemAdm();
        $this->loadUrl('modulos/operacao/consultar',$resultado);
    }

    public function consulta()
    {
        $this->inserirAuditoria('CONSULTAR-OPERACAO','C','Com Filtro');
        $resultado['periodo'] = $this->input->post('periodo');
        $resultado['usuarioFilter'] = $this->input->post('usuarioFilter');
        $resultado['lista_usuario'] = $this->UsuarioModelo->listaUsuarioSemAdm();
        $resultado['lista_operacao'] = $this->AuditoriaModelo->lista(
                $this->input->post('periodo'),
                $this->input->post('usuarioFilter'));
        $this->loadUrl('modulos/operacao/consultar',$resultado);

    }

    public function visualizar($id)
    {
        $auditoria = $this->AuditoriaModelo->editar($id);
        foreach ($auditoria as $index => $valor){

            $resultado = array(
                'data' => $valor['DATA_AUDITORIA'],
                'observacao' => $valor['OBS_AUDITORIA'],
                'tipo' => $valor['TIPO_AUDITORIA'],
                'operacao' => $valor['OPER_AUDITORIA'],
                'idUsuario' => $valor['SEQ_USUARIO'],
                'idAuditoria' => $valor['SEQ_AUDITORIA']
            );
        }
        $this->loadUrl('modulos/operacao/editar',$resultado);

    }

    public function deletar($id)
    {
        $this->load->model('auditoriaModelo', 'AuditoriaModelo');
        $this->inserirAuditoria('EXCLUIR-OPERACAO','E', 'SEQ_AUDITORIA:'.$id);
        $this->db->trans_begin();

        $this->AuditoriaModelo->deletar($id);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $class = 'error';
            $mensagem = 'Operacao Não Excluído!';
        }
        else
        {
            $this->db->trans_commit();
            $class = 'success';
            $mensagem = 'Operacao Excluido com sucesso!!';
        }

        $this->feedBack($class,$mensagem,'auditoria');

    }


}
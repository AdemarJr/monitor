<?php

class Release extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('releaseModelo', 'ReleaseModelo');
        $this->load->model('setorModelo', 'SetorModelo');
        $this->load->model('tipomateriaModelo', 'TipomateriaModelo');
        $this->auth->CheckAuth('geral', $this->router->fetch_class(), $this->router->fetch_method());
    }

    private function validaOperacao($target) {
        // verificar se existe cliente selecionado
        $clienteSessao = $this->session->userData('idClienteSessao');

        if (empty($clienteSessao)) {
            $class = 'warning';
            $mensagem = 'Cliente Não Selecionado!';
            $this->feedBack($class, $mensagem, $target);
        }

        // verifica se o cliente da sessao o usuario da sessao tem poder

        /* TODO */
    }

    public function index() {
        $this->inserirAuditoria('CONSULTAR-RELEASE', 'C', 'Lista Todos');
        $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();
        $resultado['ctrl'] = $this;
        $this->loadUrl('modulos/release/consultar', $resultado);
    }

    public function novo() {
        $resultado['lista_setor'] = $this->SetorModelo->listaSetor();
        $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria();
        $this->loadUrl('modulos/release/novo', $resultado);
    }
    
    public function getSetorPorID($setor, $release) {
        $this->db->where('SEQ_SETOR', $setor);
        $this->db->where('SEQ_RELEASE', $release);
        return $this->db->get('RELEASE_SECRETARIA')->row_array();
    }

    //salvar nova ordem de servico
    public function salvar() {
        $this->validaOperacao('release/novo');
        extract($this->input->post());

        $clienteSessao = $this->session->userData('idClienteSessao');
            //inserir release
            $data = array(
                'SEQ_CLIENTE' => $clienteSessao,
                'DESC_RELEASE' => $descricaoRelease,
                'SEQ_SETOR' => $setor,
                'SEQ_TIPO_MATERIA' => $this->input->post('tipo'),
                'TIT_MATERIA' => $this->input->post('titulo'),
                'PC_MATERIA' => tirarAcentos($this->input->post('palavra')),
                'TEXTO_MATERIA' => strip_tags($this->input->post('texto'), '<p>'),
                'IND_CLASSIFICACAO' => $this->input->post('classificacao'),
                'IND_AVALIACAO' => $this->input->post('avaliacao'),
                'IND_PAUTA' => empty($pauta) ? 'N' : $pauta,
                'DATA_ENVIO_RELEASE' => date('Y-m-d', strtotime(str_replace('/', '-', $dataEnvio))),
                'DATA' => str_replace('-', '', date('Y-m-d', strtotime(str_replace('/', '-', $dataEnvio)))),
                'IND_ATIVO' => 'S',
            );
            $this->inserirAuditoria('INSERIR-RELEASE', 'I', json_encode($data));
            $this->db->trans_begin();
            $idNew = $this->ReleaseModelo->inserir($data);
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $class = 'error';
                $mensagem = 'Release Não Incluída!';
                $this->feedBack($class, $mensagem, 'release');    
            } else {
                $this->db->trans_commit();
                foreach ($secretarias as $sec) {
                    $this->db->insert('RELEASE_SECRETARIA', array(
                        'SEQ_RELEASE' => $idNew,
                        'SEQ_SETOR' => $sec
                    ));
                }
                $class = 'success';
                $mensagem = 'Release Incluida com sucesso!!';
                $this->feedBack($class, $mensagem, 'release');    
            } 
    }

    public function editar($id) {

        $release = $this->ReleaseModelo->editar($id);

        foreach ($release as $index => $valor) {
            $resultado['descricaoRelease'] = $valor['DESC_RELEASE'];
            $resultado['dataEnvio'] = $valor['DATA_ENVIO_RELEASE'];
            $resultado['setor'] = $valor['SEQ_SETOR'];
            $resultado['pauta'] = $valor['IND_PAUTA'];
            $resultado['idRelease'] = $id;
            $resultado['tipo'] = $valor['SEQ_TIPO_MATERIA'];
            $resultado['titulo'] = $valor['TIT_MATERIA'];
            $resultado['palavra'] = $valor['PC_MATERIA'];
            $resultado['avaliacao'] = $valor['IND_AVALIACAO'];
            $resultado['classificacao'] = $valor['IND_CLASSIFICACAO'];
            $resultado['texto'] = $valor['TEXTO_MATERIA'];
            
        }
        $resultado['ctrl'] = $this;
        $resultado['lista_setor'] = $this->SetorModelo->listaSetor();
        $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria();
        $this->loadUrl('modulos/release/editar', $resultado);
    }

    public function alterar() {
        extract($this->input->post());
        $clienteSessao = $this->session->userData('idClienteSessao');

        $this->validaOperacao('release/editar/' . $idRelease);
   
        $data = array(
            'SEQ_CLIENTE' => $clienteSessao,
            'DESC_RELEASE' => $descricaoRelease,
            'SEQ_TIPO_MATERIA' => $this->input->post('tipo'),
            'TIT_MATERIA' => $this->input->post('titulo'),
            'PC_MATERIA' => tirarAcentos($this->input->post('palavra')),
            'TEXTO_MATERIA' => strip_tags($this->input->post('texto'), '<p>'),
            'IND_CLASSIFICACAO' => $this->input->post('classificacao'),
            'IND_AVALIACAO' => $this->input->post('avaliacao'),
            'SEQ_SETOR' => $setor,
            'IND_PAUTA' => empty($pauta) ? 'N' : $pauta,
            'DATA_ENVIO_RELEASE' => date('Y-m-d', strtotime(str_replace('/', '-', $dataEnvio))),
            'IND_ATIVO' => 'S',
            'DATA' => str_replace('-', '', date('Y-m-d', strtotime(str_replace('/', '-', $dataEnvio)))),
        );

        $this->inserirAuditoria('ALTERAR-RELEASE', 'A', json_encode($data));
        $this->db->trans_begin();
        $this->ReleaseModelo->alterar($data, $idRelease);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $class = 'error';
            $mensagem = 'Release Não Alterada!';
        } else {
            $this->db->trans_commit();
            $this->db->delete('RELEASE_SECRETARIA', array(
                'SEQ_RELEASE' => $idRelease
            ));
            foreach ($secretarias as $sec) {
                $this->db->insert('RELEASE_SECRETARIA', array(
                    'SEQ_RELEASE' => $idRelease,
                    'SEQ_SETOR' => $sec
                ));
            }
            $class = 'success';
            $mensagem = 'Release Alterada com sucesso!!';
        }
        $this->feedBack($class, $mensagem, 'release');
    }

    public function excluir($id) {
        $this->validaOperacao('release');
        $this->inserirAuditoria('EXCLUIR-RELEASE', 'E', 'ReleaseId: ' . $id);
        if ($this->ReleaseModelo->deletar($id)) {
            $class = 'success';
            $mensagem = 'Release Excluída com sucesso!!';
        } else {
            $class = 'error';
            $mensagem = 'Release Não pode ser Excluída!';
        }
        $this->feedBack($class, $mensagem, 'release');
    }

    public function ajaxReleaseSituacao($id, $sitNovo = NULL) {
        try {
            $data = array(
                'IND_ATIVO' => $sitNovo
            );
            $this->inserirAuditoria('ALTERAR-RELEASE', 'A', 'id:' . $id);
            $this->ReleaseModelo->alterar($data, $id);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            http_response_code(400);
        }
    }

    public function jobDesativaRelease($qtdDias) {


        try {
            $release = $this->ReleaseModelo->listaReleaseVencida($qtdDias);
            foreach ($release as $index => $valor) {
                $data = array(
                    'IND_ATIVO' => 'N'
                );
                $this->inserirAuditoria('ALTERAR-RELEASE', 'A', 'id:' . $valor['SEQ_RELEASE']);
                $this->ReleaseModelo->alterar($data, $valor['SEQ_RELEASE']);
            }
            echo 'SUCESSO';
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            http_response_code(400);
        }
    }

    public function ajaxReleaseById() {
        extract($this->input->post());
        try {

            $release = $this->ReleaseModelo->editar($id);
            $this->db->where('SEQ_RELEASE', $id);
            $secretarias = $this->db->get('RELEASE_SECRETARIA')->result_array();
            foreach ($release as $index => $valor) {
                $resultado['descricaoRelease'] = $valor['DESC_RELEASE'];
                $resultado['dataEnvio'] = $valor['DATA_ENVIO_RELEASE'];
                $resultado['idRelease'] = $id;
                $resultado['tipo'] = $valor['SEQ_TIPO_MATERIA'];
                $resultado['titulo'] = $valor['TIT_MATERIA'];
                $resultado['palavra'] = $valor['PC_MATERIA'];
                $resultado['avaliacao'] = $valor['IND_AVALIACAO'];
                $resultado['classificacao'] = $valor['IND_CLASSIFICACAO'];
                $resultado['texto'] = $valor['TEXTO_MATERIA'];
                $resultado['secretarias'] = !empty($secretarias) ? $secretarias : '';
            }
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            http_response_code(400);
        }

        echo json_encode(array('status' => 'success', 'item' => $resultado));
    }

}

<?php

/**
 * Description of Alerta
 *
 * @author Galileu Garcia
 */
class Alerta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('releaseModelo', 'ReleaseModelo');
        $this->load->model('MateriaModeloMonitor', 'MateriaModelo');
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
            $resultado['lista_dias'] = $this->MateriaModelo->getConsulta($chave, $perPage, $page);
            $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();
            return array($resultado, $header);
        } else {
            return null;
        }
    }

    public function tela($chave = NULL) {
        if (empty($chave)) {
            $this->load->view('modulos/template/404');
            return;
        } else {
            $this->session->set_userdata('codigo', $chave);
            $dados = $this->dados($chave);

            if (isset($_SESSION['data_calendario'])) {
                
            } else {
                $this->session->set_userdata('data_calendario', implode('/', array_reverse(explode('-', $dados[0]['lista_dias'][0]['DIA']))));
            }
            $this->load->view('modulos/publico/alerta/includes/topo', $dados[1]);
            $this->load->view('modulos/publico/alerta/tela', $dados[0]);
        }
    }

    public function filtra() {
        $chave = $this->input->post('chave');

        $filtro = [
            'termo' => $this->input->post('termo'),
            'grupo-v' => $this->input->post('grupo-v') != null ? $this->input->post('grupo-v') : 'off',
            'grupo-av' => $this->input->post('grupo-av') != null ? $this->input->post('grupo-av') : 'off',
            'grupo_veiculo' => $this->input->post('grupo-veiculo'),
            'grupo_avaliacao' => $this->input->post('grupo-avaliacao'),
            'ordem' => $this->input->post('ordem')
        ];

        $this->session->set_userdata('filtro', $filtro);

        redirect('alerta/' . $chave);
    }

    public function limpafiltro($chave) {
        $this->session->unset_userdata('filtro');
        redirect('alerta/' . $chave);
    }

    public function alteravaliacao($materia, $avaliacao) {
        if (!isset($_SESSION['loginUsuario'])) {
            redirect();
        }
        $this->db->update('MATERIA', array(
            'IND_AVALIACAO' => $avaliacao
                ), array(
            'SEQ_MATERIA' => $materia
        ));
        if ($avaliacao == 'N') {
            echo json_encode(array('avaliacao' => 'Negativa', 'cor' => '#F44336'));
        } else if ($avaliacao == 'T') {
            echo json_encode(array('avaliacao' => 'Neutra', 'cor' => '#757575'));
        } else {
            echo json_encode(array('avaliacao' => 'Positiva', 'cor' => '#4CAF50'));
        }
    }

    public function apagamateria($id) {
        if (!isset($_SESSION['loginUsuario'])) {
            redirect();
        }
        $this->load->model('materiaModelo', 'MateriaModelo');
        $this->inserirAuditoria('EXCLUIR-MATERIA', 'E', 'MateriaId: ' . $id);
        $dataMateria = $this->MateriaModelo->getMateria($id)->row();

        if (!empty($dataMateria) and ( ($dataMateria->SEQ_USUARIO == $this->session->userdata('idUsuario')) or ( $this->session->userdata('perfilUsuario') == 'ROLE_ADM') or ( $this->session->userdata('idUsuario') == 7) or ( $this->session->userdata('idUsuario') == 20) or ( $this->session->userdata('idUsuario') == 60) or ( $this->session->userdata('idUsuario') == 30)
                )
                and $this->MateriaModelo->deletar($id)) {
            $class = 'success';
            $mensagem = 'Matéria excluída com sucesso';
            $situacao = 1;
        } else {
            $class = 'error';
            if (!empty($dataMateria) and $dataMateria->SEQ_USUARIO == $this->session->userdata('idUsuario')) {
                $mensagem = 'Matéria não pode ser excluída!';
                $situacao = 0;
            } else {
                $mensagem = 'Matéria não pode ser excluída, pois foi cadastrada por outro usuário';
                $situacao = 0;
            }
        }

        echo json_encode(array('msg' => $mensagem, 'situacao' => $situacao));
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
        $this->AuditoriaModelo->inserir($tb_auditoria);
    }

    public function calendario($data) {
        $SQL = "SELECT * FROM `NOTA` 
                WHERE DATE(DT_INICIO) = '" . $data . "' 
                AND `IND_ATIVO` = 'S'
                AND TIT_NOTIFICACAO IS NULL
                AND SEQ_CLIENTE = " . $_SESSION['idClienteSessaoAlerta'] . "
                AND LISTA_SETOR IS NOT NULL";
        $chave = $this->db->query($SQL)->row_array()['CHAVE_NOTIFICACAO'];
        $this->session->unset_userdata('filtro');
        $this->session->set_userdata('data_calendario', implode('/', array_reverse(explode('-', $data))));
        echo json_encode(array('chave' => $chave));
    }

    public function alertamsg($id_cliente) {
        $this->session->set_userdata('idClienteSessao', $id_cliente);
    }
    
    public function seleciona($id)
    {
        $this->inserirAuditoria('SETA-CLIENTE-SESSAO','A','ClienteId: '.$id);
        try
        {
            $data= array('idClienteSessao'=>'','temaClienteSessao'=>'');
            $this->session->unset_userdata($data);

            $clienteTema = $this->ComumModelo->getTableData('CLIENTE', array('SEQ_CLIENTE' => $id))->row()->TEMA_CLIENTE;

            $data= array('idClienteSessao'=>$id,'eSelecao'=>false,'temaClienteSessao'=>$clienteTema);
            $this->session->set_userdata($data);
                $class = 'success';
                $mensagem = 'Cliente Selecionado com sucesso!!';
        }catch (Exception $e) {
            $class = 'error';
            $mensagem = 'Cliente Não pode ser Selecionado!';
        }

        redirect('clipping');
    }
}

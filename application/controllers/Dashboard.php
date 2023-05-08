<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Description of Dashboard
 *
 * @author galil
 */
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_Model', 'dash');
        $this->load->model('ComumModelo', 'ComumModelo');
        $this->load->model('materiaModelo', 'MateriaModelo');
    }
    
    public function tela() {
        if (isset($_SESSION['logado'])) {
            if (empty($_SESSION['GRUPO'])) {
                $this->session->set_userdata('GRUPO', 15);
            }
            if (empty($_SESSION['DATA_INICIAL'])) {
                $this->session->set_userdata('DATA_INICIAL', date('d/m/Y', strtotime('-1 days')));
            }
            if (empty($_SESSION['DATA_FINAL'])) {
                $this->session->set_userdata('DATA_FINAL', date('d/m/Y'));
            }

            $resultado = [
                'ctrl' => $this,
            ];
            //$this->dash->atualiza(0);
            $this->session->set_userdata('idClienteSessao', 1);
            $this->load->view('modulos/dashboard/tela', $resultado);
        } else {
            redirect('');
        }
    }
    
    public function verificaAtualizacao() {
        $atua = $this->dash->verificaAtualiza();
        echo json_encode($atua);
    }
    
    public function atualizacao() {
        $this->dash->atualiza($_POST['atualiza']);
    }
    
    public function internet() {
        if (isset($_SESSION['DATA_INICIAL'])) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
        }
        if (isset($_SESSION['DATA_FINAL'])) {
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
        }

        $veiculos = $this->dash->veiculosInternet($periodoIni, $periodoFim);

        echo json_encode(array('dados' => $veiculos));
    }
    
    
    // FUNÇÕES ASSICRONAS
    public function carregaVeiculosMonitorados() {
        $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
        $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
        $idCliente = $this->session->userData('idClienteSessao');
        $grupo = 15;
        $datae = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
        $dataef = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
        $tipo = '';
        $total = count($this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo));
        echo json_encode(array('TOTAL' => $total));
    }

    public function geral() {
        $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
        $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
        $idCliente = $this->session->userData('idClienteSessao');
        $grupo = 0;
        $datae = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
        $dataef = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
        $tipo = '';
        $itens = $this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
        $total = 0;
        foreach ($itens as $valor) {
            $total += $valor['quantidade'];
        }
        return $total;
    }
    
    public function materias($avaliacao) {
        $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
        $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
        switch ($_SESSION['GRUPO']) {
            case 15:
                $materias = $this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, base64_decode($avaliacao),
                                NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 15, NULL, NULL);
                break;
            case 1:
                $itens = $this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $this->session->userData('idClienteSessao'), 0, $datai, $dataf, '');
            case 2:
                $materias = $this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, base64_decode($avaliacao),
            NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL);
            case 3:
                $materias = $this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, base64_decode($avaliacao),
            NULL, NULL, NULL, NULL, NULL, 'R', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL); 
            case 4:
                $materias = $this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, base64_decode($avaliacao),
            NULL, NULL, NULL, NULL, NULL, 'T', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL);    
            default:
                break;
        }
        
        $this->load->view('modulos/dashboard/materias', array('materias' => $materias, 'ctrl' => $this));
    }
    
    public function portal($param) {
        $this->db->select('NOME_PORTAL');
        $this->db->where('SEQ_PORTAL', $param);
        return $this->db->get('PORTAL')->row_array()['NOME_PORTAL'];
    }
    
    public function carregaMateriasCadastrados() {

        if ($_SESSION['GRUPO'] == 15) {
            $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $consulta = $this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, NULL,
            NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 15, NULL, NULL);
            $total = count($consulta);
            $positivas =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'P',
            NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 15, NULL, NULL));
            $negativas =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'N',
            NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 15, NULL, NULL));
            $neutras =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'T',
            NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 15, NULL, NULL));
            
            $totalP = count($this->dash->totalPortal());
            
            echo json_encode(array('TOTAL' => $total, 'P' => $positivas,'N' => $negativas, 'T' => $neutras, 'M' => $totalP));
            
        } else if ($_SESSION['GRUPO'] == 1){
            
            $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $idCliente = $this->session->userData('idClienteSessao');
            $grupo = 0;
            $datae = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataef = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $tipo = '';
            $itens = $this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
            $tot = count($itens);
            $total = 0;
            foreach ($itens as $index => $valor) {
                $total += $valor['quantidade'];
            }
            $this->session->set_userdata('TOTAL_RELEASE', $total);
            echo json_encode(array('TOTAL' => $total, 'VEICULOS' => $tot));
        } else if ($_SESSION['GRUPO'] == 2){
            $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $consulta = $this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, NULL,
            NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL);
            $total = count($consulta);
            $positivas =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'P',
            NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL));
            $negativas =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'N',
            NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL));
            $neutras =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'T',
            NULL, NULL, NULL, NULL, NULL, 'S', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL));
                        
            echo json_encode(array('TOTAL' => $total, 'P' => $positivas,'N' => $negativas, 'T' => $neutras));
        } elseif ($_SESSION['GRUPO'] == 3) {
            $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $consulta = $this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, NULL,
            NULL, NULL, NULL, NULL, NULL, 'R', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL);
            $total = count($consulta);
            $positivas =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'P',
            NULL, NULL, NULL, NULL, NULL, 'R', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL));
            $negativas =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'N',
            NULL, NULL, NULL, NULL, NULL, 'R', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL));
            $neutras =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'T',
            NULL, NULL, NULL, NULL, NULL, 'R', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL));
            
            
            echo json_encode(array('TOTAL' => $total, 'P' => $positivas,'N' => $negativas, 'T' => $neutras));
        } elseif ($_SESSION['GRUPO'] == 4) {
            $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $consulta = $this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, NULL,
            NULL, NULL, NULL, NULL, NULL, 'T', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL);
            $total = count($consulta);
            $positivas =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'P',
            NULL, NULL, NULL, NULL, NULL, 'T', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL));
            $negativas =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'N',
            NULL, NULL, NULL, NULL, NULL, 'T', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL));
            $neutras =  count($this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, NULL, NULL, NULL, 'T',
            NULL, NULL, NULL, NULL, NULL, 'T', NULL, NULL, $datai, $dataf, 0, 0, NULL, NULL));
                        
            echo json_encode(array('TOTAL' => $total, 'P' => $positivas,'N' => $negativas, 'T' => $neutras));
        } elseif ($_SESSION['GRUPO'] == 5) {
            $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $idCliente = $this->session->userData('idClienteSessao');
            $grupo = 15;
            $datae = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataef = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $tipo = '';
            $itens = $this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
            $tot = count($itens);
            $total = 0;
            foreach ($itens as $index => $valor) {
                $total += $valor['quantidade'];
            }
            $this->session->set_userdata('TOTAL_RELEASE', $total);
            echo json_encode(array('TOTAL' => $total, 'P' => $total,'N' => 0, 'T' => 0));
        }
        
    }

    public function carregaMateriasCadastradosNegativas() {
        if (isset($_SESSION['DATA_INICIAL'])) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
        }
        if (isset($_SESSION['DATA_FINAL'])) {
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
        }
        $avaliacao = $this->dash->avaliacaoInternet($periodoIni, $periodoFim);

        echo json_encode(array('dados' => $avaliacao));
    }

    public function carregaGraficoVeiculos() {
        if ($_SESSION['GRUPO'] == 1) {
            $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $idCliente = $this->session->userData('idClienteSessao');
            $grupo = 0;
            $datae = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataef = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $tipo = '';
            $itens = $this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
            echo json_encode(array('dados' => $itens));
        } else if ($_SESSION['GRUPO'] == 15 || $_SESSION['GRUPO'] == 2) {
            $this->internet();
        } else if ($_SESSION['GRUPO'] == 3) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
            $veiculos = $this->dash->veiculosRadio($periodoIni, $periodoFim);
            echo json_encode(array('dados' => $veiculos));
        } else if ($_SESSION['GRUPO'] == 4) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
            $veiculos = $this->dash->veiculosTV($periodoIni, $periodoFim);
            echo json_encode(array('dados' => $veiculos));
        } else if ($_SESSION['GRUPO'] == 5) {
            $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $idCliente = $this->session->userData('idClienteSessao');
            $grupo = 15;
            $datae = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataef = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $tipo = '';
            $itens = $this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
            echo json_encode(array('dados' => $itens));
        }
    }

    public function carregaGraficoAvaliacao() {
        if (isset($_SESSION['DATA_INICIAL'])) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
        }
        if (isset($_SESSION['DATA_FINAL'])) {
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
        }
        if ($_SESSION['GRUPO'] == 15 || $_SESSION['GRUPO'] == 2) {
            $avaliacao = $this->dash->avaliacaoInternet($periodoIni, $periodoFim);
        } else if ($_SESSION['GRUPO'] == 1) {
            $total = $this->geral();
            $avaliacao = [
                array('name' => 'POSITIVO', 'value' => $total, 'cor' => '#43a047'),
                array('name' => 'NEGATIVO', 'value' => 0, 'cor' => '#d32f2f'),
                array('name' => 'NEUTRO', 'value' => 0, 'cor' => '#f9a825'),
            ];
        } else if ($_SESSION['GRUPO'] == 3) {
            $avaliacao = $this->dash->avaliacaoRadio($periodoIni, $periodoFim);
        } else if ($_SESSION['GRUPO'] == 4) {
            $avaliacao = $this->dash->avaliacaoTV($periodoIni, $periodoFim);
        } else if ($_SESSION['GRUPO'] == 5) {
            $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $idCliente = $this->session->userData('idClienteSessao');
            $grupo = 15;
            $datae = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
            $dataef = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
            $tipo = '';
            $itens = $this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
            $total = 0;
            foreach ($itens as $valor) {
                $total += $valor['quantidade'];
            }
            
            $avaliacao = [
                array('name' => 'POSITIVO', 'value' => $total, 'cor' => '#43a047'),
                array('name' => 'NEGATIVO', 'value' => 0, 'cor' => '#d32f2f'),
                array('name' => 'NEUTRO', 'value' => 0, 'cor' => '#f9a825'),
            ];
            
        }
        echo json_encode(array('dados' => $avaliacao));
    }

    public function filtra() {
        $dataInicio = $this->input->post('inicio');
        $dataFim = $this->input->post('fim');
        $grupo = $this->input->post('grupo');

        if (empty($dataInicio) || empty($dataFim)) {
            redirect('dashboard');
        } else {
            $this->session->set_userdata('DATA_INICIAL', $dataInicio);
            $this->session->set_userdata('DATA_FINAL', $dataFim);
            $this->session->set_userdata('GRUPO', $grupo);
            redirect('dashboard');
        }
    }

    public function diferencaDatas() {
        $dateStart = new \DateTime(implode('-', array_reverse(explode('/', $_SESSION['DATA_INICIAL']))));
        $dateNow = new \DateTime(implode('-', array_reverse(explode('/', $_SESSION['DATA_FINAL']))));

        return $dateStart->diff($dateNow);
    }
    
    public function rankingTV() {
        if (isset($_SESSION['DATA_INICIAL'])) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
        }
        if (isset($_SESSION['DATA_FINAL'])) {
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
        }
        
        $requestData = $_REQUEST;

        $draw = $_POST['draw'];
        
        $veiculos = $this->dash->veiculosTVTable($periodoIni, $periodoFim, $requestData['start'], $requestData['length']);
        $total = count($this->dash->veiculosTV($periodoIni, $periodoFim));
        
        $dados = array();
        if ($draw == 1) {
            $i = 1;
        } else {
            $i = $requestData['start'] + 1;
        }
        foreach ($veiculos as $vec) {
            $dado = array();
            $dado[] = $i.'º';
            $dado[] = $vec['site'];
            $av = $this->dash->avaliaTV($periodoIni, $periodoFim, $vec['sitecodigo'], 'P');
            if (!empty($av)) {
                $dado[] = $av['QUANTIDADE'];
            } else {
                $dado[] = 0;
            }
            
            $av = $this->dash->avaliaTV($periodoIni, $periodoFim, $vec['sitecodigo'], 'N');
            if (!empty($av)) {
                $dado[] = $av['QUANTIDADE'];
            } else {
                $dado[] = 0;
            }
            
            $av = $this->dash->avaliaTV($periodoIni, $periodoFim, $vec['sitecodigo'], 'T');
            if (!empty($av)) {
                $dado[] = $av['QUANTIDADE'];
            } else {
                $dado[] = 0;
            }
            
            $dado[] = $vec['quantidade'];
            $i++;
            $dados[] = $dado;
        }
        
        $json_data = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($total),
            "recordsFiltered" => intval($total),
            "data" => $dados
        );
        
        echo json_encode($json_data);
        
    }
    
    public function rankingRadio() {
        if (isset($_SESSION['DATA_INICIAL'])) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
        }
        if (isset($_SESSION['DATA_FINAL'])) {
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
        }
        
        $requestData = $_REQUEST;

        $draw = $_POST['draw'];
        
        $veiculos = $this->dash->veiculosRadioTable($periodoIni, $periodoFim, $requestData['start'], $requestData['length']);

        $total = count($this->dash->veiculosRadio($periodoIni, $periodoFim));
        
        $dados = array();
        if ($draw == 1) {
            $i = 1;
        } else {
            $i = $requestData['start'] + 1;
        }
        foreach ($veiculos as $vec) {
            $dado = array();
            $dado[] = $i.'º';
            $dado[] = $vec['site'];
            $av = $this->dash->avaliaRadio($periodoIni, $periodoFim, $vec['sitecodigo'], 'P');
            if (!empty($av)) {
                $dado[] = $av['QUANTIDADE'];
            } else {
                $dado[] = 0;
            }
            
            $av = $this->dash->avaliaRadio($periodoIni, $periodoFim, $vec['sitecodigo'], 'N');
            if (!empty($av)) {
                $dado[] = $av['QUANTIDADE'];
            } else {
                $dado[] = 0;
            }
            
            $av = $this->dash->avaliaRadio($periodoIni, $periodoFim, $vec['sitecodigo'], 'T');
            if (!empty($av)) {
                $dado[] = $av['QUANTIDADE'];
            } else {
                $dado[] = 0;
            }
            
            $dado[] = $vec['quantidade'];
            $i++;
            $dados[] = $dado;
        }
        
        $json_data = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($total),
            "recordsFiltered" => intval($total),
            "data" => $dados
        );
        
        echo json_encode($json_data);
        
    }
    
    public function ranking() {
        $colunas = array(
            '0' => '2',
        );
        
        $requestData = $_REQUEST;

        $ordem = $colunas[$requestData['order'][0]['column']] . ' ' . $requestData['order'][0]['dir'];
        $limit = $requestData['start'] . " ," . $requestData['length'];
        $draw = $_POST['draw'];
        
        $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
        $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
        $idCliente = $this->session->userData('idClienteSessao');
        $grupo = 0;
        $datae = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
        $dataef = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
        $tipo = '';
        $itens = $this->dash->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo, $ordem, $limit);
        $total = count($this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo));

        $totalRegistro = count($itens);
        $dados = array();
        if ($draw == 1) {
            $i = 1;
        } else {
            $i = $requestData['start'] + 1;
        }
        foreach ($itens as $veiculo) {
            $av = $this->getAvaliacao($veiculo['sitecodigo'], 1);
            if ($_SESSION['GRUPO'] == 1) {
            $dado = array();
            $dado[] = $i.'º';
            $dado[] = $veiculo['site'];
            $dado[] = $av['QUANTIDADE'];
            $dado[] = 0;
            $dado[] = 0;
            $dado[] = $veiculo['quantidade'];
            }
            $i++;
            $dados[] = $dado;
        }

        
        
        $json_data = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($total),
            "recordsFiltered" => intval($total),
            "data" => $dados,
        );
        
        echo json_encode($json_data);

    }
    
    public function rankingPrioritarioRelease() {
        $colunas = array(
            '0' => '2',
        );
        
        $requestData = $_REQUEST;

        $ordem = $colunas[$requestData['order'][0]['column']] . ' ' . $requestData['order'][0]['dir'];
        $limit = $requestData['start'] . " ," . $requestData['length'];
        $draw = $_POST['draw'];
        
        $datai = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
        $dataf = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
        $idCliente = $this->session->userData('idClienteSessao');
        $grupo = 15;
        $datae = empty($_SESSION['DATA_INICIAL']) ? date('d/m/Y', strtotime('-1 days')) : $_SESSION['DATA_INICIAL'];
        $dataef = empty($_SESSION['DATA_FINAL']) ? date('d/m/Y') : $_SESSION['DATA_FINAL'];
        $tipo = '';
        $itens = $this->dash->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo, $ordem, $limit);
        $total = count($this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo));

        $totalRegistro = count($itens);
        $dados = array();
        if ($draw == 1) {
            $i = 1;
        } else {
            $i = $requestData['start'] + 1;
        }
        foreach ($itens as $veiculo) {
            $av = $this->getAvaliacao($veiculo['sitecodigo'], 1);
            if ($_SESSION['GRUPO'] == 5) {
            $dado = array();
            $dado[] = $i.'º';
            $dado[] = $veiculo['site'];
            $dado[] = $av['QUANTIDADE'];
            $dado[] = 0;
            $dado[] = 0;
            $dado[] = $veiculo['quantidade'];
            }
            $i++;
            $dados[] = $dado;
        }

        
        
        $json_data = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($total),
            "recordsFiltered" => intval($total),
            "data" => $dados,
        );
        
        echo json_encode($json_data);

    }

    public function rankingPrioritario() {
        if (isset($_SESSION['DATA_INICIAL'])) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
        }
        if (isset($_SESSION['DATA_FINAL'])) {
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
        }
        
        $colunas = array(
            '0' => '2',
        );
        
        $requestData = $_REQUEST;

        $ordem = $colunas[$requestData['order'][0]['column']] . ' ' . $requestData['order'][0]['dir'];
        $limit = $requestData['start'] . " ," . $requestData['length'];
        $draw = $_POST['draw'];
        
        $veiculos = $this->dash->veiculosInternetTable($periodoIni, $periodoFim, $ordem, $requestData['start'], $requestData['length']);
        $total = count($this->dash->veiculosInternet($periodoIni, $periodoFim));
        
        $dados = array();
        if ($draw == 1) {
            $i = 1;
        } else {
            $i = $requestData['start'] + 1;
        }
        foreach ($veiculos as $vec) {
            $dado = array();
            $dado[] = $i.'º';
            $dado[] = $vec['site'];
            $av = $this->dash->avalia($periodoIni, $periodoFim, $vec['sitecodigo'], 'P');
            if (!empty($av)) {
                $dado[] = $av['QUANTIDADE'];
            } else {
                $dado[] = 0;
            }
            
            $av = $this->dash->avalia($periodoIni, $periodoFim, $vec['sitecodigo'], 'N');
            if (!empty($av)) {
                $dado[] = $av['QUANTIDADE'];
            } else {
                $dado[] = 0;
            }
            
            $av = $this->dash->avalia($periodoIni, $periodoFim, $vec['sitecodigo'], 'T');
            if (!empty($av)) {
                $dado[] = $av['QUANTIDADE'];
            } else {
                $dado[] = 0;
            }
            
            $dado[] = $vec['quantidade'];
            $i++;
            $dados[] = $dado;
        }
        
        $json_data = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($total),
            "recordsFiltered" => intval($total),
            "data" => $dados
        );
        
        echo json_encode($json_data);
        
    }
    
    public function getAvaliacao($veiculo, $op) {
        if (isset($_SESSION['DATA_INICIAL'])) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
        }
        if (isset($_SESSION['DATA_FINAL'])) {
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
        }
        
        $avaliacao = $this->dash->av($periodoIni, $periodoFim, $veiculo, $op);
        return $avaliacao;
        
    }

}

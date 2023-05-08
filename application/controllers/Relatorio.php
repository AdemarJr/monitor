<?php

use MY_Controller;
//error_reporting(-1);
//ini_set('display_errors', 1); 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';

class Relatorio extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('usuarioModelo', 'UsuarioModelo');
        $this->load->model('materiaModelo', 'MateriaModelo');
        $this->load->model('veiculoModelo', 'VeiculoModelo');
        $this->load->model('setorModelo', 'SetorModelo');
        $this->load->model('tipomateriaModelo', 'TipomateriaModelo');
        $this->load->model('releaseModelo', 'ReleaseModelo');
        $this->auth->CheckAuth('geral', $this->router->fetch_class(), $this->router->fetch_method());
    }
    
    function dataAmericana($originalDate) {
        if (!empty($originalDate)) {
            $DateTime = DateTime::createFromFormat('d/m/Y', $originalDate);
            return $DateTime->format('Y-m-d');
        } else {
            return '';
        }
    }
    
    public function veiculosInternet($mes, $cliente) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . $mes);
        $this->db->where('MATERIA.SEQ_CLIENTE', $cliente);
        $this->db->select("P.SEQ_PORTAL AS sitecodigo,P.NOME_PORTAL as site, COUNT(MATERIA.SEQ_MATERIA) AS quantidade");
        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = MATERIA.SEQ_PORTAL');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        $this->db->group_by("P.SEQ_PORTAL");
        $this->db->where("MATERIA.TIPO_MATERIA='S'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('COUNT(MATERIA.SEQ_MATERIA) DESC');
        $this->db->limit(10);
        $result = $this->db->get()->result_array();
        
        return $result;
    }
    
    public function avalia($mes, $cliente, $veiculo, $avalia) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . $mes);
        $this->db->where('MATERIA.SEQ_CLIENTE', $cliente);
        $this->db->select("COUNT(MATERIA.SEQ_MATERIA) AS QUANTIDADE");
        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = MATERIA.SEQ_PORTAL');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by("MATERIA.IND_AVALIACAO");
        $this->db->where("P.SEQ_PORTAL", $veiculo);
        $this->db->where("MATERIA.IND_AVALIACAO", $avalia);
        $this->db->from('MATERIA MATERIA');
        $result = $this->db->get()->row_array();
        return $result;
    }
    private function periodo($mes) {
        switch (trim($mes)) {
            case 'Janeiro':
                $primeiro_dia = '01/01/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'01','01',date('Y'))).'/01/'.date('Y');
                break;
            case 'Fevereiro':
                $primeiro_dia = '01/02/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'02','02',date('Y'))).'/02/'.date('Y');
                break;
            case 'MarÇo':
                $primeiro_dia = '01/03/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'03','03',date('Y'))).'/03/'.date('Y');
                break;
            case 'Abril':
                $primeiro_dia = '01/04/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'04','04',date('Y'))).'/04/'.date('Y');
                break;
            case 'Maio':
                $primeiro_dia = '01/05/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'05','05',date('Y'))).'/05/'.date('Y');
                break;
            case 'Junho':
                $primeiro_dia = '01/06/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'06','06',date('Y'))).'/06/'.date('Y');
                break;
            case 'Julho':
                $primeiro_dia = '01/07/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'07','07',date('Y'))).'/07/'.date('Y');
                break;
            case 'Agosto':
                $primeiro_dia = '01/08/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'08','08',date('Y'))).'/08/'.date('Y');
                break;
            case 'Setembro':
                $primeiro_dia = '01/09/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'09','09',date('Y'))).'/09/'.date('Y');
                break;
            case 'Outubro':
                $primeiro_dia = '01/10/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'10','10',date('Y'))).'/10/'.date('Y');
                break;
            case 'Novembro':
                $primeiro_dia = '01/11/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'11','11',date('Y'))).'/11/'.date('Y');
                break;
            case 'Dezembro':
                $primeiro_dia = '01/12/'.date('Y');
                $ultimo_dia = date("t", mktime(0,0,0,'12','12',date('Y'))).'/12/'.date('Y');
                break;
            default:
                break;
        }
        return array('primeiro_dia' => $primeiro_dia, 'ultimo_dia' => $ultimo_dia);
    }
    private function totalMaterias($cliente, $mes, $meStr) { 
        $this->load->model('ComumModelo', 'ComumModelo');
        $this->db->select('NOME_CLIENTE');
        $this->db->where('SEQ_CLIENTE', $cliente);
        $nomeCliente = $this->db->get('CLIENTE')->row_array()['NOME_CLIENTE'];
        
        //TOTAL DE MATERIAS POSITIVA, NEGATIVAS E NEUTRAS
        $this->db->select('IND_AVALIACAO, COUNT(*) AS TOTAL_MATERIAS');
        $this->db->where('DATA_PUB_NUMERO BETWEEN '.$mes);
        $this->db->where('SEQ_CLIENTE', $cliente);
        $this->db->where('IND_AVALIACAO IS NOT NULL');
        $this->db->where('TIPO_MATERIA', 'S');
        $this->db->group_by('IND_AVALIACAO');
        $this->db->order_by('COUNT(*)', 'DESC');
        $res = $this->db->get('MATERIA')->result();
        
        $positiva = $res[0]->TOTAL_MATERIAS;

        $negativa = $res[1]->TOTAL_MATERIAS;

        $neutra = $res[2]->TOTAL_MATERIAS;
        
        $totalMaterias = $positiva + $negativa + $neutra;
        // FIM DO TOTAL
        
        // MENÇÕES AO GOVERNADOR
        $this->db->where('DATA_PUB_NUMERO BETWEEN '.$mes);
        $this->db->where('SEQ_CLIENTE', $cliente);
        $this->db->where("SEQ_SETOR", 623);
        $this->db->where('IND_AVALIACAO IS NOT NULL');
        $this->db->where('TIPO_MATERIA', 'S');
        $mencoes = count($this->db->get('MATERIA')->result());

        // FIM DAS MENÇÕES
        $periodo = $this->periodo($meStr); 
        $lista_setor3= $this->ComumModelo->quantitativoSetorInternet($periodo['primeiro_dia'],$periodo['ultimo_dia'],$cliente,'S',NULL,NULL,'623, 657', NULL);
        
        $porPosit = ($positiva * 100) / $totalMaterias;
        $porNega = ($negativa * 100) / $totalMaterias;
        $porNeu = ($neutra * 100) / $totalMaterias;
        $veiculos = $this->veiculosInternet($mes, $cliente);
        $info = array();
        $this->db->select('P.NOME_PORTAL,COUNT(*) AS MATERIAS, FORMAT(P.PRECO_UNITARIO,2,"de_DE") AS PRECO_UNITARIO, FORMAT((COUNT(*) * P.PRECO_UNITARIO),2,"de_DE") AS PRECO_TOTAL, (COUNT(*) * P.PRECO_UNITARIO) AS PRECO_REAL ');
        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = M.SEQ_PORTAL');
        $this->db->where_in('M.SEQ_PORTAL', array('59035', '59023', '59020', '59029', '59022'));
        $this->db->where('M.DATA_PUB_NUMERO BETWEEN '.$mes);
        $this->db->where_in('M.IND_AVALIACAO', array('P', 'T'));
        $this->db->group_by('M.SEQ_PORTAL');
        $this->db->order_by('COUNT(*) DESC');
        $preco = $this->db->get('MATERIA M')->result();
        $preco_total = 0;
 
        foreach ($preco as $valor) {
            $preco_total += (float)$valor->PRECO_REAL;
        }
        
        foreach ($veiculos as $vec) {
            $dado = array();
            $dado['site'] = $vec['site'];
            $av = $this->avalia($mes, $cliente, $vec['sitecodigo'], 'P');
            if (!empty($av)) {
                $dado['P'] = $av['QUANTIDADE'];
            } else {
                $dado['P'] = 0;
            }
            $av = $this->avalia($mes, $cliente, $vec['sitecodigo'], 'N');
            if (!empty($av)) {
                $dado['N'] = $av['QUANTIDADE'];
            } else {
                $dado['N'] = 0;
            }
            $av = $this->avalia($mes, $cliente, $vec['sitecodigo'], 'T');
            if (!empty($av)) {
                $dado['T'] = $av['QUANTIDADE'];
            } else {
                $dado['T'] = 0;
            }
            
            $info[] = $dado;
        }

        $dados = [
            'nome' => $nomeCliente,
            'totalMateriasPositivas' => $positiva,
            'totalMateriasNegativas' => $negativa,
            'totalMateriasNeutras' => $neutra,
            'totaismencoes' => $mencoes,
            'porcentagemPositiva' => number_format($porPosit, 2, ',', '.'),
            'porcentagemNegativa' => number_format($porNega, 2, ',', '.'),
            'porcentagemNeutra'   => number_format($porNeu, 2, ',', '.'),
            'tbl' => $info,
            'preco' => $preco,
            'total_preco' => number_format($preco_total, 2, '.', ','),
            'materiasInternet' => $lista_setor3
        ];
        echo '<pre>';
        print_r($dados);
        die();
        return $dados;
    }
    
    public function gerarelatorioespecial() {
        extract($this->input->post());
        
        //$data = strftime('%A, %d de %B de %Y', strtotime($row_artigo['data']));
        if ($veiculo == 40) {
        $periodo = explode('-', $mes);    
        $dataMes = $this->periodo($periodo[1]);
        $dtF = strftime('%d', strtotime(implode('-', array_reverse(explode('/', $dataMes['ultimo_dia'])))));
        
        $dados = $this->totalMaterias($veiculo, $periodo[0], $periodo[1]);
        $r['nC'] = $dados['nome'];
        
        $r['dt']  = '01 a '.$dtF.' de '. mb_strtolower($periodo[1]).' de '.date('Y');
        $r['tmC'] = $dados['totaismencoes']; // TOTAL DE MENÕES
        $r['mC']  = 'positivas'; // MENÇÕES
        
        $r['P'] = $dados['totalMateriasPositivas']; // TOTAL DE MATERIAS POSITIVAS
        $r['N'] = $dados['totalMateriasNegativas']; // TOTAL DE MATERIAS NEGATIVAS
        $r['T'] = $dados['totalMateriasNeutras']; // TOTAL DE MATERIAS NEUTRAS
        $r['tM']  =  $r['P'] + $r['N'] + $r['T'];
        $r['i'] =  $dados['materiasInternet'][0]['TOTAL']; // TOTAL DE MATERIAS DE INTERNET
        $r['Pi'] = $dados['materiasInternet'][0]['POSITIVO']; // TOTAL DE MATERIAS POSITIVAS DE INTERNET
        $r['Ni'] = $dados['materiasInternet'][0]['NEGATIVO']; // TOTAL DE MATERIAS NEGATIVAS DE INTERNET
        $r['Ti'] = $dados['materiasInternet'][0]['NEUTRO']; // TOTAL DE MATERIAS NEUTRAS DE INTERNET
        
        $r['n']  = $dados['materiasInternet'][1]['TOTAL']; // TOTAL DE MATERIAS SOBRE O GOVERNADOR
        $r['Pn'] = $dados['materiasInternet'][1]['POSITIVO']; // TOTAL DE MATERIAS POSITIVAS SOBRE O GOVERNADOR
        $r['Nn'] = $dados['materiasInternet'][1]['NEGATIVO']; // TOTAL DE MATERIAS NEGATIVAS SOBRE O GOVERNADOR
        $r['Tn'] = $dados['materiasInternet'][1]['NEUTRO']; // TOTAL DE MATERIAS NEUTRAS SOBRE O GOVERNADOR
        
        $r['pP'] = $dados['porcentagemPositiva']; // TOTAL PORCENTAGEM POSITIVA
        $r['pN'] = $dados['porcentagemNegativa']; // TOTAL PORCENTAGEM NEGATIVA
        $r['pT'] = $dados['porcentagemNeutra']; // TOTAL PORCENTAGEM NEUTRA
        $r['item'] = $dados['tbl']; // LISTA COM OS SITES
        $r['itemprecos'] = $dados['preco']; // PRECIFICAÇÃO

        $r['itemprecostotal'] = $dados['total_preco']; 
        $r['pTS'] = $r['pP'] + $r['pT'];
        $porcentagem = ($r['Pn'] * 100) / $r['n'];
        $r['pPn'] = number_format($porcentagem, 2, '.', '');
//        echo '<pre>';
//        print_r($r);
//        die();
        $templatePath = APPPATH . '/third_party/template/modelo/mensal.docx';
        
        } else if ($veiculo == 18) {
            
        }
        $tempDir = sys_get_temp_dir();
        $tempDir .= "/" . uniqid();
        mkdir($tempDir, null, true);

        $docxTemplate = $this->template->load($templatePath);
        $this->template->setDataRelease(
                utf8_decode('FECOMERCIO'),
                NULL,
                NULL,
                $r,
                TRUE
        );
        
        $dataContent = $this->template->getJsonRelease();

        $outputPath = $tempDir . '/relatorio-mensal-'.rand(1000,9999).'.docx';
      
        $data = json_decode($dataContent, true);

        //testing merge method
        $docxTemplate->merge($data, $outputPath, true, false);
    }

    public function especiais() {
        $this->loadUrl('modulos/relatorio/consultar_especiais');
        
    }
    
    private function validaOperacao($target)
    {
        // verificar se existe cliente selecionado
        $clienteSessao = $this->session->userData('idClienteSessao');
        if (empty($clienteSessao)) {
            $class = 'warning';
            $mensagem = 'Cliente N&atilde;o Selecionado!';
            $this->feedBack($class, $mensagem, $target);
        }
        // verifica se o cliente da sessao o usuario da sessao tem poder
        /* TODO */
    }
    
    public function index()
    {
       
//        $i = 0;
//        (isset($_SESSION['acessou'])) ? $this->session->set_userdata('acessou', $_SESSION['acessou']) : $this->session->set_userdata('acessou', $i);    
//        if ($_SESSION['acessou'] > 0 and !empty($_SESSION['cli']) and $_SESSION['cli'] == $_SESSION['idClienteSessao']) {
//        $resultado = $_SESSION['resultado']; 
//        
//        } else {
//        $this->session->set_userdata('cli', $_SESSION['idClienteSessao']);    
//        $_SESSION['acessou'] = $_SESSION['acessou'] + 1;    
//        $resultado['datai'] = date('01/m/Y');
//        $resultado['dataf'] = date('d/m/Y');
//        $resultado['grupo'] = '0';
//        $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
//        $resultado['lista_portal'] = $this->VeiculoModelo->listaPortal();
//        $resultado['lista_radio'] = $this->VeiculoModelo->listaRadio();
//        $resultado['lista_tv'] = $this->VeiculoModelo->listaTv();
//        $resultado['lista_setor'] = $this->SetorModelo->listaSetor();
//        $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria();
//        $resultado['lista_usuario'] = $this->UsuarioModelo->listaOperador();
//        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
//        $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();
//        $resultado = $this->session->set_userdata('resultado', $resultado);
//        }
            
//        echo '<pre>';
//        print_r($resultado);
//        die();
        $resultado['datai'] = date('01/m/Y');
        $resultado['dataf'] = date('d/m/Y');
        $resultado['grupo'] = '0';
        $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
        $resultado['lista_portal'] = $this->VeiculoModelo->listaPortal();
        $resultado['lista_radio'] = $this->VeiculoModelo->listaRadio();
        $resultado['lista_tv'] = $this->VeiculoModelo->listaTv();
        $resultado['lista_setor'] = $this->SetorModelo->listaSetor();
        $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria();
        $resultado['lista_usuario'] = $this->UsuarioModelo->listaOperador();
        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
        $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();
        $this->session->unset_userdata('filterRel');
        $this->loadUrl('modulos/relatorio/consultar', $resultado);

    }

    public function executar()
    {
        
        
        set_time_limit(0);
      
        $this->validaOperacao('relatorio');
        extract($this->input->post());

        $isrelease = !empty($isrelease) ? $isrelease : NULL;

        $resultadoSession = array(
            'datai' => $datai,
            'dataf' => $dataf,
            'datai2' => $datai,
            'dataf2' => $dataf,
            'veiculo' => $veiculo,
            'portal' => $portal,
            'radio' => $radio,
            'tv' => $tv,
            'tipo' => $tipo,
            'horair' => $horair,
            'horafr' => $horafr,
            'tipoMat' => $tipoMat,
            'origens' => !empty($origens) ? $origens : NULL,
            'avaliacoes' => !empty($avaliacoes) ? $avaliacoes : NULL,
            'texto' => $texto,
            'stexto' => !empty($stexto) ? $stexto : NULL,
            'release' => $release,
            'isrelease' => $isrelease,
            'setor' => @$setor,
            'grupo' => $grupo,
            'usuario' => $usuario,
            'opcRelatorio' => $opcRelatorio);
//        echo '<pre>';
//        print_r($resultadoSession);
//        die();
        $datai2 = $datai;
        $dataf2 = $dataf;
        $this->session->set_userdata('filterRel', $resultadoSession);
        
        $midias = NULL;
        if (isset($tipoMat) and is_array($tipoMat)) {
            $midias = implode($tipoMat, ',');
        } else if (isset($tipoMat)) {
            $midias = $tipoMat;
        }
        
        $origens = NULL;
        if (isset($origem) and is_array($origem)) {
            $origens = implode($origem, ',');
        } else if (isset($origem)) {
            $origens = $origem;
        }
        $avaliacoes = NULL;
        if (isset($avaliacao) and is_array($avaliacao)) {
            $avaliacoes = implode($avaliacao, ',');
        } else if (isset($avaliacao)) {
            $avaliacoes = $avaliacao;
        }
        
        if (isset($setor) and is_array($setor)) {
            $setor = implode($setor, ',');
        } else if (isset($setor)) {
            $setor = $setor;
        }
        
        $veiculo = isset($veiculo) ? $veiculo : NULL;
        $portal = isset($portal) ? $portal : NULL;
        $radio = isset($radio) ? $radio : NULL;

        if ($opcRelatorio == 'super') {

            $this->processaRelatorioMark($datai, $dataf, $this->session->userData('idClienteSessao'), $veiculo, $portal, $origens, $avaliacoes,
                $texto, $setor, $radio, $tipo, $tv, $midias, $horair, $horafr, $datai2, $dataf2, $release, $grupo, $usuario, $isrelease);

        }


        $listaPendencia = $this->MateriaModelo->countMateriaPendente($datai, $dataf, $veiculo, $portal, $origens, $avaliacoes,
            $texto, @$setor, $radio, $tipo, $tv, $midias, $horair, $horafr, $datai2, $dataf2, $release, $grupo, $usuario, $isrelease);

        $countPendencia = count($listaPendencia);

        if ($countPendencia > 0) {

            $class = 'warning';
            $mensagem = 'Favor verificar Mat&eacute;rias Inconsistentes para o Per&iacute;odo Informado!-(' . $countPendencia . ')';
//            $resultado['datai']=$datai;
//            $resultado['dataf']=$dataf;
//            $resultado['veiculo']=$veiculo;
//            $resultado['portal']=$portal;
//            $resultado['radio']=$radio;
//            $resultado['tv']=$tv;
//            $resultado['tipo']=$tipo;
//            $resultado['tipoMat']=$tipoMat;
//            $resultado['origens']=$origens;
//            $resultado['avaliacoes']=$avaliacoes;
//            $resultado['texto']=$texto;
//            $resultado['stexto']=!empty($stexto)?$stexto:NULL;
//            $resultado['setor']=$setor;
//            $resultado['opcRelatorio']=$opcRelatorio;
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
            $resultado['lista_portal'] = $this->VeiculoModelo->listaPortal();
            $resultado['lista_radio'] = $this->VeiculoModelo->listaRadio();
            $resultado['lista_tv'] = $this->VeiculoModelo->listaTv();
            $resultado['lista_setor'] = $this->SetorModelo->listaSetor();
            $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria();
            $resultado['lista_materia'] = $listaPendencia;
            $resultado['lista_usuario'] = $this->UsuarioModelo->listaOperador();
            $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();
            $this->feedBackData($class, $mensagem, 'modulos/relatorio/consultar', $resultado);
            return;
        }


        if ($acao == 'enviar') {
            $this->enviarEmail($veiculo, $portal, $origens, $avaliacoes, $texto, $setor, $radio, $tipo, $tv, $midias, $horair, $horafr,
                $datai2, $dataf2, $release, $grupo, $usuario, $isrelease);
        } else if ($acao == 'pesquisar') {
            $uuid = uniqid();
            $this->download($datai, $dataf, $uuid, NULL, $veiculo, $portal, $origens, $avaliacoes, $texto, @$setor, $radio, $tipo, $tv,
                $midias, $horair, $horafr, $datai2, $dataf2, $release, $grupo, $usuario, $isrelease);
        }
        //   redirect(base_url('relatorio'));

    }

    public function enviarEmail($veiculo, $portal, $origens, $avaliacoes, $texto, $setor, $radio, $tipo, $tv, $tipoMat, $horair,
                                $horafr, $datai2, $dataf2, $release, $grupo, $usuario, $isrelease)
    {

        set_time_limit(0);
        $this->inserirAuditoria('ENVIAR-REL-MATERIA-EMAIL', 'I', json_encode($this->input->post()));

        extract($this->input->post());


        $listaTo = explode(";", $emailTo);

        $uuid = uniqid();


        try {

            $diretorio = "assets/uploads/email/cli/";
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0777, true);
            }
            $pathFinal = $diretorio . (date('dmY')) . 'clip' . $uuid . '.pdf';

            $this->download($datai, $dataf, $uuid, $diretorio, $veiculo, $portal, $origens, $avaliacoes, $texto, $setor, $radio, $tipo,
                $tv, $tipoMat, $horair, $horafr, $datai2, $dataf2, $release, $grupo, $usuario, $isrelease);

            $arquivoArray = array($pathFinal);
            $listaTo_str = implode(",", $listaTo);
            $this->notificar($listaTo_str, $assunto, $mensagem, $arquivoArray, 'RELATORIO', $uuid);
            $class = 'success';
            $mensagem = 'Email enviado com sucesso!!';
            if (!empty($arquivoArray)) {
                foreach ($arquivoArray as $item) {
                    unlink($item);
                }
            }
        } catch (Exception $e) {
            $class = 'error';
            $mensagem = 'Erro no envio de email!';
        }
        $this->feedBack($class, $mensagem, 'relatorio');
    }

    public function download($datai, $dataf, $uuid, $pathArquivo = NULL, $veiculo = NULL, $portal = NULL, $origens = NULL, $avaliacoes = NULL,
                             $texto = NULL, $setor = NULL, $radio = NULL, $tipo = NULL, $tv = NULL, $tipoMat = NULL, $horair = NULL, $horafr = NULL,
                             $datai2 = NULL, $dataf2 = NULL, $release = NULL, $grupo = NULL, $usuario = NULL, $isrelease = NULL)
    {
        
        extract($this->input->post());
        set_time_limit(0);
        $this->validaOperacao('relatorio');
        $this->inserirAuditoria('DOWNLOAD-RELATORIO-MATERIA', 'A', 'formJson:' . json_encode($this->input->post()));
        $avalia = explode(',', $avaliacoes);
        
        $resultado['materias'] = [];
        
        if ($opcRelatorio !== 'alertaFileTextExp') {
        
            foreach ($avalia as $mat) {
                $consulta = $this->MateriaModelo->listaMateriaRelatorio($datai, $dataf, $veiculo, $portal, $origens, $mat,
                $texto, $setor, $radio, $tipo, $tv, $tipoMat, $horair, $horafr, $datai2, $dataf2, $release, $grupo, $usuario, $isrelease);
                array_push($resultado['materias'], $consulta);
//                echo $this->db->last_query();
//                die();
            }
        } else {
            $consulta = $this->MateriaModelo->listaMateriaRelatorioExp($datai, $dataf, $veiculo, $portal, $origens, NULL,
            $texto, $setor, $radio, $tipo, $tv, $tipoMat, $horair, $horafr, $datai2, $dataf2, $release, $grupo, $usuario, $isrelease);
            
            array_push($resultado['materias'], $consulta);
        }
        $tot = 0;
        
//        echo '<pre>';
//        print_r($resultado);
        //die();
        foreach ($resultado['materias'] as $res) {
            $total_pub = count($res);
            $tot = $tot + $total_pub;
        }

        
        if (empty($pathArquivo) and $tot == 0) {
            
            $class = 'warning';
            $mensagem = 'Cliente N&atilde;o possui mat&eacute;ria para o Per&iacute;odo informado!';
            $resultado['datai'] = $datai;
            $resultado['dataf'] = $dataf;
            $resultado['datai2'] = $datai2;
            $resultado['dataf2'] = $dataf2;
            $resultado['veiculo'] = $veiculo;
            $resultado['portal'] = $portal;
            $resultado['radio'] = $radio;
            $resultado['tv'] = $tv;
            $resultado['tipo'] = $tipo;
            $resultado['tipoMat'] = $tipoMat;
            $resultado['horair'] = $horair;
            $resultado['horafr'] = $horafr;
            $resultado['origens'] = $origens;
            $resultado['avaliacoes'] = $avaliacoes;
            $resultado['texto'] = $texto;
            $resultado['stexto'] = !empty($stexto) ? $stexto : NULL;
            $resultado['isrelease'] = !empty($isrelease) ? $isrelease : NULL;
            $resultado['release'] = !empty($release) ? $release : 0;
            $resultado['setor'] = $setor;
            $resultado['usuario'] = $usuario;
            $resultado['opcRelatorio'] = $opcRelatorio;
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
            $resultado['lista_portal'] = $this->VeiculoModelo->listaPortal();
            $resultado['lista_setor'] = $this->SetorModelo->listaSetor();
            $resultado['lista_radio'] = $this->VeiculoModelo->listaRadio();
            $resultado['lista_tv'] = $this->VeiculoModelo->listaTv();
            $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria();
            $resultado['lista_usuario'] = $this->UsuarioModelo->listaOperador();
            $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();
            $this->feedBackData($class, $mensagem, 'modulos/relatorio/consultar', $resultado);
            return;

        }
        
        
        //descomentar para exibir no navegador
        if (isset($setor) and is_array($setor)) {
            $setor = implode($setor, ',');
        } else if (isset($setor)) {
            $setor = $setor;
        }
        $this->load->library('pdf');
        if (!empty($stexto) and $stexto == 'S') {
            $html = $this->load->view('modulos/relatorio/arquivo-texto', $resultado, true);
        } else {
            if ($opcRelatorio == 'materia') {
                $html = $this->load->view('modulos/relatorio/arquivo-imagem', $resultado, true);
            } else if ($opcRelatorio == 'alerta') {
                $header['total'] = $tot;
                $header['datai'] = $datai;
                $header['dataf'] = $dataf;
                $header['veiculo'] = $veiculo;
                $header['portal'] = $portal;
                $header['radio'] = $radio;
                $header['tv'] = $tv;
                $header['tipo'] = $tipo;
                $header['tipoMat'] = $tipoMat;
                $header['subtitulo'] = $subtitulo;
                $header['origens'] = $origens;
                $header['avaliacoes'] = $avaliacoes;
                $header['texto'] = $texto;
                $header['setor'] = $setor;

                $resultado['lista_dias'] = $resultado['materias'];
                $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();

                $this->load->view('modulos/template/cabecalho_dashboard_relatorio', $header);
                $this->load->view('modulos/relatorio/tela-lista', $resultado);
                $this->load->view('modulos/template/rodape_dashboard');
                return;
            }else if ($opcRelatorio == 'alertaFile') {
                
                $resultado['total'] = $tot;
                $resultado['datai'] = $datai;
                $resultado['dataf'] = $dataf;
                $resultado['veiculo'] = $veiculo;
                $resultado['portal'] = $portal;
                $resultado['radio'] = $radio;
                $resultado['tv'] = $tv;
                $resultado['tipo'] = $tipo;
                $resultado['tipoMat'] = $tipoMat;
                $resultado['subtitulo'] = $subtitulo;
                $resultado['origens'] = $origens;
                $resultado['avaliacoes'] = $avaliacoes;
                $resultado['texto'] = $texto;
                $resultado['setor'] = $setor;

                $resultado['lista_dias'] = $resultado['materias'];
                $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();

                $htm =   $this->load->view('modulos/relatorio/arquivo-alerta', $resultado,true);

                $pdf = $this->pdf->load();
                $pdf->WriteHTML($htm);
                $pdf->charset_in = 'UTF-8';
                $pdf->Output((date('dmY')) . 'alertaArquivo' . $uuid . '.pdf', 'D');
                return;
            }else if ($opcRelatorio == 'alertaFileText') {
               
                $rede_social = '';
                $texto_social = '';
                $txt_rede_social = '';
                $id_cliente =  $resultado['materias'][0][0]['SEQ_CLIENTE'];
                
                $this->db->where('SEQ_CLIENTE', $id_cliente);
                $cliente_social = $this->db->get('CLIENTE')->row_array()['EMPRESA_CLIENTE'];
                
                if (trim($cliente_social) == "Redes Sociais") {
                    
                    $cont_rede = 0;
                    foreach ($resultado['materias'] as $materia) {
                        foreach ($materia as $item) {
                            if ($rede_social !== $item['SIG_SETOR']) {
                                $texto_social .= $rede_social . ',';
                            }
                            $rede_social = $item['SIG_SETOR'];
                        }
                    }
                    $txt_final = substr($texto_social, 1, -1);
                    $txt_redes = implode(",", array_unique(explode(",", $txt_final)));
                    $busca_social = explode(',', $txt_redes);
                    
                    for ($count = 0; $count < count($busca_social); $count++) {
                        $this->db->select('P.NOME_PORTAL as rede, SUM(M.QTD_COMENTARIO) as comentarios, SUM(M.QTD_CURTIDA) as curtidas, SUM(M.QTD_COMPARTILHAMENTO) as compartilhamentos ');
                        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = M.SEQ_PORTAL');
                        $this->db->where('M.SEQ_CLIENTE', $id_cliente);
                        $this->db->like('P.NOME_PORTAL', $busca_social[$count]);
                        $periodo = 'date_format(M.DATA_MATERIA_CAD,"%d/%m/%Y") BETWEEN "'. $datai. '" AND "'. $dataf.'"';
                        $this->db->where($periodo);
                        $tot_rede = $this->db->get('MATERIA M')->row_array();
                        
                        $txt_rede_social .= 'Na rede social <b>'.$busca_social[$count]. '</b> houveram <b>'. $tot_rede['comentarios'].' comentários</b>, <b>'.$tot_rede['curtidas']. ' curtidas</b> e <b>'.$tot_rede['compartilhamentos']. ' compartilhamentos</b>. ';
                    }
                    
                }
                
                $resultado['redes_sociais'] = $txt_rede_social;
                $resultado['total'] = $tot;
                $resultado['datai'] = $datai;
                $resultado['dataf'] = $dataf;
                $resultado['veiculo'] = $veiculo;
                $resultado['portal'] = $portal;
                $resultado['radio'] = $radio;
                $resultado['tv'] = $tv;
                $resultado['tipo'] = $tipo;
                $resultado['tipoMat'] = $tipoMat;
                $resultado['subtitulo'] = $subtitulo;
                $resultado['origens'] = $origens;
                $resultado['avaliacoes'] = $avaliacoes;
                $resultado['texto'] = $texto;
                $resultado['setor'] = $setor;

                $resultado['lista_dias'] = $resultado['materias'];
              
                $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();
                
                $top = $this->top10($resultado);
                
                $resultado['top'] = $top;
                $htm =   $this->load->view('modulos/relatorio/arquivo-alerta-texto', $resultado,true);  

                $pdf = $this->pdf->load();
                $pdf->WriteHTML($htm);
                $pdf->charset_in = 'UTF-8';
                $pdf->Output((date('dmY')) . 'alertaArquivo' . $uuid . '.pdf', 'D');
                return;
            } else if ($opcRelatorio == 'alertaFileTextExp') {
                $rede_social = '';
                $texto_social = '';
                $txt_rede_social = '';
                $id_cliente =  $resultado['materias'][0][0]['SEQ_CLIENTE'];
                
                $this->db->where('SEQ_CLIENTE', $id_cliente);
                $cliente_social = $this->db->get('CLIENTE')->row_array()['EMPRESA_CLIENTE'];
                
                if (trim($cliente_social) == "Redes Sociais") {
                    
                    $cont_rede = 0;
                    foreach ($resultado['materias'] as $materia) {
                        foreach ($materia as $item) {
                            if ($rede_social !== $item['SIG_SETOR']) {
                                $texto_social .= $rede_social . ',';
                            }
                            $rede_social = $item['SIG_SETOR'];
                        }
                    }
                    $txt_final = substr($texto_social, 1, -1);
                    $txt_redes = implode(",", array_unique(explode(",", $txt_final)));
                    $busca_social = explode(',', $txt_redes);
                    
                    for ($count = 0; $count < count($busca_social); $count++) {
                        $this->db->select('P.NOME_PORTAL as rede, SUM(M.QTD_COMENTARIO) as comentarios, SUM(M.QTD_CURTIDA) as curtidas, SUM(M.QTD_COMPARTILHAMENTO) as compartilhamentos ');
                        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = M.SEQ_PORTAL');
                        $this->db->where('M.SEQ_CLIENTE', $id_cliente);
                        $this->db->like('P.NOME_PORTAL', $busca_social[$count]);
                        $periodo = 'date_format(M.DATA_MATERIA_CAD,"%d/%m/%Y") BETWEEN "'. $datai. '" AND "'. $dataf.'"';
                        $this->db->where($periodo);
                        $tot_rede = $this->db->get('MATERIA M')->row_array();
                        
                        $txt_rede_social .= 'Na rede social <b>'.$busca_social[$count]. '</b> houveram <b>'. $tot_rede['comentarios'].' comentários</b>, <b>'.$tot_rede['curtidas']. ' curtidas</b> e <b>'.$tot_rede['compartilhamentos']. ' compartilhamentos</b>. ';
                    }
                    
                }
                
                $resultado['redes_sociais'] = $txt_rede_social;
                $resultado['total'] = $tot;
                $resultado['datai'] = $datai;
                $resultado['dataf'] = $dataf;
                $resultado['veiculo'] = $veiculo;
                $resultado['portal'] = $portal;
                $resultado['radio'] = $radio;
                $resultado['tv'] = $tv;
                $resultado['tipo'] = $tipo;
                $resultado['tipoMat'] = $tipoMat;
                $resultado['subtitulo'] = $subtitulo;
                $resultado['origens'] = $origens;
                $resultado['avaliacoes'] = $avaliacoes;
                $resultado['texto'] = $texto;
                $resultado['setor'] = $setor;

                $resultado['lista_dias'] = $resultado['materias'];
                
                $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseAtivo();
                
                $top = $this->top10($resultado);

                $resultado['top'] = $top;
                $resultado['ctrl'] = $this;
                $htm =   $this->load->view('modulos/relatorio/arquivo-alerta-texto-exp', $resultado,true);  

                $pdf = $this->pdf->load();
                $pdf->WriteHTML($htm);
                $pdf->charset_in = 'UTF-8';
                $pdf->Output((date('dmY')) . 'alertaArquivo' . $uuid . '.pdf', 'D');
                return;
            } else if ($opcRelatorio == 'alertaFileTextWord') {
                $resultado['total'] = $tot;
                $resultado['datai'] = $datai;
                $resultado['dataf'] = $dataf;
                $resultado['veiculo'] = $veiculo;
                $resultado['portal'] = $portal;
                $resultado['radio'] = $radio;
                $resultado['tv'] = $tv;
                $resultado['tipo'] = $tipo;
                $resultado['tipoMat'] = $tipoMat;
                $resultado['subtitulo'] = $subtitulo;
                $resultado['origens'] = $origens;
                $resultado['avaliacoes'] = $avaliacoes;
                $resultado['texto'] = $texto;
                $resultado['setor'] = $setor;
                //$resultado['lista_dias'] = $resultado['materias'];
                //$resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
                $word = $this->word($resultado);
                return;
            }


        }
        
        $pdf = $this->pdf->load();
//        echo $html;
//        die();  
        $pdf->WriteHTML($html);
        
        $pdf->charset_in = 'UTF-8';
        if (empty($pathArquivo)) {
            $pdf->Output((date('dmY')) . 'clip' . $uuid . '.pdf', 'D');
        } else {
            $pdf->Output($pathArquivo . (date('dmY')) . 'clip' . $uuid . '.pdf', 'F');
        }

    }

    public function alertaTexto($datai, $dataf, $veiculo, $portal, $origens, $aval,
    $texto, $setor, $radio, $tipo, $tv, $tipoMat, $horair, $horafr, $datai2, $dataf2, $release, $grupo, $usuario, $isrelease) {

        $consulta = $this->MateriaModelo->listaMateriaRelatorioExp($datai, $dataf, $veiculo, $portal, $origens, $aval,
            $texto, $setor, $radio, $tipo, $tv, $tipoMat, $horair, $horafr, $datai2, $dataf2, $release, $grupo, $usuario, $isrelease);

        return $consulta;    
    }

    private function top10($resultado) {
        $texto = '';

         foreach ($resultado['materias'] as $materia) {
            foreach ($materia as $assunto) {
                $texto .= $assunto['TIT_MATERIA'] . ',';
            }
        }
        $texto_final = substr($texto, 0, -2);
        $texto_final = str_replace(date('d/m'), "", $texto_final);
        
        /* Separar cada palavra por espaços (raw, sem filtro) */
        $palavras_raw = explode(",", $texto_final);
        
        // Array de caracteres para serem removidos
        $ignorar = [".", ",", "!", ";", ":", "(", ")", "{", "}", "[", "]", "<", ">",
                    "?", "|", "\\", "/", "na", "da", "das", "de", "até", "o", "a", "e", "um", "uns"];

        // Array para as palavras tratadas.
        $palavrasTratadas = array();

        /* Criar uma nova array de palavras, agora tratadas */
        $palavras_raw_count = count($palavras_raw);
        
        for ($i = 0; $i < $palavras_raw_count;  ++$i) {
            $palavraAtual = $palavras_raw[$i];
            $palavraAtual = trim($palavraAtual);
            if (!empty($palavraAtual)) {
                $palavraTratada = mb_strtolower($palavraAtual);         
                      
                if (!empty($palavraTratada)) {
                    @$palavrasTratadas[$palavraTratada]++;
                }
            }
        }
        
        // Organizar pela ordem de mais ocorrências.
       arsort($palavrasTratadas);
       
       $a = 0;
       $txt = 'Os assuntos mais relevantes a partir do título das matérias são: ';
       foreach ($palavrasTratadas  as $assunto => $valor) {
            if ($a < 10) {
            $txt .= '<b>'. ucfirst($assunto). '</b> com '.$valor. ' ocorrências, ' ;     
            } else {
                continue;
            }
            $a++;
        }

        $texto_final = substr($txt, 0, -2);
       
        return $texto_final;
    }

    function cmp($a, $b) {
	return $a['TIPO_MATERIA'] > $b['TIPO_MATERIA'];
    }

    private function word($resultado) {

        usort($resultado['materias'][0], array($this, "cmp"));

        $languagePTBR = new \PhpOffice\PhpWord\Style\Language(\PhpOffice\PhpWord\Style\Language::PT_BR);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->getSettings()->setThemeFontLang($languagePTBR);
        $section = $phpWord->addSection();
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
                $fontStyleName, array('name' => 'Arial', 'size' => 11, 'color' => '1B2232', 'bold' => true)
        );
        $periodo = $resultado['datai'] . ' - ' . $resultado['dataf'];
        if ($resultado['avaliacoes'] == 'P') {
            $section->addText(
                    'POSITIVAS ' . $periodo, $fontStyleName
            );
        } else if ($resultado['avaliacoes'] == 'N') {
            $section->addText(
                    'NEGATIVAS ' . $periodo, $fontStyleName
            );
        } else if ($resultado['avaliacoes'] == 'T') {
            $section->addText(
                    'NEUTRAS ' . $periodo, $fontStyleName
            );
        } else {
            $section->addText(
                    'DATA: ' . $periodo, $fontStyleName
            );
        }
        $section->addTextBreak(1);
   
        $i = 1;

        $tipo_materia = '';
        foreach ($resultado['materias'][0] as $materia) {
            
            if ($tipo_materia !== $materia['TIPO_MATERIA']) {
                if ($materia['TIPO_MATERIA'] == 'I') {
                    $section->addText(
                        'IMPRESSO', $fontStyleName
                    );
                    
                    $section->addTextBreak(1);
                } else if ($materia['TIPO_MATERIA'] == 'S') {
                    $section->addText(
                        'INTERNET', $fontStyleName
                    );
                    $section->addTextBreak(1);
                } else if ($materia['TIPO_MATERIA'] == 'T') {
                    $section->addText(
                        'TELEVISÃO', $fontStyleName
                    );
                    $section->addTextBreak(1);
                } else {
                    $section->addText(
                        'RÁDIO', $fontStyleName
                    );
                    $section->addTextBreak(1);
                }
            }
            
            if ($materia['TIPO_MATERIA'] == 'I') {
                $this->db->where('SEQ_VEICULO', $materia['SEQ_VEICULO']);
                $veiculo = $this->db->get('VEICULO')->row_array()['FANTASIA_VEICULO'];
                    $section->addText(
                            mb_strtoupper($i . ' - ' . $veiculo), $fontStyleName
                    );
                } else if ($materia['TIPO_MATERIA'] == 'S') {
                    $this->db->where('SEQ_PORTAL', $materia['SEQ_PORTAL']);
                    $veiculo = $this->db->get('PORTAL')->row_array()['NOME_PORTAL'];
                    $section->addText(
                            mb_strtoupper($i . ' - INTERNET ' . $veiculo), $fontStyleName
                    );
                } else if ($materia['TIPO_MATERIA'] == 'T') {
                    $this->db->where('SEQ_TV', $materia['SEQ_TV']);
                    $veiculo = $this->db->get('TELEVISAO')->row_array()['NOME_TV'];
                    $section->addText(
                            mb_strtoupper($i . ' - ' . $veiculo), $fontStyleName
                    );
                    $section->addText(
                            mb_strtoupper($materia['PROGRAMA_MATERIA']), $fontStyleName
                    );
                } else if ($materia['TIPO_MATERIA'] == 'R') {
                    $this->db->where('SEQ_RADIO', $materia['SEQ_RADIO']);
                    $veiculo = $this->db->get('RADIO')->row_array()['NOME_RADIO'];
                    $section->addText(
                            mb_strtoupper($i . ' - '. $veiculo), $fontStyleName
                    );
                    $section->addText(
                            mb_strtoupper($materia['PROGRAMA_MATERIA']), $fontStyleName
                    );
                }
                $section->addText(
                str_replace("&", 'e', $materia['TIT_MATERIA'])
                );

            $section->addText(
                        'Resumo: ' . $materia['RESUMO_MATERIA']
                );
                if ($materia['RESPOSTA_MATERIA'] == 'Sem reposta' ||  $materia['RESPOSTA_MATERIA'] == 'sem resposta') {
                    
                } else {
                $section->addText(
                        $materia['RESPOSTA_MATERIA'], $fontStyleName
                );
                }
            $section->addTextBreak(1);
            $i++;
            $tipo_materia = $materia['TIPO_MATERIA'];
        }
        
        $token = mb_strimwidth(md5(uniqid("")), 0, 6);
        $filename = 'relatorio'.$token.'.docx';
        $arquivo  = FCPATH.'lixo/'.$filename;
        $phpWord->save($arquivo);
        $this->load->helper('download');
        $dataBinary = file_get_contents($arquivo);
        force_download(basename($arquivo), $dataBinary, TRUE);
        unlink(realpath($arquivo));
    }

    public function contadorUsuario()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-CADASTRO-POR-USUARIO', 'C', '');
        $this->load->helper('date');

        if (!empty($datair))
            $datair = $datair;
        else
            $datair = date('d/m/Y');

        if (!empty($datafr))
            $datafr = $datafr;
        else
            $datafr = date('d/m/Y');

        if (!empty($horair))
            $horair = $horair;
        else
            $horair = '00:00';

        if (!empty($horafr))
            $horafr = $horafr;
        else
            $horafr = '23:59';

        $resultado['datair'] = $datair;
        $resultado['datafr'] = $datafr;
        $resultado['horair'] = $horair;
        $resultado['horafr'] = $horafr;

        $this->loadUrl('modulos/relatorio/consultar-usuario', $resultado);
    }

    public function contadorUsuarioDetalhe()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-CADASTRO-POR-USUARIO-DETALHE', 'C', '');

        $resultado['lista_materia'] = $this->ComumModelo->quantitativoUsuarioDetalhe($datai, $dataf, $horai, $horaf, $usuario, $tipo, $cliente);
        echo $this->db->last_query();
        die();
        $this->load->view('modulos/relatorio/consultar-usuario-detalhe', $resultado);
    }

    public function contadorSetor()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-CADASTRO-POR-SETOR', 'C', '');


        if (empty($datai))
            if (!empty($this->session->userdata('datai')))
                $datai = $this->session->userdata('datai');
            else
                $datai = date('01/m/Y');

        if (empty($dataf))
            if (!empty($this->session->userdata('dataf')))
                $dataf = $this->session->userdata('dataf');
            else
                $dataf = date('d/m/Y');

        $resultado['datai'] = $datai;
        $resultado['dataf'] = $dataf;

        $this->loadUrl('modulos/relatorio/consultar-setor', $resultado);
    }

    public function processaSetor()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-CADASTRO-POR-SETOR', 'C', '');

        if ($acao == 'pdf') {
            $resultado['datai'] = $datai;
            $resultado['dataf'] = $dataf;
            $resultado['idCliente'] = $idCliente;
            $resultado['isSetorMonitor'] = (!empty($isSetorMonitor)) ? $isSetorMonitor : NULL;
            $resultado['tags'] = $tags;
//            print_r($resultado);
//            die();
            $this->load->library('pdf');
//            if (!empty($isSetorMonitor))
//                    $html = $this->load->view('modulos/relatorio/arquivo-setor', $resultado, true);
//                else
            $html = $this->load->view('modulos/relatorio/arquivo-setor', $resultado, true);
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->charset_in = 'UTF-8';
            $pdf->Output((date('dmY')) . 'setor' . '.pdf', 'D');
        } else {

            /*  if (!empty($isSetorMonitor)){
                  $resultado['datai']= $datai;
                  $resultado['dataf']= $dataf;
                  $resultado['idCliente']= $idCliente;
                  $resultado['isSetorMonitor']= (!empty($isSetorMonitor))?$isSetorMonitor:NULL;
                  $class = 'warning';
                  $mensagem = 'O relat&oacute;rio de Monitoramente n&atilde;o dispon&iacute;vel para Excel!';
                  $this->feedBack($class,$mensagem,'relatorio/contadorSetor');
              }*/
            $this->load->library('excel');

            $arquivo = FCPATH . 'lixo/' . (date('dmY')) . 'setor' . '.xlsx';
            $planilha = $this->excel;
            $planilha->setActiveSheetIndex(0);
            //impresso
            if (!empty($isSetorMonitor)) {
                $lista_setor = $this->ComumModelo->quantitativoSetor2($datai, $dataf, $idCliente, 'I');
            } else {
                $lista_setor = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'I', NULL, NULL, NULL, $tags);
            }
            $i = 0;
            if (!empty($lista_setor)) {
//                $controle = 1;
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->getActiveSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Secretaria/Setor');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        if ($itemS['TIPO_MATERIA'] == 'I') {
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_SETOR']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                            $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                            $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                            $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        }
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('IMPRESSO');
                }
            }
            //INTERNET
//            if (!empty($isSetorMonitor)) {
//                $lista_setor = $this->ComumModelo->quantitativoSetor2($datai, $dataf, $idCliente, 'S');
//            } else {
//                $lista_setor = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'S');
//            }
            $i = 1;
            if (!empty($lista_setor)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Secretaria/Setor');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        if ($itemS['TIPO_MATERIA'] == 'S') {
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_SETOR']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                            $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                            $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                            $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        }
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('INTERNET');
                }
            }
            //radio
//            if (!empty($isSetorMonitor)) {
//                $lista_setor = $this->ComumModelo->quantitativoSetor2($datai, $dataf, $idCliente, 'R');
//            } else {
//                $lista_setor = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'R');
//            }
            $i = 2;
            if (!empty($lista_setor)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Secretaria/Setor');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        if ($itemS['TIPO_MATERIA'] == 'R') {
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_SETOR']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                            $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                            $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                            $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        }
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('RADIO');
                }
            }
            //televisao
//            if (!empty($isSetorMonitor)) {
//                $lista_setor = $this->ComumModelo->quantitativoSetor2($datai, $dataf, $idCliente, 'T');
//            } else {
//                $lista_setor = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'T');
//            }
            $i = 3;
            if (!empty($lista_setor)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Secretaria/Setor');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        if ($itemS['TIPO_MATERIA'] == 'T') {
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_SETOR']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                            $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                            $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                            $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        }
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('TELEVISAO');
                }
            }
            $objWriter = PHPExcel_IOFactory::createWriter($planilha, "Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
            $objWriter->save($arquivo);
//            $objWriter = PHPExcel_IOFactory::createWriter($planilha,"Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
//            $objWriter->save($arquivo);

            $this->load->helper('download');

            $dataBinary = file_get_contents($arquivo);

            force_download(basename($arquivo), $dataBinary, TRUE);
        }

    }

    public function contadorVeiculo()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-RELATORIO-POR-VEICULO', 'C', '');


        if (empty($datai))
            if (!empty($this->session->userdata('datai')))
                $datai = $this->session->userdata('datai');
            else
                $datai = date('01/m/Y');

        if (empty($dataf))
            if (!empty($this->session->userdata('dataf')))
                $dataf = $this->session->userdata('dataf');
            else
                $dataf = date('d/m/Y');

        $resultado['datai'] = $datai;
        $resultado['dataf'] = $dataf;

        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();

        $this->loadUrl('modulos/relatorio/consultar-veiculo', $resultado);
    }
    
    public function processaVeiculoPrecificacao() {
        set_time_limit(0);
        extract($this->input->post());
        if ($acao == 'pdf') {
            $this->load->library('pdf');
            $resultado['datai'] = implode('-', array_reverse(explode('/', $datai)));
            $resultado['dataf'] = implode('-', array_reverse(explode('/', $dataf)));
            $resultado['idCliente'] = $idCliente;
            $html = $this->load->view('modulos/relatorio/arquivo-veiculo-precificacao', $resultado, true);
            echo $html;
            die();
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->charset_in = 'UTF-8';
            $pdf->Output((date('dmY')) . 'precificacao' . '.pdf', 'D');
        }
        
    }
    
    public function processaVeiculo()
    {
        set_time_limit(0);
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-CONTAGEM-POR-VEICULO', 'C', '');
        if ($acao == 'pdf') {
            $resultado['datai'] = $datai;
            $resultado['dataf'] = $dataf;
            $resultado['grupo'] = $grupo;
            $resultado['idCliente'] = $idCliente;
            $resultado['istempo'] = (!empty($istempo)) ? $istempo : NULL;
            $resultado['isrelease'] = (!empty($isrelease)) ? $isrelease : NULL;
            $resultado['isSetorMonitor'] = (!empty($isSetorMonitor)) ? $isSetorMonitor : NULL;
            $resultado['tags'] = $tags;
            $this->load->library('pdf');
            $html = $this->load->view('modulos/relatorio/arquivo-veiculo', $resultado, true);
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->charset_in = 'UTF-8';
            $pdf->Output((date('dmY')) . 'veiculo' . '.pdf', 'D');
        } else {
            $this->load->library('excel');
            $arquivo = FCPATH . 'lixo/' . (date('dmY')) . 'veiculo' . '.xlsx';
            $planilha = $this->excel;
            $planilha->setActiveSheetIndex(0);
            //impresso
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'I',NULL,NULL, NULL, NULL, $tags);
            $i = 0;
            if (!empty($lista_setor)) {
//                $controle = 1;
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->getActiveSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        $totalP += $itemS['POSITIVO'];
                        $totalN += $itemS['NEGATIVO'];
                        $totalT += $itemS['NEUTRO'];
                        $totalG += $itemS['TOTAL'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                        $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                        $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                        $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('IMPRESSO');
                }
            }
            //INTERNET
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'S',NULL,NULL, NULL, NULL, $tags);
            $i = 1;
            if (!empty($lista_setor)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        $totalP += $itemS['POSITIVO'];
                        $totalN += $itemS['NEGATIVO'];
                        $totalT += $itemS['NEUTRO'];
                        $totalG += $itemS['TOTAL'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                        $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                        $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                        $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('INTERNET');
                }
            }
            //radio
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'R',NULL,NULL, NULL, NULL, $tags);
            $i = 2;
            if (!empty($lista_setor)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        $totalP += $itemS['POSITIVO'];
                        $totalN += $itemS['NEGATIVO'];
                        $totalT += $itemS['NEUTRO'];
                        $totalG += $itemS['TOTAL'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                        $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                        $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                        $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('RADIO');
                }
            }
            /**  tempo radio */
            if (!empty($istempo)) {
                //radio
                $lista_setor = $this->ComumModelo->quantitativoVeiculoRadioTempo($datai, $dataf, $idCliente, NULL, NULL, $tags);
                $i = 3;
                if (!empty($lista_setor)) {
                    $totalP = 0;
                    $totalN = 0;
                    $totalT = 0;
                    $totalG = 0;
                    $rowCount = 1;
                    if (!empty($lista_setor)) {
                        $objWorkSheet = $planilha->createSheet($i);
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                        $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                        $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                        $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                        $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                        $rowCount++;
                        foreach ($lista_setor as $itemS):
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, convertSegundo2HMS($itemS['POSITIVO']));
                            $objWorkSheet->SetCellValue('C' . $rowCount, convertSegundo2HMS($itemS['NEGATIVO']));
                            $objWorkSheet->SetCellValue('D' . $rowCount, convertSegundo2HMS($itemS['NEUTRO']));
                            $objWorkSheet->SetCellValue('E' . $rowCount, convertSegundo2HMS($itemS['TOTAL']));
                            $rowCount++;
                        endforeach;
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                        $objWorkSheet->SetCellValue('B' . $rowCount, convertSegundo2HMS($totalP));
                        $objWorkSheet->SetCellValue('C' . $rowCount, convertSegundo2HMS($totalN));
                        $objWorkSheet->SetCellValue('D' . $rowCount, convertSegundo2HMS($totalT));
                        $objWorkSheet->SetCellValue('E' . $rowCount, convertSegundo2HMS($totalG));
                        $objWorkSheet->setTitle('RADIO-TEMPO');
                    }
                }
            }
            /*** fim tempo radio ****/
            //televisao
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'T',NULL,NULL, NULL, NULL, $tags);
            $i = 4;
            if (!empty($lista_setor)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Veículo');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        $totalP += $itemS['POSITIVO'];
                        $totalN += $itemS['NEGATIVO'];
                        $totalT += $itemS['NEUTRO'];
                        $totalG += $itemS['TOTAL'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                        $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                        $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                        $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('TELEVISAO');
                }
            }
            if (!empty($isrelease)) {
                $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'I', $isrelease, NULL, NULL, NULL, $tags);
                $i = 5;
                if (!empty($lista_setor)) {
                    $totalP = 0;
                    $totalN = 0;
                    $totalT = 0;
                    $totalG = 0;
                    $rowCount = 1;
                    if (!empty($lista_setor)) {
                        $objWorkSheet = $planilha->createSheet($i);
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                        $objWorkSheet->SetCellValue('B' . $rowCount, 'Total');
                        $rowCount++;
                        foreach ($lista_setor as $itemS):
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        endforeach;
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                        $objWorkSheet->SetCellValue('B' . $rowCount, $totalG);
                        $objWorkSheet->setTitle('RELEASE-IMPRESSO');
                    }
                }
                $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'S', $isrelease, NULL, NULL, NULL, $tags);
                $i = 6;
                if (!empty($lista_setor)) {
                    $totalP = 0;
                    $totalN = 0;
                    $totalT = 0;
                    $totalG = 0;
                    $rowCount = 1;
                    if (!empty($lista_setor)) {
                        $objWorkSheet = $planilha->createSheet($i);
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                        $objWorkSheet->SetCellValue('B' . $rowCount, 'Total');
                        $rowCount++;
                        foreach ($lista_setor as $itemS):
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        endforeach;
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                        $objWorkSheet->SetCellValue('B' . $rowCount, $totalG);
                        $objWorkSheet->setTitle('RELEASE-INTERNET');
                    }
                }
                $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'R', $isrelease, NULL, NULL, NULL, $tags);
                $i = 7;
                if (!empty($lista_setor)) {
                    $totalP = 0;
                    $totalN = 0;
                    $totalT = 0;
                    $totalG = 0;
                    $rowCount = 1;
                    if (!empty($lista_setor)) {
                        $objWorkSheet = $planilha->createSheet($i);
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                        $objWorkSheet->SetCellValue('B' . $rowCount, 'Total');
                        $rowCount++;
                        foreach ($lista_setor as $itemS):
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        endforeach;
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                        $objWorkSheet->SetCellValue('B' . $rowCount, $totalG);
                        $objWorkSheet->setTitle('RELEASE-RADIO');
                    }
                }
                $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'T', $isrelease, NULL, NULL, NULL, $tags);
                $i = 8;
                if (!empty($lista_setor)) {
                    $totalP = 0;
                    $totalN = 0;
                    $totalT = 0;
                    $totalG = 0;
                    $rowCount = 1;
                    if (!empty($lista_setor)) {
                        $objWorkSheet = $planilha->createSheet($i);
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                        $objWorkSheet->SetCellValue('B' . $rowCount, 'Total');
                        $rowCount++;
                        foreach ($lista_setor as $itemS):
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        endforeach;
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                        $objWorkSheet->SetCellValue('B' . $rowCount, $totalG);
                        $objWorkSheet->setTitle('RELEASE-TV');
                    }
                }
            }

            $objWriter = PHPExcel_IOFactory::createWriter($planilha, "Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
            $objWriter->save($arquivo);

            $this->load->helper('download');

            $dataBinary = file_get_contents($arquivo);

            force_download(basename($arquivo), $dataBinary, TRUE);
        }

    }

    public function contadorGeral()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-RELATORIO-POR-GERAL', 'C', '');


        if (empty($datai))
            if (!empty($this->session->userdata('datai')))
                $datai = $this->session->userdata('datai');
            else
                $datai = date('01/m/Y');

        if (empty($dataf))
            if (!empty($this->session->userdata('dataf')))
                $dataf = $this->session->userdata('dataf');
            else
                $dataf = date('d/m/Y');

        $resultado['datai'] = $datai;
        $resultado['dataf'] = $dataf;
        $resultado['idCliente'] = $this->session->userdata('idClienteSessao');

        $resultado['lista_setor'] = $this->SetorModelo->listaSetor();
        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
        
        $this->loadUrl('modulos/relatorio/consultar-geral', $resultado);
    }

    public function processaGeral()
    {
        set_time_limit(0);
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-CONTAGEM-POR-VEICULO', 'C', '');

        if ($acao == 'I') {

            $resultado['datai'] = $datai;
            $resultado['dataf'] = $dataf;

            $resultado['idCliente'] = $idCliente;
            $resultado['lista_setor'] = $this->SetorModelo->listaSetorAlerta($idCliente);
            $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
            $this->loadUrl('modulos/relatorio/consultar-geral', $resultado);
            return;
        } else if ($acao == 'graficos') {
            $resultado['datai'] = $datai;
            $resultado['dataf'] = $dataf;
            $resultado['grupo'] = $grupo;
            $resultado['idCliente'] = $idCliente;
            $resultado['istempo'] = (!empty($istempo)) ? $istempo : NULL;

            $resultado['tipoCrime'] = $tipoCrime;
            $resultado['bairroCrime'] = $bairroCrime;
            $resultado['localCrime'] = $localCrime;
            $resultado['indPreso'] = $indPreso;
            $resultado['excluirSetor'] = !empty($excluirSetor) ?$excluirSetor:NULL;
            $resultado['tags'] = $tags;
            if (is_array($this->input->post('setor'))){
                $resultado['setores'] = implode($setor,',');
            } else {
                $resultado['setores'] = $setor;
            }
  
            $html = $this->load->view('modulos/relatorio/graficos-consultar-geral', $resultado);
            
        } else if ($acao == 'pdf') {
            $resultado['datai'] = $datai;
            $resultado['dataf'] = $dataf;
            $resultado['grupo'] = $grupo;
            $resultado['idCliente'] = $idCliente;
            $resultado['istempo'] = (!empty($istempo)) ? $istempo : NULL;

            $resultado['tipoCrime'] = $tipoCrime;
            $resultado['bairroCrime'] = $bairroCrime;
            $resultado['localCrime'] = $localCrime;
            $resultado['indPreso'] = $indPreso;
            $resultado['excluirSetor'] = !empty($excluirSetor) ?$excluirSetor:NULL;
            $resultado['tags'] = $tags;
            if (is_array($this->input->post('setor'))){
                $resultado['setores'] = implode($setor,',');
            } else {
                $resultado['setores'] = $setor;
            }


            $this->load->library('pdf');
            $html = $this->load->view('modulos/relatorio/arquivo-geral', $resultado, true);

            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->charset_in = 'UTF-8';
            $pdf->Output((date('dmY')) . 'veiculo' . '.pdf', 'D');
        } else {
            $this->load->library('excel');
            $arquivo = FCPATH . 'lixo/' . (date('dmY')) . 'veiculo' . '.xlsx';
            $planilha = $this->excel;
            $planilha->setActiveSheetIndex(0);

            $setores=NULL;
            $setor = !empty($setor)?$setor:NULL;
            if (is_array($setor)){
                $setores = implode($setor,',');
            } else {
                $setores = $setor;
            }
            $excluirSetor = !empty($excluirSetor) ?$excluirSetor:NULL;

            //impresso
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'I',NULL, NULL, $excluirSetor,$setores, $tags);
            $i = 0;
            if (!empty($lista_setor)) {
//                $controle = 1;
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->getActiveSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):

                        $totalP += $itemS['POSITIVO'];
                        $totalN += $itemS['NEGATIVO'];
                        $totalT += $itemS['NEUTRO'];
                        $totalG += $itemS['TOTAL'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                        $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                        $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                        $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('IMPRESSO-Veiculo');
                }
                $i++;
            }
            $lista_setor2 = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'I', $grupo,$excluirSetor,$setores, $tags);
            // $i=0;
            if (!empty($lista_setor2)) {
//                $controle = 1;
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor2)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Secretaria/Setor');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor2 as $itemS):
                        if ($itemS['TIPO_MATERIA'] == 'I') {
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_SETOR']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                            $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                            $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                            $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        }
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('IMPRESSO-Setor');
                }
                $i++;
            }

            //INTERNET
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'S',NULL,NULL,$excluirSetor,$setores, $tags);
            //  $i=1;
            if (!empty($lista_setor)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        $totalP += $itemS['POSITIVO'];
                        $totalN += $itemS['NEGATIVO'];
                        $totalT += $itemS['NEUTRO'];
                        $totalG += $itemS['TOTAL'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                        $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                        $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                        $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('INTERNET-Veiculo');
                }
                $i++;
            }

            $lista_setor3 = $this->ComumModelo->quantitativoSetorInternet($datai,$dataf,$idCliente,'S',$grupo,$excluirSetor,$setores, $tags);
            // $i=1;
            if (!empty($lista_setor3)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor3)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Secretaria/Setor');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor3 as $itemS):
                        if ($itemS['TIPO_MATERIA'] == 'S') {
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_SETOR']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                            $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                            $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                            $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        }
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('INTERNET-Setor');
                }
                $i++;
            }
            //radio
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'R',NULL,NULL,$excluirSetor,$setores, $tags);
            // $i=2;
            if (!empty($lista_setor)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        $totalP += $itemS['POSITIVO'];
                        $totalN += $itemS['NEGATIVO'];
                        $totalT += $itemS['NEUTRO'];
                        $totalG += $itemS['TOTAL'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                        $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                        $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                        $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('RADIO-Veiulo');
                }
                $i++;
            }
//            $lista_setor2 = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'R');
            //$i=2;
            if (!empty($lista_setor2)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor2)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Secretaria/Setor');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor2 as $itemS):
                        if ($itemS['TIPO_MATERIA'] == 'R') {
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_SETOR']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                            $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                            $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                            $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        }
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('RADIO-Setor');
                }
                $i++;
            }
            /**  tempo radio */
            if (!empty($istempo)) {
                //radio
                $lista_setor = $this->ComumModelo->quantitativoVeiculoRadioTempo($datai, $dataf, $idCliente,$excluirSetor,$setores, $tags);
                //  $i = 3;
                if (!empty($lista_setor)) {
                    $totalP = 0;
                    $totalN = 0;
                    $totalT = 0;
                    $totalG = 0;
                    $rowCount = 1;
                    if (!empty($lista_setor)) {
                        $objWorkSheet = $planilha->createSheet($i);
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                        $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                        $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                        $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                        $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                        $rowCount++;
                        foreach ($lista_setor as $itemS):
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, convertSegundo2HMS($itemS['POSITIVO']));
                            $objWorkSheet->SetCellValue('C' . $rowCount, convertSegundo2HMS($itemS['NEGATIVO']));
                            $objWorkSheet->SetCellValue('D' . $rowCount, convertSegundo2HMS($itemS['NEUTRO']));
                            $objWorkSheet->SetCellValue('E' . $rowCount, convertSegundo2HMS($itemS['TOTAL']));
                            $rowCount++;
                        endforeach;
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                        $objWorkSheet->SetCellValue('B' . $rowCount, convertSegundo2HMS($totalP));
                        $objWorkSheet->SetCellValue('C' . $rowCount, convertSegundo2HMS($totalN));
                        $objWorkSheet->SetCellValue('D' . $rowCount, convertSegundo2HMS($totalT));
                        $objWorkSheet->SetCellValue('E' . $rowCount, convertSegundo2HMS($totalG));
                        $objWorkSheet->setTitle('RADIO-TEMPO');
                    }
                    $i++;
                }
            }
            /*** fim tempo radio ****/
            //televisao
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'T',NULL,NULL,$excluirSetor,$setores, $tags);
            // $i=4;
            if (!empty($lista_setor)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor as $itemS):
                        $totalP += $itemS['POSITIVO'];
                        $totalN += $itemS['NEGATIVO'];
                        $totalT += $itemS['NEUTRO'];
                        $totalG += $itemS['TOTAL'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                        $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                        $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                        $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('TELEVISAO-Veiculo');
                }
                $i++;
            }
//            $lista_setor2 = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'T');
            //  $i=3;
            if (!empty($lista_setor2)) {
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_setor2)) {
                    $objWorkSheet = $planilha->createSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Secretaria/Setor');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                    $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                    $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                    $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                    $rowCount++;
                    foreach ($lista_setor2 as $itemS):
                        if ($itemS['TIPO_MATERIA'] == 'T') {
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_SETOR']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['POSITIVO']);
                            $objWorkSheet->SetCellValue('C' . $rowCount, $itemS['NEGATIVO']);
                            $objWorkSheet->SetCellValue('D' . $rowCount, $itemS['NEUTRO']);
                            $objWorkSheet->SetCellValue('E' . $rowCount, $itemS['TOTAL']);
                            $rowCount++;
                        }
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalP);
                    $objWorkSheet->SetCellValue('C' . $rowCount, $totalN);
                    $objWorkSheet->SetCellValue('D' . $rowCount, $totalT);
                    $objWorkSheet->SetCellValue('E' . $rowCount, $totalG);
                    $objWorkSheet->setTitle('TELEVISAO-Setor');
                }
                $i++;
            }

            /**  tempo tv */
            if (!empty($istempo)) {
                //radio
                $lista_setor = $this->ComumModelo->quantitativoVeiculoTvTempo($datai,$dataf,$idCliente,$excluirSetor,$setores, $tags);
                //  $i = 3;
                if (!empty($lista_setor)) {
                    $totalP = 0;
                    $totalN = 0;
                    $totalT = 0;
                    $totalG = 0;
                    $rowCount = 1;
                    if (!empty($lista_setor)) {
                        $objWorkSheet = $planilha->createSheet($i);
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'Veiculo');
                        $objWorkSheet->SetCellValue('B' . $rowCount, 'Positivo');
                        $objWorkSheet->SetCellValue('C' . $rowCount, 'Negativo');
                        $objWorkSheet->SetCellValue('D' . $rowCount, 'Neutro');
                        $objWorkSheet->SetCellValue('E' . $rowCount, 'Total');
                        $rowCount++;
                        foreach ($lista_setor as $itemS):
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESCRICAO']);
                            $objWorkSheet->SetCellValue('B' . $rowCount, convertSegundo2HMS($itemS['POSITIVO']));
                            $objWorkSheet->SetCellValue('C' . $rowCount, convertSegundo2HMS($itemS['NEGATIVO']));
                            $objWorkSheet->SetCellValue('D' . $rowCount, convertSegundo2HMS($itemS['NEUTRO']));
                            $objWorkSheet->SetCellValue('E' . $rowCount, convertSegundo2HMS($itemS['TOTAL']));
                            $rowCount++;
                        endforeach;
                        $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                        $objWorkSheet->SetCellValue('B' . $rowCount, convertSegundo2HMS($totalP));
                        $objWorkSheet->SetCellValue('C' . $rowCount, convertSegundo2HMS($totalN));
                        $objWorkSheet->SetCellValue('D' . $rowCount, convertSegundo2HMS($totalT));
                        $objWorkSheet->SetCellValue('E' . $rowCount, convertSegundo2HMS($totalG));
                        $objWorkSheet->setTitle('TV-TEMPO');
                    }
                    $i++;
                }
            }
            /*** fim tempo tv ****/

            $objWriter = PHPExcel_IOFactory::createWriter($planilha, "Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
            $objWriter->save($arquivo);
            $objWriter = PHPExcel_IOFactory::createWriter($planilha, "Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
            $objWriter->save($arquivo);

            $this->load->helper('download');

            $dataBinary = file_get_contents($arquivo);

            force_download(basename($arquivo), $dataBinary, TRUE);
        }

    }

    public function ajaxRelease($idMateria, $idNovo = NULL)
    {
        try {
            $data = array(
                'IND_RELEASE' => ($idNovo > 0) ? 'S' : 'N',
                'SEQ_RELEASE' => $idNovo
            );
            $this->inserirAuditoria('ALTERAR-MATERIA-RELEASE', 'A', 'id:' . $idMateria);
            $this->MateriaModelo->alterar($data, $idMateria);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            http_response_code(400);
        }
    }

    public function contadorRelease()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-RELATORIO-RELEASE', 'C', '');
        $idCliente = !empty($idCliente)?$idCliente:$this->session->userData('idClienteSessao');

        if (empty($datai))
            if (!empty($this->session->userdata('datai')))
                $datai = $this->session->userdata('datai');
            else
                $datai = date('01/m/Y');

        if (empty($dataf))
            if (!empty($this->session->userdata('dataf')))
                $dataf = $this->session->userdata('dataf');
            else
                $dataf = date('d/m/Y');

        if (empty($datae))
            if (!empty($this->session->userdata('datae')))
                $datae = $this->session->userdata('datae');
            else
                $datae = date('d/m/Y');

        if (empty($dataef))
            if (!empty($this->session->userdata('dataef')))
                $dataef = $this->session->userdata('dataef');
            else
                $dataef = date('d/m/Y');


        $resultado['datai'] = $datai;
        $resultado['dataf'] = $dataf;
        $resultado['datae'] = $datae;
        $resultado['dataef'] = $dataef;
        $resultado['tipo'] = !empty($tipo)?$tipo:NULL;
        $resultado['idCliente'] = !empty($idCliente)?$idCliente:NULL;

        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
        $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria($idCliente);

        $this->loadUrl('modulos/relatorio/consultar-release', $resultado);
    }
    private function periodoRelease($dateStart, $dateEnd) {
        $dateStart = implode('-', array_reverse(explode('/', substr($dateStart, 0, 10)))) . substr($dateStart, 10);
        $dateStart = new DateTime($dateStart);

        $dateEnd = implode('-', array_reverse(explode('/', substr($dateEnd, 0, 10)))) . substr($dateEnd, 10);
        $dateEnd = new DateTime($dateEnd);

        $dateRange = array();
        while ($dateStart <= $dateEnd) {
            $dateRange[] = $dateStart->format('Y-m-d');
            $dateStart = $dateStart->modify('+1day');
        }
        
        return $dateRange;
    }

    public function processaRelease()
    {
        set_time_limit(0);
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-CONTAGEM-POR-RELEASE', 'C', '');
        if ($acao == 'I') {
            $this->contadorRelease();
            return;
        } else if ($acao == 'pdf') {

            $cliente = $this->ComumModelo->getCliente($idCliente)->row();

/*             echo '<pre>';
 */            $qt = [];
            
            $res_a =  $this->ComumModelo->quantitativoRelease($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo, $veiculo);
//            echo $this->db->last_query();
//           print_r($res_a);
//           die();
            /* foreach ($res_a as $valor_a) {
                $dado = array();
                $seq_release = $valor_a['releasecodigo'];
                $res_b = $this->ComumModelo->quantitativoReleaseB($seq_release,$datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
                $tot = $valor_a['quantidade'] + $res_b[0]['quantidade'];
                $dado['releasecodigo'] = $valor_a['releasecodigo'];
                $dado['descricaorelease'] = $valor_a['descricaorelease'];
                $dado['quantidade'] = $tot;
                 if ($dado['quantidade'] > 0) {
                    $qt[] = $dado;
                } 
                $qt[] = $dado;
            } */
            $resultado['contador'] = count($res_a);
            $resultado['release']['itens'] = $res_a;
           /*  print_r($resultado['release']['itens']);
            die(); */
            $quant_por_dia = [];
            $per = $this->periodoRelease($datai, $dataf);
            
            foreach ($per as $periodo_pub) {
                $dado = array();
                if (in_array("S", $veiculo)) {
                    $pub_internet = $this->ComumModelo->quantitativoReleasePorDia(date("d/m/Y",strtotime($periodo_pub)), $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
                }
                if ($_POST['grupo'] != 15) {
                    if (in_array("R", $veiculo)) {    
                        $pub_radio = $this->ComumModelo->quantitativoReleasePorDiaRadio(date("d/m/Y",strtotime($periodo_pub)), $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
                    }
                    if (in_array("T", $veiculo)) {
                    $pub_tv = $this->ComumModelo->quantitativoReleasePorDiaTV(date("d/m/Y",strtotime($periodo_pub)), $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
                    }
                    if (in_array("I", $veiculo)) {
                    $pub_impresso = $this->ComumModelo->quantitativoReleasePorDiaImpresso(date("d/m/Y",strtotime($periodo_pub)), $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
                    }                    
                } else {
                $pub_radio = [];
                $pub_tv = [];
                $pub_impresso = [];
                }
                
                
                $tot_dia = $pub_radio['quantidade'] + $pub_internet['quantidade_publicacoes'] + $pub_tv['quantidade'] + $pub_impresso['quantidade'];
                
                
                $dado['dia'] =  date("d/m/Y",strtotime($periodo_pub));
                $dado['quantidade'] =  $tot_dia;
                $quant_por_dia[] = $dado;
            }
            $resultado['release']['itenspordia'] = $quant_por_dia;
//            print_r($resultado['release']['itenspordia']);
//            die();
            $total_pub_geral = 0;

            foreach ($quant_por_dia as $valor_quantidade) {
                $total_pub_geral = $total_pub_geral + $valor_quantidade['quantidade'];
            }
            $resultado['release']['total_pub_geral'] = $total_pub_geral;
            $total = 0;
            foreach ($resultado['release']['itens'] as $index => $valor) {
                $total += $valor['quantidade'];
            }
            $resultado['release']['total'] = $total;
            
            /**
             * setor
             */
            $resultado['releaseSetor']['itens'] = $this->ComumModelo->quantitativoReleaseSetor($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $veiculo);
            $total = 0;
            if($cliente->SEQ_CLIENTE == 1) {
            $resultado['releaseSetor']['mais'] = $resultado['releaseSetor']['itens'][0]['setor'];
            $resultado['releaseSetor']['quant'] = $resultado['releaseSetor']['itens'][0]['quantidade'];
            }
            foreach ($resultado['releaseSetor']['itens'] as $index => $valor) {
                $total += $valor['quantidade'];
            }
            $resultado['releaseSetor']['total'] = $total;
            
            $resultado['releaseSetorSecretaria']['itens'] =  $this->ComumModelo->quantitativoReleaseSecretaria($datai, $dataf, $idCliente, $veiculo);
            
            $total = 0;
          
            foreach ($resultado['releaseSetorSecretaria']['itens'] as $index => $valor) {
                $total += $valor->QUANTIDADE;
            }
            $resultado['releaseSecretaria']['total'] = $total;
            
            /**
             * veiculo
             */
            if (in_array("S", $veiculo)) {
            $resultado['releaseVeiculo']['itens'] = $this->ComumModelo->quantitativoReleaseVeiculo($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
            } else {
            $resultado['releaseVeiculo']['itens'] = [];    
            }
            /*echo $this->db->last_query();
            die('AQUI'); */
            if (in_array("R", $veiculo)) {
            $resultado['releaseVeiculoRadio']['itens'] = $this->ComumModelo->quantitativoReleaseVeiculoRadio($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
            } else {
            $resultado['releaseVeiculoRadio']['itens'] = [];    
            }
            if ($_POST['grupo'] != 15) {
                if (in_array("T", $veiculo)) {
                    $resultado['releaseVeiculoTv']['itens'] = $this->ComumModelo->quantitativoReleaseVeiculoTV($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
                } else {
                    $resultado['releaseVeiculoTv']['itens'] = [];
                }
            } else {
                $resultado['releaseVeiculoTv']['itens'] = [];
            }
            if ($_POST['grupo'] != 15) {
                if (in_array("I", $veiculo)) {
                    $resultado['releaseVeiculoImpresso']['itens'] = $this->ComumModelo->quantitativoReleaseVeiculoImpresso($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
                } else {
                    $resultado['releaseVeiculoImpresso']['itens'] = [];
                }
            } else {
                $resultado['releaseVeiculoImpresso']['itens'] = [];
            }
            $total = 0;
            foreach ($resultado['releaseVeiculo']['itens'] as $index => $valor) {
                $total += $valor['quantidade'];
            }
            $resultado['releaseVeiculo']['total'] = $total;
            
            $total = 0;
            foreach ($resultado['releaseVeiculoRadio']['itens'] as $index => $valor) {
                $total += $valor['quantidade'];
            }
            $resultado['releaseVeiculoRadio']['total'] = $total;
            
            $total = 0;
            
            foreach ($resultado['releaseVeiculoTv']['itens'] as $index => $valor) {
                $total += $valor['quantidade'];
            }
            $resultado['releaseVeiculoTv']['total'] = $total;
            
            $total = 0;
            foreach ($resultado['releaseVeiculoImpresso']['itens'] as $index => $valor) {
                $total += $valor['quantidade'];
            }
            $resultado['releaseVeiculoImpresso']['total'] = $total;
            /*
             *  pauta
             */
            $resultado['releasePauta']['itens'] = $this->ComumModelo->quantitativoReleasePauta($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $veiculo);
            $total = 0;
            foreach ($resultado['releasePauta']['itens'] as $index => $valor) {
                $total += $valor['quantidade'];
            }
            $resultado['releasePauta']['total'] = $total;

            /**
             * veiculo sem publicacao
             */
//            $resultado['releaseSemPublicacao']['itens'] = $this->ComumModelo->quantitativoReleaseSemPublicacao($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
//            $total = 0;
//            foreach ($resultado['releaseSemPublicacao']['itens'] as $index => $valor) {
//                $total += $valor['quantidade'];
//            }
//            $resultado['releaseSemPublicacao']['total'] = $total;
//            echo '<pre>';
//            print_r($resultado);
//            die();
            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');

            $dataFiltro1 = strftime("%d de %B de %Y", strtotime(date("d M Y", strtotime(str_replace('/', '-', $datai)))));
            $dataFiltro2 = strftime("%d de %B de %Y", strtotime(date("d M Y", strtotime(str_replace('/', '-', $dataf)))));

            $dataFiltroEnvio1 = strftime("%d de %B de %Y", strtotime(date("d M Y", strtotime(str_replace('/', '-', $datae)))));
            $dataFiltroEnvio2 = strftime("%d de %B de %Y", strtotime(date("d M Y", strtotime(str_replace('/', '-', $dataef)))));

            $periodo = '';
            if ($dataFiltro1 == $dataFiltro2) {
                $periodo = utf8_encode($dataFiltro1);
            } else {
                $periodo = utf8_encode($dataFiltro1) . ' a ' . utf8_encode($dataFiltro2);
            }

            $periodoEnvio = '';
            if ($dataFiltroEnvio1 == $dataFiltroEnvio2) {
                $periodoEnvio = utf8_encode($dataFiltroEnvio1);
            } else {
                $periodoEnvio = utf8_encode($dataFiltroEnvio1) . ' a ' . utf8_encode($dataFiltroEnvio2);
            }

            $resultado['datai'] = utf8_encode($dataFiltroEnvio1). ' a ';
            $resultado['dataf'] = utf8_encode($dataFiltroEnvio2);
            
            if($cliente->SEQ_CLIENTE == 1) {
            $templatePath = APPPATH . '/third_party/template/modelo/novo-relatorio-release-quantidade.docx';
            } else {
            $templatePath = APPPATH . '/third_party/template/modelo/relatorio-release-quantidade.docx';    
            }
            $tempDir = sys_get_temp_dir();
            $tempDir .= "/" . uniqid();
            mkdir($tempDir, null, true);

            $docxTemplate = $this->template->load($templatePath);
            $this->template->setDataRelease(
                utf8_decode($cliente->EMPRESA_CLIENTE),
                $periodo,
                $periodoEnvio,
                $resultado
            );

            $dataContent = $this->template->getJsonRelease();

//            echo ($dataContent);
//            die;
            if($cliente->SEQ_CLIENTE == 1) {
            $outputPath = $tempDir . '/novo-relatorio-release-quantidade.docx';   
            } else {
            $outputPath = $tempDir . '/relatorio-release-quantidade.docx';
            }
            $data = json_decode($dataContent, true);

            //testing merge method
            $docxTemplate->merge($data, $outputPath, true, false);


        } else {
            $this->load->library('excel');
            $arquivo = FCPATH . 'lixo/' . (date('dmY')) . 'veiculo' . '.xlsx';
            $planilha = $this->excel;
            $planilha->setActiveSheetIndex(0);
            //impresso
            $lista_resultado = $this->ComumModelo->quantitativoRelease($datai, $dataf, $idCliente, $grupo, $datae, $dataef, $tipo);
            $i = 0;
            if (!empty($lista_resultado)) {
//                $controle = 1;
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_resultado)) {
                    $objWorkSheet = $planilha->getActiveSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Descricao Release');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Quantidade');
                    $rowCount++;
                    foreach ($lista_resultado as $itemS):
                        $totalN += $itemS['QUANTIDADE'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_RELEASE']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['QUANTIDADE']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalN);
                    $objWorkSheet->setTitle('RELEASE');
                }
            }

            $objWriter = PHPExcel_IOFactory::createWriter($planilha, "Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
            $objWriter->save($arquivo);
            $objWriter = PHPExcel_IOFactory::createWriter($planilha, "Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
            $objWriter->save($arquivo);

            $this->load->helper('download');

            $dataBinary = file_get_contents($arquivo);

            force_download(basename($arquivo), $dataBinary, TRUE);
        }

    }

    public function processaRelatorioMark($datai, $dataf, $idCliente, $veiculo, $portal, $origens, $avaliacoes,
                                          $texto, $idSetor, $radio, $tipo, $tv, $tipoMat, $horair, $horafr, $datai2, $dataf2, $release, $grupo,
                $usuario, $isrelease)
    {
        $cliente = $this->ComumModelo->getCliente($idCliente)->row();

        $setores = $this->ComumModelo->listaSetorClienteMat($idCliente);

        $veiculosTemp = array();
        foreach ($setores as $itemS):
            // carregar os veiculos

            $veiculos = $this->ComumModelo->quantitativoSuperTvSetorVeiculo(
                $datai, $dataf, $idCliente, NULL, $portal, $origens, $avaliacoes,
                $texto, $itemS['id'], $radio, $tipo, $tv, 'T', $horair, $horafr, $datai2, $dataf2, $release, $grupo,
                $usuario, $isrelease);



            foreach ($veiculos as $index => $itemv) {

                $itemSetor = $this->ComumModelo->quantitativoSuperTv(
                    $datai, $dataf, $idCliente, NULL, $portal, $origens, $avaliacoes,
                    $texto, $itemS['id'], $radio, $tipo, $itemv['idveiculo'], 'T', $horair, $horafr, $datai2, $dataf2, $release, $grupo,
                    $usuario, $isrelease);

                $totalRadio = 0;
                $totalPrograma = 0;
                $totalInsercao = 0;
                $totalTotal = 0;
                $tempo = 0;
                $itemSetorTemp = array();
                foreach ($itemSetor as $index => $itemi) {
                    $totalRadio++;
                    $totalPrograma++;
                    $totalInsercao += $itemi['insercao'];
                    $totalTotal += $itemi['vltotal'];
                    $tempo += $itemi['tempo'];

                    $itemTemp = array(
                        'programa' => $itemi['programa'],
                        'insercao' => $itemi['insercao'],
                        'vlunitario' => $itemi['vlunitario'],
                        'vltotal' => $itemi['vltotal'],
                        'tempo' => convertSegundo2HMS($itemi['tempo'])
                    );
                    array_push($itemSetorTemp, $itemTemp);

                };
                if ($totalInsercao > 0) {
                    $setorTemp = array(
                        'setor' => $itemv['nomesetor'],
                        'nomeveiculo' => $itemv['nomeveiculo'],
                        'items'=>$itemSetorTemp,
                        'totalRadio' => $totalRadio,
                        'totalPrograma' => $totalPrograma,
                        'totalInsercao' => $totalInsercao,
                        'totalUnitario' => '-',
                        'totalTotal' => $totalTotal,
                        'totalTempo' => convertSegundo2HMS($tempo)
                    );
                    array_push($veiculosTemp, $setorTemp);
                }
            }
        endforeach;

// fim setores tv
        $veiculosTemp2 = array();
        foreach ($setores as $itemS):
            // carregar os veiculos

            $veiculos = $this->ComumModelo->quantitativoSuperRadioSetorVeiculo(
                $datai, $dataf, $idCliente, NULL, NULL, $origens, $avaliacoes,
                $texto, $itemS['id'], NULL, $tipo, $tv, 'R', $horair, $horafr, $datai2, $dataf2, $release, $grupo,
                $usuario, $isrelease);
            foreach ($veiculos as $index => $itemv) {

                $itemSetor = $this->ComumModelo->quantitativoSuperRadio(
                    $datai, $dataf, $idCliente, NULL, NULL, $origens, $avaliacoes,
                    $texto, $itemS['id'], $itemv['idveiculo'], $tipo, NULL, 'R', $horair, $horafr, $datai2, $dataf2, $release, $grupo,
                    $usuario, $isrelease);

                $totalRadio = 0;
                $totalPrograma = 0;
                $totalInsercao = 0;
                $totalTotal = 0;
                $tempo = 0;
                $itemSetorTemp2 = array();
                foreach ($itemSetor as $index => $itemi) {
                    $totalRadio++;
                    $totalPrograma++;
                    $totalInsercao += $itemi['insercao'];
                    $totalTotal += $itemi['vltotal'];
                    $tempo += $itemi['tempo'];

                    $itemTemp = array(
                        'programa' => $itemi['programa'],
                        'insercao' => $itemi['insercao'],
                        'vlunitario' => $itemi['vlunitario'],
                        'vltotal' => $itemi['vltotal'],
                        'tempo' => convertSegundo2HMS($itemi['tempo'])
                    );
                    array_push($itemSetorTemp2, $itemTemp);

                };
                if ($totalInsercao > 0) {
                    $setorTemp = array(
                        'setor' => $itemv['nomesetor'],
                        'nomeveiculo' => $itemv['nomeveiculo'],
                        'items'=>$itemSetorTemp,
                        'totalRadio' => $totalRadio,
                        'totalPrograma' => $totalPrograma,
                        'totalInsercao' => $totalInsercao,
                        'totalUnitario' => '-',
                        'totalTotal' => $totalTotal,
                        'totalTempo' => convertSegundo2HMS($tempo)
                    );
                    array_push($veiculosTemp2, $setorTemp);
                }
            }
        endforeach;
        $resultado = array(
            'televisao'=>$veiculosTemp,
            'radio'=>$veiculosTemp2
        );

        $templatePath = APPPATH . '/third_party/template/modelo/relatorio-mark-quantidade.docx';

        $tempDir = sys_get_temp_dir();
        $tempDir .= "/" . uniqid();
        mkdir($tempDir, null, true);

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $dataGeracao = strftime("%d de %B de %Y", strtotime(date("d M Y")));

        $docxTemplate = $this->template->load($templatePath);
        $this->template->setDataMark(
            $cliente->EMPRESA_CLIENTE,
            $dataGeracao,
            $resultado
        );

        $dataContent = $this->template->getJsonRelease();
//        echo $dataContent;
//        die;

        $outputPath = $tempDir . '/relatorio-mark-quantidade.docx';

        $datafim = json_decode($dataContent, true);

//            print_r($datafim);
//            die;
 
        $docxTemplate->merge($datafim, $outputPath, true, false);
    }
    public function contadorArea()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-RELATORIO-AREA', 'C', '');


        if (empty($datai))
            if (!empty($this->session->userdata('datai')))
                $datai = $this->session->userdata('datai');
            else
                $datai = date('01/m/Y');

        if (empty($dataf))
            if (!empty($this->session->userdata('dataf')))
                $dataf = $this->session->userdata('dataf');
            else
                $dataf = date('d/m/Y');

        $resultado['datai'] = $datai;
        $resultado['dataf'] = $dataf;

        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();

        $this->loadUrl('modulos/relatorio/consultar-area', $resultado);
    }
    public function processaArea()
    {
        set_time_limit(0);
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-CONTAGEM-POR-RELEASE', 'C', '');
        if ($acao == 'pdf') {

            $cliente = $this->ComumModelo->getCliente($idCliente)->row();

            /**
             *  POR AREA
             */
            $resultado['area']['itens'] = $this->ComumModelo->quantitativoArea($datai, $dataf, $idCliente, $grupo);
            $totalp = 0;
            $totaln = 0;
            $totalt = 0;
            foreach ($resultado['area']['itens'] as $index => $valor) {
                $totalp += $valor['positiva'];
                $totaln += $valor['negativa'];
                $totalt += $valor['areatotal'];
            }
            $resultado['area']['positivageral'] = $totalp;
            $resultado['area']['negativageral'] = $totaln;
            $resultado['area']['areatotalgeral'] = $totalt;


            /**
             * TOTAL POR COMENT�RIO
             */
            $resultado['areaComentario']['itens'] = $this->ComumModelo->quantitativoComentario($datai, $dataf, $idCliente, $grupo);
            $total = 0;
            foreach ($resultado['areaComentario']['itens'] as $index => $valor) {
                $total += $valor['totall'];
            }
            $resultado['areaComentario']['total'] = $total;



            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');

            $dataFiltro1 = strftime("%d de %B de %Y", strtotime(date("d M Y", strtotime(str_replace('/', '-', $datai)))));
            $dataFiltro2 = strftime("%d de %B de %Y", strtotime(date("d M Y", strtotime(str_replace('/', '-', $dataf)))));

            $periodo = '';
            if ($dataFiltro1 == $dataFiltro2) {
                $periodo = $dataFiltro1;
            } else {
                $periodo = $dataFiltro1 . ' a ' . $dataFiltro2;
            }


            $templatePath = APPPATH . '/third_party/template/modelo/relatorio-area-quantidade.docx';

            $tempDir = sys_get_temp_dir();
            $tempDir .= "/" . uniqid();
            mkdir($tempDir, null, true);

            $docxTemplate = $this->template->load($templatePath);
            $this->template->setDataArea(
                utf8_decode($cliente->EMPRESA_CLIENTE),
                $periodo,
                $resultado
            );
            $dataContent = $this->template->getJsonRelease();


            $outputPath = $tempDir . '/relatorio-area-quantidade.docx';

            $data = json_decode($dataContent, true);

            //testing merge method
            $docxTemplate->merge($data, $outputPath, true, false);


        } else {
            $this->load->library('excel');
            $arquivo = FCPATH . 'lixo/' . (date('dmY')) . 'veiculo' . '.xlsx';
            $planilha = $this->excel;
            $planilha->setActiveSheetIndex(0);
            //impresso
            $lista_resultado = $this->ComumModelo->quantitativoRelease($datai, $dataf, $idCliente, $grupo);
            $i = 0;
            if (!empty($lista_resultado)) {
//                $controle = 1;
                $totalP = 0;
                $totalN = 0;
                $totalT = 0;
                $totalG = 0;
                $rowCount = 1;
                if (!empty($lista_resultado)) {
                    $objWorkSheet = $planilha->getActiveSheet($i);
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'Descricao Release');
                    $objWorkSheet->SetCellValue('B' . $rowCount, 'Quantidade');
                    $rowCount++;
                    foreach ($lista_resultado as $itemS):
                        $totalN += $itemS['QUANTIDADE'];
                        $objWorkSheet->SetCellValue('A' . $rowCount, $itemS['DESC_RELEASE']);
                        $objWorkSheet->SetCellValue('B' . $rowCount, $itemS['QUANTIDADE']);
                        $rowCount++;
                    endforeach;
                    $objWorkSheet->SetCellValue('A' . $rowCount, 'TOTAL');
                    $objWorkSheet->SetCellValue('B' . $rowCount, $totalN);
                    $objWorkSheet->setTitle('RELEASE');
                }
            }

            $objWriter = PHPExcel_IOFactory::createWriter($planilha, "Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
            $objWriter->save($arquivo);
            $objWriter = PHPExcel_IOFactory::createWriter($planilha, "Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
            $objWriter->save($arquivo);

            $this->load->helper('download');

            $dataBinary = file_get_contents($arquivo);

            force_download(basename($arquivo), $dataBinary, TRUE);
        }

    }

    public function linkMateria()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-RELATORIO-POR-GERAL', 'C', '');


        if (empty($datai))
            if (!empty($this->session->userdata('datai')))
                $datai = $this->session->userdata('datai');
            else
                $datai = date('01/m/Y');

        if (empty($dataf))
            if (!empty($this->session->userdata('dataf')))
                $dataf = $this->session->userdata('dataf');
            else
                $dataf = date('d/m/Y');
        $tipos = NULL;
        if(!empty($tipo) and is_array($tipo)) {
            $tipos = implode(',',$tipo);
        } else if (!empty($tipo)){
            $tipos =$tipo;
        }

        $resultado['datai'] = $datai;
        $resultado['dataf'] = $dataf;
        $resultado['idCliente'] = $this->session->userdata('idClienteSessao');

        $resultado['lista_setor'] = $this->SetorModelo->listaSetor();
        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
        $this->loadUrl('modulos/relatorio/consultar-link', $resultado);
    }
    
    private function tipoVeiculoLink($planilha, $lista_setor, $i, $novaAba, $tituloAba) {
        if (!empty($lista_setor)) {
            $rowCount = 1;
            if ($novaAba == 0) {
                $objWorkSheet = $planilha->getActiveSheet($i);
            } else {
                $objWorkSheet = $planilha->createSheet($i);
            }
            $objWorkSheet->SetCellValue('A' . $rowCount, 'DATA');
            $objWorkSheet->SetCellValue('B' . $rowCount, 'VEÍCULO');
            $objWorkSheet->SetCellValue('C' . $rowCount, 'SEÇÃO/PROGRAMA');
            $objWorkSheet->SetCellValue('D' . $rowCount, 'CIDADE');
            $objWorkSheet->SetCellValue('E' . $rowCount, 'TÍTULO');
            $objWorkSheet->SetCellValue('F' . $rowCount, 'TEMA');
            $objWorkSheet->SetCellValue('G' . $rowCount, 'LINK');
            $objWorkSheet->SetCellValue('H' . $rowCount, 'AVALIAÇÃO');
            $objWorkSheet->SetCellValue('I' . $rowCount, 'POSITIVO');
            $objWorkSheet->SetCellValue('J' . $rowCount, 'NEGATIVO');
            $objWorkSheet->SetCellValue('K' . $rowCount, 'NEUTRO');
            $objWorkSheet->SetCellValue('L' . $rowCount, 'OUTRAS SECRETARIAS');
            $rowCount++;
            foreach ($lista_setor as $item):

                $objWorkSheet->SetCellValue('A' . $rowCount, $item['DATA_PUB']);
                $objWorkSheet->SetCellValue('B' . $rowCount, $item['NOME_VEICULO']);
                $secao = explode('/', $item['SECAO_PROGRAMA']);
                $secao = array_filter($secao);
                $objWorkSheet->SetCellValue('C' . $rowCount, implode('/', $secao));
                $objWorkSheet->SetCellValue('D' . $rowCount, $item['CIDADE_VEICULO']);
                $objWorkSheet->SetCellValue('E' . $rowCount, $item['TIT_MATERIA']);
                $objWorkSheet->SetCellValue('F' . $rowCount, $item['DESC_SETOR']);
                $objWorkSheet->SetCellValue('G' . $rowCount, url_materia_simples() . "/" . $item['CHAVE']);

                $objWorkSheet->getCell('G' . $rowCount)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING);
                $objWorkSheet->getCell('G' . $rowCount)->getHyperlink()->setUrl(strip_tags(url_materia_simples() . "/" . $item['CHAVE']))->setTooltip('Click para acessar online esta matéria');
                $objWorkSheet->getStyle('G' . $rowCount)->applyFromArray(array('font' => array('color' => ['rgb' => '0000FF'], 'underline' => 'single')));

                $objWorkSheet->SetCellValue('H' . $rowCount, $item['IND_AVALIACAO']);
                $objWorkSheet->SetCellValue('I' . $rowCount, $item['POSITIVO']);
                $objWorkSheet->SetCellValue('J' . $rowCount, $item['NEGATIVO']);
                $objWorkSheet->SetCellValue('K' . $rowCount, $item['NEUTRO']);
                $SQL = 'SELECT  GROUP_CONCAT( DISTINCT SETOR.SIG_SETOR) AS SIGLA,  GROUP_CONCAT( DISTINCT SETOR.DESC_SETOR) AS SETOR FROM SECRETARIA_MATERIA SECRETARIA_MATERIA JOIN SETOR SETOR ON SETOR.SEQ_SETOR = SECRETARIA_MATERIA.SEQ_SETOR WHERE SECRETARIA_MATERIA.SEQ_MATERIA = '.$item['SEQ_MATERIA'];
                $os = $this->db->query($SQL)->row_array();
                
                if (empty($os)) {
                    $objWorkSheet->SetCellValue('L' . $rowCount, '-');
                } else {
                    $objWorkSheet->SetCellValue('L' . $rowCount, $os['SIGLA']);
                }
                
                
                $rowCount++;
            endforeach;
            // foreach(range('A','K') as $columnID) {
            for ($columnID = 'A'; $columnID != $objWorkSheet->getHighestColumn(); $columnID++) {
                $objWorkSheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            $objWorkSheet->setTitle($tituloAba);
            $objWorkSheet->getColumnDimension('L')->setWidth(60);
            $i++;
        }
    }

    public function processaLinkMateria()
    {
        
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-RELATORIO-LISTA-LINK', 'C', '');
       
        if ($acao == 'I') {

            $resultado['datai'] = $datai;
            $resultado['dataf'] = $dataf;

            $resultado['idCliente'] = $idCliente;
            $resultado['lista_setor'] = $this->SetorModelo->listaSetorAlerta($idCliente);
            $this->loadUrl('modulos/relatorio/consultar-link', $resultado);
            return;
        }

        set_time_limit(0);

            $this->load->library('excel');
            $arquivo = FCPATH . 'lixo/' . (date('dmY')) . 'linksMateriaSetor' . '.xlsx';
            $planilha = $this->excel;
            $planilha->setActiveSheetIndex(0);

            $setores=NULL;
            $setor = !empty($setor)?$setor:NULL;
            if (is_array($setor)){
                $setores = implode($setor,',');
            } else {
                $setores = $setor;
            }

            $tipos=NULL;
            $tipo = !empty($tipo)?$tipo:NULL;
            if (is_array($tipo)){
                $tipos = implode($tipo,',');
            } else {
                $tipos = $tipo;
            }
            
            //IMPRESSO
            $lista_setor = $this->ComumModelo->listaMateriaLinkVeiculo($datai, $dataf, $idCliente, $tipos,$setores, 'I');
            
            $this->tipoVeiculoLink($planilha, $lista_setor, 0, 0, 'Impresso');
            
            // INTERNET
            $lista_setor = $this->ComumModelo->listaMateriaLinkVeiculo($datai, $dataf, $idCliente, $tipos,$setores, 'S');
            $this->tipoVeiculoLink($planilha, $lista_setor, 1, 1, 'Internet');
            
            // RÁDIO
            $lista_setor = $this->ComumModelo->listaMateriaLinkVeiculo($datai, $dataf, $idCliente, $tipos,$setores, 'R');
            $this->tipoVeiculoLink($planilha, $lista_setor, 2, 1, 'Rádio');
            
             // TELEVISÃO
            $lista_setor = $this->ComumModelo->listaMateriaLinkVeiculo($datai, $dataf, $idCliente, $tipos,$setores, 'T');
            $this->tipoVeiculoLink($planilha, $lista_setor, 3, 1, 'Televisão');

            // PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
            $objWriter = PHPExcel_IOFactory::createWriter($planilha, "Excel2007");//new PHPExcel_Writer_Excel2007($planilha);
            $objWriter->save($arquivo);

            $this->load->helper('download');

            $dataBinary = file_get_contents($arquivo);

            force_download(basename($arquivo), $dataBinary, TRUE);

    }
    
}
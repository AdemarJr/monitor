<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
class Principal extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('teste/usuarioModelo', 'UsuarioModelo');
        $this->load->model('teste/notificacaoModelo', 'NotificacaoModelo');
        $this->load->model('teste/clienteModelo', 'ClienteModelo');
        $this->load->model('teste/veiculoModelo', 'VeiculoModelo');
        $this->load->model('MateriaModeloMonitor', 'MateriaModelo');
    }

    private function loadUrl($url, $data=NULL){
        $header = $this->session->userdata();
        $header['notificacoes'] = $this->NotificacaoModelo->getNotificacaoUsuario($this->session->userdata('idUsuario'));
        $this->load->view('modulos/template/cabecalho_privado',$header);
        $this->load->view($url,$data);
        $this->load->view('modulos/template/rodape_privado');
    }
    public function loadUrlUsuario($url, $data = NULL)
    {
        $header = $this->session->userdata();
        $header['notificacoes'] = $this->NotificacaoModelo->getNotificacaoUsuario($this->session->userdata('idUsuario'));
        $this->load->view('modulos/template/cabecalho_dashboard_usuario',$header);
        $this->load->view($url, $data);
        $this->load->view('modulos/template/rodape_dashboard');
    }
    public function inserirAuditoria($operacao = NULL, $tipo = NULL, $obs = NULL)
    {
        $data = $this->session->userdata();
        $tb_auditoria = array(
            'SEQ_USUARIO' => $data['idUsuario'],
            'TIPO_AUDITORIA' => $tipo,
            'OPER_AUDITORIA' => $operacao,
            'OBS_AUDITORIA' => $obs,
            'SESSION_ID'=>session_id()
        );
        $this->AuditoriaModelo->inserir($tb_auditoria);
    }
    
    public function index() {
	$this->load->view('paginas/principal');
        
    }
    private function calcAvaliacao($lista){
        $totalM = $totalP = $totalN = $totalT =0;
        foreach($lista as $row){
                $totalM += $row->QTD_MATERIA;
            if ($row->IND_AVALIACAO=='P')
                $totalP += $row->QTD_MATERIA;
            if ($row->IND_AVALIACAO=='N')
                $totalN += $row->QTD_MATERIA;
            if ($row->IND_AVALIACAO=='T')
                $totalT += $row->QTD_MATERIA;
        }
        return array(
            'total_materia'=>$totalM,
            'positivo'=>$totalP,
            'negativo'=>$totalN,
            'neutro'=>$totalT,
        );

    }

    private function calculaDiaAvaliacao($avaliacao,$dia,$lista){
        $retorno =0;
        foreach($lista as $item){
            if ($item->IND_AVALIACAO==$avaliacao and $item->DATA_PUB_NUMERO==$dia)
            $retorno +=$item->QTD_MATERIA;

        }
        return $retorno;
    }
    private function getLabel($dia,$lista){
        $retorno ='';
        foreach($lista as $item){
            if ($item->DATA_PUB_NUMERO==$dia)
                return $item->DIA_PUB;
        }
        return $retorno;
    }
    private function calChartLine($lista){
        $arr_labels = array();
        foreach ($lista as $arr) { // itera a array original
            if (!in_array($arr->DATA_PUB_NUMERO,$arr_labels))
                array_push($arr_labels,$arr->DATA_PUB_NUMERO);
        }
        sort($arr_labels);
        $i=0;
        $arr_labels_final=array();
        $arr_pos = $arr_neg = $arr_neu = [];
        foreach($arr_labels as $item){
            array_push($arr_labels_final,$this->getLabel($item,$lista));
            $arr_pos[$i]=$this->calculaDiaAvaliacao('P',$item,$lista);
            $arr_neg[$i]=$this->calculaDiaAvaliacao('N',$item,$lista);
            $arr_neu[$i]=$this->calculaDiaAvaliacao('T',$item,$lista);
            $i++;
        }
        return array(
            'labels'=>$arr_labels_final,
            'data'=>array(
                array('tipo'=>'P', 'valores'=>$arr_pos),
                array('tipo'=>'N', 'valores'=>$arr_neg),
                array('tipo'=>'T', 'valores'=>$arr_neu)
            ),
        );
    }
    /** gera dados dos graficos de linha por tipo */
    private function calculaDiaTipo($avaliacao,$dia,$tipo,$lista){
        $retorno =0;
        foreach($lista as $item){
            if ($item->IND_AVALIACAO==$avaliacao and 
                $item->DATA_PUB_NUMERO==$dia and 
                $item->TIPO_MATERIA==$tipo
                )
            $retorno +=$item->QTD_MATERIA;

        }
        return $retorno;
    }
    private function calChartLineTipo($tipo,$lista){
        $arr_labels = array();
        foreach ($lista as $arr) { // itera a array original
            if (!in_array($arr->DATA_PUB_NUMERO,$arr_labels))
                array_push($arr_labels,$arr->DATA_PUB_NUMERO);
        }
        sort($arr_labels);
        $i=0;
        $arr_labels_final=array();
        $arr_pos = $arr_neg = $arr_neu = [];
        foreach($arr_labels as $item){
            array_push($arr_labels_final,$this->getLabel($item,$lista));
            $arr_pos[$i]=$this->calculaDiaTipo('P',$item,$tipo,$lista);
            $arr_neg[$i]=$this->calculaDiaTipo('N',$item,$tipo,$lista);
            $arr_neu[$i]=$this->calculaDiaTipo('T',$item,$tipo,$lista);
            $i++;
        }
        return array(
            'labels'=>$arr_labels_final,
            'data'=>array(
                array('tipo'=>'P', 'valores'=>$arr_pos),
                array('tipo'=>'N', 'valores'=>$arr_neg),
                array('tipo'=>'T', 'valores'=>$arr_neu)
            ),
        );
    }
    private function calculaMinSetor($tipo,$label,$lista){
        $retorno =0;
        foreach($lista as $item){
            if ($item->TIPO_MATERIA==$tipo and $item->DESC_SETOR==$label)
            $retorno +=$item->QTD_MINUTO;

        }
        return round($retorno/60);
    }
    private function calChartBarH($tipo,$lista){
        $arr_labels = array();
        foreach ($lista as $arr) { // itera a array original
            if (!in_array($arr->DESC_SETOR,$arr_labels))
                array_push($arr_labels,$arr->DESC_SETOR);
        }
       // sort($arr_labels);
        $i=0;
        $arr_labels_final=array();
        $arr_valores = array();
        $arr_item =[];
        foreach($arr_labels as $item){
            array_push($arr_item,
                array('label'=> $item, 'valor' => $this->calculaMinSetor($tipo,$item,$lista))
            );
            $i++;
        }

        usort($arr_item, function ($item1, $item2) {
            return $item2['valor'] <=> $item1['valor'];
        });

        foreach($arr_item as $item){
            array_push($arr_labels_final,$item['label']);
            array_push($arr_valores,$item['valor']);
        }


        return array(
            'labels'=>$arr_labels_final,
            'data'=>array(
                array('label'=>'Minutagem de '.($tipo=='T'?'TV':'Rádio'), 'valores'=>$arr_valores),
            ),
        );
    }

    private function calculaTipo($label,$lista){
        $retorno =0;
        foreach($lista as $item){
            if ($item->TIPO_MATERIA==$label)
            $retorno +=$item->QTD_MATERIA;

        }
        return $retorno;
    }
    
    
    private function calChartPie($lista){
        $arr_labels = array();
        foreach ($lista as $arr) { // itera a array original
            if (!in_array($arr->TIPO_MATERIA,$arr_labels))
                array_push($arr_labels,$arr->TIPO_MATERIA);
        }
       
        $i=0;
        $arr_labels_final=array();
        $arr_valores = array();
        $arr_item =[];
        $tipoDesc = array(
            'S'=>'Internet',
            'I'=>'Impresso',
            'R'=>'Rádio',
            'T'=>'Televisão'
        );

        foreach($arr_labels as $item){
            array_push($arr_item,
                array('label'=> $tipoDesc[$item], 'valor' => $this->calculaTipo($item,$lista))
            );
            $i++;
        }
        

        // usort($arr_item, function ($item1, $item2) {
        //     return $item2['valor'] <=> $item1['valor'];
        // });

        foreach($arr_item as $item){
            array_push($arr_labels_final,$item['label']);
            array_push($arr_valores,$item['valor']);
        }

        // echo json_encode($arr_valores);
        // die;


        return array(
            'labels'=>$arr_labels_final,
            'data'=>array(
                array('label'=>'Quantidade', 'valores'=>$arr_valores),
            ),
        );
    }

    public function iniciousuario($avaliacao='a',$dia=NULL, $di=NULL) {
        $this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());

        if ($this->session->userdata('perfilUsuario')!='ROLE_SET' and 
            $this->session->userdata('perfilUsuario')!='ROLE_CLI'){
            $this->sempermissao();
            return;
        }
        if(empty($dia))
            $dia = NULL;

        if ($this->session->userdata('perfilUsuario')=='ROLE_SET' and 
            empty($this->session->userdata('setorUsuario'))){
            $this->sempermissao();
            return;
        }


        $this->load->model('materiaModelo', 'MateriaModelo');
        $this->load->model('setorModelo', 'SetorModelo');

        $dataSessao= array(
            'dia' => '',
            'datai'=>'',
            'dataf'=>'',
            'setor'=>'',
        );
        $this->session->unset_userdata($dataSessao);
        extract($this->input->post());
        if (!empty($dia))
            $datai= substr($dia,2,2).'/'.substr($dia,0,2).'/2020';
            else if(empty($datai))
                if (!empty($this->session->userdata('datai')))
                    $datai=$this->session->userdata('datai');
                else
                    $datai = date('01/09/2020'); //date('d/m/Y',strtotime('2020-08-01 00:00:00')) ;

        if (!empty($dia))
            $dataf= substr($dia,2,2).'/'.substr($dia,0,2).'/2020';
            else if(empty($dataf))
                if (!empty($this->session->userdata('dataf')))
                    $dataf=$this->session->userdata('dataf');
                else
                    $dataf = date('d/m/Y'); // date('d/m/Y',strtotime('2020-08-10 00:00:00'));

        if(empty($texto)) 
            $texto=NULL;
        if (empty($setor) and !empty($this->session->userdata('setor'))){
                $setor = $this->session->userdata('setor');
        } else if (empty($setor) and $this->session->userdata('perfilUsuario')=='ROLE_SET' 
            and !empty($this->session->userdata('setorUsuario'))){
                $setor = $this->session->userdata('setorUsuario');
        } else  if (empty($setor)){
            $setor = NULL;
        }

        $dataSessao= array(
            'dia' => $dia,
            'datai'=>$datai,
            'dataf'=>$dataf,
            'setor'=>$setor,
        );
        $this->session->set_userdata($dataSessao);

        if (!empty($setor)){
            $resultado['lista_dias']=$this->MateriaModelo->listaMateriaSetor($dia,$setor,$texto,$avaliacao,$datai,$dataf,$di);
        } else {
            $resultado['lista_dias']=$this->MateriaModelo->listaMateriaSetor($dia,NULL,$texto,$avaliacao,$datai,$dataf,$di);
        }
        $listagem = $this->MateriaModelo->dadosEleicao($setor,$datai);
        $listagemMinu = $this->MateriaModelo->dadosEleicaoMinutagem($setor,$datai);
        
        $header['total_avaliacao'] =  $this->calcAvaliacao($listagem);
        $header['total'] =  count($resultado['lista_dias']);
        $header['setor']=$setor;
        $header['datai']=$datai;
        $header['dataf']=$dataf;
        $header['lista_setor'] = $this->SetorModelo->listaSetor(59);

        $header['idCliente'] =  $this->session->userdata('idClienteSessao');
        $resultado['idCliente']=$this->session->userdata('idClienteSessao');
        $resultado['texto']=$texto;
        /*carrega dados do grafico de linha */
        $datas = $this->calChartLine($listagem);

        $this->load->library('cline');
        $this->cline->load(
                $datas['labels']
                ,$datas['data']);
        $resultado['data_line']= $this->cline->getJson();

        /*carrega dados do grafico de barra horizontal */
        $datas_min_tv = $this->calChartBarH('T',$listagemMinu);
        $datas_min_radio = $this->calChartBarH('R',$listagemMinu);
        $this->load->library('cbar');
        $this->cbar->load(
                'horizontalBar',
                $datas_min_tv['labels']
                ,$datas_min_tv['data']);
        $resultado['data_bar_tv']= $this->cbar->getJson();
        $this->cbar->load(
            'horizontalBar',
            $datas_min_radio['labels']
            ,$datas_min_radio['data']);
        $resultado['data_bar_radio']= $this->cbar->getJson();

        /* carrega dados de pizza */
        $datas_pie_tipo = $this->calChartPie($listagem);

        $this->load->library('cpie');

        $this->cpie->load(
            $datas_pie_tipo['labels']
            ,$datas_pie_tipo['data']);
        $resultado['data_pie_tipo']= $this->cpie->getJson();
        
        /* carrega dados de barra tipo */
        $datas_bar_tipo = $datas_pie_tipo;
        $this->load->library('cbar');
        $this->cbar->load(
                'bar',
                $datas_bar_tipo['labels']
                ,$datas_bar_tipo['data']);
        $resultado['data_bar_tipo']= $this->cbar->getJson();

        /*carrega dados do grafico de linha de internet */
        $datas_line_internet = $this->calChartLineTipo('S',$listagem);
        
        $this->load->library('cline');
        $this->cline->load(
                $datas_line_internet['labels']
                ,$datas_line_internet['data']);
        $resultado['data_line_internet']= $this->cline->getJson();

        /*carrega dados do grafico de linha de internet */
        $datas_line_impresso = $this->calChartLineTipo('I',$listagem);
        $this->cline->load(
                $datas_line_impresso['labels']
                ,$datas_line_impresso['data']);
        $resultado['data_line_impresso']= $this->cline->getJson();

        /*carrega dados do grafico de linha de internet */
        $datas_line_radio = $this->calChartLineTipo('R',$listagem);
        
        $this->cline->load(
                $datas_line_radio['labels']
                ,$datas_line_radio['data']);
        $resultado['data_line_radio']= $this->cline->getJson();

        /*carrega dados do grafico de linha de internet */
        $datas_line_tv = $this->calChartLineTipo('T',$listagem);
        
        $this->load->library('cline');
        $this->cline->load(
                $datas_line_tv['labels']
                ,$datas_line_tv['data']);
        $resultado['data_line_tv']= $this->cline->getJson();


        $this->load->view('modulos/template/cabecalho_dashboard_usuario',$header);
        $this->load->view('modulos/relatorio/tela-lista-eleicao', $resultado);
        $this->load->view('modulos/template/rodape_dashboard');
    }
	public function inicio() {
        //redirect('notificacao');    
        set_time_limit(0);
        if (($this->session->userdata('perfilUsuario')=='ROLE_SET'
            or $this->session->userdata('perfilUsuario')=='ROLE_CLI')
            and in_array($this->session->userdata('idClienteSessao'),array(59,62,63))){
            redirect('iniciousuario');
            return;
        }
        // if ($this->session->userdata('perfilUsuario')=='ROLE_ADM'){
        //     redirect('materia');
        //     return;
        // }
        
        $this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());
        $this->load->model('materiaModelo', 'MateriaModelo');
        $this->load->library('stackbar');
        $this->load->library('piehc');

        extract($this->input->post());

        if(empty($datai))
            if (!empty($this->session->userdata('datai')))
                $datai=$this->session->userdata('datai');
            else
                $datai = date('d/m/Y'); //date('d/m/Y',strtotime('2020-08-01 00:00:00')) ;

        if(empty($dataf))
            if (!empty($this->session->userdata('dataf')))
                $dataf=$this->session->userdata('dataf');
            else
                $dataf = date('d/m/Y'); // date('d/m/Y',strtotime('2020-08-10 00:00:00'));
        if(empty($grupo))
            $grupo ='';

        
        $resultado=NULL;

//        if (($this->auth->CheckMenu('geral','principal','dashRep')==1)  ) {
//            // impresso
//            
//            $datas = $this->MateriaModelo->pieRep($datai,$dataf);
//            $legendasPie1 = array();
//            if (!empty($datas)) {
//                // LEGENDAS 
//                foreach ($datas as $index => $valor) {
//                    array_push($legendasPie1, $valor['name']);
//                }
//            }
//
//            $this->piehc->load('Quantidade por Veiculos - Impresso', $legendasPie1, (array)$datas);
//            $resultado['pie_rep'] = $this->piehc->getJson();
            $resultado['ind_rep']=$this->MateriaModelo->indicadorRep();
//            //internet
//            $datas = $this->MateriaModelo->pieRep2($datai,$dataf);
//            $legendasPie1 = array();
//            if (!empty($datas)) {
//                // LEGENDAS
//                foreach ($datas as $index => $valor) {
//                    array_push($legendasPie1, $valor['name']);
//                }
//            }
//            $this->piehc->load('Quantidade por Veiculos - Internet', $legendasPie1, (array)$datas);
//            $resultado['pie_rep2'] = $this->piehc->getJson();
            $resultado['ind_rep2']=$this->MateriaModelo->indicadorRep2();
//        }
        $resultado['pie_cli_aval_barT']=0;
        $resultado['pie_cli_aval_bar3T']=0;
        $resultado['pie_cli_class_barT']=0;
        $resultado['pie_cli_class_bar3T']=0;
        if ((($this->auth->CheckMenu('geral','principal','dashboard')==1) or
            ($this->auth->CheckMenu('geral','principal','dashimpresso')==1) ) ) {
            /****  IMPRESSO - INICIO *****/
            $datas = $this->MateriaModelo->pieCliAval($datai, $dataf);
            $legendasPie2 = array();
            if (!empty($datas)) {
                // LEGENDAS
                foreach ($datas as $index => $valor) {
                    array_push($legendasPie2, utf8_encode($valor['name']));
                }
            }
            $this->piehc->load('Avaliacao - Impresso', $legendasPie2, $datas);
            $resultado['pie_cli_aval'] = $this->piehc->getJson();
            
            if (!empty($_SESSION['idClienteSessao'])) {
            
            $datas = $this->MateriaModelo->pieCliOri($datai, $dataf);
            $legendasPie3 = array();
            if (!empty($datas)) {
                foreach ($datas as $index => $valor) {
                    array_push($legendasPie3, $valor['name']);
                }

            }
            }
            $this->piehc->load('Origem  - Impresso', $legendasPie3, $datas);
            $resultado['pie_cli_ori'] = $this->piehc->getJson();
            // grafico de barra avaliacao
            
            $listaVeiculos = $this->MateriaModelo->pieCliVeiculo($datai, $dataf);
            
            $resultado['pie_cli_aval_barT'] = (count($listaVeiculos)*50)+150;
            // tratar categorias y
            $categorias = array();
            $positivos = array();
            $negativos = array();
            $neutros = array();
            $totalGeral = array();
            foreach ($listaVeiculos as $index => $valor) {
                array_push($categorias, $valor['FANTASIA_VEICULO']);
                $contVeiculoPosi = $this->ComumModelo->countVeiculoAvaliacao($valor['SEQ_VEICULO'], 'P', $datai, $dataf);
                $contVeiculoNega = $this->ComumModelo->countVeiculoAvaliacao($valor['SEQ_VEICULO'], 'N', $datai, $dataf);
                $contVeiculoNeut = $this->ComumModelo->countVeiculoAvaliacao($valor['SEQ_VEICULO'], 'T', $datai, $dataf);
                $contTotal = $contVeiculoPosi + $contVeiculoNega+$contVeiculoNeut;
                array_push($positivos, $contVeiculoPosi);
                array_push($negativos, $contVeiculoNega);
                array_push($neutros, $contVeiculoNeut);
                array_push($totalGeral, $contTotal);
            }
//            print_r($positivos);
//            print_r($negativos);
//            print_r($neutros);
//            die(); 
            $this->stackbar->load('Avaliacao por Veiculos Regionais  - Impresso',
                array('Positivo', 'Negativo','Neutro'),
                $categorias,
                array(0 => $positivos,
                    1 => $negativos,
                    2 => $neutros));
            $resultado['pie_cli_aval_bar'] = $this->stackbar->getJson();

            //  grafico demonstat. classificacao
            $resultado['pie_cli_class_barT'] = (count($listaVeiculos)*50)+150;
            $espontaneo = array();
            $exclusivo = array();
            $integra = array();
            $parcial = array();
            $categorias = array();
            foreach ($listaVeiculos as $index => $valor) {
                array_push($categorias, $valor['FANTASIA_VEICULO']);
                $contVeiculoEsp = $this->ComumModelo->countVeiculoClassificacao($valor['SEQ_VEICULO'], 'E', $datai, $dataf);
                $contVeiculoExc = $this->ComumModelo->countVeiculoClassificacao($valor['SEQ_VEICULO'], 'X', $datai, $dataf);
                $contVeiculoInt = $this->ComumModelo->countVeiculoClassificacao($valor['SEQ_VEICULO'], 'I', $datai, $dataf);
                $contVeiculoParc = $this->ComumModelo->countVeiculoClassificacao($valor['SEQ_VEICULO'], 'P', $datai, $dataf);
                array_push($espontaneo, $contVeiculoEsp);
                array_push($exclusivo, $contVeiculoExc);
                array_push($integra, $contVeiculoInt);
                array_push($parcial, $contVeiculoParc);
            }
            
            $this->stackbar->load('Demonstrativo por Origem e Veiculo  - Impresso',
            array(utf8_encode('Demanda Espontanea'), utf8_encode('Materia Exclusiva'), utf8_encode('Release na Integra'), 'Release Parcial'),
            $categorias,
            array(0 => $espontaneo,
            1 => $exclusivo,
            2 => $integra,
            3 => $parcial));
            $resultado['pie_cli_class_bar'] = $this->stackbar->getJson();
            
            
            //  grafico demonstat. por origem
            $listaClassificacao = $this->MateriaModelo->pieClasses($datai, $dataf);
            
            // tratar categorias y
            $categorias = array();
            $positivos = array();
            $negativos = array();
            $neutros = array();
            $totalGeral = array();
            foreach ($listaClassificacao as $index => $valor) {
                array_push($categorias, $valor['DESC_CLASSIFICACAO']);
                $contVeiculoPosi = $this->ComumModelo->countClassificacaoAvaliacao($valor['IND_CLASSIFICACAO'], 'P', $datai, $dataf);
                $contVeiculoNega = $this->ComumModelo->countClassificacaoAvaliacao($valor['IND_CLASSIFICACAO'], 'N', $datai, $dataf);
                $contVeiculoNeut = $this->ComumModelo->countClassificacaoAvaliacao($valor['IND_CLASSIFICACAO'], 'T', $datai, $dataf);
                $contTotal = $contVeiculoPosi + $contVeiculoNega + $contVeiculoNeut;
                array_push($positivos, $contVeiculoPosi);
                array_push($negativos, $contVeiculoNega);
                array_push($neutros, $contVeiculoNeut);
                array_push($totalGeral, $contTotal);

            }
            
            
            $this->stackbar->load('Demonstrativo por Origem  - Impresso/Internet',
                array('Positivo', 'Negativo','Neutro'),
                $categorias,
                array(0 => $positivos,
                    1 => $negativos,
                    2 => $neutros));
            $resultado['pie_cli_origem'] = $this->stackbar->getJson();
            //  grafico por avaliação
           // $listaMes = $this->MateriaModelo->chartUltimosMeses();
            // tratar categorias y
            $categorias = array();
            $positivos = array();
            $negativos = array();
            $neutros = array();
//            foreach (@$listaMes as $index => $valor) {
//                array_push($categorias, abrevMes($valor['id']));
//                $contVeiculoPosi = $this->ComumModelo->countMesAvaliacao($valor['mesId'], 'P');
//                $contVeiculoNega = $this->ComumModelo->countMesAvaliacao($valor['mesId'], 'N');
//                $contVeiculoNeut = $this->ComumModelo->countMesAvaliacao($valor['mesId'], 'T');
//                array_push($positivos, $contVeiculoPosi);
//                array_push($negativos, $contVeiculoNega);
//                array_push($neutros, $contVeiculoNeut);
//
//            }
            
            $this->stackbar->load('Avaliacao - Impresso/Internet',
                array('Positivo', 'Negativo', 'Neutro'),
                $categorias,
                array(0 => $positivos,
                    1 => $negativos,
                    2 => $neutros),null,false);
            $resultado['pie_cli_mes_aval'] = $this->stackbar->getJson();
            $resultado['ind_cli'] = $this->MateriaModelo->indicadorCli($datai, $dataf);

            //drill inicio
            $resultado['veiculo_positivos'] = $this->MateriaModelo->drillAvalArea($datai, $dataf,'P');
            $resultado['veiculo_negativos'] = $this->MateriaModelo->drillAvalArea($datai, $dataf,'N');
            $resultado['veiculo_neutros'] = $this->MateriaModelo->drillAvalArea($datai, $dataf,'T');
            // drill fim

            $allTags = $this->MateriaModelo->drillListaTagsSite($datai, $dataf,NULL);
            $resultado['tags_contadas'] = $this->processaTags($allTags);
            
            /****  IMPRESSO - FIM *****/
        
        }
        if (($this->auth->CheckMenu('geral','principal','dashboard')==1) or
            ($this->auth->CheckMenu('geral','principal','dashinternet')==1) ) {
            /****  INTERNET - INICIO *****/
            $datas = $this->MateriaModelo->pieCliAval2($datai, $dataf,$grupo);
            $legendasPie2 = array();
            if (!empty($datas)) {
                // LEGENDAS
                foreach ($datas as $index => $valor) {
                    array_push($legendasPie2, utf8_encode($valor['name']));
                }
            }
            $this->piehc->load('Avaliacao - Internet', $legendasPie2, $datas);
            $resultado['pie_cli_aval2'] = $this->piehc->getJson();
            
            
            $datas = $this->MateriaModelo->pieCliOri2($datai, $dataf,$grupo);
            $legendasPie3 = array();
            if (!empty($datas)) {
                foreach ($datas as $index => $valor) {
                    array_push($legendasPie3, $valor['name']);
                }

            }
            $this->piehc->load('Origem  - Internet', $legendasPie3, $datas);
            $resultado['pie_cli_ori2'] = $this->piehc->getJson();
        
            $listaVeiculos = [];
            // grafico de barra avaliacao
            $listaVeiculos = $this->MateriaModelo->pieCliVeiculo2($datai, $dataf,$grupo);
//            print_r($listaVeiculos);
//            die();
            $resultado['pie_cli_aval_bar2T'] = (count($listaVeiculos)*50)+150;
        
            
//            // tratar categorias y
//            $categorias = array();
//            $positivos = array();
//            $negativos = array();
//            $neutros = array();
//            $totalGeral = array();
//            foreach ($listaVeiculos as $index => $valor) {
//                array_push($categorias, $valor['NOME_PORTAL']);
//                $contVeiculoPosi = $this->ComumModelo->countPortalAvaliacao($valor['SEQ_PORTAL'], 'P', $datai, $dataf,$grupo);
//                $contVeiculoNega = $this->ComumModelo->countPortalAvaliacao($valor['SEQ_PORTAL'], 'N', $datai, $dataf,$grupo);
//                $contVeiculoNeut = $this->ComumModelo->countPortalAvaliacao($valor['SEQ_PORTAL'], 'T', $datai, $dataf,$grupo);
//                $contTotal = $contVeiculoPosi + $contVeiculoNega+$contVeiculoNeut;
//                array_push($positivos, $contVeiculoPosi);
//                array_push($negativos, $contVeiculoNega);
//                array_push($neutros, $contVeiculoNeut);
//                array_push($totalGeral, $contTotal);
//
//            }
            
            $this->stackbar->load('Avaliacao por Veiculos - Internet',
                array('Positivo', 'Negativo', 'Neutro'),
                $categorias,
                array(0 => $positivos,
                    1 => $negativos,
                    2 => $neutros));
            $resultado['pie_cli_aval_bar2'] = $this->stackbar->getJson();

            $resultado['pie_cli_class_bar2T'] = (count($listaVeiculos)*50)+150;
            //  grafico demonstat. classificacao
            $espontaneo = array();
            $exclusivo = array();
            $integra = array();
            $parcial = array();
            $categorias = array();
            foreach ($listaVeiculos as $index => $valor) {
                array_push($categorias, $valor['NOME_PORTAL']);
                $contVeiculoEsp = $this->ComumModelo->countPortalClassificacao($valor['SEQ_PORTAL'], 'E', $datai, $dataf,$grupo);
                $contVeiculoExc = $this->ComumModelo->countPortalClassificacao($valor['SEQ_PORTAL'], 'X', $datai, $dataf,$grupo);
                $contVeiculoInt = $this->ComumModelo->countPortalClassificacao($valor['SEQ_PORTAL'], 'I', $datai, $dataf,$grupo);
                $contVeiculoParc = $this->ComumModelo->countPortalClassificacao($valor['SEQ_PORTAL'], 'P', $datai, $dataf,$grupo);
                array_push($espontaneo, $contVeiculoEsp);
                array_push($exclusivo, $contVeiculoExc);
                array_push($integra, $contVeiculoInt);
                array_push($parcial, $contVeiculoParc);
            }
            $this->stackbar->load('Demonstrativo por Origem e Veiculo  - Internet',
                array(utf8_encode('Demanda Espontanea'), utf8_encode('Materia Exclusiva'), utf8_encode('Release na Integra'), 'Release Parcial'),
                $categorias,
                array(0 => $espontaneo,
                    1 => $exclusivo,
                    2 => $integra,
                    3 => $parcial));
            $resultado['pie_cli_class_bar2'] = $this->stackbar->getJson();
            
            $resultado['ind_cli2'] = $this->MateriaModelo->indicadorCli2($datai, $dataf,$grupo);

            //drill inicio
            $resultado['veiculo_positivos2'] = $this->MateriaModelo->drillAvalArea2($datai, $dataf,'P',$grupo);
            $resultado['veiculo_negativos2'] = $this->MateriaModelo->drillAvalArea2($datai, $dataf,'N',$grupo);
            $resultado['veiculo_neutros2'] = $this->MateriaModelo->drillAvalArea2($datai, $dataf,'T',$grupo);
            // drill fim

            $allTags = $this->MateriaModelo->drillListaTagsSite2($datai, $dataf,$grupo);
            $resultado['tags_contadas2'] = $this->processaTags($allTags);
            // die('$$$$X'); //echo $this->db->get_compiled_select();
            
            /****  INTERNET - FIM *****/
        }
        if ((($this->auth->CheckMenu('geral','principal','dashboard')==1) or
            ($this->auth->CheckMenu('geral','principal','dashradio')==1))  ) {
            /****  RADIO - INICIO *****/
            $datas = $this->MateriaModelo->pieCliAval3($datai, $dataf);
            $legendasPie2 = array();
            if (!empty($datas)) {
                // LEGENDAS
                foreach ($datas as $index => $valor) {
                    array_push($legendasPie2, utf8_encode($valor['name']));
                }
            }
            $this->piehc->load('Avaliacao - Radio', $legendasPie2, $datas);
            $resultado['pie_cli_aval3'] = $this->piehc->getJson();
            $datas = $this->MateriaModelo->pieCliOri3($datai, $dataf);
            $legendasPie3 = array();
            if (!empty($datas)) {
                foreach ($datas as $index => $valor) {
                    array_push($legendasPie3, $valor['name']);
                }

            }
            $this->piehc->load('Origem  - Radio', $legendasPie3, $datas);
            $resultado['pie_cli_ori3'] = $this->piehc->getJson();

            // grafico de barra avaliacao
            $listaVeiculos = $this->MateriaModelo->pieCliVeiculo3($datai, $dataf);
            $resultado['pie_cli_aval_bar3T'] = (count($listaVeiculos)*50)+150;
            // tratar categorias y
            $categorias = array();
            $positivos = array();
            $negativos = array();
            $neutros = array();
            $totalGeral = array();
            foreach ($listaVeiculos as $index => $valor) {
                array_push($categorias, $valor['NOME_RADIO']);
                $contVeiculoPosi = $this->ComumModelo->countPortalAvaliacaoRadio($valor['SEQ_RADIO'], 'P', $datai, $dataf);
                $contVeiculoNega = $this->ComumModelo->countPortalAvaliacaoRadio($valor['SEQ_RADIO'], 'N', $datai, $dataf);
                $contVeiculoNeut = $this->ComumModelo->countPortalAvaliacaoRadio($valor['SEQ_RADIO'], 'T', $datai, $dataf);
                $contTotal = $contVeiculoPosi + $contVeiculoNega+$contVeiculoNeut;
                array_push($positivos, $contVeiculoPosi);
                array_push($negativos, $contVeiculoNega);
                array_push($neutros, $contVeiculoNeut);
                array_push($totalGeral, $contTotal);

            }
            $this->stackbar->load('Avaliacao por Veiculos  - Radio',
                array('Positivo', 'Negativo', 'Neutro'),
                $categorias,
                array(0 => $positivos,
                    1 => $negativos,
                    2 => $neutros));
            $resultado['pie_cli_aval_bar3'] = $this->stackbar->getJson();

            //  grafico demonstat. classificacao
            $resultado['pie_cli_class_bar3T'] = (count($listaVeiculos)*50)+150;
            $espontaneo = array();
            $exclusivo = array();
            $integra = array();
            $parcial = array();
            $categorias = array();
            foreach ($listaVeiculos as $index => $valor) {
                array_push($categorias, $valor['NOME_RADIO']);
                $contVeiculoEsp =  $this->ComumModelo->countPortalClassificacaoRadio($valor['SEQ_RADIO'], 'E', $datai, $dataf);
                $contVeiculoExc =  $this->ComumModelo->countPortalClassificacaoRadio($valor['SEQ_RADIO'], 'X', $datai, $dataf);
                $contVeiculoInt =  $this->ComumModelo->countPortalClassificacaoRadio($valor['SEQ_RADIO'], 'I', $datai, $dataf);
                $contVeiculoParc = $this->ComumModelo->countPortalClassificacaoRadio($valor['SEQ_RADIO'], 'P', $datai, $dataf);
                array_push($espontaneo, $contVeiculoEsp);
                array_push($exclusivo, $contVeiculoExc);
                array_push($integra, $contVeiculoInt);
                array_push($parcial, $contVeiculoParc);
            }

            $this->stackbar->load('Demonstrativo por Origem e Veiculo  - Radio',
                array(utf8_encode('Demanda Espontanea'), utf8_encode('Materia Exclusiva'), utf8_encode('Release na Integra'), 'Release Parcial'),
                $categorias,
                array(0 => $espontaneo,
                    1 => $exclusivo,
                    2 => $integra,
                    3 => $parcial));
            $resultado['pie_cli_class_bar3'] = $this->stackbar->getJson();

            $resultado['ind_cli3'] = $this->MateriaModelo->indicadorCli3($datai, $dataf);

            //drill inicio
            $resultado['veiculo_positivos3'] = $this->MateriaModelo->drillAvalArea3($datai, $dataf,'P');
            $resultado['veiculo_negativos3'] = $this->MateriaModelo->drillAvalArea3($datai, $dataf,'N');
            $resultado['veiculo_neutros3'] = $this->MateriaModelo->drillAvalArea3($datai, $dataf,'T');
            // drill fim

            $allTags = $this->MateriaModelo->drillListaTagsSite3($datai, $dataf,NULL);
            $resultado['tags_contadas3'] = $this->processaTags($allTags);

            /****  RADIO - FIM *****/
        }
        if ((($this->auth->CheckMenu('geral','principal','dashboard')==1) or
            ($this->auth->CheckMenu('geral','principal','dashtv')==1))  ) {
            /****  TV - INICIO *****/
            $datas = $this->MateriaModelo->pieCliAval4($datai, $dataf);

            $legendasPie2 = array();
            if (!empty($datas)) {
                // LEGENDAS
                foreach ($datas as $index => $valor) {
                    array_push($legendasPie2, utf8_encode($valor['name']));
                }
            }
            $this->piehc->load('Avaliacao - TV', $legendasPie2, $datas);
            $resultado['pie_cli_aval4'] = $this->piehc->getJson();

            $datas = $this->MateriaModelo->pieCliOri4($datai, $dataf);
            $legendasPie3 = array();
            if (!empty($datas)) {
                foreach ($datas as $index => $valor) {
                    array_push($legendasPie3, $valor['name']);
                }

            }
            $this->piehc->load('Origem  - TV', $legendasPie3, $datas);
            $resultado['pie_cli_ori4'] = $this->piehc->getJson();

            // grafico de barra avaliacao
            $listaVeiculos = $this->MateriaModelo->pieCliVeiculo4($datai, $dataf);

            $resultado['pie_cli_aval_bar4T'] = (count($listaVeiculos)*50)+150;
            // tratar categorias y
            $categorias = array();
            $positivos = array();
            $negativos = array();
            $neutros = array();
            $totalGeral = array();
            foreach ($listaVeiculos as $index => $valor) {
                array_push($categorias, $valor['NOME_TV']);
                $contVeiculoPosi = $this->ComumModelo->countPortalAvaliacaoTv($valor['SEQ_TV'], 'P', $datai, $dataf);
                $contVeiculoNega = $this->ComumModelo->countPortalAvaliacaoTv($valor['SEQ_TV'], 'N', $datai, $dataf);
                $contVeiculoNeut = $this->ComumModelo->countPortalAvaliacaoTv($valor['SEQ_TV'], 'T', $datai, $dataf);
                $contTotal = $contVeiculoPosi + $contVeiculoNega+$contVeiculoNeut;
                array_push($positivos, $contVeiculoPosi);
                array_push($negativos, $contVeiculoNega);
                array_push($neutros, $contVeiculoNeut);
                array_push($totalGeral, $contTotal);

            }
            $this->stackbar->load('Avaliacao por Veiculos  - TV',
                array('Positivo', 'Negativo', 'Neutro'),
                $categorias,
                array(0 => $positivos,
                    1 => $negativos,
                    2 => $neutros));
            $resultado['pie_cli_aval_bar4'] = $this->stackbar->getJson();

            //  grafico demonstat. classificacao
            $espontaneo = array();
            $exclusivo = array();
            $integra = array();
            $parcial = array();
            $categorias = array();
            $resultado['pie_cli_class_bar4T'] = (count($listaVeiculos)*50)+150;
            foreach ($listaVeiculos as $index => $valor) {
                array_push($categorias, $valor['NOME_TV']);
                $contVeiculoEsp = $this->ComumModelo->countPortalClassificacaoTv($valor['SEQ_TV'], 'E', $datai, $dataf);
                $contVeiculoExc = $this->ComumModelo->countPortalClassificacaoTv($valor['SEQ_TV'], 'X', $datai, $dataf);
                $contVeiculoInt = $this->ComumModelo->countPortalClassificacaoTv($valor['SEQ_TV'], 'I', $datai, $dataf);
                $contVeiculoParc = $this->ComumModelo->countPortalClassificacaoTv($valor['SEQ_TV'], 'P', $datai, $dataf);
                array_push($espontaneo, $contVeiculoEsp);
                array_push($exclusivo, $contVeiculoExc);
                array_push($integra, $contVeiculoInt);
                array_push($parcial, $contVeiculoParc);
            }
//            echo '<pre>';
//            print_r($categorias);
//            print_r($exclusivo);
//            print_r($espontaneo);
//            die();
            $this->stackbar->load('Demonstrativo por Origem e Veiculo  - TV',
                array(utf8_encode('Demanda Espontanea'), utf8_encode('Materia Exclusiva'), utf8_encode('Release na Integra'), 'Release Parcial'),
                $categorias,
                array(0 => $espontaneo,
                    1 => $exclusivo,
                    2 => $integra,
                    3 => $parcial));
            $resultado['pie_cli_class_bar4'] = $this->stackbar->getJson();

            $resultado['ind_cli4'] = $this->MateriaModelo->indicadorCli4($datai, $dataf);

            //drill inicio
            $resultado['veiculo_positivos4'] = $this->MateriaModelo->drillAvalArea4($datai, $dataf,'P');
            $resultado['veiculo_negativos4'] = $this->MateriaModelo->drillAvalArea4($datai, $dataf,'N');
            $resultado['veiculo_neutros4']   = $this->MateriaModelo->drillAvalArea4($datai, $dataf,'T');
            // drill fim

            $allTags = $this->MateriaModelo->drillListaTagsSite4($datai, $dataf,NULL);
            $resultado['tags_contadas4'] = $this->processaTags($allTags);

            /****  RADIO - FIM *****/
        }

        $this->session->set_userdata('datai',$datai);
        $this->session->set_userdata('dataf',$dataf);
        $this->session->set_userdata('grupo',$grupo);
        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
        $this->loadUrl('modulos/template/template',$resultado);

    }
    public function sempermissao(){

    $this->load->view('modulos/template/403',NULL);
    }

    public function naoencontrada(){

        $this->load->view('modulos/template/404',NULL);
    }

    public function senha()
    {
//        $this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());
        if (!empty($this->session->userdata('idUsuario'))) {
            $usuario = $this->UsuarioModelo->editarUsuario($this->session->userdata('idUsuario'));
            foreach ($usuario as $index => $valor) {
                $resultado['loginUsuario'] = $valor['LOGIN_USUARIO'];
                $resultado['nomeUsuario'] = $valor['NOME_USUARIO'];
                $resultado['idUsuario'] = $this->session->userdata('idUsuario');
            }
            if($this->session->userdata('perfilUsuario')=='ROLE_SET')
                $this->loadUrlUsuario('modulos/usuario/senhaprincipal', $resultado);
            else
                $this->loadUrl('modulos/usuario/senhaprincipal', $resultado);
        } else {
             $this->sempermissao();
        }
    }

    public function cliente()
    {
        if (!empty($this->session->userdata('idUsuario'))) {
            $clientes=null;
            if(count($clientes)==0 and $this->session->userdata('perfilUsuario')=='ROLE_ADM'){
                $clientes = $this->ComumModelo->getClienteTodos()->result_array();
            } else { //if(count($clientes)==0 and $this->session->userdata('perfilUsuario')=='ROLE_REP'){
                $clientes = $this->ComumModelo->getClientes($this->session->userdata('listaCliente'))->result_array();
            }
            $resultado['lista_cliente'] = $clientes;
			$this->loadUrl('modulos/cliente/selecao',$resultado);
        } else {
            $this->sempermissao();
        }
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

       if (isset($_SESSION['novo-sistema'])) {
            
       } else {
        $this->session->set_flashdata('flash_message', $this->ComumModelo->flash_message($class, $mensagem));
        redirect('materia');
        }
    }

    public function alterarSenha()
    {
//        $this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());
        if (!empty($this->session->userdata('idUsuario'))
            and $this->session->userdata('idUsuario')==$this->input->post('idUsuario')) {
            $idUsuario = $this->input->post('idUsuario');

            //inserir Fornecedor
            $tb_usuario = array(
                'LOGIN_USUARIO' => $this->input->post('loginUsuario'),
                'IND_ALTERAR_SENHA' => 'N',
                'SENHA_USUARIO' => $this->UsuarioModelo->hash512($this->input->post('senhaUsuario'))
            );
            $this->inserirAuditoria('ALTERAR-SENHA-USUARIO-1VEZ', 'A', json_encode($tb_usuario));

            if (!$this->UsuarioModelo->alterar($tb_usuario, $idUsuario)) {
                $class = 'error';
                $mensagem = 'Senha do Usuario Não Alterado!';
            } else {
                $data= array('alteraSenha'=>'N');
                $this->session->set_userdata($data);
                $class = 'success';
                $mensagem = 'Senha do Usuario Alterado com sucesso!!';
            }
            if ('ROLE_ADM' == $this->session->userData('perfilUsuario')) {
                $retorno = 'usuario';
            } else {
                $retorno = 'inicio';
            }

            $this->session->set_flashdata('flash_message', $this->ComumModelo->flash_message($class, $mensagem));
            redirect($retorno);
        } else{
            $this->sempermissao();
        }
    }

    public function notificacao($id){

            $listaNotificacao = $this->NotificacaoModelo->getNotificacaoUsuario($id);
            $count =count($listaNotificacao);
        foreach ($listaNotificacao as $index => $valor){
            $dataAlt = array(
                'FLAG_NOTIFICACAO' => $valor['SEQ_NOTIFICACAO']+1
            );
            $this->NotificacaoModelo->alterar($dataAlt,$valor['SEQ_NOTIFICACAO']);
        };
        $arrData = array(
            'count' => $count
        );
        $json = json_encode($arrData);
        echo $json;

    }
    private function processaTags($tags){
        $resultado = array();
        $arrayGeral = array();

        // tranforma tags em array;
        foreach ($tags as $index => $valor){
            $arrayExp = explode(',',$valor['TAG']);
            $arrayTratado = array();
            foreach ($arrayExp as $item){
                array_push($arrayTratado,trim($item));

            }
            $arrayGeral = array_merge($arrayGeral,$arrayTratado);
        };
        // gerar contador de cada item
        $resultado= array_count_values($arrayGeral);
        arsort($resultado);
        return $resultado;

    }
    public function pdfTag($tipo){

        $this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());

        $this->load->model('materiaModelo', 'MateriaModelo');

        $datai=$this->session->userdata('datai');
        $dataf=$this->session->userdata('dataf');
        $grupo=$this->session->userdata('grupo');
        $titulo = '';
        if ($tipo=='I') {
            $allTags = $this->MateriaModelo->drillListaTagsSite($datai, $dataf,NULL);
            $resultado['tags_contadas'] = $this->processaTags($allTags);
            $titulo = 'IMPRESSO';
        } else if ($tipo=='S') {
            $allTags = $this->MateriaModelo->drillListaTagsSite2($datai, $dataf,$grupo);
            $resultado['tags_contadas'] = $this->processaTags($allTags);
            $titulo = 'INTERNET';
        }else if($tipo='R') {
            $allTags = $this->MateriaModelo->drillListaTagsSite3($datai, $dataf,NULL);
            $resultado['tags_contadas'] = $this->processaTags($allTags);
            $titulo = 'RADIO';
        }else if($tipo='T') {
            $allTags = $this->MateriaModelo->drillListaTagsSite4($datai, $dataf,NULL);
            $resultado['tags_contadas'] = $this->processaTags($allTags);
            $titulo = 'TV';
        }
        $resultado['titulo']=$titulo;
        $resultado['datai']=$datai;
        $resultado['dataf']=$dataf;

//        $this->load->view('modulos/template/arquivo-tag', $resultado);

        $this->load->library('pdf');
        $html = $this->load->view('modulos/template/arquivo-tag', $resultado, true);
        $pdf = $this->pdf->load();
//        $html = utf8_encode($html);
//        $pdf->AddPage('L');
        $pdf->WriteHTML($html);
        $pdf->Output('tags_'.strtolower($titulo).'_'.date('dmY').'.pdf', 'D');

    }
    public function perfil()
    {
        $this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());
        if (!empty($this->session->userdata('idUsuario'))) {
            $usuario = $this->UsuarioModelo->editarUsuario($this->session->userdata('idUsuario'));
            foreach ($usuario as $index => $valor){
                $resultado['loginUsuario'] =$valor['LOGIN_USUARIO'];
                $resultado['perfilUsuario'] = $valor['PERFIL_USUARIO'];
                $resultado['emailUsuario'] =$valor['EMAIL_USUARIO'];
                $resultado['cpfUsuario'] = $valor['CPF_USUARIO'];
                $resultado['nomeUsuario'] = $valor['NOME_USUARIO'];
                $resultado['foneUsuario'] = $valor['FONE_USUARIO'];
                $resultado['idUsuario'] = $this->session->userdata('idUsuario');
                $resultado['avatar'] = $valor['IMAGEM_USUARIO'];
                $resultado['logradouro'] = $valor['LOGRADOURO_USUARIO'];
                $resultado['bairro'] = $valor['BAIRRO_USUARIO'];
                $resultado['numero'] = $valor['NUMERO_USUARIO'];
                $resultado['complemento'] = $valor['COMPLEMENTO_USUARIO'];
                $resultado['cep'] = $valor['CEP_USUARIO'];
                $resultado['cidade'] = $valor['CIDADE_USUARIO'];
                $resultado['uf'] = $valor['UF_USUARIO'];
                $resultado['latitude'] = $valor['LAT_USUARIO'];
                $resultado['longitude'] = $valor['LONG_USUARIO'];
                $resultado['pais'] = $valor['PAIS_USUARIO'];
                $resultado['cliente'] = $valor['SEQ_CLIENTE'];

            }
            $resultado['lista_cliente'] = $this->ClienteModelo->listaCliente();
            $this->loadUrl('modulos/usuario/profile',$resultado);
        } else {
            $this->sempermissao();
        }
    }
    public function alterarPerfil()
    {
        $this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());
        $idUsuario = $this->input->post('idUsuario');

        $dataUsuarioAtual = $this->UsuarioModelo->getUsuario($idUsuario)->row();
        extract($this->input->post());

        $data = array(
            'EMAIL_USUARIO'=>$emailUsuario,
            'NOME_USUARIO'=>$nomeUsuario,
            'FONE_USUARIO'=>$foneUsuario,
            'LOGRADOURO_USUARIO'=>$logradouro,
            'BAIRRO_USUARIO'=>$bairro,
            'NUMERO_USUARIO'=>$numero,
            'COMPLEMENTO_USUARIO'=>$complemento,
            'CEP_USUARIO'=>$cep,
            'CIDADE_USUARIO'=>$cidade,
            'UF_USUARIO'=>$uf,
            'LAT_USUARIO'=>$latitude,
            'LONG_USUARIO'=>$longitude,
            'PAIS_USUARIO'=>$pais
        );

        if (!empty($this->input->post('imagem64'))){
            $data = array_merge($data, array('IMAGEM_USUARIO'=>$this->input->post('imagem64')));
        }

        $this->inserirAuditoria('ALTERAR-USUARIO-PERFIL','A',json_encode($data));

        if (!$this->UsuarioModelo->alterar($data, $idUsuario))
        {
            $class = 'error';
            $mensagem = 'Perfil Não Alterado!';
        }
        else
        {
            $class = 'success';
            $mensagem = 'Perfil Alterado com sucesso!!';
        }
        $this->session->set_flashdata('flash_message', $this->ComumModelo->flash_message($class, $mensagem));
        redirect('principal/perfil');
    }

    function cmpressbkpmat()
    {
        set_time_limit(0);
        $source_path= APPPATH_MATERIA;
        // Normaliza o caminho do diretório a ser compactado
        $timeseq = date('dmYHis');
        $source_path = realpath($source_path);

        // Caminho com nome completo do arquivo compactado
        // Nesse exemplo, será criado no mesmo diretório de onde está executando o script
        $zip_file = APPPATH.'/third_party/' . basename($source_path) .$timeseq.'.zip';

        // Inicializa o objeto ZipArchive
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Iterador de diretório recursivo
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source_path),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Pula os diretórios. O motivo é que serão inclusos automaticamente
            if (!$file->isDir()) {
                // Obtém o caminho normalizado da iteração corrente
                $file_path = $file->getRealPath();

                // Obtém o caminho relativo do mesmo.
                $relative_path = substr($file_path, strlen($source_path) + 1);

                // Adiciona-o ao objeto para compressão
                $zip->addFile($file_path, $relative_path);
            }
        }

        // Fecha o objeto. Necessário para gerar o arquivo zip final.
        $zip->close();

        // Retorna o caminho completo do arquivo gerado
        echo  $zip_file;
    }

// O diretório a ser compactado
//$source_path = '/folder/folder/';
//echo Compress($source_path);
}
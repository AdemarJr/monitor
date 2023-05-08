<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);
class Publico extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
    
    private function seleciona($id)
    {
        $this->inserirAuditoria('SETA-CLIENTE-SESSAO','A','ClienteId: '.$id);
        try
        {
            $data= array('idClienteSessao'=>'','temaClienteSessao'=>'');
            $this->session->unset_userdata($data);

            $clienteTema = $this->ComumModelo->getTableData('CLIENTE', array('SEQ_CLIENTE' => $id))->row()->TEMA_CLIENTE;

            $data= array('idClienteSessao'=>$id,'eSelecao'=>true,'temaClienteSessao'=>$clienteTema);

            $this->session->set_userdata($data);
        }catch (Exception $e) {
            $class = 'error';
            $mensagem = 'Cliente Não pode ser Selecionado!';
            die();
        }
    }
    public function redireciona() {
//        $this->session->sess_destroy();
//        die();
        $chave = $this->uri->segment(2);
        $idUsusario = $this->uri->segment(3);
        if (!empty($chave)) {
            if (!empty($idUsusario)) {
                // FAZ O LOGIN
                $this->db->where('SEQ_USUARIO', $idUsusario);
                $query = $this->db->get('USUARIO')->row_array();
                $permissoes = $this->ComumModelo->getUserPermission($query['SEQ_USUARIO'])->result_array();
                $data = array(
                        'idUsuario' =>$query['SEQ_USUARIO'],
                        'loginUsuario' =>$query['LOGIN_USUARIO'],
                        'nomeUsuario' =>$query['NOME_USUARIO'],
                        'emailUsuario' => $query['EMAIL_USUARIO'],
                        'perfilUsuario' => $query['PERFIL_USUARIO'],
                        'alteraSenha' => $query['IND_ALTERAR_SENHA'],
                        'setorUsuario' => $query['SEQ_SETOR'],
                        'listaCliente'=> $query['SEQ_CLIENTE'],
                        'listaTipo'=>$query['TIPO_MATERIA'],
                        'logado' => true,
                        'dominio'=> 'monitor',
                        'permissoes'=>$permissoes,
                        'acesso' => 'externo'
                    );
                                
                $this->session->set_userdata($data);
                $this->inserirAuditoria('LOGIN-SISTEMA','A','Autorizado',$query['SEQ_USUARIO']);
            } 
            $urlRedicionar = 'http://clippingeleicoes.com.br/i?' . $chave;
            header('Location: ' . $urlRedicionar);
        }
    }

    private function inserirAuditoria($operacao=NULL,$tipo=NULL, $obs=NULL,$usuario=NULL)
    {
        $tb_auditoria = array(
            'SEQ_USUARIO' => $usuario,
            'TIPO_AUDITORIA' => $tipo,
            'OPER_AUDITORIA' => $operacao,
            'OBS_AUDITORIA' => $obs,
            'SESSION_ID'=>session_id()
        );
        $this->AuditoriaModelo->inserir($tb_auditoria);
    }
    
    public function word() {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addText(
                '"Learn from yesterday, live for today, hope for tomorrow. '
                . 'The important thing is not to stop questioning." '
                . '(Albert Einstein)'
        );
        
        $filename = 'nameOfFile.docx';
        $arquivo  = FCPATH.'lixo/'.$filename;
        $phpWord->save($arquivo);
        $this->load->helper('download');
        $dataBinary = file_get_contents($arquivo);
        force_download(basename($arquivo), $dataBinary, TRUE);
        sleep(2);
        unlink($arquivo);
    }

    public function index() {
        $this->load->view('modulos/template/403');
    }
    public function exibir($idCliente=NULL) {
        $this->load->model('materiaModelo', 'MateriaModelo');
        $this->session->set_userdata('idClienteSessaoAlerta',$idCliente);

        // lista inicial anual
        $resultado['lista_radio']=$this->MateriaModelo->dashInicio('R',$idCliente);
        $resultado['lista_site']=$this->MateriaModelo->dashInicio('S',$idCliente);
        $resultado['lista_impresso']=$this->MateriaModelo->dashInicio('I',$idCliente);

        $templateId = 0;
        if (!empty($resultado['lista_radio']) and count($resultado['lista_radio'])>0) $templateId++;
        if (!empty($resultado['lista_site']) and count($resultado['lista_site'])>0) $templateId++;
        if (!empty($resultado['lista_impresso']) and count($resultado['lista_impresso'])>0) $templateId++;

        $this->load->view('modulos/template/cabecalho_dashboard',NULL);
		$this->load->view('modulos/publico/tela-inicial-'.$templateId,$resultado);
		$this->load->view('modulos/template/rodape_dashboard');
    }

    public function detalhar($urlBack=NULL) {
        extract($this->input->post());
        $this->load->model('materiaModelo', 'MateriaModelo');
        if (empty($this->session->userdata('idClienteSessaoAlerta')) ) {
            $this->load->view('modulos/template/404');
            return;
        }
        if(!empty($tipo))
            $this->session->set_userdata('tipoSessao',$tipo);
        if(!empty($ano))
            $this->session->set_userdata('anoSessao',$ano);
        if(!empty($anteNivel))
            $this->session->set_userdata('anteNivelSessao',$anteNivel);
        if(!empty($proxNivel))
            $this->session->set_userdata('proxNivelSessao',$proxNivel);
        if(!empty($mes))
            $this->session->set_userdata('mesSessao',$mes);

        // lista inicial anual
        if (!empty($urlBack)){
            $this->session->set_userdata('proxNivelSessao','mensal');
            $this->session->set_userdata('anteNivelSessao','anual');
        }

        if( (!empty($urlBack) and $urlBack=='mensal') or $this->session->userdata('proxNivelSessao')=='mensal') {
            $resultado['lista_meses'] = $this->MateriaModelo->dashMensal(
                $this->session->userdata('tipoSessao'),
                $this->session->userdata('anoSessao'),
                $this->session->userdata('idClienteSessaoAlerta'));
        } else if($this->session->userdata('proxNivelSessao')=='diario') {
            $resultado['lista_dias'] = $this->MateriaModelo->dashDiario(
                $this->session->userdata('tipoSessao'),
                $this->session->userdata('anoSessao'),
                $this->session->userdata('mesSessao'),
                $this->session->userdata('idClienteSessaoAlerta'));
        } else {
            $this->load->view('modulos/template/404');
            return;
        }

        $this->load->view('modulos/template/cabecalho_dashboard');
        $this->load->view('modulos/publico/tela-'.$this->session->userdata('proxNivelSessao') , $resultado);
        $this->load->view('modulos/template/rodape_dashboard');
    }
    public function ajaxViewer($idMateria)
    {
        $this->load->model('materiaModelo', 'MateriaModelo');
        $this->inserirAuditoria('VISUALIZAR-MATERIA-PUBLIC','A','idMateria:'.$idMateria);
        $listaItem = $this->MateriaModelo->getMateria($idMateria)->row();
        $resultado['cliente'] = $listaItem->SEQ_CLIENTE;
        $resultado['titulo'] = $listaItem->TIT_MATERIA;
        $resultado['dataPub'] = $listaItem->DATA_MATERIA_PUB;
        $resultado['palavras'] = $listaItem->PC_MATERIA;
        $resultado['veiculo'] = $listaItem->SEQ_VEICULO;
        $resultado['portal'] = $listaItem->SEQ_PORTAL;
        $resultado['radio'] = $listaItem->SEQ_RADIO;
        $resultado['link'] = $listaItem->LINK_MATERIA;
        $resultado['pagina'] = $listaItem->PAGINA_MATERIA;
        $resultado['editoria'] = $listaItem->EDITORIA_MATERIA;
        $resultado['classificacao'] = $listaItem->IND_CLASSIFICACAO;
        $resultado['avaliacao'] = $listaItem->IND_AVALIACAO;
        $resultado['setor'] = $listaItem->SEQ_SETOR;
        $resultado['destaque'] = $listaItem->DESTAQUE_MATERIA;
        $resultado['idMateria'] = $idMateria;
        $resultado['tipoMateria'] = $listaItem->TIPO_MATERIA;
        $resultado['programa'] = $listaItem->PROGRAMA_MATERIA;
        $resultado['apresentador'] = $listaItem->APRESENTADOR_MATERIA;
        $this->load->view('modulos/publico/materia-view', $resultado);

    }
    public function imagem($id){
        $this->load->model('materiaModelo', 'MateriaModelo');
        $anexo = $this->MateriaModelo->getAnexo($id)->row();

        $arquivo = APPPATH_MATERIA.$anexo->SEQ_MATERIA.'/'.$anexo->NOME_BIN_ARQUIVO;

        header("Content-type: ".$anexo->CONTT_ARQUIVO);
        readfile ($arquivo);

    }
    private function check_transparent($im) {
        $width = imagesx($im);
        $height = imagesy($im);

        for($i = 0; $i < $width; $i++) {
            for($j = 0; $j < $height; $j++) {
                $rgba = imagecolorat($im, $i, $j);
                if(($rgba & 0x7F000000) >> 24) {
                    return true;
                }
            }
        }
        return false;
    }

    private function compress_image($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg'){
            $image = imagecreatefromjpeg($source_url);
        }elseif($info['mime'] == 'image/gif'){
            $image = imagecreatefromgif($source_url);
            if($this->check_transparent($image)) {
                return $source_url;
            }
        }elseif ($info['mime'] == 'image/png'){
            $image = imagecreatefrompng($source_url);
            if($this->check_transparent($image)) {
                return $source_url;
            }
        }
        imagejpeg($image, $destination_url, $quality);
        return $destination_url;
    }
    public function imagem2($res='N',$idMat,$nome){
//        $this->load->model('materiaModelo', 'MateriaModelo');
//        $anexo = $this->MateriaModelo->getAnexo($id)->row();

        $arquivo = APPPATH_MATERIA.$idMat.'/'.$nome;
        $download = $arquivo;
        if($res!='N') {
            $ex = pathinfo($download, PATHINFO_EXTENSION); //end(explode('.', ));
            if ($ex == 'jpeg' ||  $ex == 'jpg' || $ex == 'gif' || $ex == 'png') {
                $download = $this->compress_image($arquivo, sys_get_temp_dir() . '/' . $nome, 70);
            }
        }
        // echo $download;

        // echo '<br/>existe-> '.file_exists($download);
         
        // die;
        header("Content-type: ".mime_content_type($download));
        readfile ($download);

    }
    public function audio($id)
    {
        $this->load->model('materiaModelo', 'MateriaModelo');
        $anexo = $this->MateriaModelo->getAnexo($id)->row();

        $arquivo = APPPATH_MATERIA . $anexo->SEQ_MATERIA . '/' . $anexo->NOME_BIN_ARQUIVO;

        $videoStream = $this->stream->load($arquivo);

        $videoStream->start();

    }
    public function audiodown($id)
    {
        $this->load->model('materiaModelo', 'MateriaModelo');
        $anexo = $this->MateriaModelo->getAnexo($id)->row();
        $this->load->helper('download');

        $arquivo = APPPATH_MATERIA . $anexo->SEQ_MATERIA . '/' . $anexo->NOME_BIN_ARQUIVO;

        $filename = $anexo->NOME_ARQUIVO;

        $dataBinary = file_get_contents($arquivo);

        force_download($filename, $dataBinary, TRUE);


    }
    
    public function consultarteste($chave=NULL) {
//        echo '<pre>';
//        print_r($_SESSION);
//        die();
        header('Content-type: text/html; charset=utf-8');

        header('Surrogate-Control: BigPipe/1.0');

        header("Cache-Control: no-cache, must-revalidate");

        header('X-Accel-Buffering: no');

        $perPage = 10000;
        if (empty($chave)){
            $this->load->view('modulos/template/404');
            return;
        }
        
        $dadosNota = $this->ComumModelo->getTableData('NOTA',array('CHAVE_NOTIFICACAO'=>$chave))->row();
        
        $idCliente = $dadosNota->SEQ_CLIENTE;
        $flagModelo = $dadosNota->IND_MODELO;
        $flagTema = $dadosNota->TIPO_NOTA;

            $this->session->set_userdata('idClienteSessaoAlerta',$idCliente);

        $header['chave'] =$chave;
        $this->load->model('materiaModelo', 'MateriaModelo');
        $this->db->where('CHAVE_NOTIFICACAO', $chave);
        $nn = $this->db->get('NOTA')->row_array();
        //$header['total'] =  count($this->MateriaModelo->getConsulta($chave));
        $header['total'] = $nn['QTD_MATERIA'];
        
        // altera qtd do periodo
        $this->MateriaModelo->alteraNota($chave,array('QTD_MATERIA'=>$header['total']));

        $resultado['flagModelo']=$flagModelo;

        $resultado['flagTema']=$flagTema;
        $resultado['chaveNota']=$chave;
        $resultado['flagEleicao']=($idCliente==59 
                    or $idCliente==60 
                    or $idCliente==61
                    or $idCliente==62
                    or $idCliente==63
                    or $idCliente==64
                    )? true:false;


        if(!empty($this->input->get("page"))){

            $start = ceil($this->input->get("page") * $perPage);

            $resultado['lista_dias'] = $this->MateriaModelo->getConsulta($chave,$perPage,$start);
            
            if(count($resultado['lista_dias'])>0)
                $this->load->view('modulos/publico/tela-lista-page' , $resultado);
            else
                echo 'stop';
        } else{
//            echo '<pre>';
//            print_r($_SESSION);
//            die();
            if ($_SERVER['SERVER_NAME'] != 'porto.am') {
                
            }
            //print_r($_SERVER['SERVER_NAME']);
            //die();
            $resultado['lista_dias'] = $this->MateriaModelo->getConsulta($chave,$perPage);
             
            // MANDA O CLIENTE
            $resultado['logado'] = $_SESSION['perfilUsuario'];
            if ($idCliente !== '12') {
               
            $this->load->view('modulos/template/cabecalho_dashboard',$header);
            $this->load->view('modulos/publico/tela-lista' , $resultado);
            $this->load->view('modulos/template/rodape_dashboard');
            } else {
            $this->load->view('modulos/clipping/cabecalho_dashboard',$header);
            $this->load->view('modulos/clipping/tela-lista' , $resultado);
            $this->load->view('modulos/clipping/rodape_dashboard');    
            }
        }
    }
    
    public function consultar($chave=NULL) {
//        echo '<pre>';
//        print_r($_SESSION);
//        die();
        header('Content-type: text/html; charset=utf-8');

        header('Surrogate-Control: BigPipe/1.0');

        header("Cache-Control: no-cache, must-revalidate");

        header('X-Accel-Buffering: no');

        $perPage = 10000;
        if (empty($chave)){
            $this->load->view('modulos/template/404');
            return;
        }

        $dadosNota = $this->ComumModelo->getTableData('NOTA',array('CHAVE_NOTIFICACAO'=>$chave))->row();
        
        $idCliente = $dadosNota->SEQ_CLIENTE;
        $flagModelo = $dadosNota->IND_MODELO;
        $flagTema = $dadosNota->TIPO_NOTA;

            $this->session->set_userdata('idClienteSessaoAlerta',$idCliente);

        $header['chave'] =$chave;
        $this->load->model('materiaModelo', 'MateriaModelo');
        $header['total'] =  count($this->MateriaModelo->getConsulta($chave));

        // altera qtd do periodo
        $this->MateriaModelo->alteraNota($chave,array('QTD_MATERIA'=>$header['total']));

        $resultado['flagModelo']=$flagModelo;

        $resultado['flagTema']=$flagTema;
        $resultado['chaveNota']=$chave;
        $resultado['flagEleicao']=($idCliente==59 
                    or $idCliente==60 
                    or $idCliente==61
                    or $idCliente==62
                    or $idCliente==63
                    or $idCliente==64
                    )? true:false;


        if(!empty($this->input->get("page"))){

            $start = ceil($this->input->get("page") * $perPage);

            $resultado['lista_dias'] = $this->MateriaModelo->getConsulta($chave,$perPage,$start);
            if(count($resultado['lista_dias'])>0)
                $this->load->view('modulos/publico/tela-lista-page' , $resultado);
            else
                echo 'stop';
        } else{
//            echo '<pre>';
//            print_r($_SESSION);
//            die();
            if ($_SERVER['SERVER_NAME'] != 'porto.am') {
                
            }
            //print_r($_SERVER['SERVER_NAME']);
            //die();
            $resultado['lista_dias'] = $this->MateriaModelo->getConsulta($chave,$perPage);
            // MANDA O CLIENTE
            $resultado['logado'] = $_SESSION['perfilUsuario'];
            if ($idCliente !== '12') {
            $this->load->view('modulos/template/cabecalho_dashboard',$header);
            $this->load->view('modulos/publico/tela-lista' , $resultado);
            $this->load->view('modulos/template/rodape_dashboard');
            } else {
            $this->load->view('modulos/clipping/cabecalho_dashboard',$header);
            $this->load->view('modulos/clipping/tela-lista' , $resultado);
            $this->load->view('modulos/clipping/rodape_dashboard');    
            }
        }
    }
    public function consultarMateria($chave=NULL) {
        if (empty($chave)){
            $this->load->view('modulos/template/404');
            return;
        }

        $this->load->model('materiaModelo', 'MateriaModelo');
        
        $resultadoConsulta = $this->MateriaModelo->getConsultaSingle($chave);
        //die('AQUI 2');
        $resultadoConsultaRow = $resultadoConsulta->row();

        $header['materia'] = $resultadoConsultaRow;

        $resultado['idCliente'] = $resultadoConsultaRow->SEQ_CLIENTE;

        $resultado['lista_dias'] = $resultadoConsulta->result_array();

            $this->load->view('modulos/template/cabecalho_dashboard_simples',$header);
            $this->load->view('modulos/publico/tela-single' , $resultado);
            $this->load->view('modulos/template/rodape_dashboard');
    }
    public function ajaxConteudo($idMateria=NULL) {

        $this->load->model('materiaModelo', 'MateriaModelo');

        $resultadoConsulta = $this->MateriaModelo->getConsultaSingle(NULL,$idMateria);

//        $resultadoConsultaRow = $resultadoConsulta->row();

//        $header['materia'] = $resultadoConsultaRow;

//        $resultado['idCliente'] = $resultadoConsultaRow->SEQ_CLIENTE;

        $resultado['lista_dias'] = $resultadoConsulta->result_array();

        $this->load->view('modulos/publico/conteudo-card' , $resultado);
    }

    public function consultarMateriaTI($chave=NULL) {
        if (empty($chave)){
            $this->load->view('modulos/template/404');
            return;
        }

        $this->load->model('materiaModelo', 'MateriaModelo');

        $resultadoConsulta = $this->MateriaModelo->getConsultaSingle($chave);

        $resultadoConsultaRow = $resultadoConsulta->row();

        $header['materia'] = $resultadoConsultaRow;

        $resultado['idCliente'] = $resultadoConsultaRow->SEQ_CLIENTE;

        $resultado['lista_dias'] = $resultadoConsulta->result_array();

        $this->load->view('modulos/template/cabecalho_dashboard_simples-ti',$header);
        $this->load->view('modulos/publico/tela-single-ti' , $resultado);
        $this->load->view('modulos/template/rodape_dashboard');
    }
    public function gerarChave($tamanho=1)
    {
        for ($i=1; $i<=$tamanho;$i++) {
            echo $this->uniqid_base36().'<br/>';
        }
    }
    private function uniqid_base36($more_entropy=false) {
        $s = uniqid('', $more_entropy);
        if (!$more_entropy)
            return base_convert($s, 16, 36);

        $hex = substr($s, 0, 13);
        $dec = $s[13] . substr($s, 15); // skip the dot
        return base_convert($hex, 16, 36) . base_convert($dec, 10, 36);
    }
//teste ocultar depois
    public function getConteudo() {
        $url='http://portaldoholanda.com.br/brasil/fhc-alckmin-arthur-tasso-e-perillo-reconhecem-previas-tucanas-presidencia';
        $html = $this->curl_get($url);
        echo $this->portalHolanda($html);
    }

    private function portalHolanda($htmlResp)
    {
        $html  =  $this->dom_parser->str_get_html($htmlResp);
        $result = array();
//        foreach ($html->find('div.post_main_container') as $item) {
//            $result .= $item->plaintext;
//        }
//        if($result=='') {
        $element = $html->find('div[id=mvp-content-main]');

        echo count($element);
        die;
            foreach ($html->find('div[id=mvp-content-main]') as $item) {
               $result .= $item->plaintext;

            }
//        }
        print_r($result);

     //   return html_entity_decode(str_replace('&nbsp;','',$result));
    }

    public function g1Portal() {

        $html = $this->curl_get('https://www.portaldogeneroso.com/single-post/2017/10/02/INSCRI%C3%87%C3%95ES-PARA-CURSOS-NA-SEMTRAD-ENCERRA-EM-TEMPO-RECORDE');

        echo $html;
        die;
        $htmlObj  =  $this->dom_parser->str_get_html($html);
        $result = '';
        foreach ($htmlObj->find('p.font_8') as $item) {
//            foreach ($item->find('p') as $parte) {
                $result .= '<p>' . $item->plaintext . '</p>';
//            }
        }
        echo $result;
    }

    function curl_get($url, array $options = array())
    {
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 20
        );
//        $defaults = array(
//            CURLOPT_URL => $url,
//            CURLOPT_HEADER => 0,
//            CURLOPT_RETURNTRANSFER => TRUE,
//            CURLOPT_POST=>FALSE,
//            CURLOPT_POSTFIELDS =>'',
//            CURLOPT_TIMEOUT => 20
//        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));

        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function tz(){
        $this->load->helper('date');

        echo 'Manaus: '.now('America/Manaus');
        echo '<br/>SAo Paulo: '.now('America/Sao_Paulo');

        echo '<br/> tz: '.timezones('UM4');

        echo '<br/> tz: '.date('', now('America/Manaus'));
    }

//    public function teste(){
//
//        $diretorioOrigem = APPPATH . "/third_party/video/";
//        $diretorioDestino = APPPATH . "/third_party/video2/";
//
//        $types = array( 'mp4' );
//        if ( $handle = opendir($diretorioOrigem) ) {
//            while ( $entry = readdir( $handle ) ) {
//                $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
//                $novonome = uniqid();
//                if( in_array( $ext, $types ) ) {
//                    echo '<br>' . $entry;
//                    echo '<br>Origem: ' . $diretorioOrigem . $entry;
//                    echo '<br>Destino: ' . $diretorioDestino . $novonome . '.' . $ext;
//                    if (copy($diretorioOrigem . $entry, $diretorioDestino . $novonome . '.' . $ext) && unlink($diretorioOrigem . $entry))
//                        echo '<br>deletado: ' . $entry;
//                    else echo '<br>nao deletado: ' . $entry;
//                }
//            }
//            closedir($handle);
//        }
//
//    }

    public function d8c662705325f378e8472527697ba907(){

        set_time_limit(0);
        $this->load->model('materiaModelo', 'MateriaModelo');
//        echo xmlrpc_encode($this->MateriaModelo->pivotando());

        $this->load->library('table');
        $this->table->set_heading('Cliente', 'Tipo Materia', '&Oacute;rg&atilde;o','Avalia&ccedil;&atilde;o','Ve&iacute;culo','Ano','M&ecirc;s','Dia', 'Quantidade');
//        $this->table->function = 'htmlspecialchars';

       // header('Content-type: text/html; charset=windows-1252');

        $html = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">'
                .'<head>'
                .'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
                .'</head>'
                .'<body>'.$this->table->generate($this->MateriaModelo->pivotando(2017))
                .'</body>'
                .'</html>';

        echo $html;

    //    echo json_encode($this->MateriaModelo->pivotando());
    }
    public function d8c662705325f378e8472527697ba9072(){

        set_time_limit(0);
        $this->load->model('materiaModelo', 'MateriaModelo');
//        echo xmlrpc_encode($this->MateriaModelo->pivotando());

        $this->load->library('table');
        $this->table->set_heading('Cliente', 'Tipo Materia', '&Oacute;rg&atilde;o','Avalia&ccedil;&atilde;o','Ve&iacute;culo','Ano','M&ecirc;s','Dia', 'Quantidade');
//        $this->table->function = 'htmlspecialchars';

        // header('Content-type: text/html; charset=windows-1252');

        $html = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">'
            .'<head>'
            .'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
            .'</head>'
            .'<body>'.$this->table->generate($this->MateriaModelo->pivotando(2018))
            .'</body>'
            .'</html>';

        echo $html;

        //    echo json_encode($this->MateriaModelo->pivotando());
    }
    public function d8c662705325f378e8472527697ba9073(){

        set_time_limit(0);
        $this->load->model('materiaModelo', 'MateriaModelo');
//        echo xmlrpc_encode($this->MateriaModelo->pivotando());

        $this->load->library('table');
        $this->table->set_heading('Cliente', 'Tipo Materia', '&Oacute;rg&atilde;o','Avalia&ccedil;&atilde;o','Ve&iacute;culo','Ano','M&ecirc;s','Dia', 'Quantidade');
//        $this->table->function = 'htmlspecialchars';

        // header('Content-type: text/html; charset=windows-1252');

        $html = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">'
            .'<head>'
            .'<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'
            .'</head>'
            .'<body>'.$this->table->generate($this->MateriaModelo->pivotando(2019))
            .'</body>'
            .'</html>';

        echo $html;

        //    echo json_encode($this->MateriaModelo->pivotando());
    }

    public function fotos($folder)
    {

        $this->session->set_userdata('idClienteSessaoAlerta', 4);

        $diretorioOrigem = FCPATH . "assets/albuns/".$folder;
        $resultado =array();
        $types = array( 'jpeg','jpg','png','mp4' );
        if ( $handle = opendir($diretorioOrigem) ) {
            while ( $entry = readdir( $handle ) ) {
                $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
                if( in_array( $ext, $types ) ) {
                    array_push($resultado,$entry);
                }
            }
            closedir($handle);
        }
        $resultado_ds['folder']=$folder;
        $resultado_ds['lista_video']= $resultado;
        $ini_array =NULL;

        if (file_exists($diretorioOrigem.'/album.ini'))
            $ini_array = parse_ini_file($diretorioOrigem.'/album.ini');

        $header['titulo'] = !empty($ini_array['titulo'])?$ini_array['titulo']: NULL;
        $resultado_ds['subtitulo'] = !empty($ini_array['subtitulo'])?$ini_array['subtitulo']: NULL;
        $header['url_logo'] = !empty($ini_array['url_logo'])?$ini_array['url_logo']: NULL;


        $this->load->view('modulos/template/cabecalho_dashboard_evento', $header);
        $this->load->view('modulos/publico/tela-fotos', $resultado_ds);
        $this->load->view('modulos/template/rodape_dashboard');
    }

  /*  public function processaantigo($datafim){
        set_time_limit(0);
        $contador = 0;
        $contadorBD = 0;
        $contadorMT = 0;
        $contadorSP = 0;
        $this->load->model('materiaModelo', 'MateriaModelo');
        $lista_materias = $this->MateriaModelo->listaMateriaDeleteAnexo($datafim);
        foreach ($lista_materias as $index => $materia) {
            $contadorMT++;
            $lista_anexo = $this->MateriaModelo->listaAnexo($materia['SEQ_MATERIA']);
            foreach ($lista_anexo as $index2 => $anexo) {
                $arquivo = APPPATH_MATERIA . $anexo['SEQ_MATERIA'] . '/' . $anexo['NOME_BIN_ARQUIVO'];
                // if ($this->MateriaModelo->deletarAnexoBySeq($anexo['SEQ_ANEXO'])) {
                $contadorBD++;
                if (file_exists($arquivo)) {
                    //   $this->copyr(APPPATH . "/third_party/materia/" . $anexo['SEQ_MATERIA'],'/root/materia');
                        unlink($arquivo);
//                    echo $materia['SEQ_MATERIA'].' - '.$materia['DATA_MATERIA_PUB'].'<br/>';
//                    $contadorSP+= filesize ($arquivo);
                    $contador++;
                }
                // }

            }
        }
        echo 'Total Mat-> '.$contadorMT;
        echo '<br/>Total BD-> '.$contadorBD;
        echo '<br/>Total SP-> '.$contadorSP;
        echo '<br/>Total Del-> '.$contador;
    }*/
   /* public function processaantigo($datafim){
        set_time_limit(0);
        $contador = 0;
        $contadorBD = 0;
        $contadorMT = 0;
        $this->load->model('materiaModelo', 'MateriaModelo');
        $lista_materias = $this->MateriaModelo->listaMateriaDeleteAnexo($datafim);
        foreach ($lista_materias as $index => $materia) {
            $contadorMT++;
            $lista_anexo = $this->MateriaModelo->listaAnexo($materia['SEQ_MATERIA']);
            foreach ($lista_anexo as $index2 => $anexo) {
                $arquivo = APPPATH . "/third_party/materia/" . $anexo['SEQ_MATERIA'] . '/' . $anexo['NOME_BIN_ARQUIVO'];
               // if ($this->MateriaModelo->deletarAnexoBySeq($anexo['SEQ_ANEXO'])) {
                    $contadorBD++;
                    if (file_exists($arquivo)) {
                     //   $this->copyr(APPPATH . "/third_party/materia/" . $anexo['SEQ_MATERIA'],'/root/materia');
                        unlink($arquivo);
                        $contador++;
                    }
               // }

            }
        }
        echo 'Total Mat-> '.$contadorMT;
        echo '<br/>Total BD-> '.$contadorBD;
        echo '<br/>Total Del-> '.$contador;
    }
   private function copyr($source, $dest)
    {
        // COPIA UM ARQUIVO
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // CRIA O DIRET�RIO DE DESTINO
        if (!is_dir($dest)) {
            mkdir($dest);
            echo "DIRET&Oacute;RIO $dest CRIADO<br />";
        }

        // FAZ LOOP DENTRO DA PASTA
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // PULA "." e ".."
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // COPIA TUDO DENTRO DOS DIRET�RIOS
            if ($dest !== "$source/$entry") {
                copyr("$source/$entry", "$dest/$entry");
                echo "COPIANDO $entry de $source para $dest <br />";
            }
        }

        $dir->close();
        return true;

    }*/
  /**
   * Extrair tempo de video ou audio
   *  function tempo()
    {
        $this->load->model('materiaModelo', 'MateriaModelo');
        $lista_anexo = $this->MateriaModelo->listaVideo();
        $conta = 0;
        foreach ($lista_anexo as $index => $valor) {
            $dataAudio = getId3v2($valor['SEQ_MATERIA'] . '/' . $valor['NOME_BIN_ARQUIVO']);
            $this->MateriaModelo->alterarAnexo($dataAudio, $valor['SEQ_ANEXO']);
            $conta++;
        }
        echo 'Total-> '.$conta;
    }
   * */

  /*  public function template(){


        $templatePathMatriz = APPPATH.'/third_party/template/modelo/modelo.docx';

        $document = new \DOMDocument();
        $document->preserveWhiteSpace = false;
        $document->load(APPPATH.'/third_party/template/modelo/item1.xml');


        $tempDir = sys_get_temp_dir();
        $tempDir .= "/".uniqid();
        mkdir($tempDir,null,true);

        $templatePath = $tempDir.'/template.docx';

        copy($templatePathMatriz, $templatePath);

        $template = new \ZipArchive();
        $template->open($templatePath,\ZipArchive::CREATE);
        $template->addFromString("customXml/item1.xml",$document->saveXML());
        $template->close();


       /* $docxTemplate = $this->template->load($templatePath);

        $outputPath = $tempDir.'/mergedOutput.docx';

      // $docxTemplate->merge($data,$outputPath,false,false);
        $data = array("host"=>array("name"=>"My Company","nome"=>"Mattew"));
        $record = array("items"=>array(array("name"=>"item1"),array("name"=>"item2"),array("name"=>"item3")));
        $data["record"] = $record;
        $docxTemplate->merge($data,$outputPath);*/

      /*  echo    $tempDir;
    }

*/

//    public function teste (){
//
//        $cliente = $this->ComumModelo->getCliente('')->row();
//
//        $dataContent = file_get_contents(APPPATH.'/third_party/template/modelo/data.json');
//
//
//        $templatePath = APPPATH.'/third_party/template/modelo/relatorio-mark-quantidade.docx';
//
//        $tempDir = sys_get_temp_dir();
//        $tempDir .= "/".uniqid();
//        mkdir($tempDir,null,true);
//
//        $docxTemplate = $this->template->load($templatePath);
//
////        $this->template->setDataRelease(
////            $cliente->EMPRESA_CLIENTE,
////            $periodo,
////            $periodoEnvio,
////            $resultado
////        );
//
////        $dataContent =  $this->template->getJsonRelease();
//
//
//        $outputPath = $tempDir.'/relatorio-mark-quantidade-rs.docx';
//
//        $data = json_decode($dataContent,true);
//
//        //testing merge method
//        $docxTemplate->merge($data,$outputPath,true,false);
//    }

    /*public function processavideos(){
        set_time_limit(0);
        $contador = 0;
        $contadorBD = 0;
        $contadorMT = 0;
        $this->load->model('materiaModelo', 'MateriaModelo');
        $lista_materias = $this->MateriaModelo->listaMateriaAnexosZip();
        $dieDest = '/third_party/video/lote/';
        foreach ($lista_materias as $index => $materia) {
            $contadorMT++;
            $lista_anexo = $this->MateriaModelo->listaAnexo($materia['SEQ_MATERIA']);
            $fileDest = APPPATH .$dieDest.$materia['PASTAMES'];
            if (!is_dir($fileDest)) {
                mkdir($fileDest);
            };
            $fileDest2 = $fileDest.'/'.$materia['PASTADIA'];
            if (!is_dir($fileDest2)) {
                mkdir($fileDest2);
            };

            foreach ($lista_anexo as $index2 => $anexo) {
                $arquivo = APPPATH . "/third_party/materia/" . $anexo['SEQ_MATERIA'] . '/' . $anexo['NOME_BIN_ARQUIVO'];
                $contadorBD++;

                if (file_exists($arquivo)) {
//                    echo '<br>Dest: '. is_dir($fileDest2);
//                    die;
                    $this->copyr($arquivo,$fileDest2.'/' . $materia['SEQ_MATERIA'].'_'.$anexo['NOME_ARQUIVO']);
                  //  unlink($arquivo);
                    $contador++;
                }
                // }

            }
        }
        echo 'Total Mat-> '.$contadorMT;
        echo '<br/>Total BD-> '.$contadorBD;
        echo '<br/>Total Del-> '.$contador;
    }
    private function copyr($source, $dest)
    {
        // COPIA UM ARQUIVO
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // CRIA O DIRET�RIO DE DESTINO
//        if (!is_dir($dest)) {
//            mkdir($dest);
//            echo "DIRET&Oacute;RIO $dest CRIADO<br />";
//        }
//
//        // FAZ LOOP DENTRO DA PASTA
//        $dir = dir($source);
//        while (false !== $entry = $dir->read()) {
//            // PULA "." e ".."
//            if ($entry == '.' || $entry == '..') {
//                continue;
//            }
//
//            // COPIA TUDO DENTRO DOS DIRET�RIOS
//            if ($dest !== "$source/$entry") {
//                copyr("$source/$entry", "$dest/$entry");
//                echo "COPIANDO $entry de $source para $dest <br />";
//            }
//        }
//
//        $dir->close();
        return true;

    }*/

    private function removeDomNodes($html, $xpathString,$isDecode=NULL)
    {
        $dom = new DOMDocument;
        $dom->loadHTML( !empty($isDecode)? $html:mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

        $xpath = new DOMXPath($dom);
        while ($node = $xpath->query($xpathString)->item(0))
        {
            $node->parentNode->removeChild($node);
        }
        return $dom->saveHTML();
    }
    private function quebraLinha (){
        return PHP_EOL. PHP_EOL;
    }
    private function removeTags ($htmlResp,$isDecode=NULL){

        $htmlResp = $this->removeDomNodes($htmlResp,'//comment()',$isDecode);
        $htmlResp = $this->removeDomNodes($htmlResp, '//script',$isDecode);
        $htmlResp = $this->removeDomNodes($htmlResp, '//img',$isDecode);
        $htmlResp = $this->removeDomNodes($htmlResp, '//style',$isDecode);
        $htmlResp = $this->removeDomNodes($htmlResp, '//link',$isDecode);
        $htmlResp = $this->removeDomNodes($htmlResp, '//title',$isDecode);
        $htmlResp = $this->removeDomNodes($htmlResp, '//head',$isDecode);
        $htmlResp = $this->removeDomNodes($htmlResp, '//meta',$isDecode);
//        $htmlResp = $this->removeDomNodes($htmlResp, '//body/div[1]',$isDecode);
//        $htmlResp = $this->removeDomNodes($htmlResp, '/html/body/div[2]',$isDecode);
        return $htmlResp;
    }
    private function removeClass ($element,$site){
        if ($site!='bncAmazonas') {
            $element->find('.twitter-tweet')->remove();
            $element->find('#legenda')->remove();
            $element->find('.banner-marcos-santos')->remove();
            $element->find('.Apple-converted-space')->parent()->remove();
            $element->find('figure')->remove();
            $element->find('.jeg_ad_article')->remove();
            $element->find('.barra')->remove();
            $element->find('.epigraph')->remove();
            $element->find('p > em')->remove();
            $element->find('fb')->remove();
            $element->find('.jeg_post_tags')->remove();
            $element->find('.jaw-banner')->remove();
            $element->find('.rmp-main')->remove();
            $element->find('.td-post-featured-image')->remove();
            $element->find('.wp-caption-text')->remove();
//            $element->find('.heateor_sss_sharing_container')->remove();
            $element->find('.SandboxRoot')->remove();
            $element->find('.content-ads')->remove();


        } else {
            $element->find('.twitter-tweet')->remove();
            $element->find('#legenda')->remove();
            $element->find('.banner-marcos-santos')->remove();
            $element->find('.Apple-converted-space')->parent()->remove();
            $element->find('figure')->remove();
            $element->find('amp-ad')->remove();
            $element->find('.jeg_ad_article')->remove();
            $element->find('.barra')->remove();
            $element->find('.epigraph')->remove();
            $element->find('.jeg_post_tags')->remove();
            $element->find('.td-post-featured-image')->remove();
            $element->find('.heateor_sss_sharing_container')->remove();
        }

        return $element;
    }
    private function replaceString ($element){
        $element->html(str_replace('<br>', '</p><p>',$element->html()));
        $element->html(str_replace('<h5>', '<p>',$element->html()));
        $element->html(str_replace('</h5>','</p>',$element->html()));
        $element->html(str_replace('<div>', '<p>',$element->html()));
        $element->html(str_replace('</div>','</p>',$element->html()));
        return $element;

    }

    private function limparLinha ($site,$linha){
        switch ($site) {
            case 'portalHolanda':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/A qualquer momento mais/', $linha);
                break;
            case 'portalMarcosSantos':
                return preg_match('/ Foto: /', $linha);
                break;
            case 'radarAmazonico':
                return preg_match('/ Foto: /', $linha);
                break;
            case 'fatoAmazonico':
                return preg_match('/ Foto: /', $linha);
                break;
            case 'amazonasAtual':
                return preg_match('/ Foto: /', $linha);
                break;
            case 'amPost':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/A qualquer momento mais/', $linha)
                or preg_match('/LEIA O PROJETO COMPLETO AQUI/', $linha);
                break;
            case 'portalZacarias':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/IMAGENS FORTES/', $linha)
                or preg_match('/A qualquer momento mais/', $linha)
                or preg_match('/LEIA O PROJETO COMPLETO AQUI/', $linha);
                break;
            case 'bncAmazonas':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/Foto: /', $linha)
                    or preg_match('/Leia mais/', $linha);
            case 'correioAmazonia':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/Foto: /', $linha)
                or preg_match('/Leia mais/', $linha);
            case 'onJornal':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/Foto: /', $linha)
                or preg_match('/Comentarios/', $this->retira_acentos($linha))
                or preg_match('/Leia mais/', $linha)
                or substr($linha,1,6)=='Coment';
            case 'portalJota':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/Foto: /', $linha)
                or preg_match('/Comentarios/', $this->retira_acentos($linha))
                or preg_match('/Leia mais/', $linha)
                or substr($linha,1,6)=='Coment'
                or substr(trim($linha),0,11)=='AO CENTRO A';
            case 'emTempo':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/Foto: /', $linha)
                or preg_match('/Comentarios/', $this->retira_acentos($linha))
                or preg_match('/Leia mais/', $linha)
                or substr($linha,1,6)=='Coment'
                or strtolower(substr(trim($this->retira_acentos($linha)),0,13))=='assista a mat';

            default:
                echo false;
        }
    }
    private function curl_get2($url, array $options = array())
    {
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST=>FALSE,
            CURLOPT_POSTFIELDS =>'',
            CURLOPT_TIMEOUT => 20
        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
    private function criaObjeto ($htmlResp,$isDecode=NULL){
        libxml_use_internal_errors(true);
        $document = phpQuery::newDocumentHTML($this->removeTags($htmlResp,$isDecode));
        return $document;

    }
    private function getObjeto ($document,$init,$site=''){
        $element = pq($init,$document);
        $element = $this->removeClass($element,$site);
        $element =  $this->replaceString($element);

        return $element;
    }

    private function resposta ($titulo,$conteudo){

        return json_encode(array(
            'titulo'=>trim($titulo),
            'conteudo'=>trim($conteudo)
        ));

    }

    public function teste()
    {
//        libxml_use_internal_errors(true);
//        header('content-type text/html charset=windows-');

        $url = "https://portaldogeneroso.com/com-adail-filho-e-presidente-da-camara-dos-vereadores-presos-procuradora-geral-de-coari-assume-prefeitura/";


        $User_Agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.75 Safari/537.36';

        $request_headers = array();
        $request_headers[] = 'User-Agent: '. $User_Agent;
        $request_headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
//        $request_headers[] = 'Cookie: visid_incap_1743638=NqWQqoKPQjeBPNzI5tPcXm6GeV0AAAAAQUIPAAAAAACFHDsWuHxAsIa4Mo+aJwSd; incap_ses_1245_1743638=NbuSCf6UVTTBBs+RISFHEXiGeV0AAAAAxzOfY06CPVBcEE6fndBjXA==; _ga=GA1.2.884995606.1568245370; _gid=GA1.2.1679654908.1568245370; incap_ses_1172_1743638=B0VbC3Ye/DAvv1krJchDEIGReV0AAAAAGiGtgdcdnXybrWVYglgEYg==';
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST=>FALSE,
            CURLOPT_POSTFIELDS =>'',
            CURLOPT_HTTPHEADER =>$request_headers,
            CURLOPT_TIMEOUT => 20
        );
        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt_array($ch, ($defaults));
        if( ! $htmlResp = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);


//        $htmlResp = $this->curl_get2('https://amazonas1.com.br/economia/natal-deve-gerar-103-mil-empregos-temporarios/');
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'.entry-content');
        $elementTitulo = $this->getObjeto($document,'header > h1');
        $titulo = $elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('amazonas1',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        echo $this->resposta(($titulo),(str_replace('&nbsp;','',$result)));

    }

    function retira_acentos($texto){
        return strtr($texto, "��������������������������", "aaaaeeiooouucAAAAEEIOOOUUC");
    }

    // copia s midias em lote para pasta de videos
    // comentado para naos er executado
    public function processapmm(){

        /** JULHO */
        echo '<br/><br/>JULHO<br/>';
        $this->processacopia(20200706,20200731,'T');
        $this->processacopia(20200706,20200731,'R');
        // /** AGOSTO */
        echo '<br/><br/>AGOSTO<br/>';
        $this->processacopia(20200801,20200831,'T');
        $this->processacopia(20200801,20200831,'R');
        // /** SETEMBRO */
        echo '<br/><br/>SETEMBRO<br/>';
        $this->processacopia(20200901,20200930,'T');
        $this->processacopia(20200901,20200930,'R');
    }

    private function processacopia($dtIni,$dtFim,$tipo){
        set_time_limit(0);
        $contador = 0;
        $contadorBD = 0;
        $contadorMT = 0;
        $this->load->model('materiaModelo', 'MateriaModelo');
        $lista_materias = $this->MateriaModelo->listaMateriaCopia($dtIni,$dtFim,$tipo);

        $dieDest = APPPATH_VIDEO.'pmm102020/'.$tipo.'/';
        if (!is_dir($dieDest)) {
            mkdir($dieDest);
        };
        foreach ($lista_materias as $index => $materia) {
            $contadorMT++;
            $fileDest = $dieDest.$materia['PASTAMES'];
            if (!is_dir($fileDest)) {
                mkdir($fileDest);
            };
            $fileDest2 = $fileDest.'/'.$materia['DIA'];
            if (!is_dir($fileDest2)) {
                mkdir($fileDest2);
            };
            
            $lista_anexo = $this->MateriaModelo->listaAnexo($materia['SEQ_MATERIA']);
            foreach ($lista_anexo as $index2 => $anexo) {
                $arquivo = APPPATH_MATERIA . $anexo['SEQ_MATERIA'] . '/' . $anexo['NOME_BIN_ARQUIVO'];
                $contadorBD++;

                if (file_exists($arquivo)) {
                   echo '<br>FILE: '.$arquivo;
                   $destinoFile = $fileDest2.'/' .$anexo['NOME_ARQUIVO'];
                   echo '<br>FILE Target: '.$destinoFile;
                    $this->copyr($arquivo,$destinoFile);
                    $contador++;
                }
            }
        }
        echo '<br/>Total: '.$contador;
    }
    private function copyr($source, $dest)
    {
        // COPIA UM ARQUIVO
        if (is_file($source)) {
            return copy($source, $dest);
        }

        return true;

    }
    private function sendHeaders($file, $type, $name=NULL)
    {
        if (empty($name))
        {
            $name = basename($file);
        }
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: attachment; filename="'.$name.'";');
        header('Content-Type: ' . $type);
        header('Content-Length: ' . filesize($file));
    }
	public function download($id)
    {
        $this->load->helper('download');

        $arquivo = APPPATH_EXPORTACAO . $id.'.zip';
		
		// if (is_file($arquivo)) {
        //     $dataBinary = file_get_contents($arquivo);
		// 	force_download($id.'.zip', $dataBinary, TRUE);
        // } else {
		// 	echo 'Arquivo não localizado!!';
        // }
        
        $this->sendHeaders($arquivo, mime_content_type($arquivo), $id.'.zip');
        ob_clean();
        flush();
        @readfile($arquivo);
        exit;
    }
    
    public function teste2(){

        $template = APPPATH . 'third_party/modelo/porto.docx';

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($template);
        // $templateProcessor->setValue('nome_veiculo', htmlspecialchars('Jornal Portal do Holanda'));
        // $templateProcessor->setValue('data_pub', date_format(date_create(),"d/m/Y")) ;
        // $templateProcessor->setValue('conteudo',      htmlspecialchars(' teste de conteudo de msg porto materia'));

        $replacements = array(
            array('nome_veiculo' => htmlspecialchars('Holanda'), 
                  'data_pub' => '25/02/2021',
                  'pagina' => 'Pg1',
                  'conteudo' => htmlspecialchars('Conteudo 1')
                ),
            array('nome_veiculo' => htmlspecialchars('A Critica'), 
                  'data_pub' => '26/02/2021',
                  'pagina' => '10',
                  'conteudo' => htmlspecialchars('Conteudo 2')
                ),
            array('nome_veiculo' => htmlspecialchars('G1 Amazonas'), 
                  'data_pub' => '27/02/2021',
                  'pagina' => '',
                  'conteudo' => htmlspecialchars('Conteudo 3')),
            array('nome_veiculo' => htmlspecialchars('Diário AM'), 
                  'data_pub' => '28/02/2021',
                  'pagina' => '',
                  'conteudo' => htmlspecialchars('Conteudo 4'),
            )
        );

        $templateProcessor->cloneBlock('block_msg', 0, true, false, $replacements);

        $file = APPPATH . 'third_party/lixo/porto_.docx';

        $templateProcessor->saveAs($file);

        $this->load->helper('download');
        $dataBinary = file_get_contents($file);
        force_download('livro_.docx', $dataBinary, TRUE);

        unlink($file);


    }
//    public function teste22() {
//        $SQL = 'SELECT * FROM `RELEASE_SECRETARIA` WHERE `SEQ_MATERIA` IS NOT NULL';
//        $result = $this->db->query($SQL)->result();
//        
//        foreach ($result as $value) {
//            $this->db->insert('SECRETARIA_MATERIA', array(
//                'SEQ_MATERIA' => $value->SEQ_MATERIA,
//                'SEQ_SETOR' => $value->SEQ_SETOR
//            ));
//        }
//    }
}

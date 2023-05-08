<?php
class Integracao extends MY_Controller {

        public function __construct()
        {
                parent::__construct();
			$this->load->model('integracaoModelo', 'IntegracaoModelo');
			$this->load->model('releaseModelo', 'ReleaseModelo');
			$this->load->model('assuntoModelo', 'AssuntoModelo');
			$this->load->model('veiculoModelo', 'VeiculoModelo');
			$this->load->model('setorModelo', 'SetorModelo');
			$this->load->model('tipomateriaModelo', 'TipomateriaModelo');
			$this->load->model('tipomateriaModelo', 'TipomateriaModelo');
			$this->load->model('materiaModelo', 'MateriaModelo');
			$this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());

		}
        public function monitoramento()
        {
			$this->inserirAuditoria('CONSULTAR-MONITORAMENTO','C','Lista Todos');
  			$resultado['lista_monitoramento'] = $this->IntegracaoModelo->listaMonitoramento();

			$this->loadUrl('modulos/integracao/consultar-monitoramento',$resultado);
	
        }
        public function index()
        {
            $this->inserirAuditoria('CONSULTA-MATERIA-INTEGRACAO', 'C', '');
            $resultado['lista_monitoramento'] = $this->IntegracaoModelo->listaMonitoramento();
            $resultado['datai'] = date('d/m/Y', strtotime('-1 days'));
            $resultado['dataf'] = date('d/m/Y');
            $this->loadUrl('modulos/integracao/consultar-materia',$resultado);
        }
        private function acoes($row)
        {
            $resultado = '<div class="action-buttons" >';
            $habilitaBotaoDownEmail = !empty($row->SEQ_TIPO_MATERIA) AND !empty($row->SEQ_SETOR) and  !empty($row->IND_AVALIACAO) and !empty($row->IND_CLASSIFICACAO);
            if ($this->auth->CheckMenu('geral', 'integracao', 'editar') == 1) {
                $resultado .= '<a id="btn-editar-item" data-toggle="tooltip" data-placement="top" title="Editar" class="btn bg-blue btn-circle-xm waves-effect waves-circle waves-float" href="' . base_url('integracao/editar/') . $row->SEQ_MATERIA . '"><i class="material-icons">edit</i></a>&nbsp;&nbsp;';
            }
            if ($this->auth->CheckMenu('geral', 'integracao', 'excluir') == 1) {
                $resultado .= '<a id="btn-excluir-item" data-toggle="tooltip" data-placement="top" title="Excluir" class="btn bg-light-blue btn-circle-xm waves-effect waves-circle waves-float botao-excluir" data-url="' . base_url('integracao/excluir/') . $row->SEQ_MATERIA . '"><i class="material-icons">delete</i></a>&nbsp;&nbsp;';
            }
            if ((
                    ($this->auth->CheckMenu('geral', 'integracao', 'alterar') == 1) and 
                    ($row->SEQ_USUARIO!=-1)) and
                (($row->SEQ_USUARIO==$this->session->userdata('idUsuario')) or
                ($this->session->userdata('perfilUsuario')=='ROLE_ADM') or
                ($this->session->userdata('idUsuario')==7) or
                ($this->session->userdata('idUsuario')==20) or
                ($this->session->userdata('idUsuario')==60) or
                ($this->session->userdata('idUsuario')==30))
            
            ) {
                $resultado .= '<a id="btn-alterar-item" data-toggle="tooltip" data-placement="top" title="Desbloquear" class="btn bg-light-blue btn-circle-xm waves-effect waves-circle waves-float botao-excluir" href="' . base_url('integracao/alterar/') . $row->SEQ_MATERIA .'/desbloquear"><i class="material-icons">lock_open</i></a>&nbsp;&nbsp;';
            }
            $resultado .= '</div>';
            return $resultado;
        }
        public function consultar()
        {
            $fetch_data = $this->MateriaModelo->make_datatables('K');
            $data = array();
            foreach ($fetch_data as $row) {
                $data_cliente =$this->ComumModelo->getCliente($row->SEQ_CLIENTE)->row();
                $sub_array = array();
                $sub_array[] = $row->SEQ_MATERIA;
                $sub_array[] = !empty($data_cliente)?$data_cliente->NOME_CLIENTE:'Cliente não Identificado';
                $sub_array[] = $row->TIT_MATERIA;
                $usuario = $this->ComumModelo->getUser($row->SEQ_USUARIO)->row();
                $sub_array[] = !empty($usuario)?$usuario->NOME_USUARIO:'Nenhum Resposável';
                $sub_array[] = $row->NOME_PORTAL;
                $sub_array[] = $row->DATA_MATERIA_PUB;
                $sub_array[] = '<a href="'.$row->LINK_MATERIA.'" target="_blank">acessar</a>';
                $sub_array[] = $this->acoes($row);
                $data[] = $sub_array;
            }
            $output = array(
                "draw" => intval($_POST["draw"]),
                "recordsTotal" => $this->MateriaModelo->get_all_data('K'),
                "recordsFiltered" => $this->MateriaModelo->get_filtered_data('K'),
                "data" => $data
            );
            echo json_encode($output);
        }

        public function editar($id=NULL)
    {

        if (empty($id)) {
            $class = 'warning';
            $mensagem = 'Por favor, selecione uma Matéria para editar!!';
            $this->feedBack($class, $mensagem, 'integracao');
            return;

        }
        
        $materia = $this->MateriaModelo->editar($id);

        if (empty($materia)) {
            $class = 'warning';
            $mensagem = 'Matéria não Localizada na nossa base de dados!!';
            $this->feedBack($class, $mensagem, 'integracao');
            return;
        }

        
        foreach ($materia as $index => $valor) {
            if ($valor['ORIGEM']!='K'){

                $class = 'warning';
                $mensagem = 'Matéria não Localizada, provavelmente ja foi classificada!!';
                $this->feedBack($class, $mensagem, 'integracao');
                return;
            }
            if (
                ($valor['SEQ_USUARIO']!=-1) and
                ($valor['SEQ_USUARIO']!=$this->session->userdata('idUsuario')) and
                ($this->session->userdata('perfilUsuario')!='ROLE_ADM') and
                ($this->session->userdata('idUsuario')!=7) and
                ($this->session->userdata('idUsuario')!=20) and
                ($this->session->userdata('idUsuario')!=60) and
                ($this->session->userdata('idUsuario')!=30)
            ) {
                $class = 'warning';
                $mensagem = 'Matéria Alocada para outro usuário para classificar!!';
                $this->feedBack($class, $mensagem, 'integracao');
                return;
            }
        }
        // setar o usuario a matéria
        $data = array(
            'SEQ_USUARIO' => $this->session->userdata('idUsuario'),
            'SEQ_USUARIO_ALT' => $this->session->userdata('idUsuario'),
        );
        $this->MateriaModelo->alterar($data, $id);

        foreach ($materia as $index => $valor) {
            $resultado['idMateria'] = $id;
            $resultado['tipo'] = $valor['SEQ_TIPO_MATERIA'];
            $resultado['tipoMateria'] = $valor['TIPO_MATERIA'];
            $resultado['veiculo'] = $valor['SEQ_VEICULO'];
            $resultado['portal'] = $valor['SEQ_PORTAL'];
            $resultado['preco'] = $valor['SEQ_PRECO'];
            $resultado['radio'] = $valor['SEQ_RADIO'];
            $resultado['tv'] = $valor['SEQ_TV'];
            $resultado['link'] = $valor['LINK_MATERIA'];
            $resultado['cliente'] = $valor['SEQ_CLIENTE'];
            $resultado['setor'] = $valor['SEQ_SETOR'];
            $resultado['usuario'] = $valor['SEQ_USUARIO'];
            $resultado['usuarioAlt'] = $valor['SEQ_USUARIO_ALT'];
            $resultado['titulo'] = $valor['TIT_MATERIA'];
            $resultado['palavra'] = $valor['PC_MATERIA'];
            $resultado['chave'] = $valor['CHAVE'];
            $resultado['data'] = $valor['DATA_MATERIA_PUB'];
            $resultado['dataCad'] = $valor['DATA_MATERIA_CAD'];
            $resultado['texto'] = $valor['TEXTO_MATERIA'];
            $resultado['programa'] = $valor['PROGRAMA_MATERIA'];
            $resultado['apresentador'] = $valor['APRESENTADOR_MATERIA'];
            $resultado['pagina'] = $valor['PAGINA_MATERIA'];
            $resultado['editorial'] = $valor['EDITORIA_MATERIA'];
            $resultado['destaque'] = $valor['DESTAQUE_MATERIA'];
            $resultado['autor'] = $valor['AUTOR_MATERIA'];
            $resultado['hora'] = $valor['HORA_MATERIA'];
            $resultado['avaliacao'] = $valor['IND_AVALIACAO'];
            $resultado['classificacao'] = $valor['IND_CLASSIFICACAO'];
            $resultado['modelo'] = $valor['IND_MODELO'];
            $resultado['release'] = $valor['IND_RELEASE'];
            $resultado['indFiltro'] = $valor['IND_FILTRO'];
            $resultado['analise'] = $valor['ANALISE_MATERIA'];
            $resultado['resumo'] = $valor['RESUMO_MATERIA'];
            $resultado['resposta'] = $valor['RESPOSTA_MATERIA'];
            $resultado['comentario'] = $valor['COMENTARIO_MATERIA'];
            $resultado['release'] = $valor['SEQ_RELEASE'];
            $resultado['assunto'] = $valor['SEQ_ASSUNTO_GERAL'];
            $resultado['tipoCrime'] = $valor['TIPO_CRIME'];
            $resultado['bairroCrime'] = $valor['BAIRRO_CRIME'];
            $resultado['localCrime'] = $valor['LOCAL_CRIME'];
            $resultado['qtdComentario'] = $valor['QTD_COMENTARIO'];
            $resultado['qtdCurtida'] = $valor['QTD_CURTIDA'];
            $resultado['qtdCompartilhamento'] = $valor['QTD_COMPARTILHAMENTO'];
            $resultado['indPreso'] = $valor['IND_PRISAO'];
            $resultado['origem'] = $valor['ORIGEM'];
        }

        $resultado['lista_anexo'] = $this->MateriaModelo->listaAnexo($id);
        
        $item_release=array();
        if (!empty($resultado['release'])){
        $item_release = $this->ReleaseModelo->getRelease($resultado['release'])->result_array();
        }

        if ($resultado['cliente'] != 55 and $resultado['cliente'] != 60) {
            $lista_setor_release = $this->ReleaseModelo->listaReleaseBySetor($resultado['setor'], 'S');
        } else {
            $lista_setor_release = $this->ReleaseModelo->listaReleaseTodos();
        }

        $resultado['lista_release'] = array_merge($item_release,$lista_setor_release);

        $resultado['lista_setores'] = $this->MateriaModelo->listaSetoresClientesMateria($id);
        $resultado['lista_tipos'] = $this->MateriaModelo->listaTipoClientesMateria($id);
        $resultado['lista_assunto'] = $this->AssuntoModelo->listaAssunto();
        $resultado['lista_veiculo'] = $this->VeiculoModelo->listaPortalAtivoCli($resultado['cliente']);
        $resultado['lista_setor'] = $this->SetorModelo->listaSetorCli($resultado['cliente']);
        $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria($resultado['cliente']);
            if (!empty($resultado['portal']))
                $resultado['logo_veiculo'] = $this->VeiculoModelo->getPortal($resultado['portal'])->row()->LOGO_VEICULO;
        $this->loadUrl('modulos/integracao/editar', $resultado);
    }
    public function alterar($idMateria=NULL,$isDebloq=NULL)
    {

        set_time_limit(0);
        if (empty($idMateria)) {
            $class = 'warning';
            $mensagem = 'Por favor, selecione uma Matéria para editar!!';
            $this->feedBack($class, $mensagem, 'integracao');
            return;
        }
        // setar o usuario a matéria
        if(!empty($isDebloq=='desbloquear')){
            $data = array(
                'SEQ_USUARIO' => -1,
                'SEQ_USUARIO_ALT' => -1,
            );
            $this->MateriaModelo->alterar($data, $idMateria);
            $class = 'success';
            $mensagem = 'Matéria desbloqueada com sucesso!!';
            $this->feedBack($class, $mensagem, 'integracao');
            return;
        }


        $this->load->helper('date');
        $resultado = array();
        $path='';
        $query='';
        if (!empty($this->input->post('link'))) {
            $urlParser = parse_url($this->input->post('link'));
            $array_domain = explode(".", $urlParser["host"]);
            $types = array('d', 'com', 'br', 'www');

            foreach ($array_domain as $item) {
                if (!in_array($item, $types)) {
                    array_push($resultado, $item);
                }
            }
            $path = rtrim(trim($urlParser["path"]),"/");
            $query=NULL;
            if(!empty($urlParser["query"]))
                $query = trim($urlParser["query"]);
        }
        $this->inserirAuditoria('VERIFICA-LINK-ALTERAR', 'I', 'formJson:' . json_encode($this->input->post('link')));
        if (!empty($this->input->post('link')) and 
            $this->MateriaModelo->countLink($path,$query, $idMateria,$resultado,$this->input->post('idcliente')) > 0) {
            $class = 'warning';
            $mensagem = 'Link para esssa Matéria já foi cadastrado!!';
            $this->feedBack($class, $mensagem, 'integracao/editar/' . $idMateria);
            return;
        } else {
            $materiaAtual = $this->MateriaModelo->getMateria($idMateria)->row();

            if ($materiaAtual->ORIGEM!='K'){

                $class = 'warning';
                $mensagem = 'Matéria não Localizada, provavelmente ja foi classificada!!';
                $this->feedBack($class, $mensagem, 'integracao');
                return;
            }

            $clienteSessao = $this->input->post('idcliente') ;
            $isDiferente = false;

            $setores = NULL;
            if (is_array($this->input->post('setor'))){
                $setores = implode($this->input->post('setor'),',');
            } else {
                $setores = $this->input->post('setor');
            }
            $tipos = NULL;
            if (is_array($this->input->post('tipo'))){
                $tipos = implode($this->input->post('tipo'),',');
            } else {
                $tipos = $this->input->post('tipo');
            }
            if (!empty($clienteSessao)) {
                $data = array(
                    'SEQ_CLIENTE' => $clienteSessao,
                    'SEQ_TIPO_MATERIA' => $isDiferente ? NULL : $tipos,
                    'SEQ_SETOR' => $isDiferente ? NULL : $setores ,
                    'SEQ_VEICULO' => $isDiferente ? NULL : $this->input->post('veiculo'),
                    'SEQ_PORTAL' => $isDiferente ? NULL : $this->input->post('portal'),
                    'SEQ_RADIO' => $isDiferente ? NULL : $this->input->post('radio'),
                    'SEQ_TV' => $isDiferente ? NULL : $this->input->post('tv'),
                    'SEQ_PRECO' => $this->input->post('preco'),
                    'SEQ_USUARIO' => $this->session->userdata('idUsuario'),
                    'SEQ_USUARIO_ALT' => $this->session->userdata('idUsuario'),
                    'PC_MATERIA' => tirarAcentos($this->input->post('palavra')),
                    'DATA_MATERIA_PUB' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('data')))),
                    'DATA_PUB_NUMERO' => date('Ymd', strtotime(str_replace('/', '-', $this->input->post('data')))),
                    'DATA_MATERIA_ALT' => date('Y-m-d H:i:s', now('America/Manaus')),
                    'PAGINA_MATERIA' => $this->input->post('pagina'),
                    'DESTAQUE_MATERIA' => $this->input->post('destaque'),
                    'AUTOR_MATERIA' => $this->input->post('autor'),
                    'HORA_MATERIA' => $this->input->post('hora'),
                    'EDITORIA_MATERIA' => $this->input->post('editorial'),
                    'PROGRAMA_MATERIA' => $this->input->post('programa'),
                    'ANALISE_MATERIA' => $this->input->post('analise'),
                    'RESUMO_MATERIA' => $this->input->post('resumo'),
                    'RESPOSTA_MATERIA' => $this->input->post('resposta'),
                    'COMENTARIO_MATERIA' => $this->input->post('comentario'),
                    'APRESENTADOR_MATERIA' => $this->input->post('apresentador'),
                    'IND_AVALIACAO' => $this->input->post('avaliacao'),
                    'IND_CLASSIFICACAO' => $this->input->post('classificacao'),
                    'IND_FILTRO' => !empty($this->input->post('indFiltro'))?$this->input->post('indFiltro'):'N',
                    'IND_MODELO' => empty($this->input->post('modelo')) ? 'N' : $this->input->post('modelo'),
                    'IND_RELEASE' => ($this->input->post('release')>0)?'S':'N',
                    'SEQ_RELEASE' => $isDiferente ? NULL : $this->input->post('release'),
                    'SEQ_ASSUNTO_GERAL' => $this->input->post('assunto'),
                    'TIPO_CRIME' => $this->input->post('tipoCrime'),
                    'BAIRRO_CRIME' => $this->input->post('bairroCrime'),
                    'LOCAL_CRIME' => $this->input->post('localCrime'),
                    'IND_PRISAO' => $this->input->post('indPreso'),
                    'QTD_COMENTARIO' => $this->input->post('qtdComentario'),
                    'QTD_CURTIDA' => $this->input->post('qtdCurtida'),
                    'QTD_COMPARTILHAMENTO' => $this->input->post('qtdCompartilhamento'),
                );

                if ($this->input->post('acao') == 'S'){
                    $data = array_merge($data,array('ORIGEM' => 'M'));
                }

                $this->inserirAuditoria('ALTERAR-MATERIA', 'A', json_encode($this->input->post()));

                if (!$this->MateriaModelo->alterar($data, $idMateria)) {
                    $class = 'error';
                    $mensagem = 'Matéria não Alterada!!';
                    $this->feedBack($class, $mensagem, 'integracao/editar/' . $idMateria);
                    return;
                } 
                $class = 'success';
                $mensagem = 'Matéria Classificada com Sucesso com sucesso!!';
            } else{
                $class = 'warning';
                $mensagem = 'No Momento não podemos alterar sua Matéria Alterado, tente novamente!!';
            }
        }

        if ($this->input->post('acao') == 'S')
            $this->feedBack($class, $mensagem, 'integracao');
        else
            redirect(base_url('integracao/editar/' . $idMateria));
    }
    public function excluir($id)
    {

        $this->inserirAuditoria('EXCLUIR-MATERIA', 'E', 'MateriaId: ' . $id);
        $dataMateria = $this->MateriaModelo->getMateria($id)->row();

        if (!empty($dataMateria) and $this->MateriaModelo->deletar($id)) {
            $class = 'success';
            $mensagem = 'Matéria Excluída com sucesso!!';

        } else {
            $class = 'error';
            if (!empty($dataMateria) and $dataMateria->SEQ_USUARIO==$this->session->userdata('idUsuario')){
                $mensagem = 'Matéria Não pode ser Excluída!';
            }else {
                $mensagem = 'Matéria Não pode ser Excluída, pois foi cadastrada por outro usuário!';
            }
        }
        $this->feedBack($class, $mensagem, 'integracao');
    }
    private function processaBodyApi($response,$cliente){
        try {
            foreach($response as $article) {
                // verifica se exite link
                foreach( $cliente as $item){
                    $existeLink = $this->existeLink($article->_source->url,$item['SEQ_CLIENTE']);
                    $idPortal = $this->recuperaPortal(urldecode($article->_source->url),$item['SEQ_CLIENTE']);
                    // $idUsuario = !empty($this->session->userdata('idUsuario'))?$this->session->userdata('idUsuario'):0;
                    $materia = array(
                        'SEQ_CLIENTE' => $item['SEQ_CLIENTE'],
                        'SEQ_USUARIO' => -1,
                        'SEQ_PORTAL' => $idPortal,
                        'TIPO_MATERIA' => 'S',
                        'DATA_MATERIA_CAD' => date('Y-m-d',now('America/Manaus')),
                        'DATA_MATERIA_ALT' => date('Y-m-d',now('America/Manaus')),
                        'ORIGEM'=>'K',
                        'ORIGEM_MATERIA'=>'K',
                        'IND_STATUS' => 'E',
                        'TIT_MATERIA' => $article->_source->title,
                        'TEXTO_MATERIA' => $article->_source->text,
                        'LINK_MATERIA' => urldecode($article->_source->url),
                        'DATA_MATERIA_PUB' => date("Y-m-d", strtotime($article->_source->published_date)),
                        'DATA_PUB_NUMERO' => date("Ymd", strtotime($article->_source->published_date))
                    );

                    // // VALIDAÇÂO... SE Já existi na tabela de MATERIA 
                   if (!$existeLink) {
                        $this->inserirAuditoriaKlipbox('INSERIR-MATERIA-KLIPBOX', 'I', json_encode($materia));
                        $this->MateriaModelo->inserir($materia);
                   }
                }
            }
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return;
        } 
    }
    private function processoPaginacao($dataInicio,$dataFim,$idMonitoramento,$inicioPagina){

        $this->inserirAuditoriaKlipbox('PROCESSA-PAGE-API-KLIPBOX-MONITORAMENTO', 'C', '');
        $listaMonitoramento = $this->IntegracaoModelo->getMonitoramento($idMonitoramento)->result_array();
        // config data filtro
        $filtroData = new stdClass();
        $filtroData->from = $dataInicio;
        $filtroData->to = $dataFim;
        try {
            // Url da Api que consulta as materias
            $url = 'https://api.klipbox.com.br/v1/articles';
            foreach($listaMonitoramento as $monitoramento) {
                $idCliente = $this->ComumModelo->clienteByMonitoramento($monitoramento['SEQ_MONITORAMENTO'])->result_array();
                $idCliente = count($idCliente)>0? $idCliente : array(array('SEQ_CLIENTE'=> -1));
                // MONTAR BODY
                $parametros_body = json_encode(
                    array(
                        'monitoring_id'=>$monitoramento['SEQ_MONITORAMENTO'],
                        'date_filter'=> $filtroData,
                        'from'=> $inicioPagina
                    )
                );
                $response = $this->requestApi(
                    $url,
                    $this->getHeader(),                    
                    'post',
                    $parametros_body
                );
                if(!empty($response)){
                    $this->processaBodyApi($response->hits->hits,$idCliente);
                }
            }
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return;
        } 
        return;
    }

    private function processoMonitoramento($dataInicio,$dataFim,$idMonitoramento){

        
        $listaMonitoramento = $this->IntegracaoModelo->getMonitoramento($idMonitoramento)->result_array();
        // config data filtro
        $filtroData = new stdClass();
        $filtroData->from = $dataInicio;
        $filtroData->to = $dataFim;
        try {
            // Url da Api que consulta as materias
            $url = 'https://api.klipbox.com.br/v1/articles';
            foreach($listaMonitoramento as $monitoramento) {
                $this->inserirAuditoriaKlipbox('PROCESSA-API-KLIPBOX-MONITORAMENTO', 'C', json_encode($monitoramento));
                $idCliente = $this->ComumModelo->clienteByMonitoramento($monitoramento['SEQ_MONITORAMENTO'])->result_array();
                $idCliente = count($idCliente)>0? $idCliente : array(array('SEQ_CLIENTE'=> -1));
                // MONTAR BODY
                $parametros_body = json_encode(
                    array(
                        'monitoring_id'=>$monitoramento['SEQ_MONITORAMENTO'],
                        'date_filter'=> $filtroData,
                        'from'=> 0
                    )
                );
                $response = $this->requestApi(
                    $url,
                    $this->getHeader(),                    
                    'post',
                    $parametros_body
                );
                if(!empty($response)){
                    
                    $this->processaBodyApi($response->hits->hits,$idCliente);
                    $total = $response->hits->total;
                    
                    if ($total>0){
                        $numPages =ceil($total/10);
                        
                        for ($x = 1; $x <= $numPages; $x++) {
                            $this->processoPaginacao($dataInicio,$dataFim,$idMonitoramento,$x*10);
                          }
                    } else{
                        return;
                    }
                }
            }
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            return;
        } 
    }
    public function jobProcessamento()
    {
        $this->inserirAuditoriaKlipbox('REQUEST-API-KLIPBOX-MATERIA', 'C', '');
        set_time_limit(0);
        extract($this->input->post());
        try {
            $dataIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $datai);
            $dataFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $dataf);
            $isManual = true;
            // verificar se o processamento será manual ou automatico
            if (empty($dataIni) && empty($dataFim) and empty($monitoramento)) {
                $dataFim = date("Y-m-d");
                $dataIni = date("Y-m-d", strtotime("-1 days"));
                $isManual = false;
            }
            $this->processoMonitoramento($dataIni,$dataFim,$monitoramento);

            if($isManual){
                $resultado = array(
                    'status'=>'success',
                    'mensagem'=>"showNotification('alert-success', 'Consulta realizada com sucesso', 'bottom', 'center', 'animated fadeInUp', '')",
                );
            } else {
                return ;
            }
        } catch(Exception $e) {
            log_message('error', $e->getMessage());
            if($isManual){
                $resultado = array(
                    'status'=>'danger',
                    'mensagem'=>"showNotification('alert-danger', 'Erro ao processar a consulta', 'bottom', 'center', 'animated fadeInUp', '')",
                );
            }else {
                    return ;
                }
            }    
        echo json_encode($resultado);
    }
    private function existeLink($link,$idCliente)
    {
        $this->inserirAuditoriaKlipbox('VERIFICA-LINK-INTEGRACAO', 'I', 'Link:'.$link );
        try {

            if ($this->MateriaModelo->countLinkIntegracao($link,$idCliente) > 0) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
        }
        return false;
    }
    public function recuperaPortal($link,$idCliente)
    {
        $this->inserirAuditoriaKlipbox('VERIFICA-PORTAL-INTEGRACAO', 'I', 'Link:'.$link );

        try {
            $urlParser = parse_url($link);
            $array_domain = explode(".",$urlParser["host"]);
            $resultado = array();
            $types = array( 'd','com','br','www' );

            foreach ($array_domain as $item) {
                if( ! in_array( $item, $types ) ) {
                    array_push($resultado,$item);
                }
            }
            $data_portal = $this->MateriaModelo->getPortalByDomain($resultado,$idCliente);
            if ( !empty($data_portal)) 
                return $data_portal->SEQ_PORTAL;

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
        }
        return NULL;
    }
    private function autenticarApi($isValid=NULL)
    {
        $url = 'https://api.klipbox.com.br/v1/auth';

        $this->inserirAuditoriaKlipbox('AUTENTICAR-API-KLIPBOX', 'C', '');
        try {
            // carrega parametros
            $dados = $this->IntegracaoModelo->getParametros()->row(); //->TOKEN;

            if (empty($isValid) and !empty($dados) and !empty($dados->TOKEN)){
                return $dados->TOKEN;
            } else if (!empty($dados) and !empty($dados->USUARIO) and !empty($dados->SENHA)){
                // Montar Body
                $parametros = json_encode(
                    array(
                        'email'=>$dados->USUARIO,
                        'password'=>$dados->SENHA
                    )
                );
                $response = $this->requestApi(
                                $url,
                                array( "Content-Type" => "application/json"),
                                $parametros);
                // Verifica se foi realizado com sucesso
                if (!empty($response)) {
                    // SE SIM, ATUALIZAR A TABELA PARAMETROS_IP COM O NOVO TOKEN
                    $dados->TOKEN = $response->auth_token;
                    $this->IntegracaoModelo->alterarParam($dados);
                    return $dados->TOKEN;
                } else {
                    return null;
                }
            }    
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            return NULL;
        }

    }
    public function jobMonitoramento()
    {
        $this->inserirAuditoriaKlipbox('REQUEST-API-KLIPBOX-MONITORAMENTO', 'C', '');
        set_time_limit(0);
        $url = 'https://api.klipbox.com.br/v1/monitorings';
        try {
            $response = $this->requestApi(
                    $url,
                    $this->getHeader(),                    
                    'get'
                );

                $this->inserirAuditoriaKlipbox('ATUALIZAR-MONIT-API-KLIPBOX', 'C', json_encode($response)); 
            if (!empty($response)){
                foreach($response as $valor) {
                    // VALIDACAO... SE JA EXISTIR NA TABELA MONITORAMENTO
                    $seqMonitoramento = $this->IntegracaoModelo->getMonitoramento($valor->id)->row();
                    $dados = array(
                        "SEQ_MONITORAMENTO" =>  $valor->id,
                        "NOME_MONITORAMENTO" =>  $valor->name,
                        "TAGS_MONITORAMENTO"  =>  implode(',', $valor->terms)
                    );
                    // ATUALIZAR O NOME E OS TERMOS (O RETORNO DAS TAGS DEVEM SER CONVERTIDAS PARA STRING COM FUNCAO IMPLODE)
                    if (!empty($seqMonitoramento)) {
                        $this->IntegracaoModelo->alterar($dados, $valor->id);

                    } else {
                        // SE NAO EXISTIR, INSERIR OS DADOS NA TABELA MONITORAMENTO
                        $this->IntegracaoModelo->inserir($dados);
                    }
                }   
            } 
            $resultado = array(
                'status'=>'success',
                'mensagem'=>"showNotification('alert-success', 'Monitoramento atualizado com sucesso', 'bottom', 'center', 'animated fadeInUp', '')",
            );
        }catch(Exception $e){
            log_message('error', $e->getMessage());
            $resultado = array(
                'status'=>'error',
                'mensagem'=>"showNotification('alert-danger', 'Monitoramento nãopode se atualizado', 'bottom', 'center', 'animated fadeInUp', '')",
            );
        }    
        echo json_encode($resultado);
    }
    private function getHeader(){
        $this->inserirAuditoriaKlipbox('MONTAR-HEADER-API-KLIPBOX', 'C', '');
        $token = $this->autenticarApi();
        if (empty($token)){
            $token = $this->autenticarApi('autentica');
        }
        $parametros = array( 
            "Content-Type" => "application/json",
            "cache-control" => "no-cache",
            "Authorization" => "Bearer ".$token
        );
        return $parametros;
    }

    private function requestApi($url,$header,$metodo,$parametros=NULL){
        $this->inserirAuditoriaKlipbox('REQUEST-API-KLIPBOX', 'C', '');

        if ($metodo=='get'){
            $response = $this->unirest->get(
                $url, 
                $headers = $header
            );
        }else {
            $response = $this->unirest->post(
                $url, 
                $headers = $header, 
                $body = $parametros
            );
        }
        // Verifica se foi realizado com sucesso
        if ($response->code == 200) {
            return $response->body;
        } else {
            $this->inserirAuditoriaKlipbox('REQUEST-API-KLIPBOX-ERROR', 'C', $url.' - '.json_encode($response));
            return null;
        }
    }

}
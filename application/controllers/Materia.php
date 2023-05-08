<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
class Materia extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tipomateriaModelo', 'TipomateriaModelo');
        $this->load->model('materiaModelo', 'MateriaModelo');
        $this->load->model('veiculoModelo', 'VeiculoModelo');
        $this->load->model('setorModelo', 'SetorModelo');
        $this->load->model('releaseModelo', 'ReleaseModelo');
        $this->load->model('assuntoModelo', 'AssuntoModelo');
        $this->auth->CheckAuth('geral', $this->router->fetch_class(), $this->router->fetch_method());

    }
    
    public function filtro() {
        $dados = $_POST;
        if ($dados['btn'] == 'F') {
        if (empty($dados['termo']) && empty($dados['dataI']) && empty($dados['dataF']) && !isset($dados['tipoMat']) && !isset($dados['tipoClipador']) ) {
            $class = 'warning';
            $mensagem = 'SELECIONE UM FILTRO';
            $this->feedBack($class, $mensagem, 'materia');
            return;
        }
        
        $this->session->set_userdata('FILTROS', $dados);
        } else {
            unset($_SESSION['FILTROS']);
        }
        redirect('materia');
    }
    
    private function validaOperacao($target)
    {
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
    public function index()
    {
        $this->inserirAuditoria('CONSULTA-MATERIA', 'C', '');
        $this->loadUrl('modulos/materia/consultar');
    }
    private function acoes($row)
    {
        $resultado = '<div class="action-buttons" >';
        $habilitaBotaoDownEmail = !empty($row->SEQ_TIPO_MATERIA) AND !empty($row->SEQ_SETOR) and  !empty($row->IND_AVALIACAO) and !empty($row->IND_CLASSIFICACAO);
        if ($this->auth->CheckMenu('geral', 'materia', 'editar') == 1) {
            $resultado .= '<a id="btn-editar-item" data-toggle="tooltip" data-placement="top" title="Editar" class="btn bg-blue btn-circle-xm waves-effect waves-circle waves-float" href="' . base_url('materia/editar/') . $row->SEQ_MATERIA . '"><i class="material-icons">edit</i></a>&nbsp;&nbsp;';
        }
        if ($this->auth->CheckMenu('geral', 'materia', 'excluir') == 1) {
            $this->db->where('SEQ_USUARIO', $_SESSION['idUsuario']);
            $this->db->where('SEQ_PERFIL', 21);
            $perfil = $this->db->get('PERFIL_USUARIO')->row_array();
            if (empty($perfil)) {
                $resultado .= '<a id="btn-excluir-item" data-toggle="tooltip" data-placement="top" title="Excluir" class="btn bg-light-blue btn-circle-xm waves-effect waves-circle waves-float botao-excluir" data-url="' . base_url('materia/excluir/') . $row->SEQ_MATERIA . '"><i class="material-icons">delete</i></a>&nbsp;&nbsp;';
            }
        }
        if ($row->IND_STATUS == 'C' and $this->auth->CheckMenu('geral', 'materia', 'enviar') == 1) {
            $resultado .= '<a id="btn-enviar-item" data-toggle="tooltip" data-placement="top" title="Enviar ao Cliente" class="btn bg-light-blue btn-circle-xm waves-effect waves-circle waves-float botao-enviar" href="' . base_url('materia/enviar/') . $row->SEQ_MATERIA . '"><i class="material-icons">send</i></a>&nbsp;&nbsp;';
        }
        if ($habilitaBotaoDownEmail and $row->IND_STATUS == 'E' and $this->auth->CheckMenu('geral', 'materia', 'download') == 1) {
            $resultado .= '<a id="btn-down-item" data-toggle="tooltip" data-placement="top" title="Download da Matéria" class="btn bg-light-blue btn-circle-xm waves-effect waves-circle waves-float" href="' . base_url('materia/download/') . $row->SEQ_MATERIA . '"><i class="material-icons">file_download</i></a>&nbsp;&nbsp;';
        }
//        if ($habilitaBotaoDownEmail and $row->IND_STATUS == 'E' and $this->auth->CheckMenu('geral', 'materia', 'email')) {
//            $resultado .= '<a data-toggle="tooltip" data-placement="top" title="Enviar Matéria por Email" class="btn bg-light-blue btn-circle-xm waves-effect waves-circle waves-float" href="' . base_url('materia/email/') . $row->SEQ_MATERIA . '"><i class="material-icons">email</i></a>&nbsp;&nbsp;';
//        }
        if ($habilitaBotaoDownEmail and $row->SEQ_ASSUNTO_GERAL>0  and $this->auth->CheckMenu('geral', 'materia', 'ajaxShare')) {
            $resultado .= '<a id="btn-copia-item" data-toggle="tooltip" data-placement="top" title="Copiar Alerta para Temas de Interesse" class="btn bg-light-green btn-circle-xm waves-effect waves-circle waves-float copiaMensagem" data-url="' . base_url('materia/ajaxShare/ti/') . $row->SEQ_MATERIA . '"><i class="material-icons">share</i></a>&nbsp;&nbsp;';
        }
        if ($habilitaBotaoDownEmail and $this->auth->CheckMenu('geral', 'materia', 'ajaxShare')) {
            $resultado .= '<a id="btn-copia-item" data-toggle="tooltip" data-placement="top" title="Copiar para o Cliente" class="btn bg-light-blue btn-circle-xm waves-effect waves-circle waves-float copiaMensagem" data-url="' . base_url('materia/ajaxShare/nm/') . $row->SEQ_MATERIA . '"><i class="material-icons">share</i></a>&nbsp;&nbsp;';
        }
        $resultado .= '</div>';
        return $resultado;
    }
    public function consultar()
    {
        $fetch_data = $this->MateriaModelo->make_datatables();
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = (($row->IND_AVALIACAO=='N')? '<span class="badge bg-red">'.$row->SEQ_MATERIA.'</span>':$row->SEQ_MATERIA);
//                . '<button type="button" data-toggle="tooltip" data-placement="top" title="Copiar para o Cliente" class="btn bg-light-blue btn-circle-xm waves-effect waves-circle waves-float copiaMensagem" data-url="' . base_url('materia/ajaxShare/nm/') . $row->SEQ_MATERIA . '"><i class="material-icons">share</i></button>&nbsp;&nbsp;';
            if ($row->TIPO_MATERIA == 'I')
                $sub_array[] = 'Impresso';
            else if ($row->TIPO_MATERIA == 'S')
                $sub_array[] = 'Internet';
            else if ($row->TIPO_MATERIA == 'R')
                $sub_array[] = 'R&aacute;dio';
            else if ($row->TIPO_MATERIA == 'T')
                $sub_array[] = 'Televis&atilde;o';

            if ($row->TIPO_MATERIA == 'I')
                $sub_array[] = $row->FANTASIA_VEICULO;
            else if ($row->TIPO_MATERIA == 'S')
                $sub_array[] = $row->NOME_PORTAL;
            else if ($row->TIPO_MATERIA == 'R')
                $sub_array[] = $row->NOME_RADIO;
            else if ($row->TIPO_MATERIA == 'T')
                $sub_array[] = $row->NOME_TV;

            $sub_array[] = $row->DATA_MATERIA_PUB;

            if ($this->session->userData('perfilUsuario') != 'ROLE_REP') {
                $sub_array[] = $row->DESC_TIPO_MATERIA;
            }
            $sub_array[] = $this->ComumModelo->getUser($row->SEQ_USUARIO)->row()->NOME_USUARIO;
            $sub_array[] = $this->acoes($row);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->MateriaModelo->get_all_data(),
            "recordsFiltered" => $this->MateriaModelo->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }
    public function novoi($opcao = 'i')
    {
        $this->validaOperacao('materia');
        $clienteSessao = $this->session->userData('idClienteSessao');
        $status = 'C';
        if ($this->session->userData('perfilUsuario') == 'ROLE_CLI' or $this->session->userData('perfilUsuario') == 'ROLE_USU'
            or $this->session->userData('perfilUsuario') == 'ROLE_ADM'
        ) {
            $status = 'E';
        }
        $this->load->helper('date');
        //inserir materia
        $data = array(
            'SEQ_CLIENTE' => $clienteSessao,
            'SEQ_USUARIO' => $this->session->userdata('idUsuario'),
            'DATA_MATERIA_PUB' => date('Y-m-d',now('America/Manaus')),
            'DATA_PUB_NUMERO' => date('Ymd',now('America/Manaus')),
            'DATA_NUMERO' => date('YmdHi',now('America/Manaus')),
            'DATA_MATERIA_CAD' => date('Y-m-d H:i:s',now('America/Manaus')),
            'DATA_MATERIA_ALT' => date('Y-m-d H:i:s', now('America/Manaus')),
            'TIPO_MATERIA' => strtoupper($opcao),
            'IND_STATUS' => $status
        );
        $this->inserirAuditoria('INSERIR-MATERIA', 'I', json_encode($data));
        $idNew = $this->MateriaModelo->inserir($data);

        if ($idNew>0){
            redirect(base_url('materia/editar/' . $idNew));
        }else {
            $class = 'error';
            $mensagem = 'Matéria não Incluida!!';
            $this->feedBack($class, $mensagem, 'materia');
            return;
        }

    }
    public function novos($opcao = 's')
    {
        $this->validaOperacao('materia');
        $clienteSessao = $this->session->userData('idClienteSessao');
        $status = 'C';
        if ($this->session->userData('perfilUsuario') == 'ROLE_CLI' or $this->session->userData('perfilUsuario') == 'ROLE_USU'
            or $this->session->userData('perfilUsuario') == 'ROLE_ADM'
        ) {
            $status = 'E';
        }
        $this->load->helper('date');
        //inserir materia
        $data = array(
            'SEQ_CLIENTE' => $clienteSessao,
            'SEQ_USUARIO' => $this->session->userdata('idUsuario'),
            'DATA_MATERIA_PUB' => date('Y-m-d',now('America/Manaus')),
            'DATA_PUB_NUMERO' => date('Ymd',now('America/Manaus')),
            'DATA_NUMERO' => date('YmdHi',now('America/Manaus')),
            'DATA_MATERIA_CAD' => date('Y-m-d H:i:s',now('America/Manaus')),
            'DATA_MATERIA_ALT' => date('Y-m-d H:i:s', now('America/Manaus')),
            'TIPO_MATERIA' => strtoupper($opcao),
            'IND_STATUS' => $status
        );
        $this->inserirAuditoria('INSERIR-MATERIA', 'I', json_encode($data));
        $idNew = $this->MateriaModelo->inserir($data);

        if ($idNew>0){
            redirect(base_url('materia/editar/' . $idNew));
        }else {
            $class = 'error';
            $mensagem = 'Matéria não Incluida!!';
            $this->feedBack($class, $mensagem, 'materia');
            return;
        }

    }
    public function novor($opcao = 'r')
    {
        $this->validaOperacao('materia');
        $clienteSessao = $this->session->userData('idClienteSessao');
        $status = 'C';
        if ($this->session->userData('perfilUsuario') == 'ROLE_CLI' or $this->session->userData('perfilUsuario') == 'ROLE_USU'
            or $this->session->userData('perfilUsuario') == 'ROLE_ADM'
        ) {
            $status = 'E';
        }
        $this->load->helper('date');
        //inserir materia
        $data = array(
            'SEQ_CLIENTE' => $clienteSessao,
            'SEQ_USUARIO' => $this->session->userdata('idUsuario'),
            'DATA_MATERIA_PUB' => date('Y-m-d',now('America/Manaus')),
            'DATA_PUB_NUMERO' => date('Ymd',now('America/Manaus')),
            'DATA_NUMERO' => date('YmdHi',now('America/Manaus')),
            'DATA_MATERIA_CAD' => date('Y-m-d H:i:s',now('America/Manaus')),
            'DATA_MATERIA_ALT' => date('Y-m-d H:i:s', now('America/Manaus')),
            'TIPO_MATERIA' => strtoupper($opcao),
            'IND_STATUS' => $status
        );
        $this->inserirAuditoria('INSERIR-MATERIA', 'I', json_encode($data));
        $idNew = $this->MateriaModelo->inserir($data);
        if ($idNew>0){
            redirect(base_url('materia/editar/' . $idNew));
        }else {
            $class = 'error';
            $mensagem = 'Matéria não Incluida!!';
            $this->feedBack($class, $mensagem, 'materia');
            return;
        }
    }
    public function novot($opcao = 't')
    {
        $this->validaOperacao('materia');
        $clienteSessao = $this->session->userData('idClienteSessao');
        $status = 'C';
        if ($this->session->userData('perfilUsuario') == 'ROLE_CLI' or $this->session->userData('perfilUsuario') == 'ROLE_USU'
            or $this->session->userData('perfilUsuario') == 'ROLE_ADM'
        ) {
            $status = 'E';
        }
        $this->load->helper('date');
        //inserir materia
        $data = array(
            'SEQ_CLIENTE' => $clienteSessao,
            'SEQ_USUARIO' => $this->session->userdata('idUsuario'),
            'DATA_MATERIA_PUB' => date('Y-m-d',now('America/Manaus')),
            'DATA_PUB_NUMERO' => date('Ymd',now('America/Manaus')),
            'DATA_NUMERO' => date('YmdHi',now('America/Manaus')),
            'DATA_MATERIA_CAD' => date('Y-m-d H:i:s',now('America/Manaus')),
            'DATA_MATERIA_ALT' => date('Y-m-d H:i:s', now('America/Manaus')),
            'TIPO_MATERIA' => strtoupper($opcao),
            'IND_STATUS' => $status
        );
        $this->inserirAuditoria('INSERIR-MATERIA', 'I', json_encode($data));
        $idNew = $this->MateriaModelo->inserir($data);
        if ($idNew>0){
            redirect(base_url('materia/editar/' . $idNew));
        }else {
            $class = 'error';
            $mensagem = 'Matéria não Incluida!!';
            $this->feedBack($class, $mensagem, 'materia');
            return;
        }
    }
    public function editar($id=NULL)
    {
        
        if (empty($id)) {
            $class = 'warning';
            $mensagem = 'Por favor, selecione uma Matéria para editar!!';
            $this->feedBack($class, $mensagem, 'materia');
            return;

        }
        
        $materia = $this->MateriaModelo->editar($id);
        $this->session->set_userdata('idClienteSessao', $materia[0]['SEQ_CLIENTE']);
        if (empty($materia)) {
            $class = 'warning';
            $mensagem = 'Matéria não Localizada na nossa base de dados!!';
            $this->feedBack($class, $mensagem, 'materia');
            return;
        }

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
            $resultado['indPreso'] = $valor['IND_PRISAO'];
            $resultado['interior'] = $valor['CIDADES_INTERIOR'];
        }

        $resultado['lista_anexo'] = $this->MateriaModelo->listaAnexo($id);
        $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria();
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

        if ($resultado['tipoMateria'] == 'I') {
            $resultado['lista_preco'] = $this->VeiculoModelo->carregaPreco($resultado['veiculo'],$resultado['tipoMateria']);
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
            if (!empty($resultado['veiculo']))
                $resultado['logo_veiculo'] = $this->VeiculoModelo->getVeiculo($resultado['veiculo'])->row()->LOGO_VEICULO;
        } else if ($resultado['tipoMateria'] == 'S') {
            $resultado['lista_preco'] = $this->VeiculoModelo->carregaPreco($resultado['portal'],$resultado['tipoMateria']);

            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaPortalAtivo();
            if (!empty($resultado['portal']))
                $resultado['logo_veiculo'] = $this->VeiculoModelo->getPortal($resultado['portal'])->row()->LOGO_VEICULO;
        } else if ($resultado['tipoMateria'] == 'R') {
            $resultado['lista_preco'] = $this->VeiculoModelo->carregaPreco($resultado['radio'],$resultado['tipoMateria']);
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaRadio();
            if (!empty($resultado['radio']))
                $resultado['logo_veiculo'] = $this->VeiculoModelo->getRadio($resultado['radio'])->row()->LOGO_VEICULO;
        } else if ($resultado['tipoMateria'] == 'T') {
            $resultado['lista_preco'] = $this->VeiculoModelo->carregaPreco($resultado['tv'],$resultado['tipoMateria']);
            $resultado['lista_video'] = $this->listaArquivos();
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaTv();
            if (!empty($resultado['tv']))
                $resultado['logo_veiculo'] = $this->VeiculoModelo->getTv($resultado['tv'])->row()->LOGO_VEICULO;
        } else {
            $resultado['lista_veiculo'] = array();
        }
        $resultado['lista_setor'] = $this->SetorModelo->listaSetor();
        if ($resultado['tipoMateria'] == 'I') {
            if ($this->session->userData('perfilUsuario') == 'ROLE_REP') {
                $this->loadUrl('modulos/materia/editar-rep', $resultado);
            } else {
                $this->loadUrl('modulos/materia/editar', $resultado);
            }
        } else if ($resultado['tipoMateria'] == 'S') {
            if ($this->session->userData('perfilUsuario') == 'ROLE_REP') {
                $this->loadUrl('modulos/materia/editar-rep', $resultado);
            } else {
                $this->loadUrl('modulos/materia/editar', $resultado);
            }
        } else if ($resultado['tipoMateria'] == 'R') {
            if ($this->session->userData('perfilUsuario') == 'ROLE_REP') {
                $this->loadUrl('modulos/materia/editar-rep', $resultado);
            } else {
                $this->loadUrl('modulos/materia/editar', $resultado);
            }
        }
        else if ($resultado['tipoMateria'] == 'T') {
            if ($this->session->userData('perfilUsuario') == 'ROLE_REP') {
                $this->loadUrl('modulos/materia/editar-rep', $resultado);
            } else {
                $this->loadUrl('modulos/materia/editar', $resultado);
            }
        }

    }
    public function email($id)
    {
        $this->validaOperacao('materia');
        $materia = $this->MateriaModelo->editar($id);
        if (empty($materia)) {
            $class = 'warning';
            $mensagem = 'Matéria não Localizada na nossa base de dados!!';
            $this->feedBack($class, $mensagem, 'materia');
            return;
        }

        foreach ($materia as $index => $valor) {
            $resultado['idMateria'] = $id;
            $resultado['tipo'] = $valor['SEQ_TIPO_MATERIA'];
            $resultado['veiculo'] = $valor['SEQ_VEICULO'];
            $resultado['cliente'] = $valor['SEQ_CLIENTE'];
            $resultado['portal'] = $valor['SEQ_PORTAL'];
            $resultado['radio'] = $valor['SEQ_RADIO'];
            $resultado['setor'] = $valor['SEQ_SETOR'];
            $resultado['usuario'] = $valor['SEQ_USUARIO'];
            $resultado['titulo'] = $valor['TIT_MATERIA'];
            $resultado['palavra'] = $valor['PC_MATERIA'];
            $resultado['data'] = $valor['DATA_MATERIA_PUB'];
            $resultado['dataCad'] = $valor['DATA_MATERIA_CAD'];
            $resultado['texto'] = $valor['TEXTO_MATERIA'];
            $resultado['pagina'] = $valor['PAGINA_MATERIA'];
            $resultado['editorial'] = $valor['EDITORIA_MATERIA'];
            $resultado['destaque'] = $valor['DESTAQUE_MATERIA'];
            $resultado['autor'] = $valor['AUTOR_MATERIA'];
            $resultado['avaliacao'] = $valor['IND_AVALIACAO'];
            $resultado['classificacao'] = $valor['IND_CLASSIFICACAO'];
            $resultado['programa'] = $valor['PROGRAMA_MATERIA'];
            $resultado['apresentador'] = $valor['APRESENTADOR_MATERIA'];
            $resultado['tipoMateria'] = $valor['TIPO_MATERIA'];
            $resultado['analise'] = $valor['ANALISE_MATERIA'];
            $resultado['resumo'] = $valor['RESUMO_MATERIA'];
            $resultado['resposta'] = $valor['RESPOSTA_MATERIA'];
        }
        if (!empty($resultado['veiculo']))
            $resultado['logo_veiculo'] = $this->VeiculoModelo->getVeiculo($resultado['veiculo'])->row()->LOGO_VEICULO;
        if (!empty($resultado['portal']))
            $resultado['logo_veiculo'] = $this->VeiculoModelo->getPortal($resultado['portal'])->row()->LOGO_VEICULO;


        $this->loadUrl('modulos/materia/email', $resultado);

    }
    public function alterar($idMateria=NULL)
    {
        
        set_time_limit(0);
        if (empty($idMateria)) {
            $class = 'warning';
            $mensagem = 'Por favor, selecione uma Matéria para editar!!';
            $this->feedBack($class, $mensagem, 'materia');
            return;
        }


        $this->validaOperacao('materia/editar/' . $idMateria);
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
        if (!empty($this->input->post('link')) and $this->MateriaModelo->countLink($path,$query, $idMateria,$resultado) > 0) {
            $class = 'warning';
            $mensagem = 'Link para esssa Matéria já foi cadastrado!!';
            $this->feedBack($class, $mensagem, 'materia/editar/' . $idMateria);
            return;
        } else {
            $materiaAtual = $this->MateriaModelo->getMateria($idMateria)->row();
            $clienteSessao = $this->session->userData('idClienteSessao');
            $isDiferente = false;
            if ($this->input->post('idcliente')!=$clienteSessao){
                $isDiferente = !$isDiferente;
                $clienteSessao=$this->input->post('idcliente');

            }

            $cidades = NULL;
            if (is_array($this->input->post('interior'))){
                $cidades = implode($this->input->post('interior'),',');
            } else {
                $cidades = $this->input->post('interior');
            }
//            echo '<pre>';
//            print_r($cidades);
//            die();
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
                    'SEQ_USUARIO' => $materiaAtual->IND_STATUS == 'C' ? $this->session->userdata('idUsuario') : $materiaAtual->SEQ_USUARIO,
                    'SEQ_USUARIO_ALT' => $materiaAtual->IND_STATUS != 'C' ? $this->session->userdata('idUsuario') : NULL,
                    'TIT_MATERIA' => $this->input->post('titulo'),
                    'PC_MATERIA' => tirarAcentos($this->input->post('palavra')),
                    'DATA_MATERIA_PUB' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('data')))),
                    'DATA_PUB_NUMERO' => date('Ymd', strtotime(str_replace('/', '-', $this->input->post('data')))),
                    'DATA_MATERIA_ALT' => date('Y-m-d H:i:s', now('America/Manaus')),
                    'TEXTO_MATERIA' => strip_tags($this->input->post('texto'), '<p>'),
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
                    'LINK_MATERIA' => $this->input->post('link'),
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
                    'CIDADES_INTERIOR' => $cidades
                );

                $this->inserirAuditoria('ALTERAR-MATERIA', 'A', json_encode($this->input->post()));
                if (!empty($this->input->post('secretarias'))) {
                    foreach ($this->input->post('secretarias') as $sec) {
                        $this->db->insert('SECRETARIA_MATERIA', array(
                            'SEQ_MATERIA' => $idMateria,
                            'SEQ_SETOR' => $sec
                        ));
                    }
                }
                if (!$this->MateriaModelo->alterar($data, $idMateria)) {
                    $class = 'error';
                    $mensagem = 'Matéria não Alterada!!';
                    $this->feedBack($class, $mensagem, 'materia/editar/' . $idMateria);
                    return;
                } else {
                        if (($materiaAtual->TIPO_MATERIA=='T') and !empty($this->input->post('videos'))) {
                           // if( $this->session->userdata('idClienteSessao')==59 )
                             //   $diretorioOrigem = APPPATH_ELEICAO;
                            //else if( $this->session->userdata('idClienteSessao')==62 )
                              //  $diretorioOrigem = APPPATH_ELEICAO_BELEM;
                               // else
                                if( $this->session->userdata('idClienteSessao')==40 ) {
                                $diretorioOrigem = APPPATH_VIDEO_BOA_VISTA;    
                                } 
                                
                                else if ($this->session->userdata('idClienteSessao')== 5 ) {
                                $diretorioOrigem = APPPATH_GOVERNO_AM;        
                                }
                                else if ($this->session->userdata('idUsuario')==26 ) {
                                $diretorioOrigem = APPPATH_VIDEO_MISAEL;        
                                } else if ($this->session->userdata('idUsuario')==154 ) {
                                $diretorioOrigem = APPPATH_VIDEO_SIMONE;      
                                } else if ($this->session->userdata('idUsuario')==141 ) {
                                $diretorioOrigem = APPPATH_VIDEO_THALLITA;          
                                } else if ($this->session->userdata('idUsuario')==121 ) {
                                $diretorioOrigem = APPPATH_VIDEO_WILLIAM;              
                                } else if ($this->session->userdata('idUsuario')==38 ) {
                                $diretorioOrigem = APPPATH_VIDEO_SIMONE;         
                                } else if ($this->session->userdata('idUsuario')==171 ) {
                                $diretorioOrigem = APPPATH_VIDEO_RAMON;    
                                } else if ($this->session->userdata('idUsuario')==163 ) {
                                $diretorioOrigem = APPPATH_VIDEO_RONALDO;    
                                } else if ($this->session->userdata('idUsuario')==176 ) {
                                $diretorioOrigem = APPPATH_VIDEO_WALLACE;    
                                } else if ($this->session->userdata('idUsuario')==173 ) {
                                $diretorioOrigem = APPPATH_VIDEO_LEONARDO;    
                                } 
                                else if ($this->session->userdata('idUsuario')==178 ) {
                                $diretorioOrigem = APPPATH_VIDEO_WILLIAM_SANTEIRO;    
                                }
                                else if ($this->session->userdata('idUsuario')==194 ) {
                                $diretorioOrigem = APPPATH_VIDEO_YASMIM;    
                                }
                                else if ($this->session->userdata('idUsuario')==155 ) {
                                $diretorioOrigem = APPPATH_VIDEO_CAROLINA;    
                                }
                                else if ($this->session->userdata('idUsuario')==142 ) {
                                $diretorioOrigem = APPPATH_VIDEO_RAQUEL;    
                                }
                                else if ($this->session->userdata('idUsuario')==201 ) {
                                $diretorioOrigem = APPPATH_VIDEO_EZEQUIAS;    
                                }
                                else {
                                $diretorioOrigem = APPPATH_VIDEO;
                                }                                
                                
                                
                            // if($this->session->userdata('idClienteSessao')!=3 and $this->session->userdata('idClienteSessao')!=13)
                            //     $diretorioOrigem = APPPATH_VIDEO;
                            // else if($this->session->userdata('idClienteSessao')==62)
                            //     $diretorioOrigem = APPPATH_ELEICAO_BELEM;
                            // else
                            //     $diretorioOrigem = APPPATH_ELEICAO;

                            $diretorioDest = APPPATH_MATERIA . $idMateria;

                            $url = base_url()."materia/copiaVideo/".$idMateria;

                            $param = array('diretorioOrigem' => $diretorioOrigem,
                                "diretorioDest"=>$diretorioDest,
                                "videos"=>$this->input->post('videos')
                            );
                            
                            //$ac = $this->asynctask->do_in_background($url, $param);
                            $ac = $this->copiaVideo2($idMateria, $param);
                        }
                }
                $class = 'success';
                $mensagem = 'Matéria Alterado com sucesso!!';
            } else{
                $class = 'warning';
                $mensagem = 'No Momento não podemos alterar sua Matéria Alterado, tente novamente!!';
            }
            if (!empty($clienteSessao) and $clienteSessao != $this->session->userData('idClienteSessao')){

                $clienteTema = $this->ComumModelo->getTableData('CLIENTE', array('SEQ_CLIENTE' => $clienteSessao))->row()->TEMA_CLIENTE;
                if(!empty($clienteTema)){
                    $dataSessao= array('idClienteSessao'=>'','temaClienteSessao'=>'');
                    $this->session->unset_userdata($dataSessao);
                    $dataSessaoNova= array('idClienteSessao'=>$clienteSessao,'eSelecao'=>false,'temaClienteSessao'=>$clienteTema);
                    $this->session->set_userdata($dataSessaoNova);
                }
            }
        }

        if ($this->input->post('acao') == 'S')
            $this->feedBack($class, $mensagem, 'materia');
        else
            redirect(base_url('materia/editar/' . $idMateria));
    }
    public function copiaVideo2($idMateria=NULL, $dados)
    {
        set_time_limit(0);
        extract($dados);

        if (!is_dir($diretorioDest)) {
            mkdir($diretorioDest, 0777, true);
        }
        foreach ($videos as $video) {

            $file_type = mime_content_type($diretorioOrigem . $video);
            $ext = strtolower(pathinfo($diretorioOrigem . $video, PATHINFO_EXTENSION));
            $file_name = uniqid() . '.' . $ext;

            $ordemAnexo = $this->MateriaModelo->getOrdem($idMateria);
            $dataAnexo = array(
                'SEQ_MATERIA' => $idMateria,
                'NOME_ARQUIVO' => $video,
                'NOME_BIN_ARQUIVO' => $file_name,
                'CONTT_ARQUIVO' => $file_type,
                'ORDEM_ARQUIVO' => $ordemAnexo++
            );
            $newAnexo = $this->MateriaModelo->inserirAnexo($dataAnexo);

            if (!empty($newAnexo) and !copy($diretorioOrigem . $video, $diretorioDest .'/'. $file_name) ) {
                log_message('error','Sucesso ao copiar video, de: '.$diretorioOrigem . $video.', para: '.$diretorioDest.$file_name);
            } else{
                log_message('error','Erro ao copiar video, de: '.$diretorioOrigem . $video.', para: '.$diretorioDest.$file_name);
            }
            if (!empty($newAnexo)){
                $dataAudio = getId3v2($idMateria . '/' . $file_name);
                $this->MateriaModelo->alterarAnexo($dataAudio, $newAnexo);
            }
        }
    }
    public function copiaVideo($idMateria=NULL)
    {
        set_time_limit(0);
        extract($this->input->post());

        if (!is_dir($diretorioDest)) {
            mkdir($diretorioDest, 0777, true);
        }
        foreach ($videos as $video) {

            $file_type = mime_content_type($diretorioOrigem . $video);
            $ext = strtolower(pathinfo($diretorioOrigem . $video, PATHINFO_EXTENSION));
            $file_name = uniqid() . '.' . $ext;

            $ordemAnexo = $this->MateriaModelo->getOrdem($idMateria);
            $dataAnexo = array(
                'SEQ_MATERIA' => $idMateria,
                'NOME_ARQUIVO' => $video,
                'NOME_BIN_ARQUIVO' => $file_name,
                'CONTT_ARQUIVO' => $file_type,
                'ORDEM_ARQUIVO' => $ordemAnexo++
            );
            $newAnexo = $this->MateriaModelo->inserirAnexo($dataAnexo);
            if (!empty($newAnexo) and !copy($diretorioOrigem . $video, $diretorioDest .'/'. $file_name) ) {
                log_message('error','Sucesso ao copiar video, de: '.$diretorioOrigem . $video.', para: '.$diretorioDest.$file_name);
            } else{
                log_message('error','Erro ao copiar video, de: '.$diretorioOrigem . $video.', para: '.$diretorioDest.$file_name);
            }
            if (!empty($newAnexo)){
                $dataAudio = getId3v2($idMateria . '/' . $file_name);
                $this->MateriaModelo->alterarAnexo($dataAudio, $newAnexo);
            }
        }
    }
    public function excluir($id)
    {

        $this->validaOperacao('materia');
        $this->inserirAuditoria('EXCLUIR-MATERIA', 'E', 'MateriaId: ' . $id);
        $dataMateria = $this->MateriaModelo->getMateria($id)->row();

        if (!empty($dataMateria) and
            (   ($dataMateria->SEQ_USUARIO==$this->session->userdata('idUsuario')) or
                ($this->session->userdata('perfilUsuario')=='ROLE_ADM') or
                ($this->session->userdata('idUsuario')==7) or
                ($this->session->userdata('idUsuario')==20) or
                ($this->session->userdata('idUsuario')==60) or
                ($this->session->userdata('idUsuario')==30)
            )
            and $this->MateriaModelo->deletar($id)) {
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
        $this->feedBack($class, $mensagem, 'materia');
    }
    public function enviar($idMateria)
    {

        $this->validaOperacao('materia');

        $data = array(
            'IND_STATUS' => 'E'
        );

        $this->inserirAuditoria('ALTERAR-MATERIA-ENVIAR', 'A', json_encode($data));

        $totalAnexos = count($this->MateriaModelo->listaAnexo($idMateria));
        if ($totalAnexos > 0) {
            ;

            if (!$this->MateriaModelo->alterar($data, $idMateria)) {
                $class = 'error';
                $mensagem = 'Matéria Não Enviada!';
            } else {
                $class = 'success';
                $mensagem = 'Matéria Enviada com sucesso!!';
            }
        } else {
            $class = 'warning';
            $mensagem = 'Matéria Não pode ser Enviada sem Imagem em anexo!';
        }
        $this->feedBack($class, $mensagem, 'materia');
    }
    public function download($idMateria, $pathArquivo = NULL)
    {
        $this->validaOperacao('materia');
        $this->inserirAuditoria('DOWNLOAD-MATERIA', 'A', 'formJson:' . json_encode($this->input->post()));
        $listaItem = $this->MateriaModelo->getMateria($idMateria)->row();

        $resultado['cliente'] = $listaItem->SEQ_CLIENTE;
        $resultado['titulo'] = $listaItem->TIT_MATERIA;
        $resultado['dataPub'] = $listaItem->DATA_MATERIA_PUB;
        $resultado['palavras'] = $listaItem->PC_MATERIA;
        $resultado['veiculo'] = $listaItem->SEQ_VEICULO;
        $resultado['portal'] = $listaItem->SEQ_PORTAL;
        $resultado['radio'] = $listaItem->SEQ_RADIO;
        $resultado['tv'] = $listaItem->SEQ_TV;
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
        $resultado['analise'] = $listaItem->ANALISE_MATERIA;
        $resultado['resumo'] = $listaItem->RESUMO_MATERIA;
        $resultado['resposta'] = $listaItem->RESPOSTA_MATERIA;
//        $resultado['anexos']=$this->MateriaModelo->listaAnexo($idMateria);

        //descomentar para exibir no navegador
//        $html = $this->load->view('modulos/materia/arquivo', $resultado);

        $this->load->library('pdf');
        $html = $this->load->view('modulos/materia/arquivo-imagem', $resultado, true);
        $pdf = $this->pdf->load();
        $html = $html;
//        $pdf->showImageErrors = true;
        $pdf->WriteHTML($html);
        $pdf->charset_in = 'UTF-8';
        if (empty($pathArquivo)) {
            $pdf->Output((date('dmY', strtotime($listaItem->DATA_MATERIA_PUB))) . 'clip' . $idMateria . '.pdf', 'D');
        } else {
            $pdf->Output($pathArquivo . (date('dmY', strtotime($listaItem->DATA_MATERIA_PUB))) . 'clip' . $idMateria . '.pdf', 'F');
        }
    }
    public function imagem($id)
    {

        $anexo = $this->MateriaModelo->getAnexo($id)->row();

        $arquivo = APPPATH_MATERIA. $anexo->SEQ_MATERIA . '/' . $anexo->NOME_BIN_ARQUIVO;

        header("Content-type: " . $anexo->CONTT_ARQUIVO);
        readfile($arquivo);

    }
    public function audio($id)
    {

        $anexo = $this->MateriaModelo->getAnexo($id)->row();

        $arquivo = APPPATH_MATERIA . $anexo->SEQ_MATERIA . '/' . $anexo->NOME_BIN_ARQUIVO;

//        $this->load->library('stream');

        $videoStream = $this->stream->load($arquivo);

        $videoStream->start();


//        readfile($arquivo);

    }
    public function enviarEmail()
    {
        $this->validaOperacao('materia');

        set_time_limit(0);

        extract($this->input->post());

        $this->inserirAuditoria('ENVIAR-MATERIA-EMAIL', 'I', json_encode($this->input->post()));

        $listaTo = explode(";", $emailTo);

        try {

            $diretorio = "assets/uploads/email/cli/" . $idMateria . '/';
            $listaItem = $this->MateriaModelo->getMateria($idMateria)->row();
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0777, true);
            }
            $pathFinal = $diretorio . (date('dmY', strtotime($listaItem->DATA_MATERIA_PUB))) . 'clip' . $idMateria . '.pdf';

            $this->download($idMateria, $diretorio);

            $arquivoArray = array($pathFinal);
            $listaTo_str = implode(",", $listaTo);
            $this->notificar($listaTo_str, $assunto, $mensagem, $arquivoArray, 'MATERIA', $idMateria);
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
        $this->feedBack($class, $mensagem, 'materia');
    }
    public function deleteanexo($idMateria, $id)
    {

        $this->validaOperacao('materia/editar/' . $idMateria);

        $this->inserirAuditoria('DELETAR-ANEXO-MATERIA', 'A', 'idAnexo: ' . $id);

        $anexo = $this->MateriaModelo->getAnexo($id)->row();

        $diretorio = APPPATH_MATERIA. $idMateria . '/' . $anexo->NOME_BIN_ARQUIVO;


        if (!$this->MateriaModelo->deletarAnexoBySeq($id)) {
            $class = 'error';
            $mensagem = 'Imagem  Não Excluída!';
        } else {
            if (file_exists($diretorio))
                unlink($diretorio);
            $class = 'success';
            $mensagem = 'Imagem Excluída com sucesso!!';
        }
        $this->feedBack($class, $mensagem, 'materia/editar/' . $idMateria);
    }
    public function ordenar($id, $ordem)
    {
        $data = array(
            'ORDEM_ARQUIVO' => $ordem
        );
        $this->MateriaModelo->alterarAnexo($data, $id);
        $idMateria = $this->MateriaModelo->getAnexo($id)->row()->SEQ_MATERIA;
        $materiaAtual = $this->MateriaModelo->getMateria($idMateria)->row();
        $resultado['lista_anexo'] = $this->MateriaModelo->listaAnexo($idMateria);
        $resultado['tipoMateria'] = $materiaAtual->TIPO_MATERIA;
        $this->load->view('modulos/materia/anexos', $resultado);
    }
    public function existeLink($id = NULL)
    {
        extract($this->input->post());
        $this->inserirAuditoria('VERIFICA-LINK', 'I', 'formJson:' . json_encode($this->input->post()));

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

//            $host = str_replace("www.","",trim($urlParser["host"]));
            $path = rtrim(trim($urlParser["path"]),"/");
            $query=NULL;
            if(!empty($urlParser["query"]))
            $query = trim($urlParser["query"]);


            if ($this->MateriaModelo->countLink($path,$query, $id,$resultado) > 0) {
                echo 'existe';
            } else {
                echo 'sucesso';
            }

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            http_response_code(400);
        }

    }
    public function detalhar($idMateria)
    {
        $this->validaOperacao('materia');
        $this->inserirAuditoria('VISUALIZAR-MATERIA', 'A', 'formJson:' . json_encode($this->input->post()));
        $listaItem = $this->MateriaModelo->getMateria($idMateria)->row();

        $resultado['cliente'] = $listaItem->SEQ_CLIENTE;
        $resultado['titulo'] = $listaItem->TIT_MATERIA;
        $resultado['dataPub'] = $listaItem->DATA_MATERIA_PUB;
        $resultado['palavras'] = $listaItem->PC_MATERIA;
        $resultado['veiculo'] = $listaItem->SEQ_VEICULO;
        $resultado['portal'] = $listaItem->SEQ_PORTAL;
        $resultado['radio'] = $listaItem->SEQ_RADIO;
        $resultado['tv'] = $listaItem->SEQ_TV;
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
        $resultado['release'] = $listaItem->SEQ_RELEASE;

        //descomentar para exibir no navegador
        $this->load->view('modulos/materia/arquivo-view', $resultado);
    }

    public function getConteudoUrl($idPortal=NULL)
    {
        set_time_limit(0);

        extract($this->input->post());
        $nomeFuncao = '';
        if (!empty($idPortal))
            $nomeFuncao = $this->VeiculoModelo->getPortal($idPortal)->row()->FUNCAO_PORTAL;
       
        if (in_array($nomeFuncao,array('bncAmazonas')))
            $htmlResp = $this->curl_get4($url);
        else if (in_array($nomeFuncao,array('amazonas1','gazetaAmazonas')))
            $htmlResp = $this->curl_get3($url);
        else if (in_array($nomeFuncao,array('onJornal')))
            $htmlResp = $this->curl_get2($url);
        else
           
            $htmlResp = $this->curl_get($url);
//        echo ();
//        $htmlResp  =  $this->dom_parser->str_get_html($html);

        if (!empty($nomeFuncao) and !empty($idPortal)) {
            switch ($nomeFuncao) {
                case 'portalHolanda':
                    echo $this->portalHolanda($htmlResp);
                    break;
                case 'portalMarcosSantos':
                    echo $this->portalMarcosSantos($htmlResp);
                    break;
                case 'radarAmazonico':
                    echo $this->radarAmazonico($htmlResp);
                    break;
                case 'fatoAmazonico':
                    echo $this->fatoAmazonico($htmlResp);
                    break;
                case 'amazonasAtual':
                    echo $this->amazonasAtual($htmlResp);
                    break;
                case 'manausAlerta':
                    echo $this->manausAlerta($htmlResp);
                    break;
                case 'amPost':
                    echo $this->amPost($htmlResp);
                    break;
                case 'blogAmazonia':
                    echo $this->blogAmazonia($htmlResp);
                    break;
                case 'banzeiroNews':
                    echo $this->banzeiroNews($htmlResp);
                    break;
                case 'portalFlagrante':
                    echo $this->portalFlagrante($htmlResp);
                    break;
                case 'portalGeneroso':
                    echo $this->portalGeneroso($htmlResp);
                    break;
                case 'blogFloresta':
                    echo $this->blogFloresta($htmlResp);
                    break;
                case 'amazonas1':
                    echo $this->amazonas1($htmlResp);
                    break;
                case 'roteiroNoticia':
                    echo $this->roteiroNoticia($htmlResp);
                    break;
                case 'todaHora':
                    echo $this->todaHora($htmlResp);
                    break;
                case 'portalZacarias':
                    echo $this->portalZacarias($htmlResp);
                    break;
                case 'bncAmazonas':
                    echo $this->bncAmazonas($htmlResp);
                    break;
                case 'agenciaNorte':
                    echo $this->agenciaNorte($htmlResp);
                    break;
                case 'parintinsAmazonas':
                    echo $this->parintinsAmazonas($htmlResp);
                    break;
                case 'blogHielLevy':
                    echo $this->blogHielLevy($htmlResp);
                    break;
                case 'portalHolofote':
                    echo $this->portalHolofote($htmlResp);
                    break;
                case 'tribunaAmazonas':
                    echo $this->tribunaAmazonas($htmlResp);
                    break;
                case 'portalDoAmazonas':
                    echo $this->portalDoAmazonas($htmlResp);
                    break;
                case 'portalCm7':
                    echo $this->portalCm7($htmlResp);
                    break;
                case 'deAmazonas':
                    echo $this->deAmazonas($htmlResp);
                    break;
                case 'blogMarcellMota':
                    echo $this->blogMarcellMota($htmlResp);
                    break;
                case 'blogMarioAdolfo':
                    echo $this->blogMarioAdolfo($htmlResp);
                    break;
                case 'gazetaAmazonas':
                    echo $this->gazetaAmazonas($htmlResp);
                    break;
                case 'amazonasAgora':
                    echo $this->amazonasAgora($htmlResp);
                    break;
                case 'correioAmazonia':
                    echo $this->correioAmazonia($htmlResp);
                    break;
                case 'portalAtualizado':
                    echo $this->portalAtualizado($htmlResp);
                    break;
                case 'portalLobao':
                    echo $this->portalLobao($htmlResp);
                    break;
                case 'onJornal':
                    echo $this->onJornal($htmlResp);
                    break;
                case 'portalJota':
                    echo $this->portalJota($htmlResp);
                    break;
                case 'osTucumaes':
                    echo $this->osTucumaes($htmlResp);
                    break;
                case 'conteudoAm':
                    echo $this->conteudoAm($htmlResp);
                    break;
                case 'portalUnico':
                    echo $this->portalUnico($htmlResp);
                    break;
                case 'blogGilbertoMarcal':
                    echo $this->blogGilbertoMarcal($htmlResp);
                    break;
                case 'portalNatan':
                    echo $this->portalNatan($htmlResp);
                    break;
                case 'agoraAmazonas':
                    echo $this->agoraAmazonas($htmlResp);
                    break;
                case 'culturaAmazonica':
                    echo $this->culturaAmazonica($htmlResp);
                    break;
                case 'chumboGrosso':
                    echo $this->chumboGrosso($htmlResp);
                    break;
                case 'aCritica':
                    echo $this->aCritica($htmlResp);
                    break;
                case 'amazonasNoticias':
                    echo $this->amazonasNoticias($htmlResp);
                    break;
                case 'emTempo':
                    echo $this->emTempo($htmlResp);
                    break;
                case 'g1Amazonas':
                    echo $this->g1Amazonas($htmlResp);
                    break;

                case 'nossoShowAm':
                    echo $this->nossoShowAm($htmlResp);
                    break;
                case 'olaSalveSalve':
                    echo $this->olaSalveSalve($htmlResp);
                    break;
                case 'issoEAmazonas':
                    echo $this->issoEAmazonas($htmlResp);
                    break;
                case 'portalManaos':
                    echo $this->portalManaos($htmlResp);
                    break;
                case 'amazonPlayTV':
                    echo $this->amazonPlayTV($htmlResp);
                    break;
                case 'd24Am':
                    echo $this->d24Am($htmlResp);
                    break;
                case 'portalCaboco':
                    echo $this->portalCaboco($htmlResp);
                    break;

                default:
                    echo 'Nao foi possivel extrair o conteudo do site';
            }

        } else {
            echo '';
        }
    }
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
        $htmlResp = $this->removeDomNodes($htmlResp, '//meta',$isDecode);

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
                $element->find('.jeg_post_tags')->remove();
                $element->find('.td-post-featured-image')->remove();
//                $element->find('.heateor_sss_sharing_container')->remove();
                $element->find('.jaw-banner')->remove();
                $element->find('.rmp-main')->remove();
                $element->find('.wp-caption-text')->remove();
                $element->find('.SandboxRoot')->remove();
                $element->find('.content-ads')->remove();
                $element->find("div[class='corpo']")->remove();
//                $element->find('.titulo > a')->remove();
            } else {
                $element->find('.twitter-tweet')->remove();
                $element->find('#legenda')->remove();
                $element->find('.banner-marcos-santos')->remove();
                $element->find('.Apple-converted-space')->parent()->remove();
                $element->find('figure')->remove();
                $element->find('.jeg_ad_article')->remove();
                $element->find('.barra')->remove();
                $element->find('.epigraph')->remove();
                $element->find('.jeg_post_tags')->remove();
                $element->find('.td-post-featured-image')->remove();
                $element->find('.heateor_sss_sharing_container')->remove();
                $element->find('#fb-root')->remove();
                $element->find('.fb-post')->remove();
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
                or preg_match('/A qualquer momento mais/', $linha)
                or preg_match('/IMAGEM:/', $linha);
                break;
            case 'portalMarcosSantos':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/IMAGEM:/', $linha);
                break;
            case 'radarAmazonico':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/IMAGEM:/', $linha);
                break;
            case 'fatoAmazonico':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/IMAGEM:/', $linha);
                break;
            case 'amazonasAtual':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/IMAGEM:/', $linha);
                break;
            case 'manausAlerta':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/IMAGEM:/', $linha);
                break;
            case 'amPost':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/IMAGEM:/', $linha)
                or preg_match('/A qualquer momento mais/', $linha)
                or preg_match('/LEIA O PROJETO COMPLETO AQUI/', $linha);
                break;
            case 'portalZacarias':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/IMAGENS FORTES/', $linha)
                or preg_match('/A qualquer momento mais/', $linha)
                or preg_match('/Curtiu?/', $linha)
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
            case 'issoEAmazonas':
                return preg_match('/ Foto: /', $linha)
                or preg_match('/Foto: /', $linha)
                or preg_match('/imagens: /',  strtolower($linha))
                or preg_match('/Informacoes:/', ($this->retira_acentos($linha)))
                or preg_match('/Leia mais/', $linha)
                or substr($linha,1,6)=='Coment';
            default:
                return false;
        }
    }
    function retira_acentos($texto){
        return strtr($texto, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC");
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
    private function getObjeto2($document,$init,$site=''){
        $element = pq($init,$document);
        return $element;
    }
    private function resposta ($titulo,$conteudo){

        return json_encode(array(
            'titulo'=>trim($titulo),
            'conteudo'=>trim($conteudo)
        ));

    }
    private function portalHolanda($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div[class="corpo"]');
        $elementTitulo = $this->getObjeto($document,'title');
        $titulo = $elementTitulo->text();
        
        $result = '';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalHolanda',$item->textContent)) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,str_replace('&nbsp;','',$result));
    }
    private function portalMarcosSantos($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto($document,'#single-principal');
        $elementTitulo = $this->getObjeto($document,'.titulo');
        $titulo = $elementTitulo->text();

        $result = '';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and strlen($item->textContent)!=2 and !$this->limparLinha('portalMarcosSantos',$item->textContent)) {
                $result .= preg_replace("/\r?\n/","",$item->textContent) . $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function radarAmazonico($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto($document,'article');
        $elementTitulo = $this->getObjeto($document,' header .blog-post-title');
        $titulo = $elementTitulo->text();

        $result = '';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and strlen($item->textContent)!=2 and !$this->limparLinha('radarAmazonico',$item->textContent)) {
                $result .= preg_replace("/\r?\n/","",$item->textContent) . $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function amazonasAtual($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto($document,'.content-inner');
        $elementTitulo = $this->getObjeto($document,' div.entry-header > .jeg_post_title');
        $titulo = $elementTitulo->text();

        $result = '';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('amazonasAtual',$item->textContent)) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function fatoAmazonico($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto($document,'.td-post-content');
        $elementTitulo = $this->getObjeto($document,' header .entry-title');
        $titulo = $elementTitulo->text();

        $result = '';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('fatoAmazonico',$item->textContent)) {
                $result .= preg_replace("/\r?\n/","",$item->textContent) . $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function manausAlerta($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto($document,'.td-post-content');
        $elementTitulo = $this->getObjeto($document,' header .entry-title');
        $titulo = $elementTitulo->text();

        $result = '';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent)  and !$this->limparLinha('manausAlerta',$item->textContent)) {
                $result .= preg_replace("/\r?\n/","",$item->textContent) . $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function amPost($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'#post-content');
        $elementTitulo = $this->getObjeto($document,' #post-page-title > h2');
        $titulo = $elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('amPost',$item->textContent)) {
                $result .= preg_replace("/\r?\n/","",$item->textContent) . $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function blogAmazonia($htmlResp1)
    {
        header('content-type text/html charset=utf-8');

        $document1 = $this->criaObjeto($htmlResp1);

        $elementIframe = $this->getObjeto($document1,'iframe#TPAMultiSection_jx65toegiframe');

        $urlIframe = $elementIframe->attr('src');

        $htmlResp = $this->curl_get($urlIframe);
        $document = $this->criaObjeto($htmlResp);


//        $elementConteudo = $this->getObjeto($document,'#comp-j4e58yhx_SinglePostMediaTop_MediaPost__0_0__type_MediaPost');
//        $elementTitulo = $this->getObjeto($document,'#content-wrapper > div > div.cSnEi > div:nth-child(2) > div > div:nth-child(1) > article > div > div:nth-child(1) > div._zLbN._1szKo > h1 > span > span');

        $elementConteudo = $this->getObjeto($document,'article > div > div._3uWjK > article > div');
        $elementTitulo = $this->getObjeto($document,'article > div > div:nth-child(1) > div._zLbN._1szKo > h1 > span > span');

        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('blogAmazonia',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent) . $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function banzeiroNews($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto($document,'article .entry-content');
        $elementTitulo = $this->getObjeto($document,'header h1.entry-title');
        $titulo = $elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('banzeiroNews',$item->textContent) and strlen(($item->textContent))>2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent) . $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalFlagrante($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto($document,'div.ae-element-post-content');
        $elementTitulo = $this->getObjeto($document,'h1.elementor-heading-title');
        $titulo = $elementTitulo->find('h1')->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalFlagrante',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent) . $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalGeneroso($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'.entry-content');
        $elementTitulo = $this->getObjeto($document,'header > h1');
        $titulo = $elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalGeneroso',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));

    }
    public function blogFloresta($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'.td-post-content');
        $elementTitulo = $this->getObjeto($document,'header > h1');
        $titulo = $elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('blogFloresta',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    public function amazonas1($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'.entry-content-single');
        $elementConteudo->html(str_replace('</div>','</p>',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<div','<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<span','<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</span>','</p>',$elementConteudo->html()));

        $elementTitulo = $this->getObjeto($document,'h1.single-title');
        $titulo = $elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('amazonas1',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    public function roteiroNoticia($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.entry-content');
        $elementTitulo = $this->getObjeto($document,'header h1.entry-title');
        $titulo = $elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('roteiroNoticia',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    public function todaHora($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.contenido-nota');
        $elementTitulo = $this->getObjeto($document,'.article-title > h1');
        $titulo = $elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('todaHora',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta($titulo,html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalZacarias($htmlResp)
    {
        header('content-type text/html charset=utf-8');
        $document = $this->criaObjeto($htmlResp,'N');
        $elementConteudo = $this->getObjeto($document,'#corpo');
        $elementTitulo = $this->getObjeto($document,'.barra-verde > h1');
        $titulo = $elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalZacarias',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(utf8_decode($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function bncAmazonas($htmlResp)
    {

        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto2($document,'article aside');
        $elementConteudo2 =  $elementConteudo->eq(0);
        $elementTitulo = $this->getObjeto2($document,'article h1.text-left');
        $titulo =$elementTitulo->eq(0)->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('bncAmazonas',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function agenciaNorte($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'.itemFullText');
        $elementConteudo->html(str_replace('</div>','</p>',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<div','<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</header>','</p>',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<header','<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</span>','</p>',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<span','<p',$elementConteudo->html()));
        $elementTitulo = $this->getObjeto($document,'div.itemHeader > h2.itemTitle');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('agenciaNorte',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function parintinsAmazonas($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'#noticia');
        $elementTitulo = $this->getObjeto($document,'div.lendo > h1');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('parintinsAmazonas',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function blogHielLevy($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div[data-widget_type=theme-post-content.default]');
        $elementTitulo = $this->getObjeto($document,'h1.elementor-heading-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('blogHielLevy',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalHolofote($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.texto');
        $elementTitulo = $this->getObjeto($document,'h1.titulo');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalHolofote',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function tribunaAmazonas($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.more-text');
        $elementTitulo = $this->getObjeto($document,'h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('tribunaAmazonas',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalDoAmazonas($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'#the-post');
        $elementTitulo = $this->getObjeto($document,'h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalDoAmazonas',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalCm7($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'main div.post-content');
        $elementTitulo = $this->getObjeto($document,'main h1.post-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalCm7',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function deAmazonas($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.leitura');
        $elementTitulo = $this->getObjeto($document,'div.leitura >h1');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('deAmazonas',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function blogMarcellMota($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'article .entry-content');
        $elementTitulo = $this->getObjeto($document,'h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('blogMarcellMota',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function blogMarioAdolfo($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.editor-content');
        $elementTitulo = $this->getObjeto($document,'h1.post-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('blogMarioAdolfo',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function gazetaAmazonas($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'#main .entry');
        $elementTitulo = $this->getObjeto($document,'#main > div.post >h1');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('gazetaAmazonas',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(utf8_decode($titulo),utf8_decode(str_replace('&nbsp;','',$result)));
    }

    private function amazonasAgora($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'#main div.entry-content');
        $elementTitulo = $this->getObjeto($document,'h1.single-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('amazonasAgora',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function correioAmazonia($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'article div.td-post-content');
        $elementTitulo = $this->getObjeto($document,'header > h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('correioAmazonia',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),(str_replace('&nbsp;','',$result)));
    }

    private function portalAtualizado($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.conteudo-materia');
        $elementTitulo = $this->getObjeto($document,'div.titulo-materia > h1');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalAtualizado',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function portalLobao($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.entry-content');
        $elementTitulo = $this->getObjeto($document,'header h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalLobao',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function onJornal($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.td-post-content');
        $elementTitulo = $this->getObjeto($document,'div.td-post-header > header > h1');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('onJornal',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalJota($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'article > div.entry-content');
        $elementConteudo->html(str_replace('</div>','</p>',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<div','<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<span','<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</span>','</p>',$elementConteudo->html()));


        $elementTitulo = $this->getObjeto($document,'div.post-head > h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalJota',$item->textContent) and strlen(($item->textContent))>2 and strlen(($item->textContent))!=3) {
                $result .= preg_replace("/\r?\n/","",$item->textContent).$this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }



    private function osTucumaes($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.td-post-content');
        $elementTitulo = $this->getObjeto($document,'h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('osTucumaes',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function conteudoAm($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp,'N');

        $elementConteudo = $this->getObjeto($document,'article .entry-content');
        $elementTitulo = $this->getObjeto($document,'h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('conteudoAm',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalUnico($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto($document,'article .entry-content');
        $elementTitulo = $this->getObjeto($document,'header > h2.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalUnico',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function blogGilbertoMarcal($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);

        $elementConteudo = $this->getObjeto($document,'.entry-content');
        $elementConteudo->html(str_replace('<div','<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</div>','</p>',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<span','<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</span>','</p>',$elementConteudo->html()));

        $elementTitulo = $this->getObjeto($document,'h3.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalUnico',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalNatan($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div[data-widget_type=theme-post-content.default]');
        $elementTitulo = $this->getObjeto($document,'h1.elementor-heading-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalNatan',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function agoraAmazonas($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.td-post-content');
        $elementTitulo = $this->getObjeto($document,'header > h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('agoraAmazonas',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function culturaAmazonica($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.the_content_wrapper');
        $elementTitulo = $this->getObjeto($document,'div.container  h1.title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('culturaAmazonica',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function chumboGrosso($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.td-post-content');
        $elementTitulo = $this->getObjeto($document,'header > h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('chumboGrosso',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function aCritica($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.post-content');
        $elementTitulo = $this->getObjeto($document,'article > h2.title-21');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('aCritica',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function amazonasNoticias($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.single-post-content');
        $elementTitulo = $this->getObjeto($document,'h1.single-post-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('amazonasNoticias',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function emTempo($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div#aet-text');
        $elementTitulo = $this->getObjeto($document,'div.container h1.title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('emTempo',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function g1Amazonas($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'article[itemprop=articleBody]');
        $elementTitulo = $this->getObjeto($document,'div.title h1.content-head__title');
        $elementConteudo->html(str_replace('<h2', '<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</h2>', '</p>',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<span', '<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</span>', '</p>',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<ul', '<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</ul>', '</p>',$elementConteudo->html()));
        $elementConteudo->html(str_replace('<li', '<p',$elementConteudo->html()));
        $elementConteudo->html(str_replace('</li>', '</p>',$elementConteudo->html()));
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('g1Amazonas',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function nossoShowAm($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.materia');
        $elementTitulo = $this->getObjeto($document,'h1.tit-not');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('nossoShowAm',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function olaSalveSalve($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.entry-content');
        $elementTitulo = $this->getObjeto($document,'h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('olaSalveSalve',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function issoEAmazonas($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.entry-content');
        $elementTitulo = $this->getObjeto($document,'h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('issoEAmazonas',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalManaos($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.tdb_single_content > div.tdb-block-inner');
        $elementTitulo = $this->getObjeto($document,'h1.tdb-title-text');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalManaos',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function amazonPlayTV($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'div.entry-content');
        $elementTitulo = $this->getObjeto($document,'h1.entry-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('amazonPlayTV',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }

    private function d24Am($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'section.sticky-wraper > article');
        $elementTitulo = $this->getObjeto($document,'h1.blog-post-title');
        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('d24Am',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }
    private function portalCaboco($htmlResp)
    {
        $document = $this->criaObjeto($htmlResp);
        $elementConteudo = $this->getObjeto($document,'article > div.article-content.detail-article-content > div.entry-content.detail-entry-content');
        $elementTitulo = $this->getObjeto($document,'article > div.article-content.article-title-meta > div > h4');

        $titulo =$elementTitulo->text();
        $result='';
        foreach ($elementConteudo->find('p') as $item) {
            if (!empty($item->textContent) and !$this->limparLinha('portalCaboco',$item->textContent) and strlen(($item->textContent))!=2) {
                $result .= preg_replace("/\r?\n/","",$item->textContent). $this->quebraLinha();
            }
        }
        return $this->resposta(($titulo),html_entity_decode(str_replace('&nbsp;','',$result)));
    }


    private function curl_get($url, array $options = array())
    {
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
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
    private function curl_get3($url, array $options = array())
    {
        $User_Agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.75 Safari/537.36';

        $request_headers = array();
        $request_headers[] = 'User-Agent: '. $User_Agent;
        $request_headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST=>FALSE,
            CURLOPT_POSTFIELDS =>'',
            CURLOPT_HTTPHEADER =>$request_headers,
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
    function curl_get4($url, array $options = array())
    {
        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_SSL_VERIFYPEER, false
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


    function ajaxUploadFile($idMateria) {
        set_time_limit(0);

        $diretorio = APPPATH_MATERIA. $idMateria;

        //upload file
        $config['upload_path'] = $diretorio;
        $config['allowed_types'] = '*';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '0';

        //if (isset($_FILES['file']['name'])) {
        //    if (0 < $_FILES['file']['error']) {
        //        echo 'error!';
        //    } else {
                    $this->load->library('upload', $config);
                    if (!is_dir($diretorio)) {
                        mkdir($diretorio, 0777, true);
                    }
                    if (!$this->upload->do_upload('file')) {
                        echo $this->upload->display_errors();
                    } else {
                        $file_name = $this->upload->data()['file_name'];
                        $orig_name = $this->upload->data()['orig_name'];
                        $file_type = $this->upload->data()['file_type'];

                        $this->load->database();
                        $this->db->reconnect();
                        $ordemAnexo = $this->MateriaModelo->getOrdem($idMateria);

                        $dataAnexo = array(
                            'SEQ_MATERIA' => $idMateria,
                            'NOME_ARQUIVO' => $orig_name,
                            'NOME_BIN_ARQUIVO' => $file_name,
                            'CONTT_ARQUIVO' => $file_type,
                            'ORDEM_ARQUIVO' => $ordemAnexo
                        );
                        $newAnexo = $this->MateriaModelo->inserirAnexo($dataAnexo);

                        $materiaAtual = $this->MateriaModelo->getMateria($idMateria)->row();
                        if($materiaAtual->TIPO_MATERIA=='R') {
                            $dataAudio = getId3v2($idMateria . '/' . $file_name);
                            $this->MateriaModelo->alterarAnexo($dataAudio, $newAnexo);
                        }

                        $resultado['lista_anexo'] = $this->MateriaModelo->listaAnexo($idMateria);
                        $resultado['tipoMateria'] = $materiaAtual->TIPO_MATERIA;
                        $this->load->view('modulos/materia/anexos', $resultado);
                    }
//            }
//        } else {
//            echo 'sem';
//        }
    }

    public function listaArquivos(){

        //if( $this->session->userdata('idClienteSessao')==59 )
          //  $diretorioOrigem = APPPATH_ELEICAO;
        //else if( $this->session->userdata('idClienteSessao')==62 )
          //   $diretorioOrigem = APPPATH_ELEICAO_BELEM;
            //else
            if( $this->session->userdata('idClienteSessao')==40 ) {
                $diretorioOrigem = APPPATH_VIDEO_BOA_VISTA;    
            }   
                else if ($this->session->userdata('idClienteSessao')== 5 ) {
                $diretorioOrigem = APPPATH_GOVERNO_AM;                     
                } else if ($this->session->userdata('idUsuario')==26 ) {
                $diretorioOrigem = APPPATH_VIDEO_MISAEL;        
                } else if ($this->session->userdata('idUsuario')==154 ) {
                $diretorioOrigem = APPPATH_VIDEO_SIMONE;      
                } else if ($this->session->userdata('idUsuario')==141 ) {
                $diretorioOrigem = APPPATH_VIDEO_THALLITA;          
                } else if ($this->session->userdata('idUsuario')==121 ) {
                $diretorioOrigem = APPPATH_VIDEO_WILLIAM;              
                } else if ($this->session->userdata('idUsuario')==38 ) {
                $diretorioOrigem = APPPATH_VIDEO_SIMONE;  
                }else if ($this->session->userdata('idUsuario')==171 ) {
                $diretorioOrigem = APPPATH_VIDEO_RAMON;    
                } else if ($this->session->userdata('idUsuario')==163 ) {
                $diretorioOrigem = APPPATH_VIDEO_RONALDO;    
                } else if ($this->session->userdata('idUsuario')==176 ) {
                $diretorioOrigem = APPPATH_VIDEO_WALLACE;    
                } else if ($this->session->userdata('idUsuario')==173 ) {
                $diretorioOrigem = APPPATH_VIDEO_LEONARDO;    
                } 
                else if ($this->session->userdata('idUsuario')==178 ) {
                $diretorioOrigem = APPPATH_VIDEO_WILLIAM_SANTEIRO;    
                
                } else if ($this->session->userdata('idUsuario')==194 ) {
                $diretorioOrigem = APPPATH_VIDEO_YASMIM;    
                }
                else if ($this->session->userdata('idUsuario')==155 ) {
                $diretorioOrigem = APPPATH_VIDEO_CAROLINA;    
                }
                else if ($this->session->userdata('idUsuario')==142 ) {
                $diretorioOrigem = APPPATH_VIDEO_RAQUEL;    
                }
                else if ($this->session->userdata('idUsuario')==201 ) {
                $diretorioOrigem = APPPATH_VIDEO_EZEQUIAS;    
                }
                else {
                $diretorioOrigem = APPPATH_VIDEO;
                }
                
        $resultado =array();
        $types = array( 'mp4' );
        if ( $handle = opendir($diretorioOrigem) ) {
            while ( $entry = readdir( $handle ) ) {
                $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
                if( in_array( $ext, $types ) ) {
                    array_push($resultado,$entry);
                }
            }
            closedir($handle);
        }
        return $resultado;

    }
    public function ajaxSetorCli(){

        extract($this->input->post());


        //deletar atuais
        $this->MateriaModelo->deleteSetoresClientesMateriaByMateria($idMateria);

        //insere os setores

        foreach ($listaSetor as $item){
            $data = array(
                'SEQ_CLIENTE'=>$idCliente,
                'SEQ_SETOR'=>$item,
                'SEQ_MATERIA'=>$idMateria
            );
            $this->MateriaModelo->inserirSetoresClientesMateria($data);

        }
        $dataMateria = array(
            'SEQ_SETOR'=>implode(",",$listaSetor)
        );
        $this->MateriaModelo->alterar($dataMateria,$idMateria);
        //devolve setores
        $resultado['lista_setores'] = $this->MateriaModelo->listaSetoresClientesMateria($idMateria);

        $this->load->view('modulos/materia/setor-cliente', $resultado);

    }
    public function ajaxAlteraSetorCli(){

        extract($this->input->post());

            $data = array(
                'IND_AVALIACAO'=>$valor
            );

        return $this->MateriaModelo->alterarSetorCliente($data,$chave);

    }

    public function ajaxReleaseSetor($tipo=''){

        extract($this->input->post());

        $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseBySetor($idSetor,'S');

        $this->load->view('modulos/materia/carrega-release'.$tipo, $resultado);

    }
    public function ajaxShare($tipo,$id)
    {
//        $this->load->model('materiaModelo', 'MateriaModelo');
        $listaItem = $this->MateriaModelo->getMateria($id)->row();

        $analiseConteudo='';
        $mensagem ='';
        /**
         * Montagem da Mensagem
         */
        if ($listaItem->TIPO_MATERIA == 'I' and !empty($listaItem->SEQ_VEICULO))
            $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $listaItem->SEQ_VEICULO))->row();
        else if ($listaItem->TIPO_MATERIA == 'S' and !empty($listaItem->SEQ_PORTAL))
            $dadoVeiculo = $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $listaItem->SEQ_PORTAL))->row();
        else if ($listaItem->TIPO_MATERIA == 'R' and !empty($listaItem->SEQ_RADIO))
            $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $listaItem->SEQ_RADIO))->row();
        else if ($listaItem->TIPO_MATERIA == 'T' and !empty($listaItem->SEQ_TV))
            $dadoVeiculo = $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $listaItem->SEQ_TV))->row();

        if ($listaItem->TIPO_MATERIA == 'I' and !empty($listaItem->SEQ_VEICULO)) {
            $mensagem = $dadoVeiculo->FANTASIA_VEICULO
                . PHP_EOL
                . $listaItem->TIT_MATERIA
                . PHP_EOL
                . 'Link: '
                . url_materia_simples($listaItem->SEQ_CLIENTE,$listaItem->SEQ_SETOR)
                . $listaItem->CHAVE;
            $veiculo = $dadoVeiculo->FANTASIA_VEICULO;
        } else if ($listaItem->TIPO_MATERIA == 'S' and !empty($listaItem->SEQ_PORTAL)) {
            
            $mensagem = $dadoVeiculo->NOME_PORTAL
                . PHP_EOL
                . $listaItem->TIT_MATERIA
                . PHP_EOL . 'Link: '
                . url_materia_simples($listaItem->SEQ_CLIENTE,$listaItem->SEQ_SETOR)
                . $listaItem->CHAVE;
            $veiculo = $dadoVeiculo->NOME_PORTAL;

        } else if ($listaItem->TIPO_MATERIA == 'R' and !empty($listaItem->SEQ_RADIO)){
            $mensagem = $dadoVeiculo->NOME_RADIO
                . PHP_EOL
                . $listaItem->PROGRAMA_MATERIA
                . PHP_EOL
                . $listaItem->TIT_MATERIA
                . PHP_EOL
                . 'Link: '
                . url_materia_simples($listaItem->SEQ_CLIENTE,$listaItem->SEQ_SETOR)
                . $listaItem->CHAVE;
            $veiculo = $dadoVeiculo->NOME_RADIO . ' - '. $listaItem->PROGRAMA_MATERIA;
        } else if ($listaItem->TIPO_MATERIA == 'T' and !empty($listaItem->SEQ_TV)) {
            $mensagem = $dadoVeiculo->NOME_TV
                . PHP_EOL
                . $listaItem->PROGRAMA_MATERIA
                . PHP_EOL
                . $listaItem->TIT_MATERIA
                . PHP_EOL
                . 'Link: '
                . url_materia_simples($listaItem->SEQ_CLIENTE,$listaItem->SEQ_SETOR)
                . $listaItem->CHAVE;
            $veiculo = $dadoVeiculo->NOME_TV. ' - '.$listaItem->PROGRAMA_MATERIA;
        }
        
        /*
         *
         * Analise mensagem para assunto geral
         */
        if ($listaItem->TIPO_MATERIA == 'I' and !empty($listaItem->SEQ_VEICULO) and $listaItem->SEQ_ASSUNTO_GERAL>0) {
            $mensagemti = '*'
                .$this->ComumModelo->getTableData('ASSUNTO_GERAL', array('SEQ_ASSUNTO_GERAL' => $listaItem->SEQ_ASSUNTO_GERAL))->row()->DESC_ASSUNTO_GERAL
                . '*'
                . PHP_EOL
                . $dadoVeiculo->FANTASIA_VEICULO
                . PHP_EOL
                . $listaItem->TIT_MATERIA
                . PHP_EOL
                . 'Link: '
                . url_materia_simples_ti()
                . $listaItem->CHAVE;
        } else if ($listaItem->TIPO_MATERIA == 'S' and !empty($listaItem->SEQ_PORTAL) and $listaItem->SEQ_ASSUNTO_GERAL>0) {
            $mensagemti = '*'
                . $this->ComumModelo->getTableData('ASSUNTO_GERAL', array('SEQ_ASSUNTO_GERAL' => $listaItem->SEQ_ASSUNTO_GERAL))->row()->DESC_ASSUNTO_GERAL
                . '*'
                . PHP_EOL
                . $dadoVeiculo->NOME_PORTAL
                . PHP_EOL
                . $listaItem->TIT_MATERIA
                . PHP_EOL
                . 'Link: '
                . url_materia_simples_ti()
                . $listaItem->CHAVE;
        } else if ($listaItem->TIPO_MATERIA == 'R' and !empty($listaItem->SEQ_RADIO) and $listaItem->SEQ_ASSUNTO_GERAL>0){
            $mensagemti = '*'
                . $this->ComumModelo->getTableData('ASSUNTO_GERAL', array('SEQ_ASSUNTO_GERAL' => $listaItem->SEQ_ASSUNTO_GERAL))->row()->DESC_ASSUNTO_GERAL
                . '*'
                . PHP_EOL
                . $dadoVeiculo->NOME_RADIO
                . PHP_EOL
                . $listaItem->PROGRAMA_MATERIA
                . PHP_EOL
                . $listaItem->TIT_MATERIA
                . PHP_EOL
                . 'Link: '
                . url_materia_simples_ti()
                . $listaItem->CHAVE;
        } else if ($listaItem->TIPO_MATERIA == 'T' and !empty($listaItem->SEQ_TV) and $listaItem->SEQ_ASSUNTO_GERAL>0) {
            $mensagemti = '*'
                . $this->ComumModelo->getTableData('ASSUNTO_GERAL', array('SEQ_ASSUNTO_GERAL' => $listaItem->SEQ_ASSUNTO_GERAL))->row()->DESC_ASSUNTO_GERAL
                . '*'
                . PHP_EOL
                . $dadoVeiculo->NOME_TV
                . PHP_EOL
                . $listaItem->PROGRAMA_MATERIA
                . PHP_EOL
                . $listaItem->TIT_MATERIA
                . PHP_EOL
                . 'Link: '
                . url_materia_simples_ti()
                . $listaItem->CHAVE;
        }

        $analiseConteudo='';
        if (!empty($listaItem->IND_AVALIACAO)){

            if(!empty($listaItem->RESUMO_MATERIA)) {
            $analiseConteudo = "*Resumo:* " . $listaItem->RESUMO_MATERIA;
            }
            if (!empty($listaItem->COMENTARIO_MATERIA)) {
                $analiseConteudo .= PHP_EOL
                    . "*Comentário Apresentador:* "
                    . $listaItem->COMENTARIO_MATERIA;
            }
            $dataCliente =$this->ComumModelo->getTableData('CLIENTE',array('SEQ_CLIENTE'=>$this->session->userdata('idClienteSessao')))->row();
            
            if (!empty($listaItem->RESPOSTA_MATERIA) and $listaItem->RESPOSTA_MATERIA != 'Sem resposta') {
            $analiseConteudo .= PHP_EOL
                . "*Resposta:* "
                . $listaItem->RESPOSTA_MATERIA;                
            }
            $resp = $listaItem->RESPOSTA_MATERIA;
            $mensagem = $mensagem
                . PHP_EOL
                . PHP_EOL
                . $analiseConteudo;
      
            
        } 
        
//        else if (!empty($listaItem->IND_AVALIACAO) and $listaItem->IND_AVALIACAO=='N' and !empty($listaItem->ANALISE_MATERIA)){
//            $resumoReplace = array("Resumo", "resumo", "RESUMO");
//            $respostaReplace   = array("Resposta", "resposta", "RESPOSTA");
//            
//            $analiseConteudo = str_replace($resumoReplace, "*Resumo*", $listaItem->ANALISE_MATERIA);
//            $analiseConteudo = str_replace($respostaReplace, "*Resposta*", $analiseConteudo);
//            
//            $mensagem = $mensagem
//                . PHP_EOL
//                . PHP_EOL
//                . $analiseConteudo;
//        }
        
        $dataCliente =$this->ComumModelo->getTableData('CLIENTE',array('SEQ_CLIENTE'=>$this->session->userdata('idClienteSessao')))->row();
        $resposta='';

        $status= false;
       
        if ((!empty($listaItem->SEQ_RADIO) or
                !empty($listaItem->SEQ_PORTAL) or
                !empty($listaItem->SEQ_VEICULO) or
                !empty($listaItem->SEQ_TV)) and $tipo=='nm'

        ) {
            if ($listaItem->IND_AVALIACAO=='N') {
                if ($dataCliente->SEQ_CLIENTE == 59 || $dataCliente->SEQ_CLIENTE == 55 || $dataCliente->SEQ_CLIENTE == 13) {
                    $link = str_replace('https://porto.am/v2', 'http://clippingeleicoes.com.br/v', url_materia_simples_ti());
                    $resposta .= json_decode('"\uD83D\uDED1"').' *ALERTA* '. PHP_EOL. '*MENÇÃO NEGATIVA* ' .PHP_EOL.trim($dataCliente->NOME_CLIENTE). PHP_EOL. (($dataCliente->IND_ALERTA_SETOR == 'N') ? '' : PHP_EOL . '*Veículo/Programa:* ' .$veiculo.PHP_EOL.'*Link:* '.$link.$listaItem->CHAVE.PHP_EOL)
                    . ((($listaItem->TIPO_MATERIA == 'T' OR $listaItem->TIPO_MATERIA == 'R') and (!empty($listaItem->SEQ_TV) OR !empty($listaItem->SEQ_RADIO))) ? (PHP_EOL . 'Data: '.date('d/m/Y', strtotime($listaItem->DATA_MATERIA_PUB)) . (!empty($listaItem->HORA_MATERIA)?('-' . $listaItem->HORA_MATERIA):'')) : '')
                    . PHP_EOL . PHP_EOL
                    . '*Descrição:* '. $listaItem->TIT_MATERIA . PHP_EOL . '*Resposta:* '.$resp;
                } else {
                if ($dataCliente->SEQ_CLIENTE == 1) {
                   $novo_alerta = json_decode('"\uD83D\uDED1"').json_decode('"\uD83D\uDED1"').' MATÉRIA NEGATIVA '.json_decode('"\uD83D\uDED1"').json_decode('"\uD83D\uDED1"').PHP_EOL.''; 
                } else {
                   $novo_alerta = '*MATÉRIA NEGATIVA* ' . json_decode('"\u26D4"').json_decode('"\u26D4"'). json_decode('"\u26D4"'); 
                }    
                
               
                $this->db->select("GROUP_CONCAT(TRIM(DESC_SETOR)) as SETOR ");
                $where_in = "SEQ_SETOR IN (".$listaItem->SEQ_SETOR.")";
                $this->db->where($where_in);
                $setor = $this->db->get('SETOR')->row()->SETOR;
                
                    $resposta .= $novo_alerta
                    . PHP_EOL
                    . '*' . trim($dataCliente->NOME_CLIENTE)
                    . '*'
                    . (($dataCliente->IND_ALERTA_SETOR == 'N') ? '' : PHP_EOL . $setor)
                    . ((($listaItem->TIPO_MATERIA == 'T' OR $listaItem->TIPO_MATERIA == 'R') and (!empty($listaItem->SEQ_TV) OR !empty($listaItem->SEQ_RADIO))) ? (PHP_EOL . date('d/m/Y', strtotime($listaItem->DATA_MATERIA_PUB)) . (!empty($listaItem->HORA_MATERIA)?('-' . $listaItem->HORA_MATERIA):'')) : '')
                    . PHP_EOL . PHP_EOL;
                }
                
            } else {
                
                 if ($dataCliente->SEQ_CLIENTE == 59 || $dataCliente->SEQ_CLIENTE == 55 || $dataCliente->SEQ_CLIENTE == 13) {
                 $link = str_replace('https://porto.am/v2', 'http://clippingeleicoes.com.br/v', url_materia_simples_ti());    
                 $resposta .= json_decode('"\u2705"').' *ALERTA* '. PHP_EOL. '*MENÇÃO POSITIVA* ' .PHP_EOL.trim($dataCliente->NOME_CLIENTE). PHP_EOL. (($dataCliente->IND_ALERTA_SETOR == 'N') ? '' : PHP_EOL . '*Veículo/Programa:* ' .$veiculo.PHP_EOL.'*Link:* '.$link.$listaItem->CHAVE.PHP_EOL)
                    . ((($listaItem->TIPO_MATERIA == 'T' OR $listaItem->TIPO_MATERIA == 'R') and (!empty($listaItem->SEQ_TV) OR !empty($listaItem->SEQ_RADIO))) ? (PHP_EOL . 'Data: '.date('d/m/Y', strtotime($listaItem->DATA_MATERIA_PUB)) . (!empty($listaItem->HORA_MATERIA)?('-' . $listaItem->HORA_MATERIA):'')) : '')
                    . PHP_EOL . PHP_EOL
                    . '*Descrição:* '. $listaItem->TIT_MATERIA;    
                } else {
                if ($dataCliente->SEQ_CLIENTE == 1) {
                   if ($listaItem->IND_AVALIACAO=='P') {
                   $novo_alerta = json_decode('"\u2705"').json_decode('"\u2705"').' MATÉRIA POSITIVA '.json_decode('"\u2705"').json_decode('"\u2705"').PHP_EOL.''; 
                   } else if ($listaItem->IND_AVALIACAO=='T') {
                   $novo_alerta = json_decode('"\uD83D\uDFE1"').json_decode('"\uD83D\uDFE1"').' MATÉRIA NEUTRA '.json_decode('"\uD83D\uDFE1"').json_decode('"\uD83D\uDFE1"').PHP_EOL.'';     
                   }
                } else {
                   $novo_alerta = ''; 
                }  
               
//                var_dump($listaItem->SEQ_SETOR);
//                die();
                if (!empty($listaItem->SEQ_SETOR)) {    
                $this->db->select("GROUP_CONCAT(TRIM(DESC_SETOR)) as SETOR ");
                $where_in = "SEQ_SETOR IN (".$listaItem->SEQ_SETOR.")";
                $this->db->where($where_in);
                $setor = $this->db->get('SETOR')->row()->SETOR;
                } else {
                $setor ='';    
                }
//                die();
                $resposta .=  $novo_alerta.
                    json_decode('"\u23F0"')
                    . '*Alerta de Clipping*'
                    . PHP_EOL
                    . '*'
                    . trim($dataCliente->EMPRESA_CLIENTE)
                    . '*'
                    . (($dataCliente->IND_ALERTA_SETOR == 'N') ? '' : PHP_EOL . $setor)
                    . (($listaItem->TIPO_MATERIA == 'T' OR $listaItem->TIPO_MATERIA == 'R') ? (PHP_EOL . date('d/m/Y', strtotime($listaItem->DATA_MATERIA_PUB)) . '-' .(!empty($listaItem->HORA_MATERIA)?('-' . $listaItem->HORA_MATERIA):'')) : (PHP_EOL . date('d/m/Y', strtotime($listaItem->DATA_MATERIA_PUB))))
                    . PHP_EOL
                    . PHP_EOL
                    . "";
                }
            }
            
           
            // CLIENTES ELEIÇÕES
            
            if ($dataCliente->SEQ_CLIENTE == 11 || $dataCliente->SEQ_CLIENTE == 37 || $dataCliente->SEQ_CLIENTE == 60) {
               $this->db->select("GROUP_CONCAT(TRIM(DESC_SETOR)) as SETOR ");
               $where_in = "SEQ_SETOR IN (".$listaItem->SEQ_SETOR.")";
               $this->db->where($where_in);
               $setor = $this->db->get('SETOR')->row()->SETOR; 
               $resposta  = $setor.PHP_EOL;
               $resposta .= date('d/m/Y', strtotime($listaItem->DATA_MATERIA_PUB)).PHP_EOL;
               
            }
            // FIM CLIENTES ELEIÇÕES
            $status=true;

            if ($dataCliente->SEQ_CLIENTE == '59' || $dataCliente->SEQ_CLIENTE == '55' || $dataCliente->SEQ_CLIENTE == '13') {
//            $analiseConteudo .= PHP_EOL
//                . "*Resposta:* "
//                . $listaItem->RESPOSTA_MATERIA;  
//            $resposta .= ($mensagem.$analiseConteudo);
            } else {
                $resposta .= ($mensagem);
            }
        }
       
        if ((!empty($listaItem->SEQ_RADIO) or
                !empty($listaItem->SEQ_PORTAL) or
                !empty($listaItem->SEQ_VEICULO) or
                !empty($listaItem->SEQ_TV)) and $listaItem->SEQ_ASSUNTO_GERAL>0 and $tipo=='ti'

        ) {
            $resposta .= json_decode('"\u23F0"')
                . '*Alerta de Clipping*'
                . PHP_EOL
                . '*TEMA DE INTERESSE*'
                . ($listaItem->TIPO_MATERIA == 'T' OR $listaItem->TIPO_MATERIA == 'R')?
                    (PHP_EOL.date('d/m/Y',strtotime($listaItem->DATA_MATERIA_PUB)).'-'.$listaItem->HORA_MATERIA):
                    (PHP_EOL.date('d/m/Y',strtotime($listaItem->DATA_MATERIA_PUB)));
            $status=true;
            $resposta .= ($mensagemti);
        }

        if ($dataCliente->SEQ_CLIENTE == 60) {
                $data = date('d/m/Y', strtotime($listaItem->DATA_MATERIA_PUB));
                $bolaAzul = json_decode('"\uD83D\uDD35"');
                $jornal  = json_decode('"\uD83D\uDCF0"');
                $avaliacao = '';
                if ($listaItem->IND_AVALIACAO == 'P') {
                    $avaliacao = 'Positiva';
                } elseif ($listaItem->IND_AVALIACAO == 'N') {
                    $avaliacao = 'Negativa';
                } else {
                    $avaliacao = 'Neutra';
                }
                $resposta = $data.PHP_EOL.$bolaAzul. ' *'.trim($setor).'*'.PHP_EOL.$jornal.' *'.$veiculo.' - '.$avaliacao.'*'.PHP_EOL.$listaItem->TIT_MATERIA.PHP_EOL.PHP_EOL.'Link: '.$listaItem->LINK_MATERIA;
        }
        
        $arrayResp = array(
            'status'=>$status,
            'mesage'=>($resposta)
        );
        echo json_encode($arrayResp);

    }
    public function ajaxTipoCli(){

        extract($this->input->post());


        //deletar atuais
        $this->MateriaModelo->deleteTipoClientesMateriaByMateria($idMateria);

        //insere os setores

        foreach ($listaTipo as $item){
            $data = array(
                'SEQ_CLIENTE'=>$idCliente,
                'SEQ_TIPO_MATERIA'=>$item,
                'SEQ_MATERIA'=>$idMateria
            );
            $this->MateriaModelo->inserirTipoClientesMateria($data);

        }
        $dataMateria = array(
            'SEQ_TIPO_MATERIA'=>implode(",",$listaTipo)
        );
        $this->MateriaModelo->alterar($dataMateria,$idMateria);
        //devolve areas
        $resultado['lista_tipos'] = $this->MateriaModelo->listaTipoClientesMateria($idMateria);

        $this->load->view('modulos/materia/tipo-cliente', $resultado);

    }
    public function ajaxAlteraTipoCli(){

        extract($this->input->post());

        $data = array(
            'QTD_COMENTARIO'=>$valor
        );

        return $this->MateriaModelo->alterarTipoCliente($data,$chave);

    }

}
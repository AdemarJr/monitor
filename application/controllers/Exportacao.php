<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exportacao extends MY_Controller
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
        $resultado['lista_arquivo'] = $this->ComumModelo->getTableData('DOWNLOAD',array('SEQ_USUARIO'=>$this->session->userdata('idUsuario')))->result_array();
        $this->loadUrl('modulos/exportacao/consultar-geral', $resultado);
    }

    public function executar()
    {
        set_time_limit(0);
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-CONTAGEM-POR-VEICULO', 'C', '');
        if (empty($datai) or empty($dataf) or empty($idCliente)){
            $class = 'error';
            $mensagem = 'Campos obrigatórios faltando';
            $this->feedBack($class, $mensagem, 'exportacao');
            return;
        }

        if ($acao != 'I') {
            $datai = $datai;
            $dataf = $dataf;
            $idCliente = $idCliente;
            $excluirSetor = !empty($excluirSetor) ?$excluirSetor:NULL;
            $setor = !empty($this->input->post('setor')) ?$this->input->post('setor'):NULL;

            if (is_array($setor)){
                $setores = implode($setor,',');
            } else {
                $setores = $setor;
            }
            if (is_array($tipo)){
                $tipos = implode($tipo,',');
            } else {
                $tipos = $tipo;
            }

            /** verifica se ja tem porocessamento em andamento */
            $fetch_data = $this->ComumModelo->existeProcessamento($this->session->userdata('idUsuario'));
            if (count($fetch_data)>0){
                $class = 'warning';
                $mensagem = 'Já Existe um Processamento em andamento';
                $this->feedBack($class, $mensagem, 'exportacao');
                return;
            }

            $nomeArquivo = md5(uniqid(rand(), true));
            /** INSERIR NA TABELA */
            $this->load->helper('date');
            $data_down = array(
                'SEQ_USUARIO'=>$this->session->userdata('idUsuario'),
                'NOME_ARQUIVO'=>$nomeArquivo,
                'IND_ARQUIVO'=>'P',
                'DATA_SOLICITACAO'=>date('Y-m-d H:i:s',now('America/Manaus')),
            );
            $idDown = $this->ComumModelo->inserTableData('DOWNLOAD',$data_down);

            $url = base_url()."exportacao/taskExportacao";

            $param = array(
                "idCliente" => $idCliente,
                "datai"=>$datai,
                "dataf"=>$dataf,
                "setores"=>$setores,
                "excluirSetor"=>$excluirSetor,
                "tipos"=>$tipos,
                "idDownload"=>$idDown,
                "nomeArquivo"=>$nomeArquivo,
            );
            $this->asynctask->do_in_background($url, $param);
        }


        $resultado['datai'] = $datai;
        $resultado['dataf'] = $dataf;
        $resultado['idCliente'] = $idCliente;
        $resultado['lista_setor'] = $this->SetorModelo->listaSetorAlerta($idCliente);
        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
        $resultado['lista_arquivo'] = $this->ComumModelo->getTableData('DOWNLOAD',array('SEQ_USUARIO'=>$this->session->userdata('idUsuario')))->result_array();
        $this->loadUrl('modulos/exportacao/consultar-geral', $resultado);
    }

    public function taskExportacao(){

        set_time_limit(0);
        extract($this->input->post());

        /** fazendo chamada ao processamento de copi */
        $this->processacopia($idCliente, $datai,$dataf,$setores, $excluirSetor, $tipos,$nomeArquivo);

        /** realizar a compactação da pasta */
        $comando = 'cd '.APPPATH_EXPORTACAO. ' && zip -r '.$nomeArquivo.'.zip '.$nomeArquivo.' && cd -';

        $output = shell_exec($comando);

        /** remove diretorio */
        shell_exec('rm -rf '.APPPATH_EXPORTACAO.$nomeArquivo);


        $data_down = array(
            'IND_ARQUIVO'=>'D',
        );
        $idDown = $this->ComumModelo->updateTableData('DOWNLOAD',0,array('SEQ_DOWNLOAD'=>$idDownload),$data_down);

    }
    private function processacopia($idCliente, $dtIni,$dtFim,$setor, $excluiSetor, $tipo,$nomeArquivo){
        set_time_limit(0);
        $this->load->model('materiaModelo', 'MateriaModelo');

        $lista_materias = $this->MateriaModelo->listaMateriaCopia($idCliente, $dtIni,$dtFim,$setor, $excluiSetor, $tipo);
        
        // $dieDest = APPPATH_EXPORTACAO.'pmm102020/'.$tipo.'/';
        $dieDest = APPPATH_EXPORTACAO . $nomeArquivo;
        if (!is_dir($dieDest)) {
            mkdir($dieDest);
        };
        foreach ($lista_materias as $index => $materia) {
            /** verifica se exite pasta tipo */
            $fileDest0 = $dieDest.'/'.$materia['TIPO_MATERIA'];
            if (!is_dir($fileDest0)) {
                mkdir($fileDest0);
            };

            $fileDest = $fileDest0.'/'.$materia['PASTAMES'];
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

                if (file_exists($arquivo)) {
                   $destinoFile = $fileDest2.'/' .$anexo['NOME_ARQUIVO'];
                    copyr($arquivo,$destinoFile);
                }
            }
        }
        return $nomeArquivo;
    }
    private function acoes($row)
    {
        $resultado = '<div class="action-buttons" >';
        if ($row->IND_ARQUIVO == 'D') {
            $resultado .= '<a id="btn-down" title="Baixar" class="btn bg-blue btn-circle-xm waves-effect waves-circle waves-float" href="' . base_url('publico/download/') . $row->NOME_ARQUIVO . '"><i class="material-icons">download</i></a>&nbsp;&nbsp;';
        }else{
            $resultado .= '<a id="btn-msg"  href="#">Aguarde.... </a>&nbsp;&nbsp;';
        }
        $resultado .= '</div>';
        return $resultado;
    }
    public function consultar()
    {
        $fetch_data = $this->ComumModelo->getTableData(
            'DOWNLOAD',
            array('SEQ_USUARIO'=>$this->session->userdata('idUsuario')),
            '',
            array(),
            array(),
            array(),
            array(),
            array('SEQ_DOWNLOAD','desc')
        )->result();

        // echo json_encode($fetch_data );
        // die;
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();

            /** pegar o tamanho do arquivo formatSizeUnits */
            $tamanho =0;
            if ($row->IND_ARQUIVO == 'D'){
               $arq = APPPATH_EXPORTACAO .$row->NOME_ARQUIVO.'.zip';
               if (file_exists($arq)) {
                $tamanho = filesize($arq);
               }

            }

            $sub_array[] = $row->SEQ_DOWNLOAD;
            $sub_array[] = $row->NOME_ARQUIVO;
            $sub_array[] = formatSizeUnits($tamanho) ;
            $sub_array[] = date('d/m/Y H:i:s',strtotime($row->DATA_SOLICITACAO));
            if ($row->IND_ARQUIVO == 'P')
                $sub_array[] = 'Processando';
            else if ($row->IND_ARQUIVO == 'D')
                $sub_array[] = 'Finalizado';

            $sub_array[] = $this->acoes($row);
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($fetch_data),
            "recordsFiltered" => count($fetch_data ),
            "data" => $data
        );
        echo json_encode($output);
    }

}
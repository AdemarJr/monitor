<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Notificacao extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('notificacaoModelo', 'NotificacaoModelo');
        $this->load->model('setorModelo', 'SetorModelo');
        $this->load->model('veiculoModelo', 'VeiculoModelo');
        $this->load->model('assuntoModelo', 'AssuntoModelo');
        $this->load->model('releaseModelo', 'ReleaseModelo');
        $this->load->model('tipomateriaModelo', 'TipomateriaModelo');
        $this->auth->CheckAuth('geral', $this->router->fetch_class(), $this->router->fetch_method());

    }
    
    public function ajaxAlertaEstatisticaNegativas() {
        $this->load->model('MateriaModelo');
        extract($this->input->post());       
        
        if ($idcliente == 0 || empty($link)) {
            echo 'vazio';
            exit();
        }
        
        $this->db->where('SEQ_CLIENTE', $idcliente);
        $cli = $this->db->get('CLIENTE')->row_array();
        
        // IMPRESSO
        
        $SQL = 'SELECT VEICULO.NOME_VEICULO,COUNT(MATERIA.SEQ_MATERIA) AS TOTAL FROM MATERIA MATERIA 
        JOIN VEICULO VEICULO ON VEICULO.SEQ_VEICULO = MATERIA.SEQ_VEICULO 
        WHERE MATERIA.DATA_PUB_NUMERO = DATE_FORMAT(CURDATE(), "%Y%m%d")
        AND MATERIA.IND_AVALIACAO = "N"
        AND MATERIA.SEQ_CLIENTE = '.$idcliente.'
        GROUP BY MATERIA.SEQ_VEICULO';
        
        $result = $this->db->query($SQL)->result();
        $txt = json_decode('"\uD83D\uDED1"') . ' *RELATÓRIO DE MÍDIA NEGATIVA*' . PHP_EOL . '*' . $cli['NOME_CLIENTE'] . '*' . PHP_EOL . date('d/m/Y') . PHP_EOL. PHP_EOL;
        if (!empty($result)) {
            $txt .= json_decode('"\uD83D\uDCF0"') . ' IMPRESSO' .PHP_EOL;
            foreach ($result as $item) {
                $txt .= trim($item->NOME_VEICULO) . ' - ' . $item->TOTAL . PHP_EOL;
            }
            $txt.= PHP_EOL;
        }
        
        $SQL = 'SELECT PORTAL.NOME_PORTAL,COUNT(MATERIA.SEQ_MATERIA) AS TOTAL FROM MATERIA MATERIA 
        JOIN PORTAL PORTAL ON PORTAL.SEQ_PORTAL = MATERIA.SEQ_PORTAL 
        WHERE MATERIA.DATA_PUB_NUMERO = DATE_FORMAT(CURDATE(), "%Y%m%d")
        AND MATERIA.IND_AVALIACAO = "N"
        AND MATERIA.SEQ_CLIENTE = '.$idcliente.'
        GROUP BY MATERIA.SEQ_PORTAL';
        $result = $this->db->query($SQL)->result();
        if (!empty($result)) {
            $txt .= json_decode('"\uD83D\uDCBB"') . ' INTERNET  ' .PHP_EOL;
            foreach ($result as $item) {
                $txt .= trim($item->NOME_PORTAL) . ' - ' . $item->TOTAL . PHP_EOL;
            }
            $txt.= PHP_EOL;
        }
        
        $SQL = 'SELECT RADIO.NOME_RADIO,COUNT(MATERIA.SEQ_MATERIA) AS TOTAL FROM MATERIA MATERIA 
        JOIN RADIO RADIO ON RADIO.SEQ_RADIO = MATERIA.SEQ_RADIO 
        WHERE MATERIA.DATA_PUB_NUMERO = DATE_FORMAT(CURDATE(), "%Y%m%d")
        AND MATERIA.IND_AVALIACAO = "N"
        AND MATERIA.SEQ_CLIENTE = '.$idcliente.'
        GROUP BY MATERIA.SEQ_RADIO';
        $result = $this->db->query($SQL)->result();
        if (!empty($result)) {
            $txt .= json_decode('"\uD83D\uDCFB"') . ' RÁDIO  ' .PHP_EOL;
            foreach ($result as $item) {
                $txt .= trim($item->NOME_RADIO) . ' - ' . $item->TOTAL . PHP_EOL;
            }
            $txt.= PHP_EOL;
        }
        
        $SQL = 'SELECT TELEVISAO.NOME_TV,COUNT(MATERIA.SEQ_MATERIA) AS TOTAL FROM MATERIA MATERIA 
        JOIN TELEVISAO TELEVISAO ON TELEVISAO.SEQ_TV = MATERIA.SEQ_TV 
        WHERE MATERIA.DATA_PUB_NUMERO = DATE_FORMAT(CURDATE(), "%Y%m%d")
        AND MATERIA.IND_AVALIACAO = "N"
        AND MATERIA.SEQ_CLIENTE = '.$idcliente.'
        GROUP BY MATERIA.SEQ_TV';
        $result = $this->db->query($SQL)->result();
        if (!empty($result)) {
            $txt .= json_decode('"\uD83D\uDCFA"') . ' TV  ' .PHP_EOL;
            foreach ($result as $item) {
                $txt .= trim($item->NOME_TV) . ' - ' . $item->TOTAL . PHP_EOL;
            }
            $txt.= PHP_EOL;
        }
        
        $txt.= json_decode('"\u23F2\uFE0F"').' *Alerta de Clipping*'.PHP_EOL;
        $txt.= '*TODAS AS PUBLICAÇÕES NEGATIVAS*'.PHP_EOL;
        $txt.= $link;
        
        echo $txt;
    }
    
    public function ajaxAlertaEstatisticaDestaque() {
        $this->load->model('MateriaModelo');
        extract($this->input->post());        
        
        if ($idcliente == 0) {
            echo 'vazio';
            exit();
        }
        
        // OBTER AS MATÉRIAS PUBLICADAS NO DIA
        $data = date('d/m/Y');
        $id_sessaoAnt =  $this->session->userData('idClienteSessao');
        
        $this->session->set_userdata('idClienteSessao', $idcliente);
        
        $resultado = $this->MateriaModelo->listaMateriaRelatorio($data, $data, NULL, NULL, NULL, NULL,
                    NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $data, $data, NULL, NULL, NULL, NULL);
        
        if ($idcliente !== 0) {
        $this->session->set_userdata('idClienteSessao', $id_sessaoAnt);
        }
        
        $this->top3($resultado);
        
        
        
    }
    private function top3($resultado) {
        $texto = '';
        $ctr = 0;
        $materiaNegativa = '';
        
        foreach ($resultado as $materia) {
            if ($ctr < 1) {
                if ($materia['IND_AVALIACAO'] == 'N') {
                    $materiaNegativa = $materia['TIT_MATERIA'];
                    $ctr++;
                }
            }
            if ($materia['IND_AVALIACAO'] == 'P') {
            $texto .= $materia['TIT_MATERIA'] . ',';
            }
        }
   
        $texto_final = substr($texto, 0, -2);
        $texto_final = str_replace(date('d/m'), "", $texto_final);
        /* Separar cada palavra por espaços (raw, sem filtro) */
        $palavras_raw = explode(",", $texto_final);

        // Array de caracteres para serem removidos
        $ignorar = [date('d/m'),".", ",", "!", ";", ":", "(", ")", "{", "}", "[", "]", "<", ">",
            "?", "|", "\\", "/", "na", "da", "das", "de", "até", "o", "a", "e", "um", "uns"];
                // Array para as palavras tratadas.
        $palavrasTratadas = array();

        /* Criar uma nova array de palavras, agora tratadas */
        $palavras_raw_count = count($palavras_raw);

        for ($i = 0; $i < $palavras_raw_count; ++$i) {
            $palavraAtual = $palavras_raw[$i];
            $palavraAtual = trim($palavraAtual);
            if (!empty($palavraAtual)) {
                $palavraTratada = str_replace($ignorar, "", $palavraAtual);
                $palavraTratada = mb_strtolower($palavraAtual);
                if (!empty($palavraTratada)) {
                    @$palavrasTratadas[$palavraTratada]++;
                }
            }
        }

        // Organizar pela ordem de mais ocorrências.
        arsort($palavrasTratadas);

        $a = 1;
        $txt = '';
        foreach ($palavrasTratadas as $assunto => $valor) {
            if ($a < 4) {
                $txt .= $a.' - ' . ucfirst($assunto).PHP_EOL;
            } else {
                continue;
            }
            $a++;
        }

        $texto_final = substr($txt, 0, -1);
        
        $this->db->select('NOME_CLIENTE');
        $this->db->where('SEQ_CLIENTE', $resultado[0]['SEQ_CLIENTE']);
        $cli = $this->db->get('CLIENTE')->row_array();
        
        $txt  = '*DESTAQUES DO DIA* '.json_decode('"\u26A0\uFE0F"').PHP_EOL;
        $txt .= '*'.$cli['NOME_CLIENTE'].'*'.PHP_EOL;
        $txt .= date('d/m/Y').PHP_EOL.PHP_EOL;
        $txt .= '*Positivo*'.PHP_EOL.PHP_EOL;
        $txt .= $texto_final.PHP_EOL.PHP_EOL;
        $txt .= '*Negativa*'.PHP_EOL;
        $txt .= '1 - '.$materiaNegativa;
        
        echo $txt;
    }

    public function index()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-ALERTAS', 'C', '');

        $resultado['dataFiltro']= !empty($dataFiltro)? $dataFiltro : date('d/m/Y');

        $resultado['lista_alertas']=$this->NotificacaoModelo->listaNotificacao($resultado['dataFiltro']);
        $resultado['lista_alertas_agg']=$this->NotificacaoModelo->listaNotificacaoAgg($resultado['dataFiltro']);
        
        $resultado['controle'] = $this;
        
        $this->loadUrl('modulos/alerta/consultar',$resultado);
    }
    
    public function arrumatexto($txt, $cliente, $item) {
       
        $arrumaTxt = explode('*', $txt);
        
        if ($cliente == 11 || $cliente == 37) {
            $txtCorrigido = '*' .
                    $arrumaTxt[1] . '*' . PHP_EOL . '*' .
                    $arrumaTxt[3] . '*' . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[4]) . PHP_EOL . PHP_EOL .
                    '*' . trim($arrumaTxt[5]) . '*' . PHP_EOL .
                    trim($arrumaTxt[6]);
            return $txtCorrigido;
        }

        if (isset($arrumaTxt[13])) {
            $txtCorrigido = '*' .
                    $arrumaTxt[1] . '*' . PHP_EOL . '*' .
                    $arrumaTxt[3] . '*' . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[4]) . PHP_EOL . PHP_EOL .
                    '*' . trim(@$arrumaTxt[11]) . '*' . PHP_EOL .
                    trim(@$arrumaTxt[12]) . PHP_EOL . PHP_EOL .
                    '*' . trim(@$arrumaTxt[9]) . '*' . PHP_EOL .
                    trim($arrumaTxt[10]) . PHP_EOL . PHP_EOL .
                    '*' . trim($arrumaTxt[7]) . '*' . PHP_EOL .
                    trim($arrumaTxt[8]) . PHP_EOL . PHP_EOL .
                    '*' . trim($arrumaTxt[5]) . '*' . PHP_EOL .
                    trim($arrumaTxt[6]) . PHP_EOL . PHP_EOL .
                    '*' . trim($arrumaTxt[13]) . '*' . PHP_EOL .
                    trim($arrumaTxt[14]) . PHP_EOL . PHP_EOL;
        } else {
            $txtCorrigido = '*' .
                    $arrumaTxt[1] . '*' . PHP_EOL . '*' .
                    $arrumaTxt[3] . '*' . PHP_EOL . PHP_EOL .
                    trim(@$arrumaTxt[4]) . PHP_EOL . PHP_EOL;
            $nota = $this->link($item, 'I');
                if (!empty($nota)) {
                    $txtCorrigido .= '*IMPRESSO*' . PHP_EOL;
                    $txtCorrigido .= 'Link: https://porto.am/i?' . $nota['LINK'] . PHP_EOL . PHP_EOL;
                }
            $nota = $this->link($item, 'S');
                if (!empty($nota)) {
                    $txtCorrigido .= '*INTERNET*' . PHP_EOL;
                    $txtCorrigido .= 'Link: https://porto.am/i?' . $nota['LINK'] . PHP_EOL . PHP_EOL;
                } 
            $nota = $this->link($item, 'R');
                if (!empty($nota)) {
                    $txtCorrigido .= '*RÁDIO*' . PHP_EOL;
                    $txtCorrigido .= 'Link: https://porto.am/i?' . $nota['LINK'] . PHP_EOL . PHP_EOL;
                } 
            $nota = $this->link($item, 'T');
                if (!empty($nota)) {
                    $txtCorrigido .= '*TV*' . PHP_EOL;
                    $txtCorrigido .= 'Link: https://porto.am/i?' . $nota['LINK'] . PHP_EOL . PHP_EOL;
                }
            if (isset($arrumaTxt[5]) && $arrumaTxt[5] == 'Todas as Publicacoes') {
            $txtCorrigido .= '*'.trim(@$arrumaTxt[5]).'*'.PHP_EOL.trim(@$arrumaTxt[6]).PHP_EOL.PHP_EOL;
            }    
//            if (isset($arrumaTxt[11])) {
//                $txtCorrigido .= '*' . trim(@$arrumaTxt[11]) . '*' . PHP_EOL .
//                        trim(@$arrumaTxt[12]) . PHP_EOL . PHP_EOL;
//            } else {
//                
//            }
//            if (isset($arrumaTxt[9])) {
//                $txtCorrigido .= '*' . trim(@$arrumaTxt[9]) . '*' . PHP_EOL .
//                        trim(@$arrumaTxt[10]) . PHP_EOL . PHP_EOL;
//            } else {
//                
//            }
//            if (isset($arrumaTxt[7])) {
//                
//            }
//            if (isset($arrumaTxt[5])) {
//                
//            } else {
//                
//            }
        }
        return $txtCorrigido;
    }

    public function arrumatexto2($txt, $cliente, $item) {
        $arrumaTxt = explode('*', $txt);
        if ($cliente == 11 || $cliente == 37) {
            $txtCorrigido = '*' .
                    $arrumaTxt[1] . '*' . PHP_EOL . '*' .
                    $arrumaTxt[3] . '*' . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[4]) . PHP_EOL . PHP_EOL .
                    '*' . trim($arrumaTxt[5]) . '*' . PHP_EOL .
                    trim($arrumaTxt[6]);
            return $txtCorrigido;
        }

        if (isset($arrumaTxt[13])) {
            $txtCorrigido = '*' .
                    $arrumaTxt[1] . '*' . PHP_EOL . '*' .
                    $arrumaTxt[3] . '*' . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[4]) . PHP_EOL . PHP_EOL .
                    '*' . trim(@$arrumaTxt[11]) . '*' . PHP_EOL .
                    trim(@$arrumaTxt[12]) . PHP_EOL . PHP_EOL .
                    '*' . trim(@$arrumaTxt[9]) . '*' . PHP_EOL .
                    trim($arrumaTxt[10]) . PHP_EOL . PHP_EOL .
                    '*' . trim($arrumaTxt[7]) . '*' . PHP_EOL .
                    trim($arrumaTxt[8]) . PHP_EOL . PHP_EOL .
                    '*' . trim($arrumaTxt[5]) . '*' . PHP_EOL .
                    trim($arrumaTxt[6]) . PHP_EOL . PHP_EOL .
                    '*' . trim($arrumaTxt[13]) . '*' . PHP_EOL .
                    trim($arrumaTxt[14]) . PHP_EOL . PHP_EOL;
        } else {
            $txtCorrigido = '*' .
                    $arrumaTxt[1] . '*' . PHP_EOL . '*' .
                    $arrumaTxt[3] . '*' . PHP_EOL . PHP_EOL .
                    trim(@$arrumaTxt[4]) . PHP_EOL . PHP_EOL;
            if (!isset($arrumaTxt[11])) {
                $nota = $this->link($item, 'I');
                if (!empty($nota)) {
                    $txtCorrigido .= '*IMPRESSO*' . PHP_EOL;
                    $txtCorrigido .= 'Link: https://porto.am/i?' . $nota['LINK'] . PHP_EOL . PHP_EOL;
                } else {
                    $txtCorrigido .= '';
                }
            } else {
                $txtCorrigido .= '*' . trim(@$arrumaTxt[11]) . '*' . PHP_EOL . trim(@$arrumaTxt[12]) . PHP_EOL . PHP_EOL;
            }
            if (!isset($arrumaTxt[9])) {
                $nota = $this->link($item, 'S');
                if (!empty($nota)) {
                $txtCorrigido .= '*INTERNET*' . PHP_EOL;
                $txtCorrigido .= 'Link: https://porto.am/i?' . $nota['LINK'] . PHP_EOL . PHP_EOL;
                } else {
                    $txtCorrigido .= '';
                }
            } else {
                $txtCorrigido .= '*' . trim(@$arrumaTxt[9]) . '*' . PHP_EOL . trim(@$arrumaTxt[10]) . PHP_EOL . PHP_EOL;
            }
            if (!isset($arrumaTxt[7])) {
                $nota = $this->link($item, 'R');
                if (!empty($nota)) {
                $txtCorrigido .= '*RÁDIO*' . PHP_EOL;
                $txtCorrigido .= 'Link: https://porto.am/i?' . $nota['LINK'] . PHP_EOL . PHP_EOL;
                } else {
                    $txtCorrigido .= '';
                }
            } else {
                $txtCorrigido .= '*' . trim(@$arrumaTxt[7]) . '*' . PHP_EOL . trim(@$arrumaTxt[8]) . PHP_EOL . PHP_EOL;
            }
            if (!isset($arrumaTxt[5])) {
                $nota = $this->link($item, 'T');
                if (!empty($nota)) {
                $txtCorrigido .= '*TV*' . PHP_EOL;
                $txtCorrigido .= 'Link: https://porto.am/i?' . $nota['LINK'] . PHP_EOL . PHP_EOL;
                } else {
                    $txtCorrigido .= '';
                }
            } else {
                $txtCorrigido .= '*' . trim(@$arrumaTxt[5]) . '*' . PHP_EOL . trim(@$arrumaTxt[6]) . PHP_EOL . PHP_EOL;
            }
        }
        return $txtCorrigido;
    }

    private function link($item, $materia) {
        $this->db->select('CHAVE_NOTIFICACAO AS LINK');
        $this->db->where('DT_INICIO', $item['DT_INICIO']);
        $this->db->where('DT_FIM', $item['DT_FIM']);
        $this->db->where('TIPO_MATERIA', $materia);
        $this->db->where('SEQ_CLIENTE', $item['SEQ_CLIENTE']);
        $this->db->where('LISTA_SETOR IS NULL');
        $this->db->where('GRUPO_PORTAL IS NULL');
        return $nota = $this->db->get('NOTA')->row_array();
    }

    public function novo()
    {
        $this->load->helper('date');
        $data = array(
            'CHAVE_NOTIFICACAO'=>$this->uniqid_base36(),
            'SEQ_USUARIO' => $this->session->userdata('idUsuario'),
            'DT_INICIO' => date('Y-m-d',now('America/Manaus')),
            'DT_FIM' => date('Y-m-d',now('America/Manaus')),
            'TIPO_NOTIFICACAO' => 'D',
            'DT_CADASTRO' => date('Y-m-d H:i:s',now('America/Manaus')),
            'IND_ATIVO' => 'S',
            'SEQ_CATEGORIA_SETOR' => 0,
            'SEQ_CLIENTE' => 0,
            'SEQ_ASSUNTO_GERAL'=>0
        );
        $this->inserirAuditoria('INSERIR-ALERTA', 'I', json_encode($data));
        $idNew = $this->NotificacaoModelo->inserirNota($data);
        if ($idNew>0){
            redirect(base_url('notificacao/editar/' . $idNew));
        }else {
            $class = 'error';
            $mensagem = 'Alerta n�o Incluido!!';
            $this->feedBack($class, $mensagem, 'notificacao');
            return;
        }
    }

    public function editar($idNota)
    {
        
        $nota = $this->NotificacaoModelo->editarNota($idNota);

        foreach ($nota as $index => $valor) {
            $resultado['idNota'] = $idNota;
            $resultado['dataic'] = $valor['DT_INICIO'];
            $resultado['datafc'] = $valor['DT_FIM'];
            $resultado['tipoMat'] = $valor['TIPO_MATERIA'];
            $resultado['codCliente'] = $valor['SEQ_CLIENTE'];
            $resultado['grupo'] = $valor['GRUPO_PORTAL'];
            $resultado['modelo'] = $valor['IND_MODELO'];
            $resultado['net'] = $valor['LISTA_PORTAL'];
            $resultado['impresso'] = $valor['LISTA_IMPRESSO'];
            $resultado['release'] = $valor['LISTA_RELEASE'];
            $resultado['setor'] = $valor['LISTA_SETOR'];
            $resultado['categoria'] = $valor['SEQ_CATEGORIA_SETOR'];
            $resultado['assunto'] = $valor['SEQ_ASSUNTO_GERAL'];
            $resultado['tv'] = $valor['LISTA_TV'];
            $resultado['radio'] = $valor['LISTA_RADIO'];
            $resultado['area'] = $valor['LISTA_AREA'];
            $resultado['avaliacao'] = $valor['AVALIACAO_NOTA'];
            $resultado['avulso'] = $valor['TIPO_NOTA'];
        }

        $resultado['lista_setor'] = $this->SetorModelo->listaSetorAlerta($resultado['codCliente']);
        $resultado['lista_categoria'] = $this->SetorModelo->listaCategoriaSetor($resultado['codCliente']);
        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
        $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateriaAlerta($resultado['codCliente']);

        $resultado['lista_radio'] = $this->VeiculoModelo->listaRadioAlerta($resultado['codCliente']);
        $resultado['lista_tv'] = $this->VeiculoModelo->listaTvAlerta($resultado['codCliente']);

        $resultado['lista_internet'] = $this->VeiculoModelo->listaInternetAlerta($resultado['codCliente']);
        $resultado['lista_impresso'] = $this->VeiculoModelo->listaImpressoAlerta($resultado['codCliente']);

        if($resultado['codCliente']==1) {
            $resultado['lista_release'] = $this->ReleaseModelo->listaReleaseBySetor($resultado['setor'], 'S');
        }


        $resultado['lista_assunto'] = $this->AssuntoModelo->listaAssunto();
        $this->loadUrl('modulos/alerta/editar',$resultado);
    }

    public function alterar($idNota=NULL)
    {

        set_time_limit(0);
        if (empty($idNota)) {
            $class = 'warning';
            $mensagem = 'Por favor, selecione um Alerta para editar!!';
            $this->feedBack($class, $mensagem, 'notificacao');
            return;
        }

        $this->load->helper('date');
        extract($this->input->post());
        
        $diasDiff= ( strtotime(str_replace('/', '-', $datafc)) - strtotime(str_replace('/', '-', $dataic)) ) / 86400;

            $clienteSessao = $this->session->userData('idClienteSessao');
            $isDiferente = false;
            if ($this->input->post('idcliente')!=$clienteSessao){
                $clienteSessao=$this->input->post('idcliente');

            }

        $radios = NULL;
        if (!empty($radio) and is_array($radio)){
            $radios = implode($radio,',');
        } else {
            $radios = !empty($radio)?$radio:NULL;
        }
        $tvs = NULL;
        if (!empty($tv) and is_array($tv)){
            $tvs = implode($tv,',');
        } else {
            $tvs =  !empty($tv)?$tv:NULL;
        }

        $setors = NULL;
        if (!empty($setor) and is_array($setor)){
            $setors = implode($setor,',');
        } else {
            $setors =  !empty($setor)?$setor:NULL;
        }

        $netss = NULL;
        if (!empty($internet) and is_array($internet)){
            $netss = implode($internet,',');
        } else {
            $netss = !empty($internet)?$internet:NULL;
        }

        $impressos = NULL;
        if (!empty($impresso) and is_array($impresso)){
            $impressos = implode($impresso,',');
        } else {
            $impressos = !empty($impresso)?$impresso:NULL;
        }

        $releases = NULL;
        if (!empty($release) and is_array($release)){
            $releases = implode($release,',');
        } else {
            $releases = !empty($release)?$release:NULL;
        }
        $areas = NULL;
        if (!empty($area) and is_array($area)){
            $areas = implode($area,',');
        } else {
            $areas = !empty($area)?$area:NULL;
        }

          //  if (!empty($clienteSessao)) {
                $data = array(
                    'SEQ_CLIENTE' => $clienteSessao,
                    'DT_INICIO' => date('Y-m-d', strtotime(str_replace('/', '-', $dataic))),
                    'DT_FIM' => date('Y-m-d', strtotime(str_replace('/', '-', $datafc))),
                    'TIPO_MATERIA' => empty($tipoMat) ? NULL : $tipoMat,
                    'TIPO_NOTIFICACAO' => $diasDiff>0 ? 'P' : 'D',
                    'GRUPO_PORTAL' => empty($grupo) ? NULL : $grupo,
                    'LISTA_SETOR' => $setors,

                    'LISTA_RADIO' => $radios,
                    'LISTA_TV' => $tvs,

                    'LISTA_PORTAL' => $netss,
                    'LISTA_IMPRESSO' => $impressos,
                    'LISTA_RELEASE' => $releases,
                    'LISTA_AREA' => $areas,
                    'LISTA_TAGS' => $tags,
                    'SEQ_CATEGORIA_SETOR' => empty($categoria) ? 0 : $categoria,
                    'IND_MODELO' => empty($modelo) ? 'N' : $modelo,
                    'AVALIACAO_NOTA'=>empty($avaliacao) ? NULL : $avaliacao,
                    'SEQ_ASSUNTO_GERAL'=> empty($assunto) ? 0 : $assunto,
                    'TIPO_NOTA'=> empty($avulso) ? 'N' : $avulso
                );

                $this->inserirAuditoria('ALTERAR-ALERTA', 'A', json_encode($this->input->post()));
                if (!$this->NotificacaoModelo->alterarNota($data, $idNota)) {
                    $class = 'error';
                    $mensagem = 'Alerta n�o Alterada!!';
                    $this->feedBack($class, $mensagem, 'materia/editar/' . $idMateria);
                    return;
                }
                $class = 'success';
                $mensagem = 'Alerta Alterado com sucesso!!';
//            } else{
//                $class = 'warning';
//                $mensagem = 'No Momento n�o podemos alterar seu Alerta, tente novamente!!';
//            }
//            if (!empty($clienteSessao) and $clienteSessao != $this->session->userData('idClienteSessao')){
//
//                $clienteTema = $this->ComumModelo->getTableData('CLIENTE', array('SEQ_CLIENTE' => $clienteSessao))->row()->TEMA_CLIENTE;
//                if(!empty($clienteTema)){
//                    $dataSessao= array('idClienteSessao'=>'','temaClienteSessao'=>'');
//                    $this->session->unset_userdata($dataSessao);
//                    $dataSessaoNova= array('idClienteSessao'=>$clienteSessao,'eSelecao'=>false,'temaClienteSessao'=>$clienteTema);
//                    $this->session->set_userdata($dataSessaoNova);
//                }
//            }

        if ($this->input->post('acao') == 'S')
            $this->feedBack($class, $mensagem, 'notificacao');
        else
            redirect(base_url('notificacao/editar/' . $idNota));
    }

    private function uniqid_base36($more_entropy=false) {
        $s = uniqid('', $more_entropy);
        if (!$more_entropy)
            return base_convert($s, 16, 36);

        $hex = substr($s, 0, 13);
        $dec = $s[13] . substr($s, 15); // skip the dot
        return base_convert($hex, 16, 36) . base_convert($dec, 10, 36);
    }
    public function excluir($id)
    {

        $this->inserirAuditoria('EXCLUIR-ALERTA', 'E', 'Idnota: ' . $id);

        if ($this->NotificacaoModelo->deletar($id)) {
            $class = 'success';
            $mensagem = 'Mat&eacute;ria Exclu&iacute;da com sucesso!!';
        } else {
            $class = 'error';
            $mensagem = 'Mat&eacute;ria N�o pode ser Exclu&iacute;da!';
        }
        $this->feedBack($class, $mensagem, 'notificacao');
    }
    public function estatistica()
    {
        extract($this->input->post());
        $this->inserirAuditoria('CONSULTA-ESTATISTICA', 'C', '');
        $this->load->helper('date');

        $idcliente = (!empty($idcliente) and $idcliente>0)? $idcliente:

            ((!empty($this->session->userData('idClienteSessao') ))?$this->session->userData('idClienteSessao'):0);


        if(!empty($datair))
            $datair=$datair;
        else
            $datair = date('d/m/Y');

        if(!empty($datafr))
            $datafr=$datafr;
        else
            $datafr = date('d/m/Y');

        $resultado['datair']= $datair;
        $resultado['datafr']= $datafr;
        $resultado['idcliente']= $idcliente;

        $resultado['lista_setor'] = $this->SetorModelo->listaSetorAlerta($idcliente);
        $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateriaAlerta($idcliente);

        $this->loadUrl('modulos/alerta/consultar-estatistica',$resultado);
    }
    public function ajaxAlertaEstatisticaRela(){
        extract($this->input->post());
        
        if(!empty($datair))
            $datair=explode('/',$datair);
        else
            $datair = date('Ymd');

        if(!empty($datafr))
            $datafr=explode('/', $datafr);
        else
            $datafr = date('Ymd');
        
        $datair = $datair[2].$datair[1].$datair[0];
        $datafr = $datafr[2].$datafr[1].$datafr[0];
        
        $SQL = 'SELECT S.DESC_SETOR, M.TIT_MATERIA, M.PROGRAMA_MATERIA, M.LINK_MATERIA, M.RESUMO_MATERIA FROM MATERIA M
        JOIN SETOR S ON S.SEQ_SETOR = M.SEQ_SETOR
        WHERE M.SEQ_CLIENTE = '.$idcliente.'
        AND M.DATA_PUB_NUMERO BETWEEN '.$datair.' AND '.$datafr.'
        ORDER BY M.SEQ_SETOR';

        $materias = $this->db->query($SQL)->result();
        $resposta = '';
        foreach ($materias as $materia) {
            $alfinete = json_decode('"\uD83D\uDCCC"');
            
            $resposta .= $alfinete.$materia->DESC_SETOR.PHP_EOL.$materia->TIT_MATERIA.PHP_EOL.$materia->RESUMO_MATERIA.PHP_EOL.$materia->LINK_MATERIA.PHP_EOL.PHP_EOL;
        }
        
        echo $resposta;
    }
    public function ajaxAlertaEstatistica()
    {
        extract($this->input->post());
        $this->inserirAuditoria('GERAR-ALERTA-ESTATISTICA', 'C', '');
        $this->load->helper('date');
        
        if(!empty($datair))
            $datair=$datair;
        else
            $datair = date('d/m/Y');

        if(!empty($datafr))
            $datafr=$datafr;
        else
            $datafr = date('d/m/Y');

        $lista_alerta = $this->ComumModelo->quantitativoMateriaAlerta($datair, $datafr, $idcliente,$setor,$area);
//        echo '<pre>';
//        print_r($lista_alerta);
//        die();
        $periodo = '';
        if ($datair==$datafr){
            $periodo = 'Período: '.$datair.'- Horário:'.date('H:i');
        } else {
            $periodo = 'Período: '.$datair.'-'.$datafr.'- Horário: '.date('H:i');
        }
        $titulo=NULL;
        $totalAP=''; $totalAN=''; $totalAU=''; $totalAT='';

        $totalIP='0'; $totalIN='0'; $totalIU=''; $totalIT='0';
        $totalSP='0'; $totalSN='0'; $totalSU=''; $totalST='0';
        $totalRP='0'; $totalRN='0'; $totalRU=''; $totalRT='0';
        $totalTP='0'; $totalTN='0'; $totalTU=''; $totalTT='0';
        $flag =false;
        $descSetor='';
        if (!empty($setor))
            $descSetor = PHP_EOL.'*'.trim($this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $setor))->row()->DESC_SETOR).'*';

        $descArea='';
        if (!empty($area))
            $descArea = PHP_EOL.'*'.trim($this->ComumModelo->getTableData('TIPO_MATERIA', array('SEQ_TIPO_MATERIA' => $area))->row()->DESC_TIPO_MATERIA).'*';

        foreach ($lista_alerta as $index => $valor) {
            $flag=true;
            if (empty($titulo)) {
                $titulo = '*' . trim($valor['EMPRESA_CLIENTE']) . '*'.$descSetor.$descArea.PHP_EOL.($periodo).PHP_EOL.PHP_EOL.('*TOTAL GERAL DE PUBLICAÇÕES*').PHP_EOL;
            }
            
            if ($valor['TIPO_MATERIA']=='A'){
                $totalAP =$valor['POSITIVO'];
                $totalAN =$valor['NEGATIVO'];
                $totalAU =$valor['NEUTRO'];
                $totalAT =$valor['TOTAL'];
            }
            if ($valor['TIPO_MATERIA']=='I'){
                $totalIP =$valor['POSITIVO'];
                $totalIN =$valor['NEGATIVO'];
                $totalIU =$valor['NEUTRO'];
                $totalIT =$valor['TOTAL'];
            }
            if ($valor['TIPO_MATERIA']=='S'){
                $totalSP =$valor['POSITIVO'];
                $totalSN =$valor['NEGATIVO'];
                $totalSU =$valor['NEUTRO'];
                $totalST =$valor['TOTAL'];
            }
            if ($valor['TIPO_MATERIA']=='R'){
                $totalRP =$valor['POSITIVO'];
                $totalRN =$valor['NEGATIVO'];
                $totalRU =$valor['NEUTRO'];
                $totalRT =$valor['TOTAL'];
            }
            if ($valor['TIPO_MATERIA']=='T'){
                $totalTP =$valor['POSITIVO'];
                $totalTN =$valor['NEGATIVO'];
                $totalTU =$valor['NEUTRO'];
                $totalTT =$valor['TOTAL'];
            }
        }

        if($flag) {

            
        $descGeral = $titulo
                . PHP_EOL . json_decode('"\u2705"') . ' Positivo: ' . $totalAP
                . PHP_EOL . json_decode('"\uD83D\uDEAB"') . ' Negativo: ' . $totalAN
                . PHP_EOL . json_decode('"\uD83D\uDFE1"') . ' Neutro: ' . $totalAU
                . PHP_EOL . json_decode('"\uD83D\uDD16"').' Total Geral: ' . $totalAT . PHP_EOL;
            
            $descImpresso = PHP_EOL . json_decode('"\uD83D\uDCF0"') . ' *Jornal Impresso*'
                . PHP_EOL . json_decode('"\u2705"') . ' Positivo: ' . $totalIP
                . PHP_EOL . json_decode('"\uD83D\uDEAB"') . ' Negativo: ' . $totalIN
                . PHP_EOL . json_decode('"\uD83D\uDFE1"') . ' Neutro: ' . $totalIU
                . PHP_EOL . json_decode('"\uD83D\uDD16"').' Total Impresso: ' . $totalIT . PHP_EOL;

            $descSite = PHP_EOL . json_decode('"\uD83D\uDCBB"') . ' *Sites*'
                . PHP_EOL . json_decode('"\u2705"') . ' Positivo: ' . $totalSP
                . PHP_EOL . json_decode('"\uD83D\uDEAB"') . ' Negativo: ' . $totalSN
                . PHP_EOL . json_decode('"\uD83D\uDFE1"') . ' Neutro: ' . $totalSU
                . PHP_EOL . json_decode('"\uD83D\uDD16"').' Total Sites: ' . $totalST . PHP_EOL;

            $descRadio = PHP_EOL . json_decode('"\uD83D\uDCFB"') . ' *Rádio*'
                . PHP_EOL . json_decode('"\u2705"') . ' Positivo: ' .$totalRP
                . PHP_EOL . json_decode('"\uD83D\uDEAB"') . ' Negativo: ' . $totalRN
                . PHP_EOL . json_decode('"\uD83D\uDFE1"') . ' Neutro: ' . $totalRU
                . PHP_EOL . json_decode('"\uD83D\uDD16"').' Total Rádio: ' . $totalRT . PHP_EOL;

            $descTv = PHP_EOL . json_decode('"\uD83D\uDCFA"') . ' *Televisão*'
                . PHP_EOL . json_decode('"\u2705"') . ' Positivo: ' . $totalTP
                . PHP_EOL . json_decode('"\uD83D\uDEAB"') . ' Negativo: ' . $totalTN
                . PHP_EOL . json_decode('"\uD83D\uDFE1"') . ' Neutro: ' . $totalTU
                . PHP_EOL . json_decode('"\uD83D\uDD16"').' Total Televisão: ' . $totalTT . PHP_EOL;

            $alertaFInal = $descGeral
                .(($totalIT!='0')?$descImpresso:'')
                .(($totalST!='0')?$descSite:'')
                .(($totalRT!='0')?$descRadio:'')
                .(($totalTT!='0')?$descTv:'');
            
            $txtNeg = '';
            
            if ($negativas == "true") {
                $txtNeg = $this->alertaNegativo($idcliente);
                
            } 

            echo ($alertaFInal.$txtNeg);

        }else{
            echo 'vazio';
        }


    }
    
    private function alertaNegativo($idcliente) {
        // IMPRESSO
        $SQL = 'SELECT VEICULO.NOME_VEICULO, MATERIA.TIT_MATERIA, MATERIA.TEXTO_MATERIA, OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS LINK_MATERIA, MATERIA.RESUMO_MATERIA FROM MATERIA MATERIA 
        JOIN VEICULO VEICULO ON VEICULO.SEQ_VEICULO = MATERIA.SEQ_VEICULO 
        WHERE MATERIA.DATA_PUB_NUMERO = DATE_FORMAT(CURDATE(), "%Y%m%d")
        AND MATERIA.IND_AVALIACAO = "N"
        AND MATERIA.SEQ_CLIENTE = '.$idcliente. ' LIMIT 5';
        
        $result = $this->db->query($SQL)->result();
        
        $txt = '';
        $txt.= PHP_EOL;
        if (!empty($result)) {
            $i = 1;
            $txt .= json_decode('"\uD83D\uDCF0"') . ' IMPRESSO' .PHP_EOL;
            foreach ($result as $item) {
                $txt .= $i. ' - '.trim($item->NOME_VEICULO).PHP_EOL.$item->TIT_MATERIA.PHP_EOL.base_url('v?'.$item->LINK_MATERIA).PHP_EOL.PHP_EOL;
                $txt .= 'Resumo: '.$item->RESUMO_MATERIA.PHP_EOL;
                $i++;
            }
            $txt.= PHP_EOL;
            
        }
        
        $SQL = 'SELECT PORTAL.NOME_PORTAL, MATERIA.TIT_MATERIA, MATERIA.TEXTO_MATERIA, MATERIA.LINK_MATERIA, MATERIA.RESUMO_MATERIA FROM MATERIA MATERIA 
        JOIN PORTAL PORTAL ON PORTAL.SEQ_PORTAL = MATERIA.SEQ_PORTAL 
        WHERE MATERIA.DATA_PUB_NUMERO = DATE_FORMAT(CURDATE(), "%Y%m%d")
        AND MATERIA.IND_AVALIACAO = "N"
        AND MATERIA.SEQ_CLIENTE = '.$idcliente. ' LIMIT 5';
        $result = $this->db->query($SQL)->result();
        if (!empty($result)) {
            $i = 1;
            $txt .= json_decode('"\uD83D\uDCBB"') . ' INTERNET  ' .PHP_EOL;
            foreach ($result as $item) {
                $txt .= $i. ' - '.trim($item->NOME_PORTAL).PHP_EOL.$item->TIT_MATERIA.PHP_EOL.$item->LINK_MATERIA.PHP_EOL.PHP_EOL;
                $txt .= 'Resumo: '.$item->RESUMO_MATERIA.PHP_EOL;
                $i++;
            }
            $txt.= PHP_EOL;
            
        }
        
        $SQL = 'SELECT RADIO.NOME_RADIO, MATERIA.TIT_MATERIA, MATERIA.TEXTO_MATERIA, OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS LINK_MATERIA, MATERIA.RESUMO_MATERIA FROM MATERIA MATERIA 
        JOIN RADIO RADIO ON RADIO.SEQ_RADIO = MATERIA.SEQ_RADIO 
        WHERE MATERIA.DATA_PUB_NUMERO = DATE_FORMAT(CURDATE(), "%Y%m%d")
        AND MATERIA.IND_AVALIACAO = "N"
        AND MATERIA.SEQ_CLIENTE = '.$idcliente. ' LIMIT 5';
        
        $result = $this->db->query($SQL)->result();
        if (!empty($result)) {
            $i = 1;
            $txt .= json_decode('"\uD83D\uDCFB"') . ' RÁDIO  ' .PHP_EOL;
            foreach ($result as $item) {
                $txt .= $i. ' - '.trim($item->NOME_RADIO).PHP_EOL.$item->TIT_MATERIA.PHP_EOL.base_url('v?'.$item->LINK_MATERIA).PHP_EOL.PHP_EOL;
                $txt .= 'Resumo: '.$item->RESUMO_MATERIA.PHP_EOL;
                $i++;
            }
            $txt.= PHP_EOL;
            
        }
        
        $SQL = 'SELECT TELEVISAO.NOME_TV, MATERIA.TIT_MATERIA, MATERIA.TEXTO_MATERIA, OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS LINK_MATERIA, MATERIA.RESUMO_MATERIA FROM MATERIA MATERIA 
        JOIN TELEVISAO TELEVISAO ON TELEVISAO.SEQ_TV = MATERIA.SEQ_TV 
        WHERE MATERIA.DATA_PUB_NUMERO = DATE_FORMAT(CURDATE(), "%Y%m%d")
        AND MATERIA.IND_AVALIACAO = "N"
        AND MATERIA.SEQ_CLIENTE = '.$idcliente. ' LIMIT 5';
        
        $result = $this->db->query($SQL)->result();
        if (!empty($result)) {
            $i = 1;
            $txt .= json_decode('"\uD83D\uDCFA"') . ' TV  ' .PHP_EOL;
            foreach ($result as $item) {
                $txt .= $i. ' - '.trim($item->NOME_TV).PHP_EOL.$item->TIT_MATERIA.PHP_EOL.base_url('v?'.$item->LINK_MATERIA).PHP_EOL.PHP_EOL;
                $txt .= 'Resumo: '.$item->RESUMO_MATERIA.PHP_EOL;
                $i++;
            }
            $txt.= PHP_EOL;
            
        }
        
        return $txt;
    }
}
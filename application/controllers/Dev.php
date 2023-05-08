<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dev extends CI_Controller {
    
    public function criaNotaPeriodo() {
      
        $dateStart 		= '28/04/2023';
        $dateStart 		= implode('-', array_reverse(explode('/', substr($dateStart, 0, 10)))).substr($dateStart, 10);
        $dateStart 		= new DateTime($dateStart);
        
        //End date
        $dateEnd 		= '31/12/2023';
        $dateEnd 		= implode('-', array_reverse(explode('/', substr($dateEnd, 0, 10)))).substr($dateEnd, 10);
        $dateEnd 		= new DateTime($dateEnd);
        
        //Prints days according to the interval
        $dateRange = array();
        while($dateStart <= $dateEnd){
            $dateRange[] = $dateStart->format('Y-m-d');
            $dateStart = $dateStart->modify('+1day');
        }
        
        foreach ($dateRange as $data) {
            $s = uniqid('', FALSE);
            $hash = base_convert($s, 16, 36);
            $this->insereNota($hash, $data, 'T', 70, 'NULL', NULL);
        }
       
    }
    
    private function insereNota($hash, $data, $midia, $cliente, $setor, $avaliacaoNota) {
        $SQL = "INSERT INTO `NOTA` (`SEQ_USUARIO`, `SEQ_CLIENTE`, `DT_INICIO`, `DT_FIM`, `QTD_MATERIA`, `TIT_NOTIFICACAO`, `CHAVE_NOTIFICACAO`, `TIPO_NOTIFICACAO`, `TIPO_MATERIA`,`GRUPO_PORTAL`, `IND_ATIVO`, `LISTA_SETOR`, `IND_MODELO`, `SEQ_CATEGORIA_SETOR`, `AVALIACAO_NOTA`, `SEQ_ASSUNTO_GERAL`, `TIPO_NOTA`, `LISTA_RADIO`, `LISTA_TV`, `LISTA_RELEASE`, `LISTA_PORTAL`, `LISTA_IMPRESSO`, `LISTA_AREA`, `LISTA_TAGS`) VALUES
(0, ".$cliente.", '".$data." 00:00:00', '".$data." 00:00:00', 0, NULL, '".$hash."', 'D', '".$midia."', NULL, 'S', ".$setor.", 'N', 0, '".$avaliacaoNota."', 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, '')";
        echo $SQL.'<br><br>';
        //die();
        $this->db->query($SQL);    
    }
    public function feedBack($tipo, $msg,$target)
    {
        $this->session->set_flashdata('flash_message', $this->ComumModelo->flash_message($tipo, $msg));
        redirect($target);
    }
    
    public function auditoriaMensal() {
        $dataInicio = str_replace('-', '', implode('-', array_reverse(explode('/', $this->input->post('datair')))));
        $dataFim = str_replace('-', '', implode('-', array_reverse(explode('/', $this->input->post('datafr')))));

        $this->db->select('SEQ_USUARIO');
        $where = 'DATA_NUMERO BETWEEN "' . $dataInicio . '" AND "' . $dataFim . '"';
        $this->db->where($where);
        $this->db->where('SEQ_USUARIO IS NOT NULL');
        $this->db->group_by('SEQ_USUARIO');
        $audi = $this->db->get('AUDITORIA')->result();
        $usuario = $audi[0]->SEQ_USUARIO;
        
        $spreadsheet = new Spreadsheet();
        $u = 0;
        foreach ($audi as $colaborador) {
            if ($usuario !== $colaborador->SEQ_USUARIO) {
                    $u++;
            }
            
            $result = $this->getAuditoriaUsuario($colaborador->SEQ_USUARIO, $dataInicio, $dataFim);
            if ($u == 0) {
            $sheet = $spreadsheet->getActiveSheet($u);
            } else {
            $sheet = $spreadsheet->createSheet($u);  
            }
            $sheet->setTitle($result[0]->NOME_USUARIO);
            $col = [
                ['USUARIO', 'AÇÃO', 'DESCRIÇÃO', 'DATA', 'HORA']
            ];

            $sheet->fromArray($col, NULL, 'A1');
            $sheet->getColumnDimension('A')->setWidth(30);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getColumnDimension('D')->setWidth(13);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('C1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('D1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('E1')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $sheet->getStyle('B1')->getFont()->setBold(true);
            $sheet->getStyle('C1')->getFont()->setBold(true);
            $sheet->getStyle('D1')->getFont()->setBold(true);
            $sheet->getStyle('E1')->getFont()->setBold(true);
            $i = 2;
            $diaAnterior = explode(' ', $result[0]->DATA_AUDITORIA)[0];

            foreach ($result as $acao) {
                $data = explode(' ', $acao->DATA_AUDITORIA);
                $dataconv = implode('/', array_reverse(explode('-', $data[0])));
                $sheet->setCellValue('A' . $i, $acao->NOME_USUARIO);
                $ac = $this->ajustaAcao($acao->OPER_AUDITORIA);
                if (empty($ac)) {
                    $sheet->setCellValue('B' . $i, $acao->OPER_AUDITORIA);
                } else {
                    $sheet->setCellValue('B' . $i, $ac);
                }

                $detalhe = $this->ajusteDetalhes($acao->OPER_AUDITORIA, $acao->OBS_AUDITORIA);

                if (empty($detalhe)) {
                    if (empty($acao->OBS_AUDITORIA)) {
                        $sheet->setCellValue('C' . $i, '-');
                    } else {
                        $sheet->setCellValue('C' . $i, $acao->OBS_AUDITORIA);
                    }
                } else {
                    $sheet->setCellValue('C' . $i, $detalhe);
                }
                $sheet->setCellValue('D' . $i, $dataconv);
                $sheet->setCellValue('E' . $i, $data[1]);

                if ($diaAnterior !== $data[0]) {
                    $i = $i + 1;
                }
                $i++;
                $diaAnterior = $data[0];
            }
            $i = $i + 1;
            $sheet->setCellValue('A' . $i, 'TOTAL');
            $sheet->getStyle('A' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
            $sheet->setCellValue('B' . $i, count($result) . ' AÇÕES EXECUTADAS NO SISTEMA');
            $sheet->getStyle('B' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
            $sheet->getStyle('A' . $i)->getFont()->setBold(true);
            $sheet->getStyle('B' . $i)->getFont()->setBold(true);
            $writer = new Xlsx($spreadsheet);
        }

        $uuid = rand(0, 10000);
        $arquivo = FCPATH . 'lixo/' . (date('dmY')) . 'auditoria-mensal.xlsx';
        $writer->save($arquivo);
        $this->load->helper('download');
        $dataBinary = file_get_contents($arquivo);
        force_download(basename($arquivo), $dataBinary, TRUE);
        unlink($arquivo);
    }

    public function auditoria() {
        $idUsuario = $this->input->post('usuario');
        $dataInicio = implode('-', array_reverse(explode('/', $this->input->post('datair'))));
        $dataFim = implode('-', array_reverse(explode('/', $this->input->post('datafr'))));

        $result = $this->getAuditoriaUsuario($idUsuario, str_replace('-', '', $dataInicio), str_replace('-', '',$dataFim));
        if (empty($result)) {
            $class = 'warning';
            $mensagem = 'Nenhum resultado encontrado para o período informado';
            $this->feedBack($class, $mensagem, 'usuario');
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $col = [
            ['USUARIO', 'AÇÃO', 'DESCRIÇÃO', 'DATA', 'HORA']
        ];

        $sheet->fromArray($col, NULL, 'A1');
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('C1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('B1')->getFont()->setBold(true);
        $sheet->getStyle('C1')->getFont()->setBold(true);
        $sheet->getStyle('D1')->getFont()->setBold(true);
        $sheet->getStyle('E1')->getFont()->setBold(true);
        $i = 2;
        $diaAnterior = explode(' ', $result[0]->DATA_AUDITORIA)[0];
        
        foreach ($result as $acao) {
            $data = explode(' ', $acao->DATA_AUDITORIA);
            $dataconv = implode('/', array_reverse(explode('-', $data[0])));
            $sheet->setCellValue('A' . $i, $acao->NOME_USUARIO);
            $ac = $this->ajustaAcao($acao->OPER_AUDITORIA);
            if (empty($ac)) {
                $sheet->setCellValue('B' . $i, $acao->OPER_AUDITORIA);
            } else {
                $sheet->setCellValue('B' . $i, $ac);
            }

            $detalhe = $this->ajusteDetalhes($acao->OPER_AUDITORIA, $acao->OBS_AUDITORIA);

            if (empty($detalhe)) {
                if (empty($acao->OBS_AUDITORIA)) {
                   $sheet->setCellValue('C' . $i, '-'); 
                } else {
                   $sheet->setCellValue('C' . $i, $acao->OBS_AUDITORIA); 
                }     
            } else {
                $sheet->setCellValue('C' . $i, $detalhe);
            }
            $sheet->setCellValue('D' . $i, $dataconv);
            $sheet->setCellValue('E' . $i, $data[1]);

            if ($diaAnterior !== $data[0]) {
                $i = $i + 1;
            }
            $i++;
            $diaAnterior = $data[0];
        }
        $i = $i + 1;
        $sheet->setCellValue('A' . $i, 'TOTAL');
        $sheet->getStyle('A' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
        $sheet->setCellValue('B' . $i, count($result). ' AÇÕES EXECUTADAS NO SISTEMA');
        $sheet->getStyle('B' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
        $sheet->getStyle('A' . $i)->getFont()->setBold(true);
        $sheet->getStyle('B' . $i)->getFont()->setBold(true);
        $writer = new Xlsx($spreadsheet);
        $uuid = rand(0, 10000);
        $arquivo = FCPATH . 'lixo/' . (date('dmY')) . 'auditoria.xlsx';
        $writer->save($arquivo);
        $this->load->helper('download');
        $dataBinary = file_get_contents($arquivo);
        force_download(basename($arquivo), $dataBinary, TRUE);
        unlink($arquivo);
        
    }
    

    private function ajusteDetalhes($acao, $detalhe) {
        $txt = '';

        switch ($acao) {
            case 'INSERIR-MATERIA':
                $json = json_decode($detalhe);
                $this->db->join('CLIENTE C', 'C.SEQ_CLIENTE = M.SEQ_CLIENTE');
                $this->db->where('M.SEQ_CLIENTE', $json->SEQ_CLIENTE);
                $this->db->where('M.TIPO_MATERIA', $json->TIPO_MATERIA);
                $this->db->where('M.DATA_MATERIA_CAD', $json->DATA_MATERIA_CAD);
                $materia = $this->db->get('MATERIA M')->row_array();
                $txt = '{"TITULO":"' . $materia['TIT_MATERIA'] . '", "CLIENTE":"' . $materia['NOME_CLIENTE'] . '" ,"TIPO_MATERIA":"' . $this->tipoMateria($materia['TIPO_MATERIA']) . '", "AVALIAÇÃO": "' . $this->avaliacaoMateria($materia['IND_AVALIACAO']) . '"}';
                break;
            case 'VERIFICA-LINK-ALTERAR':
                $txt = '-';
                break;
            case 'ALTERAR-MATERIA':
                $json = json_decode($detalhe);
                if (json_last_error() == 0) {
                $this->db->join('CLIENTE C', 'C.SEQ_CLIENTE = M.SEQ_CLIENTE');
                $this->db->where('M.SEQ_MATERIA', $json->idMateria);
                $materia = $this->db->get('MATERIA M')->row_array();
                $txt = '{"TITULO":"' . $materia['TIT_MATERIA'] . '", "CLIENTE":"' . $materia['NOME_CLIENTE'] . '" ,"TIPO_MATERIA":"' . $this->tipoMateria($materia['TIPO_MATERIA']) . '", "AVALIAÇÃO": "' . $this->avaliacaoMateria($materia['IND_AVALIACAO']) . '"}';
                } else {
                $txt = $detalhe;    
                }
                break;
            case 'SETA-CLIENTE-SESSAO':
                $json = explode(':', $detalhe);
                $this->db->where('SEQ_CLIENTE', $json[1]);
                $cli = $this->db->get('CLIENTE')->row_array();
                $txt = 'CLIENTE: ' . $cli['NOME_CLIENTE'];
                break;
            default:
                break;
        }

        return $txt;
    }

    private function avaliacaoMateria($aval) {
        switch ($aval) {
            case 'P':
                $aval = 'POSITIVA';
                break;
            case 'N':
                $aval = 'NEGATIVA';
                break;
            case 'T':
                $aval = 'NEUTRA';
                break;
            default:
                break;
        }

        return $aval;
    }

    private function tipoMateria($tipo) {

        switch ($tipo) {
            case 'T':
                $tipo = 'TV';
                break;
            case 'I':
                $tipo = 'IMPRESSO';
                break;
            case 'R':
                $tipo = 'RÁDIO';
                break;
            case 'S':
                $tipo = 'INTERNET';
                break;
            default:
                break;
        }
        return $tipo;
    }

    private function ajustaAcao($acao) {
        $txt = '';
        switch ($acao) {
            case 'CONSULTA-MATERIA':
                $txt = 'CONSULTA DE MATÉRIA';
                break;
            case 'INSERIR-MATERIA':
                $txt = 'INSERIU MATÉRIA';
                break;
            case 'ALTERAR-MATERIA':
                $txt = 'ALTEROU MATERIA';
                break;
            case 'VERIFICA-LINK-ALTERAR':
                $txt = 'VERIFICOU LINK DE MATÉRIA';
                break;
            case 'LOGIN-SISTEMA':
                $txt = 'LOGOU NO SISTEMA';
                break;
            case 'CONSULTA-ALERTAS':
                $txt = 'CONSULTOU ALERTAS';
                break;
            case 'SETA-CLIENTE-SESSAO':
                $txt = 'ACESSOU CLIENTE';
                break;
            case 'CONSULTAR-RELEASE':
                $txt = 'CONSULTOU RELEASE';
                break;
            case 'INSERIR-RELEASE':
                $txt = 'INSERIU RELEASE';
                break;
            case 'ALTERAR-RELEASE':
                $txt = 'ALTEROU RELEASE';
                break;
            case 'CONSULTA-ESTATISTICA':
                $txt = 'CONSULTOU ESTATISTICA';
                break;
            case 'GERAR-ALERTA-ESTATISTICA':
                $txt = 'GEROU ALERTA DE ESTATISTICA';
                break;
            case 'INSERIR-ALERTA':
                $txt = 'INSERIU ALERTA';
                break;
            case 'ALTERAR-ALERTA':
                $txt = 'ALTEROU ALERTA';
                break;
            case 'VERIFICA-LINK':
                $txt = 'VERIFICOU LINK DE MATÉRIA';
                break;
            default:
                break;
        }
        return $txt;
    }

    private function getAuditoriaUsuario($idUsuario, $dataInicio, $dataFim) {
        $this->db->join('USUARIO U', 'U.SEQ_USUARIO = A.SEQ_USUARIO');
        if (!empty($idUsuario)) {
            $this->db->where('A.SEQ_USUARIO', $idUsuario);
        }
        $where = 'DATA_NUMERO BETWEEN "' . $dataInicio . '" AND "' . $dataFim . '"';
        $this->db->where($where);
        return $this->db->get('AUDITORIA A')->result();
    }
    
    private function getAuditoriaTodos($dataInicio, $dataFim) {
        $this->db->join('USUARIO U', 'U.SEQ_USUARIO = A.SEQ_USUARIO');
        $where = 'A.DATA_NUMERO BETWEEN "' . $dataInicio . '" AND "' . $dataFim . '"';
        $this->db->where($where);
        return $this->db->get('AUDITORIA A')->result();
    }
    
    public function gerarelatorioinsercao() {
        $dados = $this->input->post();

        $dataInicio = explode('/', $dados['datainicio']);
        $dataFim = explode('/', $dados['datainicio']);

        $dataInicio = $dataInicio[2] . $dataInicio[1] . $dataInicio[0];
        $dataFim = $dataFim[2] . $dataFim[1] . $dataFim[0];
        $SQL = "SELECT TELEVISAO.NOME_TV,  MATERIA.PROGRAMA_MATERIA, DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%d/%m/%Y') AS DATA, DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%H:%ih') AS HORA, S.DESC_SETOR, TM.DESC_TIPO_MATERIA, TELEVISAO.SEQ_TV FROM MATERIA MATERIA
        JOIN TELEVISAO TELEVISAO ON TELEVISAO.SEQ_TV = MATERIA.SEQ_TV
        JOIN SETOR S ON S.SEQ_SETOR = MATERIA.SEQ_SETOR
        JOIN TIPO_MATERIA TM ON TM.SEQ_TIPO_MATERIA = MATERIA.SEQ_TIPO_MATERIA
        WHERE DATA_PUB_NUMERO BETWEEN " . $dataInicio . " AND " . $dataFim . "
        AND MATERIA.SEQ_SETOR = " . $dados['setor'] . " AND MATERIA.SEQ_TIPO_MATERIA = " . $dados['area'] . ' GROUP BY MATERIA.SEQ_TV ORDER BY MATERIA.HORA_MATERIA';
        $query['resultado'] = $this->db->query($SQL)->result();

        $query['dados'] = $dados;
        $query['dataInicio'] = $dataInicio;
        $query['dataFim'] = $dataFim;
        $this->load->library('pdf');

        if ($_POST['acao'] == 'pdf') {
            $html = $this->load->view('modulos/relatorio/insercao', $query, true);
            $pdf = $this->pdf->load('c', 'A5', '', '', 42, 15, 57, 57, 20, 17);
            $pdf->AddPage('L');
            $pdf->WriteHTML($html);
            $pdf->charset_in = 'UTF-8';
            $uuid = rand(0, 10000);
            $arquivo = (date('dmY')) . 'insercaoArquivo' . $uuid . '.pdf';
            $pdf->Output($arquivo, 'D');
        } else {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getColumnDimension('A')->setWidth(30);    // EMISSORA
            $sheet->getColumnDimension('C')->setWidth(20);   // PROGRAMA - BLOCO 1 
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(23);

            $sheet->setCellValue('E1', 'INSERÇÕES DIÁRIAS TV FISCAL – CANDIDATO WILSON LIMA');
            $sheet->getStyle('E1')->getFont()->setBold(true);
            $sheet->setCellValue('E3', 'GOVERNO - DATA: ' . $dados['datainicio'] . ' (B1/ B2/ B3)');
            $sheet->getStyle('E3')->getFont()->setBold(true);
            $sheet->getStyle('A3:K3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('93d04e');
            // ESTILO DO CABEÇALHO
            $sheet->getStyle('A4:K4')->getFont()->setBold(true);
            $sheet->getStyle('A4:H4')->getFont()->setSize(11);
            $sheet->getStyle('A4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
            $sheet->getStyle('L4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
            $sheet->getStyle('B4:K4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('99b0cf');
            $sheet->getStyle('B')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('D')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('K')->getAlignment()->setHorizontal('center');

            $sheet->getStyle('E')->getAlignment()->setHorizontal('center');

            // DEFINE AS COLUNAS

            $col = [
                ['EMISSORA', 'TSE', 'PROGRAMA', 'HORA', 'BLOCO 1', 'PROGRAMA', 'HORA', 'BLOCO 2', 'PROGRAMA', 'HORA', 'BLOCO 3', 'TOTAL']
            ];

            $sheet->fromArray($col, NULL, 'A4');
            $i = 5;   // LINHA INICIAL DA COLUNA DE EMISSORA
            $totAnt = 0;
            $ctrl = 0;
            foreach ($query['resultado'] as $emissora) {
                $sheet->setCellValue('A' . $i, $emissora->NOME_TV);
                $sheet->setCellValue('B' . $i, 25); // TSE

                $SQL = "SELECT MATERIA.PROGRAMA_MATERIA, DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%d/%m/%Y') AS DATA, TRIM(MATERIA.HORA_MATERIA) AS HORA, S.DESC_SETOR, TM.DESC_TIPO_MATERIA FROM MATERIA MATERIA
                JOIN SETOR S ON S.SEQ_SETOR = MATERIA.SEQ_SETOR
                JOIN TIPO_MATERIA TM ON TM.SEQ_TIPO_MATERIA = MATERIA.SEQ_TIPO_MATERIA
                WHERE DATA_PUB_NUMERO BETWEEN " . $dataInicio . " AND " . $dataFim . "
                AND MATERIA.SEQ_SETOR = " . $dados['setor'] . " AND MATERIA.SEQ_TV = " . $emissora->SEQ_TV . " AND MATERIA.SEQ_TIPO_MATERIA = " . $dados['area'] . ' AND TRIM(MATERIA.HORA_MATERIA) BETWEEN "04:00:00" AND "11:00:59"  ORDER BY MATERIA.HORA_MATERIA, MATERIA.PROGRAMA_MATERIA, MATERIA.DATA_MATERIA_CAD';
                $query = $this->db->query($SQL)->result();
                $tot1 = count($query);
                if (!empty($query)) {
                    $col = $i;
                    foreach ($query as $programa) {
                        $sheet->setCellValue('C' . $col, $programa->PROGRAMA_MATERIA);
                        $sheet->setCellValue('D' . $col, $programa->HORA);
                        $sheet->setCellValue('E' . $col, 1);
                        $sheet->getStyle('E' . $col)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
                        $col++;
                    }
                }

                $SQL = "SELECT MATERIA.PROGRAMA_MATERIA, DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%d/%m/%Y') AS DATA, TRIM(MATERIA.HORA_MATERIA) AS HORA, S.DESC_SETOR, TM.DESC_TIPO_MATERIA FROM MATERIA MATERIA
                JOIN SETOR S ON S.SEQ_SETOR = MATERIA.SEQ_SETOR
                JOIN TIPO_MATERIA TM ON TM.SEQ_TIPO_MATERIA = MATERIA.SEQ_TIPO_MATERIA
                WHERE DATA_PUB_NUMERO BETWEEN " . $dataInicio . " AND " . $dataFim . "
                AND MATERIA.SEQ_SETOR = " . $dados['setor'] . " AND MATERIA.SEQ_TV = " . $emissora->SEQ_TV . " AND MATERIA.SEQ_TIPO_MATERIA = " . $dados['area'] . ' AND TRIM(MATERIA.HORA_MATERIA) BETWEEN "11:01:00" AND "18:00:59"  ORDER BY MATERIA.HORA_MATERIA, MATERIA.PROGRAMA_MATERIA, MATERIA.DATA_MATERIA_CAD';
                $query = $this->db->query($SQL)->result();
                $tot2 = count($query);
                if (!empty($query)) {
                    $col = $i;
                    foreach ($query as $programa) {
                        $sheet->setCellValue('F' . $col, $programa->PROGRAMA_MATERIA);
                        $sheet->setCellValue('G' . $col, $programa->HORA);
                        $sheet->setCellValue('H' . $col, 1);
                        $sheet->getStyle('H' . $col)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
                        $sheet->getStyle('H' . $col)->getAlignment()->setHorizontal('center');
                        $col++;
                    }
                }

                $SQL = "SELECT MATERIA.PROGRAMA_MATERIA, DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%d/%m/%Y') AS DATA, TRIM(MATERIA.HORA_MATERIA) AS HORA, S.DESC_SETOR, TM.DESC_TIPO_MATERIA FROM MATERIA MATERIA
                JOIN SETOR S ON S.SEQ_SETOR = MATERIA.SEQ_SETOR
                JOIN TIPO_MATERIA TM ON TM.SEQ_TIPO_MATERIA = MATERIA.SEQ_TIPO_MATERIA
                WHERE DATA_PUB_NUMERO BETWEEN " . $dataInicio . " AND " . $dataFim . "
                AND MATERIA.SEQ_SETOR = " . $dados['setor'] . " AND MATERIA.SEQ_TV = " . $emissora->SEQ_TV . " AND MATERIA.SEQ_TIPO_MATERIA = " . $dados['area'] . ' AND TRIM(MATERIA.HORA_MATERIA) BETWEEN "18:01:00" AND "23:59:59"  ORDER BY MATERIA.HORA_MATERIA, MATERIA.PROGRAMA_MATERIA, MATERIA.DATA_MATERIA_CAD';
                $query = $this->db->query($SQL)->result();
                $tot3 = count($query);
                if (!empty($query)) {
                    $col = $i;
                    foreach ($query as $programa) {
                        $sheet->setCellValue('I' . $col, $programa->PROGRAMA_MATERIA);
                        $sheet->setCellValue('J' . $col, $programa->HORA);
                        $sheet->setCellValue('K' . $col, 1);
                        $sheet->getStyle('K' . $col)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
                        $col++;
                    }
                }
                // VERIFICA QUAL BLC TEM MAIS RESULTADOS (COLUNAS)
                if ($tot1 <= $tot2) {
                    if ($ctrl == 0) {
                        $i = $tot2 + 5;
                    } else {
                        $i = $tot2 + 1;
                    }
                } else {
                    if ($ctrl == 0) {
                        $i = $tot1 + 5;
                    } else {
                        $i = $tot1 + 1;
                    }
                }

                if ($tot3 > $tot2) {
                    if ($ctrl == 0) {
                        $i = $tot3 + 5;
                    } else {
                        $i = $tot3 + 1;
                    }
                }

                $totAnt = $totAnt + $i;
                $i = $totAnt + 1;
                $ctrl++;
            }
            // RODAPÉ
            $sheet->setCellValue('A' . $i, 'TOTAL');
            $sheet->getStyle('A' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
            $sheet->setCellValue('B' . $i, '');
            $sheet->getStyle('B' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
            $sheet->setCellValue('I' . $i, 'TOTAL DE INSERÇÕES VEICULADAS');
            $sheet->getStyle('I' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('bdbdbd');
            $sheet->mergeCells('I' . $i . ':K' . $i);
            $sheet->setCellValue('L' . $i, '');
            $sheet->getStyle('L' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');
            $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(26);
            // SALVA O ARQUIVO
            $writer = new Xlsx($spreadsheet);
            $uuid = rand(0, 10000);
            $arquivo = FCPATH . 'lixo/' . (date('dmY')) . 'insercaoArquivo.xlsx';
            $writer->save($arquivo);
            $this->load->helper('download');
            $dataBinary = file_get_contents($arquivo);
            force_download(basename($arquivo), $dataBinary, TRUE);
            unlink($arquivo);
        }
    }

    private function download($url, $nomeAquivo) {
        $ch = curl_init();
        /**
         * Set the URL of the page or file to download.
         */
        curl_setopt($ch, CURLOPT_URL, $url);

        $fp = fopen($nomeAquivo . '.docx', 'w+');
        /**
         * Ask cURL to write the contents to a file
         */
        curl_setopt($ch, CURLOPT_FILE, $fp);

        curl_exec($ch);

        curl_close($ch);
        fclose($fp);
        $this->load->helper('download');
        $dir = './' . $nomeAquivo . '.docx';
        $dataBinary = file_get_contents($dir);
        force_download(basename($dir), $dataBinary, TRUE);
        unlink(realpath($dir));
    }

    public function apagaSetor() {
        die();
        $setor = 18;

        $result = $this->db->query("SELECT * FROM `NOTA` WHERE `LISTA_SETOR` = " . $setor . " AND DATE(`DT_INICIO`) BETWEEN CURDATE() AND '2022-12-31' ORDER BY `NOTA`.`DT_INICIO` ASC")->result();
//        echo '<pre>';
//        print_r($result);
//        die();
        foreach ($result as $value) {
            echo 'APAGANDO ' . $value->SEQ_NOTIFICACAO . '<BR>';
            $this->db->where('SEQ_NOTIFICACAO', $value->SEQ_NOTIFICACAO);
            $this->db->delete('NOTA');
        }
    }

    public function criaAlertaSetor() {
        $this->db->query("INSERT INTO `NOTA` (`SEQ_USUARIO`, `SEQ_CLIENTE`, `DT_INICIO`, `DT_FIM`, `QTD_MATERIA`, `TIT_NOTIFICACAO`, `CHAVE_NOTIFICACAO`, `TIPO_NOTIFICACAO`, `TIPO_MATERIA`, `DT_CADASTRO`, `GRUPO_PORTAL`, `IND_ATIVO`, `LISTA_SETOR`, `IND_MODELO`, `SEQ_CATEGORIA_SETOR`, `AVALIACAO_NOTA`, `SEQ_ASSUNTO_GERAL`, `TIPO_NOTA`, `LISTA_RADIO`, `LISTA_TV`, `LISTA_RELEASE`, `LISTA_PORTAL`, `LISTA_IMPRESSO`, `LISTA_AREA`, `LISTA_TAGS`) "
                . "VALUES (1, 1, '2022-08-31 00:00:00', '2022-08-31 00:00:00', 0, NULL, 'h5ogowhqmi', 'D', NULL, '2022-08-29 23:57:23', NULL, 'S', '18', 'N', 0, NULL, 0, 'N', NULL, NULL, NULL, NULL, NULL, NULL, '');");
    }

    public function arrumatexto($txt) {
        $arrumaTxt = explode('*', $txt);
        if (isset($arrumaTxt[13])) {
            $txtCorrigido = '*' .
                    $arrumaTxt[1] . '*' . PHP_EOL . '*' .
                    $arrumaTxt[3] . '*' . PHP_EOL . PHP_EOL . '*' .
                    trim($arrumaTxt[4]) . '*' . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[11]) . PHP_EOL .
                    trim($arrumaTxt[12]) . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[9]) . PHP_EOL .
                    trim($arrumaTxt[10]) . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[7]) . PHP_EOL .
                    trim($arrumaTxt[8]) . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[5]) . PHP_EOL .
                    trim($arrumaTxt[6]) . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[13]) . PHP_EOL .
                    trim($arrumaTxt[14]) . PHP_EOL . PHP_EOL;
        } else {
            $txtCorrigido = '*' .
                    $arrumaTxt[1] . '*' . PHP_EOL . '*' .
                    $arrumaTxt[3] . '*' . PHP_EOL . PHP_EOL . '*' .
                    trim($arrumaTxt[4]) . '*' . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[11]) . PHP_EOL .
                    trim($arrumaTxt[12]) . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[9]) . PHP_EOL .
                    trim($arrumaTxt[10]) . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[7]) . PHP_EOL .
                    trim($arrumaTxt[8]) . PHP_EOL . PHP_EOL .
                    trim($arrumaTxt[5]) . PHP_EOL .
                    trim($arrumaTxt[6]) . PHP_EOL . PHP_EOL;
        }
        return $txtCorrigido;
    }
    
    public function criaNota($limite) {
        $more_entropy = false;
        
        $i = 1;
        while ($i <= $limite) {
            $s = uniqid('', $more_entropy);
            $hex = substr($s, 0, 13);
            $dec = $s[13] . substr($s, 15); 
            echo base_convert($hex, 16, 36) . base_convert($dec, 10, 36);
            echo '<br>';
            $i++;
        }
    }

}

<?php

/* ini_set('display_errors', 1);
ini_set('display_startup_erros', 1); */
error_reporting(E_ALL);

require FCPATH . 'vendor/autoload.php';

class RelatorioLink extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
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

    public function relatorioPDFLink()
    {
        if (isset($_SESSION['logado']) and $_SESSION['logado'] == 1) {
            $this->validaOperacao('relatorio');
            if (empty($_POST['veiculo'])) {
                $class = 'warning';
                $mensagem = 'Selecione um veículo';
                $this->feedBack($class, $mensagem, 'relatorio');
            }
            if ($_POST['veiculo'] != 'G') {
                $resultado = $this->pdfConsulta($_POST);
            } else {
                $resultado = $this->pdfConsultaGeral($_POST);
            }
            if (empty($resultado)) {
                $class = 'warning';
                $mensagem = 'Nenhuma mídia encontrada para o período';
                $this->feedBack($class, $mensagem, 'relatorio');
            }
            $dados = [
                'resultado' => $resultado
            ];
            if ($_POST['veiculo'] != 'G') {
                $this->pdfTemplate($dados['resultado'], $_POST['veiculo'], $_POST['datainicio'], $_POST['datafim']);
            } else {
                $this->pdfTemplateGeral($dados['resultado'], $_POST['veiculo'], $_POST['datainicio'], $_POST['datafim']);
            }
            //$this->word($dados['resultado'], $_POST['veiculo'], $_POST['datainicio'], $_POST['datafim']);
        }
    }

    private function pdfConsultaGeral($dados)
    {

        $data = [
            'T' => $this->ComumModelo->quantitativoVeiculo($dados['datainicio'], $dados['datafim'], 1, NULL, 'T', NULL, NULL),
            'I' => $this->ComumModelo->quantitativoVeiculo($dados['datainicio'], $dados['datafim'], 1, NULL, 'I', NULL, NULL),
            'R' => $this->ComumModelo->quantitativoVeiculo($dados['datainicio'], $dados['datafim'], 1, NULL, 'R', NULL, NULL)

        ];

        return $data;
    }

    private function mesRelatorio($data)
    {
        $dataMes = explode('/', $data);

        switch ($dataMes[1]) {
            case '01':
                $mes = 'Janeiro';
                break;
            case '02':
                $mes = 'Fevereiro';
                break;
            case '03':
                $mes = 'Março';
                break;
            case '04':
                $mes = 'Abril';
                break;
            case '05':
                $mes = 'Maio';
                break;
            case '06':
                $mes = 'Junho';
                break;
            case '07':
                $mes = 'Julho';
                break;
            case '08':
                $mes = 'Agosto';
                break;
            case '09':
                $mes = 'Setembro';
                break;
            case '10':
                $mes = 'Outubro';
                break;
            case '11':
                $mes = 'Novembro';
                break;
            case '12':
                $mes = 'Dezembro';
                break;
            default:
                # code...
                break;
        }

        return $mes;
    }

    private function pdfTemplateGeral($resultado, $veiculo, $dtinicio, $dtfim)
    {
        $mes = $this->mesRelatorio($dtinicio);

        switch ($veiculo) {
            case 'R':
                $midia = 'Rádio';
                $versao = '1.4.5';
                break;
            case 'T':
                $midia = 'Televisão';
                $versao = '1.4.4';
                break;
            default:
                $versao = '1.4.1';
                $midia = 'Análise de Jornais, Televisões, Rádios e Revistas';
                break;
        }

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->AddPage();
        $pdf->SetFont('calibri');
        $dir = str_replace("\\", '/', FCPATH) . '/pdf/';
        $pdf->Image($dir . 'TEMPLATE_page-0001.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $pdf->WriteFixedPosHTML('<p style="font-size: 35px; color:white; font-family: calibri; font-weight: bold">Clipping ' . $midia . '</p>', 95, 185, 100, 100, 'auto');
        $pdf->WriteFixedPosHTML('<p style="font-size: 25px; color:white; font-family: calibri; font-weight: bold">' . $mes . ' de ' . date("Y") . '</p>', 100, 251, 100, 100, 'auto');
        $pdf->AddPage();
        $pdf->Image($dir . 'TEMPLATE_page-0002.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $pdf->WriteFixedPosHTML('<p style="font-size: 33px; color:#ef6c00; font-family: calibri; font-weight: bold">' . $versao . '</p>', 55, 216, 100, 100, 'auto');
        $pdf->WriteFixedPosHTML('<p style="font-size: 33px; color:#808080; font-family: calibri; font-weight: bold">' . $midia . '</p>', 55, 230, 150, 100, 'auto');
        $pdf->AddPage();
        $pdf->Image($dir . 'TEMPLATE_page-0003.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $pdf->WriteFixedPosHTML('<p style="font-size: 22px; color:#ef6c00; font-family: calibri; font-weight: bold; text-align:center">' . $midia . '</p>', 65, 39, 100, 100, 'auto');
        $pdf->WriteFixedPosHTML('<p style="font-size: 22px; color:#ef6c00; font-family: calibri; font-weight: bold; text-align:center">Período - ' . $mes . '</p>', 65, 75, 100, 100, 'auto');
        
        // IMPRESSO
        $pdf->WriteFixedPosHTML('<p style="font-size: 18px; color:#808080; font-family: calibri; font-weight: bold; text-align:center">IMPRESSO</p>', 9, 100, 100, 100, 'auto');
        $stylesheet = '.tg  {border-collapse:collapse;border-color:#ef6c00;border-spacing:0;}
        .tg td{background-color:#fff;border-color:#ef6c00;border-style:solid;border-width:1px;color:#333;
          font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:5px 5px;word-break:normal;}
        .tg th{background-color:#f38630;border-color:#ef6c00;border-style:solid;border-width:1px;color:#fff;
          font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:5px 5px;word-break:normal;}
        .tg .tg-0lax{text-align:left;vertical-align:top}';
        $pdf->WriteHTML($stylesheet, 1);
        $vP = 0;
        $vN = 0;
        $vT = 0;
        $tot = 0;
        $htmlTabela = '<table class="tg">
                                    <thead>
                                        <tr style="">
                                        <th class="tg-0lax" style="width: 200px; text-align: center; font-weight:bold">Veículo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Positivo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Negativo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Neutro</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Total</th>
                                        <tr>
                                    </thead>
                                    <tbody>';
        foreach ($resultado['I'] as $value) {
            $htmlTabela .= '<tr>
                                        <td>'.$value['DESCRICAO'].'</td>
                                        <td style="text-align: center;">'.$value['POSITIVO'].'</td>
                                        <td style="text-align: center;">'.$value['NEGATIVO'].'</td>
                                        <td style="text-align: center;">'.$value['NEUTRO'].'</td>
                                        <td style="text-align: center;">'.$value['TOTAL'].'</td>
                                    <tr>';
            $vP = $vP + $value['POSITIVO'];
            $vN = $vN + $value['NEGATIVO'];
            $vT = $vT + $value['NEUTRO'];
            $tot = $tot + $value['TOTAL'];                        
        }
        $htmlTabela .= '<tr>
                        <td>TOTAL</td>
                        <td style="text-align: center;">'.$vP.'</td>
                        <td style="text-align: center;">'.$vN.'</td>
                        <td style="text-align: center;">'.$vT.'</td>
                        <td style="text-align: center;">'.$tot.'</td>
                        </tr>';             
        $htmlTabela .= '</tbody>
                                </table>';               
        // TABELA DO IMPRESSO
        $pdf->WriteFixedPosHTML($htmlTabela, 46, 108, 200, 100, 'auto');
        $vP = 0;
        $vN = 0;
        $vT = 0;
        $tot = 0;
        // RADIO
        $pdf->AddPage();
        $pdf->Image($dir . 'TEMPLATE_page-0003.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $pdf->WriteFixedPosHTML('<p style="font-size: 18px; color:#808080; font-family: calibri; font-weight: bold; text-align:center">RÁDIO</p>', 4, 20, 100, 100, 'auto');

        $htmlTabela = '<table class="tg">
                                    <thead>
                                        <tr style="">
                                        <th class="tg-0lax" style="width: 200px; text-align: center; font-weight:bold">Veículo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Positivo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Negativo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Neutro</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Total</th>
                                        <tr>
                                    </thead>
                                    <tbody>';
        foreach ($resultado['R'] as $value) {
            $htmlTabela .= '<tr>
                                        <td>'.$value['DESCRICAO'].'</td>
                                        <td style="text-align: center;">'.$value['POSITIVO'].'</td>
                                        <td style="text-align: center;">'.$value['NEGATIVO'].'</td>
                                        <td style="text-align: center;">'.$value['NEUTRO'].'</td>
                                        <td style="text-align: center;">'.$value['TOTAL'].'</td>
                                    <tr>';
                                    $vP = $vP + $value['POSITIVO'];
                                    $vN = $vN + $value['NEGATIVO'];
                                    $vT = $vT + $value['NEUTRO'];
                                    $tot = $tot + $value['TOTAL'];                             
        }  
        $htmlTabela .= '<tr>
                        <td>TOTAL</td>
                        <td style="text-align: center;">'.$vP.'</td>
                        <td style="text-align: center;">'.$vN.'</td>
                        <td style="text-align: center;">'.$vT.'</td>
                        <td style="text-align: center;">'.$tot.'</td>
                        </tr>';            
        $htmlTabela .= '</tbody>
                                </table>';               
        // TABELA DO RÁDIO
        $pdf->WriteFixedPosHTML($htmlTabela, 46, 35, 200, 100, 'auto');
        $vP = 0;
        $vN = 0;
        $vT = 0;
        $tot = 0;
        // TELEVISÃO
        $pdf->AddPage();
        $pdf->Image($dir . 'TEMPLATE_page-0003.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $pdf->WriteFixedPosHTML('<p style="font-size: 18px; color:#808080; font-family: calibri; font-weight: bold; text-align:center">TELEVISÃO</p>', 9, 20, 100, 100, 'auto');

        $htmlTabela = '<table class="tg">
                                    <thead>
                                        <tr style="">
                                        <th class="tg-0lax" style="width: 200px; text-align: center; font-weight:bold">Veículo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Positivo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Negativo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Neutro</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Total</th>
                                        <tr>
                                    </thead>
                                    <tbody>';
        foreach ($resultado['T'] as $value) {
            $htmlTabela .= '<tr>
                                        <td>'.$value['DESCRICAO'].'</td>
                                        <td style="text-align: center;">'.$value['POSITIVO'].'</td>
                                        <td style="text-align: center;">'.$value['NEGATIVO'].'</td>
                                        <td style="text-align: center;">'.$value['NEUTRO'].'</td>
                                        <td style="text-align: center;">'.$value['TOTAL'].'</td>
                                    <tr>';
                                    $vP = $vP + $value['POSITIVO'];
                                    $vN = $vN + $value['NEGATIVO'];
                                    $vT = $vT + $value['NEUTRO'];
                                    $tot = $tot + $value['TOTAL'];    
        }    
        $htmlTabela .= '<tr>
        <td>TOTAL</td>
        <td style="text-align: center;">'.$vP.'</td>
        <td style="text-align: center;">'.$vN.'</td>
        <td style="text-align: center;">'.$vT.'</td>
        <td style="text-align: center;">'.$tot.'</td>
        </tr>';           
        $htmlTabela .= '</tbody>
                                </table>';               
        // TABELA DA TV
        $pdf->WriteFixedPosHTML($htmlTabela, 46, 35, 200, 100, 'auto');


        // REVISTAS
        $pdf->AddPage();
        $pdf->Image($dir . 'TEMPLATE_page-0003.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $pdf->WriteFixedPosHTML('<p style="font-size: 18px; color:#808080; font-family: calibri; font-weight: bold; text-align:center">REVISTAS</p>', 8, 20, 100, 100, 'auto');

        $htmlTabela = '<table class="tg">
                                    <thead>
                                        <tr style="">
                                        <th class="tg-0lax" style="width: 200px; text-align: center; font-weight:bold">Veículo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Positivo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Negativo</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Neutro</th>
                                        <th class="tg-0lax" style="width: 80px; text-align: center; font-weight:bold">Total</th>
                                        <tr>
                                    </thead>
                                    <tbody>';
    
            $htmlTabela .= '<tr>
                                        <td></td>
                                        <td style="text-align: center;">0</td>
                                        <td style="text-align: center;">0</td>
                                        <td style="text-align: center;">0</td>
                                        <td style="text-align: center;">0</td>
                                    <tr>';
                   
        $htmlTabela .= '</tbody>
                                </table>';               
        // TABELA DAS REVISTAS
        $pdf->WriteFixedPosHTML($htmlTabela, 46, 35, 200, 100, 'auto');

        $pdf->AddPage();
        $pdf->Image($dir . 'TEMPLATE_page-0004.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $token = mb_strimwidth(md5(uniqid("")), 0, 6);
        $filename = 'relatorio-link-avulsos' . $token;
        $pdf->Output($filename . '.pdf', 'D');
        //$pdf->Output();
    }

    private function pdfTemplate($resultado, $veiculo, $dtinicio, $dtfim)
    {

        $mes = $this->mesRelatorio($dtinicio);

        switch ($veiculo) {
            case 'R':
                $midia = 'Rádio';
                $versao = '1.4.5';
                break;
            case 'T':
                $midia = 'Televisão';
                $versao = '1.4.4';
                break;
            default:
                $versao = '1.4.1';
                $midia = 'Análise de Jornais, Televisões, Rádios e Revistas';
                break;
        }

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->AddPage();
        $pdf->SetFont('calibri');
        $dir = str_replace("\\", '/', FCPATH) . '/pdf/';
        $pdf->Image($dir . 'TEMPLATE_page-0001.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $pdf->WriteFixedPosHTML('<p style="font-size: 35px; color:white; font-family: calibri; font-weight: bold">Clipping ' . $midia . '</p>', 103, 200, 100, 100, 'auto');
        $pdf->WriteFixedPosHTML('<p style="font-size: 25px; color:white; font-family: calibri; font-weight: bold">' . $mes . ' de ' . date("Y") . '</p>', 100, 251, 100, 100, 'auto');
        $pdf->AddPage();
        $pdf->Image($dir . 'TEMPLATE_page-0002.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $pdf->WriteFixedPosHTML('<p style="font-size: 33px; color:#ef6c00; font-family: calibri; font-weight: bold">' . $versao . '</p>', 55, 216, 100, 100, 'auto');
        $pdf->AddPage();
        $pdf->Image($dir . 'TEMPLATE_page-0003.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $pdf->WriteFixedPosHTML('<p style="font-size: 18px; color:#ef6c00; font-family: calibri; font-weight: bold">Período: ' . $mes . '</p>', 48, 25, 100, 100, 'auto');
        $pdf->WriteFixedPosHTML('<p style="font-size: 18px; color:#ef6c00; font-family: calibri; font-weight: bold">Total de Publicações: ' . count($resultado) . '</p>', 48, 32, 100, 100, 'auto');
        $pdf->WriteFixedPosHTML('<p style="font-size: 18px; color:#ef6c00; font-family: calibri; font-weight: bold">Tipo da Matéria: ' . $midia . '</p>', 48, 39, 100, 100, 'auto');

        $i = 1;
        $volta = 1;
        $xIni = 60;
        $nextpos = 5;
        foreach ($resultado as $result) {

            if ($i == 7 and $volta == 7) {
                $pdf->AddPage();
                $pdf->Image($dir . 'TEMPLATE_page-0003.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
                $xIni = 20;
                $nextpos = 5;
                $i = 1;
            } else if ($i == 8 and $volta > 7) {
                $pdf->AddPage();
                $pdf->Image($dir . 'TEMPLATE_page-0003.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
                $xIni = 20;
                $nextpos = 5;
                $i = 1;
            }

            $secretaria = $this->secretaria($result->SEQ_SETOR);
            $xIni = $xIni + $nextpos;
            $pdf->WriteFixedPosHTML('<p style="font-size: 15px; font-family: arial">' . $result->DIA . ' - ' . trim($result->NOME_VEICULO) . '</p>', 48, $xIni, 200, 100, 'auto');
            $xIni = $xIni + 5;
            $pdf->WriteFixedPosHTML('<p style="font-size: 15px; font-family: arial">' . $secretaria . '</p>', 48, $xIni, 200, 100, 'auto');
            $xIni = $xIni + 5;
            $pdf->WriteFixedPosHTML('<p style="font-size: 15px; font-family: arial">' . trim($result->TITULO_MATERIA) . '</p>', 48, $xIni, 140, 100, 'hidden');
            if (strlen(trim($result->TITULO_MATERIA)) <= 75) {
                $xIni = $xIni + 5;
            } else {
                $xIni = $xIni + 10;
            }
            $pdf->WriteFixedPosHTML('<a href="' . trim($result->LINK) . '"style="font-size: 15px; font-family: arial">' . trim($result->LINK) . '</a>', 48, $xIni, 200, 100, 'auto');
            $nextpos = 15;
            $i++;
            $volta++;
        }
        $pdf->AddPage();
        $pdf->Image($dir . 'TEMPLATE_page-0004.jpg', 0, 0, 210, 297, 'JPG',  '', true, false);
        $token = mb_strimwidth(md5(uniqid("")), 0, 6);
        $filename = 'relatorio-link-avulsos' . $token;
        $pdf->Output($filename . '.pdf', 'D');
    }

    private function secretaria($setor)
    {
        $this->db->where('SEQ_SETOR', $setor);
        $setor = $this->db->get('SETOR')->row_array();
        return $setor['DESC_SETOR'];
    }

    public function word($resultado, $veiculo, $dtinicio, $dtfim)
    {
        $languagePTBR = new \PhpOffice\PhpWord\Style\Language(\PhpOffice\PhpWord\Style\Language::PT_BR);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->getSettings()->setThemeFontLang($languagePTBR);
        $section = $phpWord->addSection();
        $fontStyleName = 'oneUserDefinedStyle';
        $tipo_veiculo = '';
        switch ($veiculo) {
            case 'R':
                $tipo_veiculo = 'Rádio';
                break;
            case 'T':
                $tipo_veiculo = 'Televisão';
                break;
            case 'I':
                $tipo_veiculo = 'Impresso';
                break;
            default:
                break;
        }
        $section->addText(
            'Período: ' . $dtinicio . ' a ' . $dtfim,
            array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
        );
        $section->addText(
            'Total de Publicações: ' . count($resultado),
            array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
        );
        $section->addText(
            'Tipo da Matéria: ' . $tipo_veiculo,
            array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
        );
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Arial', 'size' => 11, 'color' => '1B2232', 'bold' => true)
        );
        $section->addTextBreak(1);


        foreach ($resultado as $result) {

            $secretaria = $this->secretaria($result->SEQ_SETOR);

            $section->addText(
                trim($result->DIA) . ' - ' . trim($result->NOME_VEICULO)
            );

            $section->addText(
                $secretaria
            );

            $section->addText(
                $result->TITULO_MATERIA
            );

            $section->addLink(trim($result->LINK), trim($result->LINK), array('name' => 'Tahoma', 'size' => 10, 'bold' => false, 'color' => '#1976d2'));

            $section->addTextBreak(1);
        }
        $token = mb_strimwidth(md5(uniqid("")), 0, 6);
        $filename = 'relatorio-link-avulsos' . $token . '.docx';
        $arquivo = FCPATH . 'lixo/' . $filename;
        $phpWord->save($arquivo);
        $this->load->helper('download');
        $dataBinary = file_get_contents($arquivo);
        force_download(basename($arquivo), $dataBinary, TRUE);
        unlink(realpath($arquivo));
    }

    public function removerCaracteresEspeciais($str)
    {
        return preg_replace(['#(?![A-Za-zÀ-ü0-9.]).#i', '#[-]{1,}#i'], [' ', ' '], $str);
    }

    public function pdfConsulta($dados)
    {
        $tipo_midia = '';
        $join = '';
        $veiculo = '';
        $link = '';
        switch ($dados['veiculo']) {
            case 'R':
                $tipo_midia = 'audio';
                $join = 'JOIN RADIO r ON M.SEQ_RADIO = r.SEQ_RADIO ';
                $veiculo = 'r.NOME_RADIO';
                $link = "CONCAT('http://inpacto.digital/noticias/materia/audio/',SEQ_ANEXO)";
                break;
            case 'T':
                $tipo_midia = 'video';
                $join = 'JOIN TELEVISAO t ON M.SEQ_TV = t.SEQ_TV ';
                $veiculo = 't.NOME_TV';
                $link = "CONCAT('http://inpacto.digital/noticias/materia/audio/',SEQ_ANEXO)";
                break;
            case 'I':
                $tipo_midia = 'image';
                $join = 'JOIN VEICULO v ON M.SEQ_VEICULO = v.SEQ_VEICULO ';
                $veiculo = 'v.NOME_VEICULO';
                $link = "CONCAT('http://inpacto.digital/noticias/publico/imagem2/R/',M.SEQ_MATERIA,'/', NOME_BIN_ARQUIVO)";
                break;
            default:
                $tipo_midia = 'audio';
                break;
        }
        $SQL = "SELECT M.SEQ_MATERIA,C.NOME_CLIENTE, M.TIT_MATERIA as TITULO_MATERIA,M.SEQ_SETOR,A.NOME_ARQUIVO as NOME_DO_ARQUIVO, " . $veiculo . " as NOME_VEICULO, " . $link . " as LINK, TRIM(DATE_FORMAT(M.DATA_MATERIA_CAD, '%d/%m/%Y')) as DIA "
            . "FROM ANEXO A "
            . "JOIN MATERIA M ON M.SEQ_MATERIA = A.SEQ_MATERIA "
            . $join
            . "JOIN CLIENTE C ON C.SEQ_CLIENTE = M.SEQ_CLIENTE "
            . "WHERE M.SEQ_CLIENTE = " . $this->session->userData('idClienteSessao') . " AND DATA_PUB_NUMERO BETWEEN '" . str_replace('-', '', implode('-', array_reverse(explode('/', $dados['datainicio'])))) . "' AND '" . str_replace('-', '', implode('-', array_reverse(explode('/', $dados['datafim']))))
            . "' AND A.CONTT_ARQUIVO LIKE '%" . $tipo_midia . "%' ";
        //        echo $SQL;
        //        die();
        $query = $this->db->query($SQL)->result();
        return $query;
    }
}

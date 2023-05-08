<?php

ob_implicit_flush(true);
ob_end_clean();

/**
 * Description of Sistema
 *
 * @author Galileu
 */
class Sistema extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['loginUsuario'])) {
            redirect();
        }
    }

    public function tela() {

        $this->load->view('modulos/publico/alerta/sistema');
    }

    public function apaga() {
        die('ACESSO NEGADO');
        // SELECIONA TODOS OS CLIENTES QUE TEM MATÉRIAS NO SISTEMA, EXCETO PREFEITURA, GOVERNO DO AMAZONAS, ELEIÇÕES 2020 (USADA PARA FINS DEMONSTRATIVOS) e GOVERNO DO AMAZONAS
        $cli = $this->db->query('
        SELECT C.SEQ_CLIENTE, C.NOME_CLIENTE, C.EMPRESA_CLIENTE FROM ANEXO A 
        JOIN MATERIA M ON M.SEQ_MATERIA = A.SEQ_MATERIA
        JOIN CLIENTE C ON M.SEQ_CLIENTE = C.SEQ_CLIENTE
        WHERE M.SEQ_CLIENTE IN (1,5)
        GROUP BY C.SEQ_CLIENTE')->result();
        
        foreach ($cli as $cliente) {
            $res = $this->db->query("
            SELECT A.SEQ_MATERIA, A.NOME_ARQUIVO, A.NOME_BIN_ARQUIVO FROM MATERIA M
            JOIN ANEXO A ON A.SEQ_MATERIA = M.SEQ_MATERIA
            WHERE M.SEQ_CLIENTE = " . $cliente->SEQ_CLIENTE . " AND DATE(M.DATA_MATERIA_CAD) <= '2022-12-31'
            ORDER BY M.DATA_MATERIA_CAD DESC")->result();

            $i = 0;
            $tamanho = 0;
            foreach ($res as $anexo) {
                $arquivo = APPPATH_MATERIA . $anexo->SEQ_MATERIA . '/' . $anexo->NOME_BIN_ARQUIVO;
                $pasta = APPPATH_MATERIA . $anexo->SEQ_MATERIA;
                if (file_exists($arquivo)) {
                    //$this->deletaArquivoLocal($arquivo, $pasta);
                    //$this->deletaArquivoBD($anexo->SEQ_MATERIA, $anexo->NOME_BIN_ARQUIVO);
 
                    $size = $this->tamanho_arquivo($arquivo);
                    $tamanho = $tamanho + $size;
                    $i++;
                }
            }
            echo 'TOTAL DE DADOS APAGADOS ' . $cliente->NOME_CLIENTE . ' : ' . $this->converteTamanho($tamanho) . ' <br><br>';
            flush();
        }
    }

    private function deletaArquivoLocal($arquivo, $pasta) {
        unlink($arquivo);
        if ($pasta !== '/mnt/volume_sfo2_02/materia/') {
            rmdir($pasta);
        }
    }

    private function deletaArquivoBD($materia, $arquivo) {
        $this->db->delete('ANEXO', array(
            'SEQ_MATERIA' => $materia,
            'NOME_BIN_ARQUIVO' => $arquivo
        ));
    }

    function tamanho_arquivo($arquivo) {
        $tamanhoarquivo = filesize($arquivo);

        if ($tamanhoarquivo < 999) {
            $tamanhoarquivo = 1000;
        }

        return round($tamanhoarquivo);
    }

    function converteTamanho($tamanhoarquivo) {

        $medidas = array('KB', 'MB', 'GB', 'TB');

        for ($i = 0; $tamanhoarquivo > 999; $i++) {
            $tamanhoarquivo /= 1024;
        }

        return round($tamanhoarquivo) . $medidas[$i - 1];
    }

}

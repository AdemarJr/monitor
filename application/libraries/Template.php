<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once APPPATH."/third_party/template/Docx/DocxTemplate.php";

//use Template\Docx\DocxTemplate;
class Template {
    private $objetoRelease;
    function __construct()
    {
        $CI = & get_instance();
        log_message('Debug', 'DocxTemplate class is loaded.');
    }

    function load($templatePath=NULL)
    {
        include_once APPPATH."/third_party/template/Docx/DocxTemplate.php";

        return new DocxTemplate($templatePath);
    }

    public function setDataRelease(
        $nomeCliente,
        $dataFiltro,
        $datap,
        $resultado=array(),
        $op = FALSE    
        ) {

        /** cliente**/
        $relatorio = new stdClass();
        $cliente = new stdClass();
        $cliente->nome = utf8_encode($nomeCliente);
        $relatorio->cliente =$cliente;

        $relatorio->data = $dataFiltro;
        date_default_timezone_set('America/Sao_Paulo');
        $relatorio->datap = $datap;
        $total=0;

        $release = new stdClass();
        $items = array();
        $i=0;
        $jsonObject = new stdClass();
        $jsonObject->relatorio = $relatorio;
        if ($op == FALSE) {
            $jsonObject->resultado =$resultado; 
        } else {
            $jsonObject->r =$resultado;
        }
        $this->objetoRelease = $jsonObject;
    }
    public function setDataArea(
        $nomeCliente,
        $dataFiltro,
        $resultado=array()
    ) {

        /** cliente**/
        $relatorio = new stdClass();
        $cliente = new stdClass();
        $cliente->nome = utf8_encode($nomeCliente);
        $relatorio->cliente =$cliente;

        $relatorio->data = $dataFiltro;
        date_default_timezone_set('America/Sao_Paulo');
        $total=0;

        $release = new stdClass();
        $items = array();
        $i=0;
        $jsonObject = new stdClass();
        $jsonObject->relatorio = $relatorio;
        $jsonObject->resultado =$resultado;
        $this->objetoRelease = $jsonObject;
    }

    public function setDataMark(
        $nomeCliente,
        $dataFiltro,
        $resultado=array()
    ) {

        /** cliente**/
        $relatorio = new stdClass();
        $cliente = new stdClass();
        $cliente->nome = utf8_encode($nomeCliente);
        $relatorio->cliente =$cliente;
        $relatorio->data = $dataFiltro;

        $jsonObject = new stdClass();
        $jsonObject->relatorio = $relatorio;
        $jsonObject->resultado =$resultado;
        $this->objetoRelease = $jsonObject;
    }

    public function getJsonRelease(){
        return json_encode($this->objetoRelease,3);
    }
}
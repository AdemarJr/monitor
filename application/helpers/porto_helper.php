<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 01/05/2017
 * Time: 14:08
 */


if ( ! function_exists('resume'))
{
    function resume( $var, $limite ){
        if (strlen($var) > $limite)	{
            $var = substr($var, 0, $limite);
            $var = trim($var) . "...";
        }
        return $var;
    }
}

if ( ! function_exists('descAvaliacao'))
{
    function descAvaliacao( $var='' ){
        $retorno ='';
        if ($var=='P')	{
            $retorno="Positivo";
        } else if ($var=='N')	{
            $retorno="Negativo";
        }
        return $retorno;
    }
}

if ( ! function_exists('descClassificacao'))
{
    function descClassificacao( $var='' ){
        $tipo = array(
            'E'=>'Demanda Espont&acirc;nea',
            'X'=>'Mat&eacute;ria Exclusiva',
            'I'=>'Release na &Iacute;ntegra',
            'P'=>'Release Parcial'
        );
        return $tipo[$var];
    }
}
if ( ! function_exists('descTipoMateria'))
{
    function descTipoMateria( $var='' ){
        $tipo = array(
            'S'=>'Internet',
            'I'=>'Impresso',
            'R'=>'R&aacute;dio',
            'T'=>'Televis&atilde;o'
        );
        return $tipo[$var];
    }
}
if ( ! function_exists('abrevMes'))
{
    function abrevMes( $num=0 ){
        $abreviaturas = array('','Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez');
        return $abreviaturas[$num];
    }
}

if ( ! function_exists('descricaoMes'))
{
    function descricaoMes( $num=0 ){
        $abreviaturas = array('','Janeiro','Fevereiro','Marco','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
        return $abreviaturas[$num];
    }
}

if ( ! function_exists('numeroMes'))
{
    function numeroMes( $num='' ){
        $abreviaturas = array(
            'janeiro'=>'01',
            'fevereiro'=>'02',
            'marco'=>'03',
            'maro'=>'03',
            'abril'=>'04',
            'maio'=>'05',
            'junho'=>'06',
            'julho'=>'07',
            'agosto'=>'08',
            'setembro'=>'09',
            'outubro'=>'10',
            'novembro'=>'11',
            'dezembro'=>'12');
        return $abreviaturas[strtolower(tirarAcentos($num))];
    }
}

if ( ! function_exists('tirarAcentos')) {
    function tirarAcentos($string)
    {
        return strtr(utf8_decode($string),
            '���������������������������������������������������������������������',
            'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
    }
}


if ( ! function_exists('utf8_strtr')) {
    function utf8_strtr($str, $from, $to)
    {
        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        return strtr($str, $mapping);
    }
}

if ( ! function_exists('url_alerta')) {
    function url_alerta($idCliente=0, $setor=NULL)
    {
        if ($idCliente == 11 || $idCliente == 37 || $idCliente == 60 || $idCliente == 63) {
            return 'http://clippingeleicoes.com.br/monitor/x/';
        }
        else if ($idCliente!=3 
            and $idCliente!=59 
            and $idCliente!=61
            and $idCliente!=62
            and $idCliente!=63
            and $idCliente!=64
            )
            return 'https://porto.am/i?'; //$CI->config->config['url_alerta'];
        else if ($idCliente == 59 || $idCliente == 55 || $idCliente == 13) 
            return 'http://clipping.digital/i?';
        else if (SETOR_ELEICAO=='1' or (!empty($setor) and $setor=='516')) 
            return 'https://porto.am/i?';    
        else return 'https://porto.am/i?';

            // switch($_SERVER['SERVER_NAME'])
            // {
            //     case SERVER_NAME_ELEICAO1:
            //         return 'http://eleicoesnews.com.br/i?';
            //         break;
            //     case SERVER_NAME_ELEICAO2:
            //         return 'http://eleicoesmanaus.com.br/i?';
            //         break;    
            //     case SERVER_NAME_ELEICAO3:
            //         return 'http://clippingeleicoes.com.br/i?';
            //         break;    
            //     default:
            //         return 'http://eleicoesnews.com.br/i?';
            //         break;
            // }

    }
}
if ( ! function_exists('url_materia_simples')) {
    function url_materia_simples($idCliente=0, $setor=NULL)
    {
        if ($idCliente == 11 || $idCliente == 37 || $idCliente == 60 || $idCliente == 63 || $idCliente == 53) {
            return 'http://clippingeleicoes.com.br/v?';
        }
    //    $CI=&get_instance();
//        if ($_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO)
        else if ($idCliente!=13 and $idCliente!=3 
            and $idCliente!=59 
            and $idCliente!=60 
            and $idCliente!=61
            and $idCliente!=62
            and $idCliente!=63
            and $idCliente!=64
            )
            return 'https://porto.am/v?'; //$CI->config->config['url_materia_simples'];
            else if ($idCliente == 59 || $idCliente == 55 || $idCliente == 13) 
            return 'http://clipping.digital/v?';
            else if (SETOR_ELEICAO=='1' or (!empty($setor) and $setor=='516')) 
            return 'https://porto.am/v?';
        else return 'https://porto.am/v?';
            // switch($_SERVER['SERVER_NAME'])
            // {
            //     case SERVER_NAME_ELEICAO1:
            //         return 'http://eleicoesnews.com.br/v?';
            //         break;
            //     case SERVER_NAME_ELEICAO2:
            //         return 'http://eleicoesmanaus.com.br/v?';
            //         break;    
            //     case SERVER_NAME_ELEICAO3:
            //         return 'http://clippingeleicoes.com.br/v?';
            //         break;    
            //     default:
            //         return 'http://eleicoesnews.com.br/v?';
            //         break;
            // }
    }
}
if ( ! function_exists('url_materia_simples_ti')) {
    function url_materia_simples_ti()
    {
            return 'https://porto.am/v2?'; //$CI->config->config['url_materia_simples'];
    }
}
if ( ! function_exists('getId3v2')) {
    function getId3v2($arquivo=NULL)
    {
        require_once(APPPATH . '/third_party/getid3/getid3.php');
        $mp3 = APPPATH_MATERIA . $arquivo; //14927/842d7d38656985c0b23e8a0967269ff9.mp3';
        $ar = array(
            'SEC_ARQUIVO' => 0,
            'TEMPO_ARQUIVO' => '00:00'
        );
        if (file_exists($mp3)) {

            $getID3 = new getID3;

            $ThisFileInfo = $getID3->analyze($mp3);
            getid3_lib::CopyTagsToComments($ThisFileInfo);

            $ar = array(
                'SEC_ARQUIVO' => round(@$ThisFileInfo['playtime_seconds']),
                'TEMPO_ARQUIVO' => @$ThisFileInfo['playtime_string']
            );
        }
        return $ar;
    }
}

if ( ! function_exists('convertSegundo2HMS')) {
    function convertSegundo2HMS($segundo)
    {
        $total = $segundo;
        $horas = floor($total / 3600);
        $minutos = floor(($total - ($horas * 3600)) / 60);
        $segundos = floor($total % 60);
        return str_pad($horas,2,'0',STR_PAD_LEFT). ":" .str_pad($minutos,2,'0',STR_PAD_LEFT) . ":" . str_pad($segundos,2,'0',STR_PAD_LEFT);
    }
}
if ( ! function_exists('copyr')) {
    function copyr($source, $dest)
    {
        // COPIA UM ARQUIVO
        if (is_file($source)) {
            return copy($source, $dest);
        }

        return true;

    }
}
if ( ! function_exists('formatSizeUnits')) {
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
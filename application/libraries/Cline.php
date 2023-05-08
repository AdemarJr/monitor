<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 16/07/2017
 * Time: 13:18
 */
class Cline
{
    private $objeto;
    private $CI;
    function __construct()
    {
        $this->CI = & get_instance();
        log_message('Debug', 'inicio grafico de Linha');
    }

    function load($labels , $datas=array())
    {
        $legend = new stdClass();
        $legend->display = true;
        $legend->position = 'top';

        $options = new stdClass();
        $options->responsive=true;
        $options->legend=$legend;
        $options->maintainAspectRatio=false;
        


        $i=0;
        $datasets=array();
        $cores =array(
            'P'=>'76, 175, 80',
            'N'=>'244, 67, 54',
            'T'=>'255, 152, 0',
        );
        $label =array(
            'P'=>'Positiva',
            'N'=>'Negativa',
            'T'=>'Neutra',
        );
        foreach ($datas as $item){

            $dataItem = new stdClass();
            $dataItem->label = $label[$item['tipo']];
            $dataItem->data = $item['valores'];
            $dataItem->borderColor = 'rgba('.$cores[$item['tipo']].', 0.75)';
            $dataItem->backgroundColor = 'rgba('.$cores[$item['tipo']].', 0)';
            $dataItem->pointBorderColor = 'rgba('.$cores[$item['tipo']].', 0)';
            $dataItem->pointBackgroundColor = 'rgba('.$cores[$item['tipo']].', 0.9)';
            $dataItem->pointBorderWidth = 1;

            array_push($datasets,$dataItem);

        }

        $data = new stdClass();
        $data->labels=$labels;
        $data->datasets=$datasets;

        $outObject = new stdClass();
        $outObject->type='line';
        $outObject->options = $options;
        $outObject->data = $data;

        $this->objeto = $outObject;
    }

    public function getJson(){
        return json_encode($this->objeto,3);
    }
}
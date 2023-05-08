<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 16/07/2017
 * Time: 13:18
 */
class Cbar
{
    private $objeto;
    private $CI;
    function __construct()
    {
        $this->CI = & get_instance();
        log_message('Debug', 'inicio grafico de barra');
    }

    function load($type, $labels , $datas=array())
    {
        $legend = new stdClass();
        $legend->display = false;
        $legend->position = 'top';
        if ($type=='bar'){
            $tooltips = new stdClass();
            $tooltips->enabled = false;

            $labels_pr = new stdClass();
            $labels_pr->render = 'value';
            $labels_pr->fontColor = '#000000';
            $labels_pr->position= 'outside';


            $plugins = new stdClass();
            $plugins->labels= $labels_pr;
        }

        $options = new stdClass();
        $options->responsive=true;
        $options->legend=$legend;
        $options->maintainAspectRatio=false;
        if ($type=='bar'){
            $options->plugins=$plugins;
            $options->tooltips=$tooltips;
        }


        $i=0;
        $datasets=array();
        foreach ($datas as $item){
            $dataItem = new stdClass();
            $dataItem->label =$item['label'];
            $dataItem->data = $item['valores'];
            $dataItem->backgroundColor = array("#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#fdcb6e","#e17055","#546de5","#e15f41","#c44569","#b2bec3");
            array_push($datasets,$dataItem);
        }

        $data = new stdClass();
        $data->labels=$labels;
        $data->datasets=$datasets;

        $outObject = new stdClass();
        $outObject->type=$type ;
        $outObject->options = $options;
        $outObject->data = $data;

        $this->objeto = $outObject;
    }

    public function getJson(){
        return json_encode($this->objeto,3);
    }
}
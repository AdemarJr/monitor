<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 16/07/2017
 * Time: 13:18
 */
class Cpie
{
    private $objeto;
    private $CI;
    function __construct()
    {
        $this->CI = & get_instance();
        log_message('Debug', 'inicio grafico de pizza');
    }

    function load($labels , $datas=array())
    {
        $legend = new stdClass();
        $legend->display = true;
        $legend->position = 'top';

        $tooltips = new stdClass();
        $tooltips->enabled = false;

        $labels_pr = new stdClass();
        $labels_pr->render = 'value';
        $labels_pr->fontColor = '#000000';
        $labels_pr->position= 'outside';


        $plugins = new stdClass();
        $plugins->labels= $labels_pr;


        $options = new stdClass();
        $options->responsive=true;
        $options->legend=$legend;
        $options->maintainAspectRatio=false;
        $options->plugins=$plugins;
        $options->maintainAspectRatio=false;
        $options->cutoutPercentage=15;
        
        $options->tooltips=$tooltips;


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
            $dataItem->label =$item['label'];
            $dataItem->data = $item['valores'];
            $dataItem->backgroundColor = array("#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#fdcb6e","#e17055","#546de5","#e15f41","#c44569","#b2bec3");
            array_push($datasets,$dataItem);
        }

        $data = new stdClass();
        $data->labels=$labels;
        $data->datasets=$datasets;

        $outObject = new stdClass();
        $outObject->type='pie';
        $outObject->options = $options;
        $outObject->data = $data;

        $this->objeto = $outObject;
    }

    public function getJson(){
        return json_encode($this->objeto,3);
    }
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 16/07/2017
 * Time: 13:18
 */
class Stackbar
{
    private $objeto;
    private $CI;
    function __construct()
    {
        $this->CI = & get_instance();
        log_message('Debug', 'inicio StackBar');
    }

    function load($titles='',$legends=array(),$categorias=array(),$datas=array(),$textoY='Quantidade',$empilha=true)
    {
        /** Chart**/
        $chart = new stdClass();
        $chart->type = 'bar';

        /** @var  $title */
        $title = new stdClass();
        $title->text = utf8_encode($titles);

        $xAxis = new stdClass();
        $xAxis->categories = $categorias;

        $stackLabels = new stdClass();
        $stackLabels->enabled= true;
        $style = new stdClass();
        $style->fontWeight='bold';
        $style->color='';
        $stackLabels->style = $style;


        $yAxis = new stdClass();
        $yAxis->min=0;
        $yAxisTitle = new stdClass();
        $yAxisTitle->text=$textoY;
        $yAxis->stackLabels=$stackLabels;
        $yAxis->title=$yAxisTitle;


        /** @var  $legend */
        $legend = new stdClass();
        $legend->reversed = false;
        // fim $legend

        if($empilha) {
            $tooltip = new stdClass();
            $tooltip->pointFormat='<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>';
            $tooltip->shared=false;

            $series = new stdClass();
            $series->stacking = 'normal';
            $dataLabels= new stdClass();
            $dataLabels->enabled=true;
            $dataLabels->color='#294469';
            $style= new stdClass();
            $style->fontSize='10px';
            $style->textShadow='0px';
            $dataLabels->style=$style;
            $series->dataLabels=$dataLabels;
            $plotOptions = new stdClass();
            $plotOptions->series = $series;
        } else{
            $tooltip = new stdClass();
            $dataLabels= new stdClass();
            $dataLabels->enabled=true;
            $bar = new stdClass();
            $bar->dataLabels=$dataLabels;
            $plotOptions = new stdClass();
            $plotOptions->bar = $bar;
        }

        $series = array();
        $i=0;
        foreach ($legends as $item){

            $serieItem = new stdClass();
            $serieItem->name =$item;
            $serieItem->data=$datas[$i++];
            array_push($series,$serieItem);

        }
        $credits = new stdClass();
        $credits->enabled=false;

        $sHeigth = (count($categorias)*15)+150;
        $sWidth = (count($categorias)*25)+320;

        $exporting = new stdClass();
        $exporting->enabled=true;
        $exporting->sourceHeight = $sHeigth;
        $exporting->sourceWidth = $sWidth;


        $condition = new stdClass();
        $condition->maxWidth= 500;

        $chartOptions = new stdClass();
        $legend = new stdClass();
        $legend->enabled = true;

        $chartOptions->legend = $legend;

        $responsive = new stdClass();
        $responsive->rules=array('condition'=>$condition,'chartOptions'=>$chartOptions);
//        responsive: {
//        rules: [{
//            condition: {
//                maxWidth: 500
//    },
//            chartOptions: {
//                legend: {
//                    enabled: false
//      }
//            }
//        }]
//}


        $jsonObject = new stdClass();
        $jsonObject->colors = array('#20bf6b', '#ED4C67', '#FFC312', '#910000', '#1aadce','#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a');
        $jsonObject->chart = $chart;
        $jsonObject->title = $title;
        $jsonObject->xAxis = $xAxis;
        $jsonObject->yAxis = $yAxis;
        $jsonObject->tooltip = $tooltip;
        $jsonObject->legend = $legend;
        $jsonObject->plotOptions = $plotOptions;
        $jsonObject->credits=$credits;
        $jsonObject->series = $series;
        $jsonObject->exporting = $exporting;
        $this->objeto = $jsonObject;
    }

    public function getJson(){
        return json_encode($this->objeto,3);
    }
}
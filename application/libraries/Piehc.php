<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 16/07/2017
 * Time: 13:18
 */
class Piehc
{
    private $objeto;
    private $CI;
    function __construct()
    {
        $this->CI = & get_instance();
        log_message('Debug', 'inicio Pie');
    }

    function load($titles='',$legends=array(),$datas=array())
    {
        $chart = new stdClass();
        $chart->plotBlackgroundColor=null;
        $chart->plotBorderWidth=null;
        $chart->plotShadow=false;
        $chart->type='pie';

        $title = new stdClass();
        $title->text = utf8_encode($titles);

        $tooltip = new stdClass();
        $tooltip->pointFormat = '<b>{point.y:.0f} ({point.percentage:.1f}%)</b>';

        $plotOptions = new stdClass();
        $pie = new stdClass();
        $pie->allowPointSelect=true;
        $pie->cursor = 'pointer';
        $dataLabels = new stdClass();
        $dataLabels->enabled = true;
        $dataLabels->format='<b>{point.name}</b><br/> {point.y:.0f} ({point.percentage:.1f}) %';
        $pie->dataLabels=$dataLabels;
        $pie->showInLegend=true;
//        $style = new stdClass();
//        $style->
        $plotOptions->pie=$pie;

        $series = new stdClass();
        $series->name = 'Percentual';
        $series->colorByPoint = true;

        $datasA = array();
        $i=0;
        $array_cores =array();
        foreach ($legends as $item){
            if ($item=='Positivo') array_push($array_cores,'#20bf6b');
            if ($item=='Negativo') array_push($array_cores,'#ED4C67');
            if ($item=='Neutra') array_push($array_cores,'#FFC312');
 
            $data = new stdClass();
            $data->name =$item;
            $data->y = floatval($datas[$i++]['value']);
            array_push($datasA,$data);

        }
        $array_cores = array_merge($array_cores, array( '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525'));
        $series->data = $datasA;
        $credits = new stdClass();
        $credits->enabled=false;

        $pieObject = new stdClass();
        $pieObject->colors = $array_cores ;
        $pieObject->chart = $chart;
        $pieObject->title = $title;
        $pieObject->tooltip = $tooltip;
        $pieObject->credits = $credits;
        $pieObject->plotOptions = $plotOptions;
        $pieObject->series = array($series);

        $this->objeto = $pieObject;
    }

    public function getJson(){
        return json_encode($this->objeto,3);
    }
}
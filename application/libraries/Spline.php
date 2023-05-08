<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 16/07/2017
 * Time: 13:18
 */
class Spline
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
        $chart->type='spline';

        $title = new stdClass();
        $title->text = utf8_encode($titles);

        $tooltip = new stdClass();
        $tooltip->crosshairs=true;
        $tooltip->shared=true;
        $tooltip->pointFormat = '<b>{point.y:.0f} ({point.percentage:.1f}%)</b>';

        $plotOptions = new stdClass();
        $spline = new stdClass();
        $marker = new stdClass();
        $marker->radius=4;
        $marker->lineColor='#666666';
        $marker->lineWidth=1;
        $spline->marker=$marker;
        $plotOptions->spline=$spline;

        $datasA = array();
        $i=0;
        foreach ($legends as $item){

            $dataItem = new stdClass();
            $dataItem->name =$item;
            $dataItem->data = floatval($datas[$i++]['value']);
            array_push($datasA,$data);

        }

        $credits = new stdClass();
        $credits->enabled=false;

        $outObject = new stdClass();
        $outObject->chart = $chart;
        $outObject->title = $title;
        $outObject->tooltip = $tooltip;
        $outObject->credits = $credits;
        $outObject->plotOptions = $plotOptions;
        $outObject->series = array($datasA);

        $this->objeto = $outObject;
    }

    public function getJson(){
        return json_encode($this->objeto,3);
    }
}
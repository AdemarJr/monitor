<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 16/07/2017
 * Time: 13:18
 */
class Baremp
{
    private $objeto;
    private $CI;
    function __construct()
    {
        $this->CI = & get_instance();
        log_message('Debug', 'inicio BarEmp');
    }

    function load($titles='',$legends=array(),$categorias=array(),$datas=array(),$empilhar=true)
    {
        /** @var  $title */
        $title = new stdClass();
        $title->text = utf8_encode($titles);
        $title->subtext = '';
        $title->x = 'center';
        // fim $title

        /** @var  $tooltip */
        $axisPointer = new stdClass();
        $axisPointer->type ='shadow';
        $tooltip = new stdClass();
        $tooltip->trigger = 'axis';
        $tooltip->axisPointer = $axisPointer;
        // fim $tooltip

        /** @var  $legend */
        $legend = new stdClass();
        $legend->orient = 'horizontal';
        $legend->bottom = 'left';
        $legend->data = $legends;
        // fim $legend

        /** @var  $grid */
        $grid = new stdClass();
        $grid->left='3%';
        $grid->right='4%';
        $grid->bottom='10%';
        $grid->containLabel=true;
        // fim $grid

        $show = new stdClass();
        $show->show =true;

        $xAxis = new stdClass();
        $xAxis->type ='value';
        $yAxis = new stdClass();
        $yAxis->type ='category';
        $yAxis->data =$categorias;

        $notShow = new stdClass();
        $notShow->show =false;

        /** @var  $toolbox */
        $dataView = new stdClass();
        $dataView->show =true;
        $dataView->readOnly =false;
        $funnel = new stdClass();
        $funnel->x ='25%';
        $funnel->width ='50%';
        $funnel->funnelAlign = 'left';
        $funnel->max=1548;
        $magicType = new stdClass();
        $magicType->show =true;
        $magicType->readOnly =false;
        $magicType->type = array('pie','funnel');
        $magicType->option = $funnel;
        $toolboxFeature = new stdClass();
        $toolboxFeature->mark = $show;
        $toolboxFeature->dataView = $dataView;
        $toolboxFeature->magicType = $magicType;
        $toolboxFeature->restore = $notShow;
        $toolboxFeature->saveAsImage = $show;
        $toolbox = new stdClass();
        $toolbox->show = true;
        $toolbox->feature = $toolboxFeature;
        // fim $toolbox

        /** @var  $itemStyle */
        $emphasisItemStyle = new stdClass();
        $emphasisItemStyle->shadowBlur = true;
        $emphasisItemStyle->shadowOffsetX = '{b}\n{d}%';
        $emphasisItemStyle->shadowColor ='rgba(0, 0, 0, 0.5)';
        $itemStyle = new stdClass();
        $itemStyle->emphasis = $emphasisItemStyle;
        // fim  $itemStyle

        /** @var  $emphasis */
        $emphasisLabel = new stdClass();
        $emphasisLabel->show = true;
        $emphasisLabel->formatter = '{b}\n{d}%';
        $emphasis = new stdClass();
        $emphasis->label = $emphasisLabel;
        // fim $emphasis

        /** @var  $labelLine */
        $labelLine = new stdClass();
        $labelLine->normal = $show;
        // fim $labelLine

        $labelNormalSerie = new stdClass();
        $labelNormalSerie->show=true;
        $labelNormalSerie->position = 'insideRight';

        $labelSerie = new stdClass();
        $labelSerie->normal = $labelNormalSerie;

        $series = array();

        $i=0;
        $pilha=0;
        foreach ($legends as $item){

            $serieItem = new stdClass();
            $serieItem->name =$item;
            $serieItem->type ='bar';
            $serieItem->stack =$empilhar==true?'1':"'".$pilha++."'";
            $serieItem->label =$labelSerie;
            $serieItem->data=$datas[$i++];

            array_push($series,$serieItem);

        }

        $pieObject = new stdClass();
        $pieObject->title = $title;
        $pieObject->tooltip = $tooltip;
        $pieObject->legend = $legend;
        $pieObject->grid = $grid;
        $pieObject->xAxis = $xAxis;
        $pieObject->yAxis = $yAxis;
        $pieObject->toolbox = $toolbox;
        $pieObject->calculable = true;
        $pieObject->series = $series;

        $this->objeto = $pieObject;
    }

    public function getJson(){
        return json_encode($this->objeto,3);
    }
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by IntelliJ IDEA.
 * User: Matte
 * Date: 16/07/2017
 * Time: 13:18
 */
class Pie
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
        $title = new stdClass();
        $title->text = utf8_encode($titles);
        $title->subtext = '';
        $title->x = 'center';

        $tooltip = new stdClass();
        $tooltip->trigger = 'item';
        $tooltip->formatter = '{a} <br/>{b} : {c} ({d}%)';

        $legend = new stdClass();
        $legend->orient = 'vertical';
//        $legend->bottom = 'left';
        $legend->x = 'left';
        $legend->data = $legends;

        $show = new stdClass();
        $show->show =true;

        $notShow = new stdClass();
        $notShow->show =false;

        /** @var  $toolbox */
        $dataView = new stdClass();
        $dataView->show =true;
        $dataView->readOnly =false;
        $funnel = new stdClass();
        $funnel->x =true;
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

        $labelSerie = new stdClass();
        $labelSerie->normal = $labelNormalSerie;

        $series = new stdClass();
        $series->name = utf8_encode($titles);
        $series->type = 'pie';
        $series->selectedMode ='single';
        $series->radius ='65%';
        $series->center =array('50%', '50%');

        $series->label=$labelSerie;
        $series->labelLine=$labelLine;
        $series->data=$datas;
        $series->itemStyle=$itemStyle;
        $series->emphasis= $emphasis;


        $pieObject = new stdClass();
        $pieObject->title = $title;
        $pieObject->tooltip = $tooltip;
        $pieObject->legend = $legend;
        $pieObject->toolbox = $toolbox;
        $pieObject->calculable = true;
        $pieObject->series = array($series);

        $this->objeto = $pieObject;
    }

    public function getJson(){
        return json_encode($this->objeto,3);
    }
}
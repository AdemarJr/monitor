
<div class="block-header inline hidden-print">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2>Publicações
        <span class="label label-danger"><?php echo count($lista_dias)?></span>
        </h2>
        <small>&nbsp;</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        
    </div>
</div>
<style type="text/css">
    .ajax-load{
        background: #e1e1e1;
        padding: 10px 0px;
        width: 100%;
    }
</style>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  p-l-0 p-r-0 row-center-content">
            <?php
            $descTipo =array(
                'S'=>'cloud_queue',
                'I'=>'description',
                'R'=>' radio',
                'T'=>' tv'
            );
            if (!empty($lista_dias)) {
            foreach ($lista_dias as $item):
                $dadoVeiculo=NULL;
                if($item['TIPO_MATERIA']=='I' and !empty($item['SEQ_VEICULO']))
                    $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row();
                else if($item['TIPO_MATERIA']=='S' and !empty($item['SEQ_PORTAL']))
                    $dadoVeiculo =  $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row();
                else if($item['TIPO_MATERIA']=='R' and !empty($item['SEQ_RADIO']))
                    $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row();
                else if($item['TIPO_MATERIA']=='T' and !empty($item['SEQ_TV']))
                    $dadoVeiculo = $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $item['SEQ_TV']))->row();

                if ($item['TIPO_MATERIA'] == 'I' and !empty($item['SEQ_VEICULO'])) {
                    $mensagem = $dadoVeiculo->FANTASIA_VEICULO . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'];
                } else if ($item['TIPO_MATERIA'] == 'S' and !empty($item['SEQ_PORTAL'])) {
                    $mensagem = $dadoVeiculo->NOME_PORTAL . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'];
                } else if ($item['TIPO_MATERIA'] == 'R' and !empty($item['SEQ_RADIO'])){
                    $mensagem = $dadoVeiculo->NOME_RADIO.PHP_EOL.$item['PROGRAMA_MATERIA'].PHP_EOL.$item['TIT_MATERIA'].PHP_EOL.'Link: '.url_materia_simples($item['SEQ_CLIENTE']).$item['CHAVE'];
                } else if ($item['TIPO_MATERIA'] == 'T' and !empty($item['SEQ_TV'])) {
                    $mensagem = $dadoVeiculo->NOME_TV . PHP_EOL .$item['PROGRAMA_MATERIA'].PHP_EOL. $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'];
                }
                $analiseConteudo='';
                if (!empty($item['IND_AVALIACAO']) and $item['IND_AVALIACAO']=='N' and !empty($item['ANALISE_MATERIA'])){
                    $resumo = array("Resumo", "resumo", "RESUMO");
                    $resposta   = array("Resposta", "resposta", "RESPOSTA");

                    $analiseConteudo = str_replace($resumo, "*Resumo*", $item['ANALISE_MATERIA']);
                    $analiseConteudo = str_replace($resposta, "*Resposta*", $analiseConteudo);

                    $mensagem = $mensagem.PHP_EOL.$analiseConteudo;
                }
                ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header nopadding-print hidden-print">
                                <div class="row clearfix">
                                    <div  class="col-xs-9 col-md-9 col-xl-9">
                                Publicado em <?php echo date('d/m/Y', strtotime($item['DATA_MATERIA_PUB'])); ?> no
                                <?php if ($item['TIPO_MATERIA'] == 'I' and !empty($item['SEQ_VEICULO']))
                                    echo $dadoVeiculo->FANTASIA_VEICULO;
                                else if ($item['TIPO_MATERIA'] == 'S' and !empty($item['SEQ_PORTAL']))
                                    echo $dadoVeiculo->NOME_PORTAL;
                                else if ($item['TIPO_MATERIA'] == 'R' and !empty($item['SEQ_RADIO']))
                                    echo $dadoVeiculo->NOME_RADIO;
                                else if ($item['TIPO_MATERIA'] == 'T' and !empty($item['SEQ_TV']))
                                    echo $dadoVeiculo->NOME_TV.' - '.$item['PROGRAMA_MATERIA'];
                                    ?>
                                <br/><?php if ($this->session->userData('idClienteSessao')!=3 
                                        and $item['SEQ_CLIENTE']!=59 
                                        and $item['SEQ_CLIENTE']!=60 
                                        and $item['SEQ_CLIENTE']!=61
                                        and $item['SEQ_CLIENTE']!=62
                                        and $item['SEQ_CLIENTE']!=63
                                        and $item['SEQ_CLIENTE']!=64
                                        ) echo $item['DESC_SETOR'].' - '.$item['SIG_SETOR']; ?>
                                <?php if($item['TIPO_MATERIA']=='I') {
                                    $dadosMateriaArr = array();
                                    if (!empty($item['EDITORIA_MATERIA'])) array_push($dadosMateriaArr,$item['EDITORIA_MATERIA']);
                                    if (!empty($item['AUTOR_MATERIA'])) array_push($dadosMateriaArr,$item['AUTOR_MATERIA']);
                                    if (!empty($item['PAGINA_MATERIA'])) array_push($dadosMateriaArr,$item['PAGINA_MATERIA']);

                                    if (count($dadosMateriaArr)>0) echo '<br/>' . implode('/',$dadosMateriaArr);
                                } ?>

                                <?php
                                if ($this->session->userData('idClienteSessao')!=3 
                                        and $item['SEQ_CLIENTE']!=59 
                                        and $item['SEQ_CLIENTE']!=60 
                                        and $item['SEQ_CLIENTE']!=61
                                        and $item['SEQ_CLIENTE']!=62
                                        and $item['SEQ_CLIENTE']!=63
                                        and $item['SEQ_CLIENTE']!=64
                                        ) {
                                    if ($item['IND_AVALIACAO'] == 'P') { ?>
                                        <span class="badge bg-green"><?php echo 'Positiva'; ?></span>
                                    <?php } else if ($item['IND_AVALIACAO'] == 'T') { ?>
                                        <span class="badge bg-grey"><?php echo 'Neutra'; ?></span>
                                    <?php } else if ($item['IND_AVALIACAO'] == 'N') { ?>
                                        <span class="badge bg-red"><?php echo 'Negativa'; ?></span>
                                    <?php }
                                }
                                ?>
                                <i class="material-icons"><?php echo $descTipo[$item['TIPO_MATERIA']];?></i>
                                    </div>
                                    <div  class="col-xs-3 col-md-3 col-xl-3">
                                        <a data-toggle="tooltip" data-placement="top" title="Copiar para &Aacute;rea de tranfer&ecirc;ncia"
                                        class='btn btn-default pull-right m-l-5 copiar'
                                        data-alerta="<?php $dataCliente =$this->ComumModelo->getTableData('CLIENTE',array('SEQ_CLIENTE'=>$this->session->userdata('idClienteSessao')))->row();
                                        echo ($item['IND_AVALIACAO']=='N'? '*MAT&Eacute;RIA NEGATIVA* '
                                                .utf8_decode('%F0%9F%9A%AB').utf8_decode('%F0%9F%9A%AB')
                                                .utf8_decode('%F0%9F%9A%AB').PHP_EOL
                                                .'*'.trim($dataCliente->EMPRESA_CLIENTE)
                                                .'*'.( ($dataCliente->IND_ALERTA_SETOR =='N' 
                                                        and $item['SEQ_CLIENTE']!=59 
                                                        and $item['SEQ_CLIENTE']!=60 
                                                        and $item['SEQ_CLIENTE']!=61
                                                        and $item['SEQ_CLIENTE']!=62
                                                        and $item['SEQ_CLIENTE']!=63
                                                        and $item['SEQ_CLIENTE']!=64
                                                        )?'':PHP_EOL.$this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$item['SEQ_SETOR']))->row()->DESC_SETOR).(($item['TIPO_MATERIA'] == 'T')? (PHP_EOL.$item['DIA']. $item['HORA_MATERIA']):(PHP_EOL. $item['DIA'])).PHP_EOL.PHP_EOL:
                                                json_decode('"\u23F0"')
                                                .'*Alerta de Clipping*'.PHP_EOL
                                                .'*'.trim($dataCliente->EMPRESA_CLIENTE)
                                                .'*'.( ($dataCliente->IND_ALERTA_SETOR =='N' 
                                                        and $item['SEQ_CLIENTE']!=59 
                                                        and $item['SEQ_CLIENTE']!=60 
                                                        and $item['SEQ_CLIENTE']!=61
                                                        and $item['SEQ_CLIENTE']!=62
                                                        and $item['SEQ_CLIENTE']!=63
                                                        and $item['SEQ_CLIENTE']!=64
                                                        )?'':PHP_EOL
                                                    .$this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$item['SEQ_SETOR']))->row()->DESC_SETOR
                                                    )
                                                .(($item['TIPO_MATERIA'] == 'T')? (PHP_EOL.$item['DIA']. $item['HORA_MATERIA']):(PHP_EOL. $item['DIA']))
                                                .PHP_EOL.PHP_EOL.'')
                                                .urlencode($mensagem); ?>" href="javascript:void(0);">

                                            <small><i class="material-icons">content_copy</i></small>
                                        </a>&nbsp;&nbsp;

                                        <?php if ($item['TIPO_MATERIA'] == 'S') { ?>
                                            <a class="btn btn-default pull-right  m-r-5 hidden-print"
                                            href="<?php if (!empty($item['LINK_MATERIA'])) echo $item['LINK_MATERIA']; ?>"
                                            target="_blank" data-toggle="tooltip" data-placement="top"
                                            title="Visualizar na Fonte">
                                                <small><i class="material-icons">link</i></small>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if (($this->auth->CheckMenu('geral','relatorio','ajaxRelease')==1) ){  ?>
                                    <h5>Release</h5>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-md-12 col-xl-12">
                                        <div class="form-line">
                                            <select class="form-control show-tick release_item" name="release" id="release" data-live-search="true" data-size="6">
                                                <option value="0">Selecione - Release da Mat&eacute;ria</option>
                                                <?php if (!empty($lista_release)) {
                                                    foreach ($lista_release as $itemRel): ?>
                                                        <option
                                                            value="<?php echo $itemRel['SEQ_RELEASE'].'|'.$item['SEQ_MATERIA']; ?>"
                                                            <?php if (!empty($item['SEQ_RELEASE']) and $item['SEQ_RELEASE']==$itemRel['SEQ_RELEASE']) echo 'selected';?>>
                                                            <?php echo resume($itemRel['DESC_RELEASE'],200).'('.date('d/m/Y',strtotime($itemRel['DATA_ENVIO_RELEASE'])).'/'.($this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $item['SEQ_SETOR']))->row()->SIG_SETOR).')'; ?>
                                                        </option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if (!empty($item['ANALISE_MATERIA'])) {?>
                                    <div class="row clearfix">
                                        <div class="panel-group" id="accordion_<?php echo $item['SEQ_MATERIA'];?>" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-col-cyan">
                                                <div class="panel-heading" role="tab" id="headingTwo_<?php echo $item['SEQ_MATERIA'];?>">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion_<?php echo $item['SEQ_MATERIA'];?>"
                                                           href="#collapseTwo_<?php echo $item['SEQ_MATERIA'];?>" aria-expanded="false" aria-controls="collapseTwo_<?php echo $item['SEQ_MATERIA'];?>">
                                                            <i class="material-icons">perm_contact_calendar</i>An&aacute;lise do Conte&uacute;do
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo_<?php echo $item['SEQ_MATERIA'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_<?php echo $item['SEQ_MATERIA'];?>" aria-expanded="false">
                                                    <div class="panel-body">
                                                        <?php echo $item['ANALISE_MATERIA'];?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else if (!empty($item['RESUMO_MATERIA']) and !empty($item['RESPOSTA_MATERIA'])) { ?>
                                    <div class="row clearfix">
                                        <div class="panel-group" id="accordion_<?php echo $item['SEQ_MATERIA'];?>" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-col-cyan">
                                                <div class="panel-heading" role="tab" id="headingTwo_<?php echo $item['SEQ_MATERIA'];?>">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion_<?php echo $item['SEQ_MATERIA'];?>"
                                                           href="#collapseTwo_<?php echo $item['SEQ_MATERIA'];?>" aria-expanded="false" aria-controls="collapseTwo_<?php echo $item['SEQ_MATERIA'];?>">
                                                            <i class="material-icons">perm_contact_calendar</i>An&aacute;lise do Conte&uacute;do
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo_<?php echo $item['SEQ_MATERIA'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_<?php echo $item['SEQ_MATERIA'];?>" aria-expanded="false">
                                                    <div class="panel-body">
                                                        <p><strong>Resumo: </strong><?php echo $item['RESUMO_MATERIA'];?></p>
                                                        <?php if (!empty($item['COMENTARIO_MATERIA'])){ ?>
                                                            <p><strong>Coment&aacute;rio: </strong><?php echo $item['COMENTARIO_MATERIA'];?></p>
                                                        <?php } ?>
                                                        <p><strong>Resposta: </strong><?php echo $item['RESPOSTA_MATERIA'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="header nopadding-print visible-print">

                                <strong><?php echo date('d/m/Y', strtotime($item['DATA_MATERIA_PUB'])); ?> -
                                    <?php if ($item['TIPO_MATERIA'] == 'I' and !empty($item['SEQ_VEICULO']))
                                        echo $dadoVeiculo->FANTASIA_VEICULO;
                                    else if ($item['TIPO_MATERIA'] == 'S' and !empty($item['SEQ_PORTAL']))
                                        echo $dadoVeiculo->NOME_PORTAL;
                                    else if ($item['TIPO_MATERIA'] == 'R' and !empty($item['SEQ_RADIO']))
                                        echo $dadoVeiculo->NOME_RADIO;
                                    else if ($item['TIPO_MATERIA'] == 'T' and !empty($item['SEQ_TV']))
                                        echo $dadoVeiculo->NOME_TV.' - '.$item['PROGRAMA_MATERIA'];
                                    ?></strong>&nbsp;&nbsp;
                                <?php if($item['TIPO_MATERIA']=='I') {
                                    $dadosMateriaArr = array();
                                    if (!empty($item['EDITORIA_MATERIA'])) array_push($dadosMateriaArr,$item['EDITORIA_MATERIA']);
                                    if (!empty($item['AUTOR_MATERIA'])) array_push($dadosMateriaArr,$item['AUTOR_MATERIA']);
                                    if (!empty($item['PAGINA_MATERIA'])) array_push($dadosMateriaArr,$item['PAGINA_MATERIA']);

                                    if (count($dadosMateriaArr)>0) echo '<strong>' . implode('/',$dadosMateriaArr).'</strong>';
                                } ?>
                                <i class="material-icons"><?php echo $descTipo[$item['TIPO_MATERIA']];?></i><br/>
                                <strong>
                                <?php if ($this->session->userdata('idClienteSessao')!=3  and $item['SEQ_CLIENTE']!=59 and $item['SEQ_CLIENTE']!=60) echo $item['DESC_SETOR'].' - '.$item['SIG_SETOR']; ?></strong><br/>
                                <?php if (!empty($item['ANALISE_MATERIA'])) {?>
                                    <strong><u>
                                            <a href="#">
                                                An&aacute;lise do Conte&uacute;do
                                            </a></u>
                                    </strong><br/>
                                    <?php echo $item['ANALISE_MATERIA'];?>
                                <?php } ?>
                            </div>
                            <div class="body nopadding nopadding-print">
                                <div class="panel-body nopadding-print">
                                    <h4 class="text-black-print">
                                        <?php echo $item['TIT_MATERIA'] ?>
                                    </h4>
                                    <p class="hidden-print">
                                        <?php
                                        $chaves = array();
                                        if (!empty($item['PC_MATERIA']))
                                            $chaves = explode(',', $item['PC_MATERIA']);
                                        foreach ($chaves as $valor2) { ?>
                                            <span class="btn badge bg-pink"><?php echo strtoupper($valor2); ?></span>
                                        <?php } ?>
                                    </p>
                                </div>
                                <div class="panel-body visible-print  nopadding-print">
                                    <a style="color: #0000FF !important;; text-decoration: underline!important;"
                                       href="<?php echo url_materia_simples($item['SEQ_CLIENTE']).$item['CHAVE']; ?>" target="_blank"
                                       ><?php echo url_materia_simples($item['SEQ_CLIENTE']).$item['CHAVE']; ?>
                                    </a>
                                </div>
                                <div class="panel-body hidden-print <?php if($item['TIPO_MATERIA']=='I') echo 'nopadding'; ?> ajax-materia"
                                 id="conteudo-<?php echo $item['SEQ_MATERIA']; ?>"
                                 
                                    >
                                    <div class="loader" align="center">
                                        <div class="preloader">
                                            <div class="spinner-layer pl-teal">
                                                <div class="circle-clipper left">
                                                    <div class="circle"></div>
                                                </div>
                                                <div class="circle-clipper right">
                                                    <div class="circle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <p>Carregando conte&uacute;do...</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
            endforeach;  } else { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row-center-content">
                                    <h2>Nenhuma Matéria encontrada!</h4>
                                </div>
                                <?php if (!empty($texto)) { 
                                    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row-center-content">'
                                            .'<h3>Termo de pesquisa...<i>'.$texto.'</i></h3></div>';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>            

    </div>        
</div>
<textarea id="alerta" class="textarea" style="width: 0px;height: 0px;resize: none;"></textarea>
<div class="modal fade" id="materiaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect btn-fechar-modal" data-dismiss="modal">Fechar</button>
            </div>
            <div id="modal-body-content" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect btn-fechar-modal" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function beforePrint () {
        for (const id in Chart.instances) {
            Chart.instances[id].resize()
        }
    }
    function aplicaReduzTexto(){
        $('div.expander').expander({
            slicePoint: 200,
            expandText: 'Leia mais',
            userCollapseText: 'ocultar'
        });
    };
    function playRadio(e){
        e.preventDefault();
        var materia = $(this).data('materia');
        $.ajax({
            mimeType: 'text/html; charset=utf-8',
            url: '<?php echo base_url('publico/ajaxViewer/')?>'+materia,
            type: 'GET',
            success: function (data) {
                $('#modal-body-content').html(data);
                $('#materiaModal').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            dataType: "html"
        });
    };
    $(function () {
        // inicio graf de linha
        var data_line = <?php echo $data_line; ?>;
        var ctx = document.getElementById("line_chart").getContext("2d");
        var myLineChart = new Chart(ctx, data_line);
        $("#line_chart").click( 
            function(evt){
                
                var activePoint = myLineChart.getElementAtEvent(event);

                if (activePoint.length > 0) {
                    var clickedDatasetIndex = activePoint[0]._datasetIndex;
                    var clickedElementIndex = activePoint[0]._index;
                    var clickedDatasetPoint = myLineChart.data.datasets[clickedDatasetIndex];
                    var label = clickedDatasetPoint.label;
                    var dia = myLineChart.data.labels[clickedElementIndex];  
                    var url = '<?php echo base_url('iniciousuario/'); ?>';
                    var mesdia = dia.substring(3,5)+dia.substring(0,2);
                    var tipo = 't' ;
                    if (label=='Positiva') tipo = 'p';
                    if (label=='Negativa') tipo = 'n';

                   window.location.href = url+tipo+'/'+mesdia;

                }
            }
        ); 

        // grafica de barra horizontal -tv 
        var data_bar_tv = <?php echo $data_bar_tv; ?>;
        new Chart(document.getElementById("bar_tv"),data_bar_tv);
        // grafica de barra horizontal - radio
        var data_bar_radio = <?php echo $data_bar_radio; ?>;
        new Chart(document.getElementById("bar_radio"),data_bar_radio);

        // grafica de pizza tipo de midia 
        var data_pie_tipo = <?php echo $data_pie_tipo; ?>;

        new Chart(document.getElementById("pie_tipo"),data_pie_tipo);

        // grafica de barra tipo de midia 
        var data_bar_tipo = <?php echo $data_bar_tipo; ?>;
        new Chart(document.getElementById("bar_tipo"),data_bar_tipo); 

        // inicio graf de linha do tipo internet
        var data_line_internet = <?php echo $data_line_internet; ?>;
        var ctx = document.getElementById("line_internet").getContext("2d");
        var myLineChart = new Chart(ctx, data_line_internet);
        // inicio graf de linha do tipo impresso
        var data_line_impresso = <?php echo $data_line_impresso; ?>;
        var ctx = document.getElementById("line_impresso").getContext("2d");
        var myLineChart = new Chart(ctx, data_line_impresso);
        // inicio graf de linha do tipo radio
        var data_line_radio = <?php echo $data_line_radio; ?>;
        var ctx = document.getElementById("line_radio").getContext("2d");
        var myLineChart = new Chart(ctx, data_line_radio);
        // inicio graf de linha do tipo tv
        var data_line_tv = <?php echo $data_line_tv; ?>;
        var ctx = document.getElementById("line_tv").getContext("2d");
        var myLineChart = new Chart(ctx, data_line_tv);
        $('.up_images').lightGallery({
            thumbnail: true,
            selector: 'a'
        });
        $('.btn-radio-play').click(playRadio);
        $('.btn-fechar-modal').click(function(){
            $('#modal-body-content').html('');
        });

        $('#materiaModal').on('hidden.bs.modal', function () {
            $('#modal-body-content').html('');
        });
        $('.copiar').click(function(event) {
//            $("#alerta").text($(this).data('alerta'));
            $("#alerta").text(decodeURIComponent($(this).data('alerta').replace(/\+/g, ' ')));
            var copyTextarea = document.querySelector('.textarea');
            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                if(successful)
                    showNotification('alert-success', 'Alerta Copiado!', 'bottom', 'center', 'animated fadeInUp', '');
            } catch (err) {
                showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
            }
        });

        if (window.matchMedia) {
            let mediaQueryList = window.matchMedia('print')
            mediaQueryList.addListener((mql) => {
                if (mql.matches) {
                beforePrint()
                }
            })
        }    
        window.onbeforeprint = beforePrint


        $('.release_item').on("change", function(e) {
            var resposta = $(this).val();

            var chaves = resposta.split("|");
            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: '/monitor/relatorio/ajaxRelease/' + chaves[1] + '/' + chaves[0],
                type: 'GET',
                success: function (data) {
                    $('.clsShow_NotificationS').fadeIn();
                    $('.clsShow_NotificationS').fadeOut(3000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Ocorreu Algum Problema, nao foi possivel alterar!');
                    console.log(errorThrown);
                },
                dataType: "text",
                async: false
            });
        });
        $('div.expander').expander({
            slicePoint: 600,
            expandText: 'Leia mais',
            userCollapseText: 'ocultar'
        });
        

        $.each($(document).find('.ajax-materia'), function(index, item) {
            $.ajax({
                url: '<?php echo base_url('publico/ajaxConteudo/')?>'+$(item).attr('id').split('-')[1],
                type: "get",
                async: true,
            })
                .done(function(data)
                {
                    $(item).html(data);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                });

        });
        $('#dataf').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#datai').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar',
            minDate : moment('01-09-2020', 'DD/MM/YYYY')
        }).on('change', function(e, date){
            $('#dataf').bootstrapMaterialDatePicker('setMinDate', date);
        });
    });
</script>
<div class="block-header inline nopadding hidden-print">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-left">
            <li>
                <a href="javascript:void(0);">
                    <i class="material-icons">home</i> Publica&ccedil;&otilde;es
                </a>
            </li>
        </ol>
    </div>
</div>
<style type="text/css">
    .ajax-load{
        background: #e1e1e1;
        padding: 10px 0px;
        width: 100%;
    }
</style>
<div class="row clearfix" id="materia-data">
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
//                $mensagem = $item['TIT_MATERIA'].PHP_EOL.'Link: '.url_materia_simples().$item['CHAVE'];
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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                        <div class="card ">
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
                                <br/><?php if ($this->session->userData('idClienteSessao')!=3) echo $item['DESC_SETOR'].' - '.$item['SIG_SETOR']; ?>
                                <?php if($item['TIPO_MATERIA']=='I') {
                                    $dadosMateriaArr = array();
                                    if (!empty($item['EDITORIA_MATERIA'])) array_push($dadosMateriaArr,$item['EDITORIA_MATERIA']);
                                    if (!empty($item['AUTOR_MATERIA'])) array_push($dadosMateriaArr,$item['AUTOR_MATERIA']);
                                    if (!empty($item['PAGINA_MATERIA'])) array_push($dadosMateriaArr,$item['PAGINA_MATERIA']);

                                    if (count($dadosMateriaArr)>0) echo '<br/>' . implode('/',$dadosMateriaArr);
                                } ?>

                                <?php
                                if ($this->session->userData('idClienteSessao')!=3) {
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
                                       class='btn bg-blue pull-right copiar'
                                       data-alerta="<?php $dataCliente =$this->ComumModelo->getTableData('CLIENTE',array('SEQ_CLIENTE'=>$this->session->userdata('idClienteSessao')))->row();
                                       echo ($item['IND_AVALIACAO']=='N'? '*MAT&Eacute;RIA NEGATIVA* '.utf8_decode('%F0%9F%9A%AB').utf8_decode('%F0%9F%9A%AB').utf8_decode('%F0%9F%9A%AB').PHP_EOL.'*'.trim($dataCliente->EMPRESA_CLIENTE).'*'.( ($dataCliente->IND_ALERTA_SETOR =='N')?'':PHP_EOL.$this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$item['SEQ_SETOR']))->row()->DESC_SETOR).(($item['TIPO_MATERIA'] == 'T')? (PHP_EOL.$item['DIA']. $item['HORA_MATERIA']):(PHP_EOL. $item['DIA'])).PHP_EOL.PHP_EOL:
                                               json_decode('"\u23F0"').'*Alerta de Clipping*'.PHP_EOL.'*'.trim($dataCliente->EMPRESA_CLIENTE).'*'.( ($dataCliente->IND_ALERTA_SETOR =='N')?'':PHP_EOL.$this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$item['SEQ_SETOR']))->row()->DESC_SETOR).(($item['TIPO_MATERIA'] == 'T')? (PHP_EOL.$item['DIA']. $item['HORA_MATERIA']):(PHP_EOL. $item['DIA'])).PHP_EOL.PHP_EOL.'').urlencode($mensagem); ?>" href="javascript:void(0);">

                                        <small><i class="material-icons">content_copy</i></small>
                                    </a>&nbsp;&nbsp;

                                <?php if ($item['TIPO_MATERIA'] == 'S') { ?>
                                    <a class="btn bg-teal pull-right hidden-print"
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
                                                        <p><strong>Resposta: </strong><?php echo $item['RESPOSTA_MATERIA'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="header nopadding-print visible-print">

                                <strong><?php if ($item['TIPO_MATERIA'] == 'I' and !empty($item['SEQ_VEICULO']))
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
                                <strong><?php if ($this->session->userdata('idClienteSessao')!=3) echo $item['DESC_SETOR'].' - '.$item['SIG_SETOR']; ?></strong><br/>
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
                                <div class="panel-body hidden-print">
                                    <?php if($item['TIPO_MATERIA']=='S') { ?>
                                    <div class="expander">
                                        <p class="text-justify">
                                            <?php echo nl2br($item['TEXTO_MATERIA']);?>
                                        </p>
                                     </div>
                                    <?php }
                                    if($item['TIPO_MATERIA']=='I') {
                                            $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                                            if (count($anexos) > 0) {
                                                foreach ($anexos as $itemA):
                                                    ?>
                                                        <p class="text-center">
                                                            <div class="up_images">
                                                            <a href="<?php echo base_url('publico/imagem/').$itemA['SEQ_ANEXO'] ?>">
                                                            <img class="img-responsive" src="<?php echo base_url('publico/imagem/'.$itemA['SEQ_ANEXO']); ?>"/>
                                                            </a>
															</div>
                                                        </p>
                                                    <?php
                                                endforeach;
                                            }
                                            } else if($item['TIPO_MATERIA']=='R'or $item['TIPO_MATERIA']=='T') {
                                        $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                                                if (count($anexos) > 0) {
                                                    $controle = 0;
                                                    foreach ($anexos as $itemA):
                                                        $controle++;
                                                        if($controle ==1){
                                                        ?><p class="text-center">
                                                        <?php if ($this->ComumModelo->existeAnexo($itemA['SEQ_ANEXO'])) { ?>
                                                        <a  class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float btn-radio-play"
                                                        data-toggle="tooltip" data-placement="top" title="Play na Not&iacute;cia" data-materia="<?php echo $item['SEQ_MATERIA']; ?>">
                                                            <i class="material-icons">play_circle_outline</i>
                                                        </a>
<!--                                                             <audio src="--><?php //echo base_url('publico/audio/').$itemA['SEQ_ANEXO'] ?><!--" controls>-->
<!--                                                             </audio><br/>-->
                                                             <a data-toggle="tooltip" data-placement="top" title="Baixar Not&iacute;cia" class='btn bg-teal btn-circle-lg waves-effect waves-circle waves-float'
                                                                   href="<?php echo base_url('publico/audiodown/') .$itemA['SEQ_ANEXO']  ?>">
                                                                    <i class="material-icons">file_download</i>
                                                                </a>
                                                        <?php } else { ?>
                                                              <p>Sem M&iacute;dia para reprodu&ccedil;&atilde;o </p>
                                                        <?php } ?>
                                                            </p>
                                                        <?php
                                                   } endforeach;
                                                }
                                    } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
            endforeach;  } ?>
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
    });
</script>
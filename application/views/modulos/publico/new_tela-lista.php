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
<div class="row clearfix" id="materia-data">
            <?php $descTipo =array(
                'S'=>'cloud_queue',
                'I'=>'description',
                'R'=>' radio',
                'T'=>' tv'
            );
            $control = 0;
            if (!empty($lista_dias)) {
                foreach ($lista_dias as $item):
                    $dadoVeiculo = NULL;
                    $control++;

                    if ($item['TIPO_MATERIA'] == 'I' and !empty($item['SEQ_VEICULO']))
                        $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row();
                    else if ($item['TIPO_MATERIA'] == 'S' and !empty($item['SEQ_PORTAL']))
                        $dadoVeiculo = $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row();
                    else if ($item['TIPO_MATERIA'] == 'R' and !empty($item['SEQ_RADIO']))
                        $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row();
                    else if ($item['TIPO_MATERIA'] == 'T' and !empty($item['SEQ_TV']))
                        $dadoVeiculo = $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $item['SEQ_TV']))->row();
                    if ($item['TIPO_MATERIA'] == 'I' and !empty($item['SEQ_VEICULO'])) {
                        $mensagem = $dadoVeiculo->FANTASIA_VEICULO . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'].PHP_EOL. $item['DIA'];
                    } else if ($item['TIPO_MATERIA'] == 'S' and !empty($item['SEQ_PORTAL'])) {
                        $mensagem = $dadoVeiculo->NOME_PORTAL . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'].PHP_EOL. $item['DIA'];
                    } else if ($item['TIPO_MATERIA'] == 'R' and !empty($item['SEQ_RADIO'])){
                    $mensagem = $dadoVeiculo->NOME_RADIO.PHP_EOL.$item['PROGRAMA_MATERIA'].PHP_EOL.$item['TIT_MATERIA'].PHP_EOL.'Link: '.url_materia_simples($item['SEQ_CLIENTE']).$item['CHAVE'].PHP_EOL. $item['DIA'];
                    } else if ($item['TIPO_MATERIA'] == 'T' and !empty($item['SEQ_TV'])) {
                        $mensagem = $dadoVeiculo->NOME_TV . PHP_EOL .$item['PROGRAMA_MATERIA'].PHP_EOL. $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'].PHP_EOL. $item['DIA']. $item['HORA_MATERIA'];
                    }
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="card" style="height: 500px !important;">
                            <div class="header nopadding-print hidden-print">
                                <div class="row clearfix">
                                    <div  class="col-xs-9 col-md-9 col-xl-9">
                                        Publicado em <?php echo $item['DIA'] ?> no
                                        <?php if ($item['TIPO_MATERIA'] == 'I' and !empty($item['SEQ_VEICULO']))
                                            echo $dadoVeiculo->FANTASIA_VEICULO;
                                        else if ($item['TIPO_MATERIA'] == 'S' and !empty($item['SEQ_PORTAL']))
                                            echo $dadoVeiculo->NOME_PORTAL;
                                        else if ($item['TIPO_MATERIA'] == 'R' and !empty($item['SEQ_RADIO']))
                                            echo $dadoVeiculo->NOME_RADIO;
                                        else if ($item['TIPO_MATERIA'] == 'T' and !empty($item['SEQ_TV']))
                                            echo $dadoVeiculo->NOME_TV.' - '.$item['PROGRAMA_MATERIA']; ?>
                                        <br/><?php if($flagModelo<>'S' and $flagTema=='N' and $this->session->userData('idClienteSessaoAlerta') !=3) echo $item['DESC_SETOR'].' - '.$item['SIG_SETOR']; ?>
                                        <?php if($item['TIPO_MATERIA']=='I') {
                                              $dadosMateriaArr = array();
                                            if (!empty($item['EDITORIA_MATERIA'])) array_push($dadosMateriaArr,$item['EDITORIA_MATERIA']);
                                            if (!empty($item['AUTOR_MATERIA'])) array_push($dadosMateriaArr,$item['AUTOR_MATERIA']);
                                            if (!empty($item['PAGINA_MATERIA'])) array_push($dadosMateriaArr,$item['PAGINA_MATERIA']);

                                            if (count($dadosMateriaArr)>0) echo '<br/>' . implode('/',$dadosMateriaArr);
                                              } ?>

                                        <?php
                                            if ($this->session->userData('idClienteSessaoAlerta') !=3 and $flagTema=='N') {
                                                if ($item['IND_AVALIACAO'] == 'P') { ?>
                                                    <span class="badge bg-green hidden-print"><?php echo 'Positiva'; ?></span>
                                                <?php } else if ($item['IND_AVALIACAO'] == 'T') { ?>
                                                    <span class="badge bg-grey hidden-print"><?php echo 'Neutra'; ?></span>
                                                <?php } else if ($item['IND_AVALIACAO'] == 'N') { ?>
                                                    <span class="badge bg-red hidden-print"><?php echo 'Negativa'; ?></span>
                                                <?php }
                                            }?>
                                        <i class="material-icons"><?php echo $descTipo[$item['TIPO_MATERIA']];?></i>
                                        </div>
                                    <div  class="col-xs-3 col-md-3 col-xl-3">
                                            <a data-toggle="tooltip" data-placement="top" title="Compartilhar Whatsapp"
                                               class='btn bg-blue pull-right hidden-xl hidden-lg'
                                               href="whatsapp://send?text=%F0%9F%93%B0+<?php echo urlencode($mensagem); ?>">
                                                <small class=""><i class="material-icons">share</i></small>
                                            </a>&nbsp;&nbsp;
                                            <?php if ($item['TIPO_MATERIA'] == 'S') { ?>
                                                <a class="btn bg-teal pull-right hidden-print"
                                                   href="<?php if (!empty($item['LINK_MATERIA'])) echo $item['LINK_MATERIA']; else echo 'javascript:void(0);'; ?>"
                                                   target="_blank" data-toggle="tooltip" data-placement="top"
                                                   title="Visualizar na Fonte">
                                                    <small class=""><i class="material-icons">link</i></small>
                                                </a>
                                            <?php } ?>
                                    </div>
                                </div>
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
                                <strong><?php echo $item['DIA'] ?> -
                                    <?php if ($item['TIPO_MATERIA'] == 'I' and !empty($item['SEQ_VEICULO']))
                                    echo $dadoVeiculo->FANTASIA_VEICULO;
                                else if ($item['TIPO_MATERIA'] == 'S' and !empty($item['SEQ_PORTAL']))
                                    echo $dadoVeiculo->NOME_PORTAL;
                                else if ($item['TIPO_MATERIA'] == 'R' and !empty($item['SEQ_RADIO']))
                                    echo $dadoVeiculo->NOME_RADIO.' - '.$item['PROGRAMA_MATERIA'];
                                else if ($item['TIPO_MATERIA'] == 'T' and !empty($item['SEQ_TV']))
                                    echo $dadoVeiculo->NOME_TV.' - '.$item['PROGRAMA_MATERIA'];
                                    ?></strong>
                                <?php if($item['TIPO_MATERIA']=='I') {
                                    $dadosMateriaArr = array();
                                    if (!empty($item['EDITORIA_MATERIA'])) array_push($dadosMateriaArr,$item['EDITORIA_MATERIA']);
                                    if (!empty($item['AUTOR_MATERIA'])) array_push($dadosMateriaArr,$item['AUTOR_MATERIA']);
                                    if (!empty($item['PAGINA_MATERIA'])) array_push($dadosMateriaArr,$item['PAGINA_MATERIA']);

                                    if (count($dadosMateriaArr)>0) echo '<strong>' . implode('/',$dadosMateriaArr).'</strong>';
                                } ?>
                                <i class="material-icons"><?php echo $descTipo[$item['TIPO_MATERIA']];?></i><br/>
                                <?php if ($this->session->userData('idClienteSessaoAlerta') !=3) { ?>
                                <strong><?php if ($this->session->userData('idClienteSessaoAlerta')!=3
                                        and $item['SIG_SETOR']  and $flagTema=='N') echo
                                        $item['DESC_SETOR'].' - '.$item['SIG_SETOR']; ?></strong><br/>
                                <?php } ?>
                                <?php if (!empty($item['ANALISE_MATERIA'])) {?>
                                                    <strong><u>
                                                        <a href="#">
                                                            An&aacute;lise do Conte&uacute;do
                                                        </a></u>
                                                        </strong><br/>
                                                        <?php echo $item['ANALISE_MATERIA'];?>
                                <?php } ?>
                            </div>
                            <div class="body nopadding nopadding-print" >
                                <div class="panel-body nopadding-print" >
                                    <h4 class="text-black-print">
                                        <?php echo $item['TIT_MATERIA'] ?>
                                        <?php  if ($item['TIPO_MATERIA']=='T' and  !empty($item['HORA_MATERIA'])) { ?>
                                        &nbsp;&nbsp;<span class="label label-default"><?php  echo $item['HORA_MATERIA']; ?></span>
                                        <?php  } ?>
                                    </h4>
                                    <p class="hidden-print">
                                        <?php
                                        $chaves = array();
                                        if (!empty($item['PC_MATERIA'])  and $flagModelo<>'S' and $flagTema=='N')
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
                                    style="height: 200px !important;overflow: hidden !important; padding-bottom: 5px !important;"
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
                    //if (($control%3)==0) echo '</div><div class="row clearfix">';
            endforeach;  } ?>
</div>
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
            dataType: "html",
            async: false
        });
    };
    function aplicaReduzTexto(){

        $('div.expander').expander({
             slicePoint: 200,
            expandText: 'Leia mais',
            userCollapseText: 'ocultar'
        });
    };

    var page = 0;
    var findPage = true;
    function loadMoreData(page){
        $.ajax({
                url: '?page=' + page,
                type: "get",
                async: false,
                beforeSend: function()
                {
                    $('.ajax-load').show();
                }
                })
                .done(function(data)
                {
                    if(data == "stop"){
                        $('.ajax-load').html("Fim das mat&eacute;rias");
                        findPage = false;
                        return;
                    }
                    $('.ajax-load').hide();
                    $("#materia-data").append(data);
                    aplicaReduzTexto();
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    console.log(jqXHR);
                    console.log(ajaxOptions);
                    console.log(thrownError);
                });
    }
    $(function () {
//        while (findPage) {
//            page++;
//            loadMoreData(page);
//        }



        $.each($(document).find('.ajax-materia'), function(index, item) {
            let codigoMat = $(item).attr('id').split('-')[1];
            $.ajax({
                url: '<?php echo base_url('publico/ajaxConteudo/')?>'+codigoMat,
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

            console.log();
        });

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

    });
</script>
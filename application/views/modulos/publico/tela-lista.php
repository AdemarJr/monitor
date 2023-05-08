<style>
    .cidades {
        width: 50%;
    }
    @media only screen and (max-width: 600px) {
        .cidades {
            width: 100%;
        }
    }
    @media print {
            img {
                page-break-after: avoid !important; /* 'always,' 'avoid,' 'left,' 'inherit,' or 'right' */
            }
        }
        </style>
<div class="block-header inline nopadding hidden-print">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-left">
            <li>
                <a href="javascript:void(0);">
                    <i class="material-icons">home</i> Publica&ccedil;&otilde;es
                </a>
            </li>
        </ol>
        <?php 
        if (isset($_SESSION['idClienteSessaoAlerta'])) {
        ?>
<!--        <button class="btn bg-blue">GERAR RELATÓRIO DE REDES SOCIAIS</button>-->
        <?php } ?>
    </div>
</div>
<div class="row clearfix row-center-content" id="materia-data">
    
            <?php $descTipo =array(
                'S'=>'cloud_queue',
                'I'=>'description',
                'R'=>' radio',
                'T'=>' tv'
            );
            $control = 0;
            if (!empty($lista_dias)) {
                foreach ($lista_dias as $item):
//                echo '<pre>';
//                print_r($_SESSION);
//                die();
                    $dadoVeiculo = NULL;
                    $control++;
//                    echo '<pre>'; 
//                    print_r($item);
//                    die();
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
                    $mensagem = $dadoVeiculo->NOME_RADIO.PHP_EOL.$item['PROGRAMA_MATERIA'].PHP_EOL.$item['TIT_MATERIA'].PHP_EOL.'Link: '.url_materia_simples($item['SEQ_CLIENTE']).$item['CHAVE'].PHP_EOL. $item['DIA'].(!empty($item['HORA_MATERIA'])?$item['HORA_MATERIA']:'');
                    } else if ($item['TIPO_MATERIA'] == 'T' and !empty($item['SEQ_TV'])) {
                        $mensagem = $dadoVeiculo->NOME_TV . PHP_EOL .$item['PROGRAMA_MATERIA'].PHP_EOL. $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'].PHP_EOL. $item['DIA']. $item['HORA_MATERIA'];
                    }
                    $colTam='4';
                    $corLink='bg-teal';
                    $corAnalise='btn-primary';
                    if ($flagEleicao){
                        $colTam='8';
                        $corLink='btn-default btn-circle';
                        $corAnalise='btn-default';
                    }
                    ?>
                    <div class="col-lg-<?php echo $colTam;?> col-md-<?php echo $colTam;?> col-sm-12 col-xs-12 height-print">
                        <div class="card">
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
                                        <br/><?php if( /*$flagModelo<>'S' and $flagTema=='N' and*/ $this->session->userData('idClienteSessaoAlerta') !=3) echo $item['DESC_SETOR'].' - '.$item['SIG_SETOR']; ?>
                                        <?php if($item['TIPO_MATERIA']=='I') {
                                              $dadosMateriaArr = array();
                                            if (!empty($item['EDITORIA_MATERIA'])) array_push($dadosMateriaArr,$item['EDITORIA_MATERIA']);
                                            if (!empty($item['AUTOR_MATERIA'])) array_push($dadosMateriaArr,$item['AUTOR_MATERIA']);
                                            if (!empty($item['PAGINA_MATERIA'])) array_push($dadosMateriaArr,$item['PAGINA_MATERIA']);

                                            if (count($dadosMateriaArr)>0) echo '<br/>' . implode('/',$dadosMateriaArr);
                                              } ?>

                                        <?php
                                            if ($this->session->userData('idClienteSessaoAlerta') !=3 
											and $this->session->userData('idClienteSessaoAlerta') !=46 
											and $flagTema=='N') {
                                                if ($item['IND_AVALIACAO'] == 'P') { ?>
                                                    <span class="badge bg-green hidden-print"><?php echo 'Positiva'; ?></span>
                                                <?php } else if ($item['IND_AVALIACAO'] == 'T') { ?>
                                                    <span class="badge bg-grey hidden-print"><?php echo 'Neutra'; ?></span>
                                                <?php } else if ($item['IND_AVALIACAO'] == 'N') { ?>
                                                    <span class="badge bg-red hidden-print"><?php echo 'Negativa'; ?></span>
                                                <?php }
                                            }?>
                                        <i class="material-icons"><?php echo $descTipo[$item['TIPO_MATERIA']];?></i>
                                        <?php if (!empty($item['CIDADES_INTERIOR'])) { ?>            
                                                <br>    
                                                <?php
                                                $lista_cidades = explode(',', $item['CIDADES_INTERIOR']);
                                                $i = 0;
                                                foreach ($lista_cidades as $cidade) {

                                                    if ($i > 0) {
                                                        echo '<span class="badge bg-green" style="margin-left: 10px;">' . $cidade . '</span>';
                                                    } else {
                                                        echo '<span class="badge bg-green">' . $cidade . '</span>';
                                                    }
                                                    $i++;
                                                }
                                                ?> 
                                    <?php } ?>
                                        </div>
                                    <div  class="col-xs-3 col-md-3 col-xl-3">
                                            <?php if (isset($logado)) { ?>
                                                <?php 
                                                if (isset($_SESSION['acesso'])){
                                                $dominio = 'https://porto.am/monitor/';
                                                } else {
                                                $dominio = base_url();    
                                                }        
                                                ?>
                                                <a href="<?= $dominio.'materia/editar/'.$item['SEQ_MATERIA'] ?>"  data-tooltip="Editar Matéria" class="btn bg-blue pull-right" style="width: 50px;margin-left: 7%;" target="_blank" ><i class="material-icons left">edit</i></a>
                                             <?php } ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Compartilhar Whatsapp"
                                               class='btn bg-blue pull-right'
                                               href="whatsapp://send?text=%F0%9F%93%B0+<?php echo urlencode($mensagem); ?>">
                                                <small class=""><i class="material-icons">share</i></small>
                                            </a>&nbsp;&nbsp;
                                            <?php if ($item['TIPO_MATERIA'] == 'S') { ?>
                                                <a class="btn <?php echo $corLink; ?> pull-right hidden-print"
                                                   href="<?php if (!empty($item['LINK_MATERIA'])) echo $item['LINK_MATERIA']; else echo 'javascript:void(0);'; ?>"
                                                   target="_blank" data-toggle="tooltip" data-placement="top"
                                                   title="Visualizar na Fonte">
                                                    <small class=""><i class="material-icons">link</i></small>
                                                </a>
                                            <?php } ?>
                                    </div>
                                </div>
                                <?php if (!empty($item['ANALISE_MATERIA'])
                                    and $chaveNota!='gd0ofn9i11'
                                    and $chaveNota!='gd0og4nz5i'
                                    and $chaveNota!='gd0ogilzv8'
                                ) {?>
                                <div class="row clearfix">
                                    <button class="btn <?php echo $corAnalise; ?> waves-effect btn_analise" 
                                    data-caixa="collapseTwo_<?php echo $item['SEQ_MATERIA'];?>">
                                        <i class="material-icons">perm_contact_calendar</i>An&aacute;lise do Conte&uacute;do </button>
                                    <div style="display: none" class="panel-group" id="accordion_<?php echo $item['SEQ_MATERIA'];?>">
                                        <div class="panel panel-col-cyan">
                                            <div id="collapseTwo_<?php echo $item['SEQ_MATERIA'];?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_<?php echo $item['SEQ_MATERIA'];?>" aria-expanded="false">
                                                <div class="panel-body">
                                                    <?php echo $item['ANALISE_MATERIA'];?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } else if (!empty($item['RESUMO_MATERIA']) and $chaveNota!='gd0ofn9i11'
                                    and $chaveNota!='gd0og4nz5i'
                                    and $chaveNota!='gd0ogilzv8'
                                ) { ?>
                                    <div class="row clearfix">
                                        <button class="btn <?php echo $corAnalise; ?> waves-effect collapse btn_analise" data-caixa="collapseTwo_<?php echo $item['SEQ_MATERIA'];?>">
                                            <i class="material-icons">perm_contact_calendar</i>An&aacute;lise do Conte&uacute;do</button>
                                        <div style="display: none" class="panel-group" id="accordion_<?php echo $item['SEQ_MATERIA'];?>">
                                            <div class="panel panel-col-cyan">
                                                <div id="collapseTwo_<?php echo $item['SEQ_MATERIA'];?>" class="panel-collapse collapse"
                                                     role="tabpanel"
                                                     aria-labelledby="headingTwo_<?php echo $item['SEQ_MATERIA'];?>" aria-expanded="false">
                                                    <div class="panel-body">
                                                        <p><strong>Resumo: </strong><?php echo $item['RESUMO_MATERIA'];?></p>
                                                        <?php if (!empty($item['COMENTARIO_MATERIA'])){ ?>
                                                            <p><strong>Coment&aacute;rio: </strong><?php echo $item['COMENTARIO_MATERIA'];?></p>
                                                        <?php } ?>
                                                        <?php if (!empty($item['RESPOSTA_MATERIA'])) {?>    
                                                        <p><strong>Resposta: </strong><?php echo $item['RESPOSTA_MATERIA'];?></p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="header nopadding-print visible-print" style="margin-top: -30% !important;">
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
                                <?php if (!empty($item['ANALISE_MATERIA'])
                                    and $chaveNota!='gd0ofn9i11'
                                    and $chaveNota!='gd0og4nz5i'
                                    and $chaveNota!='gd0ogilzv8'
                                ) {?>
                                                    <strong><u>
                                                        <a href="#">
                                                            An&aacute;lise do Conte&uacute;do
                                                        </a></u>
                                                        </strong><br/>
                                                        <?php echo $item['ANALISE_MATERIA'];?>
                                <?php } ?>
                            </div>
                            <div class="body nopadding nopadding-print" style=" padding-bottom: 5px !important;">
                                <div class="panel-body nopadding-print" >
                                    <h4 class="text-black-print">
                                        <?php echo $item['TIT_MATERIA'] ?>
                                        <?php  if (in_array($item['TIPO_MATERIA'],array('T','R')) and  !empty($item['HORA_MATERIA'])) { ?>
                                        &nbsp;&nbsp;<span class="label label-default"><?php  echo $item['HORA_MATERIA']; ?></span>
                                        <?php  } ?>
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
                                <div class="panel-body  <?php if($item['TIPO_MATERIA']=='I') echo 'nopadding'; ?> ajax-materia"
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
<div class="modal fade" id="materiaModalAnalise" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">An&aacute;lise do Conte&uacute;do</h4>
                <button type="button" class="btn btn-link waves-effect btn-fechar-modal-analise pull-right" data-dismiss="modal">Fechar</button>
            </div>
            <div id="modal-body-content-analise" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect btn-fechar-modal-analise pull-right" data-dismiss="modal">Fechar</button>
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

        $('.btn_analise').on('click', function () {
            var cx = $(this).data('caixa');
            $('#modal-body-content-analise').html($('#'+cx).html());
            $('#materiaModalAnalise').modal('show');

//            swal({
//                title: "<small>An&aacute;lise do Conte&uacute;do</small>",
//                text: $('#'+cx).html(),
//                html: true
//            });
        });
        $('.btn-fechar-modal-analise').click(function(){
            $('#modal-body-content-analise').html('');
        });



    });
</script>
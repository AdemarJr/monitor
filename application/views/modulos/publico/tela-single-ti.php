<div class="block-header inline">
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
            <?php if (!empty($lista_dias)) {
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
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                        <div class="card ">
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
                                            echo $dadoVeiculo->NOME_TV;
                                        ?>
                                        <?php $flagModelo = empty($item['IND_MODELO'])? 'N':$item['IND_MODELO'];
                                          ?>
                                        <?php if($item['TIPO_MATERIA']=='I') {
                                            $dadosMateriaArr = array();
                                            if (!empty($item['EDITORIA_MATERIA'])) array_push($dadosMateriaArr,$item['EDITORIA_MATERIA']);
                                            if (!empty($item['AUTOR_MATERIA'])) array_push($dadosMateriaArr,$item['AUTOR_MATERIA']);
                                            if (!empty($item['PAGINA_MATERIA'])) array_push($dadosMateriaArr,$item['PAGINA_MATERIA']);

                                            if (count($dadosMateriaArr)>0) echo '<br/>' . implode('/',$dadosMateriaArr);
                                        } ?>
                                    </div>
                                    <div  class="col-xs-3 col-md-3 col-xl-3">
                                        <?php if (isset($_SESSION['perfilUsuario'])) { ?>
                                                <a href="<?= base_url('materia/editar/'.$item['SEQ_MATERIA']) ?>"  data-tooltip="Editar Matéria" class="waves-effect waves-light btn-small right blue darken-1 tooltipped" style="width: 50px;margin-right: 1%;" target="_blank" ><i class="material-icons left">edit</i></a>
                                             <?php } ?>
                                    <?php if ($item['TIPO_MATERIA'] == 'S') { ?>
                                        <a class="btn bg-teal pull-right hidden-print"
                                           href="<?php if (!empty($item['LINK_MATERIA'])) echo $item['LINK_MATERIA']; else echo 'javascript:void(0);'; ?>"
                                           target="_blank" data-toggle="tooltip" data-placement="top"
                                           title="Visualizar na Fonte">
                                            <small class="hidden-sm hidden-xs">Mat&eacute;ria na &Iacute;ntegra</small>
                                            <small class="visible-xs visible-sm hidden-md">Acesse</small>
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
                                    <?php } ?>
                            </div>
                            <?php if (!empty($item['ANALISE_MATERIA'])) {?>
                                <div class="visible-print">
                                    <strong class="visible-print"><u>
                                            <a href="#">
                                                An&aacute;lise do Conte&uacute;do
                                            </a></u>
                                    </strong><br/>
                                    <?php echo $item['ANALISE_MATERIA'];?>
                                </div>
                            <?php } ?>
                            <div class="body nopadding">
                                <div class="panel-body">
                                    <h4 class="col-blue-grey">
                                        <?php echo $item['TIT_MATERIA']; ?>
                                    </h4>
                                    <p>
                                        <?php
                                        $chaves = array();
                                        if (!empty($item['PC_MATERIA']))
                                            $chaves = explode(',', $item['PC_MATERIA']);
                                        foreach ($chaves as $valor2) { ?>
                                            <span class="btn badge bg-pink"><?php echo strtoupper($valor2); ?></span>
                                        <?php } ?>
                                    </p>
                                </div>
                                <div class="panel-body">
                                    <?php if ($item['TIPO_MATERIA'] == 'S') { ?>
                                        <p class="text-justify">
                                            <?php echo nl2br($item['TEXTO_MATERIA']); ?>
                                        </p>
                                    <?php }
                                    if ($item['TIPO_MATERIA'] == 'I') {
                                            $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                                            if (count($anexos) > 0) {
                                                foreach ($anexos as $itemA):
                                                    ?>
                                                        <p class="text-center">
                                                            <div class="up_images">
                                                            <a href="<?php echo base_url('publico/imagem2/N/').$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ?>">
                                                            <img class="img-responsive" src="<?php echo base_url('publico/imagem2/R/'.$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO']); ?>"/>
                                                            </a>
															</div>
                                                        </p>
                                                    <?php
                                                endforeach;
                                            }
                                            } else if ($item['TIPO_MATERIA'] == 'R') {
                                        $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                                        if (count($anexos) > 0) {
                                            foreach ($anexos as $itemA):
                                                ?>
                                                <p class="text-center">
                                                <?php if ($this->ComumModelo->existeAnexo($itemA['SEQ_ANEXO'])) { ?>
                                                <audio
                                                    src="<?php echo base_url('publico/audio/') . $itemA['SEQ_ANEXO'] ?>"
                                                    controls preload="auto">
                                                </audio>
                                                    <br/>
                                                <a data-toggle="tooltip" data-placement="top" title="baixar"
                                                   class='btn bg-cyan btn-sm waves-effect'
                                                   href="<?php echo base_url('publico/audiodown/') . $itemA['SEQ_ANEXO'] ?>">
                                                    baixar <i class="material-icons">file_download</i>
                                                </a>
                                                <?php } else { ?>
                                                  <p>Sem M&iacute;dia para reprodu&ccedil;&atilde;o </p>
                                                <?php } ?>
                                                </p>
                                                <?php
                                            endforeach;
                                        }
                                    } else if ($item['TIPO_MATERIA'] == 'T') {
                                    $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                                    if (count($anexos) > 0) {
                                    foreach ($anexos as $itemA):
                                    ?><p class="text-center">
                                        <?php if ($this->ComumModelo->existeAnexo($itemA['SEQ_ANEXO'])) { ?>
                                            <div align="center" class="embed-responsive embed-responsive-16by9">
                                                <video src="<?php echo base_url('publico/audio/') . $itemA['SEQ_ANEXO'] ?>"
                                                       class="img-responsive" controls preload="auto" >
                                                </video>
                                                <br/>
                                                <a data-toggle="tooltip" data-placement="top" title="baixar"
                                                   class='btn bg-cyan btn-sm waves-effect'
                                                   href="<?php echo base_url('publico/audiodown/') . $itemA['SEQ_ANEXO'] ?>">
                                                    baixar <i class="material-icons">file_download</i>
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <p>Sem M&iacute;dia para reprodu&ccedil;&atilde;o </p>
                                        <?php } ?>
                                </p>
                                <?php
                                endforeach;
                                }
                                } ?>
                            </div>
                            </div>

                        </div>
                    </div>
                    <?php
            endforeach;  } ?>
</div>
<div class="loader ajax-load text-center hidden-print" style="display:none">
    <div class="preloader ">
        <div class="spinner-layer pl-teal">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function () {
        $('.up_images').lightGallery({
            thumbnail: true,
            selector: 'a'
        });
    });
</script>
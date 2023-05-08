<div class="card">
    <div class="header">
        <div class="block-header inline">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ol class="breadcrumb breadcrumb-bg- align-left">
                    <li>
                        <a href="<?php echo base_url($this->uri->segment(1)) ?>">
                            <i class="material-icons">home</i> Publica&ccedil;&otilde;es
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url($this->uri->segment(1).'/detalhar/'.$this->session->userdata('anteNivelSessao')) ?>">
                        <i class="material-icons"><?php echo ($this->session->userdata('tipoSessao')=='R')?'radio':(($this->session->userdata('tipoSessao')=='S')?'public':'description');?></i>
                        <?php echo (($this->session->userdata('tipoSessao')=='R')?'R&aacute;dio':(($this->session->userdata('tipoSessao')=='S')?'Sites e Blogs':'Jornal Impresso')).' - '.$this->session->userdata('anoSessao');?>
                        </a>
                    </li>
                    <li class="active">
                        <i class="material-icons">event</i>
                        <?php echo descricaoMes($this->session->userdata('mesSessao')); ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="row clearfix">
            <?php
            if(count($lista_dias)>4) {
                $tmanho = floor(count($lista_dias) / 2);
                $arrayped1 = array_slice($lista_dias, 0, $tmanho);
                $arrayped2 = array_slice($lista_dias, $tmanho, count($lista_dias) - $tmanho);
            } else{
                $arrayped1 = $lista_dias;
                $arrayped2 = NULL;
            }
            ?>
            <?php if (!empty($arrayped1)) { ?>
                <div class="col-md-6">
                    <div class="card nopadding ">
                        <div class="body">
                            <?php if (!empty($arrayped1)) {
                            foreach ($arrayped1 as $item):
                                $dadoVeiculo=NULL;
                                if($item['TIPO_MATERIA']=='I' and !empty($item['SEQ_VEICULO']))
                                    $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row();
                                else if($item['TIPO_MATERIA']=='S' and !empty($item['SEQ_PORTAL']))
                                    $dadoVeiculo =  $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row();
                                else if($item['TIPO_MATERIA']=='R' and !empty($item['SEQ_RADIO']))
                                    $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row();
                                ?>
                                <div class="media">
                                    <div class="media-body">
                                        <p>
                                            <?php echo $item['DIA'] ?>
                                        </p>
                                        <h4 class="media-heading">
                                            <a href="javascript:void(0);" data-materia="<?php echo $item['SEQ_MATERIA'] ?>" class="col-blue-grey sub-n4" style="text-decoration: none!important; cursor: pointer !important;"><?php echo $item['TIT_MATERIA'] ?></a>
                                        </h4>
                                        <p>
                                            <?php if($item['TIPO_MATERIA']=='I' and !empty($item['SEQ_VEICULO']))
                                                echo $dadoVeiculo->FANTASIA_VEICULO;
                                            else if($item['TIPO_MATERIA']=='S' and !empty($item['SEQ_PORTAL']))
                                                echo $dadoVeiculo->NOME_PORTAL;
                                            else if($item['TIPO_MATERIA']=='R' and !empty($item['SEQ_RADIO']))
                                                echo $dadoVeiculo->NOME_RADIO; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach;  } ?>
                        </div>

                    </div>
                </div>
            <?php } if (!empty($arrayped2)) { ?>
                <div class="col-md-6">
                    <div class="card nopadding ">
                        <div class="body">
                            <?php if (!empty($arrayped2)) {
                                foreach ($arrayped2 as $item):
                                    $dadoVeiculo=NULL;
                                    if($item['TIPO_MATERIA']=='I' and !empty($item['SEQ_VEICULO']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row();
                                    else if($item['TIPO_MATERIA']=='S' and !empty($item['SEQ_PORTAL']))
                                        $dadoVeiculo =  $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row();
                                    else if($item['TIPO_MATERIA']=='R' and !empty($item['SEQ_RADIO']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row();
                                    ?>
                                    <div class="media">

                                        <div class="media-body">
                                            <p>
                                                <?php echo $item['DIA'] ?>
                                            </p>
                                            <h4  class="media-heading">
                                                <a href="javascript:void(0);" data-materia="<?php echo $item['SEQ_MATERIA'] ?>" class="col-blue-grey sub-n4" style="text-decoration: none!important; cursor: pointer !important;"><?php echo $item['TIT_MATERIA'] ?></a>
                                            </h4>
                                            <p>
                                                <?php if($item['TIPO_MATERIA']=='I' and !empty($item['SEQ_VEICULO']))
                                                    echo $dadoVeiculo->FANTASIA_VEICULO;
                                                else if($item['TIPO_MATERIA']=='S' and !empty($item['SEQ_PORTAL']))
                                                    echo $dadoVeiculo->NOME_PORTAL;
                                                else if($item['TIPO_MATERIA']=='R' and !empty($item['SEQ_RADIO']))
                                                    echo $dadoVeiculo->NOME_RADIO; ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach;  } ?>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="modal fade" id="materiaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Fechar</button>
                </div>
                <div id="modal-body-content" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.sub-n4').click(function(e){
            e.preventDefault();
            var materia = $(this).data('materia');
            $.ajax({
                mimeType: 'text/html; charset=utf-8',
                url: '<?php echo base_url($this->uri->segment(1).'/ajaxViewer/')?>'+materia,
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
        });
    });
</script>
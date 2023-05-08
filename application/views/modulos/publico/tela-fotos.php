<div class="block-header inline nopadding hidden-print">
    <h3>
        <?php echo $subtitulo; ?>
    </h3>
</div>
<div class="row clearfix" id="materia-data">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
        <div class="card ">
            <div class="body">
                <div id="aniimated-thumbnials" class="list-unstyled row clearfix up_images ">
                    <?php

                    if (!empty($lista_video)) {
                        $j = 1000;
                        foreach($lista_video as $itemm):
                            ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <div class="card ">
                                    <div class="body nopadding ">
                                    <div class="img-responsive thumbnail">
                                        <?php if (strpos($itemm, '.mp4')>0) { ?>
                                        <video src="<?php echo base_url('assets/albuns/'.$folder.'/'.$itemm); ?>"
                                               class="img-responsive" controls preload="auto" >
                                        </video>
                                        <?php } else { ?>
                                        <a href="<?php echo base_url('assets/albuns/'.$folder.'/'.$itemm); ?>" data-sub-html="Evento de 32 anos da Funda&ccedil;&atilde;o Matias Machline">
                                            <img class="" src="<?php echo base_url('assets/albuns/'.$folder.'/'.$itemm); ?>" height="312" width="432">
                                        </a>
                                        <?php } ?>

                                    </div>
                                    </div>
                                    </div>
                            </div>
                            <?php $j++;
                        endforeach;
                    } else {?>
                        Nenhuma Foto encontrada!
                    <?php } ?>


                </div>
            </div>
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
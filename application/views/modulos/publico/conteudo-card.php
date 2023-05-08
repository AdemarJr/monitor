<?php
if (!empty($lista_dias)) {
foreach ($lista_dias as $item):
    if($item['TIPO_MATERIA']=='S') {
		
        if ( $item['SEQ_CLIENTE'] ==12 || 
            $item['SEQ_CLIENTE'] ==4 || 
            $item['SEQ_CLIENTE'] == 53 ) {
            $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
            if (count($anexos) > 0) {
                foreach ($anexos as $itemA):
                    ?>
                            <div class="up_images-<?php echo $item['SEQ_MATERIA']; ?>">
                                <a href="<?php echo base_url('publico/imagem2/N/').$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ?>" >
                                    <img
                                        class="img-responsive thumbnail"
                                        src="<?php echo base_url('publico/imagem2/R/'.$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO']); ?>"
                                        />
                                </a>
                            </div>
                            
							
                    <?php  
                endforeach;
            }?>
			<div class="expander"><p class="text-justify"  style="font-size: 17px !important;"><?php echo nl2br($item['TEXTO_MATERIA']); ?></p></div> <?php 
         } else if ( 
                $item['SEQ_CLIENTE'] ==49 || 
                $item['SEQ_CLIENTE'] ==51 || 
                $item['SEQ_CLIENTE'] ==55  || 
                $item['SEQ_CLIENTE'] == 58 ||
                $item['SEQ_CLIENTE'] == 60 ||
                $item['SEQ_CLIENTE'] == 61 ||
                $item['SEQ_CLIENTE'] == 63 ||
                $item['SEQ_CLIENTE'] == 64
                ) {
            $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
            if ($item['SEQ_CLIENTE'] ==55  || 
                $item['SEQ_CLIENTE'] == 58 || 
                $item['SEQ_CLIENTE'] == 60 ||
                $item['SEQ_CLIENTE'] == 61 ||
                $item['SEQ_CLIENTE'] == 63 ||
                $item['SEQ_CLIENTE'] == 64
                ) {
            ?>
            <div class="col-xs-12" align="left">
                <i class="material-icons col-grey" style="font-size: 14px !important;" title="Coment&aacute;rios">comment</i><span style="font-size: 14px !important;"><?php echo $item['QTD_COMENTARIO'] ?></span>&nbsp;&nbsp;
                <i class="material-icons col-grey" style="font-size: 14px !important;" title="Curtidas">favorite</i><span style="font-size: 14px !important;"><?php echo $item['QTD_CURTIDA'] ?></span>&nbsp;&nbsp;
                <i class="material-icons col-grey" style="font-size: 14px !important;" title="Compartilhamentos">share</i><span style="font-size: 14px !important;"><?php echo $item['QTD_COMPARTILHAMENTO'] ?></span>
            </div>
            <?php }
            if (count($anexos) > 0) {
                ?>
                <div class="up_images-<?php echo $item['SEQ_MATERIA']; ?>">
                <?php
                foreach ($anexos as $itemA):
                    ?>

                                <a href="<?php echo base_url('publico/imagem2/N/').$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ?>" >
                                    <img
                                        class="img-responsive thumbnail"
                                        src="<?php echo base_url('publico/imagem2/R/'.$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO']); ?>"
                                        />
                                </a>

                    <?php
                endforeach; ?>
                </div>
            <?php
            }
         } else if ( $item['SEQ_CLIENTE'] ==39 ) {
            $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
            if (count($anexos) > 0) {
                foreach ($anexos as $itemA):
                    ?>
                            <div class="up_images-<?php echo $item['SEQ_MATERIA']; ?>">
                                <a href="<?php echo base_url('publico/imagem2/N/').$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ?>" >
                                    <img
                                        class="img-responsive thumbnail"
                                        src="<?php echo base_url('publico/imagem2/R/'.$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO']); ?>"
                                        />
                                </a>
                            </div>
                    <?php
                endforeach;
            }
         } else {   ?>

    <div class="expander"><p class="text-justify"  style="font-size: 17px !important;"><?php echo nl2br($item['TEXTO_MATERIA']); ?></p></div>
    <?php }}
     if($item['TIPO_MATERIA']=='I') {
            $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                if (count($anexos) > 0) {
                    foreach ($anexos as $itemA):
                        ?>
                            <div class="up_images-<?php echo $item['SEQ_MATERIA']; ?>">
                                <a href="<?php echo base_url('publico/imagem2/N/').$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ?>">
                                    <img class="img-responsive"  src="<?php echo base_url('publico/imagem2/R/'.$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ); ?>"/>                                                            </a>
                            </div>
                        <?php
                    endforeach;
                }
            } else if($item['TIPO_MATERIA']=='R' or $item['TIPO_MATERIA']=='T') {
                $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                if (count($anexos) > 0) {
                    $controle = 0;
                    foreach ($anexos as $itemA):
                        $controle++;
                        if($controle ==1){
                        ?><p>
                        <?php if ($this->ComumModelo->existeAnexo($itemA['SEQ_ANEXO'])) { ?>
                        <a  class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float btn-radio-play-<?php echo $item['SEQ_MATERIA']; ?>"
                        data-toggle="tooltip" data-placement="top" title="Play na Not&iacute;cia" data-materia="<?php echo $item['SEQ_MATERIA']; ?>">
                            <i class="material-icons">play_circle_outline</i>
                        </a>
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
            }
endforeach;
} ?>

<script type="text/javascript">

    $(function () {

        aplicaReduzTexto();
        $('.btn-radio-play-<?php echo $item['SEQ_MATERIA']; ?>').click(playRadio);
        $('.up_images-<?php echo $item['SEQ_MATERIA']; ?>').lightGallery({
            thumbnail: true,
            selector: 'a'
        });

    });
</script>

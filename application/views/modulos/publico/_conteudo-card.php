<?php
if (!empty($lista_dias)) {
foreach ($lista_dias as $item):
    if($item['TIPO_MATERIA']=='S') {
		
        if ( $item['SEQ_CLIENTE'] ==12 ) {
            $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
            if (count($anexos) > 0) {
                foreach ($anexos as $itemA):
                    ?>
                            <div class="up_images">
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
         } else if ( $item['SEQ_CLIENTE'] ==49 || $item['SEQ_CLIENTE'] ==51) {
            $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
            if (count($anexos) > 0) {
                foreach ($anexos as $itemA):
                    ?>
                            <div class="up_images">
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
         } else if ( $item['SEQ_CLIENTE'] ==39 ) {
            $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
            if (count($anexos) > 0) {
                foreach ($anexos as $itemA):
                    ?>
                            <div class="up_images">
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
                        <div class="up_images">
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
                        ?><p class="text-center">
                        <?php if ($this->ComumModelo->existeAnexo($itemA['SEQ_ANEXO'])) { ?>
                        <a  class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float btn-radio-play"
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



    });
</script>

<div class="col-xs-12 col-md-12 col-xl-12">
    <div id="up_images2" class="list-unstyled">
        <?php if (!empty($lista_anexo)) {
            foreach ($lista_anexo as $item): ?>
                <div id="<?php echo $item['SEQ_ANEXO'] ?>" class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <button data-toggle="tooltip" data-placement="top" title="Excluir Anexo" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float botao-excluir-anexo'
                            data-url="<?php echo base_url('materia/deleteanexo/') . $item['SEQ_MATERIA'].'/'.$item['SEQ_ANEXO'] ?>">
                        <i class="material-icons">delete</i>
                    </button>
                    <?php if ($this->ComumModelo->existeAnexo($item['SEQ_ANEXO'])) { ?>
                        <button type="button" data-toggle="tooltip" data-placement="top" title="baixar" class='btn bg-cyan btn-sm waves-effect botao-baixar'
                                data-url="<?php echo base_url('publico/audiodown/') .$item['SEQ_ANEXO']  ?>">
                            <i class="material-icons">file_download</i>
                        </button>
                    <?php } ?>
                    <?php if($tipoMateria == 'I' or $tipoMateria == 'S') { ?>
                        <a href="<?php echo base_url('materia/imagem/').$item['SEQ_ANEXO'] ?>">
                            <img class="img-responsive thumbnail" src="<?php echo base_url('materia/imagem/').$item['SEQ_ANEXO'] ?>">
                        </a>
                        <div class="form-line">
                            <input class='form-control ordem-change' type="number" id="imgOdem" name="imgOrdem" data-anexo="<?php echo $item['SEQ_ANEXO']; ?>" data-old="<?php echo $item['ORDEM_ARQUIVO']; ?>" value="<?php echo $item['ORDEM_ARQUIVO']; ?>"/>
                            <label id="label-for" class="form-label">Ordem da Imagem</label>
                        </div>
                    <?php } else if($tipoMateria == 'R') { ?>
                        <div style=" display:inline-block;border: 1px solid;">
                                <audio src="<?php echo base_url('materia/audio/').$item['SEQ_ANEXO'] ?>" controls preload="auto">
                                    <p>Seu navegador não suporta o elemento audio </p>
                                </audio><br/>
                        </div>
                    <?php } else if($tipoMateria == 'T') { ?>
                        <div style=" display:inline-block;border: 1px solid;">

                                <div align="center" class="class="embed-responsive embed-responsive-16by9">
                                    <video src="<?php echo base_url('materia/audio/').$item['SEQ_ANEXO'] ?>" controls preload="auto" >
                                        <p>Seu navegador não suporta o elemento audio </p>
                                    </video><br/>
                                </div>

                        </div>
                    <?php } ?>
                </div>
            <?php endforeach;
        } ?>
    </div>
</div>
<script type="text/javascript">

    $(function () {

        $('.botao-excluir-anexo').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você excluirá este Arquivo da matéria.',$(this));
            return false;
        });

        $('#up_images2').lightGallery({
            thumbnail: true,
            selector: 'a'
        });
        $('.ordem-change').blur(atualizaAnexos);
    });
</script>
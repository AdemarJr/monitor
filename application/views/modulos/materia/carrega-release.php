    <option value="0">Selecione - Release da Mat&eacute;ria</option>
    <?php if (!empty($lista_release)) {
        foreach ($lista_release as $item): ?>
            <option
                value="<?php echo $item['SEQ_RELEASE'] ?>" <?php if (!empty($release) and $release==$item['SEQ_RELEASE']) echo 'selected';?>><?php echo $item['DESC_RELEASE'].'('.date('d/m/Y',strtotime($item['DATA_ENVIO_RELEASE'])).')'; ?></option>
        <?php endforeach;
    } ?>

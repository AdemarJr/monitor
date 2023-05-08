<select class="form-control show-tick" name="preco"
        id="preco" data-live-search="true" data-size="6">
    <option value="0">Selecione - Preço</option>
    <?php if (!empty($lista_preco)) {
        foreach ($lista_preco as $item): ?>
            <option
                value="<?php echo $item['SEQ_PRECO'] ?>" <?php if (!empty($preco) and $preco==$item['SEQ_PRECO']) echo 'selected';?>>
                <?php echo $item['DESCRITIVO'].'('.$item['QTD_SEGUNDO'].') - ('.$item['VALOR'].')'; ?></option>
        <?php endforeach;
    } ?>
</select>

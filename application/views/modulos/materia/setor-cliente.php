        <div class="panel-body">
            <?php if (!empty($lista_setores)) {
                foreach($lista_setores as $itemm):
                    ?>
                    <div class="col-xs-12 col-md-12 col-xl-12">
                        <span>Avalia&ccedil;&atilde;o para <?php
                            $dataSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $itemm['SEQ_SETOR']))->row()->DESC_SETOR;
                            echo $dataSetor; ?></span>
                        <div class="form-group">
                            <input class="radio-col-teal processa-avaliacao" name="avaliacao_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" type="radio" data-valor="P" data-chave="<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" id="avaliacaoP2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>"  value="P" <?php if (!empty($itemm['IND_AVALIACAO']) and $itemm['IND_AVALIACAO']=='P') echo 'checked';?> />
                            <label for="avaliacaoP2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>">Positiva</label>
                            <input class="radio-col-red processa-avaliacao" name="avaliacao_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" data-valor="N" data-chave="<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" type="radio" id="avaliacaoN2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>"  value="N" <?php if (!empty($itemm['IND_AVALIACAO']) and $itemm['IND_AVALIACAO']=='N') echo 'checked';?>/>
                            <label for="avaliacaoN2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>">Negativa</label>
                            <input class="radio-col-yellow processa-avaliacao" name="avaliacao_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" data-valor="T" data-chave="<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" type="radio" id="avaliacaoT2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>"  value="T" <?php if (!empty($itemm['IND_AVALIACAO']) and $itemm['IND_AVALIACAO']=='T') echo 'checked';?>/>
                            <label for="avaliacaoT2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>">Neutra</label>
                        </div>
                    </div>
                    <?php
                endforeach;
            } else {?>
                Nenhum Setor para avaliar individualmente!!
            <?php } ?>
        </div>
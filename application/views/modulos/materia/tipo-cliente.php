        <div class="panel-body">
            <?php if (!empty($lista_tipos)) {
                foreach($lista_tipos as $itemm):
                    ?>
                    <div class="col-xs-12 col-md-12 col-xl-12">
                        <span>&Aacute;rea: <?php
                            $dataTipo = $this->ComumModelo->getTableData('TIPO_MATERIA', array('SEQ_TIPO_MATERIA' => $itemm['SEQ_TIPO_MATERIA']))->row()->DESC_TIPO_MATERIA;
                            echo $dataTipo; ?></span>
                        <div class="form-line ">
                            <label for="comentarioP2_<?php echo $itemm['SEQ_MAT_CLI_TIPO'];?>">Quantidade de Coment&aacute;rios</label>
                            <input class="processa-comentario-i"
                                   name="quantidade<?php echo $itemm['SEQ_MAT_CLI_TIPO'];?>"
                                   type="number"
                                   data-chave="<?php echo $itemm['SEQ_MAT_CLI_TIPO'];?>"
                                   id="comentarioP2_<?php echo $itemm['SEQ_MAT_CLI_TIPO'];?>"
                                   value="<?php if (!empty($itemm['QTD_COMENTARIO'])) echo $itemm['QTD_COMENTARIO'];?>"  />

                        </div>
                    </div>
                    <?php
                endforeach;
            } else {?>
                Nenhuma &Aacute;rea !!
            <?php } ?>
        </div>
        <script type="text/javascript">
            $(function () {
                $('.processa-comentario-i').blur(function () {
                    var chaveVal = $(this).data('chave');
                    var valorVal = $(this).val();
                    $.ajax({
                        mimeType: 'text; charset=utf-8',
                        url: '/monitor/materia/ajaxAlteraTipoCli',
                        type: 'POST',
                        cache: false,
                        data: {
                            chave: chaveVal,
                            valor: valorVal,
                            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                        success: function (data) {
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('msgAjax', errorThrown);
                        },
                        dataType: "html"
                    });
                });
            });
        </script>
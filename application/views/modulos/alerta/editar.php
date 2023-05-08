<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">edit</i> Alterar</h2>
        <small>Alerta</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li>
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li><a href="<?php echo base_url('materia') ?>" class="ajax-link-interno">
                    <i class="material-icons">alarm</i>Alerta</a></li>
            <li class="active">Alterar</li>
        </ol>
    </div>
</div>

<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <div class="row clearfix">
                <div class="col-xs-12 col-md-8 col-xl-8">
                    <h3 class="box-title">Dados do Alerta</h3>
                </div>
            </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php echo form_open(base_url('notificacao/alterar/'.$idNota),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <input type='hidden' id='idNota' name='idNota' value='<?php if (!empty($idNota)) echo $idNota;?>'/>
                    <input type="hidden" name="acao" id="acao"/>
                    <div class="masked-input">
                        <div class="row clearfix">
                            <?php
                            $clientes=array();
                            if($this->session->userData('perfilUsuario')=='ROLE_ADM') {
                                $clientes = $this->ComumModelo->getClienteTodos()->result_array();
                            }  else {
                                    $clientes = $this->ComumModelo->getClientes($this->session->userData('listaCliente'))->result_array();
                            }
                             ?>
                            <?php if (!empty($clientes) and count($clientes)>1) { ?>
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                            <select class="form-control show-tick" name="idcliente" id="idcliente">
                                                <option value="0">Temas de Interesse</option>
                                                <?php if (!empty($clientes)) {
                                                    foreach ($clientes as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_CLIENTE'] ?>" <?php if (!empty($codCliente) and $codCliente==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                                <input type='hidden'id='idcliente' name='idcliente' value='<?php if (!empty($this->session->userdata('idClienteSessao'))) echo $this->session->userdata('idClienteSessao');?>'/>
                            <?php } ?>
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick"
                                                multiple="multiple"
                                                name="area[]" id="area"
                                                data-live-search="true"
                                                title="Selecione o &Aacute;rea"
                                                data-size="5">
                                            <option value="">Selecione - &Aacute;rea</option>
                                            <?php if (!empty($lista_tipo)) {
                                                foreach ($lista_tipo as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_TIPO_MATERIA'] ?>" <?php if (!empty($area) and in_array($item['SEQ_TIPO_MATERIA'],explode(',',$area))) echo 'selected';?>><?php echo $item['DESC_TIPO_MATERIA']; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick"
                                                multiple="multiple"
                                                name="setor[]" id="setor"
                                                data-live-search="true"
                                                title="Selecione o Setor"
                                                data-size="5">
                                            <option value="">Selecione - Setor</option>
                                            <?php if (!empty($lista_setor)) {
                                                foreach ($lista_setor as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_SETOR'] ?>" <?php if (!empty($setor) and in_array($item['SEQ_SETOR'],explode(',',$setor))) echo 'selected';?>><?php echo $item['DESC_SETOR'].'('.$item['SIG_SETOR'].')'; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick"
                                            multiple="multiple" name="radio[]"
                                            id="radio" data-live-search="true"
                                            title="Selecione a R&aacute;dio"
                                            data-size="5">
                                        <option value="">Selecione - RADIO</option>
                                        <?php if (!empty($lista_radio)) {
                                            foreach ($lista_radio as $item): ?>
                                                <option
                                                    value="<?php echo $item['SEQ_RADIO'] ?>" <?php if (!empty($radio) and in_array($item['SEQ_RADIO'],explode(',',$radio))) echo 'selected';?>><?php echo $item['NOME_RADIO']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick"
                                            multiple="multiple" name="tv[]"
                                            id="tv" data-live-search="true"
                                            title="Selecione a Telvis&atilde;o"
                                            data-size="5">
                                        <option value="">Selecione - TV</option>
                                        <?php if (!empty($lista_tv)) {
                                            foreach ($lista_tv as $item): ?>
                                                <option
                                                    value="<?php echo $item['SEQ_TV'] ?>" <?php if (!empty($tv) and in_array($item['SEQ_TV'],explode(',',$tv))) echo 'selected';?>><?php echo $item['NOME_TV']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick"
                                            multiple="multiple" name="internet[]"
                                            id="internet" data-live-search="true"
                                            title="Selecione o Site"
                                            data-size="5">
                                        <option value="">Selecione - Site</option>
                                        <?php if (!empty($lista_internet)) {
                                            foreach ($lista_internet as $item): ?>
                                                <option
                                                    value="<?php echo $item['SEQ_PORTAL'] ?>" <?php if (!empty($net) and in_array($item['SEQ_PORTAL'],explode(',',$net))) echo 'selected';?>><?php echo $item['NOME_PORTAL']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick"
                                            multiple="multiple" name="impresso[]"
                                            id="impresso" data-live-search="true"
                                            title="Selecione o Impresso"
                                            data-size="5">
                                        <option value="">Selecione - IMPRESSO</option>
                                        <?php if (!empty($lista_impresso)) {
                                            foreach ($lista_impresso as $item): ?>
                                                <option
                                                    value="<?php echo $item['SEQ_VEICULO'] ?>" <?php if (!empty($impresso) and in_array($item['SEQ_VEICULO'],explode(',',$impresso))) echo 'selected';?>><?php echo $item['FANTASIA_VEICULO']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line"   >
                                        <select id="release" class="form-control show-tick"
                                                title="Selecione o Release"
                                                multiple="multiple" name="release[]"
                                                data-live-search="true" data-size="5">
                                            <option value="0">Selecione - RELEASE</option>
                                            <?php if (!empty($lista_release)) {
                                                foreach ($lista_release as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_RELEASE'] ?>" <?php if (!empty($release) and in_array($item['SEQ_RELEASE'],explode(',',$release))) echo 'selected';?>><?php echo $item['DESC_RELEASE'].'('.date('d/m/Y',strtotime($item['DATA_ENVIO_RELEASE'])).')'; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" class="datepicker form-control" id='dataic' name='dataic' placeholder="selecione a data inicio..." value='<?php if (!empty($dataic)) echo date('d/m/Y',strtotime($dataic));?>'>
                                        <label id="label-for" class="form-label">Data In&iacute;cio</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" class="datepicker form-control" id='datafc' name='datafc' placeholder="selecione a data fim..." value='<?php if (!empty($datafc)) echo date('d/m/Y',strtotime($datafc));?>'>
                                        <label id="label-for" class="form-label">Data Fim</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="grupo" id="grupo" data-live-search="true" data-size="6">
                                            <option value="">Selecione - Grupo de Monitoramento</option>
                                            <?php if (!empty($lista_grupo)) {
                                                foreach ($lista_grupo as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_GRUPO_VEICULO'] ?>" <?php if (!empty($grupo) and $grupo==$item['SEQ_GRUPO_VEICULO']) echo 'selected';?>><?php echo $item['DESC_GRUPO_VEICULO']; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select id="tipoMat" class="form-control show-tick"  name="tipoMat" title="Selecione o Tipo da Materia">
                                            <option value="">Selecione o Tipo de Mat&eacute;ria</option>
                                            <option value="S" <?php if(!empty($tipoMat) and $tipoMat=='S') echo 'selected'; ?>>Internet</option>
                                            <option value="I" <?php if(!empty($tipoMat) and $tipoMat=='I') echo 'selected'; ?>>Impresso</option>
                                            <option value="R" <?php if(!empty($tipoMat) and $tipoMat=='R') echo 'selected'; ?>>R&aacute;dio</option>
                                            <option value="T" <?php if(!empty($tipoMat) and $tipoMat=='T') echo 'selected'; ?>>Televis&atilde;o</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-6 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="categoria" id="categoria">
                                            <option value="0" <?php if (!empty($categoria) and $categoria==0) echo 'selected';?>>Seleciona a Categoria</option>
                                            <?php if (!empty($lista_categoria)) {
                                                foreach ($lista_categoria as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_CATEGORIA'] ?>" <?php if (!empty($categoria) and $categoria==$item['SEQ_CATEGORIA']) echo 'selected';?>><?php echo $item['DESC_CATEGORIA']; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php if ($codCliente=='0') { ?>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="assunto" id="assunto" data-live-search="true" data-size="6">
                                                <option value="0">Selecione - Assunto Geral</option>
                                                <?php if (!empty($lista_assunto)) {
                                                    foreach ($lista_assunto as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_ASSUNTO_GERAL'] ?>" <?php if (!empty($assunto) and $assunto==$item['SEQ_ASSUNTO_GERAL']) echo 'selected';?>><?php echo $item['DESC_ASSUNTO_GERAL']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select id="avaliacao" class="form-control show-tick"
                                                name="avaliacao" title="Selecione a Avalia&ccedil;&atilde;o">
                                            <option
                                                value="">Selecionar Avalia&ccedil;&atilde;o</option>
                                            <option
                                                <?php if(!empty($avaliacao) and $avaliacao=='P') echo 'selected'; ?>
                                                value="P">Positivo</option>
                                            <option
                                                <?php if(!empty($avaliacao) and $avaliacao=='N') echo 'selected'; ?>
                                                value="N">Negativo</option>
                                            <option
                                                <?php if(!empty($avaliacao) and $avaliacao=='T') echo 'selected'; ?>
                                                value="T">Neutro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" class="form-control" name="tags" 
                                        data-role="tagsinput" value="">
                                        <label id="label-for" class="form-label">Tags</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3 col-md-3 col-xl-3">
                                <div class="form-line">
                                    <div class="demo-checkbox">
                                        <input id="basic_checkbox" type="checkbox" name="modelo"
                                            <?php if(!empty($modelo) and $modelo=='S') echo 'checked'; ?>
                                               value="S">&nbsp;
                                        <label for="basic_checkbox">Definir como modelo?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-line">
                                    <div class="demo-checkbox">
                                        <input id="avulso" type="checkbox" name="avulso" value="S" <?php if(!empty($avulso) and $avulso=='S')  echo 'checked'; ?>/>&nbsp;
                                        <label for="avulso">Alerta Avulso?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <a href="<?php echo base_url('notificacao') ?>" class="btn bg-lime btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                    <i class="material-icons">cancel</i>
                                </a>&nbsp;&nbsp;&nbsp;

                                <button id="btn-enviar-form" type="submit" onclick="$('#acao').val('S');" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Salvar">
                                    <i class="material-icons">save</i>
                                </button>
                            </div>
                        </div>
                    </div>
                  </form>
               </div>
    </div>
</div><!-- /.row -->
<script type="text/javascript">
        $(function () {
            $('#formPadrao').validate({
                rules: {
                    'idcliente': {required: true},
                },
                messages:{
                    'idcliente': {
                        required: 'Cliente &eacute; Obrigat&oacute;rio',
                    },
                },
                highlight: function (input) {
                    $(input).parents('.form-line').addClass('error');
                },
                unhighlight: function (input) {
                    $(input).parents('.form-line').removeClass('error');
                },
                errorPlacement: function (error, element) {
                    $(element).parents('.form-group').append(error);
                },
            });

        var toDate = function (dateStr) {
            var parts = dateStr.split("/");
            return new Date(parts[1]+'/'+parts[0]+'/'+parts[2]);
        }


        $('#dataic').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        }).on('change', function(e, date)
        {
            $('#datafc').bootstrapMaterialDatePicker('setMinDate', date);
        });
        $('#datafc').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar',
            minDate: toDate($("#dataic").val())
        });

        $('#idcliente').on('change',function(){
            $('#acao').val('I');
            $('#btn-enviar-form').prop("disabled",true);
            document.getElementById("formPadrao").submit();
        });
        $('#datafc').bootstrapMaterialDatePicker('setMinDate', '<?php echo date('D M d Y H:i:s eO',strtotime($dataic));?>');

        $('#setor').on('change',function(){
            var item = $(this).val();
            var idcliente = $('#idcliente').val();
            if (item!=undefined && item.length>0) {
                $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/monitor/materia/ajaxReleaseSetor',
                    type: 'POST',
                    cache: false,
                    data: {
                        idCliente: idcliente,
                        idSetor: item,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function (data) {
                        $('#release').html(data);
                        $('#release').selectpicker('refresh');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('msgAjax', errorThrown);
                    },
                    dataType: "html"
                });
            }
        });

    });
</script>
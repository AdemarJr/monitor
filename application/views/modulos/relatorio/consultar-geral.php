<div class="block-header inline" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">fiber_new</i> Contagem por Ve&iacute;culo</h2>
        <small>Consulta de Ve&iacute;culo.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Contagem por Ve&iacute;culo</li>
        </ol>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">Filtro
            </div>
            <div class="body">
                <div class="row clearfix nopadding">
                    <?php echo form_open(base_url('relatorio/processaGeral'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>

                    <?php
                    $clientes=array();
                    if($this->session->userData('perfilUsuario')=='ROLE_ADM') {
                        $clientes = $this->ComumModelo->getClienteTodos()->result_array();
                    }  else {
                        
                        $clientes = $this->ComumModelo->getClientes($this->session->userData('listaCliente'))->result_array();
                    }
                    ?>
                    <?php if (!empty($clientes) and count($clientes)>=1) { ?>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick" name="idCliente" id="idCliente" data-live-search="true">
                                        <?php if (!empty($clientes)) {
                                            foreach ($clientes as $item): ?>
                                                <option
                                                    value="<?php echo $item['SEQ_CLIENTE'] ?>"
                                                    <?php if (!empty($idCliente) and $idCliente==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    <div class="col-xs-12 col-md-3 col-xl-3">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" class="datepicker form-control" id='datai' name='datai' placeholder="selecione a data inicio..." value='<?php if (!empty($datai)) echo $datai;?>'>
                                <label id="label-for" class="form-label">Data In&iacute;cio</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3 col-xl-3">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" class="datepicker form-control" id='dataf' name='dataf' placeholder="selecione a data fim..." value='<?php if (!empty($dataf)) echo $dataf;?>'>
                                <label id="label-for" class="form-label">Data Fim</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3 col-xl-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select id="setor" class="form-control show-tick"
                                        name="setor[]" title="Selecione o Secretaria"
                                        multiple="multiple"
                                        data-live-search="true">
                                    <option value="">Todos as Secretarias</option>
                                    <?php if (!empty($lista_setor)) {
                                        foreach ($lista_setor as $item): ?>
                                            <option
                                                <?php if(!empty($setor) and $setor==$item['SEQ_SETOR']) echo 'selected'; ?>
                                                value="<?php echo $item['SEQ_SETOR'] ?>"><?php echo $item['SIG_SETOR'].' - '.$item['DESC_SETOR']; ?></option>
                                        <?php endforeach;
                                    } ?>
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
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-line">
                                <div class="demo-checkbox">
                                    <input id="excluirSetor" type="checkbox" name="excluirSetor"
                                           value="S" checked />&nbsp;
                                    <label for="excluirSetor">Excluir Setores Selecionados?</label>
                                </div>
                            </div>
                        </div>
                    <div class="col-xs-12 col-md-3 col-xl-3">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <select class="form-control show-tick" name="grupo" id="grupo" data-live-search="true" data-size="6">
                                    <option value="0">Todos os Grupos</option>
                                    <?php if (!empty($lista_grupo)) {
                                        foreach ($lista_grupo as $item): ?>
                                            <option
                                                value="<?php echo $item['SEQ_GRUPO_VEICULO'] ?>"
                                                <?php if (!empty($grupo) and $grupo==$item['SEQ_GRUPO_VEICULO']) echo 'selected';?>><?php echo $item['DESC_GRUPO_VEICULO']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-xs-12 col-md-12 col-xl-12">
                            <p><strong>Dados da Seguran&ccedil;a</strong></p>
                    </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='tipoCrime' name='tipoCrime' value="<?php if (!empty($tipoCrime)) echo $tipoCrime;?>"/>
                                        <label id="label-for" class="form-label">Tipo do Crime</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='bairroCrime' name='bairroCrime' value="<?php if (!empty($bairroCrime)) echo $bairroCrime;?>"/>
                                        <label id="label-for" class="form-label">Bairro do Crime</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='localCrime' name='localCrime' value="<?php if (!empty($localCrime)) echo $localCrime;?>"/>
                                        <label id="label-for" class="form-label">Local do Crime</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select id="indPreso" class="form-control show-tick"  name="indPreso" data-live-search="true">
                                            <option value="">Ocorreu Pris&atilde;o?</option>
                                            <option value="S" <?php if(!empty($indPreso) and $indPreso=='S') echo 'selected'; ?>>Sim</option>
                                            <option value="N" <?php if(!empty($indPreso) and $indPreso=='N') echo 'selected'; ?>>N&atilde;o</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-line">
                                <div class="demo-checkbox">
                                    <input id="basic_checkbox" type="checkbox" name="istempo"
                                           checked value="S">&nbsp;
                                    <label for="basic_checkbox">Exibir Tempo para R&aacute;dio/TV</label>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type='hidden' id='idCliente' name='idCliente' value='<?php if (!empty($this->session->userdata('idClienteSessao'))) echo $this->session->userdata('idClienteSessao');?>'/>

                    <?php } ?>

                    <input type='hidden' id='acao' name='acao' value=""/>
                    <div class="col-xs-12 col-md-3 col-xl-3 hidden-print">
                        <button
                            id="btn-enviar-form"
                            type="submit"
                                onclick="$('#acao').val('pdf');"
                                class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"
                                data-toggle="tooltip" data-placement="top"
                                title="Gerar Relat&oacute;rio">
                            <i class="material-icons">filter_list</i>
                        </button>
                        <button
                            id="btn-enviar-form2"
                            type="submit" onclick="$('#acao').val('xls');" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Gerar Excel">
                            <i class="material-icons">file_download</i>
                        </button>
                        <button
                            id="btn-enviar-form"
                            type="submit"
                                onclick="$('#acao').val('graficos');"
                                class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"
                                data-toggle="tooltip" data-placement="top"
                                title="Gerar Gráficos">
                            <i class="material-icons">leaderboard</i>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Body Copy -->
<script type="text/javascript">
    $(function () {
        $('#dataf').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#datai').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        }).on('change', function(e, date)
        {
            $('#dataf').bootstrapMaterialDatePicker('setMinDate', date);
        });

        $('#idCliente').on('change',function(){
            $('#acao').val('I');
            $('#btn-enviar-form').prop("disabled",true);
            $('#btn-enviar-form2').prop("disabled",true);
            document.getElementById("formPadrao").submit();
        });
    });
</script>
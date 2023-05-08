<div class="block-header inline" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">fiber_new</i> Contagem por Release</h2>
        <small>Consulta de Release.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Contagem por Release</li>
        </ol>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">Filtro
            </div>
            <div class="body">
                <?php echo form_open(base_url('relatorio/processaRelease'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="row clearfix nopadding">
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='datai' name='datai' placeholder="selecione a data inicio..." value='<?php if (!empty($datai)) echo $datai;?>'>
                                    <label id="label-for" class="form-label">Data In&iacute;cio da Publica&ccedil;&atilde;o</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='dataf' name='dataf' placeholder="selecione a data fim..." value='<?php if (!empty($dataf)) echo $dataf;?>'>
                                    <label id="label-for" class="form-label">Data Fim da Publica&ccedil;&atilde;o</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='datae' name='datae' placeholder="selecione a data do envio..." value='<?php if (!empty($datae)) echo $datae;?>'>
                                    <label id="label-for" class="form-label">Data In&iacute;cio do Envio</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='dataef' name='dataef' placeholder="selecione a data do envio..." value='<?php if (!empty($dataef)) echo $dataef;?>'>
                                    <label id="label-for" class="form-label">Data Fim do Envio</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix nopadding">
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <select class="form-control show-tick" name="grupo" id="grupo" data-live-search="true" data-size="6">
                                        <option value="0">Todos os Grupos</option>
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
                        <?php
                        $clientes=array();
                        if($this->session->userData('perfilUsuario')=='ROLE_ADM') {
                            $clientes = $this->ComumModelo->getClienteTodos()->result_array();
                        }  else {
                            $clientes = $this->ComumModelo->getClientes($this->session->userData('listaCliente'))->result_array();
                        }
                        ?>
                        <?php if (!empty($clientes) and count($clientes)>1) { ?>
                        <div class="col-xs-12 col-md-3 col-xl-3">
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

                        <?php } else { ?>
                            <input type='hidden' id='idCliente' name='idCliente' value='<?php if (!empty($this->session->userdata('idClienteSessao'))) echo $this->session->userdata('idClienteSessao');?>'/>

                        <?php } ?>
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select id="tipo" class="form-control show-tick"  name="tipo" title="Selecione a &Aacute;rea" data-live-search="true">
                                        <option value="">Todos as &Aacute;reas</option>
                                        <?php if (!empty($lista_tipo)) {
                                            foreach ($lista_tipo as $item): ?>
                                                <option
                                                    <?php if(!empty($tipo) and $tipo==$item['SEQ_TIPO_MATERIA']) echo 'selected'; ?>
                                                    value="<?php echo $item['SEQ_TIPO_MATERIA'] ?>"><?php echo $item['DESC_TIPO_MATERIA']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select id="tipo" class="form-control show-tick"  name="veiculo[]" multiple=""  title="Selecione o veículo" data-live-search="true">
                                        <option value="I" selected="">IMPRESSO</option>
                                        <option value="R">RÁDIO</option>
                                        <option value="T">TELEVISÃO</option>
                                        <option value="S">INTERNET</option>
                                    </select>
                                </div>
                            </div>
                        </div>    
                        <input type='hidden' id='acao' name='acao' value=""/>
                        <div class="col-xs-12 col-md-3 col-xl-3 hidden-print">
                            <button type="submit" onclick="$('#acao').val('pdf');" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float btn-submit" data-toggle="tooltip" data-placement="top" title="Gerar Relat&oacute;rio">
                                <i class="material-icons">filter_list</i>
                            </button>
                            <button  type="submit" onclick="$('#acao').val('xls');" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float btn-submit" data-toggle="tooltip" data-placement="top" title="Gerar Excel">
                                <i class="material-icons">file_download</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- #END# Body Copy -->
<script type="text/javascript">
    $(function () {
        $('#formPadrao').validate({
            rules: {
                'datae': {required: true},
                'dataef': {required: true},
                'dataf': {required: true},
                'datai': {required: true}
            },
            messages:{
                'datae': {
                    required: 'Data In&iacute;cio do Envio � Obrigat�rio'
                },
                'dataef': {
                    required: 'Data Fim do Envio � Obrigat�rio'
                },
                'datai': {
                    required: 'Data In&iacute;cio da Publica&ccedil;&atilde;o � Obrigat�rio'
                },
                'dataf': {
                    required: 'Data Fim da Publica&ccedil;&atilde;o � Obrigat�rio'
                }
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            }
        });

        $('#dataef').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#datae').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        }).on('change', function(e, date)
        {
            $('#dataef').bootstrapMaterialDatePicker('setMinDate', date);
        });
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
            $('.btn-submit').prop("disabled",true);
            document.getElementById("formPadrao").submit();
        });
    });
</script>
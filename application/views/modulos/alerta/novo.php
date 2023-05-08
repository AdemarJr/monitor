<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">add</i> Cadastro</h2>
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
            <li class="active">Cadastro</li>
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
                    <?php echo form_open_multipart(base_url('notificacao/salvar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
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
                                                <option value="">Selecione - Cliente</option>
                                                <?php if (!empty($clientes)) {
                                                    foreach ($clientes as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_CLIENTE'] ?>" <?php if (!empty($this->session->userdata('idClienteSessao')) and $this->session->userdata('idClienteSessao')==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
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
                                        <select class="form-control show-tick" name="setor" id="setor" data-live-search="true" data-size="5">
                                            <option value="">Selecione - Setor</option>
                                            <?php if (!empty($lista_setor)) {
                                                foreach ($lista_setor as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_SETOR'] ?>" <?php if (!empty($setor) and $setor==$item['SEQ_SETOR']) echo 'selected';?>><?php echo $item['DESC_SETOR'].'('.$item['SIG_SETOR'].')'; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="setor" id="setor" data-live-search="true" data-size="5">
                                            <option value="">Selecione - Setor</option>
                                            <?php if (!empty($lista_setor)) {
                                                foreach ($lista_setor as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_SETOR'] ?>" <?php if (!empty($setor) and $setor==$item['SEQ_SETOR']) echo 'selected';?>><?php echo $item['DESC_SETOR'].'('.$item['SIG_SETOR'].')'; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" multiple name="radio" id="radio" data-live-search="true" data-size="5">
                                            <option value="">Selecione - RADIO</option>
                                            <?php if (!empty($lista_radio)) {
                                                foreach ($lista_radio as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_RADIO'] ?>" <?php if (!empty($radio) and $radio==$item['SEQ_RADIO']) echo 'selected';?>><?php echo $item['NOME_RADIO']; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="tv" id="tv" data-live-search="true" data-size="5">
                                            <option value="">Selecione - TV</option>
                                            <?php if (!empty($lista_tv)) {
                                                foreach ($lista_tv as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_TV'] ?>" <?php if (!empty($tv) and $tv==$item['SEQ_TV']) echo 'selected';?>><?php echo $item['NOME_TV']; ?></option>
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
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <a href="<?php echo base_url('notificacao') ?>" class="btn bg-lime btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                    <i class="material-icons">cancel</i>
                                </a>&nbsp;&nbsp;&nbsp;

                                <button id="btn-enviar-form" type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Salvar">
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
                'tipoMat': {required: true},
                'idcliente': {required: true},
            },
            messages:{
                'tipoMat': {
                    required: 'Tipo da Matéria é Obrigatório',
                },
                'idcliente': {
                    required: 'Cliente é Obrigatório',
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

    });
</script>
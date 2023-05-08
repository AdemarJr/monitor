<div class="block-header inline" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">view_module</i> Contagem por Secretaria/Setor</h2>
        <small>Consulta de Secretaria/Setor.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Contagem por Secretaria/Setor</li>
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
                    <?php echo form_open(base_url('relatorio/processaSetor'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
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
                    <?php
                    $clientes=array();
                    if($this->session->userData('perfilUsuario')=='ROLE_ADM') {
                        $clientes = $this->ComumModelo->getClienteTodos()->result_array();
                    }  else {
                        $clientes = $this->ComumModelo->getClientes($this->session->userData('listaCliente'))->result_array();
                    }
                    ?>
                    <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" class="form-control" name="tags" 
                                        data-role="tagsinput" value="">
                                        <label id="label-for" class="form-label">Tags</label>
                                    </div>
                                </div>
                            </div>
                    <?php if (!empty($clientes) and count($clientes)>1) { ?>
                    <div class="col-xs-12 col-md-3 col-xl-3">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control show-tick" name="idCliente" id="idCliente" data-live-search="true">
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
                    <div class="col-xs-12 col-md-3 col-xl-3">
                        <div class="form-line">
                            <div class="demo-checkbox">
                                <input id="basic_checkbox" type="checkbox" name="isSetorMonitor" <?php if (!empty($isSetorMonitor)) echo 'checked';?>
                                       value="S">&nbsp;
                                <label for="basic_checkbox">Exibir Somente Setores Estra&eacute;gico</label>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                        <input type='hidden' id='idCliente' name='idCliente' value='<?php if (!empty($this->session->userdata('idClienteSessao'))) echo $this->session->userdata('idClienteSessao');?>'/>

                    <?php } ?>
                    <input type='hidden' id='acao' name='acao' value=""/>
                    <div class="col-xs-12 col-md-3 col-xl-3 hidden-print">
                        <button type="submit" on onclick="$('#acao').val('pdf');" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Gerar Relat&oacute;rio">
                            <i class="material-icons">filter_list</i>
                        </button>
                        <button type="submit" onclick="$('#acao').val('xls');" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Gerar Excel">
                            <i class="material-icons">file_download</i>
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
    });
</script>
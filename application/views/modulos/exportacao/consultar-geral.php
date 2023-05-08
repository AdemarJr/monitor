<div class="block-header inline" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">attachment</i> Exporta&ccedil;&atilde;o de TV/R&aacute;dio</h2>
        <small>Exporta&ccedil;&atilde;o de Mídia</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Exporta&ccedil;&atilde;o</li>
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
                    <?php echo form_open(base_url('exportacao/executar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>

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
                            <div class="form-line focused">
                                <input type="text" class="datepicker form-control" id='datai' name='datai' placeholder="selecione a data inicio..." value='<?php if (!empty($datai)) echo $datai;?>'>
                                <label id="label-for" class="form-label">Data In&iacute;cio</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3 col-xl-3">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" class="datepicker form-control" id='dataf' name='dataf'
                                    placeholder="selecione a data fim..." value='<?php if (!empty($dataf)) echo $dataf;?>'>
                                <label id="label-for" class="form-label">Data Fim</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-xl-6">
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
                                <select class="form-control show-tick" name="tipo[]" 
                                title="Selecione o Tipo"
                                multiple="multiple"
                                id="tipo" data-live-search="false">
                                    <option value="T" selected>Televisão</option>
                                    <option value="R" selected>Rádio</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    

                    <input type='hidden' id='acao' name='acao' value=""/>
                    
                    <div class="col-xs-12 col-md-12 col-xl-12 hidden-print">
                        <button
                            id="btn-enviar-form"
                            type="submit"
                                onclick="$('#acao').val('pdf');"
                                class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"
                                data-toggle="tooltip" data-placement="top"
                                title="Processar e Aguardar para realizar o download">
                            <i class="material-icons">done</i>
                        </button>
                        <span class="badge bg-red" style="margin-left: 10px !important;">Atenção:</span> Processo demorado, multíplos processamentos pode indisponibilizar o sistema.
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">Minhas Solicitações
            </div>
            <div class="body">
                <div class="row clearfix nopadding">
                    <table  id="tabela-sol" class="table table-bordered table-striped table-hover js-basic-example-demand dataTable">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome do Arquivo</th>
                                <th>Tamanho do Arquivo</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tfoot class="hidden-sm hidden-xs">
                            <tr>
                                <th>Código</th>
                                <th>Nome do Arquivo</th>
                                <th>Tamanho do Arquivo</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </tfoot>
                    </table>
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

        var table  = $('#tabela-sol').DataTable({
            "responsive": true,
            "processing":true,
            "serverSide":true,
            "info": false,
            "paging":   false,
            "searching":   false,
            "ordering": false,
            "ajax":{
                url:"<?php echo base_url() . 'exportacao/consultar'; ?>",
                type:"POST",
                data:{'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' },
                complete: function(){
                },
            },
            "columnDefs":[
                {
                    "targets":[5],
                    "orderable":false,
                },
            ],

            language: {
                "url": "assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
            }
        });

        const processoJob = setInterval(() => {
            table.draw();
        }, 20000);

    });
</script>
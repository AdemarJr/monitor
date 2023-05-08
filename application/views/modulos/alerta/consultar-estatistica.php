<div class="block-header inline" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">timeline</i> Contagem por Mat&eacute;rias</h2>
        <small>Gerar Alerta de Estat&iacute;stica</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Alerta de Estat&iacute;stica</li>
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
                     <?php echo form_open(base_url('notificacao/estatistica'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
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
                                        <option value="0">Selecione - Cliente</option>
                                        <?php if (!empty($clientes)) {
                                            foreach ($clientes as $item): ?>
                                                <option
                                                    value="<?php echo $item['SEQ_CLIENTE'] ?>" <?php if (!empty($idcliente) and $idcliente==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick"
                                            name="setor" id="setor"
                                            data-live-search="true" data-size="5">
                                        <option value="0">Selecione - Setor</option>
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
                    <div class="col-xs-12 col-md-4 col-xl-4">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control show-tick"
                                        name="area" id="area"
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

                        <div class="col-xs-12 col-md-2 col-xl-2">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='datair' name='datair' placeholder="selecione a data inicio..." value='<?php if (!empty($datair)) echo $datair;?>'>
                                    <label id="label-for" class="form-label">Data In&iacute;cio</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2 col-xl-2">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='datafr' name='datafr' placeholder="selecione a data fim..." value='<?php if (!empty($datafr)) echo $datafr;?>'>
                                    <label id="label-for" class="form-label">Data Fim</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2 col-xl-2" style="margin-top: 1%">
                            <div class="form-line">
                                <div class="demo-checkbox">
                                    <input id="basic_checkbox" type="checkbox" name="stexto" value="S">
                                        <label for="basic_checkbox">INCLUIR NEGATIVAS</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2 col-xl-2 hidden-print">
                            <button type="button" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float processa-alerta" data-toggle="tooltip" data-placement="top" title="Gerar Alerta">
                                <i class="material-icons">filter_list</i>
                            </button>
                            <button TYPE="button" style="display: none" id="copiaAlerta" data-toggle="tooltip" data-placement="top" title="Copiar para &Aacute;rea de tranfer&ecirc;ncia" class='btn bg-red btn-circle-lg waves-effect waves-circle waves-float copiar hidden-sm hidden-md'
                                href="javascript:void(0);">
                                <i class="material-icons">content_copy</i>
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <textarea id="alerta" class="copyfrom" style="width: 0px;height: 0px;resize: none;" tabindex='-1' aria-hidden='true'>joao</textarea>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">Relatório por Setor</div>
            <div class="body">
                <?php if (!empty($clientes) and count($clientes)>1) { ?>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick" name="idcliente" id="idcliente">
                                        <option value="0">Selecione - Cliente</option>
                                        <?php if (!empty($clientes)) {
                                            foreach ($clientes as $item): ?>
                                                <option
                                                    value="<?php echo $item['SEQ_CLIENTE'] ?>" <?php if (!empty($idcliente) and $idcliente==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <div class="col-xs-12 col-md-2 col-xl-2">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='datair1' name='datair' placeholder="selecione a data inicio..." value='<?php if (!empty($datair)) echo $datair;?>'>
                                    <label id="label-for" class="form-label">Data In&iacute;cio</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2 col-xl-2">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='datafr1' name='datafr' placeholder="selecione a data fim..." value='<?php if (!empty($datafr)) echo $datafr;?>'>
                                    <label id="label-for" class="form-label">Data Fim</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2 col-xl-2 hidden-print">
                            <button type="button" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float processa-alerta-rel" data-toggle="tooltip" data-placement="top" title="Gerar Alerta">
                                <i class="material-icons">filter_list</i>
                            </button>
                            <button TYPE="button" style="display: none" id="copiaAlerta2" data-toggle="tooltip" data-placement="top" title="Copiar para &Aacute;rea de tranfer&ecirc;ncia" class='btn bg-red btn-circle-lg waves-effect waves-circle waves-float copiar2 hidden-sm hidden-md'
                                href="javascript:void(0);">
                                <i class="material-icons">content_copy</i>
                            </button>
                        </div>
                <br><br>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">Relatório Destaque</div>
            <div class="body">
                <?php if (!empty($clientes) and count($clientes)>1) { ?>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick" name="idcliente" id="idclienteDes">
                                        <option value="0">Selecione - Cliente</option>
                                        <?php if (!empty($clientes)) {
                                            foreach ($clientes as $item): ?>
                                                <option
                                                    value="<?php echo $item['SEQ_CLIENTE'] ?>" <?php if (!empty($idcliente) and $idcliente==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                        <div class="col-xs-12 col-md-2 col-xl-2 hidden-print">
                            <button type="button" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float processa-alerta-rel-destak" data-toggle="tooltip" data-placement="top" title="Gerar Alerta">
                                <i class="material-icons">filter_list</i>
                            </button>
                            <button TYPE="button" style="display: none" id="copiaAlerta3" data-toggle="tooltip" data-placement="top" title="Copiar para &Aacute;rea de tranfer&ecirc;ncia" class='btn bg-red btn-circle-lg waves-effect waves-circle waves-float copiar3 hidden-sm hidden-md'
                                href="javascript:void(0);">
                                <i class="material-icons">content_copy</i>
                            </button>
                        </div>
                <br><br>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">Relatório de Mídias Negativas</div>
            <div class="body">
                <?php if (!empty($clientes) and count($clientes)>1) { ?>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick" name="idcliente" id="idclienteNeg">
                                        <option value="0">Selecione - Cliente</option>
                                        <?php if (!empty($clientes)) {
                                            foreach ($clientes as $item): ?>
                                                <option
                                                    value="<?php echo $item['SEQ_CLIENTE'] ?>" <?php if (!empty($idcliente) and $idcliente==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4 col-xl-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id='link' name='link' placeholder="Digite o link">
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                        <div class="col-xs-12 col-md-2 col-xl-2 hidden-print">
                            <button type="button" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float processa-alerta-rel-neg" data-toggle="tooltip" data-placement="top" title="Gerar Alerta">
                                <i class="material-icons">filter_list</i>
                            </button>
                            <button TYPE="button" style="display: none" id="copiaAlerta4" data-toggle="tooltip" data-placement="top" title="Copiar para &Aacute;rea de tranfer&ecirc;ncia" class='btn bg-red btn-circle-lg waves-effect waves-circle waves-float copiar4 hidden-sm hidden-md'
                                href="javascript:void(0);">
                                <i class="material-icons">content_copy</i>
                            </button>
                        </div>
                <br><br>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">Redes Sociais (PDF)</div>
            <div class="body">
                <div class="col-xs-12 col-md-4 col-xl-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id='link2' name='link' placeholder="Digite o link">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2 col-xl-2 hidden-print">
                            <button type="button" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float gera-pdf" data-toggle="tooltip" data-placement="top" title="Gerar PDF">
                                <i class="material-icons">filter_list</i>
                            </button>
                        </div>
                <br><br>
            </div>
        </div>
    </div>
</div>
<!-- #END# Body Copy -->
<script type="text/javascript">
    $(function () {
        $('#datafr').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#datafr1').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#datair1').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        }).on('change', function(e, date)
        {
            $('#dataf1').bootstrapMaterialDatePicker('setMinDate', date);
        });
        $('#datair').bootstrapMaterialDatePicker({
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
        
        $('.gera-pdf').click(function(event) {
            var string = $("#link2").val();
            if (string == '') {
               showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel gerar o PDF', 'bottom', 'center', 'animated fadeInUp', ''); 
               return;
            }
            var retorno = string.split("i?");
            
            var URL =   'https://porto.am/monitor/sistema/clipping/clipping_pdf/'+retorno[1];
            window.open(URL, '_blank');
        });
        $('.copiar4').click(function(event) {
            //decodeURIComponent
            $("#alerta").text(decodeURIComponent($("#alerta").text().replace(/\+/g, ' ')));
            var copyTextarea = document.querySelector('textarea.copyfrom');
            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                if(successful) {
                    showNotification('alert-success', 'Alerta Copiado!', 'bottom', 'center', 'animated fadeInUp', '');
                    $('#copiaAlerta4').hide();
                }
            } catch (err) {
                showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
            }
        });
        
        $('.copiar').click(function(event) {
            //decodeURIComponent
            $("#alerta").text($("#alerta").text().replace(/\+/g, ' '));
            var copyTextarea = document.querySelector('textarea.copyfrom');
            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                if(successful) {
                    showNotification('alert-success', 'Alerta Copiado!', 'bottom', 'center', 'animated fadeInUp', '');
                    $('#copiaAlerta').hide();
                }
            } catch (err) {
                showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
            }
        });
        
        $('.copiar2').click(function(event) {
            //decodeURIComponent
            $("#alerta").text($("#alerta").text().replace(/\+/g, ' '));
            var copyTextarea = document.querySelector('textarea.copyfrom');
            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                if(successful) {
                    showNotification('alert-success', 'Alerta Copiado!', 'bottom', 'center', 'animated fadeInUp', '');
                    $('#copiaAlerta').hide();
                }
                 setTimeout(function () {
                    document.location.reload(true);
                }, 1000);
            } catch (err) {
                showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
            }
        });
        
        $('.copiar3').click(function(event) {
            //decodeURIComponent
            $("#alerta").text($("#alerta").text().replace(/\+/g, ' '));
            var copyTextarea = document.querySelector('textarea.copyfrom');
            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                if(successful) {
                    showNotification('alert-success', 'Alerta Copiado!', 'bottom', 'center', 'animated fadeInUp', '');
                    $('#copiaAlerta3').hide();
                }
//                 setTimeout(function () {
//                    document.location.reload(true);
//                }, 1000);
            } catch (err) {
                showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
            }
        });
        
        $('.processa-alerta-rel-neg').on('click',function(){
            $("#alerta").text('');
              $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/monitor/notificacao/ajaxAlertaEstatisticaNegativas',
                    type: 'POST',
                    cache: false,
                    data: {
                        idcliente: $('#idclienteNeg').val(),
                        link: $('#link').val(),
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function (data) {

                        if (data=='vazio'){
                            showNotification('alert-danger', 'N&atilde;o existe dados para gerar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                        }else {
                            $("#alerta").text(data);
                            $('#copiaAlerta4').show();
                            showNotification('alert-success', 'Alerta Gerado Com sucesso - Clicar no Botao Copiar!', 'bottom', 'center', 'animated fadeInUp', '');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('msgAjax', errorThrown);
                    },
                    dataType: "html"
                });
        });
        
        $('.processa-alerta-rel-destak').on('click',function(){
            $("#alerta").text('');
              $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/monitor/notificacao/ajaxAlertaEstatisticaDestaque',
                    type: 'POST',
                    cache: false,
                    data: {
                        idcliente: $('#idclienteDes').val(),
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function (data) {

                        if (data=='vazio'){
                            showNotification('alert-danger', 'N&atilde;o existe dados para gerar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                        }else {
                            $("#alerta").text(data);
                            $('#copiaAlerta3').show();
                            showNotification('alert-success', 'Alerta Gerado Com sucesso - Clicar no Botao Copiar!', 'bottom', 'center', 'animated fadeInUp', '');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('msgAjax', errorThrown);
                    },
                    dataType: "html"
                });
        });
        
        $('.processa-alerta-rel').on('click',function(){
            $("#alerta").text('');
              $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/monitor/notificacao/ajaxAlertaEstatisticaRela',
                    type: 'POST',
                    cache: false,
                    data: {
                        idcliente: $('#idcliente').val(),
                        setor: $('#setor').val(),
                        area: $('#area').val(),
                        datair: $('#datair1').val(),
                        datafr: $('#datafr1').val(),
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function (data) {

                        if (data=='vazio'){
                            showNotification('alert-danger', 'N&atilde;o existe dados para gerar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                        }else {
                            $("#alerta").text(data);
                            $('#copiaAlerta2').show();
                            showNotification('alert-success', 'Alerta Gerado Com sucesso - Clicar no Botao Copiar!', 'bottom', 'center', 'animated fadeInUp', '');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('msgAjax', errorThrown);
                    },
                    dataType: "html"
                });
        });

        $('.processa-alerta').on('click',function(){


              $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/monitor/notificacao/ajaxAlertaEstatistica',
                    type: 'POST',
                    cache: false,
                    data: {
                        idcliente: $('#idcliente').val(),
                        setor: $('#setor').val(),
                        area: $('#area').val(),
                        datair: $('#datair').val(),
                        datafr: $('#datafr').val(),
                        negativas: document.querySelector('#basic_checkbox').checked,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function (data) {

                        if (data=='vazio'){
                            showNotification('alert-danger', 'N&atilde;o existe dados para gerar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                        }else {
                            $("#alerta").text(data);
                            $('#copiaAlerta').show();
                            showNotification('alert-success', 'Alerta Gerado Com sucesso - Clicar no Botao Copiar!', 'bottom', 'center', 'animated fadeInUp', '');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('msgAjax', errorThrown);
                    },
                    dataType: "html"
                });
        });
        $('#idcliente').on('change',function(){
            $('#btn-enviar-form').prop("disabled",true);
            document.getElementById("formPadrao").submit();
        });



    });
</script>
<?php
$tipoMat = '';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
if (!isset($_SESSION['FILTROS']['tipoClipador'])) {
    ?>
    <style>
        .agr_C {
            display: none;
        }
    </style>
<?php } ?>
<?php
if (!isset($_SESSION['FILTROS']['tipoMat'])) {
    ?>
    <style>
        .agr_v {
            display: none;
        }
    </style>
<?php } ?>
<style>
    #tabela-materia_wrapper {
        margin-top: 2%;
    }
    .dataTables_filter {
        display: none;
    }
</style>
<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">attach_file</i> Matéria</h2>
        <small>Cadastro e Alteração de Matéria.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Matéria</li>
        </ol>
    </div>
</div>
<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Lista de Matéria</h2>
        </div><!-- /.box-header -->
        <?php echo form_open(base_url('materia/filtro'), array('role' => 'form', 'id' => 'formPadrao', 'class' => 'Formulario')); ?>
        <div class="body">
            <div class="card grey lighten-5" style="border-radius: 15px;">
                <div class="body">
                    <?php if (empty($_SESSION['idClienteSessao'])) { ?>
                    <div class="alert alert-warning">  <i class="material-icons">error</i> Selecione o cliente para a exibição das matérias</div>
                     <?php } ?>
                    <span class="card-title right"><i class="fas fa-filter"></i> Filtros</span>
                    <p><b>Buscar</b> <span style="font-size: 10pt">(Busca no título ou texto da matéria)</span></p>
                    <div clas="row">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="termo" name="texto" value="<?= isset($_SESSION['FILTROS']['texto']) ? $_SESSION['FILTROS']['texto'] : '' ?>">
                                </div>
                            </div>
                        </div>
                        <?php
                        $semana_anterior = date('d/m/Y', strtotime(date('Ymd') . ' - 7 days'));
                        $hoje = date('d/m/Y');
                        if (isset($_SESSION['FILTROS']['dataI'])) {
                            $semana_anterior = $_SESSION['FILTROS']['dataI'];
                        }
                        if (isset($_SESSION['FILTROS']['dataF'])) {
                            $hoje = $_SESSION['FILTROS']['dataF'];
                        }
                        ?>
                        <div class="col-md-3">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="datepicker form-control" id="datafr" name="dataI" value="<?= $semana_anterior ?>" placeholder="DATA DE INICIO">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class=" datepicker form-control" id="datafr1" name="dataF" value="<?= $hoje ?>" placeholder="DATA DE FIM">
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-12">
                            <label style="font-size: 11pt;"><b>Agrupar por</b></label>
                        </div>
                    </div>
                    <div clas="row">
                        <div class="col-xs-12 col-md-1 col-xl-1" style="margin-top: -2.5%;">
                            <div class="form-line">
                                <div class="demo-checkbox">
                                    <input id="indFiltroV" type="checkbox" name="indFiltroV" <?= isset($_SESSION['FILTROS']['tipoMat']) ? 'checked' : '' ?> onclick="exibeVeiculos()">&nbsp;
                                    <label for="indFiltroV">VEÍCULO</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-1 col-xl-1" style="margin-top: -2.5%;">
                            <div class="form-line">
                                <div class="demo-checkbox">
                                    <input id="indFiltroC" type="checkbox" name="indFiltroC" <?= isset($_SESSION['FILTROS']['tipoClipador']) ? 'checked' : '' ?> onclick="exibeClipador()">&nbsp;
                                    <label for="indFiltroC">CLIPADOR</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 col-xl-3" style="margin-top: -1.9%;">
                            <div class="form-group form-float agr_v">
                                <div class="form-line">
                                    <select id="tipoMat" class="form-control show-tick"  name="tipoMat[]" title="SELECIONE A MÍDIA" data-live-search="true" multiple>
                                        <option value="S" <?php if (isset($_SESSION['FILTROS']['tipoMat']) and in_array('S', $_SESSION['FILTROS']['tipoMat'])) echo 'selected'; ?>>Internet</option>
                                        <option value="I" <?php if (isset($_SESSION['FILTROS']['tipoMat']) and in_array('I', $_SESSION['FILTROS']['tipoMat'])) echo 'selected'; ?>>Impresso</option>
                                        <option value="R" <?php if (isset($_SESSION['FILTROS']['tipoMat']) and in_array('R', $_SESSION['FILTROS']['tipoMat'])) echo 'selected'; ?>>R&aacute;dio</option>
                                        <option value="T" <?php if (isset($_SESSION['FILTROS']['tipoMat']) and in_array('T', $_SESSION['FILTROS']['tipoMat'])) echo 'selected'; ?>>Televis&atilde;o</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 col-xl-3" style="margin-top: -1.9%;">
                            <div class="form-group form-float agr_C">
                                <?php
                                $this->db->where('SEQ_USUARIO > 1');
                                $this->db->where('IND_ATIVO = "S"');
                                $this->db->order_by('NOME_USUARIO', 'ASC');
                                $usuario = $this->db->get('USUARIO')->result();
                                ?>
                                <div class="form-line">
                                    <select id="tipoClipador" class="form-control show-tick"  name="tipoClipador[]" title="SELECIONE O CLIPADOR" data-live-search="true" multiple>
                                        <?php foreach ($usuario as $user) { ?>
                                        <option value="<?= $user->SEQ_USUARIO ?>" <?php if (isset($_SESSION['FILTROS']['tipoClipador']) and in_array($user->SEQ_USUARIO, $_SESSION['FILTROS']['tipoClipador'])) echo 'selected'; ?>><?= $user->NOME_USUARIO ?></option>
                                        <?php } ?>        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 col-xl-3" style="margin-top: -2.5%;">
                            <button type="submit" class="btn bg-blue btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="" data-original-title="FILTRAR" value="F" name="btn"><i class="material-icons" style="color:white;">send</i></button>
                            <button type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="" data-original-title="LIMPAR FILTROS" value="L" name="btn"><i class="material-icons" style="color:white;">close</i></button>
                        </div>

                    </div>
                </div>
                <BR><BR>
            </div>
        </div
        <?= form_close() ?>
        <div style="margin-left: 1%; margin-right: 1%;">
            <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                <i class="material-icons">home</i>
            </a>
            <a href="<?php echo base_url('materia') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                <i class="material-icons">refresh</i>
            </a>
            <?php if (($this->auth->CheckMenu('geral', 'materia', 'novoi') == 1) and in_array('I', explode(',', $this->session->userData('listaTipo')))) { ?>
                <a href="<?php echo base_url('materia/novoi') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo Impresso">
                    <i class="material-icons">new_releases</i>
                </a>
            <?php } if (($this->auth->CheckMenu('geral', 'materia', 'novos') == 1) and in_array('S', explode(',', $this->session->userData('listaTipo')))) { ?>
                <a href="<?php echo base_url('materia/novos') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo Internet">
                    <i class="material-icons">language</i>
                </a>
            <?php } if (($this->auth->CheckMenu('geral', 'materia', 'novor') == 1) and in_array('R', explode(',', $this->session->userData('listaTipo')))) { ?>
                <a href="<?php echo base_url('materia/novor') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo R&aacute;dio">
                    <i class="material-icons">radio</i>
                </a>
            <?php } if (($this->auth->CheckMenu('geral', 'materia', 'novot') == 1) and in_array('T', explode(',', $this->session->userData('listaTipo')))) { ?>
                <a href="<?php echo base_url('materia/novot') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo Tv">
                    <i class="material-icons">tv</i>
                </a>
            <?php } ?>

            <table  id="tabela-materia" class="table table-bordered table-striped table-hover js-basic-example-demand dataTable">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Nome do Veículo</th>
                        <th>Publicação</th>
                        <?php if ($this->session->userData('perfilUsuario') != 'ROLE_REP') { ?>
                            <th>Área da Matéria</th>
                        <?php } ?>
                        <th>Responsável</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tfoot class="hidden-sm hidden-xs">
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Nome do Veículo</th>
                        <th>Publicação</th>
                        <?php if ($this->session->userData('perfilUsuario') != 'ROLE_REP') { ?>
                            <th>Área da Matéria</th>
                        <?php } ?>
                        <th>Responsável</th>
                        <th>Ação</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<textarea id="alerta" class="textarea" style="width: 0px;height: 0px;resize: none;"></textarea>
<a id="linkzap" href="" target="_blank" >&nbsp;</a>
</div><!-- /.col -->
<script type="text/javascript">
    function eventBotaoExcluir(component) {
        showConfirmMessage('Você tem certeza?', 'Confirmando você excluirá esta matéria.', component);
        return false;
    }
    ;
    function eventBotaoEnviar(component) {
        showConfirmMessage('Você tem certeza?', 'Confirmando você enviará esta matéria ao cliente.', component);
        return false;
    }
    ;
    function eventBotaoCopia(component) {
        var url = component.data('url');
        $.ajax({
            mimeType: 'text; charset=utf-8',
            url: url,
            type: 'GET',
            success: function (data) {
                if (data.status) {
                    $("#alerta").text(data.mesage.replace(/\+/g, ' '));
                    var copyTextarea = document.querySelector('.textarea');

                    copyTextarea.select();
                    try {
                        var successful = document.execCommand('copy');
                        if (successful)
                            showNotification('alert-success', 'Alerta Copiado!', 'bottom', 'center', 'animated fadeInUp', '');
                    } catch (err) {
                        showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                    }
                } else {
                    showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            dataType: "json",
            async: true
        });
    }
    ;
    $(function () {
        var bindButtonClick = function () {
            $('.botao-excluir').click(function () {
                eventBotaoExcluir($(this));
                return false;
            });
            $('.botao-enviar').click(function () {
                eventBotaoEnviar($(this));
                return false;
            });
            // $('.copiaMensagem').on('click',function (){
            //     eventBotaoCopia($(this),'');
            // });
            // $('.copiaMensagemZap1').on('click',function (){
            //     alert('zap1');
            //     eventBotaoCopia($(this),'whatsapp://send?text=');
            // });
            // $('.copiaMensagemZap2').on('click',function (){
            //     alert('zap2');
            //     eventBotaoCopia($(this),'https://web.whatsapp.com/send?text=');
            // });
        };

        var table = $('#tabela-materia').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url() . 'materia/consultar'; ?>",
                type: "POST",
                data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                complete: function () {
//                    bindButtonClick();
                },
            },
            "columnDefs": [
                {
                    "targets": [6],
                    "orderable": false,
                },
            ],
            "iDisplayLength": 10,
            language: {
                "url": "assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
            }
        });

        $('#tabela-materia tbody').on('click', 'td a', function (e) {


            var btnAction = $(this).attr('id');
            var seqId = $(this).attr('seqId');
            var array = btnAction.split('-');
            if (array[1] === 'excluir') {
                e.preventDefault();
                eventBotaoExcluir($(this));
                return false;
            }

            if (array[1] === 'copia') {
                e.preventDefault();
                eventBotaoCopia($(this));
                return false;
            }
            if (array[1] === 'enviar') {
                e.preventDefault();
                eventBotaoEnviar($(this));
                return false;
            }
            if (array[1] === 'editar' || array[1] === 'down') {
                var url = $(this).attr('href');
                window.location.href = url;

            }

//            $.blockUI({ message: '<h1><img src="assets/imagens/loading.gif" />Processando ...</h1>' });
//
//            $.ajax({
//                mimeType: 'text/html; charset=utf-8',
//                url: '/sco/manutencao/'+array[1],
//                type: 'POST',
//                data: 'seqId='+seqId,
//                success: function(data) {
//                    $('#ajax-content').html(data);
//                },
//                error: function (jqXHR, textStatus, errorThrown) {
//                    console.log(errorThrown);
//                },
//                dataType: "html"//,
////				async: false
//            });

        });
    });
    function exibeVeiculos() {
        var check = document.querySelector("input[name='indFiltroV']:checked");
        if (check != null) {
            $('.agr_v').css('display', 'block');
        } else {
            $('.agr_v').css('display', 'none');
        }
    }
    function exibeClipador() {
        var check = document.querySelector("input[name='indFiltroC']:checked");
        if (check != null) {
            $('.agr_C').css('display', 'block');
        } else {
            $('.agr_C').css('display', 'none');
        }
    }
    $(function () {
        $('#datafr').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang: 'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText: 'Cancelar'
        });
        $('#datafr1').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang: 'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText: 'Cancelar'
        });
    });
</script>

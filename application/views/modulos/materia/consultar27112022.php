<style>
    #tabela-materia_wrapper {
        margin-top: 2%;
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
        <div class="body">
                        
                    <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                        <i class="material-icons">home</i>
                    </a>
                    <a href="<?php echo base_url('materia') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                        <i class="material-icons">refresh</i>
                    </a>
                    <?php if ( ($this->auth->CheckMenu('geral','materia','novoi')==1) and in_array('I',explode(',',$this->session->userData('listaTipo')))) { ?>
                        <a href="<?php echo base_url('materia/novoi') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo Impresso">
                            <i class="material-icons">new_releases</i>
                        </a>
                    <?php }  if ( ($this->auth->CheckMenu('geral','materia','novos')==1) and in_array('S',explode(',',$this->session->userData('listaTipo')))) { ?>
                        <a href="<?php echo base_url('materia/novos') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo Internet">
                            <i class="material-icons">language</i>
                        </a>
                    <?php } if ( ($this->auth->CheckMenu('geral','materia','novor')==1) and in_array('R',explode(',',$this->session->userData('listaTipo')))) { ?>
                        <a href="<?php echo base_url('materia/novor') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo R&aacute;dio">
                            <i class="material-icons">radio</i>
                        </a>
                    <?php } if ( ($this->auth->CheckMenu('geral','materia','novot')==1) and in_array('T',explode(',',$this->session->userData('listaTipo')))) { ?>
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
                            <?php if ($this->session->userData('perfilUsuario')!='ROLE_REP') { ?>
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
                            <?php if ($this->session->userData('perfilUsuario')!='ROLE_REP') { ?>
                                <th>Área da Matéria</th>
                            <?php } ?>
                            <th>Responsável</th>
                            <th>Ação</th>
                        </tr>
                        </tfoot>
                    </table>

        </div><!-- /.box-body -->
    </div><!-- /.box -->
    <textarea id="alerta" class="textarea" style="width: 0px;height: 0px;resize: none;"></textarea>
    <a id="linkzap" href="" target="_blank" >&nbsp;</a>
</div><!-- /.col -->
<script type="text/javascript">
    function eventBotaoExcluir(component){
        showConfirmMessage('Você tem certeza?','Confirmando você excluirá esta matéria.',component);
        return false;
    };
    function eventBotaoEnviar(component){
        showConfirmMessage('Você tem certeza?','Confirmando você enviará esta matéria ao cliente.',component);
        return false;
    };
    function eventBotaoCopia(component){
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
                }else {
                    showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            dataType: "json",
            async: true
        });
    };
    $(function () {
        var  bindButtonClick = function(){
            $('.botao-excluir').click(function(){
                eventBotaoExcluir($(this));
                return false;
            });
            $('.botao-enviar').click(function(){
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

        var table  = $('#tabela-materia').DataTable({
            "responsive": true,
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"<?php echo base_url() . 'materia/consultar'; ?>",
                type:"POST",
                data:{'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' },
                complete: function(){
//                    bindButtonClick();
                },
            },
            "columnDefs":[
                {
                    "targets":[6],
                    "orderable":false,
                },
            ],
            "iDisplayLength": 10,
            language: {
                "url": "assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
            }
        });

        $('#tabela-materia tbody').on( 'click', 'td a', function(e) {


            var btnAction = $(this).attr('id');
            var seqId = $(this).attr('seqId');
            var array =  btnAction.split('-');
            if (array[1] ==='excluir'){
                e.preventDefault();
                eventBotaoExcluir($(this));
                return false;
            }

            if (array[1] ==='copia'){
                e.preventDefault();
                eventBotaoCopia($(this));
                return false;
            }
            if (array[1] ==='enviar'){
                e.preventDefault();
                eventBotaoEnviar($(this));
                return false;
            }
            if (array[1] ==='editar' || array[1] ==='down'){
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
</script>

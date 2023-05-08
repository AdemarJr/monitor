<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">electrical_services</i> Matéria</h2>
        <small>Classificação de Matéria do KlipBox</small>
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
            <div class="row clearfix">
            <?php echo form_open(base_url('integracao'),
                array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                <div class="col-xs-12 col-md-3 col-xl-3">
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" class="datepicker form-control" id='datai' 
                            name='datai' placeholder="selecione a data inicio..." 
                            value='<?php if (!empty($datai)) echo $datai;?>'>
                            <label id="label-for" class="form-label">Data In&iacute;cio</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-xl-3">
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" class="datepicker form-control" id='dataf' 
                            name='dataf' placeholder="selecione a data fim..." 
                            value='<?php if (!empty($dataf)) echo $dataf;?>'>
                            <label id="label-for" class="form-label">Data Fim</label>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12 col-md-3 col-xl-3">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select id="monitoramento" class="form-control show-tick" 
                            name="monitoramento" title="">
                            <!-- <option value="">Todos os Monitoramentos</option> -->
                                <?php if (!empty($lista_monitoramento)) {
                                    foreach ($lista_monitoramento as $item): ?>
                                        <option <?php if (!empty($monitoramento) and in_array($item['SEQ_MONITORAMENTO'],explode(',',$monitoramento))) echo 'selected';?>
                                            value="<?php echo $item['SEQ_MONITORAMENTO'] ?>"><?php echo $item['NOME_MONITORAMENTO']; ?></option>
                                    <?php endforeach;
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-xl-3 hidden-print">
                    <button type="button" id="btn-processa"
                        class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" 
                        data-toggle="tooltip" 
                        data-placement="top" title="Consultar Klipbox">
                        <i class="material-icons">refresh</i>
                    </button>
                    <button type="button" id="btn-processa-monitoramento"
                        class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" 
                        data-toggle="tooltip" 
                        data-placement="top" title="Atualizar Monitoramentos">
                        <i class="material-icons">grain</i>
                    </button>
                </div>
                <div id="load_consulta" class="col-xs-12 col-md-12 col-xl-12 text-center">
                    
                </div>
                </form>
            </div>
                        <table  id="tabela-materia" class="table table-bordered table-striped table-hover js-basic-example-demand dataTable">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Cliente</th>
                            <th>Título</th>
                            <th>Responsável</th>
                            <th>Portal</th>
                            <th>Publicação</th>
                            <th>Link</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tfoot class="hidden-sm hidden-xs">
                            <tr>
                                <th>Código</th>
                                <th>Cliente</th>
                                <th>Título</th>
                                <th>Responsável</th>
                                <th>Portal</th>
                                <th>Publicação</th>
                                <th>Link</th>
                                <th>Ação</th>
                            </tr>
                        </tfoot>
                    </table>
                    <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                        <i class="material-icons">home</i>
                    </a>
                    <a href="<?php echo base_url('integracao') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                        <i class="material-icons">refresh</i>
                    </a>
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
    $(function () {
        var table  = $('#tabela-materia').DataTable({
            "responsive": true,
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"<?php echo base_url() . 'integracao/consultar'; ?>",
                type:"POST",
                data:{'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' },
                complete: function(){
                },
            },
            "iDisplayLength": 50,
            language: {
                "url": "<?php echo base_url('assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json'); ?>"
            }
        });

        $('#tabela-materia tbody').on( 'click', 'td a', function(e) {
            var btnAction = $(this).attr('id');
            var seqId = $(this).attr('seqId');
            var array =  btnAction.split('-');
            if (array[1] ==='editar' || array[1] ==='alterar'){
                var url = $(this).attr('href');
                window.location.href = url;

            }
            if (array[1] ==='excluir'){
                e.preventDefault();
                eventBotaoExcluir($(this));
                return false;
            }
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
        var iconCarregando = $('<div class="preloader pl-size-sm"><div class="spinner-layer"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
        $('#btn-processa').click(function(e){
            //  e.preventDefault();
             var serializeDados = $('#formPadrao').serialize(),
                idMonitora = $('#monitoramento').val();
             

            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: '<?php echo base_url('/integracao/jobProcessamento'); ?>',
                type: 'POST',
                data: serializeDados,
                beforeSend: function() {
                    $('#btn-processa').prop('disabled',true); 
                    $('#btn-processa-monitoramento').prop('disabled',true); 
                    $('#load_consulta').html(iconCarregando); 
                },
                complete: function() {
                    $(iconCarregando).remove(); 
                    $('#btn-processa').prop('disabled',false); 
                    $('#btn-processa-monitoramento').prop('disabled',false); 

                },
                success: function (data) {
                    eval(data.mensagem);
                    table.draw();
                    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                dataType: "json",
                async: true
            });
        });
        $('#btn-processa-monitoramento').click(function(e){
            //  e.preventDefault();
			 var serializeDados = $('#formPadrao').serialize();

            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: '<?php echo base_url('/integracao/jobMonitoramento'); ?>',
                type: 'POST',
                data: serializeDados,
                beforeSend: function() {
                    $('#btn-processa-monitoramento').prop('disabled',true); 
                    $('#load_consulta').html(iconCarregando); 
                },
                complete: function() {
                    $(iconCarregando).remove(); 
                    $('#btn-processa-monitoramento').prop('disabled',false); 

                },
                success: function (data) {
                    eval(data.mensagem);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                dataType: "json",
                async: true
            });
        });
    });
</script>

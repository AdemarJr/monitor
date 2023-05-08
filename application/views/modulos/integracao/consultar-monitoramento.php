<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">electrical_services</i> Monitoramento</h2>
        <small>Lista de Monitoramento.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Monitoramento</li>
        </ol>
    </div>
</div>
<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Lista de Monitoramento</h2>
        </div><!-- /.box-header -->
        <div class="body">
            <div class="row clearfix">
                <?php echo form_open(base_url('integracao'),
                    array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                <div class="col-xs-12 col-md-3 col-xl-3 hidden-print">
                    <button type="button" id="btn-processa"
                        class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" 
                        data-toggle="tooltip" 
                        data-placement="top" title="Atualizar Monitoramentos">
                        <i class="material-icons">grain</i>
                    </button>
                </div>
                </form>
            </div>
                <div id="load_consulta" class="col-xs-12 col-md-12 col-xl-12 text-center">
                    
                </div>
                <table id="tabela-monitor" class="table table-bordered table-striped table-hover js-basic-release dataTable">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Tags</th>
                    <th>Existe Cliente?</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($lista_monitoramento)) {
                    foreach ($lista_monitoramento as $item): ?>
                        <tr>
                            <td><?php echo $item['SEQ_MONITORAMENTO'] ?></td>
                            <td><?php echo $item['NOME_MONITORAMENTO'] ?></td>
                            <td><?php if (!empty($item['TAGS_MONITORAMENTO'])) {
                                $lista_monitor = explode(',',$item['TAGS_MONITORAMENTO']);
                                foreach($lista_monitor as $key){
                                    echo '<span class="label bg-indigo m-t-5 ">'.$key.'</span><br/>'; 
                                }
                                } ?>
                            
                            </td>
                            <td>
                                <?php 
                                    $existe = $this->ComumModelo->contaClienteByMonitoramento($item['SEQ_MONITORAMENTO']);
                                    if ($existe>0 and $existe===1){
                                        echo '<span class="label bg-green"> Associado a '.$existe.' Cliente</span>';
                                    }else if ($existe>0){
                                        echo '<span class="label bg-green"> Associado a '.$existe.' Clientes</span>';
                                    }else {
                                        echo '<span class="label bg-red"> Não Associado</span>';
                                    }
                                ?>
                            
                            </td>
                        </tr>
                    <?php endforeach;
                } ?>
                </tbody>
                <tfoot class="hidden-sm hidden-xs">
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Tags</th>
                    <th>Existe Cliente?</th>
                </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<script type="text/javascript">
    $(function () {
        var table  = $('#tabela-monitor').DataTable({
                responsive: true,
                paginate: true,
                columnDefs: [
                    { "width": "5%", "targets": 0 },
                    { "width": "45%", "targets": 1 },
                    { "width": "40%", "targets": 2 },
                    { "width": "10%", "targets": 3 },
                ],
                language: {
                    "url": "/monitor/assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
                }
            });
        var iconCarregando = $('<div class="preloader pl-size-sm"><div class="spinner-layer"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
        $('#btn-processa').click(function(e){
             e.preventDefault();
			 var serializeDados = $('#formPadrao').serialize();

            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: '<?php echo base_url('/integracao/jobMonitoramento'); ?>',
                type: 'POST',
                data: serializeDados,
                beforeSend: function() {
                    $('#btn-processa').prop('disabled',true); 
                    $('#load_consulta').html(iconCarregando); 
                },
                complete: function() {
                    $(iconCarregando).remove(); 
                    $('#btn-processa').prop('disabled',false); 
                },
                success: function (data) {
                    eval(data.mensagem);
                    location.reload();
                    
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

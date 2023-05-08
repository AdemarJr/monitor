<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">contacts</i> Seleção do Cliente de Trabalho</h2>
        <small>Escolha um cliente</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
        </ol>
    </div>
</div>
<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Lista de Clientes que você tem Permissão</h2>
        </div><!-- /.box-header -->
        <div class="body">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                <tr>
                    <th>Nome do Cliente</th>
                    <th>Empresa/Órgão/Instituição</th>
                    <th>Cidade</th>
                    <th>UF</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($lista_cliente)) {
                    foreach ($lista_cliente as $item): ?>
                        <tr>
                            <td><?php echo $item['NOME_CLIENTE'] ?></td>
                            <td><?php echo $item['EMPRESA_CLIENTE'] ?></td>
                            <td><?php echo $item['CIDADE_CLIENTE'] ?></td>
                            <td><?php echo $item['UF_CLIENTE'] ?></td>
                            <td data-title="Ação">
                                <div class='avoid-this action-buttons'>
                                    <?php if ($this->auth->CheckMenu('geral', 'principal', 'seleciona') == 1) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Selecionar este cliente" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                           href="<?php echo base_url('principal/seleciona/') . $item['SEQ_CLIENTE'] ?>">
                                            <i class="material-icons">send</i>
                                        </a>&nbsp;&nbsp;
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;
                } ?>
                </tbody>
                <tfoot class="hidden-sm hidden-xs">
                <tr>
                    <th>Nome do Cliente</th>
                    <th>Empresa/Órgão/Inst. do Cliente</th>
                    <th>Cidade</th>
                    <th>UF</th>
                    <th>Ação</th>
                </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<script type="text/javascript">
    $(function () {
        $('.botao-excluir').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você excluirá este cliente.',$(this));
            return false;
        });
    });
</script>

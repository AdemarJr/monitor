<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">contacts</i> Cliente</h2>
        <small>Cadastro e Alteração de Clientes.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Cliente</li>
        </ol>
    </div>
</div>
<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Lista de Clientes</h2>
        </div><!-- /.box-header -->
        <div class="body">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                <tr>
                    <th>Nome do Cliente</th>
                    <th>Empresa/Órgão/Instituição</th>
                    <th>Cidade</th>
                    <th>UF</th>
                    <th>Status</th>
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
                            <td><?php if ($item['IND_ATIVO']=='S') echo 'Ativo'; else echo 'Inativo'; ?></td>
                            <td data-title="Ação">
                                <div class='avoid-this action-buttons'>
                                    <?php if ($this->auth->CheckMenu('geral', 'cliente', 'editar') == 1) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                           href="<?php echo base_url('cliente/editar/') . $item['SEQ_CLIENTE'] ?>">
                                            <i class="material-icons">edit</i>
                                        </a>&nbsp;&nbsp;
                                    <?php }
                                    if (($this->auth->CheckMenu('geral', 'cliente', 'excluir') == 1)) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Excluir" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float botao-excluir'
                                           href="<?php echo base_url('cliente/excluir/') . $item['SEQ_CLIENTE'] ?>">
                                            <i class="material-icons">delete</i>
                                        </a>&nbsp;&nbsp;
                                    <?php }?>
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
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
                </tfoot>
            </table>
                    <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                        <i class="material-icons">home</i>
                    </a>
                    <a href="<?php echo base_url('cliente') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                        <i class="material-icons">refresh</i>
                    </a>
                    <a href="<?php echo base_url('cliente/novo') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo Cliente">
                        <i class="material-icons">add</i>
                    </a>
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

<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">fiber_new</i> Veículo-Televis&atilde;o</h2>
        <small>Cadastro e Alteração de Televis&atilde;o.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Veículo-Televis&atilde;o</li>
        </ol>
    </div>
</div>
<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Lista de Veículos</h2>
        </div><!-- /.box-header -->
        <div class="body">
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                <tr>
                    <th>Nome da Televis&atilde;o</th>
                    <th>Cidade</th>
                    <th>URL</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($lista_veiculo)) {
                    foreach ($lista_veiculo as $item): ?>
                        <tr>
                            <td><?php echo $item['NOME_TV'] ?></td>
                            <td><?php echo $item['CIDADE_TV'] ?></td>
                            <td><?php echo $item['SITE_TV'] ?></td>
                            <td data-title="Ação">
                                <div class='avoid-this action-buttons'>
                                    <?php if ($this->auth->CheckMenu('geral', 'veiculo', 'editarRadio') == 1) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                           href="<?php echo base_url('veiculo/editarTv/') . $item['SEQ_TV'] ?>">
                                            <i class="material-icons">edit</i>
                                        </a>&nbsp;&nbsp;
                                    <?php }
                                    if (($this->auth->CheckMenu('geral', 'veiculo', 'excluirRadio') == 1)) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Excluir" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float botao-excluir'
                                           href="<?php echo base_url('veiculo/excluirTv/') . $item['SEQ_TV'] ?>">
                                            <i class="material-icons">delete</i>
                                        </a>&nbsp;&nbsp;
                                    <?php }
                                    if (($this->auth->CheckMenu('geral', 'veiculo', 'excluirRadio') == 1)) { ?>
                                        <a data-toggle="tooltip" data-placement="top"
                                           title="Cadastrar Precificação"
                                           class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float'
                                           href="<?php echo base_url('veiculo/consultaPreco/T/') . $item['SEQ_TV'] ?>">
                                            <i class="material-icons">attach_money</i>
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
                        <th>Nome da Televis&atilde;o</th>
                        <th>Cidade</th>
                        <th>URL</th>
                        <th>Ação</th>
                    </tr>
                </tfoot>
            </table>
            <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                <i class="material-icons">home</i>
            </a>
            <a href="<?php echo base_url('veiculo/consultat') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                <i class="material-icons">refresh</i>
            </a>
            <a href="<?php echo base_url('veiculo/novo/t') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo Veículo">
                <i class="material-icons">add</i>
            </a>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<script type="text/javascript">
    $(function () {
        $('.botao-excluir').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você excluirá este veículo.',$(this));
            return false;
        });
    });
</script>

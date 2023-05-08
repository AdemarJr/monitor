<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">layers</i> Áreas da Matéria</h2>
        <small>Cadastro e Alteração de Áreas da Matéria.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Áreas da Matéria</li>
        </ol>
    </div>
</div>
<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Lista de Áreas da Matéria</h2>
        </div><!-- /.box-header -->
        <div class="body">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($lista_tipomateria)) {
                    foreach ($lista_tipomateria as $item): ?>
                        <tr>
                            <td><?php echo $item['SEQ_TIPO_MATERIA'] ?></td>
                            <td><?php echo $item['DESC_TIPO_MATERIA'] ?>
                            <?php 
                            if ($item['IND_ATIVO'] == 'N') {
                                echo '<span class="label label-info">INATIVO</span>';
                            }
                            ?>
                            </td>
                            <td data-title="Ação">
                                <div class='avoid-this action-buttons'>
                                    <?php if ($this->auth->CheckMenu('geral', 'tipomateria', 'editar') == 1) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                           href="<?php echo base_url('tipomateria/editar/') . $item['SEQ_TIPO_MATERIA'] ?>">
                                            <i class="material-icons">edit</i>
                                        </a>&nbsp;&nbsp;
                                    <?php }
                                    if (($this->auth->CheckMenu('geral', 'tipomateria', 'excluir') == 1)) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Excluir" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float botao-excluir'
                                           href="<?php echo base_url('tipomateria/excluir/') . $item['SEQ_TIPO_MATERIA'] ?>">
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
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                </tr>
                </tfoot>
            </table>
                    <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                        <i class="material-icons">home</i>
                    </a>
                    <a href="<?php echo base_url('tipomateria') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                        <i class="material-icons">refresh</i>
                    </a>
                    <a href="<?php echo base_url('tipomateria/novo') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Nova Área da Matéria">
                        <i class="material-icons">add</i>
                    </a>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<script type="text/javascript">
    $(function () {
        $('.botao-excluir').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você excluirá esta área da matéria.',$(this));
            return false;
        });
    });
</script>

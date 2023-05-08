<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">fiber_new</i> Veículo/Pre&ccedil;os-R&aacute;dio</h2>
        <small>Cadastro e Alteração de Pre&ccedil;os.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Veículo/Pre&ccedil;os-R&aacute;dio</li>
        </ol>
    </div>
</div>
<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Lista de Preços -
                <?php
                if ($tipoMat=='R'){

                    echo $this->ComumModelo->getTableData('RADIO',array('SEQ_RADIO'=>$id,'SEQ_CLIENTE'=>$this->session->userdata('idClienteSessao')))->row()->NOME_RADIO;
                } else {
                    echo $this->ComumModelo->getTableData('TELEVISAO',array('SEQ_TV'=>$id,'SEQ_CLIENTE'=>$this->session->userdata('idClienteSessao')))->row()->NOME_TV;
                }
                ?>
            </h2>
        </div><!-- /.box-header -->
        <div class="body">
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                <tr>
                    <th>Descri&ccedil;&atilde;o</th>
                    <th>Valor</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($lista_preco)) {
                    foreach ($lista_preco as $item): ?>
                        <tr>
                            <td><?php echo $item['DESCRITIVO'] ?></td>
                            <td><?php echo  number_format($item['VALOR'], 2, ",", ".") ?></td>
                            <td data-title="Ação">
                                <div class='avoid-this action-buttons'>
                                    <?php if ($this->auth->CheckMenu('geral', 'veiculo', 'editarPreco') == 1) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                           href="<?php echo base_url('veiculo/editarPreco/'.$tipoMat.'/'.$id.'/') . $item['SEQ_PRECO'] ?>">
                                            <i class="material-icons">edit</i>
                                        </a>&nbsp;&nbsp;
                                    <?php }
                                    if (($this->auth->CheckMenu('geral', 'veiculo', 'excluirPreco') == 1)) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Excluir" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float botao-excluir'
                                           href="<?php echo base_url('veiculo/excluirPreco/'.$tipoMat.'/'.$id.'/') . $item['SEQ_PRECO'] ?>">
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
                        <th>Descri&ccedil;&atilde;o</th>
                        <th>Valor</th>
                        <th>Ação</th>
                    </tr>
                </tfoot>
            </table>
            <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                <i class="material-icons">home</i>
            </a>
            <a href="<?php echo base_url('veiculo/consultaPreco/'.$tipoMat.'/'.$id) ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                <i class="material-icons">refresh</i>
            </a>
            <a href="<?php echo base_url('veiculo/novoPreco/'.$tipoMat.'/'.$id) ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo Preço">
                <i class="material-icons">add</i>
            </a>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<script type="text/javascript">
    $(function () {
        $('.botao-excluir').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você excluirá este registro.',$(this));
            return false;
        });
    });
</script>

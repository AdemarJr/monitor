<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">person</i> Usuário</h2>
        <small>Cadastro e Alteração de Usuários.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Usu&aacute;rios</li>
        </ol>
    </div>
</div>
<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Lista de Usuários</h2>
            <button data-toggle="modal" data-target="#modalAuditoriaMensal" data-placement="top" title="Auditoria Mensal" class="btn btn-circle bg-red  waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="" data-original-title="Relatório Mensal">
                <i class="material-icons">save</i>
            </button>    
            <?php 
            $listaPermitido = array('1');
            ?>
        </div><!-- /.box-header -->
        <div class="body">
            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                        <th>Login</th>
                        <th>Nome do Usuário</th>
                        <th>Perfil</th>
                        <th>Situacão</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($lista_usuario)) {
                        foreach ($lista_usuario as $item):
                            ?>
                            <tr>
                                <td width="15%"><?php echo $item['LOGIN_USUARIO'] ?></td>
                                <td width="25%">
                                    <?php echo $item['NOME_USUARIO'] ?><br>
                                    <?php if (!empty($ctrl->auditoriaTempo($item['SEQ_USUARIO']))) { ?>
                                    <i class="fa fa-exclamation-circle"></i> O tempo médio para inserir um alerta é: <b><?= $ctrl->auditoriaTempo($item['SEQ_USUARIO'])?></b>
                                    <?php } ?>
                                </td>
                                <td width="15%">
                                    <?php
                                    if ($item['PERFIL_USUARIO'] == 'ROLE_ADM') {
                                        echo 'Administrador';
                                    } else if ($item['PERFIL_USUARIO'] == 'ROLE_USU') {
                                        echo 'Usuário';
                                    } else if ($item['PERFIL_USUARIO'] == 'ROLE_REP') {
                                        echo 'Representante';
                                    } else if ($item['PERFIL_USUARIO'] == 'ROLE_CLI') {
                                        echo 'Cliente';
                                    } else if ($item['PERFIL_USUARIO'] == 'ROLE_SET') {
                                        echo 'Usuário Setor';
                                    }
                                    ?></td>
                                <td width="15%">
                                    <?php
                                    if ($item['IND_ATIVO'] == 'S') {
                                        echo 'Ativo';
                                    } else if ($item['IND_ATIVO'] == 'N') {
                                        echo 'Inativo';
                                    }
                                    ?>
                                </td>
                                <td  width="30%">
                                    <div class='avoid-this action-buttons'>
                                        <?php if ($this->auth->CheckMenu('geral', 'usuario', 'editar') == 1) { ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                               href="<?php echo base_url('usuario/editar/') . $item['SEQ_USUARIO'] ?>">
                                                <i class="material-icons">edit</i>
                                            </a>&nbsp;&nbsp;
                                            <?php
                                        }
                                        if (($this->auth->CheckMenu('geral', 'usuario', 'senha') == 1)) {
                                            ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Alterar Senha" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float'
                                               href="<?php echo base_url('usuario/senha/') . $item['SEQ_USUARIO'] ?>">
                                                <i class="material-icons">security</i>
                                            </a>&nbsp;&nbsp;
                                            <?php
                                        }
                                        if ($this->auth->CheckMenu('geral', 'usuario', 'perfil') == 1) {
                                            ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Altribuir Perfil" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                               href="<?php echo base_url('usuario/perfil/') . $item['SEQ_USUARIO'] ?>">
                                                <i class="material-icons">playlist_add_check</i>
                                            </a>&nbsp;&nbsp;
                                            <?php
                                        }
                                        if ($item['PERFIL_USUARIO'] == 'ROLE_SET' and $this->auth->CheckMenu('geral', 'usuario', 'setor') == 1) {
                                            ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Altribuir Setor" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                               href="<?php echo base_url('usuario/setor/') . $item['SEQ_USUARIO'] ?>">
                                                <i class="material-icons">list</i>
                                            </a>&nbsp;&nbsp;
                                            <?php
                                        }
                                        if ($item['LOGIN_USUARIO'] != 'admin' and $item['LOGIN_USUARIO'] != 'adm' and ($this->auth->CheckMenu('geral', 'usuario', 'alterarStatus') == 1)) {
                                            ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Alterar Status" class='btn bg-blue btn-circle waves-effect waves-circle waves-float botao-status'
                                               href="<?php echo base_url('usuario/alterarStatus/') . $item['SEQ_USUARIO'] ?>">
                                                   <?php if ($item['IND_ATIVO'] == 'N') { ?>
                                                    <i class="material-icons">blur_off</i>
                                                <?php } else if ($item['IND_ATIVO'] == 'S') { ?>
                                                    <i class="material-icons">blur_on</i>
                                                <?php } ?>
                                            </a>&nbsp;&nbsp;

                                        <?php } ?>
                                        <?php if (in_array($_SESSION['idUsuario'], $listaPermitido)) { ?>    
                                        <button data-toggle="modal" data-placement="top" title="Auditoria" class='btn bg-blue btn-circle waves-effect waves-circle waves-float btn-auditoria' data-usuario="<?=$item['SEQ_USUARIO']?>" data-target="#modalAuditoria">
                                            <i class="material-icons">list</i>
                                        </button>&nbsp;&nbsp;
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    }
                    ?>
                </tbody>
                <tfoot class="hidden-sm hidden-xs">
                    <tr>
                        <th>Login</th>
                        <th>Nome do Usuário</th>
                        <th>Perfil</th>
                        <th>Situacão</th>
                        <th>Ação</th>
                    </tr>
                </tfoot>
            </table>
            <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                <i class="material-icons">home</i>
            </a>
            <a href="<?php echo base_url('usuario') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                <i class="material-icons">refresh</i>
            </a>
            <a href="<?php echo base_url('usuario/novo') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Novo Usu&aacute;rio">
                <i class="material-icons">add</i>
            </a>
            <div class="modal fade" id="modalAuditoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="<?=base_url('dev/auditoria')?>">
                        <input type="hidden" name="usuario">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?=$this->security->get_csrf_hash(); ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Auditoria</h5>
                            </div>
                            <div class="modal-body">
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" class="date form-control" id='datair1' name='datair' value="<?= date('d/m/Y') ?>" required="">
                                            <label id="label-for" class="form-label">Data In&iacute;cio</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" class="date form-control" id='datafr1' name='datafr' value="<?= date('d/m/Y') ?>" required="">
                                            <label id="label-for" class="form-label">Data Fim</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal fade" id="modalAuditoriaMensal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="<?=base_url('dev/auditoriaMensal')?>">
                        <input type="hidden" name="usuario">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?=$this->security->get_csrf_hash(); ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Auditoria</h5>
                            </div>
                            <div class="modal-body">
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" class="date form-control" id='datair1' name='datair' value="<?= date('d/m/Y') ?>" required="">
                                            <label id="label-for" class="form-label">Data In&iacute;cio</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" class="date form-control" id='datafr1' name='datafr' value="<?= date('d/m/Y') ?>" required="">
                                            <label id="label-for" class="form-label">Data Fim</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<script type="text/javascript">
    $(function () {
        $('.botao-status').click(function () {
            showConfirmMessage('Você tem certeza?', 'Confirmando você altera a situação do usuário.', $(this));
            return false;
        });
    });
    $('body').delegate('.btn-auditoria', 'click', function () {
        var idUsuario = $(this).attr("data-usuario");
        $("input[name='usuario']").val(idUsuario);
    });
    $('#modalAuditoria').on('hidden.bs.modal', function (e) {
        document.location.reload(true);
    });
    $(document).ready(function () {
        $('.date').mask('00/00/0000');
    });
</script>

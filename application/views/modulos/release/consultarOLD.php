<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">grade</i> Release</h2>
        <small>Cadastro e Alteração de Release.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Release</li>
        </ol>
    </div>
</div>
<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Lista de Release</h2>
        </div><!-- /.box-header -->
        <div class="body">
                <table class="table table-bordered table-striped table-hover js-basic-release dataTable">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Setor</th>
                    <th>Data Envio</th>
                    <th>Ativo?</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($lista_release)) {
                    foreach ($lista_release as $item): ?>
                        <tr>
                            <td><?php echo $item['SEQ_RELEASE'] ?></td>
                            <td><?php echo $item['DESC_RELEASE'] ?></td>
                            <td><?php if (!empty($item['SEQ_SETOR'])) echo $this->ReleaseModelo->getSetor($item['SEQ_SETOR']); ?></td>
                            <td><?php if (!empty($item['DATA_ENVIO_RELEASE'])) echo date('d/m/Y',strtotime($item['DATA_ENVIO_RELEASE']));?></td>
                            <td>
                                <div class="demo-switch">
                                    <div class="switch">
                                        <label><input type="checkbox" name="release"
                                                              class="check_item"
                                                              value="<?php echo $item['SEQ_RELEASE'] ?>"
                                                              name="release<?php echo $item['SEQ_RELEASE'] ?>"
                                                              id="release-<?php echo $item['SEQ_RELEASE'] ?>"
                                                <?php if ($item['IND_ATIVO']=='S') echo 'checked'; ?>><span class="lever"></span></label>
                                    </div>
                                </div>
                            </td>
                            <td data-title="Ação">
                                <div class='avoid-this action-buttons'>
                                    <?php if ($this->auth->CheckMenu('geral', 'release', 'editar') == 1) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                           href="<?php echo base_url('release/editar/') . $item['SEQ_RELEASE'] ?>">
                                            <i class="material-icons">edit</i>
                                        </a>&nbsp;&nbsp;
                                    <?php }
                                    if (($this->auth->CheckMenu('geral', 'release', 'excluir') == 1)) { ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Excluir" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float botao-excluir'
                                           href="<?php echo base_url('release/excluir/') . $item['SEQ_RELEASE'] ?>">
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
                    <th>Setor</th>
                    <th>Data Envio</th>
                    <th>Ativo?</th>
                    <th>Ação</th>
                </tr>
                </tfoot>
            </table>
                    <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                        <i class="material-icons">home</i>
                    </a>
                    <a href="<?php echo base_url('release') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                        <i class="material-icons">refresh</i>
                    </a>
                    <a href="<?php echo base_url('release/novo') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Nova Release">
                        <i class="material-icons">add</i>
                    </a>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<script type="text/javascript">
    $(function () {
        $('.botao-excluir').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você excluirá definitivamente esta Release.',$(this));
            return false;
        });
        $('.js-basic-release').DataTable({
            responsive: true,
            paginate: true,
            columnDefs: [
                { "width": "5%", "targets": 0 },
                { "width": "50%", "targets": 1 },
                { "width": "15%", "targets": 2 },
                { "width": "10%", "targets": 3 },
                { "width": "10%", "targets": 4 },
                { "width": "5%", "targets": 5 }
            ],
            language: {
                "url": "/monitor/assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
            }
        });

        $('.check_item').on("click", function(e) {
            var resposta = $(this).is(':checked')==true?'S':'N'
            var campo = 'release'+$(this).val()+'';
            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: '/monitor/release/ajaxReleaseSituacao/' + $(this).val() + '/' + resposta,
                type: 'GET',
                success: function (data) {
                    $('.clsShow_NotificationS').fadeIn();
                    $('.clsShow_NotificationS').fadeOut(3000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    e.prese
                    alert('Ocorreu Algum Problema, nao foi possivel alterar!');
                    console.log(errorThrown);
                },
                dataType: "text",
                async: false
            });
        });
    });
</script>

<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">search</i> Resultado Pesquisa</h2>
        <small>Resultado de Consulta de Mat&eacute;rias</small>
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
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2 class="box-title">Resultado (<?php echo $totalLinhas; ?>) "<?php if (!empty($texto)) echo urldecode($texto);?>"</h2>
        </div><!-- /.box-header -->
        <div class="body">
            <?php echo form_open(base_url('pesquisa'),array('role' => 'form', 'id' => 'formPadraoSearch','class'=>'Formulario')); ?>
            <div class="row clearfix">
                <div class="col-xs-12 col-md-6 col-xl-6">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type='text' class='form-control' id='texto' name='texto' value="<?php if (!empty($texto)) echo urldecode($texto);?>"/>
                            <label id="label-for" class="form-label">Texto</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2 col-xl-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select class="form-control show-tick" name="tipo" id="tipo" data-live-search="true">
                                <option value="NA">Área da Matéria</option>
                                <?php if (!empty($lista_tipo)) {
                                    foreach ($lista_tipo as $item): ?>
                                        <option
                                            value="<?php echo $item['SEQ_TIPO_MATERIA'] ?>" <?php if (!empty($tipo) and $tipo==$item['SEQ_TIPO_MATERIA']) echo 'selected';?>><?php echo $item['DESC_TIPO_MATERIA']; ?></option>
                                    <?php endforeach;
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2 col-xl-2">
                    <div class="form-group form-float">
                        <div class="form-line">
                            <select class="form-control show-tick" name="setor" id="setor" data-live-search="true">
                                <option value="NA">Setor</option>
                                <?php if (!empty($lista_setor)) {
                                    foreach ($lista_setor as $item): ?>
                                        <option
                                            value="<?php echo $item['SEQ_SETOR'] ?>" <?php if (!empty($setor) and $setor==$item['SEQ_SETOR']) echo 'selected';?>><?php echo $item['DESC_SETOR']; ?></option>
                                    <?php endforeach;
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-2 col-xl-2">
                    <button type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Aplicar Filtro">
                        <i class="material-icons">filter_list</i>
                    </button>
                    <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                        <i class="material-icons">home</i>
                    </a>
                </div>
            </div>
            </form>
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-line dataTables_length">
                            <label>Exibir <select
                                    name="per_page" aria-controls="tabela-produto" id="per_page"
                                    class="form-control input-sm exec-pesquisa-select">
                                    <option value="5" <?php if (!empty($per_page) and $per_page==5) echo 'selected';?>>5</option>
                                    <option value="10" <?php if (!empty($per_page) and $per_page==10) echo 'selected';?>>10</option>
                                    <option value="25" <?php if (!empty($per_page) and $per_page==25) echo 'selected';?>>25</option>
                                    <option value="50" <?php if (!empty($per_page) and $per_page==50) echo 'selected';?>>50</option>
                                    <option value="100" <?php if (!empty($per_page) and $per_page==100) echo 'selected';?>>100</option>
                                </select> Registros</label></div>
                        <input type='hidden' id='sort' name='sort' value="<?php if (!empty($sort)) echo $sort;?>"/>
                        <input type='hidden' id='order' name='order' value="<?php if (!empty($order)) echo $order;?>"/>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-xl-12">
                        <table class="table table-bordered table-striped table-hover js-basic-example-demand dataTable">
                        <thead>
                        <tr>
                            <th >Código</th>
                            <th>Tipo</th>
                            <th>Nome do Veículo</th>
                            <th>Publicação</th>
                            <?php if ($this->session->userData('perfilUsuario')!='ROLE_REP') { ?>
                            <th>Área da Matéria</th>
                            <?php } ?>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($lista_materia)) {

                            foreach ($lista_materia as $item):
                                $habilitaBotaoDownEmail=false;?>
                                <tr>
                                    <td><?php echo $item['SEQ_MATERIA'] ?></td>
                                    <td><?php if(!empty($item['SEQ_VEICULO'])) echo 'Impresso'; else if(!empty($item['SEQ_PORTAL'])) echo 'Internet';else if(!empty($item['SEQ_RADIO'])) echo 'Rádio';   ?></td>
                                    <td><?php if(!empty($item['SEQ_VEICULO']))
                                            echo $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row()->FANTASIA_VEICULO;
                                        else if(!empty($item['SEQ_PORTAL'])) echo $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row()->NOME_PORTAL;
                                        else if(!empty($item['SEQ_RADIO'])) echo $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row()->NOME_RADIO;
                                        ?></td>
                                    <td><?php echo date('d/m/Y',strtotime($item['DATA_MATERIA_PUB'])); ?></td>
                                    <?php
                                    $habilitaBotaoDownEmail = (!empty($item['SEQ_TIPO_MATERIA']) AND !empty($item['SEQ_SETOR']) and !empty($item['IND_AVALIACAO']) and !empty($item['IND_CLASSIFICACAO']));
                                    if ($this->session->userData('perfilUsuario')!='ROLE_REP') { ?>
                                    <td><?php if (!empty($item['SEQ_TIPO_MATERIA'])) echo $this->ComumModelo->getTableData('TIPO_MATERIA', array('SEQ_TIPO_MATERIA' =>  $item['SEQ_TIPO_MATERIA']))->row()->DESC_TIPO_MATERIA; ?></td>
                                    <?php } ?>
                                    <td data-title="Ação">
                                        <div class='avoid-this action-buttons'>
                                            <?php if ($this->auth->CheckMenu('geral', 'materia', 'editar') == 1) { ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                                   href="<?php echo base_url('materia/editar/') . $item['SEQ_MATERIA'] ?>">
                                                    <i class="material-icons">edit</i>
                                                </a>&nbsp;&nbsp;
                                            <?php }
                                            if (($this->auth->CheckMenu('geral', 'materia', 'excluir') == 1)) { ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Excluir" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float botao-excluir'
                                                   href="<?php echo base_url('materia/excluir/') . $item['SEQ_MATERIA'] ?>">
                                                    <i class="material-icons">delete</i>
                                                </a>&nbsp;&nbsp;
                                            <?php }?>
                                            <?php if ($item['IND_STATUS']=='C' and $this->auth->CheckMenu('geral', 'materia', 'enviar')) { ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Enviar ao Cliente" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float botao-enviar'
                                                   href="<?php echo base_url('materia/enviar/') . $item['SEQ_MATERIA'] ?>">
                                                    <i class="material-icons">send</i>
                                                </a>&nbsp;&nbsp;
                                            <?php }?>
                                            <?php if ( $habilitaBotaoDownEmail and $item['IND_STATUS']=='E' and $this->auth->CheckMenu('geral', 'materia', 'download')) { ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Download da Matéria" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float'
                                                   href="<?php echo base_url('materia/download/') . $item['SEQ_MATERIA'] ?>">
                                                    <i class="material-icons">file_download</i>
                                                </a>&nbsp;&nbsp;
                                            <?php }?>
                                            <?php if ( $habilitaBotaoDownEmail and $item['IND_STATUS']=='E' and $this->auth->CheckMenu('geral', 'materia', 'email')) { ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Enviar Matéria por Email" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float'
                                                   href="<?php echo base_url('materia/email/') . $item['SEQ_MATERIA'] ?>">
                                                    <i class="material-icons">email</i>
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
                            <th>Tipo</th>
                            <th>Nome do Veículo</th>
                            <th>Publicação</th>
                            <?php if ($this->session->userData('perfilUsuario')!='ROLE_REP') { ?>
                                <th>Área da Matéria</th>
                            <?php } ?>
                            <th>Ação</th>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="dataTables_paginate paging_simple_numbers pull-right">
                        <?php echo $pagination; ?>
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<script type="text/javascript">
    $(function () {
        $('.botao-excluir').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você excluirá esta matéria.',$(this));
            return false;
        });
        $('.botao-enviar').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você enviará esta matéria ao cliente.',$(this));
            return false;
        });
        $(".exec-pesquisa-select").change(function(){
            var texto = $('#texto').val();
            var sort = $('#sort').val();
            var order = $('#order').val();

            var setor = $('#setor').val();
            var tipo = $('#tipo').val();

            var per_page = $('#per_page').val();

            var url = '<?php echo base_url('pesquisa/consultar/')?>'+(texto.length>0?texto:'NA')+
                '/'+(setor.length>0?setor:'NA')+
                '/'+(tipo.length>0?tipo:'NA')+
                '/'+ sort+'/'+order+'/'+per_page;
            window.location.href = url;
        });
        $('.js-basic-example-demand').DataTable({
            responsive: true,
            paginate: false,
            info: false,
            filter: false,
            ordering: false,
            language: {
                "url": "assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
            }
        });

    });
</script>

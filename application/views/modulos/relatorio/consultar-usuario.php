<div class="block-header inline" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">person_add</i> Contagem por Usu&aacute;rio</h2>
        <small>Consulta de Usu&aacute;rios.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Contagem por Usu&aacute;rio</li>
        </ol>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">Filtro
            </div>
            <div class="body">
                <div class="row clearfix nopadding">
                    <?php echo form_open(base_url('relatorio/contadorUsuario'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='datair' name='datair' placeholder="selecione a data inicio..." value='<?php if (!empty($datair)) echo $datair;?>'>
                                    <label id="label-for" class="form-label">Data In&iacute;cio</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='horair' name='horair' placeholder="selecione a hora inicio..." value='<?php if (!empty($horair)) echo $horair;?>'>
                                    <label id="label-for" class="form-label">Hora In&iacute;cio</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='datafr' name='datafr' placeholder="selecione a data fim..." value='<?php if (!empty($datafr)) echo $datafr;?>'>
                                    <label id="label-for" class="form-label">Data Fim</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='horafr' name='horafr' placeholder="selecione a hora fim..." value='<?php if (!empty($horafr)) echo $horafr;?>'>
                                    <label id="label-for" class="form-label">Hora Fim</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-3 col-xl-3 hidden-print">
                            <button type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Aplicar Per&iacute;odo">
                                <i class="material-icons">filter_list</i>
                            </button>
                        </div>
                    </form>
                </div>
                <h4>RESUMO</h4>
                    <?php
                        if($this->session->userData('perfilUsuario')=='ROLE_ADM') {
                            $lista_usuarios = $this->ComumModelo->quantitativoUsuario($datair, $datafr,$horair,$horafr, NULL);
                        } else {
                            $lista_usuarios = $this->ComumModelo->quantitativoUsuario($datair, $datafr,$horair,$horafr, $this->session->userData('listaCliente'));
                        }

                     ?>

                                <table id="tabela-usuario" class="table table-bordered table-striped table-hover dataTable tb-usuario">
                            <thead>
                            <tr>
                                <th>Usu&aacute;rio</th>
                                <th>Impresso</th>
                                <th>Internet</th>
                                <th>R&aacute;dio</th>
                                <th>Televis&atilde;o</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $totalI=0;$totalS=0;$totalR=0;$totalG=0;$totalT=0;
                            if (!empty($lista_usuarios)) {
                                foreach ($lista_usuarios as $itemU):
                                    $menorMaior = $this->ComumModelo->menorMaiorUsuario($itemU['SEQ_USUARIO'],$datair, $datafr,$horair,$horafr, NULL);
                                    $totalI+=$itemU['IMPRESSO'];
                                    $totalS+=$itemU['INTERNET'];
                                    $totalR+=$itemU['RADIO'];
                                    $totalT+=$itemU['TELEVISAO'];
                                    $totalG+=$itemU['TOTAL'];
                                    ?>
                                        <td><?php echo $itemU['NOME_USUARIO']; ?><br/><small><i><?php  echo date('d/m/Y h:i',strtotime($menorMaior->MENOR_MAT)).' - '.date('d/m/Y H:i',strtotime($menorMaior->MAIOR_MAT)); ?></i></small></td>
                                        <td align="right"><a data-cliente="0" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="I" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['IMPRESSO']; ?></a></td>
                                        <td align="right"><a data-cliente="0" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="S" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['INTERNET']; ?></a></td>
                                        <td align="right"><a data-cliente="0" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="R" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['RADIO']; ?></a></td>
                                        <td align="right"><a data-cliente="0" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="T" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['TELEVISAO']; ?></a></td>
                                        <td align="right"><a data-cliente="0" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="Q" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['TOTAL']; ?></a></td>
                                    </tr>
                                <?php endforeach;
                            } ?>
                            </tbody>
                            <tfoot class="hidden-sm hidden-xs">
                            <tr>
                                <th>Total</th>
                                <th><div align="right"><?php echo number_format($totalI,0,',','.'); ?></div></th>
                                <th><div align="right"><?php echo number_format($totalS,0,',','.'); ?></div></th>
                                <th><div align="right"><?php echo number_format($totalR,0,',','.'); ?></div></th>
                                <th><div align="right"><?php echo number_format($totalT,0,',','.'); ?></div></th>
                                <th><div align="right"><?php echo number_format($totalG,0,',','.'); ?></div></th>
                            </tr>
                            </tfoot>
                        </table>
                <?php
                $clientes=array();
                if($this->session->userData('perfilUsuario')=='ROLE_ADM') {
                    $clientes = $this->ComumModelo->getClienteTodos()->result_array();
                }  else {
                    $clientes = $this->ComumModelo->getClientes($this->session->userData('listaCliente'))->result_array();
                }
                ?>
                <?php if (!empty($clientes) and count($clientes)>1) {
                        foreach ($clientes as $item): ?>
                    <h4><?php echo $item['NOME_CLIENTE'];

                        $lista_usuarios = $this->ComumModelo->quantitativoUsuario($datair,$datafr,$horair,$horafr,$item['SEQ_CLIENTE']);
                        ?></h4>
                                    <table id="tabela-usuario" class="table table-bordered table-striped table-hover dataTable tb-usuario">
                                <thead>
                                <tr>
                                    <th>Usu&aacute;rio</th>
                                    <th>Impresso</th>
                                    <th>Internet</th>
                                    <th>R&aacute;dio</th>
                                    <th>Televis&atilde;o</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $totalI=0;$totalS=0;$totalR=0;$totalG=0;$totalT=0;
                                    if (!empty($lista_usuarios)) {
                                    foreach ($lista_usuarios as $itemU):
                                        $totalI+=$itemU['IMPRESSO'];
                                        $totalS+=$itemU['INTERNET'];
                                        $totalR+=$itemU['RADIO'];
                                        $totalT+=$itemU['TELEVISAO'];
                                        $totalG+=$itemU['TOTAL'];
                                        ?>
                                        <tr>
                                            <td><?php echo $itemU['NOME_USUARIO']; ?></td>
                                            <td align="right"><a data-cliente="<?php echo $item['SEQ_CLIENTE']; ?>" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="I" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['IMPRESSO']; ?></a></td>
                                            <td align="right"><a data-cliente="<?php echo $item['SEQ_CLIENTE']; ?>" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="S" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['INTERNET']; ?></a></td>
                                            <td align="right"><a data-cliente="<?php echo $item['SEQ_CLIENTE']; ?>" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="R" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['RADIO']; ?></a></td>
                                            <td align="right"><a data-cliente="<?php echo $item['SEQ_CLIENTE']; ?>" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="T" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['TELEVISAO']; ?></a></td>
                                            <td align="right"><a data-cliente="<?php echo $item['SEQ_CLIENTE']; ?>" data-usuario="<?php echo $itemU['SEQ_USUARIO']; ?>" data-tipo="Q" data-datai="<?php echo $datair; ?>" data-dataf="<?php echo $datafr; ?>" data-horai="<?php echo $horair; ?>" data-horaf="<?php echo $horafr; ?>" href="javascript:void(0);" class="carrega-modal"><?php echo $itemU['TOTAL']; ?></a></td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                                </tbody>
                                <tfoot class="hidden-sm hidden-xs">
                                <tr>
                                    <th>Total</th>
                                    <th><div align="right"><?php echo number_format($totalI,0,',','.'); ?></div></th>
                                    <th><div align="right"><?php echo number_format($totalS,0,',','.'); ?></div></th>
                                    <th><div align="right"><?php echo number_format($totalR,0,',','.'); ?></div></th>
                                    <th><div align="right"><?php echo number_format($totalT,0,',','.'); ?></div></th>
                                    <th><div align="right"><?php echo number_format($totalG,0,',','.'); ?></div></th>
                                </tr>
                                </tfoot>
                            </table>
                <?php endforeach; } ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="materiaModalUser" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Fechar</button>
            </div>
            <div id="modal-body-content-user" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- #END# Body Copy -->
<script type="text/javascript">
    $(function () {
        $('#datafr').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#horafr').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: true,
            date:false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#horair').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: true,
            date:false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        })
        $('#datair').bootstrapMaterialDatePicker({
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
        $('.tb-usuario').DataTable({
            responsive: true,
            paginate: false,
            filter: false,
            info: false,
            language: {
                "url": "/monitor/assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
            }
        });
        $('.carrega-modal').click(function(){

            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: '/monitor/relatorio/contadorUsuarioDetalhe',
                type: 'POST',
                cache: false,
                data: {cliente:$(this).data('cliente'),usuario:$(this).data('usuario'),tipo:$(this).data('tipo'),datai:$(this).data('datai'),dataf:$(this).data('dataf'),horai:$(this).data('horai'),horaf:$(this).data('horaf'),'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (data) {
                    $('#modal-body-content-user').html(data);
                    $('#materiaModalUser').modal('show');

                },
                error: function (jqXHR, textStatus, errorThrown) {
//                    alert('Ocorreu Algum Problema, não foi possível alterar!');
                    console.log('msgAjax',errorThrown);
                },
                dataType: "text"
            });


        });
    });
</script>
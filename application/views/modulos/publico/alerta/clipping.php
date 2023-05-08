<style>
    .btn-small:hover {
        background-color: #1e88e5 !important;
    }
 
</style>
<body>
    <?php $this->load->view('modulos/publico/alerta/includes/menu'); ?>
    <main>
        <div class="container" style="margin-top: 2%">
            <div class="section">
                <?php echo form_open(base_url('clipping'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                <div class="row">
                    <div class="col s12 m4">
                        <div class="input-field" style="margin-top: 0rem;">
                            <input placeholder="<?= implode("/",array_reverse(explode("-",$dataInicio))) ?>" type="date" name="dataInicio" class="date" required="">
                            <label>Data Inicial</label>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field" style="margin-top: 0rem;">
                            <input placeholder="<?= implode("/",array_reverse(explode("-",$dataFim))) ?>" type="date" name="dataFim" class="date" required="">
                            <label>Data Final</label>
                        </div>
                    </div>
                    <div class="col s12 m4" style="margin-top: 1%">
                        <button class="waves-effect waves-light btn-small" type="submit" style="font-weight: bold; width: 100%">PESQUISAR</button>
                    </div>
                </div>
                <a class="waves-effect waves-light btn-small" id="back-to-top" style="width: 50px; font-weight: bold; border-radius:20px;"><i class="material-icons">arrow_upward</i></a>

                <?= form_close(); ?>
                <div class="row" style="margin-top: -1%; padding-bottom: 1%;">
                    <div class="col s12 m12"><i class="fas fa-calendar-alt"></i> Você está vendo alertas entre <?= implode("/",array_reverse(explode("-",$dataInicio))) ?> e <?= implode("/",array_reverse(explode("-",$dataFim))) ?></div>
                </div>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card grey lighten-5" style="border-radius: 15px;">
                            <div class="card-content">
                                <table class="table highlight js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Cliente/Tipo<br/>Tipo Mat&eacute;ria</th>
                                            <th>Data In&iacute;cio<br/>Data Fim</th>
                                            <th>Grupo<br/>Setor</th>
                                            <th>A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($lista_alertas)) {
                                            foreach ($lista_alertas as $item):
                                                $dataCliente = NULL;
                                                if (!empty($item['SEQ_CLIENTE']) and $item['SEQ_CLIENTE'] > 0) {
                                                    $dataCliente = $this->ComumModelo->getCliente($item['SEQ_CLIENTE'])->row();
                                                }
                                                $tipoMsg = ($item['TIPO_NOTIFICACAO'] == 'D') ? 'Dia: ' : 'Periodo: ';
                                                $dateMsg = ($item['TIPO_NOTIFICACAO'] == 'D') ? (date('d/m/Y', strtotime($item['DT_INICIO']))) : (date('d/m/Y', strtotime($item['DT_INICIO'])) . ' - ' . date('d/m/Y', strtotime($item['DT_FIM'])));
                                                $tipoMatMsg = ($item['TIPO_MATERIA'] == 'S') ? 'INTERNET' : (($item['TIPO_MATERIA'] == 'I') ? 'IMPRESSO' : (($item['TIPO_MATERIA'] == 'R') ? 'RADIO' : (($item['TIPO_MATERIA'] == 'T') ? 'TV' : 'TODAS AS PUBLICACOES')));
                                                $descSetor = NULL;
                                                if (!empty($item['LISTA_SETOR']) and $dataCliente->IND_ALERTA_SETOR) {
                                                    foreach (explode(',', $item['LISTA_SETOR']) as $codSet) {
                                                        $dataSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $codSet))->result_array();
                                                        foreach ($dataSetor as $set) {
                                                            $descSetor .= '*' . $set['DESC_SETOR'] . ' - ' . $set['SIG_SETOR'] . '*' . PHP_EOL;
                                                        }
                                                    }
                                                }
                                                $descCategoria = '';
                                                if (!empty($item['SEQ_CATEGORIA_SETOR']))
                                                    $descCategoria = $this->ComumModelo->getTableData('CATEGORIA_SETOR', array('SEQ_CATEGORIA' => $item['SEQ_CATEGORIA_SETOR']))->row()->DESC_CATEGORIA;

                                                $mensagem = '';




                                                if (!empty($item['LISTA_SETOR']) and ! empty($dataCliente) and $dataCliente->IND_ALERTA_SETOR) {
                                                    if ($item['SEQ_CLIENTE'] !== '55') {
                                                        $mensagem = ' *Alerta de Clipping*' . PHP_EOL . $descCategoria . PHP_EOL . strtoupper($descSetor) . PHP_EOL . $tipoMsg . $dateMsg . PHP_EOL . 'Link: ' . url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']) . $item['CHAVE_NOTIFICACAO'];
                                                    } else {
                                                        $link = str_replace('https://porto.am/i', 'http://clipping.digital/i', url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']));
                                                        $mensagem = ' Monitoramento de Mídia' . PHP_EOL . '*' . trim($dataCliente->EMPRESA_CLIENTE) . '*' . PHP_EOL . $descCategoria . PHP_EOL . $tipoMatMsg . PHP_EOL . $tipoMsg . $dateMsg . PHP_EOL . 'Link: ' . $link . $item['CHAVE_NOTIFICACAO'];
                                                        $mensagem = str_replace('IMPRESSO', json_decode('"\uD83D\uDCF0"') . ' JORNAIS IMPRESSOS', $mensagem);
                                                        $mensagem = str_replace('INTERNET', json_decode('"\uD83D\uDD18"') . ' WEB', $mensagem);
                                                        $mensagem = str_replace('RADIO', json_decode('"\uD83D\uDCFB"') . ' RÁDIO', $mensagem);
                                                        $mensagem = str_replace('TV', json_decode('"\uD83D\uDCFA"') . ' TELEVISÃO', $mensagem);
                                                    }
                                                } else if (!empty($dataCliente)) {
                                                    if ($item['SEQ_CLIENTE'] == 59 || $item['SEQ_CLIENTE'] == 55 || $item['SEQ_CLIENTE'] == 13) {
                                                        $mensagem = ' Monitoramento de Mídia' . PHP_EOL . '*' . trim($dataCliente->EMPRESA_CLIENTE) . '*' . PHP_EOL . $descCategoria . PHP_EOL . $tipoMatMsg . PHP_EOL . $tipoMsg . $dateMsg . PHP_EOL . 'Link: ' . url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']) . $item['CHAVE_NOTIFICACAO'];
                                                        $mensagem = str_replace('IMPRESSO', json_decode('"\uD83D\uDCF0"') . ' JORNAIS IMPRESSOS', $mensagem);
                                                        $mensagem = str_replace('INTERNET', json_decode('"\uD83D\uDD18"') . ' WEB', $mensagem);
                                                        $mensagem = str_replace('RADIO', json_decode('"\uD83D\uDCFB"') . ' RÁDIO', $mensagem);
                                                        $mensagem = str_replace('TV', json_decode('"\uD83D\uDCFA"') . ' TELEVISÃO', $mensagem);
                                                    } else {
                                                        $mensagem = ' *Alerta de Clipping*' . PHP_EOL . '*' . trim($dataCliente->EMPRESA_CLIENTE) . '*' . PHP_EOL . $descCategoria . PHP_EOL . $tipoMatMsg . PHP_EOL . $tipoMsg . $dateMsg . PHP_EOL . 'Link: ' . url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']) . $item['CHAVE_NOTIFICACAO'];
                                                    }
                                                }
                                                ?>

                                                <?php
                                                ?>    
                                                <tr>
                                                    <td><?php if (!empty($dataCliente) and $item['TIPO_NOTA'] == 'N')
                                            echo $dataCliente->EMPRESA_CLIENTE;
                                        else
                                            echo 'TERMAS DE INTERESSE';
                                                ?>
                                                        <br/>
                                                        <?php if ($item['TIPO_NOTIFICACAO'] == 'D')
                                                            echo 'Di&aacute;rio';
                                                        else if ($item['TIPO_NOTIFICACAO'] == 'P')
                                                            echo 'Per&iacute;odo';
                                                        ?>
                                                        /<?php
                                                        if ($item['TIPO_MATERIA'] == 'S')
                                                            echo 'Internet';
                                                        else if ($item['TIPO_MATERIA'] == 'I')
                                                            echo 'Impresso';
                                                        else if ($item['TIPO_MATERIA'] == 'R')
                                                            echo 'R&aacute;dio';
                                                        else if ($item['TIPO_MATERIA'] == 'T')
                                                            echo 'Televis&atilde;o';
                                                        else
                                                            echo 'Todas as Publica&ccedil;&otilde;es';
                                                        ?>
                                                        <?php
                                                        $descAval = array(
                                                            'P' => 'Positivo',
                                                            'N' => 'Negativo',
                                                            'T' => 'Neutro'
                                                        );
                                                        if (!empty($item['AVALIACAO_NOTA']))
                                                            echo ' - ' . $descAval[$item['AVALIACAO_NOTA']];
                                                        ?>
                                                        <br/>
                                                        <?php if (!empty($item['SEQ_CATEGORIA_SETOR'])) echo $this->ComumModelo->getTableData('CATEGORIA_SETOR', array('SEQ_CATEGORIA' => $item['SEQ_CATEGORIA_SETOR']))->row()->DESC_CATEGORIA; ?>

                                                    </td>
                                                    <td><?php echo date('d/m/Y', strtotime($item['DT_INICIO'])); ?><br/>
        <?php echo date('d/m/Y', strtotime($item['DT_FIM'])); ?></td>
                                                    <td><?php if (!empty($item['GRUPO_PORTAL'])) echo strtoupper($this->ComumModelo->getTableData('GRUPO_VEICULO', array('SEQ_GRUPO_VEICULO' => $item['GRUPO_PORTAL']))->row()->DESC_GRUPO_VEICULO); ?>
                                                        <br/><?php
        if (!empty($item['LISTA_SETOR'])) {
            foreach (explode(',', $item['LISTA_SETOR']) as $codSet) {
                $dataSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $codSet))->result_array();
                foreach ($dataSetor as $set) {
                    echo $set['DESC_SETOR'] . ' - ' . $set['SIG_SETOR'] . '<br/>';
                }
            }
        }
        ?>
                                                    </td>
                                                    <td  width="20%">
                                                        <div class='avoid-this action-buttons'>
                                                            <a data-toggle="tooltip" data-placement="top" title="Visualizar o Alerta"
                                                               class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                                               target="_blank" href="<?php
                                                       if ($item['SEQ_CLIENTE'] !== '55') {
                                                           $link = str_replace('https://porto.am/i?', base_url('alerta/'), url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']));
                                                           echo $link . $item['CHAVE_NOTIFICACAO'];
                                                           
                                                       } else {
                                                           $link = str_replace('https://porto.am/i', 'http://clipping.digital/i', url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']));
                                                           echo $link . $item['CHAVE_NOTIFICACAO'];
                                                       }
        ?>">
                                                                <i class="material-icons">remove_red_eye</i>
                                                            </a>
                                                            <a data-toggle="tooltip" data-placement="top" title="Compartilhar Whatsapp" class='btn bg-blue btn-circle waves-effect waves-circle waves-float hidden-xl hidden-lg'
                                                               href="whatsapp://send?text=%E2%8F%B0+<?php echo urlencode($mensagem); ?>">
                                                                <i class="material-icons">share</i>
                                                            </a>
                                                            <a data-toggle="tooltip" data-placement="top" title="Copiar para &Aacute;rea de tranfer&ecirc;ncia" class='btn bg-blue btn-circle waves-effect waves-circle waves-float copiar hidden-sm hidden-md'
                                                               data-alerta="
                                                                <?php
                                                                if ($item['SEQ_CLIENTE'] == 59 || $item['SEQ_CLIENTE'] == 55 || $item['SEQ_CLIENTE'] == 13) {
                                                                    echo json_decode('"\uD83D\uDD50"') . ' ' . urlencode($mensagem);
                                                                } else {
                                                                    echo json_decode('"\u23F0"') . ' ' . urlencode($mensagem);
                                                                }
                                                                ?>" href="javascript:void(0);">
                                                                <i class="material-icons">content_copy</i>
                                                            </a>
                                                            <a data-toggle="tooltip" target="_blank" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                                               href="<?php echo base_url('notificacao/editar/') . $item['SEQ_NOTIFICACAO'] ?>">
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                            <a data-toggle="tooltip" data-placement="top" title="Excluir" class='btn bg-blue btn-circle waves-effect waves-circle waves-float botao-excluir'
                                                               href="<?php echo base_url('sistema/Clipping/excluir/') . $item['SEQ_NOTIFICACAO'] ?>">
                                                                <i class="material-icons">delete</i>
                                                            </a>
                                                            
                                                            <?= form_open(base_url('sistema/Clipping/clipping_detalhes'),array('role' => 'form', 'id' => 'formPadrao2','class'=>'Formulario')); ?>
                                                            <button type="submit" style="margin-top: 1%;" data-toggle="tooltip" data-chave="<?= $item['CHAVE_NOTIFICACAO'] ?>" data-placement="top" title="Informações do Alerta" class='btn bg-blue btn-circle waves-effect waves-circle waves-float btn-clipping-detalhes'>
                                                                <i class="material-icons">info</i>
                                                            </button>
                                                            <input type="hidden" name="wpp" value="<?= $mensagem ?>"/>
                                                            <input type="hidden" name="chave" value="<?= $item['CHAVE_NOTIFICACAO'] ?>"/>
                                                            <?= form_close() ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                endforeach;
                                            }
                                            ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card grey lighten-5" style="border-radius: 15px;">
                            <div class="card-content">
                                <h4>Alertas Agrupados</h4>
                                <span>Somente Alertas com Categorias de Setor</span>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable2">
                    <thead>
                    <tr>
                        <th>Cliente/Tipo<br/>Tipo Mat&eacute;ria</th>
                        <th>Data In&iacute;cio<br/>Data Fim</th>
                        <th>A&ccedil;&atilde;o</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($lista_alertas_agg)) {
                        foreach ($lista_alertas_agg as $item):
                            $dataCliente=NULL;
                            if (!empty($item['SEQ_CLIENTE']) and $item['SEQ_CLIENTE']>0){
                                $dataCliente = $this->ComumModelo->getCliente($item['SEQ_CLIENTE'])->row();
                            }
                            $tipoMsg = ($item['TIPO_NOTIFICACAO']=='D')?'Dia: ':'Periodo: ';
                            $dateMsg = ($item['TIPO_NOTIFICACAO']=='D')?(date('d/m/Y',strtotime($item['DT_INICIO']))):(date('d/m/Y',strtotime($item['DT_INICIO'])).' - '.date('d/m/Y',strtotime($item['DT_FIM'])));
                            $tipoMatMsg = ($item['TIPO_MATERIA']=='S')?'INTERNET':(($item['TIPO_MATERIA']=='I')?'IMPRESSO':(($item['TIPO_MATERIA']=='R')?'RADIO':(($item['TIPO_MATERIA']=='T')?'TV':'TODAS AS PUBLICACOES' ) ) );
                            $descSetor=NULL;
                            $descSetorHtml=NULL;
                            if(!empty($item['LISTA_SETOR']) and count(explode(',',$item['LISTA_SETOR']))>1) {
//                                $descSetor = 'Diversos Setores-'.$item['LISTA_SETOR'];
                                foreach(explode(',',$item['LISTA_SETOR']) as $codSet) {
                                    $dataSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $codSet))->result_array();
                                    foreach ($dataSetor as $set) {
                                        $descSetor .= $set['DESC_SETOR'] . ' - ' . $set['SIG_SETOR'] . PHP_EOL;
                                        $descSetorHtml .= $set['DESC_SETOR'] . ' - ' . $set['SIG_SETOR'] . '<br/>';
                                    }
                                }
                            } else if(!empty($item['LISTA_SETOR']) and $item['LISTA_SETOR']>0) {
                                $dataSetor =$this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $item['LISTA_SETOR']))->row();
                                $descSetor = $dataSetor->DESC_SETOR.' - '.$dataSetor->SIG_SETOR;
                                $descSetorHtml = $dataSetor->DESC_SETOR.' - '.$dataSetor->SIG_SETOR;

                            }
                            $descCategoria ='';
                            if(!empty($item['SEQ_CATEGORIA_SETOR']) and $item['SEQ_CATEGORIA_SETOR']>0)
                                $descCategoria=$this->ComumModelo->getTableData('CATEGORIA_SETOR',array('SEQ_CATEGORIA'=>$item['SEQ_CATEGORIA_SETOR']))->row()->DESC_CATEGORIA;

                            $mensagem='';


                          //  if(!empty($item['LISTA_SETOR']))
                        //        $mensagem = ' *Alerta de Clipping*'.PHP_EOL.$descCategoria.PHP_EOL.'*'.strtoupper($descSetor).'*'.PHP_EOL.$tipoMsg.$dateMsg.PHP_EOL.'Link: '.url_alerta($item['SEQ_CLIENTE']).$item['CHAVE_NOTIFICACAO'];
                         //   else if (!empty($dataCliente))

                            $link = str_replace("@", PHP_EOL, $item['LINK']);

//                             if ($item['SEQ_CLIENTE'] ==59 or $item['SEQ_CLIENTE'] ==60){
//                                 $link = str_replace('https://porto.am/i','http://eleicoesnews.com.br/i',$link);
//                             }
        if ($item['SEQ_CLIENTE'] == 59  || $item['SEQ_CLIENTE'] == 55 || $item['SEQ_CLIENTE'] == 13) {
            $link = str_replace('https://porto.am/i', 'http://clipping.digital/i', $link);
            $mensagem = ' Monitoramento de Mídia' . PHP_EOL . '*' . (($item['CONSULTA'] == '3') ? 'ÁREAS DE INTERESSE' : trim($dataCliente->EMPRESA_CLIENTE)) . '*' . PHP_EOL . $descSetor . PHP_EOL . $descCategoria . $tipoMsg . $dateMsg . $link;
            $mensagem = str_replace('*IMPRESSO*', json_decode('"\uD83D\uDCF0"').' JORNAIS IMPRESSOS', $mensagem);
            $mensagem = str_replace('*INTERNET*', json_decode('"\uD83D\uDD18"').' WEB', $mensagem);
            $mensagem = str_replace('*RADIO*', json_decode('"\uD83D\uDCFB"').' RÁDIO', $mensagem);
            $mensagem = str_replace('*TV*', json_decode('"\uD83D\uDCFA"').' TELEVISÃO', $mensagem);
            
        } else {
            $mensagem = ' *Alerta de Clipping*' . PHP_EOL . '*' . (($item['CONSULTA'] == '3') ? 'TEMAS DE INTERESSE' : trim($dataCliente->EMPRESA_CLIENTE)) . '*' . PHP_EOL . $descSetor . PHP_EOL . $descCategoria . $tipoMsg . $dateMsg . $link;
        }
?>
                            <tr>
                                <td><?php echo $item['EMPRESA_CLIENTE'] ?>
                                    <br/>
                                    <?php echo $descSetorHtml; ?>

                                    <?php if($item['TIPO_NOTIFICACAO']=='D') echo 'Di&aacute;rio'; else if ($item['TIPO_NOTIFICACAO']=='P') echo 'Per&iacute;odo'; ?><?php if ($item['CONSULTA']=='1') { if($item['TIPO_MATERIA']=='S') echo '/Internet'; else if($item['TIPO_MATERIA']=='I') echo '/Impresso'; else if($item['TIPO_MATERIA']=='R') echo '/R&aacute;dio'; else if($item['TIPO_MATERIA']=='T') echo '/Televis&atilde;o'; else echo '/Todas as Publica&ccedil;&otilde;es';}  ?>
                                    <?php
                                    $descAval =array(
                                        'P'=>'Positivo',
                                        'N'=>'Negativo',
                                        'T'=>'Neutro'
                                    );
                                    if(!empty($item['AVALIACAO_NOTA'])) echo ' - '.$descAval[$item['AVALIACAO_NOTA']]; ?>
                                    <br/>
                                    <?php if(!empty($item['SEQ_CATEGORIA_SETOR'])) echo $this->ComumModelo->getTableData('CATEGORIA_SETOR',array('SEQ_CATEGORIA'=>$item['SEQ_CATEGORIA_SETOR']))->row()->DESC_CATEGORIA; ?>

                                </td>
                                <td ><?php echo date('d/m/Y',strtotime($item['DT_INICIO'])); ?><br/>
                                    <?php echo date('d/m/Y',strtotime($item['DT_FIM'])); ?></td>
                                <td  width="20%">
                                    <div class='avoid-this action-buttons'>
                                        <a data-toggle="tooltip" data-placement="top" title="Compartilhar Whatsapp" class='btn bg-blue btn-circle waves-effect waves-circle waves-float hidden-xl hidden-lg'
                                           href="whatsapp://send?text=%E2%8F%B0+<?php echo urlencode($mensagem); ?>">
                                            <i class="material-icons">share</i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="top" title="Copiar para &Aacute;rea de tranfer&ecirc;ncia" class='btn bg-blue btn-circle waves-effect waves-circle waves-float copiar hidden-sm hidden-md'
                                           data-alerta="<?php if ($item['SEQ_CLIENTE'] == 59) {
                                           echo json_decode('"\uD83D\uDD50"').' '.urlencode($mensagem); 
                                           } else {
                                           echo json_decode('"\u23F0"').' '.urlencode($mensagem); 
                                           }?>" href="javascript:void(0);">
                                            <i class="material-icons">content_copy</i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                    } ?>
                    </tbody>
                    <tfoot class="hidden-sm hidden-xs">
                    <tr>
                        <th>Cliente/Tipo<br/>Tipo Mat&eacute;ria</th>
                        <th>Data In&iacute;cio<br/>Data Fim</th>
                        <th>A&ccedil;&atilde;o</th>
                    </tr>
                    </tfoot>
                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <textarea id="alerta" class="textarea" style="width: 0px;height: 0px;resize: none;"></textarea>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <?php echo $this->session->flashdata('flash_message');?>
    <script type="text/javascript">
    $(function () {
        var btn = document.querySelector("#back-to-top");
            btn.addEventListener("click", function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        $('.sidenav').sidenav();
        $('.dropdown-trigger').dropdown();
        $('.js-basic-example').DataTable({
       
        dom:
        "<'ui two column grid'<'left aligned column'l><'right aligned column'f>>" +
        "<'ui grid'<'column'tr>>" +
        "<'ui two column grid'<'aligned column'i><'aligned column'p>>",
        responsive: true,
        paginate: true,
        language: {
            "url": "/monitor/assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
        }
        });
        $('#formPadrao2').submit(function (e) {
            e.preventDefault();
            var chave = $(this).data('chave');
            $.ajax({
                data: $('#formPadrao2').serialize(),
                type: "POST",
                dataType: "json",
                url: '<?= base_url('sistema/Clipping/clipping_detalhes/') ?>',
                success: function (data) {
                    
                }
            });
        });
        
        $('.copiar').click(function(event) {
            $("#alerta").text(decodeURIComponent($(this).data('alerta').replace(/\+/g, ' ')));
            var copyTextarea = document.querySelector('.textarea');
            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                if(successful)
                alertify.set('notifier','position', 'bottom-center');
                alertify.success('ALERTA COPIADO <i class="fas fa-check-circle"></i>'); 
            } catch (err) {
                alertify.set('notifier','position', 'bottom-center');
                alertify.error('NÃO FOI POSSÍVEL COPIAR O ALERTA <i class="fas fa-info-circle"></i>'); 
            }
        });
        $('.botao-excluir').click(function(){
            console.log($(this));
            Swal.fire({
                title: 'Você quer realmente excluir esse alerta?',
                showDenyButton: true,
                confirmButtonText: 'Sim',
                denyButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).attr('href');
                }
            })
            return false;
        });

    });
</script>
    <footer class="page-footer">
        <div class="container">
            © <?= date('Y') ?> Copyright - Porto Monitor
        </div>
    </footer>
</body>
</html> 
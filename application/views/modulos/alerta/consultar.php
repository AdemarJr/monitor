
<div class="block-header inline" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">alarm</i> Alertas</h2>
        <small>Consulta de Alertas.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Alertas</li>
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
                    <?php echo form_open(base_url('notificacao'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <input type='hidden' id='acao' name='acao'/>
                    <div class="col-xs-12 col-md-3 col-xl-3">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" class="datepicker form-control" id='dataFiltro' name='dataFiltro' value='<?php if (!empty($dataFiltro)) echo $dataFiltro;?>'>
                                <label id="label-for" class="form-label">Data do Alerta</label>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                    <tr>
                        <th>Cliente/Tipo<br/>Tipo Mat&eacute;ria</th>
                        <th>Data In&iacute;cio<br/>Data Fim</th>
                        <th>Grupo<br/>Setor</th>
                        <th>A&ccedil;&atilde;o</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($lista_alertas)) {
                    foreach ($lista_alertas as $item):
                    $dataCliente = NULL;
                    if (!empty($item['SEQ_CLIENTE']) and $item['SEQ_CLIENTE'] > 0) {
                        $dataCliente = $this->ComumModelo->getCliente($item['SEQ_CLIENTE'])->row();
                    }
                    $descAval = array(
                                'P' => 'Positivas',
                                'N' => 'Negativas',
                                'T' => 'Neutras'
                    );
                    $tipoMsg = ($item['TIPO_NOTIFICACAO'] == 'D') ? 'Dia: ' : 'Periodo: ';
                    $dateMsg = ($item['TIPO_NOTIFICACAO'] == 'D') ? (date('d/m/Y', strtotime($item['DT_INICIO']))) : (date('d/m/Y', strtotime($item['DT_INICIO'])) . ' - ' . date('d/m/Y', strtotime($item['DT_FIM'])));
                    $tipoMatMsg = ($item['TIPO_MATERIA'] == 'S') ? 'INTERNET' : (($item['TIPO_MATERIA'] == 'I') ? 'IMPRESSO' : (($item['TIPO_MATERIA'] == 'R') ? 'RADIO' : (($item['TIPO_MATERIA'] == 'T') ? 'TV' : 'TODAS AS PUBLICACOES')));
                    $descSetor = NULL;
                    if (!empty($item['LISTA_SETOR']) and @$dataCliente->IND_ALERTA_SETOR) {
//                        $descSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $item['LISTA_SETOR']))->row()->DESC_SETOR;
                        foreach(explode(',',$item['LISTA_SETOR']) as $codSet) {
                            $dataSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $codSet))->result_array();
                            foreach ($dataSetor as $set) {
                                $descSetor .= '*'.$set['DESC_SETOR'] . ' - ' . $set['SIG_SETOR'] .'*'. PHP_EOL;
                            }
                        }
                    }
                    
                    if ($item['SEQ_CLIENTE'] == 1 && empty($item['LISTA_SETOR'])) {
                        if (!empty($item['GRUPO_PORTAL'])) {
                            $descSetor = $this->ComumModelo->getTableData('GRUPO_VEICULO', array('SEQ_GRUPO_VEICULO' => $item['GRUPO_PORTAL']))->row()->DESC_GRUPO_VEICULO;
                        } 
                    }
                    
                    $descCategoria = '';
                    if (!empty($item['SEQ_CATEGORIA_SETOR']))
                        $descCategoria = $this->ComumModelo->getTableData('CATEGORIA_SETOR', array('SEQ_CATEGORIA' => $item['SEQ_CATEGORIA_SETOR']))->row()->DESC_CATEGORIA;

                    $mensagem = '';

                     if ($item['SEQ_CLIENTE'] == 1 && empty($item['LISTA_SETOR']) && !empty($item['AVALIACAO_NOTA'])) {
                         $tipoMatMsg = '*'.$descAval[$item['AVALIACAO_NOTA']].'*';
                     }
                    
                     if ($item['SEQ_CLIENTE'] == 18 && empty($descCategoria) && !empty($item['LISTA_SETOR'])) {
                        $descCategoria = '*'.trim($dataCliente->NOME_CLIENTE).'*'.PHP_EOL;
                     }
                    if (!empty($item['LISTA_SETOR']) and ! empty($dataCliente) and $dataCliente->IND_ALERTA_SETOR) {
                                    if ($item['SEQ_CLIENTE'] !== '55') {
                                      $mensagem = ' *Alerta de Clipping*' . PHP_EOL . $descCategoria . PHP_EOL . mb_strtoupper($descSetor) . PHP_EOL . $tipoMsg . $dateMsg . PHP_EOL . 'Link: ' . url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']) . $item['CHAVE_NOTIFICACAO'];        
                                    } else {
                                      $link = str_replace('https://porto.am/i', 'http://clipping.digital/i', url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']));  
                                      $mensagem = ' Monitoramento de Mídia' . PHP_EOL . '*' . trim($dataCliente->EMPRESA_CLIENTE) . '*' . PHP_EOL . $descCategoria . PHP_EOL . $tipoMatMsg . PHP_EOL . $tipoMsg . $dateMsg . PHP_EOL . 'Link: ' . $link . $item['CHAVE_NOTIFICACAO'];                                        
                                      $mensagem = str_replace('IMPRESSO', json_decode('"\uD83D\uDCF0"').' JORNAIS IMPRESSOS', $mensagem);
                                      $mensagem = str_replace('INTERNET', json_decode('"\uD83D\uDD18"').' WEB', $mensagem);
                                      $mensagem = str_replace('RADIO', json_decode('"\uD83D\uDCFB"').' RÁDIO', $mensagem);
                                      $mensagem = str_replace('TV', json_decode('"\uD83D\uDCFA"').' TELEVISÃO', $mensagem);
                                    }
                                } else if (!empty($dataCliente)) {
                                    if ($item['SEQ_CLIENTE'] == 59 || $item['SEQ_CLIENTE'] == 55 || $item['SEQ_CLIENTE'] == 13) {
                                        $mensagem = ' Monitoramento de Mídia' . PHP_EOL . '*' . trim($dataCliente->EMPRESA_CLIENTE) . '*' . PHP_EOL . $descCategoria . PHP_EOL . $tipoMatMsg . PHP_EOL . $tipoMsg . $dateMsg . PHP_EOL . 'Link: ' . url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']) . $item['CHAVE_NOTIFICACAO'];                                        
                                        $mensagem = str_replace('IMPRESSO', json_decode('"\uD83D\uDCF0"').' JORNAIS IMPRESSOS', $mensagem);
                                        $mensagem = str_replace('INTERNET', json_decode('"\uD83D\uDD18"').' WEB', $mensagem);
                                        $mensagem = str_replace('RADIO', json_decode('"\uD83D\uDCFB"').' RÁDIO', $mensagem);
                                        $mensagem = str_replace('TV', json_decode('"\uD83D\uDCFA"').' TELEVISÃO', $mensagem);
                                        
                                    } else {
                                        $mensagem = ' *Alerta de Clipping*' . PHP_EOL . '*' . trim($dataCliente->EMPRESA_CLIENTE) . '*' . PHP_EOL . $descCategoria . PHP_EOL . strtoupper($descSetor) . PHP_EOL . $tipoMatMsg . PHP_EOL . $tipoMsg . $dateMsg . PHP_EOL . 'Link: ' . url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']) . $item['CHAVE_NOTIFICACAO'];
                                    }
                                }
                                ?>
                    
                    <?php 
                    
                    ?>    
                    <tr>
                        <td><?php
                            if (!empty($dataCliente) and $item['TIPO_NOTA'] == 'N') echo $dataCliente->EMPRESA_CLIENTE; else echo 'TERMAS DE INTERESSE'; ?>
                            <br/>
                            <?php if ($item['TIPO_NOTIFICACAO'] == 'D') echo 'Di&aacute;rio'; else if ($item['TIPO_NOTIFICACAO'] == 'P') echo 'Per&iacute;odo'; ?>
                            /<?php if ($item['TIPO_MATERIA'] == 'S') echo 'Internet'; else if ($item['TIPO_MATERIA'] == 'I') echo 'Impresso'; else if ($item['TIPO_MATERIA'] == 'R') echo 'R&aacute;dio'; else if ($item['TIPO_MATERIA'] == 'T') echo 'Televis&atilde;o'; else echo 'Todas as Publica&ccedil;&otilde;es'; ?>
                            <?php
                            $descAval = array(
                                'P' => 'Positivo',
                                'N' => 'Negativo',
                                'T' => 'Neutro'
                            );
                            if (!empty($item['AVALIACAO_NOTA'])) echo ' - ' . $descAval[$item['AVALIACAO_NOTA']]; ?>
                            <br/>
                            <?php if (!empty($item['SEQ_CATEGORIA_SETOR'])) echo $this->ComumModelo->getTableData('CATEGORIA_SETOR', array('SEQ_CATEGORIA' => $item['SEQ_CATEGORIA_SETOR']))->row()->DESC_CATEGORIA; ?>

                        </td>
                        <td><?php echo date('d/m/Y', strtotime($item['DT_INICIO'])); ?><br/>
                            <?php echo date('d/m/Y', strtotime($item['DT_FIM'])); ?></td>
                        <td><?php if (!empty($item['GRUPO_PORTAL'])) echo strtoupper($this->ComumModelo->getTableData('GRUPO_VEICULO', array('SEQ_GRUPO_VEICULO' => $item['GRUPO_PORTAL']))->row()->DESC_GRUPO_VEICULO); ?>
                            <br/><?php if (!empty($item['LISTA_SETOR'])) {
                                    foreach(explode(',',$item['LISTA_SETOR']) as $codSet) {
                                        $dataSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $codSet))->result_array();
                                        foreach ($dataSetor as $set) {
                                            echo $set['DESC_SETOR'] . ' - ' . $set['SIG_SETOR'] . '<br/>';
                                        }
                                    }
                                   } ?>
                                </td>
                                <td  width="20%">
                                    <div class='avoid-this action-buttons'>
                                        <a data-toggle="tooltip" data-placement="top" title="Visualizar o Alerta"
                                           class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                           target="_blank" href="<?php 
                                           if ($item['SEQ_CLIENTE'] !== '55') {
                                               if ($item['SEQ_CLIENTE'] == 11  || $item['SEQ_CLIENTE'] == 37 || $item['SEQ_CLIENTE'] == 60 || $item['SEQ_CLIENTE'] == 53) {
                                                 echo url_alerta($item['SEQ_CLIENTE'],$item['LISTA_SETOR']).$item['CHAVE_NOTIFICACAO'].'/'.$_SESSION['idUsuario'];  
                                               } else {  
                                                 echo url_alerta($item['SEQ_CLIENTE'],$item['LISTA_SETOR']).$item['CHAVE_NOTIFICACAO'];  
                                               }
                                               
                                           } else {
                                           $link = str_replace('https://porto.am/i', 'http://clipping.digital/i', url_alerta($item['SEQ_CLIENTE'], $item['LISTA_SETOR']));      
                                           echo $link.$item['CHAVE_NOTIFICACAO'];    
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
                                           echo json_decode('"\uD83D\uDD50"').' '.urlencode($mensagem); 
                                           } else {
                                             if ($item['SEQ_CLIENTE'] == 11  || $item['SEQ_CLIENTE'] == 37 || $item['SEQ_CLIENTE'] == 60 || $item['SEQ_CLIENTE'] == 63 || $item['SEQ_CLIENTE'] == 53) {
                                               $msg = json_decode('"\u23F0"').' '.urlencode($mensagem);
                                               $mvp = str_replace('http://clippingeleicoes.com.br/monitor/x/', 'http://clippingeleicoes.com.br/i?', $mensagem);
                                               echo json_decode('"\u23F0"').' '.urlencode($mvp);   
                                             } else {
                                               echo json_decode('"\u23F0"').' '.urlencode($mensagem);   
                                             }  
                                           
                                           }
                                           ?>" href="javascript:void(0);">
                                            <i class="material-icons">content_copy</i>
                                        </a>
                                        <?php if ($this->auth->CheckMenu('geral', 'notificacao', 'editar') == 1) { ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                               href="<?php echo base_url('notificacao/editar/') . $item['SEQ_NOTIFICACAO'] ?>">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        <?php }?>
                                        <?php if ($this->auth->CheckMenu('geral', 'notificacao', 'excluir') == 1) { ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Excluir" class='btn bg-blue btn-circle waves-effect waves-circle waves-float botao-excluir'
                                               href="<?php echo base_url('notificacao/excluir/') . $item['SEQ_NOTIFICACAO'] ?>">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        <?php }?>
                                        <a data-toggle="tooltip" data-placement="top" title="PDF do Alerta" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                               href="<?php echo base_url('sistema/clipping/clipping_pdf/') . $item['CHAVE_NOTIFICACAO'] ?>" target="_blank">
                                                <i class="material-icons">picture_as_pdf</i>
                                        </a>
                                        <?= form_open(base_url('sistema/Clipping/clipping_detalhes'),array('role' => 'form', 'id' => 'formPadrao2','class'=>'Formulario', 'target' => '_blank')); ?>
                                                            <button type="submit" style="margin-top: 1%;" data-toggle="tooltip" data-chave="<?= $item['CHAVE_NOTIFICACAO'] ?>" data-placement="top" title="Informações do Alerta" class='btn bg-blue btn-circle waves-effect waves-circle waves-float btn-clipping-detalhes'>
                                                                <i class="material-icons">info</i>
                                                            </button>
                                                            <input type="hidden" name="wpp" value="<?= $mensagem ?>"/>
                                                            <input type="hidden" name="chave" value="<?= $item['CHAVE_NOTIFICACAO'] ?>"/>
                                        <?= form_close() ?>
                                        
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
                        <th>Grupo<br/>Setor</th>
                        <th>A&ccedil;&atilde;o</th>
                    </tr>
                    </tfoot>
                </table>
                <h3>Alertas Agrupados</h3>
                <small>Somente Alertas com Categorias de Setor</small>
                <br/>
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
                            if ($item['SEQ_CLIENTE'] == 11  || $item['SEQ_CLIENTE'] == 37 || $item['SEQ_CLIENTE'] == 60 || $item['SEQ_CLIENTE'] == 63 || $item['SEQ_CLIENTE'] == 53) {
                            $link = str_replace('https://porto.am/i', 'http://clippingeleicoes.com.br/i', $link);    
                            }
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
                                           if ($item['SEQ_CLIENTE'] == 1 || $item['SEQ_CLIENTE'] == 18 || $item['SEQ_CLIENTE'] == 67 || $item['SEQ_CLIENTE'] == 11 || $item['SEQ_CLIENTE'] == 37) {
                                               
                                               //$mensagem = $controle->arrumatexto($mensagem, $item['SEQ_CLIENTE'], $item);
                                           }   
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
                        <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Ir para In&iacute;cio">
                            <i class="material-icons">home</i>
                        </a>
                        <a href="<?php echo base_url('notificacao') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Atualizar esta tela">
                            <i class="material-icons">refresh</i>
                        </a>
                        <a href="<?php echo base_url('notificacao/novo') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Nova Alerta">
                            <i class="material-icons">add</i>
                        </a>
                </div>
                <textarea id="alerta" class="textarea" style="width: 0px;height: 0px;resize: none;"></textarea>
            </div>
        </div>
    </div>
</div>
<!-- #END# Body Copy -->
<script type="text/javascript">


    $(function () {
        $('#dataFiltro').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        }).on('change', function(e, date)
        {
            $('#formPadrao').submit();
        });
        $('.copiar').click(function(event) {
//            $("#alerta").text($(this).data('alerta'));
            $("#alerta").text(decodeURIComponent($(this).data('alerta').replace(/\+/g, ' ')));
            var copyTextarea = document.querySelector('.textarea');
            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                if(successful)
                showNotification('alert-success', 'Alerta Copiado!', 'bottom', 'center', 'animated fadeInUp', '');
            } catch (err) {
                showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
            }
        });
        $('.botao-excluir').click(function(){
            showConfirmMessage('Voce tem certeza?','Confirmando voce excluire este alerta.',$(this));
            return false;
        });

    });
</script>
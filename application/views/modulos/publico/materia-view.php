<?php
        $anexos = $this->ComumModelo->listaAnexo($idMateria);
      if (count($anexos)>0) {
          $total = count($anexos);
          $atual = 1;
          $controle = 0;
          $flagPlay='S';
          foreach ($anexos as $item):
              $atual++;
              $controle++;
              if($controle ==1){
              ?>
              <div class="row clearfix tags-v">
                  <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                      <div class="col-xs-12 col-md-12 col-xl-12">
                          <?php
                          $chaves = array();
                          if (!empty($palavras))
                              $chaves = explode(',',$palavras);
                          foreach ($chaves as $valor){ ?>
                              <span class="badge bg-pink"><?php echo strtoupper($valor); ?></span>
                          <?php  } ?>

                      </div>
                  </div>
              </div>
              <?php } if ($tipoMateria == 'S') { ?>
                <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                      <div class="col-xs-12 col-md-12 col-xl-12">
                          <a class="btn bg-teal pull-right" href="<?php if (!empty($link)) echo $link; ?>" target="_blank">
                              <small >Mat&eacute;ria na &Iacute;ntegra</small>
                          </a>
                      </div>
                  </div>
                </div>
              <?php } ?>
              <?php if ($tipoMateria == 'S' or $tipoMateria == 'I') { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                          <td align="center" colspan="2"
                              style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                              <?php if(!empty($item['SEQ_ANEXO'])) { ?>
                                  <img class="img-responsive"
                                       src="<?php echo base_url($this->uri->segment(1).'/imagem/'.$item['SEQ_ANEXO']); ?>"/>
                              <?php } else { ?>
                                  <div class="col-xs-12 col-md-12 col-xl-12 text-center">
                                      Nao possui Imagem
                                  </div>
                              <?php } ?>
                          </td>
                      </tr>
                  </table>
              <?php } ?>
              <?php if ($tipoMateria == 'R') { ?>
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                      <td align="center" colspan="2"
                          style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                          <?php

                          if ($this->ComumModelo->existeAnexo($item['SEQ_ANEXO'])) { ?>
                          <audio id="audioMusica" controls <?php if ($flagPlay=='S') { echo 'autoplay '; $flagPlay ='N';} ?>
                                 preload="auto">
                              <source src="<?php echo base_url('materia/audio/').$item['SEQ_ANEXO'] ?>" type="audio/mpeg">
                              <p>Seu navegador n�o suporta o elemento audio </p>
                          </audio><br/>
                          <?php } else { ?>
                              <p>Sem M&iacute;dia para reprodu&ccedil;&atilde;o </p>
                          <?php } ?>
                      </td>
                  </tr>
                  <tr>
                      <td align="center" colspan="2"
                          style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                          <?php if ($this->ComumModelo->existeAnexo($item['SEQ_ANEXO'])) {
                              $dadosMateria = $this->ComumModelo->getMateria($item['SEQ_MATERIA'])->row();
//                              $mensagem = $dadosMateria->TIT_MATERIA.PHP_EOL.'Link: '.url_materia_simples().$dadosMateria->CHAVE;
                              if ($dadosMateria->TIPO_MATERIA  == 'I' and !empty($dadosMateria->SEQ_VEICULO))
                                  $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $dadosMateria->SEQ_VEICULO))->row();
                              else if ($dadosMateria->TIPO_MATERIA  == 'S' and !empty($dadosMateria->SEQ_PORTAL))
                                  $dadoVeiculo = $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $dadosMateria->SEQ_PORTAL))->row();
                              else if ($dadosMateria->TIPO_MATERIA  == 'R' and !empty($dadosMateria->SEQ_RADIO))
                                  $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $dadosMateria->SEQ_RADIO))->row();
                              else if ($dadosMateria->TIPO_MATERIA  == 'T' and !empty($dadosMateria->SEQ_TV))
                                  $dadoVeiculo = $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $dadosMateria->SEQ_TV))->row();

                              if ($dadosMateria->TIPO_MATERIA == 'I' and !empty($dadosMateria->SEQ_VEICULO)) {
                                  $mensagem = $dadoVeiculo->FANTASIA_VEICULO . PHP_EOL . $dadosMateria->TIT_MATERIA . PHP_EOL . 'Link: ' . url_materia_simples($cliente) . $dadosMateria->CHAVE.PHP_EOL. $dadosMateria->DIA;
                              } else if ($dadosMateria->TIPO_MATERIA == 'S' and !empty($dadosMateria->SEQ_PORTAL)) {
                                  $mensagem = $dadoVeiculo->FANTASIA_NOME_PORTAL . PHP_EOL . $dadosMateria->TIT_MATERIA . PHP_EOL . 'Link: ' . url_materia_simples($cliente) . $dadosMateria->CHAVE.PHP_EOL. $dadosMateria->DIA;
                              } else if ($dadosMateria->TIPO_MATERIA == 'R' and !empty($dadosMateria->SEQ_RADIO)){
                                  $mensagem = $dadoVeiculo->NOME_RADIO.PHP_EOL.$dadosMateria->PROGRAMA_MATERIA.PHP_EOL.$dadosMateria->TIT_MATERIA.PHP_EOL.'Link: '.url_materia_simples($cliente).$dadosMateria->CHAVE.PHP_EOL. $dadosMateria->DIA;
                              } else if ($dadosMateria->TIPO_MATERIA == 'T' and !empty($dadosMateria->SEQ_TV)) {
                                  $mensagem = $dadoVeiculo->NOME_TV . PHP_EOL .$dadosMateria->PROGRAMA_MATERIA.PHP_EOL. $dadosMateria->TIT_MATERIA . PHP_EOL . 'Link: ' . url_materia_simples($cliente) . $dadosMateria->CHAVE.PHP_EOL. $dadosMateria->DIA.PHP_EOL. $dadosMateria->HORA_MATERIA;
                              }

                              ?>
                              <a data-toggle="tooltip" data-placement="botton" title="baixar audio" class='btn bg-cyan btn-circle waves-effect waves-circle waves-float'
                                 href="<?php echo base_url('publico/audiodown/') .$item['SEQ_ANEXO']  ?>">
                                  <i class="material-icons">file_download</i>
                              </a>
                              <a data-toggle="tooltip" data-placement="botton" title="Compartilhar Whatsapp"
                                 class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                 href="whatsapp://send?text=%F0%9F%93%B0+<?php echo urlencode($mensagem); ?>">
                                  <i class="material-icons">share</i>
                              </a>
                          <?php } ?>
                      </td>
                  </tr>
              </table>
                    </div>
                </div>
            <?php } ?>
              <?php if ($tipoMateria == 'T') { ?>
              <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                          <tr>
                              <td align="center" colspan="2"
                                  style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                                  <?php if ($this->ComumModelo->existeAnexo($item['SEQ_ANEXO'])) { ?>
                                  <div align="center" class="embed-responsive embed-responsive-16by9">
                                      <video src="<?php echo base_url('materia/audio/').$item['SEQ_ANEXO'] ?>" controls autoplay preload="auto" >
                                          <p>Seu navegador n�o suporta o elemento audio </p>
                                      </video><br/>
                                  <?php } else { ?>
                                      <p>Sem M&iacute;dia para reprodu&ccedil;&atilde;o </p>
                                  <?php } ?>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td align="center" colspan="2"
                                  style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                                  <?php if ($this->ComumModelo->existeAnexo($item['SEQ_ANEXO'])) {
                                      $dadosMateria = $this->ComumModelo->getMateria($item['SEQ_MATERIA'])->row();
//                                      $mensagem = $dadosMateria->TIT_MATERIA.PHP_EOL.'Link: '.url_materia_simples().$dadosMateria->CHAVE;
                                      if ($dadosMateria->TIPO_MATERIA  == 'I' and !empty($dadosMateria->SEQ_VEICULO))
                                          $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $dadosMateria->SEQ_VEICULO))->row();
                                      else if ($dadosMateria->TIPO_MATERIA  == 'S' and !empty($dadosMateria->SEQ_PORTAL))
                                          $dadoVeiculo = $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $dadosMateria->SEQ_PORTAL))->row();
                                      else if ($dadosMateria->TIPO_MATERIA  == 'R' and !empty($dadosMateria->SEQ_RADIO))
                                          $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $dadosMateria->SEQ_RADIO))->row();
                                      else if ($dadosMateria->TIPO_MATERIA  == 'T' and !empty($dadosMateria->SEQ_TV))
                                          $dadoVeiculo = $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $dadosMateria->SEQ_TV))->row();

                                      if ($dadosMateria->TIPO_MATERIA == 'I' and !empty($dadosMateria->SEQ_VEICULO)) {
                                          $mensagem = $dadoVeiculo->FANTASIA_VEICULO . PHP_EOL . $dadosMateria->TIT_MATERIA . PHP_EOL . 'Link: ' . url_materia_simples($cliente) . $dadosMateria->CHAVE.PHP_EOL. $dadosMateria->DIA;
                                      } else if ($dadosMateria->TIPO_MATERIA == 'S' and !empty($dadosMateria->SEQ_PORTAL)) {
                                          $mensagem = $dadoVeiculo->FANTASIA_NOME_PORTAL . PHP_EOL . $dadosMateria->TIT_MATERIA . PHP_EOL . 'Link: ' . url_materia_simples($cliente) . $dadosMateria->CHAVE.PHP_EOL. $dadosMateria->DIA;
                                      } else if ($dadosMateria->TIPO_MATERIA == 'R' and !empty($dadosMateria->SEQ_RADIO)){
                                          $mensagem = $dadoVeiculo->NOME_RADIO.PHP_EOL.$dadosMateria->PROGRAMA_MATERIA.PHP_EOL.$dadosMateria->TIT_MATERIA.PHP_EOL.'Link: '.url_materia_simples($cliente).$dadosMateria->CHAVE.PHP_EOL. $dadosMateria->DIA;
                                      } else if ($dadosMateria->TIPO_MATERIA == 'T' and !empty($dadosMateria->SEQ_TV)) {
                                          $mensagem = $dadoVeiculo->NOME_TV . PHP_EOL .$dadosMateria->PROGRAMA_MATERIA.PHP_EOL. $dadosMateria->TIT_MATERIA . PHP_EOL . 'Link: ' . url_materia_simples($cliente) . $dadosMateria->CHAVE.PHP_EOL. $dadosMateria->DIA.PHP_EOL. $dadosMateria->HORA_MATERIA;
                                      }
                                      ?>
                                      <a data-toggle="tooltip" data-placement="botton" title="baixar audio" class='btn bg-cyan btn-circle waves-effect waves-circle waves-float'
                                         href="<?php echo base_url('publico/audiodown/') .$item['SEQ_ANEXO']  ?>">
                                          <i class="material-icons">file_download</i>
                                      </a>
                                      <a data-toggle="tooltip" data-placement="botton" title="Compartilhar Whatsapp"
                                         class='btn bg-blue btn-circle waves-effect waves-circle waves-float hidden-xs hidden-lg'
                                         href="whatsapp://send?text=%F0%9F%93%B0+<?php echo urlencode($mensagem); ?>">
                                          <i class="material-icons">share</i>
                                      </a>
                                  <?php } ?>
                              </td>
                          </tr>
                      </table>
                  </div>
              </div>
                <?php } ?>
              <?php
          endforeach;
      } else { ?>
          <div class="row clearfix">
              <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                  <div class="col-xs-12 col-md-12 col-xl-12">
                      <?php
                      $chaves = array();
                      if (!empty($palavras))
                          $chaves = explode(',',$palavras);
                      foreach ($chaves as $valor){ ?>
                          <span class="badge bg-pink"><?php echo strtoupper($valor); ?></span>
                      <?php  } ?>

                  </div>
              </div>
          </div>
            <?php if ($tipoMateria == 'S') { ?>
              <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                      <div class="col-xs-12 col-md-12 col-xl-12">
                          <a class="btn bg-teal pull-right" href="<?php if (!empty($link)) echo $link; ?>" target="_blank">
                              <small>Mat&eacute;ria na &Iacute;ntegra</small>
                          </a>
                      </div>
                  </div>
              </div>
          <?php } ?>
          <?php if ($tipoMateria == 'S' or $tipoMateria == 'I') { ?>
              <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 border-top-1">
                      <div class="col-xs-12 col-md-12 col-xl-12 margin-0">
                          <div class="col-xs-12 col-md-12 col-xl-12 text-center">
                              Nao possui Imagem
                          </div>
                      </div>
                  </div>
              </div>
          <?php } ?>
          <?php if ($tipoMateria == 'R' or $tipoMateria == 'T') { ?>
              <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 border-top-1">
                      <div class="col-xs-12 col-md-12 col-xl-12 margin-0">
                          <div class="col-xs-12 col-md-12 col-xl-12 text-center">
                              Nao possui M&iacute;dia digital
                          </div>
                      </div>
                  </div>
              </div>
          <?php } ?>
     <?php
      }
?>

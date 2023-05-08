
<?php
        $anexos = $this->ComumModelo->listaAnexo($idMateria);
      if (count($anexos)>0) {
          $total = count($anexos);
          $atual = 1;
          foreach ($anexos as $item):
              $atual++;
              ?>
              <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 border-1 nopadding">
                      <div class="col-xs-12 col-md-3 col-xl-3 text-center">
                          <img src="<?php echo $this->ComumModelo->getCliente($cliente)->row()->IMAGEM_CLIENTE; ?>" class="img-responsive"
                               style="max-height: 70px"/>
                      </div>
                      <div class="col-xs-12 col-md-9 col-xl-9 border-left-1">
                          <p style="font-size: 18px; font-weight: bold">CLIPPING JORNAL&Iacute;STICO<br/>
                              <span style="font-size: 16px; font-weight: bold">VE&Iacute;CULOS REGIONAIS</span><br/>
                                      <span
                                          style="font-size: 12px; font-weight: bold"><?php echo strtoupper(descricaoMes(intval(date('m', strtotime($dataPub))))) . '/' . date('Y', strtotime($dataPub)) ?></span>
                          </p>
                      </div>
                  </div>
              </div>
              <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 border-top-bottom-0 nopadding" >
                      <div class="col-xs-12 col-md-8 col-xl-8 margin-0 text-left nopadding">
                          <div class="col-xs-12 col-md-4 col-xl-4 border-right-1 nopadding">
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 8px"><strong>VE&Iacute;CULO</strong></small>
                              </div>
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 9px"><?php
                                      if (!empty($veiculo))
                                          echo $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $veiculo))->row()->FANTASIA_VEICULO;
                                      else if (!empty($portal))
                                          echo $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $portal))->row()->NOME_PORTAL;
                                      else if (!empty($radio))
                                          echo $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $radio))->row()->NOME_RADIO;
                                      else if (!empty($tv))
                                          echo $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $tv))->row()->NOME_TV;
                                      ?></small>
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-2 col-xl-2 border-right-1 nopadding">
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 8px"><strong>DATA</strong></small>
                              </div>
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small
                                      style="font-size: 9px"><?php if (!empty($dataPub)) echo date('d/m/Y', strtotime($dataPub)); ?></small>
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-2 col-xl-2 border-right-1 nopadding">
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 8px"><strong><?php if ($tipoMateria=='R' OR $tipoMateria=='T') echo 'PROGRAMA'; else echo 'P&Aacute;GINA'; ?></strong></small>
                              </div>
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 9px"><?php if ($tipoMateria=='R' OR $tipoMateria=='T') echo resume($programa,12); else echo $pagina; ?></small>
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-4 col-xl-4 border-right-1 nopadding">
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 8px"><strong><?php if ($tipoMateria=='R' OR $tipoMateria=='T') echo 'APRESENTADOR'; else echo 'EDITORIA'; ?></strong></small>
                              </div>
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 9px"><?php if ($tipoMateria=='R' OR $tipoMateria=='T') echo $apresentador; else echo $editoria; ?></small>
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-12 col-md-4 col-xl-4 nopadding">
                          <div class="col-xs-12 col-md-4 col-xl-4 border-right-1 nopadding">
                              <div class="col-xs-12 col-md-12 col-xl-12 ">
                                  <small style="font-size: 8px"><strong>SECRETARIA</strong></small>
                              </div>
                              <div class="col-xs-12 col-md-12 col-xl-12 ">
                                  <small
                                      style="font-size: 9px"><?php echo resume($this->ComumModelo->getSetor($setor)->row()->SIG_SETOR,10); ?></small>
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-8 col-xl-8 nopadding">
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 8px"><strong>DESTAQUE</strong></small>
                              </div>
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small
                                      style="font-size: 9px"><?php if (!empty($palavras)) echo resume($palavras,30); ?></small>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>
              <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 border-1 nopadding">
                      <div class="col-xs-12 col-md-8 col-xl-8 margin-0 border-right-1 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 8px"><strong>T&Iacute;TULO</strong></small>
                          </div>
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small
                                  style="font-size: 9px"><?php if (!empty($titulo)) echo $titulo; ?></small>
                          </div>
                      </div>
                      <div class="col-xs-12 col-md-4 col-xl-4 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 8px"><strong>ASSUNTO</strong></small>
                              </div>
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small
                                      style="font-size: 9px"><?php if (!empty($palavras)) echo resume($palavras,55); ?></small>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 <?php if ($tipoMateria != 'R') echo ' border-top-bottom-0'; else echo 'border-top-0';  ?> nopadding">
                      <div class="col-xs-12 col-md-8 col-xl-8 margin-0 border-right-1 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 8px"><strong>ORIGEM</strong></small>
                          </div>
                          <div class="col-xs-12 col-md-3 col-xl-3">
                              <small style="font-size: 8px">
                                  ( <?php if (!empty($classificacao) and $classificacao == 'E') echo 'X'; ?>
                                  ) DEMANDA ESPONT&Acirc;NEA
                              </small>
                          </div>
                          <div class="col-xs-12 col-md-3 col-xl-3">
                              <small style="font-size: 8px">
                                  ( <?php if (!empty($classificacao) and $classificacao == 'X') echo 'X'; ?>
                                  ) MAT&Eacute;RIA EXCLUSIVA
                              </small>
                          </div>
                          <div class="col-xs-12 col-md-3 col-xl-3">
                              <small style="font-size: 8px">
                                  ( <?php if (!empty($classificacao) and $classificacao == 'I') echo 'X'; ?>
                                  ) RELEASE NA &Iacute;NTEGRA
                              </small>
                          </div>
                          <div class="col-xs-12 col-md-3 col-xl-3">
                              <small style="font-size: 8px">
                                  ( <?php if (!empty($classificacao) and $classificacao == 'P') echo 'X'; ?>
                                  ) RELEASE PARCIAL
                              </small>
                          </div>
                      </div>
                      <div class="col-xs-12 col-md-4 col-xl-4 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                              <div class="col-xs-12 col-md-12 col-xl-12">
                                  <small style="font-size: 8px"><strong>AVALIA&Ccedil;&Atilde;O</strong></small>
                              </div>
                              <div class="col-xs-12 col-md-4 col-xl-4">
                                  <small style="font-size: 8px">
                                      ( <?php if (!empty($avaliacao) and $avaliacao == 'P') echo 'X'; ?>
                                      ) POSITIVA
                                  </small>
                              </div>
                              <div class="col-xs-12 col-md-4 col-xl-4">
                                  <small style="font-size: 8px">
                                      ( <?php if (!empty($avaliacao) and $avaliacao == 'N') echo 'X'; ?>
                                      ) NEGATIVA
                                  </small>
                              </div>
                              <div class="col-xs-12 col-md-4 col-xl-4">
                                  <small style="font-size: 8px">
                                      ( <?php if (!empty($avaliacao) and $avaliacao == 'T') echo 'X'; ?>
                                      ) NEUTRA
                                  </small>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <?php if ($tipoMateria == 'S') { ?>
                <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 border-1 nopadding">
                      <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 8px"><strong>Link</strong></small>
                          </div>
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <a href="<?php if (!empty($link)) echo $link; ?>" target="_blank">
                                  <small style="font-size: 9px"><?php if (!empty($link)) echo $link; ?></small>
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
              <?php } ?>
              <?php if ($tipoMateria == 'S' or $tipoMateria == 'I') { ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                          <td align="center" colspan="2"
                              style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                              <img class="img-responsive"
                                   src="<?php echo base_url('materia/imagem/'.$item['SEQ_ANEXO']); ?>"/>
                          </td>
                      </tr>
                  </table>
              <?php } ?>
              <?php if ($tipoMateria == 'R') { ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                      <td align="center" colspan="2"
                          style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                        <?php if ($this->ComumModelo->existeAnexo($item['SEQ_ANEXO'])) { ?>
                          <audio src="<?php echo base_url('materia/audio/').$item['SEQ_ANEXO'] ?>" controls preload="auto">
                              <p>Seu navegador não suporta o elemento audio </p>
                          </audio><br/>
                          <a data-toggle="tooltip" data-placement="top" title="baixar" class='btn bg-cyan btn-sm waves-effect'
                             href="<?php echo base_url('publico/audiodown/') .$item['SEQ_ANEXO']  ?>">
                              baixar <i class="material-icons">file_download</i>
                          </a>
                        <?php } else { ?>
                            <p>Sem M&iacute;dia para reprodu&ccedil;&atilde;o </p>
                        <?php } ?>
                      </td>
                  </tr>
              </table>
            <?php } ?>
              <?php if ($tipoMateria == 'T') { ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                      <td align="center" colspan="2"
                          style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                          <?php if ($this->ComumModelo->existeAnexo($item['SEQ_ANEXO'])) { ?>
                          <div align="center" class="class="embed-responsive embed-responsive-16by9">
                          <video src="<?php echo base_url('materia/audio/').$item['SEQ_ANEXO'] ?>"
                            class="img-responsive" controls preload="auto" >
                          </video>
                          <br/>
                          <a data-toggle="tooltip" data-placement="top" title="baixar" class='btn bg-cyan btn-sm waves-effect'
                             href="<?php echo base_url('publico/audiodown/') .$item['SEQ_ANEXO']  ?>">
                              baixar <i class="material-icons">file_download</i>
                          </a>
                          </div>
                           <?php } else { ?>
                              <p>Sem M&iacute;dia para reprodu&ccedil;&atilde;o </p>
                          <?php } ?>
                          </p>
                      </td>
                  </tr>
              </table>
          <?php } ?>
              <?php
              if ($atual < $total) echo '<pagebreak />';
          endforeach;
      } else { ?>

          <div class="row clearfix">
              <div class="col-xs-12 col-md-12 col-xl-12 border-1 nopadding">
                  <div class="col-xs-12 col-md-3 col-xl-3 text-center">
                      <img src="<?php echo $this->ComumModelo->getCliente($cliente)->row()->IMAGEM_CLIENTE; ?>" class="img-responsive"
                           style="max-height: 70px"/>
                  </div>
                  <div class="col-xs-12 col-md-9 col-xl-9 border-left-1">
                          <p style="font-size: 18px; font-weight: bold">CLIPPING JORNAL&Iacute;STICO<br/>
                              <span style="font-size: 16px; font-weight: bold">VE&Iacute;CULOS REGIONAIS</span><br/>
                                      <span
                                          style="font-size: 12px; font-weight: bold"><?php echo strtoupper(descricaoMes(intval(date('m', strtotime($dataPub))))) . '/' . date('Y', strtotime($dataPub)) ?></span>
                          </p>
                  </div>
              </div>
          </div>
          <div class="row clearfix">
              <div class="col-xs-12 col-md-12 col-xl-12 border-top-bottom-0 nopadding" >
                  <div class="col-xs-12 col-md-8 col-xl-8 margin-0 text-left nopadding">
                      <div class="col-xs-12 col-md-4 col-xl-4 border-right-1 nopadding">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <small style="font-size: 8px"><strong>VE&Iacute;CULO</strong></small>
                            </div>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <small style="font-size: 9px"><?php
                                  if (!empty($veiculo))
                                      echo $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $veiculo))->row()->FANTASIA_VEICULO;
                                  else if (!empty($portal))
                                      echo $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $portal))->row()->NOME_PORTAL;
                                  else if (!empty($radio))
                                      echo $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $radio))->row()->NOME_RADIO;
                                  else if (!empty($tv))
                                      echo $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $tv))->row()->NOME_TV;
                                  ?></small>
                            </div>
                      </div>
                      <div class="col-xs-12 col-md-2 col-xl-2 border-right-1 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                            <small style="font-size: 8px"><strong>DATA</strong></small>
                          </div>
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small
                                  style="font-size: 9px"><?php if (!empty($dataPub)) echo date('d/m/Y', strtotime($dataPub)); ?></small>
                          </div>
                      </div>
                      <div class="col-xs-12 col-md-2 col-xl-2 border-right-1 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 8px"><strong><?php if ($tipoMateria=='R' OR $tipoMateria=='T') echo 'PROGRAMA'; else echo 'P&Aacute;GINA'; ?></strong></small>
                          </div>
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 9px"><?php if ($tipoMateria=='R' OR $tipoMateria=='T') echo resume($programa,12); else echo $pagina; ?></small>
                          </div>
                      </div>
                      <div class="col-xs-12 col-md-4 col-xl-4 border-right-1 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 8px"><strong><?php if ($tipoMateria=='R' OR $tipoMateria=='T') echo 'APRESENTADOR'; else echo 'EDITORIA'; ?></strong></small>
                          </div>
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 9px"><?php if ($tipoMateria=='R' OR $tipoMateria=='T') echo $apresentador; else echo $editoria; ?></small>
                          </div>
                      </div>
                  </div>
                  <div class="col-xs-12 col-md-4 col-xl-4 nopadding">
                      <div class="col-xs-12 col-md-4 col-xl-4 border-right-1 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                            <small style="font-size: 8px"><strong>SECRETARIA</strong></small>
                          </div>
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small
                                  style="font-size: 9px"><?php echo resume($this->ComumModelo->getSetor($setor)->row()->SIG_SETOR,20); ?></small>
                          </div>
                      </div>
                      <div class="col-xs-12 col-md-8 col-xl-8 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 8px"><strong>DESTAQUE</strong></small>
                          </div>
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small
                                  style="font-size: 9px"><?php if (!empty($palavras)) echo resume($palavras,30); ?></small>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
          <div class="row clearfix">
              <div class="col-xs-12 col-md-12 col-xl-12 border-1 nopadding">
                  <div class="col-xs-12 col-md-8 col-xl-8 margin-0 border-right-1 nopadding">
                      <div class="col-xs-12 col-md-12 col-xl-12">
                          <small style="font-size: 8px"><strong>T&Iacute;TULO</strong></small>
                      </div>
                      <div class="col-xs-12 col-md-12 col-xl-12">
                          <small
                              style="font-size: 9px"><?php if (!empty($titulo)) echo $titulo; ?></small>
                      </div>
                  </div>
                  <div class="col-xs-12 col-md-4 col-xl-4 nopadding">
                      <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 8px"><strong>ASSUNTO</strong></small>
                          </div>
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small
                                  style="font-size: 9px"><?php if (!empty($palavras)) echo resume($palavras,55); ?></small>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row clearfix">
              <div class="col-xs-12 col-md-12 col-xl-12 <?php if ($tipoMateria != 'R') echo ' border-top-0'; else echo 'border-top-0';  ?> nopadding">
                  <div class="col-xs-12 col-md-8 col-xl-8 margin-0 border-right-1 nopadding">
                      <div class="col-xs-12 col-md-12 col-xl-12">
                          <small style="font-size: 8px"><strong>ORIGEM</strong></small>
                      </div>
                      <div class="col-xs-12 col-md-3 col-xl-3">
                          <small style="font-size: 8px">
                              ( <?php if (!empty($classificacao) and $classificacao == 'E') echo 'X'; ?>
                              ) DEMANDA ESPONT&Acirc;NEA
                          </small>
                      </div>
                      <div class="col-xs-12 col-md-3 col-xl-3">
                          <small style="font-size: 8px">
                              ( <?php if (!empty($classificacao) and $classificacao == 'X') echo 'X'; ?>
                              ) MAT&Eacute;RIA EXCLUSIVA
                          </small>
                      </div>
                      <div class="col-xs-12 col-md-3 col-xl-3">
                          <small style="font-size: 8px">
                              ( <?php if (!empty($classificacao) and $classificacao == 'I') echo 'X'; ?>
                              ) RELEASE NA &Iacute;NTEGRA
                          </small>
                      </div>
                      <div class="col-xs-12 col-md-3 col-xl-3">
                          <small style="font-size: 8px">
                              ( <?php if (!empty($classificacao) and $classificacao == 'P') echo 'X'; ?>
                              ) RELEASE PARCIAL
                          </small>
                      </div>
                  </div>
                  <div class="col-xs-12 col-md-4 col-xl-4 nopadding">
                      <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 8px"><strong>AVALIA&Ccedil;&Atilde;O</strong></small>
                          </div>
                          <div class="col-xs-12 col-md-4 col-xl-4">
                              <small style="font-size: 8px">
                                  ( <?php if (!empty($avaliacao) and $avaliacao == 'P') echo 'X'; ?>
                                  ) POSITIVA
                              </small>
                          </div>
                          <div class="col-xs-12 col-md-4 col-xl-4">
                              <small style="font-size: 8px">
                                  ( <?php if (!empty($avaliacao) and $avaliacao == 'N') echo 'X'; ?>
                                  ) NEGATIVA
                              </small>
                          </div>
                          <div class="col-xs-12 col-md-4 col-xl-4">
                              <small style="font-size: 8px">
                                  ( <?php if (!empty($avaliacao) and $avaliacao == 'T') echo 'X'; ?>
                                  ) NEUTRA
                              </small>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
            <?php if ($tipoMateria == 'S') { ?>
              <div class="row clearfix">
                  <div class="col-xs-12 col-md-12 col-xl-12 border-1 nopadding">
                      <div class="col-xs-12 col-md-12 col-xl-12 nopadding">
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <small style="font-size: 8px"><strong>Link</strong></small>
                          </div>
                          <div class="col-xs-12 col-md-12 col-xl-12">
                              <a href="<?php if (!empty($link)) echo $link; ?>" target="_blank">
                                  <small style="font-size: 9px"><?php if (!empty($link)) echo $link; ?></small>
                              </a>
                          </div>
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

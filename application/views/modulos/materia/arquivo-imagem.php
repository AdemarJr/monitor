<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Clipping</title>
 	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url().'assets/bootstrap/css/bootstrap.css' ?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!-- DATA TABLES -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
<style>
    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    .quebrapagina {
        page-break-after: always;
    }
</style>
<!--<body class="" onload="window.print()" >-->
<?php
            $anexos = $this->ComumModelo->listaAnexo($idMateria);
      if (count($anexos)>0) {
          $total = count($anexos);
          $atual = 1;
          foreach ($anexos as $item):
              $atual++;
              ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                      <td height="80" style="text-align:center;border: 1px solid black;" width="20%">
                          <img src="<?php echo $this->ComumModelo->getCliente($cliente)->row()->IMAGEM_CLIENTE; ?>"
                               style="max-height: 70px"/>
                      </td>
                      <td style="text-align:left;margin-left: 20px;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;padding-left: 10px"
                          width="80%">
                          <div style="text-align:left;margin-left: 20px">
                              <p style="font-size: 18px; font-weight: bold">CLIPPING JORNAL&Iacute;STICO<br/>
                                  <span style="font-size: 16px; font-weight: bold">VE&Iacute;CULOS REGIONAIS</span><br/>
                                  <span
                                      style="font-size: 12px; font-weight: bold"><?php echo strtoupper(descricaoMes(intval(date('m', strtotime($dataPub))))) . '/' . date('Y', strtotime($dataPub)) ?></span>
                              </p>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="text-align:left" width="100%">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                  <td width="20%"
                                      style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong>VE&Iacute;CULO</strong></small>
                                      </div>
                                  </td>
                                  <td width="10%" style="border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong>DATA</strong></small>
                                      </div>
                                  </td>
                                  <td width="10%" style="border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong><?php if ($tipoMateria=='R' or $tipoMateria=='T') echo 'PROGRAMA'; else echo 'P&Aacute;GINA'; ?></strong></small>
                                      </div>
                                  </td>
                                  <td width="25%" style="border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong><?php if ($tipoMateria=='R' or $tipoMateria=='T') echo 'APRESENTADOR'; else echo 'EDITORIA'; ?></strong></small>
                                      </div>
                                  </td>
                                  <td width="15%" style="border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong>SECRETARIA</strong></small>
                                      </div>
                                  </td>
                                  <td width="20%" style="border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong>DESTAQUE</strong></small>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td width="20%" height="30"
                                      style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
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
                                  </td>
                                  <td width="10%" height="30"
                                      style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small
                                              style="font-size: 9px"><?php if (!empty($dataPub)) echo date('d/m/Y', strtotime($dataPub)); ?></small>
                                      </div>
                                  </td>
                                  <td width="10%" height="30"
                                      style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 9px"><?php if ($tipoMateria=='R' or $tipoMateria=='T') echo $programa; else echo $pagina; ?></small>
                                      </div>
                                  </td>
                                  <td width="25%" height="30"
                                      style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 9px"><?php if ($tipoMateria=='R' or $tipoMateria=='T') echo $apresentador; else echo $editoria; ?></small>
                                      </div>
                                  </td>
                                  <td width="15%" height="30"
                                      style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small
                                              style="font-size: 9px"><?php echo $this->ComumModelo->getSetor($setor)->row()->SIG_SETOR; ?></small>
                                      </div>
                                  </td>
                                  <td width="20%" height="30"
                                      style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small
                                              style="font-size: 9px"><?php if (!empty($destaque)) echo $destaque; ?></small>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td width="65%" colspan="4"
                                      style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong>T&Iacute;TULO</strong></small>
                                      </div>
                                  </td>
                                  <td width="35%" colspan="2" style="border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong>ASSUNTO</strong></small>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td width="65%" height="30" colspan="4"
                                      style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small
                                              style="font-size: 9px"><?php if (!empty($titulo)) echo $titulo; ?></small>
                                      </div>
                                  </td>
                                  <td width="35%" height="30" colspan="2"
                                      style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small
                                              style="font-size: 9px"><?php if (!empty($palavras)) echo $palavras; ?></small>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td width="65%" colspan="4"
                                      style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong>ORIGEM</strong></small>
                                      </div>
                                  </td>
                                  <td width="35%" colspan="2"
                                      style="border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong>AVALIA&Ccedil;&Atilde;O</strong></small>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td width="65%" colspan="4" height="30"
                                      style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 10px; ">
                                          <table width="100%" border="2" cellspacing="2" cellpadding="2"
                                                 align="center">
                                              <tr>
                                                  <td width="28%" style="text-align:left">
                                                      <div style="text-align:left;margin-left: 10px">
                                                          <small style="font-size: 8px">
                                                              ( <?php if (!empty($classificacao) and $classificacao == 'E') echo 'X'; ?>
                                                              ) DEMANDA ESPONT&Acirc;NEA
                                                          </small>
                                                      </div>
                                                  </td>
                                                  <td width="24%" style="text-align:left">
                                                      <div style="text-align:left;margin-left: 10px">
                                                          <small style="font-size: 8px">
                                                              ( <?php if (!empty($classificacao) and $classificacao == 'X') echo 'X'; ?>
                                                              ) MAT&Eacute;RIA EXCLUSIVA
                                                          </small>
                                                      </div>
                                                  </td>
                                                  <td width="26%" style="text-align:left">
                                                      <div style="text-align:left;margin-left: 10px">
                                                          <small style="font-size: 8px">
                                                              ( <?php if (!empty($classificacao) and $classificacao == 'I') echo 'X'; ?>
                                                              ) RELEASE NA &Iacute;NTEGRA
                                                          </small>
                                                      </div>
                                                  </td>
                                                  <td width="22%" style="text-align:left">
                                                      <div style="text-align:left;margin-left: 10px">
                                                          <small style="font-size: 8px">
                                                              ( <?php if (!empty($classificacao) and $classificacao == 'P') echo 'X'; ?>
                                                              ) RELEASE PARCIAL
                                                          </small>
                                                      </div>
                                                  </td>
                                              </tr>
                                          </table>
                                      </div>
                                  </td>
                                  <td width="35%" colspan="2"
                                      style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                                 align="center">
                                              <tr>
                                                  <td width="33%" style="text-align:left">
                                                      <div style="text-align:left;margin-left: 20px">
                                                          <small style="font-size: 8px">
                                                              ( <?php if (!empty($avaliacao) and $avaliacao == 'P') echo 'X'; ?>
                                                              ) POSITIVA
                                                          </small>
                                                      </div>
                                                  </td>
                                                  <td width="33%" style="text-align:left">
                                                      <div style="text-align:left;margin-left: 20px">
                                                          <small style="font-size: 8px">
                                                              ( <?php if (!empty($avaliacao) and $avaliacao == 'N') echo 'X'; ?>
                                                              ) NEGATIVA
                                                          </small>
                                                      </div>
                                                  </td>
                                                  <td width="33%" style="text-align:left">
                                                      <div style="text-align:left;margin-left: 20px">
                                                          <small style="font-size: 8px">
                                                              ( <?php if (!empty($avaliacao) and $avaliacao == 'T') echo 'X'; ?>
                                                              ) NEUTRA
                                                          </small>
                                                      </div>
                                                  </td>
                                              </tr>
                                          </table>
                                      </div>
                                  </td>
                              </tr>
                              <?php if ($tipoMateria == 'S') { ?>
                                  <tr>
                                      <td width="100%" colspan="6"
                                          style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 7px">
                                          <div style="text-align:left;margin-left: 20px">
                                              <small style="font-size: 8px"><strong>Link</strong></small>
                                          </div>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td width="100%" height="30" colspan="6"
                                          style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                          <div style="text-align:left;margin-left: 20px">
                                              <small
                                                  style="font-size: 9px"><?php if (!empty($link)) echo $link; ?></small>
                                          </div>
                                      </td>
                                  </tr>
                              <?php } ?>
                          </table>
                      </td>
                  </tr>
                    <?php if ($tipoMateria == 'S' or $tipoMateria == 'I') { ?>
                      <tr>
                          <td height="750" align="center" colspan="2"
                              style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                              <img style="max-height: 750px"
                                   src="<?php echo APPPATH_MATERIA. $item['SEQ_MATERIA'] . '/' . $item['NOME_BIN_ARQUIVO']; ?>"/>
                          </td>
                      </tr>
                    <?php } ?>
                  <?php if ($tipoMateria == 'R') { ?>
                      <tr>
                          <td height="750" align="center" colspan="2"
                              style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                                  <small style="font-size: 9px">Clique aqui para ouvir o audio.</small><br/><br/>
                                  <small style="font-size: 9px"><?php echo base_url('publico/audiodown/').$item['SEQ_ANEXO']; ?></small>
                          </td>
                      </tr>
                  <?php } ?>
                  <?php if ($tipoMateria == 'T') { ?>
                      <tr>
                          <td height="750" align="center" colspan="2"
                              style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                                  <small style="font-size: 9px">Clique aqui para visualizar o video.</small><br/><br/>
                                  <small style="font-size: 9px"><?php echo base_url('publico/audiodown/').$item['SEQ_ANEXO']; ?></small>
                          </td>
                      </tr>
                  <?php } ?>
              </table>
              <?php
              if ($atual < $total) echo '<pagebreak />';
          endforeach;
      } else { ?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                  <td height="80" style="text-align:center;border: 1px solid black;" width="20%">
                      <img src="<?php echo $this->ComumModelo->getCliente($cliente)->row()->IMAGEM_CLIENTE; ?>"
                           style="max-height: 70px"/>
                  </td>
                  <td style="text-align:left;margin-left: 20px;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;padding-left: 10px"
                      width="80%">
                      <div style="text-align:left;margin-left: 20px">
                          <p style="font-size: 18px; font-weight: bold">CLIPPING JORNAL&Iacute;STICO<br/>
                              <span style="font-size: 16px; font-weight: bold">VE&Iacute;CULOS REGIONAIS</span><br/>
                                  <span
                                      style="font-size: 12px; font-weight: bold"><?php echo strtoupper(descricaoMes(intval(date('m', strtotime($dataPub))))) . '/' . date('Y', strtotime($dataPub)) ?></span>
                          </p>
                      </div>
                  </td>
              </tr>

              <tr>
                  <td colspan="2" style="text-align:left" width="100%">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                          <tr>
                              <td width="20%"
                                  style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong>VE&Iacute;CULO</strong></small>
                                  </div>
                              </td>
                              <td width="10%" style="border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong>DATA</strong></small>
                                  </div>
                              </td>
                              <td width="10%" style="border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong><?php if ($tipoMateria=='R' or $tipoMateria=='T') echo 'PROGRAMA'; else echo 'P&Aacute;GINA'; ?></strong></small>
                                  </div>
                              </td>
                              <td width="25%" style="border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong><?php if ($tipoMateria=='R' or $tipoMateria=='T') echo 'APRESENTADOR'; else echo 'EDITORIA'; ?></strong></small>
                                  </div>
                              </td>
                              <td width="15%" style="border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong>SECRETARIA</strong></small>
                                  </div>
                              </td>
                              <td width="20%" style="border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong>DESTAQUE</strong></small>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td width="20%" height="30"
                                  style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
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
                              </td>
                              <td width="10%" height="30"
                                  style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small
                                          style="font-size: 9px"><?php if (!empty($dataPub)) echo date('d/m/Y', strtotime($dataPub)); ?></small>
                                  </div>
                              </td>
                              <td width="10%" height="30"
                                  style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 9px"><?php if ($tipoMateria=='R' or $tipoMateria=='T') echo $programa; else echo $pagina; ?></small>
                                  </div>
                              </td>
                              <td width="25%" height="30"
                                  style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 9px"><?php if ($tipoMateria=='R' or $tipoMateria=='T') echo $apresentador; else echo $editoria; ?></small>
                                  </div>
                              </td>
                              <td width="15%" height="30"
                                  style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small
                                          style="font-size: 9px"><?php echo $this->ComumModelo->getSetor($setor)->row()->SIG_SETOR; ?></small>
                                  </div>
                              </td>
                              <td width="20%" height="30"
                                  style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small
                                          style="font-size: 9px"><?php if (!empty($destaque)) echo $destaque; ?></small>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td width="65%" colspan="4"
                                  style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong>T&Iacute;TULO</strong></small>
                                  </div>
                              </td>
                              <td width="35%" colspan="2" style="border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong>ASSUNTO</strong></small>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td width="65%" height="30" colspan="4"
                                  style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small
                                          style="font-size: 9px"><?php if (!empty($titulo)) echo $titulo; ?></small>
                                  </div>
                              </td>
                              <td width="35%" height="30" colspan="2"
                                  style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small
                                          style="font-size: 9px"><?php if (!empty($palavras)) echo $palavras; ?></small>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td width="65%" colspan="4"
                                  style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong>ORIGEM</strong></small>
                                  </div>
                              </td>
                              <td width="35%" colspan="2"
                                  style="border-right: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <small style="font-size: 8px"><strong>AVALIA&Ccedil;&Atilde;O</strong></small>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td width="65%" colspan="4" height="30"
                                  style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 10px; ">
                                      <table width="100%" border="2" cellspacing="2" cellpadding="2"
                                             align="center">
                                          <tr>
                                              <td width="28%" style="text-align:left">
                                                  <div style="text-align:left;margin-left: 10px">
                                                      <small style="font-size: 8px">
                                                          ( <?php if (!empty($classificacao) and $classificacao == 'E') echo 'X'; ?>
                                                          ) DEMANDA ESPONT&Acirc;NEA
                                                      </small>
                                                  </div>
                                              </td>
                                              <td width="24%" style="text-align:left">
                                                  <div style="text-align:left;margin-left: 10px">
                                                      <small style="font-size: 8px">
                                                          ( <?php if (!empty($classificacao) and $classificacao == 'X') echo 'X'; ?>
                                                          ) MAT&Eacute;RIA EXCLUSIVA
                                                      </small>
                                                  </div>
                                              </td>
                                              <td width="26%" style="text-align:left">
                                                  <div style="text-align:left;margin-left: 10px">
                                                      <small style="font-size: 8px">
                                                          ( <?php if (!empty($classificacao) and $classificacao == 'I') echo 'X'; ?>
                                                          ) RELEASE NA &Iacute;NTEGRA
                                                      </small>
                                                  </div>
                                              </td>
                                              <td width="22%" style="text-align:left">
                                                  <div style="text-align:left;margin-left: 10px">
                                                      <small style="font-size: 8px">
                                                          ( <?php if (!empty($classificacao) and $classificacao == 'P') echo 'X'; ?>
                                                          ) RELEASE PARCIAL
                                                      </small>
                                                  </div>
                                              </td>
                                          </tr>
                                      </table>
                                  </div>
                              </td>
                              <td width="35%" colspan="2"
                                  style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                  <div style="text-align:left;margin-left: 20px">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                             align="center">
                                          <tr>
                                              <td width="33%" style="text-align:left">
                                                  <div style="text-align:left;margin-left: 20px">
                                                      <small style="font-size: 8px">
                                                          ( <?php if (!empty($avaliacao) and $avaliacao == 'P') echo 'X'; ?>
                                                          ) POSITIVA
                                                      </small>
                                                  </div>
                                              </td>
                                              <td width="33%" style="text-align:left">
                                                  <div style="text-align:left;margin-left: 20px">
                                                      <small style="font-size: 8px">
                                                          ( <?php if (!empty($avaliacao) and $avaliacao == 'N') echo 'X'; ?>
                                                          ) NEGATIVA
                                                      </small>
                                                  </div>
                                              </td>
                                              <td width="33%" style="text-align:left">
                                                  <div style="text-align:left;margin-left: 20px">
                                                      <small style="font-size: 8px">
                                                          ( <?php if (!empty($avaliacao) and $avaliacao == 'T') echo 'X'; ?>
                                                          ) NEUTRA
                                                      </small>
                                                  </div>
                                              </td>
                                          </tr>
                                      </table>
                                  </div>
                              </td>
                          </tr>
                          <?php if ($tipoMateria == 'S') { ?>
                              <tr>
                                  <td width="100%" colspan="6"
                                      style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small style="font-size: 8px"><strong>Link</strong></small>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td width="100%" height="30" colspan="6"
                                      style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                      <div style="text-align:left;margin-left: 20px">
                                          <small
                                              style="font-size: 9px"><?php if (!empty($link)) echo $link; ?></small>
                                      </div>
                                  </td>
                              </tr>
                          <?php } ?>
                      </table>
                  </td>
              </tr>
              <?php if ($tipoMateria == 'S' or $tipoMateria == 'I') { ?>
                  <tr>
                      <td height="750" align="center" colspan="2"
                          style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                          Nao possui Imagem
                      </td>
                  </tr>
              <?php } ?>
              <?php if ($tipoMateria == 'R' or $tipoMateria == 'T') { ?>
                  <tr>
                      <td height="750" align="center" colspan="2"
                          style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                          Nao possui M&iacute;dia digital
                      </td>
                  </tr>
              <?php } ?>
          </table>
     <?php

      }
          ?>
</body>
</html>

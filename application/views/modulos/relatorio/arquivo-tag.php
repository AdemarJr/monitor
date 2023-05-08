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
<?php if (!empty($materias)) {
    $total = count($materias);
    $atual = 1;
        foreach ($materias as $itemM):


                $atual++;
            $cliente = $itemM['SEQ_CLIENTE'];
            $titulo = $itemM['TIT_MATERIA'];
            $dataPub = $itemM['DATA_MATERIA_PUB'];
            $palavras = $itemM['PC_MATERIA'];
            $link = $itemM['LINK_MATERIA'];
            $veiculo = $itemM['SEQ_VEICULO'];
            $portal = $itemM['SEQ_PORTAL'];
            $pagina = $itemM['PAGINA_MATERIA'];
            $editoria = $itemM['EDITORIA_MATERIA'];
            $classificacao = $itemM['IND_CLASSIFICACAO'];
            $avaliacao = $itemM['IND_AVALIACAO'];
            $setor = $itemM['SEQ_SETOR'];
            $destaque = $itemM['DESTAQUE_MATERIA'];

            $tipoMateria = NULL;
            if (!empty($veiculo))
                $tipoMateria = 'impresso';
            else if (!empty($portal))
                $tipoMateria = 'internet';

            $anexos = $this->ComumModelo->listaAnexo($itemM['SEQ_MATERIA']);


            if (count($anexos)>0) {
                foreach ($anexos as $item):
//                    $listaItem = $this->ComumModelo->getTableData('MATERIA', array('SEQ_MATERIA' => $item['SEQ_MATERIA']))->row();

                    $atual++;

                    ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td height="80" style="text-align:center;border: 1px solid black;" width="20%">
                                <?php 
                                if (!empty($this->ComumModelo->getCliente($cliente)->row()->IMAGEM_CLIENTE)) {
                                ?>
                                <img
                                    src="<?php echo $this->ComumModelo->getCliente($cliente)->row()->IMAGEM_CLIENTE; ?>"
                                    style="max-height: 70px"/>
                                <?php } ?>
                            </td>
                            <td style="text-align:left;margin-left: 20px;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;padding-left: 10px"
                                width="80%">
                                <div style="text-align:left;margin-left: 20px">
                                    <p style="font-size: 18px; font-weight: bold">CLIPPING JORNAL&Iacute;STICO<br/>
                                        <span
                                            style="font-size: 16px; font-weight: bold">VE&Iacute;CULOS REGIONAIS</span><br/>
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
                                                <small style="font-size: 8px"><strong>P&Aacute;GINA</strong></small>
                                            </div>
                                        </td>
                                        <td width="25%" style="border-right: 1px solid black;padding-left: 7px">
                                            <div style="text-align:left;margin-left: 20px">
                                                <small style="font-size: 8px"><strong>EDITORIA</strong></small>
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
                                                <small
                                                    style="font-size: 9px"><?php if (!empty($pagina)) echo $pagina; ?></small>
                                            </div>
                                        </td>
                                        <td width="25%" height="30"
                                            style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                            <div style="text-align:left;margin-left: 20px">
                                                <small
                                                    style="font-size: 9px"><?php if (!empty($editoria)) echo $editoria; ?></small>
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
                                        <td width="35%" colspan="2"
                                            style="border-right: 1px solid black;padding-left: 7px">
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
                                    <?php if ($tipoMateria != 'impresso') { ?>
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
                        <tr>
                            <td height="750" align="center" colspan="2"
                                style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">
                                <img style="max-height: 750px"
                                     src="<?php echo APPPATH_MATERIA . $item['SEQ_MATERIA'] . '/' . $item['NOME_BIN_ARQUIVO']; ?>"/>

                            </td>
                        </tr>
                    </table>
                    <?php
                endforeach;
            } else{ ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td height="80" style="text-align:center;border: 1px solid black;" width="20%">
                            <?php 
                            if (!empty($this->ComumModelo->getCliente($cliente)->row()->IMAGEM_CLIENTE)) {
                            ?>
                            <img
                                src="<?php echo $this->ComumModelo->getCliente($cliente)->row()->IMAGEM_CLIENTE; ?>"
                                style="max-height: 70px"/>
                            <?php } ?>
                        </td>
                        <td style="text-align:left;margin-left: 20px;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;padding-left: 10px"
                            width="80%">
                            <div style="text-align:left;margin-left: 20px">
                                <p style="font-size: 18px; font-weight: bold">CLIPPING JORNAL&Iacute;STICO<br/>
                                        <span
                                            style="font-size: 16px; font-weight: bold">VE&Iacute;CULOS REGIONAIS</span><br/>
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
                                            <small style="font-size: 8px"><strong>P&Aacute;GINA</strong></small>
                                        </div>
                                    </td>
                                    <td width="25%" style="border-right: 1px solid black;padding-left: 7px">
                                        <div style="text-align:left;margin-left: 20px">
                                            <small style="font-size: 8px"><strong>EDITORIA</strong></small>
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
                                    <td width="20%" height="30" style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                        <div style="text-align:left;margin-left: 20px">
                                            <small style="font-size: 9px"><?php
                                                if (!empty($veiculo))
                                                    echo $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $veiculo))->row()->FANTASIA_VEICULO;
                                                else if (!empty($portal))
                                                    echo $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $portal))->row()->NOME_PORTAL;
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
                                            <small
                                                style="font-size: 9px"><?php if (!empty($pagina)) echo $pagina; ?></small>
                                        </div>
                                    </td>
                                    <td width="25%" height="30"
                                        style="border-right: 1px solid black;border-bottom: 1px solid black;padding-left: 7px">
                                        <div style="text-align:left;margin-left: 20px">
                                            <small
                                                style="font-size: 9px"><?php if (!empty($editoria)) echo $editoria; ?></small>
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
                                    <td width="35%" colspan="2"
                                        style="border-right: 1px solid black;padding-left: 7px">
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
                                <?php if ($tipoMateria != 'impresso') { ?>
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
                    <tr>
                        <td height="750" align="center" colspan="2"
                            style="vertical-align: top; text-align:center; padding: 10px 10px" width="100%">

                            Nao possui Imagem

                        </td>
                    </tr>
                </table>
        <?php    }
            if ($atual < $total) echo '<pagebreak />';
        endforeach;
}?>
</body>
</html>

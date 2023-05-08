<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Quantitativo por Secretaria/Setor</title>
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
$dataCliente = $this->ComumModelo->getCliente($idCliente)->row();
$controle=0;
?>

        <?php
        $lista_setor = $this->ComumModelo->quantitativoSetor2($datai,$dataf,$idCliente,'I');
        if (!empty($lista_setor)){
        ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td height="80" style="text-align:center" width="20%">
                        <img src="<?php echo FCPATH . "assets/images/".$dataCliente->LOGO_EMPRESA; ?>" style="max-height: 100px"/>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;margin-left: 20px;padding-left: 10px" width="80%">
                        <div style="text-align:center;margin-left: 20px">
                            <p style="font-size: 18px; font-weight: bold">RELAT&Oacute;RIO DE QUANTITATIVO<br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td colspan="2" style="text-align:left" width="100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: ghostwhite"><div style="text-align:left;margin-left: 20px"><strong>Tema</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: ghostwhite" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: ghostwhite" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: ghostwhite" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                            <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: ghostwhite" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                        </tr>
                        <?php
                        $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                        if (!empty($lista_setor)) {
                            foreach ($lista_setor as $itemS):
                                $totalP+=$itemS['POSITIVO'];
                                $totalN+=$itemS['NEGATIVO'];
                                $totalT+=$itemS['NEUTRO'];
                                $totalG+=$itemS['TOTAL'];
                                ?>
                        <tr>
                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESC_SETOR']; ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                            <?php endforeach;
                        } ?>
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: ghostwhite"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: ghostwhite" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: ghostwhite" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: ghostwhite" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                            <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: ghostwhite" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>
        <?php } ?>
<br/><br/><br/>
        <?php
        $lista_setor2 = $this->ComumModelo->quantitativoSetor2Cliente($datai,$dataf);
        if (!empty($lista_setor2)){
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td colspan="2" style="text-align:left" width="100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: ghostwhite"><div style="text-align:left;margin-left: 20px"><strong>Tema</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: ghostwhite" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: ghostwhite" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: ghostwhite" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                            <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: ghostwhite" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                        </tr>
                        <?php
                        $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                        if (!empty($lista_setor2)) {
                            foreach ($lista_setor2 as $itemS):
                                $totalP+=$itemS['POSITIVO'];
                                $totalN+=$itemS['NEGATIVO'];
                                $totalT+=$itemS['NEUTRO'];
                                $totalG+=$itemS['TOTAL'];
                                ?>
                                <tr>
                                    <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['NOME_CLIENTE']; ?></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                                    <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                </tr>
                            <?php endforeach;
                        } ?>
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: ghostwhite"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: ghostwhite" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: ghostwhite" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: ghostwhite" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                            <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: ghostwhite" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php } ?>
</body>
</html>

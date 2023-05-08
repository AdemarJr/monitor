<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Quantitativo por Secretaria/Setor</title>
 	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url().'assets/plugins/bootstrap/css/bootstrap.css' ?>" rel="stylesheet" type="text/css" />
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
        
        //$lista_setor = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'I');
        if (!empty($isSetorMonitor)) {
            $lista_setor = $this->ComumModelo->quantitativoSetor2($datai, $dataf, $idCliente, 'I');
        } else {
            $lista_setor = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'I', NULL, NULL, NULL, $tags);
        }
//        echo $this->db->last_query();
//        die();
        if (!empty($lista_setor)){
            $controle=1;
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
                            <p style="font-size: 18px; font-weight: bold">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        <h4>CLIPPING IMPRESSO</h4>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td colspan="2" style="text-align:left" width="100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Secretaria/Setor</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                            <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                        </tr>
                        <?php
                        $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                        if (!empty($lista_setor)) {
                            foreach ($lista_setor as $itemS):
                                if ($itemS['TIPO_MATERIA']=='I') {
                                    $totalP += $itemS['POSITIVO'];
                                    $totalN += $itemS['NEGATIVO'];
                                    $totalT += $itemS['NEUTRO'];
                                    $totalG += $itemS['TOTAL'];

                                ?>
                        <tr>
                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESC_SETOR']; ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                            <?php } endforeach;
                        } ?>
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                            <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>
        <?php } ?>

        <?php
//        $lista_setor = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'S');
//        if (!empty($isSetorMonitor)) {
//            $lista_setor = $this->ComumModelo->quantitativoSetor2($datai, $dataf, $idCliente, 'S');
//        } else {
//            $lista_setor = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'S');
//        }
        if (!empty($lista_setor)){
            if ($controle>0) echo '<pagebreak />';
            $controle=1
            ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td height="80" style="text-align:center" width="20%">
                        <img src="<?php echo FCPATH . "assets/images/".$dataCliente->LOGO_EMPRESA; ?>" style="max-height: 70px"/>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;margin-left: 20px;padding-left: 10px" width="80%">
                        <div style="text-align:center;margin-left: 20px">
                            <p style="font-size: 18px; font-weight: bold">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>CLIPPING INTERNET</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td colspan="2" style="text-align:left" width="100%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Secretaria/Setor</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                            </tr>
                            <?php
                            $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                            if (!empty($lista_setor)) {
                                foreach ($lista_setor as $itemS):
                                    if ($itemS['TIPO_MATERIA']=='S') {
                                        $totalP += $itemS['POSITIVO'];
                                        $totalN += $itemS['NEGATIVO'];
                                        $totalT += $itemS['NEUTRO'];
                                        $totalG += $itemS['TOTAL'];
                                    ?>
                                    <tr>
                                        <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESC_SETOR']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                                        <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                    </tr>
                                <?php } endforeach;
                            } ?>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                                <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        <?php } ?>
        <?php
//            $lista_setor = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'R');
//        if (!empty($isSetorMonitor)) {
//            $lista_setor = $this->ComumModelo->quantitativoSetor2($datai, $dataf, $idCliente, 'R');
//        } else {
//            $lista_setor = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'R');
//        }
            if (!empty($lista_setor)){
                if ($controle>0) echo '<pagebreak />';
            ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td height="80" style="text-align:center" width="20%">
                            <img src="<?php echo FCPATH . "assets/images/".$dataCliente->LOGO_EMPRESA; ?>" style="max-height: 70px"/>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;margin-left: 20px;padding-left: 10px" width="80%">
                            <div style="text-align:center;margin-left: 20px">
                                <p style="font-size: 18px; font-weight: bold">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?><br/>
                                    <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            <h4>CLIPPING R&Aacute;DIO</h4>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td colspan="2" style="text-align:left" width="100%">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Secretaria/Setor</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                    <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                                </tr>
                                <?php
                                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                                if (!empty($lista_setor)) {
                                    foreach ($lista_setor as $itemS):
                                        if ($itemS['TIPO_MATERIA']=='R') {
                                            $totalP += $itemS['POSITIVO'];
                                            $totalN += $itemS['NEGATIVO'];
                                            $totalT += $itemS['NEUTRO'];
                                            $totalG += $itemS['TOTAL'];
                                        ?>
                                        <tr>
                                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESC_SETOR']; ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                                            <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                        </tr>
                                    <?php } endforeach;
                                } ?>
                                <tr>
                                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        <?php
//        $lista_setor = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'T');
//        if (!empty($isSetorMonitor)) {
//            $lista_setor = $this->ComumModelo->quantitativoSetor2($datai, $dataf, $idCliente, 'T');
//        } else {
//            $lista_setor = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'T');
//        }
        if (!empty($lista_setor)){
            if ($controle>0) echo '<pagebreak />';
            ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td height="80" style="text-align:center" width="20%">
                        <img src="<?php echo FCPATH . "assets/images/".$dataCliente->LOGO_EMPRESA; ?>" style="max-height: 70px"/>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;margin-left: 20px;padding-left: 10px" width="80%">
                        <div style="text-align:center;margin-left: 20px">
                            <p style="font-size: 18px; font-weight: bold">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>CLIPPING TELEVIS&Atilde;O</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td colspan="2" style="text-align:left" width="100%">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Secretaria/Setor</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                            </tr>
                            <?php
                            $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                            if (!empty($lista_setor)) {
                                foreach ($lista_setor as $itemS):
                                    if ($itemS['TIPO_MATERIA']=='T') {
                                        $totalP += $itemS['POSITIVO'];
                                        $totalN += $itemS['NEGATIVO'];
                                        $totalT += $itemS['NEUTRO'];
                                        $totalG += $itemS['TOTAL'];
                                    ?>
                                    <tr>
                                        <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESC_SETOR']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                                        <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                    </tr>
                                <?php } endforeach;
                            } ?>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                                <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        <?php } ?>

</body>
</html>

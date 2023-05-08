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

if (empty($isrelease)){
?>
    
        <?php
        
        $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'I',NULL,$isSetorMonitor, NULL, NULL, $tags);
       
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
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                            <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
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
                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                            <?php endforeach;
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
        $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'S',NULL,$isSetorMonitor, NULL, NULL, $tags);
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
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
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
                                        <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                                        <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                    </tr>
                                <?php endforeach;
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
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'R',NULL,$isSetorMonitor, NULL, NULL, $tags);
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
                                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                    <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
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
                                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                                            <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                        </tr>
                                    <?php endforeach;
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
            if (!empty($istempo)){
            $lista_setor = $this->ComumModelo->quantitativoVeiculoRadioTempo($datai,$dataf,$idCliente, NULL, NULL, $tags);
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
                <h4>CLIPPING R&Aacute;DIO - TEMPO</h4>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td colspan="2" style="text-align:left" width="100%">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                <tr>
                                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                    <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
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
                                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['POSITIVO']); ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['NEGATIVO']); ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['NEUTRO']); ?></div></td>
                                            <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['TOTAL']); ?></div></td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                                <tr>
                                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalP); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalN); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalT); ?></strong></div></td>
                                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalG); ?></strong></div></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php } }?>
        <?php
        $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'T',NULL,$isSetorMonitor, NULL, NULL, $tags);
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
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
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
                                        <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                                        <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                    </tr>
                                <?php endforeach;
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
            <?php
            if (!empty($istempo)){
                $lista_setor = $this->ComumModelo->quantitativoVeiculoTvTempo($datai,$dataf,$idCliente);
                if (!empty($lista_setor) or !empty($lista_setor2)){
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
                                        <span style="font-size: 16px; font-weight: bold">Ve&iacute;culo</span><br/>
                                        <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <h4>CLIPPING TELEVIS&Atilde;O - TEMPO</h4>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td colspan="2" style="text-align:left" width="100%">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tr>
                                        <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                        <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
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
                                                <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['POSITIVO']); ?></div></td>
                                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['NEGATIVO']); ?></div></td>
                                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['NEUTRO']); ?></div></td>
                                                <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['TOTAL']); ?></div></td>
                                            </tr>
                                        <?php endforeach;
                                    } ?>
                                    <tr>
                                        <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalP); ?></strong></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalN); ?></strong></div></td>
                                        <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalT); ?></strong></div></td>
                                        <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalG); ?></strong></div></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                <?php } }?>
        <?php } ?>
<?php } else {
//if (!empty($isrelease)){
    $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'I',$isrelease,$isSetorMonitor);
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
        <h4>RELEASE DE IMPRESSO</h4>
<!--        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">-->
<!--            <tr>-->
<!--                <td colspan="2" style="text-align:left" width="100%">-->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" autosize="1">
                        <tr>
                            <td height="15" style="width:10%;border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white">
                                <strong>Item</strong>
                            </td>
                            <td style="width:75%;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Ve&iacute;culo</strong></div></td>
                            <td  style="width:15%;border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                        </tr>
                        <?php
                        $totalP=0;$totalN=0;$totalT=0;$totalG=0; $item=1;
                        if (!empty($lista_setor)) {
                            foreach ($lista_setor as $itemS):
                                $totalP+=$itemS['POSITIVO'];
                                $totalN+=$itemS['NEGATIVO'];
                                $totalT+=$itemS['NEUTRO'];
                                $totalG+=$itemS['TOTAL'];
                                ?>
                                <tr>
                                    <td  height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $item++; ?></div></td>
                                    <td width="85%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="left"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                    <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                </tr>
                            <?php endforeach;
                        } ?>
                        <tr>
                            <td width="90%" height="30" colspan="2" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                            <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                        </tr>
                    </table>
<!--                </td>-->
<!--            </tr>-->
<!--        </table>-->
    <?php  $controle++; }
    $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'S',$isrelease,$isSetorMonitor);
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
        <h4>RELEASE DE INTERNET</h4>
<!--        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">-->
<!--            <tr>-->
<!--                <td colspan="2" style="text-align:left" width="100%">-->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td height="15" style="width:10%;border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white">
                                <strong>Item</strong>
                            </td>
                            <td style="width:75%;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Ve&iacute;culo</strong></div></td>
                            <td  style="width:15%;border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                        </tr>
                        <?php
                        $totalP=0;$totalN=0;$totalT=0;$totalG=0; $item=1;
                        if (!empty($lista_setor)) {
                            foreach ($lista_setor as $itemS):
                                $totalP+=$itemS['POSITIVO'];
                                $totalN+=$itemS['NEGATIVO'];
                                $totalT+=$itemS['NEUTRO'];
                                $totalG+=$itemS['TOTAL'];
                                ?>
                                <tr>
                                    <td  height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $item++; ?></div></td>
                                    <td width="85%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="left"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                    <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                </tr>
                            <?php endforeach;
                        } ?>
                        <tr>
                            <td width="90%" colspan="2" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                            <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                        </tr>
                    </table>
<!--                </td>-->
<!--            </tr>-->
<!--        </table>-->
    <?php   $controle++; }
    $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'R',$isrelease,$isSetorMonitor);
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
        <h4>RELEASE DE R&Aacute;DIO</h4>
<!--        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">-->
<!--            <tr>-->
<!--                <td colspan="2" style="text-align:left" width="100%">-->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td height="15" style="width:10%;border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white">
                                <strong>Item</strong>
                            </td>
                            <td style="width:75%;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Ve&iacute;culo</strong></div></td>
                            <td  style="width:15%;border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                        </tr>
                        <?php
                        $totalP=0;$totalN=0;$totalT=0;$totalG=0; $item=1;
                        if (!empty($lista_setor)) {
                            foreach ($lista_setor as $itemS):
                                $totalP+=$itemS['POSITIVO'];
                                $totalN+=$itemS['NEGATIVO'];
                                $totalT+=$itemS['NEUTRO'];
                                $totalG+=$itemS['TOTAL'];
                                ?>
                                <tr>
                                    <td  height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $item++; ?></div></td>
                                    <td width="85%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="left"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                    <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                </tr>
                            <?php endforeach;
                        } ?>
                        <tr>
                            <td width="90%" colspan="2" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                            <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                        </tr>
                    </table>
<!--                </td>-->
<!--            </tr>-->
<!--        </table>-->
    <?php  $controle++;}

    $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'T',$isrelease,$isSetorMonitor);
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
        <h4>RELEASE DE TELEVIS&Atilde;O</h4>
<!--        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">-->
<!--            <tr>-->
<!--                <td colspan="2" style="text-align:left" width="100%">-->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td height="15" style="width:10%;border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white">
                                <strong>Item</strong>
                            </td>
                            <td style="width:75%;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Ve&iacute;culo</strong></div></td>
                            <td  style="width:15%;border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                        </tr>
                        <?php
                        $totalP=0;$totalN=0;$totalT=0;$totalG=0; $item=1;
                        if (!empty($lista_setor)) {
                            foreach ($lista_setor as $itemS):
                                $totalP+=$itemS['POSITIVO'];
                                $totalN+=$itemS['NEGATIVO'];
                                $totalT+=$itemS['NEUTRO'];
                                $totalG+=$itemS['TOTAL'];
                                ?>
                                <tr>
                                    <td  height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $item++; ?></div></td>
                                    <td width="85%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="left"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                    <td width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                                </tr>
                            <?php endforeach;
                        } ?>
                        <tr>
                            <td width="90%" colspan="2" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                            <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                        </tr>
                    </table>
<!--                </td>-->
<!--            </tr>-->
<!--        </table>-->
    <?php  }?>
    <?php  }?>


</body>
</html>

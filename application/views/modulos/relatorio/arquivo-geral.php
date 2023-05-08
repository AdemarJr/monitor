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
<pagefooter name="myFooter1"
            content-left="My Book Title"
            content-center="myFooter1"
            content-right="{PAGENO}"
            footer-style="font-family:sans-serif; font-size:8pt; font-weight:bold; color:#008800;"
            footer-style-left=""
            line="on" />

<setpageheader name="myFooter1" page="E" value="on" />
<style>
    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
</style>
<!--<body class="" onload="window.print()" >-->
<?php
$dataCliente = $this->ComumModelo->getCliente($idCliente)->row();
$controle=0;
?>

        <?php
        
        $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'I',NULL,NULL,$excluirSetor,$setores, $tags);
       
        $lista_setorP = $this->ComumModelo->quantitativoSetorPanorama($datai,$dataf,$idCliente,'I',$grupo,$excluirSetor,$setores, $tags);
        $lista_setor2 = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'I',$grupo,$excluirSetor,$setores, $tags);

        $totalP=0;$totalN=0;$totalT=0;$totalG=0;
        $result_array_i = array(
            'POSITIVO'=>0,
            'NEGATIVO'=>0,
            'NEUTRO'=>0,
            'TOTAL'=>0
        );
        $result_array_s = array(
            'POSITIVO'=>0,
            'NEGATIVO'=>0,
            'NEUTRO'=>0,
            'TOTAL'=>0
        );
        $result_array_r = array(
            'POSITIVO'=>0,
            'NEGATIVO'=>0,
            'NEUTRO'=>0,
            'TOTAL'=>0
        );
        $result_array_t = array(
            'POSITIVO'=>0,
            'NEGATIVO'=>0,
            'NEUTRO'=>0,
            'TOTAL'=>0
        );
        if (!empty($lista_setorP)) {
            foreach ($lista_setorP as $itemS):
               // if (empty($setores) or in_array($itemS['SEQ_SETOR'],explode(',',$setores))){
                    if ($itemS['TIPO_MATERIA']=='I' ) {
                        $result_array_i['POSITIVO']+=$itemS['POSITIVO'];
                        $result_array_i['NEGATIVO']+=$itemS['NEGATIVO'];
                        $result_array_i['NEUTRO']+=$itemS['NEUTRO'];
                        $result_array_i['TOTAL']+=$itemS['TOTAL'];
                    } else if ($itemS['TIPO_MATERIA']=='S') {
                        $result_array_s['POSITIVO']+=$itemS['POSITIVO'];
                        $result_array_s['NEGATIVO']+=$itemS['NEGATIVO'];
                        $result_array_s['NEUTRO']+=$itemS['NEUTRO'];
                        $result_array_s['TOTAL']+=$itemS['TOTAL'];
                    } else if ($itemS['TIPO_MATERIA']=='R') {
                        $result_array_r['POSITIVO']+=$itemS['POSITIVO'];
                        $result_array_r['NEGATIVO']+=$itemS['NEGATIVO'];
                        $result_array_r['NEUTRO']+=$itemS['NEUTRO'];
                        $result_array_r['TOTAL']+=$itemS['TOTAL'];
                    } else if ($itemS['TIPO_MATERIA']=='T') {
                        $result_array_t['POSITIVO']+=$itemS['POSITIVO'];
                        $result_array_t['NEGATIVO']+=$itemS['NEGATIVO'];
                        $result_array_t['NEUTRO']+=$itemS['NEUTRO'];
                        $result_array_t['TOTAL']+=$itemS['TOTAL'];
                    }
             //   }
            endforeach;
        }

        if (!empty($lista_setorP)) {
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
                                <span style="font-size: 16px; font-weight: bold">Panorama Geral</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA GERAL</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px">Impresso</div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_i['POSITIVO'],0,',','.').'('.number_format(($result_array_i['POSITIVO']/$result_array_i['TOTAL']*100),2,',','.').'%)'; ?></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_i['NEGATIVO'],0,',','.').'('.number_format(($result_array_i['NEGATIVO']/$result_array_i['TOTAL']*100),2,',','.').'%)'; ?></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_i['NEUTRO'],0,',','.').'('.number_format(($result_array_i['NEUTRO']/$result_array_i['TOTAL']*100),2,',','.').'%)'; ?></div></td>
                    <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_i['TOTAL'],0,',','.'); ?></div></td>
                </tr>
                <tr>
                    <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px">Internet</div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_s['POSITIVO'],0,',','.').'('.number_format(($result_array_s['POSITIVO']/$result_array_s['TOTAL']*100),2,',','.').'%)'; ?></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_s['NEGATIVO'],0,',','.').'('.number_format(($result_array_s['NEGATIVO']/$result_array_s['TOTAL']*100),2,',','.').'%)'; ?></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_s['NEUTRO'],0,',','.').'('.number_format(($result_array_s['NEUTRO']/$result_array_s['TOTAL']*100),2,',','.').'%)'; ?></div></td>
                    <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_s['TOTAL'],0,',','.'); ?></div></td>
                </tr>
                <tr>
                    <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px">R&aacute;dio</div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_r['POSITIVO'],0,',','.').'('.number_format(($result_array_r['POSITIVO']/$result_array_r['TOTAL']*100),2,',','.').'%)'; ?></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_r['NEGATIVO'],0,',','.').'('.number_format(($result_array_r['NEGATIVO']/$result_array_r['TOTAL']*100),2,',','.').'%)'; ?></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_r['NEUTRO'],0,',','.').'('.number_format(($result_array_t['NEUTRO']/$result_array_r['TOTAL']*100),2,',','.').'%)'; ?></div></td>
                    <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_r['TOTAL'],0,',','.'); ?></div></td>
                </tr>
                <tr>
                    <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px">Televis&atilde;o</div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_t['POSITIVO'],0,',','.').'('.(($result_array_t['TOTAL']>0)? number_format(($result_array_t['POSITIVO']/$result_array_t['TOTAL']*100),2,',','.'):'0').'%)'; ?></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_t['NEGATIVO'],0,',','.').'('.(($result_array_t['TOTAL']>0)? number_format(($result_array_t['NEGATIVO']/$result_array_t['TOTAL']*100),2,',','.'):'0').'%)'; ?></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_t['NEUTRO'],0,',','.').'('.  (($result_array_t['TOTAL']>0)? number_format(($result_array_t['NEUTRO']/$result_array_t['TOTAL']*100),2,',','.'):'0').'%)'; ?></div></td>
                    <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($result_array_t['TOTAL'],0,',','.'); ?></div></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format(($result_array_i['POSITIVO']+$result_array_s['POSITIVO']+$result_array_r['POSITIVO']+$result_array_t['POSITIVO']),0,',','.').'('.number_format(((($result_array_i['POSITIVO']+$result_array_s['POSITIVO']+$result_array_r['POSITIVO']+$result_array_t['POSITIVO'])/($result_array_i['TOTAL']+$result_array_s['TOTAL']+$result_array_r['TOTAL']+$result_array_t['TOTAL']))*100),2,',','.').'%)'; ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format(($result_array_i['NEGATIVO']+$result_array_s['NEGATIVO']+$result_array_r['NEGATIVO']+$result_array_t['NEGATIVO']),0,',','.').'('.number_format(((($result_array_i['NEGATIVO']+$result_array_s['NEGATIVO']+$result_array_r['NEGATIVO']+$result_array_t['NEGATIVO'])/($result_array_i['TOTAL']+$result_array_s['TOTAL']+$result_array_r['TOTAL']+$result_array_t['TOTAL']))*100),2,',','.').'%)'; ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format(($result_array_i['NEUTRO']+$result_array_s['NEUTRO']+$result_array_r['NEUTRO']+$result_array_t['NEUTRO']),0,',','.').'('.number_format(((($result_array_i['NEUTRO']+$result_array_s['NEUTRO']+$result_array_r['NEUTRO']+$result_array_t['NEUTRO'])/($result_array_i['TOTAL']+$result_array_s['TOTAL']+$result_array_r['TOTAL']+$result_array_t['TOTAL']))*100),2,',','.').'%)'; ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format(($result_array_i['TOTAL']+$result_array_s['TOTAL']+$result_array_r['TOTAL']+$result_array_t['TOTAL']),0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }

        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSeguranca($datai,$dataf,$idCliente,$grupo,'I',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Bairro</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR BAIRRO - IMPRESSO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Bairro</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['BAIRRO_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }


        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSeguranca($datai,$dataf,$idCliente,$grupo,'S',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Bairro</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR BAIRRO - INTERNET</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Bairro</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['BAIRRO_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }


        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSeguranca($datai,$dataf,$idCliente,$grupo,'R',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Bairro</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR BAIRRO - R&Aacute;DIO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Bairro</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['BAIRRO_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }



        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSeguranca($datai,$dataf,$idCliente,$grupo,'T',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Bairro</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR BAIRRO - TV</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Bairro</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['BAIRRO_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }
        // por crime

        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaCrime($datai,$dataf,$idCliente,$grupo,'I',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Tipo de Crime</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR TIPO DE CRIME - IMPRESSO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Tipo do Crime</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['TIPO_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }


        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaCrime($datai,$dataf,$idCliente,$grupo,'S',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Tipo de Crime</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR TIPO DE CRIME - INTERNET</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Tipo do Crime</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['TIPO_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }


        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaCrime($datai,$dataf,$idCliente,$grupo,'R',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Tipo de Crime</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR TIPO DE CRIME - R&Aacute;DIO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Tipo do Crime</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['TIPO_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }



        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaCrime($datai,$dataf,$idCliente,$grupo,'T',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Tipo de Crime</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR TIPO DE CRIME - TV</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Tipo do Crime</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['TIPO_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }
        // por local

        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaLocal($datai,$dataf,$idCliente,$grupo,'I',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Local</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR LOCAL - IMPRESSO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Local</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['LOCAL_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }


        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaLocal($datai,$dataf,$idCliente,$grupo,'S',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Local</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR LOCAL - INTERNET</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Local</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['LOCAL_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }


        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaLocal($datai,$dataf,$idCliente,$grupo,'R',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Local</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR LOCAL - R&Aacute;DIO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Local</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['LOCAL_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }



        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaLocal($datai,$dataf,$idCliente,$grupo,'T',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Local</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR LOCAL - TV</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Local</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['LOCAL_CRIME']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }

        // por Prisao

        if (!empty($idCliente) and $idCliente==10) {

            if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaPrisao($datai,$dataf,$idCliente,$grupo,'I',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

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
                                <span style="font-size: 16px; font-weight: bold">Panorama por Ocorr&ecirc;ncia de Pris&atilde;o</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>PANORAMA POR OCORR&Ecirc;NCIA DE PRIS&Atilde;O - IMPRESSO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ocorr&ecirc;ncia de Pris&atilde;o?</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php if (!empty($itemS['IND_PRISAO']) and $itemS['IND_PRISAO']=='S') echo 'Sim'; else if (!empty($itemS['IND_PRISAO']) and $itemS['IND_PRISAO']=='N') echo 'N&atilde;o'; else echo ''; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }


        if (!empty($idCliente) and $idCliente==10) {

        //   if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaPrisao($datai,$dataf,$idCliente,$grupo,'S',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

            $controle=1;
            ?>
<!--            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">-->
<!--                <tr>-->
<!--                    <td height="80" style="text-align:center" width="20%">-->
<!--                        <img src="--><?php //echo FCPATH . "assets/images/".$dataCliente->LOGO_EMPRESA; ?><!--" style="max-height: 100px"/>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td style="text-align:center;margin-left: 20px;padding-left: 10px" width="80%">-->
<!--                        <div style="text-align:center;margin-left: 20px">-->
<!--                            <p style="font-size: 18px; font-weight: bold">CLIPPING --><?php //echo strtoupper($dataCliente->NOME_CLIENTE); ?><!--<br/>-->
<!--                                <span style="font-size: 16px; font-weight: bold">Panorama por Ocorr&ecirc;ncia de Pris&atilde;o</span><br/>-->
<!--                                <span style="font-size: 16px; font-weight: bold">--><?php //echo $datai.' - '. $dataf; ?><!--</span><br/>-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </td>-->
<!--                </tr>-->
<!--            </table>-->
            <h4>PANORAMA POR OCORR&Ecirc;NCIA DE PRIS&Atilde;O - INTERNET</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ocorr&ecirc;ncia de Pris&atilde;o?</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php if (!empty($itemS['IND_PRISAO']) and $itemS['IND_PRISAO']=='S') echo 'Sim'; else if (!empty($itemS['IND_PRISAO']) and $itemS['IND_PRISAO']=='N') echo 'N&atilde;o'; else echo ''; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }


        if (!empty($idCliente) and $idCliente==10) {

         //   if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaPrisao($datai,$dataf,$idCliente,$grupo,'R',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

            $controle=1;
            ?>
<!--            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">-->
<!--                <tr>-->
<!--                    <td height="80" style="text-align:center" width="20%">-->
<!--                        <img src="--><?php //echo FCPATH . "assets/images/".$dataCliente->LOGO_EMPRESA; ?><!--" style="max-height: 100px"/>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td style="text-align:center;margin-left: 20px;padding-left: 10px" width="80%">-->
<!--                        <div style="text-align:center;margin-left: 20px">-->
<!--                            <p style="font-size: 18px; font-weight: bold">CLIPPING --><?php //echo strtoupper($dataCliente->NOME_CLIENTE); ?><!--<br/>-->
<!--                                <span style="font-size: 16px; font-weight: bold">Panorama por Ocorr&ecirc;ncia de Pris&atilde;o</span><br/>-->
<!--                                <span style="font-size: 16px; font-weight: bold">--><?php //echo $datai.' - '. $dataf; ?><!--</span><br/>-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </td>-->
<!--                </tr>-->
<!--            </table>-->
            <h4>PANORAMA POR OCORR&Ecirc;NCIA DE PRIS&Atilde;O - R&Aacute;DIO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ocorr&ecirc;ncia de Pris&atilde;o?</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php if (!empty($itemS['IND_PRISAO']) and $itemS['IND_PRISAO']=='S') echo 'Sim'; else if (!empty($itemS['IND_PRISAO']) and $itemS['IND_PRISAO']=='N') echo 'N&atilde;o'; else echo ''; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }



        if (!empty($idCliente) and $idCliente==10) {

         //   if ($controle>0) echo '<pagebreak />';

            $lista_seguranca = $this->ComumModelo->quantitativoVeiculoSegurancaPrisao($datai,$dataf,$idCliente,$grupo,'T',NULL,
                $tipoCrime,$bairroCrime,$localCrime,$indPreso);

            $controle=1;
            ?>
<!--            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">-->
<!--                <tr>-->
<!--                    <td height="80" style="text-align:center" width="20%">-->
<!--                        <img src="--><?php //echo FCPATH . "assets/images/".$dataCliente->LOGO_EMPRESA; ?><!--" style="max-height: 100px"/>-->
<!--                    </td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td style="text-align:center;margin-left: 20px;padding-left: 10px" width="80%">-->
<!--                        <div style="text-align:center;margin-left: 20px">-->
<!--                            <p style="font-size: 18px; font-weight: bold">CLIPPING --><?php //echo strtoupper($dataCliente->NOME_CLIENTE); ?><!--<br/>-->
<!--                                <span style="font-size: 16px; font-weight: bold">Panorama por Ocorr&ecirc;ncia de Pris&atilde;o</span><br/>-->
<!--                                <span style="font-size: 16px; font-weight: bold">--><?php //echo $datai.' - '. $dataf; ?><!--</span><br/>-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </td>-->
<!--                </tr>-->
<!--            </table>-->
            <h4>PANORAMA POR OCORR&Ecirc;NCIA DE PRIS&Atilde;O - TV</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                <tr>
                    <td width="40%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ocorr&ecirc;ncia de Pris&atilde;o?</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo(%)</strong></div></td>
                    <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro(%)</strong></div></td>
                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                </tr>
                </thead>
                <tbody>

                <?php
                $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                if (!empty($lista_seguranca)) {
                    foreach ($lista_seguranca as $itemS):
                        $totalP+=$itemS['POSITIVO'];
                        $totalN+=$itemS['NEGATIVO'];
                        $totalT+=$itemS['NEUTRO'];
                        $totalG+=$itemS['TOTAL'];
                        ?>
                        <tr>
                            <td width="40%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php if (!empty($itemS['IND_PRISAO']) and $itemS['IND_PRISAO']=='S') echo 'Sim'; else if (!empty($itemS['IND_PRISAO']) and $itemS['IND_PRISAO']=='N') echo 'N&atilde;o'; else echo ''; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['POSITIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEGATIVO']; ?></div></td>
                            <td width="15%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['NEUTRO']; ?></div></td>
                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo $itemS['TOTAL']; ?></div></td>
                        </tr>
                    <?php endforeach;
                } ?>


                </tbody>
                <tfoot>
                <tr>
                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                </tr>
                </tfoot>
            </table>
        <?php }
        if (!empty($lista_setor)) {
            if ($controle>0) echo '<pagebreak />';
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
                                <span style="font-size: 16px; font-weight: bold">Ve&iacute;culo</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        <h4>CLIPPING IMPRESSO</h4>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <thead>
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                            <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                        </tr>
            </thead>
            <tbody>
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
            </tbody>
            <tfoot>
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                            <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                        </tr>
            </tfoot>
                    </table>
        <?php } ?>
        <?php
//        $lista_setor2 = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'I');
        if (!empty($lista_setor2)){
            if ($controle>0) echo '<pagebreak />';
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
                                <span style="font-size: 16px; font-weight: bold">Secretaria/Setor</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>CLIPPING IMPRESSO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Secretaria/Setor</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                            </tr>
                            </thead>
                <tbody>
                            <?php
                            $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                            if (!empty($lista_setor2)) {
                                foreach ($lista_setor2 as $itemS):
                                    if ($itemS['TIPO_MATERIA']=='I') {
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
                                <?php } endforeach;
                            } ?>
                </tbody>
                <tfoot>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                                <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                            </tr>
                </tfoot>
                        </table>
        <?php } ?>

        <?php
        $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'S',NULL,NULL,$excluirSetor,$setores, $tags);
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
                                <span style="font-size: 16px; font-weight: bold">Ve&iacute;culo</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>CLIPPING INTERNET</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <thead>
                            <tr>
                                <th width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></th>
                                <th width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></th>
                                <th width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></th>
                                <th width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></th>
                                <th  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></th>
                            </tr>
                            </thead>
                            <tbody>
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
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></th>
                                    <th width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></th>
                                    <th width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></th>
                                    <th width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></th>
                                    <th  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></th>
                                </tr>
                            </tfoot>
                        </table>
        <?php } ?>
        <?php
        $lista_setor3= $this->ComumModelo->quantitativoSetorInternet($datai,$dataf,$idCliente,'S',$grupo,$excluirSetor,$setores, $tags);
        if (!empty($lista_setor3)){
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
                                <span style="font-size: 16px; font-weight: bold">Secretaria/Setor</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>CLIPPING INTERNET</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <thead>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Secretaria/Setor</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                            </tr>
                            </thead>
                <tbody>
                            <?php
                            $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                            if (!empty($lista_setor3)) {
                                foreach ($lista_setor3 as $itemS):
                                    if ($itemS['TIPO_MATERIA']=='S') {
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
                                <?php } endforeach;
                            } ?>
                </tbody>
                <tfoot>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                                <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                            </tr>
                </tfoot>
                        </table>
        <?php } ?>

        <?php
            $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'R',NULL,NULL,$excluirSetor,$setores, $tags);
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
                                    <span style="font-size: 16px; font-weight: bold">Ve&iacute;culo</span><br/>
                                    <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            <h4>CLIPPING R&Aacute;DIO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                                <tr>
                                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                    <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                                </tr>
                </thead>
                <tbody>
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
                </tbody>
                <tfoot>
                                <tr>
                                    <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                                    <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                                </tr>
                </tfoot>
                            </table>
            <?php } ?>
        <?php
//        $lista_setor2 = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'R');
        if (!empty($lista_setor2)){
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
                                <span style="font-size: 16px; font-weight: bold">Secretaria/Setor</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>CLIPPING R&Aacute;DIO</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Secretaria/Setor</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                            </tr>
                </thead>
                <tbody>
                            <?php
                            $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                            if (!empty($lista_setor2)) {
                                foreach ($lista_setor2 as $itemS):
                                    if ($itemS['TIPO_MATERIA']=='R') {
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
                                <?php } endforeach;
                            } ?>
                </tbody>
                <tfoot>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                                <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                            </tr>
                </tfoot>
                        </table>
        <?php } ?>
            <?php
            if (!empty($istempo)){
            $lista_setor = $this->ComumModelo->quantitativoVeiculoRadioTempo($datai,$dataf,$idCliente,$excluirSetor,$setores, $tags);
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
                <h4>CLIPPING R&Aacute;DIO - TEMPO</h4>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <thead>
                                <tr>
                                    <td width="55%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                                </tr>
                    </thead>
                    <tbody>
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
                                            <td width="55%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['POSITIVO']); ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['NEGATIVO']); ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['NEUTRO']); ?></div></td>
                                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['TOTAL']); ?></div></td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                    </tbody>
                    <tfoot>
                                <tr>
                                    <td width="55%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalP); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalN); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalT); ?></strong></div></td>
                                    <td  width="15%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalG); ?></strong></div></td>
                                </tr>
                    </tfoot>
                            </table>
            <?php } }?>
        <?php
        $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai,$dataf,$idCliente,$grupo,'T',NULL,NULL,$excluirSetor,$setores, $tags);
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
            <h4>CLIPPING TELEVIS&Atilde;O</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                            </tr>
                </thead>
                <tbody>
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
                </tbody>
                <tfoot>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                                <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                            </tr>
                </tfoot>
                        </table>
        <?php } ?>
        <?php
        if (!empty($istempo)){
            $lista_setor = $this->ComumModelo->quantitativoVeiculoTvTempo($datai,$dataf,$idCliente,$excluirSetor,$setores,$tags);
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
                    <thead>
                                <tr>
                                    <td width="55%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Ve&iacute;culo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                    <td  width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                                </tr>
                    </thead>
                    <tbody>
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
                                            <td width="55%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS['DESCRICAO']; ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['POSITIVO']); ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['NEGATIVO']); ?></div></td>
                                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['NEUTRO']); ?></div></td>
                                            <td width="15%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo convertSegundo2HMS($itemS['TOTAL']); ?></div></td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                    </tbody>
                    <tfoot>
                                <tr>
                                    <td width="55%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalP); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalN); ?></strong></div></td>
                                    <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalT); ?></strong></div></td>
                                    <td  width="15%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo convertSegundo2HMS($totalG); ?></strong></div></td>
                                </tr>
                    </tfoot>
                            </table>
            <?php } }?>
        <?php
//        $lista_setor2 = $this->ComumModelo->quantitativoSetor($datai,$dataf,$idCliente,'T');
        if (!empty($lista_setor2)){
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
                                <span style="font-size: 16px; font-weight: bold">Secretaria/Setor</span><br/>
                                <span style="font-size: 16px; font-weight: bold"><?php echo $datai.' - '. $dataf; ?></span><br/>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <h4>CLIPPING TELEVIS&Atilde;O</h4>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <thead>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Secretaria/Setor</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Positivo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Negativo</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Neutro</strong></div></td>
                                <td  width="10%" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>Total</strong></div></td>
                            </tr>
                </thead>
                <tbody>
                            <?php
                            $totalP=0;$totalN=0;$totalT=0;$totalG=0;
                            if (!empty($lista_setor2)) {
                                foreach ($lista_setor2 as $itemS):
                                    if ($itemS['TIPO_MATERIA']=='T') {
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
                                <?php } endforeach;
                            } ?>
                </tbody>
                <tfoot>
                            <tr>
                                <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>Total</strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalP,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalN,0,',','.'); ?></strong></div></td>
                                <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalT,0,',','.'); ?></strong></div></td>
                                <td  width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px"><strong><?php echo number_format($totalG,0,',','.'); ?></strong></div></td>
                            </tr>
                </tfoot>
                        </table>
        <?php } ?>

</body>
</html>

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
<?php
$dataCliente = $this->ComumModelo->getCliente($idCliente)->row();
?>    
<style>
    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    .quebrapagina {
        page-break-after: always;
    }
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td height="80" style="text-align:center" width="20%">
            <img src="<?php echo FCPATH . "assets/images/" . $dataCliente->LOGO_EMPRESA; ?>" style="max-height: 100px"/>
        </td>
    </tr>
    <tr>
        <td style="text-align:center;margin-left: 20px;padding-left: 10px" width="80%">
            <div style="text-align:center;margin-left: 20px">
                <p style="font-size: 18px; font-weight: bold">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?><br/>
                    <span style="font-size: 16px; font-weight: bold"><?php echo implode('/', array_reverse(explode('-', $datai))) . ' - ' . implode('/', array_reverse(explode('-', $dataf))); ?></span><br/>
                </p>
            </div>
        </td>
    </tr>
</table>    
        <?php
        $SQL = 'SELECT v.FANTASIA_VEICULO as NOME_VEICULO, SUM(m.SEQ_PRECO) as PRECO FROM MATERIA m
                JOIN VEICULO v ON v.SEQ_VEICULO = m.SEQ_VEICULO
                WHERE SEQ_PRECO IS NOT NULL AND m.SEQ_CLIENTE = '.$idCliente.'
                AND DATA_PUB_NUMERO BETWEEN "'. str_replace('-', '', $datai).'" AND "'.str_replace('-', '', $dataf).'"
                AND TIPO_MATERIA = "I"
                GROUP BY m.SEQ_VEICULO';    
        $lista = $this->db->query($SQL)->result();
        if (!empty($lista)){
        ?>
        <h4>CLIPPING IMPRESSO</h4>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td colspan="2" style="text-align:left" width="100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>VEÍCULO</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>PREÇO</strong></div></td>
                        </tr>
                        <?php
                        if (!empty($lista)) {
                            $total = 0;
                            foreach ($lista as $itemS):
                        ?>
                        <tr>
                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS->NOME_VEICULO ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($itemS->PRECO,2,",",".") ?></div></td>
                        </tr>
                        <?php 
                        $total += $itemS->PRECO;
                        endforeach;
                        } ?>
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>TOTAL</strong></div></td>
                            <td width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px">R$ <?= number_format($total,2,",",".") ?></div></td>

                        </tr>
                    </table>
                </td>
            </tr>
		</table>
        <?php } ?>

        <?php
        $SQL = 'SELECT v.NOME_TV as NOME_VEICULO, SUM(m.SEQ_PRECO) as PRECO FROM MATERIA m
                JOIN TELEVISAO v ON v.SEQ_TV = m.SEQ_TV
                WHERE SEQ_PRECO IS NOT NULL AND m.SEQ_CLIENTE = '.$idCliente.'
                AND DATA_PUB_NUMERO BETWEEN "'. str_replace('-', '', $datai).'" AND "'.str_replace('-', '', $dataf).'"
                AND TIPO_MATERIA = "T"
                GROUP BY m.SEQ_TV';  
        $lista = $this->db->query($SQL)->result();
        if (!empty($lista)){
        ?>
        <h4>CLIPPING TELEVISÃO</h4>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td colspan="2" style="text-align:left" width="100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>VEÍCULO</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>PREÇO</strong></div></td>
                        </tr>
                        <?php
                        if (!empty($lista)) {
                            $total = 0;
                            foreach ($lista as $itemS):
                        ?>
                        <tr>
                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS->NOME_VEICULO ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($itemS->PRECO,2,",",".") ?></div></td>
                        </tr>
                        <?php 
                        $total += $itemS->PRECO;
                        endforeach;
                        } ?>
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>TOTAL</strong></div></td>
                            <td width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px">R$ <?= number_format($total,2,",",".") ?></div></td>

                        </tr>
                    </table>
                </td>
            </tr>
		</table>
        <?php } ?>
        
        <?php
        $SQL = 'SELECT v.NOME_PORTAL as NOME_VEICULO, SUM(m.SEQ_PRECO) as PRECO FROM MATERIA m
                JOIN PORTAL v ON v.SEQ_PORTAL = m.SEQ_PORTAL
                WHERE SEQ_PRECO IS NOT NULL AND m.SEQ_CLIENTE = '.$idCliente.'
                AND DATA_PUB_NUMERO BETWEEN "'. str_replace('-', '', $datai).'" AND "'.str_replace('-', '', $dataf).'"
                AND TIPO_MATERIA = "S"
                GROUP BY m.SEQ_PORTAL';  
        $lista = $this->db->query($SQL)->result();
        if (!empty($lista)){
        ?>
        <h4>CLIPPING INTERNET</h4>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td colspan="2" style="text-align:left" width="100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>VEÍCULO</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>PREÇO</strong></div></td>
                        </tr>
                        <?php
                        if (!empty($lista)) {
                            $total = 0;
                            foreach ($lista as $itemS):
                        ?>
                        <tr>
                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS->NOME_VEICULO ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($itemS->PRECO,2,",",".") ?></div></td>
                        </tr>
                        <?php 
                        $total += $itemS->PRECO;
                        endforeach;
                        } ?>
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>TOTAL</strong></div></td>
                            <td width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px">R$ <?= number_format($total,2,",",".") ?></div></td>

                        </tr>
                    </table>
                </td>
            </tr>
		</table>
        <?php } ?>
        
        <?php
        $SQL = 'SELECT v.NOME_RADIO as NOME_VEICULO, SUM(m.SEQ_PRECO) as PRECO FROM MATERIA m
                JOIN RADIO v ON v.SEQ_RADIO = m.SEQ_RADIO
                WHERE SEQ_PRECO IS NOT NULL AND m.SEQ_CLIENTE = '.$idCliente.'
                AND DATA_PUB_NUMERO BETWEEN "'. str_replace('-', '', $datai).'" AND "'.str_replace('-', '', $dataf).'"
                AND TIPO_MATERIA = "R"
                GROUP BY m.SEQ_RADIO';  
        $lista = $this->db->query($SQL)->result();
        if (!empty($lista)){
        ?>
        <h4>CLIPPING RÁDIO</h4>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td colspan="2" style="text-align:left" width="100%">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>VEÍCULO</strong></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black; background-color: #018ed6; color: white" align="center"><div style="text-align:center;"><strong>PREÇO</strong></div></td>
                        </tr>
                        <?php
                        if (!empty($lista)) {
                            $total = 0;
                            foreach ($lista as $itemS):
                        ?>
                        <tr>
                            <td width="60%" height="15" style="border-top: 1px solid black;border-left: 1px solid black;padding-left: 7px"><div style="text-align:left;margin-left: 20px;font-size: 14px"><?php echo $itemS->NOME_VEICULO ?></div></td>
                            <td width="10%" style="border-left: 1px solid black;border-top: 1px solid black;padding-right: 10px" align="right"><div style="text-align:right;margin-right: 20px"><?php echo number_format($itemS->PRECO,2,",",".") ?></div></td>
                        </tr>
                        <?php 
                        $total += $itemS->PRECO;
                        endforeach;
                        } ?>
                        <tr>
                            <td width="60%" height="30" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 7px; background-color: #018ed6; color: white"><div style="text-align:left;margin-left: 20px"><strong>TOTAL</strong></div></td>
                            <td width="10%" style="border: 1px solid black;padding-right: 10px; background-color: #018ed6; color: white" align="right"><div style="text-align:right;margin-right: 20px">R$ <?= number_format($total,2,",",".") ?></div></td>

                        </tr>
                    </table>
                </td>
            </tr>
		</table>
        <?php } ?>
</body>
</html>

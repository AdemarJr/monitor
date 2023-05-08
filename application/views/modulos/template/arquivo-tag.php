<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Tags mais usadas - <?php echo $titulo; ?></title>
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
<table width="60%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td height="50" colspan="2" style="text-align:center;border: 1px solid black;" width="100%">
            <h4><?php echo $titulo; ?> - TAGS MAIS USADAS</h4>
        </td>
    </tr>
        <?php if (!empty($tags_contadas)) {
        $qtdTotal =0;
            $linhas =0;
        foreach ($tags_contadas as $chave =>$valor){
            $qtdTotal+=$valor;
        }
        foreach ($tags_contadas as $chave =>$valor):
        $arrayMat = $this->ComumModelo->listMateriaTag($chave,$datai,$dataf);
            $linhas++;
        ?>
            <tr>
                <td height="30" style="text-align:center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;" width="60%">
                                        <?php echo $chave; ?>
                </td>
                <td height="30" style="text-align:center;border-bottom: 1px solid black;border-right: 1px solid black;" width="40%">
                    <span><?php echo $valor.' ('.number_format((($valor/$qtdTotal)*100),2,'.',',').'%)'; ?></span>
                </td>
            </tr>
        <?php endforeach;
        } else { ?>
            <h5>NENHUMA MAT&Eacute;RIA</h5>
        <?php } ?>
</table>
</body>
</html>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?php 
    $background ='background';
      if ($_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO1 and $_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO2
      and $_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO3) { ?>
      <title>Porto - Monitoramento de Not&iacute;cias em Tempo Real</title>
      <link rel="shortcut icon" href="<?php echo base_url().'assets/images/porto-ico.png' ?>">
    <?php } else { $background ='background-eleicao'; ?>
      <title>Elei&ccedil;&otilde;es <?= date('Y')?></title>
      <link rel="shortcut icon" type="image/x-icon" href="http://www.tse.jus.br/favicon.ico">
    <?php } ?>
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url().'assets/plugins/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url().'assets/plugins/node-waves/waves.css'?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url().'assets/plugins/animate-css/animate.css'?>" rel="stylesheet" type="text/css" />

      <link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url().'assets/plugins/jQuery/jQuery-2.1.4.min.js'?>"></script>

    <style>
        #background {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          color: #000;
          background-color: #000000;
          background-image: url("assets/images/clipping.jpg");
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
          z-index: -1000;

          opacity: 0.6;
          filter:alpha(opacity=60);
      }
      #background-eleicao {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          color: #000;
          background-color: #000000;
          background-image: linear-gradient(140deg, white 0%, grey 50%, white 90%);
          /* background-image: url(""); */
          background-repeat: no-repeat;
          /* background-attachment: fixed; */
          /* background-size: cover; */
          z-index: -1000;
          opacity: 0.9;
          filter:alpha(opacity=90);
      }

    </style>
  </head>
  <body class="login-page">
  <div id="<?php echo $background; ?>"></div>

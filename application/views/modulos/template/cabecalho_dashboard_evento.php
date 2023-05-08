<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php if ($_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO1 and $_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO2
        and $_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO3) { ?>
        <title>Porto - Monitoramento de Not&iacute;cias em Tempo Real</title>
    <link rel="shortcut icon" href="<?php echo base_url().'assets/images/porto-ico.png' ?>">
        <?php 
        } else if ($_SERVER['SERVER_NAME']==SERVER_NAME_ELEICAO1) { 
        $isEleicao = true;    
        ?>
        <title>Carlos Almeida</title>
        <link rel="shortcut icon" href="<?php echo base_url().'assets/images/user.png' ?>">
    <?php } else { ?>
      <title>Elei&ccedil;&otilde;es <?= date('Y')?></title>
    <?php } ?>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

      <!-- Bootstrap Core Css -->
      <link href="<?php echo base_url().'assets/plugins/bootstrap/css/bootstrap.css' ?>" rel="stylesheet" type="text/css" />

      <!-- iCheck -->
      <link href="<?php echo base_url().'assets/plugins/node-waves/waves.css'?>" rel="stylesheet" type="text/css" />
      <!--dataTables-->
      <link href="<?php echo base_url().'assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css'?>" rel="stylesheet" type="text/css" />

      <!-- Animation Css -->
      <link href="<?php echo base_url().'assets/plugins/animate-css/animate.css'?>" rel="stylesheet" type="text/css" />

      <!-- Bootstrap Select Css -->
      <link href="<?php echo base_url().'assets/plugins/bootstrap-select/css/bootstrap-select.css'?>" rel="stylesheet" type="text/css" />

      <!-- Bootstrap Material Datetime Picker Css -->
      <link href="<?php echo base_url().'assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'?>" rel="stylesheet" type="text/css" />
      <!-- Light Gallery Plugin Css -->
      <link href="<?php echo base_url().'assets/plugins/light-gallery/css/lightgallery.css'?>" rel="stylesheet" type="text/css" />
      <!-- Custom Css -->
      <link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet" type="text/css" />
      <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
      <link href="<?php echo base_url().'assets/css/themes/all-themes.css'?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url().'assets/plugins/bootstrap-autocomplete/bootcomplete.css'?>" rel="stylesheet" type="text/css" />
      <script src="<?php echo base_url().'assets/plugins/jQuery/jQuery-2.1.4.min.js'?>"></script>
      <script src="<?php echo base_url().'assets/plugins/bootstrap-autocomplete/jquery.bootcomplete.js'?>" type="text/javascript"></script>
  </head>
<body class="theme-pmm public-menu-closed">
<div class="overlay"></div>
<!-- Search Bar -->
<div class="search-bar hidden-print">
    <?php echo form_open(base_url($this->uri->segment(1).'/pesquisa'),array('role' => 'form', 'id' => 'formPadraoSearch','class'=>'Formulario')); ?>
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" name="texto" placeholder="pesquisa ..." autocomplete="off">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
    </form>
</div>
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
<!--            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>-->
            <a class="navbar-brand" href="javascript:void(0);">MoniTOR - Acompanhando os acontecimentos.</a>

        </div>

<!--        <div class="collapse navbar-collapse" id="navbar-collapse">-->
<!--            <ul class="nav navbar-nav navbar-right">-->
<!--                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>-->
<!--            </ul>-->
<!--        </div>-->
    </div>
</nav>
<section class="content-public">
    <div class="container-fluid posicao-custom">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding tam-custom-1">
                <div class="card">
                    <div class="body ">
                        <div class="row clearfix ">
                            <div class="media-custom nopadding">
                                <div class="media-left hidden-print nopadding">
                                    <?php if(!empty($url_logo)) { ?>
                                    <a href="javascript:void(0);">
                                        <img class="media-object" src="<?php echo $url_logo; ?>" style="height: 36px !important;">
                                    </a>
                                    <?php } ?>
                                </div>
                                <?php if(!empty($titulo)) { ?>
                                <div class="media-body-custom nopadding">
                                    <h3 class="media-heading">&nbsp;&nbsp;<?php echo $titulo; ?></h3>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
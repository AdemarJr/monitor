<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php 
        $isEleicao = $isEleicao70 = false;
        if ($_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO1 and $_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO2
        and $_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO3) { ?>
        <title>Porto - Monitoramento de Not&iacute;cias em Tempo Real</title>
        <link rel="shortcut icon" href="<?php echo base_url().'assets/images/porto-ico.png' ?>">
        <?php 
        } else if ($_SERVER['SERVER_NAME']==SERVER_NAME_ELEICAO1) { 
        $isEleicao = true;    
        ?>
        <title>Carlos Almeida</title>
        <link rel="shortcut icon" href="<?php echo base_url().'assets/images/user.png' ?>">
    <?php } else if (SETOR_ELEICAO=='1') { 
            $isEleicao70=true;
        ?>
    
    <?php }else { $isEleicao = true;?>
      <title>Elei&ccedil;&otilde;es <?= date('Y')?></title>
      <link rel="shortcut icon" type="image/x-icon" href="http://www.tse.jus.br/favicon.ico">
    <?php } ?>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

      <!-- Bootstrap Core Css -->
      <link href="<?php echo base_url().'assets/plugins/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet" type="text/css" />

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
<body class="<?php echo ($isEleicao70)? 'theme-avante':(($isEleicao)?'theme-ele' : 'theme-pmm'); ?> public-menu-closed">
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-teal">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Carregando...</p>
    </div>
</div>
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
<?php
if (!empty($materia->SEQ_CLIENTE)){
    $dadosCliente = $this->ComumModelo->getCliente($materia->SEQ_CLIENTE)->row();
}
?>
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
<!--            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>-->
            <a class="navbar-brand" href="javascript:void(0);"><?php  echo $dadosCliente->EMPRESA_CLIENTE; ?></a>

        </div>
    </div>
</nav>
<section class="content-public">
    <div class="container-fluid posicao-custom">
        <?php if($materia->IND_MODELO<>'S') {?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="card">
                <?php
                    if (!empty($materia->SEQ_CLIENTE)){
                        $dadosCliente = $this->ComumModelo->getCliente($materia->SEQ_CLIENTE)->row();
                    }
                $descTipo =array(
                    'S'=>'INTERNET',
                    'I'=>'IMPRESSO',
                    'R'=>' RADIO',
                    'T'=>' TV'
                );
                ?>
                    <div class="body ">

                        <div class="row clearfix ">
                            
                            <div class="media-custom">
                                <?php if($materia->SEQ_SETOR!=83 and $materia->SEQ_ASSUNTO_GERAL!=0) { ?>
                                    <div class="media-left">
                                        <a href="javascript:void(0);">
                                            <img class="media-object" src="<?php echo $dadosCliente->IMAGEM_CLIENTE; ?>" height="64">
                                        </a>
                                    </div>
                                    <div class="media-body-custom">
                                        <h3 class="media-heading">Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?></h3>
                                        <?php echo $descTipo[$materia->TIPO_MATERIA]; ?>
                                    </div>
                                <?php } else if ($dadosCliente->SEQ_CLIENTE == 39) { ?>
                                    <div class="media-body-custom">
                                        <h3 class="media-heading">Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?></h3>
                                    </div>
                                <?php } else if ($dadosCliente->SEQ_CLIENTE == 59 or $dadosCliente->SEQ_CLIENTE == 60) { ?>
                                    <?php if (SETOR_ELEICAO=='1') { ?>
                                        <div class="media-left hidden-print">
                                                <a href="javascript:void(0);">
                                                <img src="<?php echo base_url().'assets/images/avante70.png' ?>" height="64">
                                                </a>
                                            </div>
                                            <div class="media-body-custom">
                                                <h3 class="media-heading">Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?></h3>
                                            </div>
                                    <?php } else  { ?>
                                        <div class="media-left">
                                            <a href="javascript:void(0);">
                                                <img class="media-object" src="<?php echo $dadosCliente->IMAGEM_CLIENTE; ?>" height="64">
                                            </a>
                                        </div>
                                        <div class="media-body-custom">
                                            <h3 class="media-heading">Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?></h3>
                                        </div>
                                <?php } } else { ?>
                                    <div class="media-body-custom">
                                        <h3 class="media-heading">Clipping Jornal&iacute;stico <?php echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$materia->SEQ_SETOR))->row()->DESC_SETOR; ?></h3>
                                    </div>
                                <?php }?>
                            </div>
                            <?php
                            if(!empty($chave)){ ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <div class="col-xs-4 col-md-4 col-xl-4">
                                        <h6><strong><?php echo ($dataNota->TIPO_NOTIFICACAO=='D'? 'Dia':'Per&iacute;odo'); ?></strong>:
                                            <span>
                                                <?php echo ($dataNota->TIPO_NOTIFICACAO=='D'? date('d/m/Y', strtotime($dataNota->DT_INICIO)):(date('d/m/Y', strtotime($dataNota->DT_INICIO)) . ' - '.date('d/m/Y', strtotime($dataNota->DT_FIM)))); ?></span></h6>
                                    </div>
                                    <div class="col-xs-4 col-md-4 col-xl-4">
                                        <h6><strong>Total de Publica&ccedil;&otilde;es</strong>: <span><?php echo $total;?></span></h6>
                                    </div>
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php }?>
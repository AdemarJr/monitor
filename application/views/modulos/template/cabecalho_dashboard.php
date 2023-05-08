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
     
      <?php }else { $isEleicao = true; ?>
      <title>Elei&ccedil;&otilde;es <?= date('Y')?></title>
      <link rel="shortcut icon" type="image/x-icon" href="http://www.tse.jus.br/favicon.ico">
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

      <link href="<?php echo base_url().'assets/plugins/sweetalert/sweetalert.css'?>" rel="stylesheet" />

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
  <head></head>
     <?php flush(); ?>
  <body></body>
  <body class="<?php echo ($isEleicao70)? 'theme-avante':(($isEleicao)?'theme-ele' : 'theme-pmm'); ?> public-menu-closed">
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
if(!empty($chave)){
    $dataNota = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $chave))->row();
}

if (!empty($this->session->userdata('idClienteSessaoAlerta'))){
    $dadosCliente = $this->ComumModelo->getCliente($this->session->userdata('idClienteSessaoAlerta'))->row();
} else if (!empty($chave)) {
    $dadosCliente = $this->ComumModelo->getCliente($dataNota->SEQ_CLIENTE)->row();
}
    if (!empty($chave))
        $flagModelo = $this->ComumModelo->getTableData('NOTA',array('CHAVE_NOTIFICACAO'=>$chave))->row()->IND_MODELO;
?>
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
<!--            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>-->
            <?php if(!empty($flagModelo) and $dataNota->TIPO_NOTA=='N'   ) { ?>
            <a class="navbar-brand" href="javascript:void(0);"><?php  echo $dadosCliente->EMPRESA_CLIENTE; ?></a>
            <?php } ?>

        </div>

<!--        <div class="collapse navbar-collapse" id="navbar-collapse">-->
<!--            <ul class="nav navbar-nav navbar-right">-->
<!--                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>-->
<!--            </ul>-->
<!--        </div>-->
    </div>
</nav>

<section class="content-public">
    <div class="container-fluid posicao-custom nopadding">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  tam-custom-1">
                <div class="card">
                <?php
//                if(!empty($chave)){
                    $dataNota = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $chave))->row();
//                }
                ?>
                <?php
                $descTipo =array(
                    'S'=>'INTERNET',
                    'I'=>'IMPRESSO',
                    'R'=>' RADIO',
                    'T'=>' TV'
                );
                $descTipoIcon =array(
                    'S'=>'cloud_queue',
                    'I'=>'description',
                    'R'=>' radio',
                    'T'=>' tv'
                );
                ?>
                    <div class="body ">
                        <?php if(!empty($flagModelo) and $dataNota->TIPO_NOTA=='N'   ) { ?>
                        <div class="row clearfix hidden-print" style="display:none;">
                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 nopadding text-left ">
                                <a href="javascript:void(0);">
                                    <img class="" src="<?php echo $dadosCliente->IMAGEM_CLIENTE; ?>" height="60">
                                </a>
                                <a href="javascript:void(0);">
                                    <img class="" src="<?php echo base_url('assets/images/'.$dadosCliente->LOGO_EMPRESA); ?>" height="128">
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row clearfix ">
                            <?php if(!empty($flagModelo)) { ?>
                            <div class="media-custom nopadding">
                            <?php if((!empty($dataNota->LISTA_SETOR) and  $dataNota->LISTA_SETOR==517)) { ?>
                                <div class="media-left hidden-print nopadding">
                                    <a href="javascript:void(0);">
                                    <img src="<?php echo base_url().'assets/images/avante70.png' ?>" height="64">
                                    </a>
                                </div>
                                <div class="media-body-custom">
                                    <h3 class="media-heading m-l-10"><?php echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$dataNota->LISTA_SETOR))->row()->DESC_SETOR; ?></h3>
                                </div>
                                <?php } else if((empty($dataNota->LISTA_SETOR) or $dataNota->LISTA_SETOR<>83) and  $dataNota->TIPO_NOTA=='N') { ?>
                                <div class="media-left hidden-print nopadding">
                                    <a href="javascript:void(0);">
                                        <img class="media-object" src="<?php echo $dadosCliente->IMAGEM_CLIENTE; ?>" height="64">
                                    </a>
                                </div>
                                <?php } else if(!empty($dataNota->LISTA_SETOR) and $dataNota->LISTA_SETOR==83) { ?>
                                <div class="media-body-custom">
                                    <h3 class="media-heading">Clipping Jornal&iacute;stico <?php echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$dataNota->LISTA_SETOR))->row()->DESC_SETOR; ?></h3>
                                </div>
                                <?php } else if ($dataNota->TIPO_NOTA=='N'){ ?>
                                <div class="media-body-custom nopadding">
                                    <h3 class="media-heading">Clipping <?php if(!empty($dataNota->GRUPO_PORTAL)) echo strtoupper($this->ComumModelo->getTableData('GRUPO_VEICULO',array('SEQ_GRUPO_VEICULO'=>$dataNota->GRUPO_PORTAL))->row()->DESC_GRUPO_VEICULO); ?> <?php echo $dadosCliente->EMPRESA_CLIENTE; ?></h3>
                                    <?php // if(!empty($dataNota->LISTA_SETOR) and $dataNota->LISTA_SETOR<>83) echo '<h5>'.$this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$dataNota->LISTA_SETOR))->row()->DESC_SETOR.'<br/></h5>'; ?>
                                    <?php if(!empty($dataNota->TIPO_MATERIA)) echo $descTipo[$dataNota->TIPO_MATERIA]; ?>
                                </div>
                                    <div class="media-right">
                                        <h1 class="media-heading" ><i class="material-icons" style="font-size: 50px !important;"><?php if(!empty($dataNota->TIPO_MATERIA)) echo $descTipoIcon[$dataNota->TIPO_MATERIA]; ?></i></h1>
                                    </div>
                                <?php } else if ($dataNota->TIPO_NOTA=='S'){ ?>
                                    <div class="media-body-custom nopadding">
                                        <h3 class="media-heading">Clipping  Temas de Interesse</h3>
                                        <?php if(!empty($dataNota->SEQ_ASSUNTO_GERAL)) echo '<h5>'.$this->ComumModelo->getTableData('ASSUNTO_GERAL',array('SEQ_ASSUNTO_GERAL'=>$dataNota->SEQ_ASSUNTO_GERAL))->row()->DESC_ASSUNTO_GERAL.'<br/></h5>'; ?>
                                        <?php if(!empty($dataNota->TIPO_MATERIA)) echo $descTipo[$dataNota->TIPO_MATERIA]; ?>
                                    </div>
                                    <div class="media-right">
                                        <h1 class="media-heading" ><i class="material-icons" style="font-size: 50px !important;"><?php if(!empty($dataNota->TIPO_MATERIA)) echo $descTipoIcon[$dataNota->TIPO_MATERIA]; ?></i></h1>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php
                            if(!empty($chave)){
                                $dataUltima = $this->ComumModelo->getMaiorDataAlerta($chave);
                                ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding hidden-print">
                                <?php if (! in_array($dadosCliente->SEQ_CLIENTE,array(59,60,61,62,63,64))) { ?>
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <h6><strong>Atualiza&ccedil;&atilde;o</strong>: <span><?php echo !empty($dataUltima)?date('d/m/Y H:i',strtotime($dataUltima)):'';?></span></h6>
                                </div>
                                <?php } ?>
                                    <div class="col-xs-4 col-md-4 col-xl-4">
                                        <h6><strong><?php echo ($dataNota->TIPO_NOTIFICACAO=='D'? 'Dia':'Per&iacute;odo'); ?></strong>:
                                            <span>
                                                <?php echo ($dataNota->TIPO_NOTIFICACAO=='D'? date('d/m/Y', strtotime($dataNota->DT_INICIO)):(date('d/m/Y', strtotime($dataNota->DT_INICIO)) . ' - '.date('d/m/Y', strtotime($dataNota->DT_FIM)))); ?></span></h6>
                                    </div>
                                <?php
                                if(!empty($dataNota->SEQ_CATEGORIA_SETOR)){ ?>
                                    <div class="col-xs-4 col-md-4 col-xl-4">
                                        <h6><strong>Especial</strong>: <span><?php echo $this->ComumModelo->getTableData('CATEGORIA_SETOR',array('SEQ_CATEGORIA'=>$dataNota->SEQ_CATEGORIA_SETOR))->row()->DESC_CATEGORIA; ?></span></h6>
                                    </div>
                                <?php } ?>
                                <?php
                                if(!empty($dataNota->AVALIACAO_NOTA)){ ?>
                                    <div class="col-xs-4 col-md-4 col-xl-4">
                                        <h6><strong>Avalia&ccedil;&atilde;o</strong>: <span><?php
                                                $descAval =array(
                                                    'P'=>'Positivo',
                                                    'N'=>'Negativo',
                                                    'T'=>'Neutro'
                                                );
                                                echo $descAval[$dataNota->AVALIACAO_NOTA]; ?></span></h6>
                                    </div>
                                <?php } ?>
                                <?php
                                if(!empty($total)){ ?>
                                    <div class="col-xs-4 col-md-4 col-xl-4 hidden-print">
                                        <h6><strong>Total de Publica&ccedil;&otilde;es</strong>: <span><?php echo $total;?></span></h6>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

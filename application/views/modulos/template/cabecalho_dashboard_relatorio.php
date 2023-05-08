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
  <style>
      .clsShow_NotificationSuccess
      {
          width:100%;
          /*position:absolute;*/
          padding: 10px 5px;
          background: rgba(0,166,9,0.7);
          z-index: 999999;
          font-size: 16px;
          font-weight: 600;
          text-align:center;
          color:#ffffff;
          bottom: 0;
          position: fixed;

      }
      .clsShow_NotificationError
      {
          width:100%;
          /*position:absolute;*/
          padding: 10px 5px;
          background: rgba(221,75,57,0.7);
          z-index: 999999;
          font-size: 16px;
          font-weight: 600;
          text-align:center;
          color:#ffffff;
          bottom: 0;
          position: fixed;
      }
      .clsShow_NotificationWarning
      {
          width:100%;
          /*position:absolute;*/
          padding: 10px 5px;
          background: rgba(243,156,18,0.7);
          z-index: 999999;
          font-size: 16px;
          font-weight: 600;
          text-align:center;
          color:#ffffff;
          bottom: 0;
          position: fixed;
      }
  </style>
<body class="theme-pmm public-menu-closed">
<div class="clsShow_NotificationS clsShow_NotificationSuccess" style="display: none"><p><span>Altera&ccedil;&atilde;o Realizada com sucesso!</span></p></div>
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
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
<!--            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>-->
            <a class="navbar-brand" href="javascript:void(0);">MoniTOR - Acompanhando os acontecimentos.</a>

        </div>

        <div class="collapse navbar-collapse hidden-print" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url('relatorio');  ?>"  data-toggle="tooltip" data-placement="bottom" title="Voltar para tela anterior" data-close="true"><i class="material-icons">arrow_back</i></a></li>
            </ul>
        </div>
    </div>
</nav>
<section class="content-public">
    <div class="container-fluid posicao-custom">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding tam-custom-1">
                <div class="card">
                <?php
                    if (!empty($this->session->userdata('idClienteSessao'))){
                        $dadosCliente = $this->ComumModelo->getCliente($this->session->userdata('idClienteSessao'))->row();
                    }
                $descTipo =array(
                    'S'=>'INTERNET',
                    'I'=>'IMPRESSO',
                    'R'=>' RADIO',
                    'T'=>' TV'
                );
                ?>
                    <div class="body ">
                        <div class="row clearfix visible-print">
                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 nopadding text-left ">
                                <a href="javascript:void(0);">
                                    <img class="" src="<?php echo $dadosCliente->IMAGEM_CLIENTE; ?>" height="60">
                                </a>
                                <a href="javascript:void(0);">
                                    <img class="" src="<?php echo base_url('assets/images/'.$dadosCliente->LOGO_EMPRESA); ?>" height="128">
                                </a>
                            </div>
                        </div>
                        <div class="row clearfix ">

                            <div class="media-custom">
                                <?php if(empty($setor) or (!empty($setor) and $setor<>83)) { ?>
                                <div class="media-left hidden-print">
                                    <a href="javascript:void(0);">
                                        <img class="media-object" src="<?php echo $dadosCliente->IMAGEM_CLIENTE; ?>" height="64">
                                    </a>
                                </div>
                                <?php } ?>
                                <?php if(empty($setor) ) { ?>
                                <div class="media-body-custom">
                                    <h3 class="media-heading">Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?></h3>
                                    <h4 class="media-heading"><?php if (!empty($subtitulo)) echo $subtitulo; ?></h4>
                                </div>
                                <?php } else if(!empty($setor)  and $setor==83) { ?>
                                <div class="media-body-custom">
                                    <h3 class="media-heading">Clipping Jornal&iacute;stico <?php echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$setor))->row()->DESC_SETOR; ?></h3>
                                </div>
                                <?php } else if(!empty($setor)  and $setor<>83) { ?>
                                <div class="media-body-custom">
                                    <h3 class="media-heading">Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?></h3>
                                    <h4 class="media-heading"><?php echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$setor))->row()->DESC_SETOR; ?></h4>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                        <h6><strong>Per&iacute;odo</strong>:
                                            <span>  <?php echo $datai.' - '.$dataf; ?></span></h6>
                                    </div>
                                    <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                        <h6><strong>Total de Publica&ccedil;&otilde;es</strong>: <span><?php echo $total;?></span></h6>
                                    </div>
                                    <?php if(!empty($tipoMat)) { ?>
                                        <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                            <h6><strong>Tipo da Mat&eacute;ria</strong>: <span><?php echo descTipoMateria($tipoMat); ?></span></h6>
                                        </div>
                                    <?php }?>
                                    <?php if(!empty($veiculo)) { ?>
                                        <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                            <h6><strong>Ve&iacute;culo</strong>: <span><?php echo $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $veiculo))->row()->FANTASIA_VEICULO; ?></span></h6>
                                        </div>
                                    <?php }?>

                                    <?php if(!empty($portal)) { ?>
                                        <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                            <h6><strong>Site</strong>: <span><?php echo $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $portal))->row()->NOME_PORTAL; ?></span></h6>
                                        </div>
                                    <?php }?>
                                    <?php if(!empty($radio)) { ?>
                                        <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                            <h6><strong>R&aacute;dio</strong>: <span><?php echo $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $radio))->row()->NOME_RADIO; ?></span></h6>
                                        </div>
                                    <?php }?>
                                    <?php if(!empty($tv)) { ?>
                                        <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                            <h6><strong>Televis&atilde;o</strong>: <span><?php echo $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $tv))->row()->NOME_TV; ?></span></h6>
                                        </div>
                                    <?php }?>
                                    <?php if(!empty($tipo)) { ?>
                                        <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                            <h6><strong>&Aacute;rea de assunto</strong>: <span><?php echo $this->ComumModelo->getTableData('TIPO_MATERIA', array('SEQ_TIPO_MATERIA' => $tipo))->row()->DESC_TIPO_MATERIA; ?></span></h6>
                                        </div>
                                    <?php }?>
                                    <?php if(!empty($setor)) { ?>
                                        <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                            <h6><strong>Setor</strong>: <span><?php echo $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $setor))->row()->DESC_SETOR; ?></span></h6>
                                        </div>
                                    <?php }?>
                                    <?php if(!empty($texto)) { ?>
                                        <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                            <h6><strong>Texto</strong>: <span><?php echo $texto; ?></span></h6>
                                        </div>
                                    <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        <!--  croppie-->
      <link href="<?php echo base_url().'assets/plugins/croppie/croppie.css'?>" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url().'assets/plugins/croppie/demo.css'?>" rel="stylesheet" type="text/css" />

      <!-- Bootstrap Material Datetime Picker Css -->
      <link href="<?php echo base_url().'assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'?>" rel="stylesheet" type="text/css" />

      <!-- Bootstrap Tagsinput Css -->
      <link href="<?php echo base_url().'assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'?>" rel="stylesheet" type="text/css" />
      <!-- Sweet Alert Css -->
      <link href="<?php echo base_url().'assets/plugins/sweetalert/sweetalert.css'?>" rel="stylesheet" type="text/css" />

      <!-- Light Gallery Plugin Css -->
      <link href="<?php echo base_url().'assets/plugins/light-gallery/css/lightgallery.css'?>" rel="stylesheet" type="text/css" />

      <!-- Multi Select Css -->
      <link href="<?php echo base_url().'assets/plugins/multi-select/css/multi-select.css'?>" rel="stylesheet" type="text/css" />

      <!-- Custom Css -->
      <link href="<?php echo base_url().'assets/css/style.css'?>" rel="stylesheet" type="text/css" />

      <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
      <link href="<?php echo base_url().'assets/css/themes/all-themes.css'?>" rel="stylesheet" type="text/css" />

      <link href="<?php echo base_url().'assets/plugins/bootstrap-autocomplete/bootcomplete.css'?>" rel="stylesheet" type="text/css" />

      <script src="<?php echo base_url().'assets/plugins/jQuery/jQuery-2.1.4.min.js'?>"></script>
      <script src="<?php echo base_url().'assets/plugins/bootstrap-autocomplete/jquery.bootcomplete.js'?>" type="text/javascript"></script>

      <script src="<?php echo base_url().'assets/plugins/echarts/echarts.js'?>"></script>
      <script src="<?php echo base_url().'assets/plugins/echarts/theme/custom.js'?>"></script>

      <script src="<?php echo base_url().'assets/plugins/highcharts/highcharts.js'?>"></script>
      <script src="<?php echo base_url().'assets/plugins/highcharts/exporting.js'?>"></script>
      <script src="<?php echo base_url().'assets/plugins/highcharts/google.js'?>"></script>

       <link href="<?php echo base_url().'assets/plugins/wslidermenu/waslidemenu.min.css'?>" rel="stylesheet" type="text/css" />
      <script src="<?php echo base_url().'assets/plugins/wslidermenu/jquery.waslidemenu.min.js'?>"></script>
      <script src="<?php echo base_url().'assets/plugins/jsPDF/jspdf.min.js'?>"></script>

      <script src="<?php echo base_url().'assets/plugins/html2canvas/html2canvas.min.js'?>"></script>
      <script src="<?php echo base_url().'assets/plugins/html2canvas/canvas2image.js'?>"></script>
      <?php if (isset($_SESSION['novo-sistema'])) { ?>
      <style>
          #leftsidebar {
              display: none;
          }
      </style>
      <?php } ?>  
  </head>

<body class="theme-<?php echo $temaClienteSessao;?>">
<!--<div class="page-loader-wrapper">-->
<!--    <div class="loader">-->
<!--        <div class="preloader">-->
<!--            <div class="spinner-layer pl-red">-->
<!--                <div class="circle-clipper left">-->
<!--                    <div class="circle"></div>-->
<!--                </div>-->
<!--                <div class="circle-clipper right">-->
<!--                    <div class="circle"></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <p>Aguarde...</p>-->
<!--    </div>-->
<!--</div>-->
<div class="overlay"></div>
<!-- Search Bar -->
<div class="search-bar hidden-print">
    <?php echo form_open(base_url('pesquisa'),array('role' => 'form', 'id' => 'formPadraoSearch','class'=>'Formulario')); ?>
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
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="<?php echo base_url('inicio'); ?>">MoniTOR <?php if (!empty($idClienteSessao)) echo ' - '.$this->ComumModelo->getCliente($idClienteSessao)->row()->NOME_CLIENTE; ?></a>
            <a id="menu-teste" href="javascript:void(0);" class="navbar-brand hidden-sm"><i class="material-icons">menu</i></a>
            <a href="javascript:void(0);" class="bars"></a>

        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <?php if (($this->auth->CheckMenu('geral','relatorio','index')==1) ){  ?>
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                <?php } ?>
                <!-- #END# Call Search -->
                <?php if (($this->auth->CheckMenu('geral','integracao','index')==1) ){  ?>
                <li><a href="<?php echo base_url('integracao'); ?>" 
                        class="dropdown-toggle" 
                         role="top">
                            <i class="material-icons">notifications</i>
                            <?php 
                                $totalItem = $this->ComumModelo->contaKlipboxPendente();
                                if ($totalItem>0){
                            ?>
                            <span class="label-count"><?php echo $totalItem; ?></span>
                                <?php } ?>
                    </a>
                </li>
                <?php } ?>
                <?php
                    $clientes=array();
                    if($this->session->userData('perfilUsuario')=='ROLE_ADM') {
                        $clientes = $this->ComumModelo->getClienteTodos()->result_array();
                    }  else {
//                        if (!empty($this->session->userData('idUsuario')))
                            $clientes = $this->ComumModelo->getClientes($this->session->userData('listaCliente'))->result_array();
                    }
                if ( !empty($clientes) and count($clientes)>1) { ?>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">person_pin</i>
                        <span class="label-count"><?php echo count($clientes);?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Clientes</li>
                        <li class="body">
                            <ul class="menu">
                                <?php if (!empty($clientes)) {
                                foreach ($clientes as $item): ?>
                                <li>
                                    <a href="<?php if ($item['SEQ_CLIENTE']!=$this->session->userData('idClienteSessao')) echo base_url('cliente/seleciona/'.$item['SEQ_CLIENTE'].'/'.$this->uri->segment(1)); else echo '#';?>">
                                        <?php if ($item['SEQ_CLIENTE']==$this->session->userData('idClienteSessao')) { ?>
                                            <div class="icon-circle bg-light-green">
                                        <?php } else { ?>
                                                <div class="icon-circle bg-grey">
                                        <?php } ?>
                                            <i class="material-icons">check_circle</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><?php echo resume($item['NOME_CLIENTE'],30); ?></h4>
                                            <p><?php echo $item['EMPRESA_CLIENTE']; ?></p>
                                        </div>
                                    </a>
                                </li>
                                <?php endforeach; } ?>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<section class="hidden-print">
<!-- Left Sidebar -->
<aside id="leftsidebar" class="over sidebar">
    <!-- User Info -->
    <div class="user-info hidden-print">
        <div class="image">
            <img src="<?php echo base_url('usuario/avatar/'.$idUsuario);?>" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if(!empty($nomeUsuario)) echo $nomeUsuario ?></div>
            <div class="email"><?php if(!empty($emailUsuario)) echo $emailUsuario ?></div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?php echo base_url('principal/perfil'); ?>"><i class="material-icons">person</i>Perfil</a></li>
                    <li><a href="<?php echo base_url('principal/senha'); ?>"><i class="material-icons">lock</i>Alterar Senha</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="<?php echo base_url('logout'); ?>"><i class="material-icons">input</i>Sair</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu hidden-print">
        <ul class="list">
            <li class="header">Menu de Navegação</li>
            <?php
            $totalFunc = 0;
            if (($this->auth->CheckMenu('geral','principal','inicio')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='inicio') echo 'active'; ?>">
                <a href="<?php echo base_url('dashboard'); ?>">
                    <i class="material-icons">home</i>
                    <span>In&iacute;cio</span>
                </a>
            </li>
            <?php } ?>
            <?php if (($this->auth->CheckMenu('geral','notificacao','index')==1) or
                ($this->auth->CheckMenu('geral','notificacao','estatistica')==1)
            ){ $totalFunc++; ?>
                <li class="<?php if ($this->uri->segment(1)=='notificacao') echo 'active'; ?>">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">alarm</i>
                        <span>Alertas</span>
                    </a>
                    <ul class="ml-menu">
                        <?php if (($this->auth->CheckMenu('geral','notificacao','index')==1)){?>
                            <li class="<?php if ($this->uri->segment(1)=='notificacao' and $this->uri->segment(2)!='estatistica') echo 'active'; ?>">
                                <a href=" <?php echo base_url('notificacao'); ?>" >
                                    <span>Visualização</span>
                                </a>
                            </li>
                        <?php } if (($this->auth->CheckMenu('geral','notificacao','estatistica')==1)){ ?>
                            <li class="<?php if ($this->uri->segment(1)=='notificacao' and $this->uri->segment(2)=='estatistica') echo 'active'; ?>">
                                <a href="<?php echo base_url('notificacao/estatistica'); ?>">
                                    <span>Estat&iacute;stica</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>


            <?php if (($this->auth->CheckMenu('geral','usuario','index')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='usuario') echo 'active'; ?>">
                <a href="<?php echo base_url('usuario'); ?>">
                    <i class="material-icons">person</i>
                    <span>Usu&aacute;rios</span>
                </a>
            </li>
            <?php } ?>
            <?php if (($this->auth->CheckMenu('geral','veiculo','consultai')==1) or
                ($this->auth->CheckMenu('geral','veiculo','consultas')==1) or
                ($this->auth->CheckMenu('geral','veiculo','consultat')==1) or
                ($this->auth->CheckMenu('geral','veiculo','consultar')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='veiculo') echo 'active'; ?>">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">fiber_new</i>
                    <span>Ve&iacute;culos</span>
                </a>
                <ul class="ml-menu">
                    <?php if (($this->auth->CheckMenu('geral','veiculo','consultai')==1)){?>
                    <li class="<?php if ($this->uri->segment(1)=='veiculo' and $this->uri->segment(2)=='consultai') echo 'active'; ?>">
                        <a href=" <?php echo base_url('veiculo/consultai'); ?>" >
                            <span>Impresso</span>
                        </a>
                    </li>
                    <?php } if (($this->auth->CheckMenu('geral','veiculo','consultas')==1)){ ?>
                    <li class="<?php if ($this->uri->segment(1)=='veiculo' and $this->uri->segment(2)=='consultas') echo 'active'; ?>">
                        <a href="<?php echo base_url('veiculo/consultas'); ?>">
                            <span>Site</span>
                        </a>
                    </li>
                    <?php } if (($this->auth->CheckMenu('geral','veiculo','consultar')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='veiculo' and $this->uri->segment(2)=='consultar') echo 'active'; ?>">
                            <a href="<?php echo base_url('veiculo/consultar'); ?>">
                                <span>R&aacute;dio</span>
                            </a>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','veiculo','consultat')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='veiculo' and $this->uri->segment(2)=='consultat') echo 'active'; ?>">
                            <a href="<?php echo base_url('veiculo/consultat'); ?>">
                                <span>Televis&atilde;o</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if (($this->auth->CheckMenu('geral','cliente','index')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='cliente') echo 'active'; ?>">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">contacts</i>
                    <span>Clientes</span>
                </a>
                <ul class="ml-menu">
                    <?php if (($this->auth->CheckMenu('geral','cliente','index')==1)){?>
                        <li class="<?php if ($this->uri->segment(1)=='cliente' and $this->uri->segment(2)!='replica') echo 'active'; ?>">
                            <a href=" <?php echo base_url('cliente'); ?>" >
                                <span>Consulta</span>
                            </a>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','cliente','replica')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='cliente' and $this->uri->segment(2)=='replica') echo 'active'; ?>">
                            <a href="<?php echo base_url('cliente/replica'); ?>">
                                <span>Replicar Ve&iacute;culos</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if (($this->auth->CheckMenu('geral','tipomateria','index')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='tipomateria') echo 'active'; ?>">
                <a href="<?php echo base_url('tipomateria'); ?>">
                    <i class="material-icons">layers</i>
                    <span>&Aacute;reas da Mat&eacute;ria</span>
                </a>
            </li>
            <?php } ?>
            <?php if (($this->auth->CheckMenu('geral','setor','index')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='setor') echo 'active'; ?>">
                <a href="<?php echo base_url('setor'); ?>">
                    <i class="material-icons">view_comfy</i>
                    <span>Setor</span>
                </a>
            </li>
            <?php } ?>
            <?php if (($this->auth->CheckMenu('geral','release','index')==1)
            ){ $totalFunc++; ?>
                <li class="<?php if ($this->uri->segment(1)=='release') echo 'active'; ?>">
                    <a href="<?php echo base_url('release'); ?>">
                        <i class="material-icons">grade</i>
                        <span>Release</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (($this->auth->CheckMenu('geral','materia','index')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='materia') echo 'active'; ?>">
                <a href="<?php echo base_url('materia'); ?>">
                    <i class="material-icons">attach_file</i>
                    <span>Mat&eacute;ria</span>
                </a>
            </li>
            <?php } ?>
            <?php if (  ($this->auth->CheckMenu('geral','integracao','monitoramento')==1)
                        or ($this->auth->CheckMenu('geral','integracao','index')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='integracao') echo 'active'; ?>">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">electrical_services</i>
                    <span>Integra&ccedil;&atilde;o</span>
                </a>
                <ul class="ml-menu">
                    <?php if (($this->auth->CheckMenu('geral','integracao','monitoramento')==1)){?>
                        <li class="<?php if ($this->uri->segment(1)=='integracao' and $this->uri->segment(2)=='monitoramento') echo 'active'; ?>">
                            <a href=" <?php echo base_url('integracao/monitoramento'); ?>" >
                                <span>Monitoramento</span>
                            </a>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','integracao','index')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='integracao' and $this->uri->segment(2)=='index') echo 'active'; ?>">
                            <a href="<?php echo base_url('integracao/index'); ?>">
                                <span>Classifica&ccedil;&atilde;o</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php if (($this->auth->CheckMenu('geral','relatorio','index')==1) or
                    ($this->auth->CheckMenu('geral','relatorio','contadorUsuario')==1) or
                ($this->auth->CheckMenu('geral','relatorio','contadorSetor')==1) or
                ($this->auth->CheckMenu('geral','relatorio','linkMateria')==1) or
                ($this->auth->CheckMenu('geral','relatorio','contadorVeiculo')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='relatorio') echo 'active'; ?>">
                <a href="<?php echo base_url('relatorio'); ?>">
                    <i class="material-icons">print</i>
                    <span>Relat&oacute;rios</span>
                </a>
                <ul class="ml-menu">
                    <?php if (($this->auth->CheckMenu('geral','relatorio','index')==1)){?>
                        <li class="<?php if ($this->uri->segment(1)=='relatorio' and empty($this->uri->segment(2))) echo 'active'; ?>">
                            <a href=" <?php echo base_url('relatorio'); ?>" >
                                <span>Mat&eacute;ria</span>
                            </a>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','relatorio','contadorUsuario')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='relatorio' and $this->uri->segment(2)=='contadorUsuario') echo 'active'; ?>">
                            <?php 
                            $data = $this->session->userdata();
                            if ($data['idUsuario'] == 1) {
                            ?>
                            <a href="<?php echo base_url('relatorio/contadorUsuario'); ?>">
                                <span>Quantitativo de Usu&aacute;rios</span>
                            </a>
                            <?php } ?>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','relatorio','contadorSetor')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='relatorio' and $this->uri->segment(2)=='contadorSetor') echo 'active'; ?>">
                            <a href="<?php echo base_url('relatorio/contadorSetor'); ?>">
                                <span>Setor/Departamento</span>
                            </a>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','relatorio','contadorVeiculo')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='relatorio' and $this->uri->segment(2)=='contadorVeiculo') echo 'active'; ?>">
                            <a href="<?php echo base_url('relatorio/contadorVeiculo'); ?>">
                                <span>Veículo</span>
                            </a>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','relatorio','contadorGeral')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='relatorio' and $this->uri->segment(2)=='contadorGeral') echo 'active'; ?>">
                            <a href="<?php echo base_url('relatorio/contadorGeral'); ?>">
                                <span>Setor/Departamento/Veículo</span>
                            </a>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','relatorio','contadorRelease')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='relatorio' and $this->uri->segment(2)=='contadorRelease') echo 'active'; ?>">
                            <a href="<?php echo base_url('relatorio/contadorRelease'); ?>">
                                <span>Releases</span>
                            </a>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','relatorio','contadorArea')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='relatorio' and $this->uri->segment(2)=='contadorArea') echo 'active'; ?>">
                            <a href="<?php echo base_url('relatorio/contadorArea'); ?>">
                                <span>&Aacute;rea</span>
                            </a>
                        </li>
                    <?php } if (($this->auth->CheckMenu('geral','relatorio','linkMateria')==1)){ ?>
                        <li class="<?php if ($this->uri->segment(1)=='relatorio' and $this->uri->segment(2)=='linkMateria') echo 'active'; ?>">
                            <a href="<?php echo base_url('relatorio/linkMateria'); ?>">
                                <span>Lista de Mat&eacute;rias/Setor</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php ?>    
                        <li class="<?php if ($this->uri->segment(1)=='especiais' and empty($this->uri->segment(2))) echo 'active'; ?>">
                            <a href=" <?php echo base_url('relatorio/especiais'); ?>" >
                                <span>Mensais</span>
                            </a>
                        </li>
                </ul>
            </li>
            <?php } ?>
            <?php if (($this->auth->CheckMenu('geral','exportacao','index')==1)
            ){ $totalFunc++; ?>
          <li class="<?php if ($this->uri->segment(1)=='exportacao') echo 'active'; ?>">
            <?php if ($_SESSION['idUsuario'] != '170') { ?>
            <a href="<?php echo base_url('exportacao'); ?>">
              <i class="material-icons">attachment</i>
              <span>Exporta&ccedil;&atilde;o TV/R&aacute;dio</span>
            </a> 
            <?php } ?>  
          </li>
          <?php } ?>

        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal hidden-print">
        <div class="version">
            <b>Version: </b> 1.0.0
            <b>Modo: </b><?php echo ENVIRONMENT;?>
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->

</section>

<section class="content ">
    <div class="container-fluid" id="conteudo-geral">
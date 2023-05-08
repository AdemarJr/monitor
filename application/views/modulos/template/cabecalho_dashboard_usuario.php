<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
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
      <!-- Chart Plugins Js -->
      <script src="<?php echo base_url().'assets/plugins/bootstrap-autocomplete/jquery.bootcomplete.js'?>" type="text/javascript"></script>
    <script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
      <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js"></script> -->
      <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
  </head>
<body class="<?php echo ($isEleicao70)? 'theme-avante':(($isEleicao)?'theme-ele' : 'theme-pmm'); ?>">
<!-- <div class="page-loader-wrapper">
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
</div> -->
<div class="overlay"></div>
<!-- Search Bar -->
<div class="search-bar hidden-print">
    <?php echo form_open(NULL,array('role' => 'form', 'id' => 'formPadraoSearch','class'=>'Formulario')); ?>
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" name="texto" 
        placeholder="Informe o texto da pesquisa ...depois pressione ENTER" 
        autocomplete="off">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
    </form>
</div>
<?php
    if (!empty($idCliente)){
        $dadosCliente = $this->ComumModelo->getCliente($idCliente)->row();
    }
$descTipo =array(
    'S'=>'INTERNET',
    'I'=>'IMPRESSO',
    'R'=>' RADIO',
    'T'=>' TV'
);
?>
<nav class="navbar">
    <div class="container-fluid">
    <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="<?php echo base_url('inicio'); ?>">
            <?php if(empty($setor) ) { ?>
                Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?>
            <?php } else if(!empty($setor)  and $setor==83) { ?>
                Clipping Jornal&iacute;stico <?php echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$setor))->row()->DESC_SETOR; ?>
            <?php } else if(!empty($setor)  and $setor<>83) { ?>
                Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?>
            <?php } ?>
            <a id="menu-teste" href="javascript:void(0);" class="navbar-brand hidden-sm"><i class="material-icons">menu</i></a>
            <a href="javascript:void(0);" class="bars"></a>

        </div>
        <div class="collapse navbar-collapse hidden-print" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <?php echo $this->session->userdata('nomeUsuario');?>
                    </a>
                </li>
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>

                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Menu</li>
                        <li class="body">
                            <ul class="menu">
                                <li>
                                    <a href="<?php echo base_url('principal/senha'); ?>">
                                        <div class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                            <i class="material-icons">lock</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>Alterar Senha</h4>
                                            <p>
                                                <i class="material-icons">check</i>Altera&ccedil;&atilde;o de Senha
                                            </p>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo base_url('logout'); ?>">
                                        <div class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                            <i class="material-icons">input</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>Sair</h4>
                                            <p>
                                                <i class="material-icons">check</i> Efetuar Logout
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<section class="hidden-print">
<!-- Left Sidebar -->
<aside id="leftsidebar" class="over sidebar">
<div class="user-info2 hidden-print">
        <div class="info-container row-center-content">
            <div class="m-t-10 m-b-10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php if (SETOR_ELEICAO=='1') { ?>
                <div class="media-left hidden-print">
                        <a href="javascript:void(0);">
                        <img src="<?php echo base_url().'assets/images/avante70.png' ?>" height="64">
                        </a>
                    </div>
            <?php } else if(empty($setor) or (!empty($setor) and $setor<>529)) { ?>
                    <div class="media-left hidden-print">
                        <a href="javascript:void(0);">
                            <img class="media-object" src="<?php echo $dadosCliente->IMAGEM_CLIENTE; ?>" height="64">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php  $dia_f = '';
        if (!empty($this->session->userdata('dia'))) $dia_f = '/'.$this->session->userdata('dia').'/di';
    ?>
    <!-- Menu -->
    <div class="menu hidden-print">
        <ul class="list">
            <li class="header">Menu de Navegação</li>
            <?php
            $totalFunc = 0;
            if (($this->auth->CheckMenu('geral','principal','iniciousuario')==1)
            ){ $totalFunc++; ?>
            <li class="<?php if ($this->uri->segment(1)=='inicio') echo 'active'; ?>">
                <a href="<?php echo base_url('iniciousuario/a'.$dia_f); ?>">
                    <i class="material-icons">title</i>
                    <span>Todas (<?php echo number_format($total_avaliacao['total_materia'],0,',','.'); ?>)</span>
                </a>
            </li>
            <?php } ?>
            <li>
                <a href="<?php echo base_url('iniciousuario/p'.$dia_f); ?>">
                    <i class="material-icons">flight_takeoff</i>
                    <span>Positivas (<?php echo number_format($total_avaliacao['positivo'],0,',','.'); ?>)</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('iniciousuario/n'.$dia_f); ?>">
                    <i class="material-icons">flight_land</i>
                    <span>Negativas (<?php echo number_format($total_avaliacao['negativo'],0,',','.'); ?>)</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('iniciousuario/t'.$dia_f); ?>">
                    <i class="material-icons">panorama_fish_eye</i>
                    <span>Neutras (<?php echo number_format($total_avaliacao['neutro'],0,',','.'); ?>)</span>
                </a>
            </li>
            <li class="header">Filtro para matérias apenas</li>
                <?php echo form_open(base_url('iniciousuario/a'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
            <li>
                <div class="col-xs-12 col-md-12 col-xl-12 m-t-20">
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" class="datepicker form-control" 
                            id='datai' name='datai' placeholder="selecione a data inicio..." value='<?php if (!empty($datai)) echo $datai;?>'>
                            <label id="label-for" class="form-label">Data In&iacute;cio</label>
                        </div>
                    </div>
                </div>
            </li>    
            <li>    
                <div class="col-xs-12 col-md-12 col-xl-12">
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" class="datepicker form-control" id='dataf' name='dataf' placeholder="selecione a data fim..." value='<?php if (!empty($dataf)) echo $dataf;?>'>
                            <label id="label-for" class="form-label">Data Fim</label>
                        </div>
                    </div>
                </div>
            </li>
            <?php if ($this->session->userdata('perfilUsuario')=='ROLE_CLI') { ?>
            <li>    
                <div class="col-xs-12 col-md-12 col-xl-12">
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <select id="setor" class="form-control show-tick"
                                    name="setor" title="Selecione o Candidato"
                                    data-live-search="true">
                                <option value="">Todos os Candidatos</option>
                                <?php if (!empty($lista_setor)) {
                                    foreach ($lista_setor as $item): ?>
                                        <option
                                            <?php if(!empty($setor) and $setor==$item['SEQ_SETOR']) echo 'selected'; ?>
                                            value="<?php echo $item['SEQ_SETOR'] ?>">
                                                <?php echo $item['DESC_SETOR'].' ('.$item['SIG_SETOR'].')'; ?>
                                                </option>
                                    <?php endforeach;
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </li>
            <?php } ?>
            <li>
                <div class="col-xs-12 col-md-12 col-xl-12 hidden-print m-b-20">
                        <button type="submit" 
                        class="btn btn-default btn-circle-lg waves-effect waves-circle waves-float" 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Aplicar Filtro">
                            <i class="material-icons">filter_list</i>
                        </button>
                        <button type="button"
                        class="btn btn-default btn-circle-lg waves-effect waves-circle waves-float btn-printer m-l-20" 
                        data-toggle="tooltip" 
                        onclick="javascript: window.print();"
                        data-placement="top" 
                        title="Imprimir Painel">
                            <i class="material-icons">print</i>
                        </button>
                </div>
            </li>
            </form>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal hidden-print">
        <?php if (!empty($this->session->userdata('setorUsuario')) ) { ?>
        <small>Meu Candidador:</small>
        <h4 class="header">
            <?php
                    echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$this->session->userdata('setorUsuario')))->row()->DESC_SETOR; 
              ?>
        </h4>
        <hr/>
        <?php } ?>
        <div class="version">
                <div class="header">Está lento?, podes cancelar o carregamento.</div>
                <script type="text/javascript">
                    $.xhrPool = [];
                    $.xhrPool.abortAll = function() {
                        $(this).each(function(idx, jqXHR) {
                            jqXHR.abort();
                        });
                        $.xhrPool = [];
                    };
                    $.ajaxSetup({
                        beforeSend: function(jqXHR) {
                            $.xhrPool.push(jqXHR);
                        },
                        complete: function(jqXHR) {
                            var index = $.xhrPool.indexOf(jqXHR);
                            if (index > -1) {
                                $.xhrPool.splice(index, 1);
                            }
                        }
                    });
                    $(function () {
                        // Everything below this is only for the jsFiddle demo
                        $('#cancelBtnAjax').click(function() {
                            $.xhrPool.abortAll();
                        });
                    });
                </script>
                <div class="col-xs-12 col-md-12 col-xl-12 hidden-print m-t-10 m-b-10">
                    <button type="button" 
                    class="btn btn-default btn-circle-lg waves-effect waves-circle waves-float" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    id="cancelBtnAjax"
                    title="Cancelar o carregamento das matérias">
                        <i class="material-icons">cancel</i>
                    </button>
                </div>
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->

</section>
<section class="content">
    <div class="container-fluid">
        <?php if (!empty($idCliente)) { ?>
            <div class="row clearfix">
            <div class="visible-print">
                <h4 class="header">
                <?php if(empty($setor) ) { ?>
                    Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?>
                <?php } else if(!empty($setor)  and $setor==83) { ?>
                    Clipping Jornal&iacute;stico <?php echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$setor))->row()->DESC_SETOR; ?>
                <?php } else if(!empty($setor)  and $setor<>83) { ?>
                    Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?>
                <?php } ?>
                </h4>
                <?php if (!empty($this->session->userdata('setorUsuario')) ) { ?>
                    <h4 class="header">
                        <?php echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$this->session->userdata('setorUsuario')))->row()->DESC_SETOR; ?>
                    </h4>
                    <?php } ?>
                <hr/>
            </div>    
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <a href="<?php echo base_url('iniciousuario/a'.$dia_f); ?>"  style="text-decoration: none !important">
                        <div class="info-box-2 bg-deep-purple hover-expand-effect" style="cursor: pointer !important;">
                            <div class="icon">
                                <i class="material-icons">title</i>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL DE PUBLICAÇÕES</div>
                                <div class="number">
                                
                                    <?php echo number_format($total_avaliacao['total_materia'],0,',','.'); ?>
                                
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <a href="<?php echo base_url('iniciousuario/p'.$dia_f); ?>" style="text-decoration: none !important">
                        <div class="info-box-2 bg-green hover-expand-effect" style="cursor: pointer !important;">
                            <div class="icon">
                                <i class="material-icons">flight_takeoff</i>
                            </div>
                            <div class="content">
                                <div class="text">POSITIVAS</div>
                                <div class="number"><?php echo number_format($total_avaliacao['positivo'],0,',','.'); ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <a href="<?php echo base_url('iniciousuario/n'.$dia_f); ?>" style="text-decoration: none !important">
                        <div class="info-box-2 bg-red hover-expand-effect" style="cursor: pointer !important;">
                            <div class="icon">
                                <i class="material-icons">flight_land</i>
                            </div>
                            <div class="content">
                                <div class="text">NEGATIVAS</div>
                                <div class="number"><?php echo number_format($total_avaliacao['negativo'],0,',','.'); ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <a href="<?php echo base_url('iniciousuario/t'.$dia_f); ?>" style="text-decoration: none !important">
                        <div class="info-box-2 bg-orange hover-expand-effect" style="cursor: pointer !important;">
                            <div class="icon">
                                <i class="material-icons">panorama_fish_eye</i>
                            </div>
                            <div class="content">
                                <div class="text">NEUTRAS</div>
                                <div class="number"><?php echo number_format($total_avaliacao['neutro'],0,',','.'); ?></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Quantitativo diário por tipo de Avaliação
                                <small><code>1</code>Clique no ponto do gráfico para exibir as matérias <code>2</code> Clique na legenda para ocultar ou exibir.</small>
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="line_chart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header">
                            <h2>
                            Quantitativo por tipo de Mídia 1
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="pie_tipo" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header">
                            <h2>
                            Quantitativo por tipo de Mídia 2
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="bar_tipo" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Quantitativo de Internet
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="line_internet" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Quantitativo de Impresso
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="line_impresso" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 visible-print" style="height: 250px !important;">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                    <div class="card">
                        <div class="header">
                            <h2>
                                Quantitativo de Televisão
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="line_tv" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Quantitativo de Rádio
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="line_radio" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Minutagem de Televisão
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="bar_tv" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="card">
                    <div class="header">
                            <h2>
                                Minutagem de Rádio
                            </h2>
                        </div>
                        <div class="body">
                            <canvas id="bar_radio" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
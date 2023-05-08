<!DOCTYPE html>
<?php
$selected = '';
$selected_P = '';
$selected_R = '';
$selected_RA = '';
$selected_TV = '';
$selected_RELE = '';
 $selected_MAPA = '';
?>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="https://porto.am/monitor/assets/images/porto-ico.png">
        <title>Porto - Monitoramento de Notícias em Tempo Real</title>
        <link href="<?= base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?= base_url() ?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/css/ruang-admin.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <base href="<?= base_url() ?>">
    </head>
    <style>
        .bg-navbar {
            background-color: #3F51B5;
        }
        #dataTable_filter {
            display: none;
        }
        th.sorting_asc::before {
            display: none;
        }
        th.sorting_asc::after {
            display: none;
        }
        .card {
            border-radius: 25px !important;
            border-top-left-radius: 25px !important;
            border-top-right-radius: 25px !important;
        }
    </style>
    <script>
        var GRUPO = <?= $_SESSION['GRUPO'] ?>;
        var CLIENTE = '<?= $this->session->userData('idClienteSessao') ?>';
        var graficoVeiculo;
        var graficoAvaliacao;
    </script>
    <body id="page-top">
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                    <div class="sidebar-brand-text mx-3">Porto Monitor</div>
                </a>
                <hr class="sidebar-divider my-0">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <hr class="sidebar-divider">
                <div class="version" id="version-ruangadmin"></div>
            </ul>
            <!-- Sidebar -->
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <!-- TopBar -->
                    <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                        <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </nav>
                    <!-- Topbar -->

                    <!-- Container Fluid-->
                    <div class="container-fluid" id="container-wrapper">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard<br><small style="font-size: 10pt;">Ferramenta para gerenciar os acontencimentos jornal&iacute;sticos em diversos ve&iacute;culos de comunica&ccedil;&atilde;o.</small></h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active"><a href="<?= base_url('notificacao'); ?>">Página Inicial</a></li>
                                <li class="breadcrumb-item">Dashboard</li>
                            </ol>
                        </div>
                        <?php if (empty($_SESSION['idClienteSessao'])) { ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-warning"><i class="fas fa-exclamation-circle"></i> Selecione o cliente para a geração do relatório</div>
                                </div>
                            </div>    
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                            <?php if ($_SESSION['GRUPO'] == '15' || $_SESSION['GRUPO'] == '1' || $_SESSION['GRUPO'] == '2' || $_SESSION['GRUPO'] == '5') { ?>
                                                                MATÉRIAS CADASTRADAS - INTERNET
                                                            <?php } else if ($_SESSION['GRUPO'] == '3') { ?>
                                                                MATÉRIAS CADASTRADAS - RÁDIO
                                                            <?php } else if ($_SESSION['GRUPO'] == '4') { ?>
                                                                MATÉRIAS CADASTRADAS - TELEVISÃO
                                                            <?php } ?>
                                                        </div>
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800" id="txtQuantMat">CARREGANDO...</div>
                                                        <div class="mt-2 mb-0 text-muted text-xs">
                                                            <?php
                                                            $diff = $ctrl->diferencaDatas();
                                                            if ($diff->d < 2) {
                                                                ?>
                                                            <span>Nas últimas 24 horas</span> <small id="dataAtualiza"></small>
                                                            <?php } else { ?>
                                                                <?= $_SESSION['DATA_INICIAL'] . ' à ' . $_SESSION['DATA_FINAL'] ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="form-group">
                                                            <label></label>
                                                            <div class="custom-control custom-switch">
                                                                <?php
                                                                $this->db->order_by('ID_ATUALIZACAO', 'DESC');
                                                                $atual = $this->db->get('ATUALIZACAO')->row_array();
                                                                ?>
                                                                <?php if ($atual['ATIVO'] == 1) { ?>
                                                                    <input type="checkbox" checked class="custom-control-input" id="customSwitch2">
                                                                <?php } else { ?>
                                                                    <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                                                <?php } ?>
                                                                <label class="custom-control-label" for="customSwitch2">Atualização Automática</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                            <a style="color:#5a5c69"href="<?= base_url('visualizar-materias/'. base64_encode('P'))?>" target="_blank">POSITIVAS</a>
                                                        </div>
                                                        <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800" id="txtQuantMatPosi">0</div>
                                                        <div class="mt-2 mb-0 text-muted text-xs">
                                                            <?php
                                                            $diff = $ctrl->diferencaDatas();
                                                            if ($diff->d < 2) {
                                                                ?>
                                                                <span>Nas últimas 24 horas</span>
                                                            <?php } else { ?>
                                                                <?= $_SESSION['DATA_INICIAL'] . ' à ' . $_SESSION['DATA_FINAL'] ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-thumbs-up fa-2x text-success"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pending Requests Card Example -->
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                            <a style="color:#5a5c69"href="<?= base_url('visualizar-materias/'. base64_encode('N'))?>" target="_blank">NEGATIVAS</a>
                                                        </div>
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800" id="txtQuantMatNeg">0</div>
                                                        <div class="mt-2 mb-0 text-muted text-xs">
                                                            <?php
                                                            $diff = $ctrl->diferencaDatas();
                                                            if ($diff->d < 2) {
                                                                ?>
                                                                <span>Nas últimas 24 horas</span>
                                                            <?php } else { ?>
                                                                <?= $_SESSION['DATA_INICIAL'] . ' à ' . $_SESSION['DATA_FINAL'] ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas  fa-thumbs-down fa-2x text-danger"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                            <a style="color:#5a5c69"href="<?= base_url('visualizar-materias/'. base64_encode('T'))?>" target="_blank">NEUTRAS</a>                                                       
                                                        </div>
                                                        <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800" id="txtQuantMatNeut">0</div>
                                                        <div class="mt-2 mb-0 text-muted text-xs">
                                                            <?php
                                                            $diff = $ctrl->diferencaDatas();
                                                            if ($diff->d < 2) {
                                                                ?>
                                                                <span>Nas últimas 24 horas</span>
                                                            <?php } else { ?>
                                                                <?= $_SESSION['DATA_INICIAL'] . ' à ' . $_SESSION['DATA_FINAL'] ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-exclamation-circle fa-2x text-warning"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold">Período</h6>
                                    </div>
                                    <?php echo form_open(base_url('dashboard/filtra'), array('role' => 'form', 'id' => 'formPadrao', 'class' => 'Formulario')); ?>
                                    <div class="card-body" style="margin-top: -4.8%">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar fa-fw"></i></span>
                                                    </div>
                                                    <input type="text" name="inicio" id="inicio" class="form-control" value="<?= $_SESSION['DATA_INICIAL'] ?>" placeholder="Data de Inicio" aria-describedby="basic-addon1" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar fa-fw"></i></span>
                                                    </div>
                                                    <input type="text" name="fim" id="fim" class="form-control" value="<?= $_SESSION['DATA_FINAL'] ?>" placeholder="Data de Fim" aria-describedby="basic-addon1" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control relatorio" name="grupo">
                                                    <?php
                                                    if ($_SESSION['GRUPO'] == '15') {
                                                        $selected_P = 'selected';
                                                    }

                                                    if ($_SESSION['GRUPO'] == '1') {
                                                        $selected = 'selected';
                                                    }

                                                    if ($_SESSION['GRUPO'] == '2') {
                                                        $selected_R = 'selected';
                                                    }
                                                    if ($_SESSION['GRUPO'] == '3') {
                                                        $selected_RA = 'selected';
                                                    }
                                                    if ($_SESSION['GRUPO'] == '4') {
                                                        $selected_TV = 'selected';
                                                    }
                                                    if ($_SESSION['GRUPO'] == '5') {
                                                        $selected_RELE = 'selected';
                                                    }
                                                    if ($_SESSION['GRUPO'] == '6') {
                                                        $selected_MAPA = 'selected';
                                                    }
                                                    ?>
                                                    <option value="1"<?= $selected ?> >SITES GERAIS (RELEASES)</option>
                                                    <option value="5" <?= $selected_RELE ?> >SITES PRIORITÁRIOS (RELEASES)</option>
                                                    <option value="15" <?= $selected_P ?> >SITES PRIORITÁRIOS</option>
                                                    <option value="2" <?= $selected_R ?> >SITES GERAIS</option>
                                                    <option value="3" <?= $selected_RA ?> >RÁDIO</option>
                                                    <option value="4" <?= $selected_TV ?> >TV</option>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary" style="width: 100%;">APLICAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-12 col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold">
                                            <?php if ($_SESSION['GRUPO'] == '15') { ?>
                                                <i class="fas fa-wifi"></i> Sites Prioritários <br>
                                                <small>SITES QUE PUBLICARAM QUALQUER ASSUNTO SOBRE A PREFEITURA</small>
                                            <?php } else if ($_SESSION['GRUPO'] == '1') { ?>
                                                <i class="fas fa-wifi"></i> Sites (Releases) <br>
                                                <small> SITES EM GERAL QUE PUBLICARAM OS RELEASES DA PREFEITURA.(PRIORITÁRIOS E NÃO PRIORITÁRIOS)</small>
                                            <?php } else if ($_SESSION['GRUPO'] == '2') { ?>
                                                <i class="fas fa-wifi"></i> Sites Gerais <br>
                                                <small> SITES E PORTAIS EM GERAL - PRIORITÁRIOS OU NÃO - QUE PUBLICARAM CONTEÚDOS CITANDO A PREFEITURA E ÓRGÃOS VINCULADOS, RELEASES E PUBLICAÇÕES EM GERAL.</small>
                                            <?php } else if ($_SESSION['GRUPO'] == '3') { ?>
                                                <i class="fas fa-radio"></i>Rádios <br>
                                                <small>VEÍCULOS QUE PUBLICARAM CONTEÚDOS CITANDO A PREFEITURA E ÓRGÃOS VINCULADOS, RELEASES E PUBLICAÇÕES EM GERAL</small>
                                            <?php } else if ($_SESSION['GRUPO'] == '4') { ?> 
                                                <i class="fas fa-tv"></i> TELEVISÃO <br>
                                                <small>VEÍCULOS QUE PUBLICARAM CONTEÚDOS CITANDO A PREFEITURA E ÓRGÃOS VINCULADOS, RELEASES E PUBLICAÇÕES EM GERAL</small>
                                            <?php } else if ($_SESSION['GRUPO'] == '5') { ?>
                                                <i class="fas fa-wifi"></i> Sites Prioritários (RELEASES)<br>
                                                <small>SOMENTE PRIORITÁRIOS QUE PUBLICARAM RELEASES ENVIADOS.</small>
                                            <?php } ?>    
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush" id="dataTable" style="width:100%">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th></th>
                                                        <th>VEICULO</th>
                                                        <th>POSITIVO</th>
                                                        <th>NEGATIVO</th>
                                                        <th>NEUTRO</th>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Area Chart -->
                            <div class="col-xl-12 col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold">
                                            <?php if ($_SESSION['GRUPO'] == '1') { ?>
                                                <i class="fas fa-globe"></i> Sites que Publicaram (Releases)
                                            <?php } else if ($_SESSION['GRUPO'] == '15') { ?>
                                                <i class="fas fa-globe"></i> Sites Prioritários 
                                            <?php } else if ($_SESSION['GRUPO'] == '2') { ?>
                                                <i class="fas fa-globe"></i> Sites Gerais
                                            <?php } else if ($_SESSION['GRUPO'] == '5') { ?>  
                                                <i class="fas fa-globe"></i> Sites Prioritários (RELEASES)<br>
                                            <?php } ?>        
                                        </h6>
                                    </div>
                                    <div class="card-body card-chart">
                                        <progress id="animationProgress" max="1" value="0" style="width: 100%;"></progress>
                                        <div class="chart-area">
                                            <canvas id="veiculosChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pie Chart -->

                            <!-- Invoice Example -->
                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold">Avaliação</h6>
                                    </div>
                                    <div class="card-body card-chart">
                                        <progress id="animationProgress2" max="1" value="0" style="width: 100%;"></progress>
                                        <div class="chart-bar"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                            <canvas id="avaliacaoChart" width="287" height="160" style="display: block; width: 287px; height: 160px;" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; <script> document.write(new Date().getFullYear());</script> - Porto Monitor - Todos os direitos reservados
                            </span>
                        </div>
                    </div>
                </footer>
                <!-- Footer -->
            </div>
        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="<?= base_url() ?>assets/js/ruang-admin.js"></script>
        <script src="<?= base_url() ?>assets/vendor/chart.js/Chart.min.js"></script>
        <script src="<?= base_url() ?>assets/js/demo/chart-area-demo.js"></script>  
        <script src="<?= base_url() ?>assets/js/demo/chart-bar-demo.js"></script>  
        <script src="<?= base_url() ?>assets/vendor/datatables/jquery.dataTables.min.js"></script> 
        <script src="<?= base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script> 
        <script src="<?= base_url() ?>assets/js/dash.js?nocache=<?= rand(1, 10000000) ?>"></script>
        <script>
                                $(document).ready(function () {
//                                    $(document).on('change', '.relatorio', function (e) {
//                                        $("#formPadrao").submit();
//                                    });
                                    if (CLIENTE !== "") {
                                        if (GRUPO == 1) {
                                            $('#dataTable').DataTable({
                                                'processing': true,
                                                'serverSide': true,
                                                'serverMethod': 'post',
                                                'ajax': {
                                                    'data': {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                                    'url': baseUrl + 'ranking',
                                                    dataType: "json"
                                                },
                                                "columnDefs": [
                                                    {
                                                        "targets": [0, 1, 2, 3, 4, 5],
                                                        "orderable": false
                                                    }
                                                ],
                                                language: {
                                                    url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json"
                                                }
                                            });
                                        } else if (GRUPO == 15 || GRUPO == 2) {
                                            $('#dataTable').DataTable({
                                                'processing': true,
                                                'serverSide': true,
                                                'serverMethod': 'post',
                                                'ajax': {
                                                    'data': {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                                    'url': baseUrl + 'rankingPrioritario',
                                                    dataType: "json"

                                                },
                                                "columnDefs": [
                                                    {
                                                        "targets": [0, 1, 2, 3, 4, 5],
                                                        "orderable": false
                                                    }
                                                ],
                                                language: {
                                                    url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json"
                                                }
                                            });
                                        } else if (GRUPO == 3) {
                                            $('#dataTable').DataTable({
                                                'processing': true,
                                                'serverSide': true,
                                                'serverMethod': 'post',
                                                'ajax': {
                                                    'data': {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                                    'url': baseUrl + 'rankingRadio',
                                                    dataType: "json"

                                                },
                                                "columnDefs": [
                                                    {
                                                        "targets": [0, 1, 2, 3, 4, 5],
                                                        "orderable": false
                                                    }
                                                ],
                                                language: {
                                                    url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json"
                                                }
                                            });
                                        } else if (GRUPO == 4) {
                                            $('#dataTable').DataTable({
                                                'processing': true,
                                                'serverSide': true,
                                                'serverMethod': 'post',
                                                'ajax': {
                                                    'data': {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                                    'url': baseUrl + 'rankingTV',
                                                    dataType: "json"

                                                },
                                                "columnDefs": [
                                                    {
                                                        "targets": [0, 1, 2, 3, 4, 5],
                                                        "orderable": false
                                                    }
                                                ],
                                                language: {
                                                    url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json"
                                                }
                                            });
                                        } else if (GRUPO == 5) {
                                            $('#dataTable').DataTable({
                                                'processing': true,
                                                'serverSide': true,
                                                'serverMethod': 'post',
                                                'ajax': {
                                                    'data': {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                                    'url': baseUrl + 'rankingPrioritarioRelease',
                                                    dataType: "json"
                                                },
                                                "columnDefs": [
                                                    {
                                                        "targets": [0, 1, 2, 3, 4, 5],
                                                        "orderable": false
                                                    }
                                                ],
                                                language: {
                                                    url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json"
                                                }
                                            });
                                        }
                                    }
                                    setInterval(function () {
                                        $.ajax({
                                            type: "POST",
                                            dataType: 'json',
                                            data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                            url: baseUrl + 'verificaAtualizacao',
                                            success: function (data) {
                                                if (data.ATIVO == 1) {
                                                    const dataAtual = new Date().toLocaleDateString();
                                                    const hora = new Date().toLocaleTimeString();
                                                    
                                                    $("#dataAtualiza").html('<b>Atualizado em: '+dataAtual+' às '+hora+'</b>');
                                                    $("#txtQuantMatPosi").text('CARREGANDO...');
                                                    $("#txtQuantMatNeg").text('CARREGANDO...');
                                                    $("#txtQuantMatNeut").text('CARREGANDO...');
                                                    carregaMaterias();
                                                    $('#dataTable').DataTable().ajax.reload();
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: 'json',
                                                        data: {atualiza: 1, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                                        url: baseUrl + 'carregaGraficoVeiculos',
                                                        success: function (data) {
                                                            const labelVeiculos = data.dados.map(
                                                                    function (index) {
                                                                        return index.site;
                                                                    }
                                                            );
                                                            const dataVeiculos = data.dados.map(
                                                                    function (index) {
                                                                        return index.quantidade;
                                                                    }
                                                            );

                                                            graficoVeiculo.config.data.labels = labelVeiculos;
                                                            graficoVeiculo.config.data.datasets[0].data = dataVeiculos;
                                                            graficoVeiculo.update();
                                                        }
                                                    });
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: 'json',
                                                        data: {atualiza: 1, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                                        url: baseUrl + 'carregaGraficoAvaliacao',
                                                        success: function (data) {
                                                            const labelAvalia = data.dados.map(
                                                                    function (index) {
                                                                        if (index.name === 'APOSITIVO') {
                                                                            index.name = 'POSITIVO';
                                                                        }
                                                                        return index.name;
                                                                    }
                                                            );
                                                            const dataAvalia = data.dados.map(
                                                                    function (index) {
                                                                        return index.value;
                                                                    }
                                                            );

                                                            const cor = data.dados.map(
                                                                    function (index) {
                                                                        return index.cor;
                                                                    }
                                                            );
                                                    
                                                            graficoAvaliacao.config.data.labels = labelAvalia;
                                                            graficoAvaliacao.config.data.datasets[0].data = dataAvalia;
                                                            graficoAvaliacao.update();
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    }, 60000);
                                    $("#customSwitch2").change(function () {
                                        if ($(this).prop("checked") == true) {
                                            $.ajax({
                                                type: "POST",
                                                dataType: 'json',
                                                data: {atualiza: 1, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                                url: baseUrl + 'atualizacao',
                                                success: function (data) {

                                                }
                                            });
                                        } else {
                                            $.ajax({
                                                type: "POST",
                                                dataType: 'json',
                                                data: {atualiza: 0, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                                                url: baseUrl + 'atualizacao',
                                                success: function (data) {

                                                }
                                            });
                                        }
                                    });
                                });
        </script>
    </body>
</html>
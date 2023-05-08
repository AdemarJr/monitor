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
        .mais-texto {
            display: none;
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
                                <li class="breadcrumb-item">Dashboard / Matérias</li>
                            </ol>
                        </div>
                        <?php if (!empty($materias)) { ?>
                            <div class="row">
                                <?php foreach ($materias as $materia) { ?>
                                    <div class="col-md-4" style="margin-bottom: 1%;">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="h6 mb-0 text-gray-800">Publicado em <?= $materia['DIA'] ?> no <?= $ctrl->portal($materia['SEQ_PORTAL']) ?></div>
                                                <div class="h6 mb-0 text-gray-800"><?= $materia['DESC_SETOR'] ?></div>
                                                <hr>
                                                <div class="h5 mb-0 text-gray-800" style="padding-bottom: 2%;">
                                                    <?php if (!empty($materia['LINK_MATERIA'])) { ?>
                                                        <a href="<?= $materia['LINK_MATERIA'] ?>" target="_blank">
                                                            <b><?= $materia['TIT_MATERIA'] ?></b>
                                                        </a>
                                                    <?php } else { ?>
                                                        <b><?= $materia['TIT_MATERIA'] ?></b>
                                                    <?php } ?>
                                                </div>
                                                <span class="txt-curto-<?= $materia['SEQ_MATERIA'] ?>" style="font-size: 11pt;">
                                                    <?= mb_strimwidth($materia['TEXTO_MATERIA'], 0, 200, "...") ?>    
                                                </span>
                                                <span class="mais-texto texto-<?= $materia['SEQ_MATERIA'] ?>">
                                                    <?= $materia['TEXTO_MATERIA'] ?>    
                                                </span>
                                                <div class="row" style="margin-top: 1%;">
                                                    <div class="col-md-3">
                                                        <a class="btn-default btn-leia-mais btn-<?= $materia['SEQ_MATERIA'] ?>" data-id="<?= $materia['SEQ_MATERIA'] ?>" style="width: 100px; font-weight: bold; border-radius:20px;color: black; cursor: pointer">LER MAIS</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>    
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-md-12" style="margin-bottom: 1%;">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            Nenhuma matéria disponível
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; <script> document.write(new Date().getFullYear());</script> - Porto Monitor - Todos os direitos reservados
                            </span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/js/ruang-admin.js"></script>
        <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script>
                                $(document).ready(function () {
                                    $('body').delegate('.btn-leia-mais', 'click', function (e) {
                                        e.preventDefault();
                                        var materia = $(this).attr("data-id");
                                        var btn = $(".btn-" + materia).text();
                                        if (btn === 'LER MAIS') {
                                            $(".btn-" + materia).text("LER MENOS");
                                            $('.txt-curto-' + materia).css('display', 'none');
                                            $('.mais-texto').css('display', 'none');
                                            $('.texto-' + materia).css('display', 'block');
                                        } else {
                                            $(".scroll-to-top").click();
                                            $(".btn-" + materia).text("LER MAIS");
                                            $('.txt-curto-' + materia).css('display', 'block');
                                            $('.mais-texto').css('display', 'none');
                                            $('.texto-' + materia).css('display', 'none');
                                        }
                                    });
                                });
        </script>
    </body>
</html>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="<?= base_url() ?>/assets/js/grafico.js" type="text/javascript"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <title>Gráficos - Quantitativo por Secretaria/Setor</title>
        <style>
            @media print {
                .pagebreak {
                    clear: both;
                    page-break-after: always;
                }
            }
        </style>
        <script>

            Chart.Tooltip.positioners.outer = function (elements) {
                if (!elements.length) {
                    return false;
                }

                var i, len;
                var x = 0;
                var y = 0;

                for (i = 0, len = elements.length; i < len; ++i) {
                    var el = elements[i];
                    if (el && el.hasValue()) {
                        var elPosX = el._view.x + 0.95 * el._view.outerRadius * Math.cos((el._view.endAngle - el._view.startAngle) / 2 + el._view.startAngle);
                        var elPosY = el._view.y + 0.95 * el._view.outerRadius * Math.sin((el._view.endAngle - el._view.startAngle) / 2 + el._view.startAngle);
                        if (x < elPosX) {
                            x = elPosX;
                        }
                        if (y < elPosY) {
                            y = elPosY;
                        }
                    }
                }

                return {
                    x: Math.round(x),
                    y: Math.round(y)
                };
            };
            Chart.pluginService.register({
                beforeRender: function (chart) {
                    if (chart.config.options.showAllTooltips) {
                        // create an array of tooltips
                        // we can't use the chart tooltip because there is only one tooltip per chart
                        chart.pluginTooltips = [];
                        chart.config.data.datasets.forEach(function (dataset, i) {
                            chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                                chart.pluginTooltips.push(new Chart.Tooltip({
                                    _chart: chart.chart,
                                    _chartInstance: chart,
                                    _data: chart.data,
                                    _options: chart.options.tooltips,
                                    _active: [sector]
                                }, chart));
                            });
                        });

                        // turn off normal tooltips
                        chart.options.tooltips.enabled = false;
                    }
                },
                afterDraw: function (chart, easing) {
                    if (chart.config.options.showAllTooltips) {
                        // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
                        if (!chart.allTooltipsOnce) {
                            if (easing !== 1)
                                return;
                            chart.allTooltipsOnce = true;
                        }

                        // turn on tooltips
                        chart.options.tooltips.enabled = true;
                        Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
                            tooltip.initialize();
                            tooltip.update();
                            // we don't actually need this since we are not animating tooltips
                            tooltip.pivot();
                            tooltip.transition(easing).draw();
                        });
                        chart.options.tooltips.enabled = false;
                    }
                }
            });
        </script>
    </head>
    <body>
        <?php
        $dataCliente = $this->ComumModelo->getCliente($idCliente)->row();
        $controle = 0;
        ?>
        <?php
        $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'I', NULL, NULL, $excluirSetor, $setores, $tags);

        $lista_setorP = $this->ComumModelo->quantitativoSetorPanorama($datai, $dataf, $idCliente, 'I', $grupo, $excluirSetor, $setores, $tags);
        $lista_setor2 = $this->ComumModelo->quantitativoSetor($datai, $dataf, $idCliente, 'I', $grupo, $excluirSetor, $setores, $tags);

        $totalP = 0;
        $totalN = 0;
        $totalT = 0;
        $totalG = 0;
        $result_array_i = array(
            'POSITIVO' => 0,
            'NEGATIVO' => 0,
            'NEUTRO' => 0,
            'TOTAL' => 0
        );
        $result_array_s = array(
            'POSITIVO' => 0,
            'NEGATIVO' => 0,
            'NEUTRO' => 0,
            'TOTAL' => 0
        );
        $result_array_r = array(
            'POSITIVO' => 0,
            'NEGATIVO' => 0,
            'NEUTRO' => 0,
            'TOTAL' => 0
        );
        $result_array_t = array(
            'POSITIVO' => 0,
            'NEGATIVO' => 0,
            'NEUTRO' => 0,
            'TOTAL' => 0
        );
        if (!empty($lista_setorP)) {
            foreach ($lista_setorP as $itemS):
                if ($itemS['TIPO_MATERIA'] == 'I') {
                    $result_array_i['POSITIVO'] += $itemS['POSITIVO'];
                    $result_array_i['NEGATIVO'] += $itemS['NEGATIVO'];
                    $result_array_i['NEUTRO'] += $itemS['NEUTRO'];
                    $result_array_i['TOTAL'] += $itemS['TOTAL'];
                } else if ($itemS['TIPO_MATERIA'] == 'S') {
                    $result_array_s['POSITIVO'] += $itemS['POSITIVO'];
                    $result_array_s['NEGATIVO'] += $itemS['NEGATIVO'];
                    $result_array_s['NEUTRO'] += $itemS['NEUTRO'];
                    $result_array_s['TOTAL'] += $itemS['TOTAL'];
                } else if ($itemS['TIPO_MATERIA'] == 'R') {
                    $result_array_r['POSITIVO'] += $itemS['POSITIVO'];
                    $result_array_r['NEGATIVO'] += $itemS['NEGATIVO'];
                    $result_array_r['NEUTRO'] += $itemS['NEUTRO'];
                    $result_array_r['TOTAL'] += $itemS['TOTAL'];
                } else if ($itemS['TIPO_MATERIA'] == 'T') {
                    $result_array_t['POSITIVO'] += $itemS['POSITIVO'];
                    $result_array_t['NEGATIVO'] += $itemS['NEGATIVO'];
                    $result_array_t['NEUTRO'] += $itemS['NEUTRO'];
                    $result_array_t['TOTAL'] += $itemS['TOTAL'];
                }
            endforeach;
        }

        if (!empty($lista_setorP)) {
            $controle = 1;
            ?>
            <nav class="print-hide" style="background-color: #3F51B5"></nav>
            <div class="container">
                <div class="row print-hide">
                    <div class="col s12">
                        <div class="card grey lighten-2" style="border-radius: 25px;">
                            <div class="card-content white-text">
                                <button class="waves-effect waves-light btn" style="border-radius: 15px;">GERAR PDF</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="line-height: .8; margin-top: 2%">
                        <p style="font-size: 22px; font-weight: bold; text-align: center;">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?></p>
                        <p style="font-size: 18px; font-weight: bold; text-align: center;">PANORAMA GERAL</p>
                        <p style="font-size: 18px; font-weight: bold; text-align: center;"><?php echo $datai . ' - ' . $dataf; ?></p>
                    </div>
                </div>
                <div class="row" style="margin-left: -10%;">
                    <div class="col s6">
                        <?php
                        $positivo = number_format(($result_array_i['POSITIVO'] / $result_array_i['TOTAL'] * 100), 2, '.', '.');
                        $negativo = number_format(($result_array_i['NEGATIVO'] / $result_array_i['TOTAL'] * 100), 2, '.', '.');
                        $neutro = number_format(($result_array_i['NEUTRO'] / $result_array_i['TOTAL'] * 100), 2, '.', '.');
                        ?>
                        <p style="text-align: center; margin-left: 8%;">IMPRESSO</p>
                        <canvas id="panorama-impresso" width="320" height="320"></canvas>
                    </div>
                    <div class="col s6">
                        <p style="text-align: center; margin-left: 8%;">RÁDIO</p>
                        <canvas id="panorama-radio" width="320" height="320"></canvas>
                    </div>

                </div>
                <div class="pagebreak"> </div>
                <div class="row" style="margin-left: -10%;">
                    <div class="col s6">
                        <p style="text-align: center; margin-left: 8%;">INTERNET</p>
                        <canvas id="panorama-internet" width="320" height="320"></canvas>
                    </div>
                    <div class="col s6">
                        <p style="text-align: center; margin-left: 8%;">TV</p>
                        <canvas id="panorama-tv" width="320" height="320"></canvas>
                    </div>
                </div>
                <div class="pagebreak"> </div>
                <?php if (!empty($lista_setor)) { ?>
                    <div class="row">
                        <div class="col-md-12" style="line-height: .8; margin-top: 2%">
                            <p style="font-size: 22px; font-weight: bold; text-align: center;">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?></p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;">VEÍCULO</p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;"><?php echo $datai . ' - ' . $dataf; ?></p>
                        </div>

                        <p><b>CLIPPING IMPRESSO</b></p>
                        <?php
                        $totalP = 0;
                        $totalN = 0;
                        $totalT = 0;
                        $totalG = 0;
                        $pos = '';
                        $neg = '';
                        $neu = '';
                        $descricao_clip_impresso = '';

                        foreach ($lista_setor as $itemS) {
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $descricao_clip_impresso .= "'" . $itemS['DESCRICAO'] . "', ";
                            $pos .= "'" . $itemS['POSITIVO'] . "', ";
                            $neg .= "'" . $itemS['NEGATIVO'] . "', ";
                            $neu .= "'" . $itemS['NEUTRO'] . "', ";
                        }
                        ?>
                        <canvas id="veiculo-impresso" height="20" width="20" style="margin-left: -2%;"></canvas>
                    </div>
                    <div class="pagebreak"> </div>    
                <?php } ?>
                <?php if (!empty($lista_setor2)) { ?>    
                    <div class="row">
                        <div class="col-md-12" style="line-height: .8; margin-top: 2%">
                            <p style="font-size: 22px; font-weight: bold; text-align: center;">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?></p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;">SECRETÁRIA/SETOR</p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;"><?php echo $datai . ' - ' . $dataf; ?></p>
                        </div>
                        <p><b>CLIPPING IMPRESSO</b></p>
                        <?php $i = 0; ?>
                        <?php foreach ($lista_setor2 as $itemS) { ?>
                            <?php if ($itemS['TIPO_MATERIA'] == 'I') { ?>
                                <div class="col s6">
                                    <?php
                                    $totalP = 0;
                                    $totalN = 0;
                                    $totalT = 0;
                                    $totalG = 0;
                                    $totalP += $itemS['POSITIVO'];
                                    $totalN += $itemS['NEGATIVO'];
                                    $totalT += $itemS['NEUTRO'];
                                    $totalG += $itemS['TOTAL'];
                                    $i++;
                                    ?>
                                    <p style="text-align: center; margin-left: 8%;"><?= mb_strimwidth($itemS['DESC_SETOR'], 0, 70, "..."); ?></p>
                                    <canvas id="secretaria-setor-impresso-<?= $i ?>" height="20" width="20" style="margin-bottom: 2px;"></canvas>
                                    <script>
                                        new Chart(document.getElementById('secretaria-setor-impresso-<?= $i ?>'), {
                                            type: 'bar',
                                            data: {
                                                labels: ['POSITIVO', 'NEGATIVO', 'NEUTRO'],
                                                datasets: [{
                                                        data: [<?= number_format($totalP, 0, ',', '.') ?>, <?= number_format($totalN, 0, ',', '.') ?>, <?= number_format($totalT, 0, ',', '.') ?>],
                                                        backgroundColor: [
                                                            'rgb(46, 125, 50)',
                                                            'rgb(244, 67, 54)',
                                                            'rgb(255, 111, 0)'
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                            },
                                            options: {
                                                legend: {
                                                    display: false
                                                },
                                                responsive: true,
                                                showAllTooltips: true,
                                                maintainAspectRatio: false,
                                                scales: {
                                                    yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true
                                                            }
                                                        }]
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="pagebreak"> </div>    
                <?php } ?>
                <?php $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'S', NULL, NULL, $excluirSetor, $setores, $tags); ?> 
                <?php if (!empty($lista_setor)) { ?>
                    <div class="row">
                        <div class="col-md-12" style="line-height: .8; margin-top: 2%">
                            <p style="font-size: 22px; font-weight: bold; text-align: center;">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?></p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;">VEÍCULO</p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;"><?php echo $datai . ' - ' . $dataf; ?></p>
                        </div>
                        <p><b>CLIPPING INTERNET</b></p>

                        <?php
                        $i = 0;
                        foreach ($lista_setor as $itemS) {
                            $totalP = 0;
                            $totalN = 0;
                            $totalT = 0;
                            $totalG = 0;
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $i++;
                            ?>
                            <div class="col s6">
                                <p style="text-align: center; margin-left: 8%;"><?= mb_strimwidth($itemS['DESCRICAO'], 0, 70, "..."); ?></p>
                                <canvas id="veiculo-internet-<?= $i ?>" height="20" width="20" style="margin-bottom: 2px;"></canvas>
                                <script>
                                    new Chart(document.getElementById('veiculo-internet-<?= $i ?>'), {
                                        type: 'bar',
                                        data: {
                                            labels: ['POSITIVO', 'NEGATIVO', 'NEUTRO'],
                                            datasets: [{
                                                    data: [<?= number_format($totalP, 0, ',', '.') ?>, <?= number_format($totalN, 0, ',', '.') ?>, <?= number_format($totalT, 0, ',', '.') ?>],
                                                    backgroundColor: [
                                                        'rgb(46, 125, 50)',
                                                        'rgb(244, 67, 54)',
                                                        'rgb(255, 111, 0)'
                                                    ],
                                                    borderWidth: 1
                                                }]
                                        },
                                        options: {
                                            legend: {
                                                display: false
                                            },
                                            responsive: true,
                                            showAllTooltips: true,
                                            maintainAspectRatio: false,
                                            scales: {
                                                yAxes: [{
                                                        ticks: {
                                                            beginAtZero: true
                                                        }
                                                    }]
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        <?php } ?>    
                    </div>
                    <div class="pagebreak"> </div>       
                <?php } ?>   
                <?php $lista_setor3 = $this->ComumModelo->quantitativoSetorInternet($datai, $dataf, $idCliente, 'S', $grupo, $excluirSetor, $setores, $tags); ?>  
                <?php if (!empty($lista_setor3)) { ?>
                    <div class="row">
                        <div class="col-md-12" style="line-height: .8; margin-top: 2%">
                            <p style="font-size: 22px; font-weight: bold; text-align: center;">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?></p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;">SECRETARIA/SETOR</p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;"><?php echo $datai . ' - ' . $dataf; ?></p>
                        </div>
                        <p><b>CLIPPING INTERNET</b></p>
                        <?php
                        $i = 0;
                        foreach ($lista_setor3 as $itemS) {
                            if ($itemS['TIPO_MATERIA'] == 'S') {
                                $totalP = 0;
                                $totalN = 0;
                                $totalT = 0;
                                $totalG = 0;
                                $totalP += $itemS['POSITIVO'];
                                $totalN += $itemS['NEGATIVO'];
                                $totalT += $itemS['NEUTRO'];
                                $totalG += $itemS['TOTAL'];
                                $i++;
                                ?>
                                <div class="col s6">
                                    <p style="text-align: center; margin-left: 8%;"><?= mb_strimwidth($itemS['DESC_SETOR'], 0, 70, "..."); ?></p>
                                    <canvas id="veiculo-setor-internet-<?= $i ?>" height="20" width="20" style="margin-bottom: 2px;"></canvas>
                                    <script>
                                        new Chart(document.getElementById('veiculo-setor-internet-<?= $i ?>'), {
                                            type: 'bar',
                                            data: {
                                                labels: ['POSITIVO', 'NEGATIVO', 'NEUTRO'],
                                                datasets: [{
                                                        data: [<?= number_format($totalP, 0, ',', '.') ?>, <?= number_format($totalN, 0, ',', '.') ?>, <?= number_format($totalT, 0, ',', '.') ?>],
                                                        backgroundColor: [
                                                            'rgb(46, 125, 50)',
                                                            'rgb(244, 67, 54)',
                                                            'rgb(255, 111, 0)'
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                            },
                                            options: {
                                                legend: {
                                                    display: false
                                                },
                                                responsive: true,
                                                showAllTooltips: true,
                                                maintainAspectRatio: false,
                                                scales: {
                                                    yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true
                                                            }
                                                        }]
                                                }
                                            }
                                        });
                                    </script>
                                </div>    
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="pagebreak"> </div>        
                <?php } ?>
                <?php $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'R', NULL, NULL, $excluirSetor, $setores, $tags); ?> 
                <?php if (!empty($lista_setor)) { ?>
                    <div class="row">
                        <div class="col-md-12" style="line-height: .8; margin-top: 2%">
                            <p style="font-size: 22px; font-weight: bold; text-align: center;">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?></p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;">VEÍCULO</p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;"><?php echo $datai . ' - ' . $dataf; ?></p>
                        </div>
                        <p><b>CLIPPING RÁDIO</b></p>

                        <?php
                        $i = 0;
                        foreach ($lista_setor as $itemS) {
                            $totalP = 0;
                            $totalN = 0;
                            $totalT = 0;
                            $totalG = 0;
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $i++;
                            ?>
                            <div class="col s6">
                                <p style="text-align: center; margin-left: 8%;"><?= mb_strimwidth($itemS['DESCRICAO'], 0, 70, "..."); ?></p>
                                <canvas id="veiculo-radio-<?= $i ?>" height="20" width="20" style="margin-bottom: 2px;"></canvas>
                                <script>
                                    new Chart(document.getElementById('veiculo-radio-<?= $i ?>'), {
                                        type: 'bar',
                                        data: {
                                            labels: ['POSITIVO', 'NEGATIVO', 'NEUTRO'],
                                            datasets: [{
                                                    data: [<?= number_format($totalP, 0, ',', '.') ?>, <?= number_format($totalN, 0, ',', '.') ?>, <?= number_format($totalT, 0, ',', '.') ?>],
                                                    backgroundColor: [
                                                        'rgb(46, 125, 50)',
                                                        'rgb(244, 67, 54)',
                                                        'rgb(255, 111, 0)'
                                                    ],
                                                    borderWidth: 1
                                                }]
                                        },
                                        options: {
                                            legend: {
                                                display: false
                                            },
                                            responsive: true,
                                            showAllTooltips: true,
                                            maintainAspectRatio: false,
                                            scales: {
                                                yAxes: [{
                                                        ticks: {
                                                            beginAtZero: true
                                                        }
                                                    }]
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        <?php } ?>    
                    </div>
                    <div class="pagebreak"> </div>       
                <?php } ?>  
                <?php if (!empty($lista_setor2)) { ?>
                    <div class="row">
                        <div class="col-md-12" style="line-height: .8; margin-top: 2%">
                            <p style="font-size: 22px; font-weight: bold; text-align: center;">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?></p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;">SECRETARIA/SETOR</p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;"><?php echo $datai . ' - ' . $dataf; ?></p>
                        </div>
                        <p><b>CLIPPING RÁDIO</b></p>
                        <?php
                        $i = 0;
                        foreach ($lista_setor2 as $itemS) {
                            if ($itemS['TIPO_MATERIA'] == 'R') {
                                $totalP = 0;
                                $totalN = 0;
                                $totalT = 0;
                                $totalG = 0;
                                $totalP += $itemS['POSITIVO'];
                                $totalN += $itemS['NEGATIVO'];
                                $totalT += $itemS['NEUTRO'];
                                $totalG += $itemS['TOTAL'];
                                $i++;
                                ?>
                                <div class="col s6">
                                    <p style="text-align: center; margin-left: 8%;"><?= mb_strimwidth($itemS['DESC_SETOR'], 0, 70, "..."); ?></p>
                                    <canvas id="veiculo-radio-secretaria-<?= $i ?>" height="20" width="20" style="margin-bottom: 2px;"></canvas>
                                    <script>
                                        new Chart(document.getElementById('veiculo-radio-secretaria-<?= $i ?>'), {
                                            type: 'bar',
                                            data: {
                                                labels: ['POSITIVO', 'NEGATIVO', 'NEUTRO'],
                                                datasets: [{
                                                        data: [<?= number_format($totalP, 0, ',', '.') ?>, <?= number_format($totalN, 0, ',', '.') ?>, <?= number_format($totalT, 0, ',', '.') ?>],
                                                        backgroundColor: [
                                                            'rgb(46, 125, 50)',
                                                            'rgb(244, 67, 54)',
                                                            'rgb(255, 111, 0)'
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                            },
                                            options: {
                                                legend: {
                                                    display: false
                                                },
                                                responsive: true,
                                                showAllTooltips: true,
                                                maintainAspectRatio: false,
                                                scales: {
                                                    yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true
                                                            }
                                                        }]
                                                }
                                            }
                                        });
                                    </script>
                                </div>        
                                <?php
                            }
                        }
                        ?> 
                    </div>
                    <div class="pagebreak"> </div>            
                <?php } ?>    
                <?php $lista_setor = $this->ComumModelo->quantitativoVeiculo($datai, $dataf, $idCliente, $grupo, 'T', NULL, NULL, $excluirSetor, $setores, $tags); ?> 
                <?php if (!empty($lista_setor)) { ?>
                    <div class="row">
                        <div class="col-md-12" style="line-height: .8; margin-top: 2%">
                            <p style="font-size: 22px; font-weight: bold; text-align: center;">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?></p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;">VEÍCULO</p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;"><?php echo $datai . ' - ' . $dataf; ?></p>
                        </div>
                        <p><b>CLIPPING TELEVISÃO</b></p>

                        <?php
                        $i = 0;
                        foreach ($lista_setor as $itemS) {
                            $totalP = 0;
                            $totalN = 0;
                            $totalT = 0;
                            $totalG = 0;
                            $totalP += $itemS['POSITIVO'];
                            $totalN += $itemS['NEGATIVO'];
                            $totalT += $itemS['NEUTRO'];
                            $totalG += $itemS['TOTAL'];
                            $i++;
                            ?>
                            <div class="col s6">
                                <p style="text-align: center; margin-left: 8%;"><?= mb_strimwidth($itemS['DESCRICAO'], 0, 70, "..."); ?></p>
                                <canvas id="veiculo-tv-<?= $i ?>" height="20" width="20" style="margin-bottom: 2px;"></canvas>
                                <script>
                                    new Chart(document.getElementById('veiculo-tv-<?= $i ?>'), {
                                        type: 'bar',
                                        data: {
                                            labels: ['POSITIVO', 'NEGATIVO', 'NEUTRO'],
                                            datasets: [{
                                                    data: [<?= number_format($totalP, 0, ',', '.') ?>, <?= number_format($totalN, 0, ',', '.') ?>, <?= number_format($totalT, 0, ',', '.') ?>],
                                                    backgroundColor: [
                                                        'rgb(46, 125, 50)',
                                                        'rgb(244, 67, 54)',
                                                        'rgb(255, 111, 0)'
                                                    ],
                                                    borderWidth: 1
                                                }]
                                        },
                                        options: {
                                            legend: {
                                                display: false
                                            },
                                            responsive: true,
                                            showAllTooltips: true,
                                            maintainAspectRatio: false,
                                            scales: {
                                                yAxes: [{
                                                        ticks: {
                                                            beginAtZero: true
                                                        }
                                                    }]
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        <?php } ?>    
                    </div>
                    <div class="pagebreak"> </div>       
                <?php } ?> 
                <?php if (!empty($lista_setor2)) { ?>
                    <div class="row">
                        <div class="col-md-12" style="line-height: .8; margin-top: 2%">
                            <p style="font-size: 22px; font-weight: bold; text-align: center;">CLIPPING <?php echo strtoupper($dataCliente->NOME_CLIENTE); ?></p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;">SECRETARIA/SETOR</p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center;"><?php echo $datai . ' - ' . $dataf; ?></p>
                        </div>
                        <p><b>CLIPPING TELEVISÃO</b></p>
                        <?php
                        $i = 0;
                        foreach ($lista_setor2 as $itemS) {
                            if ($itemS['TIPO_MATERIA'] == 'T') {
                                $totalP = 0;
                                $totalN = 0;
                                $totalT = 0;
                                $totalG = 0;
                                $totalP += $itemS['POSITIVO'];
                                $totalN += $itemS['NEGATIVO'];
                                $totalT += $itemS['NEUTRO'];
                                $totalG += $itemS['TOTAL'];
                                $i++;
                                ?>
                                <div class="col s6">
                                    <p style="text-align: center; margin-left: 8%;"><?= mb_strimwidth($itemS['DESC_SETOR'], 0, 70, "..."); ?></p>
                                    <canvas id="veiculo-tv-secretaria-<?= $i ?>" height="20" width="20" style="margin-bottom: 2px;"></canvas>
                                    <script>
                                        new Chart(document.getElementById('veiculo-tv-secretaria-<?= $i ?>'), {
                                            type: 'bar',
                                            data: {
                                                labels: ['POSITIVO', 'NEGATIVO', 'NEUTRO'],
                                                datasets: [{
                                                        data: [<?= number_format($totalP, 0, ',', '.') ?>, <?= number_format($totalN, 0, ',', '.') ?>, <?= number_format($totalT, 0, ',', '.') ?>],
                                                        backgroundColor: [
                                                            'rgb(46, 125, 50)',
                                                            'rgb(244, 67, 54)',
                                                            'rgb(255, 111, 0)'
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                            },
                                            options: {
                                                legend: {
                                                    display: false
                                                },
                                                responsive: true,
                                                showAllTooltips: true,
                                                maintainAspectRatio: false,
                                                scales: {
                                                    yAxes: [{
                                                            ticks: {
                                                                beginAtZero: true
                                                            }
                                                        }]
                                                }
                                            }
                                        });
                                    </script>
                                </div>        
                                <?php
                            }
                        }
                        ?> 
                    </div>
                    <div class="pagebreak"> </div>            
                <?php } ?>    
                <div id="load" class="modal"></div>    
            </div>
        <?php } else { ?>
            <?php
            redirect('relatorio/contadorGeral');
        }
        ?>
        <script>
            $('.modal').modal();
            $('#load').modal('open');
            setTimeout(function () {
                $('#load').modal('close');
            }, 1500);
            $('body').delegate('.btn', 'click', function () {
                $('.print-hide').css('display', 'none');
                window.print();
            });
            new Chart(document.getElementById('panorama-impresso'), {
                type: 'pie',
                data: {
                    labels: ['POSITIVO: <?= $positivo ?>%', 'NEGATIVO: <?= $negativo ?>%', 'NEUTRO: <?= $neutro ?>%'],
                    datasets: [{
                            data: [<?= $positivo ?>, <?= $negativo ?>, <?= $neutro ?>],
                            backgroundColor: [
                                'rgb(46, 125, 50)',
                                'rgb(244, 67, 54)',
                                'rgb(255, 111, 0)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    responsive: true,
                    showAllTooltips: false,
                    maintainAspectRatio: false
                }
            });
            new Chart(document.getElementById('panorama-radio'), {
                type: 'pie',
                data: {
                    labels: ['POSITIVO: <?= number_format(($result_array_r['POSITIVO'] / $result_array_r['TOTAL'] * 100), 2, '.', '.') . '%' ?>', 'NEGATIVO: <?= number_format(($result_array_r['NEGATIVO'] / $result_array_r['TOTAL'] * 100), 2, '.', '.') . '%' ?>', 'NEUTRO: <?= number_format(($result_array_r['NEUTRO'] / $result_array_r['TOTAL'] * 100), 2, '.', '.') . '%' ?>'],
                    datasets: [{
                            data: [<?= number_format(($result_array_r['POSITIVO'] / $result_array_r['TOTAL'] * 100), 2, '.', '.') ?>, <?= number_format(($result_array_r['NEGATIVO'] / $result_array_r['TOTAL'] * 100), 2, '.', '.') ?>, <?= number_format(($result_array_r['NEUTRO'] / $result_array_r['TOTAL'] * 100), 2, '.', '.') ?>],
                            backgroundColor: [
                                'rgb(46, 125, 50)',
                                'rgb(244, 67, 54)',
                                'rgb(255, 111, 0)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    showAllTooltips: false
                }
            });

            new Chart(document.getElementById('panorama-internet'), {
                type: 'pie',
                data: {
                    labels: ['POSITIVO: <?= number_format(($result_array_s['POSITIVO'] / $result_array_s['TOTAL'] * 100), 2, '.', '.') . '%' ?>', 'NEGATIVO: <?= number_format(($result_array_s['NEGATIVO'] / $result_array_s['TOTAL'] * 100), 2, '.', '.') . '%' ?>', 'NEUTRO: <?= number_format(($result_array_s['NEUTRO'] / $result_array_s['TOTAL'] * 100), 2, '.', '.') . '%' ?>'],
                    datasets: [{
                            data: [<?= number_format(($result_array_s['POSITIVO'] / $result_array_s['TOTAL'] * 100), 2, '.', '.') ?>, <?= number_format(($result_array_s['NEGATIVO'] / $result_array_s['TOTAL'] * 100), 2, '.', '.') ?>, <?= number_format(($result_array_s['NEUTRO'] / $result_array_s['TOTAL'] * 100), 2, '.', '.') ?>],
                            backgroundColor: [
                                'rgb(46, 125, 50)',
                                'rgb(244, 67, 54)',
                                'rgb(255, 111, 0)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
            new Chart(document.getElementById('panorama-tv'), {
                type: 'pie',
                data: {
                    labels: ['POSITIVO: <?= number_format(($result_array_t['POSITIVO'] / $result_array_t['TOTAL'] * 100), 2, '.', '.') . '%' ?>', 'NEGATIVO: <?= number_format(($result_array_t['NEGATIVO'] / $result_array_t['TOTAL'] * 100), 2, '.', '.') . '%' ?>', 'NEUTRO: <?= number_format(($result_array_t['NEUTRO'] / $result_array_t['TOTAL'] * 100), 2, '.', '.') . '%' ?>'],
                    datasets: [{
                            data: [<?= number_format(($result_array_t['POSITIVO'] / $result_array_t['TOTAL'] * 100), 2, '.', '.') ?>, <?= number_format(($result_array_t['NEGATIVO'] / $result_array_t['TOTAL'] * 100), 2, '.', '.') ?>, <?= number_format(($result_array_t['NEUTRO'] / $result_array_t['TOTAL'] * 100), 2, '.', '.') ?>],
                            backgroundColor: [
                                'rgb(46, 125, 50)',
                                'rgb(244, 67, 54)',
                                'rgb(255, 111, 0)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    maintainAspectRatio: false,
                }
            });

            new Chart(document.getElementById('veiculo-impresso'), {
                type: 'bar',
                data: {
                    labels: [<?= substr($descricao_clip_impresso, 0, -1); ?>],
                    datasets: [
                        {
                            label: 'POSITIVO',
                            data: [<?= $pos ?>],
                            backgroundColor: [
                                'rgb(46, 125, 50)',
                                'rgb(46, 125, 50)',
                                'rgb(46, 125, 50)'
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'NEGATIVO',
                            data: [<?= $neg ?>],
                            backgroundColor: [
                                'rgb(244, 67, 54)',
                                'rgb(244, 67, 54)',
                                'rgb(244, 67, 54)'
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'NEUTRO',
                            data: [<?= $neu ?>],
                            backgroundColor: [
                                'rgb(255, 111, 0)',
                                'rgb(255, 111, 0)',
                                'rgb(255, 111, 0)'
                            ],
                            borderWidth: 1
                        }

                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    showAllTooltips: true,
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        titleMarginBottom: 10
                    },
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
        </script>
    </body>
</html>
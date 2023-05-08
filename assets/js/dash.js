var baseUrl = 'dashboard/';
var progress = document.getElementById('animationProgress');
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
function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}

function removeData(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });
    chart.update();
}

function carregaMaterias() {
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: baseUrl + 'carregaMateriasCadastrados',
        success: function (data) {
            if (GRUPO == 15 || GRUPO == 2 || GRUPO == 3 || GRUPO == 4 || GRUPO == 5) {
                $("#txtQuantMatPosi").text(data.P);
                $("#txtQuantMatNeg").text(data.N);
                $("#txtQuantMatNeut").text(data.T);
                $("#txtQuantMat").text(data.TOTAL);
            } else if (GRUPO == 1) {
                $("#txtQuantMat").text(data['TOTAL']);
                $("#txtQuantMatPosi").text(data['TOTAL']);
                $("#txtQuantMatNeg").text('0');
                $("#txtQuantMatNeut").text('0');
            }
        }
    });
}

function carregaGraficoVeiculos() {
    $.ajax({
            type: "GET",
            dataType: 'json',
            url: baseUrl + 'carregaGraficoVeiculos',
            beforeSend: function () {
                $('#animationProgress').css('width', '5%');
                $('#animationProgress').attr('value', 5);
                window.setTimeout(function () {
                    $('#animationProgress').css('width', '25%');
                    $('#animationProgress').attr('value', 25);
                }, 6000);
                window.setTimeout(function () {
                    $('#animationProgress').css('width', '55%');
                    $('#animationProgress').attr('value', 55);
                }, 8000);
                window.setTimeout(function () {
                    $('#animationProgress').css('width', '75%');
                    $('#animationProgress').attr('value', 75);
                }, 10000);
            },
            success: function (data) {
                $('#animationProgress').css('display', 'none');
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

                const ctx = document.getElementById('veiculosChart');

                graficoVeiculo = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labelVeiculos,
                        datasets: [{
                                label: 'VEICULOS QUE PUBLICARAM MATÉRIAS',
                                data: dataVeiculos,
                                borderWidth: 1,
                                backgroundColor: "#4e73df",
                                hoverBackgroundColor: "#2e59d9",
                                borderColor: "#4e73df"
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }

                        },
                        tooltips: {
                            callbacks: {

                                label: function (tooltipItem, chart) {
                                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                    return  '' + number_format(tooltipItem.yLabel);
                                }
                            }
                        }
                    }

                });
            }
        });
}

function carregaGraficoAvaliacao() {
    $.ajax({
            type: "GET",
            dataType: 'json',
            url: baseUrl + 'carregaGraficoAvaliacao',
            beforeSend: function () {
                $('#animationProgress2').css('width', '5%');
                $('#animationProgress2').attr('value', 5);
                window.setTimeout(function () {
                    $('#animationProgress2').css('width', '25%');
                    $('#animationProgress2').attr('value', 25);
                }, 6000);
                window.setTimeout(function () {
                    $('#animationProgress2').css('width', '55%');
                    $('#animationProgress2').attr('value', 55);
                }, 8000);
                window.setTimeout(function () {
                    $('#animationProgress2').css('width', '75%');
                    $('#animationProgress2').attr('value', 75);
                }, 10000);
            },
            success: function (data) {
                $('#animationProgress2').css('display', 'none');
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

                const ctx2 = document.getElementById('avaliacaoChart');

                graficoAvaliacao = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: labelAvalia,
                        datasets: [{
                                label: 'VEICULOS QUE PUBLICARAM MATÉRIAS',
                                data: dataAvalia,
                                borderWidth: 1,
                                backgroundColor: GRUPO == 15 ? cor : ["#43a047", "#d32f2f", "#f9a825"]
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        showAllTooltips: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, chart) {
                                    return  'TOTAL: ' + number_format(tooltipItem.yLabel);
                                }
                            }
                        }
                    }

                });
            }
        });
}

$(document).ready(function () {
    $("#version-ruangadmin").text('Versão: 1.0');
    $("#txtQuantMatPosi").text('CARREGANDO...');
    $("#txtQuantMatNeg").text('CARREGANDO...');
    $("#txtQuantMatNeut").text('CARREGANDO...');
    if (CLIENTE !== '') {
        // SE DESEJA OBTER DADOS DE RELEASE
        carregaMaterias();
        // CARREGA OS DADOS DO GRÁFICO
        carregaGraficoVeiculos();
        // CARREGA O GRÁFICO DE AVALIAÇÃO
        carregaGraficoAvaliacao();
    } else {
        $("#txtQuantMatPosi").text('0');
        $("#txtQuantMatNeg").text('0');
        $("#txtQuantMat").text('0');
        $(".card-chart").html('');
    }

    $('#inicio').datepicker({
        onRender: function (date) {
            return date.valueOf() < new Date().valueOf() ? 'disabled' : '';
        },
        language: 'pt-BR',
        endDate: '0',
        format: 'dd/mm/yyyy',
        todayBtn: 'linked',
        todayHighlight: true,
        autoclose: true
    });

    $('#fim').datepicker({
        language: 'pt-BR',
        format: 'dd/mm/yyyy',
        endDate: '0',
        autoclose: true,
        todayHighlight: true,
        todayBtn: 'linked'
    });
});


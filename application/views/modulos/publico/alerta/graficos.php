<style>
    .btn-small:hover {
        background-color: #1e88e5 !important;
    }
    .txt-p {
        display: none;
    }
</style>
<body>
    <?php $this->load->view('modulos/publico/alerta/includes/menu'); ?>
    <?php
    $chave = $this->uri->segment(2);
    $dadosCliente = $this->ComumModelo->getCliente($clipping->SEQ_CLIENTE)->row();
    $total = count($this->MateriaModelo->getConsulta($chave));
    ?>
    <main>
        <div class="container">
            <div class="section">
                <div class="row">
                    <?php
                    $titulo = 'Clipping ' . $dadosCliente->NOME_CLIENTE;
                    $data = new DateTime($clipping->DT_INICIO);
                    $data2 = new DateTime($clipping->DT_FIM);
                    $data_inicio = $data->format('d/m/Y');
                    $data_fim = $data2->format('d/m/Y');
                    if ($clipping->TIPO_NOTIFICACAO == 'D') {
                        $titulo .= ' ' . $data_inicio . ' - Diário';
                    } else {
                        $titulo .= ' ' . $data_inicio . ' - ' . $data_fim . ' - Período';
                    }
                    ?>
                    <div class="col s12 m8">
                        <h5><?= $titulo; ?></h5>
                    </div>
                </div>
                <div class="row" style="padding-bottom: 2%">
                    <div class="col m2 s5">
                        <button class="waves-effect waves-light btn-small btn-pdf" type="button" style="font-weight: bold; width: 100%;">GERAR PDF <i class="fas fa-file-pdf"></i></button>
                    </div>
                    <div class="col m6 s7">
                        <button class="waves-light btn-small btn-pub"type="button" style="font-weight: bold; cursor: default;"><?= $total ?> PUBLICAÇÕES</button>
                    </div>
                </div>
                <div class="col s12 m12">
                    <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                        <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><i class="fas fa-chart-line"></i> PANORAMA GERAL</b></p>
                        <p class="black-text right txt-p" style="font-size: 14pt; margin-top: 0%; margin-right: 3%"><b><?= $total ?> PUBLICAÇÕES</b></p>
                    </nav>
                </div>
                <div class="row">
                    <div class="col s12">
                        <canvas id="chart-avaliacao" width="400" height="400"></canvas>
                    </div>
                </div>
                <div class="row" style="margin-top: 2%;">
                    <div class="col s4">
                        <nav class="" style="height: 55px; border-radius: 15px; background-color: #2E7D32 !important; ">
                            <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['AVALIACOES']['POSITIVAS'] ?> POSITIVAS</b></p>
                        </nav>
                    </div>
                    <div class="col s4">
                        <nav class="red" style="height: 55px; border-radius: 15px;">
                            <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['AVALIACOES']['NEGATIVAS'] ?> NEGATIVAS</b></p>
                        </nav>
                    </div>
                    <div class="col s4">
                        <nav class="amber darken-4" style="height: 55px; border-radius: 15px;">
                            <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['AVALIACOES']['NEUTRAS'] ?> NEUTRAS</b></p>
                        </nav>
                    </div>
                </div>
                <div class="pagebreak"> </div>
                <!-- INTERNET -->
                <?php
                if (empty($clipping->TIPO_MATERIA)) {
                    ?>
                    <div class="row" style="margin-top: 2%;">
                        <div class="col s12 m12">
                            <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                                <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><i class="fas fa-laptop"></i> INTERNET</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col s6">
                            <nav class="grey darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] ?> MENÇÕES MONITORADAS</b></p>
                            </nav>
                            <table class="striped highlight">
                                <thead>
                                    <tr>
                                        <th style="text-transform: uppercase">Veículos com mais menções</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-transform: uppercase">Roraima em Foco</td>
                                        <td>45</td>
                                    </tr>
                                    <tr>
                                        <td style="text-transform: uppercase">Folha BV</td>
                                        <td>42</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>-->
                        <div class="col s12">
                            <canvas id="chart-avaliacao-internet" width="400" height="400"></canvas>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                        <div class="col s4">
                            <nav class="green darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['INTERNET']['POSITIVAS'] ?> POSITIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="red" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['INTERNET']['NEGATIVAS'] ?> NEGATIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="amber darken-4" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['INTERNET']['NEUTRAS'] ?> NEUTRAS</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="pagebreak"> </div>
                    <!-- RADIO -->

                    <div class="row" style="margin-top: 2%;">
                        <div class="col s12 m12">
                            <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                                <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><i class="fas fa-headphones"></i> RÁDIO</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col s6">
                            <nav class="grey darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] ?> MENÇÕES MONITORADAS</b></p>
                            </nav>
                            <table class="striped highlight">
                                <thead>
                                    <tr>
                                        <th style="text-transform: uppercase">Veículos com mais menções</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-transform: uppercase">Roraima em Foco</td>
                                        <td>45</td>
                                    </tr>
                                    <tr>
                                        <td style="text-transform: uppercase">Folha BV</td>
                                        <td>42</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>-->
                        <div class="col s12">
                            <canvas id="chart-avaliacao-radio" width="400" height="400"></canvas>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 2%;">
                        <div class="col s4">
                            <nav class="green darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['RADIO']['POSITIVAS'] ?> POSITIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="red" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['RADIO']['NEGATIVAS'] ?> NEGATIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="amber darken-4" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['RADIO']['NEUTRAS'] ?> NEUTRAS</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="pagebreak"> </div>
                    <!-- TV -->

                    <div class="row" style="margin-top: 2%;">
                        <div class="col s12 m12">
                            <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                                <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><i class="fas fa-tv"></i> TV</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col s6">
                            <nav class="grey darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['TV']['TOTAL'] ?> MENÇÕES MONITORADAS</b></p>
                            </nav>
                            <table class="striped highlight">
                                <thead>
                                    <tr>
                                        <th style="text-transform: uppercase">Veículos com mais menções</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-transform: uppercase">Roraima em Foco</td>
                                        <td>45</td>
                                    </tr>
                                    <tr>
                                        <td style="text-transform: uppercase">Folha BV</td>
                                        <td>42</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>-->
                        <div class="col s12">
                            <canvas id="chart-avaliacao-tv" width="400" height="400"></canvas>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 2%;">
                        <div class="col s4">
                            <nav class="green darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['TV']['POSITIVAS'] ?> POSITIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="red" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['TV']['NEGATIVAS'] ?> NEGATIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="amber darken-4" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['TV']['NEUTRAS'] ?> NEUTRAS</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="pagebreak"> </div>
                    <!-- IMPRESSO -->
                    
                    <div class="row" style="margin-top: 2%;">
                        <div class="col s12 m12">
                            <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                                <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><i class="fas fa-newspaper"></i> JORNAIS</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col s6">
                            <nav class="grey darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['IMPRESSO']['TOTAL'] ?> MENÇÕES MONITORADAS</b></p>
                            </nav>
                            <table class="striped highlight">
                                <thead>
                                    <tr>
                                        <th style="text-transform: uppercase">Veículos com mais menções</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-transform: uppercase">Roraima em Foco</td>
                                        <td>45</td>
                                    </tr>
                                    <tr>
                                        <td style="text-transform: uppercase">Folha BV</td>
                                        <td>42</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>-->
                        <div class="col s12">
                            <canvas id="chart-avaliacao-impresso" width="400" height="400"></canvas>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                        <div class="col s4">
                            <nav class="green darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['IMPRESSO']['POSITIVAS'] ?> POSITIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="red" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['IMPRESSO']['NEGATIVAS'] ?> NEGATIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="amber darken-4" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['IMPRESSO']['NEUTRAS'] ?> NEUTRAS</b></p>
                            </nav>
                        </div>
                    </div>
                <?php } else if ($clipping->TIPO_MATERIA == 'R') { ?>
                    <div class="row" style="margin-top: 2%;">
                        <div class="col s12 m12">
                            <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                                <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><i class="fas fa-headphones"></i> RÁDIO</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col s6">
                            <nav class="grey darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] ?> MENÇÕES MONITORADAS</b></p>
                            </nav>
                            <table class="striped highlight">
                                <thead>
                                    <tr>
                                        <th style="text-transform: uppercase">Veículos com mais menções</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-transform: uppercase">Roraima em Foco</td>
                                        <td>45</td>
                                    </tr>
                                    <tr>
                                        <td style="text-transform: uppercase">Folha BV</td>
                                        <td>42</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>-->
                        <div class="col s12">
                            <canvas id="chart-avaliacao-radio" width="400" height="400"></canvas>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 2%;">
                        <div class="col s4">
                            <nav class="green darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['RADIO']['POSITIVAS'] ?> POSITIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="red" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['RADIO']['NEGATIVAS'] ?> NEGATIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="amber darken-4" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['RADIO']['NEUTRAS'] ?> NEUTRAS</b></p>
                            </nav>
                        </div>
                    </div>
                <?php } else if ($clipping->TIPO_MATERIA == 'S') { ?>   

                    <div class="row" style="margin-top: 2%;">
                        <div class="col s12 m12">
                            <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                                <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><i class="fas fa-laptop"></i> INTERNET</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col s6">
                            <nav class="grey darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] ?> MENÇÕES MONITORADAS</b></p>
                            </nav>
                            <table class="striped highlight">
                                <thead>
                                    <tr>
                                        <th style="text-transform: uppercase">Veículos com mais menções</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-transform: uppercase">Roraima em Foco</td>
                                        <td>45</td>
                                    </tr>
                                    <tr>
                                        <td style="text-transform: uppercase">Folha BV</td>
                                        <td>42</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>-->
                        <div class="col s12">
                            <canvas id="chart-avaliacao-internet" width="400" height="400"></canvas>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                        <div class="col s4">
                            <nav class="green darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['INTERNET']['POSITIVAS'] ?> POSITIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="red" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['INTERNET']['NEGATIVAS'] ?> NEGATIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="amber darken-4" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['INTERNET']['NEUTRAS'] ?> NEUTRAS</b></p>
                            </nav>
                        </div>
                    </div>    
                <?php } else if ($clipping->TIPO_MATERIA == 'T') { ?>
                <div class="row" style="margin-top: 2%;">
                        <div class="col s12 m12">
                            <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                                <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><i class="fas fa-tv"></i> TV</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col s6">
                            <nav class="grey darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['TV']['TOTAL'] ?> MENÇÕES MONITORADAS</b></p>
                            </nav>
                            <table class="striped highlight">
                                <thead>
                                    <tr>
                                        <th style="text-transform: uppercase">Veículos com mais menções</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-transform: uppercase">Roraima em Foco</td>
                                        <td>45</td>
                                    </tr>
                                    <tr>
                                        <td style="text-transform: uppercase">Folha BV</td>
                                        <td>42</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>-->
                        <div class="col s12">
                            <canvas id="chart-avaliacao-tv" width="400" height="400"></canvas>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 2%;">
                        <div class="col s4">
                            <nav class="green darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['TV']['POSITIVAS'] ?> POSITIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="red" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['TV']['NEGATIVAS'] ?> NEGATIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="amber darken-4" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['TV']['NEUTRAS'] ?> NEUTRAS</b></p>
                            </nav>
                        </div>
                    </div>    
                <?php } else if ($clipping->TIPO_MATERIA == 'I') {?> 
                 <div class="row" style="margin-top: 2%;">
                        <div class="col s12 m12">
                            <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                                <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><i class="fas fa-newspaper"></i> JORNAIS</b></p>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
<!--                        <div class="col s6">
                            <nav class="grey darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['IMPRESSO']['TOTAL'] ?> MENÇÕES MONITORADAS</b></p>
                            </nav>
                            <table class="striped highlight">
                                <thead>
                                    <tr>
                                        <th style="text-transform: uppercase">Veículos com mais menções</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-transform: uppercase">Roraima em Foco</td>
                                        <td>45</td>
                                    </tr>
                                    <tr>
                                        <td style="text-transform: uppercase">Folha BV</td>
                                        <td>42</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>-->
                        <div class="col s12">
                            <canvas id="chart-avaliacao-impresso" width="400" height="400"></canvas>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                        <div class="col s4">
                            <nav class="green darken-3" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['IMPRESSO']['POSITIVAS'] ?> POSITIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="red" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['IMPRESSO']['NEGATIVAS'] ?> NEGATIVAS</b></p>
                            </nav>
                        </div>
                        <div class="col s4">
                            <nav class="amber darken-4" style="height: 55px; border-radius: 15px;">
                                <p class="white-text center" style="font-size: 20pt; margin-left: 3%; margin-top: 0%; text-transform: uppercase"><b><?= $chart_avaliacao['MIDIAS']['IMPRESSO']['NEUTRAS'] ?> NEUTRAS</b></p>
                            </nav>
                        </div>
                    </div>   
                <?php } ?>    
            </div>
            <a class="waves-effect waves-light btn-small" id="back-to-top" style="width: 50px; font-weight: bold; border-radius:20px;"><i class="material-icons">arrow_upward</i></a>
            <div class="modal" id="loading">
                <div class="modal-content" style="padding: 0px">
                    <div id="modal-body-content">
                        <h3 style="text-align:center; margin-top: 1%;">Procurando publicações <i class="fas fa-spinner fa-spin"></i></h3>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url() ?>/assets/js/grafico.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
        $('body').delegate('.btn-pdf', 'click', function () {
           $('#navbar0').css('display', 'none');
           $('.btn-pdf').css('display', 'none');
           $('.btn-pub').css('display', 'none');
           $('#back-to-top').css('display', 'none');
           $('footer').css('display', 'none');
           $('.txt-p').css('display', 'block');
           
           window.print();
           setTimeout(function () {
            $('.txt-p').css('display', 'none');
            $('#navbar0').css('display', 'block');
            $('.btn-pdf').css('display', 'block');
            $('.btn-pub').css('display', 'block');
            $('#back-to-top').css('display', 'block');
            $('footer').css('display', 'block');
           }, 10);
        });
        function numberToReal(numero) {
            var numero = parseFloat(numero).toFixed(2).split('.');
            numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
            return numero.join(',');
        }
        $(document).ready(function () {
            
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
<?php
if (empty($clipping->TIPO_MATERIA)) {
    ?>
    <?php if ($chart_avaliacao['MIDIAS']['TV']['TOTAL'] != 0) { ?>            
    new Chart(document.getElementById('chart-avaliacao-tv'), {
                    type: 'pie',
                    data: {
                        labels: ['POSITIVA', 'NEGATIVA', 'NEUTRA'],
                        datasets: [{
                                data: ['<?= $chart_avaliacao['MIDIAS']['TV']['POSITIVAS'] * 100 / $chart_avaliacao['MIDIAS']['TV']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['TV']['NEGATIVAS'] * 100 / $chart_avaliacao['MIDIAS']['TV']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['TV']['NEUTRAS'] * 100 / $chart_avaliacao['MIDIAS']['TV']['TOTAL'] ?>'],
                                backgroundColor: [
                                    'rgb(46, 125, 50)',
                                    'rgb(244, 67, 54)',
                                    'rgb(255, 111, 0)'

                                ],

                                borderWidth: 1,
                                hoverOffset: 10
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        showAllTooltips: false,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {

                                    let label = data.labels[tooltipItem.index];
                                    let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return ' ' + label + ': ' + parseFloat(value).toFixed(2) + '%';

                                }
                            }
                        }
                    }
                });
    <?php } ?>
                <?php if ($chart_avaliacao['MIDIAS']['IMPRESSO']['TOTAL'] != 0) { ?>
                new Chart(document.getElementById('chart-avaliacao-impresso'), {
                    type: 'pie',
                    data: {
                        labels: ['POSITIVA', 'NEGATIVA', 'NEUTRA'],
                        datasets: [{
                                data: ['<?= $chart_avaliacao['MIDIAS']['IMPRESSO']['POSITIVAS'] * 100 / $chart_avaliacao['MIDIAS']['IMPRESSO']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['IMPRESSO']['NEGATIVAS'] * 100 / $chart_avaliacao['MIDIAS']['IMPRESSO']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['IMPRESSO']['NEUTRAS'] * 100 / $chart_avaliacao['MIDIAS']['IMPRESSO']['TOTAL'] ?>'],
                                backgroundColor: [
                                    'rgb(46, 125, 50)',
                                    'rgb(244, 67, 54)',
                                    'rgb(255, 111, 0)'

                                ],

                                borderWidth: 1,
                                hoverOffset: 10
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        showAllTooltips: false,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {

                                    let label = data.labels[tooltipItem.index];
                                    let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return ' ' + label + ': ' + parseFloat(value).toFixed(2) + '%';

                                }
                            }
                        }
                    }
                });
        <?php } ?>
                <?php if ($chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] != 0) { ?>
                new Chart(document.getElementById('chart-avaliacao-radio'), {
                    type: 'pie',
                    data: {
                        labels: ['POSITIVA', 'NEGATIVA', 'NEUTRA'],
                        datasets: [{
                                data: ['<?= $chart_avaliacao['MIDIAS']['RADIO']['POSITIVAS'] * 100 / $chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['RADIO']['NEGATIVAS'] * 100 / $chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['RADIO']['NEUTRAS'] * 100 / $chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] ?>'],
                                backgroundColor: [
                                    'rgb(46, 125, 50)',
                                    'rgb(244, 67, 54)',
                                    'rgb(255, 111, 0)'

                                ],

                                borderWidth: 1,
                                hoverOffset: 10
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        showAllTooltips: false,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {

                                    let label = data.labels[tooltipItem.index];
                                    let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return ' ' + label + ': ' + parseFloat(value).toFixed(2) + '%';

                                }
                            }
                        }
                    }
                });
                <?php } ?>
                <?php if ($chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] != 0) { ?>
                new Chart(document.getElementById('chart-avaliacao-internet'), {
                    type: 'pie',
                    data: {
                        labels: ['POSITIVA', 'NEGATIVA', 'NEUTRA'],
                        datasets: [{
                                data: ['<?= $chart_avaliacao['MIDIAS']['INTERNET']['POSITIVAS'] * 100 / $chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['INTERNET']['NEGATIVAS'] * 100 / $chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['INTERNET']['NEUTRAS'] * 100 / $chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] ?>'],
                                backgroundColor: [
                                    'rgb(46, 125, 50)',
                                    'rgb(244, 67, 54)',
                                    'rgb(255, 111, 0)'

                                ],

                                borderWidth: 1,
                                hoverOffset: 10
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        showAllTooltips: false,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {

                                    let label = data.labels[tooltipItem.index];
                                    let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return ' ' + label + ': ' + parseFloat(value).toFixed(2) + '%';

                                }
                            }
                        }
                    }
                });
                <?php } ?>
<?php } else if ($clipping->TIPO_MATERIA == 'R') { ?>
                new Chart(document.getElementById('chart-avaliacao-radio'), {
                    type: 'pie',
                    data: {
                        labels: ['POSITIVA', 'NEGATIVA', 'NEUTRA'],
                        datasets: [{
                                data: ['<?= $chart_avaliacao['MIDIAS']['RADIO']['POSITIVAS'] * 100 / $chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['RADIO']['NEGATIVAS'] * 100 / $chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['RADIO']['NEUTRAS'] * 100 / $chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] ?>'],
                                backgroundColor: [
                                    'rgb(46, 125, 50)',
                                    'rgb(244, 67, 54)',
                                    'rgb(255, 111, 0)'

                                ],

                                borderWidth: 1,
                                hoverOffset: 10
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        showAllTooltips: false,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {

                                    let label = data.labels[tooltipItem.index];
                                    let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return ' ' + label + ': ' + parseFloat(value).toFixed(2) + '%';

                                }
                            }
                        }
                    }
                });
<?php } else if ($clipping->TIPO_MATERIA == 'S') { ?>
                new Chart(document.getElementById('chart-avaliacao-internet'), {
                    type: 'pie',
                    data: {
                        labels: ['POSITIVA', 'NEGATIVA', 'NEUTRA'],
                        datasets: [{
                                data: ['<?= $chart_avaliacao['MIDIAS']['INTERNET']['POSITIVAS'] * 100 / $chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['INTERNET']['NEGATIVAS'] * 100 / $chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['INTERNET']['NEUTRAS'] * 100 / $chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] ?>'],
                                backgroundColor: [
                                    'rgb(46, 125, 50)',
                                    'rgb(244, 67, 54)',
                                    'rgb(255, 111, 0)'

                                ],

                                borderWidth: 1,
                                hoverOffset: 10
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        showAllTooltips: false,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {

                                    let label = data.labels[tooltipItem.index];
                                    let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return ' ' + label + ': ' + parseFloat(value).toFixed(2) + '%';

                                }
                            }
                        }
                    }
                });
<?php } else if ($clipping->TIPO_MATERIA == 'T') { ?>
new Chart(document.getElementById('chart-avaliacao-tv'), {
                    type: 'pie',
                    data: {
                        labels: ['POSITIVA', 'NEGATIVA', 'NEUTRA'],
                        datasets: [{
                                data: ['<?= $chart_avaliacao['MIDIAS']['TV']['POSITIVAS'] * 100 / $chart_avaliacao['MIDIAS']['TV']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['TV']['NEGATIVAS'] * 100 / $chart_avaliacao['MIDIAS']['TV']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['TV']['NEUTRAS'] * 100 / $chart_avaliacao['MIDIAS']['TV']['TOTAL'] ?>'],
                                backgroundColor: [
                                    'rgb(46, 125, 50)',
                                    'rgb(244, 67, 54)',
                                    'rgb(255, 111, 0)'

                                ],

                                borderWidth: 1,
                                hoverOffset: 10
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        showAllTooltips: false,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {

                                    let label = data.labels[tooltipItem.index];
                                    let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return ' ' + label + ': ' + parseFloat(value).toFixed(2) + '%';

                                }
                            }
                        }
                    }
                });
<?php } else if ($clipping->TIPO_MATERIA == 'I') { ?>
new Chart(document.getElementById('chart-avaliacao-impresso'), {
                    type: 'pie',
                    data: {
                        labels: ['POSITIVA', 'NEGATIVA', 'NEUTRA'],
                        datasets: [{
                                data: ['<?= $chart_avaliacao['MIDIAS']['IMPRESSO']['POSITIVAS'] * 100 / $chart_avaliacao['MIDIAS']['IMPRESSO']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['IMPRESSO']['NEGATIVAS'] * 100 / $chart_avaliacao['MIDIAS']['IMPRESSO']['TOTAL'] ?>', '<?= $chart_avaliacao['MIDIAS']['IMPRESSO']['NEUTRAS'] * 100 / $chart_avaliacao['MIDIAS']['IMPRESSO']['TOTAL'] ?>'],
                                backgroundColor: [
                                    'rgb(46, 125, 50)',
                                    'rgb(244, 67, 54)',
                                    'rgb(255, 111, 0)'

                                ],

                                borderWidth: 1,
                                hoverOffset: 10
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        showAllTooltips: false,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {

                                    let label = data.labels[tooltipItem.index];
                                    let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    return ' ' + label + ': ' + parseFloat(value).toFixed(2) + '%';

                                }
                            }
                        }
                    }
                });
<?php } ?>
            new Chart(document.getElementById('chart-avaliacao'), {
                type: 'pie',
                data: {
                    labels: ['INTERNET', 'RÁDIO', 'TV'],
                    datasets: [{
                            data: ['<?= $chart_avaliacao['MIDIAS']['INTERNET']['TOTAL'] * 100 / $total ?>', '<?= $chart_avaliacao['MIDIAS']['RADIO']['TOTAL'] * 100 / $total ?>', '<?= $chart_avaliacao['MIDIAS']['TV']['TOTAL'] * 100 / $total ?>'],
                            backgroundColor: [
                                'rgb(40, 53, 147)',
                                'rgb(30, 136, 229)',
                                'rgb(230, 81, 0)'

                            ],

                            borderWidth: 1,
                            hoverOffset: 10
                        }]
                },
                options: {
                    maintainAspectRatio: false,
                    showAllTooltips: false,
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {

                                let label = data.labels[tooltipItem.index];
                                let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                return ' ' + label + ': ' + parseFloat(value).toFixed(2) + '%';

                            }
                        }
                    }
                }
            });
        });
    </script>
    <footer class="page-footer">
        <div class="container">
            © <?= date('Y') ?> Copyright - Porto Monitor
        </div>
    </footer>
</body>
</html>
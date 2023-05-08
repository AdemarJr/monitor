<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Google Fonts -->

        <!-- Bootstrap Core Css -->
        <!-- Custom Css -->
        <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    </head>
    <style>
        body {
            font-family: Arial,"Helvetica Neue", Helvetica,  sans-serif;
        }

    </style>
    <body>   
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <?php
                    if (!empty($this->session->userdata('idClienteSessao'))) {
                        $dadosCliente = $this->ComumModelo->getCliente($this->session->userdata('idClienteSessao'))->row();
                    }
                    $descTipo = array(
                        'S' => 'INTERNET',
                        'I' => 'IMPRESSO',
                        'R' => 'RADIO',
                        'T' => 'TV'
                    );
                    if (empty($avaliacoes)) {
                        $avaliacoes = 'P,N,T';
                    }
                    $listaVeiculo = explode(',', $avaliacoes);

                    if (empty($tipoMat)) {
                        $tipoMat = ['S', 'I', 'R', 'T'];
                    }

                    //echo '<pre>';
                    $veiculoTipo = '';
                    foreach ($tipoMat as $vec) {
                        if (array_key_exists($vec, $descTipo)) {
                            $veiculoTipo .= ucfirst(strtolower($descTipo[$vec])) . ', ';
                        }
                    }
                    $veiculoTipo = substr($veiculoTipo, 0, -2);
                    ?>
                    <div class="body ">
                        <div class="row clearfix ">

                            <div class="media-custom">
                                <?php if (empty($setor)) { ?>
                                    <div class="media-body-custom">
                                        <h3 class="media-heading">Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?></h3>
                                        <h4 class="media-heading"><?php if (!empty($subtitulo)) echo $subtitulo; ?></h4>
                                    </div>
                                <?php } else if (!empty($setor) and $setor == 83) { ?>
                                    <div class="media-body-custom">
                                        <h3 class="media-heading">Clipping Jornal&iacute;stico <?php echo $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $setor))->row()->DESC_SETOR; ?></h3>
                                    </div>
                                <?php } else if (!empty($setor) and $setor <> 83) { ?>
                                    <div class="media-body-custom">
                                        <h3 class="media-heading">Clipping <?php
                                            $dadosSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $setor))->row();
                                            echo $dadosSetor->DESC_SETOR . ' - ' . $dadosSetor->SIG_SETOR;
                                            ?></h3>
                                        <h4 class="media-heading"><?php if (!empty($subtitulo)) echo $subtitulo; ?></h4>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                                <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                                    <h6><strong>Per&iacute;odo</strong>:<span>  <?php echo $datai . ' - ' . $dataf; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
<!--                                        <strong id="totalPub">Total de Publica&ccedil;&otilde;es</strong> &nbsp;&nbsp;&nbsp;&nbsp;-->
                                        <?php if (!empty($tipoMat)) { ?>
                                            <strong>Tipo da Mat&eacute;ria</strong>: <span><?php echo $veiculoTipo ?></span>
                                        <?php } ?>
                                        <?php if (!empty($veiculo)) { ?>
                                            <strong>Ve&iacute;culo</strong>: <span><?php echo $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $veiculo))->row()->FANTASIA_VEICULO; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php } ?>

                                        <?php if (!empty($portal)) { ?>
                                            <strong>Site</strong>: <span><?php echo $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $portal))->row()->NOME_PORTAL; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php } ?>
                                        <?php if (!empty($radio)) { ?>
                                            <strong>R&aacute;dio</strong>: <span><?php echo $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $radio))->row()->NOME_RADIO; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;

                                        <?php } ?>
                                        <?php if (!empty($tv)) { ?>

                                            <strong>Televis&atilde;o</strong>: <span><?php echo $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $tv))->row()->NOME_TV; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php } ?>
                                        <?php if (!empty($tipo)) { ?>
                                            <strong>&Aacute;rea de assunto</strong>: <span><?php echo $this->ComumModelo->getTableData('TIPO_MATERIA', array('SEQ_TIPO_MATERIA' => $tipo))->row()->DESC_TIPO_MATERIA; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php } ?>
                                        <?php if (!empty($setor)) { ?>
                                            <strong>Setor</strong>: <span><?php
                                                $dadosSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $setor))->row();
                                                echo $dadosSetor->DESC_SETOR . ' - ' . $dadosSetor->SIG_SETOR;
                                                ?>
                                            </span>&nbsp;&nbsp;&nbsp;&nbsp;

                                        <?php } ?>

                                        <?php if (!empty($texto)) { ?>
                                            <strong>TAGS</strong>: <span><?php echo $texto; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php } ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($lista_dias)) { ?>
                            <?php
                            $vecAnt = $lista_dias[0][0]['TIPO_MATERIA'];
                            $ctrl = 0;
                            $totalPub = 0;
                            ?>
                            <?php foreach ($lista_dias as $materia) { ?>
                                <?php foreach ($materia as $item) { ?>
                                    <?php
                                    $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
                                    $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
                                    ?>
                                    <?php
                                    $analiseConteudo = '';
                                    if (!empty($item['IND_AVALIACAO']) and $item['IND_AVALIACAO'] == 'N' and!empty($item['ANALISE_MATERIA'])) {
                                        $resumo = array("Resumo", "resumo", "RESUMO");
                                        $resposta = array("Resposta", "resposta", "RESPOSTA");

                                        $analiseConteudo = str_replace($resumo, "*Resumo*", $item['ANALISE_MATERIA']);
                                        $analiseConteudo = str_replace($resposta, "*Resposta*", $analiseConteudo);
                                    }

                                    if ($item['TIPO_MATERIA'] == 'S') {
                                        ?>
                                        <h3><?= ucfirst(strtolower($descTipo[$item['TIPO_MATERIA']])); ?></h3>
                                        <?php
                                        if (in_array('P', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('P', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS POSITIVAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        if (in_array('N', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('N', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS NEGATIVAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        if (in_array('T', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('T', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS NEUTRAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        echo '<div style="break-after:page"></div>';
                                        ?>
                                    <?php } ?>
                                    <?php if ($item['TIPO_MATERIA'] == 'I') { ?>
                                        <hr>
                                        <h3><?= ucfirst(strtolower($descTipo[$item['TIPO_MATERIA']])); ?></h3>
                                        <?php
                                        if (in_array('P', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('P', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS POSITIVAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        if (in_array('N', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('N', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS NEGATIVAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        if (in_array('T', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('T', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS NEUTRAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        echo '<div style="break-after:page"></div>';
                                        ?>

                                    <?php } ?> 
                                    <?php if ($item['TIPO_MATERIA'] == 'T') { ?>
                                        <hr>
                                        <h3><?= $descTipo[$item['TIPO_MATERIA']]; ?></h3>
                                        <?php
                                        if (in_array('P', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('P', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS POSITIVAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        if (in_array('N', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('N', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS NEGATIVAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        if (in_array('T', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('T', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS NEUTRAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        echo '<div style="break-after:page"></div>';
                                    }
                                    ?>
                                    <?php if ($item['TIPO_MATERIA'] == 'R') { ?>
                                        <hr>
                                        <h3><?= ucfirst(strtolower($descTipo[$item['TIPO_MATERIA']])); ?></h3>
                                        <?php
                                        if (in_array('P', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('P', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS POSITIVAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        if (in_array('N', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('N', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS NEGATIVAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        if (in_array('T', $listaVeiculo)) {
                                            $query = $ctr->alertaMateria('T', $item['TIPO_MATERIA'], $periodoIni, $periodoFim);
                                            $totalPub = $totalPub + count($query);
                                            echo '<h5>MATÉRIAS NEUTRAS -  ' . count($query) . '  PUBLICAÇÕES</h5>';
                                            foreach ($query as $value) {
                                                echo $ctr->htmlAlerta($value);
                                            }
                                        }
                                        echo '<div style="break-after:page"></div>';
                                        ?>
                                    <?php } ?>
                                <?php } ?>    
                            <?php } ?>
                        <?php } ?>         
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>

<?php $this->load->view('modulos/publico/alerta/includes/topo'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    p {
        font-size: 20px;
    }
</style>
<?php
if (!empty($chave)) {
    $dataNota = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $chave))->row();
}

if (!empty($this->session->userdata('idClienteSessaoAlerta'))) {
    $dadosCliente = $this->ComumModelo->getCliente($this->session->userdata('idClienteSessaoAlerta'))->row();
} else if (!empty($chave)) {
    $dadosCliente = $this->ComumModelo->getCliente($dataNota->SEQ_CLIENTE)->row();
}
if (!empty($chave))
    $flagModelo = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $chave))->row()->IND_MODELO;
?>
<?php
$descTipo = array(
    'S' => 'fas fa-laptop',
    'I' => 'fas fa-newspaper',
    'R' => 'fas fa-headphones',
    'T' => 'fas fa-tv'
);
?>
<body style="color:black;">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <main>    
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col s12 m12" >

                                <?php
                                $i = 0;
                                foreach ($lista_dias as $item) {
                                    $dadoVeiculo = NULL;
                                    $i++;
                                    if ($item['TIPO_MATERIA'] == 'I' and ! empty($item['SEQ_VEICULO']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row();
                                    else if ($item['TIPO_MATERIA'] == 'S' and ! empty($item['SEQ_PORTAL']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row();
                                    else if ($item['TIPO_MATERIA'] == 'R' and ! empty($item['SEQ_RADIO']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row();
                                    else if ($item['TIPO_MATERIA'] == 'T' and ! empty($item['SEQ_TV']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $item['SEQ_TV']))->row();
                                    if ($item['TIPO_MATERIA'] == 'I' and ! empty($item['SEQ_VEICULO'])) {
                                        $mensagem = $dadoVeiculo->FANTASIA_VEICULO . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'] . PHP_EOL . $item['DIA'];
                                    } else if ($item['TIPO_MATERIA'] == 'S' and ! empty($item['SEQ_PORTAL'])) {
                                        $mensagem = $dadoVeiculo->NOME_PORTAL . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'] . PHP_EOL . $item['DIA'];
                                    } else if ($item['TIPO_MATERIA'] == 'R' and ! empty($item['SEQ_RADIO'])) {
                                        $mensagem = $dadoVeiculo->NOME_RADIO . PHP_EOL . $item['PROGRAMA_MATERIA'] . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'] . PHP_EOL . $item['DIA'] . (!empty($item['HORA_MATERIA']) ? $item['HORA_MATERIA'] : '');
                                    } else if ($item['TIPO_MATERIA'] == 'T' and ! empty($item['SEQ_TV'])) {
                                        $mensagem = $dadoVeiculo->NOME_TV . PHP_EOL . $item['PROGRAMA_MATERIA'] . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'] . PHP_EOL . $item['DIA'] . $item['HORA_MATERIA'];
                                    }
                                    ?>
                                <div class="row pub-<?= $item['SEQ_MATERIA'] ?>">
                                        <?php
                                        if ($i > 1) {
                                            echo '';
                                        }
                                        ?>
                                        <div class="col s12 m12">
                                            <div class="row" style="margin-bottom: 0px; line-height: .9">
                                                    <?php
                                                    $dia = strftime('%d', strtotime(implode('-', array_reverse(explode('/', $item['DIA'])))));
                                                    $mes = ucfirst(strftime('%B', strtotime(implode('-', array_reverse(explode('/', $item['DIA']))))));
                                                    $ano = strftime('%Y', strtotime(implode('-', array_reverse(explode('/', $item['DIA'])))));
                                                    ?>
                                                    <?php
                                                        $veiculo_pub = '';
                                                        if ($item['TIPO_MATERIA'] == 'I' and ! empty($item['SEQ_VEICULO']))
                                                            $veiculo_pub = $dadoVeiculo->FANTASIA_VEICULO;
                                                        else if ($item['TIPO_MATERIA'] == 'S' and ! empty($item['SEQ_PORTAL']))
                                                            $veiculo_pub = $dadoVeiculo->NOME_PORTAL;
                                                        else if ($item['TIPO_MATERIA'] == 'R' and ! empty($item['SEQ_RADIO']))
                                                            $veiculo_pub = $dadoVeiculo->NOME_RADIO;
                                                        else if ($item['TIPO_MATERIA'] == 'T' and ! empty($item['SEQ_TV']))
                                                            $veiculo_pub = $dadoVeiculo->NOME_TV . ' - ' . $item['PROGRAMA_MATERIA'];
                                                    ?>
                                            </div>
                                            
                                            <div style="margin-top: 0%; line-height: normal">                   
                                                   <?php 
                                                   if($item['TIPO_MATERIA']=='I') { 
                                                   $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                                                   if (count($anexos) > 0) {
                                                   ?>

                                                    <?php
                                                       foreach ($anexos as $itemA) {
                                                    ?>     
                                                    <a href="<?php echo base_url('publico/imagem2/R/'.$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ); ?>" target="_blank"><b><?= $item['TIT_MATERIA'] ?></b></a><br>
                                                    <?php } } } else if ($item['TIPO_MATERIA'] == 'R' or $item['TIPO_MATERIA'] == 'T') { ?> 
                                                    <?php 
                                                        $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                                                        if (count($anexos) > 0) {
                                                            $controle = 0;
                                                                foreach ($anexos as $itemA) {
                                                                    $controle++;
                                                                    if ($controle == 1) {

                                                                    }
                                                                }
                                                        }
                                                        ?>
                                                    <a target="_blank" href="<?= base_url('publico/audio/') . $itemA['SEQ_ANEXO'] ?>">
                                                        <b><?= $item['TIT_MATERIA'] ?></b><br>
                                                    </a>
                                                    <?php } else {  ?>
                                                    <?php if($item['TIPO_MATERIA']=='S') {  ?>
                                                    <?php $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']); ?>
                                                    <p style="margin-top:-1.5%"><b><?= $item['DIA'] .' - '.$veiculo_pub?></b></p>
                                                    <p style="margin-top:-1.5%"><?= $item['DESC_SETOR'] .' - '. $item['SIG_SETOR'] ?></p>
                                                    <p style="margin-top:-1.5%"><b><?= $item['TIT_MATERIA'] ?></b></p>
                                                    <a style="margin-top:-1.5%" href="<?= $item['LINK_MATERIA'] ?>" target="_blank"><?= $item['LINK_MATERIA'] ?></a>
                                                    <p>
                                                    <i class="material-icons col-grey" style="font-size: 18px !important;" title="Coment&aacute;rios">comment</i><span style="font-size: 18px !important;"> <?php echo $item['QTD_COMENTARIO'] ?></span>&nbsp;&nbsp;
                                                    <i class="material-icons col-grey" style="font-size: 18px !important;" title="Curtidas">favorite</i><span style="font-size: 18px !important;"> <?php echo $item['QTD_CURTIDA'] ?></span>&nbsp;&nbsp;
                                                    <i class="material-icons col-grey" style="font-size: 18px !important;" title="Compartilhamentos">share</i><span style="font-size: 18px !important;"> <?php echo $item['QTD_COMPARTILHAMENTO'] ?></span>
                                                    <p>
                                                    <?php 
                                                    if (count($anexos) > 0) {
                                                        foreach ($anexos as $itemA):
                                                            ?>
                                                    <div class="up_images-<?php echo $item['SEQ_MATERIA']; ?>" style="margin-top: 2%">
                                                                    <a href="<?php echo base_url('publico/imagem2/N/').$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ?>">
                                                                        <img class="img-responsive" style="width: 40%"  src="<?php echo base_url('publico/imagem2/R/'.$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ); ?>"/>                                                            </a>
                                                                </div>
                                                            <?php
                                                        endforeach;
                                                        
                                                    }
                                                    ?>
                                                    <?php } else { ?>
                                                    <a href="" target="_blank"><b><?= $item['TIT_MATERIA'] ?></b></a><br>
                                                    <?php } } ?>
                                            </div>
                                        </div>
                                    </div>
                                <div style="break-after:page"></div>
                                <?php } ?>
                            </div>
                        </div>
                        <script>
                                window.addEventListener('afterprint', e => window.location = 'https://porto.am/monitor/relatorio');
                                $(document).ready(function () {
                                     window.print();
                                });
                        </script>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
       
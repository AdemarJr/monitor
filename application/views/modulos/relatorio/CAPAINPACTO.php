<?php
$mesPost = explode('/',$_POST['datai']);
if ($mesPost[1] == '01') {
    $mes = 'Janeiro';
} else if ($mesPost[1] == '02') {
    $mes = 'Fevereiro';
} else if ($mesPost[1] == '03') {
    $mes = 'Março';
} else if ($mesPost[1] == '04') {
    $mes = 'Abril';
} else if ($mesPost[1] == '05') {
    $mes = 'Maio';
} else if ($mesPost[1] == '06') {
    $mes = 'Junho';
} else if ($mesPost[1] == '07') {
    $mes = 'Julho';
} else if ($mesPost[1] == '08') {
    $mes = 'Agosto';
} else if ($mesPost[1] == '09') {
    $mes = 'Setembro';
} else if ($mesPost[1] == '10') {
    $mes = 'Outubro';
} else if ($mesPost[1] == '11') {
    $mes = 'Novembro';
} else if ($mesPost[1] == '12') {
    $mes = 'Dezembro';
}
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Manaus');
//$mes = ucfirst(strftime('%B', strtotime('today')));
$ano = 'de '.$mesPost[2];
?>

<style>
    * {
        padding:0px;
        margin:0px;
    }
    .minhaClass{
        background: url(../imagens/corpo/imagen.jpg) no-repeat center center;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    .texto {
        position: absolute;
        margin-top:  -620px !important;
        margin-left: 350px !important;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }
    .logo-img {
        position: absolute;
        margin-top: -420px !important;
        margin-left: 170px;
    }
</style>
<div style="position: absolute; left:0; right: 0; top: 0; bottom: 0;">
    <img class="minhaClass" src="<?= base_url('assets/images/CAPA-IMPACTO.jpg'); ?>">
    <div class="texto">
        <p style="font-size: 50pt; color: white">Prefeitura<br>de Manaus</p>
        <br>
        <?php if (isset($_POST['tipoMat'][0])) { ?>
            <?php if ($_POST['tipoMat'][0] == 'I') { ?>
                <p style="font-size: 25pt; color: white">Clipping Jornais<br>Impressos</p>
            <?php } else if ($_POST['tipoMat'][0] == 'T') { ?>
                <p style="font-size: 25pt; color: white">Clipping Televisão</p><br><br>
            <?php } ?>
        <?php } ?>

        <br>
        <p style="font-size: 25pt; color: white"><?= $mes . ' ' . $ano ?></p>
    </div>
<!--    <div class="logo-img">
        <img  src="<?= base_url('assets/images/logo-manaus.png'); ?>" style="width: 150px;">
    </div>-->
</div>
<?php if (isset($_POST['tipoMat'][0])) { ?>
    <pagebreak />
    <?php if ($_POST['tipoMat'][0] == 'I') { ?>
        <div style="position: absolute; left:0; right: 0; top: 0; bottom: 0;">
            <img class="minhaClass" src="<?= base_url('assets/images/CONTRACAPA.jpg'); ?>">
        </div>
    <?php } else if ($_POST['tipoMat'][0] == 'T') { ?>
        <div style="position: absolute; left:0; right: 0; top: 0; bottom: 0;">
            <img class="minhaClass" src="<?= base_url('assets/images/CONTRACAPA-TV.jpg'); ?>">
        </div>
    <?php } ?>
<?php } ?>


<?php 
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Manaus');
$mes = ucfirst(strftime('%B', strtotime('today')));
$ano = strftime('de %Y', strtotime('today'));
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
    <img class="minhaClass" src="<?= base_url('assets/images/CAPA'); ?>">
</div>

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
<?php 
function cmp($a, $b) {
    return $a['IND_AVALIACAO'] > $b['IND_AVALIACAO'];
}
?>     
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <?php
            if (!empty($this->session->userdata('idClienteSessao'))){
                $dadosCliente = $this->ComumModelo->getCliente($this->session->userdata('idClienteSessao'))->row();
            }
            $descTipo =array(
                'S'=>'INTERNET',
                'I'=>'IMPRESSO',
                'R'=>' RADIO',
                'T'=>' TV'
            );
            ?>
            <div class="body ">
                <div class="row clearfix ">

                    <div class="media-custom">
                        <?php if(empty($setor) ) { ?>
                            <div class="media-body-custom">
                                <h3 class="media-heading">Clipping <?php echo $dadosCliente->EMPRESA_CLIENTE; ?></h3>
                                <h4 class="media-heading"><?php if (!empty($subtitulo)) echo $subtitulo; ?></h4>
                            </div>
                        <?php } else if(!empty($setor)  and $setor==83) { ?>
                            <div class="media-body-custom">
                                <h3 class="media-heading">Clipping Jornal&iacute;stico <?php echo $this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$setor))->row()->DESC_SETOR; ?></h3>
                            </div>
                        <?php } else if(!empty($setor)  and $setor<>83) { ?>
                            <div class="media-body-custom">
                                <h3 class="media-heading">Clipping <?php $dadosSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $setor))->row();
                                    echo $dadosSetor->DESC_SETOR. ' - '.$dadosSetor->SIG_SETOR; ?></h3>
                                <h4 class="media-heading"><?php if (!empty($subtitulo)) echo $subtitulo; ?></h4>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                        <div class="col-xs-4 col-md-4 col-xl-4 nopadding">
                            <h6><strong>Per&iacute;odo</strong>:<span>  <?php echo $datai.' - '.$dataf; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Total de Publica&ccedil;&otilde;es</strong>: <span><?php echo $total;?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php if(!empty($tipoMat)) { ?>
                                <strong>Tipo da Mat&eacute;ria</strong>: <span><?php echo descTipoMateria($tipoMat); ?></span>
                        <?php }?>
                        <?php if(!empty($veiculo)) { ?>
                                <strong>Ve&iacute;culo</strong>: <span><?php echo $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $veiculo))->row()->FANTASIA_VEICULO; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php }?>

                        <?php if(!empty($portal)) { ?>
                                <strong>Site</strong>: <span><?php echo $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $portal))->row()->NOME_PORTAL; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php }?>
                        <?php if(!empty($radio)) { ?>
                                <strong>R&aacute;dio</strong>: <span><?php echo $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $radio))->row()->NOME_RADIO; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;

                        <?php }?>
                        <?php if(!empty($tv)) { ?>

                                <strong>Televis&atilde;o</strong>: <span><?php echo $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $tv))->row()->NOME_TV; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php }?>
                        <?php if(!empty($tipo)) { ?>
                                <strong>&Aacute;rea de assunto</strong>: <span><?php echo $this->ComumModelo->getTableData('TIPO_MATERIA', array('SEQ_TIPO_MATERIA' => $tipo))->row()->DESC_TIPO_MATERIA; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php }?>
                        <?php if(!empty($setor)) { ?>
                                <strong>Setor</strong>: <span><?php $dadosSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $setor))->row();
                                echo $dadosSetor->DESC_SETOR. ' - '.$dadosSetor->SIG_SETOR; ?>
                            </span>&nbsp;&nbsp;&nbsp;&nbsp;

                        <?php }?>

                        <?php if(!empty($texto)) { ?>
                                <strong>Texto</strong>: <span><?php echo $texto; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php }?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <?php
    $descTipo =array(
        'S'=>'cloud_queue',
        'I'=>'description',
        'R'=>' radio',
        'T'=>' tv'
    );
    if (!empty($lista_dias)) {
//        echo '<pre>';
//        print_r($lista_dias);
//        die();
        foreach ($lista_dias as $materia):
//            echo '<pre>';
//            print_r($materia);
//            die();
        //usort($materia, "cmp");      
        
        foreach ($materia as $item):
            $dadoVeiculo=NULL;
            if($item['TIPO_MATERIA']=='I' and !empty($item['SEQ_VEICULO']))
                $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row();
            else if($item['TIPO_MATERIA']=='S' and !empty($item['SEQ_PORTAL']))
                $dadoVeiculo =  $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row();
            else if($item['TIPO_MATERIA']=='R' and !empty($item['SEQ_RADIO']))
                $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row();
            else if($item['TIPO_MATERIA']=='T' and !empty($item['SEQ_TV']))
                $dadoVeiculo = $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $item['SEQ_TV']))->row();

            $analiseConteudo='';
            if (!empty($item['IND_AVALIACAO']) and $item['IND_AVALIACAO']=='N' and !empty($item['ANALISE_MATERIA'])){
                $resumo = array("Resumo", "resumo", "RESUMO");
                $resposta   = array("Resposta", "resposta", "RESPOSTA");

                $analiseConteudo = str_replace($resumo, "*Resumo*", $item['ANALISE_MATERIA']);
                $analiseConteudo = str_replace($resposta, "*Resposta*", $analiseConteudo);

            }
            ?>
                <div class="card" style="margin-bottom: 0px !important;border-bottom: 1px solid rgba(204, 204, 204, 0.35) !important;; ">
                    <div class="header " style="border-bottom: 0px!important;">
                        <?php 
                        if ($tipo_avaliacao_materia !== $item['IND_AVALIACAO']) {
                            if ($item['IND_AVALIACAO'] == 'P') {
                                echo '<h4> MATÉRIAS POSITIVAS </h4>';
                            } else if ($item['IND_AVALIACAO'] == 'N') {
                                echo '<h4> MATÉRIAS NEGATIVAS </h4>';
                            } else {
                                echo '<h4> MATÉRIAS NEUTRAS </h4>';
                            }
                        }
                        $tipo_avaliacao_materia = $item['IND_AVALIACAO'];
                        ?>
                        <?php echo date('d/m/Y', strtotime($item['DATA_MATERIA_PUB'])).' '. date('H:i:s', strtotime($item['DATA_MATERIA_CAD'])). ' - '; ?> 
                            <?php if ($item['TIPO_MATERIA'] == 'I' and !empty($item['SEQ_VEICULO']))
                                echo $dadoVeiculo->FANTASIA_VEICULO;
                            else if ($item['TIPO_MATERIA'] == 'S' and !empty($item['SEQ_PORTAL']))
                                echo $dadoVeiculo->NOME_PORTAL;
                            else if ($item['TIPO_MATERIA'] == 'R' and !empty($item['SEQ_RADIO']))
                                echo $dadoVeiculo->NOME_RADIO;
                            else if ($item['TIPO_MATERIA'] == 'T' and !empty($item['SEQ_TV']))
                                echo $dadoVeiculo->NOME_TV.' - '.$item['PROGRAMA_MATERIA'];
                            ?>
                        <?php if($item['TIPO_MATERIA']=='I') {
                            $dadosMateriaArr = array();
                            if (!empty($item['EDITORIA_MATERIA'])) array_push($dadosMateriaArr,$item['EDITORIA_MATERIA']);
                            if (!empty($item['AUTOR_MATERIA'])) array_push($dadosMateriaArr,$item['AUTOR_MATERIA']);
                            if (!empty($item['PAGINA_MATERIA'])) array_push($dadosMateriaArr,$item['PAGINA_MATERIA']);

                            if (count($dadosMateriaArr)>0) echo '' . implode('/',$dadosMateriaArr).'';
                        } ?>
                        <br/>
                        <?php if ($this->session->userdata('idClienteSessao')!=3) echo $item['DESC_SETOR'].' - '.$item['SIG_SETOR']; ?><br/>
                            <strong><?php echo $item['TIT_MATERIA']; ?></strong><br/>
                    </div>
                    <div class="body">
                        <div class="panel-body nopadding-print">
                            <?php if($item['TIPO_MATERIA']!='S') { ?>
                                <a style="color: #0000FF !important;; text-decoration: underline!important;"
                                   href="<?php echo url_materia_simples($item['SEQ_CLIENTE']).$item['CHAVE']; ?>" target="_blank"
                                    ><?php echo url_materia_simples($item['SEQ_CLIENTE']).$item['CHAVE']; ?>
                                </a>
                            <?php  } else { ?>
                                <a style="color: #0000FF !important;; text-decoration: underline!important;"
                                   href="<?php echo $item['LINK_MATERIA']; ?>" target="_blank"
                                    ><?php echo $item['LINK_MATERIA'];?>
                                </a>
                            <?php  } ?>
                            <br/><br/>
                        </div>
                    </div>
                </div>
            <hr/>
            <?php
        endforeach; endforeach; } ?>
</div>
</body>
</html>

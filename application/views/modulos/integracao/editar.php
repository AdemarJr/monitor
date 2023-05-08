<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">edit</i> Alterar</h2>
        <small>Matéria</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li>
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li><a href="<?php echo base_url('materia') ?>" class="ajax-link-interno">
                    <i class="material-icons">attach_file</i>Matéria</a></li>
            <li class="active">Alterar</li>
        </ol>
    </div>
</div> 
<?php
//
if ($tipoMateria == 'I' and !empty($veiculo))
    $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $veiculo))->row();
else if ($tipoMateria == 'S' and !empty($portal))
    $dadoVeiculo = $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $portal))->row();
else if ($tipoMateria == 'R' and !empty($radio))
    $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $radio))->row();
else if ($tipoMateria == 'T' and !empty($tv))
    $dadoVeiculo = $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $tv))->row();
if ($tipoMateria == 'I' and !empty($veiculo)) {
    $mensagem = $dadoVeiculo->FANTASIA_VEICULO . PHP_EOL . $titulo . PHP_EOL . 'Link: ' . url_materia_simples($cliente) . $chave;
} else if ($tipoMateria == 'S' and !empty($portal)) {
    $mensagem = $dadoVeiculo->NOME_PORTAL . PHP_EOL . $titulo . PHP_EOL . 'Link: ' . url_materia_simples($cliente) . $chave;
} else if ($tipoMateria == 'R' and !empty($radio)){
    $mensagem = $dadoVeiculo->NOME_RADIO.PHP_EOL.$programa.PHP_EOL.$titulo.PHP_EOL.'Link: '.url_materia_simples($cliente).$chave;
} else if ($tipoMateria == 'T' and !empty($tv)) {
    $mensagem = $dadoVeiculo->NOME_TV . PHP_EOL .$programa.PHP_EOL. $titulo . PHP_EOL . 'Link: ' . url_materia_simples($cliente) . $chave;
}

$cliFlavio = 49;

$listaMidias = array (55,58,60);


/*
 *
 * Analise mensagem para assunto geral
 */

if ($tipoMateria == 'I' and !empty($veiculo) and $assunto>0) {
    $mensagemti = '*'.$this->ComumModelo->getTableData('ASSUNTO_GERAL', array('SEQ_ASSUNTO_GERAL' => $assunto))->row()->DESC_ASSUNTO_GERAL.'*'.PHP_EOL.$dadoVeiculo->FANTASIA_VEICULO . PHP_EOL . $titulo . PHP_EOL . 'Link: ' . url_materia_simples_ti() . $chave;
} else if ($tipoMateria == 'S' and !empty($portal) and $assunto>0) {
    $mensagemti = '*'.$this->ComumModelo->getTableData('ASSUNTO_GERAL', array('SEQ_ASSUNTO_GERAL' => $assunto))->row()->DESC_ASSUNTO_GERAL.'*'.PHP_EOL.$dadoVeiculo->NOME_PORTAL . PHP_EOL . $titulo . PHP_EOL . 'Link: ' . url_materia_simples_ti() . $chave;
} else if ($tipoMateria == 'R' and !empty($radio) and $assunto>0){
    $mensagemti = '*'.$this->ComumModelo->getTableData('ASSUNTO_GERAL', array('SEQ_ASSUNTO_GERAL' => $assunto))->row()->DESC_ASSUNTO_GERAL.'*'.PHP_EOL.$dadoVeiculo->NOME_RADIO.PHP_EOL.$programa.PHP_EOL.$titulo.PHP_EOL.'Link: '.url_materia_simples_ti().$chave;
} else if ($tipoMateria == 'T' and !empty($tv) and $assunto>0) {
    $mensagemti = '*'.$this->ComumModelo->getTableData('ASSUNTO_GERAL', array('SEQ_ASSUNTO_GERAL' => $assunto))->row()->DESC_ASSUNTO_GERAL.'*'.PHP_EOL.$dadoVeiculo->NOME_TV . PHP_EOL .$programa.PHP_EOL. $titulo . PHP_EOL . 'Link: ' . url_materia_simples_ti() . $chave;
}

$analiseConteudo='';
if (!empty($avaliacao) and $avaliacao=='N' and !empty($resumo) and !empty($resposta)){


        $analiseConteudo = "*Resumo:* " . $resumo;
        if (!empty($comentario)) {
            $analiseConteudo .= PHP_EOL . "*Comentário Apresentador:* " . $comentario;
        }
        $analiseConteudo .= PHP_EOL . "*Resposta:* " . $resposta;
    $mensagem = $mensagem.PHP_EOL.PHP_EOL.$analiseConteudo;
} else if (!empty($avaliacao) and $avaliacao=='N' and !empty($analise)){
    $resumoReplace = array("Resumo", "resumo", "RESUMO");
    $respostaReplace   = array("Resposta", "resposta", "RESPOSTA");

    $analiseConteudo = str_replace($resumoReplace, "*Resumo*", $analise);
    $analiseConteudo = str_replace($respostaReplace, "*Resposta*", $analiseConteudo);

    $mensagem = $mensagem.PHP_EOL.PHP_EOL.$analiseConteudo;
}

$flagMidiaSocial = !(!empty($this->session->userdata('idClienteSessao')) && ($this->session->userdata('idClienteSessao')==39 ||
        $this->session->userdata('idClienteSessao')==$cliFlavio)) ;

$flagMidiaSocial55 = in_array($this->session->userdata('idClienteSessao'),$listaMidias);



?>

<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <div class="row clearfix">
                <div class="col-xs-12 col-md-8 col-xl-8">
                    <h3 class="box-title">Dados do Matéria <span class="label bg-pink"><?php echo descTipoMateria($tipoMateria);?></span> <span class="label bg-cyan"><?php echo $idMateria;?></span> </h3>
                </div>
                <div class="col-xs-12 col-md-4 col-xl-4">
                    <div class="image align-right">
                        <img id="logo-veiculo" <?php if (!empty($logo_veiculo)) echo 'src="'.$logo_veiculo.'"';?> width="48" height="48">
                    </div>
                </div>
                <div class="col-xs-12 col-md-12 col-xl-12">
                    <?php if (!empty($usuarioAlt) and $usuarioAlt ==$this->session->userdata('idUsuario')) {?>
                        <small class="pull-right"><i>Atualizado por: Voc&ecirc;</i></small>
                    <?php } else if (!empty($usuarioAlt) and $usuarioAlt>0) {?>
                        <small class="pull-right"><i>Atualizado por: <?php echo $this->ComumModelo->getUser($usuarioAlt)->row()->NOME_USUARIO; ?></i></small>
                    <?php }?>
                </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php echo form_open(base_url('integracao/alterar/'.$idMateria),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="masked-input">
                        <div class="row clearfix">
                            <input type="hidden" name="acao" id="acao"/>
                            <input type="hidden" name="tipoMat" id="tipoMat" value="<?php echo $tipoMateria;?>"/>
                            <input type='hidden'id='idMateria' name='idMateria' value='<?php if (!empty($idMateria)) echo $idMateria;?>'/>
                            <?php
                            $clientes=array();
                        //    if($this->session->userData('perfilUsuario')=='ROLE_ADM') {
                                $clientes = $this->ComumModelo->getClienteTodos()->result_array();
                        //    }  else {
                        //            $clientes = $this->ComumModelo->getClientes($this->session->userData('listaCliente'))->result_array();
                        //    }
                             ?>
                            <?php if (!empty($clientes) and count($clientes)>1) { ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                            <select class="form-control show-tick" name="idcliente" 
                                            id="idcliente" data-live-search="true">
                                                <?php if (!empty($clientes)) {
                                                    foreach ($clientes as $item): ?>
                                                        <option value="">Selecionar cliente</option>
                                                        <option
                                                            value="<?php echo $item['SEQ_CLIENTE'] ?>" 
                                                            <?php if (!empty($cliente) and $cliente==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                                <input type='hidden'id='idcliente' name='idcliente' value='<?php if (!empty($this->session->userdata('idClienteSessao'))) echo $this->session->userdata('idClienteSessao');?>'/>
                            <?php } ?>
                                   
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">

                                        <?php if($tipoMateria == 'S') { ?>
                                        <select class="form-control show-tick" name="portal" id="portal" data-live-search="true" data-size="5">
                                            <option value="">Selecione - Site</option>
                                            <?php
                                                $funcaoSel=NULL;
                                                if (!empty($lista_veiculo)) {
                                                foreach ($lista_veiculo as $item): ?>
                                                    <option data-funcao="<?php echo $item['FUNCAO_PORTAL']; ?>"
                                                        value="<?php echo $item['SEQ_PORTAL'] ?>" <?php if (!empty($portal) and $portal==$item['SEQ_PORTAL']){ echo 'selected'; $funcaoSel = $item['FUNCAO_PORTAL']; }?>><?php echo $item['NOME_PORTAL']; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                        <?php } else if($tipoMateria == 'I') { ?>
                                        <select class="form-control show-tick" name="veiculo" id="veiculo" data-live-search="true" data-size="5">
                                            <option value="">Selecione - Veículo</option>
                                            <?php if (!empty($lista_veiculo)) {
                                                foreach ($lista_veiculo as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_VEICULO'] ?>" <?php if (!empty($veiculo) and $veiculo==$item['SEQ_VEICULO']) echo 'selected';?>><?php echo $item['FANTASIA_VEICULO']; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                        <?php } else if($tipoMateria == 'R') { ?>
                                            <select class="form-control show-tick" name="radio" id="radio" data-live-search="true" data-size="5">
                                                <option value="">Selecione - R&aacute;dio</option>
                                                <?php if (!empty($lista_veiculo)) {
                                                    foreach ($lista_veiculo as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_RADIO'] ?>" <?php if (!empty($radio) and $radio==$item['SEQ_RADIO']) echo 'selected';?>><?php echo $item['NOME_RADIO']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        <?php } else if($tipoMateria == 'T') { ?>
                                            <select class="form-control show-tick" name="tv" id="tv" data-live-search="true" data-size="5">
                                                <option value="">Selecione - Televis&atilde;o</option>
                                                <?php if (!empty($lista_veiculo)) {
                                                    foreach ($lista_veiculo as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_TV'] ?>" <?php if (!empty($tv) and $tv==$item['SEQ_TV']) echo 'selected';?>><?php echo $item['NOME_TV']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="tipo" data-live-search="true" data-size="5"

                                                <?php if ( $cliente ==$cliFlavio
                                                ) echo 'multiple="multiple" name="tipo[]"';
                                                else echo 'name="tipo"'
                                                ?>
                                                >
                                                <option value="">Selecione - Área da Matéria</option>
                                                <?php if (!empty($lista_tipo)) {
                                                    foreach ($lista_tipo as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_TIPO_MATERIA'] ?>"
                                                            <?php if (!empty($tipo) and in_array($item['SEQ_TIPO_MATERIA'],explode(',',$tipo))) echo 'selected';?>>
                                                            <?php echo $item['DESC_TIPO_MATERIA']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" class="datepicker form-control" id='data' name='data' placeholder="selecione a data..."  value='<?php if (!empty($data)) echo date('d/m/Y',strtotime($data));?>'>
                                            <label id="label-for" class="form-label">Data Publicação <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="row clearfix">
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                            <span class="font-bold">Título</span>
                                            <blockquote class="m-b-25"><p><?php if (!empty($titulo)) echo $titulo;?></p></blockquote>
                                    </div>
                                </div>
                            <?php if($tipoMateria == 'S') { ?>
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <span class="font-bold">URL</span>
                                        <input type="hidden" name="link" id="link" value="<?php if (!empty($link)) echo $link; ?>"/>
                                        <blockquote class="m-b-25"><p><?php if (!empty($link)) echo $link;?></p></blockquote>
                                    </div>
                                </div>
                            <?php } ?>
                                
                            <?php if(($this->session->userdata('idClienteSessao')!=$cliFlavio and $this->session->userdata('idClienteSessao')!=43  and $tipoMateria=='S'
                                and !in_array($this->session->userdata('idClienteSessao'),$listaMidias)
                            ) or
                            ($this->session->userdata('idClienteSessao')==43 and in_array($tipoMateria,array('R','T')))

                            ) { ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                    <span class="font-bold">Resumo/Texto</span>
                                        <blockquote class="m-b-25"><?php if (!empty($texto)) echo nl2br($texto);?></blockquote>
                                    </div>
                            </div>
                            <?php } ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control show-tick"
                                                    <?php if ( $cliente ==3 
                                                            or $cliente ==59
                                                            or $cliente ==62
                                                            or $cliente ==63
                                                            or $cliente ==64
                                                            ) echo 'multiple="multiple" name="setor[]"';
                                                        else echo 'name="setor"'
                                                    ?>
                                                    id="setor" data-live-search="true" data-size="5">
                                                <option value="">Selecione - Setor</option>
                                                <?php if (!empty($lista_setor)) {
                                                    foreach ($lista_setor as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_SETOR'] ?>"
                                                            <?php if (!empty($setor) and in_array($item['SEQ_SETOR'],explode(',',$setor))) echo 'selected';?>>
                                                            <?php echo $item['DESC_SETOR'].'('.$item['SIG_SETOR'].')'; ?>
                                                        </option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="box-title">Releases</h4>
                                <div class="row clearfix">
                                    <div class="col-xs-12 col-md-12 col-xl-12">
                                        <div class="form-group form-float">
                                            <div class="form-line" id="divrelease">
                                                <select class="form-control show-tick" name="release" id="release" data-live-search="true" data-size="6">
                                                    <option value="0">Selecione - Release da Mat&eacute;ria</option>
                                                    <?php if (!empty($lista_release)) {
                                                        foreach ($lista_release as $item): ?>
                                                            <option
                                                                value="<?php echo $item['SEQ_RELEASE'] ?>" <?php if (!empty($release) and $release==$item['SEQ_RELEASE']) echo 'selected';?>><?php echo $item['DESC_RELEASE'].'('.date('d/m/Y',strtotime($item['DATA_ENVIO_RELEASE'])).')'; ?></option>
                                                        <?php endforeach;
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            <?php if($flagMidiaSocial and $this->session->userdata('idClienteSessao')!=43 and !$flagMidiaSocial55) { ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" class="form-control palavra" id="palavra" name="palavra" data-role="tagsinput" value="<?php if (!empty($palavra)) echo $palavra;?>">
                                        <label id="label-for" class="form-label">Palavras-Chaves <span style="color:red">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="row clearfix">
                            <?php if($tipoMateria == 'I') { ?>
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='pagina' name='pagina' value="<?php if (!empty($pagina)) echo $pagina;?>"/>
                                            <label id="label-for" class="form-label">Página </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='autor' name='autor' value="<?php if (!empty($autor)) echo $autor;?>"/>
                                            <label id="label-for" class="form-label">Autor da Matéria</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='editorial' name='editorial' value="<?php if (!empty($editorial)) echo $editorial;?>"/>
                                            <label id="label-for" class="form-label">Editoria</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } else if($tipoMateria == 'R' or $tipoMateria == 'T'){ ?>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='hora' name='hora' value="<?php if (!empty($hora)) echo $hora;?>" maxlength="200"/>
                                            <label id="label-for" class="form-label">Horário <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='programa' name='programa' value="<?php if (!empty($programa)) echo $programa;?>" maxlength="500"/>
                                            <label id="label-for" class="form-label">Programa <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='apresentador' name='apresentador' value="<?php if (!empty($apresentador)) echo $apresentador;?>" maxlength="500"/>
                                            <label id="label-for" class="form-label">Apresentador</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row clearfix">
                            <?php if($tipoMateria == 'S' and $flagMidiaSocial55) { ?>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='number' class='form-control' id='qtdComentario' name='qtdComentario' value="<?php if (!empty($qtdComentario)) echo $qtdComentario;?>"/>
                                            <label id="label-for" class="form-label">Quantidade Coment&aacute;rios</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='number' class='form-control' id='qtdCurtida' name='qtdCurtida' value="<?php if (!empty($qtdCurtida)) echo $qtdCurtida;?>"/>
                                            <label id="label-for" class="form-label">Quantidade Curtidas</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='number' class='form-control' id='qtdCompartilhamento' name='qtdCompartilhamento' value="<?php if (!empty($qtdCompartilhamento)) echo $qtdCompartilhamento;?>"/>
                                            <label id="label-for" class="form-label">Quantidade Compartilhamentos</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if($tipoMateria == 'I' or ($tipoMateria == 'S' and $flagMidiaSocial and !$flagMidiaSocial55)) { ?>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='destaque' name='destaque' value="<?php if (!empty($destaque)) echo $destaque;?>"/>
                                            <label id="label-for" class="form-label">Destaque</label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                                
                            <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                <?php if (!empty($cliente) and 
                                        ($cliente==3 or 
                                        $cliente==59)
                                    ) { ?>
                                <div class="panel-group" id="accordion_20" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading" role="tab" id="headingOne_2">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" href="#collapseOne_2" aria-expanded="true" aria-controls="collapseOne_2">
                                                    <i class="material-icons">assignment_turned_in</i> Avalia&ccedil;&atilde;o individual por setor
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne_2" class="panel-collapse collapse in" role="tabpanel2" aria-labelledby="headingOne_2">
                                            <div class="panel-body">
                                                <?php if (!empty($lista_setores)) {
                                                    $j = 1000;
                                                    foreach($lista_setores as $itemm):
                                                        ?>
                                                        <div class="col-xs-12 col-md-12 col-xl-12">
                                                            <span>Avaliação para <?php
                                                                $dataSetor = $this->ComumModelo->getTableData('SETOR', array('SEQ_SETOR' => $itemm['SEQ_SETOR']))->row()->DESC_SETOR;
                                                                echo $dataSetor; ?></span>
                                                            <div class="form-group">
                                                                <input class="radio-col-teal processa-avaliacao" name="avaliacao_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" type="radio" data-valor="P" data-chave="<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" id="avaliacaoP2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>"  value="P" <?php if (!empty($itemm['IND_AVALIACAO']) and $itemm['IND_AVALIACAO']=='P') echo 'checked';?> />
                                                                <label for="avaliacaoP2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>">Positiva</label>
                                                                <input class="radio-col-red processa-avaliacao" name="avaliacao_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" data-valor="N" data-chave="<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" type="radio" id="avaliacaoN2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>"  value="N" <?php if (!empty($itemm['IND_AVALIACAO']) and $itemm['IND_AVALIACAO']=='N') echo 'checked';?>/>
                                                                <label for="avaliacaoN2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>">Negativa</label>
                                                                <input class="radio-col-yellow processa-avaliacao" name="avaliacao_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" data-valor="T" data-chave="<?php echo $itemm['SEQ_MAT_CLI_SET'];?>" type="radio" id="avaliacaoT2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>"  value="T" <?php if (!empty($itemm['IND_AVALIACAO']) and $itemm['IND_AVALIACAO']=='T') echo 'checked';?>/>
                                                                <label for="avaliacaoT2_<?php echo $itemm['SEQ_MAT_CLI_SET'];?>">Neutra</label>
                                                            </div>
                                                        </div>
                                                        <?php $j++;
                                                    endforeach;
                                                } else {?>
                                                    Nenhum Setor para avaliar individualmente!!
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if (!empty($this->session->userdata('idClienteSessao')) and ( $this->session->userdata('idClienteSessao')==$cliFlavio )) { ?>
                                    <div class="panel-group" id="accordion_t20" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading" role="tab" id="headingOne_t">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" href="#collapseOne_t" aria-expanded="true" aria-controls="collapseOne_t">
                                                        <i class="material-icons">assignment_turned_in</i> Quantitativo de Coment&aacute;rio por &Aacute;rea
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne_t" class="panel-collapse collapse in" role="tabpanelt" aria-labelledby="headingOne_t">
                                                <div class="panel-body">
                                                    <?php if (!empty($lista_tipos)) {
                                                        $j = 1000;
                                                        foreach($lista_tipos as $itemm):
                                                            ?>
                                                            <div class="col-xs-12 col-md-12 col-xl-12">

                                                            <span>&Aacute;rea: <?php
                                                                $dataTipo = $this->ComumModelo->getTableData('TIPO_MATERIA', array('SEQ_TIPO_MATERIA' => $itemm['SEQ_TIPO_MATERIA']))->row()->DESC_TIPO_MATERIA;
                                                                echo $dataTipo; ?></span>

                                                            <div class="form-line ">
                                                                <label for="comentarioP2_<?php echo $itemm['SEQ_MAT_CLI_TIPO'];?>">Quantidade de Coment&aacute;rios</label>
                                                                <input class="processa-comentario"
                                                                       name="quantidade<?php echo $itemm['SEQ_MAT_CLI_TIPO'];?>"
                                                                       type="number"
                                                                       data-chave="<?php echo $itemm['SEQ_MAT_CLI_TIPO'];?>"
                                                                       id="comentarioP2_<?php echo $itemm['SEQ_MAT_CLI_TIPO'];?>"
                                                                       value="<?php if (!empty($itemm['QTD_COMENTARIO'])) echo $itemm['QTD_COMENTARIO'];?>"  />

                                                            </div>
                                                            </div>
                                                            <?php $j++;
                                                        endforeach;
                                                    } else {?>
                                                        Nenhuma &Aacute;rea selecionada!!
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if ($flagMidiaSocial and !$flagMidiaSocial55) { ?>
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="form-line">
                                    <div class="demo-checkbox">
                                        <input id="indFiltro" type="checkbox" name="indFiltro" value="S" <?php if(!empty($indFiltro) and $indFiltro=='S')  echo 'checked'; ?>/>&nbsp;
                                        <label for="indFiltro">Aplicar Filtro no Alerta/Relatório?</label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        
                        <div class="row clearfix">
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <p>Avaliação <span style="color:red">*</span></p>
                                    <div class="form-group">
                                        <input  class="radio-col-teal" name="avaliacao" type="radio" id="avaliacaoP"  value="P" <?php if (!empty($avaliacao) and $avaliacao=='P') echo 'checked';?> />
                                        <label for="avaliacaoP">Positiva</label>
                                        <input class="radio-col-red" name="avaliacao" type="radio" id="avaliacaoN"  value="N" <?php if (!empty($avaliacao) and $avaliacao=='N') echo 'checked';?>/>
                                        <label for="avaliacaoN">Negativa</label>
                                        <input class="radio-col-yellow" name="avaliacao" type="radio" id="avaliacaoT"  value="T" <?php if (!empty($avaliacao) and $avaliacao=='T') echo 'checked';?>/>
                                        <label for="avaliacaoT">Neutra</label>
                                    </div>
                                </div>
                                <?php if($tipoMateria == 'I' or ($tipoMateria == 'S' and $flagMidiaSocial) and !$flagMidiaSocial55) { ?>
                                    <div class="col-xs-12 col-md-8 col-xl-8">
                                        <p>Origem <span style="color:red">*</span></p>
                                             <div class="form-group">
                                                 <input class="radio-col-blue" name="classificacao" type="radio" id="classificacaoE" value="E" <?php if (!empty($classificacao) and $classificacao=='E') echo 'checked';?>/>
                                                 <label for="classificacaoE">Demanda Espontânea</label>
                                                 <input class="radio-col-pink" name="classificacao" type="radio" id="classificacaoX"  value="X" <?php if (!empty($classificacao) and $classificacao=='X') echo 'checked';?>/>
                                                 <label for="classificacaoX">Matéria Exclusiva</label>
                                                 <input class="radio-col-pink" name="classificacao" type="radio" id="classificacaoI"  value="I" <?php if (!empty($classificacao) and $classificacao=='I') echo 'checked';?>/>
                                                 <label for="classificacaoI">Release na Íntegra</label>
                                                 <input class="radio-col-pink" name="classificacao" type="radio" id="classificacaoP"  value="P" <?php if (!empty($classificacao) and $classificacao=='P') echo 'checked';?>/>
                                                 <label for="classificacaoP">Release Parcial</label>
                                             </div>
                                    </div>
                                <?php } ?>

                        </div>
                        <?php if($flagMidiaSocial) { ?>
                        <?php if(!$flagMidiaSocial55) { ?>
                        <div class="row clearfix">
                            <p><strong>An&aacute;lise do Conte&uacute;do</strong></p>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="2" maxlength="500" id="resumo" name="resumo" class="form-control no-resize auto-growth" ><?php if (!empty($resumo)) echo $resumo;?></textarea>
                                        <label id="label-for" class="form-label">Resumo <span style="color:red">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="2" maxlength="1000" id="resposta" name="resposta" class="form-control no-resize auto-growth" ><?php if (!empty($resposta)) echo $resposta;?></textarea>
                                        <label id="label-for" class="form-label">Resposta <span style="color:red">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="2" maxlength="1000" id="comentario" name="comentario" class="form-control no-resize auto-growth" ><?php if (!empty($comentario)) echo $comentario;?></textarea>
                                        <label id="label-for" class="form-label">Coment&aacute;rio Apresentador</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-line">
                                    <div class="demo-checkbox">
                                        <input id="basic_checkbox" type="checkbox" name="modelo"
                                            <?php if(!empty($modelo) and $modelo=='S') echo 'checked'; ?>
                                               value="S">&nbsp;
                                        <label for="basic_checkbox">Definir como modelo?</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php } ?>
                        
                        <?php if(!$flagMidiaSocial55) { ?>
                        <h4 class="box-title">Assunto Geral</h4>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="assunto" id="assunto" data-live-search="true" data-size="6">
                                            <option value="0">Selecione - Assunto Geral</option>
                                            <?php if (!empty($lista_assunto)) {
                                                foreach ($lista_assunto as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_ASSUNTO_GERAL'] ?>" <?php if (!empty($assunto) and $assunto==$item['SEQ_ASSUNTO_GERAL']) echo 'selected';?>><?php echo $item['DESC_ASSUNTO_GERAL']; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <h4 class="box-title">Precificação</h4>
                            <div class="row clearfix">
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line" id="divpreco">
                                            <select class="form-control show-tick" name="preco"
                                                    id="preco" data-live-search="true" data-size="6">
                                                <option value="0">Selecione - Preço</option>
                                                <?php if (!empty($lista_preco)) {
                                                    foreach ($lista_preco as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_PRECO'] ?>" <?php if (!empty($preco) and $preco==$item['SEQ_PRECO']) echo 'selected';?>><?php echo $item['DESCRITIVO'].'('.$item['QTD_SEGUNDO'].') - ('.$item['VALOR'].')'; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } ?>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <a href="<?php echo base_url('integracao') ?>" class="btn bg-lime btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                    <i class="material-icons">cancel</i>
                                </a>&nbsp;&nbsp;&nbsp;
                                <button
                                    id="btn-enviar-form"
                                    type="submit"
                                    onclick="$('#acao').val('S');$('#audio').val('');"
                                    class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title="Salvar">
                                    <i class="material-icons">save</i>
                                </button>
                                <?php if ( ($this->auth->CheckMenu('geral','integracao','excluir')==1)) { ?>
                                    <a href="<?php echo base_url('integracao/excluir/'.$idMateria) ?>"
                                       class="btn bg-orange btn-circle-lg waves-effect waves-circle waves-float pull-right botao-excluir"
                                       data-toggle="tooltip" data-placement="top" title="Descartar essa Matéria">
                                        <i class="material-icons">delete</i>
                                    </a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                  </form>
               </div>
    </div>
</div><!-- /.row -->
</div>
<script type="text/javascript">
    
    function initAjaxSetorCli() {
        $('.processa-avaliacao').click(function(){
            var chaveVal = $(this).data('chave');
            var valorVal = $(this).data('valor');
            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: '/monitor/materia/ajaxAlteraSetorCli',
                type: 'POST',
                cache: false,
                data: {
                    chave: chaveVal,
                    valor: valorVal,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function (data) {
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('msgAjax', errorThrown);
                },
                dataType: "html"
            });
        });
    }
    function initAjaxTipoCli() {
        $('.processa-comentario').blur(function(){
            var chaveVal = $(this).data('chave');
            var valorVal = $(this).val();
            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: '/monitor/materia/ajaxAlteraTipoCli',
                type: 'POST',
                cache: false,
                data: {
                    chave: chaveVal,
                    valor: valorVal,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function (data) {
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('msgAjax', errorThrown);
                },
                dataType: "html"
            });
        });
    }

    $(function () {


        $.validator.addMethod("validaAnaliseResu", function(v, e, p) {
            return !(e.textLength==0 && $("input[name='"+p+"']:checked").val()=='N');
        },"Resumo obrigatorio");
        $.validator.addMethod("validaAnaliseResp", function(v, e, p) {
            return !(e.textLength==0 && $("input[name='"+p+"']:checked").val()=='N');
        },"Resposta obrigatoria");
        $('#formPadrao').validate({
            rules: {
                'idcliente': {required: true},
                'veiculo': {required: true},
                'portal': {required: true},
                'radio': {required: true},
                'tv': {required: true},
                'setor': {required: true},
                'tipo': {required: true},
                'resumo': {validaAnaliseResu: "avaliacao"},
                'resposta': {validaAnaliseResp: "avaliacao"},
                <?php if(($tipoMateria == 'S' and $flagMidiaSocial and !$flagMidiaSocial55 ) or $tipoMateria == 'T') { ?>'texto': {required: true},<?php } ?>
                <?php if($tipoMateria == 'S' and $flagMidiaSocial and !$flagMidiaSocial55) { ?>'pagina': {required: true},<?php } ?>
                'programa': {required: true},
                <?php if($tipoMateria == 'S' and $flagMidiaSocial and !$flagMidiaSocial55) { ?>'apresentador': {required: true},<?php } ?>
                <?php if($tipoMateria == 'S' and $flagMidiaSocial and !$flagMidiaSocial55) { ?>'autor': {required: true},<?php } ?>
                'avaliacao': {required: true},
                'classificacao': {required: true},
                'data': {required: true},
                <?php if (!empty($this->session->userdata('idClienteSessao')) and $this->session->userdata('idClienteSessao')==10) { ?>
                'tipoCrime': {required: true},
                'bairroCrime': {required: true},
                'localCrime': {required: true},
                'indPreso': {required: true},

                <?php } ?>
                'hora': {required: true},

            },
            messages:{

                'idcliente': {
                    required: 'Cliente da Matéria é Obrigatório',
                },
                'veiculo': {
                    required: 'Veículo da Matéria é Obrigatório',
                },
                'tv': {
                    required: 'Televisão da Matéria é Obrigatório',
                },
                'portal': {
                    required: 'Site da Matéria é Obrigatório',
                },
                'radio': {
                    required: 'Rádio da Matéria é Obrigatório',
                },
                'setor': {
                    required: 'Setor da Matéria é obrigatório!'
                },
                'tipo': {
                    required: 'Área da Matéria é obrigatório!'
                },
                <?php if ($flagMidiaSocial) { ?>
                'analise': {
                    validaAnalise: 'Análise do Conteúdo é obrigatório!',
                },
                <?php } ?>
                <?php if (!empty($this->session->userdata('idClienteSessao')) and $this->session->userdata('idClienteSessao')==10) { ?>
                'tipoCrime': {required: 'Tipo do Crime é obrigatório!'},
                'bairroCrime': {required: 'Bairro do Crime é obrigatório!'},
                'localCrime': {required: 'Local do Crime é obrigatório!'},
                'indPreso': {required: 'Ocorreu Prisão é obrigatório!'},
                <?php } ?>

                <?php if(($tipoMateria == 'S' and $flagMidiaSocial) or $tipoMateria == 'T') { ?>'texto': {required: 'Texto da Matéria é obrigatório!' },<?php } ?>
                <?php if($tipoMateria == 'S' and $flagMidiaSocial) { ?>'pagina': { required: 'Página da Matéria é obrigatório!'},<?php } ?>
                'programa': {
                    required: 'Programa da Matéria é obrigatório!'
                },
                'hora': {required: 'Hora da publicação da Matéria é obrigatório!'},
                <?php if($tipoMateria == 'S' and $flagMidiaSocial) { ?>'apresentador': { required: 'Apresentador da Matéria é obrigatório!' },<?php } ?>
                <?php if($tipoMateria == 'S' and $flagMidiaSocial) { ?>'autor': {required: 'Autor da Matéria é obrigatório!'},<?php } ?>
                'avaliacao': {required: 'Avaliação da Matéria é obrigatório!'},
                <?php if ($flagMidiaSocial) { ?>
                'classificacao': {required: 'Origem da Matéria é obrigatório!'},
                <?php } ?>
                'data': {required: 'Data da publicação da Matéria é obrigatório!'}
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            },
            submitHandler: function(form) {
                <?php if ($flagMidiaSocial and !$flagMidiaSocial55 and $this->session->userdata('idClienteSessao')!=43) { ?>
                if ($(".bootstrap-tagsinput").find(".tag").length <= 0){
                    var formLine = $('.bootstrap-tagsinput').parents('.form-line');
                    formLine.addClass('error');
                    $(formLine).parents('.form-group').append('<label id="titulo-error" class="error" for="titulo">Palavras chaves da Matéria é obrigatória!</label>');
                    return false;
                }
                <?php } ?>
                return true;
            }
        });

        $('.btn-fechar-modal').click(function(){
            $('#modal-body-content').html('');
        });

        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });

        
        <?php if ( $cliente ==3  
                or $cliente ==59
                or $cliente ==62
                or $cliente ==63
                or $cliente ==64
                ){ ?>
          $('#setor').on('hidden.bs.select',function(){
            var item = $(this).val();
            var idcliente = $('#idcliente').val();
            if (item!=undefined && item.length>0) {
                $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/monitor/materia/ajaxSetorCli',
                    type: 'POST',
                    cache: false,
                    data: {
                        idCliente: idcliente,
                        idMateria: $('#idMateria').val(),
                        listaSetor: item,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function (data) {
                        $('#collapseOne_2').html(data);
                        initAjaxSetorCli();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('msgAjax', errorThrown);
                    },
                    dataType: "html"
                });
            }
        });
        initAjaxSetorCli();
        <?php } else if ( $cliente!=55 
            and $cliente!=60 
            and $cliente!=61
            and $cliente!=62
            and $cliente!=63
            and $cliente!=64
            ){ ?>
        $('#setor').on('change',function(){
            var item = $(this).val();
            var idcliente = $('#idcliente').val();
            if (item!=undefined && item.length>0) {
                $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/monitor/materia/ajaxReleaseSetor',
                    type: 'POST',
                    cache: false,
                    data: {
                        idCliente: idcliente,
                        idSetor: item,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function (data) {
                        $('#release').html(data);
                        $('#release').selectpicker('refresh');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('msgAjax', errorThrown);
                    },
                    dataType: "html"
                });
            }
        });
        <?php }  ?>

        <?php if ( $cliente ==$cliFlavio) { ?>
            $('#tipo').on('hidden.bs.select',function(){
                var item = $(this).val();
                var idcliente = $('#idcliente').val();
                if (item!=undefined && item.length>0) {
                    $.ajax({
                        mimeType: 'text; charset=utf-8',
                        url: '/monitor/materia/ajaxTipoCli',
                        type: 'POST',
                        cache: false,
                        data: {
                            idCliente: idcliente,
                            idMateria: $('#idMateria').val(),
                            listaTipo: item,
                            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                        success: function (data) {
                            $('#collapseOne_t').html(data);
                            initAjaxTipoCli();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('msgAjax', errorThrown);
                        },
                        dataType: "html"
                    });
                }
            });
            initAjaxTipoCli();
        <?php } ?>


        $('#idcliente').on('change',function(){
            $('#acao').val('I');
            $('#btn-enviar-form').prop("disabled",true);
            document.getElementById("formPadrao").submit();
        });

    });
</script>

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
                    <i class="material-icons">attach_file</i>Matéria </a></li>
            <li class="active">Alterar</li>
        </ol>
    </div>
</div> 
<?php

$lista_op = [11, 37, 60, 63];
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

$listaMidias = array (53,55,58,60,61,63,64);


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

$flag_social = in_array($this->session->userdata('idClienteSessao'),$lista_op);
//print_r($flagMidiaSocial);
//die();
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
                    <?php if (!empty($usuario) and $usuario ==$this->session->userdata('idUsuario')) {?>
                        <small class="pull-left"><i>Criado por: Voc&ecirc;</i></small>
                    <?php } else if (!empty($usuario)) {?>
                        <small class="pull-left"><i>Criado por: <?php echo $this->ComumModelo->getUser($usuario)->row()->NOME_USUARIO; ?></i></small>
                    <?php }?>
                    <?php if (!empty($usuarioAlt) and $usuarioAlt ==$this->session->userdata('idUsuario')) {?>
                        <small class="pull-right"><i>Atualizado por: Voc&ecirc;</i></small>
                    <?php } else if (!empty($usuarioAlt)) {?>
                        <small class="pull-right"><i>Atualizado por: <?php echo $this->ComumModelo->getUser($usuarioAlt)->row()->NOME_USUARIO; ?></i></small>
                    <?php }?>
                </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php echo form_open(base_url('materia/alterar/'.$idMateria),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="masked-input">
                        <div class="row clearfix">
                            <input type="hidden" name="acao" id="acao"/>
                            <input type="hidden" name="tipoMat" id="tipoMat" value="<?php echo $tipoMateria;?>"/>
                            <input type="hidden" name="idRelease" id="idRelease" value="<?php echo $release;?>"/>
                            <input type='hidden'id='idMateria' name='idMateria' value='<?php if (!empty($idMateria)) echo $idMateria;?>'/>
                            <?php
                            $clientes=array();
                            if($this->session->userData('perfilUsuario')=='ROLE_ADM') {
                                $clientes = $this->ComumModelo->getClienteTodos()->result_array();
                            }  else {
                                    $clientes = $this->ComumModelo->getClientes($this->session->userData('listaCliente'))->result_array();
                            }
                             ?>
                            <?php if (!empty($clientes) and count($clientes)>1) { ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                            <select class="form-control show-tick" name="idcliente" id="idcliente" data-live-search="true">
                                                <?php if (!empty($clientes)) {
                                                    foreach ($clientes as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_CLIENTE'] ?>" <?php if (!empty($this->session->userdata('idClienteSessao')) and $this->session->userdata('idClienteSessao')==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
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
                                        <div class="form-line">
                                            <textarea rows="2" id="titulo" name="titulo" class="form-control no-resize auto-growth" ><?php if (!empty($titulo)) echo $titulo;?></textarea>
                                            <label id="label-for" class="form-label">Título da Matéria <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            <?php if($tipoMateria == 'S') { ?>
                                <div class="col-xs-12 col-md-11 col-xl-11">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control link-process' id='link' name='link' value="<?php if (!empty($link)) echo $link;?>"/>
                                            <label id="label-for" class="form-label">URL <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-1 col-xl-1">
                                        <button type="button" id="copiaMateria" <?php if (empty($link) or empty($funcaoSel)) echo 'disabled';?>
                                            class="btn bg-teal btn-circle-lg waves-effect waves-circle waves-float"
                                            data-toggle="tooltip" data-placement="top" title="Copiar Conteúdo do Site"
                                            href="#">
                                            <i class="material-icons">file_copy</i>
                                        </button>
                                </div>
                            <?php } ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control show-tick"
                                                    <?php if ( $cliente ==3 
                                                            or $cliente ==59
                                                            or $cliente ==5
                                                            or $cliente ==1
                                                            or $cliente ==62
                                                            or $cliente ==63
                                                            or $cliente ==11
                                                            or $cliente ==64
                                                            or $cliente ==37
                                                            or $cliente ==18
                                                            or $cliente ==60
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
                            <?php if(

                            ($this->session->userdata('idClienteSessao')!=$cliFlavio and $this->session->userdata('idClienteSessao')!=43  and $tipoMateria=='S'
                                and !in_array($this->session->userdata('idClienteSessao'),$listaMidias)
                            ) or
                            ($this->session->userdata('idClienteSessao')==43 and in_array($tipoMateria,array('R','T')))

                            ) { ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea rows="15" id="texto" name="texto" class="form-control no-resize auto-growth" ><?php if (!empty($texto)) echo $texto;?></textarea>
                                            <label id="label-for" class="form-label">Resumo/Texto <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                            </div>
                            <?php } ?>
                            <?php if($flagMidiaSocial and $this->session->userdata('idClienteSessao')!=43 and !$flagMidiaSocial55) { ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" class="form-control palavra" id="palavra" name="palavra" 
                                        data-role="tagsinput" value="<?php if (!empty($palavra)) echo $palavra;?>">
                                        <label id="label-for" class="form-label">Palavras-Chaves <span style="color:red">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if ($this->session->userdata('idClienteSessao') == 63 || $this->session->userdata('idClienteSessao') == 53) {?>    
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                        <input type="text" class="form-control palavra" id="palavra" name="palavra" 
                                        data-role="tagsinput" value="<?php if (!empty($palavra)) echo $palavra;?>">
                                        <label id="label-for" class="form-label">Palavras-Chaves <span style="color:red">*</span></label>
                                    </div>
                                </div>
                            </div> 
                            <?php } ?>     
                        </div>
                        <div class="row clearfix">
                            <?php 
                            $lista_setor = $this->SetorModelo->listaSetor();
//                            if (!empty($idMateria)) {
//                                $this->db->join('RELEASE_MATERIA RM', 'RM.SEQ_RELEASE = RS.SEQ_RELEASE');
//                                $this->db->join('MATERIA M', 'M.SEQ_RELEASE = RM.SEQ_RELEASE');
//                                $this->db->where('M.SEQ_MATERIA', $idMateria);
//                                $this->db->get('RE');
//                            }
                            ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick"
                                                name="secretarias[]" <?= ($cliente != 1 ? 'multiple="" ' : '')?>
                                                id="secretarias" data-size="5">
                                            <option value="">Outras Secretarias</option>
                                            <?php if (!empty($lista_setor)) {
                                            foreach ($lista_setor as $item): ?>
                                            <?php 
                                            if (!empty($idMateria)) {
                                                $this->db->where('SEQ_SETOR', $item['SEQ_SETOR']);
                                                if (!empty($release)) {
                                                $this->db->where('SEQ_RELEASE', $release);
                                                $sec = $this->db->get('RELEASE_SECRETARIA')->row_array();                                                
                                                    if (empty($sec)) {
                                                        $this->db->where('SEQ_SETOR', $item['SEQ_SETOR']);
                                                        $this->db->where('SEQ_MATERIA', $idMateria);
                                                        $sec = $this->db->get('SECRETARIA_MATERIA')->row_array();
                                                    }                                                
                                                } else {
                                                $this->db->where('SEQ_MATERIA', $idMateria);
                                                $sec = $this->db->get('SECRETARIA_MATERIA')->row_array();
                                                }
                                            }
                                            ?>
                                                <option
                                                    value="<?php echo $item['SEQ_SETOR'] ?>" <?= (!empty($sec) ? 'selected' : '') ?> ><?php echo $item['DESC_SETOR'].'('.$item['SIG_SETOR'].')'; ?></option>
                                            <?php endforeach;
                                        } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
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
<!--                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='destaque' name='destaque' value="<?php if (!empty($destaque)) echo $destaque;?>"/>
                                            <label id="label-for" class="form-label">Destaque</label>
                                        </div>
                                    </div>
                                </div>-->
                            <?php } ?>
                                
                            <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                <?php if (!empty($this->session->userdata('idClienteSessao')) and 
                                        ($this->session->userdata('idClienteSessao')==3 or $this->session->userdata('idClienteSessao')==59)
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
                        <?php if (!empty($this->session->userdata('idClienteSessao')) and $this->session->userdata('idClienteSessao')==10) { ?>
                        <div class="row clearfix">
                            <p><strong>Dados da Seguran&ccedil;a</strong></p>
                                <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='tipoCrime' name='tipoCrime' value="<?php if (!empty($tipoCrime)) echo $tipoCrime;?>"/>
                                            <label id="label-for" class="form-label">Tipo do Crime <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='bairroCrime' name='bairroCrime' value="<?php if (!empty($bairroCrime)) echo $bairroCrime;?>"/>
                                        <label id="label-for" class="form-label">Bairro do Crime <span style="color:red">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='localCrime' name='localCrime' value="<?php if (!empty($localCrime)) echo $localCrime;?>"/>
                                        <label id="label-for" class="form-label">Local do Crime <span style="color:red">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select id="indPreso" class="form-control show-tick"  name="indPreso" data-live-search="true">
                                            <option value="">Ocorreu Pris&atilde;o?</option>
                                            <option value="S" <?php if(!empty($indPreso) and $indPreso=='S') echo 'selected'; ?>>Sim</option>
                                            <option value="N" <?php if(!empty($indPreso) and $indPreso=='N') echo 'selected'; ?>>N&atilde;o</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row clearfix">
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <p>Avaliação 
                                        <?php if ($this->session->userdata('idClienteSessao') != 11) { ?>
                                        <span style="color:red">*</span></p>
                                        <?php } ?>
                                    <div class="form-group">
                                        <input  class="radio-col-teal" name="avaliacao" type="radio" id="avaliacaoP"  value="P" <?php if (!empty($avaliacao) and $avaliacao=='P') echo 'checked';?> />
                                        <label for="avaliacaoP">Positiva</label>
                                        <input class="radio-col-red" name="avaliacao" type="radio" id="avaliacaoN"  value="N" <?php if (!empty($avaliacao) and $avaliacao=='N') echo 'checked';?>/>
                                        <label for="avaliacaoN">Negativa</label>
                                        <input class="radio-col-yellow" name="avaliacao" type="radio" id="avaliacaoT"  value="T" <?php if (!empty($avaliacao) and $avaliacao=='T') echo 'checked';?>/>
                                        <label for="avaliacaoT">Neutra</label>
                                    </div>
                                </div>
              
                                <?php /*if($tipoMateria == 'I' or ($tipoMateria == 'S' and $flagMidiaSocial) and !$flagMidiaSocial55) {  */?>
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
                                <?php /*}*/ ?>

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
                                        <label id="label-for" class="form-label">Resposta</label>
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
                                                            value="<?php echo $item['SEQ_PRECO'] ?>" <?php if (!empty($preco) and $preco==$item['SEQ_PRECO']) echo 'selected';?>><?php echo $item['DESCRITIVO']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php } ?>
                       <?php if($flag_social) { ?>
                       <?php 
                       $lista_cidades = [
                           'NOME_CIDADE' => array("Alvarães", "Amaturá", "Anamã", "Anori", "Apuí", "Atalaia do Norte", "Autazes", "Barcelos", "Barreirinha", "Benjamin Constant", "Beruri", "Boa Vista do Ramos", "Boca do Acre", "Borba", "Caapiranga", "Canutama", "Carauari", "Careiro", "Careiro da Várzea", "Coari", "Codajás", "Eirunepé", "Envira", "Fonte Boa", "Guajará", "Humaitá", "Ipixuna", "Iranduba", "Itacoatiara", "Itamarati", "Itapiranga", "Japurá", "Juruá", "Jutaí", "Lábrea", "Manacapuru", "Manaquiri", "Manaus", "Manicoré", "Maraã", "Maués", "Nhamundá", "Nova Olinda do Norte", "Novo Airão", "Novo Aripuanã", "Parintins", "Pauini", "Presidente Figueiredo", "Rio Preto da Eva", "Santa Isabel do Rio Negro", "Santo Antônio do Içá", "São Gabriel da Cachoeira", "São Paulo de Olivença", "São Sebastião do Uatumã", "Silves", "Tabatinga", "Tapauá", "Tefé", "Tonantins", "Uarini", "Urucará", "Urucurituba")
                        ];
                       ?>    
                    <h4 class="box-title">Cidades</h4>
                        <?php
                        $cidades = '';
                        if (!empty($interior)) {
                            $cidades = explode(',',$interior);
                        }
                        ?>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <select class="form-control show-tick" multiple name="interior[]" id="interior" data-live-search="true" data-size="6">
                                            <option value="">Selecione - Cidade</option>
                                            <?php if (!empty($lista_cidades)) {
                                                foreach ($lista_cidades['NOME_CIDADE'] as $item): ?>
                                                    <option
                                                        <?php if (!empty($interior) and in_array($item, $cidades)) echo 'selected';?>
                                                        value="<?= $item ?>" ><?= $item ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>    
                        <a name="imagens"></a>
                        <h4 class="box-title">Anexos</h4>
                        <div class="row clearfix">
                            <?php if($tipoMateria != 'T') { ?>
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <label class="btn bg-purple btn-circle waves-effect waves-circle waves-float" type="button"  data-toggle="tooltip" data-placement="top" title="Carregar Arquivo">
                                        <?php if($tipoMateria == 'I' or $tipoMateria == 'S') { ?>
                                            <input  id="audio" name="audio" class="upload" type="file" accept="image/gif, image/jpg, image/png, image/jpeg" />
                                        <?php } else if($tipoMateria == 'R') { ?>
                                            <input id="audio" name="audio" class="upload" type="file" accept="audio/*" />
                                        <?php } ?>
                                        <i class="material-icons">insert_drive_file</i>
                                    </label>
                                    <p class="help-block" id="qtd-arquivo"></p>
                                </div>

                            <div class="col-xs-12 col-md-12 col-xl-12">

                                <div class="progress">
                                    <div id="progressbar" class="progress-bar bg-pink progress-bar-striped"
                                         role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                        <div class="status">0%</div>
                                    </div>
                                </div>

                            </div>
                            <?php } else { ?>
                                <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                    <div class="panel-group" id="accordion_19" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading" role="tab" id="headingOne_1">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" href="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne_1">
                                                                <i class="material-icons">tv</i> Arquivos de vídeos no FTP (*.mp4)
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne_1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_1">
                                                        <div class="panel-body">
                                                            <?php if (!empty($lista_video)) {
                                                                $j = 1000;
                                                                foreach($lista_video as $itemm):
                                                                        ?>
                                                                        <div class="col-xs-6">
                                                                            <div class="form-line">
                                                                                <div class="demo-checkbox">
                                                                                    <input id="basic_checkbox_<?php echo $j; ?>" type="checkbox" name="videos[]" value="<?php echo $itemm;?>" >&nbsp;
                                                                                    <label for="basic_checkbox_<?php echo $j; ?>"><?php echo $itemm;?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php $j++;
                                                                endforeach;
                                                            } else {?>
                                                                Nenhum arquivo para selecionar no FTP!
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="list-unstyled row clearfix" id="up_images">
                            <div  class="col-xs-12 col-md-12 col-xl-12">
                                    <?php if (!empty($lista_anexo)) {
                                        foreach ($lista_anexo as $item): ?>
                                            <div id="<?php echo $item['SEQ_ANEXO'] ?>" class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                <button data-toggle="tooltip" data-placement="top" title="Excluir Anexo" class='btn bg-light-blue btn-circle waves-effect waves-circle waves-float botao-excluir-anexo'
                                                        data-url="<?php echo base_url('materia/deleteanexo/') . $item['SEQ_MATERIA'].'/'.$item['SEQ_ANEXO'] ?>">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                <?php if ($this->ComumModelo->existeAnexo($item['SEQ_ANEXO'])) { ?>
                                                    <button type="button" data-toggle="tooltip" data-placement="top" title="baixar" class='btn bg-cyan  btn-circle waves-effect waves-circle botao-baixar'
                                                            data-url="<?php echo base_url('publico/audiodown/') .$item['SEQ_ANEXO']  ?>">
                                                        <i class="material-icons">file_download</i>
                                                    </button>
                                                <?php } ?>

                                                <?php if($tipoMateria == 'I' or $tipoMateria == 'S') { ?>
                                                    <a href="<?php echo base_url('materia/imagem/').$item['SEQ_ANEXO'] ?>">
                                                        <img class="img-responsive thumbnail" src="<?php echo base_url('materia/imagem/').$item['SEQ_ANEXO'] ?>">
                                                    </a>
                                                    <div class="form-line">
                                                        <input class='form-control ordem-change' type="number" id="imgOdem" name="imgOrdem" data-anexo="<?php echo $item['SEQ_ANEXO']; ?>" data-old="<?php echo $item['ORDEM_ARQUIVO']; ?>" value="<?php echo $item['ORDEM_ARQUIVO']; ?>"/>
                                                        <label id="label-for" class="form-label">Ordem da Imagem</label>
                                                    </div>
                                                <?php } else if($tipoMateria == 'R') { ?>
                                                    <div style=" display:inline-block;border: 1px solid;">
                                                            <audio src="<?php echo base_url('materia/audio/').$item['SEQ_ANEXO'] ?>" controls preload="auto">
                                                                <p>Seu navegador não suporta o elemento audio </p>
                                                            </audio><br/>
                                                    </div>
                                                <?php }  ?>
                                            </div>
                                        <?php endforeach;
                                    } ?>
                            </div>
                            
                        </div>
                        <div class="list-unstyled row clearfix" >
                            <div  class="col-xs-12 col-md-12 col-xl-12">
                                <?php if (!empty($lista_anexo)) {
                                     ?>
                                        <?php if($tipoMateria == 'T') {  ?>
                                            <a  class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float btn-radio-play"
                                                data-toggle="tooltip" data-placement="top" title="Play no V&iacute;deo" data-materia="<?php echo $item['SEQ_MATERIA']; ?>">
                                                <i class="material-icons">play_circle_outline</i>
                                            </a>
                                        <?php }  ?>
                                  
                                <?php }  ?>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <a href="<?php echo base_url('materia') ?>" class="btn bg-lime btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                                <?php if ( ($this->auth->CheckMenu('geral','materia','excluir')==1)) { ?>
                                    <a href="<?php echo base_url('materia/excluir/'.$idMateria) ?>"
                                       class="btn bg-orange btn-circle-lg waves-effect waves-circle waves-float pull-right botao-excluir"
                                       data-toggle="tooltip" data-placement="top" title="Descartar essa Matéria">
                                        <i class="material-icons">delete</i>
                                    </a>
                                <?php }
                                if (!empty($radio) or !empty($portal) or !empty($veiculo) or !empty($tv)){
                                ?>
                                <a
                                   class="btn bg-green btn-circle-lg waves-effect waves-circle waves-float pull-right hidden-xl hidden-lg"
                                   data-toggle="tooltip" data-placement="top" title="Descartar essa Matéria"
                                   href="whatsapp://send?text=%F0%9F%93%B0+<?php echo urlencode($mensagem); ?>">
                                    <i class="material-icons">share</i>
                                </a>&nbsp;&nbsp;
                                <a data-toggle="tooltip" data-placement="top"
                                   title="Copiar para o Cliente" data-tipo="nm"
                                   class='btn bg-blue  btn-circle-lg waves-effect waves-circle waves-float pull-right copiar hidden-sm hidden-md'
                                       data-alerta="<?php $dataCliente =$this->ComumModelo->getTableData('CLIENTE',array('SEQ_CLIENTE'=>$this->session->userdata('idClienteSessao')))->row();
                                       echo ($avaliacao=='N'? '*MAT&Eacute;RIA NEGATIVA* '.json_decode('"\u26D4"') .json_decode('"\u26D4"') .json_decode('"\u26D4"') .PHP_EOL.'*'.trim($dataCliente->NOME_CLIENTE).'*'.( ($dataCliente->IND_ALERTA_SETOR =='N')?'':PHP_EOL.$this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$setor))->row()->DESC_SETOR).((in_array($tipoMateria, array('T','R')) and (!empty($tv) or !empty($radio)))? (PHP_EOL. date('d/m/Y',strtotime($data)).(!empty($hora)?'-'.$hora:'')):'').PHP_EOL.PHP_EOL:
                                               json_decode('"\u23F0"').'*Alerta de Clipping*'.PHP_EOL.'*'.trim($dataCliente->EMPRESA_CLIENTE).'*'.( ($dataCliente->IND_ALERTA_SETOR =='N')?'':PHP_EOL.$this->ComumModelo->getTableData('SETOR',array('SEQ_SETOR'=>$setor))->row()->DESC_SETOR).((in_array($tipoMateria, array('T','R')))? (PHP_EOL.date('d/m/Y',strtotime($data)).(!empty($hora)?'-'.$hora:'')):(PHP_EOL.date('d/m/Y',strtotime($data)))).PHP_EOL.PHP_EOL.'').urlencode($mensagem); ?>" href="javascript:void(0);">
                                    <i class="material-icons">content_copy</i>
                                </a>
                                <?php }
                                if ((!empty($radio) or !empty($portal) or !empty($veiculo) or !empty($tv)) and $assunto>0) {
                                ?>
                                <a
                                    class="btn bg-teal btn-circle-lg waves-effect waves-circle waves-float pull-right hidden-xl hidden-lg"
                                    data-toggle="tooltip" data-placement="top" title="Descartar essa Matéria"
                                    href="whatsapp://send?text=%F0%9F%93%B0+<?php echo urlencode($mensagemti); ?>">
                                    <i class="material-icons">share</i>
                                </a>&nbsp;&nbsp;
                                <a data-toggle="tooltip" data-placement="top" data-tipo="ti"
                                   title="Copiar Alerta para Temas de Interesse"
                                   class='btn bg-teal  btn-circle-lg waves-effect waves-circle waves-float pull-right copiar hidden-sm hidden-md'
                                   data-alerta="<?php echo (json_decode('"\u23F0"').'*Alerta de Clipping*'.PHP_EOL.'*TEMA DE INTERESSE*'
                                           .((in_array($tipoMateria, array('T','R')))? (PHP_EOL.date('d/m/Y',strtotime($data)).(!empty($hora)?'-'.$hora:'')):(PHP_EOL.date('d/m/Y',strtotime($data)))).PHP_EOL.PHP_EOL.'').urlencode($mensagemti); ?>" href="javascript:void(0);">
                                    <i class="material-icons">content_copy</i>
                                </a>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                  </form>
               </div>
        <textarea id="alerta" class="textarea" style="width: 0px;height: 0px;resize: none;"></textarea>
        <a id="linkzap" href="" target="_blank" >&nbsp;</a>
    </div>
</div><!-- /.row -->
    <div class="modal fade" id="materiaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect btn-fechar-modal" data-dismiss="modal">Fechar</button>
                </div>
                <div id="modal-body-content" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect btn-fechar-modal" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function atualizaAnexos() {
        var valorNovo = $(this).val();
        valorNovo = valorNovo.length>0?valorNovo:0;
        var valorAntigo = $(this).data('old');
        var seqAnexo = $(this).data('anexo');

        if(valorNovo!=valorAntigo){
            $('#btn-enviar-form').prop("disabled",true);
            $.ajax({
                mimeType: 'text/html; charset=utf-8',
                url: '/monitor/materia/ordenar/'+ seqAnexo+'/'+valorNovo,
                type: 'GET',
                success: function(data) {
                    $('#up_images').html(data);
                    showNotification('alert-success', 'Ordenamento Realizado com sucesso', 'bottom', 'center', 'animated fadeInUp', '');
                    $('#btn-enviar-form').prop("disabled",false);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    showNotification('alert-danger', 'Não foi possível realizar o ordenamento, tente novamente', 'bottom', 'center', 'animated fadeInUp', '');
                    $('#btn-enviar-form').prop("disabled",false);
                },
                dataType: "html",
            });
        }
    };
    function initUpload() {
        $('.botao-excluir').click(function(){
            showConfirmMessage('Voc&ecirc; tem certeza?','Confirmando voc&ecirc; excluir&aacute; esta mat&eacute;ria.',$(this));
            return false;
        });
        $('#audio').on('change', function () {
            if (this.files.length>1)
                $("#qtd-arquivo").html(this.files.length+" arquivos selecionados");
            else
                $("#qtd-arquivo").html(this.files.length+" arquivo selecionado");
            $("#progressbar").css("width", "0%");
            $("#progressbar .status").text("0%");
            $('#btn-enviar-form').prop("disabled",true);
            var file_data = $(this).prop('files')[0];
            if (file_data==null){
                return false;
            }
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
            $.ajax({
                url: '<?php echo base_url('materia/ajaxUploadFile/'.$idMateria); ?>', // point to server-side controller method
//                dataType: 'text', // what to expect back from the server
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                mimeType:"multipart/form-data",
                type: 'post',
                xhr: function(){
                    //upload Progress
                    var xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function(event) {
                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percent = Math.ceil(position / total * 100);
                            }
                            //update progressbar
                            $("#progressbar").css("width", + percent +"%");
                            $("#progressbar .status").text(percent+"%");
                        }, true);
                    }
                    return xhr;
                },
                success: function (response) {
                    if(response!='error' && response!='existe' && response!='sem' ) {
                        $('#up_images').html(response);
                        showNotification('alert-success', 'Arquivo Anexado com sucesso', 'bottom', 'center', 'animated fadeInUp', '');
                    } else {
                        showNotification('alert-warning', 'Arquivo não Anexado, tente novamente', 'bottom', 'center', 'animated fadeInUp', '');
                    }
                    $("#qtd-arquivo").html('');
                    $('#btn-enviar-form').prop("disabled",false);
                  //  $("#formPadrao").reset();
                },
                error: function (response) {
                    showNotification('alert-danger', 'Arquivo não Anexado, tente novamente', 'bottom', 'center', 'animated fadeInUp', '');
                    $('#btn-enviar-form').prop("disabled",false);
                }
            });


        });
        $('.ordem-change').blur(atualizaAnexos);
    };

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
    function playRadio(e){
        e.preventDefault();
        var materia = $(this).data('materia');
        $.ajax({
            mimeType: 'text/html; charset=utf-8',
            url: '<?php echo base_url('publico/ajaxViewer/')?>'+materia,
            type: 'GET',
            success: function (data) {
                $('#modal-body-content').html(data);
                $('#materiaModal').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            dataType: "html",
            async: false
        });
    };

    function carregaPreco(e){
        var tipoMat = $('#tipoMat').val();
        var item = $(e).val();
        if (tipoMat=='R' || tipoMat=='T') {
//            $.ajax({
//                mimeType: 'text; charset=utf-8',
//                url: '/monitor/veiculo/carregaPreco/' + item+'/'+tipoMat,
//                type: 'GET',
//                success: function (data) {
//                    $('#divpreco').html(data);
//                },
//                error: function (jqXHR, textStatus, errorThrown) {
//                    //alert('Ocorreu Algum Problema, não foi possível alterar!');
//                    console.log(errorThrown);
//                },
//                dataType: "html",
//                async: false
//            });
        }
    };
    function eventBotaoCopia(component,urlTarget){
        var url = component.data('url'),
        target = urlTarget;
        $.ajax({
            mimeType: 'text; charset=utf-8',
            url: url,
            type: 'GET',
            success: function (data) {
                if (data.status) {
                    
                        var uragetUrl = target+data.mesage;
                        $('#linkzap').attr('href', uragetUrl)[0].click();
                }else {
                    showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            dataType: "json",
            async: true
        });
    };
    $(function () {

        initUpload();

        $.validator.addMethod("validaAnaliseResu", function(v, e, p) {
            return !(e.textLength==0 && $("input[name='"+p+"']:checked").val()=='N');
        },"Resumo obrigatorio");
//        $.validator.addMethod("validaAnaliseResp", function(v, e, p) {
//            return !(e.textLength==0 && $("input[name='"+p+"']:checked").val()=='N');
//        },"Resposta obrigatoria");
        $('#formPadrao').validate({
            rules: {
                'secretarias': {required: true},
                'veiculo': {required: true},
                'portal': {required: true},
                'radio': {required: true},
                'tv': {required: true},
                'setor': {required: true},
                'tipo': {required: true},
                'titulo': {required: true},
                'resumo': {validaAnaliseResu: "avaliacao"},
//                'resposta': {validaAnaliseResp: "avaliacao"},
                <?php if(($tipoMateria == 'S' and $flagMidiaSocial and !$flagMidiaSocial55 ) or $tipoMateria == 'T') { ?>'texto': {required: true},<?php } ?>
                <?php if($tipoMateria == 'S' and $flagMidiaSocial and !$flagMidiaSocial55) { ?>'pagina': {required: true},<?php } ?>
                'programa': {required: true},
                <?php if($tipoMateria == 'S' and $flagMidiaSocial and !$flagMidiaSocial55) { ?>'apresentador': {required: true},<?php } ?>
                <?php if($tipoMateria == 'S' and $flagMidiaSocial and !$flagMidiaSocial55) { ?>'autor': {required: true},<?php } ?>
                <?php if($this->session->userdata('idClienteSessao') != 11) { ?> 'avaliacao': {required: true},<?php } ?>
                'classificacao': {required: true},
                'data': {required: true},
                <?php if (!empty($this->session->userdata('idClienteSessao')) and $this->session->userdata('idClienteSessao')==10) { ?>
                'tipoCrime': {required: true},
                'bairroCrime': {required: true},
                'localCrime': {required: true},
                'indPreso': {required: true},

                <?php } ?>
                'hora': {required: true},
                'link': {
                    url: true,
                    required: true,
                    remote: {
                        data:{'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' },
                        type: "POST",
                        url: '/monitor/materia/existeLink/'+$('#idMateria').val(),
                        dataFilter: function(response) {
                            return response==='sucesso';
                        }
                    }
                },
            },
            messages:{
                'link': {
                    url: 'Link da Matéria é inválido!',
                    required: 'Link da Matéria é Obrigatório',
                    remote:'Link já cadastrado em outra matéria!',
                },
                'secretarias': {
                    required: 'Secretarias da Matéria é Obrigatório',
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
                'titulo': {
                    required: 'Título da Matéria é obrigatório!',
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
                <?php if($this->session->userdata('idClienteSessao') != 11) { ?> 'avaliacao': {required: 'Avaliação da Matéria é obrigatório!'},<?php } ?>
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


        $('.botao-excluir-anexo').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você excluirá este Arquivo da matéria.',$(this));
            return false;
        });

        $('.botao-baixar').click(function(e){
            e.preventDefault();
            window.location.href = $(this).data('url');
        });
        $('.btn-fechar-modal').click(function(){
            $('#modal-body-content').html('');
        });
        $('.copiarxxx').click(function(event) {
            //$("#alerta").text(JSON.parse($(this).data('alerta')));
            $("#alerta").text(decodeURIComponent($(this).data('alerta').replace(/\+/g, ' ')));
            var copyTextarea = document.querySelector('.textarea');

            copyTextarea.select();
            try {
                var successful = document.execCommand('copy');
                if(successful)
                    showNotification('alert-success', 'Alerta Copiado!', 'bottom', 'center', 'animated fadeInUp', '');
            } catch (err) {
                showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
            }
        });
        $('.copiar').on('click',function (){
            var idMateria = $('#idMateria').val();
            var tipo = $(this).data('tipo');
            var url = '<?php echo base_url('materia/ajaxShare/'); ?>';

            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: url+tipo+'/'+idMateria,
                type: 'GET',
                success: function (data) {
                    if (data.status) {
                        $("#alerta").text(data.mesage.replace(/\+/g, ' '));
                        var copyTextarea = document.querySelector('.textarea');

                        copyTextarea.select();
                        try {
                            var successful = document.execCommand('copy');
                            if (successful)
                                showNotification('alert-success', 'Alerta Copiado!', 'bottom', 'center', 'animated fadeInUp', '');
                        } catch (err) {
                            showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                        }
                    }else {
                        showNotification('alert-danger', 'N&atilde;o foi poss&iacute;vel copiar o alerta!', 'bottom', 'center', 'animated fadeInUp', '');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                dataType: "json",
                async: true
            });
        });
        $('.copiarz1').on('click',function (){
            eventBotaoCopia($(this),'whatsapp://send?text=');
        });
        $('.copiarz2').on('click',function (){
            eventBotaoCopia($(this),'https://web.whatsapp.com/send?text=');
        });


        $('.btn-radio-play').click(playRadio);

        $('.link-process').blur(function(){
            var funcao = $('#portal').find(':selected').data('funcao');
            var link = $(this).val();
            var portalId = $('#portal').val();

            if (link.length >0 && portalId>0 && funcao.length>0){
                $('#copiaMateria').attr('disabled',false);
            }else {
                $('#copiaMateria').attr('disabled',true);
            }
        });

        $('#copiaMateria').click(function(){
             var portalId = $('#portal').val();

            $.ajax({
                mimeType: 'text; charset=utf-8',
                url: '/monitor/materia/getConteudoUrl/' + portalId,
                type: 'POST',
                data: {url:$('#link').val(),'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (data) {
//                    var resp = JSON.parse(data);
//                    if (resp!='vazio'){
//                        var limpo = data.replace(/( )+/g, ' ');
//                        $('#texto').val(limpo.replace(/\t/g,''));
                        $('#texto').val(data.conteudo);
                        $('#titulo').val(data.titulo)
                        $('#texto').parent().addClass('focused');
                        $('#titulo').parent().addClass('focused');
//                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
//                    alert('Ocorreu Algum Problema, não foi possível alterar!');
                    console.log(errorThrown);
                },
                dataType: "json",
                async: false
            });
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

        $('#up_images').lightGallery({
            thumbnail: true,
            selector: 'a'
        });
        $('#radio').on('change',function(){
            carregaPreco(this);
        });
        $('#tv').on('change',function(){
            carregaPreco(this);
        });
        $('#portal').change(function(){
            var funcao = $('#portal').find(':selected').data('funcao');
            var link = $('#link').val();
            var portalId = $('#portal').val();

            if (link.length >0 && portalId>0  && funcao.length>0){
                $('#copiaMateria').attr('disabled',false);
            }else {
                $('#copiaMateria').attr('disabled',true);
            }

        });
//        $('#portal').on('change',function(){
//            var item = $(this).val();
//            if (item.length>0) {
//                $.ajax({
//                    mimeType: 'text; charset=utf-8',
//                    url: '/monitor/veiculo/carregaLogoPortal/' + item,
//                    type: 'GET',
//                    success: function (data) {
//                        $('#logo-veiculo').attr('src', data);
//                    },
//                    error: function (jqXHR, textStatus, errorThrown) {
//                        console.log(errorThrown);
//                    },
//                    dataType: "text",
//                    async: false
//                });
//            } else {
//                $('#logo-veiculo').attr('src', '');
//            }
//        });
//        $('#radio').on('change',function(){
//            var item = $(this).val();
//            if (item.length>0) {
//                $.ajax({
//                    mimeType: 'text; charset=utf-8',
//                    url: '/monitor/veiculo/carregaLogoRadio/' + item,
//                    type: 'GET',
//                    success: function (data) {
//                        $('#logo-veiculo').attr('src', data);
//                    },
//                    error: function (jqXHR, textStatus, errorThrown) {
//                        console.log(errorThrown);
//                    },
//                    dataType: "text",
//                    async: false
//                });
//            } else {
//                $('#logo-veiculo').attr('src', '');
//            }
//        });
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
        <?php } else if ( $cliente!=55 and $cliente!=58){ ?>
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
        $('#release').on('change',function(){
            var item = $(this).val();
            if (item!=undefined && item.length>0) {
                $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/monitor/release/ajaxReleaseById',
                    type: 'POST',
                    cache: false,
                    data: {
                        id: item,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function (data) {
                        $('#texto').val(data.item.texto);
                        $('#tipo').val(data.item.tipo).change();;
                        // $('#palavra').val(data.item.palavra);
                        if (data.item.palavra){
                            $.each(data.item.palavra.split(','), function(index, value) {
                                $('#palavra').tagsinput('add', value);
                            });
                            $('#palavra').tagsinput('refresh');
                        }
                        $('#secretarias option:selected').removeAttr('selected');
                        $('#secretarias').selectpicker('refresh');
                        if (data.item.secretarias ){
                            $.each(data.item.secretarias, function(index, value) {
                                $('#secretarias option[value='+value.SEQ_SETOR+']').attr('selected','selected');
                            });
                        } 
                        $('#secretarias').selectpicker('refresh');
                        $('#titulo').val(data.item.titulo);

                        $('#texto').parent().addClass('focused');
                        $('#titulo').parent().addClass('focused');


                        $('#avaliacao' + data.item.avaliacao).prop('checked',true);
                        $('#classificacao' + data.item.classificacao).prop('checked',true);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('msgAjax', errorThrown);
                    },
                    dataType: "json"
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
            if ($(".bootstrap-tagsinput").find(".tag").length <= 0){
                var formLine = $('.bootstrap-tagsinput').parents('.form-line');
                formLine.addClass('error');
                $(formLine).parents('.form-group').append('<label id="titulo-error" class="error" for="titulo">Palavras chaves da Matéria é obrigatória!</label>');
                return false;
            }
            $('#acao').val('I');
            $('#btn-enviar-form').prop("disabled",true);
            document.getElementById("formPadrao").submit();
        });

    });
</script>

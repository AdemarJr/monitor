<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    RELATÓRIOS
                    <small>Geração de Relatórios</small>
                </h2>
            </div>
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#1" data-toggle="tab">MATÉRIAS</a></li>
                    <li role="presentation"><a href="#2" data-toggle="tab">LISTA DE MATÉRIAS/SETOR</a></li>
                    <li role="presentation"><a href="#3" data-toggle="tab">SETOR/DEPARTAMENTO</a></li>
                    <li role="presentation"><a href="#4" data-toggle="tab">SETOR/DEPARTAMENTO/VEICULO</a></li>
                    <li role="presentation"><a href="#5" data-toggle="tab">VEICULO</a></li>
                    <li role="presentation"><a href="#6" data-toggle="tab">RELEASES</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="1">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="header">Per&iacute;odo
                                    </div>
                                    <div class="body">
                                        <?php echo form_open(base_url('relatorio/executar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                                        <div class="row clearfix">
                                            <input type='hidden' id='acao' name='acao'/>
                                            <div class="col-xs-12 col-md-2 col-xl-2">
                                                <div class="form-group form-float">
                                                    <div class="form-line focused">
                                                        <input type="text" class="datepicker form-control" id='datai' name='datai' placeholder="selecione a data inicio..." value='<?php if (!empty($datai)) echo $datai;?>'>
                                                        <label id="label-for" class="form-label">Data In&iacute;cio</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-2 col-xl-2">
                                                <div class="form-group form-float">
                                                    <div class="form-line focused">
                                                        <input type="text" class="datepicker form-control" id='dataf' name='dataf' placeholder="selecione a data fim..." value='<?php if (!empty($dataf)) echo $dataf;?>'>
                                                        <label id="label-for" class="form-label">Data Fim</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4 col-xl-4">
                                                <div class="form-group form-float">
                                                    <div class="col-xs-12 col-md-8 col-xl-8">
                                                    <div class="form-line focused">
                                                        <input type="text" class="datepicker form-control" id='datai2' name='datai2' placeholder="selecione a data inicio..." value='<?php if (!empty($datai2)) echo $datai2;?>'>
                                                        <label id="label-for" class="form-label">Data In&iacute;cio Cad.</label>
                                                    </div>
                                                    </div>
                                                        <div class="col-xs-12 col-md-4 col-xl-4">
                                                    <div class="form-line focused">
                                                        <input type="text" class="datepicker form-control" id='horair' name='horair' placeholder="selecione a hora inicio..." value='<?php if (!empty($horair)) echo $horair;?>'>
                                                        <label id="label-for" class="form-label">HI Cad.</label>
                                                    </div>
                                                            </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4 col-xl-4">
                                                <div class="form-group form-float">
                                                    <div class="col-xs-12 col-md-8 col-xl-8">
                                                        <div class="form-line focused">
                                                            <input type="text" class="datepicker form-control" id='dataf2' name='dataf2' placeholder="selecione a data fim..." value='<?php if (!empty($dataf2)) echo $dataf2;?>'>
                                                            <label id="label-for" class="form-label">Data Fim Cad.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-4 col-xl-4">
                                                        <div class="form-line focused">
                                                            <input type="text" class="datepicker form-control" id='horafr' name='horafr' placeholder="selecione a hora fim..." value='<?php if (!empty($horafr)) echo $horafr;?>'>
                                                            <label id="label-for" class="form-label">HF Cad</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select id="tipoMat" class="form-control show-tick"  name="tipoMat" title="Selecione o Tipo da Materia" data-live-search="true">
                                                            <option value="">Todos os Tipos</option>
                                                            <option value="S" <?php if(!empty($tipoMat) and $tipoMat=='S') echo 'selected'; ?>>Internet</option>
                                                            <option value="I" <?php if(!empty($tipoMat) and $tipoMat=='I') echo 'selected'; ?>>Impresso</option>
                                                            <option value="R" <?php if(!empty($tipoMat) and $tipoMat=='R') echo 'selected'; ?>>R&aacute;dio</option>
                                                            <option value="T" <?php if(!empty($tipoMat) and $tipoMat=='T') echo 'selected'; ?>>Televis&atilde;o</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select id="veiculo" class="form-control show-tick"  name="veiculo" title="Selecione o Ve&iacute;culo" data-live-search="true">
                                                            <option value="">Todos os Ve&iacute;culos</option>
                                                            <?php if (!empty($lista_veiculo)) {
                                                                foreach ($lista_veiculo as $item): ?>
                                                                    <option
                                                                        <?php if(!empty($veiculo) and $veiculo==$item['SEQ_VEICULO']) echo 'selected'; ?>
                                                                        value="<?php echo $item['SEQ_VEICULO'] ?>"><?php echo $item['FANTASIA_VEICULO']; ?></option>
                                                                <?php endforeach;
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select id="portal" class="form-control show-tick"  name="portal" title="Selecione o Site" data-live-search="true">
                                                            <option value="">Todos os Sites</option>
                                                            <?php if (!empty($lista_portal)) {
                                                                foreach ($lista_portal as $item): ?>
                                                                    <option
                                                                        <?php if(!empty($portal) and $portal==$item['SEQ_PORTAL']) echo 'selected'; ?>
                                                                        value="<?php echo $item['SEQ_PORTAL'] ?>"><?php echo $item['NOME_PORTAL']; ?></option>
                                                                <?php endforeach;
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select id="radio" class="form-control show-tick"  name="radio" title="Selecione a R&aacute;dio" data-live-search="true">
                                                            <option value="">Todos as R&aacute;dios</option>
                                                            <?php if (!empty($lista_radio)) {
                                                                foreach ($lista_radio as $item): ?>
                                                                    <option
                                                                        <?php if(!empty($radio) and $radio==$item['SEQ_RADIO']) echo 'selected'; ?>
                                                                        value="<?php echo $item['SEQ_RADIO'] ?>"><?php echo $item['NOME_RADIO']; ?></option>
                                                                <?php endforeach;
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                                <div class="col-xs-12 col-md-3 col-xl-3">
                                                    <div class="form-group form-float">
                                                        <div class="form-line">
                                                            <select id="tv" class="form-control show-tick"  name="tv" title="Selecione a Televis&atilde;o" data-live-search="true">
                                                                <option value="">Todos as Televis&otilde;es</option>
                                                                <?php if (!empty($lista_tv)) {
                                                                    foreach ($lista_tv as $item): ?>
                                                                        <option
                                                                            <?php if(!empty($tv) and $tv==$item['SEQ_TV']) echo 'selected'; ?>
                                                                            value="<?php echo $item['SEQ_TV'] ?>"><?php echo $item['NOME_TV']; ?></option>
                                                                    <?php endforeach;
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type='text' class='form-control tag-rela' data-role="tagsinput" id='texto' name='texto' value="<?php if (!empty($texto)) echo $texto;?>"/>
                                                        <label id="label-for" class="form-label">Texto de Tags</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select id="setor" class="form-control show-tick"  name="setor" title="Selecione o Secretaria" data-live-search="true">
                                                            <option value="">Todos as Secretarias</option>
                                                            <?php if (!empty($lista_setor)) {
                                                                foreach ($lista_setor as $item): ?>
                                                                    <option
                                                                        <?php if(!empty($setor) and $setor==$item['SEQ_SETOR']) echo 'selected'; ?>
                                                                        value="<?php echo $item['SEQ_SETOR'] ?>"><?php echo $item['SIG_SETOR'].' - '.$item['DESC_SETOR']; ?></option>
                                                                <?php endforeach;
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select id="tipo" class="form-control show-tick"  name="tipo" title="Selecione a &Aacute;rea" data-live-search="true">
                                                            <option value="">Todos as &Aacute;reas</option>
                                                            <?php if (!empty($lista_tipo)) {
                                                                foreach ($lista_tipo as $item): ?>
                                                                    <option
                                                                        <?php if(!empty($tipo) and $tipo==$item['SEQ_TIPO_MATERIA']) echo 'selected'; ?>
                                                                        value="<?php echo $item['SEQ_TIPO_MATERIA'] ?>"><?php echo $item['DESC_TIPO_MATERIA']; ?></option>
                                                                <?php endforeach;
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <?php
                                                           $arrayOrig =array();
                                                           if(!empty($origens)) {
                                                               $arrayOrig = explode(',',$origens);
                                                           }
                                                        ?>
                                                        <select id="origem" class="form-control show-tick" multiple  name="origem[]" title="Selecione a Origem">
                                                            <option
                                                                <?php if(!empty($origens) and in_array('E',$arrayOrig)) echo 'selected'; ?>
                                                                value="E">Demanda Espont&acirc;nea</option>
                                                            <option
                                                                <?php if(!empty($origens) and in_array('X',$arrayOrig)) echo 'selected'; ?>
                                                                value="X">Mat&eacute;ria Exclusiva</option>
                                                            <option
                                                                <?php if(!empty($origens) and in_array('I',$arrayOrig)) echo 'selected'; ?>
                                                                value="I">Release na &Iacute;ntegra</option>
                                                            <option
                                                                <?php if(!empty($origens) and in_array('P',$arrayOrig)) echo 'selected'; ?>
                                                                value="P">Release Parcial</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <?php
                                                        $arrayAval =array();
                                                        if(!empty($avaliacoes)) {
                                                            $arrayAval = explode(',',$avaliacoes);
                                                        }
                                                        ?>
                                                        <select id="avaliacao" class="form-control show-tick" multiple  name="avaliacao[]" title="Selecione a Avalia&ccedil;&atilde;o">
                                                            <option
                                                                <?php if(!empty($avaliacoes) and in_array('P',$arrayAval)) echo 'selected'; ?>
                                                                value="P">Positivo</option>
                                                            <option
                                                                <?php if(!empty($avaliacoes) and in_array('N',$arrayAval)) echo 'selected'; ?>
                                                                value="N">Negativo</option>
                                                            <option
                                                                <?php if(!empty($avaliacoes) and in_array('T',$arrayAval)) echo 'selected'; ?>
                                                                value="T">Neutro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-line">
                                                    <div class="demo-checkbox">
                                                        <input id="basic_checkbox" type="checkbox" name="stexto"
                                                            <?php if(!empty($stexto) and $stexto=='S') echo 'checked'; ?>
                                                               value="S">&nbsp;
                                                        <label for="basic_checkbox">Somente Texto</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" name="isrelease" id="isrelease" data-size="6">
                                                            <option value="" >Selecione - op&ccedil;&atilde;o do Release</option>
                                                            <option value="S" <?php if(!empty($isrelease) and $isrelease=='S') echo 'selected'; ?>>Com Release</option>
                                                            <option value="N" <?php if(!empty($isrelease) and $isrelease=='N') echo 'selected'; ?>>Sem Release</option>
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="col-xs-12 col-md-12 col-xl-12">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select class="form-control show-tick" name="release" id="release" data-live-search="true" data-size="6">
                                                            <option value="0">Selecione - Release da Mat&eacute;ria</option>
                                                            <?php if (!empty($lista_release)) {
                                                                foreach ($lista_release as $item): ?>
                                                                    <option
                                                                        value="<?php echo $item['SEQ_RELEASE'] ?>" <?php if (!empty($release) and $release==$item['SEQ_RELEASE']) echo 'selected';?>><?php echo $item['DESC_RELEASE']; ?></option>
                                                                <?php endforeach;
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type='text' class='form-control' id='subtitulo' name='subtitulo' value="<?php if (!empty($subtitulo)) echo $subtitulo;?>"/>
                                                        <label id="label-for" class="form-label">Subt&iacute;tulo</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select id="opcRelatorio" class="form-control show-tick"  name="opcRelatorio">
                                                            <option
                                                                <?php if(!empty($opcRelatorio) and $opcRelatorio=='materia') echo 'selected'; ?>
                                                                value="materia">Publica&ccedil;&atilde;o de Mat&eacute;ria</option>
                                                            <option
                                                                <?php if((!empty($opcRelatorio) and $opcRelatorio=='super') or empty($opcRelatorio)) echo 'selected'; ?>
                                                                value="super">Tipo Super/Setor</option>
                                                            <option
                                                                <?php if((!empty($opcRelatorio) and $opcRelatorio=='alerta') or empty($opcRelatorio)) echo 'selected'; ?>
                                                                value="alerta">Tipo Alerta</option>
                                                            <option
                                                                <?php if((!empty($opcRelatorio) and $opcRelatorio=='alertaFile') or empty($opcRelatorio)) echo 'selected'; ?>
                                                                value="alertaFile">Tipo Alerta em Arquivo</option>
                                                            <option
                                                                <?php if((!empty($opcRelatorio) and $opcRelatorio=='alertaFileText') or empty($opcRelatorio)) echo 'selected'; ?>
                                                                value="alertaFileText">Tipo Alerta em Arquivo com Texto</option>
                                                            <option
                                                                <?php if((!empty($opcRelatorio) and $opcRelatorio=='alertaFileTextWord') or empty($opcRelatorio)) echo ''; ?>
                                                                value="alertaFileTextWord">Tipo Alerta em Arquivo com Texto (Word)</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line focused">
                                                        <select class="form-control show-tick" name="grupo" id="grupo" data-live-search="true" data-size="6">
                                                            <option value="0">Selecione - Grupo de Monitoramento</option>
                                                            <?php if (!empty($lista_grupo)) {
                                                                foreach ($lista_grupo as $item): ?>
                                                                    <option
                                                                        value="<?php echo $item['SEQ_GRUPO_VEICULO'] ?>" <?php if (!empty($grupo) and $grupo==$item['SEQ_GRUPO_VEICULO']) echo 'selected';?>><?php echo $item['DESC_GRUPO_VEICULO']; ?></option>
                                                                <?php endforeach;
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <select id="usuario" class="form-control show-tick"  name="usuario" title="Selecione o Usu&aacute;rio" data-live-search="true">
                                                            <option value="">Todos os Usu&aacute;rios</option>
                                                            <?php if (!empty($lista_usuario)) {
                                                                foreach ($lista_usuario as $item): ?>
                                                                    <option
                                                                        <?php if(!empty($usuario) and $usuario==$item['SEQ_USUARIO']) echo 'selected'; ?>
                                                                        value="<?php echo $item['SEQ_USUARIO'] ?>"><?php echo $item['NOME_USUARIO']; ?></option>
                                                                <?php endforeach;
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <button type="submit" onclick="$('#acao').val('pesquisar');" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Executar">
                                                    <i class="material-icons">search</i>
                                                </button>
                                                <button type="button" onclick="$('#email-div').show();" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Enviar por Email">
                                                    <i class="material-icons">email</i>
                                                </button>
                                            </div>
                                            <div class="row clearfix" id="email-div" style="display: none">
                                                    <div class="col-xs-12 col-md-12 col-xl-12" >
                                                        <div class="col-xs-12 col-md-12 col-xl-12">
                                                            <h4>Preparar Email</h4>
                                                        </div>
                                                        <div class="col-xs-12 col-md-12 col-xl-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" id='emailTo' name='emailTo''>
                                                                    <label id="label-for" class="form-label">Destinat&aacute;rio <span style="color:red">*</span></label>
                                                                </div>
                                                                <small class="text-red">Informar os email separados por (;)</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-md-12 col-xl-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <input type="text" class=" form-control" id='assunto' name='assunto''>
                                                                    <label id="label-for" class="form-label">Assunto <span style="color:red">*</span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-md-12 col-xl-12">
                                                            <div class="form-group form-float">
                                                                <div class="form-line">
                                                                    <textarea rows="3" id="mensagem" name="mensagem" class="form-control no-resize auto-growth" ></textarea>
                                                                    <label id="label-for" class="form-label">Mensagem <span style="color:red">*</span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-md-12 col-xl-12">
                                                            <button type="button" onclick="$('#email-div').hide();" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                                                <i class="material-icons">cancel</i>
                                                            </button>
                                                            <button type="submit" onclick="$('#acao').val('enviar');" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Enviar">
                                                                <i class="material-icons">send</i>
                                                            </button>

                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        </form>
                                    <?php if (!empty($lista_materia) and count($lista_materia)>0) { ?>
                                        <div class="row clearfix">
                                            <div class="col-xs-12 col-md-12 col-xl-12">
                                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                                    <thead>
                                                    <tr>
                                                        <th >C&oacute;digo</th>
                                                        <th>Tipo</th>
                                                        <th>Nome do Ve&iacute;culo</th>
                                                        <th>Publica&ccedil;&atilde;o</th>
                                                        <th>&Aacute;rea da Mat&eacute;ria</th>
                                                        <th>A&ccedil;&atilde;o</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php if (!empty($lista_materia)) {
                                                        foreach ($lista_materia as $item): ?>
                                                            <tr>
                                                                <td><?php echo $item['SEQ_MATERIA'] ?></td>
                                                                <td><?php if(!empty($item['SEQ_VEICULO'])) echo 'Impresso'; else if(!empty($item['SEQ_PORTAL'])) echo 'Internet';else if(!empty($item['SEQ_RADIO'])) echo 'R�dio';   ?></td>
                                                                <td><?php if(!empty($item['SEQ_VEICULO']))
                                                                        echo $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row()->FANTASIA_VEICULO;
                                                                    else if(!empty($item['SEQ_PORTAL'])) echo $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row()->NOME_PORTAL;
                                                                    else if(!empty($item['SEQ_RADIO'])) echo $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row()->NOME_RADIO;
                                                                    ?></td>
                                                                <td><?php echo date('d/m/Y',strtotime($item['DATA_MATERIA_PUB'])); ?></td>
                                                                <td><?php if (!empty($item['SEQ_TIPO_MATERIA'])) echo $this->ComumModelo->getTableData('TIPO_MATERIA', array('SEQ_TIPO_MATERIA' =>  $item['SEQ_TIPO_MATERIA']))->row()->DESC_TIPO_MATERIA; ?></td>
                                                                <td data-title="A��o">
                                                                    <div class='avoid-this action-buttons'>
                                                                        <?php if ($this->auth->CheckMenu('geral', 'materia', 'editar') == 1) { ?>
                                                                            <a data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                                                                               href="<?php echo base_url('materia/editar/') . $item['SEQ_MATERIA'] ?>">
                                                                                <i class="material-icons">edit</i>
                                                                            </a>&nbsp;&nbsp;
                                                                        <?php }?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach;
                                                    } ?>
                                                    </tbody>
                                                    <tfoot class="hidden-sm hidden-xs">
                                                    <tr>
                                                        <th >C&oacute;digo</th>
                                                        <th>Tipo</th>
                                                        <th>Nome do Ve&iacute;culo</th>
                                                        <th>Publica&ccedil;&atilde;o</th>
                                                        <th>&Aacute;rea da Mat&eacute;ria</th>
                                                        <th>A&ccedil;&atilde;o</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                    </div>
                                    <?php } ?>
                                </div>
                              </div>
                           </div>
                        </div>
     
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="header">Geração de Link de Mídias</div>
                                    <div class="body">
                                        <?php echo form_open(base_url('gerarelatoriolink'), array('role' => 'form', 'id' => 'formPadrao2', 'class' => 'Formulario2')); ?>
                                        <div class="row">
                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Período</p>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="datepicker form-control" id='dataInicio' name='datainicio' placeholder="Data de Inicio" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" class="datepicker form-control" id='dataFim' name='datafim' placeholder="Data de Fim" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-3 col-xl-3">
                                                <select class="form-control show-tick" name="veiculo" title="Selecione o veículo">
                                                    <option value="R" selected="">Rádio</option>
                                                    <option value="T">Televisão</option>
                                                    <option value="I">Impresso</option>
                                                </select>
                                            </div>    
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-1 col-xl-3">
                                                <button type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Gerar Documento"><i class="material-icons" style="color:white;">send</i></button>
                                            </div>
                                        </div>
                                        <?php echo form_close() ?>
                                    </div> 
                                </div>
                            </div>    
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="2">
                        <?php echo $this->load->view('modulos/relatorio/consultar-link'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="3">
                        <?php echo $this->load->view('modulos/relatorio/consultar-setor'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="4">
                        <?php echo $this->load->view('modulos/relatorio/consultar-geral'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="6">
                        <?php echo $this->load->view('modulos/relatorio/consultar-release'); ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="5">
                        <?php echo $this->load->view('modulos/relatorio/consultar-veiculo'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function IsEmail(mail){
        var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
        if (typeof(mail) == "string") {
            if (er.test(mail)) {
                return true;
            }
        } else if (typeof(mail) == "object") {
            if (er.test(mail.value)) {
                return true;
            }
        } else {
            return false;
        }
    };
    $(function () {
         $('#dataf').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#datai').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        }).on('change', function(e, date)
        {
            $('#dataf').bootstrapMaterialDatePicker('setMinDate', date);
        });
        $('#dataf2').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#datai2').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        }).on('change', function(e, date)
        {
            $('#dataf2').bootstrapMaterialDatePicker('setMinDate', date);
        });
        $('#horafr').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: true,
            date:false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $('#horair').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: true,
            date:false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
        $.validator.addMethod("validaTo", function(value) {
            var listEmailTo = value;
            var arrayTo = listEmailTo.split(';');
            if (listEmailTo.length==0) {
                return false;
            }else{
                var arrayTo = listEmailTo.split(';');
                for (var i = 0; i < arrayTo.length; i++) {
                    if (!IsEmail(arrayTo[i].trim())) {
                        return false;
                    }
                    ;
                }
            }
            return true;
        }, 'Lista de Destinat&aacute;rios Inv&aacute;lida!');
        $('#formPadrao').validate({
            rules: {
                'datai': {required: true},
                'dataf': {required: true},
                'assunto': {required: true},
                'mensagem': {required: true},
                'emailTo': 'validaTo'
            },
            messages:{
                'datai': {
                    required: 'Data In&iacute;cio &eacute; Obrigat&oacute;rio'
                },
                'dataf': {
                    required: 'Data Fim &eacute; Obrigat&oacute;rio'
                },
                'assunto': {
                    required: 'Assunto &eacute; Obrigat&oacute;rio'
                },
                'mensagem': {
                    required: 'Mensagem &eacute; obrigat&oacute;riio!'
                },
                'emailTo': {
                    required: 'Destinat�rios &eacute; obrigat&oacute;riio!'
                }
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataInicio').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang: 'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText: 'Cancelar'
        });
        $('#dataFim').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang: 'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText: 'Cancelar'
        });
        
    });
</script>
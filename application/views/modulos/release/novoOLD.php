<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">add</i> Cadastro</h2>
        <small>Release</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li>
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li><a href="<?php echo base_url('release') ?>" class="ajax-link-interno">
                    <i class="material-icons">layers</i>Release</a></li>
            <li class="active">Cadastro</li>
        </ol>
    </div>
</div>

<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <div class="row clearfix">
                <div class="col-xs-12 col-md-8 col-xl-8">
                    <h3 class="box-title">Dados da Release</h3>
                </div>
            </div>
        </div><!-- /.box-header -->
        <div class="body">
            <?php echo form_open(base_url('release/salvar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
            <div class="masked-input">
                <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-xl-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <textarea rows="4" class="form-control no-resize auto-growth" maxlength="500" id='descricaoRelease' name='descricaoRelease'></textarea>
                                    <label id="label-for" class="form-label">Descrição <span style="color:red">*</span></label>
                                </div>
                            </div>
                        </div>
                    <div class="col-xs-12 col-md-6 col-xl-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control show-tick"
                                    name="setor[]" multiple=""
                                        id="setor" data-live-search="true" data-size="5">
                                    <option value="">Selecione - Setor</option>
                                    <?php if (!empty($lista_setor)) {
                                        foreach ($lista_setor as $item): ?>
                                            <option
                                                value="<?php echo $item['SEQ_SETOR'] ?>" <?php if (!empty($setor) and in_array($item['SEQ_SETOR'],explode(',',$setor))) echo 'selected';?>><?php echo $item['DESC_SETOR'].'('.$item['SIG_SETOR'].')'; ?></option>
                                        <?php endforeach;
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                        <div class="col-xs-12 col-md-3 col-xl-3">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="text" class="datepicker form-control" id='dataEnvio' name='dataEnvio' placeholder="selecione a data..."  value='<?php if (!empty($dataEnvio)) echo date('d/m/Y',strtotime($dataEnvio));?>'>
                                    <label id="label-for" class="form-label">Data Envio <span style="color:red">*</span></label>
                                </div>
                            </div>
                        </div>
                    <div class="col-xs-3 col-md-3 col-xl-3">
                        <div class="form-line">
                            <div class="demo-checkbox">
                                <input id="basic_checkbox" type="checkbox" name="pauta"
                                    <?php if(!empty($pauta) and $pauta=='S') echo 'checked'; ?>
                                       value="S">&nbsp;
                                <label for="basic_checkbox">Sugest&atilde;o de pauta?</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                    <div class="col-xs-12 col-md-3 col-xl-3">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control show-tick" id="tipo" data-live-search="true" data-size="5"
                                    name="tipo">
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
                    <div class="col-xs-12 col-md-3 col-xl-3">
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
                    <div class="col-xs-12 col-md-6 col-xl-6">
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
                    <div class="col-xs-12 col-md-12 col-xl-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <textarea rows="15" id="texto" name="texto" class="form-control no-resize auto-growth" ><?php if (!empty($texto)) echo $texto;?></textarea>
                                <label id="label-for" class="form-label">Resumo/Texto <span style="color:red">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 col-xl-12">
                        <div class="form-group form-float">
                            <div class="form-line focused">
                                <input type="text" class="form-control palavra" id="palavra" name="palavra" data-role="tagsinput" value="<?php if (!empty($palavra)) echo $palavra;?>">
                                <label id="label-for" class="form-label">Palavras-Chaves <span style="color:red">*</span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-xl-12">
                    <input type='hidden' id='longitude' name='longitude'/>
                    <input type='hidden' id='latitude' name='latitude'/>
                    <a href="<?php echo base_url('release') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                        <i class="material-icons">cancel</i>
                    </a>
                    <button type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Salvar">
                        <i class="material-icons">save</i>
                    </button>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
<script type="text/javascript">



    $(function () {

        $('#formPadrao').validate({
            rules: {
                'descricaoRelease': {required: true},
                'dataEnvio': {required: true},
                'setor': {required: true},
                'titulo': {required: true},
                'tipo': {required: true},
                'avaliacao': {required: true},
                'texto': {required: true},
                'classificacao': {required: true},
                'palavra': {required: true},
            },
            messages:{
                'descricaoRelease': {
                    required: 'Descrição é Obrigatório'
                },
                'dataEnvio': {
                    required: 'Data do Envio é obrigatóriio!'
                },
                'setor': {
                    required: 'Setoro é obrigatóriio!'
                },
                'titulo': {
                    required: 'Título do Release é obrigatório!',
                },
                'tipo': {
                    required: 'Área do Release é obrigatório!'
                },
                'avaliacao': {required: 'Avaliação do Release é obrigatório!'},
                'texto': {required: 'Resumo/Texto do Release é obrigatório!'},
                'classificacao': {required: 'Origem do Release é obrigatório!'},
                'palavra': {required: 'Palavras chaves do Release é obrigatório!'},
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
        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });
    });
</script>
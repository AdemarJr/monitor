<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">add</i> Cadastro</h2>
        <small>Setor</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li>
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li><a href="<?php echo base_url('departamento') ?>" class="ajax-link-interno">
                    <i class="material-icons">view_comfy</i>Setor</a></li>
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
                    <h3 class="box-title">Dados do Setor</h3>
                </div>
            </div>
        </div><!-- /.box-header -->
        <div class="body">
            <?php echo form_open(base_url('setor/salvar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
            <div class="masked-input">
                <div class="row clearfix">
                    <div class="col-xs-12 col-md-3 col-xl-3">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input class="form-control no-resize auto-growth" maxlength="50" id='siglaSetor' name='siglaSetor' required />
                                <label id="label-for" class="form-label">Sigla <span style="color:red">*</span></label>
                            </div>
                        </div>
                    </div>
                        <div class="col-xs-12 col-md-9 col-xl-9">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type='text' class='form-control' id='descricaoTipomateria' name='descricaoSetor' maxlength="150" required />
                                    <label id="label-for" class="form-label">Descrição <span style="color:red">*</span></label>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="row clearfix">
                    <div class="col-xs-8 col-md-8 col-xl-8">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control show-tick" name="categoria" id="categoria">
                                    <option value="0" >Seleciona a Categoria</option>
                                    <?php if (!empty($lista_categoria)) {
                                        foreach ($lista_categoria as $item): ?>
                                            <option
                                                value="<?php echo $item['SEQ_CATEGORIA'] ?>" ><?php echo $item['DESC_CATEGORIA']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-md-4 col-xl-4">
                        <div class="form-line">
                            <div class="demo-checkbox">
                                <input id="indEstr" type="checkbox" name="indEstr"
                                       value="S" />&nbsp;
                                <label for="indEstr">Este Setor &eacute; estrat&eacute;gico?</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-xl-12">
                    <input type='hidden' id='longitude' name='longitude'/>
                    <input type='hidden' id='latitude' name='latitude'/>
                    <a href="<?php echo base_url('setor') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                'descricaoSetor': {required: true},
                'siglaSetor': {required: true}
            },
            messages:{
                'descricaoSetor': {
                    required: 'Descrição do Setor é Obrigatório'
                },
                'siglaSetor': {
                    required: 'Sigla do Setor é obrigatóriio!'
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
<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">edit</i> Cadastrar/Alterar</h2>
        <small>Pre&ccedil;os</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li>
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li><a href="<?php echo base_url('veiculo/consultaPreco/'.$tipoMat.'/'.!empty($idChave)?$idChave:'') ?>" class="ajax-link-interno">
                    <i class="material-icons">attach_money</i>Pre&ccedil;o</a></li>
            <li class="active">Alterar</li>
        </ol>
    </div>
</div>

<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <div class="row clearfix">
                <div class="col-xs-12 col-md-8 col-xl-8">
                    <h3 class="box-title">Dados do Pre&ccedil;o</h3>
                </div>
            </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php echo form_open(base_url('veiculo/alterarPreco'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="masked-input">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='hidden'id='idPreco' name='idPreco' value='<?php if (!empty($idPreco)) echo $idPreco;?>'/>
                                            <input type='hidden'id='idChave' name='idChave' value='<?php if (!empty($idChave)) echo $idChave;?>'/>
                                            <input type='hidden'id='tipoMat' name='tipoMat' value='<?php if (!empty($tipoMat)) echo $tipoMat;?>'/>
                                            <input type='text' class='form-control' id='descricao' name='descricao' maxlength="50" required value="<?php if (!empty($descricao)) echo $descricao;?>"/>
                                            <label id="label-for" class="form-label">Descri&ccedil;&atilde;o <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control number-mask2' id='segundo' name='segundo' value="<?php if (!empty($segundo)) echo $segundo;?>"/>
                                            <label id="label-for" class="form-label">Segundo <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control number-mask' id='valor' name='valor' value="<?php if (!empty($valor)) echo $valor;?>"/>
                                            <label id="label-for" class="form-label">Valor <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-xl-12">
                            <a href="<?php echo base_url('veiculo/consultaPreco/'.$tipoMat.'/'.$idChave) ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
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
          </div><!-- /.row -->
        </section><!-- /.content -->
<script type="text/javascript">


    $(function () {


        $('#formPadrao').validate({
            rules: {
                'descricao': {required: true},
                'valor': {required: true}
            },
            messages:{
                'descricao': {
                    required: 'Descrição é obrigatóriio!'
                },
                'valor': {required: 'Valor é obrigatóriio!'}
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
        var $maskedInput = $('.masked-input');
        $maskedInput.find('.number-mask').inputmask('numeric',{rightAlign: true, prefix: '',groupSeparator: ","});
        $maskedInput.find('.number-mask2').inputmask('numeric',{rightAlign: true, prefix: ''});
    });
</script>
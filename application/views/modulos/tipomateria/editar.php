<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">add</i> Alterar</h2>
        <small>Áreas da Matéria</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li>
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li><a href="<?php echo base_url('tipomateria') ?>" class="ajax-link-interno">
                    <i class="material-icons">layers</i>Áreas da Matéria</a></li>
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
                    <h3 class="box-title">Dados da Área da Matéria</h3>
                </div>
            </div>
        </div><!-- /.box-header -->
        <div class="body">
            <?php echo form_open(base_url('tipomateria/alterar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
            <div class="masked-input">
                <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-xl-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type='hidden'id='idTipomateria' name='idTipomateria' value='<?php if (!empty($idTipomateria)) echo $idTipomateria;?>'/>
                                    <input type='text' class='form-control' id='descricaoTipomateria' name='descricaoTipomateria' maxlength="50" value="<?php if (!empty($descricaoTipomateria)) echo $descricaoTipomateria;?>"/>
                                    <label id="label-for" class="form-label">Descrição <span style="color:red">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-12 col-xl-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <textarea rows="4" class="form-control no-resize auto-growth" maxlength="2000" id='sinteseTipomateria' name='sinteseTipomateria'><?php if (!empty($sinteseTipomateria)) echo $sinteseTipomateria;?></textarea>
                                    <label id="label-for" class="form-label">Síntese Global <span style="color:red">*</span></label>
                                </div>
                            </div>
                        </div>
                       <?php 
                    $this->db->where('SEQ_TIPO_MATERIA', $idTipomateria);
                    $set = $this->db->get('TIPO_MATERIA')->row_array();
                    ?>
                    <div class="col-xs-12 col-md-12 col-xl-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <select class="form-control show-tick" name="situacao" id="situacao">
                                    <option value="S" <?php echo ($set['IND_ATIVO'] == 'S' ? 'selected' : '') ?>>ATIVO</option>
                                    <option value="N" <?php echo ($set['IND_ATIVO'] == 'N' ? 'selected' : '') ?>>INATIVO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-xl-12">
                    <input type='hidden' id='longitude' name='longitude'/>
                    <input type='hidden' id='latitude' name='latitude'/>
                    <a href="<?php echo base_url('tipomateria') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                'descricaoTipomateria': {required: true},
                'sinteseTipomateria': {required: true}
            },
            messages:{
                'descricaoTipomateria': {
                    required: 'Descrição é Obrigatório'
                },
                'sinteseTipomateria': {
                    required: 'Síntese Global é obrigatóriio!'
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
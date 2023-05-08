<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">email</i>Email</h2>
        <small>Enviar recibo do Pagamento em Caixa Aprovado por email</small>
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
            <li class="active">Email</li>
        </ol>
    </div>
</div>

<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <div class="row clearfix">
                <div class="col-xs-12 col-md-8 col-xl-8">
                    <h3 class="box-title">Dados do Mat&eacute;ria</h3>
                </div>
                <div class="col-xs-12 col-md-4 col-xl-4">
                    <div class="image align-right">
                        <img id="logo-veiculo" src="<?php if (!empty($logo_veiculo)) echo $logo_veiculo;?>" width="48" height="48">
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="box box-solid">
                        <div class="box-body no-padding">
                            <div class="list-group">
                                <a href="javascript:void(0);" class="list-group-item">
                                    <?php if (!empty($veiculo)) { ?>
                                    <span class="badge bg-pink"><?php if (!empty($veiculo)) echo $this->ComumModelo->getVeiculo($veiculo)->row()->NOME_VEICULO;?></span> Ve&iacute;culo
                                    <?php } else if (!empty($portal)) {?>
                                        <span class="badge bg-pink"><?php if (!empty($portal)) echo $this->ComumModelo->getPortal($portal)->row()->NOME_PORTAL;?></span> Site
                                    <?php } else if (!empty($radio)) {?>
                                        <span class="badge bg-pink"><?php if (!empty($radio)) echo $this->ComumModelo->getRadio($radio)->row()->NOME_RADIO;?></span> R&aacute;dio
                                    <?php }?>
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-cyan"><?php if(!empty($data)) echo date('d/m/Y',strtotime($data));?></span> Data da Pub.
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <?php if (!empty($tipoMateria) and $tipoMateria!='R') { ?>
                                        <span class="badge bg-teal"><?php if(!empty($editorial)) echo $editorial;?></span> Editoria
                                    <?php } else if (!empty($tipoMateria) and $tipoMateria=='R') { ?>
                                        <span class="badge bg-teal"><?php if(!empty($programa)) echo $programa;?></span> Programa
                                    <?php }?>
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <?php if (!empty($tipoMateria) and $tipoMateria!='R') { ?>
                                        <span class="badge bg-orange"><?php if(!empty($autor)) echo $autor;?></span> Autor
                                    <?php } else if (!empty($tipoMateria) and $tipoMateria=='R') { ?>
                                        <span class="badge bg-orange"><?php if(!empty($apresentador)) echo $apresentador;?></span> Apresentador
                                    <?php }?>
                                </a>
                                <a href="javascript:void(0);" class="list-group-item">
                                    <span class="badge bg-purple"><?php echo $this->ComumModelo->getSetor($setor)->row()->SIG_SETOR; ?></span> Setor
                                </a>
                            </div>
                        </div>
                    <!-- /.box-body -->
                    </div>
                <!-- /. box -->
                </div>
                <!-- /.col -->
                <div class="col-md-8">
                        <div class="box-header with-border">
                            <h3 class="box-title">Preparar Email</h3>
                        </div>
                        <?php echo form_open(base_url('materia/enviarEmail'), array('role' => 'form', 'id' => 'form-novo-email')); ?>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <input type="hidden" value="<?php if (!empty($idMateria)) echo $idMateria ?>" name="idMateria">
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
                        </div>

                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-xl-12">
                            <a href="<?php echo base_url('materia') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                <i class="material-icons">cancel</i>
                            </a>
                            <button type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Enviar">
                                <i class="material-icons">send</i>
                            </button>
                        </div>
                    </div>
                        <!-- /.box-footer -->
                        </form>
                    </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
        </div>
    <!-- /.row -->
</div>
<script>
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
        $.validator.addMethod("validaTo", function(value) {
            var listEmailTo = value;
            var arrayTo = listEmailTo.split(';');


            if (listEmailTo.length==0) {
//                alert('A Lista de Emails destinatArio nAo pode ser vazio - Dados incluido na empresa com o perfil de faturamento direto!');
                return false;
            }else{
                var arrayTo = listEmailTo.split(';');
                for (var i = 0; i < arrayTo.length; i++) {
                    if (!IsEmail(arrayTo[i].trim())) {
//                        alert('O email "' + arrayTo[i].trim() + '" esta invalido, favor verificar os dados. ');
                        return false;
                    }
                    ;
                }
            }
            return true;

          //  return isCpfCnpj(value);
        }, 'Lista de Destinat&aacute;rios Inv&aacute;lida!');

        $('#form-novo-email').validate({
            rules: {
                'assunto': {required: true},
                'mensagem': {required: true},
                'emailTo': 'validaTo'
            },
            messages:{
                'assunto': {
                    required: 'Assunto &eacute; Obrigat&oacute;rio'
                },
                'mensagem': {
                    required: 'Mensagem &eacute; obrigat&oacute;riio!'
                },
                'emailTo': {
                    required: 'Destinatários &eacute; obrigat&oacute;riio!'
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
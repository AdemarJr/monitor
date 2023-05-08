<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">edit</i> Alterar</h2>
        <small>R&aacute;dio</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li>
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li><a href="<?php echo base_url('veiculo/consultas') ?>" class="ajax-link-interno">
                    <i class="material-icons">fiber_new</i>R&aacute;dio</a></li>
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
                    <h3 class="box-title">Dados da R&aacute;dio</h3>
                </div>
                <div class="col-xs-12 col-md-4 col-xl-4">
                    <div class="image align-right">
                        <img id="avatar-prev" src="<?php if(!empty($imagem64)) echo $imagem64; else echo base_url('assets/images/user.png');?>" width="48" height="48" style="border-radius: 50%">
                    </div>
                </div>
            </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php echo form_open(base_url('veiculo/alterarRadio'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="masked-input">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-8 col-xl-8">
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='hidden'id='idVeiculo' name='idVeiculo' value='<?php if (!empty($idVeiculo)) echo $idVeiculo;?>'/>
                                            <input type='text' class='form-control' id='nomeVeiculo' name='nomeVeiculo' maxlength="50" required value="<?php if (!empty($nomeVeiculo)) echo $nomeVeiculo;?>"/>
                                            <label id="label-for" class="form-label">Nome <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="100" id='cidade' name='cidade' value="<?php if (!empty($cidade)) echo $cidade;?>"/>
                                            <label id="label-for" class="form-label">Cidade <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='siteVeiculo' name='siteVeiculo' value="<?php if (!empty($siteVeiculo)) echo $siteVeiculo;?>"/>
                                            <label id="label-for" class="form-label">Home Page</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                    <label id="label-for" class="form-label">Logo</label>

                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <label class="btn bg-purple btn-circle waves-effect waves-circle waves-float" type="button"  data-toggle="tooltip" data-placement="top" title="Carregar Imagem">
                                        <input type="file" name="image" id="image" class="upload" accept="image/gif, image/jpg, image/png, image/jpeg" />
                                        <i class="material-icons">add_a_photo</i>
                                    </label>&nbsp;&nbsp;
                                    <input type="hidden" id="imagem64" name="imagem64" />
                                    <button class="btn bg-indigo btn-circle waves-effect waves-circle waves-float upload-result" type="button"  data-toggle="tooltip" data-placement="top" title="Cortar Imagem"><i class="material-icons">crop</i></button>
                                </div>
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="col-xs-12 col-md-12 col-xl-12 upload-demo-wrap">
                                        <div id="upload-demo" class="upload-demo"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-xl-12">
                            <a href="<?php echo base_url('veiculo/consultar') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
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

    function initUpload() {
        var $uploadCrop;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('complete');
                    });
                }

                reader.readAsDataURL(input.files[0]);

                $('.upload-demo-wrap').prop('style','display:block !important');
            }
            else {
                swal("Seu Navegador não tem suporte a esta API");
            }
        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 150,
                height: 150,
                type: 'square'
            },
            enableExif: true
        });

        $('.upload-demo-wrap').prop('style','display:none !important');

        $('#image').on('change', function () { readFile(this); });

        $('.upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                size: 'viewport'
            }).then(function (resp) {
                $('#imagem64').val(resp);
                showNotification('bg-light-green', 'Imagem cortada com sucesso!', 'top', 'center', '', '');
                $('#avatar-prev').attr('src', resp);
            });
        });
    };

    function isUrlValid(url) {
        if (url.length==0) return true;
        return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
    };

    $(function () {

        initUpload();

        $.validator.addMethod("validaURL", function(value) {
            return isUrlValid(value);
        }, 'URL Inválida"!');
        $('#formPadrao').validate({
            rules: {
                'nomeVeiculo': {required: true},
                'siteVeiculo': 'validaURL',
                'cidade': {required: true}
            },
            messages:{
                'nomeVeiculo': {
                    required: 'Nome do R&aacute;dio é obrigatóriio!'
                },
                'cidade': {required: 'Cidade é obrigatóriio!'}
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
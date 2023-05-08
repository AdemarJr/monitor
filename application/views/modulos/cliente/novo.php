<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">add</i> Cadastro</h2>
        <small>Cliente</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li>
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li><a href="<?php echo base_url('cliente') ?>" class="ajax-link-interno">
                    <i class="material-icons">contacts</i>Cliente</a></li>
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
                    <h3 class="box-title">Dados do Cliente</h3>
                </div>
                <div class="col-xs-12 col-md-4 col-xl-4">
                    <div class="image align-right">
                        <img id="avatar-prev" src="<?php echo base_url('assets/images/user.png');?>" width="48" height="48">
                    </div>
                </div>
            </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php echo form_open(base_url('cliente/salvar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="masked-input">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-8 col-xl-8">
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='nomeCliente' name='nomeCliente' maxlength="50" required/>
                                            <label id="label-for" class="form-label">Nome <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='empresaCliente' name='empresaCliente' maxlength="50"/>
                                            <label id="label-for" class="form-label">Empresa/Órgão/Instituição <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                        <div class="demo-radio-button">
                                            <input name="tipoPessoa" type="radio" id="tipoPessoaF" checked  value="F"/>
                                            <label for="tipoPessoaF">Física</label>
                                            <input name="tipoPessoa" type="radio" id="tipoPessoaJ"  value="J"/>
                                            <label for="tipoPessoaJ">Jurídica</label>
                                        </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control input-qtd cnpj-mask' id='cpfcnpjCliente' name='cpfcnpjCliente'/>
                                            <label id="label-for" class="form-label">CPF/CNPJ <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control email-mask' id='emailCliente' name='emailCliente' required/>
                                            <label id="label-for" class="form-label">E-mail <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='profissaoCliente' name='profissaoCliente'/>
                                            <label id="label-for" class="form-label">Profissão <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control phone-mask' maxlength="15" id='foneCliente' name='foneCliente' required/>
                                            <label id="label-for" class="form-label">Telefone <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 col-xl-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='logoEmpresa' name='logoEmpresa' maxlength="50" required/>
                                            <label id="label-for" class="form-label">Nome Arquivo Empresa <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-8 col-xl-8" id="div-monitoramento">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select id="monitoramentos" class="form-control show-tick" name="monitoramento[]" 
                                            title="Selecione os Monitoramentos">
                                                <?php if (!empty($lista_monitoramento)) {
                                                    foreach ($lista_monitoramento as $item): ?>
                                                        <option <?php if (!empty($monitoramento) and in_array($item['SEQ_MONITORAMENTO'],explode(',',$monitoramento))) echo 'selected';?>
                                                            value="<?php echo $item['SEQ_MONITORAMENTO'] ?>"><?php echo $item['NOME_MONITORAMENTO']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                    <label id="label-for" class="form-label">Foto</label>

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
                        <h4 class="box-title">Endereço do Cliente</h4>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="200" id='pesquisa' name='pesquisa'/>
                                            <label id="label-for" class="form-label">Pesquisa</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="200" id='logradouro' name='logradouro' required/>
                                            <label id="label-for" class="form-label">Logradouro <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="15" id='numero' name='numero' required/>
                                            <label id="label-for" class="form-label">Número <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="50" id='complemento' name='complemento'/>
                                            <label id="label-for" class="form-label">Complemento</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="15" id='uf' name='uf' required/>
                                            <label id="label-for" class="form-label">UF <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="20" id='bairro' name='bairro'/>
                                            <label id="label-for" class="form-label">Bairro <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="100" id='cidade' name='cidade'/>
                                            <label id="label-for" class="form-label">Cidade <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control cep-mask' maxlength="100" id='cep' name='cep'/>
                                            <label id="label-for" class="form-label">CEP <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="15" id='pais' name='pais'/>
                                            <label id="label-for" class="form-label">País <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div id="mapa" class="gmap"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-xl-12">
                        	<input type='hidden' id='longitude' name='longitude'/>
                            <input type='hidden' id='latitude' name='latitude'/>
                            <a href="<?php echo base_url('cliente') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
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
                height: 60,
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


    $(function () {

        initUpload();

        $.validator.addMethod("validaCNPJ", function(value) {
            return isCpfCnpj(value);
        }, 'CPF Inválido"!');
        $('#formPadrao').validate({
            rules: {
                'empresaCliente': {required: true},
                'nomeCliente': {required: true},
                'fantasiaCliente': {required: true},
                'cpfcnpjCliente': 'validaCNPJ',
                'emailCliente': {required: true, email:true},
                'profissaoCliente': {required: true},
                'logradouro': {required: true},
                'numero': {required: true},
                'uf': {required: true},
                'bairro': {required: true},
                'cidade': {required: true},
                'cep': {required: true},
                'pais': {required: true},
                'foneCliente': {required: true},
            },
            messages:{
                'empresaCliente': {
                    required: 'Empresa/Órgão/Instituição do Cliente é Obrigatório'
                },
                'cnpjCliente': {
                    required: 'CPF/CNPJ do Cliente é obrigatóriio!'
                },
                'emailCliente': {
                    required: 'Email do Cliente é obrigatóriio!',
                    email:'Email Inválido!',
                    remote:'Email já cadastrado!'
                },
                'profissaoCliente': {
                    required: 'Profissão do Cliente é obrigatóriio!'
                },
                'nomeCliente': {
                    required: 'Nome do Cliente é obrigatóriio!'
                },
                'foneCliente': {
                    required: 'Telefone do usuário é obrigatóriio!'
                },
                'logradouro': {required: 'Logradouep do usuário é obrigatóriio!'},
                'numero': {required: 'Número é obrigatóriio!'},
                'uf': {required: 'UF é obrigatóriio!'},
                'bairro': {required: 'Bairro é obrigatóriio!'},
                'cidade': {required: 'Cidade é obrigatóriio!'},
                'cep': {required: 'CEP é obrigatóriio!'},
                'pais': {required: 'País é obrigatóriio!'},
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
        $maskedInput.find('.cnpj-mask').inputmask('999.999.999-99', { placeholder: '___.___.___-__' });
        $maskedInput.find('.email-mask').inputmask({ alias: "email" });
        $maskedInput.find('.phone-mask').inputmask('(99)99999-9999', { placeholder: '(__)_____-____' });
        $maskedInput.find('.cep-mask').inputmask('99.999-999', { placeholder: '__.___-___' });

        $('input[type=radio][name=tipoPessoa]').change(function(){
            var opcao = $(this).val();
            if (opcao==="F"){
                $maskedInput.find('.cnpj-mask').inputmask('999.999.999-99', { placeholder: '___.___.___-__' });
            } else{
                $maskedInput.find('.cnpj-mask').inputmask('99.999.999/9999-99', { placeholder: '__.___.___/____-__' });
            }
        });

    });
</script>
<script src="<?php echo base_url().'assets/js/mapa.js'?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl7EfJf58qTH8IjaVOJX94l19A6z2kXwI&libraries=places&callback=initAutocomplete"></script>
<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">edit</i> Alterar</h2>
        <small>Perfil</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li>
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li><a href="<?php echo base_url('usuario') ?>" class="ajax-link-interno">
                    <i class="material-icons">person</i>Usuário</a></li>
            <li class="active">Perfil</li>
        </ol>
    </div>
</div>

<!-- Main content -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <div class="row clearfix">
                <div class="col-xs-12 col-md-8 col-xl-8">
                    <h3 class="box-title">Dados do Usuário</h3>
                </div>
                <div class="col-xs-12 col-md-4 col-xl-4">
                    <div class="image align-right">
                        <img id="avatar-prev" src="<?php if(!empty($avatar)) echo $avatar; else echo base_url('assets/images/user.png');?>" width="48" height="48" style="border-radius: 50%">
                    </div>
                </div>
            </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php if (!empty($perfilUsuario) and $perfilUsuario!='ROLE_CLI') echo form_open(base_url('principal/alterarPerfil'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="masked-input">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-8 col-xl-8">

                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <span class='form-control'>
                                            <?php if (!empty($cpfUsuario)) echo $cpfUsuario;?>
                                            </span>
                                            <label id="label-for" class="form-label">CPF</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type='hidden'id='idUsuario' name='idUsuario' value='<?php if (!empty($idUsuario)) echo $idUsuario;?>'/>
                                            <span type='text' class='form-control'>
                                            <?php if (!empty($loginUsuario)) echo $loginUsuario;?>
                                            </span>
                                            <label id="label-for" class="form-label">Login</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='nomeUsuario' name='nomeUsuario' maxlength="50" value="<?php if (!empty($nomeUsuario)) echo $nomeUsuario;?>" <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">Nome <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control email-mask' id='emailUsuario' name='emailUsuario' value="<?php if (!empty($emailUsuario)) echo $emailUsuario;?>" <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">E-mail <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control phone-mask' maxlength="15" id='foneUsuario' name='foneUsuario' value="<?php if (!empty($foneUsuario)) echo $foneUsuario;?>" <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">Telefone <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($perfilUsuario) and $perfilUsuario!='ROLE_CLI') {?>
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                    <label id="label-for" class="form-label">Avatar</label>

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
                            <?php } ?>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12" id="div-clientes">
                                <h5>Clientes que Represento</h5>
                                <div class="form-group form-float">
                                    <div class="form-line focused">
                                            <?php if (!empty($lista_cliente)) {
                                                foreach ($lista_cliente as $item):
                                                    if (!empty($cliente) and in_array($item['SEQ_CLIENTE'],explode(',',$cliente)))
                                                        echo $item['NOME_CLIENTE'].'<br/>';
                                                endforeach;
                                            } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="box-title">Endereço</h4>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <?php if (!empty($perfilUsuario) and $perfilUsuario!='ROLE_CLI') { ?>
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="200" id='pesquisa' name='pesquisa' />
                                            <label id="label-for" class="form-label">Pesquisa</label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="200" id='logradouro' name='logradouro' value="<?php if (!empty($logradouro)) echo $logradouro;?>"  <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">Logradouro <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="15" id='numero' name='numero' value="<?php if (!empty($numero)) echo $numero;?>"  <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">Número <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="50" id='complemento' name='complemento' value="<?php if (!empty($complemento)) echo $complemento;?>"  <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">Complemento</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-2 col-xl-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="15" id='uf' name='uf' value="<?php if (!empty($uf)) echo $uf;?>"  <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">UF <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="20" id='bairro' name='bairro' value="<?php if (!empty($bairro)) echo $bairro;?>"  <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">Bairro <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="100" id='cidade' name='cidade' value="<?php if (!empty($cidade)) echo $cidade;?>"  <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">Cidade <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control cep-mask' maxlength="100" id='cep' name='cep' value="<?php if (!empty($cep)) echo $cep;?>"  <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
                                            <label id="label-for" class="form-label">CEP <span style="color:red">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' maxlength="15" id='pais' name='pais' value="<?php if (!empty($pais)) echo $pais;?>"  <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_CLI') echo 'disabled';?>/>
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
                        	<input type='hidden' id='longitude' name='longitude' value="<?php if (!empty($longitude)) echo $longitude;?>"/>
                            <input type='hidden' id='latitude' name='latitude' value="<?php if (!empty($latitude)) echo $latitude;?>"/>
                            <a href="<?php echo base_url('inicio') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                <i class="material-icons">cancel</i>
                            </a>
                            <?php if (!empty($perfilUsuario) and $perfilUsuario!='ROLE_CLI') { ?>
                            <button type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Salvar">
                                <i class="material-icons">save</i>
                            </button>
                            <?php } ?>
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
                width: 100,
                height: 100,
                type: 'circle'
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

        $.validator.addMethod("validaCPF", function(value) {
            return isCpfCnpj(value);
        }, 'CPF Inválido"!');
        $('#formPadrao').validate({
            rules: {
                'loginUsuario': {required: true},
                'cliente': {required: true},
                'cliente[]': {required: true},
                'cpfUsuario': 'validaCPF',
                'emailUsuario': {required: true, email:true},
                'nomeUsuario': {required: true},
                'logradouro': {required: true},
                'numero': {required: true},
                'uf': {required: true},
                'bairro': {required: true},
                'cidade': {required: true},
                'cep': {required: true},
                'pais': {required: true},
                'perfilUsuario': {required: true},
                'foneUsuario': {required: true}
            },
            messages:{
                'loginUsuario': {
                    required: 'Login do usuário é Obrigatório',
                    remote:'Login em uso!'
                },
                'cliente': {
                    required: 'Cliente do Usuário é obrigatóriio!'
                },
                'cliente[]': {
                    required: 'Clientes do usuário é obrigatóriio!'
                },
                'cpfUsuario': {
                    required: 'CPF do usuário é obrigatóriio!'
                },
                'emailUsuario': {
                    required: 'Email do usuário é obrigatóriio!',
                    email:'Email Inválido!',
                    remote:'Email já cadastrado!'
                },
                'nomeUsuario': {
                    required: 'Nome do usuário é obrigatóriio!'
                },
                'perfilUsuario': {
                    required: 'Perfil do usuário é obrigatóriio!'
                },
                'foneUsuario': {
                    required: 'Telefone do usuário é obrigatóriio!'
                },
                'logradouro': {required: 'Logradouro do usuário é obrigatóriio!'},
                'numero': {required: 'Número é obrigatóriio!'},
                'uf': {required: 'UF é obrigatóriio!'},
                'bairro': {required: 'Bairro é obrigatóriio!'},
                'cidade': {required: 'Cidade é obrigatóriio!'},
                'cep': {required: 'CEP é obrigatóriio!'},
                'pais': {required: 'País é obrigatóriio!'}
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
        $maskedInput.find('.email-mask').inputmask({ alias: "email" });
        $maskedInput.find('.phone-mask').inputmask('(99)99999-9999', { placeholder: '(__)_____-____' });
        $maskedInput.find('.cep-mask').inputmask('99.999-999', { placeholder: '__.___-___' });
    });
</script>
<script src="<?php echo base_url().'assets/js/mapa.js'?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl7EfJf58qTH8IjaVOJX94l19A6z2kXwI&libraries=places&callback=initAutocomplete"></script>
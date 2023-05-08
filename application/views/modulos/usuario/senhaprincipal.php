<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">security</i> Alterar Senha</h2>
        <small>Usuário</small>
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
            <li class="active">Alterar Senha</li>
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
            </div>
        </div>
        <div class="body">
            <?php echo form_open(base_url('principal/alterarSenha'),array('role' => 'form', 'id' => 'formPadrao')); ?>
            <div class="masked-input">
                     <div class="row clearfix">
                         <div class="col-xs-12 col-md-6 col-xl-6">
                             <div class="form-group form-float">
                                 <div class="form-line focused">
                                     <input type='hidden' id='idUsuario' name='idUsuario' value='<?php if (!empty($idUsuario)) echo $idUsuario;?>'/>
                                     <input type='hidden' id='loginUsuario' name='loginUsuario' value='<?php if (!empty($loginUsuario)) echo $loginUsuario;?>'/>
                                     <span type='text' class='form-control'>
                                            <?php if (!empty($loginUsuario)) echo $loginUsuario;?>
                                            </span>
                                     <label id="label-for" class="form-label">Login</label>
                                 </div>
                             </div>
                         </div>
                         <div class="col-xs-12 col-md-6 col-xl-6">
                             <div class="form-group form-float">
                                 <div class="form-line focused">
                                     <span type='text' class='form-control'>
                                            <?php if (!empty($nomeUsuario)) echo $nomeUsuario;?>
                                            </span>
                                     <label id="label-for" class="form-label">Nome</label>
                                 </div>
                             </div>
                         </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type='password' class='form-control' id='senhaUsuario' name='senhaUsuario' maxlength="15"/>
                                    <label id="label-for" class="form-label">Senha <span style="color:red">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-xl-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type='password' class='form-control' id='senha2Usuario' name='senha2Usuario' maxlength="15"/>
                                    <label id="label-for" class="form-label">Confirmar Senha <span style="color:red">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-12 col-md-12 col-xl-12">
                            <input type='hidden' id='formJson' name='formJson'/>
                            <?php if ($perfilUsuario=='ROLE_ADM'){?>
                                <a href="<?php echo base_url('usuario'); ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                    <i class="material-icons">cancel</i></a>
                            <?php } else {?>
                                <a href="<?php echo base_url('inicio'); ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"  data-toggle="tooltip" data-placement="top" title="Cancelar">
                                    <i class="material-icons">cancel</i></a>
                            <?php }?>
                            <?php if ($this->auth->CheckMenu('geral','usuario', 'alterarSenha')==1) {?>
                                <button class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" type="submit" data-toggle="tooltip" data-placement="top" title="Salvar">
                                    <i class="material-icons">save</i></button>
                            <?php }?>
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
                'senhaUsuario': {required: true},
                'senha2Usuario': {required: true, equalTo: "#senhaUsuario"},
            },
            messages:{
                'senhaUsuario': {
                    required: 'Senha é Obrigatório',
                },
                'senha2Usuario': {
                    required: 'Confirmação da Senha é obrigatóriio!',
                    equalTo:'Confirmação da Senha deve ser idêntica a Senha!!'
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
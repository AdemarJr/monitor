    <div class="login-box">
        <div class="logo">
        <?php 
            $colorBtn = 'bg-pink';
            if ($_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO1 and $_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO2
            and $_SERVER['SERVER_NAME']!=SERVER_NAME_ELEICAO3) { ?>
            <img class="img-" src="<?php echo base_url().'assets/images/porto-azul.png' ?>" alt="">
            <a href="javascript:void(0);">Moni<b>TOR</b></a>
            <small>clipando os acontecimentos</small>
        <?php } else if (SETOR_ELEICAO=='1') { $colorBtn = 'bg-blue-grey'; ?>
            <div class="row-center-content">
                <img src="<?php echo base_url().'assets/images/avante.png' ?>" alt="">
            </div>
        <?php } else { $colorBtn = 'bg-blue-grey'; ?>
            <div class="row-center-content">
                <img src="<?php echo base_url().'assets/images/eleicao2020.png' ?>" alt="">
            </div>
            <!-- <a href="javascript:void(0);" class="col-black">Eleições 2020</b></a> -->
            <!-- <small class="col-black">clipando os acontecimentos</small> -->
        <?php } ?>
            
        </div>
        <div class="card">
            <div class="body">

                <?php echo form_open(NULL,array('role' => 'form', 'id' => 'formPadrao')); ?>
                    <div class="msg">Informe os dados para iniciar a sess&atilde;o</div>
                <p class="login-box-msg"></p>
                <?php echo validation_errors(); ?>
                <?php
                if(isset($errorAutenticacao)){
                    echo "<p class='col-pink'>".$errorAutenticacao."</p>";
                }
                ?>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="login" name="login" class="form-control" placeholder="Login" required autofocus/>
                                <input type="hidden" name="target"value="<?php echo $this->input->get('target');?>"/>
                            </div>
                            </div>
                    </div>
                    <div class="input-group input-group-lg">
                            <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-8 p-t-5">
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block <?php echo $colorBtn; ?> waves-effect" type="submit">Entrar</button>
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
                    'login': {required: true},
                    'senha': {required: true}
                },
                messages:{
                    'login': {
                        required: 'Informar Usuário!'
                    },
                    'senha': {
                        required: 'Informar Senha!'
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

<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">add</i> Replica Ve&iacute;culos</h2>
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
            </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php echo form_open(base_url('cliente/replicar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label>Origem</label>
                                            <select class="form-control show-tick" name="oCliente" id="oCliente" data-live-search="true">
                                                <?php if (!empty($lista_cliente)) {
                                                    foreach ($lista_cliente as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_CLIENTE'] ?>" <?php if (!empty($this->session->userdata('idClienteSessao')) and $this->session->userdata('idClienteSessao')==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label>Destino</label>
                                            <select class="form-control show-tick" name="dCliente" id="dCliente" data-live-search="true">
                                                <?php if (!empty($lista_cliente)) {
                                                    foreach ($lista_cliente as $item):
                                                        if ( $item['IND_REPLICA']=='N'  ){
                                                        ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_CLIENTE'] ?>" <?php if (!empty($this->session->userdata('idClienteSessao')) and $this->session->userdata('idClienteSessao')==$item['SEQ_CLIENTE']) echo 'selected';?>><?php echo $item['NOME_CLIENTE']; ?></option>
                                                    <?php } endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-xs-12 col-md-12 col-xl-12">
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
</div>
<script type="text/javascript">
    $(function () {
        $.validator.addMethod("notEqualTo", function(v, e, p) {
            return this.optional(e) || v != $(p).val();
        }, "Please specify a different value");

        $('#formPadrao').validate({
            rules: {
                'oCliente': {required: true},
                'dCliente': {required: true, notEqualTo: "#oCliente"}
            },
            messages:{
                'oCliente': {
                    required: 'Cliente de Origem é Obrigatório'
                },
                'dCliente': {
                    required: 'Cliente de Destino é obrigatóriio!',
                    notEqualTo:'Cliente de Origem e Destino Não podem se iguais!!'
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
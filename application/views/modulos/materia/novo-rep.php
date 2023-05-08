<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">add</i> Cadastro</h2>
        <small>Matéria</small>
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
                    <h3 class="box-title">Dados do Matéria</h3>
                </div>
                <div class="col-xs-12 col-md-4 col-xl-4">
                    <div class="image align-right">
                        <img id="logo-veiculo"  width="48" height="48">
                    </div>
                </div>
            </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php echo form_open_multipart(base_url('materia/salvar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="masked-input">
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="hidden" name="tipoMat" id="tipoMat" value="<?php echo $tipoMateria;?>"/>
                                        <?php if($tipoMateria == 'S') { ?>
                                            <select class="form-control show-tick" name="portal" id="portal" data-live-search="true">
                                                <option value="">Selecione - Site</option>
                                                <?php if (!empty($lista_veiculo)) {
                                                    foreach ($lista_veiculo as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_PORTAL'] ?>"><?php echo $item['NOME_PORTAL']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>

                                        <?php } else { ?>
                                        <select class="form-control show-tick" name="veiculo" id="veiculo" data-live-search="true">
                                            <option value="">Selecione - Veículo</option>
                                            <?php if (!empty($lista_veiculo)) {
                                                foreach ($lista_veiculo as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_VEICULO'] ?>"><?php echo $item['FANTASIA_VEICULO']; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                    <div class="form-group form-float">
                                        <div class="form-line focused">
                                            <input type="text" class="datepicker form-control" id='data' name='data' placeholder="selecione a data...">
                                            <label id="label-for" class="form-label">Data Publicação</label>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='pagina' name='pagina'/>
                                        <label id="label-for" class="form-label">Página</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='editorial' name='editorial'/>
                                        <label id="label-for" class="form-label">Editoria</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='autor' name='autor'/>
                                        <label id="label-for" class="form-label">Autor da Matéria</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='destaque' name='destaque'/>
                                        <label id="label-for" class="form-label">Destaque</label>
                                    </div>
                                </div>
                            </div>
                            <?php if($tipoMateria == 'S') { ?>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='link' name='link'/>
                                        <label id="label-for" class="form-label">URL</label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea rows="2" id="titulo" name="titulo" class="form-control no-resize auto-growth" ></textarea>
                                            <label id="label-for" class="form-label">Título da Matéria</label>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="8" id="texto" name="texto" class="form-control no-resize auto-growth"></textarea>
                                        <label id="label-for" class="form-label">Observação da Matéria</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="box-title">Anexos</h4>
                        <div class="row clearfix">
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <label class="btn bg-purple btn-circle waves-effect waves-circle waves-float" type="button"  data-toggle="tooltip" data-placement="top" title="Carregar Imagens">
                                        <input multiple id="image" name="images[]" class="upload"  type="file" accept="image/gif, image/jpg, image/png, image/jpeg" />
                                        <i class="material-icons">insert_drive_file</i>
                                    </label>
                                    <div id =""></div>
                                </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div id="up_images" class="list-unstyled">

                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <a href="<?php echo base_url('materia') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                    <i class="material-icons">cancel</i>
                                </a>
                                <button type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Salvar">
                                    <i class="material-icons">save</i>
                                </button>
                            </div>
                        </div>
                    </div>
                  </form>
               </div>
    </div>
</div><!-- /.row -->
<script type="text/javascript">
    function removeImage(id){

        $('#'+id).remove();
    };
    function initUpload() {
//        var $uploadCrop;

        function readFile(input) {

            $('#up_images').empty();
            var number = 0;
            $.each(input.files, function(value) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var id = (new Date).getTime();
                    number++;
                    $('#up_images').append('<div id="'+id+'" class="col-lg-3 col-md-4 col-sm-6 col-xs-12"><button onclick="removeImage(\''+id+'\');" type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float"><i class="material-icons">delete</i></button><a target="_blank" href="'+e.target.result+'"><img class="img-responsive thumbnail" src="'+e.target.result+'"></a></div>');
                };
                reader.readAsDataURL(input.files[value]);
            });
        }
        $('#image').on('change', function () {
            readFile(this);
        });
    };

    $(function () {

        initUpload();

        $('#formPadrao').validate({
            rules: {
                'veiculo': {required: true},
                'portal': {required: true},
//                'titulo': {required: true},
//                'texto': {required: true},
//                'pagina': {required: true},
//                'autor': {required: true},
//                'data': {required: true}
            },
            messages:{
                'veiculo': {
                    required: 'Veículo da Matéria é Obrigatório'
                },
                'portal': {
                    required: 'Site da Matéria é Obrigatório'
                },
//                'titulo': {
//                    required: 'Título da Matéria é obrigatóriio!',
//                    email:'Email Inválido!',
//                    remote:'Email já cadastrado!'
//                },
//                'texto': {
//                    required: 'Observação da Matéria é obrigatóriio!'
//                },
//                'pagina': {
//                    required: 'Página da Matéria é obrigatóriio!'
//                },
//                'autor': {required: 'Autor da Matéria é obrigatóriio!'},
//                'data': {required: 'Data da publicação da Matéria é obrigatóriio!'}
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
        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang:'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText:'Cancelar'
        });

        $('#up_images').lightGallery({
            thumbnail: true,
            selector: 'img'
        });

        $('#veiculo').on('change',function(){
            var item = $(this).val();
            if (item.length>0) {
                $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/veiculo/carregaLogo/' + item,
                    type: 'GET',
                    success: function (data) {
                        $('#logo-veiculo').attr('src', data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Ocorreu Algum Problema, não foi possível alterar!');
                        console.log(errorThrown);
                    },
                    dataType: "text",
                    async: false
                });
            } else {
                $('#logo-veiculo').attr('src', '');
            }
        });
        $('#portal').on('change',function(){
            var item = $(this).val();
            if (item.length>0) {
                $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: '/veiculo/carregaLogoPortal/' + item,
                    type: 'GET',
                    success: function (data) {
                        $('#logo-veiculo').attr('src', data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Ocorreu Algum Problema, não foi possível alterar!');
                        console.log(errorThrown);
                    },
                    dataType: "text",
                    async: false
                });
            } else {
                $('#logo-veiculo').attr('src', '');
            }
        });
    });
</script>
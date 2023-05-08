<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">edit</i> Alterar</h2>
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
                    <h3 class="box-title">Dados do Matéria</h3>
                </div>
                <div class="col-xs-12 col-md-4 col-xl-4">
                    <div class="image align-right">
                        <img id="logo-veiculo" <?php if (!empty($logo_veiculo)) echo 'src="'.$logo_veiculo.'"';?> width="48" height="48">
                    </div>
                </div>
            </div>
        </div><!-- /.box-header -->
                <div class="body">
                    <?php echo form_open_multipart(base_url('materia/alterar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
                    <div class="masked-input">
                        <div class="row clearfix">
                            <input type='hidden'id='idMateria' name='idMateria' value='<?php if (!empty($idMateria)) echo $idMateria;?>'/>
                            <div class="col-xs-12 col-md-6 col-xl-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="hidden" name="tipoMat" id="tipoMat" value="<?php echo $tipoMateria;?>"/>
                                        <input type="hidden" name="acao" id="acao"/>
                                        <?php if($tipoMateria == 'S') { ?>
                                            <select class="form-control show-tick" name="portal" id="portal" data-live-search="true">
                                                <option value="">Selecione - Site</option>
                                                <?php if (!empty($lista_veiculo)) {
                                                    foreach ($lista_veiculo as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_PORTAL'] ?>" <?php if (!empty($portal) and $portal==$item['SEQ_PORTAL']) echo 'selected';?>><?php echo $item['NOME_PORTAL']; ?></option>
                                                    <?php endforeach;
                                                } ?>
                                            </select>
                                        <?php } else if($tipoMateria == 'I') { ?>
                                        <select class="form-control show-tick" name="veiculo" id="veiculo" data-live-search="true">
                                            <option value="">Selecione - Veículo</option>
                                            <?php if (!empty($lista_veiculo)) {
                                                foreach ($lista_veiculo as $item): ?>
                                                    <option
                                                        value="<?php echo $item['SEQ_VEICULO'] ?>" <?php if (!empty($veiculo) and $veiculo==$item['SEQ_VEICULO']) echo 'selected';?>><?php echo $item['FANTASIA_VEICULO']; ?></option>
                                                <?php endforeach;
                                            } ?>
                                        </select>
                                        <?php } else if($tipoMateria == 'R') { ?>
                                            <select class="form-control show-tick" name="radio" id="radio" data-live-search="true">
                                                <option value="">Selecione - R&aacute;dio</option>
                                                <?php if (!empty($lista_veiculo)) {
                                                    foreach ($lista_veiculo as $item): ?>
                                                        <option
                                                            value="<?php echo $item['SEQ_RADIO'] ?>" <?php if (!empty($veiculo) and $veiculo==$item['SEQ_RADIO']) echo 'selected';?>><?php echo $item['NOME_RADIO']; ?></option>
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
                                            <input type="text" class="datepicker form-control" id='data' name='data' placeholder="selecione a data..."  value='<?php if (!empty($data)) echo date('d/m/Y',strtotime($data));?>'>
                                            <label id="label-for" class="form-label">Data Publicação </label>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-xs-12 col-md-3 col-xl-3">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='pagina' name='pagina' value="<?php if (!empty($pagina)) echo $pagina;?>"/>
                                        <label id="label-for" class="form-label">Página</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='editorial' name='editorial' value="<?php if (!empty($editorial)) echo $editorial;?>"/>
                                        <label id="label-for" class="form-label">Editoria</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='autor' name='autor' value="<?php if (!empty($autor)) echo $autor;?>"/>
                                        <label id="label-for" class="form-label">Autor da Matéria</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 col-xl-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type='text' class='form-control' id='destaque' name='destaque' value="<?php if (!empty($destaque)) echo $destaque;?>"/>
                                        <label id="label-for" class="form-label">Destaque</label>
                                    </div>
                                </div>
                            </div>
                            <?php if($tipoMateria == 'S') { ?>
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type='text' class='form-control' id='link' name='link' value="<?php if (!empty($link)) echo $link;?>"/>
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
                                            <textarea rows="2" id="titulo" name="titulo" class="form-control no-resize auto-growth" ><?php if (!empty($titulo)) echo $titulo;?></textarea>
                                            <label id="label-for" class="form-label">Título da Matéria</label>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <textarea rows="8" id="texto" name="texto" class="form-control no-resize auto-growth" ><?php if (!empty($texto)) echo $texto;?></textarea>
                                        <label id="label-for" class="form-label">Observação da Matéria</label>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <a name="imagens"></a>
                        <h4 class="box-title">Anexos</h4>
                        <div class="row clearfix">
                                <div class="col-xs-12 col-md-12 col-xl-12">
                                    <label class="btn bg-purple btn-circle waves-effect waves-circle waves-float" type="button"  data-toggle="tooltip" data-placement="top" title="Carregar Imagens">
                                        <input multiple id="image" name="images[]" class="upload"  type="file" accept="image/gif, image/jpg, image/png, image/jpeg" />
                                        <i class="material-icons">insert_drive_file</i>
                                    </label>
                                </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <div id="up_images" class="list-unstyled">
                                    <?php if (!empty($lista_anexo)) {
                                        foreach ($lista_anexo as $item): ?>
                                            <div id="<?php echo $item['SEQ_ANEXO'] ?>" class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                <button data-toggle="tooltip" data-placement="top" title="Excluir Imagem" class='btn bg-red btn-circle waves-effect waves-circle waves-float botao-excluir'
                                                        data-url="<?php echo base_url('materia/deleteanexo/') . $item['SEQ_MATERIA'].'/'.$item['SEQ_ANEXO'] ?>">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                <?php if($tipoMateria != 'R') { ?>
                                                    <a href="<?php echo base_url('materia/imagem/').$item['SEQ_ANEXO'] ?>">
                                                        <img class="img-responsive thumbnail" src="<?php echo base_url('materia/imagem/').$item['SEQ_ANEXO'] ?>">
                                                    </a>
                                                    <div class="form-line">
                                                        <input class='form-control ordem-change' type="number" id="imgOdem" name="imgOrdem" data-anexo="<?php echo $item['SEQ_ANEXO']; ?>" data-old="<?php echo $item['ORDEM_ARQUIVO']; ?>" value="<?php echo $item['ORDEM_ARQUIVO']; ?>"/>
                                                        <label id="label-for" class="form-label">Ordem da Imagem</label>
                                                    </div>
                                                <?php } else { ?>
                                                    <div style=" display:inline-block;border: 1px solid;">
                                                        <audio src="<?php echo base_url('materia/audio/').$item['SEQ_ANEXO'] ?>" controls >
                                                            <p>Seu navegador não suporta o elemento audio </p>
                                                        </audio>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php endforeach;
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-md-12 col-xl-12">
                                <a href="<?php echo base_url('materia') ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                    <i class="material-icons">cancel</i>
                                </a>
                                <button type="submit" onclick="$('#acao').val('S');" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Salvar">
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

    function initUpload() {

        $('#image').on('change', function () {
           // readFile(this);
            $('#acao').val('I');
            document.getElementById("formPadrao").submit();
        });
        $('.ordem-change').blur(function () {
            var valorNovo = $(this).val();
            valorNovo = valorNovo.length>0?valorNovo:0;
            var valorAntigo = $(this).data('old');
            var seqAnexo = $(this).data('anexo');
            if(valorNovo!=valorAntigo){
                $.ajax({
                    mimeType: 'text/html; charset=utf-8',
                    url: '/materia/ordenar/'+ seqAnexo+'/'+valorNovo,
                    type: 'GET',
                    success: function(data) {
                        window.location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        window.location.reload();
                    },
                    dataType: "html",
                    async: false
                });
            }
        });
    };

    $(function () {

        initUpload();

        $.validator.addMethod('validaTag', function (value, element) {
                return value.match(/^\d\d\d\d?-\d\d?-\d\d$/);
            },
            'Please enter a date in the format YYYY-MM-DD.'
        );

        $.validator.addMethod('validaLink', function (value, element) {
                return value.match(/^\d\d\d\d?-\d\d?-\d\d$/);
            },
            'Please enter a date in the format YYYY-MM-DD.'
        );

        $('#formPadrao').validate({
            rules: {
                'veiculo': {required: true},
                'portal': {required: true},
                'radio': {required: true},
                'link': {
                    remote: {
                        data:{'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' },
                        type: "POST",
                        url: '/materia/existeLink/'+$('#idMateria').val(),
                        dataFilter: function(response) {
                            return response==='sucesso';
                        }
                    }
                },
            },
            messages:{
                'link': {
                    remote:'Link já cadastrado em outra matéria!',
                },
                'veiculo': {
                    required: 'Veículo da Matéria é Obrigatório'
                },
                'portal': {
                    required: 'Site da Matéria é Obrigatório'
                },
                'radio': {
                    required: 'Rádio da Matéria é Obrigatório'
                },
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
        $('.botao-excluir').click(function(){
            showConfirmMessage('Você tem certeza?','Confirmando você excluirá esta Imagem da matéria.',$(this));
            return false;
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
            selector: 'a'
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
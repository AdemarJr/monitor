<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">playlist_add_check</i> Permiss&otilde;es</h2>
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
            <li class="active">Permiss&otilde;es</li>
        </ol>
    </div>
</div>
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
            <?php if (!empty($perfilUsuario) and $perfilUsuario!='ROLE_CLI') echo form_open(base_url('usuario/perfilSalvar'),array('role' => 'form', 'id' => 'form-novo-usu')); ?>
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
                            <input type='hidden' id='idUsuario' name='idUsuario' value='<?php if (!empty($idUsuario)) echo $idUsuario;?>'/>
                            <input type='hidden' id='loginUsuario' name='loginUsuario' value='<?php if (!empty($loginUsuario)) echo $loginUsuario;?>'/>
                                     <span type='text' class='form-control'>
                                            <?php if (!empty($nomeUsuario)) echo $nomeUsuario;?>
                                            </span>
                            <label id="label-for" class="form-label">Nome</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix hidden-sm hidden-xs">
                 <?php if (!empty($perfis)) { foreach($perfis as $itemm):
                     if (count($permissoes)>0 and in_array($itemm['SEQ_PERFIL'],$permissoes)){
                         ?>
                         <div class="col-xs-12 col-md-3 col-xl-3">
                             <small class="badge bg-teal"><?php echo $itemm['DESC_MODULO'].' - '.$itemm['DESC_PERFIL'];?></small>
                         </div>
                     <?php }
                 endforeach; } ?>

            </div>

             <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="card">
                         <div class="header">
                             <h2>Lista de Módulos
                             <small>Clique no nome do módulo para abrir ou fechar.</small>
                             </h2>
                         </div>
                         <!-- /.box-header -->
                         <div class="body">
                             <div class="row clearfix">
                                 <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                     <div class="panel-group" id="accordion_19" role="tablist" aria-multiselectable="true">
                                         <?php if (!empty($sistemas)) {
                                         $i=0;
                                         foreach($sistemas as $item):
                                         $i++;?>
                                             <div class="panel panel-primary">
                                                 <div class="panel-heading" role="tab" id="headingOne_<?php echo $i; ?>">
                                                     <h4 class="panel-title">
                                                         <a role="button" data-toggle="collapse" href="#collapseOne_<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne_<?php echo $i; ?>">
                                                             <i class="material-icons">perm_contact_calendar</i> <?php echo ucfirst($item['MOD_METODO']);?>
                                                         </a>
                                                     </h4>
                                                 </div>
                                                 <div id="collapseOne_<?php echo $i; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_<?php echo $i; ?>">
                                                     <div class="panel-body">
                                                         <?php if (!empty($perfis)) {
                                                          $j = $i*1000;
                                                         foreach($perfis as $itemm):
                                                             if ($item['MOD_METODO']==$itemm['DESC_MODULO']){
                                                                 ?>
                                                                 <div class="col-xs-4">
                                                                     <div class="form-line">
                                                                         <div class="demo-checkbox">
                                                                         <input id="basic_checkbox_<?php echo $j; ?>" type="checkbox" name="perfis[]" value="<?php echo $itemm['SEQ_PERFIL'];?>" <?php if(count($permissoes)>0 and in_array($itemm['SEQ_PERFIL'],$permissoes)  ) echo 'checked';?>>&nbsp;
                                                                             <label for="basic_checkbox_<?php echo $j; ?>"><?php echo $itemm['DESC_PERFIL'];?></label>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             <?php } $j++;
                                                         endforeach; } ?>
                                                     </div>
                                                 </div>
                                             </div>
                                         <?php endforeach; } ?>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <!-- /.box-body -->
                     </div>
                 <!-- /.box -->
                 </div>
             </div>
                        <div class="box-footer">
                            <a href="<?php echo base_url('usuario'); ?>" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                <i class="material-icons">cancel</i></a>
                            <?php if (!empty($perfilUsuario) and $perfilUsuario!='ROLE_CLI'){  ?>
                            <button class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float" type="submit" data-toggle="tooltip" data-placement="top" title="Salvar">
                                <i class="material-icons">save</i></button>
                            <?php } ?>
                  		</div>
                  </form>
                </div>
               </div>
              </div>
          </div><!-- /.row -->
        </section><!-- /.content -->
<script type="text/javascript">
//	$(function () {
//		$("#form-novo-usu").on('success.form.bv',function(event){
//			//event.preventDefault();
//			$.blockUI({ message: '<img src="<?php //echo base_url('assets/imagens/loading.gif'); ?>//" />' });
//
//		});
//	});
</script>        
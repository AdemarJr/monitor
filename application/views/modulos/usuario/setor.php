<div class="block-header inline">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">list</i> Setores</h2>
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
            <li class="active">Setores do Usuário</li>
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
            <?php if (!empty($perfilUsuario) and $perfilUsuario=='ROLE_SET')
                echo form_open(base_url('usuario/setorSalvar'),array('role' => 'form', 'id' => 'form-novo-usu')); ?>
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
            <div class="row clearfix hidden-sm hidden-xs">
                 <?php
                 $setores = $this->ComumModelo->listaSetor()->result_array();
                 $checkSetor = explode(',',$setorUsuario);
                 if (!empty($setorUsuario)) {
                     if (!empty($setores)) {
                         foreach ($setores as $itemm):
                             if(count($checkSetor)>0 and in_array($itemm['SEQ_SETOR'],$checkSetor)  ) {
                             ?>
                             <div class="col-xs-12 col-md-3 col-xl-3">
                                 <small class="badge bg-teal"><?php echo $itemm['DESC_SETOR'] . '(' . $itemm['SIG_SETOR'] . ')';?></small>
                             </div>
                             <?php }
                         endforeach;
                     }
                 }
                 ?>


            </div>

             <div class="row clearfix">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div class="card">
                         <div class="header">
                             <h2>Lista de Clientes/Setor
                             <small>Clique no nome do Cliente para abrir ou fechar.</small>
                             </h2>
                         </div>
                         <!-- /.box-header -->
                         <div class="body">
                             <div class="row clearfix">
                                 <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                                     <div class="panel-group" id="accordion_19" role="tablist" aria-multiselectable="true">
                                         <?php if (!empty($clientes)) {
                                         $i=0;
                                         foreach($clientes as $item):
                                         $i++;?>
                                             <div class="panel panel-primary">
                                                 <div class="panel-heading" role="tab" id="headingOne_<?php echo $i; ?>">
                                                     <h4 class="panel-title">
                                                         <a role="button" data-toggle="collapse" href="#collapseOne_<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne_<?php echo $i; ?>">
                                                             <i class="material-icons">reorder</i> <?php echo ucfirst($item['NOME_CLIENTE']);?>
                                                         </a>
                                                     </h4>
                                                 </div>
                                                 <div id="collapseOne_<?php echo $i; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_<?php echo $i; ?>">
                                                     <div class="panel-body">
                                                         <?php
                                                         $setores = $this->ComumModelo->getSetorCliente($item['SEQ_CLIENTE'])->result_array();
                                                         if (!empty($setores)) {
                                                          $j = $i*1000;
                                                         foreach($setores as $itemm):
                                                                 ?>
                                                                 <div class="col-xs-12">
                                                                     <div class="form-line">
                                                                         <div class="demo-checkbox">
                                                                            <input id="basic_checkbox_<?php echo $j; ?>" type="radio" name="setor" value="<?php echo $itemm['SEQ_SETOR'];?>" <?php if(count($checkSetor)>0 and in_array($itemm['SEQ_SETOR'],$checkSetor)  ) echo 'checked';?>/>&nbsp;
                                                                            <label for="basic_checkbox_<?php echo $j; ?>"><?php echo $itemm['DESC_SETOR'].'('.$itemm['SIG_SETOR'].')';?></label>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             <?php  $j++;
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
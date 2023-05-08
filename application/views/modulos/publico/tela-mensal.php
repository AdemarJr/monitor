<div class="card">
    <div class="header">
        <div class="block-header inline">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ol class="breadcrumb breadcrumb-bg- align-left">
                    <li>
                        <a href="<?php echo base_url($this->uri->segment(1)) ?>">
                            <i class="material-icons">home</i> Publica&ccedil;&otilde;es
                        </a>
                    </li>
                    <li class="active">
                        <i class="material-icons"><?php echo ($this->session->userdata('tipoSessao')=='R')?'radio':(($this->session->userdata('tipoSessao')=='S')?'public':'description');?></i>
                        <?php echo (($this->session->userdata('tipoSessao')=='R')?'R&aacute;dio':(($this->session->userdata('tipoSessao')=='S')?'Sites e Blogs':'Jornal Impresso')).' - '.$this->session->userdata('anoSessao');?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="row clearfix">
            <?php
             $corMes = array('','red','indigo','purple','deep-purple','pink','blue','light-blue','cyan','teal','green','light-green','lime');
            if (!empty($lista_meses)) {
            foreach ($lista_meses as $item): ?>
                <div class="col-md-2">
                    <div class="card nopadding sub-n3" data-mes="<?php echo $item['NUM_MES']; ?>" >
                        <div class="header nopadding">
                            <div class="info-box-2 bg-<?php echo $corMes[$item['NUM_MES']]; ?> hover-expand-effect nopadding">
                                <div class="icon">
                                    <i class="material-icons">event</i>
                                </div>
                                <div class="content">
                                    <div class="text"><?php echo descricaoMes($item['NUM_MES']); ?></div>
                                    <div class="number count-to" data-from="0" data-to="<?php echo $item['QTD'] ?>" data-speed="15" data-fresh-interval="20"><?php echo $item['QTD'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;  } ?>
        </div>
    </div>
</div>
<?php echo form_open(base_url($this->uri->segment(1).'/detalhar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
<input type="hidden" name="mes" id="mes">
<input type="hidden" name="anteNivel" value="mensal">
<input type="hidden" name="proxNivel" value="diario">
</form>
<script type="text/javascript">
    $(function () {
        $('.sub-n3').click(function(){
            $('#mes').val($(this).data('mes'));
            $('#formPadrao').submit();
        });
    });
</script>
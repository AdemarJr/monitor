
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
                </ol>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="row clearfix">
            <div class="col-md-4"></div>
            <?php if (!empty($lista_radio)) { ?>
            <div class="col-md-4">
                <div class="card nopadding">
                    <div class="header nopadding">
                        <div class="info-box bg-teal hover-expand-effect nopadding">
                            <div class="icon">
                                <i class="material-icons">radio</i>
                            </div>
                            <div class="content">
                                <div class="text">R&aacute;dio</div>
                                <?php
                                $totalRadio=0;
                                if (!empty($lista_radio)) {
                                    foreach ($lista_radio as $item):
                                        $totalRadio+=$item['QTD'];
                                    endforeach;  } ?>
                                <div class="number count-to" data-from="0" data-to="<?php echo $totalRadio; ?>" data-speed="15" data-fresh-interval="20"><?php echo $totalRadio; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="body nopadding">
                        <ul class="list-group">
                            <?php if (!empty($lista_radio)) {
                                foreach ($lista_radio as $item): ?>
                                    <a href="javascript:void(0);" data-tipo="R" data-ano="<?php echo $item['ANO'] ?>"  class="list-group-item sub-n2"><?php echo $item['ANO'] ?> <span class="badge bg-pink"><?php echo $item['QTD'] ?></span></a>
                                <?php endforeach;  } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if (!empty($lista_site)) { ?>
            <div class="col-md-4">
                <div class="card nopadding">
                    <div class="header nopadding">
                        <div class="info-box bg-teal hover-expand-effect nopadding">
                            <div class="icon">
                                <i class="material-icons">public</i>
                            </div>
                            <div class="content">
                                <div class="text">Sites e Blogs</div>
                                <?php
                                $totalSite=0;
                                if (!empty($lista_site)) {
                                    foreach ($lista_site as $item):
                                        $totalSite+=$item['QTD'];
                                    endforeach;  } ?>
                                <div class="number count-to" data-from="0" data-to="<?php echo $totalSite; ?>" data-speed="15" data-fresh-interval="20"><?php echo $totalSite; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="body nopadding">
                        <ul class="list-group">
                            <?php if (!empty($lista_site)) {
                                foreach ($lista_site as $item): ?>
                                    <a href="javascript:void(0);" data-tipo="S" data-ano="<?php echo $item['ANO'] ?>"  class="list-group-item sub-n2"><?php echo $item['ANO'] ?> <span class="badge bg-purple"><?php echo $item['QTD'] ?></span></a>
                                <?php endforeach;  } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if (!empty($lista_impresso)) { ?>
            <div class="col-md-4">
                <div class="card nopadding">
                    <div class="header nopadding">
                        <div class="info-box bg-teal hover-expand-effect nopadding">
                            <div class="icon">
                                <i class="material-icons">description</i>
                            </div>
                            <div class="content">
                                <div class="text">Jornal Impresso</div>
                                <?php
                                $totalImpresso=0;
                                if (!empty($lista_impresso)) {
                                    foreach ($lista_impresso as $item):
                                        $totalImpresso+=$item['QTD'];
                                    endforeach;  } ?>
                                <div class="number count-to" data-from="0" data-to="<?php echo $totalImpresso; ?>" data-speed="15" data-fresh-interval="20"><?php echo $totalImpresso; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="body nopadding">
                        <ul class="list-group">
                            <?php if (!empty($lista_impresso)) {
                                foreach ($lista_impresso as $item): ?>
                                    <a href="javascript:void(0);" data-tipo="I" data-ano="<?php echo $item['ANO'] ?>"  class="list-group-item sub-n2"><?php echo $item['ANO'] ?> <span class="badge bg-cyan"><?php echo $item['QTD'] ?></span></a>
                                <?php endforeach;  } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
<?php echo form_open(base_url($this->uri->segment(1).'/detalhar'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
<input type="hidden" name="tipo" id="tipo">
<input type="hidden" name="ano" id="ano">
<input type="hidden" name="anteNivel" value="inicial">
<input type="hidden" name="proxNivel" value="mensal">
</form>
<script type="text/javascript">
    $(function () {
        $('.sub-n2').click(function(){
            $('#tipo').val($(this).data('tipo'));
            $('#ano').val($(this).data('ano'));
            $('#formPadrao').submit();
        });
    });
</script>
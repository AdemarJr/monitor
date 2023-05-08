<?php
$semana_anterior = date('d/m/Y', strtotime(date('Ymd') . ' - 31 days'));
$hoje = date('d/m/Y', strtotime(date('Ymd') . ' - 1 days'));
if (isset($_SESSION['FILTROS']['dataI'])) {
    $semana_anterior = $_SESSION['FILTROS']['dataI'];
}
if (isset($_SESSION['FILTROS']['dataF'])) {
    $hoje = $_SESSION['FILTROS']['dataF'];
}
?>
<style>
    .card {
        border-radius: 15px;
    }
</style>
<div class="block-header inline" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h2><i class="material-icons">print</i> Relat&oacute;rio</h2>
        <small>Gera&ccedil;&atilde;o de Documentos das Mat&eacute;rias.</small>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ol class="breadcrumb breadcrumb-bg- align-right">
            <li class="active">
                <a href="<?php echo base_url('inicio') ?>">
                    <i class="material-icons">home</i> In&iacute;cio
                </a>
            </li>
            <li class="active">Relatórios Especiais</li>
        </ol>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">Filtro
            </div>
            <div class="body">
                <div class="row clearfix nopadding">
                    <?php echo form_open(base_url('relatorio/gerarelatorioespecial'), array('role' => 'form', 'id' => 'formPadrao2', 'class' => 'Formulario2')); ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-2 col-xl-2">
                            <select class="form-control show-tick" name="mes" title="SELECIONE O MÊS">
                               <?php 
                               $meses = $this->db->get('MESES')->result();
                               foreach ($meses as $mes) {
                                   echo '<option value="'.$mes->comando.' - '. ucfirst(strtolower($mes->mes)).'">'.$mes->mes.'</option>';
                               }
                               ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-md-2 col-xl-2">
                            <select class="form-control show-tick" name="veiculo" title="SELECIONE O CLIENTE">
                                <option value="">SELECIONE O CLIENTE</option>
                                <option value="40">GOVERNO DE RORAIMA</option>
                                <!-- <option value="18">SISTEMA FECOMERCIO</option>
                                <option value="5">GOVERNO DO AMAZONAS</option>
                                <option value="1">PREFEITURA (SEMED)</option> -->
                            </select>
                        </div>  
                        <div class="col-xs-12 col-md-1 col-xl-3">
                            <button type="submit" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Gerar Documento"><i class="material-icons" style="color:white;">send</i></button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataInicio').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang: 'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText: 'Cancelar'
        });
        $('#dataFim').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            clearButton: true,
            weekStart: 1,
            lang: 'pt-br',
            time: false,
            clearText: 'Limpar',
            cancelText: 'Cancelar'
        });

    });
</script>
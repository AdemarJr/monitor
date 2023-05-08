<style>
    .btn-small:hover {
        background-color: #1e88e5 !important;
    }
</style>
<?php
$dadosCliente = $this->ComumModelo->getCliente($dataNota->SEQ_CLIENTE)->row();
$dateMsg = ($dataNota->TIPO_NOTIFICACAO == 'D') ? (date('d/m/Y', strtotime($dataNota->DT_INICIO))) : (date('d/m/Y', strtotime($dataNota->DT_INICIO)) . ' - ' . date('d/m/Y', strtotime($dataNota->DT_FIM)));
$tipoMsg = ($dataNota->TIPO_NOTIFICACAO == 'D') ? 'DIÁRIO' : 'PERÍODO';
$tipoMatMsg = ($dataNota->TIPO_MATERIA == 'S') ? 'INTERNET' : (($dataNota->TIPO_MATERIA == 'I') ? 'IMPRESSO' : (($dataNota->TIPO_MATERIA == 'R') ? 'RADIO' : (($dataNota->TIPO_MATERIA == 'T') ? 'TV' : 'TODAS AS PUBLICACOES')));
$mensagem = $_SESSION['txt-wpp'];
?>
<body>
    <?php $this->load->view('modulos/publico/alerta/includes/menu'); ?>
    <main>
        <div class="container">
            <div class="section">
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card grey lighten-5" style="border-radius: 15px;">
                            <div class="card-content">
                                <h5><?= $dadosCliente->NOME_CLIENTE ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card grey lighten-5" style="border-radius: 15px;">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12 m2 margin-mobile">
                                        <button <?= ($total == 0 ? 'disabled' : '') ?> class="waves-effect waves-light btn-small dropdown-trigger" data-target='envio' type="button" style="width: 100%; font-weight: bold"><i class="far fa-paper-plane"></i> ENCAMINHAR</button>
                                    </div>
                                    <div class="col s12 m2 margin-mobile">
                                        <a <?= ($total == 0 ? 'disabled' : '') ?> target="_blank" href="<?= base_url('estatisticas/' . $this->uri->segment(2)); ?>" class="waves-effect waves-light btn-small" type="button" style="width: 100%; font-weight: bold"><i class="fas fa-chart-bar"></i> ESTATISTICAS</a>
                                    </div>
                                    <div class="col s12 m2 margin-mobile">
                                        <a <?= ($total == 0 ? 'disabled' : '') ?> href="<?= base_url('sistema/clipping/clipping_pdf/'.$this->uri->segment(2))?>" class="waves-effect waves-light btn-small" type="button" style="width: 100%; font-weight: bold"><i class="fas fa-file-pdf"></i> GERAR PDF </a>
                                    </div>
                                    <div class="col s12 m2 margin-mobile">
                                        <a <?= ($total == 0 ? 'disabled' : '') ?> target="_blank" href="<?= base_url('alerta/' . $this->uri->segment(2)); ?>" class="waves-effect waves-light btn-small" type="button" style="width: 100%; font-weight: bold"><i class="fas fa-eye"></i> VISUALIZAR ALERTA </a>
                                    </div>
                                    <ul id='envio' class='dropdown-content'>
                                        <li><a href="whatsapp://send?text=%E2%8F%B0+<?php echo urlencode($mensagem); ?>"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                                    </ul>
                                </div>
                                <div class="row" style="margin-top:1%;">
                                    <div class="col s12 m12">
                                        <p class="left"><b>TITULO:</b> <?= $dadosCliente->NOME_CLIENTE . ' ' . $tipoMsg . '/' . $tipoMatMsg . ' - ' . $dateMsg ?> <i class="fas fa-calendar-alt"></i></p>
                                        <p class="right"><b>TOTAL DE PUBLICAÇÕES:</b> <?= $total ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="row" style="margin-top:1%;">
                    <div class="col s12 m12">
                        <ul class="collapsible">
                            <li>
                                <div class="collapsible-header"><i class="material-icons">article</i>Observações</div>
                                <div class="collapsible-body">
                                    <form>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <span><b>Observação</b></span>
                                                <textarea id="textarea1" rows="8" cols="20" style="height: 80px;" placeholder="Digite o texto da observação"></textarea>

                                            </div>
                                            <div class="col s12 m2 margin-mobile">
                                                <a target="_blank" href="<?= base_url('estatisticas/' . $this->uri->segment(2)); ?>" class="waves-effect waves-light btn-small" type="button" style="width: 100%; font-weight: bold">SALVAR</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>-->

            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url() ?>/assets/js/grafico.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.collapsible').collapsible();
            $('.dropdown-trigger').dropdown();
        });
    </script>
    <footer class="page-footer">
        <div class="container">
            © <?= date('Y') ?> Copyright - Porto Monitor
        </div>
    </footer>
</body>
</html>
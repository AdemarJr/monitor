<nav id="navbar0">
    <div class="nav-wrapper">
        <a href="#" class="brand-logo titulo-pagina"><?= TITULO ?></a>
        <a href="#" class="brand-logo titulo-pagina-mobile">MONITOR</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <?php
            $cod = '';
            if (isset($_SESSION['codigo'])) {
                $cod = $_SESSION['codigo'];
                if ($cod == '$1') {
                    $cod = '';
                }
            } else {
                if (!empty($this->uri->segment(2))) {
                    $cod = $this->uri->segment(2);
                }
            }
            ?>
            <li><a href="<?= base_url('alerta/' . $cod) ?>">Noticias</a></li>
            <?php if (isset($_SESSION['perfilUsuario'])) { ?>
                <!--<li><a href="<?= base_url('clipping') ?>">Alertas</a></li> -->
            <?php } ?>                
        </ul>
    </div>
</nav>
<ul class="sidenav" id="mobile-demo">
    <li><a href="<?= base_url('alerta/' . $cod) ?>">Noticias</a></li>
    <?php if (isset($_SESSION['perfilUsuario'])) { ?>
        <!-- <li><a href="<?= base_url('clipping') ?>">Alertas</a></li> -->
        <?php if (empty($_SESSION['idClienteSessao'])) { ?>
            <!-- <li><a href="<?= base_url('relatoriosistema') ?>">Relatórios</a></li> -->
        <?php } else { ?>
           <!-- <li><a href="<?= base_url('meusrelatorios') ?>">Relatórios</a></li> -->
        <?php } ?>
        <hr>
        <li style="margin-left: 10%;"><i class="fas fa-user-circle"></i> <?= $_SESSION['nomeUsuario']; ?></li>;
        <?php } ?>
</ul>

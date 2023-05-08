<?php $this->load->view('modulos/publico/alerta/includes/topo') ?>
<style>
    h4 {
        text-align: center;
    }
    .div-container{
        width: 100%;
        -webkit-transition: -webkit-transform .5s ease;
        transition: transform .5s ease;
    }
    .div-container:hover{
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>
<body style="background-color: #e9e9e9">
    <main>
        <div class="container">
            <div class="row" align="center">
                <div class="col s12">
                    <img class="responsive-img" src="<?= base_url('assets/images/porto-azul.png')?>"> 
                </div>
            </div>
            <div class="row">
                <a href="<?= base_url('inicio') ?>">
                    <div class="col s12 m6 div-container">
                        <div class="card grey lighten-5" style="border-radius: 15px;">
                            <div class="card-content">
                                <h4><i class="fas fa-laptop fa-3x"></i><br>Sistema Atual</h4>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="<?= base_url('alerta') ?>">
                    <div class="col s12 m6 div-container">
                        <div class="card grey lighten-5" style="border-radius: 15px;">
                            <div class="card-content">
                                <h4><i class="fas fa-laptop-house fa-3x"></i><br>Sistema (Desenvolvimento)</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
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
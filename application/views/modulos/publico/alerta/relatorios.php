<?php $this->load->view('modulos/publico/alerta/includes/topo'); ?>
<style>
    .btn-small:hover {
        background-color: #1e88e5 !important;
    }
    .tabs {
        background-color: #e9e9e9; 
    }
    .tabs .tab a:hover, .tabs .tab a.active {
        color: black;
    }
    .tabs .tab a {
        color: gray;
    }
    .tabs .indicator {
        background-color: black;
    }

</style>
<body style="background-color: #e9e9e9">
    <?php $this->load->view('modulos/publico/alerta/includes/menu'); ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col s12">
                    <div class="card grey lighten-5" style="border-radius: 15px;">
                        <div class="card-content">
                            <h4 class="box-title">Lista de Clientes que você tem Permissão</h4>
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>Nome do Cliente</th>
                                        <th>Empresa/Órgão/Instituição</th>
                                        <th>Cidade</th>
                                        <th>UF</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($lista_cliente)) {
                                        foreach ($lista_cliente as $item):
                                            ?>
                                            <tr>
                                                <td><?php echo $item['NOME_CLIENTE'] ?></td>
                                                <td><?php echo $item['EMPRESA_CLIENTE'] ?></td>
                                                <td><?php echo $item['CIDADE_CLIENTE'] ?></td>
                                                <td><?php echo $item['UF_CLIENTE'] ?></td>
                                                <td data-title="Ação">
                                                    <div class='avoid-this action-buttons'>
                                                        <?php if ($this->auth->CheckMenu('geral', 'principal', 'seleciona') == 1) { ?>
                                                            <a data-toggle="tooltip" data-id_cliente="<?= $item['SEQ_CLIENTE'] ?>"data-placement="top" title="Selecionar este cliente" class='btn bg-blue btn-circle waves-effect waves-circle waves-float btn-seleciona'
                                                               href="<?php echo base_url('principal/seleciona/') . $item['SEQ_CLIENTE'] ?>">
                                                                <i class="material-icons">send</i>
                                                            </a>&nbsp;&nbsp;
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a class="waves-effect waves-light btn-small" id="back-to-top" style="width: 50px; font-weight: bold; border-radius:20px;"><i class="material-icons">arrow_upward</i></a>
                </div>
            </div>
            <div class="modal" id="loading">
                <div class="modal-content" style="padding: 0px">
                    <div id="modal-body-content">
                        <h3 style="text-align:center; margin-top: 1%;">Aguarde <i class="fas fa-spinner fa-spin"></i></h3>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.tabs').tabs();
            $('.modal').modal();
            $('.dropdown-trigger').dropdown();
            var btn = document.querySelector("#back-to-top");
            btn.addEventListener("click", function () {
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
            $('.js-basic-example').DataTable({
                dom:
                        "<'ui two column grid'<'left aligned column'l><'right aligned column'f>>" +
                        "<'ui grid'<'column'tr>>" +
                        "<'ui two column grid'<'aligned column'i><'aligned column'p>>",
                responsive: true,
                paginate: true,
                language: {
                    "url": "/monitor/assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
                }
            });
        });
        $('body').delegate('.btn-seleciona', 'click', function (e) {
            e.preventDefault();
            $('#loading').modal('open', {dismissible: false});
            var id_cliente = $(this).data('id_cliente');
            $.ajax({
                mimeType: 'text/html; charset=utf-8',
                url: '<?php echo base_url('principal/seleciona/') ?>' + id_cliente,
                type: 'GET',
                success: function (data) {
                    window.location.href = '<?= base_url('meusrelatorios') ?>';
                },
                dataType: "html",
                async: false
            });

        });
    </script>

    <footer class="page-footer">
        <div class="container">
            © <?= date('Y') ?> Copyright - Porto Monitor
        </div>
    </footer>
</body>
</html>
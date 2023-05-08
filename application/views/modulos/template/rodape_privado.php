</div>
</section>
<script type="text/javascript">
    $(function () {
        <?php
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg.';';
        }
        ?>
        $('.page-loader-wrapper').fadeOut();

    });
</script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo base_url() . 'assets/plugins/bootstrap/js/bootstrap.min.js' ?>" type="text/javascript"></script>
<!-- Select Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/bootstrap-select/js/bootstrap-select.js' ?>"
        type="text/javascript"></script>
<!-- Slimscroll Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/jquery-slimscroll/jquery.slimscroll.js' ?>"
        type="text/javascript"></script>
<!-- Waves Effect Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/node-waves/waves.js' ?>"></script>
<!-- Jquery DataTable Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/jquery-datatable/jquery.dataTables.js' ?>"></script>
<script
    src="<?php echo base_url() . 'assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/jquery-datatable/dataTables.responsive.min.js' ?>"></script>
<script
    src="<?php echo base_url() . 'assets/plugins/jquery-datatable/skin/bootstrap/js/responsive.bootstrap.min.js' ?>"></script>
<script
    src="<?php echo base_url() . 'assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js' ?>"></script>
<script
    src="<?php echo base_url() . 'assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/jquery-datatable/extensions/export/jszip.min.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js' ?>"></script>
<script
    src="<?php echo base_url() . 'assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js' ?>"></script>
<script
    src="<?php echo base_url() . 'assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js' ?>"></script>

<!-- Jquery Validation Plugin Css -->
<script src="<?php echo base_url() . 'assets/plugins/jquery-validation/jquery.validate.js' ?>"></script>

<!-- Sweet Alert Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/sweetalert/sweetalert.min.js' ?>"></script>

<!-- Input Mask Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js' ?>"></script>

<!-- Croppie -->
<script src="<?php echo base_url() . 'assets/plugins/croppie/croppie.js' ?>"></script>

<!-- Bootstrap Notify Plugin Js-->
<script src="<?php echo base_url() . 'assets/plugins/bootstrap-notify/bootstrap-notify.js' ?>"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/momentjs/moment.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/momentjs/moment.pt.br.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js' ?>"></script>
<!-- TinyMCE -->
<script src="<?php echo base_url() . 'assets/plugins/tinymce/tinymce.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/tinymce/langs/pt_BR.js' ?>"></script>

<!-- Bootstrap Tags Input Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js' ?>"></script>

<!-- Multi Select Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/multi-select/js/jquery.multi-select.js' ?>"></script>

<!-- Light Gallery Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/light-gallery/js/lightgallery-all.js' ?>"></script>

<!-- Flot Chart Plugins Js -->
<script src="<?php echo base_url() . 'assets/plugins/flot-charts/jquery.flot.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/flot-charts/jquery.flot.resize.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/flot-charts/jquery.flot.valuelabels.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/plugins/flot-charts/jquery.flot.orderBars.js' ?>"></script>

<script src="<?php echo base_url() . 'assets/plugins/flot-charts/jquery.flot.pie.js' ?>"></script>

<!-- JQuery Steps Plugin Js -->
<script src="<?php echo base_url() . 'assets/plugins/jquery-steps/jquery.steps.js' ?>"></script>


<script src="<?php echo base_url() . 'assets/js/admin.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/js/pages/tables/jquery-datatable.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/js/pages/ui/tooltips-popovers.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/js/utils.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/js/pages/ui/dialogs.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/js/pages/ui/notifications.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/js/site.js' ?>"></script>
</body>
</html>
$(function () {
    $('.js-basic-example').DataTable({
        responsive: true,
        paginate: true,
        language: {
            "url": "/monitor/assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
        }
    });

    ////Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        paginate: true,
        buttons: [
            'excel', 'pdf', 'print'
        ]
    });
});
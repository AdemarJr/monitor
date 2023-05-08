<?php
define('COR_TEMA', '#1e88e5');
define('TITULO', 'Monitor - Sistema de Monitoramento de Notícias');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Manaus');
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        <meta name="author" content="Monitor">
        <meta property="og:title" content="<?= TITULO ?>" />
        <meta property="title" content="<?= TITULO ?>" />
        <title><?= TITULO ?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="shortcut icon" href="https://porto.am/monitor/assets/images/porto-ico.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css"/>
<!--        <link href="<?= base_url() ?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />-->
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
        <?php
        if (isset($_SESSION['filtro'])) {
            if ($_SESSION['filtro']['grupo-v'] == 'on') {
                $veiculo_v = 'block';
            } else {
                $veiculo_v = 'none';
            }

            if ($_SESSION['filtro']['grupo-av'] == 'on') {
                $av = 'block';
            } else {
                $av = 'none';
            }
        } else {
            $av = 'none';
            $veiculo_v = 'none';
        }
        ?>
        <style>
            body::-webkit-scrollbar {
                width: 10px;              
            }
            body::-webkit-scrollbar-thumb {
                background-color: #bdbdbd;
                border-radius: 20px;  
            }
            .img-mdl {
                width: 100% !important;
            }
            .up_images {
                cursor: pointer;
            }
            #modal-img {
                width: 85% !important;
                overflow-y: auto;
            } 
            .row {
                margin-bottom: 0px !important;
            }
            img.responsive-img, video.responsive-video {
                max-width: 60%;
            }
            #back-to-top {
                position: fixed;
                bottom: 50px;
                right: 50px;
            }
            .calendar tr td {
                cursor: pointer;
            }
            video {
                border-radius: 25px !important;
                width: 400px;
            }
            .tags-v {
                display:none;
            }
            #materiaModal,  #modal-img{
                border-radius: 25px !important;
            }
            .modal .open {
                overflow:hidden;
                overflow-y:scroll;
            }
            .btn-circle-lg {
                border: none;
                outline: none !important;
                overflow: hidden;
                width: 50px;
                height: 50px;
                -webkit-border-radius: 50% !important;
                -moz-border-radius: 50% !important;
                -ms-border-radius: 50% !important;
                border-radius: 50% !important;
            }
            .btn-circle-lg i {
                font-size: 26px !important;
                position: relative !important;
                left: -4px !important;
                top: 7px !important;
            }
            .btn-circle i {
                margin-left: -8px !important;
            }
            .bg-red {
                background-color: #F44336 !important;
                color: #fff;
            }
            .brand-logo {
                margin-left: 3%;
            }
            body {
                font-family: 'Roboto Condensed', sans-serif;
                display: flex;
                min-height: 100vh;
                flex-direction: column;
            }
            main {
                flex: 1 0 auto;
            }
            nav {
                background-color: <?= COR_TEMA ?>;
            }
            .nav-wrapper p {
                font-size: 18pt;
            }
            hr {
                color: #e0e0e0;
            }
            .card .card-content .card-title {
                margin-bottom: 0px;
            }
            .selectBox{border-radius:10px;border:1px solid #AAAAAA;}
            .bg-white {
                color: white !important;
                background-color: #757575 !important;
                font-size: 8pt !important;
            }
            .btn, .btn-large, .btn-small {
                background-color: <?= COR_TEMA ?>
            }
            .bg-green {
                background-color: #4CAF50 !important;
                color: #fff !important;
                border-radius: 10px;
            }
            .card-title {
                font-size: 13pt !important;
            }
            .datepicker-inline {
                width: 100%;
            }
            .datepicker,
            .table-condensed {
                font-size: x-small; 
            }
            select.browser-default {
                font-size: 15px; 
                height: 35px;
            }
            .page-footer {
                background-color: <?= COR_TEMA ?>            
            }
            .pagination li.active {
                background-color: <?= COR_TEMA ?>  
            }
            span.badge {
                margin-right: 7px;
                margin-left: 0px;
            }
            .page-footer .container {
                padding-bottom: 1%
            }
            .mais-texto {
                font-size: 11pt;
                display: none;
            }
            .veiculo-agr {
                display: <?= $veiculo_v ?>;
            }
            .avaliacao-agr {
                display:  <?= $av ?>;
            }
            .titulo-pagina {
                display: block;
            }
            .titulo-pagina-mobile {
                display: none !important;
            }
            @media print {
                .pagebreak { page-break-before: always; } /* page-break-after works, as well */
                @page {size: landscape}
            }
            @media only screen and (max-width: 600px) {
                select.browser-default {
                    margin-bottom: 3%;
                }
                .margin-mobile {
                    margin-top: 2%;
                }
                .titulo-pagina {
                    display: none !important;
                }
                .titulo-pagina-mobile {
                    display: block !important;
                }
                .btn .badge {
                    margin-bottom: 3%;
                }
                .acoes {
                    margin-top: 3%;
                }
                span.badge {
                    margin-left: 0px;
                    margin-top: 5px;
                }
                .page-footer {
                    text-align: center;
                }
                .page-footer .container {
                    padding-bottom: 4%
                }
            }
            .ui.table.dataTable thead th
            {
                border-left: 1px solid rgba(34, 36, 38, 0.15);
                color: rgba(0, 0, 0, 0.87);
                cursor: pointer;
                white-space: nowrap;
            }
            .ui.table.dataTable thead th:first-child
            {
                border-left: none;
            }
            .ui.table.dataTable thead .sorting,
            .ui.table.dataTable thead .sorting_asc ,
            .ui.table.dataTable thead .sorting_desc ,
            .ui.table.dataTable thead .sorting_asc_disabled ,
            .ui.table.dataTable thead .sorting_desc_disabled,
            .ui.table.dataTable thead .sorting:hover,
            .ui.table.dataTable thead .sorting_asc:hover ,
            .ui.table.dataTable thead .sorting_desc:hover ,
            .ui.table.dataTable thead .sorting_asc_disabled:hover ,
            .ui.table.dataTable thead .sorting_desc_disabled:hover
            {
                moz-user-select: none;
                ms-user-select: none;
                user-select: none;
                webkit-user-select: none;
            }
            .ui.table.dataTable thead th:after
            {
                content: '';
                display: none;
                font-family: 'Icons';
                font-style: normal;
                font-weight: normal;
                height: 1em;
                margin: 0em 0em 0em 0.5em;
                opacity: 0.8;
                text-decoration: inherit;
                width: auto;
            }
            .ui.table.dataTable thead th.sorting_asc:after
            {
                content: '\f160';
            }
            .ui.table.dataTable thead th.sorting_desc:after
            {
                content: '\f161';
            }
            .ui.table.dataTable th.disabled:hover
            {
                color: rgba(40, 40, 40, 0.3);
                cursor: auto;
            }
            .ui.table.dataTable thead th:hover
            {
                background: rgba(0, 0, 0, 0.05);
                color: rgba(0, 0, 0, 0.8);
            }
            .ui.table.dataTable thead .sorting_asc ,
            .ui.table.dataTable thead .sorting_desc ,
            .ui.table.dataTable thead .sorting_asc_disabled ,
            .ui.table.dataTable thead .sorting_desc_disabled
            {
                background: rgba(0, 0, 0, 0.05);
                color: rgba(0, 0, 0, 0.95);
            }
            .ui.table.dataTable thead .sorting_asc:after ,
            .ui.table.dataTable thead .sorting_desc:after ,
            .ui.table.dataTable thead .sorting_asc_disabled:after ,
            .ui.table.dataTable thead .sorting_desc_disabled:after
            {
                display: inline-block;
            }
            .ui.table.dataTable thead .sorting_asc:hover ,
            .ui.table.dataTable thead .sorting_desc:hover ,
            .ui.table.dataTable thead .sorting_asc_disabled:hover ,
            .ui.table.dataTable thead .sorting_desc_disabled:hover
            {
                background: rgba(0, 0, 0, 0.05);
                color: rgba(0, 0, 0, 0.95);
            }
            .dataTables_length select
            {
                background:#ffffff none repeat scroll 0 0;
                border: 1px solid rgba(34, 36, 38, 0.15);
                border-radius: 0.285714rem;
                box-shadow: none;
                color: rgba(0, 0, 0, 0.87);
                cursor: pointer;
                display: inline-block;
                line-height: 1.2142em;
                min-height: 0.714286em;
                outline: 0 none;
                padding: 0.3em;
                transform: rotateZ(0deg);
                transition: box-shadow 0.1s ease 0s, width 0.1s ease 0s;
                white-space: normal;
                word-wrap: break-word;
            }
            .dataTables_wrapper .dataTables_filter
            {
                color: rgba(0, 0, 0, 0.87);
                display: inline-flex;
                position: relative;
                text-align: right;
            }
            .dataTables_wrapper .dataTables_filter input
            {
                margin-left: 0.5em;
            }
            .dataTables_wrapper .dataTables_info
            {
                clear: both;
                padding-top: 0.755em;
            }
            .dataTables_paginate:after
            {
                clear: both;
                content: "";
                display: block;
                height: 0;
                visibility: hidden;
            }
            .dataTables_paginate
            {
                display: inline-flex;
                margin: 0;
                vertical-align: middle;
            }
            .dataTables_paginate:last-child
            {
                margin-bottom: 0;
            }
            .dataTables_paginate:first-child
            {
                margin-top: 0;
            }
            .dataTables_paginate
            {
                font-size: 1rem;
            }
            .dataTables_paginate
            {
                background:#ffffff none repeat scroll 0 0;
                border: 1px solid rgba(34, 36, 38, 0.15);
                border-radius: 0.285714rem;
                box-shadow: 0 1px 2px 0 rgba(34, 36, 38, 0.15);
                font-family: Lato,"Helvetica Neue",Arial,Helvetica,sans-serif;
                font-weight: 400;
                margin: 1rem 0;
                min-height: 2.85714em;
            }
            .dataTables_paginate .paginate_button:before
            {
                background: rgba(34, 36, 38, 0.1) none repeat scroll 0 0;
                content: "";
                height: 100%;
                position: absolute;
                right: 0;
                top: 0;
                width: 1px;
            }
            .dataTables_paginate .paginate_button
            {
                min-width: 3em;
                text-align: center;
            }
            .dataTables_paginate .paginate_button .disabled, .ui.paginate_button .paginate_button .disabled:hover
            {
                background-color: transparent !important;
                color: rgba(40, 40, 40, 0.3);
                cursor: default;
            }
            .dataTables_paginate .paginate_button
            {
                background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
                color: rgba(0, 0, 0, 0.87);
                font-weight: 400;
                line-height: 1;
                moz-user-select: none;
                padding: 0.928571em 1.14286em;
                position: relative;
                text-decoration: none;
                text-transform: none;
                transition: background 0.1s ease 0s, box-shadow 0.1s ease 0s, color 0.1s ease 0s;
                vertical-align: middle;
            }
            .dataTables_paginate span
            {
                display: inherit;
            }
            .dataTables_paginate > .paginate_button:last-child
            {
                border-radius: 0 0.285714rem 0.285714rem 0;
            }
            .dataTables_paginate > .paginate_button:last-child:before
            {
                display: none;
            }
            .dataTables_paginate .paginate_button
            {
                min-width: 3em;
                text-align: center;
            }
            .dataTables_paginate.icon.paginate_button i.icon
            {
                vertical-align: top;
            }
            .dataTables_paginate .current.paginate_button
            {
                background-color: rgba(0, 0, 0, 0.05);
                border-top: medium none;
                box-shadow: none;
                color: rgba(0, 0, 0, 0.95);
                padding-top: 0.928571em;
            }
            .dataTables_paginate .paginate_button.disabled, .dataTables_paginate .paginate_button.disabled:hover
            {
                background-color: transparent !important;
                color: rgba(40, 40, 40, 0.3);
                cursor: default;
            }
            .dataTables_paginate a.paginate_button:hover
            {
                background: rgba(0, 0, 0, 0.03);
                color: rgba(0, 0, 0, 0.95);
                cursor: pointer;
            }
            .dataTables_filter input
            {
                background:#ffffff none repeat scroll 0 0;
                border: 1px solid rgba(34, 36, 38, 0.15);
                border-radius: 0.285714rem;
                box-shadow: none;
                color: rgba(0, 0, 0, 0.87);
                flex: 1 0 auto;
                font-family: Lato,"Helvetica Neue",Arial,Helvetica,sans-serif;
                height:1em;
                margin: 0;
                max-width: 100%;
                outline: 0 none;
                padding: .4em;
                text-align: left;
                transition: background-color 0.1s ease 0s, box-shadow 0.1s ease 0s, border-color 0.1s ease 0s;
            }
        </style>
    </head>
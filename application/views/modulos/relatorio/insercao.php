<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
    </head>
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 20px 0px 0px 0px;
                font-size: 10pt;
            }
        }
    </style>
    <style>
        .bl {
            background-color: #fdfed2 !important;
        }
        .tb {
            background-color: #f1f1f1 !important;
        }
        .table>:not(caption)>*>* {
            padding: 0px !important;
        }
        body {
            font-family: Arial,"Helvetica Neue", Helvetica,  sans-serif;
            font-size: 10pt;
            /*            break-inside: avoid;*/
        }
    </style>
    <body>

        <div>
            <div class="row" style="margin-top: 5%;">
                <div class="col-md-12">
                    <p class="text-center" style="text-align:center"><b>INSERÇÕES DIÁRIAS TV FISCAL – CANDIDATO WILSON LIMA</b></p>
                    <p class="text-center" style="text-align:center;background-color: #93d04e; color: white;margin-bottom: -2px; padding: 6px;"><b>GOVERNO - DATA: <?= $dados['datainicio'] ?>  (B1/ B2/ B3)</b></p>
                    <table class="table table-bordered border-dark">
                        <thead class="text-center" style="text-align:center;">
                            <tr>
                                <th scope="col" class="tb">EMISSORA</th>
                                <th scope="col" style="background-color: #99b0cf">PREVISÃO TSE<br><br></th>
                                <th scope="col" style="background-color: #99b0cf">PROGRAMA/HORA<br><br></th>
                                <th scope="col" style="background-color: #99b0cf">BLOCO 1<br><br></th>
                                <th scope="col" style="background-color: #99b0cf">PROGRAMA/HORA<br><br></th>
                                <th scope="col" style="background-color: #99b0cf">BLOCO 2<br><br></th>
                                <th scope="col" style="background-color: #99b0cf">PROGRAMA/HORA<br><br></th>
                                <th scope="col" style="background-color: #99b0cf">BLOCO 3<br><br></th>
                            </tr>
                        </thead>
                        <tbody class="text-center" style="text-align:center;">
                            <?php foreach ($resultado as $emissora) { ?>
                                <tr>
                                    <th scope="row" class="tb"><?= $emissora->NOME_TV ?></th>
                                    <td>25</td>
                                    <!-- PROGRAMA DO BLC 1 -->
                                    <?php
                                    $SQL = "SELECT MATERIA.PROGRAMA_MATERIA, DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%d/%m/%Y') AS DATA, TRIM(MATERIA.HORA_MATERIA) AS HORA, S.DESC_SETOR, TM.DESC_TIPO_MATERIA FROM MATERIA MATERIA
                                    JOIN SETOR S ON S.SEQ_SETOR = MATERIA.SEQ_SETOR
                                    JOIN TIPO_MATERIA TM ON TM.SEQ_TIPO_MATERIA = MATERIA.SEQ_TIPO_MATERIA
                                    WHERE DATA_PUB_NUMERO BETWEEN " . $dataInicio . " AND " . $dataFim . "
                                    AND MATERIA.SEQ_SETOR = " . $dados['setor'] . " AND MATERIA.SEQ_TV = " . $emissora->SEQ_TV . " AND MATERIA.SEQ_TIPO_MATERIA = " . $dados['area'] . ' AND TRIM(MATERIA.HORA_MATERIA) BETWEEN "04:00:00" AND "11:00:59"  ORDER BY MATERIA.HORA_MATERIA, MATERIA.PROGRAMA_MATERIA, MATERIA.DATA_MATERIA_CAD';
                                    $query = $this->db->query($SQL)->result();
                                    ?>
                                    <?php if (!empty($query)) { ?>
                                        <td>
                                            <table  class="table border-dark">
                                                <?php foreach ($query as $programa) { ?>
                                                    <tr>
                                                        <td><?= $programa->PROGRAMA_MATERIA ?> / <?= !empty($programa->HORA) ? strlen($programa->HORA) > 5 ? substr($programa->HORA, 0, -3) : $programa->HORA : '-' ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                        <td class="tb">
                                            <table  class="table border-dark">
                                                <?php foreach ($query as $programa) { ?>
                                                    <tr class="">
                                                        <td>
                                                            1
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                    <?php } else { ?>

                                    <?php } ?>   
                                    <!-- PROGRAMA DO BLC 2 -->
                                    <?php
                                    $SQL = "SELECT MATERIA.PROGRAMA_MATERIA, DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%d/%m/%Y') AS DATA, TRIM(MATERIA.HORA_MATERIA) AS HORA, S.DESC_SETOR, TM.DESC_TIPO_MATERIA FROM MATERIA MATERIA
                                    JOIN SETOR S ON S.SEQ_SETOR = MATERIA.SEQ_SETOR
                                    JOIN TIPO_MATERIA TM ON TM.SEQ_TIPO_MATERIA = MATERIA.SEQ_TIPO_MATERIA
                                    WHERE DATA_PUB_NUMERO BETWEEN " . $dataInicio . " AND " . $dataFim . "
                                    AND MATERIA.SEQ_SETOR = " . $dados['setor'] . " AND MATERIA.SEQ_TV = " . $emissora->SEQ_TV . " AND MATERIA.SEQ_TIPO_MATERIA = " . $dados['area'] . ' AND TRIM(MATERIA.HORA_MATERIA) BETWEEN "11:01:00" AND "18:00:59"  ORDER BY MATERIA.HORA_MATERIA, MATERIA.PROGRAMA_MATERIA, MATERIA.DATA_MATERIA_CAD';
                                    $query = $this->db->query($SQL)->result();
                                    ?>
                                    <?php if (!empty($query)) { ?>
                                        <td>
                                            <table  class="table border-dark">
                                                <?php foreach ($query as $programa) { ?>
                                                    <tr>
                                                        <td><?= $programa->PROGRAMA_MATERIA ?> / <?= !empty($programa->HORA) ? strlen($programa->HORA) > 5 ? substr($programa->HORA, 0, -3) : $programa->HORA : '-' ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                        <td>
                                            <table  class="table border-dark">
                                                <?php foreach ($query as $programa) { ?>
                                                    <tr class="tb">
                                                        <td>
                                                            1
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                    <?php } else { ?>

                                    <?php } ?>   
                                    <!-- PROGRAMA DO BLC 3 -->
                                    <?php
                                    $SQL = "SELECT MATERIA.PROGRAMA_MATERIA, DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%d/%m/%Y') AS DATA, TRIM(MATERIA.HORA_MATERIA) AS HORA, S.DESC_SETOR, TM.DESC_TIPO_MATERIA FROM MATERIA MATERIA
                                    JOIN SETOR S ON S.SEQ_SETOR = MATERIA.SEQ_SETOR
                                    JOIN TIPO_MATERIA TM ON TM.SEQ_TIPO_MATERIA = MATERIA.SEQ_TIPO_MATERIA
                                    WHERE DATA_PUB_NUMERO BETWEEN " . $dataInicio . " AND " . $dataFim . "
                                    AND MATERIA.SEQ_SETOR = " . $dados['setor'] . " AND MATERIA.SEQ_TV = " . $emissora->SEQ_TV . " AND MATERIA.SEQ_TIPO_MATERIA = " . $dados['area'] . ' AND TRIM(MATERIA.HORA_MATERIA) BETWEEN "18:01:00" AND "23:59:59"  ORDER BY MATERIA.HORA_MATERIA, MATERIA.PROGRAMA_MATERIA, MATERIA.DATA_MATERIA_CAD';
                                    $query = $this->db->query($SQL)->result();
                                    ?>
                                    <?php if (!empty($query)) { ?>
                                        <td>
                                            <table  class="table border-dark">
                                                <?php foreach ($query as $programa) { ?>
                                                    <tr>
                                                        <td><?= $programa->PROGRAMA_MATERIA ?> / <?= !empty($programa->HORA) ? strlen($programa->HORA) > 5 ? substr($programa->HORA, 0, -3) : $programa->HORA : '-' ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                        <td>
                                            <table  class="table border-dark">
                                                <?php foreach ($query as $programa) { ?>
                                                    <tr class="tb">
                                                        <td>
                                                            1

                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                    <?php } else { ?>

                                    <?php } ?> 
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--        <script>
            $(document).ready(function () {
                 window.print();
                setTimeout(function () {
                    window.location = 'https://porto.am/monitor/relatorio';
                }, 1000);
            });
        </script>-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </body>
</html>
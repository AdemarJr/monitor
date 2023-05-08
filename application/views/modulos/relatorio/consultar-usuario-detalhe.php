    <table class="table table-bordered table-striped table-hover js-basic-example-modal dataTable">
    <thead>
    <tr>
        <th >Código</th>
        <th>Tipo/Avaliação</th>
        <th>Nome do Veículo/Título</th>
        <th>Publicação</th>
        <th>Área da Matéria</th>
        <th>Ação</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($lista_materia)) {

        foreach ($lista_materia as $item):
            $habilitaBotaoDownEmail=false;?>
            <tr>
                <td><?php echo $item['SEQ_MATERIA'] ?></td>
                <td><?php if(!empty($item['SEQ_VEICULO'])) echo 'Impresso'; else if(!empty($item['SEQ_PORTAL'])) echo 'Internet';else if(!empty($item['SEQ_RADIO'])) echo 'Rádio';   ?><br/>
                    <small><i></small><?php if($item['IND_AVALIACAO']=='T') echo 'Neutro'; else if($item['IND_AVALIACAO']=='P') echo 'Positivo';else if($item['IND_AVALIACAO']=='N') echo 'Negativo';   ?></i></small>
                </td>
                <td><?php if(!empty($item['SEQ_VEICULO']))
                        echo $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row()->FANTASIA_VEICULO;
                    else if(!empty($item['SEQ_PORTAL'])) echo $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row()->NOME_PORTAL;
                    else if(!empty($item['SEQ_RADIO'])) echo $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row()->NOME_RADIO;
                    ?>
                    <br/><small><i></small><?php echo resume($item['TIT_MATERIA'],100);   ?></i></small>
                </td>
                <td><?php echo date('d/m/Y',strtotime($item['DATA_MATERIA_PUB'])); ?></td>
                <td><?php if (!empty($item['SEQ_TIPO_MATERIA'])) echo $this->ComumModelo->getTableData('TIPO_MATERIA', array('SEQ_TIPO_MATERIA' =>  $item['SEQ_TIPO_MATERIA']))->row()->DESC_TIPO_MATERIA; ?></td>
                <td data-title="Ação">
                    <div class='avoid-this action-buttons'>
                        <?php if ($this->auth->CheckMenu('geral', 'materia', 'editar') == 1) { ?>
                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="Editar" class='btn bg-blue btn-circle waves-effect waves-circle waves-float'
                               href="<?php echo base_url('materia/editar/') . $item['SEQ_MATERIA'] ?>">
                                <i class="material-icons">edit</i>
                            </a>&nbsp;&nbsp;
                        <?php } ?>
                    </div>
                </td>
            </tr>
        <?php endforeach;
    } ?>
    </tbody>
    <tfoot class="hidden-sm hidden-xs">
    <tr>
        <th>Código</th>
        <th>Tipo/Avaliação</th>
        <th>Nome do Veículo/Título</th>
        <th>Publicação</th>
        <th>Área da Matéria</th>
        <th>Ação</th>
    </tr>
    </tfoot>
</table>
<script type="text/javascript">
    $(function () {
        $('.js-basic-example-modal').DataTable({
            responsive: true,
            paginate: true,
            info: true,
            filter: true,
            ordering: true,
            iDisplayLength:5,
            lengthMenu: [[5,10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            language: {
                "url": "/monitor/assets/plugins/jquery-datatable/i18n/Portuguese-Brasil.json"
            }
        });

    });
</script>

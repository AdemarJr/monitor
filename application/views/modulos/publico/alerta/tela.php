<?php
if (!empty($chave)) {
    $dataNota = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $chave))->row();
}

if (!empty($this->session->userdata('idClienteSessaoAlerta'))) {
    $dadosCliente = $this->ComumModelo->getCliente($this->session->userdata('idClienteSessaoAlerta'))->row();
} else if (!empty($chave)) {
    $dadosCliente = $this->ComumModelo->getCliente($dataNota->SEQ_CLIENTE)->row();
}
if (!empty($chave))
    $flagModelo = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $chave))->row()->IND_MODELO;
?>
<?php
$descTipo = array(
    'S' => 'fas fa-laptop',
    'I' => 'fas fa-newspaper',
    'R' => 'fas fa-headphones',
    'T' => 'fas fa-tv'
);
?>
<body>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <?php $this->load->view('modulos/publico/alerta/includes/menu'); ?>
    <?php
    if (!empty($lista_dias)) {
        ?>
        <main>    
            <div class="container">
                <div class="section">
                    <div class="row">
                        <div class="col s12 m8">
                            <?php $this->load->view('modulos/publico/alerta/includes/filtro'); ?>

                            <?php $i = 0 ?>

                            <div class="col s12 m12">
                                <nav class="grey lighten-3" style="height: 55px; border-radius: 15px;">
                                    <p class="black-text left" style="font-size: 14pt; margin-left: 3%; margin-top: 1%; text-transform: uppercase"><b><i class="fas fa-user-tie"></i> <?= $dadosCliente->NOME_CLIENTE ?></b></p>
                                    <p class="black-text right" style="font-size: 14pt; margin-right: 3%; margin-top: 1%;"><b><i class="fas fa-list"></i> TODAS AS MATÉRIAS - <?= $total . ' PUBLICAÇÕES' ?></b></p>
                                </nav>
                            </div>
                            <div class="col s12 m12" style="margin-top: -2%;">

                                <?php
                                $i = 0;
                                foreach ($lista_dias as $item) {
                                    
                                    $dadoVeiculo = NULL;
                                    $i++;
                                    if ($item['TIPO_MATERIA'] == 'I' and ! empty($item['SEQ_VEICULO']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('VEICULO', array('SEQ_VEICULO' => $item['SEQ_VEICULO']))->row();
                                    else if ($item['TIPO_MATERIA'] == 'S' and ! empty($item['SEQ_PORTAL']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('PORTAL', array('SEQ_PORTAL' => $item['SEQ_PORTAL']))->row();
                                    else if ($item['TIPO_MATERIA'] == 'R' and ! empty($item['SEQ_RADIO']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('RADIO', array('SEQ_RADIO' => $item['SEQ_RADIO']))->row();
                                    else if ($item['TIPO_MATERIA'] == 'T' and ! empty($item['SEQ_TV']))
                                        $dadoVeiculo = $this->ComumModelo->getTableData('TELEVISAO', array('SEQ_TV' => $item['SEQ_TV']))->row();
                                    if ($item['TIPO_MATERIA'] == 'I' and ! empty($item['SEQ_VEICULO'])) {
                                        $mensagem = $dadoVeiculo->FANTASIA_VEICULO . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'] . PHP_EOL . $item['DIA'];
                                    } else if ($item['TIPO_MATERIA'] == 'S' and ! empty($item['SEQ_PORTAL'])) {
                                        $mensagem = $dadoVeiculo->NOME_PORTAL . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'] . PHP_EOL . $item['DIA'];
                                    } else if ($item['TIPO_MATERIA'] == 'R' and ! empty($item['SEQ_RADIO'])) {
                                        $mensagem = $dadoVeiculo->NOME_RADIO . PHP_EOL . $item['PROGRAMA_MATERIA'] . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'] . PHP_EOL . $item['DIA'] . (!empty($item['HORA_MATERIA']) ? $item['HORA_MATERIA'] : '');
                                    } else if ($item['TIPO_MATERIA'] == 'T' and ! empty($item['SEQ_TV'])) {
                                        $mensagem = $dadoVeiculo->NOME_TV . PHP_EOL . $item['PROGRAMA_MATERIA'] . PHP_EOL . $item['TIT_MATERIA'] . PHP_EOL . 'Link: ' . url_materia_simples($item['SEQ_CLIENTE']) . $item['CHAVE'] . PHP_EOL . $item['DIA'] . $item['HORA_MATERIA'];
                                    }
                                    ?>
                                <div class="row pub-<?= $item['SEQ_MATERIA'] ?>">
                                        <?php
                                        if ($i > 1) {
                                            echo '<hr style="width: 50%">';
                                        }
                                        ?>
                                        <div class="col s12 m12">
                                            <div class="row" style="margin-bottom: 0px;">
                                                <div class="col s7 m8">
                                                    <?php
                                                    $dia = strftime('%d', strtotime(implode('-', array_reverse(explode('/', $item['DIA'])))));
                                                    $mes = ucfirst(strftime('%B', strtotime(implode('-', array_reverse(explode('/', $item['DIA']))))));
                                                    $ano = strftime('%Y', strtotime(implode('-', array_reverse(explode('/', $item['DIA'])))));
                                                    ?>
                                                    <p class="left" style="font-size: 18px"><b><?= $item['DIA'] ?> | <?= $item['HORA_MATERIA'] ?></b> 
                                                        <?php
                                                        if ($item['IND_AVALIACAO'] == 'P') {
                                                            ?>
                                                            <span class="badge hidden-tag badge-av-<?= $item['SEQ_MATERIA'] ?>" style="margin-left: 5px; background-color: #4CAF50; color: white; border-radius: 10px">Positiva</span> 
                                                        <?php } else if ($item['IND_AVALIACAO'] == 'T') { ?>
                                                            <span class="badge hidden-print badge-av-<?= $item['SEQ_MATERIA'] ?>" style="margin-left: 5px; color:white; border-radius: 10px; background-color: #757575">Neutra</span>
                                                        <?php } else { ?>
                                                            <span class="badge bg-red hidden-print badge-av-<?= $item['SEQ_MATERIA'] ?>" style="margin-left: 5px; color:white;border-radius: 10px; background-color: #F44336">Negativa</span>
                                                        <?php } ?>
                                                        <i class="fas <?= $descTipo[$item['TIPO_MATERIA']]; ?>"></i>
                                                    </p>
                                                </div>
                                                <div class="col s5 m4" style="margin-top: 2%">
                                                    <?php
                                                        $veiculo_pub = '';
                                                        if ($item['TIPO_MATERIA'] == 'I' and ! empty($item['SEQ_VEICULO']))
                                                            $veiculo_pub = $dadoVeiculo->FANTASIA_VEICULO;
                                                        else if ($item['TIPO_MATERIA'] == 'S' and ! empty($item['SEQ_PORTAL']))
                                                            $veiculo_pub = $dadoVeiculo->NOME_PORTAL;
                                                        else if ($item['TIPO_MATERIA'] == 'R' and ! empty($item['SEQ_RADIO']))
                                                            $veiculo_pub = $dadoVeiculo->NOME_RADIO;
                                                        else if ($item['TIPO_MATERIA'] == 'T' and ! empty($item['SEQ_TV']))
                                                            $veiculo_pub = $dadoVeiculo->NOME_TV . ' - ' . $item['PROGRAMA_MATERIA'];
                                                        ?>
                                                    <?php if (isset($_SESSION['perfilUsuario'])) {?>
                                                    <button  data-id_cliente="<?= $item['SEQ_CLIENTE'] ?>" data-mensagem="<?= base_url('materia/ajaxShare/nm/'.$item['SEQ_MATERIA'])?>" data-position="left" data-tooltip="COPIAR MENSAGEM PARA O CLIENTE" class="waves-effect waves-light btn-small right green darken-1 tooltipped btn-wpp" style="width: 50px;margin-right: 1%;"><i class="material-icons left">share</i></button>
                                                    <?php } ?>
                                                    <?php if ($item['TIPO_MATERIA'] == 'S') { ?>
                                                    <a  href="<?php if (!empty($item['LINK_MATERIA'])) echo $item['LINK_MATERIA']; else echo 'javascript:void(0);'; ?>" target="_blank" data-position="left" data-tooltip="Visualizar na Fonte" class="waves-effect waves-light btn-small right blue darken-4 tooltipped" style="width: 50px;margin-right: 1%;"><i class="material-icons left">link</i></a>
                                                    <?php } ?>
                                                    <?php if (isset($_SESSION['perfilUsuario'])) { ?>
                                                    <a href="<?= base_url('materia/editar/'.$item['SEQ_MATERIA']) ?>"  data-tooltip="Editar Matéria" class="waves-effect waves-light btn-small right blue darken-1 tooltipped" style="width: 50px;margin-right: 1%;" target="_blank" ><i class="material-icons left">edit</i></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <p class="left" style="margin-top: 0%; font-size: 18px">
                                                <a href="" target="_blank"><b><?= $item['TIT_MATERIA'] ?></b></a><br>
                                                <span style="font-size: 15px"><i class="far fa-calendar-alt"></i> Publicado em: <?= $dia ?> de <?= $mes ?> de <?= $ano ?> em 
                                                    <b>
                                                        <?= $veiculo_pub ?>
                                                    </b>
                                                </span><br>
                                                <span class="txt-curto-<?= $item['SEQ_MATERIA'] ?>" style="font-size: 11pt;">
                                                    <?= mb_strimwidth($item['TEXTO_MATERIA'], 0, 200, "...") ?>    
                                                </span>
                                                <span class="mais-texto texto-<?= $item['SEQ_MATERIA'] ?>">
                                                    <?= $item['TEXTO_MATERIA'] ?>    
                                                </span>
                                            </p>

                                            <div class="row">
                                                <div class="col s12 m12">
                                                    <?php if (!empty($item['TEXTO_MATERIA'])) { ?>
                                                        <a class="waves-effect waves-light btn-small btn-leia-mais btn-<?= $item['SEQ_MATERIA'] ?>" data-id="<?= $item['SEQ_MATERIA'] ?>" style="width: 100px; font-weight: bold; border-radius:20px;">LER MAIS</a>
                                                    <?php } ?>
                                                    <?php 
                                                    if ($this->session->userData('perfilUsuario') == 'ROLE_ADM') {
                                                    ?>
                                                    <p class="hidden-print">
                                                    <?php
                                                    $chaves = array();
                                                    if (!empty($item['PC_MATERIA'])  and $flagModelo<>'S' and $flagTema=='N')
                                                        $chaves = explode(',', $item['PC_MATERIA']);
                                                    foreach ($chaves as $valor2) { ?>
                                                        <span class="btn badge bg-pink left"  style="color:white; cursor: default; border-radius: 10px;"><?php echo strtoupper($valor2); ?></span>
                                                    <?php } ?>
                                                    </p><br><br>    
                                                    <?php } ?>
                                                    <?php if ($item['TIPO_MATERIA'] == 'R' or $item['TIPO_MATERIA'] == 'T') { ?>
                                                        <?php
                                                        $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                                                        if (count($anexos) > 0) {
                                                            $controle = 0;
                                                            foreach ($anexos as $itemA) {
                                                                $controle++;
                                                                if ($controle == 1) {
                                                                    
                                                                }
                                                                ?>
                                                                
                                                                <?php if ($this->ComumModelo->existeAnexo($itemA['SEQ_ANEXO'])) { ?>    
                                                                    <a class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float btn-radio-play left" data-toggle="tooltip" data-placement="top" title="Play na Notícia" data-materia="<?= $item['SEQ_MATERIA']; ?>">
                                                                        <i class="material-icons">play_circle_outline</i>
                                                                    </a>
                                                    <a style="margin-left: 2%;" data-toggle="tooltip" data-placement="top" title="Baixar Notícia" class="btn bg-teal btn-circle-lg waves-effect waves-circle waves-float left" href="<?= base_url('publico/audiodown/') . $itemA['SEQ_ANEXO'] ?>">
                                                                        <i class="material-icons">file_download</i>
                                                                    </a>
                                                                
                                                                    <?php
                                                                } else {
                                                                    echo ' <p><i class="fas fa-exclamation-circle"></i> Sem mídia para reproduzir o conteúdo </p>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                   <?php } ?>
                                                   <?php 
                                                   if($item['TIPO_MATERIA']=='I') { 
                                                   $anexos = $this->ComumModelo->listaAnexo($item['SEQ_MATERIA']);
                                                   if (count($anexos) > 0) {
                                                       foreach ($anexos as $itemA) {
                                                   ?>     
                                                   <div class="up_images" data-img="<?php echo base_url('publico/imagem2/R/'.$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ); ?>">
                                                        <img class="responsive-img"  src="<?php echo base_url('publico/imagem2/R/'.$itemA['SEQ_MATERIA'].'/'.$itemA['NOME_BIN_ARQUIVO'] ); ?>"/>
                                                   </div>
                                                    <?php } } }?>     
                                                </div>
                                            </div>

                                            <div class="row" style="margin-top: 2%;">
                                                <?php  if (isset($_SESSION['perfilUsuario'])) { ?>
                                                <?php if ($_SESSION['perfilUsuario'] == 'ROLE_ADM') { ?>
                                                
                                                <?php } ?>
                                                <?php } ?>
                                                <div class="col s12 m6 acoes right">
                                                    <?php
                                                    if (isset($_SESSION['perfilUsuario'])) {
                                                        ?>
                                                        <?php if ($_SESSION['perfilUsuario'] == 'ROLE_USU' || $_SESSION['perfilUsuario'] == 'ROLE_ADM') { ?>
                                                            <a class="btn-altera-avaliacao waves-effect waves-light btn-small right red darken-1 tooltipped" style="width: 50px;margin-right: 1%;" data-position="bottom" data-tooltip="MARCAR MATÉRIA COMO NEGATIVA" data-materia="<?= $item['SEQ_MATERIA'] ?>" data-avaliacao="N"><i class="material-icons left">thumb_down_off_alt</i></a>
                                                            <a class="btn-altera-avaliacao waves-effect waves-light btn-small right grey darken-1 tooltipped" style="width: 50px;margin-right: 1%;" data-position="bottom" data-tooltip="MARCAR MATÉRIA COMO NEUTRA" data-materia="<?= $item['SEQ_MATERIA'] ?>" data-avaliacao="T"><i class="material-icons left">remove</i></a>
                                                            <a class="btn-altera-avaliacao waves-effect waves-light btn-small right green darken-1 tooltipped" style="width: 50px;margin-right: 1%;" data-position="bottom" data-tooltip="MARCAR MATÉRIA COMO POSITIVA" data-materia="<?= $item['SEQ_MATERIA'] ?>" data-avaliacao="P"><i class="material-icons left">thumb_up</i></a>
                                                        <?php } ?>
                                                        <?php if ($_SESSION['perfilUsuario'] == 'ROLE_ADM') { ?>
                                                            <a class="btn-apaga-materia waves-effect waves-light btn-small right black tooltipped" style="width: 50px;margin-right: 1%;" data-position="bottom" data-tooltip="APAGAR MATÉRIA" data-materia="<?= $item['SEQ_MATERIA'] ?>"><i class="material-icons left">delete</i></a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                
                                <?php } ?>
                                <?= $paginacao ?>

                            </div>
                        </div>

                        <!-- COLUNA 02 -->

                        <div class="col s12 m4" style="padding-bottom: 1%;">
                            <button class="btn blue darken-5" style="height: 30px; border-radius: 15px; width: 100%; cursor: default;">
                                <p class="black-text center white-text" style="margin-top: 0px; text-transform: uppercase"><b><i class="fas fa-newspaper"></i> Últimas Publicações</b></p>
                            </button>
                        </div>
                        <div class="col s12 m4">
                            <div class="card grey lighten-5" style="border-radius: 15px;">
                                <div class="card-content" style="padding: 0px 0px 0px 10px;">
                                    <br><p>Calendário</p>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input name="calendario" type="text" class="validate date">
                                            <span class="helper-text">Selecione a data para visualizar as publicações</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4" style="padding-bottom: 1%;">
                            <a href="<?= base_url('estatisticas/'.$this->uri->segment(2)); ?>" class="btn black darken-5 tooltipped btn-estatistica-tela" style="height: 30px; border-radius: 15px; width: 100%;" data-position="bottom" data-tooltip="GERAR OS GRÁFICOS DESTE ALERTA">
                                <p class="black-text center white-text" style="margin-top: 0px; text-transform: uppercase"><b><i class="fas fa-chart-bar"></i> ESTATISTICAS</b></p>
                            </a>
                            
                            <a href="<?= base_url('sistema/clipping/clipping_pdf/'.$this->uri->segment(2))?>" class="btn black darken-5" style="height: 30px; border-radius: 15px; width: 100%; margin-top: 2%">
                                <p class="black-text center white-text" style="margin-top: 0px; text-transform: uppercase"><b><i class="fas fa-file-pdf"></i> GERAR PDF</b></p>
                            </a>
                        </div>
                        <a class="waves-effect waves-light btn-small" id="back-to-top" style="width: 50px; font-weight: bold; border-radius:20px;"><i class="material-icons">arrow_upward</i></a>

                    </div>
                </div>
              
                <div class="modal" id="materiaModal">
                    <div class="modal-content">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect modal-close" style="border-radius: 20px;">Fechar</button>
                        </div>
                        <div id="modal-body-content">
                            
                        </div>
                    </div>
                </div>
                <div class="modal" id="modal-img">
                    <div class="modal-content">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect modal-close" style="border-radius: 20px;">Fechar</button>
                        </div>
                        <div id="modal-body-content" class="mdl-img">
                            
                        </div>
                    </div>
                </div>
                <div class="modal" id="loading">
                    <div class="modal-content" style="padding: 0px">
                        <div id="modal-body-content">
                            <h3 style="text-align:center; margin-top: 1%;">Procurando publicações <i class="fas fa-spinner fa-spin"></i></h3>
                        </div>
                    </div>
                </div>
                <div class="modal" id="loading-grafico">
                    <div class="modal-content" style="padding: 0px">
                        <div id="modal-body-content">
                            <h3 style="text-align:center; margin-top: 1%;">Gerando Estatisticas <i class="fas fa-spinner fa-spin"></i></h3>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <?php } else { ?>
        <main>    
            <div class="container">
                <div class="section">
                    <div class="row">
                        <div class="col s12 m8">
                            <?php $this->load->view('modulos/publico/alerta/includes/filtro'); ?>
                            <p style="text-align:center"><i class="fas fa-exclamation-circle"></i> Nenhuma matéria encontrada</p>
                        </div>
                        <div class="col s12 m4" style="padding-bottom: 1%;">
                            <button class="btn blue darken-5" style="height: 30px; border-radius: 15px; width: 100%; cursor: default;">
                                <p class="black-text center white-text" style="margin-top: 0px; text-transform: uppercase"><b><i class="fas fa-newspaper"></i> Últimas Publicações</b></p>
                            </button>
                        </div>
                        <div class="col s12 m4">
                            <div class="card grey lighten-5" style="border-radius: 15px;">
                                <div class="card-content" style="padding: 0px 0px 0px 10px;">
                                    <br><p>Calendário</p>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <?php if (!empty( $this->uri->segment(2))) {?>
                                            <input name="calendario" type="text" class="validate">
                                            <?php } else { ?>
                                            <input name="calendario_" type="text" class="validate" value="<?= date('d/m/Y')?>">
                                            <?php } ?>
                                            <span class="helper-text">Selecione a data para visualizar as publicações</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <a class="waves-effect waves-light btn-small" id="back-to-top" style="width: 100px; font-weight: bold; border-radius:20px; display: none;"><i class="material-icons">arrow_upward</i></a>
                    </div>
                </div>
            </div>
        </main>
    <?php } 
    ?>
    <textarea id="alerta" class="textarea-wpp" style="width: 0px;height: 0px;resize: none;"></textarea>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>  
        $('body').delegate('.btn-wpp', 'click', function (e) {
          e.preventDefault();
          var mensagem = $(this).data('mensagem');
          var id_cliente = $(this).data('id_cliente');
          $.ajax({
                mimeType: 'text/html; charset=utf-8',
                url: '<?php echo base_url('sistema/Alerta/alertamsg/') ?>' + id_cliente,
                type: 'GET',
                success: function (data) {
                    $.ajax({
                    mimeType: 'text; charset=utf-8',
                    url: mensagem,
                    type: 'GET',
                    success: function (data) {
                        if (data.status) {
                            $("#alerta").text(data.mesage.replace(/\+/g, ' '));
                            var copyTextarea = document.querySelector('.textarea-wpp');

                            copyTextarea.select();
                            try {
                                var successful = document.execCommand('copy');
                                if (successful)
                                    alertify.set('notifier','position', 'bottom-center');
                                    alertify.success('ALERTA COPIADO <i class="fas fa-check-circle"></i>'); 
                            } catch (err) {
                                alertify.set('notifier','position', 'bottom-center');
                                alertify.error('NÃO FOI POSSÍVEL COPIAR O ALERTA <i class="fas fa-info-circle"></i>'); 
                            }
                        }else {
                            alertify.set('notifier','position', 'bottom-center');
                            alertify.error('NÃO FOI POSSÍVEL COPIAR O ALERTA <i class="fas fa-info-circle"></i>'); 
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    },
                    dataType: "json",
                    async: true
                    });
                        },
                        dataType: "html",
                        async: false
                  });
          
        });
        $('body').delegate('.botao-baixar', 'click', function (e) {
            e.preventDefault();
            window.location.href = $(this).data('url');
        });
        $('body').delegate('.botao-excluir-anexo', 'click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Você quer realmente excluir esse arquivo?',
                text: "Confirmando você excluirá este arquivo da matéria.",
                showDenyButton: true,
                confirmButtonText: 'Sim',
                denyButtonText: `Cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).data('url');
                }
            })
            
        });
           
        function exibeVeiculos(){
            var check = document.querySelector("input[name='grupo-v']:checked");
            if (check != null) {
            $('.veiculo-agr').css('display', 'block');
            } else {
            $('.veiculo-agr').css('display', 'none');
            }
        }
        function exibeAvaliacao(){
            var check = document.querySelector("input[name='grupo-av']:checked");
            if (check != null) {
            $('.avaliacao-agr').css('display', 'block');
            } else {
            $('.avaliacao-agr').css('display', 'none');
            }
        }
        function playRadio(e) {
            e.preventDefault();
            var materia = $(this).data('materia');
            $.ajax({
                mimeType: 'text/html; charset=utf-8',
                url: '<?php echo base_url('publico/ajaxViewer/') ?>' + materia,
                type: 'GET',
                success: function (data) {
                    $('#modal-body-content').html(data);
                    $('#materiaModal').modal('open');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                dataType: "html",
                async: false
            });
        }
        $('body').delegate('.btn-leia-mais', 'click', function (e) {
            e.preventDefault();
            var materia = $(this).attr("data-id");
            var btn = $(".btn-" + materia).text();
            if (btn === 'LER MAIS') {
                $(".btn-" + materia).text("LER MENOS");
                $('.txt-curto-' + materia).css('display', 'none');
                $('.mais-texto').css('display', 'none');
                $('.texto-' + materia).css('display', 'block');
            } else {
                $(".btn-" + materia).text("LER MAIS");
                $('.txt-curto-' + materia).css('display', 'block');
                $('.mais-texto').css('display', 'none');
                $('.texto-' + materia).css('display', 'none');
            }
        });
        $('body').delegate('.btn-filtro', 'click', function (e) {
            $('#loading').modal('open', {dismissible: false});
        });
        $('body').delegate('.btn-estatistica-tela', 'click', function (e) {
            $('#loading-grafico').modal('open', {dismissible: false});
        });
        $('body').delegate('.up_images', 'click', function (e) {
            var img = $(this).attr("data-img");
            $('.responsive-img').css('width', '100%');
            $('.mdl-img').html('<img class="img-mdl"  src="'+img+'" />');
            $('#modal-img').modal('open');
        });
        $('body').delegate('.btn-apaga-materia', 'click', function (e) {
            e.preventDefault();
            var materia = $(this).attr("data-materia");
            Swal.fire({
                title: 'Você quer realmente excluir essa materia?',
                text: "A matéria não será mais exibida para o cliente e os dados de mídia serão excluídos",
                showDenyButton: true,
                confirmButtonText: 'Sim',
                denyButtonText: `Cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        mimeType: 'text/html; charset=utf-8',
                        type: "GET",
                        dataType: "json",
                        url: '<?= base_url('sistema/Alerta/apagamateria/') ?>' + materia,
                        success: function (data) {
                            if (data['situacao'] == 1) {
                                Swal.fire(data['msg'], '', 'success');
                                $(".pub-" + materia).css('display', 'none');
                            } else {
                                Swal.fire(data['msg'], '', 'error');
                            }
                        }
                    });

                } else if (result.isDenied) {
                    Swal.fire('Nenhuma alteração foi realizada', '', 'info')
                }
            })
        });
        $('body').delegate('.btn-altera-avaliacao', 'click', function (e) {
            e.preventDefault();
            var materia = $(this).data('materia');
            var ava = $(this).data('avaliacao');
            $.ajax({
                mimeType: 'text/html; charset=utf-8',
                type: "GET",
                dataType: "json",
                url: '<?= base_url('sistema/Alerta/alteravaliacao/') ?>' + materia + '/' + ava,
                success: function (data) {
                    $(".badge-av-" + materia).text(data['avaliacao']);
                    $(".badge-av-" + materia).css('background-color', data['cor']);
                }
            });
        });
        $(document).ready(function () {
            $('.sidenav').sidenav();
            $('select').formSelect();
            $('.date').mask('00/00/0000');
            $('.time').mask('00:00');
            $(document).on('change', '.agr', function (e) {
                e.preventDefault();
                var opcao = $(".agr option:selected").val();
                if (opcao == '2') {
                    $('.veiculo-agr').css('display', 'block');
                    $('.avaliacao-agr').css('display', 'none');
                } else if (opcao == '3') {
                    $('.veiculo-agr').css('display', 'none');
                    $('.avaliacao-agr').css('display', 'block');
                } else {
                    $('.veiculo-agr').css('display', 'none');
                    $('.avaliacao-agr').css('display', 'none');
                }
            });
            $('.modal').modal();
            $('.btn-radio-play').click(playRadio);
            $('.modal').modal({
                preventScrolling: true,
                dismissible: false,
                onCloseEnd: function () {
                    $('#modal-body-content').html('');
                    $('video').trigger('pause');
                }
            });
            $('.tooltipped').tooltip();
        });
//        window.onbeforeunload = function(e) {
//            $('#loading').modal('open', {dismissible: false});
//        };
        $(document).ready(function () {
            $('.dropdown-trigger').dropdown({constrainWidth: false});
            var btn = document.querySelector("#back-to-top");
            btn.addEventListener("click", function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            var data = new Date();
            var dia = data.getDate();
            var mes = data.getMonth();
            var ano = data.getFullYear();
            var str_data = dia + '/' + (mes + 1) + '/' + ano;
            $('input[name="calendario"]').daterangepicker({
                singleDatePicker: true,
                maxDate: str_data,
                startDate: '<?= empty($lista_dias[0]['DIA']) ? $_SESSION['data_calendario'] : $lista_dias[0]['DIA'] ?>',
                locale: {
                    format: 'DD/MM/YYYY',
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "De",
                    "toLabel": "Até",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Dom",
                        "Seg",
                        "Ter",
                        "Qua",
                        "Qui",
                        "Sex",
                        "Sáb"
                    ],
                    "monthNames": [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro"
                    ],
                    "firstDay": 0
                },
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 5,
                opens: 'center',
                drops: 'auto',
                "autoApply": true
            }, function (chosen_date) {
                $('input[name="calendario').val(chosen_date.format('DD/MM/YYYY'));
                var data = chosen_date.format('YYYY-MM-DD');
                $('#loading').modal('open');
                $.ajax({
                    mimeType: 'text/html; charset=utf-8',
                    type: "GET",
                    dataType: "json",
                    url: '<?= base_url('sistema/Alerta/calendario/') ?>' + data,
                    success: function (data) {
                        window.location = '<?= base_url('alerta/') ?>' + data['chave'];
                    }
                });
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

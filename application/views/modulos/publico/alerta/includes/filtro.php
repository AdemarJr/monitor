<div class="card grey lighten-5" style="border-radius: 15px;">
    <?= form_open(base_url('sistema/Alerta/filtra'),array('role' => 'form', 'id' => 'formPadrao','class'=>'Formulario')); ?>
    <div class="card-content">
        <span class="card-title right"><i class="fas fa-filter"></i> Filtros</span>
        <p><b>Buscar</b> <span style="font-size: 10pt">(Busca no título ou texto da matéria)</span></p>
        <div class="input-field" style="margin-top: 0rem;">
            <?php 
            $termo = '';
            if (isset($_SESSION['filtro'])) {
                if (!empty($_SESSION['filtro']['termo'])) {
                    $termo = $_SESSION['filtro']['termo'];
                }
            }
            ?>
            <input id="last_name" type="text" name="termo" class="validate" placeholder="Digite o termo para procurar" value="<?= $termo ?>">
        </div>
        <div class="row" style="margin-top: -2%;  margin-bottom: 15px !important;">
            <div class="col s12 m3">
                <label style="font-size: 11pt;"><b>Agrupar por</b></label>
            </div>
        </div>
        <div class="row" style="margin-top: -2%;  margin-bottom: 15px !important;">
            <?php
            $selected_0 = '';
            $selected_2 = '';
            $selected_3 = '';
            $selected_I = '';
            $selected_P = '';
            $selected_R = '';
            $selected_T = '';
            $selected_POSI = '';
            $selected_NEG = '';
            $selected_NEU = '';
            if (isset($_SESSION['filtro'])) {
                    if ($_SESSION['filtro']['grupo-v'] == 'on') {
                        $selected_2 = 'checked';
                        
                        if ($_SESSION['filtro']['grupo_veiculo'] == 'I') {
                            $selected_I = 'selected';
                        }
                        
                        if ($_SESSION['filtro']['grupo_veiculo'] == 'S') {
                            $selected_P = 'selected';
                        }
                        
                        if ($_SESSION['filtro']['grupo_veiculo'] == 'R') {
                            $selected_R = 'selected';
                        }
                        
                        if ($_SESSION['filtro']['grupo_veiculo'] == 'T') {
                            $selected_T = 'selected';
                        }
                        
                    }
                    if ($_SESSION['filtro']['grupo-av'] == 'on') {
                        $selected_3 = 'checked';
                        
                        if ($_SESSION['filtro']['grupo_avaliacao'] == 'P') {
                            $selected_POSI = 'selected';
                        }
                        
                        if ($_SESSION['filtro']['grupo_avaliacao'] == 'N') {
                            $selected_NEG = 'selected';
                        }
                        
                        if ($_SESSION['filtro']['grupo_avaliacao'] == 'T') {
                            $selected_NEU = 'selected';
                        }
                    }
                    
                
            } else {
                $selected_0 = 'selected';
            }
            ?>
            <div class="col s12 m12">
                <div class="row">
                    <?php 
                    $dadosNota = $this->ComumModelo->getTableData('NOTA', array('CHAVE_NOTIFICACAO' => $this->uri->segment(2)))->row(); 
                    if (empty($dadosNota->TIPO_MATERIA)) {
                    ?>
                    <div class="col s12 m6">
                        <p>
                            <label>
                                <input type="checkbox" name="grupo-v" <?=  $selected_2 ?> onclick="exibeVeiculos()"/>
                                <span>VEÍCULO</span>
                            </label>
                        </p>
                    </div>
                    <?php } ?>
                    <div class="col s12 m6">
                       <p>
                            <label>
                                <input type="checkbox" name="grupo-av" <?=  $selected_3 ?> onclick="exibeAvaliacao()"/>
                                <span>AVALIAÇÃO</span>
                            </label>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 veiculo-agr" style="margin-top: 1%">
                <select class="browser-default selectBox agr_v" name="grupo-veiculo">
                    <option value="I"  <?= $selected_I ?>>IMPRESSO</option>
                    <option value="S"  <?= $selected_P ?>>INTERNET</option>
                    <option value="R"  <?= $selected_R ?>>RÁDIO</option>
                    <option value="T"  <?= $selected_T ?>>TV</option>
                </select>
            </div>
            <div class="col s12 m12 avaliacao-agr" style="margin-top: 1%">
                <select class="browser-default selectBox agr_av" name="grupo-avaliacao">
                    <option value="P"  <?= $selected_POSI ?>>POSITIVO</option>
                    <option value="N"  <?= $selected_NEG ?>>NEGATIVO</option>
                    <option value="T"  <?= $selected_NEU ?>>NEUTRO</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top: -2%; margin-bottom: 15px !important;">
            <div class="col s12 m3">
                <label style="font-size: 11pt;"><b><i class="fas fa-sort-amount-up-alt"></i> Ordenar por</b></label>
            </div>
        </div>
        <div class="row" style="margin-top: -2%; margin-bottom: 15px !important;">
            <div class="col s12 m12">
                <select class="browser-default selectBox" name="ordem">
                    <option value="0">Data de Publicação</option>
                    <option value="1">Avaliação</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top: -1%; margin-bottom: 15px !important;">
            <div class="col s12 m12">
                <?php if (!empty( $this->uri->segment(2))) {?>
                <button class="waves-effect waves-light btn-small btn-filtro"type="submit" style="width: 100px; font-weight: bold">FILTRAR</button>
                <?php } else { ?>
                <button class="waves-effect waves-light btn-small btn-filtro"type="submit" disabled="" style="width: 100px; font-weight: bold">FILTRAR</button>
                <?php } ?>
                <?php if (isset($_SESSION['filtro'])) { ?>
                <a class="waves-effect waves-light btn-small right red darken-1" style="width: 50px;margin-right: 1%;" href="<?= base_url('sistema/Alerta/limpafiltro/'.$this->uri->segment(2))?>"><i class="material-icons left">delete</i></a>
                <?php } ?>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?= $this->uri->segment(2) ?>" name="chave">
     <?= form_close() ?>
</div>
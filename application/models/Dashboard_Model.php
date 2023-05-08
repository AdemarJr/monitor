<?php

/**
 * Description of Dashboard_Model
 *
 * @author galil
 */
class Dashboard_Model extends CI_Model {
    
    public function atualiza($op) {
        $this->db->insert('ATUALIZACAO', array(
            'ATIVO' => $op
        ));
    }
    
    public function verificaAtualiza() {
        $this->db->select('ATIVO,  DATE_FORMAT(DATA_ATUALIZACAO, "%d/%m/%Y às %H:%i:%s") AS DATA_ATUALIZACAO');
        $this->db->order_by('ID_ATUALIZACAO', 'DESC');
        return $this->db->get('ATUALIZACAO')->row_array();
    }
    
    public function avaliacaoTV($periodoIni, $periodoFim) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("if(MATERIA.IND_AVALIACAO='P','APOSITIVO',if(MATERIA.IND_AVALIACAO='N','NEGATIVO','NEUTRA')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value, if(MATERIA.IND_AVALIACAO='P','#43a047',if(MATERIA.IND_AVALIACAO='N','#d32f2f','#f9a825')) as cor ");
        $this->db->join('TELEVISAO T', 'T.SEQ_TV = MATERIA.SEQ_TV');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','APOSITIVO',if(MATERIA.IND_AVALIACAO='N','NEGATIVO','NEUTRA'))");
        $this->db->where("MATERIA.TIPO_MATERIA='T'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('name');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function veiculosTVTable($periodoIni, $periodoFim, $limit1, $limit2) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("T.SEQ_TV as sitecodigo,T.NOME_TV as site, COUNT(MATERIA.SEQ_MATERIA) AS quantidade");
        $this->db->join('TELEVISAO T', 'T.SEQ_TV = MATERIA.SEQ_TV');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        $this->db->group_by("T.SEQ_TV");
        $this->db->where("MATERIA.TIPO_MATERIA='T'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('COUNT(MATERIA.SEQ_MATERIA) DESC');
        $this->db->limit($limit2, $limit1);
        $result = $this->db->get()->result_array();

        return $result;
    }
    
    public function veiculosTV($periodoIni, $periodoFim) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        // MANTIVE ERRADO PARA NÃO DAR PROBLEMA NA GERAÇÃO DO GRÁFICO
        $this->db->select("T.SEQ_TV as sitecodigo,T.NOME_TV as site, COUNT(MATERIA.SEQ_MATERIA) AS quantidade");
        $this->db->join('TELEVISAO T', 'T.SEQ_TV = MATERIA.SEQ_TV');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        $this->db->group_by("T.SEQ_TV");
        $this->db->where("MATERIA.TIPO_MATERIA='T'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('COUNT(MATERIA.SEQ_MATERIA) DESC');
        $result = $this->db->get()->result_array();
        
        return $result;
    }
    
    public function avaliaTV($periodoIni, $periodoFim, $veiculo, $avalia) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("COUNT(MATERIA.SEQ_MATERIA) AS QUANTIDADE");
        $this->db->join('TELEVISAO T', 'T.SEQ_TV = MATERIA.SEQ_TV');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by("MATERIA.IND_AVALIACAO");
        $this->db->where("T.SEQ_TV", $veiculo);
        $this->db->where("MATERIA.IND_AVALIACAO", $avalia);
        $this->db->from('MATERIA MATERIA');
        $result = $this->db->get()->row_array();
        return $result;
    }
    
    public function veiculosRadio($periodoIni, $periodoFim) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        // MANTIVE ERRADO PARA NÃO DAR PROBLEMA NA GERAÇÃO DO GRÁFICO
        $this->db->select("R.SEQ_RADIO as sitecodigo,R.NOME_RADIO as site, COUNT(MATERIA.SEQ_MATERIA) AS quantidade");
        $this->db->join('RADIO R', 'R.SEQ_RADIO = MATERIA.SEQ_RADIO');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        $this->db->group_by("R.SEQ_RADIO");
        $this->db->where("MATERIA.TIPO_MATERIA='R'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('COUNT(MATERIA.SEQ_MATERIA) DESC');
        $result = $this->db->get()->result_array();
        
        return $result;
    }
    
    public function veiculosRadioTable($periodoIni, $periodoFim, $limit1, $limit2) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("R.SEQ_RADIO as sitecodigo,R.NOME_RADIO as site, COUNT(MATERIA.SEQ_MATERIA) AS quantidade");
        $this->db->join('RADIO R', 'R.SEQ_RADIO = MATERIA.SEQ_RADIO');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        $this->db->group_by("R.SEQ_RADIO");
        $this->db->where("MATERIA.TIPO_MATERIA='R'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('COUNT(MATERIA.SEQ_MATERIA) DESC');
        $this->db->limit($limit2, $limit1);
        $result = $this->db->get()->result_array();

        return $result;
    }
    
    public function avaliaRadio($periodoIni, $periodoFim, $veiculo, $avalia) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("COUNT(MATERIA.SEQ_MATERIA) AS QUANTIDADE");
        $this->db->join('RADIO R', 'R.SEQ_RADIO = MATERIA.SEQ_RADIO');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by("MATERIA.IND_AVALIACAO");
        $this->db->where("R.SEQ_RADIO", $veiculo);
        $this->db->where("MATERIA.IND_AVALIACAO", $avalia);
        $this->db->from('MATERIA MATERIA');
        $result = $this->db->get()->row_array();
        return $result;
    }
    
    public function avaliacaoRadio($periodoIni, $periodoFim) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("if(MATERIA.IND_AVALIACAO='P','APOSITIVO',if(MATERIA.IND_AVALIACAO='N','NEGATIVO','NEUTRA')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value, if(MATERIA.IND_AVALIACAO='P','#43a047',if(MATERIA.IND_AVALIACAO='N','#d32f2f','#f9a825')) as cor ");
        $this->db->join('RADIO R', 'R.SEQ_RADIO = MATERIA.SEQ_RADIO');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','APOSITIVO',if(MATERIA.IND_AVALIACAO='N','NEGATIVO','NEUTRA'))");
        $this->db->where("MATERIA.TIPO_MATERIA='R'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('name');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function totalPortal() {
        if (isset($_SESSION['DATA_INICIAL'])) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
        }
        if (isset($_SESSION['DATA_FINAL'])) {
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
        }
        if ($_SESSION['GRUPO'] == '15') {
        $SQL = "SELECT PORTAL.NOME_PORTAL AS TOTAL FROM `MATERIA` JOIN PORTAL PORTAL ON PORTAL.SEQ_PORTAL = MATERIA.SEQ_PORTAL WHERE DATA_PUB_NUMERO BETWEEN ".$periodoIni." AND ".$periodoFim." AND MATERIA.SEQ_CLIENTE = 1 AND TIPO_MATERIA = 'S' AND PORTAL.GRUPO_PORTAL = 15 GROUP BY PORTAL.SEQ_PORTAL";
        } else {
        $SQL = "SELECT PORTAL.NOME_PORTAL AS TOTAL FROM `MATERIA` JOIN PORTAL PORTAL ON PORTAL.SEQ_PORTAL = MATERIA.SEQ_PORTAL WHERE DATA_PUB_NUMERO BETWEEN ".$periodoIni." AND ".$periodoFim." AND MATERIA.SEQ_CLIENTE = 1 AND TIPO_MATERIA = 'S' GROUP BY PORTAL.SEQ_PORTAL";            
        }
        return $this->db->query($SQL)->result();
    }
    
    public function internetGeral() {
        if (isset($_SESSION['DATA_INICIAL'])) {
            $dia_anterior = explode('/', $_SESSION['DATA_INICIAL']);
            $periodoIni = $dia_anterior[2] . $dia_anterior[1] . $dia_anterior[0];
        }
        if (isset($_SESSION['DATA_FINAL'])) {
            $dia_anterior2 = explode('/', $_SESSION['DATA_FINAL']);
            $periodoFim = $dia_anterior2[2] . $dia_anterior2[1] . $dia_anterior2[0];
        }
        $this->db->select('M.SEQ_PORTAL, P.NOME_PORTAL');
        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = M.SEQ_PORTAL');
        $this->db->where('M.DATA_PUB_NUMERO BETWEEN '. $periodoIni. ' AND '. $periodoFim);
        $this->db->where('M.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->group_by('M.SEQ_PORTAL');
        return $this->db->get('MATERIA M')->result();
    }
    
    public function veiculosTotal() {
        $this->db->where('DATE(DATA) = CURDATE()');
        $this->db->order_by('ID_VEICULOS_MONITORADOS DESC');
        $this->db->limit(1);
        return $this->db->get('VEICULOS_MONITORADOS')->result_array();
    }
    
    public function veiculosMonitorados($veiculo) {
        $this->db->insert('VEICULOS_MONITORADOS', array('TOTAL'=> $veiculo[0]['TOTAL']));
    }
    
    public function veiculosMonitoras() {
        $SQL = 'SELECT COUNT(SEQ_MATERIA) AS TOTAL FROM `MATERIA` 
        WHERE TIPO_MATERIA = "S"
        AND DATE(DATA_PUB_NUMERO) > (DATE_SUB(CURDATE(), INTERVAL 1 DAY))
        AND SEQ_CLIENTE = '.$this->session->userData('idClienteSessao');

        return $this->db->query($SQL)->result_array();
    }

    public function materiasCadastradasInternet($periodoIni, $periodoFim) {
        $SQL = "SELECT COUNT(SEQ_MATERIA) AS TOTAL FROM MATERIA M JOIN PORTAL P ON P.SEQ_PORTAL = M.SEQ_PORTAL WHERE M.SEQ_CLIENTE = ".$this->session->userData('idClienteSessao')." AND M.DATA_PUB_NUMERO BETWEEN '".$periodoIni."' AND '".$periodoFim."'";
        return $this->db->query($SQL)->result_array();
    }

    public function avaliacaoInternet($periodoIni, $periodoFim) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("if(MATERIA.IND_AVALIACAO='P','APOSITIVO',if(MATERIA.IND_AVALIACAO='N','NEGATIVO','NEUTRA')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value, if(MATERIA.IND_AVALIACAO='P','#43a047',if(MATERIA.IND_AVALIACAO='N','#d32f2f','#f9a825')) as cor ");
        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = MATERIA.SEQ_PORTAL');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        if ($this->session->userData('GRUPO') == 15){
        $this->db->where('P.GRUPO_PORTAL', $this->session->userData('GRUPO'));
        }
        $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','APOSITIVO',if(MATERIA.IND_AVALIACAO='N','NEGATIVO','NEUTRA'))");
        $this->db->where("MATERIA.TIPO_MATERIA='S'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('name');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    public function veiculosInternet($periodoIni, $periodoFim) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("P.SEQ_PORTAL AS sitecodigo,P.NOME_PORTAL as site, COUNT(MATERIA.SEQ_MATERIA) AS quantidade");
        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = MATERIA.SEQ_PORTAL');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        if ($this->session->userData('GRUPO') == 15){
        $this->db->where('P.GRUPO_PORTAL', $this->session->userData('GRUPO'));
        }
        $this->db->group_by("P.SEQ_PORTAL");
        $this->db->where("MATERIA.TIPO_MATERIA='S'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('COUNT(MATERIA.SEQ_MATERIA) DESC');
        $result = $this->db->get()->result_array();
        
        return $result;
    }
    
    public function veiculosInternetTable($periodoIni, $periodoFim, $ordem, $limit1, $limit2) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("P.SEQ_PORTAL AS sitecodigo,P.NOME_PORTAL as site, COUNT(MATERIA.SEQ_MATERIA) AS quantidade");
        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = MATERIA.SEQ_PORTAL');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
        if ($this->session->userData('GRUPO') == 15){
        $this->db->where('P.GRUPO_PORTAL', $this->session->userData('GRUPO'));
        }
        $this->db->group_by("P.SEQ_PORTAL");
        $this->db->where("MATERIA.TIPO_MATERIA='S'");
        $this->db->from('MATERIA MATERIA');
        $this->db->order_by('COUNT(MATERIA.SEQ_MATERIA) DESC');
        $this->db->limit($limit2, $limit1);
        $result = $this->db->get()->result_array();

        return $result;
    }
    
    public function av($periodoIni, $periodoFim, $veiculo, $op) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if ($op == 1) {
        $this->db->where("RA.DATA BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        }
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("MATERIA.IND_AVALIACAO AS AVALIACAO,COUNT(MATERIA.SEQ_MATERIA) AS QUANTIDADE");
        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = MATERIA.SEQ_PORTAL');
        if ($op == 1) {
        $this->db->join('RELEASE_MATERIA RA', 'RA.SEQ_RELEASE = MATERIA.SEQ_RELEASE');
        }
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by("MATERIA.IND_AVALIACAO");
        $this->db->where("P.SEQ_PORTAL", $veiculo);
        $this->db->from('MATERIA MATERIA');
        $result = $this->db->get()->row_array();
        return $result;
    }
    
    public function avalia($periodoIni, $periodoFim, $veiculo, $avalia) {
        $this->db->where("DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " and " . trim($periodoFim));
        if (!empty($this->session->userData('idClienteSessao'))) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        }
        $this->db->select("COUNT(MATERIA.SEQ_MATERIA) AS QUANTIDADE");
        $this->db->join('PORTAL P', 'P.SEQ_PORTAL = MATERIA.SEQ_PORTAL');
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by("MATERIA.IND_AVALIACAO");
        $this->db->where("P.SEQ_PORTAL", $veiculo);
        $this->db->where("MATERIA.IND_AVALIACAO", $avalia);
        $this->db->from('MATERIA MATERIA');
        $result = $this->db->get()->row_array();
        return $result;
    }
    
    public function quantitativoReleaseVeiculo($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL, $ordem, $limit)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);
        /*
        $slq ="SELECT  C.SEQ_PORTAL as sitecodigo, C.NOME_PORTAL as site, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." INNER JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." GROUP BY C.SEQ_PORTAL, C.NOME_PORTAL "
            ." ORDER BY 3 DESC" ;*/

        $slq = "SELECT X.sitecodigo, X.site, X.quantidade FROM ( SELECT C.SEQ_PORTAL AS sitecodigo, C.NOME_PORTAL AS site,  "
        ." (SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN RELEASE_MATERIA A  ON A.SEQ_RELEASE=B.SEQ_RELEASE "
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
        ." AND C.SEQ_PORTAL=B.SEQ_PORTAL AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
        ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
        ." ) AS quantidade FROM  PORTAL C WHERE C.SEQ_CLIENTE =".$idCliente." AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
        ." ORDER BY 3 DESC ) X WHERE X.quantidade>0 ORDER BY 3 DESC LIMIT ".$limit;

        $query = $this->db->query($slq);

        return $query->result_array();

    }
}

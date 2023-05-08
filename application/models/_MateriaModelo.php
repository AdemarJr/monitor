<?php
class MateriaModelo extends CI_Model {

    var $order_column = array(
        "MATERIA.SEQ_MATERIA",
        "MATERIA.TIPO_MATERIA",
        "2",
        "MATERIA.DATA_MATERIA_PUB",
        "TIPO_MATERIA.DESC_TIPO_MATERIA",
        "5",
        null);

    public function __construct()
        {
			$this->load->database();
        }
	
	public function listaMateria($sort = 'SEQ_MATERIA',$order = 'asc', $limit = null, $offset = null) {

            $this->db->order_by($sort, $order);
        if($limit)
            $this->db->limit($limit,$offset);

        $this->db->select('*');
        $this->db->from('MATERIA');

        $arrayTipo = array();
        if ( ($this->auth->CheckMenu('geral','materia','novoi')==1)) {
            array_push($arrayTipo,'I');
        }
        if ( ($this->auth->CheckMenu('geral','materia','novos')==1)) {
            array_push($arrayTipo,'S');
        }
        if ( ($this->auth->CheckMenu('geral','materia','novor')==1)) {
            array_push($arrayTipo,'R');
        }
        if (count($arrayTipo)>0)
            $this->db->where_in('TIPO_MATERIA',$arrayTipo);
            else
                $this->db->where('TIPO_MATERIA IS NULL');


        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));

        if ($this->session->userData('perfilUsuario')=='ROLE_REP' or $this->session->userdata('idUsuario')==41) {
            $this->db->where('SEQ_USUARIO', $this->session->userData('idUsuario'));
        //    $this->db->where('IND_STATUS', 'C');
        } else {
            $this->db->where("IND_STATUS='E'");
        }

        $this->db->order_by('SEQ_MATERIA', 'ASC');

        $query = $this->db->get();

		return $query->result_array();
    }
    public function listaAnexo($id) {
        $this->db->order_by('ORDEM_ARQUIVO', 'ASC');
        $this->db->where('SEQ_MATERIA', $id);
        $query = $this->db->get('ANEXO');
        return $query->result_array();
    }
    public function listaAudio() {
        $this->db->where("lower(NOME_BIN_ARQUIVO) like '%.mp3%' or lower(NOME_BIN_ARQUIVO) like '%.wav%'");
        $query = $this->db->get('ANEXO');
        return $query->result_array();
    }
    public function listaVideo() {
        $this->db->where("lower(NOME_BIN_ARQUIVO) like '%.mp4%' and (`SEC_ARQUIVO`=0 or `SEC_ARQUIVO` is null)");
        $query = $this->db->get('ANEXO');
        return $query->result_array();
    }
    public function getAnexo($id) {
        $this->db->where('SEQ_ANEXO', $id);
        return  $this->db->get('ANEXO');
    }
        # inserir empresa
    public function inserir($data_os=NULL)
	{
		$this->db->insert('MATERIA', $data_os);

		return $this->db->insert_id();
	}
    public function inserirAnexo($data_os=NULL)
    {
        $this->load->database();
        $this->db->reconnect();
        $this->db->insert('ANEXO', $data_os);
        return $this->db->insert_id();
    }
    //editar um empresa
    public function getOrdem($id) {
        $this->load->database();
        $this->db->reconnect();

        $this->db->select('(IFNULL(MAX(ORDEM_ARQUIVO),0)+1) AS ORDEM ');
        $this->db->where('SEQ_MATERIA', $id);
        $query = $this->db->get('ANEXO');
        return $query->row()->ORDEM;
    }

	//editar um empresa
	public function editar($id) {

        $this->db->select('OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS CHAVE, MATERIA.*',false);

		$this->db->where('SEQ_MATERIA', $id);
		$query = $this->db->get('MATERIA');
		return $query->result_array();
	}
	public function deletar($id) {
        $this->db->where('SEQ_MATERIA', $id);
        $dataMateriaArray =  $this->db->get('MATERIA')->result_array();

        $this->db->insert('MATERIA_DELETADA', $dataMateriaArray[0]);

		$this->db->where('SEQ_MATERIA', $id);
    	return $this->db->delete('MATERIA');
    }
    public function deletarAnexo($id) {
        $this->db->where('SEQ_MATERIA', $id);
        return $this->db->delete('ANEXO');
    }

    public function deletarAnexoBySeq($id) {
        $this->db->where('SEQ_ANEXO', $id);
        return $this->db->delete('ANEXO');
    }

	
	public function alterar($tb_empresa_servico,$idMateria) {
		$this->db->where('SEQ_MATERIA', $idMateria);
		return $this->db->update('MATERIA',$tb_empresa_servico);
	}

    public function indicadorRep(){
        $result = null;

        if ($this->session->userData('perfilUsuario')=='ROLE_REP') {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('SEQ_USUARIO', $this->session->userData('idUsuario'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->select('MATERIA.SEQ_MATERIA');
;            $this->db->from('MATERIA');
            $totalCadastrada =$this->db->count_all_results();

            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('SEQ_USUARIO', $this->session->userData('idUsuario'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $this->db->where("DATE_FORMAT(DATA_MATERIA_CAD,'%Y-%m-%d')=DATE_FORMAT(sysdate(),'%Y-%m-%d')");


            $hojeCadastrada =$this->db->count_all_results();

            $result = array(
                'ind2'=>$totalCadastrada,
                'ind1'=>$hojeCadastrada
            );


        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM'){

            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $totalCadastrada =$this->db->count_all_results();

            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $this->db->where("DATE_FORMAT(DATA_MATERIA_CAD,'%Y-%m-%d')=DATE_FORMAT(sysdate(),'%Y-%m-%d')");

            $hojeCadastrada =$this->db->count_all_results();

            $result = array(
                'ind2'=>$totalCadastrada,
                'ind1'=>$hojeCadastrada
            );
        }

        return $result;
    }
    public function indicadorRep2(){
        $result = null;

        if ($this->session->userData('perfilUsuario')=='ROLE_REP') {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('SEQ_USUARIO', $this->session->userData('idUsuario'));
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->where('SEQ_PORTAL > 0');
            $this->db->from('MATERIA');
            $totalCadastrada =$this->db->count_all_results();

            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('SEQ_USUARIO', $this->session->userData('idUsuario'));
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->where('SEQ_PORTAL > 0');
            $this->db->from('MATERIA');
            $this->db->where("DATE_FORMAT(DATA_MATERIA_CAD,'%Y-%m-%d')=DATE_FORMAT(sysdate(),'%Y-%m-%d')");


            $hojeCadastrada =$this->db->count_all_results();

            $result = array(
                'ind2'=>$totalCadastrada,
                'ind1'=>$hojeCadastrada
            );


        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM'){

            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $totalCadastrada =$this->db->count_all_results();

            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $this->db->where("DATE_FORMAT(DATA_MATERIA_CAD,'%Y-%m-%d')=DATE_FORMAT(sysdate(),'%Y-%m-%d')");

            $hojeCadastrada =$this->db->count_all_results();

            $result = array(
                'ind2'=>$totalCadastrada,
                'ind1'=>$hojeCadastrada
            );
        }

        return $result;
    }
    public function indicadorCli($datai,$dataf){
        $result = null;
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
            if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
                ($this->session->userData('perfilUsuario')=='ROLE_USU')) {

            // demanda espontanea
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where("IND_CLASSIFICACAO='E'");
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $demandaEspontanea =$this->db->count_all_results();

            // materia exclusiva
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'X');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $materiaExclusiva =$this->db->count_all_results();

            // materia exclusiva
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $releaseIntegra =$this->db->count_all_results();

            // materia parcial
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $releaseParcial =$this->db->count_all_results();

            // total positivo
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');

            $totalPositivo =$this->db->count_all_results();

            // total negativo
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'N');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $totalNegativo =$this->db->count_all_results();

            // total neutra
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'T');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $totalNeutra =$this->db->count_all_results();

            $totalGeral = $totalPositivo+$totalNegativo+$totalNeutra;

            // veiculos monitorados
            $this->db->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->from('VEICULO');
            $totalVeiculo =$this->db->count_all_results();


            $result = array(
                'ind1'=>$demandaEspontanea,
                'ind2'=>$materiaExclusiva,
                'ind3'=>$releaseIntegra,
                'ind4'=>$releaseParcial,
                'ind5'=>$totalPositivo,
                'ind6'=>$totalNegativo,
                'ind7'=>$totalGeral,
                'ind8'=>$totalVeiculo,
                'ind9'=>$totalNeutra
            );


        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM'){

            // demanda espontanea
            if (!empty($this->session->userData('idClienteSessao')))
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'E');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $demandaEspontanea =$this->db->count_all_results();

            // materia exclusiva
            if (!empty($this->session->userData('idClienteSessao')))
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'X');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $materiaExclusiva =$this->db->count_all_results();

            // materia exclusiva
            if (!empty($this->session->userData('idClienteSessao')))
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $releaseIntegra =$this->db->count_all_results();

            // materia parcial
            if (!empty($this->session->userData('idClienteSessao')))
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $releaseParcial =$this->db->count_all_results();

            // total positivo
            if (!empty($this->session->userData('idClienteSessao')))
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->from('MATERIA');

            $totalPositivo =$this->db->count_all_results();

            // total negativo
            if (!empty($this->session->userData('idClienteSessao')))
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'N');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $totalNegativo =$this->db->count_all_results();

            // total neutra
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'T');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $totalNeutra =$this->db->count_all_results();

            $totalGeral = $totalPositivo+$totalNegativo+$totalNeutra;

            // veiculos monitorados
            if (!empty($this->session->userData('idClienteSessao')))
            $this->db->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->from('VEICULO');
            $totalVeiculo =$this->db->count_all_results();


            $result = array(
                'ind1'=>$demandaEspontanea,
                'ind2'=>$materiaExclusiva,
                'ind3'=>$releaseIntegra,
                'ind4'=>$releaseParcial,
                'ind5'=>$totalPositivo,
                'ind6'=>$totalNegativo,
                'ind7'=>$totalGeral,
                'ind8'=>$totalVeiculo,
                'ind9'=>$totalNeutra
            );
        }

        return $result;
    }
    public function indicadorCli2($datai,$dataf,$grupo){
        $result = null;
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU')) {

            // demanda espontanea
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }else {
                $this->db->where('SEQ_PORTAL > 0');
            }
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where("IND_CLASSIFICACAO='E'");
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $demandaEspontanea =$this->db->count_all_results();

            // materia exclusiva
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }else{}
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'X');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->select('MATERIA.SEQ_MATERIA');
            $this->db->from('MATERIA');
            $materiaExclusiva =$this->db->count_all_results();

            // materia exclusiva
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $releaseIntegra =$this->db->count_all_results();

            // materia parcial
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $releaseParcial =$this->db->count_all_results();

            // total positivo
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $totalPositivo =$this->db->count_all_results();

            // total negativo
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'N');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $totalNegativo =$this->db->count_all_results();

            // total neutra
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'T');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $totalNeutra =$this->db->count_all_results();

            $totalGeral = $totalPositivo+$totalNegativo+$totalNeutra;

            // veiculos monitorados
            if(!empty($grupo)){
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            $this->db->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->from('PORTAL');
            $totalVeiculo =$this->db->count_all_results();


            $result = array(
                'ind1'=>$demandaEspontanea,
                'ind2'=>$materiaExclusiva,
                'ind3'=>$releaseIntegra,
                'ind4'=>$releaseParcial,
                'ind5'=>$totalPositivo,
                'ind6'=>$totalNegativo,
                'ind7'=>$totalGeral,
                'ind8'=>$totalVeiculo,
                'ind9'=>$totalNeutra
            );


        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM'){

            // demanda espontanea
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'E');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $demandaEspontanea =$this->db->count_all_results();

            // materia exclusiva
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'X');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $materiaExclusiva =$this->db->count_all_results();

            // materia exclusiva
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $releaseIntegra =$this->db->count_all_results();

            // materia parcial
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $releaseParcial =$this->db->count_all_results();

            // total positivo
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $totalPositivo =$this->db->count_all_results();

            // total negativo
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'N');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $totalNegativo =$this->db->count_all_results();

            // total neutra
            if(!empty($grupo)){
                $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'T');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $totalNeutra =$this->db->count_all_results();

            $totalGeral = $totalPositivo+$totalNegativo+$totalNeutra;

            // veiculos monitorados
            if(!empty($grupo)){
                $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
            }
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->from('PORTAL');
            $totalVeiculo =$this->db->count_all_results();


            $result = array(
                'ind1'=>$demandaEspontanea,
                'ind2'=>$materiaExclusiva,
                'ind3'=>$releaseIntegra,
                'ind4'=>$releaseParcial,
                'ind5'=>$totalPositivo,
                'ind6'=>$totalNegativo,
                'ind7'=>$totalGeral,
                'ind8'=>$totalVeiculo,
                'ind9'=>$totalNeutra
            );
        }

        return $result;
    }
    public function indicadorCli3($datai,$dataf){
        $result = null;
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU')) {

            // demanda espontanea
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where("IND_CLASSIFICACAO='E'");
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $demandaEspontanea =$this->db->count_all_results();

            // materia exclusiva
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'X');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $materiaExclusiva =$this->db->count_all_results();

            // materia exclusiva
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $releaseIntegra =$this->db->count_all_results();

            // materia parcial
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $releaseParcial =$this->db->count_all_results();

            // total positivo
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $totalPositivo =$this->db->count_all_results();

            // total negativo
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'N');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $totalNegativo =$this->db->count_all_results();

            // total neutra
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'T');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $totalNeutra =$this->db->count_all_results();

            $totalGeral = $totalPositivo+$totalNegativo+$totalNeutra;

            // veiculos monitorados
            $this->db->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->from('RADIO');
            $totalVeiculo =$this->db->count_all_results();


            $result = array(
                'ind1'=>$demandaEspontanea,
                'ind2'=>$materiaExclusiva,
                'ind3'=>$releaseIntegra,
                'ind4'=>$releaseParcial,
                'ind5'=>$totalPositivo,
                'ind6'=>$totalNegativo,
                'ind7'=>$totalGeral,
                'ind8'=>$totalVeiculo,
                'ind9'=>$totalNeutra
            );


        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM'){

            // demanda espontanea
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'E');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $demandaEspontanea =$this->db->count_all_results();

            // materia exclusiva
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'X');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $materiaExclusiva =$this->db->count_all_results();

            // materia exclusiva
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $releaseIntegra =$this->db->count_all_results();

            // materia parcial
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $releaseParcial =$this->db->count_all_results();

            // total positivo
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $totalPositivo =$this->db->count_all_results();

            // total negativo
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'N');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $totalNegativo =$this->db->count_all_results();

            // total neutra
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'T');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $totalNeutra =$this->db->count_all_results();

            $totalGeral = $totalPositivo+$totalNegativo+$totalNeutra;

            // veiculos monitorados
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->from('RADIO');
            $totalVeiculo =$this->db->count_all_results();


            $result = array(
                'ind1'=>$demandaEspontanea,
                'ind2'=>$materiaExclusiva,
                'ind3'=>$releaseIntegra,
                'ind4'=>$releaseParcial,
                'ind5'=>$totalPositivo,
                'ind6'=>$totalNegativo,
                'ind7'=>$totalGeral,
                'ind8'=>$totalVeiculo,
                'ind9'=>$totalNeutra
            );
        }

        return $result;
    }
    public function indicadorCli4($datai,$dataf){
        $result = null;
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU')) {

            // demanda espontanea
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where("IND_CLASSIFICACAO='E'");
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $demandaEspontanea =$this->db->count_all_results();

            // materia exclusiva
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'X');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $materiaExclusiva =$this->db->count_all_results();

            // materia exclusiva
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $releaseIntegra =$this->db->count_all_results();

            // materia parcial
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_CLASSIFICACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $releaseParcial =$this->db->count_all_results();

            // total positivo
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $totalPositivo =$this->db->count_all_results();

            // total negativo
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'N');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $totalNegativo =$this->db->count_all_results();

            // total neutra
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('IND_AVALIACAO', 'T');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $totalNeutra =$this->db->count_all_results();

            $totalGeral = $totalPositivo+$totalNegativo+$totalNeutra;

            // veiculos monitorados
            $this->db->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->from('TELEVISAO');
            $totalVeiculo =$this->db->count_all_results();


            $result = array(
                'ind1'=>$demandaEspontanea,
                'ind2'=>$materiaExclusiva,
                'ind3'=>$releaseIntegra,
                'ind4'=>$releaseParcial,
                'ind5'=>$totalPositivo,
                'ind6'=>$totalNegativo,
                'ind7'=>$totalGeral,
                'ind8'=>$totalVeiculo,
                'ind9'=>$totalNeutra
            );


        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM'){

            // demanda espontanea
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'E');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $demandaEspontanea =$this->db->count_all_results();

            // materia exclusiva
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'X');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $materiaExclusiva =$this->db->count_all_results();

            // materia exclusiva
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $releaseIntegra =$this->db->count_all_results();

            // materia parcial
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_CLASSIFICACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $releaseParcial =$this->db->count_all_results();

            // total positivo
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'P');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $totalPositivo =$this->db->count_all_results();

            // total negativo
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'N');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $totalNegativo =$this->db->count_all_results();

            // total neutra
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where('IND_AVALIACAO', 'T');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('IND_STATUS', array('E','F'));
            $this->db->where('SEQ_TV > 0');
            $this->db->from('MATERIA');
            $totalNeutra =$this->db->count_all_results();

            $totalGeral = $totalPositivo+$totalNegativo+$totalNeutra;

            // veiculos monitorados
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->from('TELEVISAO');
            $totalVeiculo =$this->db->count_all_results();


            $result = array(
                'ind1'=>$demandaEspontanea,
                'ind2'=>$materiaExclusiva,
                'ind3'=>$releaseIntegra,
                'ind4'=>$releaseParcial,
                'ind5'=>$totalPositivo,
                'ind6'=>$totalNegativo,
                'ind7'=>$totalGeral,
                'ind8'=>$totalVeiculo,
                'ind9'=>$totalNeutra
            );
        }

        return $result;
    }

    public function getMateria($id) {
        $this->db->select('OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS CHAVE, MATERIA.*',false);

        $this->db->where('SEQ_MATERIA', $id);
        return $this->db->get('MATERIA');
    }

    public function pieRep(){
        $result=array();
        if ($this->session->userData('perfilUsuario')=='ROLE_REP') {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('MATERIA.SEQ_USUARIO', $this->session->userData('idUsuario'));
            $this->db->select('VEICULO.FANTASIA_VEICULO as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value');
            $this->db->join('VEICULO', 'VEICULO.SEQ_VEICULO=MATERIA.SEQ_VEICULO');
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->group_by('VEICULO.FANTASIA_VEICULO');
            $this->db->where('MATERIA.SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select('VEICULO.FANTASIA_VEICULO as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value');
            $this->db->join('VEICULO', 'VEICULO.SEQ_VEICULO=MATERIA.SEQ_VEICULO');
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->group_by('VEICULO.FANTASIA_VEICULO');
            $this->db->where('MATERIA.SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieRep2(){
        $result=array();
        if ($this->session->userData('perfilUsuario')=='ROLE_REP') {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->where('MATERIA.SEQ_USUARIO', $this->session->userData('idUsuario'));
            $this->db->select('PORTAL.NOME_PORTAL as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value');
            $this->db->join('PORTAL', 'PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->group_by('PORTAL.NOME_PORTAL');
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select('PORTAL.NOME_PORTAL as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value');
            $this->db->join('PORTAL', 'PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->group_by('PORTAL.NOME_PORTAL');
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliAval($datai,$dataf){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
            $this->db->where('MATERIA.TIPO_MATERIA', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra'))");
            $this->db->where('MATERIA.SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
            $this->db->where('MATERIA.TIPO_MATERIA', 'I');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra'))");
            $this->db->where('MATERIA.SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliAval2($datai,$dataf,$grupo){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
//        if ($this->session->userData('perfilUsuario')=='ROLE_

        if(!empty($grupo)){
            $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {

            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra'))");
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra'))");
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliAval3($datai,$dataf){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
//        if ($this->session->userData('perfilUsuario')=='ROLE_
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {

            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra'))");
            $this->db->where('MATERIA.TIPO_MATERIA','R');
            $this->db->where('MATERIA.SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra'))");
            $this->db->where('MATERIA.TIPO_MATERIA','R');
            $this->db->where('MATERIA.SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliAval4($datai,$dataf){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
//        if ($this->session->userData('perfilUsuario')=='ROLE_
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {

            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra'))");
            $this->db->where('MATERIA.TIPO_MATERIA','T');
            $this->db->where('MATERIA.SEQ_TV > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra')) as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where('MATERIA.IND_AVALIACAO IS NOT NULL');
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->group_by("if(MATERIA.IND_AVALIACAO='P','Positivo',if(MATERIA.IND_AVALIACAO='N','Negativo','Neutra'))");
            $this->db->where('MATERIA.TIPO_MATERIA','T');
            $this->db->where('MATERIA.SEQ_TV > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliOri($datai,$dataf){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("CLASSIFICACAO.DESC_CLASSIFICACAO  as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->join('CLASSIFICACAO', 'CLASSIFICACAO.IND_CLASSIFICACAO=MATERIA.IND_CLASSIFICACAO');
            $this->db->group_by('CLASSIFICACAO.IND_CLASSIFICACAO');
            $this->db->where('MATERIA.SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select("CLASSIFICACAO.DESC_CLASSIFICACAO  as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->join('CLASSIFICACAO', 'CLASSIFICACAO.IND_CLASSIFICACAO=MATERIA.IND_CLASSIFICACAO');
            $this->db->group_by('CLASSIFICACAO.IND_CLASSIFICACAO');
            $this->db->where('MATERIA.SEQ_VEICULO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliOri2($datai,$dataf,$grupo){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        if(!empty($grupo)){
            $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("CLASSIFICACAO.DESC_CLASSIFICACAO  as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->join('CLASSIFICACAO', 'CLASSIFICACAO.IND_CLASSIFICACAO=MATERIA.IND_CLASSIFICACAO');
            $this->db->group_by('CLASSIFICACAO.IND_CLASSIFICACAO');
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select("CLASSIFICACAO.DESC_CLASSIFICACAO  as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->join('CLASSIFICACAO', 'CLASSIFICACAO.IND_CLASSIFICACAO=MATERIA.IND_CLASSIFICACAO');
            $this->db->group_by('CLASSIFICACAO.IND_CLASSIFICACAO');
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliOri3($datai,$dataf){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("CLASSIFICACAO.DESC_CLASSIFICACAO  as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->join('CLASSIFICACAO', 'CLASSIFICACAO.IND_CLASSIFICACAO=MATERIA.IND_CLASSIFICACAO');
            $this->db->group_by('CLASSIFICACAO.IND_CLASSIFICACAO');
            $this->db->where('MATERIA.TIPO_MATERIA','R');
            $this->db->where('MATERIA.SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select("CLASSIFICACAO.DESC_CLASSIFICACAO  as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->join('CLASSIFICACAO', 'CLASSIFICACAO.IND_CLASSIFICACAO=MATERIA.IND_CLASSIFICACAO');
            $this->db->group_by('CLASSIFICACAO.IND_CLASSIFICACAO');
            $this->db->where('MATERIA.TIPO_MATERIA','R');
            $this->db->where('MATERIA.SEQ_RADIO > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliOri4($datai,$dataf){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("CLASSIFICACAO.DESC_CLASSIFICACAO  as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->join('CLASSIFICACAO', 'CLASSIFICACAO.IND_CLASSIFICACAO=MATERIA.IND_CLASSIFICACAO');
            $this->db->group_by('CLASSIFICACAO.IND_CLASSIFICACAO');
            $this->db->where('MATERIA.TIPO_MATERIA','T');
            $this->db->where('MATERIA.SEQ_TV > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select("CLASSIFICACAO.DESC_CLASSIFICACAO  as name, (COUNT(MATERIA.SEQ_MATERIA)) AS value");
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->join('CLASSIFICACAO', 'CLASSIFICACAO.IND_CLASSIFICACAO=MATERIA.IND_CLASSIFICACAO');
            $this->db->group_by('CLASSIFICACAO.IND_CLASSIFICACAO');
            $this->db->where('MATERIA.TIPO_MATERIA','T');
            $this->db->where('MATERIA.SEQ_TV > 0');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliVeiculo($datai,$dataf){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

    //    $this->db->distinct();
        $this->db->order_by('3','asc');
        if (($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('VEICULO.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
//            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select('VEICULO.SEQ_VEICULO, VEICULO.FANTASIA_VEICULO, count(MATERIA.SEQ_MATERIA) as qtd');
//            $this->db->join('MATERIA', 'VEICULO.SEQ_VEICULO=MATERIA.SEQ_VEICULO');
            $this->db->join("MATERIA", "VEICULO.SEQ_VEICULO=MATERIA.SEQ_VEICULO AND MATERIA.TIPO_MATERIA='I'  AND MATERIA.IND_STATUS IN('E', 'F') AND MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim),'left');
//            $this->db->where('MATERIA.SEQ_VEICULO > 0');
//            $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
//            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->group_by('VEICULO.SEQ_VEICULO, VEICULO.FANTASIA_VEICULO');
            $this->db->from('VEICULO');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('VEICULO.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select('VEICULO.SEQ_VEICULO, VEICULO.FANTASIA_VEICULO, count(MATERIA.SEQ_MATERIA) as qtd');
            $this->db->join("MATERIA", "VEICULO.SEQ_VEICULO=MATERIA.SEQ_VEICULO AND MATERIA.TIPO_MATERIA='I'  AND MATERIA.IND_STATUS IN('E', 'F') AND MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim),'left');
//            $this->db->join('MATERIA', 'VEICULO.SEQ_VEICULO=MATERIA.SEQ_VEICULO');
//            $this->db->where('MATERIA.SEQ_VEICULO > 0');
//            $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
//            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->group_by('VEICULO.SEQ_VEICULO, VEICULO.FANTASIA_VEICULO');
                $this->db->from('VEICULO');
                $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliVeiculo2($datai,$dataf,$grupo){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($grupo)){
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }
   //     $this->db->distinct();
        $this->db->order_by('3','asc');
        if ( ($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('PORTAL.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
//            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select('PORTAL.SEQ_PORTAL, PORTAL.NOME_PORTAL, count(MATERIA.SEQ_MATERIA) as qtd');
            $this->db->join("MATERIA", "PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL AND MATERIA.TIPO_MATERIA='S'  AND MATERIA.IND_STATUS IN('E', 'F') AND MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim),'left');
//            $this->db->where('MATERIA.SEQ_PORTAL > 0');
//            $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
//            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->group_by('PORTAL.SEQ_PORTAL, PORTAL.NOME_PORTAL');
            $this->db->from('PORTAL');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('PORTAL.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select('PORTAL.SEQ_PORTAL, PORTAL.NOME_PORTAL, count(MATERIA.SEQ_MATERIA) as qtd');
            $this->db->join("MATERIA", "PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL AND MATERIA.TIPO_MATERIA='S'  AND MATERIA.IND_STATUS IN('E', 'F') AND MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim),'left');
//            $this->db->where('MATERIA.SEQ_PORTAL > 0');
//            $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->group_by('PORTAL.SEQ_PORTAL, PORTAL.NOME_PORTAL');
            $this->db->from('PORTAL');

            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliVeiculo3($datai,$dataf){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->distinct();
        $this->db->order_by('3','ASC');
        if ( ($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('RADIO.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
//            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->group_by('RADIO.SEQ_RADIO, RADIO.NOME_RADIO');
            $this->db->select('RADIO.SEQ_RADIO, RADIO.NOME_RADIO, count(MATERIA.SEQ_MATERIA) as qtd');
            $this->db->join("MATERIA", "RADIO.SEQ_RADIO=MATERIA.SEQ_RADIO AND MATERIA.TIPO_MATERIA='R'  AND MATERIA.IND_STATUS IN('E', 'F') AND MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim),'left');
            $this->db->from('RADIO');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('RADIO.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select('RADIO.SEQ_RADIO, RADIO.NOME_RADIO, count(MATERIA.SEQ_MATERIA) as qtd');
            $this->db->join("MATERIA", "RADIO.SEQ_RADIO=MATERIA.SEQ_RADIO AND MATERIA.TIPO_MATERIA='R'  AND MATERIA.IND_STATUS IN('E', 'F') AND MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim),'left');
            $this->db->from('RADIO');
            $this->db->group_by('RADIO.SEQ_RADIO, RADIO.NOME_RADIO');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieCliVeiculo4($datai,$dataf){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->distinct();
        $this->db->order_by('3','ASC');
        if ( ($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('TELEVISAO.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->group_by('TELEVISAO.SEQ_TV, TELEVISAO.NOME_TV');
            $this->db->select('TELEVISAO.SEQ_TV, TELEVISAO.NOME_TV, count(MATERIA.SEQ_MATERIA) as qtd');
            $this->db->join("MATERIA", "TELEVISAO.SEQ_TV=MATERIA.SEQ_TV AND MATERIA.TIPO_MATERIA='R'  AND MATERIA.IND_STATUS IN('E', 'F') AND MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim),'left');
            $this->db->from('TELEVISAO');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('TELEVISAO.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select('TELEVISAO.SEQ_TV, TELEVISAO.NOME_TV, count(MATERIA.SEQ_MATERIA) as qtd');
            $this->db->join("MATERIA", "TELEVISAO.SEQ_TV=MATERIA.SEQ_TV AND MATERIA.TIPO_MATERIA='R'  AND MATERIA.IND_STATUS IN('E', 'F') AND MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim),'left');
            $this->db->from('TELEVISAO');
            $this->db->group_by('TELEVISAO.SEQ_TV, TELEVISAO.NOME_TV');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function pieClasses($datai,$dataf){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->join('MATERIA', 'CLASSIFICACAO.IND_CLASSIFICACAO=MATERIA.IND_CLASSIFICACAO');
//        $this->db->where('MATERIA.SEQ_VEICULO > 0');
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->distinct();
        $this->db->select('CLASSIFICACAO.IND_CLASSIFICACAO, CLASSIFICACAO.DESC_CLASSIFICACAO');
            return $this->db->get('CLASSIFICACAO')->result_array();
    }
    public function chartUltimosMeses (){
        $result=array();
        if ($this->session->userData('perfilUsuario')=='ROLE_CLI') {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("date_format(DATA_MATERIA_PUB,'%Y%m') as mesId, date_format(DATA_MATERIA_PUB,'%c') as id");
            $this->db->where("date_format(DATA_MATERIA_PUB,'%Y%m') > date_format(date_sub(sysdate(), interval 6 MONTH),'%Y%m')");
            $this->db->group_by("date_format(DATA_MATERIA_PUB,'%Y%m')");
//            $this->db->where('MATERIA.SEQ_VEICULO > 0');
            $this->db->where('MATERIA.IND_AVALIACAO is not null and  MATERIA.IND_CLASSIFICACAO is not null');
            $this->db->order_by('1 ASC');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select("date_format(DATA_MATERIA_PUB,'%Y%m') as mesId, date_format(DATA_MATERIA_PUB,'%c') as id");
            $this->db->where("date_format(DATA_MATERIA_PUB,'%Y%m') > date_format(date_sub(sysdate(), interval 6 MONTH),'%Y%m')");
            $this->db->group_by("date_format(DATA_MATERIA_PUB,'%Y%m')");
//            $this->db->where('MATERIA.SEQ_VEICULO > 0');
            $this->db->where('MATERIA.IND_AVALIACAO is not null and  MATERIA.IND_CLASSIFICACAO is not null');
            $this->db->order_by('1 ASC');
            $this->db->from('MATERIA');

            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function chartUltimosMeses2 (){
        $result=array();
        if  ( ($this->session->userData('perfilUsuario')=='ROLE_CLI') or
            ($this->session->userData('perfilUsuario')=='ROLE_USU') ) {
            $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select("date_format(DATA_MATERIA_PUB,'%Y%m') as mesId, date_format(DATA_MATERIA_PUB,'%c') as id");
            $this->db->where("date_format(DATA_MATERIA_PUB,'%Y%m') > date_format(date_sub(sysdate(), interval 6 MONTH),'%Y%m')");
            $this->db->group_by("date_format(DATA_MATERIA_PUB,'%Y%m')");
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->where('MATERIA.IND_AVALIACAO is not null and  MATERIA.IND_CLASSIFICACAO is not null');
            $this->db->order_by('1 ASC');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select("date_format(DATA_MATERIA_PUB,'%Y%m') as mesId, date_format(DATA_MATERIA_PUB,'%c') as id");
            $this->db->where("date_format(DATA_MATERIA_PUB,'%Y%m') > date_format(date_sub(sysdate(), interval 6 MONTH),'%Y%m')");
            $this->db->group_by("date_format(DATA_MATERIA_PUB,'%Y%m')");
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->where('MATERIA.IND_AVALIACAO is not null and  MATERIA.IND_CLASSIFICACAO is not null');
            $this->db->order_by('1 ASC');
            $this->db->from('MATERIA');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    public function listaAnexoRelatorio($datai,$dataf) {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

       /* $arrayTipo = array();
        if ( ($this->auth->CheckMenu('geral','materia','novoi')==1)) {
            array_push($arrayTipo,'I');
        }
        if ( ($this->auth->CheckMenu('geral','materia','novos')==1)) {
            array_push($arrayTipo,'S');
        }
        if ( ($this->auth->CheckMenu('geral','materia','novor')==1)) {
            array_push($arrayTipo,'R');
        }
        if (count($arrayTipo)>0)
            $this->db->where_in('TIPO_MATERIA',$arrayTipo);
        else
            $this->db->where('TIPO_MATERIA IS NULL');*/

        $this->db->order_by('MATERIA.DATA_MATERIA_PUB ASC,MATERIA.SEQ_MATERIA ASC,ANEXO.ORDEM_ARQUIVO ASC');
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->where("(MATERIA.SEQ_VEICULO IS NOT NULL OR MATERIA.SEQ_PORTAL IS NOT NULL) AND MATERIA.SEQ_SETOR IS NOT NULL AND MATERIA.IND_AVALIACAO IS NOT NULL AND MATERIA.IND_CLASSIFICACAO IS NOT NULL");
        $this->db->join('MATERIA', 'ANEXO.SEQ_MATERIA=MATERIA.SEQ_MATERIA');
        $query = $this->db->get('ANEXO');

        return $query->result_array();
    }
    public function listaMateriaRelatorio($datai,$dataf,$veiculo,$portal,$origens,$avaliacoes,$texto,$setor,$radio,$tipo,$tv,$tipoMat,$horair=NULL,
                                          $horafr=NULL,$datai2=NULL,$dataf2=NULL,$release=NULL,$grupo=NULL,$usuario=NULL,$isrelease=NULL) {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {

            $periodoIni2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai2);
            $periodoFim2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf2);

            $periodoIni2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
            $periodoFim2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);
            $this->db->where("DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%Y%m%d%H%i') BETWEEN " . trim($periodoIni2) . " AND " . trim($periodoFim2));
        }

        if(!empty($tipoMat)){
            $this->db->like('MATERIA.TIPO_MATERIA', $tipoMat);
        }
        if(!empty($release)){

            $this->db->where('MATERIA.SEQ_RELEASE',$release);

        }
        if(!empty($isrelease)){

            $this->db->where('MATERIA.IND_RELEASE', $isrelease );

        }

        if(!empty($texto)){
//            $this->db->like('MATERIA.PC_MATERIA', $texto);
            $this->db->where("(upper(MATERIA.PC_MATERIA) like '%".
                    strtoupper($texto).
                    "%' or upper(MATERIA.TIT_MATERIA) like '%".
                    strtoupper($texto).
                    "%' or upper(MATERIA.TEXTO_MATERIA) like '%".strtoupper($texto)."%')");
        }

        if(!empty($setor)){
            $this->db->where('MATERIA.SEQ_SETOR', $setor);
        }else{
            $this->db->where("(MATERIA.SEQ_SETOR<>83 or IND_FILTRO='N')");
        }
        if(!empty($veiculo)){
            $this->db->where('MATERIA.SEQ_VEICULO', $veiculo);
        }
        if(!empty($portal)){
            $this->db->where('MATERIA.SEQ_PORTAL', $portal);
        }
        if(!empty($radio)){
            $this->db->where('MATERIA.SEQ_RADIO', $radio);
        }
        if(!empty($tv)){
            $this->db->where('MATERIA.SEQ_TV', $tv);
        }
        if(!empty($tipo)){
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA', $tipo);
        }
        if(!empty($usuario)){
            $this->db->where('MATERIA.SEQ_USUARIO', $usuario);
        }
        if(!empty($origens)){
            $this->db->where_in('MATERIA.IND_CLASSIFICACAO', $origens);
        }
        if(!empty($avaliacoes)){
            $this->db->where_in('MATERIA.IND_AVALIACAO', $avaliacoes);
        }
        /*
         * alteracao joka
         */
        if($this->session->userData('idClienteSessao') =='1'
        //    and $this->session->userData('loginUsuario') != 'admin'
        ) {
            $this->db->where("MATERIA.SEQ_SETOR NOT IN (316,317,318)");
        } else if ($this->session->userData('loginUsuario') == 'admin'){
            $this->db->where("MATERIA.SEQ_SETOR IN (316,317,318)");
        }

        $this->db->order_by('MATERIA.DATA_MATERIA_PUB ASC,MATERIA.SEQ_MATERIA ASC');
        $this->db->select("MATERIA.SEQ_RELEASE,SETOR.DESC_SETOR,SETOR.SIG_SETOR,OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS CHAVE,DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, MATERIA.*");

        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
//        $this->db->where("(MATERIA.SEQ_VEICULO IS NOT NULL OR MATERIA.SEQ_PORTAL IS NOT NULL OR MATERIA.SEQ_RADIO IS NOT NULL OR MATERIA.SEQ_TV IS NOT NULL) AND MATERIA.SEQ_SETOR IS NOT NULL AND MATERIA.IND_AVALIACAO IS NOT NULL AND MATERIA.IND_CLASSIFICACAO IS NOT NULL AND MATERIA.PC_MATERIA <> ''");
        $this->db->where("(MATERIA.SEQ_VEICULO IS NOT NULL OR MATERIA.SEQ_PORTAL IS NOT NULL OR MATERIA.SEQ_RADIO IS NOT NULL OR MATERIA.SEQ_TV IS NOT NULL) AND MATERIA.SEQ_SETOR IS NOT NULL AND MATERIA.IND_AVALIACAO IS NOT NULL ");
        if(!empty($grupo) and $grupo!='0'){
            $this->db->join("PORTAL", "PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL AND PORTAL.GRUPO_PORTAL='".$grupo."' ");
        }
        $this->db->join("SETOR", "SETOR.SEQ_SETOR=MATERIA.SEQ_SETOR","LEFT");

        $this->db->from('MATERIA');

        $query = $this->db->get();

        return $query->result_array();
    }
    public function listaMateriaSetor($anoSetor,$setor,$texto=NULL) {
//        $mesSetor = preg_replace('#(\d{2})/(\d{4})#', '$2$1', $mesSetor);

        if(!empty($setor)){
            $this->db->where('FIND_IN_SET('.$setor.', MATERIA.SEQ_SETOR)>0 ');
        }

        if(!empty($texto)){
            $this->db->where("(upper(MATERIA.PC_MATERIA) like '%".
                strtoupper($texto).
                "%' or upper(MATERIA.TIT_MATERIA) like '%".
                strtoupper($texto).
                "%' or upper(MATERIA.TEXTO_MATERIA) like '%".strtoupper($texto)."%')");
        } else {
            $this->db->where("DATEDIFF(SYSDATE(),DATA_MATERIA_PUB)<=15");
        }

        $this->db->order_by('MATERIA.DATA_MATERIA_PUB DESC,MATERIA.SEQ_MATERIA DESC');
        $this->db->select("DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, SETOR.DESC_SETOR,SETOR.SIG_SETOR,OLD_PASSWORD(MATERIA.SEQ_MATERIA) AS CHAVE, MATERIA.*");

        $this->db->where("DATE_FORMAT(MATERIA.DATA_MATERIA_PUB,'%Y')= ".$anoSetor);
        $this->db->where('MATERIA.SEQ_CLIENTE in ('.$this->session->userData('listaCliente').')');
        $this->db->where("(MATERIA.SEQ_VEICULO IS NOT NULL OR MATERIA.SEQ_PORTAL IS NOT NULL OR MATERIA.SEQ_RADIO IS NOT NULL OR MATERIA.SEQ_TV IS NOT NULL) AND MATERIA.SEQ_SETOR IS NOT NULL AND MATERIA.IND_AVALIACAO IS NOT NULL ");

        $this->db->join("SETOR", "SETOR.SEQ_SETOR=MATERIA.SEQ_SETOR","LEFT");
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));

        $this->db->from('MATERIA');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function listaMateriaPesquisa($texto='NA',$setor=NULL,$tipo=NULL,$sort = 'SEQ_MATERIA',$order = 'asc', $limit = null, $offset = null) {

        $this->db->order_by($sort, $order);
        if($limit)
            $this->db->limit($limit,$offset);
        $this->db->order_by('SEQ_MATERIA', 'ASC');

//        $arrayTipo = array();
//        if ( ($this->auth->CheckMenu('geral','materia','novoi')==1)) {
//            array_push($arrayTipo,'I');
//        }
//        if ( ($this->auth->CheckMenu('geral','materia','novos')==1)) {
//            array_push($arrayTipo,'S');
//        }
//        if ( ($this->auth->CheckMenu('geral','materia','novor')==1)) {
//            array_push($arrayTipo,'R');
//        }
//        if (count($arrayTipo)>0)
//            $this->db->where_in('MATERIA.TIPO_MATERIA',$arrayTipo);
//        else
//            $this->db->where('MATERIA.TIPO_MATERIA IS NULL');

        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('IND_STATUS', array('E','F'));
//        if(!empty($veiculo) and $veiculo!='NA'){
//            $this->db->where('VEICULO.SEQ_VEICULO', $veiculo);
//        }
        if(!empty($setor) and $setor!='NA'){
            $this->db->where('SETOR.SEQ_SETOR', $setor);
        }
        if(!empty($tipo) and $tipo!='NA'){
            $this->db->where('TIPO_MATERIA.SEQ_TIPO_MATERIA', $tipo);
        }
        if($texto!='NA'){
            $this->db->where("(upper(MATERIA.PC_MATERIA) like '%".
                strtoupper($texto).
                "%' or upper(MATERIA.TIT_MATERIA) like '%".
                strtoupper($texto).
                "%' or upper(MATERIA.TEXTO_MATERIA) like '%".strtoupper($texto)."%')");
        }
        $this->db->join('VEICULO', 'VEICULO.SEQ_VEICULO=MATERIA.SEQ_VEICULO','left');
        $this->db->join('PORTAL', 'PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL','left');
        $this->db->join('RADIO', 'RADIO.SEQ_RADIO=MATERIA.SEQ_RADIO','left');
        $this->db->join('SETOR', 'SETOR.SEQ_SETOR=MATERIA.SEQ_SETOR','left');
        $this->db->join('TIPO_MATERIA', 'TIPO_MATERIA.SEQ_TIPO_MATERIA=MATERIA.SEQ_TIPO_MATERIA','left');
        $this->db->from('MATERIA');
        $query = $this->db->get();

        return $query->result_array();
    }
    public function countMateriaPendente($datai,$dataf,$veiculo,$portal,$origens,$avaliacoes,$texto,$setor,$radio,$tipo,$tv,$tipoMat,
                                         $horair=NULL,$horafr=NULL,$datai2=NULL,$dataf2=NULL,$release=NULL,$grupo=NULL,$usuario=NULL,
                                         $isrelease=NULL){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $periodoIni2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai2);
            $periodoFim2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf2);

            $periodoIni2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
            $periodoFim2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);
        }

       /* $arrayTipo = array();
        if ( ($this->auth->CheckMenu('geral','materia','novoi')==1)) {
            array_push($arrayTipo,'I');
        }
        if ( ($this->auth->CheckMenu('geral','materia','novos')==1)) {
            array_push($arrayTipo,'S');
        }
        if ( ($this->auth->CheckMenu('geral','materia','novor')==1)) {
            array_push($arrayTipo,'R');
        }
        if (count($arrayTipo)>0)
            $this->db->where_in('MATERIA.TIPO_MATERIA',$arrayTipo);
        else
            $this->db->where('MATERIA.TIPO_MATERIA IS NULL');*/

        if(!empty($tipoMat)){
            $this->db->where('MATERIA.TIPO_MATERIA', $tipoMat);
        }
        if(!empty($release)){
            $this->db->where('MATERIA.SEQ_RELEASE', $release);
        }
        if(!empty($isrelease)){
            $this->db->where('MATERIA.IND_RELEASE', $isrelease);
        }
        if(!empty($texto)){
            $this->db->like('MATERIA.PC_MATERIA', $texto);
        }
        if(!empty($setor)){
            $this->db->where('MATERIA.SEQ_SETOR', $setor);
        } else{
            $this->db->where('MATERIA.SEQ_SETOR<>83');
        }
        if(!empty($veiculo)){
            $this->db->where('MATERIA.SEQ_VEICULO', $veiculo);
        }
        if(!empty($portal)){
            $this->db->where('MATERIA.SEQ_PORTAL', $portal);
        }
        if(!empty($radio)){
            $this->db->where('MATERIA.SEQ_RADIO', $radio);
        }
        if(!empty($usuario)){
            $this->db->where('MATERIA.SEQ_USUARIO', $usuario);
        }
        if(!empty($grupo) and $grupo!='0'){
            $this->db->join("PORTAL", "PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL AND PORTAL.GRUPO_PORTAL='".$grupo."' ");
        }
        if(!empty($tv)){
            $this->db->where('MATERIA.SEQ_TV', $tv);
        }
        if(!empty($tipo)){
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA', $tipo);
        }
        if(!empty($origens)){
            $this->db->where_in('MATERIA.IND_CLASSIFICACAO', $origens);
        }
        if(!empty($avaliacoes)){
            $this->db->where_in('MATERIA.IND_AVALIACAO', $avaliacoes);
        }
        /*
         * alteracao joka
         */
        if($this->session->userData('idClienteSessao') =='1' and $this->session->userData('loginUsuario') != 'admin') {
            $this->db->where("MATERIA.SEQ_SETOR NOT IN (316,317,318)");
        } else if ($this->session->userData('loginUsuario') == 'admin'){
            $this->db->where("MATERIA.SEQ_SETOR IN (316,317,318)");
        }
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $this->db->where("DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%Y%m%d%H%i') BETWEEN " . trim($periodoIni2) . " AND " . trim($periodoFim2));
        }
//        $this->db->where("((MATERIA.SEQ_TV IS NULL AND MATERIA.SEQ_VEICULO IS NULL AND MATERIA.SEQ_PORTAL IS NULL AND MATERIA.SEQ_RADIO IS NULL) OR MATERIA.SEQ_SETOR IS NULL OR MATERIA.IND_AVALIACAO IS NULL OR MATERIA.IND_CLASSIFICACAO IS NULL OR (MATERIA.PC_MATERIA = '' and MATERIA.SEQ_PORTAL IS NULL))");
        $this->db->where("((MATERIA.SEQ_TV IS NULL AND MATERIA.SEQ_VEICULO IS NULL AND MATERIA.SEQ_PORTAL IS NULL AND MATERIA.SEQ_RADIO IS NULL) OR MATERIA.SEQ_SETOR IS NULL OR MATERIA.IND_AVALIACAO IS NULL )");
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');

        return $this->db->get()->result_array();
    }
    public function alterarAnexo($tb,$id) {
        $this->db->where('SEQ_ANEXO', $id);
        return $this->db->update('ANEXO',$tb);
    }
    /*public function countLink($novoLink,$id=NULL){

        if (!empty($id))
            $this->db->where('MATERIA.SEQ_MATERIA<>'.$id);
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->like('MATERIA.LINK_MATERIA', trim($novoLink));
        $this->db->from('MATERIA');

        return $this->db->count_all_results();

    }*/
    public function countLink($path,$query,$id=NULL,$domains){

        if (!empty($id))
            $this->db->where('MATERIA.SEQ_MATERIA<>'.$id);
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
//        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
//        $this->db->like("MATERIA.LINK_MATERIA", trim($host));


        $this->db->group_start();
        $this->db->like("MATERIA.LINK_MATERIA", ($path));
        $this->db->or_like("MATERIA.LINK_MATERIA", (urldecode($path)));
        $this->db->or_like("MATERIA.LINK_MATERIA", (urlencode($path)));
        $this->db->group_end();

        if(!empty($query))
            $this->db->like("MATERIA.LINK_MATERIA", trim($query));
        $this->db->from('MATERIA');
        foreach ($domains as $item) {
            $this->db->like("MATERIA.LINK_MATERIA", trim($item));
        }
        return $this->db->count_all_results();
    }
    public function drillAval($datai,$dataf,$tipo){
        $result=array();
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->distinct();
        if ($this->session->userData('perfilUsuario')=='ROLE_CLI' or
            $this->session->userData('perfilUsuario')=='ROLE_USU') {
            $this->db->where('PORTAL.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
            $this->db->select('PORTAL.SEQ_PORTAL, PORTAL.NOME_PORTAL');
            $this->db->join('MATERIA', 'PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->where('MATERIA.IND_AVALIACAO',$tipo);
            $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->from('PORTAL');
            $result = $this->db->get()->result_array();
        } else if ($this->session->userData('perfilUsuario')=='ROLE_ADM') {
            if (!empty($this->session->userData('idClienteSessao')))
                $this->db->where('PORTAL.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
            $this->db->select('PORTAL.SEQ_PORTAL, PORTAL.NOME_PORTAL');
            $this->db->join('MATERIA', 'PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where("MATERIA.TIPO_MATERIA='S'");
            $this->db->where('MATERIA.IND_AVALIACAO',$tipo);
            $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
            $this->db->from('PORTAL');
            $result = $this->db->get()->result_array();
        }
        return $result;
    }
    // IMPRESSO SOMENTE
    public function drillAvalArea($datai,$dataf,$tipo){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->distinct();
        $this->db->order_by('3','DESC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->select('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA,COUNT(*) as QTD');
        $this->db->join('MATERIA', 'MATERIA.SEQ_TIPO_MATERIA=TIPO_MATERIA.SEQ_TIPO_MATERIA', 'RIGHT');
        $this->db->where('MATERIA.SEQ_VEICULO > 0');
        $this->db->where('MATERIA.IND_AVALIACAO',$tipo);
        $this->db->where('MATERIA.TIPO_MATERIA','I');
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA');
        $this->db->from('TIPO_MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function drillListaTagsSite($datai,$dataf,$grupo){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($grupo)){
            $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }

        $this->db->distinct();
//        $this->db->order_by('3','DESC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->select('UPPER(MATERIA.PC_MATERIA) AS TAG');
        $this->db->join('TIPO_MATERIA', 'MATERIA.SEQ_TIPO_MATERIA=TIPO_MATERIA.SEQ_TIPO_MATERIA');
        $this->db->where('MATERIA.TIPO_MATERIA','I');
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');

        $result = $this->db->get()->result_array();
        return $result;
    }
    //SOMENTE INTERNET
    public function drillAvalArea2($datai,$dataf,$tipo,$grupo){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->distinct();
        $this->db->order_by('3','DESC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->select('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA,COUNT(*) as QTD');
        $this->db->join('MATERIA', 'MATERIA.SEQ_TIPO_MATERIA=TIPO_MATERIA.SEQ_TIPO_MATERIA', 'RIGHT');
        $this->db->where("MATERIA.TIPO_MATERIA='S'");
        $this->db->where('MATERIA.IND_AVALIACAO',$tipo);
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        if(!empty($grupo)){
            $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA');
        $this->db->from('TIPO_MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function drillListaTagsSite2($datai,$dataf,$grupo){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($grupo)){
            $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }

        $this->db->distinct();
//        $this->db->order_by('3','DESC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->select('UPPER(MATERIA.PC_MATERIA) AS TAG');
        $this->db->join('TIPO_MATERIA', 'MATERIA.SEQ_TIPO_MATERIA=TIPO_MATERIA.SEQ_TIPO_MATERIA');
        $this->db->where('MATERIA.TIPO_MATERIA','S');
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    // radio somente
    public function drillAvalArea3($datai,$dataf,$tipo){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->distinct();
        $this->db->order_by('3','DESC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->select('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA,COUNT(*) as QTD');
        $this->db->join('MATERIA', 'MATERIA.SEQ_TIPO_MATERIA=TIPO_MATERIA.SEQ_TIPO_MATERIA', 'RIGHT');
        $this->db->where('MATERIA.SEQ_RADIO > 0');
        $this->db->where('MATERIA.IND_AVALIACAO',$tipo);
        $this->db->where('MATERIA.TIPO_MATERIA','R');
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA');
        $this->db->from('TIPO_MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function drillAvalArea4($datai,$dataf,$tipo){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->distinct();
        $this->db->order_by('3','DESC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->select('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA,COUNT(*) as QTD');
        $this->db->join('MATERIA', 'MATERIA.SEQ_TIPO_MATERIA=TIPO_MATERIA.SEQ_TIPO_MATERIA', 'RIGHT');
        $this->db->where('MATERIA.SEQ_TV > 0');
        $this->db->where('MATERIA.IND_AVALIACAO',$tipo);
        $this->db->where('MATERIA.TIPO_MATERIA','T');
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA');
        $this->db->from('TIPO_MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function drillListaTagsSite3($datai,$dataf,$grupo){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($grupo)){
            $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }

        $this->db->distinct();
//        $this->db->order_by('3','DESC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->select('UPPER(MATERIA.PC_MATERIA) AS TAG');
        $this->db->join('TIPO_MATERIA', 'MATERIA.SEQ_TIPO_MATERIA=TIPO_MATERIA.SEQ_TIPO_MATERIA');
        $this->db->where('MATERIA.TIPO_MATERIA','R');
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function drillListaTagsSite4($datai,$dataf,$grupo){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($grupo)){
            $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }

        $this->db->distinct();
//        $this->db->order_by('3','DESC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        $this->db->select('UPPER(MATERIA.PC_MATERIA) AS TAG');
        $this->db->join('TIPO_MATERIA', 'MATERIA.SEQ_TIPO_MATERIA=TIPO_MATERIA.SEQ_TIPO_MATERIA');
        $this->db->where('MATERIA.TIPO_MATERIA','T');
        $this->db->where("MATERIA.DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function dashInicio($tipo,$cliente){

        $this->db->order_by('1','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $cliente);
        $this->db->select("DATE_FORMAT(DATA_MATERIA_PUB, '%Y') as ANO, COUNT(SEQ_MATERIA) AS QTD");
        $this->db->where("MATERIA.TIPO_MATERIA",$tipo);
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by("DATE_FORMAT(DATA_MATERIA_PUB, '%Y')");
        $this->db->from('MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function dashMensal($tipo,$ano,$cliente){
        $this->db->order_by('1','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $cliente);
        $this->db->select(" CAST(DATE_FORMAT(DATA_MATERIA_PUB, '%c') AS INT) as NUM_MES, COUNT(SEQ_MATERIA) AS QTD");
        $this->db->where("MATERIA.TIPO_MATERIA",$tipo);
        $this->db->where("DATE_FORMAT(DATA_MATERIA_PUB, '%Y')=".$ano);
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by("DATE_FORMAT(DATA_MATERIA_PUB, '%c')");
        $this->db->from('MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function dashrio($tipo,$ano,$mes,$cliente){
        $this->db->order_by('DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $cliente);
        $this->db->select("DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, SEQ_MATERIA, TIPO_MATERIA,TIT_MATERIA, SEQ_PORTAL,SEQ_VEICULO,SEQ_RADIO");
        $this->db->where("TIPO_MATERIA",$tipo);
        $this->db->where("(IND_STATUS='E' or IND_STATUS='F')");
        $this->db->where("DATE_FORMAT(DATA_MATERIA_PUB, '%Y%c')=".$ano.$mes);
//        $this->db->where("DATE_FORMAT(DATA_MATERIA_PUB, '%c')=".$mes);
        $this->db->from('MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function dashConsultar($tipo,$ano,$mes,$cliente,$limit = null, $offset = null){

        if($limit)
            $this->db->limit($limit,$offset);

        $this->db->order_by('DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $cliente);
        $this->db->select("DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, SEQ_MATERIA, LINK_MATERIA,TIPO_MATERIA,TIT_MATERIA,PC_MATERIA, SEQ_PORTAL,SEQ_VEICULO,SEQ_RADIO,IND_AVALIACAO");
        $this->db->where("TIPO_MATERIA",$tipo);
        $this->db->where("(IND_STATUS='E' or IND_STATUS='F')");
        $this->db->where("DATE_FORMAT(DATA_MATERIA_PUB, '%Y%c')=".$ano.$mes);
        $this->db->from('MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getConsulta($chave=null,$limit= null, $offset = null)
    {
        $dataNota = $this->ComumModelo->getTableData('NOTA',array('CHAVE_NOTIFICACAO'=>$chave))->row();
        $grupoNota= $dataNota->GRUPO_PORTAL;
        $setorNota= $dataNota->LISTA_SETOR;
        $categoriaSetorNota= $dataNota->SEQ_CATEGORIA_SETOR;
        $avaliacaoNota= $dataNota->AVALIACAO_NOTA;
        $assunto= $dataNota->SEQ_ASSUNTO_GERAL;

        $radio= $dataNota->LISTA_RADIO;
        $tv= $dataNota->LISTA_TV;
        $internet= $dataNota->LISTA_PORTAL;
        $impresso= $dataNota->LISTA_IMPRESSO;
        $release= $dataNota->LISTA_RELEASE;
        $area= $dataNota->LISTA_AREA;

        $clienteNota = $dataNota->SEQ_CLIENTE;

        if (!empty($limit))
            $this->db->limit($limit, $offset);
//        if($dataNota->TIPO_NOTIFICACAO=='D')
            $this->db->order_by('SEQ_MATERIA', 'DESC');
//        else
//            $this->db->order_by('DATA_MATERIA_PUB', 'ASC');
        if(!empty($assunto)) {
//            $this->db->where();
            $this->db->where("MATERIA.SEQ_ASSUNTO_GERAL", $assunto);
        }

        if(!empty($radio) and $radio!='N') {
            $this->db->where("MATERIA.SEQ_RADIO IN (".$radio.")");
        }
        if(!empty($tv) and $tv!='N') {
            $this->db->where("MATERIA.SEQ_TV IN (".$tv.")");
        }
        if(!empty($internet) and $internet!='N') {
            $this->db->where("MATERIA.SEQ_PORTAL IN (".$internet.")");
        }
        if(!empty($impresso) and $impresso!='N') {
            $this->db->where("MATERIA.SEQ_VEICULO IN (".$impresso.")");
        }
        if(!empty($release)) {
            $this->db->where("MATERIA.SEQ_RELEASE IN (".$release.")");
        }
        if(!empty($area)) {
            $this->db->where("MATERIA.SEQ_TIPO_MATERIA IN (".$area.")");
        }

        if(!empty($clienteNota) and $clienteNota =='1'
            and $chave !='gbjr5p6a3j'
            and $chave !='gbjr59zco1'
            and $chave !='gbjr4rgs9l'
            and $chave !='gcrhz90vjb'
			and $chave !='gcyfnjcoh5'
			and $chave !='gcyfpl0vdk'
			and $chave !='gcyfq7llfb'
			and $chave !='gcyfqp83x8'
            and $chave !='gbjr49lvqp'
            and $chave !='gh12p2ph81') {
            $this->db->where("MATERIA.SEQ_SETOR NOT IN (316,317,318)");
        } else if(!empty($clienteNota) and $clienteNota =='1' and ($chave =='gbjr5p6a3j' or $chave =='gbjr59zco1' or $chave =='gbjr4rgs9l' or $chave =='gbjr49lvqp' or $chave =='gh12p2ph81'))  {
			$this->db->where("MATERIA.SEQ_SETOR IN (316,317,318)");
		}

        $this->db->select("MATERIA.SEQ_ASSUNTO_GERAL,NOTA.TIPO_NOTA,MATERIA.RESUMO_MATERIA,MATERIA.RESPOSTA_MATERIA,"
                         ."MATERIA.COMENTARIO_MATERIA,MATERIA.ANALISE_MATERIA, MATERIA.SEQ_CLIENTE,MATERIA.HORA_MATERIA,"
                         ."MATERIA.PROGRAMA_MATERIA,MATERIA.SEQ_TV,TELEVISAO.NOME_TV,SETOR.DESC_SETOR,SETOR.SIG_SETOR,"
                         ."OLD_PASSWORD(SEQ_MATERIA) AS CHAVE,DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, SEQ_MATERIA, "
                         ."LINK_MATERIA,MATERIA.TIPO_MATERIA,TIT_MATERIA,PC_MATERIA,TEXTO_MATERIA, MATERIA.SEQ_PORTAL,SEQ_VEICULO,SEQ_RADIO,"
                         ."IND_AVALIACAO,MATERIA.EDITORIA_MATERIA,MATERIA.PAGINA_MATERIA,MATERIA.AUTOR_MATERIA,"
                         ."MATERIA.QTD_COMENTARIO , MATERIA.QTD_CURTIDA , MATERIA.QTD_COMPARTILHAMENTO");
        $this->db->where("(IND_STATUS='E' or IND_STATUS='F')");
        $this->db->where("NOTA.CHAVE_NOTIFICACAO", "$chave");
        $this->db->where("(MATERIA.DATA_MATERIA_PUB IS NOT NULL AND (MATERIA.SEQ_TV>0 OR MATERIA.SEQ_PORTAL>0 OR MATERIA.SEQ_RADIO>0 OR MATERIA.SEQ_VEICULO>0))");
        $this->db->where("DATA_PUB_NUMERO BETWEEN DATE_FORMAT(NOTA.DT_INICIO, '%Y%m%d') and DATE_FORMAT(NOTA.DT_FIM, '%Y%m%d')");
        $this->db->join("NOTA", ($dataNota->TIPO_NOTA=='S'?'':"NOTA.SEQ_CLIENTE=MATERIA.SEQ_CLIENTE AND ")."MATERIA.TIPO_MATERIA =IF((NOTA.LISTA_SETOR=83 or NOTA.TIPO_MATERIA = '' or NOTA.TIPO_MATERIA is null),MATERIA.TIPO_MATERIA,NOTA.TIPO_MATERIA)");

        $this->db->join("TELEVISAO", "TELEVISAO.SEQ_TV=MATERIA.SEQ_TV","LEFT");
        if(!empty($grupoNota))
            $this->db->join("PORTAL", "PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL AND PORTAL.GRUPO_PORTAL='$grupoNota'");

        if(!empty($avaliacaoNota)) {
            $this->db->where("MATERIA.IND_AVALIACAO", $avaliacaoNota);
        }

        if(!empty($setorNota)) {
            $this->db->where("SETOR.SEQ_SETOR IN (". $setorNota.")");
            $this->db->join("SETOR", "FIND_IN_SET(SETOR.SEQ_SETOR, MATERIA.SEQ_SETOR)>0","LEFT");
        } else {
            $this->db->join("SETOR", "SETOR.SEQ_SETOR=MATERIA.SEQ_SETOR","LEFT");
            $this->db->where("(FIND_IN_SET(83, MATERIA.SEQ_SETOR)=0  OR IND_FILTRO='N')");
        }
        if(!empty($categoriaSetorNota)) {
//            $this->db->where();
            $this->db->join("SETOR AS SETORA", "SETORA.SEQ_SETOR=MATERIA.SEQ_SETOR AND SETORA.SEQ_CATEGORIA_SETOR=".$categoriaSetorNota);
        }




        $this->db->from('MATERIA');

        $result = $this->db->get()->result_array();
        return $result;
    }
    public function getConsultaSingle($chave=null, $idMat=NULL)
    {
        $this->db->select("MATERIA.SEQ_ASSUNTO_GERAL,MATERIA.RESUMO_MATERIA,MATERIA.RESPOSTA_MATERIA, ".
                    "MATERIA.ANALISE_MATERIA,MATERIA.IND_RELEASE,MATERIA.IND_MODELO,MATERIA.HORA_MATERIA, ".
                    "MATERIA.PROGRAMA_MATERIA ,MATERIA.SEQ_TV,TELEVISAO.NOME_TV,SETOR.DESC_SETOR,SETOR.DESC_SETOR, ".
                    "SETOR.SIG_SETOR,SETOR.SEQ_SETOR,OLD_PASSWORD(SEQ_MATERIA) AS CHAVE,MATERIA.SEQ_CLIENTE,".
                    "DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, SEQ_MATERIA, LINK_MATERIA,MATERIA.TIPO_MATERIA,".
                    "TIT_MATERIA,PC_MATERIA,TEXTO_MATERIA, MATERIA.SEQ_PORTAL,SEQ_VEICULO,SEQ_RADIO,IND_AVALIACAO, ".
                    "MATERIA.QTD_COMENTARIO , MATERIA.QTD_CURTIDA , MATERIA.QTD_COMPARTILHAMENTO");
        $this->db->where("(IND_STATUS='E' or IND_STATUS='F')");
        $this->db->where("(MATERIA.DATA_MATERIA_PUB IS NOT NULL AND (MATERIA.SEQ_TV>0 OR MATERIA.SEQ_PORTAL>0 OR MATERIA.SEQ_RADIO>0 OR MATERIA.SEQ_VEICULO>0))");
        if (!empty($chave)) {
            $this->db->where("OLD_PASSWORD(MATERIA.SEQ_MATERIA)='" . $chave . "'");
        } else if (!empty($idMat)) {
            $this->db->where("MATERIA.SEQ_MATERIA=".$idMat."");
        } else {
            $this->db->where("MATERIA.SEQ_MATERIA=-1");
        }
        $this->db->join("SETOR", "SETOR.SEQ_SETOR=MATERIA.SEQ_SETOR","LEFT");
        $this->db->join("TELEVISAO", "TELEVISAO.SEQ_TV=MATERIA.SEQ_TV","LEFT");
        $this->db->from('MATERIA');
        $result = $this->db->get();
        return $result;
    }

    public function alteraNota($chave=null, $data=NULL){
        $this->db->where('CHAVE_NOTIFICACAO', $chave);
        return $this->db->update('NOTA',$data);

    }

    /*************************/

    public function listaMateria2($sort = 'SEQ_MATERIA',$order = 'asc', $limit = null, $offset = null) {

        $this->db->order_by($sort, $order);
        if($limit)
            $this->db->limit($limit,$offset);

        $this->db->select('*');
        $this->db->from('MATERIA');

        $this->db->order_by('SEQ_MATERIA', 'ASC');

        $query = $this->db->get();

        return $query->result_array();
    }
    function make_query()
    {
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where_in('MATERIA.TIPO_MATERIA', explode(',',$this->session->userData('listaTipo')));
        if ($this->session->userData('perfilUsuario')=='ROLE_REP' or $this->session->userdata('idUsuario')==41) {
            $this->db->where('MATERIA.SEQ_USUARIO', $this->session->userData('idUsuario'));
         //   $this->db->where('IND_STATUS', 'C');
        } else {
            $this->db->where("IND_STATUS='E'");
        }

        /*$arrayTipo = array();
        if ( ($this->auth->CheckMenu('geral','materia','novoi')==1)) {
            array_push($arrayTipo,'I');
        }
        if ( ($this->auth->CheckMenu('geral','materia','novos')==1)) {
            array_push($arrayTipo,'S');
        }
        if ( ($this->auth->CheckMenu('geral','materia','novor')==1)) {
            array_push($arrayTipo,'R');
        }
        if ( ($this->auth->CheckMenu('geral','materia','novot')==1)) {
            array_push($arrayTipo,'T');
        }
        if (count($arrayTipo)>0)
            $this->db->where_in('TIPO_MATERIA',$arrayTipo);
        else
            $this->db->where('TIPO_MATERIA IS NULL');*/

        $this->db->select("MATERIA.SEQ_ASSUNTO_GERAL,MATERIA.SEQ_TV, TELEVISAO.NOME_TV,MATERIA.SEQ_MATERIA,DATE_FORMAT(MATERIA.DATA_MATERIA_PUB,'%d/%m/%Y') AS DATA_MATERIA_PUB, TIPO_MATERIA.DESC_TIPO_MATERIA, PORTAL.NOME_PORTAL, VEICULO.FANTASIA_VEICULO, RADIO.NOME_RADIO, MATERIA.TIPO_MATERIA, MATERIA.SEQ_TIPO_MATERIA, MATERIA.SEQ_SETOR, MATERIA.PC_MATERIA, MATERIA.IND_AVALIACAO, MATERIA.IND_CLASSIFICACAO, MATERIA.IND_STATUS, MATERIA.SEQ_USUARIO");
        $this->db->join('RADIO', 'RADIO.SEQ_RADIO = MATERIA.SEQ_RADIO','LEFT');
        $this->db->join('PORTAL', 'PORTAL.SEQ_PORTAL = MATERIA.SEQ_PORTAL','LEFT');
        $this->db->join('TELEVISAO', 'TELEVISAO.SEQ_TV = MATERIA.SEQ_TV','LEFT');
        $this->db->join('VEICULO', 'VEICULO.SEQ_VEICULO = MATERIA.SEQ_VEICULO','LEFT');
        $this->db->join('TIPO_MATERIA', 'TIPO_MATERIA.SEQ_TIPO_MATERIA = MATERIA.SEQ_TIPO_MATERIA','LEFT');

        $this->db->from('MATERIA');

        if(isset($_POST["search"]["value"]) and strlen($_POST["search"]["value"])>0)
        {
            $this->db->group_start();
//            $this->db->like("PORTAL.NOME_PORTAL", $_POST["search"]["value"]);
//            $this->db->or_like("VEICULO.FANTASIA_VEICULO", $_POST["search"]["value"]);
//            $this->db->or_like("RADIO.NOME_RADIO", $_POST["search"]["value"]);
            $this->db->like("MATERIA.TIT_MATERIA", $_POST["search"]["value"]);
            $this->db->or_like("MATERIA.PC_MATERIA", $_POST["search"]["value"]);
//            $this->db->or_like("MATERIA.EDITORIA_MATERIA", $_POST["search"]["value"]);
//            $this->db->or_like("MATERIA.DESTAQUE_MATERIA", $_POST["search"]["value"]);
//            $this->db->or_like("MATERIA.PROGRAMA_MATERIA", $_POST["search"]["value"]);
            $this->db->or_like("MATERIA.TEXTO_MATERIA", $_POST["search"]["value"]);
//            $this->db->or_like("TIPO_MATERIA.DESC_TIPO_MATERIA", $_POST["search"]["value"]);
            $this->db->group_end();
        }
        if(isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else {
            $this->db->order_by('MATERIA.DATA_MATERIA_PUB DESC, MATERIA.SEQ_MATERIA DESC');
        }
    }
    function make_datatables(){
        $this->make_query();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function get_filtered_data(){
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_all_data()
    {
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if ($this->session->userData('perfilUsuario')=='ROLE_REP') {
            $this->db->where('SEQ_USUARIO', $this->session->userData('idUsuario'));
            $this->db->where('IND_STATUS', 'C');
        } else {
            $this->db->where("IND_STATUS='E'");
        }
//        $arrayTipo = array();
//        if ( ($this->auth->CheckMenu('geral','materia','novoi')==1)) {
//            array_push($arrayTipo,'I');
//        }
//        if ( ($this->auth->CheckMenu('geral','materia','novos')==1)) {
//            array_push($arrayTipo,'S');
//        }
//        if ( ($this->auth->CheckMenu('geral','materia','novor')==1)) {
//            array_push($arrayTipo,'R');
//        }
//        if (count($arrayTipo)>0)
//            $this->db->where_in('TIPO_MATERIA',$arrayTipo);
//        else
//            $this->db->where('TIPO_MATERIA IS NULL');

        $this->db->select("*");
        $this->db->from('MATERIA');
        return $this->db->count_all_results();
    }
    function pivotando($limit=2018)
    {
        $sql =" SELECT C0.NOME_CLIENTE, "
            ." 	CASE "
            ." 		WHEN A.TIPO_MATERIA='I' THEN 'Impresso' "
            ." 		WHEN A.TIPO_MATERIA='S' THEN 'Internet' "
            ." 		WHEN A.TIPO_MATERIA='R' THEN 'Radio' "
            ." 		WHEN A.TIPO_MATERIA='T' THEN 'Televisao' "
            ." 		ELSE 'N�o definido' "
            ." 	END TIPO_MATERIA, "
            ." 	B.DESC_SETOR, "
            ." 	CASE "
            ."      WHEN A.SEQ_CLIENTE=3 AND CS0.IND_AVALIACAO IS NOT NULL AND CS0.IND_AVALIACAO='P' THEN 'Positivo' "
            ." 		WHEN A.IND_AVALIACAO='P' THEN 'Positivo' "
            ."      WHEN A.SEQ_CLIENTE=3 AND CS0.IND_AVALIACAO IS NOT NULL AND CS0.IND_AVALIACAO='N' THEN 'Negativo' "
            ." 		WHEN A.IND_AVALIACAO='N' THEN 'Negativo' "
            ."      WHEN A.SEQ_CLIENTE=3 AND CS0.IND_AVALIACAO IS NOT NULL AND CS0.IND_AVALIACAO='T' THEN 'Neutro' "
            ." 		WHEN A.IND_AVALIACAO='T' THEN 'Neutro' "
            ." 		ELSE 'Nao definido' "
            ." 	END IND_AVALIACAO, "
            ." 	COALESCE(C.NOME_VEICULO,D.NOME_PORTAL,E.NOME_RADIO,F.NOME_TV) as VEICULO, "
            ." 	DATE_FORMAT(DATA_MATERIA_PUB, '%Y') AS ANO, "
            ." 	rpad(DATE_FORMAT(DATA_MATERIA_PUB, '%m'),2,'0') AS MES, "
            ." 	rpad(DATE_FORMAT(DATA_MATERIA_PUB, '%d'),2,'0') AS DIA, "
            ." 	COUNT(*) as QTD FROM MATERIA A  "
            ." INNER JOIN SETOR B ON FIND_IN_SET(B.SEQ_SETOR, A.SEQ_SETOR)>0  "
            ." INNER JOIN CLIENTE C0 ON A.SEQ_CLIENTE=C0.SEQ_CLIENTE  "
            ." LEFT JOIN MATERIA_CLIENTE_SETOR CS0 ON CS0.SEQ_MATERIA=A.SEQ_MATERIA AND CS0.SEQ_SETOR=B.SEQ_SETOR AND CS0.SEQ_CLIENTE=A.SEQ_CLIENTE "
            ." LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO  "
            ." LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL  "
            ." LEFT JOIN RADIO E ON A.SEQ_RADIO=E.SEQ_RADIO  "
            ." LEFT JOIN TELEVISAO F ON A.SEQ_TV=F.SEQ_TV  "
            ." WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0  "
            ." 	AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL)  "
            ."        AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL )  "
            ."  AND DATE_FORMAT(DATA_MATERIA_PUB, '%Y') =".$limit." AND A.SEQ_CLIENTE IN (1,5,3,4,8,9,12,13) "
            ." GROUP BY C0.NOME_CLIENTE, "
            ." A.TIPO_MATERIA, "
            ." B.DESC_SETOR, "
            ." A.IND_AVALIACAO, "
            ." COALESCE(C.NOME_VEICULO,D.NOME_PORTAL,E.NOME_RADIO,F.NOME_TV), "
            ." DATE_FORMAT(DATA_MATERIA_PUB, '%Y'), "
            ." DATE_FORMAT(DATA_MATERIA_PUB, '%m'), "
            ." DATE_FORMAT(DATA_MATERIA_PUB, '%d') ";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function listaSetoresClientesMateria($idMateria=NULL){
        $this->db->where('SEQ_MATERIA', $idMateria);
        $query = $this->db->get('MATERIA_CLIENTE_SETOR');
        return $query->result_array();

    }
    public function listaSetoresClientesMateriaNaoCad($idMateria=NULL){
        $this->db->where('SEQ_MATERIA', $idMateria);
        $query = $this->db->get('MATERIA_CLIENTE_SETOR');
        return $query->result_array();

    }
    public function deleteSetoresClientesMateriaByMateria($idMateria=NULL){
        $this->db->where('SEQ_MATERIA', $idMateria);
        return $this->db->delete('MATERIA_CLIENTE_SETOR');
    }
    public function inserirSetoresClientesMateria($data=NULL)
    {
        $this->db->insert('MATERIA_CLIENTE_SETOR', $data);

        return $this->db->insert_id();
    }
    public function alterarSetorCliente($dados,$id) {
        $this->db->where('SEQ_MAT_CLI_SET', $id);
        return $this->db->update('MATERIA_CLIENTE_SETOR',$dados);
    }

    public function listaMateriaDeleteAnexo($data_fim) {
        $this->db->where("DATA_PUB_NUMERO') <= ".trim($data_fim));
        $this->db->from('MATERIA');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function listaMateriaAnexosZip() {

        $sql = "SELECT SEQ_MATERIA,DATE_FORMAT(DATA_MATERIA_CAD,'%Y%m') AS PASTAMES,"
            ." DATE_FORMAT(DATA_MATERIA_CAD,'%Y%m%d') AS PASTADIA  FROM "
            ." MATERIA WHERE  SEQ_CLIENTE=1 AND SEQ_TV=14 AND UPPER(TRIM(PROGRAMA_MATERIA)) LIKE 'AL%_AMAZONAS%'"
            ." AND IND_AVALIACAO='N' AND DATE_FORMAT(DATA_MATERIA_CAD,'%Y%m') BETWEEN 201901 AND 201904";

        $query = $this->db->query($sql);

        return $query->result_array();
    }
    public function listaTipoClientesMateria($idMateria=NULL){
        $this->db->where('SEQ_MATERIA', $idMateria);
        $query = $this->db->get('MATERIA_CLIENTE_TIPO');
        return $query->result_array();

    }
    public function listaTipoClientesMateriaNaoCad($idMateria=NULL){
        $this->db->where('SEQ_MATERIA', $idMateria);
        $query = $this->db->get('MATERIA_CLIENTE_TIPO');
        return $query->result_array();

    }
    public function deleteTipoClientesMateriaByMateria($idMateria=NULL){
        $this->db->where('SEQ_MATERIA', $idMateria);
        return $this->db->delete('MATERIA_CLIENTE_TIPO');
    }
    public function inserirTipoClientesMateria($data=NULL)
    {
        $this->db->insert('MATERIA_CLIENTE_TIPO', $data);

        return $this->db->insert_id();
    }
    public function alterarTipoCliente($dados,$id) {
        $this->db->where('SEQ_MAT_CLI_TIPO', $id);
        return $this->db->update('MATERIA_CLIENTE_TIPO',$dados);
    }

}
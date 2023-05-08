<?php
class ReleaseModelo extends CI_Model {


	public function __construct()
        {
			$this->load->database();
        }
		
	public function listaReleaseAtivo() {
        $this->db->order_by('SEQ_RELEASE', 'DESC');
//		$this->db->where('IND_ATIVO','S');
	$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
        $this->db->where('DATA BETWEEN "20221201" AND '.date('Ymd'));
        $query = $this->db->get('RELEASE_MATERIA');
	return $query->result_array();
    }

    public function listaReleaseTodos() {
        $query = $this->db->get('RELEASE_MATERIA');
			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));

        return $query->result_array();
    }


    # VERIFICA SE O USUÁRIO ESTÁ LOGADO
    public function inserir($data_os=NULL)
	{
		$this->db->insert('RELEASE_MATERIA', $data_os);
		
		return $this->db->insert_id();
	}
	
	public function alterar($data,$id) {
		$this->db->where('SEQ_RELEASE', $id);
		return $this->db->update('RELEASE_MATERIA',$data);
	}
	public function editar($id) {
		$this->db->where('SEQ_RELEASE', $id);
		$query = $this->db->get('RELEASE_MATERIA');
		return $query->result_array();
	}
	
	public function deletar($id) {
	$tb_unidade = array( 'IND_ATIVO'=>'N');
		$this->db->where('SEQ_RELEASE', $id);
    	return $this->db->update('RELEASE_MATERIA',$tb_unidade);
    }
	public function getRelease($id) {
		$this->db->where('SEQ_RELEASE', $id);
		return $this->db->get('RELEASE_MATERIA');
	}

	public function listaReleaseVencida($qtdDias)
	{
		$this->db->where('TIMESTAMPDIFF(DAY,DATA_ENVIO_RELEASE,SYSDATE())>'.$qtdDias);
		$this->db->where('IND_ATIVO','S');
		$query = $this->db->get('RELEASE_MATERIA');
		return $query->result_array();
	}
	public function listaReleaseBySetor($setor,$ativo=NULL) {
		$this->db->order_by('DESC_RELEASE', 'ASC');
		if (!empty($ativo)) {
			$this->db->where('IND_ATIVO', $ativo);
		}
		if (is_array($setor)) {
			$this->db->where_in('SEQ_SETOR', $setor);
		}else {
			$this->db->where_in('SEQ_SETOR',explode(',',$setor));
		}
		$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		$query = $this->db->get('RELEASE_MATERIA');
		return $query->result_array();
	}
        public function getSetor($param) {
        $SQL = 'SELECT SIG_SETOR  
            FROM SETOR WHERE `SEQ_SETOR` IN (' . $param . ')';
        $setor = $this->db->query($SQL)->result();
        if (!empty($setor)) {
            $regra = '';

            foreach ($setor as $value) {
                $regra .= $value->SIG_SETOR . ', ';
            }

            return substr($regra, 0, -2);
        } else {
            return '';
        }
    }

}
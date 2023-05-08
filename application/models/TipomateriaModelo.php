<?php
class TipomateriaModelo extends CI_Model {


	public function __construct()
        {
			$this->load->database();
        }
		
	public function listaTipomateria($idCliente=NULL) {
		$this->db->order_by('DESC_TIPO_MATERIA', 'ASC');
		$this->db->where('IND_ATIVO','S');
//		if ($this->session->userData('perfilUsuario')!='ROLE_ADM')
		if (!empty($idCliente)){
			$this->db->where('SEQ_CLIENTE',$idCliente);
		} else {
			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		}
        $query = $this->db->get('TIPO_MATERIA');
		return $query->result_array();
	}
        public function listaTipomateria33($idCliente=NULL) {
		$this->db->order_by('DESC_TIPO_MATERIA', 'ASC');
		//$this->db->where('IND_ATIVO','S');
//		if ($this->session->userData('perfilUsuario')!='ROLE_ADM')
		if (!empty($idCliente)){
			$this->db->where('SEQ_CLIENTE',$idCliente);
		} else {
			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		}
        $query = $this->db->get('TIPO_MATERIA');
		return $query->result_array();
	}
	public function listaTipomateriaAlerta($idCliente) {
		$this->db->order_by('DESC_TIPO_MATERIA', 'ASC');
		$this->db->where('IND_ATIVO','S');
		$this->db->where('SEQ_CLIENTE',$idCliente);
		$query = $this->db->get('TIPO_MATERIA');
		return $query->result_array();
	}

    public function listaTipo($id=NULL) {
        $query = $this->db->get('TIPO_MATERIA');
		if ($this->session->userData('perfilUsuario')!='ROLE_ADM')
			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
        return $query->result_array();
    }


    # VERIFICA SE O USUÁRIO ESTÁ LOGADO
    public function inserir($data_os=NULL)
	{
		$this->db->insert('TIPO_MATERIA', $data_os);
		
		return $this->db->insert_id();
	}
	
	public function alterar($tb_servico,$servicoId) {
		$this->db->where('SEQ_TIPO_MATERIA', $servicoId);
		return $this->db->update('TIPO_MATERIA',$tb_servico);
	}
	public function editar($id) {
		$this->db->where('SEQ_TIPO_MATERIA', $id);
		$query = $this->db->get('TIPO_MATERIA');
		return $query->result_array();
	}
	
	public function deletar($id) {
	$tb_unidade = array( 'IND_ATIVO'=>'N');
		$this->db->where('SEQ_TIPO_MATERIA', $id);
    	return $this->db->update('TIPO_MATERIA',$tb_unidade);
    }
}
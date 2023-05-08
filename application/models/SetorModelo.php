<?php
class SetorModelo extends CI_Model {


	public function __construct()
        {
			$this->load->database();
        }
		
	public function listaSetor() {
		$this->db->order_by('DESC_SETOR', 'ASC');
		$this->db->where('IND_ATIVO','S');
//		if ($this->session->userData('perfilUsuario')!='ROLE_ADM')
			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
//		else if(!empty($this->session->userData('idClienteSessao')))
//			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
//		else $this->db->where('SEQ_CLIENTE',0);
        $query = $this->db->get('SETOR');
		return $query->result_array();
	}
        public function listaSetor33() {
		$this->db->order_by('DESC_SETOR', 'ASC');
		//$this->db->where('IND_ATIVO','S');
//		if ($this->session->userData('perfilUsuario')!='ROLE_ADM')
			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
//		else if(!empty($this->session->userData('idClienteSessao')))
//			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
//		else $this->db->where('SEQ_CLIENTE',0);
        $query = $this->db->get('SETOR');
		return $query->result_array();
	}
	public function listaSetorCli($id) {
		$this->db->order_by('DESC_SETOR', 'ASC');
		$this->db->where('IND_ATIVO','S');
			$this->db->where('SEQ_CLIENTE',$id);
        $query = $this->db->get('SETOR');
		return $query->result_array();
    }

	public function listaCategoriaSetor($idCliente=NULL) {
		$this->db->order_by('DESC_CATEGORIA', 'ASC');
		if (!empty($idCliente))
			$this->db->where('SEQ_CLIENTE',$idCliente);
		else
			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		$query = $this->db->get('CATEGORIA_SETOR');
		return $query->result_array();
	}

	public function listaSetorAlerta($idCliente=NULL) {
		$this->db->order_by('DESC_SETOR', 'ASC');
		$this->db->where('IND_ATIVO','S');
		if (!empty($idCliente))
			$this->db->where('SEQ_CLIENTE',$idCliente);
		else
			$this->db->where('SEQ_CLIENTE',0);
//		else if(!empty($this->session->userData('idClienteSessao')))
//			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
//		else $this->db->where('SEQ_CLIENTE',0);
		$query = $this->db->get('SETOR');
		return $query->result_array();
	}

    # VERIFICA SE O USUÁRIO ESTÁ LOGADO
    public function inserir($data_os=NULL)
	{
		$this->db->insert('SETOR', $data_os);
		
		return $this->db->insert_id();
	}
	
	public function alterar($tb_servico,$servicoId) {
		$this->db->where('SEQ_SETOR', $servicoId);
		return $this->db->update('SETOR',$tb_servico);
	}
	public function editar($id) {
		$this->db->where('SEQ_SETOR', $id);
		$query = $this->db->get('SETOR');
		return $query->result_array();
	}
	
	public function deletar($id) {
	$tb_unidade = array( 'IND_ATIVO'=>'N');
		$this->db->where('SEQ_SETOR', $id);
    	return $this->db->update('SETOR',$tb_unidade);
    }
	public function listaSetorCliente($idCliente=NULL,$setores=NULL) {
		$this->db->order_by('DESC_SETOR', 'ASC');
		$this->db->where('IND_ATIVO','S');
		$this->db->where_in('SEQ_SETOR',$setores);
		$this->db->where('SEQ_CLIENTE',$idCliente);
		$query = $this->db->get('SETOR');
		return $query->result_array();
	}
}
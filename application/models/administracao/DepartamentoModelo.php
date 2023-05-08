<?php
class DepartamentoModelo extends CI_Model {


	public function __construct()
        {
			$this->load->database();
        }
		
	public function listaDepartamento() {
		$this->db->order_by('DESC_DEPARTAMENTO', 'ASC');
		$this->db->where('IND_ATIVO','S');
        $query = $this->db->get('DEPARTAMENTO');
		return $query->result_array();
    }

    public function listaTipo($id=NULL) {
        $query = $this->db->get('DEPARTAMENTO');
        return $query->result_array();
    }


    # VERIFICA SE O USUÁRIO ESTÁ LOGADO
    public function inserir($data_os=NULL)
	{
		$this->db->insert('DEPARTAMENTO', $data_os);
		
		return $this->db->insert_id();
	}
	
	public function alterar($tb_servico,$servicoId) {
		$this->db->where('SEQ_DEPARTAMENTO', $servicoId);
		return $this->db->update('DEPARTAMENTO',$tb_servico);
	}
	public function editar($id) {
		$this->db->where('SEQ_DEPARTAMENTO', $id);
		$query = $this->db->get('DEPARTAMENTO');
		return $query->result_array();
	}
	
	public function deletar($id) {
	    $tb_unidade = array( 'IND_ATIVO'=>'N');
		$this->db->where('SEQ_DEPARTAMENTO', $id);
    	return $this->db->update('DEPARTAMENTO',$tb_unidade);
    }
}
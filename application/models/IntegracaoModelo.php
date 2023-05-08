<?php
class IntegracaoModelo extends CI_Model {


	public function __construct()
        {
			$this->load->database();
        }
	/**
	 * Metodos do monitoramento
	 *  */		
	public function listaMonitoramento() {
		$this->db->order_by('NOME_MONITORAMENTO', 'ASC');
        $query = $this->db->get('MONITORAMENTO');
		return $query->result_array();
	}
	public function getMonitoramento($id=NULL) {
		if (!empty($id))
			$this->db->where('SEQ_MONITORAMENTO', $id);

        $this->db->from('MONITORAMENTO');
		return $this->db->get();
	}
	public function alterar($data, $id)
	{
        $this->db->where($this->colunaSeq, $id);
        return $this->db->update('MONITORAMENTO', $data);
    }
    
    public function inserir($data)
	{
        return $this->db->insert('MONITORAMENTO', $data);
	}
	/**
	 * Metodos do parametros
	 *  */	
	public function getParametros(){
        $this->db->select('USUARIO,SENHA,TOKEN');
        $this->db->from('PARAMETRO_API');
        return $this->db->get();
    }
    
	public function alterarParam($data)
	{
		return $this->db->update('PARAMETRO_API', $data);
	}

	/**
	 * invlusao das materias
	 */
	public function inserirRejeito($data)
	{
        return $this->db->insert('MATERIA_REJEITADA', $data);
	}
	


}
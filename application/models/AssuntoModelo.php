<?php
class AssuntoModelo extends CI_Model {


	public function __construct()
        {
			$this->load->database();
        }
		
	public function listaAssunto() {
		$this->db->order_by('DESC_ASSUNTO_GERAL', 'ASC');
		$this->db->where('IND_ATIVO','S');
        $query = $this->db->get('ASSUNTO_GERAL');
		return $query->result_array();
    }
}
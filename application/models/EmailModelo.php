<?php
class EmailModelo extends CI_Model {

	public function __construct()
        {
			$this->load->database();
        }

    public function inserir($data=NULL)
	{
		return $this->db->insert('EMAIL', $data);

	}
}
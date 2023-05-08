<?php
class PerfilModelo extends CI_Model {

	protected $tabela = "PERFIL";

	protected $colunaId = "SEQ_PERFIL";

	protected $colunaOrder = "DESC_PERFIL";
	

	
	public function __construct()
        {
			$this->load->database();
        }

    public function listaPerfil() {
        $this->db->where("IND_ATIVO","S");
        $this->db->order_by('DESC_PERFIL', 'ASC');
        $query = $this->db->get('PERFIL');
        return $query->result_array();
    }

    public function editarPerfil($id) {
		$this->db->where('SEQ_PERFIL', $id);
		$query = $this->db->get('PERFIL');
		return $query->result_array();
	}

    # VERIFICA SE O USUÁRIO ESTÁ LOGADO
    public function inserir($data=NULL)
	{
		$this->db->insert('PERFIL', $data);

        return $this->db->insert_id();

	}

	public function alterar($tb,$idPerfil) {
		$this->db->where('SEQ_PERFIL', $idPerfil);
		return $this->db->update('PERFIL',$tb);
	}
    public function excluir($id=NULL) {
        $this->db->where('SEQ_PERFIL', $id);
        return $this->db->delete('PERFIL');
    }

	public function inserirPermissao($data=NULL)
	{
		return $this->db->insert('PERFIL_METODO', $data);

	}
//
	public function listaPermissao($id) {
		$this->db->select('PERFIL_METODO.SEQ_METODO');
		$this->db->where('SEQ_PERFIL',$id);
		$query = $this->db->get('PERFIL_METODO');
		return $query->result_array();
	}

	public function deletarPermissao($id) {
		$this->db->where('SEQ_PERFIL', $id);
		return $this->db->delete('PERFIL_METODO');
	}
    public function deletarPermissaoUsuario($id) {
        $this->db->where('SEQ_PERFIL', $id);
        return $this->db->delete('PERFIL_USUARIO');
    }
}
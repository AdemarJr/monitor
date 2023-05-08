<?php
class NotificacaoModelo extends CI_Model {

	public function __construct()
        {
			$this->load->database();
        }


    public function getNotificacaoUsuario($idUser) {

        $this->db->from('NOTIFICACAO');
        $this->db->where('NOTIFICACAO.SEQ_USUARIO',$idUser);
        $this->db->where('NOTIFICACAO.LID_NOTIFICACAO',0);
//        $this->db->where('DATEDIFF(SYSDATE(),NOTIFICACAO.DTE_NOTIFICACAO)<= ',2);
        $this->db->where('NOTIFICACAO.FLAG_NOTIFICACAO<=10');
        $this->db->order_by('NOTIFICACAO.SEQ_NOTIFICACAO','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getNotificacaoUsuarioPor30($idUser) {

        $this->db->from('NOTIFICACAO');
        $this->db->where('NOTIFICACAO.SEQ_USUARIO',$idUser);
        $this->db->where('NOTIFICACAO.LID_NOTIFICACAO',0);
        $this->db->order_by('NOTIFICACAO.SEQ_NOTIFICACAO','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function inserir($data=NULL)
	{
		return $this->db->insert('NOTIFICACAO', $data);

	}

	public function alterar($data,$id) {
		$this->db->where('SEQ_NOTIFICACAO', $id);
		return $this->db->update('NOTIFICACAO',$data);
	}

	public function listaUsuarioEnviarNotificacao() {

		$this->db->select('PERMISSAO.SEQ_USUARIO, USUARIO.EMAIL_USUARIO');
		$this->db->from('PERMISSAO');
		$this->db->join('METODO', 'PERMISSAO.SEQ_METODO = METODO.SEQ_METODO');
		$this->db->join('USUARIO', 'PERMISSAO.SEQ_USUARIO = USUARIO.SEQ_USUARIO');
		$this->db->where('METODO.MOD_METODO','contrato');
		$this->db->where('METODO.CLA_METODO','agendador');
		$this->db->where('METODO.NOM_METODO','processa');
		$query = $this->db->get();

		return $query->result();
	}
}
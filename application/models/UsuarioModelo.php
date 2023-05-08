<?php
class UsuarioModelo extends CI_Model {

	protected $tabela = "USUARIO";

	protected $colunaId = "SEQ_USUARIO";

	protected $colunaOrder = "LOGIN_USUARIO";
	

	
	public function __construct()
        {
			$this->load->database();
        }

    # VALIDA USUÁRIO
    public function validate() {
//		'SENHA_USUARIO' => $this->hash512($this->input->post('senha')),
		$query = $this->db->get_where($this->tabela,
			array(
				'LOGIN_USUARIO' => $this->input->post('login'),
				'SENHA_USUARIO' => $this->hash512($this->input->post('senha')),
				'IND_ATIVO' => 'S'));
		return $query->row_array();
    }
	
	public function hash512($senha){
		return hash('sha512',$senha,false);
	}
	

    # VERIFICA SE O USUÁRIO ESTÁ LOGADO
    public function logado() {
        $logado = $this->session->userdata('logado');
        if (!isset($logado) || $logado != true) {
            redirect('login');
        }
    }
	
	public function listaOperador() {
		
			$this->db->where('IND_ATIVO', 'S');
			$this->db->order_by('NOME_USUARIO', 'ASC');

        $query = $this->db->get($this->tabela);
		return $query->result_array();
    }
	public function loginUsuario($login) {
		$this->db->where('LOGIN_USUARIO',$login);
		return $this->db->count_all_results($this->tabela);
    }
	public function emailUsuario($mail) {
		
		$this->db->where('EMAIL_USUARIO',$mail);
        return $this->db->count_all_results($this->tabela);
    }
	public function listaUsuario() {
		$this->db->order_by('LOGIN_USUARIO', 'ASC');
        $this->db->where("LOGIN_USUARIO<>'admin'");
        $this->db->where("PERFIL_USUARIO<>'ROLE_CLI'");
        $this->db->where("IND_ATIVO<>'N'");
        $query = $this->db->get($this->tabela);
		return $query->result_array();
    }
    public function listaUsuarioSemAdm() {
//        $this->db->where("PERFIL_USUARIO<>'ROLE_ADM'");
        $this->db->where("LOGIN_USUARIO<>'admin'");
        $this->db->order_by('LOGIN_USUARIO', 'ASC');
        $query = $this->db->get($this->tabela);
        return $query->result_array();
    }

    public function editarUsuario($id) {
		$this->db->where('SEQ_USUARIO', $id);
		$query = $this->db->get($this->tabela);
		return $query->result_array();
	}

    # VERIFICA SE O USUÁRIO ESTÁ LOGADO
    public function inserir($data=NULL)
	{
		$this->db->insert($this->tabela, $data);

        return $this->db->insert_id();

	}

    public function inserirLotePerfil($data=NULL)
    {
        return $this->db->insert_batch('PERFIL_USUARIO', $data);

    }

	public function alterarLogin($tb_usuario,$idUsuario) {
		$this->db->where('LOGIN_USUARIO', $idUsuario);
		return $this->db->update($this->tabela,$tb_usuario);
	}

	public function alterar($tb_usuario,$idUsuario) {
		$this->db->where('SEQ_USUARIO', $idUsuario);
		return $this->db->update($this->tabela,$tb_usuario);
	}

	public function listaMetodos() {

		$this->db->distinct();
		$this->db->select('METODO.SEQ_METODO,METODO.MOD_METODO, METODO.CLA_METODO, METODO.NOM_METODO, METODO.IDE_METODO, METODO.DESC_METODO');
		$this->db->order_by('METODO.IDE_METODO', 'ASC');
		$query = $query = $this->db->get('METODO');
		return $query->result_array();
	}
	public function listaSistema() {

		$this->db->distinct();
		$this->db->select('METODO.MOD_METODO');
		$this->db->order_by('METODO.MOD_METODO', 'ASC');
		$query = $query = $this->db->get('METODO');
		return $query->result_array();
	}

	public function inserirPermissao($data=NULL)
	{
		return $this->db->insert('PERFIL_USUARIO', $data);

	}

	public function listaPermissao($id) {
		$this->db->select('PERFIL_USUARIO.SEQ_PERFIL');
		$this->db->where('SEQ_USUARIO',$id);
		$query = $this->db->get('PERFIL_USUARIO');
		return $query->result_array();
	}

	public function deletarPermissao($id) {
		$this->db->where('SEQ_USUARIO', $id);
		return $this->db->delete('PERFIL_USUARIO');
	}

	public function getUsuario($id) {
		$this->db->where('SEQ_USUARIO', $id);
		return $this->db->get($this->tabela);
	}
}
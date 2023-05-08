<?php
class UsuarioModelo extends MY_Model {

	protected $tabela = "USUARIO";

	protected $colunaId = "SEQ_USUARIO";

	protected $colunaOrder = "LOGIN_USUARIO";
	

	
	public function __construct()
        {
			$this->load->database('monitor');
        }

    # VALIDA USUÁRIO
    public function validate() {
//		'SENHA_USUARIO' => $this->hash512($this->input->post('senha')),
		$query = $this->monitor->get_where($this->tabela,
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
		
			$this->monitor->where('IND_ATIVO', 'S');
			$this->monitor->order_by('NOME_USUARIO', 'ASC');

        $query = $this->monitor->get($this->tabela);
		return $query->result_array();
    }
	public function loginUsuario($login) {
		$this->monitor->where('LOGIN_USUARIO',$login);
		return $this->monitor->count_all_results($this->tabela);
    }
	public function emailUsuario($mail) {
		
		$this->monitor->where('EMAIL_USUARIO',$mail);
        return $this->monitor->count_all_results($this->tabela);
    }
	public function listaUsuario() {
		$this->monitor->order_by('LOGIN_USUARIO', 'ASC');
        $this->monitor->where("LOGIN_USUARIO<>'admin'");
        $query = $this->monitor->get($this->tabela);
		return $query->result_array();
    }
    public function listaUsuarioSemAdm() {
//        $this->monitor->where("PERFIL_USUARIO<>'ROLE_ADM'");
        $this->monitor->where("LOGIN_USUARIO<>'admin'");
        $this->monitor->order_by('LOGIN_USUARIO', 'ASC');
        $query = $this->monitor->get($this->tabela);
        return $query->result_array();
    }

    public function editarUsuario($id) {
		$this->monitor->where('SEQ_USUARIO', $id);
		$query = $this->monitor->get($this->tabela);
		return $query->result_array();
	}

    # VERIFICA SE O USUÁRIO ESTÁ LOGADO
    public function inserir($data=NULL)
	{
		$this->monitor->insert($this->tabela, $data);

        return $this->monitor->insert_id();

	}

    public function inserirLotePerfil($data=NULL)
    {
        return $this->monitor->insert_batch('PERFIL_USUARIO', $data);

    }

	public function alterarLogin($tb_usuario,$idUsuario) {
		$this->monitor->where('LOGIN_USUARIO', $idUsuario);
		return $this->monitor->update($this->tabela,$tb_usuario);
	}

	public function alterar($tb_usuario,$idUsuario) {
		$this->monitor->where('SEQ_USUARIO', $idUsuario);
		return $this->monitor->update($this->tabela,$tb_usuario);
	}

	public function listaMetodos() {

		$this->monitor->distinct();
		$this->monitor->select('METODO.SEQ_METODO,METODO.MOD_METODO, METODO.CLA_METODO, METODO.NOM_METODO, METODO.IDE_METODO, METODO.DESC_METODO');
		$this->monitor->order_by('METODO.IDE_METODO', 'ASC');
		$query = $query = $this->monitor->get('METODO');
		return $query->result_array();
	}
	public function listaSistema() {

		$this->monitor->distinct();
		$this->monitor->select('METODO.MOD_METODO');
		$this->monitor->order_by('METODO.MOD_METODO', 'ASC');
		$query = $query = $this->monitor->get('METODO');
		return $query->result_array();
	}

	public function inserirPermissao($data=NULL)
	{
		return $this->monitor->insert('PERFIL_USUARIO', $data);

	}

	public function listaPermissao($id) {
		$this->monitor->select('PERFIL_USUARIO.SEQ_PERFIL');
		$this->monitor->where('SEQ_USUARIO',$id);
		$query = $this->monitor->get('PERFIL_USUARIO');
		return $query->result_array();
	}

	public function deletarPermissao($id) {
		$this->monitor->where('SEQ_USUARIO', $id);
		return $this->monitor->delete('PERFIL_USUARIO');
	}

	public function getUsuario($id) {
		$this->monitor->where('SEQ_USUARIO', $id);
		return $this->monitor->get($this->tabela);
	}
}
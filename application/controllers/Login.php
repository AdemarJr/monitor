<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
    }
	public function inserirAuditoria($operacao=NULL,$tipo=NULL, $obs=NULL,$usuario=NULL)
    {
        $tb_auditoria = array(
            'SEQ_USUARIO' => $usuario,
            'TIPO_AUDITORIA' => $tipo,
            'OPER_AUDITORIA' => $operacao,
            'OBS_AUDITORIA' => $obs,
            'SESSION_ID'=> session_id()
        );
        $this->AuditoriaModelo->inserir($tb_auditoria);
    }
    function index() {

        if(!empty($this->session->userdata('dominio')))
//            $this->session->userdata('dominio')
            $this->session->sess_destroy();

        // VALIDATION RULES
        $this->load->library('form_validation');
        $this->form_validation->set_rules('login', 'Login', 'callback_login_check');
        $this->form_validation->set_rules('senha', 'Senha', 'callback_senha_check');
        $this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
        // MODELO AutenticarModelo
        $query = $this->UsuarioModelo->validate();
        if ($this->form_validation->run() == FALSE) {
			$this->load->view('modulos/template/cabecalho');
			$this->load->view('modulos/autenticar/login');
            $this->load->view('modulos/template/rodape');
        } else {
            $target = $this->input->post('target');
            if (isset($query)) { // VERIFICA LOGIN E SENHA
                if ((SETOR_ELEICAO=='1' and $query['SEQ_SETOR']!=516) or (SETOR_ELEICAO=='0' and $query['SEQ_SETOR']==516) ){

                    $data['errorAutenticacao']="Acesso Negado!";
                    $this->load->view('modulos/template/cabecalho', $data);
                    $this->load->view('modulos/autenticar/login', $data);
                    $this->load->view('modulos/template/rodape');
                } else {
                    $listaClientes=NULL;
                    $idClienteSessao = NULL;
                    $temaClienteSessao='indigo';
                    $permissoes = $this->ComumModelo->getUserPermission($query['SEQ_USUARIO'])->result_array();
                    $eSelecao=true;
    //                if($query['PERFIL_USUARIO']=='ROLE_CLI'){
    //                    $idClienteSessao = $this->ComumModelo->getUserPermission($query['SEQ_USUARIO'])->result_array();
    //                    $eSelecao = false;
    //                } else
                    if($query['PERFIL_USUARIO']=='ROLE_ADM') {
                        $listaClientes = $this->ComumModelo->getClienteTodos()->result_array();
                        $eSelecao = false;
                    }  else {
                        $listaClientes = $this->ComumModelo->getClientes($query['SEQ_CLIENTE'])->result_array();
                    }

                    if((!empty($listaClientes) and count($listaClientes)==1) or ($query['PERFIL_USUARIO']=='ROLE_SET')){
                        foreach ($listaClientes as $index => $valor) {
                            $idClienteSessao = $valor['SEQ_CLIENTE'];
                            $temaClienteSessao=$valor['TEMA_CLIENTE'];
                            $eSelecao = false;
                        }
                    }
                    $dominio = 'monitor';
                    if (stripos($_SERVER['REQUEST_URI'],'monitor-dsv')==false){
                        $dominio = 'monitor-dsv';
                    }

                    $data = array(
                        'idUsuario' =>$query['SEQ_USUARIO'],
                        'loginUsuario' =>$query['LOGIN_USUARIO'],
                        'nomeUsuario' =>$query['NOME_USUARIO'],
                        'emailUsuario' => $query['EMAIL_USUARIO'],
                        'perfilUsuario' => $query['PERFIL_USUARIO'],
                        'alteraSenha' => $query['IND_ALTERAR_SENHA'],
                        'setorUsuario' => $query['SEQ_SETOR'],
                        'idClienteSessao' => $idClienteSessao,
                        'temaClienteSessao' => $temaClienteSessao,
                        'listaCliente'=>$query['SEQ_CLIENTE'],
                        'listaTipo'=>$query['TIPO_MATERIA'],
                        'logado' => true,
                        'eSelecao'=> $eSelecao,
    //                    'clientes'=>$listaClientes,
                        'dominio'=>$dominio,
                        'permissoes'=>$permissoes
                    );
                    $this->inserirAuditoria('LOGIN-SISTEMA','A','Autorizado',$query['SEQ_USUARIO']);
                    $this->session->set_userdata($data);
                    if (!empty($target)){
                        redirect(base_url($target));
                    }else if ($query['PERFIL_USUARIO']!='ROLE_SET'){
                        
//                        if ($_SESSION['idUsuario'] == 1 || $_SESSION['idUsuario'] == 60 || $_SESSION['idUsuario'] == 155 ) {
//                            redirect('novosistema');  
//                          } else {
//                            redirect('materia');   
//                          }
                        if ($_SESSION['idUsuario'] == 204) {
                            redirect('dashboard');
                        } else {
                            redirect('notificacao');
                        }
                    }
                    else{
                        redirect('iniciousuario');
                    }
                }
            } else {
				$data['errorAutenticacao']="Acesso Negado!";
				$this->load->view('modulos/template/cabecalho', $data);
				$this->load->view('modulos/autenticar/login', $data);
				$this->load->view('modulos/template/rodape');
            }
        }
    }
	
	public function login_check($str)
        {
                if (!isset($str))
                {
                        $this->form_validation->set_message('login_check', 'O Login é obrigatório!');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
		public function senha_check($str)
        {
                if (!isset($str))
                {
                        $this->form_validation->set_message('senha_check', 'A Senha é obrigatório!');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
	
}
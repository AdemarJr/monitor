<?php

class Usuario extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('perfilModelo', 'PerfilModelo');
        $this->load->model('clienteModelo', 'ClienteModelo');
        $this->auth->CheckAuth('geral', $this->router->fetch_class(), $this->router->fetch_method());
    }

    public function index() {
        $this->inserirAuditoria('CONSULTAR-USUARIO', 'C', 'Lista Todos');
        $resultado['lista_usuario'] = $this->UsuarioModelo->listaUsuario();
        $resultado['ctrl'] = $this;
        $this->loadUrl('modulos/usuario/consultar', $resultado);
    }
    
    public function auditoria() {
        
    }
    
    public function novo() {
        $resultado['lista_cliente'] = $this->ClienteModelo->listaCliente();
        $this->loadUrl('modulos/usuario/novo', $resultado);
    }

    public function existeLogin() {
        $valid = true;
        $message = '';
        $valor = explode("=", $_SERVER['QUERY_STRING']);
        if ($this->UsuarioModelo->loginUsuario(preg_replace('/[^0-9]/', '', $valor[1])) > 0) {
            $valid = false;
        }
        echo $valid ? 'sucesso' : 'erro';
    }

    public function existeEmail() {
        $valid = true;
        $message = '';
        $valor = explode("=", $_SERVER['QUERY_STRING']);
        $email = str_replace("%40", "@", $valor[1]);
        if ($this->UsuarioModelo->emailUsuario($email) > 0) {
            $valid = false;
        }
        echo $valid ? 'sucesso' : 'erro';
    }

    //salvar nova ordem de servico
    public function salvar() {
        extract($this->input->post());
        $clientes = NULL;
        if (is_array($cliente)) {
            $clientes = implode($cliente, ',');
        } else {
            $clientes = $cliente;
        }
        $tipos = NULL;
        if (is_array($tipo)) {
            $tipos = implode($tipo, ',');
        } else {
            $tipos = $tipo;
        }


        //inserir usuario cliente
        $data = array(
            'LOGIN_USUARIO' => preg_replace('/[^0-9]/', '', $loginUsuario),
            'PERFIL_USUARIO' => $perfilUsuario,
            'EMAIL_USUARIO' => $emailUsuario,
            'CPF_USUARIO' => $cpfUsuario,
            'IND_ATIVO' => 'N',
            'NOME_USUARIO' => $nomeUsuario,
            'FONE_USUARIO' => $foneUsuario,
            'SEQ_CLIENTE' => $clientes,
            'TIPO_MATERIA' => $tipos,
            'LOGRADOURO_USUARIO' => $logradouro,
            'BAIRRO_USUARIO' => $bairro,
            'NUMERO_USUARIO' => $numero,
            'COMPLEMENTO_USUARIO' => $complemento,
            'CEP_USUARIO' => $cep,
            'CIDADE_USUARIO' => $cidade,
            'UF_USUARIO' => $uf,
            'LAT_USUARIO' => $latitude,
            'LONG_USUARIO' => $longitude,
            'IMAGEM_USUARIO' => $imagem64,
            'PAIS_USUARIO' => $pais
        );
        $this->inserirAuditoria('INSERIR-USUARIO', 'I', json_encode($data));
        $this->db->trans_begin();
        $idNewUser = $this->UsuarioModelo->inserir($data);
        // inserir perfil
        if ($perfilUsuario == 'ROLE_CLI') {
            $dataPerfil = array(
                'SEQ_USUARIO' => $idNewUser,
                'SEQ_PERFIL' => 2
            );
        } else if ($perfilUsuario == 'ROLE_REP') {
            $dataPerfil = array(
                'SEQ_USUARIO' => $idNewUser,
                'SEQ_PERFIL' => 3
            );
        }/* else if ($perfilUsuario=='ROLE_USU') {
          $dataPerfil = array(
          'SEQ_USUARIO'=>$idNewUser,
          'SEQ_PERFIL'=>4
          );
          } */ else if ($perfilUsuario == 'ROLE_SET') {
            $dataPerfil = array(
                'SEQ_USUARIO' => $idNewUser,
                'SEQ_PERFIL' => 13
            );
        }
        $dataPerfil2 = array(
            'SEQ_USUARIO' => $idNewUser,
            'SEQ_PERFIL' => 5
        );
        if (!empty($dataPerfil))
            $this->UsuarioModelo->inserirPermissao($dataPerfil);
        $this->UsuarioModelo->inserirPermissao($dataPerfil2);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $class = 'error';
            $mensagem = 'Usuário Não Incluído!';
        } else {
            $this->db->trans_commit();
            $class = 'success';
            $mensagem = 'Usuário Incluido com sucesso!!';
        }
        $this->feedBack($class, $mensagem, 'usuario');
    }
    private function diferencaHora($horario1, $horario2) {
        $entrada = $horario1;
        $saida = $horario2;
        $hora1 = explode(":", $entrada);
        $hora2 = explode(":", $saida);
        $acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
        $acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
        $resultado = $acumulador2 - $acumulador1;
        $hora_ponto = floor($resultado / 3600);
        $resultado = $resultado - ($hora_ponto * 3600);
        $min_ponto = floor($resultado / 60);
        $resultado = $resultado - ($min_ponto * 60);
        $secs_ponto = $resultado;
        $minuto = '';
        $segundos = '';
        if (strlen($min_ponto) == 2) {
            $minuto = $min_ponto;
        } else {
            $minuto = '0'.$min_ponto;
        }
        if (strlen($secs_ponto) == 2) {
            $segundos = $secs_ponto;
        } else {
            $segundos = $secs_ponto.'0';
        }
        //Grava na variável resultado final
        return  '00:'.$minuto . ":" . $segundos;
        
    }
    public function auditoriaTempo($idUsuario) {

        $SQL = "SELECT DATA_AUDITORIA, OPER_AUDITORIA FROM `AUDITORIA` "
                . "WHERE `SEQ_USUARIO` = $idUsuario "
                . "AND DATA_NUMERO BETWEEN 20230301 AND 20230301  "
                . "ORDER BY DATA_AUDITORIA ASC";
        $result = $this->db->query($SQL)->result();
        if (!empty($result)) {
        $horaInicial = '';
        $horaMeio = '';
        $horaFinal = '';
        $diferenca = '';
        $i = 0;
        $tempo = [];
        foreach ($result as $vl) {
            if ($i == 1) {
                $hora = explode(' ', $vl->DATA_AUDITORIA);
                $horaMeio = $hora[1];
                $i = 0;
            }
            if ($vl->OPER_AUDITORIA == 'INSERIR-MATERIA') {
                $hora = explode(' ', $vl->DATA_AUDITORIA);
                $horaInicial = $hora[1];
                $i++;
            }

            if (!empty($horaInicial) and!empty($horaMeio)) {
                $diferenca = $this->diferencaHora($horaInicial, $horaMeio);
                array_push($tempo, $diferenca);
                $horaInicial = '';
                $horaMeio = '';
            }
        }
        
        $tp = 0;
        
        foreach ($tempo as $k => $v ) {
            $tp += strtotime($v);
        }
        
        $horaf = date('H:i:s', ceil($tp/count($tempo)));
            return date('00:i:s', strtotime($horaf.'+15 minute'));
        } else {
            return '';    
        }
        
    }
    public function editar($id) {

        $usuario = $this->UsuarioModelo->editarUsuario($id);

        foreach ($usuario as $index => $valor) {
            $resultado['loginUsuario'] = $valor['LOGIN_USUARIO'];
            $resultado['perfilUsuario'] = $valor['PERFIL_USUARIO'];
            $resultado['emailUsuario'] = $valor['EMAIL_USUARIO'];
            $resultado['cpfUsuario'] = $valor['CPF_USUARIO'];
            $resultado['nomeUsuario'] = $valor['NOME_USUARIO'];
            $resultado['foneUsuario'] = $valor['FONE_USUARIO'];
            $resultado['idUsuario'] = $id;
            $resultado['avatar'] = $valor['IMAGEM_USUARIO'];
            $resultado['logradouro'] = $valor['LOGRADOURO_USUARIO'];
            $resultado['bairro'] = $valor['BAIRRO_USUARIO'];
            $resultado['numero'] = $valor['NUMERO_USUARIO'];
            $resultado['complemento'] = $valor['COMPLEMENTO_USUARIO'];
            $resultado['cep'] = $valor['CEP_USUARIO'];
            $resultado['cidade'] = $valor['CIDADE_USUARIO'];
            $resultado['uf'] = $valor['UF_USUARIO'];
            $resultado['latitude'] = $valor['LAT_USUARIO'];
            $resultado['longitude'] = $valor['LONG_USUARIO'];
            $resultado['pais'] = $valor['PAIS_USUARIO'];
            $resultado['cliente'] = $valor['SEQ_CLIENTE'];
            $resultado['tipo'] = $valor['TIPO_MATERIA'];
        }
        $resultado['lista_cliente'] = $this->ClienteModelo->listaCliente();
        $this->loadUrl('modulos/usuario/editar', $resultado);
    }

    public function senha($id) {

        $usuario = $this->UsuarioModelo->editarUsuario($id);
        foreach ($usuario as $index => $valor) {
            $resultado['loginUsuario'] = $valor['LOGIN_USUARIO'];
            $resultado['nomeUsuario'] = $valor['NOME_USUARIO'];
            $resultado['idUsuario'] = $id;
        }
        $this->loadUrl('modulos/usuario/senha', $resultado);
    }

    //alterar o fornecedor
    public function alterar() {
        $idUsuario = $this->input->post('idUsuario');

        $dataUsuarioAtual = $this->UsuarioModelo->getUsuario($idUsuario)->row();
        extract($this->input->post());
        $clientes = NULL;
        if (is_array($cliente)) {
            $clientes = implode($cliente, ',');
        } else {
            $clientes = $cliente;
        }

        $tipos = NULL;
        if (is_array($tipo)) {
            $tipos = implode($tipo, ',');
        } else {
            $tipos = $tipo;
        }

        $data = array(
            'PERFIL_USUARIO' => $perfilUsuario,
            'EMAIL_USUARIO' => $emailUsuario,
            'CPF_USUARIO' => $cpfUsuario,
            'LOGIN_USUARIO' => $loginUsuario,
            //  'IND_ATIVO'=>'N',
            'NOME_USUARIO' => $nomeUsuario,
            'SEQ_CLIENTE' => $clientes,
            'TIPO_MATERIA' => $tipos,
            'FONE_USUARIO' => $foneUsuario,
            'LOGRADOURO_USUARIO' => $logradouro,
            'BAIRRO_USUARIO' => $bairro,
            'NUMERO_USUARIO' => $numero,
            'COMPLEMENTO_USUARIO' => $complemento,
            'CEP_USUARIO' => $cep,
            'CIDADE_USUARIO' => $cidade,
            'UF_USUARIO' => $uf,
            'LAT_USUARIO' => $latitude,
            'LONG_USUARIO' => $longitude,
            'PAIS_USUARIO' => $pais,
            'SEQ_SETOR' => NULL
        );

        if (!empty($this->input->post('imagem64'))) {
            $data = array_merge($data, array('IMAGEM_USUARIO' => $this->input->post('imagem64')));
        }

        $this->inserirAuditoria('ALTERAR-USUARIO', 'A', json_encode($data));
        $this->db->trans_begin();
        $this->UsuarioModelo->alterar($data, $idUsuario);
        if ($dataUsuarioAtual->PERFIL_USUARIO != $perfilUsuario) {
            $this->UsuarioModelo->deletarPermissao($idUsuario);

            if ($perfilUsuario == 'ROLE_CLI') {
                $dataPerfil = array(
                    'SEQ_USUARIO' => $idUsuario,
                    'SEQ_PERFIL' => 2
                );
            } else if ($perfilUsuario == 'ROLE_REP') {
                $dataPerfil = array(
                    'SEQ_USUARIO' => $idUsuario,
                    'SEQ_PERFIL' => 3
                );
            } else if ($perfilUsuario == 'ROLE_USU') {
                $dataPerfil = array(
                    'SEQ_USUARIO' => $idUsuario,
                    'SEQ_PERFIL' => 4
                );
            } else if ($perfilUsuario == 'ROLE_SET') {
                $dataPerfil = array(
                    'SEQ_USUARIO' => $idUsuario,
                    'SEQ_PERFIL' => 13
                );
            }
            $dataPerfil2 = array(
                'SEQ_USUARIO' => $idUsuario,
                'SEQ_PERFIL' => 5
            );
            $this->UsuarioModelo->inserirPermissao($dataPerfil);
            $this->UsuarioModelo->inserirPermissao($dataPerfil2);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $class = 'error';
            $mensagem = 'Usuário Não Alterado!';
        } else {
            $this->db->trans_commit();
            $class = 'success';
            $mensagem = 'Usuário Alterado com sucesso!!';
        }
        $this->feedBack($class, $mensagem, 'usuario');
    }

    public function alterarSenha() {

        $idUsuario = $this->input->post('idUsuario');

        //inserir Fornecedor
        $tb_usuario = array(
            'LOGIN_USUARIO' => $this->input->post('loginUsuario'),
            'SENHA_USUARIO' => $this->UsuarioModelo->hash512($this->input->post('senhaUsuario'))
        );
        $this->inserirAuditoria('ALTERAR-SENHA-USUARIO', 'A', json_encode($tb_usuario));
        $this->db->trans_begin();
        $this->UsuarioModelo->alterar($tb_usuario, $idUsuario);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $class = 'error';
            $mensagem = 'Senha do Usuário Não Alterado!';
        } else {
            $this->db->trans_commit();
            $class = 'success';
            $mensagem = 'Senha do Usuário Alterado com sucesso!!';
        }
        if ('ROLE_ADM' == $this->session->userData('perfilUsuario')) {
            $retorno = 'usuario';
        } else {
            $retorno = 'inicio';
        }
        $this->feedBack($class, $mensagem, $retorno);
    }

    public function alterarStatus($id) {
        $usuarioSts = '';

        $usuario = $this->UsuarioModelo->editarUsuario($id);
        foreach ($usuario as $index => $valor) {
            $usuarioSts = $valor['IND_ATIVO'] == 'S' ? 'N' : 'S';
        }
        $tb_usuario = array('IND_ATIVO' => $usuarioSts);

        $this->db->trans_begin();
        $this->UsuarioModelo->alterar($tb_usuario, $id);

        $this->inserirAuditoria('ALTERAR-STATUS-USUARIO', 'A', 'usuarioId:' . $id . ' - usuarioSts:' . $usuarioSts);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $class = 'error';
            $mensagem = 'Usuário Não Alterado!';
        } else {
            $this->db->trans_commit();
            $class = 'success';
            $mensagem = 'Usuário Alterado com sucesso!!';
        }
        $this->feedBack($class, $mensagem, 'usuario');
    }

    public function perfil($id) {
        $usuario = $this->UsuarioModelo->editarUsuario($id);

        foreach ($usuario as $index => $valor) {
            $resultado['loginUsuario'] = $valor['LOGIN_USUARIO'];
            $resultado['nomeUsuario'] = $valor['NOME_USUARIO'];
            $resultado['perfilUsuario'] = $valor['PERFIL_USUARIO'];
            $resultado['idUsuario'] = $id;
        }

        $permissoes = $this->UsuarioModelo->listaPermissao($id);
        $permissoesResult = array();
        foreach ($permissoes as $index => $valor1) {
            array_push($permissoesResult, $valor1['SEQ_PERFIL']);
        }


        $resultado['sistemas'] = $this->UsuarioModelo->listaSistema();
        $resultado['perfis'] = $this->PerfilModelo->listaPerfil();
        $resultado['permissoes'] = $permissoesResult;

        $this->loadUrl('modulos/usuario/perfil', $resultado);
    }

    public function setor($id) {
        $usuario = $this->UsuarioModelo->editarUsuario($id);

        foreach ($usuario as $index => $valor) {
            $resultado['loginUsuario'] = $valor['LOGIN_USUARIO'];
            $resultado['nomeUsuario'] = $valor['NOME_USUARIO'];
            $resultado['perfilUsuario'] = $valor['PERFIL_USUARIO'];
            $resultado['setorUsuario'] = $valor['SEQ_SETOR'];
            $resultado['clienteUsuario'] = $valor['SEQ_CLIENTE'];
            $resultado['idUsuario'] = $id;
        }

        //	$permissoes=$this->UsuarioModelo->listaPermissao($id);
//		$permissoesResult = array();
//		foreach ($permissoes as $index => $valor1){
//			array_push($permissoesResult,$valor1['SEQ_PERFIL']);
//		}
//		$resultado['sistemas']=$this->ClienteModelo->listaClientes();

        $resultado['clientes'] = $this->ComumModelo->getClientes($resultado['clienteUsuario'])->result_array();

//		$resultado['perfis']=$this->SetorModelo->listaSetor();
//		$resultado['permissoes']=$permissoesResult;

        $this->loadUrl('modulos/usuario/setor', $resultado);
    }

    public function perfilSalvar() {
        extract($this->input->post());

        $this->db->trans_begin();
        $this->UsuarioModelo->deletarPermissao($idUsuario);
        foreach ($perfis as $itemMetodo) {
            $data = array(
                'SEQ_USUARIO' => $idUsuario,
                'SEQ_PERFIL' => $itemMetodo
            );

            $this->UsuarioModelo->inserirPermissao($data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $class = 'error';
            $mensagem = 'Usuario Nao Alterado!';
        } else {
            $this->db->trans_commit();
            $class = 'success';
            $mensagem = 'Usuário Alterado com sucesso!!';
        }
        $this->feedBack($class, $mensagem, 'usuario');
    }

    public function setorSalvar() {
        extract($this->input->post());

//		$this->UsuarioModelo->deletarPermissao($idUsuario);
//		$setoresArray = array();
//		foreach ($setor as $itemSetor) {
//			array_push($setoresArray,$itemSetor);
//
//		}

        $data = array(
            'SEQ_SETOR' => $setor
        );

        if (!$this->UsuarioModelo->alterar($data, $idUsuario)) {
            $class = 'error';
            $mensagem = 'Usuario Nao Alterado!';
        } else {
            $class = 'success';
            $mensagem = 'Usuário Alterado com sucesso!!';
        }


        $this->feedBack($class, $mensagem, 'usuario');
    }

    public function avatar($id) {
        $usuario = $this->UsuarioModelo->getUsuario($id)->row()->IMAGEM_USUARIO;

        if (!empty($usuario)) {
            $data = explode(',', $usuario);
            header('Content-Type: image/png');
            echo base64_decode($data[1]);
        } else {
            header("Content-Type: image/png");
            readfile("./assets/images/user.png");
        }
    }

}

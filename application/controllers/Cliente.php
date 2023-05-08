<?php
class Cliente extends MY_Controller {

        public function __construct()
        {
                parent::__construct();
            $this->load->model('clienteModelo', 'ClienteModelo');
            $this->load->model('integracaoModelo', 'IntegracaoModelo');
			$this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());

		}
        public function index()
        {
			$this->inserirAuditoria('CONSULTAR-CLIENTE','C','Lista Todos');
  			$resultado['lista_cliente'] = $this->ClienteModelo->listaCliente();
			$this->loadUrl('modulos/cliente/consultar',$resultado);
	
        }
		
		public function novo()
		{
			$this->loadUrl('modulos/cliente/novo');
		}

		//salvar nova ordem de servico
		public function salvar()
		{
            extract($this->input->post());
            //inserir cliente
            $monitores = NULL;
			if (is_array($monitoramento)){
				$monitores = implode($monitoramento,',');
			} else {
				$monitores = $monitoramento;
			}
			$data = array(
                'NOME_CLIENTE'=>$this->input->post('nomeCliente'),
                'EMPRESA_CLIENTE'=>$this->input->post('empresaCliente'),
                'PROFISSAO_CLIENTE'=>$this->input->post('profissaoCliente'),
                'LOGRADOURO_CLIENTE'=>$this->input->post('logradouro'),
                'BAIRRO_CLIENTE'=>$this->input->post('bairro'),
                'NUMERO_CLIENTE'=>$this->input->post('numero'),
                'COMPLEMENTO_CLIENTE'=>$this->input->post('complemento'),
                'TIPO_PESSOA_CLIENTE'=>$this->input->post('tipoPessoa'),
                'CEP_CLIENTE'=>$this->input->post('cep'),
                'CIDADE_CLIENTE'=>$this->input->post('cidade'),
                'EMAIL_CLIENTE'=>$this->input->post('emailCliente'),
                'CNPJ_CPF_CLIENTE'=>$this->input->post('cpfcnpjCliente'),
                'FONE_CLIENTE'=>$this->input->post('foneCliente'),
                'IND_ATIVO'=>'S',
                'UF_CLIENTE'=>$this->input->post('uf'),
                'LAT_CLIENTE'=>$this->input->post('latitude'),
                'LONG_CLIENTE'=>$this->input->post('longitude'),
                'IMAGEM_CLIENTE'=>$this->input->post('imagem64'),
                'PAIS_CLIENTE'=>$this->input->post('pais'),
                'TERMO_CLIENTE'=>$this->input->post('termo'),
                'IND_SETOR'=>$this->input->post('setor'),
                'LOGO_EMPRESA'=>$this->input->post('logoEmpresa'),
                'LISTA_MONITORAMENTO'=>$monitores
						);
			$this->inserirAuditoria('INSERIR-CLIENTE','I', json_encode($data));



			if (!$this->ClienteModelo->inserir($data))
			{
                $class = 'error';
                $mensagem = 'Cliente Não Incluído!';
			}
			else
			{
                $this->salvarUsuario($data);
                $class = 'success';
                $mensagem = 'Cliente Incluido com sucesso!!';
			}
            $this->feedBack($class,$mensagem,'cliente');
		}
    public function salvarUsuario($cliente)
    {
        $data = array(
            'LOGIN_USUARIO' =>preg_replace( '/[^0-9]/', '', $cliente['CNPJ_CPF_CLIENTE'] ),
            'PERFIL_USUARIO' =>'ROLE_CLI',
            'EMAIL_USUARIO'=>$cliente['EMAIL_CLIENTE'],
            'CPF_USUARIO'=>$cliente['CNPJ_CPF_CLIENTE'],
            'IND_ATIVO'=>'N',
            'NOME_USUARIO'=>$cliente['NOME_CLIENTE'],
            'FONE_USUARIO'=>$cliente['FONE_CLIENTE'],
            'LOGRADOURO_USUARIO'=>$cliente['LOGRADOURO_CLIENTE'],
            'BAIRRO_USUARIO'=>$cliente['BAIRRO_CLIENTE'],
            'NUMERO_USUARIO'=>$cliente['NUMERO_CLIENTE'],
            'COMPLEMENTO_USUARIO'=>$cliente['COMPLEMENTO_CLIENTE'],
            'CEP_USUARIO'=>$cliente['CEP_CLIENTE'],
            'CIDADE_USUARIO'=>$cliente['CIDADE_CLIENTE'],
            'UF_USUARIO'=>$cliente['UF_CLIENTE'],
            'LAT_USUARIO'=>$cliente['LAT_CLIENTE'],
            'LONG_USUARIO'=>$cliente['LONG_CLIENTE'],
            'IMAGEM_USUARIO'=>$cliente['IMAGEM_CLIENTE'],
            'PAIS_USUARIO'=>$cliente['PAIS_CLIENTE']
        );
        $this->inserirAuditoria('INSERIR-USUARIO-CLIENTE','I', json_encode($data));
        $userNovo = $this->UsuarioModelo->inserir($data);

        $dataPerfil = array(
            'SEQ_USUARIO'=>$userNovo,
            'SEQ_PERFIL'=>2
        );
        $dataPerfil2 = array(
            'SEQ_USUARIO'=>$userNovo,
            'SEQ_PERFIL'=>5
        );

        $this->UsuarioModelo->inserirPermissao($dataPerfil);
        $this->UsuarioModelo->inserirPermissao($dataPerfil2);


    }
		public function editar($id)
		{
			
			$cliente = $this->ClienteModelo->editar($id);

			foreach ($cliente as $index => $valor){
				$resultado['nomeCliente'] =$valor['NOME_CLIENTE'];
                $resultado['empresaCliente'] =$valor['EMPRESA_CLIENTE'];
                $resultado['profissaoCliente'] =$valor['PROFISSAO_CLIENTE'];
				$resultado['logradouro'] =$valor['LOGRADOURO_CLIENTE'];
				$resultado['bairro'] = $valor['BAIRRO_CLIENTE'];
				$resultado['numero'] = $valor['NUMERO_CLIENTE'];
				$resultado['complemento'] = $valor['COMPLEMENTO_CLIENTE'];
                $resultado['tipoPessoa'] = $valor['TIPO_PESSOA_CLIENTE'];
				$resultado['idCliente'] = $id;
                $resultado['cep'] = $valor['CEP_CLIENTE'];
                $resultado['cidade'] = $valor['CIDADE_CLIENTE'];
                $resultado['emailCliente'] = $valor['EMAIL_CLIENTE'];
                $resultado['cpfcnpjCliente'] = $valor['CNPJ_CPF_CLIENTE'];
                $resultado['foneCliente'] = $valor['FONE_CLIENTE'];
                $resultado['uf'] = $valor['UF_CLIENTE'];
                $resultado['latitude'] = $valor['LAT_CLIENTE'];
                $resultado['longitude'] = $valor['LONG_CLIENTE'];
                $resultado['termo'] = $valor['TERMO_CLIENTE'];
                $resultado['setor'] = $valor['IND_SETOR'];
                $resultado['pais'] = $valor['PAIS_CLIENTE'];
                $resultado['imagem64'] = $valor['IMAGEM_CLIENTE'];
                $resultado['logoEmpresa'] = $valor['LOGO_EMPRESA'];
                $resultado['monitoramento'] = $valor['LISTA_MONITORAMENTO'];
            }
            $resultado['lista_monitoramento'] = $this->IntegracaoModelo->listaMonitoramento();
			$this->loadUrl('modulos/cliente/editar',$resultado);
		}

		//alterar o fornecedor
		public function alterar()
		{
            $idCliente = $this->input->post('idCliente');
            extract($this->input->post());
            //inserir cliente
            $monitores = NULL;
			if (is_array($monitoramento)){
				$monitores = implode($monitoramento,',');
			} else {
				$monitores = $monitoramento;
			}

            $data = array(
                'NOME_CLIENTE'=>$this->input->post('nomeCliente'),
                'EMPRESA_CLIENTE'=>$this->input->post('empresaCliente'),
                'PROFISSAO_CLIENTE'=>$this->input->post('profissaoCliente'),
                'LOGRADOURO_CLIENTE'=>$this->input->post('logradouro'),
                'BAIRRO_CLIENTE'=>$this->input->post('bairro'),
                'NUMERO_CLIENTE'=>$this->input->post('numero'),
                'COMPLEMENTO_CLIENTE'=>$this->input->post('complemento'),
                'CEP_CLIENTE'=>$this->input->post('cep'),
                'CIDADE_CLIENTE'=>$this->input->post('cidade'),
                'EMAIL_CLIENTE'=>$this->input->post('emailCliente'),
                'FONE_CLIENTE'=>$this->input->post('foneCliente'),
                'IND_ATIVO'=>'S',
                'CNPJ_CPF_CLIENTE'=>$this->input->post('cpfcnpjCliente'),
                'UF_CLIENTE'=>$this->input->post('uf'),
                'LAT_CLIENTE'=>$this->input->post('latitude'),
                'LONG_CLIENTE'=>$this->input->post('longitude'),
                'PAIS_CLIENTE'=>$this->input->post('pais'),
                'TERMO_CLIENTE'=>$this->input->post('termo'),
                'IND_SETOR'=>$this->input->post('setor'),
                'LOGO_EMPRESA'=>$this->input->post('logoEmpresa'),
                'LISTA_MONITORAMENTO'=>$monitores
            );
            $this->inserirAuditoria('ALTERAR-CLIENTE','A',json_encode($data));
            if (!empty($this->input->post('imagem64'))){
                $data = array_merge($data, array('IMAGEM_CLIENTE'=>$this->input->post('imagem64')));
            }

			if (!$this->ClienteModelo->alterar($data, $idCliente))
			{
				$this->db->trans_rollback();
                $class = 'error';
                $mensagem = 'Cliente Não Alterado!';
			}
			else
			{
                $this->alterarUsuario($data,preg_replace( '/[^0-9]/', '',$this->input->post('cpfcnpjCliente')  ));
                $class = 'success';
                $mensagem = 'Cliente Alterado com sucesso!!';
			}
            $this->feedBack($class,$mensagem,'cliente');
		}
    public function alterarUsuario($cliente,$idUsuario)
    {

        $data = array(
            'EMAIL_USUARIO'=>$cliente['EMAIL_CLIENTE'],
            'CPF_USUARIO'=>$cliente['CNPJ_CPF_CLIENTE'],
            'IND_ATIVO'=>$cliente['IND_ATIVO'],
            'NOME_USUARIO'=>$cliente['NOME_CLIENTE'],
            'FONE_USUARIO'=>$cliente['FONE_CLIENTE'],
            'LOGRADOURO_USUARIO'=>$cliente['LOGRADOURO_CLIENTE'],
            'BAIRRO_USUARIO'=>$cliente['BAIRRO_CLIENTE'],
            'NUMERO_USUARIO'=>$cliente['NUMERO_CLIENTE'],
            'COMPLEMENTO_USUARIO'=>$cliente['COMPLEMENTO_CLIENTE'],
            'CEP_USUARIO'=>$cliente['CEP_CLIENTE'],
            'CIDADE_USUARIO'=>$cliente['CIDADE_CLIENTE'],
            'UF_USUARIO'=>$cliente['UF_CLIENTE'],
            'LAT_USUARIO'=>$cliente['LAT_CLIENTE'],
            'LONG_USUARIO'=>$cliente['LONG_CLIENTE'],
            'PAIS_USUARIO'=>$cliente['PAIS_CLIENTE']
        );

        if (!empty($cliente['IMAGEM_CLIENTE'])){
            $data = array_merge($data, array('IMAGEM_USUARIO'=>$cliente['IMAGEM_CLIENTE']));
        }
        $this->inserirAuditoria('ALTERAR-USUARIO-CLIENTE','A',json_encode($data));
        $this->UsuarioModelo->alterarLogin($data, preg_replace( '/[^0-9]/', '', $idUsuario ));

    }
    public function excluir($id)
    {
        $this->inserirAuditoria('EXCLUIR-CLIENTE','E','ClienteId: '.$id);
        $data = array('IND_ATIVO'=>'N');
        if($this->ClienteModelo->alterar($data,$id)){

            $clienteDoc = $this->ClienteModelo->getCliente($id)->row()->CNPJ_CPF_CLIENTE;

            $this->inserirAuditoria('ALTERAR-USUARIO-CLIENTE','A',json_encode($data));
            $this->UsuarioModelo->alterarLogin($data, preg_replace( '/[^0-9]/', '', $clienteDoc ));


            $class = 'success';
            $mensagem = 'Cliente Excluída com sucesso!!';

        } else  {
            $class = 'error';
            $mensagem = 'Cliente Não pode ser Excluída!';
        }
        $this->feedBack($class,$mensagem,'cliente');
    }
    public function seleciona($id, $modulo)
    {
        $this->inserirAuditoria('SETA-CLIENTE-SESSAO','A','ClienteId: '.$id);
        try
        {
            $data= array('idClienteSessao'=>'','temaClienteSessao'=>'');
            $this->session->unset_userdata($data);

            $clienteTema = $this->ComumModelo->getTableData('CLIENTE', array('SEQ_CLIENTE' => $id))->row()->TEMA_CLIENTE;

            $data= array('idClienteSessao'=>$id,'eSelecao'=>false,'temaClienteSessao'=>$clienteTema);
            $this->session->set_userdata($data);
                $class = 'success';
                $mensagem = 'Cliente Selecionado com sucesso!!';
        }catch (Exception $e) {
            $class = 'error';
            $mensagem = 'Cliente Não pode ser Selecionado!';
        }

        $this->feedBack($class,$mensagem,$modulo);
    }
    public function replica()
    {
        $this->inserirAuditoria('CONSULTAR-CLIENTE','C','Lista Todos');
        $resultado['lista_cliente'] = $this->ClienteModelo->listaCliente();
        $this->loadUrl('modulos/cliente/replica',$resultado);
    }
    public function replicar()
    {
        $this->inserirAuditoria('REPLICA-VEICULO-CLIENTE','E','Replica de:'.$oCliente .' para'.$dCliente);
        extract($this->input->post());

        $cliDest = $this->ClienteModelo->getCliente($dCliente)->row()->IND_REPLICA;

        if ($cliDest=='S'){
            $class = 'warning';
            $mensagem = 'Cliente já recebeu Veiculos replicados!';
        } else {
            if ($this->ClienteModelo->replicarVeiculos($oCliente, $dCliente)) {

                $data = array('IND_REPLICA'=>'S');
                $this->ClienteModelo->alterar($data, $dCliente);

                $class = 'success';
                $mensagem = 'Veiculos replicados com sucesso!!';

            } else {
                $class = 'error';
                $mensagem = 'Veiculos Não podem ser replicados!';
            }
        }
        $this->feedBack($class,$mensagem,'cliente');
    }
}
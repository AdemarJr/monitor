<?php
class Veiculo extends MY_Controller {

        public function __construct()
        {
                parent::__construct();
            $this->load->model('veiculoModelo', 'VeiculoModelo');
			$this->auth->CheckAuth('geral',$this->router->fetch_class(), $this->router->fetch_method());

		}
    private function validaOperacao($target){
        // verificar se existe cliente selecionado
        $clienteSessao = $this->session->userData('idClienteSessao');

        if (empty($clienteSessao)){
            $class = 'warning';
            $mensagem = 'Cliente Não Selecionado!';
            $this->feedBack($class,$mensagem,$target);
        }

        // verifica se o cliente da sessao o usuario da sessao tem poder

        /* TODO */
    }
        public function index()
        {
			$this->inserirAuditoria('CONSULTAR-VEICULO','C','Lista Todos');
  			$resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
			$this->loadUrl('modulos/veiculo/consultar',$resultado);
	
        }

        public function consultai($opcao='i')
        {
            $this->inserirAuditoria('CONSULTAR-VEICULO','C','Lista Todos');


            if($opcao=='i') {
                $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
                $this->loadUrl('modulos/veiculo/consultar', $resultado);
            }else if ($opcao=='s') {
                $resultado['lista_veiculo'] = $this->VeiculoModelo->listaPortal();
                $this->loadUrl('modulos/veiculo/consultar-site', $resultado);
            }else if ($opcao=='r') {
                $resultado['lista_veiculo'] = $this->VeiculoModelo->listaRadio();
                $this->loadUrl('modulos/veiculo/consultar-radio', $resultado);
            }else if ($opcao=='t') {
                $resultado['lista_veiculo'] = $this->VeiculoModelo->listaTv();
                $this->loadUrl('modulos/veiculo/consultar-tv', $resultado);
            }else {
                $this->index();
            }

        }
    public function consultas($opcao='s')
    {
        $this->inserirAuditoria('CONSULTAR-VEICULO','C','Lista Todos');
        if($opcao=='i') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
            $this->loadUrl('modulos/veiculo/consultar', $resultado);
        }else if ($opcao=='s') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaPortal();
            $this->loadUrl('modulos/veiculo/consultar-site', $resultado);
        }else if ($opcao=='r') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaRadio();
            $this->loadUrl('modulos/veiculo/consultar-radio', $resultado);
        }else if ($opcao=='t') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaTv();
            $this->loadUrl('modulos/veiculo/consultar-tv', $resultado);
        }else {
            $this->index();
        }

    }
    public function consultar($opcao='r')
    {
        if($opcao=='i') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
            $this->loadUrl('modulos/veiculo/consultar', $resultado);
        }else if ($opcao=='s') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaPortal();
            $this->loadUrl('modulos/veiculo/consultar-site', $resultado);
        }else if ($opcao=='r') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaRadio();
            $this->loadUrl('modulos/veiculo/consultar-radio', $resultado);
        }else if ($opcao=='t') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaTv();
            $this->loadUrl('modulos/veiculo/consultar-tv', $resultado);
        }else {
            $this->index();
        }
    }
    public function consultat($opcao='t')
    {
        if($opcao=='i') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
            $this->loadUrl('modulos/veiculo/consultar', $resultado);
        }else if ($opcao=='s') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaPortal();
            $this->loadUrl('modulos/veiculo/consultar-site', $resultado);
        }else if ($opcao=='r') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaRadio();
            $this->loadUrl('modulos/veiculo/consultar-radio', $resultado);
        }else if ($opcao=='t') {
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaTv();
            $this->loadUrl('modulos/veiculo/consultar-tv', $resultado);
        }else {
            $this->index();
        }

    }
		
		public function novo($opcao='i')
		{
            $resultado['tipoMat'] = $opcao;
            $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
            if($opcao=='s')
			    $this->loadUrl('modulos/veiculo/novo-site',$resultado);
            else if($opcao=='i')
                $this->loadUrl('modulos/veiculo/novo',$resultado);
            else  if($opcao=='r')
                $this->loadUrl('modulos/veiculo/novo-radio',$resultado);
            else
                $this->loadUrl('modulos/veiculo/novo-tv',$resultado);
		}


		//salvar nova ordem de servico
		public function salvar()
{
        extract($this->input->post());
        $this->validaOperacao('veiculo/novo/'.$tipoMat);

        $clienteSessao = $this->session->userData('idClienteSessao');

    //inserir veiculo
    $data = array(
        'SEQ_CLIENTE'=>$clienteSessao,
        'NOME_VEICULO'=>$this->input->post('nomeVeiculo'),
        'FANTASIA_VEICULO'=>$this->input->post('fantasiaVeiculo'),
        'LOGRADOURO_VEICULO'=>$this->input->post('logradouro'),
        'BAIRRO_VEICULO'=>$this->input->post('bairro'),
        'NUMERO_VEICULO'=>$this->input->post('numero'),
        'COMPLEMENTO_VEICULO'=>$this->input->post('complemento'),
        'CEP_VEICULO'=>$this->input->post('cep'),
        'CIDADE_VEICULO'=>$this->input->post('cidade'),
        'EMAIL_VEICULO'=>$this->input->post('emailVeiculo'),
        'SITE_VEICULO'=>$this->input->post('siteVeiculo'),
        'CNPJ_VEICULO'=>$this->input->post('cnpjVeiculo'),
        'FONE_VEICULO'=>$this->input->post('foneVeiculo'),
        'IND_ATIVO'=>'S',
        'UF_VEICULO'=>$this->input->post('uf'),
        'LAT_VEICULO'=>$this->input->post('latitude'),
        'LONG_VEICULO'=>$this->input->post('longitude'),
        'LOGO_VEICULO'=>$this->input->post('imagem64'),
        'PAIS_VEICULO'=>$this->input->post('pais')
    );
    $this->inserirAuditoria('INSERIR-VEICULO','I', json_encode($data));
    $this->db->trans_begin();
    $idNew =  $this->VeiculoModelo->inserir($data);

    if ($this->db->trans_status() === FALSE)
    {
        $this->db->trans_rollback();
        $class = 'error';
        $mensagem = 'Veículo Não Incluído!';
    }
    else
    {
        $this->db->trans_commit();
        $class = 'success';
        $mensagem = 'Veículo Incluido com sucesso!!';
    }
    $this->feedBack($class,$mensagem,'veiculo/consulta/i');
}
    public function salvarSite()
    {
        extract($this->input->post());
        $this->validaOperacao('veiculo/novo/'.$tipoMat);

        $clienteSessao = $this->session->userData('idClienteSessao');

        $data = array(
            'SEQ_CLIENTE'=>$clienteSessao,
            'NOME_PORTAL'=>$this->input->post('nomeVeiculo'),
            'CIDADE_PORTAL'=>$this->input->post('cidade'),
            'GRUPO_PORTAL'=>$this->input->post('grupo'),
            'SITE_PORTAL'=>$this->input->post('siteVeiculo'),
            'LOGO_VEICULO'=>$this->input->post('imagem64')
        );
        $this->inserirAuditoria('INSERIR-PORTAL','I', json_encode($data));
        $this->db->trans_begin();
        $idNew =  $this->VeiculoModelo->inserirPortal($data);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $class = 'error';
            $mensagem = 'Site Não Incluído!';
        }
        else
        {
            $this->db->trans_commit();
            $class = 'success';
            $mensagem = 'Site Incluido com sucesso!!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultas');
    }
    public function salvarRadio()
    {
        extract($this->input->post());
        $this->validaOperacao('veiculo/novo/'.$tipoMat);

        $clienteSessao = $this->session->userData('idClienteSessao');

        $data = array(
            'SEQ_CLIENTE'=>$clienteSessao,
            'NOME_RADIO'=>$this->input->post('nomeVeiculo'),
            'CIDADE_RADIO'=>$this->input->post('cidade'),
            'SITE_RADIO'=>$this->input->post('siteVeiculo'),
            'LOGO_VEICULO'=>$this->input->post('imagem64')
        );
        $this->inserirAuditoria('INSERIR-RADIO','I', json_encode($data));
        $idNew =  $this->VeiculoModelo->inserirRadio($data);

        if ($idNew<=0)
        {
            $class = 'error';
            $mensagem = 'Rádio Não Incluído!';
        }
        else
        {
            $this->db->trans_commit();
            $class = 'success';
            $mensagem = 'Rádio Incluido com sucesso!!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultar');
    }
    public function salvarTv()
    {
        extract($this->input->post());
        $this->validaOperacao('veiculo/novo/'.$tipoMat);

        $clienteSessao = $this->session->userData('idClienteSessao');

        $data = array(
            'SEQ_CLIENTE'=>$clienteSessao,
            'NOME_TV'=>$this->input->post('nomeVeiculo'),
            'CIDADE_TV'=>$this->input->post('cidade'),
            'SITE_TV'=>$this->input->post('siteVeiculo'),
            'LOGO_VEICULO'=>$this->input->post('imagem64')
        );
        $this->inserirAuditoria('INSERIR-TV','I', json_encode($data));
        $idNew =  $this->VeiculoModelo->inserirTv($data);

        if ($idNew<=0)
        {
            $class = 'error';
            $mensagem = 'Televisão Não Incluído!';
        }
        else
        {
            $class = 'success';
            $mensagem = 'Televisão Incluido com sucesso!!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultat');
    }
		public function editar($id)
		{
			$veiculo = $this->VeiculoModelo->editar($id);
			foreach ($veiculo as $index => $valor){
				$resultado['nomeVeiculo'] =$valor['NOME_VEICULO'];
				$resultado['fantasiaVeiculo'] = $valor['FANTASIA_VEICULO'];
				$resultado['logradouro'] =$valor['LOGRADOURO_VEICULO'];
				$resultado['bairro'] = $valor['BAIRRO_VEICULO'];
				$resultado['numero'] = $valor['NUMERO_VEICULO'];
				$resultado['complemento'] = $valor['COMPLEMENTO_VEICULO'];
				$resultado['idVeiculo'] = $id;
                $resultado['cep'] = $valor['CEP_VEICULO'];
                $resultado['cidade'] = $valor['CIDADE_VEICULO'];
                $resultado['emailVeiculo'] = $valor['EMAIL_VEICULO'];
                $resultado['siteVeiculo'] = $valor['SITE_VEICULO'];
                $resultado['cnpjVeiculo'] = $valor['CNPJ_VEICULO'];
                $resultado['foneVeiculo'] = $valor['FONE_VEICULO'];
                $resultado['uf'] = $valor['UF_VEICULO'];
                $resultado['latitude'] = $valor['LAT_VEICULO'];
                $resultado['longitude'] = $valor['LONG_VEICULO'];
                $resultado['pais'] = $valor['PAIS_VEICULO'];
                $resultado['imagem64'] = $valor['LOGO_VEICULO'];
			}
			$this->loadUrl('modulos/veiculo/editar',$resultado);
		}
    public function editarSite($id)
    {
        $veiculo = $this->VeiculoModelo->editarPortal($id);
        foreach ($veiculo as $index => $valor){
            $resultado['nomeVeiculo'] = $valor['NOME_PORTAL'];
            $resultado['cidade'] =$valor['CIDADE_PORTAL'];
            $resultado['grupo'] =$valor['GRUPO_PORTAL'];
            $resultado['siteVeiculo'] = $valor['SITE_PORTAL'];
            $resultado['idVeiculo'] = $id;
            $resultado['imagem64'] = $valor['LOGO_VEICULO'];
        }
        $resultado['lista_grupo'] = $this->VeiculoModelo->listaGrupoVeiculo();
        $this->loadUrl('modulos/veiculo/editar-site',$resultado);
    }

    public function editarRadio($id)
    {
        $veiculo = $this->VeiculoModelo->editarRadio($id);
        foreach ($veiculo as $index => $valor){
            $resultado['nomeVeiculo'] = $valor['NOME_RADIO'];
            $resultado['cidade'] =$valor['CIDADE_RADIO'];
            $resultado['siteVeiculo'] = $valor['SITE_RADIO'];
            $resultado['idVeiculo'] = $id;
            $resultado['imagem64'] = $valor['LOGO_VEICULO'];
        }
        $this->loadUrl('modulos/veiculo/editar-radio',$resultado);
    }

    public function editarTv($id)
    {
        $veiculo = $this->VeiculoModelo->editarTv($id);
        foreach ($veiculo as $index => $valor){
            $resultado['nomeVeiculo'] = $valor['NOME_TV'];
            $resultado['cidade'] =$valor['CIDADE_TV'];
            $resultado['siteVeiculo'] = $valor['SITE_TV'];
            $resultado['idVeiculo'] = $id;
            $resultado['imagem64'] = $valor['LOGO_VEICULO'];
        }
        $this->loadUrl('modulos/veiculo/editar-tv',$resultado);
    }

		//alterar o fornecedor
		public function alterar()
		{

			$idVeiculo = $this->input->post('idVeiculo');

            $this->validaOperacao('veiculo/editar/'.$idVeiculo);

            extract($this->input->post());

            $clienteSessao = $this->session->userData('idClienteSessao');

            $data = array(
                'SEQ_CLIENTE'=>$clienteSessao,
                'NOME_VEICULO'=>$this->input->post('nomeVeiculo'),
                'FANTASIA_VEICULO'=>$this->input->post('fantasiaVeiculo'),
                'LOGRADOURO_VEICULO'=>$this->input->post('logradouro'),
                'BAIRRO_VEICULO'=>$this->input->post('bairro'),
                'NUMERO_VEICULO'=>$this->input->post('numero'),
                'COMPLEMENTO_VEICULO'=>$this->input->post('complemento'),
                'CEP_VEICULO'=>$this->input->post('cep'),
                'CIDADE_VEICULO'=>$this->input->post('cidade'),
                'EMAIL_VEICULO'=>$this->input->post('emailVeiculo'),
                'SITE_VEICULO'=>$this->input->post('siteVeiculo'),
                'CNPJ_VEICULO'=>$this->input->post('cnpjVeiculo'),
                'FONE_VEICULO'=>$this->input->post('foneVeiculo'),
                'IND_ATIVO'=>'S',
                'UF_VEICULO'=>$this->input->post('uf'),
                'LAT_VEICULO'=>$this->input->post('latitude'),
                'LONG_VEICULO'=>$this->input->post('longitude'),
                'PAIS_VEICULO'=>$this->input->post('pais')
            );

            if (!empty($this->input->post('imagem64'))){
                $data = array_merge($data, array('LOGO_VEICULO'=>$this->input->post('imagem64')));
            }

			$this->inserirAuditoria('ALTERAR-VEICULO','A',json_encode($data));
			$this->db->trans_begin();
			$this->VeiculoModelo->alterar($data, $idVeiculo);
			
			if ($this->db->trans_status() === FALSE)
			{
					$this->db->trans_rollback();
                $class = 'error';
                $mensagem = 'Veículo Não Alterado!';
			}
			else
			{
					$this->db->trans_commit();
                $class = 'success';
                $mensagem = 'Veículo Alterado com sucesso!!';
			}
            $this->feedBack($class,$mensagem,'veiculo/consultai');
		}
    public function alterarSite()
    {

        $idVeiculo = $this->input->post('idVeiculo');

        $this->validaOperacao('veiculo/editarSite/'.$idVeiculo);

        extract($this->input->post());

        $clienteSessao = $this->session->userData('idClienteSessao');

        $data = array(
            'SEQ_CLIENTE'=>$clienteSessao,
            'NOME_PORTAL'=>$this->input->post('nomeVeiculo'),
            'CIDADE_PORTAL'=>$this->input->post('cidade'),
            'GRUPO_PORTAL'=>$this->input->post('grupo'),
            'SITE_PORTAL'=>$this->input->post('siteVeiculo')
        );

        if (!empty($this->input->post('imagem64'))){
            $data = array_merge($data, array('LOGO_VEICULO'=>$this->input->post('imagem64')));
        }

        $this->inserirAuditoria('ALTERAR-VEICULO','A',json_encode($data));
        if (!$this->VeiculoModelo->alterarPortal($data, $idVeiculo)){
            $class = 'error';
            $mensagem = 'Site Não Alterado!';
        } else
        {
            $class = 'success';
            $mensagem = 'Site Alterado com sucesso!!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultas');
    }
    public function alterarRadio()
    {

        $idVeiculo = $this->input->post('idVeiculo');

        $this->validaOperacao('veiculo/editarRadio/'.$idVeiculo);

        extract($this->input->post());

        $clienteSessao = $this->session->userData('idClienteSessao');

        $data = array(
            'SEQ_CLIENTE'=>$clienteSessao,
            'NOME_RADIO'=>$this->input->post('nomeVeiculo'),
            'CIDADE_RADIO'=>$this->input->post('cidade'),
            'SITE_RADIO'=>$this->input->post('siteVeiculo')
        );

        if (!empty($this->input->post('imagem64'))){
            $data = array_merge($data, array('LOGO_VEICULO'=>$this->input->post('imagem64')));
        }

        $this->inserirAuditoria('ALTERAR-RADIO','A',json_encode($data));

        if (!$this->VeiculoModelo->alterarRadio($data, $idVeiculo))
        {
            $class = 'error';
            $mensagem = 'Rádio Não Alterado!';
        }
        else
        {
            $class = 'success';
            $mensagem = 'Rádio Alterado com sucesso!!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultar');
    }
    public function alterarTv()
    {

        $idVeiculo = $this->input->post('idVeiculo');

        $this->validaOperacao('veiculo/editarTv/'.$idVeiculo);

        extract($this->input->post());

        $clienteSessao = $this->session->userData('idClienteSessao');

        $data = array(
            'SEQ_CLIENTE'=>$clienteSessao,
            'NOME_TV'=>$this->input->post('nomeVeiculo'),
            'CIDADE_TV'=>$this->input->post('cidade'),
            'SITE_TV'=>$this->input->post('siteVeiculo')
        );

        if (!empty($this->input->post('imagem64'))){
            $data = array_merge($data, array('LOGO_VEICULO'=>$this->input->post('imagem64')));
        }

        $this->inserirAuditoria('ALTERAR-TV','A',json_encode($data));

        if (!$this->VeiculoModelo->alterarTv($data, $idVeiculo))
        {
            $class = 'error';
            $mensagem = 'Televisão Não Alterado!';
        }
        else
        {
            $class = 'success';
            $mensagem = 'Televisão Alterado com sucesso!!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultat');
    }
    public function excluir($id)
    {
        $this->validaOperacao('veiculo');
        $this->inserirAuditoria('EXCLUIR-VEICULO','E','VeiculoId: '.$id);
        if($this->VeiculoModelo->deletar($id)){
            $class = 'success';
            $mensagem = 'Veículo Excluído com sucesso!!';

        } else  {
            $class = 'error';
            $mensagem = 'Veículo Não pode ser Excluído!';
        }
        $this->feedBack($class,$mensagem,'veiculo');
    }
    public function excluirSite($id)
    {
        $this->validaOperacao('veiculo');
        $this->inserirAuditoria('EXCLUIR-PORTAL','E','VeiculoId: '.$id);
        if($this->VeiculoModelo->deletarPortal($id)){
            $class = 'success';
            $mensagem = 'Site Excluído com sucesso!!';

        } else  {
            $class = 'error';
            $mensagem = 'Site Não pode ser Excluído!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultas');
    }
    public function excluirRadio($id)
    {
        $this->validaOperacao('veiculo/consultar');
        $this->inserirAuditoria('EXCLUIR-RADIO','E','VeiculoId: '.$id);
        if($this->VeiculoModelo->deletarRadio($id)){
            $class = 'success';
            $mensagem = 'Rádio Excluído com sucesso!!';
        } else  {
            $class = 'error';
            $mensagem = 'Rádio Não pode ser Excluído!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultar');
    }

    public function excluirTv($id)
    {
        $this->validaOperacao('veiculo/consultat');
        $this->inserirAuditoria('EXCLUIR-TV','E','VeiculoId: '.$id);
        if($this->VeiculoModelo->deletarTv($id)){
            $class = 'success';
            $mensagem = 'Televisão Excluído com sucesso!!';
        } else  {
            $class = 'error';
            $mensagem = 'Televisão Não pode ser Excluído!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultat');
    }

    public function carregaLogo($id)
    {

        $veiculo = $this->VeiculoModelo->getVeiculo($id)->row();

          echo !empty($veiculo)? $veiculo->LOGO_VEICULO:'';
    }
    public function carregaLogoPortal($id)
    {

        $veiculo = $this->VeiculoModelo->getPortal($id)->row();

        echo !empty($veiculo)? $veiculo->LOGO_VEICULO:'';
    }
    public function carregaLogoRadio($id)
    {

        $veiculo = $this->VeiculoModelo->getRadio($id)->row();

        echo !empty($veiculo)? $veiculo->LOGO_VEICULO:'';
    }
    public function carregaLogoTv($id)
    {

        $veiculo = $this->VeiculoModelo->getTv($id)->row();

        echo !empty($veiculo)? $veiculo->LOGO_VEICULO:'';
    }

    public function existeSite($id = NULL)
    {
        extract($this->input->post());
        $this->inserirAuditoria('VERIFICA-LINK-SITE', 'I', 'formJson:' . json_encode($this->input->post()));

        try {
            $urlParser = parse_url($siteVeiculo);
            $array_domain = explode(".",$urlParser["host"]);
            $resultado = array();
            $types = array( 'd','com','br','www','www2','' );

            foreach ($array_domain as $item) {
                if( ! in_array( $item, $types ) ) {
                    array_push($resultado,$item);
                }
            }

            if ($this->VeiculoModelo->countLinkSite( $id,$resultado) > 0) {
                echo 'existe';
            } else {
                echo 'sucesso';
            }

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            http_response_code(400);
        }

    }

    public function carregaPreco($id,$tipoMat)
    {

        $resultado['lista_preco'] = $this->VeiculoModelo->carregaPreco($id,$tipoMat);
        $this->load->view('modulos/veiculo/carrega-preco', $resultado);
    }

    public function consultaPreco($tipoMat,$id)
    {

        $resultado['id'] = $id;
        $resultado['tipoMat'] = $tipoMat;
        $resultado['lista_preco'] = $this->VeiculoModelo->carregaPreco($id,$tipoMat);
        $this->loadUrl('modulos/veiculo/consultar-preco', $resultado);
    }
    public function novoPreco($tipoMat,$id)
    {
        $resultado['idChave'] = $id;
        $resultado['tipoMat'] = $tipoMat;
        $this->loadUrl('modulos/veiculo/editar-preco', $resultado);
    }
    public function editarPreco($tipoMat,$id,$idPreco=NULL)
    {
        $resultado['idChave'] = $id;
        $resultado['idPreco'] = $idPreco;
        $resultado['tipoMat'] = $tipoMat;
        $lista_preco= $this->VeiculoModelo->getPreco($idPreco)->row();

        $resultado['descricao'] =$lista_preco->DESCRITIVO;
        $resultado['valor'] = $lista_preco->VALOR;
        $resultado['segundo'] = $lista_preco->QTD_SEGUNDO;

        $this->loadUrl('modulos/veiculo/editar-preco', $resultado);
    }

    public function alterarPreco()
    {

        extract($this->input->post());

        $clienteSessao = $this->session->userData('idClienteSessao');

        $data = array(
            'SEQ_CLIENTE'=>$clienteSessao,
            'DESCRITIVO'=>$descricao,
            'TIPO_MATERIA'=>$tipoMat,
            'SEQ_CHAVE'=>$idChave,
            'VALOR'=>$valor,
            'QTD_SEGUNDO'=> $segundo
        );

        $this->inserirAuditoria('ALTERAR-PRECO','A',json_encode($data));
        try
        {

            if (!empty($idPreco)) {
                $this->VeiculoModelo->alterarPreco($data, $idPreco);
            } else {
                $this->VeiculoModelo->inserirPreco($data);
            }
            $class = 'success';
            $mensagem = 'Preco Incluido/Alterado com sucesso!!';

        } catch (Exception $e){
            $class = 'error';
            $mensagem = 'Preco Não Incluido/Alterado!';
        }

        $this->feedBack($class,$mensagem,'veiculo/consultaPreco/'.$tipoMat.'/'.$idChave);
    }
    public function excluirPreco($tipoMat,$idChave,$id)
    {
        $this->validaOperacao('veiculo');
        $this->inserirAuditoria('EXCLUIR-VEICULO','E','VeiculoId: '.$id);
        if($this->VeiculoModelo->deletarPreco($id)){
            $class = 'success';
            $mensagem = 'Preco Excluído com sucesso!!';

        } else  {
            $class = 'error';
            $mensagem = 'Preco Não pode ser Excluído!';
        }
        $this->feedBack($class,$mensagem,'veiculo/consultaPreco/'.$tipoMat.'/'.$idChave);
    }


}
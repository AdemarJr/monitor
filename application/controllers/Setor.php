<?php
class Setor extends MY_Controller {

        public function __construct()
        {
                parent::__construct();
            $this->load->model('setorModelo', 'SetorModelo');
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
			$this->inserirAuditoria('CONSULTAR-SETOR','C','Lista Todos');
  			$resultado['lista_setor'] = $this->SetorModelo->listaSetor33();
			$this->loadUrl('modulos/setor/consultar',$resultado);
	
        }
		
		public function novo()
		{
			$resultado['lista_categoria'] = $this->SetorModelo->listaCategoriaSetor();
			$this->loadUrl('modulos/setor/novo',$resultado);
		}

		//salvar nova ordem de servico
		public function salvar()
		{
			$this->validaOperacao('setor/novo');
			extract($this->input->post());

			$clienteSessao = $this->session->userData('idClienteSessao');

			//inserir setor
			$data = array(
                'SEQ_CLIENTE'=>$clienteSessao,
				'DESC_SETOR'=>$descricaoSetor,
                'SIG_SETOR'=>$siglaSetor,
				'IND_ESTR'=>$indEstr,
                'IND_ATIVO'=>'S',
				'SEQ_CATEGORIA_SETOR'=>$categoria
						);
			$this->inserirAuditoria('INSERIR-SETOR','I', json_encode($data));
			$this->db->trans_begin();
			$idNew =  $this->SetorModelo->inserir($data);

			if ($this->db->trans_status() === FALSE)
			{
					$this->db->trans_rollback();
                $class = 'error';
                $mensagem = 'Setor Não Incluído!';
			}
			else
			{
					$this->db->trans_commit();
                $class = 'success';
                $mensagem = 'Setor Incluido com sucesso!!';
			}
            $this->feedBack($class,$mensagem,'setor');
		}
		public function editar($id)
		{
			
			$setor = $this->SetorModelo->editar($id);

			foreach ($setor as $index => $valor){
				$resultado['descricaoSetor'] =$valor['DESC_SETOR'];
                $resultado['siglaSetor'] =$valor['SIG_SETOR'];
				$resultado['indEstr'] =$valor['IND_ESTR'];
				$resultado['idSetor'] = $id;
				$resultado['categoria'] = $valor['SEQ_CATEGORIA_SETOR'];
			}
			$resultado['lista_categoria'] = $this->SetorModelo->listaCategoriaSetor();
			$this->loadUrl('modulos/setor/editar',$resultado);
		}

		//alterar o fornecedor
		public function alterar()
		{
			extract($this->input->post());

			$this->validaOperacao('setor/editar/'.$idSetor);

			$clienteSessao = $this->session->userData('idClienteSessao');

			//inserir setor
			$data = array(
				'SEQ_CLIENTE'=>$clienteSessao,
				'DESC_SETOR'=>$descricaoSetor,
				'SIG_SETOR'=>$siglaSetor,
				'IND_ESTR'=>$indEstr,
				'SEQ_CATEGORIA_SETOR'=>$categoria,
                                'IND_ATIVO' => $situacao
			);


			$this->inserirAuditoria('ALTERAR-SETOR','A',json_encode($data));
			$this->db->trans_begin();
			$this->SetorModelo->alterar($data, $idSetor);
			
			if ($this->db->trans_status() === FALSE)
			{
					$this->db->trans_rollback();
                $class = 'error';
                $mensagem = 'Setor Não Alterado!';
			}
			else
			{
					$this->db->trans_commit();
                $class = 'success';
                $mensagem = 'Setor Alterado com sucesso!!';
			}
            $this->feedBack($class,$mensagem,'setor');
		}
    public function excluir($id)
    {
		$this->validaOperacao('setor');
        $this->inserirAuditoria('EXCLUIR-SETOR','E','SetorId: '.$id);
        if($this->SetorModelo->deletar($id)){
            $class = 'success';
            $mensagem = 'Setor Excluído com sucesso!!';

        } else  {
            $class = 'error';
            $mensagem = 'Setor Não pode ser Excluído!';
        }
        $this->feedBack($class,$mensagem,'setor');
    }
}
<?php
class Tipomateria extends MY_Controller {

        public function __construct()
        {
                parent::__construct();
            $this->load->model('tipomateriaModelo', 'TipomateriaModelo');
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
			$this->inserirAuditoria('CONSULTAR-TIPO_MATERIA','C','Lista Todos');
  			$resultado['lista_tipomateria'] = $this->TipomateriaModelo->listaTipomateria33();
			$this->loadUrl('modulos/tipomateria/consultar',$resultado);
	
        }
		
		public function novo()
		{
			$this->loadUrl('modulos/tipomateria/novo');
		}

		//salvar nova ordem de servico
		public function salvar()
		{
			$this->validaOperacao('tipomateria/novo');
			extract($this->input->post());

			$clienteSessao = $this->session->userData('idClienteSessao');

			//inserir tipomateria
			$data = array(
				'SEQ_CLIENTE'=>$clienteSessao,
                'DESC_TIPO_MATERIA'=>$descricaoTipomateria,
                'SINT_TIPO_MATERIA'=>$sinteseTipomateria,
                'IND_ATIVO'=>'S'
						);
			$this->inserirAuditoria('INSERIR-TIPO_MATERIA','I', json_encode($data));
			$this->db->trans_begin();
			$idNew =  $this->TipomateriaModelo->inserir($data);

			if ($this->db->trans_status() === FALSE)
			{
					$this->db->trans_rollback();
                $class = 'error';
                $mensagem = 'Área da Matéria Não Incluído!';
			}
			else
			{
					$this->db->trans_commit();
                $class = 'success';
                $mensagem = 'Área da Matéria Incluido com sucesso!!';
			}
            $this->feedBack($class,$mensagem,'tipomateria');
		}
		public function editar($id)
		{
			
			$tipomateria = $this->TipomateriaModelo->editar($id);

			foreach ($tipomateria as $index => $valor){
				$resultado['descricaoTipomateria'] =$valor['DESC_TIPO_MATERIA'];
                $resultado['sinteseTipomateria'] =$valor['SINT_TIPO_MATERIA'];
				$resultado['idTipomateria'] = $id;
			}
			$this->loadUrl('modulos/tipomateria/editar',$resultado);
		}

		//alterar o fornecedor
		public function alterar()
		{
			extract($this->input->post());
			$clienteSessao = $this->session->userData('idClienteSessao');

			$this->validaOperacao('tipomateria/editar/'.$idTipomateria);

            $data = array(
				'SEQ_CLIENTE'=>$clienteSessao,
                'DESC_TIPO_MATERIA'=>$descricaoTipomateria,
                'SINT_TIPO_MATERIA'=>$sinteseTipomateria,
                'IND_ATIVO'=> $situacao
            );

			$this->inserirAuditoria('ALTERAR-TIPO_MATERIA','A',json_encode($data));
			$this->db->trans_begin();
			$this->TipomateriaModelo->alterar($data, $idTipomateria);
			
			if ($this->db->trans_status() === FALSE)
			{
					$this->db->trans_rollback();
                $class = 'error';
                $mensagem = 'Área da Matéria Não Alterado!';
			}
			else
			{
					$this->db->trans_commit();
                $class = 'success';
                $mensagem = 'Área da Matéria Alterado com sucesso!!';
			}
            $this->feedBack($class,$mensagem,'tipomateria');
		}
    public function excluir($id)
    {
		$this->validaOperacao('tipomateria');
        $this->inserirAuditoria('EXCLUIR-TIPO_MATERIA','E','TipomateriaId: '.$id);
        if($this->TipomateriaModelo->deletar($id)){
            $class = 'success';
            $mensagem = 'Área da Matéria Excluída com sucesso!!';

        } else  {
            $class = 'error';
            $mensagem = 'Área da Matéria Não pode ser Excluída!';
        }
        $this->feedBack($class,$mensagem,'tipomateria');
    }
}
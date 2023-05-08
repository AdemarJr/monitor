<?php
class Pesquisa extends MY_Controller {

        public function __construct()
        {
                parent::__construct();
            $this->load->model('tipomateriaModelo', 'TipomateriaModelo');
            $this->load->model('materiaModelo', 'MateriaModelo');
            $this->load->model('veiculoModelo', 'VeiculoModelo');
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

    public function index($texto='NA',$setor='NA',$tipo='NA',$sort = 'SEQ_MATERIA', $order = 'DESC',$per_page=10,$page=1)
        {
            $this->validaOperacao('inicio');
			$this->inserirAuditoria('CONSULTAR-MATERIA','C','Lista Todos');

            extract($this->input->post());


            $arrayResult = $this->MateriaModelo->listaMateriaPesquisa(urldecode($texto),$setor,$tipo);
            $config = array(
                "base_url" => base_url('pesquisa/consultar/'.$texto.'/'.$setor.'/'.$tipo.'/'.$sort.'/'.$order.'/'.$per_page),
                "per_page" => $per_page,
                "num_links" => 3,
                "uri_segment" => 9,
                "total_rows" => count($arrayResult),
                "full_tag_open" => "<ul class='pagination'>",
                "full_tag_close" => "</ul>",
                "first_link" => "Primeira",
                "last_link" => "Última",
                "first_tag_open" => "<li>",
                "first_tag_close" => "</li>",
                "prev_link" => "Anterior",
                "prev_tag_open" => "<li class='prev'>",
                "prev_tag_close" => "</li>",
                "next_link" => "Próxima",
                "next_tag_open" => "<li class='next'>",
                "next_tag_close" => "</li>",
                "last_tag_open" => "<li>",
                "last_tag_close" => "</li>",
                "cur_tag_open" => "<li class='active'><a href='#'>",
                "cur_tag_close" => "</a></li>",
                "num_tag_open" => "<li >",
                "num_tag_close" => "</li>"
            );
            $this->pagination->initialize($config);

            $resultado['pagination'] = $this->pagination->create_links();
            $resultado['per_page'] = $per_page;
            $resultado['sort'] = $sort;
            $resultado['order'] = $order;

            $offset = ($this->uri->segment(9)) ? $this->uri->segment(9) : 0;

            $resultado['lista_materia'] = $this->MateriaModelo->listaMateriaPesquisa(urldecode($texto),$setor,$tipo,$sort,$order,$per_page,$offset);

            $resultado['texto'] = $texto=='NA'?'':$texto;
//            $resultado['veiculo'] = $veiculo=='NA'?'':$veiculo;
            $resultado['setor'] = $setor=='NA'?'':$setor;
            $resultado['tipo'] = $tipo=='NA'?'':$tipo;
            $resultado['totalLinhas'] = count($arrayResult);

            $resultado['lista_tipo'] = $this->TipomateriaModelo->listaTipomateria();
            $resultado['lista_veiculo'] = $this->VeiculoModelo->listaVeiculo();
            $resultado['lista_setor'] = $this->SetorModelo->listaSetor();


			$this->loadUrl('modulos/pesquisa/consultar',$resultado);
	
        }
        public function consultar($texto=NULL,$setor='NA',$tipo='NA',$sort = 'SEQ_MATERIA', $order = 'DESC',$per_page=10,$page=1)
        {

            $this->index($texto,$setor,$tipo,$sort,$order,$per_page,$page);
        }



}
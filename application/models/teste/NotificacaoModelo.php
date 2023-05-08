<?php
class NotificacaoModelo extends MY_Model {

	public function __construct()
        {
			$this->load->database('monitor');
        }

    public function listaNotificacao($dataFiltro) {
        $periodo = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataFiltro);

        if ($this->session->userData('perfilUsuario')!='ROLE_ADM') {
            $this->monitor->where('NOTA.SEQ_CLIENTE in ('. $this->session->userdata('listaCliente').')');
        }
        $this->monitor->where(trim($periodo). " BETWEEN NOTA.DT_INICIO  and NOTA.DT_FIM");
        $this->monitor->where("IND_ATIVO","S");
        
        $query = $this->monitor->get('NOTA');

        return $query->result_array();
    }
    
    public function listaNotificacaoPeriodo($dataInicio, $dataFim) {
        $dataInicio1 = implode('-', array_reverse(explode('/', $dataInicio)));
        $dataFim1 = implode('-', array_reverse(explode('/', $dataFim)));
        if ($this->session->userData('perfilUsuario')!='ROLE_ADM') {
            $this->monitor->where('NOTA.SEQ_CLIENTE in ('. $this->session->userdata('listaCliente').')');
        }
        $this->monitor->where("NOTA.DT_INICIO BETWEEN '".$dataInicio1."' AND '".$dataFim1."' ");
        $this->monitor->where("IND_ATIVO","S");
        $this->monitor->order_by('NOTA.DT_INICIO', 'ASC');
        $query = $this->monitor->get('NOTA');

        return $query->result_array();
    }
    
    public function listaNotificacaoAgg($dataFiltro) {
        $periodo = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataFiltro);
        $where = " ";
        if ($this->session->userData('perfilUsuario')!='ROLE_ADM') {
            $where = ' A.SEQ_CLIENTE in ('. $this->session->userdata('listaCliente').') AND ';
        }
        $slq = " SELECT CONSULTA,SEQ_CLIENTE,EMPRESA_CLIENTE,DT_INICIO,DT_FIM,'A' AS TIPO_MATERIA,TIPO_NOTIFICACAO ,LISTA_SETOR, "
            ." GROUP_CONCAT(  "
            ." CONCAT ( "
            ." CASE  "
            ." 		when TIPO_MATERIA='I' then '@@*IMPRESSO*' "
            ." 		when TIPO_MATERIA='S' and GRUPO_PORTAL IS NULL  then '@@*INTERNET*' "
            ." 		when TIPO_MATERIA='R' then '@@*RADIO*' "
            ." 		when TIPO_MATERIA='T' then '@@*TV*' "
            ." 		when TIPO_MATERIA='S' and GRUPO_PORTAL > 0 then CONCAT('@*',(SELECT UPPER(DESC_GRUPO_VEICULO) FROM GRUPO_VEICULO GR WHERE GR.SEQ_GRUPO_VEICULO=GRUPO_PORTAL ),'*') "
            ." 		else '@@*Todas as Publicacoes*' END, LINK) "
            ." 		ORDER BY TIPO_MATERIA separator  '') AS LINK "
            ." FROM ( "
            ." SELECT '1' as CONSULTA,A.SEQ_CLIENTE,B.EMPRESA_CLIENTE,A.DT_INICIO,A.DT_FIM,A.TIPO_MATERIA,A.GRUPO_PORTAL,A.TIPO_NOTIFICACAO, IFNULL(A.LISTA_SETOR,0) LISTA_SETOR, "
            ."  GROUP_CONCAT(  "
            ."  CONCAT('@', "
            ."  CONCAT((SELECT XI.DESC_CATEGORIA FROM CATEGORIA_SETOR XI WHERE XI.SEQ_CATEGORIA=A.SEQ_CATEGORIA_SETOR),'@Link: https://porto.am/i?' "
            ."  ) "
            ." ,A.CHAVE_NOTIFICACAO) ORDER BY 1 SEPARATOR '') AS LINK FROM NOTA A "
            ." INNER JOIN CLIENTE B ON A.SEQ_CLIENTE=B.SEQ_CLIENTE WHERE ".$where." A.SEQ_CATEGORIA_SETOR>0 and A.TIPO_NOTA='N' and ".trim($periodo). " BETWEEN A.DT_INICIO  and A.DT_FIM "
            ." GROUP BY '1',A.SEQ_CLIENTE,B.EMPRESA_CLIENTE,A.DT_INICIO,A.DT_FIM,A.TIPO_MATERIA,A.GRUPO_PORTAL,A.TIPO_NOTIFICACAO, A.LISTA_SETOR) RS "
            ." GROUP BY '1',SEQ_CLIENTE,EMPRESA_CLIENTE,DT_INICIO,DT_FIM,GRUPO_PORTAL,TIPO_NOTIFICACAO, LISTA_SETOR "
            ." UNION ALL"
            ." SELECT '2' as CONSULTA,A.SEQ_CLIENTE,B.EMPRESA_CLIENTE,A.DT_INICIO,A.DT_FIM,'A' AS TIPO_MATERIA,A.TIPO_NOTIFICACAO,IFNULL(A.LISTA_SETOR,0) LISTA_SETOR,  "
            ." GROUP_CONCAT( CONCAT('@',CONCAT(( "
            ." 	CASE  "
            ." 		when A.TIPO_MATERIA='I' then '@*IMPRESSO*' "
            ." 		when A.TIPO_MATERIA='S' AND A.GRUPO_PORTAL IS NULL then '@*INTERNET*' "
            ." 		when TIPO_MATERIA='S' and GRUPO_PORTAL > 0 then CONCAT('@*',(SELECT UPPER(DESC_GRUPO_VEICULO) FROM GRUPO_VEICULO GR WHERE GR.SEQ_GRUPO_VEICULO=GRUPO_PORTAL ),'*') "
            ." 		when A.TIPO_MATERIA='R' then '@*RADIO*' "
            ." 		when A.TIPO_MATERIA='T' then '@*TV*' "
            ." 		else '@*Todas as Publicacoes*' END "
            ." 	),'@Link: https://porto.am/i?') ,A.CHAVE_NOTIFICACAO)  "
            ." 	ORDER BY A.SEQ_NOTIFICACAO SEPARATOR '') AS LINK  "
            ." FROM NOTA A  "
            ." INNER JOIN CLIENTE B ON A.SEQ_CLIENTE=B.SEQ_CLIENTE  "
            ." WHERE ".$where." A.SEQ_CATEGORIA_SETOR=0 AND A.TIPO_NOTA='N' and IFNULL(A.LISTA_SETOR,'0') <> '83'"
            ." and ".trim($periodo). " BETWEEN A.DT_INICIO and A.DT_FIM "
            ." GROUP BY '2',A.SEQ_CLIENTE,B.EMPRESA_CLIENTE,A.DT_INICIO,A.DT_FIM,'A',A.TIPO_NOTIFICACAO,A.LISTA_SETOR "
            ." UNION ALL"
            ." SELECT CONSULTA,SEQ_CLIENTE,EMPRESA_CLIENTE,DT_INICIO,DT_FIM,'A' AS TIPO_MATERIA,TIPO_NOTIFICACAO ,LISTA_SETOR, "
            ." GROUP_CONCAT( CONCAT ( CASE when TIPO_MATERIA='I' then '@@*IMPRESSO*' "
            ." when TIPO_MATERIA='S' and GRUPO_PORTAL IS NULL then '@@*INTERNET*' "
            ." when TIPO_MATERIA='R' then '@@*RADIO*' when TIPO_MATERIA='T' then '@@*TV*' "
            ." when TIPO_MATERIA='S' and GRUPO_PORTAL > 0 then CONCAT('@*', "
            ." (SELECT UPPER(DESC_GRUPO_VEICULO) "
            ." FROM GRUPO_VEICULO GR "
            ." WHERE GR.SEQ_GRUPO_VEICULO=GRUPO_PORTAL ),'*') "
            ." else '@@*Todas as Publicacoes*' END, LINK) ORDER BY TIPO_MATERIA separator '') AS LINK "
            ." FROM "
            ." ( SELECT '3' as CONSULTA,0 AS SEQ_CLIENTE,'TEMAS DE INTERESSE' EMPRESA_CLIENTE,A.DT_INICIO,A.DT_FIM,A.TIPO_MATERIA , "
            ." A.GRUPO_PORTAL,A.TIPO_NOTIFICACAO,IFNULL(A.LISTA_SETOR,0) LISTA_SETOR, GROUP_CONCAT( CONCAT('@@', CONCAT((SELECT XI.DESC_ASSUNTO_GERAL "
            ." FROM ASSUNTO_GERAL XI WHERE XI.SEQ_ASSUNTO_GERAL=A.SEQ_ASSUNTO_GERAL),'@Link: https://porto.am/i?' ) ,A.CHAVE_NOTIFICACAO) "
            ." ORDER BY 1 SEPARATOR '') AS LINK FROM NOTA A "
            ." WHERE A.TIPO_NOTA='S' and 20190121 BETWEEN A.DT_INICIO and A.DT_FIM "
            ." GROUP BY '3',A.DT_INICIO,A.DT_FIM,A.TIPO_MATERIA,A.GRUPO_PORTAL,A.TIPO_NOTIFICACAO,A.LISTA_SETOR) RS "
            ." GROUP BY '3',EMPRESA_CLIENTE,DT_INICIO,DT_FIM,GRUPO_PORTAL,TIPO_NOTIFICACAO,LISTA_SETOR ";



//        echo $slq;
//        die;
        $query = $this->monitor->query($slq);

        return $query->result_array();
    }

    public function getNotificacaoUsuario($idUser) {

        $this->monitor->from('NOTIFICACAO');
        $this->monitor->where('NOTIFICACAO.SEQ_USUARIO',$idUser);
        $this->monitor->where('NOTIFICACAO.LID_NOTIFICACAO',0);
//        $this->monitor->where('DATEDIFF(SYSDATE(),NOTIFICACAO.DTE_NOTIFICACAO)<= ',2);
        $this->monitor->where('NOTIFICACAO.FLAG_NOTIFICACAO<=10');
        $this->monitor->order_by('NOTIFICACAO.SEQ_NOTIFICACAO','DESC');
        $query = $this->monitor->get();

        return $query->result_array();
    }

    public function getNotificacaoUsuarioPor30($idUser) {

        $this->monitor->from('NOTIFICACAO');
        $this->monitor->where('NOTIFICACAO.SEQ_USUARIO',$idUser);
        $this->monitor->where('NOTIFICACAO.LID_NOTIFICACAO',0);
        $this->monitor->order_by('NOTIFICACAO.SEQ_NOTIFICACAO','DESC');
        $query = $this->monitor->get();

        return $query->result_array();
    }

    public function inserir($data=NULL)
	{
		return $this->monitor->insert('NOTIFICACAO', $data);

	}
    public function inserirNota($data=NULL)
    {
        $this->monitor->insert('NOTA', $data);

        return $this->monitor->insert_id();

    }

	public function alterar($data,$id) {
		$this->monitor->where('SEQ_NOTIFICACAO', $id);
		return $this->monitor->update('NOTIFICACAO',$data);
	}
    public function alterarNota($data,$id) {
        $this->monitor->where('SEQ_NOTIFICACAO', $id);
        return $this->monitor->update('NOTA',$data);
    }
    public function editarNota($id) {
        $this->monitor->where('SEQ_NOTIFICACAO', $id);
        $query = $this->monitor->get('NOTA');
        return $query->result_array();
    }

	public function listaUsuarioEnviarNotificacao() {

		$this->monitor->select('PERMISSAO.SEQ_USUARIO, USUARIO.EMAIL_USUARIO');
		$this->monitor->from('PERMISSAO');
		$this->monitor->join('METODO', 'PERMISSAO.SEQ_METODO = METODO.SEQ_METODO');
		$this->monitor->join('USUARIO', 'PERMISSAO.SEQ_USUARIO = USUARIO.SEQ_USUARIO');
		$this->monitor->where('METODO.MOD_METODO','contrato');
		$this->monitor->where('METODO.CLA_METODO','agendador');
		$this->monitor->where('METODO.NOM_METODO','processa');
		$query = $this->monitor->get();

		return $query->result();
	}
    public function deletar($id) {
        $this->monitor->where('SEQ_NOTIFICACAO', $id);
        return $this->monitor->delete('NOTA');
    }
}
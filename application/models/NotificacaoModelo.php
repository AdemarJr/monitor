<?php
class NotificacaoModelo extends CI_Model {

	public function __construct()
        {
			$this->load->database();
        }

    public function listaNotificacao($dataFiltro) {

        $periodo = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $dataFiltro);
        $periodoStr = "'".$periodo."'";
        if ($this->session->userData('perfilUsuario')!='ROLE_ADM') {
            $this->db->where('NOTA.SEQ_CLIENTE in ('. $this->session->userdata('listaCliente').')');
        }
        $this->db->where(trim($periodoStr). " BETWEEN DATE(DT_INICIO)  and DATE(DT_FIM)");
        $this->db->where("IND_ATIVO","S");
        
        $query = $this->db->get('NOTA');

        return $query->result_array();
    }
    
    public function listaNotificacaoPeriodo($dataInicio, $dataFim) {
        $dataInicio1 = implode('-', array_reverse(explode('/', $dataInicio)));
        $dataFim1 = implode('-', array_reverse(explode('/', $dataFim)));
        if ($this->session->userData('perfilUsuario')!='ROLE_ADM') {
            $this->db->where('NOTA.SEQ_CLIENTE in ('. $this->session->userdata('listaCliente').')');
        }
        $this->db->where("NOTA.DT_INICIO BETWEEN '".$dataInicio1."' AND '".$dataFim1."' ");
        $this->db->where("IND_ATIVO","S");
        $this->db->order_by('NOTA.DT_INICIO', 'ASC');
        $query = $this->db->get('NOTA');

        return $query->result_array();
    }
    
    public function listaNotificacaoAgg($dataFiltro) {
        $periodo = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $dataFiltro);
        $periodoStr = "'".$periodo."'";
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
            ." INNER JOIN CLIENTE B ON A.SEQ_CLIENTE=B.SEQ_CLIENTE WHERE ".$where." A.SEQ_CATEGORIA_SETOR>0 and A.TIPO_NOTA='N' and ".trim($periodoStr). " BETWEEN DATE(A.DT_INICIO)  and DATE(A.DT_FIM) "
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
            ." and ".trim($periodoStr). " BETWEEN DATE(A.DT_INICIO) AND DATE(A.DT_FIM) "
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
        $query = $this->db->query($slq);

        return $query->result_array();
    }

    public function getNotificacaoUsuario($idUser) {

        $this->db->from('NOTIFICACAO');
        $this->db->where('NOTIFICACAO.SEQ_USUARIO',$idUser);
        $this->db->where('NOTIFICACAO.LID_NOTIFICACAO',0);
//        $this->db->where('DATEDIFF(SYSDATE(),NOTIFICACAO.DTE_NOTIFICACAO)<= ',2);
        $this->db->where('NOTIFICACAO.FLAG_NOTIFICACAO<=10');
        $this->db->order_by('NOTIFICACAO.SEQ_NOTIFICACAO','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getNotificacaoUsuarioPor30($idUser) {

        $this->db->from('NOTIFICACAO');
        $this->db->where('NOTIFICACAO.SEQ_USUARIO',$idUser);
        $this->db->where('NOTIFICACAO.LID_NOTIFICACAO',0);
        $this->db->order_by('NOTIFICACAO.SEQ_NOTIFICACAO','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function inserir($data=NULL)
	{
		return $this->db->insert('NOTIFICACAO', $data);

	}
    public function inserirNota($data=NULL)
    {
        $this->db->insert('NOTA', $data);

        return $this->db->insert_id();

    }

	public function alterar($data,$id) {
		$this->db->where('SEQ_NOTIFICACAO', $id);
		return $this->db->update('NOTIFICACAO',$data);
	}
    public function alterarNota($data,$id) {
        $this->db->where('SEQ_NOTIFICACAO', $id);
        return $this->db->update('NOTA',$data);
    }
    public function editarNota($id) {
        $this->db->where('SEQ_NOTIFICACAO', $id);
        $query = $this->db->get('NOTA');
        return $query->result_array();
    }

	public function listaUsuarioEnviarNotificacao() {

		$this->db->select('PERMISSAO.SEQ_USUARIO, USUARIO.EMAIL_USUARIO');
		$this->db->from('PERMISSAO');
		$this->db->join('METODO', 'PERMISSAO.SEQ_METODO = METODO.SEQ_METODO');
		$this->db->join('USUARIO', 'PERMISSAO.SEQ_USUARIO = USUARIO.SEQ_USUARIO');
		$this->db->where('METODO.MOD_METODO','contrato');
		$this->db->where('METODO.CLA_METODO','agendador');
		$this->db->where('METODO.NOM_METODO','processa');
		$query = $this->db->get();

		return $query->result();
	}
    public function deletar($id) {
        $this->db->where('SEQ_NOTIFICACAO', $id);
        return $this->db->delete('NOTA');
    }
}
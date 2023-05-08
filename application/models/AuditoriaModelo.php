<?php
class AuditoriaModelo extends CI_Model {
	
	public function __construct()
        {
                $this->load->database();
        }

	
        # inserir log
    public function inserir($data_log=NULL)
	{
		return $this->db->insert('AUDITORIA', $data_log);
		
    }
    public function inserirKlipbox($data_log=NULL)
	{
		return $this->db->insert('AUDITORIA_KLIPBOX', $data_log);
		
	}
    public function editar($id) {
        $this->db->where('SEQ_AUDITORIA', $id);
        $query = $this->db->get('AUDITORIA');
        return $query->result_array();
    }
    /**
     * lista as opercaos
     */
    public function lista($periodo=NULL,$usuario=NULL) {
        $limite = true;
        if (!empty($periodo)){
                list($periodoIni, $periodoFim) = explode("-",  $periodo);
                $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $periodoIni);
                $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $periodoFim);

//                $this->db->where("TO_CHAR(DATA_AUDITORIA,'YYYYMMDD') BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
            $this->db->where("DATA_AUDITORIA BETWEEN ".trim($periodoIni)." and ".trim($periodoFim+1));
            $limite=false;
        }
        if (!empty($usuario)){
            $this->db->where('SEQ_USUARIO',$usuario);
            $limite=false;
        }
//        $this
        $this->db->order_by('DATA_AUDITORIA', 'DESC');
        $this->db->select(" SEQ_AUDITORIA,SEQ_USUARIO,DATE_FORMAT(DATA_AUDITORIA, '%d/%m/%Y %H:%i') AS DATA_AUDITORIA,OPER_AUDITORIA");
        if($limite){
            $this->db->limit(100);
        }
        $query = $this->db->get('AUDITORIA');
        return $query->result_array();
    }

    public function deletar($id=NULL) {
        $this->db->where('SEQ_AUDITORIA', $id);
        return $this->db->delete('AUDITORIA');
    }


}
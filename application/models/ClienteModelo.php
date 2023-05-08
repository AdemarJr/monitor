<?php
class ClienteModelo extends CI_Model {

	public function __construct()
        {
			$this->load->database();
        }
	
	public function listaCliente() {	
		$this->db->order_by('SEQ_CLIENTE', 'ASC');

		if($this->session->userdata('perfilUsuario')!='ROLE_ADM')
			$this->db->where('IND_ATIVO', 'S');

        $query = $this->db->get('CLIENTE');
		return $query->result_array();
    }
        # inserir empresa
    public function inserir($data_os=NULL)
	{
		$this->db->insert('CLIENTE', $data_os);
		
		return $this->db->insert_id();
	}
	
	//editar um empresa
	public function editar($id) {
		$this->db->where('SEQ_CLIENTE', $id);
		$query = $this->db->get('CLIENTE'); 
		return $query->result_array();
	}

	public function deletar($id) {
		$this->db->where('SEQ_CLIENTE', $id);
    	return $this->db->delete('CLIENTE');
    }

	
	public function alterar($tb_empresa_servico,$idCliente) {
		$this->db->where('SEQ_CLIENTE', $idCliente);
		return $this->db->update('CLIENTE',$tb_empresa_servico);
	}
	public function getCliente($id) {
		$this->db->where('SEQ_CLIENTE', $id);
		return $this->db->get('CLIENTE');
	}

	public function replicarVeiculos($idOrigem,$idDestino) {

		//PORTAL
//		if ($tipo=='S') {
			$sql1 = "INSERT INTO PORTAL(`SEQ_CLIENTE`, `NOME_PORTAL`, `CIDADE_PORTAL`, `SITE_PORTAL`, `LOGO_VEICULO`, `GRUPO_PORTAL`, `FUNCAO_PORTAL`, `IND_ATIVO`) ".
				   " SELECT ?, `NOME_PORTAL`, `CIDADE_PORTAL`, `SITE_PORTAL`, `LOGO_VEICULO`, `GRUPO_PORTAL`, `FUNCAO_PORTAL`, `IND_ATIVO` FROM `PORTAL` WHERE ".
				   " `SEQ_CLIENTE` = ?";

//		}
		//RADIO
//		if ($tipo=='R') {
			$sql2 = "INSERT INTO RADIO (`SEQ_CLIENTE`, `NOME_RADIO`, `CIDADE_RADIO`, `SITE_RADIO`, `LOGO_VEICULO`) ".
				   "SELECT ?, `NOME_RADIO`, `CIDADE_RADIO`, `SITE_RADIO`, `LOGO_VEICULO` FROM `RADIO` WHERE `SEQ_CLIENTE`=? ";

//		}
		//TELEVISAO
//		if ($tipo=='T') {
			$sql3 = "INSERT INTO TELEVISAO (`SEQ_CLIENTE`, `NOME_TV`, `CIDADE_TV`, `SITE_TV`, `LOGO_VEICULO`) " .
				   " SELECT ?, `NOME_TV`, `CIDADE_TV`, `SITE_TV`, `LOGO_VEICULO` FROM `TELEVISAO` WHERE `SEQ_CLIENTE`=?";

//		}
		//IMPRESO
//		if ($tipo=='I') {
			$sql4 = "INSERT INTO VEICULO(`NOME_VEICULO`, `FANTASIA_VEICULO`, `LOGRADOURO_VEICULO`, `BAIRRO_VEICULO`, `NUMERO_VEICULO`, `COMPLEMENTO_VEICULO`, `CEP_VEICULO`, `CIDADE_VEICULO`, `EMAIL_VEICULO`, `SITE_VEICULO`, `CNPJ_VEICULO`, `FONE_VEICULO`, `LOGO_VEICULO`, `IND_ATIVO`, `PAIS_VEICULO`, `UF_VEICULO`, `LAT_VEICULO`, `LONG_VEICULO`, `SEQ_CLIENTE`) ".
				   " SELECT `NOME_VEICULO`, `FANTASIA_VEICULO`, `LOGRADOURO_VEICULO`, `BAIRRO_VEICULO`, `NUMERO_VEICULO`, `COMPLEMENTO_VEICULO`, `CEP_VEICULO`, `CIDADE_VEICULO`, `EMAIL_VEICULO`, `SITE_VEICULO`, `CNPJ_VEICULO`, `FONE_VEICULO`, `LOGO_VEICULO`, `IND_ATIVO`, `PAIS_VEICULO`, `UF_VEICULO`, `LAT_VEICULO`, `LONG_VEICULO`, ? FROM `VEICULO` WHERE `SEQ_CLIENTE` = ?";
//			}
		return $this->db->query($sql1,array($idDestino,$idOrigem)) and $this->db->query($sql2,array($idDestino,$idOrigem)) and $this->db->query($sql3,array($idDestino,$idOrigem))
			and $this->db->query($sql4,array($idDestino,$idOrigem));;
	}
}
<?php
class VeiculoModelo extends CI_Model {

	public function __construct()
        {
			$this->load->database();
        }
	
	public function listaVeiculo() {
			$this->db->order_by('NOME_VEICULO', 'ASC');
			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
			$query = $this->db->get('VEICULO');
		return $query->result_array();
    }
	public function listaPortal() {

			$this->db->order_by('NOME_PORTAL', 'ASC');
			$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
			$query = $this->db->get('PORTAL');
		return $query->result_array();
	}
	public function listaPortalAtivo() {

		$this->db->order_by('NOME_PORTAL', 'ASC');
		$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		$this->db->where('IND_ATIVO','S');
		$query = $this->db->get('PORTAL');
		return $query->result_array();
	}
	public function listaPortalAtivoCli($id) {

		$this->db->order_by('NOME_PORTAL', 'ASC');
		$this->db->where('SEQ_CLIENTE',$id);
		$this->db->where('IND_ATIVO','S');
		$query = $this->db->get('PORTAL');
		return $query->result_array();
	}
	public function listaRadio() {

		$this->db->order_by('NOME_RADIO', 'ASC');
		$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		$query = $this->db->get('RADIO');
		return $query->result_array();
	}
	public function listaRadioAlerta($idCliente) {

		$this->db->order_by('NOME_RADIO', 'ASC');
		$this->db->where('SEQ_CLIENTE',$idCliente);
		$query = $this->db->get('RADIO');
		return $query->result_array();
	}
	public function listaTv() {

		$this->db->order_by('NOME_TV', 'ASC');
		$this->db->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		$query = $this->db->get('TELEVISAO');
		return $query->result_array();
	}
	public function listaTvAlerta($idCliente) {

		$this->db->order_by('NOME_TV', 'ASC');
		$this->db->where('SEQ_CLIENTE', $idCliente);
		$query = $this->db->get('TELEVISAO');
		return $query->result_array();
	}
        # inserir empresa
    public function inserir($data_os=NULL)
	{
		$this->db->insert('VEICULO', $data_os);

		return $this->db->insert_id();
	}
	public function inserirPortal($data_os=NULL)
	{
		$this->db->insert('PORTAL', $data_os);

		return $this->db->insert_id();
	}
	public function inserirRadio($data_os=NULL)
	{
		$this->db->insert('RADIO', $data_os);

		return $this->db->insert_id();
	}
	public function inserirTv($data_os=NULL)
	{
		$this->db->insert('TELEVISAO', $data_os);

		return $this->db->insert_id();
	}
	
	//editar um empresa
	public function editar($id) {
		$this->db->where('SEQ_VEICULO', $id);
		$query = $this->db->get('VEICULO'); 
		return $query->result_array();
	}
	public function editarPortal($id) {
		$this->db->where('SEQ_PORTAL', $id);
		$query = $this->db->get('PORTAL');
		return $query->result_array();
	}
	public function editarRadio($id) {
		$this->db->where('SEQ_RADIO', $id);
		$query = $this->db->get('RADIO');
		return $query->result_array();
	}
	public function editarTv($id) {
		$this->db->where('SEQ_TV', $id);
		$query = $this->db->get('TELEVISAO');
		return $query->result_array();
	}

	public function deletar($id) {
		$this->db->where('SEQ_VEICULO', $id);
    	return $this->db->delete('VEICULO');
    }
	public function deletarPortal($id) {
		$this->db->where('SEQ_PORTAL', $id);
		return $this->db->delete('PORTAL');
	}
	public function deletarRadio($id) {
		$this->db->where('SEQ_RADIO', $id);
		return $this->db->delete('RADIO');
	}
	public function deletarTv($id) {
		$this->db->where('SEQ_TV', $id);
		return $this->db->delete('TELEVISAO');
	}

	
	public function alterar($tb,$idVeiculo) {
		$this->db->where('SEQ_VEICULO', $idVeiculo);
		return $this->db->update('VEICULO',$tb);
	}

	public function alterarPortal($tb, $idVeiculo)
	{
		$this->db->where('SEQ_PORTAL', $idVeiculo);
		return $this->db->update('PORTAL', $tb);
	}
	public function alterarRadio($tb, $idVeiculo)
	{
		$this->db->where('SEQ_RADIO', $idVeiculo);
		return $this->db->update('RADIO', $tb);
	}
	public function alterarTv($tb, $idVeiculo)
	{
		$this->db->where('SEQ_TV', $idVeiculo);
		return $this->db->update('TELEVISAO', $tb);
	}
	public function getVeiculo($id) {
		$this->db->where('SEQ_VEICULO', $id);
		return $this->db->get('VEICULO');
	}

	public function getPortal($id)
	{
		$this->db->where('SEQ_PORTAL', $id);
		return $this->db->get('PORTAL');
	}
	public function getRadio($id)
	{
		$this->db->where('SEQ_RADIO', $id);
		return $this->db->get('RADIO');
	}
	public function getTv($id)
	{
		$this->db->where('SEQ_TV', $id);
		return $this->db->get('TELEVISAO');
	}

	public function listaGrupoVeiculo() {

		$this->db->order_by('DESC_GRUPO_VEICULO', 'ASC');
		$query = $this->db->get('GRUPO_VEICULO');
		return $query->result_array();
	}
	public function countLinkSite($id=NULL,$domains){

		if (!empty($id))
			$this->db->where('PORTAL.SEQ_PORTAL<>'.$id);
		$this->db->where('PORTAL.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));

		foreach ($domains as $item) {
			$this->db->like("PORTAL.SITE_PORTAL", trim($item));
		}
		$this->db->from('PORTAL');
//        echo $this->db->get_compiled_select();
//        die;
		return $this->db->count_all_results();
	}

	public function carregaPreco($id,$tipoMat) {

		$this->db->order_by('DESCRITIVO', 'ASC');
		$this->db->where('IND_ATIVO',  'S');
		$this->db->where('SEQ_CHAVE',  $id);
		$this->db->where('TIPO_MATERIA',  $tipoMat);
		$this->db->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
		$query = $this->db->get('PRECO');
		return $query->result_array();
	}

	public function inserirPreco($data_os=NULL)
	{
		$this->db->insert('PRECO', $data_os);

		return $this->db->insert_id();
	}

	public function deletarPreco($id) {
		$this->db->where('SEQ_PRECO', $id);
		return $this->db->delete('PRECO');
	}
	public function getPreco($id) {
		$this->db->where('SEQ_PRECO', $id);
		return $this->db->get('PRECO');
	}

	public function alterarPreco($tb,$id) {
		$this->db->where('SEQ_PRECO', $id);
		return $this->db->update('PRECO',$tb);
	}
	public function listaInternetAlerta($idCliente) {

		$this->db->order_by('NOME_PORTAL', 'ASC');
		$this->db->where('SEQ_CLIENTE',$idCliente);
		$query = $this->db->get('PORTAL');
		return $query->result_array();
	}
	public function listaImpressoAlerta($idCliente) {

		$this->db->order_by('NOME_VEICULO', 'ASC');
		$this->db->where('SEQ_CLIENTE',$idCliente);
		$query = $this->db->get('VEICULO');
		return $query->result_array();
	}
}
<?php
class VeiculoModelo extends MY_Model {

	public function __construct()
        {
			//$this->load->database('monitor');
        }
	
	public function listaVeiculo() {
			$this->monitor->order_by('NOME_VEICULO', 'ASC');
			$this->monitor->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
			$query = $this->monitor->get('VEICULO');
		return $query->result_array();
    }
	public function listaPortal() {

			$this->monitor->order_by('NOME_PORTAL', 'ASC');
			$this->monitor->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
			$query = $this->monitor->get('PORTAL');
		return $query->result_array();
	}
	public function listaPortalAtivo() {

		$this->monitor->order_by('NOME_PORTAL', 'ASC');
		$this->monitor->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		$this->monitor->where('IND_ATIVO','S');
		$query = $this->monitor->get('PORTAL');
		return $query->result_array();
	}
	public function listaPortalAtivoCli($id) {

		$this->monitor->order_by('NOME_PORTAL', 'ASC');
		$this->monitor->where('SEQ_CLIENTE',$id);
		$this->monitor->where('IND_ATIVO','S');
		$query = $this->monitor->get('PORTAL');
		return $query->result_array();
	}
	public function listaRadio() {

		$this->monitor->order_by('NOME_RADIO', 'ASC');
		$this->monitor->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		$query = $this->monitor->get('RADIO');
		return $query->result_array();
	}
	public function listaRadioAlerta($idCliente) {

		$this->monitor->order_by('NOME_RADIO', 'ASC');
		$this->monitor->where('SEQ_CLIENTE',$idCliente);
		$query = $this->monitor->get('RADIO');
		return $query->result_array();
	}
	public function listaTv() {

		$this->monitor->order_by('NOME_TV', 'ASC');
		$this->monitor->where('SEQ_CLIENTE',$this->session->userData('idClienteSessao'));
		$query = $this->monitor->get('TELEVISAO');
		return $query->result_array();
	}
	public function listaTvAlerta($idCliente) {

		$this->monitor->order_by('NOME_TV', 'ASC');
		$this->monitor->where('SEQ_CLIENTE', $idCliente);
		$query = $this->monitor->get('TELEVISAO');
		return $query->result_array();
	}
        # inserir empresa
    public function inserir($data_os=NULL)
	{
		$this->monitor->insert('VEICULO', $data_os);

		return $this->monitor->insert_id();
	}
	public function inserirPortal($data_os=NULL)
	{
		$this->monitor->insert('PORTAL', $data_os);

		return $this->monitor->insert_id();
	}
	public function inserirRadio($data_os=NULL)
	{
		$this->monitor->insert('RADIO', $data_os);

		return $this->monitor->insert_id();
	}
	public function inserirTv($data_os=NULL)
	{
		$this->monitor->insert('TELEVISAO', $data_os);

		return $this->monitor->insert_id();
	}
	
	//editar um empresa
	public function editar($id) {
		$this->monitor->where('SEQ_VEICULO', $id);
		$query = $this->monitor->get('VEICULO'); 
		return $query->result_array();
	}
	public function editarPortal($id) {
		$this->monitor->where('SEQ_PORTAL', $id);
		$query = $this->monitor->get('PORTAL');
		return $query->result_array();
	}
	public function editarRadio($id) {
		$this->monitor->where('SEQ_RADIO', $id);
		$query = $this->monitor->get('RADIO');
		return $query->result_array();
	}
	public function editarTv($id) {
		$this->monitor->where('SEQ_TV', $id);
		$query = $this->monitor->get('TELEVISAO');
		return $query->result_array();
	}

	public function deletar($id) {
		$this->monitor->where('SEQ_VEICULO', $id);
    	return $this->monitor->delete('VEICULO');
    }
	public function deletarPortal($id) {
		$this->monitor->where('SEQ_PORTAL', $id);
		return $this->monitor->delete('PORTAL');
	}
	public function deletarRadio($id) {
		$this->monitor->where('SEQ_RADIO', $id);
		return $this->monitor->delete('RADIO');
	}
	public function deletarTv($id) {
		$this->monitor->where('SEQ_TV', $id);
		return $this->monitor->delete('TELEVISAO');
	}

	
	public function alterar($tb,$idVeiculo) {
		$this->monitor->where('SEQ_VEICULO', $idVeiculo);
		return $this->monitor->update('VEICULO',$tb);
	}

	public function alterarPortal($tb, $idVeiculo)
	{
		$this->monitor->where('SEQ_PORTAL', $idVeiculo);
		return $this->monitor->update('PORTAL', $tb);
	}
	public function alterarRadio($tb, $idVeiculo)
	{
		$this->monitor->where('SEQ_RADIO', $idVeiculo);
		return $this->monitor->update('RADIO', $tb);
	}
	public function alterarTv($tb, $idVeiculo)
	{
		$this->monitor->where('SEQ_TV', $idVeiculo);
		return $this->monitor->update('TELEVISAO', $tb);
	}
	public function getVeiculo($id) {
		$this->monitor->where('SEQ_VEICULO', $id);
		return $this->monitor->get('VEICULO');
	}

	public function getPortal($id)
	{
		$this->monitor->where('SEQ_PORTAL', $id);
		return $this->monitor->get('PORTAL');
	}
	public function getRadio($id)
	{
		$this->monitor->where('SEQ_RADIO', $id);
		return $this->monitor->get('RADIO');
	}
	public function getTv($id)
	{
		$this->monitor->where('SEQ_TV', $id);
		return $this->monitor->get('TELEVISAO');
	}

	public function listaGrupoVeiculo() {
            $this->load->database();
                $this->db->order_by('DESC_GRUPO_VEICULO', 'ASC');
		$query = $this->db->get('GRUPO_VEICULO');
		return $query->result_array();
	}
	public function countLinkSite($id=NULL,$domains){

		if (!empty($id))
			$this->monitor->where('PORTAL.SEQ_PORTAL<>'.$id);
		$this->monitor->where('PORTAL.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));

		foreach ($domains as $item) {
			$this->monitor->like("PORTAL.SITE_PORTAL", trim($item));
		}
		$this->monitor->from('PORTAL');
//        echo $this->monitor->get_compiled_select();
//        die;
		return $this->monitor->count_all_results();
	}

	public function carregaPreco($id,$tipoMat) {

		$this->monitor->order_by('DESCRITIVO', 'ASC');
		$this->monitor->where('IND_ATIVO',  'S');
		$this->monitor->where('SEQ_CHAVE',  $id);
		$this->monitor->where('TIPO_MATERIA',  $tipoMat);
		$this->monitor->where('SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
		$query = $this->monitor->get('PRECO');
		return $query->result_array();
	}

	public function inserirPreco($data_os=NULL)
	{
		$this->monitor->insert('PRECO', $data_os);

		return $this->monitor->insert_id();
	}

	public function deletarPreco($id) {
		$this->monitor->where('SEQ_PRECO', $id);
		return $this->monitor->delete('PRECO');
	}
	public function getPreco($id) {
		$this->monitor->where('SEQ_PRECO', $id);
		return $this->monitor->get('PRECO');
	}

	public function alterarPreco($tb,$id) {
		$this->monitor->where('SEQ_PRECO', $id);
		return $this->monitor->update('PRECO',$tb);
	}
	public function listaInternetAlerta($idCliente) {

		$this->monitor->order_by('NOME_PORTAL', 'ASC');
		$this->monitor->where('SEQ_CLIENTE',$idCliente);
		$query = $this->monitor->get('PORTAL');
		return $query->result_array();
	}
	public function listaImpressoAlerta($idCliente) {

		$this->monitor->order_by('NOME_VEICULO', 'ASC');
		$this->monitor->where('SEQ_CLIENTE',$idCliente);
		$query = $this->monitor->get('VEICULO');
		return $query->result_array();
	}
}
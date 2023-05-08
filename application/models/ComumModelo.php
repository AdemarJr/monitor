<?php
class ComumModelo extends CI_Model
{

    /**
     * Constructor
     *
     */
    function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->helper('url');

    }//Controller End


    /**
     * Set Style for the flash messages
     *
     * @access    public
     * @param    string    the type of the flash message
     * @param    string  flash message
     * @return    string    flash message with proper style
     */
    function flash_message($type, $message)
    {
        $tipo = array(
            'success'=>'alert-success',
            'error'=>'alert-danger',
            'warning'=>'alert-warning'
        );

        return $data = "showNotification('".$tipo[$type]."', '".$message."', 'bottom', 'center', 'animated fadeInUp', '')" ; //'
    }//End of flash_message Function


    /**
     * Set Style for the flash messages in admin section
     *
     * @access    public
     * @param    string    the type of the flash message
     * @param    string  flash message
     * @return    string    flash message with proper style
     */
    function admin_flash_message($type, $message)
    {
        switch ($type) {
            case 'success':
                $data = '<div class="message"><div class="success">' . $message . '</div></div>';
                break;
            case 'error':
                $data = '<div class="message"><div class="error">' . $message . '</div></div>';
                break;
        }
        return $data;
    }//End of flash_message Function


    function getCountries($conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->from('country');
        $this->db->select('country.id,country.country_symbol,country.country_name');
        $result = $this->db->get();
        return $result;
    }

    function getUser($id)
    {
        $this->db->where('SEQ_USUARIO',$id);
        return $this->db->get('USUARIO');
    }
    function getUserPermission($id)
    {
        $this->db->distinct();
        $this->db->select('MOD_METODO, CLA_METODO, NOM_METODO');
        $this->db->where('SEQ_USUARIO',$id);
        return $this->db->get('VW_PERMISSAO');
    }

    function getCliente($id)
    {
        $this->db->where('SEQ_CLIENTE',$id);
        return $this->db->get('CLIENTE');
    }
    function getClienteByLogin($id)
    {
        $this->db->where("REPLACE(REPLACE(REPLACE(CNPJ_CPF_CLIENTE,'-',''),'.',''),'/','')='".$id."'");
        return $this->db->get('CLIENTE');
    }
    function getClientes($id)
    {
        $this->db->distinct('CLIENTE.*');
        $this->db->where('CLIENTE.SEQ_CLIENTE IN ('.$id.')');
        return $this->db->get('CLIENTE');
    }
    function getClienteTodos()
    {
        $this->db->where('ATIVO', 1);
        $this->db->order_by('NOME_CLIENTE', 'ASC');
        return $this->db->get('CLIENTE');
    }
    public function quantitativoReleaseSecretaria($datai=NULL, $dataf=NULL, $idCliente=NULL, $veiculo=NULL) {
        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        if(empty($veiculo)) {
            $SQL = 'SELECT RM.SEQ_SETOR, S.SIG_SETOR AS SETOR, COUNT(RA.SEQ_RELEASE) AS QUANTIDADE FROM RELEASE_SECRETARIA RA
            JOIN RELEASE_MATERIA RM ON RM.SEQ_RELEASE = RA.SEQ_RELEASE
            JOIN SETOR S ON S.SEQ_SETOR = RA.SEQ_SETOR
            WHERE RM.DATA BETWEEN '.$periodoEnvIni.' AND '.$periodoEnvFim.'
            AND RM.SEQ_CLIENTE = '.$idCliente.'
            GROUP BY RA.SEQ_SETOR, S.SIG_SETOR
            ORDER BY 3 DESC';
        } else {
            $SQL = 'SELECT RM.SEQ_SETOR, S.SIG_SETOR AS SETOR, COUNT(RA.SEQ_RELEASE) AS QUANTIDADE FROM RELEASE_SECRETARIA RA
            JOIN RELEASE_MATERIA RM ON RM.SEQ_RELEASE = RA.SEQ_RELEASE
            JOIN MATERIA M ON M.SEQ_RELEASE = RM.SEQ_RELEASE
            JOIN SETOR S ON S.SEQ_SETOR = RA.SEQ_SETOR
            WHERE RM.DATA BETWEEN '.$periodoEnvIni.' AND '.$periodoEnvFim;
            $vecStr = '';
            foreach ($veiculo as $vec) {
                $vecStr .= "'$vec'" .', ';
            }
            $strVec = substr($vecStr, 0, -2);
           
            $SQL .= ' AND M.TIPO_MATERIA IN ('.$strVec.') ';
            $SQL .= 'AND RM.SEQ_CLIENTE = '.$idCliente.'
            GROUP BY RA.SEQ_SETOR, S.SIG_SETOR
            ORDER BY 3 DESC';
        }
        return $this->db->query($SQL)->result();
    }
    function getAreaMateria($id)
    {
        $this->db->where('SEQ_TIPO_MATERIA',$id);
        return $this->db->get('TIPO_MATERIA');
    }

    function getVeiculo($id)
    {
        $this->db->where('SEQ_VEICULO',$id);
        return $this->db->get('VEICULO');
    }
    function getPortal($id)
    {
        $this->db->where('SEQ_PORTAL',$id);
        return $this->db->get('PORTAL');
    }
    function getRadio($id)
    {
        $this->db->where('SEQ_RADIO',$id);
        return $this->db->get('RADIO');
    }
    function getSetor($id)
    {
        $this->db->where('SEQ_SETOR',$id);
        return $this->db->get('SETOR');
    }
    function getSetorCliente($id)
    {
        $this->db->where('SEQ_CLIENTE',$id);
        return $this->db->get('SETOR');
    }
    function listaSetor()
    {
        return $this->db->get('SETOR');
    }
    function listaSetorClienteMat($id)
    {
        $this->db->distinct();
        $this->db->select('SETOR.SEQ_SETOR as id, SETOR.DESC_SETOR AS nome');
        $this->db->where('SETOR.SEQ_CLIENTE',$id);

        $this->db->where('(MATERIA.SEQ_TV>0 OR MATERIA.SEQ_RADIO>0)');

        $this->db->join("MATERIA", "MATERIA.SEQ_SETOR=SETOR.SEQ_SETOR");
        return $this->db->get('SETOR')->result_array();
    }
    function getDescSituacaoAvulso($id)
{

    $lista = array(
        'R'=>'Revisao',
        'C'=>'Cadastrada',
        'A'=>'Aprovada',
        'E'=>'Efetuado',
        'D'=>'Deletado',
        'P'=>'Em aprovacao',
        'T'=>'Aprovada/Aguardando tesouraria',
        'L'=>'Liberado'
    );
    return $lista[$id];
}
    function getCorSituacaoAvulso($id)
    {

        $lista = array(
            'R'=>'-orange',
            'C'=>'-olive',
            'A'=>'-purple',
            'E'=>'-blue',
            'D'=>'-red',
            'P'=>'-teal',
            'T'=>'-navy',
            'L'=>'-fuchsia'
        );
        return $lista[$id];
    }
    function getDescSituacaoOC($id)
    {

        $lista = array(
            'R'=>'Revisao',
            'C'=>'Cadastrada',
            'A'=>'Aprovada',
            'E'=>'Efetuado',
            'D'=>'Deletado',
            'P'=>'Em aprovacao'
        );
        return $lista[$id];
    }
    function getCorSituacaoOC($id)
    {

        $lista = array(
            'R'=>'-orange',
            'C'=>'-olive',
            'A'=>'-purple',
            'E'=>'-blue',
            'D'=>'-red',
            'P'=>'-teal'
        );
        return $lista[$id];
    }

    function getDescSituacaoProtocolo($id)
    {

        $lista = array(
            'R'=>'Revisao',
            'C'=>'Cadastrada',
            'A'=>'Autenticada',
            'D'=>'Deletado',
            'E'=>'Em Autenticacao'
        );
        return $lista[$id];
    }

    function getDescSituacaoRC($id)
    {

        $lista = array(
            'C'=>'Cadastrada',
            'E'=>'Em Cotacao',
            'P'=>'Atendida Parcial',
            'F'=>'Concluida',
            'D'=>'Deletada',
            'V'=>'Enviado para Compra',
        );
        return $lista[$id];
    }
    function getCorSituacaoRC($id)
    {
        $lista = array(
            'E'=>'-orange',
            'C'=>'-olive',
            'P'=>'-green',
            'F'=>'-teal',
            'D'=>'-red',
            'V'=>'-purple'
        );
        return $lista[$id];
    }
    function getDescGrauRC($id)
    {

        $lista = array(
            'R'=>'Vermelho',
            'A'=>'Amarelo',
            'G'=>'Verde'
        );
        return $lista[$id];
    }
    function getCorGrauRC($id)
    {

        $lista = array(
            'A'=>'-orange',
            'G'=>'-green',
            'R'=>'-red'
        );
        return $lista[$id];
    }
    function getCorSituacaoProtocolo($id)
    {

        $lista = array(
            'R'=>'-orange',
            'C'=>'-olive',
            'A'=>'-purple',
            'E'=>'-teal',
            'D'=>'-red'
        );
        return $lista[$id];
    }


    /**
     * Get getPages
     *
     * @access    public
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function getSitelogo()
    {
        $conditions = array('settings.code' => 'SITE_LOGO');
        $data = array();
        $this->db->where($conditions);
        $this->db->from('settings');
        $this->db->select('settings.string_value');
        $result = $this->db->get();
        $data['site_logo'] = $result->result();
        return $data;
    }


    function user_notification()
    {

        $this->db->select('*');
        $this->db->from('user_notification');
        $query = $this->db->get();
        $result = $query->result();

        return $result;

    }

    function countVeiculoAvaliacao($veiculo=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('SEQ_VEICULO',$veiculo);
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function countPortalAvaliacao($veiculo=NULL,$avaliacao='',$datai=NULL,$dataf=NULL,$grupo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if(!empty($grupo)){
            $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }
        if (!empty($veiculo))
            $this->db->where('MATERIA.SEQ_PORTAL',$veiculo);
        $this->db->select("MATERIA.SEQ_MATERIA");
        $this->db->where('MATERIA.TIPO_MATERIA','S');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function countPortalAvaliacaoRadio($veiculo=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if (!empty($veiculo))
            $this->db->where('SEQ_RADIO',$veiculo);
        $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where('MATERIA.TIPO_MATERIA','R');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function countPortalAvaliacaoTv($veiculo=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if (!empty($veiculo))
            $this->db->where('SEQ_TV',$veiculo);
            $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where('MATERIA.TIPO_MATERIA','T');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function countPortalAvaliacaoImpresso($veiculo=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if (!empty($veiculo))
            $this->db->where('SEQ_RADIO',$veiculo);
            $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where('MATERIA.TIPO_MATERIA','I');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }

    // somente internet e impresso
    function countMesAvaliacao($mes=NULL,$avaliacao='')
    {
        $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".$mes.'01 and '.$mes.'31');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where_in('MATERIA.TIPO_MATERIA',array('S','I'));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function listMateriaVeiculoAvaliacao($veiculo=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('SEQ_VEICULO',$veiculo);
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return $this->db->result_array();
    }
    function listMateriaPortalAvaliacao($area=NULL,$avaliacao='',$datai=NULL,$dataf=NULL,$grupo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->distinct();
        $this->db->order_by('3','DESC');
//        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if (!empty($area))
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA',$area);
        else
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA is null');
//        $this->db->where('MATERIA.SEQ_PORTAL > 0');
        $this->db->where('MATERIA.TIPO_MATERIA','S');
//        $this->db->where("DATA_MATERIA_PUB BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
//        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
//        $this->db->from('MATERIA');
        $this->db->where('PORTAL.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->select('PORTAL.SEQ_PORTAL, PORTAL.NOME_PORTAL,COUNT(*) as QTD');
        $this->db->join('MATERIA', 'PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL','right');
        $this->db->where('MATERIA.SEQ_PORTAL > 0');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        if(!empty($grupo)){
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }

        $this->db->group_by('PORTAL.SEQ_PORTAL, PORTAL.NOME_PORTAL');
        $this->db->from('PORTAL');
        return $this->db->get()->result_array();
    }
    function listMateriaPortalAvaliacaoRadio($area=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->distinct();
        $this->db->order_by('3','DESC');
        if (!empty($area))
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA',$area);
        else
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA is null');
        $this->db->where('MATERIA.TIPO_MATERIA','R');
        $this->db->where('RADIO.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->select('RADIO.SEQ_RADIO, RADIO.NOME_RADIO,COUNT(*) as QTD');
        $this->db->join('MATERIA', 'RADIO.SEQ_RADIO=MATERIA.SEQ_RADIO','right');
        $this->db->where('MATERIA.SEQ_RADIO > 0');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by('RADIO.SEQ_RADIO, RADIO.NOME_RADIO');
        $this->db->from('RADIO');
        return $this->db->get()->result_array();
    }
    function listMateriaPortalAvaliacaoTv($area=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->distinct();
        $this->db->order_by('3','DESC');
        if (!empty($area))
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA',$area);
        else
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA is null');
        $this->db->where('MATERIA.TIPO_MATERIA','T');
        $this->db->where('TELEVISAO.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->select('TELEVISAO.SEQ_TV, TELEVISAO.NOME_TV,COUNT(*) as QTD');
        $this->db->join('MATERIA', 'TELEVISAO.SEQ_TV=MATERIA.SEQ_TV','right');
        $this->db->where('MATERIA.SEQ_TV > 0');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by('TELEVISAO.SEQ_TV, TELEVISAO.NOME_TV');
        $this->db->from('TELEVISAO');
        return $this->db->get()->result_array();
    }
    function listMateriaPortalAvaliacaoImpresso($area=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->distinct();
        $this->db->order_by('3','DESC');
        if (!empty($area))
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA',$area);
        else
            $this->db->where('MATERIA.SEQ_TIPO_MATERIA is null');
        $this->db->where('MATERIA.TIPO_MATERIA','I');
        $this->db->where('VEICULO.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->select('VEICULO.SEQ_VEICULO, VEICULO.NOME_VEICULO,COUNT(*) as QTD');
        $this->db->join('MATERIA', 'VEICULO.SEQ_VEICULO=MATERIA.SEQ_VEICULO','right');
        $this->db->where('MATERIA.SEQ_VEICULO > 0');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by('VEICULO.SEQ_VEICULO, VEICULO.NOME_VEICULO');
        $this->db->from('VEICULO');
        return $this->db->get()->result_array();
    }
    function listMateriaPortalAreaAvaliacao($area=NULL,$portal=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->order_by('MATERIA.DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if (!empty($area))
            $this->db->where('SEQ_TIPO_MATERIA',$area);
        else
            $this->db->where('SEQ_TIPO_MATERIA is null');
            $this->db->where('MATERIA.SEQ_PORTAL',$portal);
        $this->db->where('MATERIA.TIPO_MATERIA','S');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return $this->db->get()->result_array();
    }
    function listMateriaPortalAreaAvaliacaoRadio($area=NULL,$portal=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->order_by('MATERIA.DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if (!empty($area))
            $this->db->where('SEQ_TIPO_MATERIA',$area);
        else
            $this->db->where('SEQ_TIPO_MATERIA is null');
        $this->db->where('MATERIA.SEQ_RADIO',$portal);
        $this->db->where('MATERIA.TIPO_MATERIA','R');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return $this->db->get()->result_array();
    }
    function listMateriaPortalAreaAvaliacaoTv($area=NULL,$portal=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->order_by('MATERIA.DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if (!empty($area))
            $this->db->where('SEQ_TIPO_MATERIA',$area);
        else
            $this->db->where('SEQ_TIPO_MATERIA is null');
        $this->db->where('MATERIA.SEQ_TV',$portal);
        $this->db->where('MATERIA.TIPO_MATERIA','T');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return $this->db->get()->result_array();
    }
    function listMateriaPortalAreaAvaliacaoImpresso($area=NULL,$portal=NULL,$avaliacao='',$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->order_by('MATERIA.DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        if (!empty($area))
            $this->db->where('SEQ_TIPO_MATERIA',$area);
        else
            $this->db->where('SEQ_TIPO_MATERIA is null');
        $this->db->where('MATERIA.SEQ_VEICULO',$portal);
        $this->db->where('MATERIA.TIPO_MATERIA','I');
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return $this->db->get()->result_array();
    }

    function listMateriaTag($texto=NULL,$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->order_by('MATERIA.DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('MATERIA.TIPO_MATERIA', 'S');

        $this->db->like('upper(MATERIA.PC_MATERIA)',$texto);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');

        return $this->db->get()->result_array();
    }
    function listMateriaTagRadio($texto=NULL,$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->order_by('MATERIA.DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('MATERIA.TIPO_MATERIA', 'R');
        $this->db->like('upper(MATERIA.PC_MATERIA)',$texto);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');

        return $this->db->get()->result_array();
    }

    function listMateriaTagTv($texto=NULL,$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->order_by('MATERIA.DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('MATERIA.TIPO_MATERIA', 'T');
        $this->db->like('upper(MATERIA.PC_MATERIA)',$texto);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');

        return $this->db->get()->result_array();
    }

    function listMateriaTagImpresso($texto=NULL,$datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->order_by('MATERIA.DATA_MATERIA_PUB','ASC');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('MATERIA.TIPO_MATERIA', 'I');
        $this->db->like('upper(MATERIA.PC_MATERIA)',$texto);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');

        return $this->db->get()->result_array();
    }

    public function drillAvalPortalArea($datai,$dataf,$area=NULL,$portal=NULL){
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $this->db->distinct();
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->select('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA,COUNT(*) as QTD');
        $this->db->join('MATERIA', 'MATERIA.SEQ_TIPO_MATERIA=TIPO_MATERIA.SEQ_TIPO_MATERIA', 'RIGHT');
        $this->db->where('MATERIA.SEQ_PORTAL > 0');
        $this->db->where('MATERIA.IND_AVALIACAO',$tipo);
        $this->db->where("MATERIA.DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->group_by('TIPO_MATERIA.SEQ_TIPO_MATERIA,TIPO_MATERIA.DESC_TIPO_MATERIA');
        $this->db->from('TIPO_MATERIA');
        $result = $this->db->get()->result_array();
        return $result;
    }


    function listaAnexo($id) {
        $this->db->order_by('ORDEM_ARQUIVO', 'ASC');
        $this->db->where('SEQ_MATERIA', $id);
        $query = $this->db->get('ANEXO');
        return $query->result_array();
    }
    // somente impresso e internet
    function countClassificacaoAvaliacao($classificacao=NULL,$avaliacao='',$datai,$dataf)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('MATERIA.IND_CLASSIFICACAO',$classificacao);
        $this->db->where('MATERIA.IND_AVALIACAO',$avaliacao);
        $this->db->where_in('MATERIA.TIPO_MATERIA',array('S','I'));
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function countVeiculoClassificacao($veiculo=NULL,$classificacao='',$datai,$dataf)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('SEQ_VEICULO',$veiculo);
        $this->db->where('MATERIA.IND_CLASSIFICACAO',$classificacao);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function countPortalClassificacao($veiculo=NULL,$classificacao='',$datai,$dataf,$grupo)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        if(!empty($grupo)){
            $this->db->join('PORTAL','PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL');
            $this->db->where('PORTAL.GRUPO_PORTAL', $grupo);
        }
        $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('MATERIA.SEQ_PORTAL',$veiculo);
        $this->db->where('MATERIA.IND_CLASSIFICACAO',$classificacao);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function countPortalClassificacaoRadio($veiculo=NULL,$classificacao='',$datai,$dataf)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('SEQ_RADIO',$veiculo);
        $this->db->where('MATERIA.IND_CLASSIFICACAO',$classificacao);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function countPortalClassificacaoTv($veiculo=NULL,$classificacao='',$datai,$dataf)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $this->db->select('MATERIA.SEQ_MATERIA');
        $this->db->where('MATERIA.SEQ_CLIENTE', $this->session->userData('idClienteSessao'));
        $this->db->where('SEQ_TV',$veiculo);
        $this->db->where('MATERIA.IND_CLASSIFICACAO',$classificacao);
        $this->db->where("DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." and ".trim($periodoFim));
        $this->db->where_in('MATERIA.IND_STATUS', array('E', 'F'));
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function getTableData($table = '', $conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array(), $like1 = array(), $order = array(), $conditions1 = array())
    {
         $this->load->database();
        //Check For Conditions
        if (is_array($conditions) and count($conditions) > 0)
            $this->db->where($conditions);

        //Check For Conditions
        if (is_array($conditions1) and count($conditions1) > 0)
            $this->db->or_where($conditions1);

        //Check For like statement
        if (is_array($like) and count($like) > 0)
            $this->db->like($like);

        if (is_array($like1) and count($like1) > 0)

            $this->db->or_like($like1);

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }


        //Check for Order by
        if (is_array($order) and count($order) > 0)
            $this->db->order_by($order[0], $order[1]);

        $this->db->from($table);

        //Check For Fields
        if ($fields != '')

            $this->db->select($fields);

        else
            $this->db->select();

        if ($fields == 'user_id') {
            $this->db->distinct();
        }
        // echo $this->db->get_compiled_select();
        // die;

        $result = $this->db->get();

        return $result;

    }
    function deleteTableData($table = '', $conditions = array())
    {
        //Check For Conditions
        if (is_array($conditions) and count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->delete($table);
        return $this->db->affected_rows();

    }//End of deleteTableData Function
    function insertData($table = '', $insertData = array())
    {
        $this->db->insert($table, $insertData);
        return $this->db->insert_id();
    }//End of insertData Function
    function updateTableData($table = '', $id = 0, $conditions = array(), $updateData = array())
    {
        if (is_array($conditions) and count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->update($table, $updateData);

    }//End of updateTableData Function
    function inserTableData($table = '', $insertData = array())
    {

        $this->db->insert($table, $insertData);
        return $this->db->insert_id();
    }//End of inserTableData Function
    function valorPorExtenso($valor=0) {
        $singular = array("Centavo", "Real", "Mil", "Milh&atilde;o", "Bilh&atilde;o", "Trilh&atilde;o", "Quatrilh&atilde;o");
        $plural = array("Centavos", "Reais", "Mil", "Milh&otilde;es", "Bilh&otilde;es", "Trilh&otilde;es","Quatrilh&otilde;es");

        $c = array("", "Cem", "Duzentos", "Trezentos", "Quatrocentos","Quinhentos", "Seiscentos", "Setecentos", "Oitocentos", "Novecentos");
        $d = array("", "Dez", "Vinte", "Trinta", "Quarenta", "Cinquenta","Sessenta", "Setenta", "Oitenta", "Noventa");
        $d10 = array("Dez", "Onze", "Doze", "Treze", "Quatorze", "Quinze","Dezesseis", "Dezesete", "Dezoito", "Dezenove");
        $u = array("", "Um", "Dois", "Tr&ecirc;s", "Quatro", "Cinco", "Seis","Sete", "Oito", "Nove");

        $z=0;
        $rt="";

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for($i=0;$i<count($inteiro);$i++)
            for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
                $inteiro[$i] = "0".$inteiro[$i];

        // $fim identifica onde que deve se dar jun��o de centenas por "e" ou por "," ?
        $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
        for ($i=0;$i<count($inteiro);$i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
            $t = count($inteiro)-1-$i;
            $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ($valor == "000")$z++; elseif ($z > 0) $z--;
            if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
            if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        return ($rt ? $rt : "zero");
    }
    public function getMaiorDataAlerta($chave=null)
    {
        $dataNota = $this->ComumModelo->getTableData('NOTA',array('CHAVE_NOTIFICACAO'=>$chave))->row();
        $grupoNota= $dataNota->GRUPO_PORTAL;
        $this->db->select("MAX(DATA_MATERIA_CAD) as DT_ULTIMA");
        $this->db->where("(IND_STATUS='E' or IND_STATUS='F')");
        $this->db->where("NOTA.CHAVE_NOTIFICACAO", "$chave");
        $this->db->where("DATA_PUB_NUMERO BETWEEN DATE_FORMAT(NOTA.DT_INICIO, '%Y%m%d') and DATE_FORMAT(NOTA.DT_FIM, '%Y%m%d')");
        $this->db->join("NOTA", "NOTA.SEQ_CLIENTE=MATERIA.SEQ_CLIENTE AND (MATERIA.TIPO_MATERIA=NOTA.TIPO_MATERIA OR NOTA.TIPO_MATERIA IS NULL)");
        if(!empty($grupoNota))
            $this->db->join("PORTAL", "PORTAL.SEQ_PORTAL=MATERIA.SEQ_PORTAL AND PORTAL.GRUPO_PORTAL='$grupoNota'");
        $this->db->from('MATERIA');
        $result = $this->db->get()->row();
        return $result->DT_ULTIMA;
    }
    public function existeAnexo($id=NULL)
    {
        if (empty($id)) return false;

        $this->load->model('materiaModelo', 'MateriaModelo');
        $anexo = $this->MateriaModelo->getAnexo($id)->row();

        $arquivo = APPPATH_MATERIA . $anexo->SEQ_MATERIA . '/' . $anexo->NOME_BIN_ARQUIVO;

        return is_file($arquivo);

    }
    public function getMateria($idMateria=null)
    {
        $this->db->select("MATERIA.HORA_MATERIA,MATERIA.PROGRAMA_MATERIA ,MATERIA.SEQ_TV,TELEVISAO.NOME_TV,SETOR.DESC_SETOR,SETOR.DESC_SETOR,SETOR.SIG_SETOR,SETOR.SEQ_SETOR,OLD_PASSWORD(SEQ_MATERIA) AS CHAVE,MATERIA.SEQ_CLIENTE,DATE_FORMAT(DATA_MATERIA_PUB, '%d/%m/%Y') as DIA, SEQ_MATERIA, LINK_MATERIA,MATERIA.TIPO_MATERIA,TIT_MATERIA,PC_MATERIA,TEXTO_MATERIA, MATERIA.SEQ_PORTAL,SEQ_VEICULO,SEQ_RADIO,IND_AVALIACAO");
        $this->db->where("(IND_STATUS='E' or IND_STATUS='F')");
        $this->db->where("(MATERIA.DATA_MATERIA_PUB IS NOT NULL AND (MATERIA.SEQ_TV>0 OR MATERIA.SEQ_PORTAL>0 OR MATERIA.SEQ_RADIO>0 OR MATERIA.SEQ_VEICULO>0))");
        $this->db->where("MATERIA.SEQ_MATERIA=".$idMateria);
        $this->db->join("SETOR", "SETOR.SEQ_SETOR=MATERIA.SEQ_SETOR","LEFT");
        $this->db->join("TELEVISAO", "TELEVISAO.SEQ_TV=MATERIA.SEQ_TV","LEFT");
        $this->db->from('MATERIA');
//        echo $this->db->get_compiled_select();
//        die;
        $result = $this->db->get();
        return $result;
    }
    public function quantitativoUsuario($datai=NULL,$dataf=NULL,$horair=NULL,$horafr=NULL,$idCliente=NULL)
    {
//        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4}) - (\d{2}):(\d{2})#', '$3$2$1$4$5', $datai);
//        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4}) - (\d{2}):(\d{2})#', '$3$2$1$4$5', $dataf);
        $periodoIni = preg_replace("#(\d{2})\/(\d{2})\/(\d{4})#", "$3$2$1", $datai);
        $periodoFim = preg_replace("#(\d{2})\/(\d{2})\/(\d{4})#", "$3$2$1", $dataf);

        $periodoIni .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
        $periodoFim .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);

        $slq = "SELECT A.SEQ_USUARIO,A.NOME_USUARIO, SUM(IF(A.TIPO_MATERIA='I',QTD,0)) AS IMPRESSO,SUM(IF(A.TIPO_MATERIA='S',QTD,0)) AS INTERNET, "
            ."SUM(IF(A.TIPO_MATERIA='R',QTD,0)) AS RADIO,SUM(IF(A.TIPO_MATERIA='T',QTD,0)) AS TELEVISAO, SUM(A.QTD) AS TOTAL FROM (SELECT B.SEQ_USUARIO, B.NOME_USUARIO,A.TIPO_MATERIA,COUNT(*) as QTD "
            ."FROM MATERIA A INNER JOIN USUARIO B ON A.SEQ_USUARIO=B.SEQ_USUARIO LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            ."LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL WHERE B.LOGIN_USUARIO<>'admin' AND"
            ."(A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL "
            ."AND DATA_NUMERO BETWEEN ".trim($periodoIni)." AND ".trim($periodoFim).(!empty($idCliente)? " AND A.SEQ_CLIENTE in ( ".$idCliente.")":'')." GROUP BY B.SEQ_USUARIO,B.NOME_USUARIO,A.TIPO_MATERIA) A GROUP BY A.SEQ_USUARIO,NOME_USUARIO";

//        if (!empty($idCliente)){ echo $slq;die;}


        $query = $this->db->query($slq);
//        echo $this->db->last_query();
//        die();
        return $query->result_array();

    }

    public function quantitativoMateriaAlerta($datai=NULL,$dataf=NULL,$idCliente=NULL,$setor=NULL,$area=NULL)
    {
        $periodoIni = preg_replace("#(\d{2})\/(\d{2})\/(\d{4})#", "$3$2$1", $datai);
        $periodoFim = preg_replace("#(\d{2})\/(\d{2})\/(\d{4})#", "$3$2$1", $dataf);

//        $periodoIni .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
//        $periodoFim .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);

        $slq = 	" SELECT EMPRESA_CLIENTE, 'A' as TIPO_MATERIA, "
            ." REPLACE(CONCAT(POSITIVO,' (',(ROUND(((POSITIVO/TOTAL)*100),2)),'%)'),'.',',') AS POSITIVO, "
            ." REPLACE(CONCAT(NEGATIVO,' (',(ROUND(((NEGATIVO/TOTAL)*100),2)),'%)'),'.',',') AS NEGATIVO, "
            ." REPLACE(CONCAT(NEUTRO,' (',(ROUND(((NEUTRO/TOTAL)*100),2)),'%)'),'.',',') AS NEUTRO, "
    ." TOTAL "
    ." FROM "
    ." (SELECT A.EMPRESA_CLIENTE,A.TIPO_MATERIA,  "
    ." SUM(IF(A.IND_AVALIACAO='P',QTD,0)) AS POSITIVO, "
    ." SUM(IF(A.IND_AVALIACAO='N',QTD,0)) AS NEGATIVO,  "
    ." SUM(IF(A.IND_AVALIACAO='T',QTD,0)) AS NEUTRO,  "
    ." SUM(A.QTD) AS TOTAL FROM ( "
    ." SELECT A1.EMPRESA_CLIENTE, A.TIPO_MATERIA,A.IND_AVALIACAO,COUNT(*) as QTD  "
    ." FROM MATERIA A  "
    ." INNER JOIN CLIENTE A1 ON A.SEQ_CLIENTE=A1.SEQ_CLIENTE  "
    ." INNER JOIN USUARIO B ON A.SEQ_USUARIO=B.SEQ_USUARIO  "
    ." LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO  "
    ." LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL  "
    ." WHERE A.SEQ_SETOR NOT IN (316,317,318) AND "
    .($setor>0?' FIND_IN_SET('.$setor. ', A.SEQ_SETOR)>0 AND':"")
    . ($area>0?' A.SEQ_TIPO_MATERIA='.$area. ' AND':'')
    ." (A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) AND  "
    ." A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL AND  "
    ." DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." AND ".trim($periodoFim).(!empty($idCliente)? " AND A.SEQ_CLIENTE =".$idCliente:'')
    ." GROUP BY A1.EMPRESA_CLIENTE,A.TIPO_MATERIA,A.IND_AVALIACAO ) A  "
    ." GROUP BY A.EMPRESA_CLIENTE,'A') TT1 "
    ." UNION ALL "
    ." SELECT EMPRESA_CLIENTE,TIPO_MATERIA, "
    ." REPLACE(CONCAT(POSITIVO,' (',(ROUND(((POSITIVO/TOTAL)*100),2)),'%)'),'.',',') AS POSITIVO, "
    ." REPLACE(CONCAT(NEGATIVO,' (',(ROUND(((NEGATIVO/TOTAL)*100),2)),'%)'),'.',',') AS NEGATIVO, "
    ." REPLACE(CONCAT(NEUTRO,' (',(ROUND(((NEUTRO/TOTAL)*100),2)),'%)'),'.',',') AS NEUTRO, "
    ." TOTAL "
    ." FROM "
    ." (SELECT A.EMPRESA_CLIENTE,A.TIPO_MATERIA,  "
    ." SUM(IF(A.IND_AVALIACAO='P',QTD,0)) AS POSITIVO, "
    ." SUM(IF(A.IND_AVALIACAO='N',QTD,0)) AS NEGATIVO,  "
    ." SUM(IF(A.IND_AVALIACAO='T',QTD,0)) AS NEUTRO,  "
    ." SUM(A.QTD) AS TOTAL FROM ( "
    ." SELECT A1.EMPRESA_CLIENTE, A.TIPO_MATERIA,A.IND_AVALIACAO,COUNT(*) as QTD  "
    ." FROM MATERIA A  "
    ." INNER JOIN CLIENTE A1 ON A.SEQ_CLIENTE=A1.SEQ_CLIENTE  "
    ." INNER JOIN USUARIO B ON A.SEQ_USUARIO=B.SEQ_USUARIO  "
    ." LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO  "
    ." LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL  "
    ." WHERE A.SEQ_SETOR NOT IN (316,317,318) AND  "
    .($setor>0?' FIND_IN_SET('.$setor. ', A.SEQ_SETOR)>0 AND':"")
    . ($area>0?' A.SEQ_TIPO_MATERIA='.$area. ' AND':'')
    ." (A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) AND  "
    ." A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL AND  "
    ." DATA_PUB_NUMERO BETWEEN ".trim($periodoIni)." AND ".trim($periodoFim).(!empty($idCliente)? " AND A.SEQ_CLIENTE =".$idCliente:'')
    ." GROUP BY A1.EMPRESA_CLIENTE,A.TIPO_MATERIA,A.IND_AVALIACAO ) A  "
    ." GROUP BY A.EMPRESA_CLIENTE,A.TIPO_MATERIA) TT2 ";
//    echo $slq;
//        die;

        $query = $this->db->query($slq);
        return $query->result_array();

    }

    public function menorMaiorUsuario($idUsuario=NULL,$datai=NULL,$dataf=NULL,$horair=NULL,$horafr=NULL,$idCliente=NULL)
    {
//        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4}) - (\d{2}):(\d{2})#', '$3$2$1$4$5', $datai);
//        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4}) - (\d{2}):(\d{2})#', '$3$2$1$4$5', $dataf);
        $periodoIni = preg_replace("#(\d{2})\/(\d{2})\/(\d{4})#", "$3$2$1", $datai);
        $periodoFim = preg_replace("#(\d{2})\/(\d{2})\/(\d{4})#", "$3$2$1", $dataf);

        $periodoIni .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
        $periodoFim .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);

        $slq = "SELECT MIN(DATA_MATERIA_CAD) AS MENOR_MAT,MAX(DATA_MATERIA_CAD) AS MAIOR_MAT"
            ." FROM MATERIA A INNER JOIN USUARIO B ON A.SEQ_USUARIO=B.SEQ_USUARIO LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            ."LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL WHERE B.LOGIN_USUARIO<>'admin' AND"
            ."(A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL "
            ."AND DATA_NUMERO BETWEEN ".trim($periodoIni)." AND ".trim($periodoFim).(!empty($idCliente)? " AND A.SEQ_CLIENTE in ( ".$idCliente.")":'')." AND A.SEQ_USUARIO=".$idUsuario;

//        if (!empty($idCliente)){ echo $slq;die;}
        $query = $this->db->query($slq);
        return $query->row();

    }
    public function quantitativoSetor($datai=NULL,$dataf=NULL,$idCliente=NULL,$tipoMateria=NULL,$grupo=NULL,
                                      $excluirSetor=NULL,$setores=NULL, $tags=NULL)
    {
        
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $whereGrupo = '';
        if (!empty($grupo) and $grupo != 0)
            $whereGrupo = " and D.GRUPO_PORTAL=" . $grupo;

        $setor ='';
        if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
            $setor = " B.SEQ_SETOR NOT IN (".$setores.") AND ";
        } else if (!empty($setores) and empty($excluirSetor)){
            $setor = " B.SEQ_SETOR IN (".$setores.") AND";
        }
        if (!empty($tags)) {
            $lista_tag = explode(',', $tags);
            $where = '';
            foreach ($lista_tag as $tag) {
                $where .= "upper(PC_MATERIA) LIKE '%" . strtoupper($tag) . "%' or ";
            }
            $condicao_tag = ' AND ('.substr($where, 0, -4).')';
        } else {
            $condicao_tag = '';
        }


        /*if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
            $array_set = explode(',',$setores);
            if (count($array_set)===1) {
                $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)=0  AND";
            } else {
                foreach($array_set as $set) {
                    $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)>0 AND"; 
                }
            }
        } else if (!empty($setores) and empty($excluirSetor)){
            $array_set = explode(',',$setores);
            if (count($array_set)===1) {
                $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)>0  AND";
            } else {
                $linhas =count($array_set);
                $flag = 1;
                $setor ="(";
                foreach($array_set as $set) {
                    $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)>0 "; 
                    if ($flag < $linhas){
                        $setor .= "OR";
                    }
                    $flag++;
                }
                $setor .=") AND";
            }
        }*/
        

        $slq = "SELECT X.TIPO_MATERIA,X.SEQ_SETOR,X.DESC_SETOR, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
//               "SELECT                X.DESCRICAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
//              "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT A.TIPO_MATERIA,B.SEQ_SETOR,B.DESC_SETOR,A.IND_AVALIACAO,COUNT(*) as QTD FROM MATERIA A "
//              "(SELECT C.NOME_PORTAL AS DESCRICAO,A.IND_AVALIACAO, COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN SETOR B ON FIND_IN_SET(B.SEQ_SETOR, A.SEQ_SETOR)>0 LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            . "LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL " . $whereGrupo . " WHERE ".$setor." FIND_IN_SET(83, A.SEQ_SETOR)=0  AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) AND DATA_PUB_NUMERO BETWEEN " .
            trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente
            .$condicao_tag. " GROUP BY A.TIPO_MATERIA,B.SEQ_SETOR,B.DESC_SETOR,A.IND_AVALIACAO ) X GROUP BY TIPO_MATERIA,SEQ_SETOR,DESC_SETOR ORDER BY 1 ASC,6 DESC ";
    //    echo $slq;
    //    die;
        $query = $this->db->query($slq);
        return $query->result_array();

    }
    public function quantitativoSetorPanorama($datai=NULL,$dataf=NULL,$idCliente=NULL,$tipoMateria=NULL,$grupo=NULL,
                                      $excluirSetor=NULL,$setores=NULL, $tags)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $whereGrupo = '';
        if (!empty($grupo) and $grupo != 0)
            $whereGrupo = " and D.GRUPO_PORTAL=" . $grupo;

        $setor ='';
        if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
            $setor = " B.SEQ_SETOR NOT IN (".$setores.") AND ";
        } else if (!empty($setores) and empty($excluirSetor)){
            $setor = " B.SEQ_SETOR IN (".$setores.") AND";
        }
        
         if (!empty($tags)) {
            $lista_tag = explode(',', $tags);
            $where = '';
            foreach ($lista_tag as $tag) {
                $where .= "upper(A.PC_MATERIA) LIKE '%" . strtoupper($tag) . "%' or ";
            }
            $condicao_tag = ' AND ('.substr($where, 0, -4).')';
        } else {
            $condicao_tag = '';
        }
        
        $slq = "SELECT X.TIPO_MATERIA, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT A.TIPO_MATERIA,A.IND_AVALIACAO,COUNT(distinct SEQ_MATERIA) as QTD FROM MATERIA A "
            . "INNER JOIN SETOR B ON FIND_IN_SET(B.SEQ_SETOR, A.SEQ_SETOR)>0 LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            . "LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL " . $whereGrupo . " WHERE ".$setor." FIND_IN_SET(83, A.SEQ_SETOR)=0  AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) AND DATA_PUB_NUMERO BETWEEN " .
            trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente
            .$condicao_tag. " GROUP BY A.TIPO_MATERIA,A.IND_AVALIACAO ) X GROUP BY TIPO_MATERIA ORDER BY 1 ASC,4 DESC ";
        $query = $this->db->query($slq);
        return $query->result_array();

    }
    public function quantitativoSetorInternet($datai=NULL,$dataf=NULL,$idCliente=NULL,$tipoMateria=NULL,$grupo=NULL,
                                      $excluirSetor=NULL,$setores=NULL, $tags=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $whereGrupo = '';
        if (!empty($grupo) and $grupo != 0)
            $whereGrupo = " and D.GRUPO_PORTAL=" . $grupo;
		
		$setor ='';
        if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
            $setor = " B.SEQ_SETOR NOT IN (".$setores.") AND ";
        } else if (!empty($setores) and empty($excluirSetor)){
            $setor = " B.SEQ_SETOR IN (".$setores.") AND";
        }
        // if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
        //     $array_set = explode(',',$setores);
        //     if (count($array_set)===1) {
        //         $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)=0  AND";
        //     } else {
        //         foreach($array_set as $set) {
        //             $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)>0 AND"; 
        //         }
        //     }
            
        // } else if (!empty($setores) and empty($excluirSetor)){
        //     $array_set = explode(',',$setores);
        //     if (count($array_set)===1) {
        //         $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)>0  AND";
        //     } else {
        //         $linhas =count($array_set);
        //         $flag = 1;
        //         $setor ="(";
        //         foreach($array_set as $set) {
        //             $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)>0 "; 
        //             if ($flag < $linhas){
        //                 $setor .= "OR";
        //             }
        //             $flag++;
        //         }
        //         $setor .=") AND";
        //     }
        // }
        if (!empty($tags)) {
            $lista_tag = explode(',', $tags);
            $where = '';
            foreach ($lista_tag as $tag) {
                $where .= "upper(A.PC_MATERIA) LIKE '%" . strtoupper($tag) . "%' or ";
            }
            $condicao_tag = ' AND ('.substr($where, 0, -4).')';
        } else {
            $condicao_tag = '';
        }
        $slq = "SELECT X.TIPO_MATERIA,X.DESC_SETOR, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT A.TIPO_MATERIA,B.DESC_SETOR,A.IND_AVALIACAO,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN SETOR B ON FIND_IN_SET(B.SEQ_SETOR, A.SEQ_SETOR)>0 LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            . "INNER JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL " . $whereGrupo . " WHERE ".$setor." FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente
            .$condicao_tag. " GROUP BY A.TIPO_MATERIA,B.DESC_SETOR,A.IND_AVALIACAO ) X GROUP BY TIPO_MATERIA,DESC_SETOR ORDER BY 1 ASC,6 DESC ";



        $query = $this->db->query($slq);
        return $query->result_array();

    }
    public function quantitativoSetor2($datai=NULL,$dataf=NULL,$idCliente,$tipoMateria=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $slq = "SELECT X.TIPO_MATERIA,X.DESC_SETOR, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT A.TIPO_MATERIA,B.DESC_SETOR,A.IND_AVALIACAO,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN SETOR B ON FIND_IN_SET(B.SEQ_SETOR, A.SEQ_SETOR)>0 LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            . "LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL  WHERE B.IND_ESTR='S' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim). " AND A.SEQ_CLIENTE =" . $idCliente
            . " GROUP BY A.TIPO_MATERIA,B.DESC_SETOR,A.IND_AVALIACAO ) X GROUP BY X.TIPO_MATERIA,DESC_SETOR ORDER BY 1 ASC,6 DESC ";
        $query = $this->db->query($slq);
        return $query->result_array();
    }
    public function quantitativoSetor2Cliente($datai=NULL,$dataf=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $slq = "SELECT X.NOME_CLIENTE, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT F.NOME_CLIENTE,A.IND_AVALIACAO,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN CLIENTE F ON A.SEQ_CLIENTE=F.SEQ_CLIENTE INNER JOIN SETOR B ON FIND_IN_SET(B.SEQ_SETOR, A.SEQ_SETOR)>0 LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            . "LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL  WHERE B.IND_ESTR='S'  AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            . " GROUP BY F.NOME_CLIENTE,A.IND_AVALIACAO ) X GROUP BY NOME_CLIENTE ORDER BY 5 DESC ";
        $query = $this->db->query($slq);
        return $query->result_array();

    }
    public function quantitativoVeiculo($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$tipoMateria=NULL,$isrelease=NULL,$isSetorMonitor=NULL,
        $excluirSetor=NULL,$setores=NULL, $tags=NULL)
    {
        
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $release ='';
        $setor = '';
        if (!empty($isrelease)){
            $release=" and IND_RELEASE='S' ";
        }
        if (!empty($isSetorMonitor)){
            $release=" and A.SEQ_SETOR IN (SELECT SEQ_SETOR FROM SETOR WHERE SETOR.IND_ESTR='S' AND SETOR.SEQ_CLIENTE=".$idCliente.") ";
        }
      /*  $setor ='';
        if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
            $setor = " A.SEQ_SETOR NOT IN (".$setores.") AND ";
        } else if (!empty($setores) and empty($excluirSetor)){
            $setor = " A.SEQ_SETOR IN (".$setores.") AND";
        }*/

        if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
            $array_set = explode(',',$setores);
            if (count($array_set)===1) {
                $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)=0  AND";
            } else {
                foreach($array_set as $set) {
                    $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)=0 AND"; 
                }
            }
            
        } else if (!empty($setores) and empty($excluirSetor)){
            $array_set = explode(',',$setores);
            if (count($array_set)===1) {
                $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)>0  AND";
            } else {
                $linhas =count($array_set);
                $flag = 1;
                $setor ="(";
                foreach($array_set as $set) {
                    $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)>0 "; 
                    if ($flag < $linhas){
                        $setor .= "OR";
                    }
                    $flag++;
                }
                $setor .=") AND";
            }
        }
        if (!empty($tags)) {
            $lista_tag = explode(',', $tags);
            $where = '';
            foreach ($lista_tag as $tag) {
                $where .= "upper(A.PC_MATERIA) LIKE '%" . strtoupper($tag) . "%' or ";
            }
            $condicao_tag = ' AND ('.substr($where, 0, -4).')';
        } else {
            $condicao_tag = '';
        }
        if ($tipoMateria == 'I') {
        $slq = "SELECT X.DESCRICAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.FANTASIA_VEICULO AS DESCRICAO,A.IND_AVALIACAO,COUNT(distinct A.SEQ_MATERIA) as QTD FROM MATERIA A "
            . "INNER JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            . "WHERE ".$setor." FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "'".$condicao_tag." AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente
            . " GROUP BY C.FANTASIA_VEICULO,A.IND_AVALIACAO ) X GROUP BY DESCRICAO ORDER BY 5 DESC ";
        } else if($tipoMateria == 'S'){

            $slq = "SELECT X.DESCRICAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
                . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
                . "(SELECT C.NOME_PORTAL AS DESCRICAO,A.IND_AVALIACAO,COUNT(distinct A.SEQ_MATERIA) as QTD FROM MATERIA A "
                . "INNER JOIN PORTAL C ON A.SEQ_PORTAL=C.SEQ_PORTAL ".($grupo=='0'?"":" and GRUPO_PORTAL=".$grupo)
                . " WHERE ".$setor." FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "'".$condicao_tag." AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
                . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente
                . " GROUP BY C.NOME_PORTAL,A.IND_AVALIACAO ) X GROUP BY DESCRICAO ORDER BY 5 DESC ";
        } else if($tipoMateria == 'R'){
            $slq = "SELECT X.DESCRICAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
                . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
                . "(SELECT C.NOME_RADIO AS DESCRICAO,A.IND_AVALIACAO,COUNT(distinct A.SEQ_MATERIA) as QTD FROM MATERIA A "
                . "INNER JOIN RADIO C ON A.SEQ_RADIO=C.SEQ_RADIO "
                . "WHERE ".$setor." FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "'".$condicao_tag." AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
                . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente
                . " GROUP BY C.NOME_RADIO,A.IND_AVALIACAO ) X GROUP BY DESCRICAO ORDER BY 5 DESC ";
        } else if($tipoMateria == 'T'){
            $slq = "SELECT X.DESCRICAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
                . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
                . "(SELECT C.NOME_TV AS DESCRICAO,A.IND_AVALIACAO,COUNT(distinct A.SEQ_MATERIA) as QTD FROM MATERIA A "
                . "INNER JOIN TELEVISAO C ON A.SEQ_TV=C.SEQ_TV "
                . "WHERE ".$setor." FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "'".$condicao_tag." AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
                . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente
                . " GROUP BY C.NOME_TV,A.IND_AVALIACAO ) X GROUP BY DESCRICAO ORDER BY 5 DESC ";
        }
//        echo $slq;
//        die;
        $query = $this->db->query($slq);
        return $query->result_array();

    }
    public function quantitativoVeiculoSeguranca(
        $datai=NULL,
        $dataf=NULL,
        $idCliente=NULL,
        $grupo=NULL,
        $tipoMateria=NULL,
        $isrelease=NULL,
        $tipoCrime=NULL,
        $bairroCrime=NULL,
        $localCrime=NULL,
        $indPreso=NULL
    )
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
        $release ='';
        if (!empty($isrelease)){
            $release=" and IND_RELEASE='S' ";
        }
        $strSeguranca='';
        $strSeguranca1='';
        $strSeguranca2='';
        $strSeguranca3='';
        $strSeguranca4='';
        if ($idCliente==10 and !empty($tipoCrime)){
            $strSeguranca1=" upper(A.TIPO_CRIME) LIKE '%".strtoupper($tipoCrime)."%' ";
        }
        if ($idCliente==10 and !empty($bairroCrime)){
            $strSeguranca2="  upper(A.BAIRRO_CRIME) LIKE '%".strtoupper($bairroCrime)."%' ";
        }

        if ($idCliente==10 and !empty($localCrime)){
            $strSeguranca3="  upper(A.LOCAL_CRIME) LIKE '%".strtoupper($localCrime)."%' ";
        }

        if ($idCliente==10 and !empty($indPreso)){
            $strSeguranca4="  A.IND_PRISAO='".$indPreso."' ";
        }

        $strSeguranca = (!empty($strSeguranca1)? " and ".$strSeguranca1:"")
            .(!empty($strSeguranca2)? " and ".$strSeguranca2:"")
            .(!empty($strSeguranca3)? " and ".$strSeguranca3:"")
            .(!empty($strSeguranca4)? " and ".$strSeguranca4:"");

        if ($tipoMateria == 'I') {
            $slq = "SELECT X.BAIRRO_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
                . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
                . "(SELECT C.FANTASIA_VEICULO AS DESCRICAO,A.IND_AVALIACAO, A.BAIRRO_CRIME,COUNT(*) as QTD FROM MATERIA A "
                . "INNER JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
                . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
                . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente . $strSeguranca
                . " GROUP BY C.FANTASIA_VEICULO,A.IND_AVALIACAO, A.BAIRRO_CRIME ) X GROUP BY BAIRRO_CRIME ORDER BY 5 DESC ";

        } else if($tipoMateria == 'S'){

            $slq = "SELECT X.BAIRRO_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
                . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
                . "(SELECT C.NOME_PORTAL AS DESCRICAO,A.IND_AVALIACAO, A.BAIRRO_CRIME,COUNT(*) as QTD FROM MATERIA A "
                . "INNER JOIN PORTAL C ON A.SEQ_PORTAL=C.SEQ_PORTAL ".($grupo=='0'?"":" and GRUPO_PORTAL=".$grupo)
                . " WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
                . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
                . " GROUP BY C.NOME_PORTAL,A.IND_AVALIACAO, A.BAIRRO_CRIME ) X GROUP BY BAIRRO_CRIME ORDER BY 5 DESC ";
        } else if($tipoMateria == 'R'){
            $slq = "SELECT X.BAIRRO_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
                . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
                . "(SELECT C.NOME_RADIO AS DESCRICAO,A.IND_AVALIACAO, A.BAIRRO_CRIME,COUNT(*) as QTD FROM MATERIA A "
                . "INNER JOIN RADIO C ON A.SEQ_RADIO=C.SEQ_RADIO "
                . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
                . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
                . " GROUP BY C.NOME_RADIO,A.IND_AVALIACAO, A.BAIRRO_CRIME ) X GROUP BY BAIRRO_CRIME ORDER BY 5 DESC ";
        } else if($tipoMateria == 'T'){
            $slq = "SELECT X.BAIRRO_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
                . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
                . "(SELECT C.NOME_TV AS DESCRICAO,A.IND_AVALIACAO, A.BAIRRO_CRIME,COUNT(*) as QTD FROM MATERIA A "
                . "INNER JOIN TELEVISAO C ON A.SEQ_TV=C.SEQ_TV "
                . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
                . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
                . " GROUP BY C.NOME_TV,A.IND_AVALIACAO, A.BAIRRO_CRIME ) X GROUP BY BAIRRO_CRIME ORDER BY 5 DESC ";
        }


//        echo $slq;
//        die;
        $query = $this->db->query($slq);
        return $query->result_array();

    }

    public function quantitativoVeiculoSegurancaCrime(
    $datai=NULL,
    $dataf=NULL,
    $idCliente=NULL,
    $grupo=NULL,
    $tipoMateria=NULL,
    $isrelease=NULL,
    $tipoCrime=NULL,
    $bairroCrime=NULL,
    $localCrime=NULL,
    $indPreso=NULL
)
{
    $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
    $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
    $release ='';
    if (!empty($isrelease)){
        $release=" and IND_RELEASE='S' ";
    }
    $strSeguranca='';
    $strSeguranca1='';
    $strSeguranca2='';
    $strSeguranca3='';
    $strSeguranca4='';
    if ($idCliente==10 and !empty($tipoCrime)){
        $strSeguranca1=" upper(A.TIPO_CRIME) LIKE '%".strtoupper($tipoCrime)."%' ";
    }
    if ($idCliente==10 and !empty($bairroCrime)){
        $strSeguranca2="  upper(A.BAIRRO_CRIME) LIKE '%".strtoupper($bairroCrime)."%' ";
    }

    if ($idCliente==10 and !empty($localCrime)){
        $strSeguranca3="  upper(A.LOCAL_CRIME) LIKE '%".strtoupper($localCrime)."%' ";
    }

    if ($idCliente==10 and !empty($indPreso)){
        $strSeguranca4="  A.IND_PRISAO='".$indPreso."' ";
    }

    $strSeguranca = (!empty($strSeguranca1)? " and ".$strSeguranca1:"")
        .(!empty($strSeguranca2)? " and ".$strSeguranca2:"")
        .(!empty($strSeguranca3)? " and ".$strSeguranca3:"")
        .(!empty($strSeguranca4)? " and ".$strSeguranca4:"");

    if ($tipoMateria == 'I') {
        $slq = "SELECT X.TIPO_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.FANTASIA_VEICULO AS DESCRICAO,A.IND_AVALIACAO, A.TIPO_CRIME,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente . $strSeguranca
            . " GROUP BY C.FANTASIA_VEICULO,A.IND_AVALIACAO, A.TIPO_CRIME ) X GROUP BY TIPO_CRIME ORDER BY 5 DESC ";

    } else if($tipoMateria == 'S'){

        $slq = "SELECT X.TIPO_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_PORTAL AS DESCRICAO,A.IND_AVALIACAO, A.TIPO_CRIME,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN PORTAL C ON A.SEQ_PORTAL=C.SEQ_PORTAL ".($grupo=='0'?"":" and GRUPO_PORTAL=".$grupo)
            . " WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
            . " GROUP BY C.NOME_PORTAL,A.IND_AVALIACAO, A.TIPO_CRIME ) X GROUP BY TIPO_CRIME ORDER BY 5 DESC ";
    } else if($tipoMateria == 'R'){
        $slq = "SELECT X.TIPO_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_RADIO AS DESCRICAO,A.IND_AVALIACAO, A.TIPO_CRIME,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN RADIO C ON A.SEQ_RADIO=C.SEQ_RADIO "
            . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
            . " GROUP BY C.NOME_RADIO,A.IND_AVALIACAO, A.TIPO_CRIME ) X GROUP BY TIPO_CRIME ORDER BY 5 DESC ";
    } else if($tipoMateria == 'T'){
        $slq = "SELECT X.TIPO_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_TV AS DESCRICAO,A.IND_AVALIACAO, A.TIPO_CRIME,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN TELEVISAO C ON A.SEQ_TV=C.SEQ_TV "
            . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
            . " GROUP BY C.NOME_TV,A.IND_AVALIACAO, A.TIPO_CRIME ) X GROUP BY TIPO_CRIME ORDER BY 5 DESC ";
    }


//        echo $slq;
//        die;
    $query = $this->db->query($slq);
    return $query->result_array();

}
    public function quantitativoVeiculoSegurancaLocal(
    $datai=NULL,
    $dataf=NULL,
    $idCliente=NULL,
    $grupo=NULL,
    $tipoMateria=NULL,
    $isrelease=NULL,
    $tipoCrime=NULL,
    $bairroCrime=NULL,
    $localCrime=NULL,
    $indPreso=NULL
)
{
    $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
    $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
    $release ='';
    if (!empty($isrelease)){
        $release=" and IND_RELEASE='S' ";
    }
    $strSeguranca='';
    $strSeguranca1='';
    $strSeguranca2='';
    $strSeguranca3='';
    $strSeguranca4='';
    if ($idCliente==10 and !empty($tipoCrime)){
        $strSeguranca1=" upper(A.TIPO_CRIME) LIKE '%".strtoupper($tipoCrime)."%' ";
    }
    if ($idCliente==10 and !empty($bairroCrime)){
        $strSeguranca2="  upper(A.BAIRRO_CRIME) LIKE '%".strtoupper($bairroCrime)."%' ";
    }

    if ($idCliente==10 and !empty($localCrime)){
        $strSeguranca3="  upper(A.LOCAL_CRIME) LIKE '%".strtoupper($localCrime)."%' ";
    }

    if ($idCliente==10 and !empty($indPreso)){
        $strSeguranca4="  A.IND_PRISAO='".$indPreso."' ";
    }

    $strSeguranca = (!empty($strSeguranca1)? " and ".$strSeguranca1:"")
        .(!empty($strSeguranca2)? " and ".$strSeguranca2:"")
        .(!empty($strSeguranca3)? " and ".$strSeguranca3:"")
        .(!empty($strSeguranca4)? " and ".$strSeguranca4:"");

    if ($tipoMateria == 'I') {
        $slq = "SELECT X.LOCAL_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.FANTASIA_VEICULO AS DESCRICAO,A.IND_AVALIACAO, A.LOCAL_CRIME,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente . $strSeguranca
            . " GROUP BY C.FANTASIA_VEICULO,A.IND_AVALIACAO, A.LOCAL_CRIME ) X GROUP BY LOCAL_CRIME ORDER BY 5 DESC ";

    } else if($tipoMateria == 'S'){

        $slq = "SELECT X.LOCAL_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_PORTAL AS DESCRICAO,A.IND_AVALIACAO, A.LOCAL_CRIME,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN PORTAL C ON A.SEQ_PORTAL=C.SEQ_PORTAL ".($grupo=='0'?"":" and GRUPO_PORTAL=".$grupo)
            . " WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
            . " GROUP BY C.NOME_PORTAL,A.IND_AVALIACAO, A.LOCAL_CRIME ) X GROUP BY LOCAL_CRIME ORDER BY 5 DESC ";
    } else if($tipoMateria == 'R'){
        $slq = "SELECT X.LOCAL_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_RADIO AS DESCRICAO,A.IND_AVALIACAO, A.LOCAL_CRIME,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN RADIO C ON A.SEQ_RADIO=C.SEQ_RADIO "
            . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
            . " GROUP BY C.NOME_RADIO,A.IND_AVALIACAO, A.LOCAL_CRIME ) X GROUP BY LOCAL_CRIME ORDER BY 5 DESC ";
    } else if($tipoMateria == 'T'){
        $slq = "SELECT X.LOCAL_CRIME, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_TV AS DESCRICAO,A.IND_AVALIACAO, A.LOCAL_CRIME,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN TELEVISAO C ON A.SEQ_TV=C.SEQ_TV "
            . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
            . " GROUP BY C.NOME_TV,A.IND_AVALIACAO, A.LOCAL_CRIME ) X GROUP BY LOCAL_CRIME ORDER BY 5 DESC ";
    }


//        echo $slq;
//        die;
    $query = $this->db->query($slq);
    return $query->result_array();

}public function quantitativoVeiculoSegurancaPrisao(
    $datai=NULL,
    $dataf=NULL,
    $idCliente=NULL,
    $grupo=NULL,
    $tipoMateria=NULL,
    $isrelease=NULL,
    $tipoCrime=NULL,
    $bairroCrime=NULL,
    $localCrime=NULL,
    $indPreso=NULL
)
{
    $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
    $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);
    $release ='';
    if (!empty($isrelease)){
        $release=" and IND_RELEASE='S' ";
    }
    $strSeguranca='';
    $strSeguranca1='';
    $strSeguranca2='';
    $strSeguranca3='';
    $strSeguranca4='';
    if ($idCliente==10 and !empty($tipoCrime)){
        $strSeguranca1=" upper(A.TIPO_CRIME) LIKE '%".strtoupper($tipoCrime)."%' ";
    }
    if ($idCliente==10 and !empty($bairroCrime)){
        $strSeguranca2="  upper(A.BAIRRO_CRIME) LIKE '%".strtoupper($bairroCrime)."%' ";
    }

    if ($idCliente==10 and !empty($localCrime)){
        $strSeguranca3="  upper(A.LOCAL_CRIME) LIKE '%".strtoupper($localCrime)."%' ";
    }

    if ($idCliente==10 and !empty($indPreso)){
        $strSeguranca4="  A.IND_PRISAO='".$indPreso."' ";
    }

    $strSeguranca = (!empty($strSeguranca1)? " and ".$strSeguranca1:"")
        .(!empty($strSeguranca2)? " and ".$strSeguranca2:"")
        .(!empty($strSeguranca3)? " and ".$strSeguranca3:"")
        .(!empty($strSeguranca4)? " and ".$strSeguranca4:"");

    if ($tipoMateria == 'I') {
        $slq = "SELECT X.IND_PRISAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.FANTASIA_VEICULO AS DESCRICAO,A.IND_AVALIACAO, A.IND_PRISAO,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente . $strSeguranca
            . " GROUP BY C.FANTASIA_VEICULO,A.IND_AVALIACAO, A.IND_PRISAO ) X GROUP BY IND_PRISAO ORDER BY 5 DESC ";

    } else if($tipoMateria == 'S'){

        $slq = "SELECT X.IND_PRISAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_PORTAL AS DESCRICAO,A.IND_AVALIACAO, A.IND_PRISAO,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN PORTAL C ON A.SEQ_PORTAL=C.SEQ_PORTAL ".($grupo=='0'?"":" and GRUPO_PORTAL=".$grupo)
            . " WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
            . " GROUP BY C.NOME_PORTAL,A.IND_AVALIACAO, A.IND_PRISAO ) X GROUP BY IND_PRISAO ORDER BY 5 DESC ";
    } else if($tipoMateria == 'R'){
        $slq = "SELECT X.IND_PRISAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_RADIO AS DESCRICAO,A.IND_AVALIACAO, A.IND_PRISAO,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN RADIO C ON A.SEQ_RADIO=C.SEQ_RADIO "
            . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
            . " GROUP BY C.NOME_RADIO,A.IND_AVALIACAO, A.IND_PRISAO ) X GROUP BY IND_PRISAO ORDER BY 5 DESC ";
    } else if($tipoMateria == 'T'){
        $slq = "SELECT X.IND_PRISAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_TV AS DESCRICAO,A.IND_AVALIACAO, A.IND_PRISAO,COUNT(*) as QTD FROM MATERIA A "
            . "INNER JOIN TELEVISAO C ON A.SEQ_TV=C.SEQ_TV "
            . "WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='" . $tipoMateria . "' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) ".$release."  AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente. $strSeguranca
            . " GROUP BY C.NOME_TV,A.IND_AVALIACAO, A.IND_PRISAO ) X GROUP BY IND_PRISAO ORDER BY 5 DESC ";
    }


//        echo $slq;
//        die;
    $query = $this->db->query($slq);
    return $query->result_array();

}

    public function quantitativoReleasePorDia($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);

        $release ='';
  /*      $slq ="SELECT  A.SEQ_RELEASE as releasecodigo, DESC_RELEASE as descricaorelease, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." inner JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL)"
            ." AND DATE_FORMAT(DATA_MATERIA_PUB, '%Y%m%d') BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." inner JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente .$periodoEnvio
            ." GROUP BY A.SEQ_RELEASE,A.DESC_RELEASE "
            ." ORDER BY 3 DESC" ;
*/
        $slq =" SELECT A.SEQ_RELEASE as releasecodigo, DESC_RELEASE as descricaorelease, "
        ." SUM((SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL "
        ." AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_RELEASE=B.SEQ_RELEASE AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL "
        ." OR B.SEQ_TV IS NOT NULL) AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoIni)."))"
        ." AS quantidade_publicacoes, date_format(A.DATA_ENVIO_RELEASE,'%d/%m/%Y') as data_release "
        ." FROM RELEASE_MATERIA A "
        ." WHERE A.SEQ_CLIENTE =" . $idCliente .$periodoEnvio
        ." ORDER BY A.DATA_ENVIO_RELEASE ASC ";

//        echo $slq;
//        die;
        $query = $this->db->query($slq);
        return $query->row_array();

    }
    
    public function quantitativoRelease($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL, $veiculo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);

        $release ='';
  /*      $slq ="SELECT  A.SEQ_RELEASE as releasecodigo, DESC_RELEASE as descricaorelease, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." inner JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL)"
            ." AND DATE_FORMAT(DATA_MATERIA_PUB, '%Y%m%d') BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." inner JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente .$periodoEnvio
            ." GROUP BY A.SEQ_RELEASE,A.DESC_RELEASE "
            ." ORDER BY 3 DESC" ;
*/
        $slq =" SELECT A.SEQ_RELEASE as releasecodigo, DESC_RELEASE as descricaorelease, "
        ." (SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL "
        ." AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_RELEASE=B.SEQ_RELEASE";
        if (!empty($veiculo)) {
            $vecStr = '';
            foreach ($veiculo as $vec) {
                $vecStr .= "'$vec'" .', ';
            }
            $strVec = substr($vecStr, 0, -2);
           
            $slq .= ' AND B.TIPO_MATERIA IN ('.$strVec.') ';
        }
        $slq .=
        " AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL "
        ." OR B.SEQ_TV IS NOT NULL) AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim).")"
        ." AS quantidade "
        ." FROM RELEASE_MATERIA A "
        //." JOIN MATERIA M ON M.SEQ_RELEASE = A.SEQ_RELEASE "        
        ." WHERE A.SEQ_CLIENTE =" . $idCliente .$periodoEnvio;
        /* if (!empty($veiculo)) {
            $vecStr = '';
            foreach ($veiculo as $vec) {
                $vecStr .= "'$vec'" .', ';
            }
            $strVec = substr($vecStr, 0, -2);
           
            $slq .= ' AND M.TIPO_MATERIA IN ('.$strVec.') ';
        }   */      
        $slq .= " GROUP BY A.SEQ_RELEASE ORDER BY 3 DESC ";
        $query = $this->db->query($slq);
        return $query->result_array();

    }
    
    public function quantitativoReleaseB($seq_release,$datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL, $veiculo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);

        $slq =" SELECT A.SEQ_RELEASE as releasecodigo, DESC_RELEASE as descricaorelease, "
        ." (SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B  "
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_RELEASE=B.SEQ_RELEASE AND A.SEQ_RELEASE = ".$seq_release." AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_RADIO IS NOT NULL "
        ." OR B.SEQ_TV IS NOT NULL) AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim).")"
        ." AS quantidade "
        ." FROM RELEASE_MATERIA A "
        //." JOIN MATERIA M ON M.SEQ_RELEASE = A.SEQ_RELEASE "           
        ." WHERE A.SEQ_CLIENTE =" . $idCliente .$periodoEnvio;
        /* if (!empty($veiculo)) {
            $vecStr = '';
            foreach ($veiculo as $vec) {
                $vecStr .= "'$vec'" .', ';
            }
            $strVec = substr($vecStr, 0, -2);
           
            $slq .= ' AND M.TIPO_MATERIA IN ('.$strVec.') ';
        }  */       
        $slq .= " ORDER BY 3 DESC LIMIT 1 ";
//                echo $slq;
//        die;
        $query = $this->db->query($slq);
        return $query->result_array();

    }
    
    public function quantitativoArea($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        //."INNER JOIN MATERIA_CLIENTE_TIPO B ON B.SEQ_MATERIA=A.SEQ_MATERIA "
        $slq =" SELECT X.DESC_TIPO_MATERIA as descricao, "
            ."SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS positiva, "
            ."SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS negativa,  "
            ."SUM(X.QTD) AS areatotal FROM ( "
            ."SELECT C.DESC_TIPO_MATERIA,A.IND_AVALIACAO, 1 AS QTD "
            ."FROM MATERIA A  "
            ."INNER JOIN MATERIA_CLIENTE_TIPO B ON B.SEQ_MATERIA=A.SEQ_MATERIA "
            ."INNER JOIN TIPO_MATERIA C ON C.SEQ_TIPO_MATERIA=B.SEQ_TIPO_MATERIA "
            ."INNER JOIN PORTAL D ON D.SEQ_PORTAL=A.SEQ_PORTAL "
            ." WHERE "
            ." (A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL)"
            ." AND A.SEQ_CLIENTE =" . $idCliente
            ." AND (D.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." ) X GROUP BY DESC_TIPO_MATERIA ORDER BY 3 DESC";

        $query = $this->db->query($slq);
        return $query->result_array();

    }
    
    public function listaMateriaLinkVeiculo($datai=NULL,
        $dataf=NULL,
        $idCliente=NULL,
        $tipoMateria=NULL,
        $setores=NULL, $veiculo)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        
        $setor ='';
        if (!empty($setores)){
            $setor = " A.SEQ_SETOR IN (".$setores.") AND";
        }
        $tipo ='';
        if (!empty($tipoMateria)){
            $tipo = " and A.TIPO_MATERIA IN ('".str_replace(",","','",$tipoMateria)."')";
        }
        $sql ="SELECT A.SEQ_MATERIA, A.SEQ_SETOR, S.DESC_SETOR, date_format(A.DATA_MATERIA_PUB,'%d/%m/%Y') as DATA_PUB,"
        ." OLD_PASSWORD(A.SEQ_MATERIA) AS CHAVE,COALESCE(C.FANTASIA_VEICULO,D.NOME_PORTAL,F.NOME_RADIO,E.NOME_TV) AS NOME_VEICULO,"
        ." COALESCE(C.CIDADE_VEICULO,D.CIDADE_PORTAL,F.CIDADE_RADIO,E.CIDADE_TV) AS CIDADE_VEICULO, "
        ." TIT_MATERIA,CASE WHEN A.TIPO_MATERIA='I' THEN CONCAT(CONCAT(EDITORIA_MATERIA,'/'),PAGINA_MATERIA) WHEN A.TIPO_MATERIA='S' THEN ''"
        ." WHEN A.TIPO_MATERIA='T' THEN PROGRAMA_MATERIA WHEN A.TIPO_MATERIA='R' THEN PROGRAMA_MATERIA ELSE '' END SECAO_PROGRAMA,"
        ." CASE WHEN A.IND_AVALIACAO='P' THEN 'Positiva' WHEN A.IND_AVALIACAO='N' THEN 'Negativa' ELSE 'Neutra' END AS IND_AVALIACAO, "
        ." CASE WHEN A.IND_AVALIACAO='P' THEN '1' ELSE '' END AS POSITIVO, CASE WHEN A.IND_AVALIACAO='N' THEN '1' ELSE '' END AS NEGATIVO, "
        ." CASE WHEN A.IND_AVALIACAO='T' THEN '1' ELSE '' END AS NEUTRO, CASE WHEN A.TIPO_MATERIA='I' THEN 'IMPRESSO' WHEN A.TIPO_MATERIA='S' THEN 'INTERNET' "
        ." WHEN A.TIPO_MATERIA='T' THEN 'TV' WHEN A.TIPO_MATERIA='R' THEN 'RADIO' ELSE 'ND' END TIPO_MATERIA FROM MATERIA A"
        ." INNER JOIN SETOR S ON S.SEQ_SETOR = A.SEQ_SETOR LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL "
        ." LEFT JOIN TELEVISAO E ON E.SEQ_TV=A.SEQ_TV LEFT JOIN RADIO F ON F.SEQ_RADIO=A.SEQ_RADIO "
        ." WHERE A.SEQ_CLIENTE = ".$idCliente." and ".$setor." DATA_PUB_NUMERO between ".$periodoIni." and ".$periodoFim.$tipo
        ." AND A.TIPO_MATERIA = '".$veiculo."' ORDER BY 3,4 ";

       
//        echo $slq;
//        die;
        $query = $this->db->query($sql);
        return $query->result_array();

    }
    
    public function listaMateriaLink($datai=NULL,
        $dataf=NULL,
        $idCliente=NULL,
        $tipoMateria=NULL,
        $setores=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        
        $setor ='';
        if (!empty($setores)){
            $setor = " A.SEQ_SETOR IN (".$setores.") AND";
        }
        $tipo ='';
        if (!empty($tipoMateria)){
            $tipo = " and A.TIPO_MATERIA IN ('".str_replace(",","','",$tipoMateria)."')";
        }
        $sql ="SELECT A.SEQ_MATERIA, A.SEQ_SETOR, S.DESC_SETOR, date_format(A.DATA_MATERIA_PUB,'%d/%m/%Y') as DATA_PUB,"
        ." OLD_PASSWORD(A.SEQ_MATERIA) AS CHAVE,COALESCE(C.FANTASIA_VEICULO,D.NOME_PORTAL,F.NOME_RADIO,E.NOME_TV) AS NOME_VEICULO,"
        ." COALESCE(C.CIDADE_VEICULO,D.CIDADE_PORTAL,F.CIDADE_RADIO,E.CIDADE_TV) AS CIDADE_VEICULO, "
        ." TIT_MATERIA,CASE WHEN A.TIPO_MATERIA='I' THEN CONCAT(CONCAT(EDITORIA_MATERIA,'/'),PAGINA_MATERIA) WHEN A.TIPO_MATERIA='S' THEN ''"
        ." WHEN A.TIPO_MATERIA='T' THEN PROGRAMA_MATERIA WHEN A.TIPO_MATERIA='R' THEN PROGRAMA_MATERIA ELSE '' END SECAO_PROGRAMA,"
        ." CASE WHEN A.IND_AVALIACAO='P' THEN 'Positiva' WHEN A.IND_AVALIACAO='N' THEN 'Negativa' ELSE 'Neutra' END AS IND_AVALIACAO, "
        ." CASE WHEN A.IND_AVALIACAO='P' THEN '1' ELSE '' END AS POSITIVO, CASE WHEN A.IND_AVALIACAO='N' THEN '1' ELSE '' END AS NEGATIVO, "
        ." CASE WHEN A.IND_AVALIACAO='T' THEN '1' ELSE '' END AS NEUTRO, CASE WHEN A.TIPO_MATERIA='I' THEN 'IMPRESSO' WHEN A.TIPO_MATERIA='S' THEN 'INTERNET' "
        ." WHEN A.TIPO_MATERIA='T' THEN 'TV' WHEN A.TIPO_MATERIA='R' THEN 'RADIO' ELSE 'ND' END TIPO_MATERIA FROM MATERIA A"
        ." INNER JOIN SETOR S ON S.SEQ_SETOR = A.SEQ_SETOR LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL "
        ." LEFT JOIN TELEVISAO E ON E.SEQ_TV=A.SEQ_TV LEFT JOIN RADIO F ON F.SEQ_RADIO=A.SEQ_RADIO "
        ." WHERE A.SEQ_CLIENTE = ".$idCliente." and ".$setor." DATA_PUB_NUMERO between ".$periodoIni." and ".$periodoFim.$tipo
        ." ORDER BY 3,4 ";

       
//        echo $slq;
//        die;
        $query = $this->db->query($sql);
        return $query->result_array();

    }
    public function quantitativoComentario($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $slq =" SELECT X.DESC_TIPO_MATERIA as descricao, "
            ." SUM(QTD_COMENTARIO) AS totall FROM ( "
            ." SELECT C.DESC_TIPO_MATERIA,B.QTD_COMENTARIO "
            ."FROM MATERIA A  "
            ."INNER JOIN MATERIA_CLIENTE_TIPO B ON B.SEQ_MATERIA=A.SEQ_MATERIA "
            ."INNER JOIN TIPO_MATERIA C ON C.SEQ_TIPO_MATERIA=B.SEQ_TIPO_MATERIA "
            ."INNER JOIN PORTAL D ON D.SEQ_PORTAL=A.SEQ_PORTAL "
            ." WHERE (A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL) "
            ." AND A.SEQ_CLIENTE =" . $idCliente
            ." AND (D.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." ) X GROUP BY DESC_TIPO_MATERIA HAVING SUM(QTD_COMENTARIO)>0 ORDER BY 2 DESC";

        $query = $this->db->query($slq);
        return $query->result_array();

    }
    public function quantitativoReleaseSetor($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $veiculo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);

        $slq ="SELECT  A.SEQ_SETOR AS setorcodigo, S.SIG_SETOR as setor, "
            ." COUNT(DISTINCT A.SEQ_RELEASE) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." JOIN MATERIA M ON M.SEQ_RELEASE = A.SEQ_RELEASE "       
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." WHERE A.IND_PAUTA='N' AND  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio;
            if (!empty($veiculo)) {
                $vecStr = '';
                foreach ($veiculo as $vec) {
                    $vecStr .= "'$vec'" .', ';
                }
                $strVec = substr($vecStr, 0, -2);

                $slq .= ' AND M.TIPO_MATERIA IN ('.$strVec.') ';
            }
            $slq .= 
             " GROUP BY A.SEQ_SETOR, S.SIG_SETOR "
            ." ORDER BY 3 DESC" ;

       // echo $slq;
       // die;
        $query = $this->db->query($slq);
        return $query->result_array();

    }

    public function quantitativoReleasePauta($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $veiculo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);

        $slq ="SELECT  A.SEQ_SETOR AS pautacodigo, S.SIG_SETOR as pauta, "
            ." COUNT(DISTINCT A.SEQ_RELEASE) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            //." JOIN MATERIA M ON M.SEQ_RELEASE = A.SEQ_RELEASE "    
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." WHERE A.IND_PAUTA='S' AND A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio;
//        if (!empty($veiculo)) {
//            $vecStr = '';
//            foreach ($veiculo as $vec) {
//                $vecStr .= "'$vec'" .', ';
//            }
//            $strVec = substr($vecStr, 0, -2);
//           
//            $slq .= ' AND M.TIPO_MATERIA IN ('.$strVec.') ';
//        } 
        $slq .=    
             " GROUP BY A.SEQ_SETOR, S.SIG_SETOR "
            ." ORDER BY 3 DESC" ;

//        echo $slq;
//        die;
        $query = $this->db->query($slq);
        return $query->result_array();

    }

    public function quantitativoReleaseVeiculo($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);
        /*
        $slq ="SELECT  C.SEQ_PORTAL as sitecodigo, C.NOME_PORTAL as site, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." INNER JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." GROUP BY C.SEQ_PORTAL, C.NOME_PORTAL "
            ." ORDER BY 3 DESC" ;*/

        $slq = "SELECT X.sitecodigo, X.site, X.quantidade FROM ( SELECT C.SEQ_PORTAL AS sitecodigo, C.NOME_PORTAL AS site,  "
        ." (SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN RELEASE_MATERIA A  ON A.SEQ_RELEASE=B.SEQ_RELEASE "
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
        ." AND C.SEQ_PORTAL=B.SEQ_PORTAL AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
        ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
        ." ) AS quantidade FROM  PORTAL C WHERE C.SEQ_CLIENTE =".$idCliente." AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
        ." ORDER BY 3 DESC ) X WHERE X.quantidade>0 ORDER BY 3 DESC";

        $query = $this->db->query($slq);
//        echo $slq;
//        die();
        return $query->result_array();

    }
    
    public function quantitativoReleaseVeiculoRadio($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);
        /*
        $slq ="SELECT  C.SEQ_PORTAL as sitecodigo, C.NOME_PORTAL as site, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." INNER JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." GROUP BY C.SEQ_PORTAL, C.NOME_PORTAL "
            ." ORDER BY 3 DESC" ;*/

        $slq = "SELECT X.radiocodigo, X.radio, X.quantidade FROM ( SELECT C.SEQ_RADIO AS radiocodigo, C.NOME_RADIO AS radio,  "
        ." (SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN RELEASE_MATERIA A  ON A.SEQ_RELEASE=B.SEQ_RELEASE "
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
        ." AND C.SEQ_RADIO = B.SEQ_RADIO AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
        ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
        ." ) AS quantidade FROM  RADIO C WHERE C.SEQ_CLIENTE =".$idCliente." "
        ." ORDER BY 3 DESC ) X WHERE X.quantidade>0 ORDER BY 3 DESC";

        $query = $this->db->query($slq);

        return $query->result_array();

    }
    
    public function quantitativoReleasePorDiaRadio($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);
        /*
        $slq ="SELECT  C.SEQ_PORTAL as sitecodigo, C.NOME_PORTAL as site, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." INNER JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." GROUP BY C.SEQ_PORTAL, C.NOME_PORTAL "
            ." ORDER BY 3 DESC" ;*/

        $slq = "SELECT X.radiocodigo, X.radio, X.quantidade FROM ( SELECT C.SEQ_RADIO AS radiocodigo, C.NOME_RADIO AS radio,  "
        ." SUM((SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN RELEASE_MATERIA A  ON A.SEQ_RELEASE=B.SEQ_RELEASE "
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
        ." AND C.SEQ_RADIO = B.SEQ_RADIO AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
        ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoIni)
        ." )) AS quantidade FROM  RADIO C WHERE C.SEQ_CLIENTE =".$idCliente." "
        ." ORDER BY 3 DESC ) X WHERE X.quantidade>0 ORDER BY 3 DESC";

        $query = $this->db->query($slq);

        return $query->row_array();

    }
    
    public function quantitativoReleasePorDiaTV($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);
        /*
        $slq ="SELECT  C.SEQ_PORTAL as sitecodigo, C.NOME_PORTAL as site, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." INNER JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." GROUP BY C.SEQ_PORTAL, C.NOME_PORTAL "
            ." ORDER BY 3 DESC" ;*/

        $slq = "SELECT X.televisaocodigo, X.televisao, X.quantidade FROM ( SELECT C.SEQ_TV AS televisaocodigo, C.NOME_TV AS televisao,  "
        ." SUM((SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN RELEASE_MATERIA A  ON A.SEQ_RELEASE=B.SEQ_RELEASE "
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
        ." AND C.SEQ_TV = B.SEQ_TV AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
        ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoIni)
        ." )) AS quantidade FROM  TELEVISAO C WHERE C.SEQ_CLIENTE =".$idCliente." "
        ." ORDER BY 3 DESC ) X WHERE X.quantidade>0 ORDER BY 3 DESC";

        $query = $this->db->query($slq);

        return $query->row_array();

    }
    
    public function quantitativoReleasePorDiaImpresso($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);
        /*
        $slq ="SELECT  C.SEQ_PORTAL as sitecodigo, C.NOME_PORTAL as site, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." INNER JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." GROUP BY C.SEQ_PORTAL, C.NOME_PORTAL "
            ." ORDER BY 3 DESC" ;*/

        $slq = "SELECT  X.impressocodigo, X.impresso, X.quantidade FROM ( SELECT C.SEQ_VEICULO AS impressocodigo, C.NOME_VEICULO AS impresso,  "
        ." SUM((SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN RELEASE_MATERIA A  ON A.SEQ_RELEASE=B.SEQ_RELEASE "
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
        ." AND C.SEQ_VEICULO = B.SEQ_VEICULO AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
        ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoIni)
        ." )) AS quantidade FROM  VEICULO C WHERE C.SEQ_CLIENTE =".$idCliente." "
        ." ORDER BY 3 DESC ) X WHERE X.quantidade>0 ORDER BY 3 DESC";

        $query = $this->db->query($slq);

        return $query->row_array();

    }
    
    public function quantitativoReleaseVeiculoTV($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);
        /*
        $slq ="SELECT  C.SEQ_PORTAL as sitecodigo, C.NOME_PORTAL as site, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." INNER JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." GROUP BY C.SEQ_PORTAL, C.NOME_PORTAL "
            ." ORDER BY 3 DESC" ;*/

        $slq = "SELECT X.televisaocodigo, X.televisao, X.quantidade FROM ( SELECT C.SEQ_TV AS televisaocodigo, C.NOME_TV AS televisao,  "
        ." (SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN RELEASE_MATERIA A  ON A.SEQ_RELEASE=B.SEQ_RELEASE "
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
        ." AND C.SEQ_TV = B.SEQ_TV AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
        ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
        ." ) AS quantidade FROM  TELEVISAO C WHERE C.SEQ_CLIENTE =".$idCliente." "
        ." ORDER BY 3 DESC ) X WHERE X.quantidade>0 ORDER BY 3 DESC";

        $query = $this->db->query($slq);

        return $query->result_array();

    }
    
    public function quantitativoReleaseVeiculoImpresso($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND A.DATA BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);
        /*
        $slq ="SELECT  C.SEQ_PORTAL as sitecodigo, C.NOME_PORTAL as site, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." INNER JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." GROUP BY C.SEQ_PORTAL, C.NOME_PORTAL "
            ." ORDER BY 3 DESC" ;*/

        $slq = "SELECT  X.impressocodigo, X.impresso, X.quantidade FROM ( SELECT C.SEQ_VEICULO AS impressocodigo, C.NOME_VEICULO AS impresso,  "
        ." (SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN RELEASE_MATERIA A  ON A.SEQ_RELEASE=B.SEQ_RELEASE "
        ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
        ." A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
        ." AND C.SEQ_VEICULO = B.SEQ_VEICULO AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
        ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
        ." ) AS quantidade FROM  VEICULO C WHERE C.SEQ_CLIENTE =".$idCliente." "
        ." ORDER BY 3 DESC ) X WHERE X.quantidade>0 ORDER BY 3 DESC";

        $query = $this->db->query($slq);

        return $query->result_array();

    }
    
    public function quantitativoReleaseSemPublicacao($datai=NULL,$dataf=NULL,$idCliente=NULL,$grupo=NULL,$datae=NULL,$dataef=NULL, $tipo=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $periodoEnvIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datae);
        $periodoEnvFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataef);

        $periodoEnvio = " AND DATE_FORMAT(A.DATA_ENVIO_RELEASE, '%Y%m%d') BETWEEN " . trim($periodoEnvIni) . " AND " . trim($periodoEnvFim);
        /*
        $slq ="SELECT  C.SEQ_PORTAL as sitecodigo, C.NOME_PORTAL as site, "
            ." SUM(CASE WHEN B.SEQ_MATERIA IS NOT NULL THEN 1 ELSE 0 END) AS quantidade "
            ." FROM RELEASE_MATERIA A "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." INNER JOIN MATERIA B ON B.SEQ_RELEASE=A.SEQ_RELEASE AND "
            ." (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            ." INNER JOIN PORTAL C ON C.SEQ_PORTAL=B.SEQ_PORTAL AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." WHERE  A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." GROUP BY C.SEQ_PORTAL, C.NOME_PORTAL "
            ." ORDER BY 3 DESC" ;*/

        $slq = "SELECT X.sitecodigo, X.site, X.quantidade FROM ( SELECT C.SEQ_PORTAL AS sitecodigo, C.NOME_PORTAL AS site,  "
            ." (SELECT COUNT(B.SEQ_MATERIA) FROM MATERIA B INNER JOIN RELEASE_MATERIA A  ON A.SEQ_RELEASE=B.SEQ_RELEASE "
            ." WHERE ". (!empty($tipo)? " B.SEQ_TIPO_MATERIA=".$tipo." AND ":"" )
            . " A.SEQ_CLIENTE =" . $idCliente.$periodoEnvio
            ." AND C.SEQ_PORTAL=B.SEQ_PORTAL AND (B.SEQ_VEICULO IS NOT NULL OR B.SEQ_PORTAL IS NOT NULL OR B.SEQ_RADIO IS NOT NULL OR B.SEQ_TV IS NOT NULL) "
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim)
            .") AS quantidade FROM  PORTAL C WHERE C.SEQ_CLIENTE =".$idCliente." AND (C.GRUPO_PORTAL=".$grupo." OR 0=".$grupo.")"
            ." ORDER BY 3 DESC ) X WHERE X.quantidade=0";

//        echo $slq;
//        die;
        $query = $this->db->query($slq);
        return $query->result_array();

    }

    public function quantitativoVeiculoRadioTempo($datai=NULL,$dataf=NULL,$idCliente=NULL,$excluirSetor=NULL,$setores=NULL, $tags)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $setor ='';
        // if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
        //     $setor = " A.SEQ_SETOR NOT IN (".$setores.") AND ";
        // } else if (!empty($setores) and empty($excluirSetor)){
        //     $setor = " A.SEQ_SETOR IN (".$setores.") AND ";
        // }
        if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
            $array_set = explode(',',$setores);
            if (count($array_set)===1) {
                $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)=0  AND";
            } else {
                foreach($array_set as $set) {
                    $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)=0 AND"; 
                }
            }
            
        } else if (!empty($setores) and empty($excluirSetor)){
            $array_set = explode(',',$setores);
            if (count($array_set)===1) {
                $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)>0  AND";
            } else {
                $linhas =count($array_set);
                $flag = 1;
                $setor ="(";
                foreach($array_set as $set) {
                    $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)>0 "; 
                    if ($flag < $linhas){
                        $setor .= "OR";
                    }
                    $flag++;
                }
                $setor .=") AND";
            }
        }
        
        if (!empty($tags)) {
            $lista_tag = explode(',', $tags);
            $where = '';
            foreach ($lista_tag as $tag) {
                $where .= "upper(A.PC_MATERIA) LIKE '%" . strtoupper($tag) . "%' or ";
            }
            $condicao_tag = ' AND ('.substr($where, 0, -4).')';
        } else {
            $condicao_tag = '';
        }

            $slq = "SELECT X.DESCRICAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
                . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
                . "(SELECT C.NOME_RADIO AS DESCRICAO,A.IND_AVALIACAO, SUM(B.SEC_ARQUIVO) as QTD FROM MATERIA A "
                . " INNER JOIN ANEXO B ON B.SEQ_MATERIA=A.SEQ_MATERIA INNER JOIN RADIO C ON A.SEQ_RADIO=C.SEQ_RADIO "
                . "WHERE ".$setor." FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='R' ".$condicao_tag." AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
                . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente
                . " GROUP BY C.NOME_RADIO,A.IND_AVALIACAO ) X GROUP BY DESCRICAO ORDER BY 5 DESC ";

        $query = $this->db->query($slq);
        return $query->result_array();

    }

    public function quantitativoSuperRadio($datai,$dataf,$idCliente=NULL,$veiculo,$portal,$origens,$avaliacoes,$texto,
                                           $setor,$radio,$tipo,$tv,$tipoMat,
                                         $horair=NULL,$horafr=NULL,$datai2=NULL,$dataf2=NULL,$release=NULL,
                                           $grupo=NULL,$usuario=NULL,
                                         $isrelease=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $periodoIni2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai2);
            $periodoFim2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf2);

            $periodoIni2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
            $periodoFim2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);
        }

        $flagFiltro=false;
        $where ='';
        if(!empty($tipoMat)){
            $where .= " AND A.TIPO_MATERIA='". $tipoMat."'";
            $flagFiltro=true;
        }
        if(!empty($release)){
            $where .= " AND A.SEQ_RELEASE=". $release;
            $flagFiltro=true;
        }
        if(!empty($isrelease)){
            $where .= " AND A.IND_RELEASE='". $isrelease."'";
            $flagFiltro=true;
        }
        if(!empty($texto)){
            $where .= " AND A.PC_MATERIA LIKE '%". $texto."%'";
            $flagFiltro=true;
        }
        if(!empty($setor)){
            $where .= " AND A.SEQ_SETOR=". $setor;
            $flagFiltro=true;
        } else{
            $where .= " AND A.SEQ_SETOR<>83";
            $flagFiltro=true;
        }
        if(!empty($veiculo)){
            $where .= " AND A.SEQ_VEICULO=". $veiculo;
            $flagFiltro=true;
        }
        if(!empty($portal)){
            $where .= " AND A.SEQ_PORTAL=". $portal;
            $flagFiltro=true;
        }
        if(!empty($radio)){
            $where .= " AND A.SEQ_RADIO=". $radio;
            $flagFiltro=true;
        }
        if(!empty($usuario)){
            $where .= " AND A.SEQ_USUARIO='". $usuario."'";
            $flagFiltro=true;
        }
        if(!empty($tv)){
            $where .= " AND A.SEQ_TV=". $tv;
            $flagFiltro=true;
        }
        if(!empty($tipo)){
            $where .= " AND A.SEQ_TIPO_MATERIA=". $tipo;
            $flagFiltro=true;
        }
        if(!empty($origens)){
            $where .= " AND A.IND_CLASSIFICACAO='".$origens."'";
            $flagFiltro=true;
        }
        if(!empty($avaliacoes)){
            $where .= " AND A.IND_AVALIACAO IN (".$avaliacoes.")";
            $flagFiltro=true;
        }

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $where .= " AND DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%Y%m%d%H%i') BETWEEN " . trim($periodoIni2) . " AND " . trim($periodoFim2);
        }



        $sql =" SELECT TRIM(X.DESCRICAO) AS radio, X.PROGRAMA_MATERIA as programa, X.VALOR as vlunitario ,"
            ." SUM(X.QTM_MAT) AS insercao,"
            ." SUM(X.VALOR*X.QTM_MAT) AS vltotal,"
            ." SUM(X.QTD) AS tempo FROM "
            ." (SELECT C.NOME_RADIO AS DESCRICAO,A.PROGRAMA_MATERIA, "
            ." IFNULL(P.DESCRITIVO, 'Nao Definido') AS DESCRITIVO, "
            ." IFNULL(P.VALOR,0) as VALOR,"
            ." COUNT(DISTINCT A.SEQ_MATERIA) AS QTM_MAT, "
            ." SUM(B.SEC_ARQUIVO) as QTD "
            ." FROM MATERIA A "
            ." INNER JOIN ANEXO B ON B.SEQ_MATERIA=A.SEQ_MATERIA "
            ." INNER JOIN RADIO C ON A.SEQ_RADIO=C.SEQ_RADIO "
            ." LEFT JOIN PRECO P ON P.SEQ_PRECO=A.SEQ_PRECO "
            ." WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 ".$where
            ." AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            ." AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL )"
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =". $idCliente
            ." GROUP BY C.NOME_RADIO,A.PROGRAMA_MATERIA,P.DESCRITIVO,P.VALOR ) X "
            ." GROUP BY DESCRICAO,PROGRAMA_MATERIA,VALOR ORDER BY 5 DESC";


        $query = $this->db->query($sql);
        return $query->result_array();

    }
    public function quantitativoSuperTvSetorVeiculo($datai,$dataf,$idCliente=NULL,$veiculo,$portal,$origens,$avaliacoes,$texto,
                                        $setor,$radio,$tipo,$tv,$tipoMat,
                                        $horair=NULL,$horafr=NULL,$datai2=NULL,$dataf2=NULL,$release=NULL,
                                        $grupo=NULL,$usuario=NULL,
                                        $isrelease=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $periodoIni2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai2);
            $periodoFim2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf2);

            $periodoIni2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
            $periodoFim2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);
        }

        $flagFiltro=false;
        $where ='';
        if(!empty($tipoMat)){
            $where .= " AND A.TIPO_MATERIA='". $tipoMat."'";
            $flagFiltro=true;
        }
        if(!empty($release)){
            $where .= " AND A.SEQ_RELEASE=". $release;
            $flagFiltro=true;
        }
        if(!empty($isrelease)){
            $where .= " AND A.IND_RELEASE='". $isrelease."'";
            $flagFiltro=true;
        }
        if(!empty($texto)){
            $where .= " AND A.PC_MATERIA LIKE '%". $texto."%'";
            $flagFiltro=true;
        }
        if(!empty($setor)){
            $where .= " AND A.SEQ_SETOR=". $setor;
            $flagFiltro=true;
        } else{
            $where .= " AND A.SEQ_SETOR<>83";
            $flagFiltro=true;
        }
        if(!empty($veiculo)){
            $where .= " AND A.SEQ_VEICULO=". $veiculo;
            $flagFiltro=true;
        }
        if(!empty($portal)){
            $where .= " AND A.SEQ_PORTAL=". $portal;
            $flagFiltro=true;
        }
        if(!empty($radio)){
            $where .= " AND A.SEQ_RADIO=". $radio;
            $flagFiltro=true;
        }
        if(!empty($usuario)){
            $where .= " AND A.SEQ_USUARIO='". $usuario."'";
            $flagFiltro=true;
        }
        if(!empty($tv)){
            $where .= " AND A.SEQ_TV=". $tv;
            $flagFiltro=true;
        }
        if(!empty($tipo)){
            $where .= " AND A.SEQ_TIPO_MATERIA=". $tipo;
            $flagFiltro=true;
        }
        if(!empty($origens)){
            $where .= " AND A.IND_CLASSIFICACAO='".$origens."'";
            $flagFiltro=true;
        }
        if(!empty($avaliacoes)){
            $where .= " AND A.IND_AVALIACAO IN (".$avaliacoes.")";
            $flagFiltro=true;
        }

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $where .= " AND DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%Y%m%d%H%i') BETWEEN " . trim($periodoIni2) . " AND " . trim($periodoFim2);
        }
        $sql ="SELECT S.SEQ_SETOR as idsetor, S.DESC_SETOR as nomesetor, C.SEQ_TV as idveiculo, C.NOME_TV AS nomeveiculo "
            ." FROM MATERIA A "
            ." INNER JOIN ANEXO B ON B.SEQ_MATERIA=A.SEQ_MATERIA "
            ." INNER JOIN TELEVISAO C ON A.SEQ_TV=C.SEQ_TV "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." LEFT JOIN PRECO P ON P.SEQ_PRECO=A.SEQ_PRECO "
            ." WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 ".$where
            ." AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            ." AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL )"
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =". $idCliente
            ." GROUP BY S.SEQ_SETOR, S.DESC_SETOR, C.SEQ_TV, C.NOME_TV ";

        $query = $this->db->query($sql);
        return $query->result_array();

    }
    public function quantitativoSuperRadioSetorVeiculo($datai,$dataf,$idCliente=NULL,$veiculo,$portal,$origens,$avaliacoes,$texto,
                                                    $setor,$radio,$tipo,$tv,$tipoMat,
                                                    $horair=NULL,$horafr=NULL,$datai2=NULL,$dataf2=NULL,$release=NULL,
                                                    $grupo=NULL,$usuario=NULL,
                                                    $isrelease=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $periodoIni2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai2);
            $periodoFim2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf2);

            $periodoIni2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
            $periodoFim2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);
        }

        $flagFiltro=false;
        $where ='';
        if(!empty($tipoMat)){
            $where .= " AND A.TIPO_MATERIA='". $tipoMat."'";
            $flagFiltro=true;
        }
        if(!empty($release)){
            $where .= " AND A.SEQ_RELEASE=". $release;
            $flagFiltro=true;
        }
        if(!empty($isrelease)){
            $where .= " AND A.IND_RELEASE='". $isrelease."'";
            $flagFiltro=true;
        }
        if(!empty($texto)){
            $where .= " AND A.PC_MATERIA LIKE '%". $texto."%'";
            $flagFiltro=true;
        }
        if(!empty($setor)){
            $where .= " AND A.SEQ_SETOR=". $setor;
            $flagFiltro=true;
        } else{
            $where .= " AND A.SEQ_SETOR<>83";
            $flagFiltro=true;
        }
        if(!empty($veiculo)){
            $where .= " AND A.SEQ_VEICULO=". $veiculo;
            $flagFiltro=true;
        }
        if(!empty($portal)){
            $where .= " AND A.SEQ_PORTAL=". $portal;
            $flagFiltro=true;
        }
        if(!empty($radio)){
            $where .= " AND A.SEQ_RADIO=". $radio;
            $flagFiltro=true;
        }
        if(!empty($usuario)){
            $where .= " AND A.SEQ_USUARIO='". $usuario."'";
            $flagFiltro=true;
        }
        if(!empty($tv)){
            $where .= " AND A.SEQ_TV=". $tv;
            $flagFiltro=true;
        }
        if(!empty($tipo)){
            $where .= " AND A.SEQ_TIPO_MATERIA=". $tipo;
            $flagFiltro=true;
        }
        if(!empty($origens)){
            $where .= " AND A.IND_CLASSIFICACAO='".$origens."'";
            $flagFiltro=true;
        }
        if(!empty($avaliacoes)){
            $where .= " AND A.IND_AVALIACAO IN (".$avaliacoes.")";
            $flagFiltro=true;
        }

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $where .= " AND DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%Y%m%d%H%i') BETWEEN " . trim($periodoIni2) . " AND " . trim($periodoFim2);
        }
        $sql ="SELECT S.SEQ_SETOR as idsetor, S.DESC_SETOR as nomesetor, C.SEQ_RADIO as idveiculo, C.NOME_RADIO AS nomeveiculo "
            ." FROM MATERIA A "
            ." INNER JOIN ANEXO B ON B.SEQ_MATERIA=A.SEQ_MATERIA "
            ." INNER JOIN RADIO C ON A.SEQ_RADIO=C.SEQ_RADIO "
            ." INNER JOIN SETOR S ON S.SEQ_SETOR=A.SEQ_SETOR "
            ." LEFT JOIN PRECO P ON P.SEQ_PRECO=A.SEQ_PRECO "
            ." WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 ".$where
            ." AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            ." AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL )"
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =". $idCliente
            ." GROUP BY S.SEQ_SETOR, S.DESC_SETOR, C.SEQ_RADIO, C.NOME_RADIO ";

        $query = $this->db->query($sql);
        return $query->result_array();

    }

    public function quantitativoSuperTv($datai,$dataf,$idCliente=NULL,$veiculo,$portal,$origens,$avaliacoes,$texto,
                                           $setor,$radio,$tipo,$tv,$tipoMat,
                                           $horair=NULL,$horafr=NULL,$datai2=NULL,$dataf2=NULL,$release=NULL,
                                           $grupo=NULL,$usuario=NULL,
                                           $isrelease=NULL)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $periodoIni2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai2);
            $periodoFim2 = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf2);

            $periodoIni2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
            $periodoFim2 .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);
        }

        $flagFiltro=false;
        $where ='';
        if(!empty($tipoMat)){
            $where .= " AND A.TIPO_MATERIA='". $tipoMat."'";
            $flagFiltro=true;
        }
        if(!empty($release)){
            $where .= " AND A.SEQ_RELEASE=". $release;
            $flagFiltro=true;
        }
        if(!empty($isrelease)){
            $where .= " AND A.IND_RELEASE='". $isrelease."'";
            $flagFiltro=true;
        }
        if(!empty($texto)){
            $where .= " AND A.PC_MATERIA LIKE '%". $texto."%'";
            $flagFiltro=true;
        }
        if(!empty($setor)){
            $where .= " AND A.SEQ_SETOR=". $setor;
            $flagFiltro=true;
        } else{
            $where .= " AND A.SEQ_SETOR<>83";
            $flagFiltro=true;
        }
        if(!empty($veiculo)){
            $where .= " AND A.SEQ_VEICULO=". $veiculo;
            $flagFiltro=true;
        }
        if(!empty($portal)){
            $where .= " AND A.SEQ_PORTAL=". $portal;
            $flagFiltro=true;
        }
        if(!empty($radio)){
            $where .= " AND A.SEQ_RADIO=". $radio;
            $flagFiltro=true;
        }
        if(!empty($usuario)){
            $where .= " AND A.SEQ_USUARIO='". $usuario."'";
            $flagFiltro=true;
        }
        if(!empty($tv)){
            $where .= " AND A.SEQ_TV=". $tv;
            $flagFiltro=true;
        }
        if(!empty($tipo)){
            $where .= " AND A.SEQ_TIPO_MATERIA=". $tipo;
            $flagFiltro=true;
        }
        if(!empty($origens)){
            $where .= " AND A.IND_CLASSIFICACAO='".$origens."'";
            $flagFiltro=true;
        }
        if(!empty($avaliacoes)){
            $where .= " AND A.IND_AVALIACAO IN (".$avaliacoes.")";
            $flagFiltro=true;
        }

        if(!empty($horair) and !empty($horafr) and !empty($datai2) and !empty($dataf2)) {
            $where .= " AND DATE_FORMAT(MATERIA.DATA_MATERIA_CAD, '%Y%m%d%H%i') BETWEEN " . trim($periodoIni2) . " AND " . trim($periodoFim2);
        }



        $sql =" SELECT X.PROGRAMA_MATERIA as programa, X.VALOR as vlunitario ,"
            ." SUM(X.QTM_MAT) AS insercao,"
            ." SUM(X.VALOR*X.QTM_MAT) AS vltotal,"
            ." SUM(X.QTD) AS tempo FROM "
            ." (SELECT C.NOME_TV AS DESCRICAO,A.PROGRAMA_MATERIA, "
            ." IFNULL(P.DESCRITIVO, 'Nao Definido') AS DESCRITIVO, "
            ." IFNULL(P.VALOR,0) as VALOR,"
            ." COUNT(DISTINCT A.SEQ_MATERIA) AS QTM_MAT, "
            ." SUM(B.SEC_ARQUIVO) as QTD "
            ." FROM MATERIA A "
            ." INNER JOIN ANEXO B ON B.SEQ_MATERIA=A.SEQ_MATERIA "
            ." INNER JOIN TELEVISAO C ON A.SEQ_TV=C.SEQ_TV "
            ." LEFT JOIN PRECO P ON P.SEQ_PRECO=A.SEQ_PRECO "
            ." WHERE FIND_IN_SET(83, A.SEQ_SETOR)=0 ".$where
            ." AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            ." AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL )"
            ." AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =". $idCliente
            ." GROUP BY C.NOME_TV,A.PROGRAMA_MATERIA,P.DESCRITIVO,P.VALOR ) X "
            ." GROUP BY PROGRAMA_MATERIA,VALOR ORDER BY 5 DESC";


        $query = $this->db->query($sql);
        return $query->result_array();

    }


    public function quantitativoVeiculoTvTempo($datai=NULL,$dataf=NULL,$idCliente=NULL,$excluirSetor=NULL,$setores=NULL, $tags)
    {
        $periodoIni = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $datai);
        $periodoFim = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3$2$1', $dataf);

        $setor ='';
        // if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
        //     $setor = " A.SEQ_SETOR NOT IN (".$setores.") AND ";
        // } else if (!empty($setores) and empty($excluirSetor)){
        //     $setor = " A.SEQ_SETOR IN (".$setores.") AND";
        // }
        if (!empty($excluirSetor) and $excluirSetor=='S' and !empty($setores)){
            $array_set = explode(',',$setores);
            if (count($array_set)===1) {
                $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)=0  AND";
            } else {
                foreach($array_set as $set) {
                    $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)=0 AND"; 
                }
            }
            
        } else if (!empty($setores) and empty($excluirSetor)){
            $array_set = explode(',',$setores);
            if (count($array_set)===1) {
                $setor = " FIND_IN_SET(".$setores.", A.SEQ_SETOR)>0  AND";
            } else {
                $linhas =count($array_set);
                $flag = 1;
                $setor ="(";
                foreach($array_set as $set) {
                    $setor .= " FIND_IN_SET(".$set.", A.SEQ_SETOR)>0 "; 
                    if ($flag < $linhas){
                        $setor .= "OR";
                    }
                    $flag++;
                }
                $setor .=") AND";
            }
        }
        if (!empty($tags)) {
            $lista_tag = explode(',', $tags);
            $where = '';
            foreach ($lista_tag as $tag) {
                $where .= "upper(PC_MATERIA) LIKE '%" . strtoupper($tag) . "%' or ";
            }
            $condicao_tag = ' AND ('.substr($where, 0, -4).')';
        } else {
            $condicao_tag = '';
        }
        $slq = "SELECT X.DESCRICAO, SUM(IF(X.IND_AVALIACAO='P',X.QTD,0)) AS POSITIVO, SUM(IF(X.IND_AVALIACAO='N',X.QTD,0)) AS NEGATIVO, "
            . "SUM(IF(X.IND_AVALIACAO='T',X.QTD,0)) AS NEUTRO, SUM(X.QTD) AS TOTAL FROM "
            . "(SELECT C.NOME_TV AS DESCRICAO,A.IND_AVALIACAO, SUM(B.SEC_ARQUIVO) as QTD FROM MATERIA A "
            . " INNER JOIN ANEXO B ON B.SEQ_MATERIA=A.SEQ_MATERIA INNER JOIN TELEVISAO C ON A.SEQ_TV=C.SEQ_TV "
            . "WHERE ".$setor." FIND_IN_SET(83, A.SEQ_SETOR)=0 AND A.TIPO_MATERIA='T' AND ((A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) "
            . "AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL ) AND DATA_PUB_NUMERO BETWEEN " . trim($periodoIni) . " AND " . trim($periodoFim) . " AND A.SEQ_CLIENTE =" . $idCliente
            .$condicao_tag. " GROUP BY C.NOME_TV,A.IND_AVALIACAO ) X GROUP BY DESCRICAO ORDER BY 5 DESC ";

        $query = $this->db->query($slq);
        return $query->result_array();

    }

    public function quantitativoUsuarioDetalhe($datai=NULL,$dataf=NULL,$horair=NULL,$horafr=NULL,$idUsuario=NULL
        ,$tipo=NULL,$idCliente=NULL)
    {
        $periodoIni = preg_replace("#(\d{2})\/(\d{2})\/(\d{4})#", "$3$2$1", $datai);
        $periodoFim = preg_replace("#(\d{2})\/(\d{2})\/(\d{4})#", "$3$2$1", $dataf);

        $periodoIni .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horair);
        $periodoFim .= preg_replace("#(\d{2}):(\d{2})#", "$1$2", $horafr);
        $whereCliente='';
        if (!empty($idCliente) and $idCliente>0){
            $whereCliente=" AND A.SEQ_CLIENTE =".$idCliente;
        }
        $whereTipo='';
        if (!empty($tipo) and $tipo!='Q'){
            $whereTipo=" AND A.TIPO_MATERIA ='".$tipo."'";
        }

        $slq = "SELECT A.* "
            ." FROM MATERIA A INNER JOIN USUARIO B ON A.SEQ_USUARIO=B.SEQ_USUARIO LEFT JOIN VEICULO C ON A.SEQ_VEICULO=C.SEQ_VEICULO "
            ." LEFT JOIN PORTAL D ON A.SEQ_PORTAL=D.SEQ_PORTAL WHERE B.LOGIN_USUARIO<>'admin' AND B.SEQ_USUARIO=".$idUsuario.$whereTipo
            ." AND (A.SEQ_VEICULO IS NOT NULL OR A.SEQ_PORTAL IS NOT NULL OR A.SEQ_RADIO IS NOT NULL OR A.SEQ_TV IS NOT NULL) AND A.SEQ_SETOR IS NOT NULL AND A.IND_AVALIACAO IS NOT NULL "
            ." AND DATE_FORMAT(DATA_MATERIA_CAD, '%Y%m%d%H%i') BETWEEN ".trim($periodoIni)." AND ".trim($periodoFim).(!empty($idCliente)? :'').$whereCliente
            ." ORDER BY SEQ_MATERIA DESC";
        $query = $this->db->query($slq);
        return $query->result_array();

    }

    public function getOrdem($id) {
        $this->db->select('(IFNULL(MAX(ORDEM_ARQUIVO),0)+1) AS ORDEM ');
        $this->db->where('SEQ_MATERIA', $id);
        $query = $this->db->get('ANEXO');
        return $query->row()->ORDEM;
    }

    public function inserirAnexo($id,$data_os=NULL)
    {
        $this->db->select('(IFNULL(MAX(ORDEM_ARQUIVO),0)+1) AS ORDEM ');
        $this->db->where('SEQ_MATERIA', $id);
        $query = $this->db->get('ANEXO');

        $data_os = array_merge($data_os, array('ORDEM_ARQUIVO'=>$query->row()->ORDEM));

        $this->db->insert('ANEXO', $data_os);
        return $this->db->insert_id();
    }
    function contaClienteByMonitoramento($id)
    {
        $this->db->select("SEQ_CLIENTE");
        $this->db->where("FIND_IN_SET('".$id."',LISTA_MONITORAMENTO )>0");
        $this->db->from('CLIENTE');
        return count($this->db->get()->result_array());
    }
    function contaKlipboxPendente()
    {
        $this->db->select("SEQ_MATERIA");
        $this->db->where("ORIGEM","K");
        $this->db->from('MATERIA');
        return count($this->db->get()->result_array());
    }
    function clienteByMonitoramento($id)
    {
        $this->db->select("SEQ_CLIENTE");
        $this->db->where("FIND_IN_SET('".$id."',LISTA_MONITORAMENTO )>0");
        $this->db->from('CLIENTE');
        return $this->db->get();
    }
    function existeProcessamento($idUsuario)
    {
        $this->db->select("SEQ_DOWNLOAD");
        $this->db->where("SEQ_USUARIO",$idUsuario);
        $this->db->where("IND_ARQUIVO","P");
       $this->db->where("DATE_FORMAT(DATA_SOLICITACAO,'%Y%m%d')=DATE_FORMAT(SYSDATE(),'%Y%m%d')");
        $this->db->from('DOWNLOAD');
        return $this->db->get()->result_array();
    }

}
?>

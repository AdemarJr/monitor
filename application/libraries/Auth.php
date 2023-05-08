<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth
{
    private $CI;
    private $dbo;
    public function __construct(){
        $this->CI=&get_instance();
//        $this->dbo = $this->CI->load->database('dbCache',true);
    }

    function CheckAuth($module,$classe,$metodo)
    {
        /*
        * Criando uma inst�ncia do CodeIgniter para poder acessar
        * banco de dados, sessionns, models, etc...
        */
//        $this->CI=&get_instance();

        /**
         * Buscando a classe e metodo da tabela sys_metodos
         */
        $array = array('MOD_METODO' => $module,'CLA_METODO' => $classe, 'NOM_METODO' => $metodo);
        $this->CI->db->where($array);
        $query = $this->CI->db->get('METODO');
        $result = $query->result();

        $alteraSenha =  $this->CI->session->userdata('alteraSenha');
        $perfilUsuario =  $this->CI->session->userdata('perfilUsuario');
        $eSelecao   = $this->CI->session->userdata('eSelecao');


        // Se este metodo ainda n�o existir na tabela sera cadastrado
        if(count($result)==0){
            $data = array(
                'MOD_METODO' => $module ,
                'CLA_METODO' => $classe ,
                'NOM_METODO' => $metodo ,
                'IDE_METODO' => $classe .  '/' . $metodo,
                'PRIV_METODO' => 1
            );
            if($perfilUsuario=='ROLE_ADM'){
                $this->CI->db->insert('METODO', $data);
            }
            redirect(base_url('principal/naoencontrada'), 'refresh');
        }
        //Se ja existir tras as informacoes de publico ou privado
        else{
            if ($alteraSenha=='S' and $result[0]->PRIV_METODO==1)
                redirect(base_url('principal/senha'), 'refresh');
            if ($eSelecao==true and $result[0]->PRIV_METODO==1)
                redirect(base_url('principal/cliente'), 'refresh');
 
            if($result[0]->PRIV_METODO==0){
                // Escapa da validacao e mostra o metodo.
                return false;
            }
            else{

                // Se for privado, verifica o login
                $nome = $this->CI->session->userdata('nomeUsuario');
                $logged_in = $this->CI->session->userdata('logado');
                $email = $this->CI->session->userdata('emailUsuario');
                $id_usuario =  $this->CI->session->userdata('idUsuario');
                $dominioSession = $this->CI->session->userdata('dominio');
                $dominio = 'monitor';
                if (stripos($_SERVER['REQUEST_URI'],'monitor-dsv')==false){
                    $dominio = 'monitor-dsv';
                }


                $id_sys_metodos = $result[0]->SEQ_METODO;

                // Se o usuario estiver logado vai verificar se tem permissao na tabela.
                if($nome && $logged_in && $id_usuario && $dominioSession==$dominio){

                    $array = array('SEQ_METODO' => $id_sys_metodos, 'SEQ_USUARIO' => $id_usuario);
                    $this->CI->db->where($array);
                    $query2 = $this->CI->db->get('VW_PERMISSAO');
                    $result2 = $query2->result();

                    // Se n�o vier nenhum resultado da consulta, manda para p�gina de
                    // usuario sem permiss�o.
                    if(count($result2)==0 and $perfilUsuario!='ROLE_ADM'){
                        redirect(base_url('principal/sempermissao'), 'refresh');
                    }
                    else{
                        return true;
                    }
                }
                // Se n�o estiver logado, sera redirecionado para o login.
                else{
//                    $this->CI->session->sess_destroy();
                    redirect(base_url('login?target=').$this->CI->uri->uri_string(), 'refresh');
                }
            }
        }
    }

    /**
     * M�todo auxiliar para autenticar entradas em menu.
     * N�o faz parte do plugin como um todo.
     */
    function CheckMenu($module,$classe,$metodo){
        $perfilUsuario =  $this->CI->session->userdata('perfilUsuario');

        if($perfilUsuario=='ROLE_ADM'){
           return 1;
        }

        $permissoes = $this->CI->session->userdata('permissoes');
        foreach ($permissoes as $index => $valor) {
            if($valor['CLA_METODO']==$classe and
                $valor['NOM_METODO']==$metodo and
                $valor['MOD_METODO']==$module){
                return 1;
            }
        }
        return 0;


//        $sql = "SELECT SQL_CACHE count(*) as found FROM VW_PERMISSAO WHERE SEQ_USUARIO = ".$this->CI->session->userdata('idUsuario')." AND CLA_METODO = '".$classe ."' AND NOM_METODO = '".$metodo."' AND MOD_METODO = '".$module."'";
//        $query = $this->CI->db->query($sql);
//        $result = $query->result();
//        $resultado = $result[0]->found;
//        return $resultado;
    }
}
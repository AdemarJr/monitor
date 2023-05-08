<?php

class MY_Model extends CI_Model {
    protected $active_group;
    protected $monitor; // <------ ADICIONE 

    public function __construct() {
        parent::__construct();
        $this->connect();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function connect($active_group = 'default'){
        $this->active_group = $active_group;
        $db = $this->load->database($active_group, TRUE);
        $this->db = $db;

        // ADICIONE ISTO ABAIXO
        $db2 = $this->load->database('monitor', TRUE);
        $this->monitor = $db2;
    }

}
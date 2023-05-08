		<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Logout extends MY_Controller {

	function __construct() {
		parent::__construct();
	}
	function index() {
		$this->inserirAuditoria('LOGOUT-SISTEMA','A','Sair do Sistema');
       $this->session->sess_destroy();
	   redirect('login');
    }
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fpdftest extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
	//	$this->load->library('fpdf');

		$this->fpdf->SetFont('Arial','B',16);
		$this->fpdf->Cell(40,10,'Hello World!');
		
		echo $this->fpdf->Output('hello_world.pdf','D');
	}
}

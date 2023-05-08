<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Name:  FPDF
* 
* Author: Jd Fiscus
* 	 	  jdfiscus@gmail.com
*         @iamfiscus
*          
*
* Origin API Class: http://www.fpdf.org/
* 
* Location: http://github.com/iamfiscus/Codeigniter-FPDF/
*          
* Created:  06.22.2010 
* 
* Description:  This is a Codeigniter library which allows you to generate a PDF with the FPDF library
* 
*/

class Fpdf_monitor {
		
	public function __construct() {
		
		require_once APPPATH.'/third_party/fpdf/fpdf.php';
		
		$pdf = new FPDF();
		$pdf->AddPage();
		
		$CI =& get_instance();
		$CI->fpdf = $pdf;
		
	}

	//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
	function hex2dec($couleur = "#000000"){
		$R = substr($couleur, 1, 2);
		$rouge = hexdec($R);
		$V = substr($couleur, 3, 2);
		$vert = hexdec($V);
		$B = substr($couleur, 5, 2);
		$bleu = hexdec($B);
		$tbl_couleur = array();
		$tbl_couleur['R']=$rouge;
		$tbl_couleur['V']=$vert;
		$tbl_couleur['B']=$bleu;
		return $tbl_couleur;
	}
	
}
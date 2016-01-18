<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Nilai extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class GeneratePass extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	public function index()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('home');
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["apptitle"]="Generate Password Buat Yang Sudah Bayar";
				$this->load->view("v_generatepass.php",$data);
			} else {
				redirect('home');
			}
		}
	}
	
	function process_generatepass(){
	$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
	if(empty($login)){
		redirect('user/login');
	}  else {
		$this->load->model('generatepass_model','',true);
		$this->generatepass_model->generate_pass();
		redirect('home');
	}
	
	}
}
?>
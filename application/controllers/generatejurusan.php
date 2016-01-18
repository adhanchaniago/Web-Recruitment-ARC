<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class generatejurusan extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	public function index()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["apptitle"]="Generate Password Buat Yang Sudah Bayar";
				$this->load->view("v_generatejurusan.php",$data);
			} else {
				redirect('home');
			}
		}
	}
	
	function process_generatejurusan(){
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		}  else {
			$this->load->model('generatejurusan_model','',true);
			$this->generatejurusan_model->generate_jurusan();
		}
	
	}
}	
?>
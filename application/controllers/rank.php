<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Rank extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	public function index()
	{	
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('rank_model','',true);
			$data["query_result"] = $this->rank_model->get_friendssortbyrank();
			$data["apptitle"] = "Ranking";
			$this->load->view("v_rank",$data);
		}
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Home extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	/*
	public function index(){
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
			//home versi guest
			$data["isLogin"] = false;
			$n=5;
			$data["isAdmin"] = false;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'news/page/';
			$this->load->model('news_model','',true);
			$config['total_rows'] = ceil(($this->news_model->getjrecord())/$n);
			$config['per_page'] = 1;
			$this->pagination->initialize($config);
				
			$data['base_url'] = site_url().'news/page/';
			$data["pagination"] = $this->pagination->create_links();
			$data["query_result"] = $this->news_model->get_newspage(0,$n);
			$data["apptitle"] = "Home";
			$data["pnumbers"] = ceil($config['total_rows']/$n);
			$this->load->view("v_news_pagination",$data);
		} else {
			//home untuk yang sudah login
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();
			
			$rs = $this->user_model->isValid();
				if(count($rs)>0){
				$data["query_result"] = $this->user_model->getNilai();
				$data["query_result2"] = $this->user_model->getUserData();
				$this->load->view('v_home_loggedin',$data);
			} else {
				//nanti ganti jadi user not valid
				$this->load->view("v_notallowed");
			}
			
		}
	}*/
	public function index()
	{
		$data["isAdmin"] = false;
		
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["isAdmin"] = true;
			}
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();
			$n=5;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'materi/page/';
			$this->load->model('materi_model','',true);
			$config['total_rows'] = ceil(($this->materi_model->getjrecord())/$n);
			$config['per_page'] = 1;
			$this->pagination->initialize($config);
			
			$data['base_url'] = site_url().'materi/page/';
			$data["pagination"] = $this->pagination->create_links();
			$data["query_result"] = $this->materi_model->get_materipage(0,$n);
			$data["apptitle"] = "Materi";
			$data["pnumbers"] = ceil($config['total_rows']/$n);
			$this->load->view("v_materi_pagination",$data);
		}
	}
	
	function page($p=0){
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		
		if($p<0 || !is_numeric($p)){
			redirect('materi/page');
		} else {
			$data["isAdmin"] = false;
			
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				redirect('user/login');

			} else {
				$this->load->model('user_model','',true);
				$tipe = $this->user_model->get_AccType();
				if($tipe == "admin"){
					$data["isAdmin"] = true;
				}
			}
			
			$n=5;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'materi/page/';
			$this->load->model('materi_model','',true);
			$config['total_rows'] = ceil(($this->materi_model->getjrecord())/$n);
			$config['per_page'] = 1;
			$this->pagination->initialize($config);
			
			$data['base_url'] = site_url().'materi/page/';
			$data["pagination"] = $this->pagination->create_links();
			$data["query_result"] = $this->materi_model->get_materipage($p,$n);
			$data["apptitle"] = "materi | Page ".$p;
			$data["pnumbers"] = ceil($config['total_rows']/$n);
			$this->load->view("v_materi_pagination",$data);
		}
	}

}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class News extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	public function index()
	{
		
		
		$data["isAdmin"] = false;
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$data["isLogin"] = true;
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();
			//$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["isAdmin"] = true;
			}
		}
		
		$n=5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'news/page/';
		$this->load->model('news_model','',true);
		$config['total_rows'] = ceil(($this->news_model->getjrecord())/$n);
		$config['per_page'] = 1;
		$this->pagination->initialize($config);
			
		$data['base_url'] = site_url().'news/page/';
		$data["pagination"] = $this->pagination->create_links();
		$data["query_result"] = $this->news_model->get_newspage(0,$n);
		$data["apptitle"] = "News";
		$data["pnumbers"] = ceil($config['total_rows']/$n);
		$this->load->view("v_news_pagination",$data);

	}
	
	function page($p=0){
	
		if($p<0 || !is_numeric($p)){
			redirect('user/login');
		} else {
			
			$data["isAdmin"] = false;
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				$data["isLogin"] = false;
			} else {
				$data["isLogin"] = true;
				$this->load->model('user_model','',true);
				$tipe = $this->user_model->get_AccType();
				if($tipe == "admin"){
					$data["isAdmin"] = true;
				}
				$this->user_model->redirectUser();
			}
			
			
			
			$n=5;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'news/page/';
			$this->load->model('news_model','',true);
			$config['total_rows'] = ceil(($this->news_model->getjrecord())/$n);
			$config['per_page'] = 1;
			$this->pagination->initialize($config);
			
			$data['base_url'] = site_url().'news/page/';
			$data["pagination"] = $this->pagination->create_links();
			$data["query_result"] = $this->news_model->get_newspage($p,$n);
			$data["apptitle"] = "News | Page ".$p;
			$data["pnumbers"] = ceil($config['total_rows']/$n);
			$this->load->view("v_news_pagination",$data);
		}
	}
	
	public function view($id=NULL){
		
		$data["isAdmin"] = false;
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$data["isLogin"] = true;
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["isAdmin"] = true;
			}
			$this->user_model->redirectUser();
		}

		
		
		$this->load->model('news_model','',true);
		$rs=$this->news_model->view_news($id);
		$data["query_result"]=$rs;
		$row = $rs->row();
		if((count($row)>0) && ($row->published)){
			$data["apptitle"]=$row->title;
			$this->load->view("v_news.php",$data);
		} else {
			$this->load->view("v_notfound.php",$data);
		}
	}

	public function edit($id=0){
		$this->load->library('uri');
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["apptitle"]="Edit Berita";
				//
				$id = $this->uri->segment(3);
				$this->load->model('news_model','',true);
				//apakah valid
				$rs = $this->news_model->isValid($id);
				if(count($rs)>0){
					$data["query_result"]=$this->news_model->get_thisnews($id);
					$this->load->view("v_editnews.php",$data);
				} else {
					//nanti ganti jadi not found
					$this->load->view("v_notallowed");
				}
		
			} else {
				$this->load->view("v_notallowed");
			}
		}
	}
	
	function update($id)
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();
			$newsTitle = $this->input->post('title');
			$newsType = $this->input->post('type');
			$newsContent = $this->input->post('content');
			$newsStatus = $this->input->post('status');
			
			$this->load->model('news_model','',true);
			$this->news_model->update($id,$newsTitle,$newsContent,$newsStatus);
			redirect('news');
		}
	}
}
?>
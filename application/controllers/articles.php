<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Articles extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	public function index()
	{
	/*
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
			$config['base_url'] = site_url().'articles/page/';
			$this->load->model('articles_model','',true);
			$config['total_rows'] = ceil(($this->articles_model->getjrecord())/$n);
			$config['per_page'] = 1;
			$this->pagination->initialize($config);
			
			$data['base_url'] = site_url().'articles/page/';
			$data["pagination"] = $this->pagination->create_links();
			$data["query_result"] = $this->articles_model->get_articlespage(0,$n);
			$data["apptitle"] = "Articles";
			$data["pnumbers"] = ceil($config['total_rows']/$n);
			$this->load->view("v_articles_pagination",$data);
		}*/

	redirect('home');
	}
	
	function page($p=0){
	/*
		if($p<0 || !is_numeric($p)){
			redirect('articles/page');
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
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();
			$n=5;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'articles/page/';
			$this->load->model('articles_model','',true);
			$config['total_rows'] = ceil(($this->articles_model->getjrecord())/$n);
			$config['per_page'] = 1;
			$this->pagination->initialize($config);
			
			$data['base_url'] = site_url().'articles/page/';
			$data["pagination"] = $this->pagination->create_links();
			$data["query_result"] = $this->articles_model->get_articlespage($p,$n);
			$data["apptitle"] = "Articles | Page ".$p;
			$data["pnumbers"] = ceil($config['total_rows']/$n);
			$this->load->view("v_articles_pagination",$data);
		}*/
	redirect('home');
	}
	
	public function view($id){
	
		$data["isAdmin"] = false;
		$data["isTugas"] = false;
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
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		$this->load->model('articles_model','',true);
		$rs=$this->articles_model->view_article($id);
		$data["query_result"]=$rs;
		$row = $rs->row();
		if(count($row)>0){
			$data["apptitle"]=$row->title;
			$this->load->view("v_article.php",$data);
		} else {
			$this->load->view("v_notfound.php",$data);
		}
	}

	public function create_new()
	{
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["apptitle"]="New Article";
				$this->load->view("v_newArticle.php",$data);
			} else {
				$this->load->view("v_notallowed");
			}
		}
	}
	
	function new_article()
	{
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		
		$articleTitle = $this->input->post('title');
		$articleType = $this->input->post('type');
		$articleContent = $this->input->post('content');
		$articleStatus = $this->input->post('status'); 
		$this->load->model('articles_model','',true);
		$this->articles_model->create_article($articleTitle,$articleType,$articleContent,$articleStatus);
		if($articleType == 'materi')
			redirect(site_url('materi'));
		else 
			redirect(site_url('news'));
	}
	
}
?>
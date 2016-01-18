<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Materi extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	public function index()
	{
		$data["isAdmin"] = false;
		
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('home');
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
		} else if($p==0){
			redirect('materi');
		} else {
			$data["isAdmin"] = false;
			
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				
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
			$data["apptitle"] = "Materi | Page ".$p;
			$data["pnumbers"] = ceil($config['total_rows']/$n);
			$this->load->view("v_materi_pagination",$data);
		}
	}
	
	public function view($id=NULL){
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		
		$data["isAdmin"] = false;
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["isAdmin"] = true;
			}
		}
		$this->load->model('materi_model','',true);
		$rs=$this->materi_model->view_materi($id);
		$data["query_result"]=$rs;
		$row = $rs->row();
		if((count($row)>0)&&($row->published)){
			$data["apptitle"]=$row->title;
			$this->load->view("v_materi.php",$data);
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
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["apptitle"]="Edit Materi";
				//
				$id = $this->uri->segment(3);
				$this->load->model('materi_model','',true);
				//apakah valid
				$rs = $this->materi_model->isValid($id);
				if(count($rs)>0){
					$data["query_result"]=$this->materi_model->get_thismateri($id);
					$this->load->view("v_editmateri.php",$data);
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
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		$materiTitle = $this->input->post('title');
		$materiContent = $this->input->post('content');
		$materiStatus = $this->input->post('status');
		
		$this->load->model('materi_model','',true);
		$this->materi_model->update($id,$materiTitle,$materiContent,$materiStatus);
		redirect('materi');
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Friends extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	public function index()
	{	
			redirect('friends/display');
			/*$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				redirect('login');
			} else {
				$n=2;
				$this->load->library('pagination');
				$config['base_url'] = site_url().'friends/full_name/';
				$this->load->model('friends_model','',true);
				$query = $this->friends_model->getjrecord();
				$row = $query->row();
				$count = $row->a;
				$config['total_rows'] = ceil($count/$n);
				$config['per_page'] = 1;
				$this->pagination->initialize($config);
				
				$data['base_url'] = site_url().'friends/full_name/';
				$data["pagination"] = $this->pagination->create_links();
				$data["query_result"] = $this->friends_model->get_friendspage(0,$n);
				$data["apptitle"] = "Friends";
				$data["pnumbers"] = ceil($config['total_rows']/$n);
				//untuk pencarian
				$data["jurusan_options"] = $this->friends_model->jurusan_options();
				$data["fakultas_options"] = $this->friends_model->fakultas_options();
				$this->load->view("v_friends",$data);
			}*/
		
	}
	
	function display($orderby='full_name',$p=1){
		if($p<0 || !is_numeric($p) || (($orderby!='full_name') && ($orderby!='nim') && ($orderby!='jurusan') && ($orderby!='fakultas'))){
			redirect('/friends/display');
		} else {
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				redirect('login');
			} else {
				$this->input->load_query($query_id);
				$query_array = array(
					'name' => $this->input->get('name'),
					'jurusan' => $this->input->get('jurusan'),
					'fakultas' => $this->input->get('fakultas')
				);
			
				
				$n=10;
				$this->load->library('pagination');
				$config['base_url'] = site_url().'friends/display/'.$query_id.'/'.$orderby;
				$this->load->model('friends_model','',true);
				$query = $this->friends_model->getjrecord($query_array);
				$row = $query->row();
				$count = $row->a;
				$config['total_rows'] = ceil($count/$n);
				$config['per_page'] = 1;
				$this->pagination->initialize($config);
				
				$data['base_url'] = site_url().'friends/display/';
				$data["pagination"] = $this->pagination->create_links();
				$data["query_result"] = $this->friends_model->get_friendspage($p,$n,$orderby);
				$data["apptitle"] = "Friends | Page".$p;
				$data["pnumbers"] = ceil($config['total_rows']/$n);

				$message = $this->session->flashdata('message');
				if (isset($message)){
					$data["jurusan_options"] = $message;
				} else {
					$data["jurusan_options"] = $this->friends_model->jurusan_options('z');
				}
				$name = $this->session->flashdata('name');
				if (isset($name)){
					$data["name"] = $name;
				} else {
					$data["name"] = '';
				}
				$fakultas = $this->session->flashdata('fakultas');
				if (isset($name)){
					$data["fakultas"] = $fakultas;
				} else {
					$data["fakultas"] = '';
				}
				$data["fakultas_options"] = $this->friends_model->fakultas_options();
				$data["sortby"] = $orderby;
				$this->load->view("v_friends",$data);
			}
		}
	}
	
	function getjurusan(){
		$this->load->model('friends_model','',true);
		
		$this->message = $this->friends_model->jurusan_options($this->input->get('fakultas') );
		$data["name"] = $this->input->get('name') ;
		$data["fakultas"] = $this->input->get('fakultas') ;
		$link = $this->input->get('url');
		//$this->display();
		
		$this->session->set_flashdata('message', $this->friends_model->jurusan_options($this->input->get('fakultas')));
		$this->session->set_flashdata('name', $data["name"]);
		$this->session->set_flashdata('fakultas', $data["fakultas"]);
		redirect($link, 'refresh'); 
	}
	/*
	function full_name($p=1){
		if($p<0 || !is_numeric($p))	{
			redirect('/friends/');
		} else {
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				redirect('login');
			} else {
				$n=2;
				$this->load->library('pagination');
				$config['base_url'] = site_url().'friends/full_name/';
				$this->load->model('friends_model','',true);
				$query = $this->friends_model->getjrecord();
				$row = $query->row();
				$count = $row->a;
				$config['total_rows'] = ceil($count/$n);
				$config['per_page'] = 1;
				$this->pagination->initialize($config);
				
				$data['base_url'] = site_url().'friends/page/';
				$data["pagination"] = $this->pagination->create_links();
				$data["query_result"] = $this->friends_model->get_friendsbyfullname($p,$n);
				$data["apptitle"] = "Friends | Page".$p;
				$data["pnumbers"] = ceil($config['total_rows']/$n);
				$this->load->view("v_friends",$data);
			}
		}
	}
	
	function nim($p=1){
		if($p<0 || !is_numeric($p))	{
			redirect('/friends/');
		} else {
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				redirect('login');
			} else {
				$n=2;
				$this->load->library('pagination');
				$config['base_url'] = site_url().'friends/nim/';
				$this->load->model('friends_model','',true);
				$query = $this->friends_model->getjrecord();
				$row = $query->row();
				$count = $row->a;
				$config['total_rows'] = ceil($count/$n);
				$config['per_page'] = 1;
				$this->pagination->initialize($config);
				
				$data['base_url'] = site_url().'friends/page/';
				$data["pagination"] = $this->pagination->create_links();
				$data["query_result"] = $this->friends_model->get_friendsbynim($p,$n);
				$data["apptitle"] = "Friends | Page".$p;
				$data["pnumbers"] = ceil($config['total_rows']/$n);
				$this->load->view("v_friends",$data);
			}
		}
	}
	
	
	function jurusan($p=1){
		if($p<0 || !is_numeric($p))	{
			redirect('/friends/');
		} else {
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				redirect('login');
			} else {
				$n=2;
				$this->load->library('pagination');
				$config['base_url'] = site_url().'friends/jurusan/';
				$this->load->model('friends_model','',true);
				$query = $this->friends_model->getjrecord();
				$row = $query->row();
				$count = $row->a;
				$config['total_rows'] = ceil($count/$n);
				$config['per_page'] = 1;
				$this->pagination->initialize($config);
				
				$data['base_url'] = site_url().'friends/page/';
				$data["pagination"] = $this->pagination->create_links();
				$data["query_result"] = $this->friends_model->get_friendsbyjurusan($p,$n);
				$data["apptitle"] = "Friends | Page".$p;
				$data["pnumbers"] = ceil($config['total_rows']/$n);
				$this->load->view("v_friends",$data);
			}
		}
	}
	
	function view($nim){
		
		if($nim<0 || !is_numeric($nim))	{
			redirect('/friends/');
		}
		
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('login');
		} else {
			$this->load->model('friends_model','',true);
			$rs=$this->friends_model->view_friend($nim);
			$row = $rs->row();
			if(count($row)>0){
				$data["query_result"]=$rs;
				$data["jumlah"] = count($rs);
				$data["apptitle"]=$row->full_name;
				$this->load->view("v_friend.php",$data);
			} else {
				//ganti dengan not found
				$this->load->view("v_notfound");
			}
		}
	}
	*/
	function search(){
		$query_array = array(
		'name' => $this->input->post('name'),
		'jurusan' => $this->input->post('jurusan'),
		'fakultas' => $this->input->post('fakultas')
		);
		
		$query_id = $this->input->save_query($query_array);
		
		redirect("friends/display/$query_id");
	}
}
?>
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
	}
	
	function display($orderby='full_name',$p=1){
		if($p<0 || !is_numeric($p) || (($orderby!='full_name') && ($orderby!='nim') && ($orderby!='jurusan') && ($orderby!='fakultas'))){
			redirect('/friends/display');
		} else {
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				redirect('user/login');
			} else {
				$this->load->model('user_model','',true);
				$this->user_model->redirectUser();
				$full_name = $this->input->get('name');
				$fakultas = $this->input->get('fakultas');
				$jurusan = $this->input->get('jurusan');
				
				$search = "";
				if(($full_name != '') || ($fakultas != '') || ($jurusan != '')){
					$search .= "?";
				}
				
				if($full_name != ''){
					$search .= "name=".$full_name;
				}
				if($fakultas != ''){
					if($full_name != '')
						$search.="&";
					$search .= "fakultas=".$fakultas;
				}
				if($jurusan != ''){
					if(($full_name != '') || ($fakultas != ''))
						$search.="&";
					$search .= "jurusan=".$jurusan;
				}
				$data["search"] = $search;
				$data["page"] = $p;
				$n=20;//YANG HARUS DIGANTI UNTUK MENENTUKAN JUMLAH PER HALAMAN, bukan di $config['per_page'] karena library pagination sudah dimodifikasi
				$this->load->library('pagination');
				$config['base_url'] = site_url().'friends/display/'.$orderby;
				$this->load->model('friends_model','',true);
				$query = $this->friends_model->getjrecord($full_name,$fakultas,$jurusan);
				$row = $query->row();
				$count = $row->a;
				$config['total_rows'] = ceil($count/$n);
				$config['per_page'] = 1;
				$this->pagination->initialize($config);
				
				$data['base_url'] = site_url().'friends/display/';
				$data["pagination"] = $this->pagination->create_links();
				$data["query_result"] = $this->friends_model->get_friendspage($p,$n,$orderby,'ASC',$full_name,$fakultas,$jurusan);
				$data["apptitle"] = "Friends | Page".$p;
				$data["pnumbers"] = ceil($count/$n);
				//untuk pencarian
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
	/*
	function getjurusan(){
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		$this->load->model('friends_model','',true);
		
		$this->message = $this->friends_model->jurusan_options($this->input->get('fakultas') );
		$data["name"] = $this->input->get('name2') ;
		$data["fakultas"] = $this->input->get('fakultas2');
		
		$name = $this->input->get('name') ;
		$fakultas = $this->input->get('fakultas') ;
		$jurusan = $this->input->get('jurusan') ;
		
		
		$link = $this->input->get('url');
		//$this->display();
		if($fakultas!=""){
			$link .= "&fakultas=";
			$link .= $fakultas;
		}
		
		if($jurusan!=""){
			$link .= "&jurusan=";
			$link .= $jurusan;
		}
		
		$this->session->set_flashdata('message', $this->friends_model->jurusan_options($this->input->get('fakultas2')));
		$this->session->set_flashdata('name', $data["name"]);
		$this->session->set_flashdata('fakultas', $data["fakultas"]);
		redirect($link, 'refresh'); 
	}*/
	
	function view($nim){
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		
		if($nim<0 || !is_numeric($nim))	{
			redirect('/friends/');
		}
		
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('friends_model','',true);
			$rs=$this->friends_model->view_friend($nim);
			$row = $rs->row();
			if((count($row)>0) && ($row->tipe == 'cakru')){
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
	
	public function jimmy($fakultas=NULL){
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();
		$this->load->model('friends_model','',true);
		$jurusan_options = $this->friends_model->jurusan_options($fakultas);
		$attrjurusan = 'id="jurusan"';
		echo "<tr><td>";
		echo form_label('Jurusan:','jurusan');
		echo "</td><td>&nbsp;";
		echo form_dropdown('jurusan',$jurusan_options,set_value('jurusan'),$attrjurusan);
		echo "</td></tr>";
	}
}
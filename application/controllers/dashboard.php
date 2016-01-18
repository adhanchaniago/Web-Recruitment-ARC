<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
class Dashboard extends CI_Controller {

	public function index()
	{
		$data["isAdmin"] = false;
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$this->load->view('v_notallowed');	
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe != "admin"){
				$this->load->view('v_notallowed');
			} else {
				//jika admin
				$this->load->view('v_dashboard');
			}
		}
		
	}
	
	/*
	function process_register()
	{
		$this->load->model('register_model','',true);
		$rs = $this->register_model->insert($this->input);
		
	}*/
	
	function _crud_output_user($output = null){
		
		$data["isAdmin"] = false;
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$this->load->view('v_notallowed');	
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe != "admin"){
				$this->load->view('v_notallowed');
			} else {
				//jika admin
				$this->load->view('v_adminpanel_user',$output);
			}
		}
		
	
	}
	
	function display_users()
	{
	
		$data["isAdmin"] = false;
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$this->load->view('v_notallowed');	
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe != "admin"){
				$this->load->view('v_notallowed');
			} else {
				//jika admin
				$this->load->library('grocery_CRUD');
				$crud = new grocery_CRUD();
				$crud->set_theme('flexigrid');
				$crud->set_table('user');
				$crud->set_subject('Add User');
				
				$crud->columns('nim','full_name','no_hp','tipe');
				$crud->display_as('NIM','Nama Lengkap','No.Handphone','Tipe');
				$crud->required_fields('');
				$crud->fields('nim','full_name','no_hp','tipe','address','addressbdg','email','photo_added','foto','pilihan_divisi','passChanged','tgllahir','fakultas','profile_complete','fakultas','jurusan');
			
				$output = $crud->render();
				$this->_crud_output_user($output);
			}
		}
		
	}
	
	function display_tugas()
	{
		$data["isAdmin"] = false;
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$this->load->view('v_notallowed');	
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe != "admin"){
				$this->load->view('v_notallowed');
			} else {
				//jika admin
				$this->load->library('grocery_CRUD');
				$crud = new grocery_CRUD();
				$crud->set_theme('flexigrid');
				$crud->set_table('task');
				$crud->set_subject('Add User');
				
				$crud->columns('id','title','author','publishtime','published','content','deadline','format','createtime','maxsize');
				$crud->display_as('id','title','author','publishtime','published','content','deadline','format','createtime','maxsize');
				$crud->required_fields('');
				$crud->fields('id','title','author','publishtime','published','content','deadline','format','createtime','maxsize');
			
				$output = $crud->render();
				$this->_crud_output_user($output);
			}
		}
	}
	
	function display_materi()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$this->load->view('v_notallowed');	
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe != "admin"){
				$this->load->view('v_notallowed');
			} else {
				//jika admin
				$this->load->library('grocery_CRUD');
				$crud = new grocery_CRUD();
				$crud->set_theme('flexigrid');
				$crud->set_table('materi');
				$crud->set_subject('Add User');
				
				$crud->columns('id','title','author','createtime','publishtime','published','content');
				$crud->display_as('id','title','author','createtime','publishtime','published','content');
				$crud->required_fields('');
				$crud->fields('id','title','author','createtime','publishtime','published','content');
			
				$output = $crud->render();
				$this->_crud_output_user($output);
			}
		}
	}
	
	function display_news()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$this->load->view('v_notallowed');	
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe != "admin"){
				$this->load->view('v_notallowed');
			} else {
				//jika admin
				$this->load->library('grocery_CRUD');
				$crud = new grocery_CRUD();
				$crud->set_theme('flexigrid');
				$crud->set_table('news');
				$crud->set_subject('Add User');
				
				$crud->columns('id','title','author','createtime','publishtime','published','content');
				$crud->display_as('id','title','author','createtime','publishtime','published','content');
				$crud->required_fields('');
				$crud->fields('id','title','author','createtime','publishtime','published','content');
			
				$output = $crud->render();
				$this->_crud_output_user($output);
			}
		}
	}

	function edit_nilai($id)
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$this->load->view('v_notallowed');	
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe != "admin"){
				$this->load->view('v_notallowed');
			} else {
				$data["id"]=$id;
				$data["query_result"]=$this->user_model->getAllNilai();
				$this->load->view("v_editnilai",$data);
			}
		}
	}

	function update_nilai($id){
		//var_dump($this->input->post());
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		
		if(empty($login)){
			$this->load->view('v_notallowed');	
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe != "admin"){
		 	$this->load->view('v_notallowed');
			} else {
				//pertemuan
				$pertemuan = $this->input->post('pertemuan');
				foreach ($pertemuan as $nim => $nilai) {
					$this->user_model->updateNilai($id,"pertemuan",$nilai,$nim);
				}

				//tugas
				$tugas = $this->input->post('tugas');
				foreach ($tugas as $nim => $nilai) {
					$this->user_model->updateNilai($id,"tugas",$nilai,$nim);
				}

				//tugas bonus
				$tugasbonus = $this->input->post('tugasbonus');
				foreach ($tugasbonus as $nim => $nilai) {
					$this->user_model->updateNilai($id,"tugasbonus",$nilai,$nim);
				}
				redirect('dashboard/edit_nilai/'.$id);
			}
		}
		//foreach ($)
		// $login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		// if(empty($login)){
		// 	$this->load->view('v_notallowed');	
		// } else {
		// 	$this->load->model('user_model','',true);
		// 	$tipe = $this->user_model->get_AccType();
		// 	if($tipe != "admin"){
		// 		$this->load->view('v_notallowed');
		// 	} else {
				
		// 		$jumlah_pertemuan=$this->input->post('');
				
		// 		while($i<=$jumlah_pertemuan){
		// 			$pertemuan_id="pertemuan".$i;
		//     		$tugas_id="tugas".$i;
	 //    			$tugasbonus_id="tugasbonus".$i;
		// 			$nilai_pertemuan=$this->input-post($pertemuan_id);
		// 			$this->user_model->updateNilai($pertemuan_id,$nim,$nilai_pertemuan);
		// 			$nilai_tugas=$this->input-post($tugas_id);
		// 			$this->user_model->updateNilai($tugas_id,$nim,$nilai_tugas);
		// 			$nilai_bonus=$this->input-post($tugasbonus_id);
		// 			$this->user_model->updateNilai($tugasbonus_id,$nim,$nilai_bonus);
		// 			$i++;
		// 		}
		// 	}
		// }	
	}

	public function updateTotal(){
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$this->load->view('v_notallowed');	
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe != "admin"){
		 	$this->load->view('v_notallowed');
			} else {
				$this->user_model->updateTotal();
			}
		}
		redirect('dashboard');
	}
}
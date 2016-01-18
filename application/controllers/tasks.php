<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Tasks extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	private function loadview(){
		
	}
	
	public function index()
	{
		$data["isAdmin"] = false;
		
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();

			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["isAdmin"] = true;
			}
			$n=5;
			$this->load->library('pagination');
			$config['base_url'] = site_url().'tasks/page/';
			$this->load->model('tasks_model','',true);
			$config['total_rows'] = ceil(($this->tasks_model->getjrecord())/$n);
			$config['per_page'] = 1;
			$this->pagination->initialize($config);
			
			$data['base_url'] = site_url().'tasks/page/';
			$data["pagination"] = $this->pagination->create_links();
			$data["query_result"] = $this->tasks_model->get_taskspage(0,$n);
			$data["apptitle"] = "Tugas";
			$data["pnumbers"] = ceil($config['total_rows']/$n);
			$this->load->view("v_tasks_pagination",$data);
		}
	}
	
	function page($p=0){
	
		if($p<0 || !is_numeric($p)){
			redirect('tasks/page');
		} else {
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();


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
			$config['base_url'] = site_url().'tasks/page/';
			$this->load->model('tasks_model','',true);
			$config['total_rows'] = ceil(($this->tasks_model->getjrecord())/$n);
			$config['per_page'] = 1;
			$this->pagination->initialize($config);
			
			$data['base_url'] = site_url().'tasks/page/';
			$data["pagination"] = $this->pagination->create_links();
			$data["query_result"] = $this->tasks_model->get_taskspage($p,$n);
			$data["apptitle"] = "Tasks | Page ".$p;
			$data["pnumbers"] = ceil($config['total_rows']/$n);
			$this->load->view("v_tasks_pagination",$data);
		}
	}
	
	public function view($id=NULL){
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();


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
		
		$data["action"] = "Upload";
		$data['error'] = isset($_SESSION["uploadtaskerror"])?$_SESSION["uploadtaskerror"]:'';
		$this->load->model('tasks_model','',true);
		$rs=$this->tasks_model->view_task($id);
		$data["query_result"]=$rs;
		$row = $rs->row();
		if(count($row)>0){
			if($row->published){
				$file_format = $row->format;
				$data["script"] = "tasks/upload/".$id."/";
				$data["tugasid"] = $id;
				$data["formatfile"] = $file_format;
				$rs2=$this->tasks_model->get_uploadedtask($id);
				$row2 = $rs2->row();
				if(count($row2)>0){
					$data["hasUpload"] = true;
					$data["filelink"] = $this->config->base_url().($row2->file);
				} else {
					$data["hasUpload"] = false;
				}
				$data["apptitle"]=$row->title;
				$this->load->view("v_task.php",$data);
				unset($_SESSION["uploadtaskerror"]);
			} else {
				redirect('tasks');
			}
			
		} else {
			$this->load->view("v_notfound.php",$data);
			
		}
	}
	
	function upload($id){
		$this->load->model('user_model','',true);
		$this->user_model->redirectUser();


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
		
		//upload
		$data["action"] = "Upload";
		
		//mengambil format dan filesize
		$this->load->model('tasks_model','',true);
		$rs=$this->tasks_model->view_task($id);
		$data["query_result"]=$rs;
		$row = $rs->row();
		$file_format = $row->format;
		$config['allowed_types'] = $file_format;
		$maxsize = $row->maxsize;
		$config['max_size'] = $maxsize;
		$deadline = $row->deadline;

		//$data["script"] = "tasks/upload/".$id."/";
		$data["apptitle"]=$row->title;
		$folder = "tugas" . $id;
		$config['upload_path'] = "./$folder";
		
		$this->load->model('user_model','',true);
		$rs = $this->user_model->getuserdata();
		$row = $rs->row();
		$nim = $row->nim;
		$nombre = pathinfo($_FILES['userfile']['name']);
		//echo $nombre['extension'];
		$config['file_name'] = "tugas".$id."-".$nim.".".$nombre['extension'];
		//echo $config['file_name'];
		$this->load->library('upload',$config);
		$this->upload->overwrite = true;
		
		if(count($row)>0){
			
			if(!$this->upload->do_upload()){
				$error = $this->upload->display_errors();
				$_SESSION["uploadtaskerror"] = $error;
				$data['error'] = isset($_SESSION["uploadtaskerror"])?$_SESSION["uploadtaskerror"]:'';
				$data["pagetitle"] = "Upload Tugas";
			$data["script"] = "tasks/upload/".$id."/";
			$data["action"] = "Upload";
				$this->load->view("v_task",$data);
			} else {
				//mengecek apakah user pernah mengupload tugas
				$rs2=$this->tasks_model->get_uploadedtask($id);
				$row2 = $rs2->row();
				if(count($row2)>0){
					$hasUpload = true;
				} else {
					$hasUpload = false;
				}
				//$data = array('upload_data' => $this->upload->data());
				//redirect($this->uri->uri_string());
				//update database
				$this->load->model('tasks_model','',true);
				$filelocation = $folder."/".$config['file_name'];
				if(strtotime($deadline)>strtotime('now')){
					if($hasUpload){
						$this->tasks_model->update($id);
					} else {
						$this->tasks_model->insert($filelocation,$id);
					}
					$_SESSION["uploadtaskerror"] = "";
				} else {
					$_SESSION["uploadtaskerror"] = "UPLOAD TUGAS Terlambat !";
					//$data['error'] = isset($_SESSION["uploadtaskerror"])?$_SESSION["uploadtaskerror"]:'';
					//$this->load->view("v_task",$data);
				}
			}
			redirect('tasks/view/'.$id);
		} else{
			redirect('v_notallowed');
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
				$data["apptitle"]="Edit Artikel";
				//
				$id = $this->uri->segment(3);
				$this->load->model('tasks_model','',true);
				//apakah valid
				$rs = $this->tasks_model->isValid($id);
				if(count($rs)>0){
					$data["query_result"]=$this->tasks_model->get_thistask($id);
					$this->load->view("v_edittask.php",$data);
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
		
		$taskTitle = $this->input->post('title');
		$taskDeadline = $this->input->post('deadline');
		$taskFormat = $this->input->post('format');
		$taskMaxSize = $this->input->post('maxsize');
		$taskContent = $this->input->post('content');
		$taskStatus = $this->input->post('status');
		
		$this->load->model('tasks_model','',true);
		$this->tasks_model->update_task	($id,$taskTitle,$taskDeadline,$taskFormat,$taskMaxSize,$taskContent,$taskStatus);
		redirect('tasks');
	}

	public function create_new()
	{
		$this->load->model('user_model','',true);

		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["apptitle"]="New task";
				$this->load->view("v_newtask.php",$data);
			} else {
				$this->load->view("v_notallowed");
			}
		}
	}
	
	function new_task()
	{
		$this->load->model('user_model','',true);	
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
	
			$this->user_model->redirectUser();
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
		
				$taskTitle = $this->input->post('title');
				$taskDeadline = $this->input->post('deadline');
				var_dump($taskDeadline);
				$taskFormat = $this->input->post('format');
				$taskMaxSize = $this->input->post('maxsize');
				$taskContent = $this->input->post('content');
				$taskStatus = $this->input->post('status');
		
				$this->load->model('tasks_model','',true);
				$this->tasks_model->create_task($taskTitle,$taskContent,$taskStatus,$taskDeadline,$taskFormat,$taskMaxSize);
				redirect('tasks');
			} else {
				$this->load->view("v_notallowed");
			}
		}
	}
}
?>
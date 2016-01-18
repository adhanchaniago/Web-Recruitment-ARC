<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class User extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	public function login()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$loginerror = isset($_SESSION["loginerror"])?$_SESSION["loginerror"]:'';
			$data["loginerror"] = $loginerror;
			$data["apptitle"]="Login";
			$this->load->view("v_login3.php",$data);
			$_SESSION["loginerror"] = "";
		} else {
			redirect('home');
		}
	}
	
	public function process_login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		$this->load->model('user_model','',true);
		$rs = $this->user_model->check_user($email,$password);
		
		$nim = $rs->nim;
		
		if(count($rs)>0){
			$_SESSION["nim"] = $nim;
			redirect('home');
		} else {
			$_SESSION["loginerror"] = "password dan username tidak match";
			redirect('user/login');
		}
	}

	public function logout()
	{
		session_unset();
		session_destroy();
		redirect('home');
	}

	public function my_profile()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$myprofileerror = isset($_SESSION["myprofileerror"])?$_SESSION["myprofileerror"]:'';
			$this->load->model('user_model','',true);
			$str=$this->user_model->getUserData();
			$row=$str->row();
			if(!$row->passChanged){
				redirect('user/change_pass');
			}
			
			$rs = $this->user_model->isValid();
			if(count($rs)>0){
				$data["query_result"]=$str;
				$data["apptitle"] = "Profil Saya";
				$data["myprofileerror"] = $myprofileerror;
				//var_dump($data);
				$this->load->view("v_myprofile.php",$data);
			} else {
				//nanti ganti jadi user not valid
				$this->load->view("v_notallowed");
			}
			$_SESSION["myprofileerror"] = "";
			
		}
	}
	
	public function profile_update()
	{
		//mengambil data dari form
		$full_name = $this->input->post('full_name');
		$panggilan = $this->input->post('panggilan');
		$no_hp = $this->input->post('no_hp');
		$addressbdg = $this->input->post('addressbdg');
		$address = $this->input->post('address');
		$tgllahir = $this->input->post('tgllahir');
		
		//mengupdate
		$this->load->model('user_model','',true);
		
		//check error  no_hp
		$no_hp_length=strlen($no_hp);
		$no_hp_error=false;
		if($no_hp_length<9 || $no_hp_length>12){
			$no_hp_error=true;
		}
		
		for($i=0;$i<$no_hp_length;$i++){
			if(!is_numeric(($no_hp{$i}))){
				$no_hp_error=true;
				break;
			}
		}
		if(!$no_hp_error){
			if($no_hp{0} == '6' && $no_hp{1} == '2'){
				if($no_hp{2} == '8'){

				} else if($no_hp{2} == '2'){
					if($no_hp{3} == '1'){

					} else {
						$no_hp_error=true;
					}
				} else {
					$no_hp_error=true;
				}
			} else if($no_hp{0} == '0'){
				if($no_hp{1} == '8'){

				} else if($no_hp{1} == '2'){
					if($no_hp{2} == '1'){

					} else {
						$no_hp_error=true;
					}
				} else {
					$no_hp_error=true;
				}
			} else {
				$no_hp_error=true;
			}

		}

		if($no_hp_error){
			$_SESSION["myprofileerror"] = "Format no.hp tidak valid";
			redirect('user/my_profile');
		}

		$this->user_model->update($full_name,$panggilan,$no_hp,$addressbdg,$address,$tgllahir);
		//cek apakah foto sudah atau belum
		$this->load->model('user_model','',true);
		$rs = $this->user_model->getUserData();
		$row = $rs->row();
		$_photo_added = $row->photo_added;
		if(!$_photo_added){
			redirect('user/upload_photo');
		} else {
			redirect('home');
		}
	}

	public function reset_pass()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		$resetpasserror = isset($_SESSION["resetpasserror"])?$_SESSION["resetpasserror"]:'';
		if(empty($login)){
			$data["resetpasserror"] = $resetpasserror;
			$data["apptitle"] = "Reset password";
			$this->load->view('v_resetpass',$data);
			$_SESSION["resetpasserror"] = "";
		} else {
			redirect('/user/change_pass');
		}
		
	}
		
	public function reset(){	
		$email = $this->input->post('email') ;
		$this->load->model('user_model','',true);
		$row = $this->user_model->get_user($email);
		if(count($row)>0){
			$this->user_model->sendEmail($email);
			$this->load->view('v_passwordsent');
		} else {
			$_SESSION["resetpasserror"] = "user tidak ditemukan";
			
			redirect('user/reset_pass');
		}
	}
	
	public function reset_code(){
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			$code = $this->input->get('code') ;
			$this->load->model('user_model','',true);
			$row = $this->user_model->isCodeValid($code);
			if(count($row)>0){
				//valid
				//cek apakah masih berlaku;
				$expire = $row->expire;
				if(strtotime($expire)-6*60*60>strtotime('now')){
					$data["apptitle"] = "Reset Password";
					$resetpasserror = "";
					$data["resetpasserror"] = $resetpasserror;
					$data["code"] = $code;
					$this->load->view('v_resetpassform',$data);
					$_SESSION["resetpasserror"] = "";
				} else {
					$_SESSION["resetpasserror"] = "Permintaan request tidak valid";
					$this->load->view('v_requestnotvalid');
				}
			} else {
				//tidak valid
				$_SESSION["resetpasserror"] = "Permintaan request tidak valid";
				$this->load->view('v_requestnotvalid');
			}
		} else {
			redirect('user/change_pass');
		}
	}
	
	public function process_resetpass($code){
		
		$newpassword = $this->input->post('newpassword');
		$confirmpassword = $this->input->post('confirmpassword');
		
		$this->load->model('user_model','',true);
		
		$row = $this->user_model->isCodeValid($code);
		if(count($row)>0){
			$errorFound = false;
			if($this->user_model->check_pass_empty($newpassword)){
				$data["error"] = "Password harus diisi";
				$errorFound = true;
			}
			
			if($this->user_model->check_pass_empty($newpassword)){
				$data["error"] = "Confirm password harus diisi";
				$errorFound = true;
			}
			
			if(!$this->user_model->check_pass_same($newpassword,$confirmpassword)){
				$data["error"] = "Confirm password harus sama dengan password";
				$errorFound = true;
			}
			
			if(!$this->user_model->check_pass_valid($newpassword)){
				$data["error"] = "Password harus minimal 6 karakter dan teridiri dari huruf besar dan kecil";
				$errorFound = true;
			}
			$_SESSION["resetpasserror"] = $data["error"];
			
			if($errorFound){
				redirect('user/reset_pass');
			} else {
				$email = $row->email;
				$this->user_model->update_pass($newpassword,$email);
				redirect('home');
			}
		} else {
			$_SESSION["resetpasserror"] = "Permintaan reset password tidak valid";
			redirect('user/reset_pass');
		}
		
		
	}

	public function change_pass()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		$changepasserror = isset($_SESSION["changepasserror"])?$_SESSION["changepasserror"]:'';
		$data["changepasserror"] = $changepasserror;
		if(empty($login)){
			redirect('home');
		}
		$data["apptitle"]="Change Password";
		$data["error"]="";
		$this->load->view("v_changepass.php",$data);
		$_SESSION["changepasserror"]="";
	}
	
	public function process_changepass()
	{
		$oldpassword = $this->input->post('oldpassword');
		$newpassword = $this->input->post('newpassword');
		$confirmpassword = $this->input->post('confirmpassword');
		
		$this->load->model('user_model','',true);
		$errorFound = false;
		if($this->user_model->check_pass_empty($newpassword)){
			$data["error"] = "Password harus diisi";
			$errorFound = true;
		}
		
		if($this->user_model->check_pass_empty($newpassword)){
			$data["error"] = "Confirm password harus diisi";
			$errorFound = true;
		}
		
		if(!$this->user_model->check_pass_same($newpassword,$confirmpassword)){
			$data["error"] = "Confirm password harus sama dengan password";
			$errorFound = true;
		}
		
		if(!$this->user_model->check_pass_valid($newpassword)){
			$data["error"] = "Password harus minimal 6 karakter dan teridiri dari huruf besar dan kecil";
			$errorFound = true;
		}
		$_SESSION["changepasserror"] = $data["error"];
		
		if($errorFound){
			redirect('user/change_pass');
		} else {
		
			$rs = $this->user_model->check_pass($oldpassword);
			
			if(count($rs)>0){
				$this->user_model->update_pass2($newpassword);
				redirect('home');
			} else {
				$data["error"]="Old password not match";
				$_SESSION["changepasserror"] = $data["error"];
				redirect('user/change_pass');
			}
		}
	}

	public function upload_photo()
	{

		
		
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$str=$this->user_model->getUserData();
			$row=$str->row();
			if(!$row->passChanged){
				redirect('user/change_pass');
			}
			if(!$row->profile_complete){
				redirect('user/myprofile');
			}
			
			$data["apptitle"] = "Upload Photo";
			$data["script"] = "user/process_upload_photo";
			$data["action"] = "Upload";
			$data["error"] = isset($_SESSION["uploadphotoerror"])?$_SESSION["uploadphotoerror"]:'';
			//$this->load->model('user_model','',true);
			$rs = $this->user_model->getuserdata();
			$row = $rs->row();
			$data["photolink"] = $this->config->base_url().($row->foto);
			$data["photoadded"] = $row->photo_added;
			$viewfile="v_cupload_form";
			$this->load->view("v_uploadphoto",$data);
			unset($_SESSION["uploadphotoerror"]);
		}
	}

	public function process_upload_photo(){
		
		$folder = foto;
		$config['upload_path'] = './'.$folder;
		$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
		//$config['max_width'] = '1024';
    ///$config['max_height'] = '768';
		$config['max_size'] = '2000000';
		$this->load->model('user_model','',true);
		$rs = $this->user_model->getuserdata();
		$row = $rs->row();
		$nim = $row->nim;
		$nombre = pathinfo($_FILES['userfile']['name']);
		echo $nombre['extension'];
		$config['file_name'] = "foto-".$nim.".".$nombre['extension'];
		echo $config['file_name'];
		$this->load->library('upload',$config);
		$this->upload->overwrite = true;
		if(!$this->upload->do_upload()){
			$error = $this->upload->display_errors();
			$_SESSION["uploadphotoerror"] = $error;
			$data['error'] = isset($_SESSION["uploadphotoerror"])?$_SESSION["uploadphotoerror"]:'';
			$data["pagetitle"] = "Upload Photo";
			$data["script"] = "uploadphoto/upload";
			$data["action"] = "Upload";			
			redirect('user/upload_photo');
			//$this->load->view("v_uploadphoto",$data);
		} else {
			//$data = array('upload_data' => $this->upload->data());
			//redirect($this->uri->uri_string());
			//update database
			$this->load->model('user_model','',true);
			$fotolocation = $folder."/".$config['file_name'];
			$this->user_model->upload_photo($fotolocation);
			$_SESSION["uploadphotoerror"] = "";
			if(!$row->profile_complete){
				redirect('myprofile');
			} else {
				redirect('user/upload_Photo');
			}
		}
	}

	public function nilai()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();
			
			$rs = $this->user_model->isValid();
			if(count($rs)>0){
				$this->load->model('user_model','',true);
				$data["apptitle"] = "Nilai Saya";
				$data["query_result"] = $this->user_model->getNilai();
				$this->load->view('v_nilai',$data);
			} else {
				//nanti ganti jadi user not valid
				$this->load->view("v_notallowed");
			}
			
		}
	}

	//user_article


	public function my_articles(){
		$allowedid = 1;
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('home');
		}

		$this->load->model('userarticles_model','',true);
		$data["query_result"] = $this->userarticles_model->get_alluserarticles();
		$data["allowedid"] = $allowedid;

		$this->load->model('userarticles_model','',true);
		$this->load->view('v_myarticles',$data);

	}

	public function view_article($id=NULL){
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('home');
		}
		$this->load->model('userarticles_model','',true);
		$str = $this->userarticles_model->get_userarticle($id);
		$row = $str->row();
		if(count())
		$this->load->view('v_article');
	}


	public function write_article($id=NULL){
		$allowedid = 1;
		if((empty($id)) || ($id!=$allowedid)){
			redirect('user/my_acrtiles');
		} else {
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				redirect('home');
			}

			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();

			$this->load->model('userarticles_model','',true);
			$data["query_result"] = $this->userarticles_model->get_userarticle($id);


			$data["id"]=$id;
			$data["apptitle"] = "Write New Article";
			$this->load->view('v_writearticle',$data);
		}
	}

	public function update_article($id=NULL){
		$allowedid = 1;
		if((empty($id)) || ($id!=$allowedid)){
			redirect('user/my_acrtile');
		} else {
			$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
			if(empty($login)){
				redirect('home');
			}

			$articleTitle=$this->input->post('title');
			$articleContent=$this->input->post('content');

			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();

			$this->load->model('userarticles_model','',true);
			$row=$this->userarticles_model->get_userarticle($id)->row();
			if(count($row)){
				//update	
				$this->userarticles_model->update_article($id,$articleTitle,$articleContent);
				redirect('user/my_articles');
			} else {
				//create new
				$this->userarticles_model->create_article($id,$articleTitle,$articleContent);			}
				redirect('user/my_articles');
		}	
	}

	public function profile(){
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');

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
	}

	public function penjurusan(){
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();
			
			$total = $this->user_model->getTotalNilai();
			$data["total"] = $total;
			$data["apptitle"] = "Penjurusan";
			if($total >= 100){
				$pilihan = $this->user_model->getPilihanPenjurusan();
				if($pilihan == NULL){
					$this->load->view("v_user_penjurusan",$data);
				} else {
					$data["pilihan"] = $pilihan;
					$this->load->view("v_user_wes_penjurusan",$data);
				}
			} else {
				$this->load->view("v_user_gaboleh_penjurusan",$data);
			}
			

					
		}

	}


	public function savePenjurusan(){

		$user_pilihan = $this->input->post('pilihan');
		$user_komentar = $this->input->post('komentar');
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('user/login');
		} else {
			$this->load->model('user_model','',true);
			$this->user_model->redirectUser();

			$total = $this->user_model->getTotalNilai();
			$data["total"] = $total;
			$data["apptitle"] = "Penjurusan";
			if($total >= 100){
				$pilihan = $this->user_model->getPilihanPenjurusan();
				if($pilihan == NULL){
							
					$this->user_model->updatePenjurusan($user_pilihan,$user_komentar);

				}
			}
			redirect('user/penjurusan');

					
		}

	}


}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Form_Absen extends CI_Controller{
	function __construct(){
	parent::__construct();
	$this->load->helper(array("html","form","text"));
	}
	
	public function index()
	{
		$login = isset($_SESSION["nim"])?$_SESSION["nim"]:'';
		if(empty($login)){
			redirect('home');
		} else {
			$this->load->model('user_model','',true);
			$tipe = $this->user_model->get_AccType();
			if($tipe == "admin"){
				$data["apptitle"]="Absen";
				$data["pertemuan"]=6;
				$data["formabsenerror"]=isset($_SESSION["formabsenerror"])?$_SESSION["formabsenerror"]:'';
				$data["formabsenuserset"]=isset($_SESSION["formabsenuserset"])?$_SESSION["formabsenuserset"]:'';
				$data["formabsenuser"]=isset($_SESSION["formabsenuser"])?$_SESSION["formabsenuser"]:false;
				if($data["formabsenuserset"]){
					$data["query_result"] = $this->user_model->getUserDataWithNIM($data["formabsenuser"]);
				}
				$this->load->view("v_formabsen.php",$data);
				$_SESSION["formabsenuserset"] = false;
				$_SESSION["formabsenuser"] = '';
				$_SESSION["formabsenerror"] = '';
			} else {
				redirect('home');
			}
		}
	}
	
	public function process_formabsen($pertemuan=NULL,$nilai=NULL)
	{
		$nim = $this->input->post('nim');		
		//cek apakah nim valid
		$this->load->model('user_model','',true);
		$row = $this->user_model->isNimValid($nim);
		$pertemuan="pertemuan".$pertemuan;
		$divisi="Web";
		if(count($row)>0){
			//cek
			$pilihan = $this->user_model->getPilihanJurusan($nim);

			if(strcmp($pilihan, $divisi) == 0){
				//pilihan sesuai
				$this->load->model('formabsen_model','',true);
				$hasAbsence=$this->formabsen_model->hasAbsence($nim,$pertemuan);
				if($hasAbsence>0){
					$_SESSION["formabsenerror"] = "Anda sudah absen";
				} else {
					$waktumasuk = strtotime('12 April 2015 09:10:00');
					$waktusekarang = strtotime('now')+5*60*60;
					$selisihwaktu =  ($waktusekarang-$waktumasuk);
					if($selisihwaktu <= 300){
						$nilai = 20;
					} else if ($selisihwaktu <= 1200){
						$nilai = 15;
					} else {
						$nilai = 10;
					} 
					$this->formabsen_model->update($nim,$pertemuan,$nilai);
					$_SESSION["formabsenerror"] = "Terima kasih sudah absen";
					$_SESSION["formabsenuserset"] = true;
					$_SESSION["formabsenuser"] = $nim;
				}		
			} else {
				$_SESSION["formabsenerror"] = "Anda tidak memilih divisi ".$divisi;
			}
			
		} else {
			$_SESSION["formabsenerror"] = "NIM tidak ditemukan";

		}
		redirect('form_absen');
	}
	
	
}
?>
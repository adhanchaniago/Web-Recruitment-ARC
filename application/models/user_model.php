<?php

class User_Model extends CI_Model {

	public function isNimValid($nim)  {
		$rs = $this->db->query("SELECT * FROM user WHERE nim = ?", array($nim));
		return $rs->row();	
	}

	public function isValid()  {
		$rs = $this->db->query("SELECT * FROM user WHERE nim = ?", array($_SESSION["nim"]));
		return $rs->row();	
	}
	
	public function getUserData()  {
		$rs = $this->db->query("SELECT * FROM user WHERE nim = ?", array($_SESSION["nim"]));
		return $rs;	
	}

	public function getUserDataWithNIM($nim)  {
		$rs = $this->db->query("SELECT * FROM user WHERE nim = ?", array($nim));
		return $rs;	
	}
	
	public function redirectUser(){
		
		$str=$this->getUserData();
		$row=$str->row();
		if(!$row->passChanged){
			redirect('user/change_pass');
		}
		if(!$row->profile_complete){
			redirect('user/my_profile');
		}
		if(!$row->photo_added){
			redirect('user/upload_photo');
		}
	}
	public function get_AccType()  {
		$str = $this->db->query("SELECT tipe from user WHERE nim = ? ",$_SESSION["nim"]);
		$row = $str->row();
		return $row->tipe;
	}

	function get_user($email){
		$str = $this->db->query("SELECT * FROM user WHERE email = ?",array($email));
		return $str->row();
	}
	
	function generateUpper($length = 1) {
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomUpper = '';
		for ($i = 0; $i < $length; $i++) {
			$randomUpper .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomUpper;
	}
			
	function generateLower($length = 1) {
		$characters = 'abcdefghijklmnopqrstuvwxyz';
		$randomLower = '';
		for ($i = 0; $i < $length; $i++) {
			$randomLower .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomLower;
	}
			
	function generateNumber($length = 1) {
		$characters = '0123456789';
		$randomNumber = '';
		for ($i = 0; $i < $length; $i++) {
			$randomNumber .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomNumber;
	}
			
	function generateChar($length = 1) {
		$characters = '@#$%*()';
		$randomChar = '';
		for ($i = 0; $i < $length; $i++) {
			$randomChar .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomChar;
	}
			
			
	function generateRandomCode() {
		$randomString = '';
			$randomString .= $this->generateUpper();
			$randomString .= $this->generateUpper();
			$randomString .= $this->generateNumber();
			$randomString .= $this->generateLower();
			$randomString .= $this->generateNumber();
			$randomString .= $this->generateNumber();
			$randomString .= $this->generateLower();
			$randomString .= $this->generateUpper();
		return $randomString;
	}
	
	function hasRequested($email){
		$str = $this->db->query("SELECT * FROM reqpass WHERE email = ?",$email);
		return $str->row();
	}
	
	public function sendEmail($email) {
		$randomcode = $this->generateRandomCode();
		$row = $this->hasRequested($email);
		if(count($row)>0){
			$str = $this->db->query("UPDATE reqpass SET randomcode = ?,request = NOW(),expire = ADDDATE(NOW(), INTERVAL 1 DAY) WHERE email=?",array($randomcode,$email));
		} else {
			$sql= $this->db->query("INSERT INTO reqpass(randomcode,email,request,expire) VALUES(?,?,NOW(),ADDDATE(NOW(), INTERVAL 1 DAY))",array($randomcode,$email));
		}
		$to = "$email";
		$subject = "Reset Password | Oprec ARC";
		$base = $this->config->base_url();
		$link = $base."user/reset_code?code=".$randomcode;//GANTI KALO PERLU
		$txt = "Untuk melakukan registrasi. Klik $link";
		$headers = "From: oprec@arc.itb.ac.id" . "\r\n";
		mail($to,$subject,$txt,$headers);
	}
	
	public function isCodeValid($code){
		$str = $this->db->query("SELECT * FROM reqpass WHERE randomcode = ?",array($code));
		return $str->row();
	}
	
	public function check_pass($password)  {
		$rs = $this->db->query("SELECT * FROM user WHERE nim = ? AND password=?", array($_SESSION["nim"],md5($password)));
		return $rs->row();
	}
	
	public function check_pass_empty($password){
		if (empty($password)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function check_pass_same($newpass,$confirmpass){
		return ($newpass == $confirmpass);
	}
	
	public function check_pass_valid($password){
		$b = true;
		if(strlen($password)<6){
			$b = false;
		} else {
			//!@#$%^&*()?
			if ((strpos($password,'a') !== false) || (strpos($password,'b') !== false) || (strpos($password,'c') !== false)
			 || (strpos($password,'d') !== false) || (strpos($password,'e') !== false) || (strpos($password,'f') !== false)
			  || (strpos($password,'g') !== false) || (strpos($password,'h') !== false) || (strpos($password,'i') !== false)
			   || (strpos($password,'j') !== false) || (strpos($password,'k') !== false) || (strpos($password,'l') !== false)
			    || (strpos($password,'m') !== false) || (strpos($password,'n') !== false) || (strpos($password,'o') !== false)
				 || (strpos($password,'p') !== false) || (strpos($password,'q') !== false) || (strpos($password,'r') !== false)
				  || (strpos($password,'s') !== false) || (strpos($password,'t') !== false) || (strpos($password,'u') !== false)
				   || (strpos($password,'v') !== false) || (strpos($password,'w') !== false) || (strpos($password,'x') !== false)
				    || (strpos($password,'y') !== false) || (strpos($password,'z') !== false)){
					
					} else {
					 $b= false;
					}
			if ((strpos($password,'A') !== false) || (strpos($password,'B') !== false) || (strpos($password,'C') !== false)
			 || (strpos($password,'D') !== false) || (strpos($password,'E') !== false) || (strpos($password,'F') !== false)
			  || (strpos($password,'G') !== false) || (strpos($password,'H') !== false) || (strpos($password,'I') !== false)
			   || (strpos($password,'J') !== false) || (strpos($password,'K') !== false) || (strpos($password,'L') !== false)
			    || (strpos($password,'M') !== false) || (strpos($password,'N') !== false) || (strpos($password,'O') !== false)
				 || (strpos($password,'P') !== false) || (strpos($password,'Q') !== false) || (strpos($password,'R') !== false)
				  || (strpos($password,'S') !== false) || (strpos($password,'T') !== false) || (strpos($password,'U') !== false)
				   || (strpos($password,'B') !== false) || (strpos($password,'W') !== false) || (strpos($password,'X') !== false)
				    || (strpos($password,'Y') !== false) || (strpos($password,'Z') !== false)){
					
					} else {
					 $b= false;
					}
		}
		return $b;
	}
	
	public function update_pass($newpassword,$email) {
		$this->db->query("UPDATE user SET password = ? , passChanged = true WHERE email = ? ", array(md5($newpassword),$email));
		$this->db->query("DELETE FROM reqpass WHERE email=?",array($email));
	}

	public function update_pass2($newpassword) {
		$this->db->query("UPDATE user SET password = ? , passChanged = true WHERE nim= ? ", array(md5($newpassword),$_SESSION["nim"]));
	}

	public function upload_photo($path)  {
		$rs = $this->db->query("UPDATE user SET photo_added = ?, foto = ? WHERE nim = ?", array(true,$path,$_SESSION["nim"]));
	}

	public function getTotalNilai(){
		$str=$this->db->query("SELECT total FROM nilai WHERE nim=?",array($_SESSION["nim"]));
		return $str->row()->total;

	}

	public function getPilihanPenjurusan(){
		
		$str=$this->db->query("SELECT pilihan FROM penjurusan WHERE nim=?",array($_SESSION["nim"]));
		return $str->row()->pilihan;

	}

	public function updatePenjurusan($pilihan,$komentar){
		$this->db->query("UPDATE penjurusan SET pilihan = ?, komentar = ?, tanggal = NOW() WHERE nim=?",array($pilihan,$komentar,$_SESSION["nim"]));
	}

	public function getNilai(){
		
		$str=$this->db->query("SELECT * FROM nilai WHERE nim=?",array($_SESSION["nim"]));
		return $str;
	}

	public function getAllNilai(){

		$str=$this->db->query("SELECT *, u.full_name FROM nilai INNER JOIN user u ON u.nim = nilai.nim;");
		return $str;
	}

	public function updateNilai($id,$type,$nilai,$nim){		
		if(($id>0) && ($id<=jumlah_pertemuan)){
			$penilaian=$type.$id;
			$str=$this->db->query("SELECT $penilaian, total FROM nilai INNER JOIN user u ON u.nim = nilai.nim WHERE nilai.nim=?;",array($nim));
			$row=$str->row();
			$total=$row->total;
			$curnilai = $row->$penilaian;
			$total+=$nilai-($curnilai);
			$this->db->query("UPDATE nilai SET $penilaian = ?, total=$total WHERE nim=?",array($nilai,$nim));

		}
	}

	public function updateTotal(){
			$str=$this->db->query("SELECT * FROM nilai");
			foreach($str->result() as $row){
				$nim = $row->nim;
				$i=0;
				$total=0;
				while($i<=jumlah_pertemuan){
					$pertemuan_id='pertemuan'.$i;
					$tugas_id='tugas'.$i;
					$tugasbonus_id='tugasbonus'.$i;
					$total+=$row->$pertemuan_id;
					$total+=$row->$tugas_id;
					$total+=$row->$tugasbonus_id;
					$i++;
				}

			$this->db->query("UPDATE nilai SET total=$total WHERE nim=$nim");
			}
	}

	public function check_user($email, $password)  {
		$rs = $this->db->query("SELECT * FROM user WHERE email = ? AND password=?", array($email,md5($password)));
		return $rs->row();
	}

	public function update($full_name,$panggilan,$no_hp,$addressbdg,$address,$tgllahir)  {
		$rs = $this->db->query("UPDATE user SET full_name = ?, panggilan = ?, no_hp = ?, addressbdg = ?, address = ?, tgllahir = ?, profile_complete = true WHERE nim = ?", array($full_name,$panggilan,$no_hp,$addressbdg,$address,$tgllahir,$_SESSION["nim"]));
	}

	public function jrs($fakultas){
		$str = $this->db->query("SELECT DISTINCT jurusan FROM user where fakultas=? order by jurusan",array($fakultas));
		return $str;
	}

	public function getPilihanJurusan($nim){
		$str = $this->db->query("SELECT pilihan FROM penjurusan where nim=?",array($nim));
		return $str->row()->pilihan;
	}
/*
	public function cek_tanggal($tgl){
		$b = true;
		if(strlen!10){
			$b = false;
		}

		if(!is_numeric($tgl{0}){
			$b = false;
		}

		if(!is_numeric($tgl{1}){
			$b = false;
		}

		if($tgl{2} != '/'){
			$b = false;
		}

		if(!is_numeric($tgl{3}){
			$b = false;
		}

		if(!is_numeric($tgl{4}){
			$b = false;
		}

		if($tgl{5} != '/'){
			$b = false;
		}

		if(!is_numeric($tgl{6}){
			$b = false;
		}

		if(!is_numeric($tgl{7}){
			$b = false;
		}

		if(!is_numeric($tgl{8}){
			$b = false;
		}

		if(!is_numeric($tgl{9}){
			$b = false;
		}



	}*/

}
?>
<?php

class GeneratePass_Model extends CI_Model {

	function generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
		
		return $randomString;
	}

	public function generate_pass()  {
		$str = $this->db->query("SELECT * from user WHERE bayar = true AND randompassset = false");
		foreach($str->result() as $row){
			$nim = $row->nim;
			$this->load->model('generatepass_model','',true);
			$password = $this->generatepass_model->generateRandomString();
			$this->db->query("UPDATE user SET password = ?, randompassset = true WHERE nim = $nim",array(md5($password)));
			$this->load->helper('url');
			
			$to = $row->email;
			$subject = "[ARC] Petunjuk Login";
			$base = $this->config->base_url();
			$link = $base."user/login/";
			$txt = "Gunakan link berikut $link untuk login dan segera ubah password serta lengkapi profil\nGunakan email sebagai username Anda\nPassword unik Anda adalah $password";
			$headers = "From: oprec@arc.itb.ac.id" . "\r\n";

			mail($to,$subject,$txt,$headers);
		}
	}
}
?>
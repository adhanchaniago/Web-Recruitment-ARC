<?php

class MyProfile_Model extends CI_Model {

	public function update($full_name,$no_hp,$addressbdg,$address,$fakultas,$jurusan)  {
		$rs = $this->db->query("UPDATE user SET full_name = ?, no_hp = ?, addressbdg = ?, address = ?, fakultas = ?, jurusan = ?, profile_complete = true WHERE nim = ?", array($full_name,$no_hp,$addressbdg,$address,$fakultas,$jurusan,$_SESSION["nim"]));
	}
}
?>
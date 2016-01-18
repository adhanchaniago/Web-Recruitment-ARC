<?php

class Rank_Model extends CI_Model {
	
	function get_friendssortbyrank()  {
		$str = $this->db->query("SELECT nilai.total, nilai.nim, user.full_name FROM nilai INNER JOIN user ON user.nim = nilai.nim WHERE user.tipe='cakru' ORDER BY nilai.total DESC");
		return $str;
	}
}
?>
<?php

class UserArticles_Model extends CI_Model {
	
	public function get_alluserarticles()  {
		$str = $this->db->query("SELECT * FROM userarticle WHERE nim = ? ORDER BY createtime DESC",array($_SESSION["nim"]));
		return $str;
	}

	public function get_userarticle($artikelke)  {
		$str = $this->db->query("SELECT * FROM userarticle WHERE artikelke =  ?  AND nim = ? ORDER BY createtime DESC",array($artikelke,$_SESSION["nim"]));
		return $str;
	}
	
	public function create_article($artikelke,$title,$content)  {
		$this->db->query("INSERT INTO userarticle(artikelke,nim,title,content,createtime,publishtime) VALUES(?,?,?,?,NOW(),NOW())", array($artikelke,$_SESSION["nim"],$title,$content));
	}

	public function update_article($artikelke,$title,$content)  {
		$this->db->query("UPDATE userarticle SET title = ?, content = ?, publishtime=NOW() WHERE artikelke=? AND nim=?", array($title,$content,$artikelke,$_SESSION["nim"]));
	}
	
}
?>
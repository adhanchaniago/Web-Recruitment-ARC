<?php

class News_Model extends CI_Model {
	
	public function get_news()  {
		$str = $this->db->query("SELECT * FROM news WHERE published=true ORDER BY createtime DESC");
		return $str;
	}
	
	function getjrecord(){
		$str = $this->db->query("SELECT * FROM news WHERE published=true");
		$result = $str->result();
		return (count($result));
		//$jrec = $this->db->count_all("news");
		//return $jrec;
	}
	
	function get_newspage($p=1,$jppage=5){
		if ($p==0) $p++;
		$start = ($p-1) * $jppage ;
		$str = "SELECT * FROM news WHERE published=true ORDER BY createtime DESC limit $start, $jppage";
		$query_result = $this->db->query($str);
		return $query_result;
	}
	
	public function view_news($id){
		$str = $this->db->query("SELECT * FROM news WHERE id = ?",$id);
		return $str;
	}
	
	public function isValid($id)  {
		$rs = $this->db->query("SELECT * FROM news WHERE id = ?", array($id));
		return $rs->row();
	}
	
	public function get_thisnews($id)  {
		$rs = $this->db->query("SELECT * FROM news WHERE id = ?", array($id));
		return $rs;
	}
	
	public function update($id,$title,$content,$published){
		$this->db->query("UPDATE news SET title = ?, content = ?, publishtime = NOW(), published = ? WHERE id = ?", array($title,$content,$published,$id));
	}
}
?>
<?php

class Articles_Model extends CI_Model {
	
	public function get_articles()  {
		$str = $this->db->query("SELECT * FROM article WHERE published='true' ORDER BY createtime DESC");
		return $str;
	}
	
	function getjrecord(){
		$str = $this->db->query("SELECT * FROM article WHERE published='true'");
		$row = $str->row();
		return count($row);
		$jrec = $this->db->count_all("article");
		return $jrec;
	}
	
	function get_articlespage($p=1,$jppage=5){
		if ($p==0) $p++;
		$start = ($p-1) * $jppage ;
		$str = "SELECT * FROM article WHERE published='true' ORDER BY createtime DESC limit $start, $jppage";
		$query_result = $this->db->query($str);
		return $query_result;
	}
	
	function get_newspage($p=1,$jppage=5){
		if ($p==0) $p++;
		$start = ($p-1) * $jppage ;
		$str = "SELECT * FROM article WHERE type='beritaumum' ORDER BY createtime DESC limit $start, $jppage";
		$query_result = $this->db->query($str);
		return $query_result;
	}
	
	public function view_article($id){
		$str = $this->db->query("SELECT * FROM article WHERE id = ?",$id);
		return $str;
	}

	public function create_article($title,$type, $content,$status)  {
	
			$this->db->query("INSERT INTO materi(title,content,createtime,publishtime,published) VALUES(?,?,NOW(),NOW(),?)", array($title,$content,$status));
		

	}

	public function get_ArticleType($id)  {
		$str = $this->db->query("SELECT type from article WHERE id = ? ",$id);
		$row = $str->row();
		return $row->tipe;
	}
	
}
?>
<?php

class Friends_Model extends CI_Model {
	
	public function get_articles()  {
		$str = $this->db->query("SELECT * FROM user ORDER BY full_name WHERE tipe='cakru'");
		return $str;
	}
	
	function getjrecord($full_name='',$fakultas='',$jurusan=''){
		$name='%'.$full_name.'%';
		$str = $this->db->query("SELECT count(*) as a FROM user WHERE full_name LIKE ? AND tipe = 'cakru' AND fakultas = ? AND jurusan = ?",array($name,$fakultas,$jurusan));
			
		return $str;//nanti result dan row
	}
	 
	function get_friendspage($p=1,$jppage=5,$orderby='full_name',$ordertype="ASC",$full_name,$fakultas,$jurusan){
		if ($p==0) $p++;
		$start = ($p-1) * $jppage ;
		$order = $orderby;
		$name='%'.$full_name.'%';
		$query_result = $this->db->query("SELECT a.* FROM (SELECT * FROM user WHERE tipe = 'cakru' AND full_name LIKE ? AND fakultas = ? and jurusan = ? ORDER BY ".$orderby." ASC) a limit $start, $jppage", array($name,$fakultas,$jurusan,$order));
		
		return $query_result;
	}
	public function view_friend($nim){
		$str = $this->db->query("SELECT * FROM user WHERE nim = ? AND tipe='cakru'",array($nim));
		
		return $str;
	}
	
	function fakultas_options(){
		$this->db->distinct();
		$rows = $this->db->select('fakultas')
		->from('user')
		->get()->result();
	
		$fakultas_options = array('' => '');
		foreach($rows as $row){
			$fakultas_options[$row->fakultas] = $row->fakultas;
		}
	
		return $fakultas_options;
	}
	
	function jurusan_options($fakultas){

		$this->db->distinct();
		$rows = $this->db->query("SELECT DISTINCT jurusan FROM user WHERE fakultas = ?",array($fakultas));
		$jurusan_options = array('' => '');
		foreach($rows->result() as $row){		
			$jurusan_options[$row->jurusan] = $row->jurusan;
		}
		
		return $jurusan_options;
	}
	
}
?>
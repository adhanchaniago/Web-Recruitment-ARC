<?php

class Tasks_Model extends CI_Model {
	
	public function get_tasks()  {
		$str = $this->db->query("SELECT * FROM task WHERE published = true ORDER BY createtime DESC");
		return $str;
	}
	
	function getjrecord(){
		$str = $this->db->query("SELECT * FROM task WHERE published = true");
		$row = $str->row();
		return count($row);
		//$jrec = $this->db>count_all("task");
		//return $jrec;
	}
	
	function get_taskspage($p=1,$jppage=5){
		if ($p==0) $p++;
		$start = ($p-1) * $jppage ;
		$str = "SELECT * FROM task WHERE published = true ORDER BY createtime DESC limit $start, $jppage";
		$query_result = $this->db->query($str);
		return $query_result;
	}
	
	public function view_task($id){
		$str = $this->db->query("SELECT * FROM task WHERE id = ?",$id);
		return $str;
	}
	
	public function get_uploadedtask($id){
		$str = $this->db->query("SELECT * FROM uploadtugas WHERE tugas = ? and nim = ?",array($id,$_SESSION["nim"]));
		return $str;
	}
	
	function insert($filelocation,$tugasid){
		$str = $this->db->query("INSERT INTO uploadtugas (time, file, nim, tugas) VALUES(NOW(),?,?,?)",array($filelocation,(int)$_SESSION["nim"],(int)$tugasid));
	}
	
	function update($tugasid){
		$this->db->query("UPDATE uploadtugas SET time = NOW() WHERE nim = ? AND tugas=?",array((int)$_SESSION["nim"],(int)$tugasid));
	}

	public function isValid($id)  {
		$rs = $this->db->query("SELECT * FROM task WHERE id = ?", array($id));
		return $rs->row();
	}
	
	public function get_thistask($id)  {
		$rs = $this->db->query("SELECT * FROM task WHERE id = ?", array($id));
		return $rs;
	}
	
	public function update_task($id,$taskTitle,$taskDeadline,$taskFormat,$taskMaxSize,$taskContent,$taskStatus){
		$this->db->query("UPDATE task SET title = ?, deadline = ?, format = ?, maxsize = ?, content = ?, publishtime = NOW(), published = ? WHERE id = ?", array($taskTitle,$taskDeadline,$taskFormat,$taskMaxSize,$taskContent,$taskStatus,$id));
	}

	public function create_task($title,$content,$status,$deadline,$format,$maxsize)  {
		//$this->load->helper('date');
		//$time = date('Y-m-d H:i:s');
		$this->db->query("INSERT INTO task(title,content,createtime,publishtime,published,deadline,format,maxsize) VALUES(?,?,NOW(),NOW(),?,?,?,?)", array($title,$content,$status,$deadline,$format,$maxsize));
	}

}
?>
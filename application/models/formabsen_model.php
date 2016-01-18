<?php

class FormAbsen_Model extends CI_Model {

	public function hasAbsence($nim,$pertemuan){
		$rs = $this->db->query("SELECT $pertemuan FROM nilai WHERE nim = ?", array($nim));
		$row=$rs->row();
		return $row->$pertemuan;
	}

	public function update($nim,$pertemuan,$nilai)  {

		$rs = $this->db->query("SELECT total FROM nilai WHERE nim = ?", array($nim));
		$row = $rs->row();
		$total=$row->total;
		$total += $nilai;
		$rs = $this->db->query("UPDATE nilai SET $pertemuan = $nilai WHERE nim = ?", array($nim));
		$rs = $this->db->query("UPDATE nilai SET total = $total WHERE nim = ?", array($nim));
	}
}
?>
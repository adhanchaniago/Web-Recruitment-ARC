<?php

class GenerateJurusan_Model extends CI_Model {

	public function generate_jurusan()  {
		$str = $this->db->query("SELECT * from user");
		foreach($str->result() as $row){
			$nim = $row->nim;
			$nimjurusan = substr($nim,0,3);
			switch($nimjurusan){
				case "102":
					$this->db->query("UPDATE user SET jurusan='Fisika' WHERE nim=$nim");
					break;
				case "103":
					$this->db->query("UPDATE user SET jurusan='Astronomi' WHERE nim=$nim");
					break;
				case "131":
					$this->db->query("UPDATE user SET jurusan='Teknik Mesin' WHERE nim=$nim");
					break;
				case "132":
					$this->db->query("UPDATE user SET jurusan='Teknik Elektro' WHERE nim=$nim");
					break;
				case "133":
					$this->db->query("UPDATE user SET jurusan='Teknik Fisika' WHERE nim=$nim");
					break;
				case "135":
					$this->db->query("UPDATE user SET jurusan='Teknik Informatika' WHERE nim=$nim");
					break;
				case "150":
					$this->db->query("UPDATE user SET jurusan='Teknik Sipil' WHERE nim=$nim");
					break;
				case "151":
					$this->db->query("UPDATE user SET jurusan='Teknik Geodesi dan Geomatika' WHERE nim=$nim");
					break;
				case "154":
					$this->db->query("UPDATE user SET jurusan='Perencanaan Wilayah dan Kota' WHERE nim=$nim");
					break;
				case "160":
					$this->db->query("UPDATE user SET jurusan='TPB FMIPA' WHERE nim=$nim");
					break;
				case "162":
					$this->db->query("UPDATE user SET jurusan='TPB Sekolah Farmasi' WHERE nim=$nim");
					break;
				case "163":
					$this->db->query("UPDATE user SET jurusan='TPB Fakultas Ilmu dan Teknik Kebumian' WHERE nim=$nim");
					break;
				case "164":
					$this->db->query("UPDATE user SET jurusan='TPB Fakultas Teknik Pertambangan dan Perminyakan' WHERE nim=$nim");
					break;
				case "165":
					$this->db->query("UPDATE user SET jurusan='TPB Sekolah Teknik Elektro dan Informatika' WHERE nim=$nim");
					break;
				case "166":
					$this->db->query("UPDATE user SET jurusan='TPB Fakultas Teknologi Sipil dan Lingkungan' WHERE nim=$nim");
					break;
				case "167":
					$this->db->query("UPDATE user SET jurusan='TPB Fakultas Teknologi Industri' WHERE nim=$nim");
					break;
				case "168":
					$this->db->query("UPDATE user SET jurusan='TPB Fakultas Seni Rupa dan Desain' WHERE nim=$nim");
					break;
				case "169":
					$this->db->query("UPDATE user SET jurusan='TPB Fakultas Teknik Mesin dan Dirgantara' WHERE nim=$nim");
					break;
				case "190":
					$this->db->query("UPDATE user SET jurusan='Sekolah Bisnis dan Manajemen' WHERE nim=$nim");
					break;
				case "192":
					$this->db->query("UPDATE user SET jurusan='-' WHERE nim=$nim");
					break;
				case "198":
					$this->db->query("UPDATE user SET jurusan='-' WHERE nim=$nim");
					break;
				case "199":
					$this->db->query("UPDATE user SET jurusan='TPB SAPPK' WHERE nim=$nim");
					break;
				case "208":
					$this->db->query("UPDATE user SET jurusan='Aktuaria ITB' WHERE nim=$nim");
					break;
			}
		}
	}
}
?>
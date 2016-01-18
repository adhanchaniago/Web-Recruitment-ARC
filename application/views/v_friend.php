<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
	<?php
		$base = $this->config->base_url();
		$row = $query_result->row();
		echo "<h2>".$row->full_name."</h2>";
		echo br();
		
		
		if($row->photo_added){
			$link = $base.$row->foto;
			echo "<img src='".$link."' width=200></img>";
		} else {
			$link = base_url('foto/default.jpg');
			echo "<img src='".$link."' width=200></img>";
		}
		echo br();
		echo br();
		?>
		<table>
			<tr  class="spaceUnder"><td  width=150><strong>NIM</strong></td><td><?php echo $row->nim;?></td></tr>
			<tr  class="spaceUnder"><td  width=150><strong>Jenis Kelamin</strong></td><td><?php echo $row->jenis_kelamin;?></td></tr>
			<tr  class="spaceUnder"><td  width=150><strong>Fakultas</strong></td><td><?php echo $row->fakultas;?></td></tr>
			<tr  class="spaceUnder"><td  width=150><strong>Jurusan</strong></td><td><?php echo $row->jurusan;?></td></tr>
			<tr  class="spaceUnder"><td  width=150><strong>Alamat Asal</strong></td><td><?php echo $row->address;?></td></tr>
			<tr  class="spaceUnder"><td  width=150><strong>Alamat Bandung</strong></td><td><?php echo $row->addressbdg;?></td></tr>
			<tr  class="spaceUnder"><td  width=150><strong>No handphone</strong></td><td><?php echo $row->no_hp;?></td></tr>
		</table>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
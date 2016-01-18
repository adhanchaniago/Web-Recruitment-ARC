<?php $this->load->view('header.php')?>
	<title><?php echo "Home".judul_situs?></title>
<?php $this->load->view('header2.php')?>


<?php
	$jumlahtugas = 3;
	$i = 1;
	$row=$query_result->row();
	$row2 = $query_result2->row();
	$_full_name=$row2->full_name;
	$_jenis_kelamin=$row2->jenis_kelamin;
	$_no_hp=$row2->no_hp;
	$_jurusan=$row2->jurusan;
	$_addressbdg=$row2->addressbdg;
	$_address=$row2->address;
	$_fakultas=$row2->fakultas;
	$_jurusan=$row2->jurusan;
	$_tgllahir=$row2->tgllahir;
	$editprofillink = base_url('user/my_profile');
	$editfotolink = base_url('user/upload_photo');
	$ubahpasswordlink = base_url('user/change_pass');?>
	<h2><?php echo "Profil Saya";?></h2>
	<?php
	if($row2->photo_added)	{
		$_foto=$row2->foto;
		$linkfoto = base_url($_foto);
	} else {
		$linkfoto = base_url('foto/default.jpg');
	}
	echo "<img width=200 src=$linkfoto>";
	?>
		<table>
			<tr class="spaceUnder"><td width=150><strong>Nama Lengkap		</strong></td><td><?php echo $_full_name;?></td></tr>
			<tr class="spaceUnder"><td width=150><strong>Jenis Kelamin		</strong></td><td><?php echo $_jenis_kelamin;?></td></tr>
			<tr class="spaceUnder"><td width=150><strong>No. handphone		</strong></td><td><?php echo $_no_hp;?></td></tr>
			<tr class="spaceUnder"><td width=150><strong>Alamat Bandung		</strong></td><td><?php echo $_addressbdg;?></td></tr>
			<tr class="spaceUnder"><td width=150><strong>Alamat Asal			</strong></td><td><?php echo $_address;?></td></tr>
			<tr class="spaceUnder"><td width=150><strong>fakultas     		</strong></td><td><?php echo $_fakultas;?></td></tr>
			<tr class="spaceUnder"><td width=150><strong>jurusan 			</strong></td><td><?php echo $_jurusan;?></td></tr>
			<tr class="spaceUnder"><td width=150><strong>Tanggal Lahir		</strong></td><td><?php echo $_tgllahir;?></td></tr>
		</table>	
		<a href="<?php echo $editprofillink;?>"><button class="button">Edit Profil</button></a>
		<a href="<?php echo $editfotolink;?>"><button class="button">Edit Foto</button></a>
		<a href="<?php echo $ubahpasswordlink;?>"><button class="button">Ubah Password</button></a>
		
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
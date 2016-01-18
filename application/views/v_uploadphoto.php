<?php $this->load->view('header.php')?>
<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
<?php
	echo heading($apptitle,2);
	echo $error;
	echo form_open_multipart("$script");
	echo form_label("Pilih foto untuk diupload : ");
	$attr='class="button"';
	echo form_upload("userfile","",$attr);
	echo br();
	echo "Format yang diperbolehkan: gif|jpg|jpeg|png|bmp";
	echo br();
	echo form_submit("btnSimpan","$action",$attr);
	echo form_close();
	if($photoadded){
		echo "<img src='".$photolink."' width='200'></img>";
	} else {
		echo "Silakan upload foto Anda";
	}
?>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
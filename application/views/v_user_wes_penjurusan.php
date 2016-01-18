<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
<h2><?php echo $apptitle;?></h2>
<br>
<?php
	echo "Anda sudah memilih. Pilihan Anda adalah ".$pilihan;
?>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
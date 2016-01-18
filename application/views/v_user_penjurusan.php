<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
<h2><?php echo $apptitle;?></h2>
<br>
<?php
$komentar = array(
	'name' => 'komentar',
	'id' => 'content',
	'rows' => 10,
	'cols' => 50,
);
	echo form_open("/user/savePenjurusan");
	echo '<input required type="radio" name="pilihan" value="Web"/>Web';
	echo '<input type="radio" name="pilihan" value="Net" />Net<br>';
	//echo '<input type="radio" name="pilihan" value="RW" />RW<br>';
	echo form_alabel("Saran materi pada Training Divisi: ");
	echo form_textarea($komentar);
	echo "<br/>";
	$attrsubmit ='class="button"';
	echo form_submit("","Submit",$attrsubmit);
	echo form_close();

?>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>

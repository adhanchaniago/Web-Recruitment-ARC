<html>
<head>
	<title><?php echo $apptitle.judul_situs;?></title>
</head>
<body>
<?php
	$oldpassword = array(
		"name"=>"oldpassword",
		"id"=>"oldpassword",
		"maxlength"=>"30",
		"size"=>"10"
	);
	$newpassword = array(
		"name"=>"password",
		"id"=>"newpassword",
		"maxlength"=>"30",
		"size"=>"10"
	);
	$confirmpassword = array(
		"name"=>"confirmpassword",
		"id"=>"confirmpassword",
		"maxlength"=>"30",
		"size"=>"10"
	);
	echo form_open("generatepass/process_generatepass");
	echo form_submit("generate","Generate");
	echo form_close();
?>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
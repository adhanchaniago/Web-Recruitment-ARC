<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
<h2><?php echo $apptitle;?></h2>
<br>
<?php
	$loginerror = isset($loginerror)?$loginerror:'';
	$email = array(
		"name"=>"email",
		"id"=>"email",
		"maxlength"=>"50",
		"size"=>"15"
	);
	$password = array(
		"name"=>"password",
		"id"=>"password",
		"size"=>"15"
	);
	$loginerror = isset($_SESSION["loginerror"])?$_SESSION["loginerror"]:'';
	echo "<span class='error'>".$loginerror."</span>";
	$_SESSION["loginerror"] = '';
	echo "<center>";
	echo "<table>";
	echo "<tr class='spaceUnder'><td>";
	echo form_open("user/process_login");
	echo form_label("Email: ");
	echo "</td><td>";
	echo form_input($email);
	echo "</td></tr><tr class='spaceUnder'><td>";
	echo form_label("Password: ");
	echo "</td><td>";
	echo form_password($password);
	echo "</td></tr>";
	echo "</table>";
	$attrlogin='class="button"';
	echo form_submit("","Login",$attrlogin);
	echo form_close();
	echo br();
	$link = base_url().'user/reset_pass';
	echo "Lupa password? Klik <a href=$link>di sini</a>";		
	echo "</center>";
?>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-guest.php')?>
<?php $this->load->view('post-sidebar.php')?>
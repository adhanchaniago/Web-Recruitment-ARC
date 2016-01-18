<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
<?php
	$newpassword = array(
		"name"=>"newpassword",
		"id"=>"newpassword",
		"onkeyup"=>"chkPasswordStrength(this.value)",
		"maxlength"=>"30",
		"size"=>"10"
	);
	$confirmpassword = array(
		"name"=>"confirmpassword",
		"onkeyup"=>"checkPass()",
		"id"=>"confirmpassword",
		"maxlength"=>"30",
		"size"=>"10"
	);
	$data = array('onsubmit' => "return chkValidity()");
	echo form_open("user/process_resetpass/$code",$data);
	echo $resetpasserror;
	echo "<br/>";
	echo form_label("New Password: ");
	echo form_password($newpassword);
	echo " <span id='strength'></span>";
	echo "<br/>";
	echo " <span id='error'> </span>";
	echo "<br/>";
	echo form_label("Confirm Password: ");
	echo form_password($confirmpassword);
	echo "<br/>";
	echo form_submit("login","Login");
	echo form_close();
?>
<script>
function chkValidity(){
	
		//password
		var txtpass = document.getElementById('newpassword').value;
		
		if(txtpass.length < 6){
			alert("Password minimal 6 karakter");
			return false;
		}
		
		if(!(txtpass.match(/[a-z]/)) || !(txtpass.match(/[A-Z]/))){
			alert("Password harus mengandung huruf besar dan kecil");
			return false;
		}
		
		//confirmpass
		var pass1 = document.getElementById('newpassword').value;
		var pass2 = document.getElementById('confirmpassword').value;
		if(pass1 != pass2){
			alert("Password harus match");
			return false;
		}
	}
	
	function chkPasswordStrength(txtpass){

		var desc = new Array();
		desc[0] = "Sangat lemah";
		desc[1] = "Lemah";
		desc[2] = "Sedang";
		desc[3] = "Kuat";
		desc[4] = "Sangat Kuat";
		var strengthMsg = document.getElementById("strength");
		var errorMsg = document.getElementById("error");
		errorMsg.innerHTML = "";
		var score = 0;
	
		if(txtpass.length > 6){
			score++;
		}
	
		if((txtpass.match(/[a-z]/)) && (txtpass.match(/[A-Z]/))){
			score++;
		} else {
			errorMsg.innerHTML = "Password harus mengandung huruf besar dan kecil";
			errorMsg.className = "error";
		}
		
		if(txtpass.length > 12){
			score++;
		}
		
		strengthMsg.innerHTML = desc[score];
		strengthMsg.className = "strength" + score;
		
		if(txtpass.length<6){
			errorMsg.innerHTML = "Password harus minimum 6 karakter";
			errorMsg.className = "error";
		}
	}

	function checkPass(){
		var pass1 = document.getElementById('newpassword');
		var pass2 = document.getElementById('confirmpassword');

		var message = document.getElementById('confirmMessage');
		
		var goodColor = "#66cc66";
		var badColor = "#ff6666";
		
		if(pass1.value == pass2.value){
			pass2.style.backgroundColor = goodColor;
			message.style.color = goodColor;
			message.innerHTML = "Password Match!";
		} else {
			pass2.style.backgroundColor = badColor;
			message.style.color = badColor;
			message.innerHTML = "Password Do Not Match!";
		}
	}
</script>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-guest.php')?>
<?php $this->load->view('post-sidebar.php')?>
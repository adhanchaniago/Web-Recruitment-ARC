<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs?></title>
<?php $this->load->view('header2.php')?>
<h2><?php echo $apptitle;?></h2>
<br>
<center>
	<?php echo form_open("user/reset");?>
		<table>
		<tr><td width="80">E-mail:</td><td><input width="250" type="text" required placeholder="email" name="email" value="">
		<?php echo $resetpasserror; ?></td></tr>
		</table>
		<input type="submit" name="submit" value="Submit" class="button">
	</form>
	<?php $link = base_url('user/login');
	echo "<a href=$link>Back to login</a>";?>
</center>

<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-guest.php')?>
<?php $this->load->view('post-sidebar.php')?>
<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
	<table style="margin:auto;width:80%;">
	<?php
		//$c=1;
		$base = $this->config->base_url();
		$row = $query_result->row();
		echo "<h2>".$row->title."</h2>";
		echo $row->createtime;
		echo "<div class='article-content'>".$row->content."</div>";
		if($isAdmin){
			$editlink = $base."news/edit/".$row->id;
			echo "<a href='$editlink'>Edit</a>";
		}
	?>
	</table>
<?php
$this->load->view('post-content.php');
if(!$isLogin){
	$this->load->view('sidebar-guest.php');
} else {
	$this->load->view('sidebar-loggedin.php');
}
$this->load->view('post-sidebar.php')
?>
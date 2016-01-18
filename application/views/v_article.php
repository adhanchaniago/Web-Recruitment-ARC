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
		echo "<div class='article'>".$row->content."</div>";
		if($isAdmin){
			$editlink = $base."editarticle/id/".$row->id;
			echo "<a href='$editlink'>Edit</a>";
		}
	?>
	</table>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
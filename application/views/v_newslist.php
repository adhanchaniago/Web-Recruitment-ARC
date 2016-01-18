<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
	<table style="margin:auto;width:80%;">
	<?php
		$base = $this->config->base_url();
		foreach($query_result->result() as $row){
			if($isAdmin || $row->published){
				echo "<tr><td>";
				$link = $base."articles/view/".$row->id;
				echo "<a href='$link'><h2>".$row->title."</h2></a>";
				echo $row->createtime;
				echo "<div class='article'>".$row->content."</div>";
				if($isAdmin){
					$editlink = $base."editnews/id/".$row->id;
					echo "<a href='$editlink'>Edit</a>";
				}
				echo "</td></tr>";
			}
		}
	?>
	</table>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
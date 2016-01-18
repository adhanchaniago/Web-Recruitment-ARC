<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
	<table style="margin:auto;width:40%;">
	<?php
		$base = $this->config->base_url();
		$i=1;
		foreach($query_result->result() as $row){
				echo "<tr><td>";
				echo "Tugas Artikel ".$i;
				echo "</td><td>";
				echo $row->title;				
				echo "</td><td>";
				if($i==$allowedid){
					$link = $base."user/write_article/".$row->id;
					echo "<a href='$link'>Edit</a>";
				} else {
					$link = $base."user/view_article/".$row->id;
					echo "<a href='$link'>View</a>";
				}
				$i++;
				echo "</td></tr>";
		}
	?>
	</table>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
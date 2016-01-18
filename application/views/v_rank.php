<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
<h1 class="title"><?php echo $apptitle;?></h1>
	
	
<?php		
		
	$base = $this->config->base_url();
		
		/*stats_rand_setall(iseed1, iseed2) table penampil list friends*/
	if(count($query_result->result()) > 0){
		?>
		<div class='table-container'>
		<table class='table-responsive' border = '1' style='margin:auto;'>
		<b> Last update : 28 Maret 2015 (sampai pertemuan 3) </b> <br><br>
		<thead><tr><th width="30"><strong>No</strong></th><th><strong>Nama</strong></th><th><strong>NIM</strong></th><th><strong>Nilai Total</strong></th></tr></thead>
		<tbody>
		<?php 
		$i=1;
		foreach($query_result->result() as $row){
			?>
			<tr>
			
			<td><?php echo $i;?></td>
			
			<td><?php $link = $base.'friends/view/'.$row->nim;?>
			<a href="<?php echo $link;?>"><?php echo $row->full_name;?></a>
			</td>
			
			<td><?php echo $row->nim;?></td>
			<td><?php echo $row->total;?></td>
			</tr>
			<?php $i++;}?>
		</tbody>
		</table>
		</div>
	<?php
	} else {
		echo "<p align='center'>Data tidak ditemukan</p>";
	}
	
	?>

<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
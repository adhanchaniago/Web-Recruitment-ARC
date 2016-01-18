<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
	<?php
		
		$row=$query_result->row();
		$jumlahpertemuan = 3;
		$i=1;
		?>
		<h2><?php echo $apptitle;?></h2><br>
		<table class="table-responsive table-nilai" border = 1>
		<thead><tr><th>Pertemuan</th><th>Tugas Pokok</th><th>Tugas Bonus</th><th>Kehadiran</th><th>Total</th></tr></thead>
		<tbody>
		<?php $total0 = $row->tugas0 + $row->tugasbonus0;?>
		<tr><td>0</td><td><?php echo $row->tugas0;?></td><td><?php echo $row->tugasbonus0;?></td><td>TIDAK ADA</td><td><?php echo $total0;?></td></tr>
		<?php
		while($i<=$jumlahpertemuan){
			$tugaske="tugas".$i;
			$tugasbonuske="tugasbonus".$i;
			$pertemuanke="pertemuan".$i;
			$nilaipokok = $row->$tugaske;
			$nilaibonus = $row->$tugasbonuske;
			$kehadiran = $row->$pertemuanke;
			$nilaitotal = $nilaipokok + $nilaibonus + $kehadiran;
			?>
			<tr>
			<td width=150><?php echo $i;?></td>
			<td width=150><?php echo $nilaipokok;?></td>
			<td width=150><?php echo $nilaibonus;?></td>
			<td width=150><?php echo $kehadiran;?></td>
			<td width=150><?php echo $nilaitotal;?></td>
			</tr>
			<?php
			$i++;
		}?>

		<tr align="center"><td><strong>Nilai Total</strong></td><td></td><td></td><td></td><td><?php echo $row->total;?></td></tr>
		</tbody>
		</table>
		
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
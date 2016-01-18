<html>
<head>


</head>
<body>
<?php
	$link = base_url('dashboard/display_users/');
	echo "<a href='".$link."'>User</a>";
	echo "<br>";
	
	$link = base_url('dashboard/display_tugas/');
	echo "<a href='".$link."'>Tugas</a>";
	echo "<br>";
	
	$link = base_url('dashboard/display_materi/');
	echo "<a href='".$link."'>Materi</a>";
	echo "<br>";
	
	$link = base_url('dashboard/display_materi/');
	echo "<a href='".$link."'>News</a>";
	echo "<br>";

	$link = base_url('tasks/create_new/');
	echo "<a href='".$link."'>Buat tugas baru</a>";
	echo "<br>";

	$link = base_url('articles/create_new');
	echo "<a href='".$link."'>Buat materi baru</a>";
	echo "<br>";

	echo "NILAI S NAHAR";
	$i=1;

	while($i<=jumlah_pertemuan){
		$link=base_url('dashboard/edit_nilai').'/'.$i;
		echo "<a href=$link>Nilai $i</a>";
		$i++;
	}
	echo "<a href='dashboard/updateTotal'>Reset Total</a>";
?>

<html>
<head>
<title>Edit nilai</title>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.8.2.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.js"></script>
<script type="text/javascript">


function update(){
	alert("a");
	$(this).parent("form").submit();
    //document.getElementsByClassName("formEditNilai").submit();("form2").submit();
}
</script>
</head>
<body>
<table>
<tr>
<td>NIM</td>
<?php
			$i=$id;
			$pertemuan_id="pertemuan".$i;
		    $tugas_id="tugas".$i;
		    $tugasbonus_id="tugasbonus".$i;
		   	?>
		   	<td><?php echo $pertemuan_id;?></td>
		   	<td><?php echo $tugas_id;?></td>
		   	<td><?php echo $tugasbonus_id;?></td>
		   	<?php
		   	$i++;

?>
<td>Total</td>
</tr>
<form action="<?php echo base_url('dashboard/update_nilai/').'/'.$id;?>" method="post">
<?php
	foreach($row=$query_result->result() as $row){
		//$action="dashboard/update_nilai/".$row->nim;
	    ?>
		<tr><td><?php echo $row->nim;?></td>
    		<?php
    			$nim=$row->nim;
	    		$jumlah=12;
	    		$i=$id;
	    		/*while($i<=$jumlah) {
	    			$pertemuan_id="pertemuan".$i;
	    			$tugas_id="tugas".$i;
	    			$tugasbonus_id="tugasbonus".$i;*/
	    			?>
	    			<td><input type='number' name='<?="pertemuan[$nim]"?>' value="<?php if ($row->$pertemuan_id == '') echo '0'; else echo $row->$pertemuan_id;?>"></input></td>
	    			<td><input type='number' name='<?="tugas[$nim]"?>' value="<?php if ($row->$tugas_id == '') echo '0'; else echo $row->$tugas_id;?>" ></input></td>
	    			<td><input type='number' name='<?="tugasbonus[$nim]"?>' value="<?php if ($row->$tugasbonus_id == '') echo '0'; else echo $row->$tugasbonus_id;?>" ></input></td>
	    			<?php
	    			//$i++;
	    		//}
	    	?>
	    	<td><?php echo $row->total;?></td></tr>
		<?php		
	}
?>
<input type="submit" value="sapi" />
</form>

</table>
<!-- <input type="button" id="clickMe2" value="Submit ALL"  onclick="update();" /> -->
</body>
</html>
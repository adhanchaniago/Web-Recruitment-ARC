<?php $this->load->view('header.php')?>
	<meta charset="utf-8">
	<title><?php echo $apptitle.judul_situs;?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
   <script>
  $(function() {
    $( "#2" ).datepick();
  });
  </script>
<?php $this->load->view('header2.php')?>
<?php
$nim = array(
	"name"=>"nim",
	"id"=>"nim",
	"maxlength"=>"30",
	"size"=>"16.5",
	'required' => 'required'
);
	//$data = array('onsubmit' => "return chkValidity()");
	
	echo "<h2>$apptitle</h2>";
	echo "<span class='error'>".$formabsenerror."</span>";
	if($formabsenuser){
		$row = $query_result->row();
		if($row->photo_added){
			$link = base_url().$row->foto;
		} else {
			$link = base_url().'foto/default.jpg';
		}
		$row = $query_result->row();
		echo "<table class='table-responsive' border=1>";
		echo "<thead>";
		echo "<tr align='center'><th width='200'>Foto</th><th width='100'>Nama</th><th width='100'>NIM</th></tr>";
		echo "</thead>";
		echo "<tbody>";
		echo "<tr bgcolor='#FFF' align='center'><td><img width='200' src='$link'></td><td>".$row->full_name."</td><td>".$row->nim."</td></tr>";
		echo "</tbody>";
		echo "</table>";
	}
	echo br();
	echo form_open("form_absen/process_formabsen/".$pertemuan);
	echo "<tr class='spaceUnder'><td width='150'>";
	echo form_label("NIM");
	echo "</td><td>";
	echo form_input($nim);
	echo "</td></tr>";
	
	$attrsubmit ='class="button"';
	echo form_submit("","Submit",$attrsubmit);
	echo form_close();
	
?>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
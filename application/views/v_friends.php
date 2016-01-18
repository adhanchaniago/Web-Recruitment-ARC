<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
	
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.8.2.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.js"></script>

	<script type="text/javascript">
	function sortby(){
		var data = "<?php echo $this->config->base_url(); ?>";
		var sort = "<?php echo $search;?>";
		
		if (document.getElementById("option").value == "full_name"){
			var str="friends/display/full_name";
		} else if (document.getElementById("option").value == "nim") {
			var str="friends/display/nim";
		} else if (document.getElementById("option").value == "jurusan") {
			var str="friends/display/jurusan";
		}  else if (document.getElementById("option").value == "fakultas") {
			var str="friends/display/fakultas";
		} 	
		var data = data.concat(str);
		var data = data.concat(sort);
		window.location.href = data;
	}
		
	function getSearch(){
		
		var data = "<?php echo $this->config->base_url().'friends/display/'.$sortby; ?>";
		var url = window.location.href;
		
		var name = document.getElementById("name").value;
		var fakultas = document.getElementById("fakultas").value;
		var jurusan = document.getElementById("jurusan").value;
		
		var str2 = data.concat('?');
		if(name != ""){
			var str2 = str2.concat('name=');
			var str2 = str2.concat(name);
		}
		
		if(fakultas != ""){
			if(name != ""){
				var str2 = str2.concat('&');
			}
			var str2 = str2.concat('fakultas=');
			var str2 = str2.concat(fakultas);
		}
		if(jurusan != ""){
			if((fakultas != "") || (name != "")){
				var str2 = str2.concat('&');
			}
			var str2 = str2.concat(	'jurusan=');
			var str2 = str2.concat(jurusan);
		}
		window.location.href=str2;
	}
	
	</script>
	<script>
	$(document).ready(function(){
		$("#fakultas").change(function() {
			//alert("halo fakultas changed");
			$('#jurusan').html('adfaafsd');
			var category_id = {"fakultas" : $('#fakultas').val()};
			console.log(fakultas);

			/*
			$.ajax({
				type: "POST",
				data: fakultas,
				url: "<?= base_url() ?>friends/jrs",

				success: function(data){
					$('#jurusan').html('<option value="">-- Select Type --</option>');
					$.each(data, function(i, data){
						$('#jurusan').append("<option value='"+data.id_type+"'>"+data.name+"</option>");
					});
				});
			}*/
			var fakultas = $(this).val();
			var urlpath = '<?php echo base_url()?>friends/jimmy/' + fakultas;	
			$.ajax({
				type: "POST",
			  url: urlpath,
			  success: function(data) {
				$("#jurusanz").html(data);
			  }
			});
		});
    });
	</script>
<?php $this->load->view('header2.php')?>
	<h1 class="title"><?php echo $apptitle;?></h1>
	<?php		
		$arraysort=array(
			"full_name"=>"Full name",
			"nim"=>"Nim",
			"jurusan"=>"Jurusan",
			"fakultas"=>"Fakultas"
		);
		$base = $this->config->base_url();
		$attrname = 'id="name"';
		$attrfakultas='id="fakultas"';
		//search
		$data = array('onsubmit' => "getSearch()");
		/* start table search */
		echo form_label('Nama:  ','name');
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo form_input('name',set_value('name',$name),$attrname);
		
		echo br();
		echo form_label('Fakultas:','fakultas');
		echo form_dropdown('fakultas',$fakultas_options,set_value('fakultas',$fakultas),$attrfakultas);
		echo br();
		echo "<div id='jurusanz'>";
		echo "</div>";?><?php
		/*end table search*/
		echo "<center><button style='width:300px' class='button' onclick='getSearch();'>Search</button></center>";
		echo br();
		$resetlink = base_url('friends/display');
		echo "<a href=$resetlink>Reset Search</a>";
		echo br();
		$attrsort='id="option" onchange="sortby();"';
		echo "Sort by: ".form_dropdown("option",$arraysort,set_value('sortby',$sortby),$attrsort);
		
		/*start table penampil list friends*/
		if(count($query_result->result()) > 0){
		echo "<div class='table-container'>";
		echo "<table class='table-responsive' border = '1' style='margin:auto;'>";
		echo "<thead><tr><th width=150>Foto</th><th>Nama</th><th>NIM</th><th>Fakultas</th><th>Jurusan</th></tr></thead>";
		foreach($query_result->result() as $row){
		
				echo "<tr height=150><td>";
				
				if($row->photo_added){
					echo "<img src='".$base.$row->foto."' width=150>";
				} else {
					echo "<img src='".$base."/foto/default.jpg' width=150>";
				}
				echo "</td><td>";
				
				$link = $base."friends/view/".$row->nim;
				echo "<a href='$link'>".$row->full_name."</a>";
				echo "</td><td>";
				
				echo $row->nim;
				echo "</td><td>";
				
				echo $row->fakultas;
				echo "</td><td>";
				
				echo $row->jurusan;
				echo "</td></tr>";
		}
	?>
		</table>
		</div>
		<!--end table penampil list friends-->
	<?php
	
		//pagination manual
		if($page>2){
			$start = $page-2;
		} else {
			$start = 1;
		}
		
		if($page<($pnumbers-2)){
			$finish = $page+2;
		} else {
			$finish = $pnumbers;
		}
		if($start>1){
			$url = $this->config->base_url().'friends/display/'.$sortby.'/'.$pnumbers.''.	$search;
			echo "<a href= '".$url."'>First</a>";
		}
		for($i = $start; $i<= $finish; $i++){
			$url = $this->config->base_url().'friends/display/'.$sortby.'/'.$i.''.	$search;
			echo "<a href= '".$url."'>".$i."</a>";
			echo ' ';
		}
		if($finish<$pnumbers){
			$url = $this->config->base_url().'friends/display/'.$sortby.'/'.$pnumbers.''.	$search;
			echo "<a href= '".$url."'>Last</a>";
		}
	} else {
		echo "<p align='center'>Data tidak ditemukan</p>";
	}
	
	?>
	<?php $this->load->view('post-content.php')?>
	<?php $this->load->view('sidebar-loggedin.php')?>
	<?php $this->load->view('post-sidebar.php')?>

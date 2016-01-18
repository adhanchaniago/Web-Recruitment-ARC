<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
<?php $this->load->view('header2.php')?>
	<script type="text/javascript">
	function sqlToJsDate(sqlDate){
    //sqlDate in SQL DATETIME format ("yyyy-mm-dd hh:mm:ss.ms")
    var sqlDateArr1 = sqlDate.split("-");
    //format of sqlDateArr1[] = ['yyyy','mm','dd hh:mm:ms']
    var sYear = sqlDateArr1[0];
    var sMonth = (Number(sqlDateArr1[1]) - 1).toString();
    var sqlDateArr2 = sqlDateArr1[2].split(" ");
    //format of sqlDateArr2[] = ['dd', 'hh:mm:ss.ms']
    var sDay = sqlDateArr2[0];
    var sqlDateArr3 = sqlDateArr2[1].split(":");
    //format of sqlDateArr3[] = ['hh','mm','ss.ms']
    var sHour = sqlDateArr3[0];
    var sMinute = sqlDateArr3[1];
    var sqlDateArr4 = sqlDateArr3[2].split(".");
    //format of sqlDateArr4[] = ['ss','ms']
    var sSecond = sqlDateArr4[0];
    var sMillisecond = sqlDateArr4[1];
    
    return new Date(sYear,sMonth,sDay,sHour,sMinute,sSecond,sMillisecond);
	}
	</script>

	<?php
		$base = $this->config->base_url();
		$row = $query_result->row();
		$curDate = date('D M d Y H:i:s O');
		$deadlineDate = date('D 	M d Y H:i:s O', strtotime($row->deadline));
		echo "<h2>".$row->title."</h2>";
		echo "<div class='spek-tugas'>";
		echo "<strong><font color='blue'>Server Time: ";
		echo "<span id='serverTime'></span></font></strong><br>";
		echo "<strong><font color='red'>Deadline: ";
		echo "<span id='deadlineTime'></span></font></strong><br>";
		echo "<font color='red'>";
		echo "</font>";
		echo "</span>";
		echo br();
		$attr = 'class="button"';
		echo "Format File: ";
		echo $formatfile;
		echo br();
		echo "Ukuran File Maksimal: ";
		$maxsize = $row->maxsize/1000000;
		echo $maxsize . " MB";
		echo br();
		echo form_open_multipart("$script");
		echo form_label("Pilih file untuk diupload : ");
		echo form_upload("userfile","",$attr);
		echo br();
		echo form_submit("btnSimpan","$action",$attr);
		echo form_close();
		echo br();
		if($hasUpload){
			echo "SUDAH MENGUPLOAD";
			echo br();
			
		} else {
			echo "<font color='red'>BELUM MENGUPLOAD</font>";
		}
		echo "<br><span class='error'>$error</span>";
		echo "</div>";

		echo "<div class='task'>".$row->content."</div>";
		
		
		
		
		if($isAdmin){
			$editlink = $base."taks/edit/".$row->id;
			echo "<a href='$editlink'>Edit</a>";
		}
	?>
	<script type="text/javascript">
	
	var date;
	
	bulan = new Array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
	hari  = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
	
	function date_formatter(date) {
		day = date.getDay();
	    year = date.getFullYear();
        month = date.getMonth();
        
        d = date.getDate();
		h = date.getHours();
        s = date.getSeconds();
        m = date.getMinutes();
        
		if(h<10) h = "0"+h;
        if(m<10) m = "0"+m;
        if(s<10) s = "0"+s;
        
		console.log(date);
		
		return hari[day]+' '+d+' '+bulan[month]+' '+year+' '+h+':'+m+':'+s;	
	};
	
	function date_time(id)
	{
        document.getElementById(id).innerHTML = date_formatter(date);
		setTimeout('date.setSeconds(date.getSeconds()+1); date_time("'+id+'");','1000');
	}
	
	</script>
	
	<?php
		echo "<script type='text/javascript'>date=new Date('$curDate');date_time('serverTime'); document.getElementById('deadlineTime').innerHTML = date_formatter(new Date('$deadlineDate'));</script>";
	?>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>	
<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('script/style.css');?>">
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
	
	function date_time(cname,i)
	{
        var x = document.getElementsByClassName(cname);
		x[i].innerHTML = date_formatter(date);
		setTimeout('date.setSeconds(date.getSeconds()+1); date_time("'+id+'");','1000');
	}
	
	</script>
	<div class="site-content">
	<h2><?php echo $apptitle;?></h2><br>
	<table style="margin:auto;width:80%;">
	<?php
		$c=0;
		$base = $this->config->base_url();
		foreach($query_result->result() as $row){
			if($isAdmin || $row->published){
				echo "<div class='article-item'>";
				$link = $base."materi/view/".$row->id;
				echo "<a href='$link'><h2 class='article-title'>".$row->title."</h2></a>";
				$createtime = date('D 	M d Y H:i:s O', strtotime($row->createtime));
				echo "<span class='createtime'></span>";
				echo "<script type='text/javascript'>
				date=new Date('$createtime');
				date_time('createtime',".$c.");
				</script>";
				
				//
				echo "<div class='article-content'>".$row->content."</div>";
				if($isAdmin){
					$editlink = $base."materi/edit/".$row->id;
					echo "<a href='$editlink'>Edit</a>";
				}
				echo "</div>";
				$c++;
				echo "<hr style='border-top: solid 1px;border-color: #cccccc;' />";
			}
		}
	?>
	</table>
	<?php
	/*
	for ($x = 0; $x < $pnumbers; $x++) {
		echo "<a href='".$base_url.$x."'>".($x+1)."</a>"." ";
	} 
	
	echo $pnumbers;*/
	echo br();
	echo $pagination;?>
	</div>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
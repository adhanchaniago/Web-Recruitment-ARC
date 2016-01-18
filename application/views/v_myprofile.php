<?php $this->load->view('header.php')?>
	<meta charset="utf-8">
	<title><?php echo $apptitle.judul_situs;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('script/jquery.datetimepicker.css');?>"/>
<style type="text/css">

.custom-date-style {
	background-color: red !important;
}

</style>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/> 
<?php $this->load->view('header2.php')?>
<?php
$full_name = array(
	"name"=>"full_name",
	"id"=>"full_name",
	"maxlength"=>"50",
	"size"=>"16.5",
	'required' => 'required'
);
$panggilan = array(
	"name"=>"panggilan",
	"id"=>"panggilan",
	"maxlength"=>"15",
	"size"=>"16.5",
	'required' => 'required'
);
$no_hp = array(
	'name' => 'no_hp',
	'id' => 'no_hp',
	"maxlength"=>"20",
	"size"=>"16.5",
	'required' => 'required'
);
$addressbdg = array(
	'name' => 'addressbdg',
	'id' => 'addressbdg',
	"maxlength"=>"200",
	"size"=>"16.5",
	'required' => 'required'
 );
$address = array(
	'name' => 'address',
	'id' => 'address',
	"maxlength"=>"200",
	"size"=>"16.5",
	'required' => 'required'
 );
	$row=$query_result->row();
	$_full_name=$row->full_name;
	$_panggilan=$row->panggilan;
	$_no_hp=$row->no_hp;
	$_jurusan=$row->jurusan;
	$_addressbdg=$row->addressbdg;
	$_address=$row->address;
	$_fakultas=$row->fakultas;
	$_jurusan=$row->jurusan;
	$_tgllahir=$row->tgllahir;
	$data = array('onsubmit' => "return chkValidity()");
	echo form_open("user/profile_update",$data);
	echo "<h2>$apptitle</h2>";
	echo "<span class='error'>".$myprofileerror."</span>";
	echo br();
	echo "<table>";

	echo "<tr class='spaceUnder'><td width='150'>";
	echo form_label("Nama Lengkap");
	echo "</td><td>";
	echo form_input($full_name, set_value('full_name',$_full_name));
	echo "</td></tr>";

	echo "<tr class='spaceUnder'><td width='150'>";
	echo form_label("Nama Panggilan");
	echo "</td><td>";
	echo form_input($panggilan, set_value('panggilan',$_panggilan));
	echo "</td></tr>";
	
	echo "<tr class='spaceUnder'><td>";
	echo form_label("No hp");
	echo "</td><td>";
	echo form_input($no_hp, set_value('no_hp',$_no_hp));
	echo "</td></tr>";
	
	echo "<tr class='spaceUnder'><td>";
	echo form_label("Alamat Bandung");
	echo "</td><td>";
	echo form_input($addressbdg, set_value('addressbdg',$_addressbdg));
	echo "</td></tr>";
	
	echo "<tr class='spaceUnder'><td>";
	echo form_label("Alamat Asal");
	echo "</td><td>";
	echo form_input($address, set_value('address',$_address));
	echo "</td></tr>";

	echo "<tr class='spaceUnder'><td>";
	echo form_label("Tgl. Lahir");
	echo "</td><td>";
	//echo "<input type='text' value='$_tgllahir' name='tgllahir' id='tgllahir'/><br><br>";
	//echo "<input type='text' name='tgllahir' id='tgllahir' required>";
	//echo "<input type='date' name='tgllahir' id='tgllahir' value='$_tgllahir' required>";
	echo "<input size='16.5' type='text' value='$_tgllahir'  name = 'tgllahir' id = 'tgllahir'>";
	echo "</td></tr>";
	

	echo "</table>";
	$attrsubmit = 'class="button"';
	echo form_submit("","Submit",$attrsubmit);
	echo form_close();
	
?>
<script>
var isWhole_re  = /^\s*\d+\s*$/;
function isWhole (s) {
	return String(s).search (isWhole_re) != -1;
}

function chkValidity(){
		// Check if string is a whole number(digits only).
		

		//password
		var no_hp = document.getElementById('no_hp').value;
		
		if(no_hp.length < 9 || no_hp.length >12){
			alert("Format no. hp salah");
			return false;
		}
		
		if(!isWhole(no_hp)){
			alert("Format no. hp salah");
			return false;
		}
		
		if((no_hp.charAt(0) == '6') && (no_hp.charAt(1) == '2')){
			if(no_hp.charAt(2) == '8'){

			} else if(no_hp.charAt(3) == '2'){
				if(no_hp.charAt(4) == '1'){
				
				} else {
					alert("Format no. hp salah");
					return false;
				}
			}

		} else if(no_hp.charAt(0) == '0'){
			if(no_hp.charAt(1) == '8'){

			} else if(no_hp.charAt(1) == '2'){
				if(no_hp.charAt(2) == '1'){
				
				} else {
					alert("Format no. hp salah");
					return false;
				}
			}

		} else {
			alert("Format no. hp salah");
			return false;
		}
	}
</script>
</body>
<script src="<?php echo site_url('script/jquery.js');?>"></script>
<script src="<?php echo site_url('script/jquery.datetimepicker.js');?>"></script>
<script>/*
window.onerror = function(errorMsg) {
	$('#console').html($('#console').html()+'<br>'+errorMsg)
}*/
$('#tgllahirx').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
startDate:	'1986/01/05'
});
$('#tgllahirx').datetimepicker();

$('.some_class').datetimepicker();

$('#default_datetimepicker').datetimepicker({
	formatTime:'H:i',
	formatDate:'d.m.Y',
	defaultDate:'8.12.1986', // it's my birthday
	defaultTime:'10:00',
	timepickerScrollbar:false
});

$('#datetimepicker10').datetimepicker({
	step:5,
	inline:true
});
$('#datetimepicker_mask').datetimepicker({
	mask:'9999/19/39 29:59'
});

$('#datetimepicker1').datetimepicker({
	datepicker:false,
	format:'H:i',
	step:5
});
$('#tgllahir').datetimepicker({
	yearOffset:-20,
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y/m/d'
	//minDate:'-1990/01/02', // yesterday is minimum date
	//maxDate:'+2010/01/02' // and tommorow is maximum date calendar
});
$('#tgllahir').datetimepicker({value:$_tgllahir,step:10});
$('#datetimepicker3').datetimepicker({
	inline:true
});
$('#datetimepicker4').datetimepicker();
$('#open').click(function(){
	$('#datetimepicker4').datetimepicker('show');
});
$('#close').click(function(){
	$('#datetimepicker4').datetimepicker('hide');
});
$('#reset').click(function(){
	$('#datetimepicker4').datetimepicker('reset');
});
$('#datetimepicker5').datetimepicker({
	datepicker:false,
	allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00'],
	step:5
});
$('#datetimepicker6').datetimepicker();
$('#destroy').click(function(){
	if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
		$('#datetimepicker6').datetimepicker('destroy');
		this.value = 'create';
	}else{
		$('#datetimepicker6').datetimepicker();
		this.value = 'destroy';
	}
});
var logic = function( currentDateTime ){
	if( currentDateTime.getDay()==6 ){
		this.setOptions({
			minTime:'11:00'
		});
	}else
		this.setOptions({
			minTime:'8:00'
		});
};
$('#datetimepicker7').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});
$('#datetimepicker8').datetimepicker({
	onGenerate:function( ct ){
		$(this).find('.xdsoft_date')
			.toggleClass('xdsoft_disabled');
	},
	minDate:'-1970/01/2',
	maxDate:'+1970/01/2',
	timepicker:false
});
$('#datetimepicker9').datetimepicker({
	onGenerate:function( ct ){
		$(this).find('.xdsoft_date.xdsoft_weekend')
			.addClass('xdsoft_disabled');
	},
	weekends:['01.01.2014','02.01.2014','03.01.2014','04.01.2014','05.01.2014','06.01.2014'],
	timepicker:false
});
var dateToDisable = new Date();
	dateToDisable.setDate(dateToDisable.getDate() + 2);
$('#datetimepicker11').datetimepicker({
	beforeShowDay: function(date) {
		if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
			return [false, ""]
		}

		return [true, ""];
	}
});
$('#datetimepicker12').datetimepicker({
	beforeShowDay: function(date) {
		if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
			return [true, "custom-date-style"];
		}

		return [true, ""];
	}
});
$('#datetimepicker_dark').datetimepicker({theme:'dark'})


</script>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
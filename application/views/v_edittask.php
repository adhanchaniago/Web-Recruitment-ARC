<?php $this->load->view('header.php')?>
	<title><?php echo $apptitle.judul_situs;?></title>
	<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo site_url('tiny_mce/tiny_mce.js');?>"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		width: "500",
        height: "200",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull",
		theme_advanced_buttons2 : "styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons3 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo",
		theme_advanced_buttons4 : "link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons5 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup",
		theme_advanced_buttons6 : "charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons7 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resizing_use_cookie : false,

		relative_urls : false,
		document_base_url : "<?=base_url()?>",

	});
</script>
<!-- /TinyMCE -->
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('/script/jquery.datetimepicker.css');?>"/>
<style type="text/css">

.custom-date-style {
	background-color: red !important;
}
</style>
<?php $this->load->view('header2.php')?>
<?php
$title = array(
	"name"=>"title",
	"id"=>"title",
	"maxlength"=>"100",
	"size"=>"10"
);
$content = array(
	'name' => 'content',
	'id' => 'content',
	'rows' => 10,
	'cols' => 50
);
$format = array(
	'zip' => 'zip',
	'pdf' => 'pdf',
	'txt' => 'txt'
);
$maxsize = array(
	"name"=>"maxsize",
	"id"=>"maxsize",
	"maxlength"=>"100",
	"size"=>"10",
	"type"=>"number"
);
$status = array(
	false  => 'Draft',
	true  => 'Publish'
 );
	$row=$query_result->row();
	$_id=$row->id;
	$_title=$row->title;
	$_deadline=$row->deadline;
	$_format=$row->format;
	$_maxsize=$row->maxsize;
	$_content=$row->content;
	$_published=$row->published;
	echo form_open("tasks/update/$_id");
	echo form_label("Title: ");
	echo form_input($title, set_value('title',$_title));
	echo "<br/>";
	echo form_label("Deadline: ");
	echo "<input type='text' value='$_deadline' name='deadline' id='deadline'/><br><br>";
	echo form_label("Format: ");
	echo form_dropdown("format",$format,$_format);
	echo "<br/>";
	echo form_label("Max. size: ");
	echo form_input($maxsize, set_value('maxsize',$_maxsize));
	echo "<br/>";
	echo form_label("Status: ");
	echo form_dropdown("status",$status,$_published);
	echo "<br/>";
	echo form_label("Content: ");
	echo form_textarea($content, set_value('content',$_content));
	echo "<br/>";
	//echo "<textarea class='tinyMCE'></textarea>";
	$attrsubmit ='class="button"';
	echo form_submit("","Submit",$attrsubmit);
	echo form_close();
	
?>
</body>
<script src="<?php echo site_url('script/jquery.js');?>"></script>
<script src="<?php echo site_url('script/jquery.datetimepicker.js');?>"></script>
<script>/*
window.onerror = function(errorMsg) {
	$('#console').html($('#console').html()+'<br>'+errorMsg)
}*/
$('#deadline').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
startDate:	'1986/01/05'
});
$('#deadline').datetimepicker({value:$_deadline,step:10});

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
$('#datetimepicker2').datetimepicker({
	yearOffset:222,
	lang:'ch',
	timepicker:false,
	format:'d/m/Y',
	formatDate:'Y/m/d',
	minDate:'-1970/01/02', // yesterday is minimum date
	maxDate:'+1970/01/02' // and tommorow is maximum date calendar
});
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
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
$status = array(
	false  => 'Draft',
	true  => 'Publish'
 );

	$row=$query_result->row();
	$_title=$row->title;
	$_content=$row->content;

	
	echo form_open("user/update_article/".$id);
	echo form_label("Title: ");
	echo form_input($title, set_value('title',$_title));
	echo "<br/>";
	$attrtipe= 'id="type"';
	echo form_label("Content: ");
	echo form_textarea($content, set_value('content',$_content));
	echo "<br/>";
	//echo "<textarea class='tinyMCE'></textarea>";
	$attrsubmit ='class="button"';
	echo form_submit("","Submit",$attrsubmit);
	echo form_close();
	
?>
<?php $this->load->view('post-content.php')?>
<?php $this->load->view('sidebar-loggedin.php')?>
<?php $this->load->view('post-sidebar.php')?>
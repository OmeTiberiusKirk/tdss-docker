<?php
	function tinymce($flag = true)
	{
		if($flag == true)
		{
?>
<script type="text/javascript" src="../../library/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect,bullist,numlist,outdent,indent,undo,redo",
		theme_advanced_buttons2 : "forecolor,backcolor, tablecontrols,|,hr,visualaid,media,image,fullscreen",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_default_font : "[arial|15]",

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "../../library/tinymce/res/css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "../../library/tinymce/res/lists/template_list.js",
		external_link_list_url : "../../library/tinymce/res/lists/link_list.js",
		external_image_list_url : "../../library/tinymce/res/lists/image_list.js",
		media_external_list_url : "../../library/tinymce/res/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<?php
		}
	}
?>

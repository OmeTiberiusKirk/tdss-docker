<?php
	set_time_limit(0);	
	
	/* download.php?type=db&filename=untitled-6&table=ds_config_param&field_select=template_file&refer_id=2&refer_field=var_id */
	if(isset($_REQUEST['type'], $_REQUEST['filename'], $_REQUEST['table'], $_REQUEST['refer_id'], $_REQUEST['field_select'], $_REQUEST['refer_field']) && $_REQUEST['type'] == "db") {
			require('connectdb.inc.php');
			require('function.inc.php');
			
			$sql = "SELECT `".$_REQUEST['table']."`.`".$_REQUEST['field_select']."` , `".$_REQUEST['table']."`.`name` ";
			$sql .= "FROM `".$_REQUEST['table']."` WHERE ";
			$sql .= "`".$_REQUEST['table']."`.`".$_REQUEST['refer_field']."` = ".$_REQUEST['refer_id'];

			$result = mysql_query($sql, $connection);
			if($result) {
				if ( mysql_num_rows($result) == 1 ) {
					$obj = mysql_fetch_object($result);
					$file_contents = stripslashes($obj->template_file);
					if(strlen($file_contents) < 1) {
						JSAlert('Fatal Error : Unable to load template.', '../user-menu/config/seq_p1.php?section=10');
					}
					$file_name = $obj->name;
					/*
					echo "<pre>";
					echo $file_name."\n";
					echo $file_contents;
					echo "</pre>";
					*/
					$file_path = "tmp/".$file_name."_".time();
					file_put_contents($file_path, $file_contents);
					force_download($file_path, $file_name, 'text/plain', true);
				}else
					JSAlert('Fatal Error : Duplicate  filename.', '../user/user.datasource.php');
			}
	}else {
		if ($_REQUEST['file'] && strlen($_REQUEST['file']) == 32) {
			require('connectdb.inc.php');
			require('function.inc.php');
			
			$sql = "SELECT `aliasname`, `orgname` FROM datasource WHERE `aliasname` LIKE '".$_REQUEST['file']."';";
			//echo $sql;
			$result = mysql_query($sql, $connection);
			if($result) {
				if ( mysql_num_rows($result) == 1 ) {
					$field_name = mysql_fetch_object($result);
					$org_filename = $field_name->orgname;
					$alias_filename = $field_name->aliasname;
					
					$file_path='../workspace/formulated-data/'.$alias_filename;
					force_download($file_path, $org_filename, 'text/plain');
					
				}else
					JSAlert('Fatal Error : Duplicate alias filename.', '../user/user.datasource.php');
			}
		}
	}
?>
<?php
	session_start(); 
	require_once('../../library/connectdb.inc.php');
	if($connection) {
		//echo $_REQUEST['grp_id'];
		//exit;
	    //echo "<pre>";
		//print_r($_POST);
		$field = array( 'wave', 'eta', 'zmax', 'R1', 'R2', 'R3', 'R4');
		$field_post = array();
		foreach($_POST as $var_name => $rec_id){
			if(is_array($rec_id)){
				foreach($rec_id as $id => $status){
					$update_var[$id][$var_name] = $status;
					$field_post[$id][] = $var_name;
					
				}
			}
		}
		//echo "1"; print_r($update_var);
		//echo "2"; print_r($field_post);
		foreach($field_post as $record_id => $val){
			foreach($field as $index => $value){
				if(array_search($value, $val) === FALSE){
					$sql_set[$record_id][] = $value."= 'no' ";
				}else{
					$sql_set[$record_id][] = $value."= 'yes' ";
				}
			}
		}
		//echo "33"; print_r($sql_set);
		//echo "3"; print_r($update_var); //echo "4 "; print_r($field_post);
		$select_sql = "select observ_point_id from observe_point where UID = ".$_SESSION['uid'];				
		$res = mysql_query($select_sql, $connection);
		if($res){
					if(mysql_num_rows($res) != NULL )
					{					
						$no = mysql_num_rows($res);
						for($a = 0; $a < $no; $a++){
							$obj = mysql_fetch_object($res);
							$point_id[$a] = $obj->observ_point_id;
						}
					}
		}	
		//print_r($point_id);
		$a = 0;
		foreach($sql_set as $p_id => $arr_field){
			foreach($arr_field as $field_name => $flag){	
				if($a == 0){
     				$poin_id[] = $p_id; 
					$a = 1;		
					$temp_id = $p_id;			
				}else{
					if($temp_id != $p_id){
						$a = 0;
					}
				}
				$sql[$p_id] = "UPDATE observe_point SET ".implode(",", $sql_set[$p_id])." WHERE UID = ".$_SESSION['uid']." AND observ_point_id = ".$p_id." AND `grp_id` = ".$_REQUEST['grp_id'];
			}
		}
		$coun = count($point_id);
			for($i = 0; $i < $coun; $i++){
				if(array_search($point_id[$i], $poin_id ) === FALSE){
					$sql[$point_id[$i]] = "UPDATE observe_point SET wave= 'no' ,eta= 'no' ,zmax= 'no' ,R1= 'no' ,R2= 'no' ,R3= 'no' ,R4= 'no'  WHERE UID = ".$_SESSION['uid']." AND observ_point_id = ".$point_id[$i]." AND `grp_id` = ".$_REQUEST['grp_id'];
					$results = mysql_query($sql[$point_id[$i]], $connection);
				}else{
					$results = mysql_query($sql[$point_id[$i]], $connection);
				}
			}
		//echo "</pre>";
		$dest = "observ_point.php?section=11";
		echo "<script language=javascript> location.href='".$_SERVER['HTTP_REFERER']."'; </script>";
	}else{
		$dest = "observ_point.php?section=11";
		echo "<script language=javascript> location.href='".$_SERVER['HTTP_REFERER']."'; </script>";	}	

?>
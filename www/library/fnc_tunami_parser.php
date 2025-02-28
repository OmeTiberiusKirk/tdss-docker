<?php
	

	function fnc_parser($file_contents) {
		preg_match_all("/__[a-zA-Z0-9]*_[a-zA-Z0-9]*__/", $file_contents, $string_out_array);
		$string_out[] = $string_out_array[0];
		preg_match_all("/__[a-zA-Z0-9]*__/", $file_contents, $string_out_array);
		$string_out[] = $string_out_array[0];
		foreach ($string_out as $index => $list) {
			foreach ($list as $iterator => $var_name) {
				$temp = str_replace("__", "", $var_name);
				if((strpos($temp, "NAME") === FALSE) && (strpos($temp, "_") !== FALSE)) {
					$temp = str_replace("_", "(", $temp);
					$temp[strlen($temp)] = ')';
				}
				if(@array_search($temp, $var_list) === FALSE)
					$var_list[] = $temp;		
				else {
					$dup[] = $temp;
				}
	
			}
		}
		
		if(count($dup) > 0 )
			echo "<script language=javascript>alert(' ".implode(", ", $dup)." is duplicated !'); location.href='".$_SERVER['PHP_SELF']."?section=10';</script>";
			
		sort($var_list);	
		return $var_list;
	}
?>
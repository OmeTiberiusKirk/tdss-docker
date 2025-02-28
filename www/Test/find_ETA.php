<?php
	set_time_limit(0);

	$coord = array(4, 22, 25, 17, 1, 8, 27, 26, 19, 28, 30, 29, 18, 12, 13, 20, 21, 15, 24, 7, 3, 5, 2, 10, 9, 16, 23, 6, 11, 14);
	#$coord = array(4);
	$x = array(312, 271, 240, 253, 233, 224, 196, 191, 191, 192, 181, 186, 182, 184, 203, 201, 347, 312, 195, 200, 199, 311, 442, 395, 453, 494, 528, 570, 526, 627);
	#$x = array(312);
	$y = array(291, 39, 121, 130, 152, 178, 212, 229, 267, 298, 329, 341, 368, 397, 457, 478, 494, 495, 509, 529, 541, 567, 613, 620, 649, 685, 709, 797, 809, 857);
	#$y = array(291);

	$region = 2;
	$m = "H:/tsunami_project/resources/NDWC_result/";
	#$main_path['7510'] = $m."7510_TG/";
	#$main_path['7530'] = $m."7530_TG/";
	$main_path['8010'] = $m."8010_TG/";
	#$main_path['8030'] = $m."8030_TG/";
	#$main_path['9010'] = $m."9010_TG/";
	#$main_path['9030'] = $m."9030_TG/";
	
	foreach ($main_path as $case_id => $path) {
		for ($R=1; $R<=100; $R++) {
			
			if($R < 10) $pref = "00";
			if($R >= 10 && $R <= 99) $pref = "0";
			if($R >= 100) $pref = "";
			
			$path = $main_path[$case_id].$case_id.$pref.$R."/";	
			
			$eta_file = $path."eta".$region.".out";
			$fp = fopen($eta_file, "r");
			
			$i = 1;
			$j = 1;
			$eta_val[$pref.$R] = array();
			$nX = 689;
			
			while($line = fgets($fp, 16)) {
				#$temp[$i++] =  number_format(doubleval($line)/3600, 3);
				$temp[$i++] =  (int)($line);
				if($i > $nX) {
					$eta_val[$pref.$R][$j++] = $temp;
					$i=1;
					$temp = null;
				}
			}
			fclose($fp);
			unset($temp);
		
			/**
			 * 
			 *  get ZMAX 
			 * 
			 * */
			$zmax_file = $path."zm".$region.".out";
			$fp = fopen($zmax_file, "r");
			
			$i = 1;
			$j = 1;
			$zmax_val[$pref.$R] = array();
			$temp = array();
			
			while($line = fgets($fp, 16)) {
				$temp[$i++] =  number_format(doubleval($line), 3);
				if($i > $nX) {
					$zmax_val[$pref.$R][$j++] = $temp;
					$i=1;
					$temp = null;
				}
			}
			fclose($fp);
	
			$fp = fopen("C:/Users/yod/Desktop/NDWC_result/R".$region."_".$case_id.".txt", "a");
			for($i=0; $i<count($coord); $i++) {
				fprintf($fp, $case_id.$pref.$R." ".$coord[$i]."\t=>\t".$zmax_val[$pref.$R][$y[$i]][$x[$i]]."\t".$eta_val[$pref.$R][$y[$i]][$x[$i]]."\n");
			}
			fprintf($fp, "\n\n");
			fclose($fp);
			flush();		
			unset($temp);
			unset($eta_val);
			unset($zmax_val);
			echo "! case ".$case_id.$pref.$R."\n";
		}
		echo "\n\n";
	}
?>
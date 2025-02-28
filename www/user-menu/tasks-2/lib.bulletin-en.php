<?php
	require_once('pdflib/fpdf.php');
	
	class PDF_EN extends FPDF {
		function SetThaiFont() {
			$this->AddFont('AngsanaNew','','angsa.php');
			$this->AddFont('AngsanaNew','B','angsab.php');
			$this->AddFont('AngsanaNew','I','angsai.php');
			$this->AddFont('AngsanaNew','IB','angsaz.php');
			$this->AddFont('CordiaNew','','cordia.php');
			$this->AddFont('CordiaNew','B','cordiab.php');
			$this->AddFont('CordiaNew','I','cordiai.php');
			$this->AddFont('CordiaNew','IB','cordiaz.php');
			$this->AddFont('Tahoma','','tahoma.php');
			$this->AddFont('Tahoma','B','tahomab.php');
			$this->AddFont('BrowalliaNew','','browa.php');
			$this->AddFont('BrowalliaNew','B','browab.php');
			$this->AddFont('BrowalliaNew','I','browai.php');
			$this->AddFont('BrowalliaNew','IB','browaz.php');
			$this->AddFont('KoHmu','','kohmu.php');
			$this->AddFont('KoHmu2','','kohmu2.php');
			$this->AddFont('KoHmu3','','kohmu3.php');
			$this->AddFont('MicrosoftSansSerif','','micross.php');
			$this->AddFont('PLE_Cara','','plecara.php');
			$this->AddFont('PLE_Care','','plecare.php');
			$this->AddFont('PLE_Care','B','plecareb.php');
			$this->AddFont('PLE_Joy','','plejoy.php');
			$this->AddFont('PLE_Tom','','pletom.php');
			$this->AddFont('PLE_Tom','B','pletomb.php');
			$this->AddFont('PLE_TomOutline','','pletomo.php');
			$this->AddFont('PLE_TomWide','','pletomw.php');
			$this->AddFont('DilleniaUPC','','dill.php');
			$this->AddFont('DilleniaUPC','B','dillb.php');
			$this->AddFont('DilleniaUPC','I','dilli.php');
			$this->AddFont('DilleniaUPC','IB','dillz.php');
			$this->AddFont('EucrosiaUPC','','eucro.php');
			$this->AddFont('EucrosiaUPC','B','eucrob.php');
			$this->AddFont('EucrosiaUPC','I','eucroi.php');
			$this->AddFont('EucrosiaUPC','IB','eucroz.php');
			$this->AddFont('FreesiaUPC','','free.php');
			$this->AddFont('FreesiaUPC','B','freeb.php');
			$this->AddFont('FreesiaUPC','I','freei.php');
			$this->AddFont('FreesiaUPC','IB','freez.php');
			$this->AddFont('IrisUPC','','iris.php');
			$this->AddFont('IrisUPC','B','irisb.php');
			$this->AddFont('IrisUPC','I','irisi.php');
			$this->AddFont('IrisUPC','IB','irisz.php');
			$this->AddFont('JasmineUPC','','jasm.php');
			$this->AddFont('JasmineUPC','B','jasmb.php');
			$this->AddFont('JasmineUPC','I','jasmi.php');
			$this->AddFont('JasmineUPC','IB','jasmz.php');
			$this->AddFont('KodchiangUPC','','kodc.php');
			$this->AddFont('KodchiangUPC','B','kodc.php');
			$this->AddFont('KodchiangUPC','I','kodci.php');
			$this->AddFont('KodchiangUPC','IB','kodcz.php');
			$this->AddFont('LilyUPC','','lily.php');
			$this->AddFont('LilyUPC','B','lilyb.php');
			$this->AddFont('LilyUPC','I','lilyi.php');
			$this->AddFont('LilyUPC','IB','lilyz.php');
		}
		
		function conv($string) {
			return iconv('UTF-8', 'TIS-620', $string);
		}
		
		function thai_date($time){
			$thai_day_arr = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์");
			$thai_month_arr = array(
				"0"=>"",
				"1"=>"January",
				"2"=>"February",
				"3"=>"March",
				"4"=>"April",
				"5"=>"May",
				"6"=>"June",
				"7"=>"July",
				"8"=>"August",
				"9"=>"September",
				"10"=>"October",
				"11"=>"November",
				"12"=>"December"
			); 
			//global $thai_day_arr, $thai_month_arr;
			//$thai_date_return = "วัน".$thai_day_arr[date("w",$time)];
			//$thai_date_return .= "ที่ ".date("d", $time);
			$thai_date_return  = "".date("d", $time);
			//$thai_date_return .= " เดือน".$thai_month_arr[date("n", $time)];
			$thai_date_return .= "  ".$thai_month_arr[date("n", $time)];
			//$thai_date_return .= " พ.ศ.".(date("Y", $time)+543);
			$thai_date_return .= "  ".(date("Y", $time));
			//$thai_date_return .= "เวลา ".date("H:i", $time). " น. ";
			return $thai_date_return;
		
		}
	}


	class Bulletin_EN {
	
		/* obj of pdf */
		private $pdf;
		
		/* bulletin header */	
		private $h_release;
		private $h_year;
		private $h_date;
		private $h_time;
		
		/* earthquake parameters */
		private $eq_date;
		private $eq_time;
		private $eq_richter;
		private $eq_depth;
		private $eq_gname;
		private $eq_gid;
		
		/* earthquake location */
		private $eq_latitude;
		private $eq_longitude;
		private $eq_area;
		private $eq_distance;
		private $eq_coastname;
		
		/* observation area information */
		private $ob_area = array();
		
		/* ob point string of each pages */
		private $pointString = array();
		
		public function __construct() {
			$this->pdf = new PDF_EN();
			$this->pdf->SetThaiFont();
			$this->pdf->SetMargins(20, 20);
		}
		
		public function assignHeaderInfo($release_no, $year_release, $announce_date, $announce_time) {
			$this->h_release = $release_no;
			$this->h_year = date("Y",$year_release)+39;//date("y", $time_now)+43;
			$this->h_date = $announce_date;
			$this->h_time = $announce_time;
		}
		
		public function assignEqInfo($eq_gname, $eq_gid, $eq_date, $eq_time, $richter, $depth) {
			$this->eq_gname = $eq_gname;
			$this->eq_gid = $eq_gid;
			
			if($eq_date == "(click to select date)"){
				$this->eq_date = $this->pdf->thai_date(time());
			}else{
				$time = explode("/",$eq_date);
				$date = $this->pdf->thai_date(strtotime($time[2]."-".$time[0]."-".$time[1]));
				$this->eq_date = $date;
			}
			if($eq_time == "(enter time)"){
				$this->eq_time = $this->h_time;
			}else{
				$this->eq_time = $eq_time;
			}
			$this->eq_richter = $richter;
			$this->eq_depth = $depth;
		}
		
		public function assignEqLocation($latitude, $longitude) {
			$this->eq_latitude = $latitude;
			$this->eq_longitude = $longitude;
		}
		
		public function assignObservationArea($province, $area, $eta_value, $zmax_value) {
			$c = count($this->ob_area);
			$this->ob_area[$c]['province'] = $province;
			$this->ob_area[$c]['area'] = $area;
			$this->ob_area[$c]['eta_value'] = $eta_value;
			$this->ob_area[$c]['zmax_value'] = $zmax_value;
		}
		
		public function getOutput($filename ='', $store_path = '') {
			return $this->pdf->Output($filename, $store_path);
		}
		
		private function createPointString() {
			$this->pointString = "";
			//foreach($this->ob_area as $index => $p_info) {
				//$this->pointString .= $this->Space(20).$p_info['province'].$this->Space(10).$p_info['area'].$this->Space(10).$p_info['eta_value'].$this->Space(2)."น."."";
				
			//}
		}
		
		private function Space($no) {
			$space_str = "";
			for($i=1; $i<=$no; $i++ )
				$space_str .= " ";
			return $space_str;
		}
		
		public function Create() {
			$this->createPointString();
			$this->pdf->AddPage();
			
			/*$this->pdf->SetDrawColor($r=255, $g=128, $b=0);
			$this->pdf->SetLineWidth(0.7);
			$this->pdf->Line(95, 16, 115, 16);
			$this->pdf->Line(95, 16, 95, 25);
			$this->pdf->Line(95, 25, 115, 25);
			$this->pdf->Line(115, 25, 115, 16);
			*/
			$this->pdf->SetDrawColor($r=255, $g=128, $b=0);
			$this->pdf->SetLineWidth(0.35);
			$this->pdf->Line(153, 15, 190, 15);
			$this->pdf->Line(153, 15, 153, 25);
			$this->pdf->Line(153, 25, 190, 25);
			$this->pdf->Line(190, 25, 190, 15);
			
			$this->pdf->SetFont('AngsanaNew', '', 16);
			//$txt = $this->pdf->conv("F3_2");
			//$this->pdf->Cell(0, 0, $txt, 0, 1, 'C');
	
			$this->pdf->SetTextColor(255, 0, 0);
			$txt_1 = $this->pdf->conv("IMPORTANT     ");
			$this->pdf->Cell(0, 0, $txt_1, 0, 1, 'R');
			
			$this->pdf->Ln(20);
			
			$this->pdf->SetTextColor(0, 0, 0);
			$this->pdf->SetFont('AngsanaNew', 'B', 16.5);
			$txt_2 = $this->pdf->conv("NATIONAL DISASTER WARNING CENTER");
			$this->pdf->Cell(0, 0, $txt_2, 0, 1, 'C');
			$this->pdf->Ln(8);
			
			$this->pdf->SetFont('AngsanaNew', '', 16);
			$txt_3 = $this->pdf->conv("SUBMARINE EARTHQUAKE WARNING BULLETIN");
			$this->pdf->Cell(0, 0, $txt_3, 0, 1, 'C');
			$this->pdf->Ln(8);
			
			$this->pdf->SetFont('AngsanaNew', '', 16);
			$txt_4 = $this->pdf->conv("BULLETIN NUMBER    ".$this->h_release." /".$this->h_year."");
			$this->pdf->Cell(0, 0, $txt_4, 0, 1, 'C');
			//$this->pdf->MultiCell(0, 9, $txt, 0, 'J');
			$this->pdf->Image('pdflib/LOGO_NDWC.jpg', 35, 35, 22);
			$this->pdf->Ln(10);
			
			$this->pdf->SetFont('AngsanaNew', '', 15);
			$txt_5 = $this->pdf->conv("TO               RELATED AUTHORITIES." );
			$this->pdf->Cell(0, 0, $txt_5, 0, 1, 'L');
			$this->pdf->Ln(7);
			
			$this->pdf->SetFont('AngsanaNew', '', 18);
			$date = $this->pdf->thai_date(time());
			$txt_6 = $this->pdf->conv("Date         ".$date."           Time     ".date("H:i", time())."      " );
			$this->pdf->Cell(0, 0, $txt_6, 0, 1, 'L');
			$this->pdf->Ln(7);
			
			$this->pdf->SetFont('AngsanaNew', '', 15);
			$txt_7 = $this->pdf->conv("SITUATION" );
			$this->pdf->Cell(0, 0, $txt_7, 0, 1, 'L');
			$this->pdf->SetDrawColor($r=0, $g=0, $b=0);
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(21, 82, 40, 82);
			$this->pdf->Ln(4);
			
			$this->pdf->SetFont('AngsanaNew', '', 18);
			$txt_8 = $this->pdf->conv("     On  ".$this->eq_date.",  at  ".$this->eq_time.",   a  ".$this->eq_richter."  magnitude earthquake has occurred about ".$this->eq_depth."  km undersea." );
			$this->pdf->MultiCell(0, 7, $txt_8, 0, 'J');
			$this->pdf->Ln(5);
			
			$this->pdf->SetFont('AngsanaNew', '', 15);
			$txt_8 = $this->pdf->conv("LOCATION");
			$this->pdf->Cell(0, 0, $txt_8, 0, 1, 'L');
			$this->pdf->SetDrawColor($r=0, $g=0, $b=0);
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(21, 105, 39.5, 105);
			$this->pdf->Ln(4);
			
			$this->pdf->SetFont('AngsanaNew', '', 18);
			$txt_8 = $this->pdf->conv("         The earthquake's center was at lattitude  ".(round($this->eq_latitude, 2) < 0 ? round($this->eq_latitude, 2)*(-1) : round($this->eq_latitude, 2))."   ".(round($this->eq_latitude) > 0 ? "degree N " : "degree S").",  longitude   ".(round($this->eq_longitude, 2) < 0 ? round($this->eq_longitude, 2)*(-1) : round($this->eq_longitude, 2)).(round($this->eq_longitude) > 0 ? "  degree E " : "  degree W"));
			$this->pdf->MultiCell(0, 7, $txt_8, 0, 'J');
			$this->pdf->Ln(5);
			
			$this->pdf->SetFont('AngsanaNew', '', 15);
			$txt_9 = $this->pdf->conv("EVALUATION");
			$this->pdf->Cell(0, 0, $txt_9, 0, 1, 'L');
			$this->pdf->SetDrawColor($r=0, $g=0, $b=0);
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(21, 121, 44.5, 121);
			$this->pdf->Ln(4);
			
			$this->pdf->SetFont('AngsanaNew', '', 18);
			$txt_10 = $this->pdf->conv("          There is a  possibility of a tsunami. A Tsunami warning is in effect." );
			$this->pdf->MultiCell(0, 7, $txt_10, 0, 'J');
			$this->pdf->Ln(5);
			
			$this->pdf->SetFont('AngsanaNew', '', 15);
			$txt_11 = $this->pdf->conv("ADVICE");
			$this->pdf->Cell(0, 0, $txt_11, 0, 1, 'L');
			$this->pdf->SetDrawColor($r=0, $g=0, $b=0);
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(21, 137, 35, 137);
			$this->pdf->Ln(4);
			
			$this->pdf->SetFont('AngsanaNew', '', 18);
			
			if($this->eq_gid == 1) {
				$s1 = "The Andaman sea of Thailand";
			}else {
				$s1 = "the gulf of Thailand";
			}
			
			$txt_12 = $this->pdf->conv("          This tsunami may have been destructive along coastlines of ".$s1."
             -  Issue a tsunami warning and  evacuate people to save area.
             -  Prepare for  appropaiate disaster relief plans in affected areas.
             -  Monitor the situation and further announcement.
			" );
			$this->pdf->MultiCell(0, 7, $txt_12, 0, 'J');
			
			$this->pdf->SetFont('AngsanaNew', '', 15);
			$txt_13 = $this->pdf->conv("OTHER ADVICE");
			$this->pdf->Cell(0, 0, $txt_13, 0, 1, 'L');
			$this->pdf->SetDrawColor($r=0, $g=0, $b=0);
			$this->pdf->SetLineWidth(0.2);
			$this->pdf->Line(21, 176, 47, 176);
			$this->pdf->Ln(4);
			
			$this->pdf->SetFillColor(134, 4, 40);
			$this->pdf->SetFont('AngsanaNew', '', 18);
			$txt_14 = $this->pdf->conv("          Estimated initial tsunami wave arrival times at the warning areas are given below." );
			$this->pdf->MultiCell(0, 7, $txt_14, 0, 'J');
			$this->pdf->Ln(3);

			$this->pdf->Line(33, 187, 182, 187);
			$this->pdf->Line(33, 195, 182, 195);
			
			$this->pdf->SetFont('AngsanaNew', '', 15);
			$txt_14 = $this->pdf->conv("                         District                      Location                  Estimated Time of Arrival             Tsunami Height (m)" );
			
			$this->pdf->MultiCell(0, 7, $txt_14, 0, 'L');
			
			
			//$txt_15 = $this->pdf->conv($this->pointString);
			//$this->pdf->MultiCell(0, 8, $txt_15, 0, 'L');
			$xx = 35; $yy = 200.5;  $xx2 = 35; $yy2 = 45;
			$yy_column = 202; $yy2_col = 47;
			$yy_row = 202; $yy2_row = 47;
			/* page 3 */
			$xx3 = 35; $yy3 = 45;
			$yy3_col = 47;
			$yy3_row = 47;
			$line = 1; 
			
			$check_page_2 = 1; $check_page_3 = 1;
			foreach($this->ob_area as $index => $p_info) {
				
				$pointStr_province = $p_info['province'];
				$pointStr_area = $p_info['area'];
				
				$time = explode(":", $this->eq_time);
				
				$hr = explode(".", $p_info['eta_value']);
				$hour = $hr[0] + $time[0];
				
				$min = "0.".$hr[1]; 
				$mins = $min * 60;
				$minutes = explode(".", $mins);	
				$minute = $minutes[0] + $time[1];
								
				$sec = "0.".$minutes[1];
				$sec = $sec * 60;
				$secs = explode(".", $sec);
				$second = $secs[0] + $time[2];
				// check second if more than 60
				if($second > 60){
					$second = $second - 60;
					$minute = $minute + 1;
					if($minute > 60){
						$minute = $minute - 60;
						$hour = $hour + 1;
						if($hour > 24 ){
							$hour = $hour - 24;
						}
					}
				}
				// check minute if more than 60
				if($minute > 60 ){
					$minute = $minute - 60;
					$hour = $hour +1;
					if($hour > 24){
						$hour = $hour -24;
					}
				}
				/// check hour if more than 24
				if($hour > 24 ){
					$hour = $hour - 24;
				}
				if($hour == 24){
					$hour = 0;
				}
				
				if($hour < 10)
					$hour = "0".$hour;
				if($minute < 10)
					$minute = "0".$minute;
				if($second < 10)
					$second = "0".$second;
				
				$pointStr_eta = $hour.":".$minute.":".$second;//$p_info['eta_value'];//.":".$minut;//$p_info['eta_value'];
				if($p_info['eta_value'] == 0)
					$pointStr_eta = "       -";

				$pointStr_eta_unit = "";
				$pointStr_zmax = $p_info['zmax_value'];
				$pointStr_zmax_unit = "";
				$txt_15 = $this->pdf->conv($pointStr_province);
				$txt_16 = $this->pdf->conv($pointStr_area);
				$txt_17 = $this->pdf->conv($pointStr_eta);
				$txt_17_1 = $this->pdf->conv($pointStr_eta_unit);
				$txt_18 = $this->pdf->conv($pointStr_zmax);
				$txt_18_1 = $this->pdf->conv($pointStr_zmax_unit);
				if($line < 10 ){	
					$this->pdf->Text($xx, $yy, $txt_15);
					$this->pdf->Text($xx+33 , $yy, $txt_16);
					$this->pdf->Text($xx+76 , $yy, $txt_17);
					$this->pdf->Text($xx+88 , $yy, $txt_17_1);
					$this->pdf->Text($xx+121 , $yy, $txt_18);
					$this->pdf->Text($xx+130 , $yy, $txt_18_1);
					/* table column */
					$this->pdf->Line(33, 187, 33, $yy_column);
					$this->pdf->Line(65, 187, 65, $yy_column);
					$this->pdf->Line(98, 187, 98, $yy_column);
					$this->pdf->Line(140, 187, 140, $yy_column);
					$this->pdf->Line(182, 187, 182, $yy_column);
					
					$this->pdf->Line(33, $yy_row, 182, $yy_row);
					
					
					$yy = $yy + 8; 
					$yy_column = $yy_column + 8;
					$yy_row = $yy_row + 8;
					if($this->eq_gid == 2 && $line == 5){
						$txt_19 = $this->pdf->conv("   NATIONAL DISASTER WARNING CENTER");
						$txt_20 = $this->pdf->conv("   RATTANATHIBET ROAD, BANG KRA SOR, ");
						$txt_21 = $this->pdf->conv("   MUANG, NONTABURI, 11000, THAILAND.");
						$txt_22 = $this->pdf->conv("   TEL.   1860   FAX. 0-2589-2497 EXT. 22 ");
						$this->pdf->Text(30 , $yy+8, $txt_19);
						$this->pdf->Text(30 , $yy+16, $txt_20);
						$this->pdf->Text(30 , $yy+24, $txt_21);
						$this->pdf->Text(30 , $yy+32, $txt_22);
						
						$this->pdf->SetFont('AngsanaNew', '', 17);
						$this->pdf->SetTextColor(0, 0, 255);
						$txt_20 = $this->pdf->conv("www.ndwc.or.th");
						$this->pdf->Text(32, $yy+40, $txt_20);
						//$link = $this->pdf->Link(30, $yy2+40, 50, 10, $txt_20);
						//$this->pdf->MultiCell(0, 8, $yy2+40, 0, 'L');
			
						$this->pdf->SetDrawColor($r=0, $g=0, $b=255);
						$this->pdf->SetLineWidth(0.2);
						$this->pdf->Line(32, $yy+41, 59, $yy+41);
						$this->pdf->Ln(4);
					}	
					
			
				}elseif($line > 9 && $line < 39){
					if($check_page_2 == 1){
						$this->pdf->AddPage();
						$page = $this->pdf->PageNo();
						$this->pdf->Cell(0, 0, $page, 0, 1, 'C');
					    $this->pdf->Ln(12);
					
					    $txt_14 = $this->pdf->conv("                         District                      Location                  Estimated Time of Arrival             Tsunami Height (m)" );
					    $this->pdf->MultiCell(0, 7, $txt_14, 0, 'L');
						$check_page_2 = 0;
						/* create table */
						
						$this->pdf->Line(33, $yy2_row-8, 182, $yy2_row-8);
						$this->pdf->Line(33, $yy2_row-16, 182, $yy2_row-16);
					}else{}
			
					$this->pdf->Text($xx2, $yy2, $txt_15);
					$this->pdf->Text($xx2+33 , $yy2, $txt_16);
					$this->pdf->Text($xx2+76 , $yy2, $txt_17);
					$this->pdf->Text($xx2+88 , $yy2, $txt_17_1);					
					$this->pdf->Text($xx2+121 , $yy2, $txt_18);
					$this->pdf->Text($xx2+130 , $yy2, $txt_18_1);
					/* create table */
					$this->pdf->Line(33, 31, 33, $yy2_col);
					$this->pdf->Line(65, 31, 65, $yy2_col);
					$this->pdf->Line(98, 31, 98, $yy2_col);
					$this->pdf->Line(140, 31, 140, $yy2_col);
					$this->pdf->Line(182, 31, 182, $yy2_col);
					
					$this->pdf->Line(33, $yy2_row, 182, $yy2_row);
					$yy2 = $yy2 + 8; 
					$yy2_row = $yy2_row + 8;
					$yy2_col = $yy2_col + 8;
					$new_line = $yy2;
				}elseif($line > 38){
					if($check_page_3 == 1){
						$this->pdf->AddPage();
						$page = $this->pdf->PageNo();
						$this->pdf->Cell(0, 0, $page, 0, 1, 'C');
					    $this->pdf->Ln(12);
					
					    $txt_14 = $this->pdf->conv("                         District                      Location                  Estimated Time of Arrival             Tsunami Height (m)" );
					    $this->pdf->MultiCell(0, 7, $txt_14, 0, 'L');
						$check_page_3 = 0;
						
						$this->pdf->Line(33, $yy3_row-8, 182, $yy3_row-8);
						$this->pdf->Line(33, $yy3_row-16, 182, $yy3_row-16);
					}else{}
			
					$this->pdf->Text($xx3, $yy3, $txt_15);
					$this->pdf->Text($xx3+33 , $yy3, $txt_16);
					$this->pdf->Text($xx3+76 , $yy3, $txt_17);
					$this->pdf->Text($xx3+88 , $yy3, $txt_17_1);
					$this->pdf->Text($xx3+121 , $yy3, $txt_18);
					$this->pdf->Text($xx3+130 , $yy3, $txt_18_1);
					/* create table */
					$this->pdf->Line(33, 31, 33, $yy3_col);
					$this->pdf->Line(65, 31, 65, $yy3_col);
					$this->pdf->Line(98, 31, 98, $yy3_col);
					$this->pdf->Line(140, 31, 140, $yy3_col);
					$this->pdf->Line(182, 31, 182, $yy3_col);
					
					$this->pdf->Line(33, $yy3_row, 182, $yy3_row);
					$yy3 = $yy3 + 8; 
					$yy3_row = $yy3_row + 8;
					$yy3_col = $yy3_col + 8;
					
					//if($this->eq_gid == 2)
						//$new_line = $yy;
					//else
						$new_line = $yy3;
				}
				$line++;
		
			}
			if( $line >= 9){
				$txt_19 = $this->pdf->conv("   NATIONAL DISASTER WARNING CENTER");
				$txt_20 = $this->pdf->conv("   RATTANATHIBET ROAD, BANG KRA SOR, ");
				$txt_21 = $this->pdf->conv("   MUANG, NONTABURI, 11000, THAILAND.");
				$txt_22 = $this->pdf->conv("   TEL.   1860   FAX. 0-2589-2497 EXT. 22 ");
				$this->pdf->Text(30 , $new_line+8, $txt_19);
				$this->pdf->Text(30 , $new_line+16, $txt_20);
				$this->pdf->Text(30 , $new_line+24, $txt_21);
				$this->pdf->Text(30 , $new_line+32, $txt_22);
													
				
				$this->pdf->SetFont('AngsanaNew', '', 17);
				$this->pdf->SetTextColor(0, 0, 255);
				$txt_20 = $this->pdf->conv("www.ndwc.or.th");
				$this->pdf->Text(32, $new_line+40, $txt_20);
				//$link = $this->pdf->Link(30, $yy2+40, 50, 10, $txt_20);
				//$this->pdf->MultiCell(0, 8, $yy2+40, 0, 'L');
	
				$this->pdf->SetDrawColor($r=0, $g=0, $b=255);
				$this->pdf->SetLineWidth(0.2);
				$this->pdf->Line(32, $new_line+41, 59, $new_line+41);
				$this->pdf->Ln(4);
			}
			/**/			
			//s$this->pdf->Output("eng.pdf");
			//$this->pdf->Output("eng.pdf");
		}	
	}

?>

<?php
require('fpdf.php');

class PDF extends FPDF {
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
}

$pdf = new PDF();

$pdf->SetThaiFont();

$pdf->SetMargins(20, 20);

$pdf->AddPage();


$pdf->SetDrawColor($r=255, $g=128, $b=0);
$pdf->SetLineWidth(0.7);
$pdf->Line(95, 16, 115, 16);
$pdf->Line(95, 16, 95, 25);
$pdf->Line(95, 25, 115, 25);
$pdf->Line(115, 25, 115, 16);

$pdf->SetDrawColor($r=255, $g=128, $b=0);
$pdf->SetLineWidth(0.35);
$pdf->Line(153, 15, 190, 15);
$pdf->Line(153, 15, 153, 25);
$pdf->Line(153, 25, 190, 25);
$pdf->Line(190, 25, 190, 15);
$pdf->SetFont('AngsanaNew', '', 16);
$txt = $pdf->conv("F3_2");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');


$pdf->SetTextColor(255, 0, 0);
$txt_1 = $pdf->conv("ข้อความสำคัญมาก   ");
$pdf->Cell(0, 0, $txt_1, 0, 1, 'R');

$pdf->Ln(20);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('AngsanaNew', 'B', 16.5);
$txt_2 = $pdf->conv("ศูนย์เตือนภัยพิบัติแห่งชาติ");
$pdf->Cell(0, 0, $txt_2, 0, 1, 'C');
$pdf->Ln(8);

$pdf->SetFont('AngsanaNew', '', 16);
$txt_3 = $pdf->conv("แจ้งเตือนแผ่นดินไหวในทะเล");
$pdf->Cell(0, 0, $txt_3, 0, 1, 'C');
$pdf->Ln(8);

$pdf->SetFont('AngsanaNew', '', 16);
$txt_4 = $pdf->conv("ฉบับที่       /52");
$pdf->Cell(0, 0, $txt_4, 0, 1, 'C');
//$pdf->MultiCell(0, 9, $txt, 0, 'J');
$pdf->Image('LOGO_NDWC.jpg', 55, 38, 22);
$pdf->Ln(10);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_5 = $pdf->conv("ถึง        ผู้เกี่ยวข้องและผู้ปฎิบัติ" );
$pdf->Cell(0, 0, $txt_5, 0, 1, 'L');
$pdf->Ln(7);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_6 = $pdf->conv("วันที่     .................        เวลา ................ น." );
$pdf->Cell(0, 0, $txt_6, 0, 1, 'L');
$pdf->Ln(7);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_7 = $pdf->conv("สถานการณ์" );
$pdf->Cell(0, 0, $txt_7, 0, 1, 'L');
$pdf->SetDrawColor($r=0, $g=0, $b=0);
$pdf->SetLineWidth(0.2);
$pdf->Line(21, 82, 37, 82);
$pdf->Ln(4);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_8 = $pdf->conv("            เมื่อวันที่ ........................       เวลา ................... น.   ได้เกิดแผ่นดินไหวในทะเล ขนาด ......... ริกเตอร์ 
 ที่ความลึกใต้ผิวโลก ............. กิโลเมตร" );
$pdf->MultiCell(0, 7, $txt_8, 0, 'J');
$pdf->Ln(5);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_8 = $pdf->conv("สถานที่เกิดเหตุ");
$pdf->Cell(0, 0, $txt_8, 0, 1, 'L');
$pdf->SetDrawColor($r=0, $g=0, $b=0);
$pdf->SetLineWidth(0.2);
$pdf->Line(21, 105, 42, 105);
$pdf->Ln(4);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_8 = $pdf->conv("          ศูนย์กลางที่ ละติจูด ............. องศาเหนือ    ลองจิจูด ................. องศาตะวันออก บริเวณ ......................      ระยะห่าง ............ กิโลเมตร จากชายฝั่ง .............. ของไทย " );
$pdf->MultiCell(0, 7, $txt_8, 0, 'J');
$pdf->Ln(5);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_9 = $pdf->conv("การประเมินสถานการณ์");
$pdf->Cell(0, 0, $txt_9, 0, 1, 'L');
$pdf->SetDrawColor($r=0, $g=0, $b=0);
$pdf->SetLineWidth(0.2);
$pdf->Line(21, 128, 54, 128);
$pdf->Ln(4);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_10 = $pdf->conv("          คาดว่ามีโอกาสที่จะเกิดคลื่นสึนามิ  เป็นเกณฑ์แจ้งเตือนภัย" );
$pdf->MultiCell(0, 7, $txt_10, 0, 'J');
$pdf->Ln(5);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_11 = $pdf->conv("คำแนะนำ");
$pdf->Cell(0, 0, $txt_11, 0, 1, 'L');
$pdf->SetDrawColor($r=0, $g=0, $b=0);
$pdf->SetLineWidth(0.2);
$pdf->Line(21, 144, 35, 144);
$pdf->Ln(4);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_12 = $pdf->conv("          ภัยคลื่นสึนามิ  อาจเป็นอันตรายต่อพื้นที่บริเวณแนวชายฝั่ง จังหวัดภูเก็ต พังงา กระบี่ ระนอง สตูล และตรัง 
          -  ให้แจ้งเตือนภัยและอพยพประชาชนไปยังพื้นที่ปลอดภัย
          -  ให้เตรียมปฏิบัติตามแผนบรรเทาสาธารณภัยบริเวณพื้นที่รับผิดชอบ
          -  ให้ติดตามสถานการณ์และเฝ้าฟังการแจ้งข่าวเพิ่มเติม
" );
$pdf->MultiCell(0, 7, $txt_12, 0, 'J');
$pdf->Ln(5);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_13 = $pdf->conv("คำแนะนำอื่นๆ");
$pdf->Cell(0, 0, $txt_13, 0, 1, 'L');
$pdf->SetDrawColor($r=0, $g=0, $b=0);
$pdf->SetLineWidth(0.2);
$pdf->Line(21, 181, 41, 181);
$pdf->Ln(4);

$pdf->SetFillColor(134, 4, 40);
$pdf->SetFont('AngsanaNew', '', 15);
$txt_14 = $pdf->conv("          คาดว่าเวลาที่คลื่นสึนามิ    จะกระทบฝั่งตามหาดต่างๆ  ดังนี้" );
$pdf->MultiCell(0, 7, $txt_14, 0, 'J');
$pdf->Ln(3);


$pdf->Line(55, 192, 55, 272);
$pdf->Line(80, 192, 80, 272);
$pdf->Line(107, 192, 107, 272);
$pdf->Line(166, 192, 166, 272);

$pdf->Line(55, 192, 166, 192);
$pdf->Line(55, 200, 166, 200);
$pdf->Line(55, 208, 166, 208);
$pdf->Line(55, 216, 166, 216);
$pdf->Line(55, 224, 166, 224);
$pdf->Line(55, 232, 166, 232);
$pdf->Line(55, 240, 166, 240);
$pdf->Line(55, 248, 166, 248);
$pdf->Line(55, 256, 166, 256);
$pdf->Line(55, 264, 166, 264);
$pdf->Line(55, 272, 166, 272);


$txt_14 = $pdf->conv("                                                จังหวัด                  พื้นที่                 เวลาคาดว่าคลื่นสึนามิจะกระทบหาด   " );

$pdf->MultiCell(0, 7, $txt_14, 0, 'L');

$txt_15 = $pdf->conv("                                                ระนอง            บ้านทะเลนอก    	                                                  น.
                                                ระนอง            หาดประพาส                                                        น.
                                                ระนอง            แหลมพ่อตา                                                          น.
                                                ระนอง            ปากน้ำระนอง                                                       น.
                                                ระนอง            หาดบางเทา                                                           น.
                                                พังงา               เกาะเมียง                                                               น.
                                                พังงา               ท้ายเหมือง                                                            น.    
                                                พังงา               ทับละมุ       	                                                          น.
                                                พังงา               เกาะคอเขา                                                            น.
" );
$pdf->MultiCell(0, 8, $txt_15, 0, 'L');


$pdf->AddPage();
$page = $pdf->PageNo();
$pdf->Cell(0, 0, $page, 0, 1, 'C');
$pdf->Ln(12);


$pdf->Line(55, 30, 55, 207);
$pdf->Line(80, 30, 80, 207);
$pdf->Line(108, 30, 108, 207);
$pdf->Line(166, 30, 166, 207);

$pdf->Line(55, 30, 166, 30);
$pdf->Line(55, 39, 166, 39);
$pdf->Line(55, 47, 166, 47);
$pdf->Line(55, 55, 166, 55);
$pdf->Line(55, 63, 166, 63);
$pdf->Line(55, 71, 166, 71);
$pdf->Line(55, 79, 166, 79);
$pdf->Line(55, 87, 166, 87);
$pdf->Line(55, 95, 166, 95);
$pdf->Line(55, 103, 166, 103);
$pdf->Line(55, 111, 166, 111);
$pdf->Line(55, 119, 166, 119);
$pdf->Line(55, 127, 166, 127);
$pdf->Line(55, 135, 166, 135);
$pdf->Line(55, 143, 166, 143);
$pdf->Line(55, 151, 166, 151);
$pdf->Line(55, 159, 166, 159);
$pdf->Line(55, 159, 166, 159);

$pdf->Line(55, 167, 166, 167);
$pdf->Line(55, 175, 166, 175);
$pdf->Line(55, 183, 166, 183);
$pdf->Line(55, 191, 166, 191);
$pdf->Line(55, 199, 166, 199);
$pdf->Line(55, 207, 166, 207);

$txt_16 = $pdf->conv("                                                จังหวัด                  พื้นที่                 เวลาคาดว่าคลื่นสึนามิจะกระทบหาด   " );

$pdf->MultiCell(0, 6, $txt_16, 0, 'L');

$txt_17 = $pdf->conv("                                                พังงา              เกาะพระทอง    	                                                   น.
                                                พังงา              คุระบุรี                                                                 น.
                                                พังงา              บ้านน้ำเค็ม                                                           น.
                                                พังงา              เขาหลัก                                                                น.
                                                พังงา              แหลมปะการัง                                                     น.
                                                ภูเก็ต              หาดกะรน                                                            น.
                                                ภูเก็ต              หาดป่าตอง                                                          น.
                                                ภูเก็ต              หาดท่าฉัตรไชย       	                                            น.
                                                ภูเก็ต              ไนยาง                                                                  น.
                                                ภูเก็ต              บางเทา                                                                 น.
                                                กระบี่              เกาะพีพี                                                               น.
                                                กระบี่              เกาะลันตา                                                           น.
                                                กระบี่             หาดนพรัตน์ธารา                                                 น.
                                                กระบี่             ปากน้ำกระบี่                                                        น.
                                                ตรัง               หาดเจ้าไหม                                                          น.
                                                ตรัง               หาดตรัง       	                                                         น.
                                                ตรัง               หาดสำราญ                                                           น.	
                                                ตรัง               ปะเหลียน                                                             น.
                                                สตูล               ละงู                                                                      น.
                                                สตูล               เกาะตะรุเตา                                                         น.
                                                สตูล               บ้านตำมะลัง                                                        น." );
$pdf->MultiCell(0, 8, $txt_17, 0, 'L');
$pdf->Ln(10);

$txt_18 = $pdf->conv("ศูนย์เตือนภัยพิบัติแห่งชาติ
อาคารศูนย์สื่อสารดาวเทียมในประเทศ 
ถ.รัตนาธิเบศร์ ต.บางกระสอ อ.เมือง จ.นนทบุรี 11000
โทร.   1860   โทรสาร. 0-2589-2497 ต่อ 22");
$pdf->MultiCell(0, 8, $txt_18, 0, 'L');
$pdf->Ln(4);

$pdf->SetFont('AngsanaNew', '', 17);
$pdf->SetTextColor(0, 0, 255);
$txt_18 = $pdf->conv("www.ndwc.or.th");
$pdf->Text(22, 252, $txt_18);
$link = $pdf->Link(22, 252, 50, 10, $txt_18);
$pdf->MultiCell(0, 8, $link, 0, 'L');

$pdf->SetDrawColor($r=0, $g=0, $b=255);
$pdf->SetLineWidth(0.2);
$pdf->Line(22, 252.5, 48.5, 252.5);
$pdf->Ln(4);

$pdf->Output();
?>

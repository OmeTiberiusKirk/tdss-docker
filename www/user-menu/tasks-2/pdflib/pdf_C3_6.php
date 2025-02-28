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
$txt = $pdf->conv("C3_6");
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

$txt_3 = $pdf->conv("แจ้งเตือนภัยสึนามิ");
$pdf->Cell(0, 0, $txt_3, 0, 1, 'C');
$pdf->Ln(8);

$pdf->SetFont('AngsanaNew', '', 16);
$txt_4 = $pdf->conv("ฉบับที่ .......... ");
$pdf->Cell(0, 0, $txt_4, 0, 1, 'C');
$pdf->Ln(7);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_4 = $pdf->conv("วันที่  17  มีนาคม  2552     เวลา 1:40 น. ");
$pdf->Cell(0, 0, $txt_4, 0, 1, 'C');

$pdf->Image('LOGO_NDWC.jpg', 55, 38, 22);
$pdf->Ln(10);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_5 = $pdf->conv("เรียน          ฝ่ายข่าว" );
$pdf->Cell(0, 0, $txt_5, 0, 1, 'L');
$pdf->Ln(7);

$txt_6 = $pdf->conv("ข่าวอักษรวิ่ง" );
$pdf->Cell(0, 0, $txt_6, 0, 1, 'L');
$pdf->SetDrawColor($r=0, $g=0, $b=0);
$pdf->SetLineWidth(0.2);
$pdf->Line(21, 82, 38, 82);
$pdf->Ln(4);

$pdf->SetFont('AngsanaNew', '', 15);
$txt_7 = $pdf->conv("เมื่อเวลา     .....................   น.   ได้เกิดแผ่นดินไหวในทะเลขนาด   ............   ริกเตอร์     บริเวณ   ......................     
ระยะทาง   .....................   กิโลเมตร.   จากชายฝั่งทะเลภูเก็ตของไทย
                                                                 เวลาที่คลื่นสึนามิ  จะกระทบฝั่งตามสถานที่ต่าง ๆ ดังนี้" );
$pdf->MultiCell(0, 9, $txt_7, 0, 'J');

$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('AngsanaNew', 'B', 18);
$txt_8 = $pdf->conv("มีโอกาสสูงที่จะเกิดสึนามิ");
$pdf->text(122, 99, $txt_8);
$txt_9 = $pdf->conv("ให้อพยพไปที่ปลอดภัยโดยเร็ว");
$pdf->text(21, 108, $txt_9);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('AngsanaNew', '', 15);
$txt_10 = $pdf->conv("ระนอง               บ้านทะเลนอก      ..............    น.      หาดประพาส      ...............    น.      แหลมพ่อตา          ...............    น.
                          ปากน้ำระนอง      ...............    น.      หาดบางเทา        ...............    น.
พังงา                  เกาะเมียง             ................   น.      ท้ายเหมือง          ...............    น.      ทับละมุ                ................    น.
                          เกาะคอเขา           ...............    น.      เกาะพระทอง      ..............     น.      คุระบุรี                  ...............    น.
                          บ้านน้ำเค็ม          ...............    น.       เขาหลัก              ...............    น.       แหลมปะการัง      ...............   น.
ภูเก็ต                 หาดกะรน            ...............    น.      หาดป่าตอง          ...............    น.      หาดท่าฉัตรไชย     ...............   น.
                         ไนยาง                  ................   น.       บางเทา                ...............    น.
กระบี่                เกาะพีพี               ...............    น.       เกาะลันตา           ...............    น.      หาดนพรัตน์ธารา  ...............    น.
                         ปากน้ำกระบี่        ...............    น.
ตรัง                  หาดเจ้าไหม          ...............    น.       หาดตรัง    	          ...............    น.      หาดสำราญ      ................   น.
                          ปะเหลียน            ...............    น.
สตูล                  ละงู                     ...............    น.        เกาะตะรุเตา         ...............    น.      บ้านตำมะลัง      ...............    น." );
$pdf->MultiCell(0, 8, $txt_10, 0, 'L');

$pdf->Ln(3);

$pdf->Line(21, 123, 31, 123);
$pdf->Line(21, 139, 28.5, 139);
$pdf->Line(21, 163, 28.5, 163);
$pdf->Line(21, 179, 29, 179);
$pdf->Line(21, 195, 27, 195);
$pdf->Line(21, 211, 27.5, 211);


$txt_11 = $pdf->conv("และให้ติดตามข้อมูลเพิ่มเติม จากศูนย์เตือนภัยพิบัติแห่งชาติ หมายเลขโทรศัพท์ 1860");
$pdf->MultiCell(0, 8, $txt_11, 0, 'L');
$txt_11 = $pdf->conv("");
$pdf->MultiCell(0, 12, $txt_11, 0, 'L');

$txt_18 = $pdf->conv("               ศูนย์เตือนภัยพิบัติแห่งชาติ                                                                           ลงชื่อ         ..........................................
               อาคารศูนย์สื่อสารดาวเทียมในประเทศ                                                                             หัวหน้าเวรประจำวัน
               ถ.รัตนาธิเบศร์ ต.บางกระสอ อ.เมือง จ.นนทบุรี 11000
               โทร.   1860   โทรสาร. 0-2589-6008");
$pdf->MultiCell(0, 8, $txt_18, 0, 'L');


$pdf->SetFont('AngsanaNew', '', 17);
$pdf->SetTextColor(0, 0, 255);
$txt_12 = $pdf->conv("www.ndwc.or.th");
$pdf->Text(35, 272, $txt_12);
$link = $pdf->Link(35, 272, 50, 10, $txt_12);
$pdf->MultiCell(0, 8, $link, 0, 'L');

$pdf->SetDrawColor($r=0, $g=0, $b=255);
$pdf->SetLineWidth(0.2);
$pdf->Line(35, 272.5, 61.5, 272.5);


$pdf->Output();
?>

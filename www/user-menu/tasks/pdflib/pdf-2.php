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

$pdf->SetFont('AngsanaNew', 'B', 20);
$txt = $pdf->conv("การเรียก Google Bot ให้มาที่เว็บเรา");
$pdf->Cell(0, 0, $txt, 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('AngsanaNew', '', 16);
$txt = $pdf->conv("เมื่อเราทำเว็บไซต์เสร็จแล้ว หากต้องการให้ Google รู้จักเว็บเรานั้น ควรเข้าไปที่ http://www.google.com/addurl เพื่อที่จะให้ Bot ของ Google เข้ามาที่เว็บเรา โดยจะต้องกรอก URL ของเว็บไซต์ลงไป ซึ่งส่วนของ Comment นั้นไม่จำเป็นต้องกรอกข้อมูล ดังรูปด้านล่าง");
$pdf->MultiCell(0, 7, $txt, 0, 'J');

$pdf->Ln(72);

$pdf->Image('google_addurl_1.jpg', 59, 52, 100);

$txt = $pdf->conv("หากกรอกข้อมูลเสร็จและส่งข้อมูลแล้ว จะได้ดังรูปด้านล่างนี้");
$pdf->MultiCell(0, 7, $txt, 0, 'J');

$pdf->Image('google_addurl_2.jpg', 59, 132, 100);
$pdf->Output();
?>

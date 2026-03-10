<?php

session_start();
include "config/base.php";
include('../../cdn/TCPDF-main/config/tcpdf_config_alt.php');
include('../../cdn/TCPDF-main/tcpdf.php');

$Sheet_No = $_GET['Sheet_No'];
$LogSheet = Select_Logsheet($_GET['Sheet_No']);
$List_File = List_File($_GET['Sheet_No']);
$item_arr = explode(',', $LogSheet['ItemID']);

$item1 = in_array('6', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item2 = in_array('7', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item3 = in_array('8', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item4 = in_array('9', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item5 = in_array('14', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item6 = in_array('10', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item7 = in_array('11', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item8 = in_array('12', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item9 = in_array('15', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item10 = in_array('13', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item10_remark = in_array('13', $item_arr) ? $LogSheet['ItemOth'] : '';

// echo "<pre>";
// print_r($LogSheet);
// exit();

$date = date_format(DateTime::createFromFormat("Y-m-d H:i:s.u", $LogSheet['Sheet_Date']), 'd/m/Y');
$LeadOut_Date = date_format(DateTime::createFromFormat("Y-m-d H:i:s.u", $LogSheet['LeadOut_Date']), 'd/m/Y');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('ASEFA');
$pdf->setTitle('Logsheet Center');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->setHeaderData(PDF_HEADER_LOGO, 15, "บริษัท อาซีฟา จำกัด มหาชน", "Asefa Public Company limited", array(0,64,245), array(0,64,118));
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
// $pdf->setHeaderFont(array("thsarabun", 'B', 11));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// $pdf->SetMargins(PDF_MARGIN_LEFT,10,PDF_MARGIN_RIGHT);
// $pdf->SetMargins(10,5,10, true);
$pdf->SetMargins(5,5,5, true); // Dew ตั้งเองได้เลย
$pdf->setHeaderMargin(2);
$pdf->setFooterMargin(2);
$pdf->SetPrintHeader(false); 
$pdf->setPrintFooter(false);

// set auto page breaks
// $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setAutoPageBreak(TRUE, 5);


// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
	require_once(dirname(__FILE__) . '/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$dotted = '.....................................................';

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->setFont('thsarabun', '', 9, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
// $pdf->AddPage('L'); L คือแนวนอน
$pdf->AddPage('P', 'A4');

// $pdf->SetPageSize(210, 297);

$pdf->Ln(4);

$html = '<div style="text-align:center; font-size: 11px;"><b>บริษัท อาซีฟา จำกัด (มหาชน)</b></div>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(200, 6, 'ใบนำของออกนอกบริษัท', 1, 0, 'C');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(158, 6, '', 'L', 0, 'C');
$pdf->Cell(42, 6, 'เลขที่  '.$Sheet_No, 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(60, 6, 'ชื่อ                    '. $LogSheet['LeadOutUsers'] , 'L', 0, 'L');
$pdf->Cell(48, 6, 'ตำแหน่ง', '', 0, 'L');
$pdf->Cell(47, 6, 'ฝ่าย/แผนก', '', 0, 'L');
$pdf->Cell(45, 6, 'วันที่  '.$date, 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'BU', 9);
$pdf->Cell(200, 4, 'รายการที่ต้องการนำออก', 'RL', 0, 'L');
$pdf->Ln(4);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(105, 7, '1. เครื่องมือที่ใช้ในการปฏิบัติงานนอก', 'L', 0, 'L');
$pdf->Image($item5, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 5. เครื่องใช้และอุปกรณ์ไว้ที่ Site งาน', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item1, $pdf->GetX() + 2, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '        เครื่องมือประจำตัว', 'L', 0, 'L');
$pdf->Image($item6, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 6. ชิ้นงานเหล็ก อุปกรณ์และบัสบาร์นำไปปฏิบัติงานภายนอก', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item1, $pdf->GetX() + 2, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '        เครื่องมืออื่น ๆ ..............................................................................................', 'L', 0, 'L');
$pdf->Image($item7, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 7. สินต้าสำเร็จรูป/ตู้สำเร็จรูปส่งให้ลูกค้า ลูกค้ามารับเอง', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(105, 7, '...........................................................................................................................', 'L', 0, 'L');
$pdf->Image($item8, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 8. เศษสินค้าต่างๆ ที่ขายให้ผู้ซื้อ คือ .........................................', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item2, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       2. ชิ้นงานเหล็ก อุปกรณ์และบัสบาร์ส่งจ้างเหมาภายนอก', 'L', 0, 'L');
$pdf->Image($item9, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 9. นำวัสดุ/สารเคมีอันตรายไปกำจัด/เศษวัสดุ อุปกรณ์ที่ไม่ใช้แล้วจากงานปรับปรุง ก่อสร้าง ซ่อมแซม', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item3, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       3. ตู้สำเร็จรูป/อุปกรณ์ต่างๆที่นำไปจัดแสดงสินค้าและลูกค้ายืม', 'L', 0, 'L');
$pdf->Image($item10, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 10. อื่น ๆ        '. $item10_remark, 'R', 0, 'L');
$pdf->Line($pdf->GetX() - 83, $pdf->GetY() + 5, $pdf->GetX() - 30, $pdf->GetY() + 5, 'dotted');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item4, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       4. สินค้าหรืออุปกรณ์ส่งเคลม/ส่งชุบ/ซ่อม/สอบเทียบ', 'L', 0, 'L');
$pdf->Cell(95, 7, '', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'BU', 9);
$pdf->Cell(47, 7, 'เอกสารแนบกับใบนำของออก', 'L', 0, 'L');
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(55, 7, 'เลขที่เอกสาร   '. $LogSheet['Doc_No'], '', 0, 'L');
$pdf->Line($pdf->GetX() - 42, $pdf->GetY() + 5, $pdf->GetX() -4, $pdf->GetY() + 5, 'dotted');
$pdf->Cell(28, 7, 'นำออกวันที่   '. $LeadOut_Date, '', 0, 'L');
$pdf->Line($pdf->GetX() - 16, $pdf->GetY() + 5, $pdf->GetX(), $pdf->GetY() + 5, 'dotted');
$pdf->Cell(28, 7, 'เวลา ', '', 0, 'L');
$pdf->Line($pdf->GetX() - 22, $pdf->GetY() + 5, $pdf->GetX(), $pdf->GetY() + 5, 'dotted');
$pdf->Cell(28, 7, 'รถทะเบียน ', '', 0, 'L');
$pdf->Line($pdf->GetX() - 17, $pdf->GetY() + 5, $pdf->GetX(), $pdf->GetY() + 5, 'dotted');
$pdf->Cell(14, 7, '', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'BU', 9);
$pdf->Cell(20, 6, 'หมายเหตุ', 'L', 0, 'L');
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(180, 6, '        '. $LogSheet['Remark'] != NULL ? $LogSheet['Remark'] : '' , 'R', 0, 'L');
$pdf->Line($pdf->GetX() - 180, $pdf->GetY() + 4.5, $pdf->GetX() -5, $pdf->GetY() + 4.5, 'dotted');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(200, 5, 'ส่วนของการอนุมัตินำออก', 1, 0, 'C');
$pdf->Ln(5);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(40, 5, 'ผู้แจ้งนำออก', 1, 0, 'C');
$pdf->Cell(160, 5, 'ผู้อนุมัติ', 1, 0, 'C');
$pdf->Ln(5);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(40, 6, '.................................................................', 'RL', 0, 'L');
$pdf->Cell(53, 6, 'No. ____    ................................................................', 'RL', 0, 'L');
$pdf->Cell(53, 6, 'No. ____    ................................................................', 'RL', 0, 'L');
$pdf->Cell(54, 6, 'No. ____    ................................................................', 'RL', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(40, 6, 'ตัวบรรจง.................................................', 'RL', 0, 'L');
$pdf->Cell(53, 6, 'ตัวบรรจง......................................................................', 'RL', 0, 'L');
$pdf->Cell(53, 6, 'ตัวบรรจง......................................................................', 'RL', 0, 'L');
$pdf->Cell(54, 6, 'ตัวบรรจง......................................................................', 'RL', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(40, 4, 'แผนก.......................................................', 'RL', 0, 'L');
$pdf->Cell(53, 4, 'แผนก...........................................................................', 'RL', 0, 'L');
$pdf->Cell(53, 4, 'แผนก...........................................................................', 'RL', 0, 'L');
$pdf->Cell(54, 4, 'แผนก...........................................................................', 'RL', 0, 'L');
$pdf->Ln(4);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(200, 6, 'ส่วนของการตรวจปล่อย', 1, 0, 'C');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(40, 5, 'ผู้นำออก', 1, 0, 'C');
$pdf->Cell(120, 5, 'ผู้ตรวจปล่อย', 1, 0, 'C');
$pdf->Cell(40, 5, 'รปภ.', 1, 0, 'C');
$pdf->Ln(5);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(40, 6, '.................................................................', 'RL', 0, 'L');
$pdf->Cell(40, 6, 'No. ____    ............................................', 'RL', 0, 'L');
$pdf->Cell(40, 6, 'No. ____    ............................................', 'RL', 0, 'L');
$pdf->Cell(40, 6, 'No. ____    ............................................', 'RL', 0, 'L');
$pdf->Cell(40, 6, '.................................................................', 'RL', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(40, 6, 'ตัวบรรจง.................................................', 'RL', 0, 'L');
$pdf->Cell(40, 6, 'ตัวบรรจง..................................................', 'RL', 0, 'L');
$pdf->Cell(40, 6, 'ตัวบรรจง..................................................', 'RL', 0, 'L');
$pdf->Cell(40, 6, 'ตัวบรรจง..................................................', 'RL', 0, 'L');
$pdf->Cell(40, 6, 'ตัวบรรจง..................................................', 'RL', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(40, 4, 'แผนก.......................................................', 'RLB', 0, 'L');
$pdf->Cell(40, 4, 'แผนก........................................................', 'RLB', 0, 'L');
$pdf->Cell(40, 4, 'แผนก........................................................', 'RLB', 0, 'L');
$pdf->Cell(40, 4, 'แผนก........................................................', 'RLB', 0, 'L');
$pdf->Cell(40, 4, 'เวลา  .....................  น.  วันที่ .................', 'RLB', 0, 'L');
$pdf->Ln(7);

$pdf->Ln(1);
$html = '

	<div align="right">
		<strong>FM-GMHM-148(00)<br>เริ่มใช้ 3 พ.ค.2566</strong>
	</div>
';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(8);

if($List_File != null){
	$pdf->SetLineWidth(0.3);
	$pdf->SetFont('thsarabun', 'B', 9.5);
	$pdf->Cell(100, 5, 'รายการไฟล์แนบ', 1, 0, 'C');
	$pdf->Ln(5);

	$pdf->SetLineWidth(0.3);
	$pdf->SetFont('thsarabun', 'B', 9.5);
	$pdf->Cell(10, 5, 'ลำดับ', 1, 0, 'C');
	$pdf->Cell(90, 5, 'ชื่อไฟล์', 1, 0, 'C');
	$pdf->Ln(5);

	$i = 1;
	foreach ($List_File as $key => $value) {
		$pdf->SetLineWidth(0.3);
		$pdf->SetFont('thsarabun', '', 9);
		$pdf->Cell(10, 6, $i, 1, 0, 'C');
		$pdf->Cell(90, 6, $value['name'], 1, 0, 'L');
		$pdf->Ln(6);

		$i++;
	}
}

$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->Line(170, 23.5, 185, 23.5, 'dotted');

$pdf->Line(125, 29.5, 160, 29.5, 'dotted');

$pdf->Line(10, 29.5, 65, 29.5, 'dotted');

$pdf->Line(75, 29.5, 113, 29.5, 'dotted');

$pdf->Line(166, 29.5, 180, 29.5, 'dotted');

$pdf->Output($Sheet_No.'.pdf', 'I');

<?php

session_start();
include "config/base.php";
include('../../cdn/TCPDF-main/config/tcpdf_config_alt.php');
include('../../cdn/TCPDF-main/tcpdf.php');

$Sheet_No = $_GET['Sheet_No'];
$LogSheet = Select_Logsheet($_GET['Sheet_No']);
$List_File = List_File($_GET['Sheet_No']);
$item_arr = explode(',', $LogSheet['ItemID']);

$item1 = in_array('16', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item2 = in_array('17', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item3 = in_array('18', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item4 = in_array('19', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item5 = in_array('22', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item6 = in_array('23', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item7 = in_array('24', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item8 = in_array('25', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item9 = in_array('26', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item10 = in_array('27', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item11 = in_array('28', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item12 = in_array('29', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item13 = in_array('30', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item14 = in_array('31', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item15 = in_array('32', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item16 = in_array('33', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item17 = in_array('34', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item18 = in_array('35', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item19 = in_array('36', $item_arr) ? './icon/check-box.png' : './icon/square.png';
$item19_remark = in_array('36', $item_arr) ? $LogSheet['ItemOth'] : '';

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
$pdf->Image($item1, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       1. ชิ้นงานเหล็ก อุปกรณ์และบัสบาร์ ส่งจ้างภายนอก', 'L', 0, 'L');
$pdf->Image($item12, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 12. สินค้า/อุปกรณ์ต่างๆ ที่ส่งให้ลูกค้า หรือลูกค้ามารับเอง', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item2, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       2. ตู้สำเร็จรูป/ อุปกรณ์ต่างๆ ที่นำไปจัดแสดงสินค้า หรือออกบูท', 'L', 0, 'L');
$pdf->Image($item13, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 13. ทรัพย์สินหรือวัตถุดิบ เศษวัสดุหรือเศษสินค้าต่างๆ ที่ชำรุด/ใช้งานไม่ได้หรือไม่ได้ใช้งาน ', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item3, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       3. ตู้สำเร็จรูป/ อุปกรณ์ต่างๆ ที่ลูกค้ายืม', 'L', 0, 'L');
$pdf->Cell(95, 7, ' ที่จำหน่ายให้ผู้รับซื้อ', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item4, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       4. สินค้าหรืออุปกรณ์ส่ง Claim ที่นำส่งให้ Supplier หรือ Supplier มารับเอง', 'L', 0, 'L');
$pdf->Image($item14, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 14. เศษสายไฟ, ทองแดง, เศษเหล็ก, อุปกรณ์ไฟฟ้าชำรุด และเศษสินค้าอื่นจากกระบวนการผลิต ', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item5, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       5. เครื่องใช้สำนักงาน เครื่องมือ เครื่องจักร อะไหล่ ส่งซ่อมที่นำส่งให้ Supplier ', 'L', 0, 'L');
$pdf->Cell(95, 7, ' ที่จำหน่ายให้ผู้รับซื้อ', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(105, 7, '       หรือ Supplier มารับเอง', 'L', 0, 'L');
$pdf->Image($item15, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 15. กระดาษ, ขวด, พลาสติก, เศษไม้, พาเลท, PVC ที่จำหน่ายให้ผู้รับซื้อ', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item6, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       6. เครื่องมือวัดส่งสอบเทียบหรือส่งซ่อมที่นำส่งให้ Supplier หรือ Supplier มารับเอง', 'L', 0, 'L');
$pdf->Image($item16, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 16. วัสดุจากการใช้งานซ่อมสร้าง/เศษวัสดุ อุปกรณ์ที่ไม่ใช้แล้วจากงานปรับปรุง งานก่อสร้าง ', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item7, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       7. อุปกรณ์ I.T. ส่งซ่อมที่นำส่งให้ Supplier หรือ Supplier มารับเอง', 'L', 0, 'L');
$pdf->Cell(95, 7, ' งานซ่อมแซม งานสวน ที่จำหน่ายให้ผู้รับซื้อ', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item8, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       8. เครื่องใช้และอุปกรณ์ที่ Site งาน เช่น โต๊ะ/เก้าอี้/อุปกรณ์สำนักงาน/อุปกรณ์ I.T.', 'L', 0, 'L');
$pdf->Image($item17, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 17. ขยะอันตราย เศษวัสดุอันตราย หรือเศษสารเคมีอันตรายที่ต้องส่งไปกำจัด', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item9, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       9. สินค้า/อุปกรณ์ต่างๆ ทรัพย์สินหรือวัตถุดิบ เศษวัสดุหรือเศษสินค้าต่างๆ ', 'L', 0, 'L');
$pdf->Image($item18, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 18. ชิ้นงานเหล็ก บัสบาร์ อุปกรณ์ต่างๆ ซึ่งต้องนำไปติดตั้งเป็นส่วนประกอบเข้ากับตัวสินค้าภายนอก ', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(105, 7, '       ที่นำไปจัดเก็บพื้นที่อื่น (ย้าย Location)', 'L', 0, 'L');
$pdf->Cell(95, 7, ' ที่เบิกออกจากสโตร์แล้ว ที่นำออกไปปฏิบัติงาน เช่น Service, PRD เป็นต้น', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item10, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       10. เศษวัสดุหรืออุปกรณ์ที่ไม่ใช้แล้วจากงานปรับปรุง งานก่อสร้าง งานซ่อมแซม ', 'L', 0, 'L');
$pdf->Image($item19, $pdf->GetX() - 3, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(95, 7, ' 19. อื่นๆ ของที่นำออกนอกเหนือจาก ข้อ 1-18', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Cell(105, 7, '       งานสวน ที่นำไปจัดเก็บพื้นที่อื่น (ย้าย Location)', 'L', 0, 'L');
$pdf->Cell(95, 7, '', 'R', 0, 'L');
$pdf->Ln(6);

$pdf->SetLineWidth(0.3);
$pdf->SetFont('thsarabun', 'B', 9.5);
$pdf->Image($item11, $pdf->GetX() + 1, $pdf->GetY() + 2, 4, 4);
$pdf->Cell(105, 7, '       11. ชิ้นงานเหล็ก บัสบาร์ และอุปกรณ์ต่างๆ  ซึ่งต้องนำไปติดตั้งเป็นส่วนประกอบเข้ากับตัวสินค้าภายนอก', 'L', 0, 'L');
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
		<strong>FM-GMHM-153 (00)<br>เริ่มใช้ 1 ก.ค.2568</strong>
	</div>
';

try {
    if (!empty($LeadOut_Date)) {
        $leadOutDate = DateTime::createFromFormat('d/m/Y', $LeadOut_Date);
        $checkDate = DateTime::createFromFormat('d/m/Y', '01/07/2025');
        
        if ($leadOutDate <= $checkDate) {
            $html = '
            <div align="right">
				<strong>FM-CMMO-312 (00)<br>เริ่มใช้ 1 พ.ค.2568</strong>
			</div>
            ';
        }
    }
} catch (Exception $e) {
    error_log("Date conversion error: " . $e->getMessage());
}

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

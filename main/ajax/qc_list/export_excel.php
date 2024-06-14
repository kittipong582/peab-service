<?php
session_start();
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");


require ('../../PHPExcel-1.8/Classes/PHPExcel.php');
require ('../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

$objPHPExcel = new PHPExcel();
// กำหนดค่าต่างๆ
$objPHPExcel->getProperties()->setCreator("Company Co., Ltd.");
$objPHPExcel->getProperties()->setLastModifiedBy("Company Co., Ltd.");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX ReportQuery Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX ReportQuery Document");
$objPHPExcel->getProperties()->setDescription("ReportQuery from Company Co., Ltd.");

$sheet = $objPHPExcel->getActiveSheet();
$pageMargins = $sheet->getPageMargins();

// margin is set in inches (0.5cm)
$margin = 0.5 / 2.54;
$pageMargins->setTop($margin);
$pageMargins->setBottom($margin);
$pageMargins->setLeft($margin);
$pageMargins->setRight(0);

$styleHeader = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFFF00'),
    ),
    'font' => array(
        'bold' => true,
        'size' => 10,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleHeaderLeft = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'bold' => true,
        'size' => 10,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleHeaderRight = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'bold' => true,
        'size' => 10,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleHeaderNoBorder = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'font' => array(
        'bold' => true,
        'size' => 10,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleNumber = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleTextNoBorder = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),

    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText_green = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
        'color' => array('rgb' => '21BA21'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText_red = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
        'color' => array('rgb' => 'FF0000'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText_blue = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
        'color' => array('rgb' => '0000FF'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

// 'color' => array('rgb' => '32CD32'),
$styleTextCenter = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleTextLeft = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleTextRight = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);



$rowCell = 1;
$columnCharacter = array(
    'A',
    'B',
    'C',
    'D',
    'E',
    'F',
    'G',
    'H',
    'I',
    'J',
    'K',
    'L',
    'M',
    'N',
    'O',
    'P',
    'Q',
    'R',
    'S',
    'T',
    'U',
    'V',
    'W',
    'X',
    'Y',
    'Z',
    'AA',
    'AB',
    'AC',
    'AD',
    'AE',
    'AF',
    'AG',
    'AH',
    'AI',
    'AJ',
    'AK',
    'AL',
    'AM',
    'AN',
    'AO',
    'AP',
    'AQ',
    'AR',
    'AS',
    'AT',
    'AU',
    'AV',
    'AW',
    'AX',
    'AY',
    'AZ',
    'BA',
    'BB',
    'BC',
    'BD',
    'BE',
    'BF',
    'BG',
    'BH',
    'BI',
    'BJ',
    'BK',
    'BL',
    'BM',
    'BN',
    'BO',
    'BP',
    'BQ',
    'BR',
    'BS',
    'BT',
    'BU',
    'BV',
    'BW',
    'BX',
    'BY',
    'BZ'
);

$columnHeaderName = array(
    "วันที่",
    "เครื่อง",
    "ช่าง",
    "สถานะ"
);

$num_header = count($columnHeaderName);
$c = 0;
for ($i = 0; $i < $num_header; $i++) {
    $objPHPExcel->getActiveSheet()->setCellValue($columnCharacter[$c] . $rowCell, $columnHeaderName[$c]);
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$c])->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[$c] . $rowCell)->applyFromArray($styleTextCenter);

    $c++;
}
//////////// body //////////////////// 
$rowCell = 2;



$temp_start_date = explode("/", $_POST['start_date']);
$start_date = date("Y-m-d", strtotime($temp_start_date[0] . "-" . $temp_start_date[1] . "-" . $temp_start_date[2]));

$temp_end_date = explode("/", $_POST['end_date']);
$end_date = date("Y-m-d", strtotime($temp_end_date[0] . "-" . $temp_end_date[1] . "-" . $temp_end_date[2]));

$sql = "SELECT * FROM tbl_job_qc WHERE start_qc BETWEEN '$start_date' AND '$end_date' ORDER BY appointment_date ASC";
$res = mysqli_query($connection, $sql);


while ($row = mysqli_fetch_assoc($res)) {

   
    $status = $row['start_qc'];

    if ($row['start_qc'] == '') {
        $status = 'รอเปิดงาน';
    } else if ($row['start_qc'] != '' && $row['close_qc'] == '') {
        $status = 'กำลังดำเนินการ';
    } else if ($row['start_qc'] != '' && $row['close_qc'] != '') {
        $status = 'ปิดงาน';
    }


    $sql_product = "SELECT a.*,b.model_code,model_name FROM tbl_product_waiting a LEFT JOIN tbl_product_model b ON a.model_code = b.model_code
    WHERE a.lot_id = '{$row['lot_id']}' ";
    $rs_product = mysqli_query($connection, $sql_product) or die($connection->error);
    $row_product = mysqli_fetch_assoc($rs_product);


    $sql_staff = "SELECT a.*,b.fullname,c.branch_name FROM tbl_staff_qc a LEFT JOIN tbl_user b ON a.staff_id = b.user_id LEFT JOIN tbl_branch c ON b.branch_id = c.branch_id WHERE job_qc_id  = '{$row['job_qc_id']}'";
    $res_staff = mysqli_query($connection, $sql_staff);
    $row_staff = mysqli_fetch_assoc($res_staff);

  

    $objPHPExcel->getActiveSheet()->setCellValue("A" . $rowCell, $row['appointment_date']);
    $objPHPExcel->getActiveSheet()->setCellValue("B" . $rowCell, $row_product['model_code'] . '-' . $row_product['model_name']);
    $objPHPExcel->getActiveSheet()->setCellValue("C" . $rowCell, $row_staff['fullname']);
    $objPHPExcel->getActiveSheet()->setCellValue("D" . $rowCell, $status);
    // $objPHPExcel->getActiveSheet()->setCellValue("E" . $rowCell, $ct_name);
    // $objPHPExcel->getActiveSheet()->setCellValue("F" . $rowCell, $register_level);
    // $objPHPExcel->getActiveSheet()->setCellValue("G" . $rowCell, $register_type);
    // $objPHPExcel->getActiveSheet()->setCellValue("H" . $rowCell, $citizen_no);
    // $objPHPExcel->getActiveSheet()->setCellValue("I" . $rowCell, date('d M', strtotime($row_member['card_expire_date'])) . ' ' . date('Y', strtotime($row_member['card_expire_date'] + 543)));
    // $objPHPExcel->getActiveSheet()->setCellValueExplicit("J" . $rowCell, $visa_no, PHPExcel_Cell_DataType::TYPE_STRING);
    // $objPHPExcel->getActiveSheet()->setCellValue("K" . $rowCell, date('d M', strtotime($row_member['visa_expire_date'])) . ' ' . date('Y', strtotime($row_member['visa_expire_date'] + 543)));
    // $objPHPExcel->getActiveSheet()->setCellValueExplicit("L" . $rowCell, $work_permit, PHPExcel_Cell_DataType::TYPE_STRING);
    // $objPHPExcel->getActiveSheet()->setCellValue("M" . $rowCell, date('d M', strtotime($row_member['work_expire_date'])) . ' ' . date('Y', strtotime($row_member['work_expire_date'] + 543)));
    // $objPHPExcel->getActiveSheet()->setCellValue("N" . $rowCell, $row_member['company_name']);
    // $objPHPExcel->getActiveSheet()->setCellValue("O" . $rowCell, $row_member['company_phone']);

    $objPHPExcel->getActiveSheet()->getStyle("A" . $rowCell . ':' . "D" . $rowCell)->applyFromArray($styleTextCenter);

    $rowCell++;
}

/*-------------------------------------------------------------------------------------------------------------------------------*/

$objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
// $file_name = "Test รายการ QC วันที่" . date("d-m-Y", strtotime("today"));
$file_name = " รายการ QC วันที่ " . date("d-m-y", strtotime($start_date)) . " - " . date("d-m-y", strtotime($end_date)) . ".xlsx";

//
// Save Excel 2007 file
#echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');
// It will be called file.xls
header('Content-Disposition: attachment;filename="' . $file_name . '.xlsx');

$objWriter->save('php://output');

exit();

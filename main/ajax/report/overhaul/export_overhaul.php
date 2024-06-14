<?php
session_start();
include ('../../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

// set_time_limit(0);
/** PHPExcel */
require ('../../../PHPExcel-1.8/Classes/PHPExcel.php');
// /** PHPExcel_IOFactory - Reader */
require ('../../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');


// สร้าง object ของ Class  PHPExcel  ขึ้นมาใหม่
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


/////////////////////////////////////////////////////////////////////////////


$type_date = $_POST['type_date'];

$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));




switch ($type_date) {
    case "1":
        $condition .= " AND b.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        break;
    case "2":
        $condition .= " AND b.appointment_date BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        break;
    case "3":
        $condition .= " AND b.start_service_time BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        break;
    default:
        $condition .= " AND b.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
}


$sql = "SELECT 
    a.*,a.create_datetime AS log_create_datetime,
    b.*,
    c.serial_no,c.warranty_start_date,c.warranty_end_date,
    d.branch_code,d.branch_name AS cus_branch_name,d.branch_code,
    e.customer_name,e.customer_code,
    f.branch_name,
    g.fullname,
    i.brand_name,
    j.model_name
    FROM tbl_overhaul_log a  

    LEFT JOIN tbl_job b ON a.job_id = b.job_id
    LEFT JOIN tbl_overhaul c ON a.overhaul_id = c.overhaul_id
    LEFT JOIN tbl_customer_branch d ON b.customer_branch_id = d.customer_branch_id
    LEFT JOIN tbl_customer e ON e.customer_id = d.customer_id 
    LEFT JOIN tbl_branch f ON b.care_branch_id = f.branch_id
    LEFT JOIN tbl_user g ON b.responsible_user_id = g.user_id
    LEFT JOIN tbl_product_brand i ON c.brand_id = i.brand_id
    LEFT JOIN tbl_product_model j ON c.model_id = j.model_id

    WHERE c.overhaul_id IS NOT NULL $condition
    ORDER BY b.get_oh_datetime DESC
    ;";
// echo $sql;
$rs = mysqli_query($connection, $sql) or die($connection->error);
// $row = mysqli_fetch_array($rs);



/////////////////////////////////////////////////////////////////////////////


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

$styleHeader_second = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFA500'),
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



$timestamp = strtotime($row['get_oh_datetime']);
$hours = floor($timestamp / 3600);



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

/*------------------------------------------------------------------------------------------------------------------------------*/

// หัวตาราง
$rowCell = 4;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'หมายเลขเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'ยี่ห้อ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'รุ่น');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'ประเภทเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'เลขที่งาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'ประเภทงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'ชื่อลูกค้า');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'ชื่อร้าน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(40);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'ทีมที่ดูแล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, 'ช่างผู้ดูแล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[9])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, 'วันที่รับเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[10])->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, 'ผู้รับผิดชอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[11])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, 'วันเปิดล้างเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[12])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, 'ผู้รับผิดชอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[13])->setWidth(30);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, 'วันที่ตรวจสภาพก่อนถอด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[14])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, 'ผู้รับผิดชอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[15])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, 'วันที่แยกชิ้นส่วน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[16])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, 'ผู้รับผิดชอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[17])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, 'วันที่แช่ล้าง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[18])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, 'ผู้รับผิดชอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[19])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[20] . $rowCell, 'ประกอบชิ้นส่วนพร้อมทดสอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[20] . $rowCell . ':' . $columnCharacter[20] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[20])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[21] . $rowCell, 'ผู้รับผิดชอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[21] . $rowCell . ':' . $columnCharacter[21] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[21])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[22] . $rowCell, 'QC');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[22] . $rowCell . ':' . $columnCharacter[22] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[22])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[23] . $rowCell, 'ผู้รับผิดชอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[23] . $rowCell . ':' . $columnCharacter[23] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[23])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[24] . $rowCell, 'ส่งคืนเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[24] . $rowCell . ':' . $columnCharacter[24] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[24])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[25] . $rowCell, 'ผู้รับผิดชอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[25] . $rowCell . ':' . $columnCharacter[25] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[25])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[26] . $rowCell, 'วันที่โอนชำระ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[26] . $rowCell . ':' . $columnCharacter[26] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[26])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[27] . $rowCell, 'ผู้รับผิดชอบ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[27] . $rowCell . ':' . $columnCharacter[27] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[27])->setWidth(30);








$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[27] . ($rowCell))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[11] . ($rowCell))->applyFromArray($styleHeader);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[10] . $rowCell . ':' . $columnCharacter[27] . ($rowCell))->applyFromArray($styleHeader_second);


$rowCell = 5;

while ($row = mysqli_fetch_assoc($rs)) {

    $condition_jobtype = "";
    switch ($row['job_type']) {
        case "1":
            $condition_jobtype .= "CM";
            break;
        case "2":
            $condition_jobtype .= "PM";
            break;
        case "3":
            $condition_jobtype .= "Installation ";
            break;
        case "4":
            $condition_jobtype .= "overhaul";
            break;
        case "5":
            $condition_jobtype .= "oth";
            break;
        case "6":
            $condition_jobtype .= "quotation";
            break;
        default:
            $condition_jobtype = "ไม่ระบุ";
    }

    $condition_product_type = "";
    switch ($row['product_type']) {
        case "1":
            $condition_product_type .= "เครื่องชง";
            break;
        case "2":
            $condition_product_type .= "เครื่องบด";
            break;
        case "3":
            $condition_product_type .= "เครื่องปั่น ";
            break;
        default:
            $condition_product_type = "ไม่ระบุ";
    }



    $sql_u = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['create_user_id']}' ";
    $rs_u = mysqli_query($connection, $sql_u) or die($connection->error);
    $row_u = mysqli_fetch_array($rs_u);

    $sql_au = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['approve_user_id']}' ";
    $rs_au = mysqli_query($connection, $sql_au) or die($connection->error);
    $row_au = mysqli_fetch_array($rs_au);


    $sql_sum_spare = "SELECT SUM(unit_price * quantity) AS sum_spare FROM tbl_job_spare_used WHERE job_id = '{$row['job_id']}'";
    $rs_sum_spare = mysqli_query($connection, $sql_sum_spare) or die($connection->error);
    $row_sum_spare = mysqli_fetch_array($rs_sum_spare);

    $sql_sum_income = "SELECT SUM(income_amount * quantity) AS sum_income FROM tbl_job_income WHERE job_id = '{$row['job_id']}'";
    $rs_sum_income = mysqli_query($connection, $sql_sum_income) or die($connection->error);
    $row_sum_income = mysqli_fetch_array($rs_sum_income);

    $alltotal = $row_sum_spare['sum_spare'] + $row_sum_income['sum_income'];


    $create_datetime = date('Y-m-d', strtotime($row['log_create_datetime']));
    $return_datetime = date('Y-m-d', strtotime($row['return_datetime']));

    $appointment_end_date = date('Y-m-d', strtotime($row['appointment_date'])) . " " . date('H:i:s', strtotime($row['appointment_time_end']));


    $diff = abs($return_datetime - $create_datetime);
    $years = floor($diff / (365 * 60 * 60 * 24));
    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


    //////////////////รับเครื่อง
    $sql_get = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['get_oh_user']}'";
    $rs_get = mysqli_query($connection, $sql_get);
    $row_get = mysqli_fetch_assoc($rs_get);


    //////////////////ส่งเครื่อง
    $sql_send = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['send_oh_user']}'";
    $rs_send = mysqli_query($connection, $sql_send);
    $row_send = mysqli_fetch_assoc($rs_send);


    //////////////////เปิด qc
    $sql_get_qc = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['get_qcoh_user']}'";
    $rs_get_qc = mysqli_query($connection, $sql_get_qc);
    $row_get_qc = mysqli_fetch_assoc($rs_get_qc);


    //////////////////ปิด qc
    $sql_send_qc = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['send_qcoh_user']}'";
    $rs_send_qc = mysqli_query($connection, $sql_send_qc);
    $row_send_qc = mysqli_fetch_assoc($rs_send_qc);


    //////////////////คืนเครื่อง
    $sql_return_qc = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['return_oh_user']}'";
    $rs_return_qc = mysqli_query($connection, $sql_return_qc);
    $row_return_qc = mysqli_fetch_assoc($rs_return_qc);


    //////////////////โอน
    $sql_pay = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['pay_oh_user']}'";
    $rs_pay = mysqli_query($connection, $sql_pay);
    $row_pay = mysqli_fetch_assoc($rs_pay);

    //////////ชั่วโมงที่ใช้ล้างเครื่อง (เวลาตั้งแต่เปิดงานจนปิดงาน)1
    $sql_time_receive = "SELECT * FROM tbl_job_oh WHERE job_id = '{$row['job_id']}' AND oh_type = '1'";
    $res_time_receive = mysqli_query($connection, $sql_time_receive);
    $row_time_receive = mysqli_fetch_array($res_time_receive);




    //////////ชั่วโมงที่ใช้ล้างเครื่อง (เวลาตั้งแต่เปิดงานจนปิดงาน)2
    $sql_time_open = "SELECT * FROM tbl_job_oh WHERE job_id = '{$row['job_id']}' AND oh_type  = '2'";
    $res_time_open = mysqli_query($connection, $sql_time_open);
    $row_time_open = mysqli_fetch_assoc($res_time_open);

    $time_open1 = strtotime($row_time_open['check_in_datetime']);
    $time_open2 = strtotime($row_time_open['check_out_datetime']);
    $interval_time_open = abs($time_open2 - $time_open1);

    // แปลงเป็นชั่วโมงและนาที
    $time_open_hours = floor($interval_time_open / 3600);
    $time_open_minutes = round(($interval_time_open % 3600) / 60);


    $worktime_open = $time_open_hours . ' : ' . $time_open_minutes . ' นาที';

    //////////ชั่วโมงที่ใช้ตรวจสอบก่อนแยกชิ้นส่วน3
    $sql_before_Separate = "SELECT * FROM tbl_job_oh WHERE job_id = '{$row['job_id']}' AND oh_type  = '3'";
    $res_before_Separate = mysqli_query($connection, $sql_before_Separate);
    $row_before_Separate = mysqli_fetch_assoc($res_before_Separate);

    $time_before_Separate1 = strtotime($row_before_Separate['check_in_datetime']);
    $time_before_Separate2 = strtotime($row_before_Separate['check_out_datetime']);
    $interval_before_Separate = abs($time_before_Separate2 - $time_before_Separate1);
    $hours_before_Separate = round($interval_before_Separate / 3600);

    $time_before_Separate1 = strtotime($row_before_Separate['check_in_datetime']);
    $time_before_Separate2 = strtotime($row_before_Separate['check_out_datetime']);
    $interval_time_open = abs($time_before_Separate2 - $time_before_Separate1);

    // แปลงเป็นชั่วโมงและนาที
    $time_before_Separate_hours = floor($interval_time_open / 3600);
    $time_before_Separate_minutes = round(($interval_time_open % 3600) / 60);


    $worktime_before_Separate = $time_before_Separate_hours . ' : ' . $time_before_Separate_minutes . ' นาที';

    ////////////วันที่ตรวจสภาพก่อนถอด4
    $sql_time_Separate = "SELECT * FROM tbl_job_oh WHERE job_id = '{$row['job_id']}' AND oh_type  = '4'";
    $res_time_Separate = mysqli_query($connection, $sql_time_Separate);
    $row_time_Separate = mysqli_fetch_assoc($res_time_Separate);

    $time_Separate1 = strtotime($row_time_Separate['check_in_datetime']);
    $time_Separate2 = strtotime($row_time_Separate['check_out_datetime']);
    $interval_time_Separate = abs($time_Separate2 - $time_Separate1);

    // แปลงเป็นชั่วโมงและนาที
    $time_Separate_hours = floor($interval_time_Separate / 3600);
    $time_Separate_minutes = round(($interval_time_Separate % 3600) / 60);


    $worktime_Separate = $time_Separate_hours . ' : ' . $time_Separate_minutes . ' นาที';

    ////////////วันที่แยกชิ้นส่วน5
    $sql_time_washing = "SELECT * FROM tbl_job_oh WHERE job_id = '{$row['job_id']}' AND oh_type  = '5'";
    $res_time_washing = mysqli_query($connection, $sql_time_washing);
    $row_time_washing = mysqli_fetch_assoc($res_time_washing);

    $time_washing1 = strtotime($row_time_washing['check_in_datetime']);
    $time_washing2 = strtotime($row_time_washing['check_out_datetime']);
    $interval_time_washing = abs($time_washing2 - $time_washing1);

    // แปลงเป็นชั่วโมงและนาที
    $time_washing_hours = floor($interval_time_washing / 3600);
    $time_washing_minutes = round(($interval_time_washing % 3600) / 60);


    $worktime_washing = $time_washing_hours . ' : ' . $time_washing_minutes . ' นาที';

    ////////////วันที่แช่ล้าง6
    $sql_time_testing = "SELECT * FROM tbl_job_oh WHERE job_id = '{$row['job_id']}' AND oh_type  = '6'";
    $res_time_testing = mysqli_query($connection, $sql_time_testing);
    $row_time_testing = mysqli_fetch_assoc($res_time_testing);

    $time_testing1 = strtotime($row_time_testing['check_in_datetime']);
    $time_testing2 = strtotime($row_time_testing['check_out_datetime']);
    $interval_time_testing = abs($time_testing2 - $time_testing1);

    // แปลงเป็นชั่วโมงและนาที
    $time_testing_hours = floor($interval_time_testing / 3600);
    $time_testing_minutes = round(($interval_time_testing % 3600) / 60);


    $worktime_testing = $time_testing_hours . ' : ' . $time_testing_minutes . ' นาที';


    ////////////ชั่วโมงที่ QC7
    $sql_time_qc = "SELECT * FROM tbl_job_oh WHERE job_id = '{$row['job_id']}' AND oh_type  = '7'";
    $res_time_qc = mysqli_query($connection, $sql_time_qc);
    $row_time_qc = mysqli_fetch_assoc($res_time_qc);

    $time_time_qc1 = strtotime($row_time_qc['check_in_datetime']);
    $time_time_qc2 = strtotime($row_time_qc['check_out_datetime']);
    $interval_time_qc = abs($time_time_qc2 - $time_time_qc1);

    // แปลงเป็นชั่วโมงและนาที
    $time_qc_hours = floor($interval_time_qc / 3600);
    $time_qc_minutes = round(($interval_time_qc % 3600) / 60);


    $worktime_qc = $time_qc_hours . ' : ' . $time_qc_minutes . ' นาที';

    ////////////ส่งคืนเครื่อง8
    $sql_time_transfer = "SELECT * FROM tbl_job_oh WHERE job_id = '{$row['job_id']}' AND oh_type  = '8'";
    $res_time_transfer = mysqli_query($connection, $sql_time_transfer);
    $row_time_transfer = mysqli_fetch_assoc($res_time_transfer);

    $time_time_transfer1 = strtotime($row_time_transfer['check_in_datetime']);
    $time_time_transfer2 = strtotime($row_time_transfer['check_out_datetime']);
    $interval_time_transfer = abs($time_time_transfer2 - $time_time_transfer1);

    // แปลงเป็นชั่วโมงและนาที
    $time_transfer_hours = floor($interval_time_transfer / 3600);
    $time_transfer_minutes = round(($interval_time_transfer % 3600) / 60);


    $worktime_transfer = $time_transfer_hours . ' : ' . $time_transfer_minutes . ' นาที';

    if ($days > 0) {
        $days = $days;
    } else {
        $days = 0;
    }


    $payment = "";
    if ($row['payment_type'] == 2) {
        $payment = $alltotal;
    } else {
        $payment = "-";
    }


    //ห้องที่ (ไล่ตาม order_id)
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row['serial_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));

    //order_no
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['brand_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));

    //ชื่อผู้จอง member_name
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $row['model_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));

    //เบอร์ผู้จอง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $condition_product_type);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $row['job_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

    //ห้องที่ (List_order)
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $condition_jobtype);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

    //ห้องที่ (List_order)
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, $row['customer_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));

    //คำนำหน้าชื่อ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, $row['cus_branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));

    //ชื่อจริง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, $row['branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));

    //นามสกุล
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, $row['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));

    //วันที่รับเครื่อง1
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, ($row_time_receive['appointment_datetime'] == '') ? "" : date('d/m/Y', strtotime($row_time_receive['appointment_datetime'])));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, ($row['fullname'] == "") ? "" : $row['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));

    //////////วันเปิดล้างเครื่อง2
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, ($worktime_open));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, ($row_get['fullname'] == "") ? "" : $row_get['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));


    //////////วันที่ตรวจสภาพก่อนถอด3
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, ($worktime_before_Separate));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, ($row_send['fullname'] == "") ? "" : $row_send['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));

    ////////////วันที่แยกชิ้นส่วน4
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, ($worktime_Separate));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));

    //ห้องที่ (List_order)
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, ($row_get_qc['fullname'] == "") ? "" : $row_get_qc['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));

    ////////////วันที่แช่ล้าง5
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, ($worktime_washing));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));

    //ชื่อจริง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, ($row_send_qc['fullname'] == "") ? "" : $row_send_qc['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));

    ////////////ประกอบชิ้นส่วนพร้อมทดสอบ6
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[20] . $rowCell, ($worktime_testing));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[20] . $rowCell . ':' . $columnCharacter[20] . ($rowCell));

    //วันเกิด
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[21] . $rowCell, ($row_return_qc['fullname'] == "") ? "" : $row_return_qc['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[21] . $rowCell . ':' . $columnCharacter[21] . ($rowCell));

    ////////////ชั่วโมงที่ QC7
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[22] . $rowCell, ($worktime_qc));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[22] . $rowCell . ':' . $columnCharacter[22] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[23] . $rowCell, ($row_return_qc['fullname'] == "") ? "" : $row_return_qc['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[23] . $rowCell . ':' . $columnCharacter[23] . ($rowCell));

    ////////////ส่งคืนเครื่อง8
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[24] . $rowCell, ($worktime_transfer));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[24] . $rowCell . ':' . $columnCharacter[24] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[25] . $rowCell, ($row_return_qc['fullname'] == "") ? "" : $row_return_qc['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[25] . $rowCell . ':' . $columnCharacter[25] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[26] . $rowCell, ($row['pay_oh_datetime'] == "") ? "" : date('d/m/Y', strtotime($row['pay_oh_datetime'])));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[26] . $rowCell . ':' . $columnCharacter[26] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[27] . $rowCell, ($row_pay['fullname'] == "") ? "" : $row_pay['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[27] . $rowCell . ':' . $columnCharacter[27] . ($rowCell));



    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[27] . ($rowCell))->applyFromArray($styleTextCenter);

    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[1] . ($rowCell))->applyFromArray($styleTextCenter);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell))->applyFromArray($styleTextLeft);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[3] . $rowCell . ':' . $columnCharacter[7] . ($rowCell))->applyFromArray($styleTextCenter);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[8] . $rowCell . ':' . $columnCharacter[9] . ($rowCell))->applyFromArray($styleTextLeft);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[10] . $rowCell . ':' . $columnCharacter[16] . ($rowCell))->applyFromArray($styleTextCenter);



    $rowCell++;
}

/*-------------------------------------------------------------------------------------------------------------------------------*/

$objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
$file_name = "ReportOverhaul" . "_" . date("d-m-Y H-i-s");
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

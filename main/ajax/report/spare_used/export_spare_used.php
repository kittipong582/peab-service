<?php
session_start();
include('../../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

// set_time_limit(0);
/** PHPExcel */
require('../../../PHPExcel-1.8/Classes/PHPExcel.php');
// /** PHPExcel_IOFactory - Reader */
require('../../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');


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
$report_type = $_POST['report_type'];
$condition = "";
if ($report_type == 1) {


    $start_date = explode('/', $_POST['start_date']);
    $start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));
    $end_date = explode('/', $_POST['end_date']);
    $end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));

    $date = date("Y-m-d");
    $condition = "WHERE appointment_date BETWEEN '$start_date' and '$end_date'";
    $header_text = 'รายวันวันที่ ' . $_POST['start_date']." - ". $_POST['end_date'];

    $file_name = "การใช้อะไหล่_" . $header_text;
} else if ($report_type == 2) {

    // $fdate = date("Y-m-d", strtotime("monday"));
    // $ldate = date("Y-m-d", strtotime("sunday"));

    $week = date("N", strtotime(date("Y-m-d"))); //นับลำดับวันที่ในสัปดาห์สัปดาห์ เช่น วันที่ 1,2,3.....
    $start = date("Y-m-d", strtotime("-" . ($week - 1) . " days"));
    $end = date("Y-m-d", strtotime("+" . (7 - $week) . " days"));

    $condition = "WHERE appointment_date BETWEEN '$start' and '$end'";
    $header_text = 'รายสัปดาห์วันที่ ' . date("d-m-Y", strtotime($start)) . " ถึง " . date("d-m-Y", strtotime($end));

    $file_name = "การใช้อะไหล่_" . $header_text;
} else if ($report_type == 3) {

    $month_thai = array(
        "",
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม"
    );

    $month = $_POST['month'];
    $year = date("Y", strtotime("today"));

    $condition = "WHERE MONTH(appointment_date) = '$month' and YEAR(appointment_date) = '$year'";
    $header_text = 'รายเดือน ' . $month_thai[$month];
    $file_name = "การใช้อะไหล่_" . $header_text;
} else if ($report_type == 4) {
    $year = date("Y", strtotime("today"));
    if ($_POST['quarter'] == 1) {
        $condition = "WHERE MONTH(appointment_date) BETWEEN '1' and '3'  AND YEAR(appointment_date) = '$year'";
    } else if ($_POST['quarter'] == 2) {
        $condition = "WHERE MONTH(appointment_date) BETWEEN '4' and '6'  AND YEAR(appointment_date) = '$year'";
    } else if ($_POST['quarter'] == 3) {
        $condition = "WHERE MONTH(appointment_date) BETWEEN '7' and '9'  AND YEAR(appointment_date) = '$year'";
    } else if ($_POST['quarter'] == 4) {
        $condition = "WHERE MONTH(appointment_date) BETWEEN '10' and '12'  AND YEAR(appointment_date) = '$year'";
    }

    $header_text = 'ไตรมาสที่ ' . $_POST['quarter'];
    $file_name = "การใช้อะไหล่_" . $header_text;
} else if ($report_type == 5) {
    $year = date("Y", strtotime("today"));
    if ($_POST['select_year'] == 1) {
        $condition = "WHERE MONTH(appointment_date) BETWEEN '1' and '6'  AND YEAR(appointment_date) = '$year'";
        $header_text = 'ราย6เดือนแรก ';
    } else if ($_POST['select_year'] == 2) {
        $condition = "WHERE MONTH(appointment_date) BETWEEN '7' and '12'  AND YEAR(appointment_date) = '$year'";
        $header_text = 'ราย6เดือนหลัง ';
    }
    $file_name = "การใช้อะไหล่_" . $header_text;
} else if ($report_type == 6) {

    $year = date("Y", strtotime("today"));

    $condition = "WHERE YEAR(appointment_date) = '$year'";
    $header_text = 'รายปี ' . ($year + 543);
    $file_name = "การใช้อะไหล่_" . $header_text;
}

if (isset($_POST['team']) && $_POST['team'] != "x") {
    $team = $_POST['team'];
    $condition .= "AND e.branch_id = '$team'";

    if (isset($_POST['user_id']) && $_POST['user_id'] != "x") {
        $user_id = $_POST['user_id'];
        $condition .= "AND a.responsible_user_id = '$user_id'";
    }
}







$sql = "SELECT 
    a.job_id as job_id,
    a.job_type as job_type,
    a.job_no as job_no,
    a.so_no as so_no, 
    a.receipt_no as receipt_no,
    c.spare_part_name as spare_part_name, 
    c.spare_part_code as spare_part_code, 
    d.spare_type_name as spare_type_name, 
    b.quantity as quantity,
    b.spare_part_id as spare_part_id,
    b.insurance_status as insurance_status,
    b.create_datetime as used_date, 
    e.fullname as fullname , 
    f.branch_name as branch_name,
    g.serial_no as serial_no,
    g.product_id as product_id,
    k.branch_code as branch_code
    FROM tbl_job_spare_used b
    LEFT JOIN tbl_job a ON a.job_id = b.job_id 
    LEFT JOIN tbl_spare_part c ON b.spare_part_id = c.spare_part_id
    LEFT JOIN tbl_spare_type d ON c.spare_type_id = d.spare_type_id
    LEFT JOIN tbl_user e ON a.responsible_user_id = e.user_id
    LEFT JOIN tbl_branch f ON f.branch_id = e.branch_id
    LEFT JOIN tbl_product g ON g.product_id = a.product_id 
    
    LEFT JOIN tbl_product_type j ON g.product_type = j.type_id
    LEFT JOIN tbl_customer_branch k ON k.customer_branch_id = a.customer_branch_id
    $condition
    ORDER BY a.job_no";
/*
    GROUP BY b.spare_part_id
    h.brand_name as brand_name,
    i.model_name as model_name
    LEFT JOIN tbl_product g ON g.product_id = a.product_id 
    LEFT JOIN tbl_product_brand h ON g.brand_id = h.brand_id 
    LEFT JOIN tbl_product_model i ON g.model_id = i.model_id

    -- SUM(CASE WHEN b.insurance_status = '1' THEN b.quantity ELSE 0 END) AS SUM_in,
    -- SUM(CASE WHEN b.insurance_status = '0' THEN b.quantity ELSE 0 END) AS SUM_out,
    -- SUM(CASE WHEN b.insurance_status = '0' THEN b.quantity*b.unit_price ELSE 0 END) AS Total_price
    
$sql = "SELECT  a.job_id,
    c.spare_part_name  as spare_part_name,
    c.spare_part_code  as spare_part_code,
    d.spare_type_name as spare_type_name,
    SUM(b.quantity) as quantity,
    b.spare_part_id as spare_part_id,
    b.insurance_status,
    SUM(CASE WHEN b.insurance_status = '1' THEN b.quantity ELSE 0 END) AS SUM_in,
    SUM(CASE WHEN b.insurance_status = '0' THEN b.quantity ELSE 0 END) AS SUM_out,
    SUM(CASE WHEN b.insurance_status = '0' THEN b.quantity*b.unit_price ELSE 0 END) AS Total_price
    FROM  tbl_job_spare_used b
    LEFT JOIN tbl_job a ON a.job_id = b.job_id
    LEFT JOIN tbl_spare_part c ON b.spare_part_id = c.spare_part_id
    LEFT JOIN tbl_spare_type d ON c.spare_type_id = d.spare_type_id
    LEFT JOIN tbl_user e ON a.responsible_user_id = e.user_id
    $condition 
    GROUP BY b.spare_part_id
    ORDER BY a.job_no";
    */
$result = mysqli_query($connection, $sql);


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
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . '1', "รายงานการใช้อะไหล่\n" . $header_text);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:O1');
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(35);



$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '1' . ':' . $columnCharacter[0] . ('1'))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . '1' . ':' . $columnCharacter[0] . ('1'))->applyFromArray($styleHeader);


// หัวตาราง
$rowCell = 2;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'หมายเลขงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'วันที่ใช้');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'ประเภทอะไหล่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'รหัสอะไหล่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(25);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'อะไหล่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(50);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'จำนวนทั้งหมด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'คลังอะไหล่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'ประเภทงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'หมายเลขเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, 'เครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[9])->setWidth(50);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, 'ในประกัน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[10])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, 'หมดประกัน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[11])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, 'ร้าน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[12])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, 'เลขที่บิล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[13])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, 'so no');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[14])->setWidth(16);



// $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[14] . ($rowCell))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[14] . ($rowCell))->applyFromArray($styleHeader);



$rowCell = 3;

while ($row = mysqli_fetch_assoc($result)) {

    // $sql_in = "SELECT quantity) as total_in FROM tbl_job_spare_used 
    // WHERE spare_part_id = '{$row['spare_part_id']}' and job_id = '{$row['job_id']}' and insurance_status = 1";
    // $result_in  = mysqli_query($connection, $sql_in);
    // $row_in = mysqli_fetch_assoc($result_in);

    // $sql_out = "SELECT SUM(quantity) as total_out FROM tbl_job_spare_used 
    // WHERE spare_part_id = '{$row['spare_part_id']}' and job_id = '{$row['job_id']}' and insurance_status = 0";
    // $result_out  = mysqli_query($connection, $sql_out);
    // $row_out = mysqli_fetch_assoc($result_out);

    $brand_name = $row['brand_name'];
    $model_name = $row['model_name'];

    if ($row['job_type'] == '1') {
        $job_type = 'CM';
    } else if ($row['job_type'] == '2') {
        $job_type = 'PM';
    } else if ($row['job_type'] == '3') {
        $job_type = 'Installation';
    } else if ($row['job_type'] == '4') {
        $job_type = 'overhaul';
    } else if ($row['job_type'] == '5') {
        $job_type = 'oth';
    } else if ($row['job_type'] == 6) {
        $job_type = 'Quotation';
    }


    if ($row['insurance_status'] == '1') {
        $insurance = 'ในประกัน';
        $non_insurance = '-';
    } else if ($row['insurance_status'] == '0') {
        $insurance = '-';
        $non_insurance = 'หมดประกัน';
    }

    if ($row['job_type'] == '3') {

        $sql_type3 = "SELECT a.*,
        b.serial_no,
        c.model_name,
        d.brand_name

        FROM tbl_in_product a 
        LEFT JOIN tbl_product b ON b.product_id = a.product_id
        LEFT JOIN tbl_product_model c ON c.model_id = b.model_id
        LEFT JOIN tbl_product_brand d ON d.brand_id = b.brand_id
        WHERE job_id = '{$row['job_id']}'";

        $res_type3 = mysqli_query($connection, $sql_type3);
        $row_type3 = mysqli_fetch_assoc($res_type3);
        $serial_no = $row_type3['serial_no'];
        $brand_name = $row_type3['brand_name'];
        $model_name = $row_type3['model_name'];
    } else {

        $sql_type3 = "SELECT a.*,
        b.model_name as model_name,
        c.brand_name as brand_name
        FROM tbl_product a 
        LEFT JOIN tbl_product_model b ON b.model_id = a.model_id
        LEFT JOIN tbl_product_brand c ON c.brand_id = a.brand_id
        WHERE product_id = '{$row['product_id']}'";

        $res_type3 = mysqli_query($connection, $sql_type3);
        $row_type3 = mysqli_fetch_assoc($res_type3);

        $serial_no = $row_type3['serial_no'];
        $brand_name = $row_type3['brand_name'];
        $model_name = $row_type3['model_name'];
    }

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row['job_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['used_date']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $row['spare_type_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $row['spare_part_code']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $row['spare_part_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $row['quantity']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, $row['branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, $job_type);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, $serial_no);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, "ยี่ห้อ : " . $brand_name . " , รุ่น : " . $model_name);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, $insurance);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, $non_insurance);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, $row['branch_code']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, $row['receipt_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, $row['so_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));


    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[14] . ($rowCell))->applyFromArray($styleTextCenter);

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
// $file_name = "ราคาอะไหล่ทั้งหมด";
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
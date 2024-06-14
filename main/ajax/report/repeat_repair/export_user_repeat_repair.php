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

// $time_type = $_POST['time_type'];
$responsible_user_id = $_POST['staff'];
$team = $_POST['team'];
$condition = "";

if (isset($_POST['team']) && $_POST['team'] != "x") {

    $condition .= "AND b.branch_id = '$team'";
}

if (isset($_POST['staff']) && $_POST['staff'] != "x") {

    $condition .= "AND b.user_id = '$responsible_user_id'";
}

$array_check_out = array();
$sql_job = "SELECT a.product_id,a.finish_service_time FROM tbl_job a 
LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id 
LEFT JOIN tbl_branch c ON b.branch_id = c.branch_id
WHERE a.job_type = 1 and a.finish_service_time is not NULL $condition GROUP BY product_id ORDER BY finish_service_time ";
$result_job  = mysqli_query($connection, $sql_job);
while ($row_job = mysqli_fetch_assoc($result_job)) {

    $temp = array(
        "product_id" => $row_job['product_id'],
        "finish_service_time" => $row_job['finish_service_time'],
    );

    array_push($array_check_out, $temp);
}


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
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
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
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
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
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleHeaderNoBorder = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleTextNoBorder = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),

    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);



$columnCharacter = array(
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
    'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP',
    'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK',
    'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ'
);

/*------------------------------------------------------------------------------------------------------------------------------*/

// หัวตาราง
$rowCell = 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'เลขที่งาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'วันที่นัดหมาย');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'หมายเลขเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'เครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(50);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'ประเภทเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'ร้าน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(40);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'ลูกค้า');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(40);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'ช่าง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(25);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'ทีม');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(25);



// $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[8] . ($rowCell))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[8] . ($rowCell))->applyFromArray($styleHeader);



$rowCell = 2;

foreach ($array_check_out as $row) {

    $product_id = $row['product_id'];
    $tomorrow_datetime = date("Y-m-d", strtotime($row['finish_service_time'] . "+1 days"));
    $next_datetime = date("Y-m-d", strtotime("+30 days"));

    $sql_main = "SELECT job_no,product_id,appointment_date,responsible_user_id FROM tbl_job WHERE job_type = 1 AND product_id = '$product_id' and appointment_date between '$tomorrow_datetime' and '$next_datetime' ORDER BY appointment_date ";
    $result_main  = mysqli_query($connection, $sql_main);

    echo $sql_main;

    while ($row_main = mysqli_fetch_assoc($result_main)) {

        $sql_product = "SELECT 
        a.product_id,
        a.serial_no,
        d.branch_code,d.branch_name AS cus_branch_name,
        e.customer_name,e.customer_code,
        i.brand_name,
        j.model_name,
        b.type_name
        FROM tbl_product a  
        LEFT JOIN tbl_customer_branch d ON a.current_branch_id = d.customer_branch_id
        LEFT JOIN tbl_customer e ON e.customer_id = d.customer_id 
        LEFT JOIN tbl_product_brand i ON a.brand_id = i.brand_id
        LEFT JOIN tbl_product_model j ON a.model_id = j.model_id
        LEFT JOIN tbl_product_type b ON a.product_type = b.type_id
        WHERE a.product_id = '$product_id'";
        $rs_product  = mysqli_query($connection, $sql_product);
        $row_product = mysqli_fetch_assoc($rs_product);

        $sql_user = "SELECT b.branch_name,a.fullname FROM tbl_user a 
        LEFT JOIN tbl_branch b ON a.branch_id = b.branch_id 
        WHERE a.user_id = '{$row_main['responsible_user_id']}'";
        $rs_user  = mysqli_query($connection, $sql_user);
        $row_user = mysqli_fetch_assoc($rs_user);

        //ห้องที่ (ไล่ตาม order_id)
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row_main['job_no']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));

        //order_no
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row_main['appointment_date']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));

        //ชื่อผู้จอง member_job
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $row_product['serial_no']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));

        //เบอร์ผู้จอง
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $row_product['brand_name'] . " - " . $row_product['model_name']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

        //เบอร์ผู้จอง
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $row_product['type_name']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

        //เบอร์ผู้จอง
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $row_product['branch_code'] . " - " . $row_product['cus_branch_name']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));


        //order_no
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, $row_product['customer_code'] . " " . $row_product['customer_name']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));


        //เบอร์ผู้จอง
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, $row_user['fullname']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));

        //เบอร์ผู้จอง
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, $row_user['branch_name']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));




        $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[8] . ($rowCell))->applyFromArray($styleTextCenter);

        // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[1] . ($rowCell))->applyFromArray($styleTextCenter);
        // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell))->applyFromArray($styleTextLeft);
        // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[3] . $rowCell . ':' . $columnCharacter[7] . ($rowCell))->applyFromArray($styleTextCenter);
        // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[8] . $rowCell . ':' . $columnCharacter[9] . ($rowCell))->applyFromArray($styleTextLeft);
        // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[10] . $rowCell . ':' . $columnCharacter[16] . ($rowCell))->applyFromArray($styleTextCenter);



        $rowCell++;
    }
}

/*-------------------------------------------------------------------------------------------------------------------------------*/

// $objPHPExcel->setActiveSheetIndex(0);
// //ตั้งชื่อไฟล์
// $file_job = "รายงานช่างซ่อมซ้ำใน30วัน - " . date("d-m-Y");
// //
// // Save Excel 2007 file
// #echo date('H:i:s') . " Write to Excel2007 format\n";
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// ob_end_clean();
// // We'll be outputting an excel file
// header('Content-type: application/vnd.ms-excel');
// // It will be called file.xls
// header('Content-Disposition: attachment;filename="' . $file_job . '.xlsx');

// $objWriter->save('php://output');

// exit();

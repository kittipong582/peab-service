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

$customer_group_id = $_POST['customer_group_id'];

$sql_name = "SELECT customer_group_name FROM tbl_customer_group WHERE customer_group_id = '$customer_group_id'";
$result_name  = mysqli_query($connection, $sql_name);
$row_name = mysqli_fetch_assoc($result_name);

$sql = "SELECT * FROM tbl_customer_group_part_price WHERE customer_group_id = '$customer_group_id'";
$result  = mysqli_query($connection, $sql);


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

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'ตัวชี้วัดกลุ่ม');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'ตัวชี้วัดอะไหล่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'รหัสอะไหล่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'อะไหล่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(50);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'ราคา');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(16);


// $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[4] . ($rowCell))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[4] . ($rowCell))->applyFromArray($styleHeader);



$rowCell = 2;

while ($row = mysqli_fetch_assoc($result)) {

    $spare_part_id = $row['spare_part_id'];

    $sql_sum_spare = "SELECT *  FROM tbl_spare_part WHERE spare_part_id = '$spare_part_id'";
    $rs_sum_spare  = mysqli_query($connection, $sql_sum_spare) or die($connection->error);
    $row_sum_spare = mysqli_fetch_array($rs_sum_spare);

    // echo "test";

    //ห้องที่ (ไล่ตาม order_id)
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row['customer_group_id']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));

    //order_no
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['spare_part_id']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));

    //ชื่อผู้จอง member_name
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $row_sum_spare['spare_part_code']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));

    //เบอร์ผู้จอง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $row_sum_spare['spare_part_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

    //เบอร์ผู้จอง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $row['unit_price']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));


    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[4] . ($rowCell))->applyFromArray($styleTextCenter);

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
$file_name = "ราคาอะไหล่ของกลุ่ม-" . $row_name['customer_group_name'];
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

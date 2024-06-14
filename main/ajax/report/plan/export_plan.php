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


$customer = $_POST['customer'];
$cus_branch = $_POST['cus_branch'];

$type_date = $_POST['type_date'];

// $start_date = explode('/', $_POST['start_date']);
// $start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

// $end_date = explode('/', $_POST['end_date']);
// $end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));

$month = $_POST['month'];
$year = $_POST['year'];

$month2 = $_POST['month2'];
$year2 = $_POST['year2'];
// $s = date('m',strtotime($_POST['start_date']));
// $s2 = date('Y',strtotime($_POST['start_date']));

// $e = date('m',strtotime($_POST['end_date']));
// $e2 = date('Y',strtotime($_POST['end_date']));

if(strlen($month) == 1){
    $pre_month = "0" . $month;
}

if(strlen($month2) == 1){
    $pre_month2 = "0" . $month2;
}

$start_date = $year . "-" . $pre_month . "-" . "01";
$end_date = $year2  . "-" . $pre_month2 . "-" . "31";


    $condition = "";
    if($customer != "x"){
        $condition .=" AND a.customer_id = '$customer' ";
    }

    $condition2 = "";
    if($cus_branch != "x"){
        $condition2 .=" AND b.customer_branch_id = '$cus_branch' ";
    }

    switch ($type_date) {
        case "1":
            $condition3 .=" AND a.customer_id IN (SELECT a.customer_id FROM tbl_customer_branch a JOIN tbl_job b ON a.customer_branch_id = b.customer_branch_id WHERE b.appointment_date BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59' )";
            break;
        case "2":
            $condition3 .=" AND a.customer_id IN (SELECT a.customer_id FROM tbl_customer_branch a JOIN tbl_job b ON a.customer_branch_id = b.customer_branch_id WHERE b.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59')";
            break;
        case "3":
            $condition3 .=" AND a.customer_id IN (SELECT a.customer_id FROM tbl_customer_branch a JOIN tbl_job b ON a.customer_branch_id = b.customer_branch_id WHERE b.start_service_time BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59')";
            break;
        default:
            $condition3 .=" AND a.customer_id IN (SELECT a.customer_id FROM tbl_customer_branch a JOIN tbl_job b ON a.customer_branch_id = b.customer_branch_id WHERE b.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59')";
    }


    $sql = "SELECT DISTINCT a.*,b.* FROM tbl_customer a  
    LEFT JOIN tbl_customer_branch b ON a.customer_id = b.customer_id
    WHERE a.active_status = 1 $condition $condition2 $condition3
    ORDER BY a.customer_code DESC
    ;";
    // echo $sql;
    $rs  = mysqli_query($connection, $sql) or die($connection->error);
    // $row = mysqli_fetch_array($rs);



    // $sql_b = "SELECT a.branch_name FROM tbl_branch a
    // JOIN tbl_customer_branch b ON a.branch_id = b.branch_care_id
    // WHERE b.customer_id = '{$row['customer_id']}' ";
    // $rs_b  = mysqli_query($connection, $sql_b) or die($connection->error);
    // $row_b = mysqli_fetch_array($rs_b);


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
$rowCell = 3;
$rowCell2 = 4;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'ลูกค้า');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell2));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(38);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'สาขา');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell2));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(30);


$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[1] . ($rowCell2))->applyFromArray($styleHeader);




////////////////////////////////////////////////////////// loop หัว
    $start_cell = 2;
    $end_cell = 7;


    $month_array = array();
    while (($year < $year2) || ($year == $year2 && $month<=$month2)) {

        if(strlen($month) == 1){
            $month = "0" . $month;
        }

        // $date = $year . "-". $month . "-" . "00";
        $date = $year . "-". $month;
        
        array_push($month_array,$date);

        

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell] . $rowCell, $date);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[$start_cell] . $rowCell . ':' . $columnCharacter[$end_cell] . ($rowCell));
        $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[$start_cell] . $rowCell . ':' . $columnCharacter[$end_cell] . ($rowCell2))->applyFromArray($styleHeader);


        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell] . $rowCell2, 'CM');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[$start_cell] . $rowCell2 . ':' . $columnCharacter[$start_cell] . ($rowCell2));
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$start_cell])->setWidth(6);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 1] . $rowCell2, 'PM');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[$start_cell + 1] . $rowCell2 . ':' . $columnCharacter[$start_cell + 1] . ($rowCell2));
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$start_cell + 1])->setWidth(6);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 2] . $rowCell2, 'Installation');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[$start_cell + 2] . $rowCell2 . ':' . $columnCharacter[$start_cell + 2] . ($rowCell2));
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$start_cell + 2])->setWidth(15);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 3] . $rowCell2, 'Overhual');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[$start_cell + 3] . $rowCell2 . ':' . $columnCharacter[$start_cell + 3] . ($rowCell2));
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$start_cell + 3])->setWidth(14);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 4] . $rowCell2, 'Other');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[$start_cell + 4] . $rowCell2 . ':' . $columnCharacter[$start_cell + 4] . ($rowCell2));
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$start_cell + 4])->setWidth(10);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 5] . $rowCell2, 'Quotation');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[$start_cell + 5] . $rowCell2 . ':' . $columnCharacter[$start_cell + 5] . ($rowCell2));
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$start_cell + 5])->setWidth(10);


        $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$start_cell + 2])->setWidth(11);



        if($month == 12){
            $month = 01;
            $year = $year + 1 ;
        }else{
            $month = $month + 1 ;
        }

        $start_cell += 6;
        $end_cell += 6;

    }

//////////////////////////////////////////////////////////

// print_r($month_array);


////////////////////////////////////////////////////////// loop ลูกค้า

switch ($type_date) {
    case "1":
        $condition .="appointment_date";
        break;
    case "2":
        $condition .="create_datetime";
        break;
    case "3":
        $condition .="start_service_time'";
        break;
    default:
        $condition .="create_datetime";
}





$rowCell_cus = 5;
while ($row = mysqli_fetch_assoc($rs)) {

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell_cus, $row['customer_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell_cus . ':' . $columnCharacter[0] . ($rowCell_cus));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell_cus, $row['branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell_cus . ':' . $columnCharacter[1] . ($rowCell_cus));

    $objPHPExcel->getActiveSheet()->getRowDimension($rowCell_cus)->setRowHeight(20);

    $start_cell = 2;

     foreach ($month_array as $value) {



     
        $sql_cm = "SELECT COUNT(job_type)AS COUNT_CM FROM tbl_job WHERE customer_branch_id = '{$row['customer_branch_id']}' AND job_type = 1  AND $condition LIKE '$value%' ;";
        // echo $sql_cm . "<br>";
        $rs_cm  = mysqli_query($connection, $sql_cm) or die($connection->error);
        $row_cm = mysqli_fetch_array($rs_cm);

        $sql_pm = "SELECT COUNT(job_type)AS COUNT_PM FROM tbl_job WHERE customer_branch_id = '{$row['customer_branch_id']}' AND job_type = 2 AND $condition LIKE '$value%' ;";
        // echo $sql_pm. "<br>";
        $rs_pm  = mysqli_query($connection, $sql_pm) or die($connection->error);
        $row_pm = mysqli_fetch_array($rs_pm);

        $sql_Installation = "SELECT COUNT(job_type)AS COUNT_Installation FROM tbl_job WHERE customer_branch_id = '{$row['customer_branch_id']}' AND job_type = 3 AND $condition LIKE '$value%' ;";
        // echo $sql_Installation. "<br>";
        $rs_Installation  = mysqli_query($connection, $sql_Installation) or die($connection->error);
        $row_Installation = mysqli_fetch_array($rs_Installation);

        $sql_overhaul = "SELECT COUNT(job_type)AS COUNT_Overhaul FROM tbl_job WHERE customer_branch_id = '{$row['customer_branch_id']}' AND job_type = 4 AND $condition LIKE '$value%' ;";
        // echo $sql_overhaul. "<br>";
        $rs_overhaul  = mysqli_query($connection, $sql_overhaul) or die($connection->error);
        $row_overhaul = mysqli_fetch_array($rs_overhaul);

        $sql_oth = "SELECT COUNT(job_type)AS COUNT_OTH FROM tbl_job WHERE customer_branch_id = '{$row['customer_branch_id']}' AND job_type = 5 AND $condition LIKE '$value%' ;";
        // echo $sql_oth. "<br>";
        $rs_oth  = mysqli_query($connection, $sql_oth) or die($connection->error);
        $row_oth = mysqli_fetch_array($rs_oth);

        $sql_quotation = "SELECT COUNT(job_type)AS COUNT_Quotation FROM tbl_job WHERE customer_branch_id = '{$row['customer_branch_id']}' AND job_type = 6 AND $condition LIKE '$value%' ;";
        // echo $sql_quotation. "<br>";
        $rs_quotation  = mysqli_query($connection, $sql_quotation) or die($connection->error);
        $row_quotation = mysqli_fetch_array($rs_quotation);

        // echo "<br>";

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell] . $rowCell_cus, $row_cm['COUNT_CM']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 1] . $rowCell_cus, $row_pm['COUNT_PM']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 2] . $rowCell_cus, $row_Installation['COUNT_Installation']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 3] . $rowCell_cus, $row_overhaul['COUNT_Overhaul']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 4] . $rowCell_cus, $row_oth['COUNT_OTH']);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$start_cell + 5] . $rowCell_cus, $row_quotation['COUNT_Quotation']);



        // $start_cell = $start_cell + 6;
        $start_cell += 6;

    }




    $rowCell_cus++;

}
//////////////////////////////////////////////////////////


   

// $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(29);
// $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[29] . ($rowCell))->getAlignment()->setWrapText(true); 
// $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[29] . ($rowCell))->applyFromArray($styleHeader);











/*-------------------------------------------------------------------------------------------------------------------------------*/

$objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
$file_name = "ReportPlan" . "_" . date("d-m-Y H_i_s");
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
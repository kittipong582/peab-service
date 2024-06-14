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

$job_type = $_POST['job_type'];
$subjob_type = $_POST['subjob_type'];
$customer = $_POST['customer'];
$cus_branch = $_POST['cus_branch'];
$team = $_POST['team'];
$staff = $_POST['staff'];
$type_date = $_POST['type_date'];

$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));


$condition = "";
$condition2 = "";
switch ($job_type) {
    case "1":
        $condition .= "AND a.job_type = 1";
        $condition2 .= "AND a.job_type = 1";
        break;
    case "2":
        $condition .= "AND a.job_type =2";
        $condition2 .= "AND a.job_type =2";
        break;
    case "3":
        $condition .= "AND a.job_type =3";
        $condition2 .= "AND a.job_type =3";
        break;
    case "4":
        $condition .= "AND a.job_type =4";
        $condition2 .= "AND a.job_type =4";
        break;
    case "5":
        $condition .= "AND a.job_type =5";
        $condition2 .= "AND a.job_type =5";
        break;
    case "6":
        $condition .= "AND a.job_type =6";
        $condition2 .= "AND a.job_type =6";
        break;
    default:
        $condition = "";
        $condition2 = "";
}


if ($subjob_type != "x" && !isset($_POST['subjob_type'])) {
    $condition .= " AND c.sub_job_type_id = '$subjob_type' ";
    $condition2 .= " AND c.sub_job_type_id = '$subjob_type' ";
}

$condition3 = "";
if ($customer != "x" && !isset($_POST['customer'])) {
    $condition .= " AND d.customer_id = '$customer' ";
    $condition2 .= " AND d.customer_id = '$customer' ";
}

$condition4 = "";
if ($cus_branch != "x" && !isset($_POST['cus_branch'])) {
    $condition .= " AND c.customer_branch_id = '$cus_branch' ";
    $condition2 .= " AND c.customer_branch_id = '$cus_branch' ";
}

$condition5 = "";
if ($team != "x" && !isset($_POST['customer'])) {
    $condition .= " AND f.branch_id = '$team' ";
    $condition2 .= " AND f.branch_id = '$team' ";
}

$condition6 = "";
if ($staff != "x" && !isset($_POST['staff'])) {
    $condition .= " AND f.user_id = '$staff' ";
    $condition2 .= " AND f.user_id = '$staff' ";
}

switch ($type_date && !isset($_POST['type_date'])) {
    case "1":
        $condition .= " AND a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        $condition2 .= " AND a.group_date BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        break;
    case "2":
        $condition .= " AND a.appointment_date BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        $condition2 .= " AND a.group_date BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        break;
    case "3":
        $condition .= " AND a.start_service_time BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        $condition2 .= " AND a.start_service_time BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        break;
    default:
        $condition .= " AND a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        $condition2 .= " AND a.group_date BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
}

$work_list = array();

$sql = "SELECT a.job_no,a.job_type,b.sub_type_name,d.customer_name,d.customer_code,c.branch_name,c.branch_code,a.create_datetime,e.fullname,f.fullname as responsible_name,g.branch_name as responsible_branch,
h.serial_no,a.appointment_date,a.appointment_time_start,a.appointment_time_end,a.start_service_time,a.finish_service_time,a.close_datetime,i.fullname AS close_name FROM tbl_job a 
    LEFT JOIN tbl_sub_job_type b ON a.sub_job_type_id = b.sub_job_type_id
    LEFT JOIN tbl_customer_branch c ON a.customer_branch_id = c.customer_branch_id   
    LEFT JOIN tbl_customer d ON c.customer_id = d.customer_id 
    LEFT JOIN tbl_user e ON a.create_user_id = e.user_id 
    LEFT JOIN tbl_user f ON a.responsible_user_id = f.user_id 
    LEFT JOIN tbl_branch g ON f.branch_id = g.branch_id 
    LEFT JOIN tbl_product h ON a.product_id = h.product_id 
    LEFT JOIN tbl_user i ON a.close_user_id = i.user_id 
     WHERE a.job_id NOT in(select b.job_id from tbl_group_pm a LEFT JOIN tbl_group_pm_detail b ON a.group_pm_id = b.group_pm_id) $condition;";
// echo $sql;
$rs  = mysqli_query($connection, $sql) or die($connection->error);
while ($row = mysqli_fetch_array($rs)) {


    if ($row['job_type'] == 1) {
        $job_type = "CM";
    } elseif ($row['job_type'] == 2) {
        $job_type = "PM";
    } else if ($row['job_type'] == 3) {
        $job_type = "INSTALLATION";
    } else if ($row['job_type'] == 5) {
        $job_type = "งานอื่นๆ";
    } else if ($row['job_type'] == 4) {
        $job_type = 'OVERHAUL';
    } else if ($row['job_type'] == 6) {
        $job_type = 'เสนอราคา';
    }

    $h = ($row['start_service_time'] == "") ? '' : (date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time'])));
    $m = ($row['start_service_time'] == "") ? '' : ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;
    $working_time =  $h . "." . number_format(abs($m));


    $h_late = ($row['start_service_time'] == "") ? '' : (date('H', strtotime($row['start_service_time'])) - date('H', strtotime($row['appointment_time_start'])));
    $m_late = ($row['start_service_time'] == "") ? '' : ((date('i', strtotime($row['start_service_time'])) - date('i', strtotime($row['appointment_time_start']))) / 60) * 10;
    $late_time =  ($h_late <= 0) ? '0' : $h_late . "." . number_format(abs($m_late));


    $temp_array = array(

        "job_no" => $row['job_no'],
        "job_type" => $job_type,
        "sub_type_name" => $row['sub_type_name'],
        "customer_name" => $row['customer_name'],
        "customer_code" => $row['customer_code'],
        "branch_name" => $row['branch_name'],
        "branch_code" => $row['branch_code'],
        "create_datetime" => $row['create_datetime'],
        "fullname" => $row['fullname'],
        "responsible_name" => $row['responsible_name'],
        "responsible_branch" => $row['responsible_branch'],
        "serial_no" => $row['serial_no'],
        "appointment_date" => (($row['appointment_date'] == "") ? "" : date("d/m/Y", strtotime($row['appointment_date']))),
        "appointment_time_start" => (($row['appointment_time_start'] == "") ? "" : date("H:i", strtotime($row['appointment_time_start']))),
        "appointment_time_end" => (($row['appointment_time_end'] == "") ? "" : date(" H:i", strtotime($row['appointment_time_end']))),
        "start_service_time" => (($row['start_service_time'] == "") ? "" : date("d/m/Y H:i", strtotime($row['start_service_time']))),
        "finish_service_time" => (($row['finish_service_time'] == "") ? "" : date("d/m/Y H:i", strtotime($row['finish_service_time']))),
        "close_datetime" => (($row['close_datetime'] == "") ? "" : date("d/m/Y H:i", strtotime($row['close_datetime']))),
        "close_name" => $row['close_name'],
        "working_time" => $working_time,
        "late_time" => $late_time,
        "type" => '1'

    );

    array_push($work_list, $temp_array);
}
// $row = mysqli_fetch_array($rs);


$sql_chk = "SELECT a.group_date,a.group_pm_id,a.start_service_time,a.finish_service_time,e.fullname,f.fullname as responsible_name,a.close_datetime,i.fullname AS close_name,g.branch_name as responsible_branch FROM tbl_group_pm a
LEFT JOIN tbl_user e ON a.create_user_id = e.user_id  
LEFT JOIN tbl_user f ON a.responsible_user_id = f.user_id
LEFT JOIN tbl_branch g ON f.branch_id = g.branch_id 
LEFT JOIN tbl_user i ON a.close_user_id = i.user_id
WHERE a.group_pm_id IN (select group_pm_id from tbl_group_pm_detail b 
LEFT JOIN tbl_job a ON a.job_id = b.job_id) $condition2";
$rs_chk  = mysqli_query($connection, $sql_chk) or die($connection->error);
// echo $sql_chk;

while ($row_chk = mysqli_fetch_array($rs_chk)) {

    $h = ($row_chk['start_service_time'] == "") ? '' : (date('H', strtotime('NOW')) - date('H', strtotime($row_chk['start_service_time'])));
    $m = ($row_chk['start_service_time'] == "") ? '' : ((date('i', strtotime('NOW')) - date('i', strtotime($row_chk['start_service_time']))) / 60) * 10;
    $working_time =  $h . "." . number_format(abs($m));


    $sql_group = "SELECT a.job_no,b.sub_type_name,d.customer_name,d.customer_code,c.branch_name,c.branch_code,a.create_datetime,
h.serial_no,a.appointment_date,a.appointment_time_start,a.appointment_time_end FROM tbl_group_pm_detail j
    LEFT JOIN tbl_job a ON a.job_id = j.job_id 
    LEFT JOIN tbl_sub_job_type b ON a.sub_job_type_id = b.sub_job_type_id
    LEFT JOIN tbl_customer_branch c ON a.customer_branch_id = c.customer_branch_id   
    LEFT JOIN tbl_customer d ON c.customer_id = d.customer_id   
    LEFT JOIN tbl_product h ON a.product_id = h.product_id  
     WHERE j.group_pm_id = '{$row_chk['group_pm_id']}';";

    $rs_group  = mysqli_query($connection, $sql_group) or die($connection->error);
    $i = 1;
    while ($row_group = mysqli_fetch_array($rs_group)) {

        $comma = ($row_group['job_no'] == "") ? '' : ',';
        $job_no .= $row_group['job_no'] . $comma;
        $sub_type_name = $row_group['sub_type_name'];
        $customer_name = $row_group['customer_name'];
        $customer_code = $row_group['customer_code'];
        $branch_name = $row_group['branch_name'];
        $branch_code = $row_group['branch_code'];
        $fullname = $row_group['fullname'];
        $serial_no .= $row_group['serial_no'] . ",";
        $appointment_date = $row_group['appointment_date'];
        $appointment_time_start = $row_group['appointment_time_start'];
        $appointment_time_end = $row_group['appointment_time_end'];



        $h_late = ($row_chk['start_service_time'] == "") ? '' : (date('H', strtotime($row_chk['start_service_time'])) - date('H', strtotime($row_group['appointment_time_start'])));
        $m_late = ($row_chk['start_service_time'] == "") ? '' : ((date('i', strtotime($row_chk['start_service_time'])) - date('i', strtotime($row_group['appointment_time_start']))) / 60) * 10;
        $late_time =  ($h_late <= 0) ? '0' : $h_late . "." . number_format(abs($m_late));

        $date1 = date("Y/m/d", strtotime($row_chk['start_service_time']));
        $date2 = date("Y/m/d", strtotime($row_chk['group_date']));

        $diff = abs(strtotime($date1) - strtotime($date2));

        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24)*24);
        // echo $days  . "<br/>";
    }



    $temp_array = array(
        "job_no" => $job_no,
        "job_type" => "PM group",
        "sub_type_name" => $sub_type_name,
        "customer_name" => $customer_name,
        "customer_code" => $customer_code,
        "branch_name" => $branch_name,
        "branch_code" => $branch_code,
        "create_datetime" => $row_chk['group_date'],
        "fullname" => $row_chk['fullname'],
        "responsible_name" => $row_chk['responsible_name'],
        "responsible_branch" => $row_chk['responsible_branch'],
        "serial_no" => $serial_no,
        "appointment_date" => (($appointment_date == "") ? "" : date("d/m/Y", strtotime($appointment_date))),
        "appointment_time_start" => (($appointment_time_start == "") ? "" : date("H:i", strtotime($appointment_time_start))),
        "appointment_time_end" => (($appointment_time_end == "") ? "" : date("H:i", strtotime($appointment_time_end))),
        "start_service_time" => (($row_chk['start_service_time'] == "") ? "" : date("d/m/Y H:i", strtotime($row_chk['start_service_time']))),
        "finish_service_time" => (($row_chk['finish_service_time'] == "") ? "" : date("d/m/Y H:i", strtotime($row_chk['finish_service_time']))),
        "close_datetime" => (($row_chk['close_datetime'] == "") ? "" : date("d/m/Y H:i", strtotime($row_chk['close_datetime']))),
        "close_name" => $row_chk['close_name'],
        "working_time" => $working_time,
        "late_time" => $late_time,
        "type" => '2'

    );

    array_push($work_list, $temp_array);
}

// print_r ($work_list);

///////////////////////////////////////////////////////////////////////////


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
$rowCell = 4;


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'เลขที่งาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'ประเภทงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'ประเภทงานย่อย');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'รหัสลูกค้า');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'ชื่อลูกค้า');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'รหัสสาขา');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'ชื่อร้าน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(40);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'วันที่สร้างรายการ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'ผู้สร้างรายการ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, 'ทีมที่ดูแล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[9])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, 'ช่างผู้ดูแล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[10])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, 'วันเวลาที่นัดหมาย');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[11])->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, 'วันเวลาที่เข้างาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[12])->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, 'เข้าล่าช้า(นาที)');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[13])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, 'แผนแล้วเสร็จ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[14])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, 'วันเวลาออกงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[15])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, 'ระยะเวลาดำเนินการ(นาที)');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[16])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, 'เสร็จล่าช้า(นาที)');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[17])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, 'วันที่ปิดงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[18])->setWidth(30);



$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(29);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[18] . ($rowCell))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[18] . ($rowCell))->applyFromArray($styleHeader);




// $temp_array = array(
//     "job_no" => $job_no,
//     "job_type" => "PM group",
//     "sub_type_name" => $sub_type_name,
//     "customer_name" => $customer_name,
//     "customer_code" => $customer_code,
//     "branch_name" => $branch_name,
//     "branch_code" => $branch_code,
//     "create_datetime" => $row_chk['create_datetime'],
//     "fullname" => $fullname,
//     "responsible_name" => $row_chk['responsible_name'],
//     "responsible_branch" => $row_chk['responsible_branch'],
//     "serial_no" => $serial_no,
//     "appointment_date" => $appointment_date,
//     "appointment_time_start" => $appointment_time_start,
//     "appointment_time_end" => $appointment_time_end,
//     "start_service_time" => $row_chk['start_service_time'],
//     "finish_service_time" => $row_chk['finish_service_time'],
//     "close_datetime" => $row_chk['close_datetime'],
//     "close_name" => $row_chk['close_name'],
//     "type" => '2'

// );

$rowCell = 5;

foreach ($work_list as $row) {

    //ห้องที่ (ไล่ตาม order_id)
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row['job_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));


    //order_no
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['job_type']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));

    //ชื่อผู้จอง member_name
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $row['sub_type_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));

    //เบอร์ผู้จอง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $row['customer_code']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $row['customer_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

    //ห้องที่ (List_order)
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $row['branch_code']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

    //ห้องที่ (List_order)
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, $row['branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));

    //ประเภทห้อง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, $row['create_datetime']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));

    //คำนำหน้าชื่อ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, $row['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));

    //ชื่อจริง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, $row['responsible_branch']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));

    //นามสกุล
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, $row['responsible_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, $row['appointment_date'] . "  " . (($row['appointment_time_start'] == "") ? '' : $row['appointment_time_start'] . " - ") . (($row['appointment_time_end'] == "") ? '' : $row['appointment_time_end']));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, $row['start_service_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, $row['late_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell,);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, $row['finish_service_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, $row['working_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell,);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, $row['close_datetime']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));



    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[18] . ($rowCell))->applyFromArray($styleTextCenter);

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
$file_name = "ReportPerformance" . "_" . date("d-m-Y H:i:s");
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

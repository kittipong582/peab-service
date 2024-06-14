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
$product_type = $_POST['product_type'];
$status = $_POST['status'];
$team = $_POST['team'];
$staff = $_POST['staff'];
$type_date = $_POST['type_date'];
$product_type = $_POST['product_type'];

$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));


$condition = "";
$condition2 = "";
if ($job_type == '1') {
    $condition .= "AND a.job_type = 1";
} elseif ($job_type == '2') {
    $condition .= "AND a.job_type =2";
} elseif ($job_type == '3') {
    $condition .= "AND a.job_type =3";
} elseif ($job_type == '4') {
    $condition .= "AND a.job_type =4";
} elseif ($job_type == '5') {
    $condition .= "AND a.job_type =5";
} elseif ($job_type == '6') {
    $condition .= "AND a.job_type =6";
}




if ($status == 'x') {
    $condition .= '';
    $condition2 .= '';
} else if ($status == '1') {
    $condition .= ' AND a.start_service_time IS NULL ';
    $condition2 .= ' AND a.start_service_time IS NULL ';
} else if ($status == '2') {
    $condition .= ' AND a.start_service_time IS NOT NULL and a.finish_service_time IS NULL';
    $condition2 .= ' AND a.start_service_time IS NOT NULL and a.finish_service_time IS NULL';
} else if ($status == '3') {
    $condition .= ' AND hold_status = 1';
    $condition2 .= ' AND hold_status = 1';
} else if ($status == '4') {

    $condition .= ' AND a.finish_service_time IS NOT NULL and a.close_datetime IS NULL';
    $condition2 .= ' AND a.finish_service_time IS NOT NULL and a.close_datetime IS NULL';
    // $condition .= ' AND a.close_datetime IS NOT NULL ';
    // $condition2 .= ' AND a.close_datetime IS NOT NULL ';
} else if ($status == '5') {

    $condition .= ' AND a.close_datetime IS NOT NULL ';
    $condition2 .= ' AND a.close_datetime IS NOT NULL ';
    // $condition .= ' AND a.cancel_datetime IS NOT NULL ';
    // $condition2 = 'AND a.cancel_datetime IS NOT NULL ';
}


if ($team != "x") {
    $condition .= " AND f.branch_id = '$team' ";
    $condition2 .= " AND g.branch_id = '$team' ";
}


if ($staff != "x") {
    $condition .= " AND g.user_id = '$staff' ";
    $condition2 .= " AND f.user_id = '$staff' ";
}

switch ($type_date) {
    case "1":
        $condition .= " AND a.start_service_time BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        $condition2 .= " AND a.start_service_time BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        break;
    case "2":
        $condition .= " AND a.create_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
        $condition2 .= " AND a.create_group_datetime BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
}


if ($product_type != "x") {
    $condition .= " AND h.product_type = '$product_type' ";
    $product_type_cond = "WHERE c.product_type = '$product_type_id'";
}

$work_list = array();

    $sql = "SELECT a.*,b.sub_type_name,c.branch_code,c.branch_name AS cus_branch_name,d.customer_name,d.customer_code,f.branch_name,g.fullname,h.serial_no,h.product_type,h.warranty_type,h.warranty_expire_date,i.brand_name,j.model_name,l.type_name,l.type_code,c.district_id
    FROM tbl_job a  

    LEFT JOIN tbl_sub_job_type b ON a.sub_job_type_id = b.sub_job_type_id
    LEFT JOIN tbl_customer_branch c ON a.customer_branch_id = c.customer_branch_id
    LEFT JOIN tbl_customer d ON c.customer_id = d.customer_id 
    LEFT JOIN tbl_branch f ON a.care_branch_id = f.branch_id
    LEFT JOIN tbl_user g ON a.responsible_user_id = g.user_id
    LEFT JOIN tbl_product h ON a.product_id = h.product_id
    LEFT JOIN tbl_product_brand i ON h.brand_id = i.brand_id
    LEFT JOIN tbl_product_model j ON h.model_id = j.model_id
    LEFT JOIN tbl_product_type l ON h.product_type = l.type_id

    WHERE a.cancel_datetime IS NULL $condition 
    ORDER BY a.job_no DESC
    ;";

// WHERE a.job_id NOT in(select job_id from tbl_group_pm_detail) AND a.cancel_datetime IS NULL $condition 
// echo $sql;
$rs  = mysqli_query($connection, $sql);
$num = mysqli_num_rows($rs);
// echo$num_rows = mysqli_num_rows($rs);
while ($row = mysqli_fetch_array($rs)) {
    $array_product = array();
    $total_income = 0;
    $sql_income = "SELECT income_amount,quantity FROM tbl_job_income WHERE job_id = '{$row['job_id']}'";
    $rs_income  = mysqli_query($connection, $sql_income);
    while ($row_income = mysqli_fetch_array($rs_income)) {

        $total_income += ($row_income['income_amount'] * $row_income['quantity']);
    }

    $product = "ยี่ห้อ: " . $row['brand_name'] . " รุ่น: " . $row['model_name'];
    ////////////////////ประกัน
    $now = strtotime("today");
    $expire_date = strtotime($row['warranty_expire_date']);
    $datediff = $expire_date - $now;

    $days_remain = round($datediff / (60 * 60 * 24));
    if ($days_remain <= 0) {
        $warranty_remain = "หมดประกัน";
    } else {
        $warranty_remain = "ในประกัน";
    }


    $cash = 0;
    $transfer = 0;
    $bill = 0;
    $sql_payment = "SELECT cash_amount,transfer_amount,customer_cost FROM tbl_job_payment_file WHERE job_id = '{$row['job_id']}'";
    $rs_payment  = mysqli_query($connection, $sql_payment);
    while ($row_payment = mysqli_fetch_array($rs_payment)) {

        $cash += $row_payment['cash_amount'];
        $transfer += $row_payment['transfer_amount'];
        $bill += $row_payment['customer_cost'];
    }


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



    if ($row['cancel_datetime'] != null) {
        $job_status = "ยกเลิกงาน";
    } else if ($row['close_user_id'] != null) {
        $job_status = "ปิดงาน" . " " .  " " . str_replace("&nbsp;", "", strip_tags($row['close_note'])) . " ";
    } else if ($row['finish_service_time'] != null) {
        $job_status = "รอปิดงาน";
    } else if ($row['start_service_time'] != null) {
        $h = date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time']));
        $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;
        $stajob_statustus =  "กำลังดำเนินการ" . " " . $h . "." . number_format(abs($m));
    } else if ($row['start_service_time'] == null) {
        $job_status = "เปิดงาน";
    }

    $datetime1 = strtotime($row['create_datetime']);
    $datetime2 = strtotime($row['finish_service_time']);
    $interval  = abs($datetime2 - $datetime1);
    $minutes   = round($interval / 60);
    $sla_status = "";
    if ($datetime2 != NULL) {
        if ($minutes > 2880) {
            $sla_status = $minutes . "  (inactive)";
        } else {
            $sla_status = $minutes . "  (active)";
        }
    }

    array_push($array_product, $row['product_id']);

    $temp_array = array(

        "job_no" => $row['job_no'],
        "job_type" => $job_type,
        "sub_type_name" => $row['sub_type_name'],
        "customer_name" => $row['customer_name'],
        "customer_code" => $row['customer_code'],
        "branch_name" => $row['cus_branch_name'],
        "branch_code" => $row['branch_code'],
        "create_datetime" => $row['create_datetime'],
        "fullname" => $row['fullname'],
        "responsible_name" => $row['fullname'],
        "responsible_branch" => $row['branch_name'],
        "serial_no" => $row['serial_no'],
        "appointment_date" => $row['appointment_date'],
        "appointment_time_start" => (($row['appointment_time_start'] == "") ? "" : date("H:i", strtotime($row['appointment_time_start']))),
        "appointment_time_end" => (($row['appointment_time_end'] == "") ? "" : date(" H:i", strtotime($row['appointment_time_end']))),
        "start_service_time" => (($row['start_service_time'] == "") ? "" : date("d/m/Y H:i", strtotime($row['start_service_time']))),
        "finish_service_time" => (($row['finish_service_time'] == "") ? "" : date("d/m/Y H:i", strtotime($row['finish_service_time']))),
        "close_datetime" => (($row['close_datetime'] == "") ? "" : date("d/m/Y H:i", strtotime($row['close_datetime']))),
        "close_name" => $row['close_name'],
        "working_time" => $working_time,
        "cancel_datetime" => $cancel_datetime,
        "brand_name" => $row['brand_name'],
        "model_name" => $row['model_name'],
        "late_time" => $late_time,
        "type" => '1',
        "product_type" => $row['type_code'] . " - " . $row['type_name'],
        "job_id" => $row['job_id'],
        "total_income" => $total_income,
        "cash" => $cash,
        "transfer" => $transfer,
        "bill" => $bill,
        "district_id" => $row['district_id'],
        "warranty_check" => $warranty_remain,
        "product" => $array_product,
        "job_status" => $job_status,
        "sla_status" => $sla_status,
        "so_no" => $row['so_no']

    );

    array_push($work_list, $temp_array);
}





if ($_POST['job_type'] == 'x' || $_POST['job_type'] == 2) {

    $sql_chk = "SELECT a.create_group_datetime
    ,a.group_date
    ,a.group_pm_id
    ,a.start_service_time
    ,a.finish_service_time
    ,e.fullname
    ,f.fullname as responsible_name
    ,a.close_datetime,i.fullname AS close_name
    ,g.branch_name as responsible_branch 
        FROM tbl_group_pm a
        LEFT JOIN tbl_user e ON a.create_user_id = e.user_id  
        LEFT JOIN tbl_user f ON a.responsible_user_id = f.user_id
        LEFT JOIN tbl_branch g ON f.branch_id = g.branch_id 
        LEFT JOIN tbl_user i ON a.close_user_id = i.user_id
        WHERE a.group_pm_id IN (select group_pm_id from tbl_group_pm_detail b 
        LEFT JOIN tbl_job a ON a.job_id = b.job_id 
        LEFT JOIN tbl_product c ON c.product_id = a.product_id
        $product_type_cond) $condition2";
    $rs_chk  = mysqli_query($connection, $sql_chk);
    // echo $sql_chk;

    while ($row_chk = mysqli_fetch_array($rs_chk)) {
        $array_product1 = array();
        
        $h = ($row_chk['start_service_time'] == "") ? '' : (date('H', strtotime('NOW')) - date('H', strtotime($row_chk['start_service_time'])));
        $m = ($row_chk['start_service_time'] == "") ? '' : ((date('i', strtotime('NOW')) - date('i', strtotime($row_chk['start_service_time']))) / 60) * 10;
        $working_time =  $h . "." . number_format(abs($m));


        $total_income = 0;

        $sql_group = "SELECT a.job_id
        ,a.job_no
        ,a.job_id
        ,b.sub_type_name
        ,d.customer_name
        ,d.customer_code
        ,c.branch_name
        ,c.branch_code
        ,a.create_datetime
        ,h.serial_no
        ,a.appointment_date
        ,a.appointment_time_start
        ,a.appointment_time_end
        ,h.brand_id,h.model_id
        ,c.district_id
        ,h.product_type
        ,a.cancel_datetime
        ,a.close_user_id
        ,a.finish_service_time
        ,a.start_service_time
        ,a.close_datetime
        ,a.close_note
        ,a.so_no
        ,a.product_id
    FROM tbl_group_pm_detail j
    LEFT JOIN tbl_job a ON a.job_id = j.job_id 
    LEFT JOIN tbl_sub_job_type b ON a.sub_job_type_id = b.sub_job_type_id
    LEFT JOIN tbl_customer_branch c ON a.customer_branch_id = c.customer_branch_id   
    LEFT JOIN tbl_customer d ON c.customer_id = d.customer_id   
    LEFT JOIN tbl_product h ON a.product_id = h.product_id  
     WHERE j.group_pm_id = '{$row_chk['group_pm_id']}';";
        // echo $sql_group."<br/>";
        $rs_group  = mysqli_query($connection, $sql_group);
        $i = 1;
        $job_no = "";
        $product_type = "";
        $serial_no = "";
        $product = "";
        $warranty_remain = "";
        while ($row_group = mysqli_fetch_array($rs_group)) {


            if ($row_group['cancel_datetime'] != null) {
                $job_status = "ยกเลิกงาน";
            } else if ($row_group['close_user_id'] != null) {
                $job_status = "ปิดงาน" . " " . " " . str_replace("&nbsp;", "", strip_tags($row_group['close_note'])) . " ";
            } else if ($row_group['finish_service_time'] != null && $row_group['finish_service_time'] != null) {
                $job_status = "รอปิดงาน";
            } else if ($row_group['start_service_time'] != null) {
                $h = date('H', strtotime('NOW')) - date('H', strtotime($row_group['start_service_time']));
                $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row_group['start_service_time']))) / 60) * 10;
                $job_status =  "กำลังดำเนินการ" . " " . $h . "." . number_format(abs($m));
            } else if ($row_group['start_service_time'] == null) {
                $job_status = "เปิดงาน";
            }


            $comma = ($row_group['job_no'] == "") ? '' : ",\n";
            $job_no .= $row_group['job_no'] . $comma;
            $sub_type_name = $row_group['sub_type_name'];
            $customer_name = $row_group['customer_name'];
            $customer_code = $row_group['customer_code'];
            $branch_name = $row_group['branch_name'];
            $branch_code = $row_group['branch_code'];
            $fullname = $row_group['fullname'];
            $serial_no .= $row_group['serial_no'] . ",";
            $cancel_datetime = $row['cancel_datetime'];
            $appointment_time_start = $row_group['appointment_time_start'];
            $appointment_time_end = $row_group['appointment_time_end'];


            $sql_type = "SELECT type_code,type_name FROM tbl_product_type WHERE type_id = '{$row_group['product_type']}'";
            $rs_type  = mysqli_query($connection, $sql_type);
            $row_type = mysqli_fetch_array($rs_type);

            $product_type .=  $row_type['type_code'] . " - " . $row_type['type_name'] . ', ';


            $h_late = ($row_chk['start_service_time'] == "") ? '' : (date('H', strtotime($row_chk['start_service_time'])) - date('H', strtotime($row_group['appointment_time_start'])));
            $m_late = ($row_chk['start_service_time'] == "") ? '' : ((date('i', strtotime($row_chk['start_service_time'])) - date('i', strtotime($row_group['appointment_time_start']))) / 60) * 10;
            $late_time =  ($h_late <= 0) ? '0' : $h_late . "." . number_format(abs($m_late));

            $date1 = date("Y/m/d", strtotime($row_chk['start_service_time']));
            $date2 = date("Y/m/d", strtotime($row_chk['group_date']));

            $diff = abs(strtotime($date1) - strtotime($date2));

            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24) * 24);
            // echo $days  . "<br/>";


            $sql_income = "SELECT income_amount,quantity FROM tbl_job_income WHERE job_id = '{$row_group['job_id']}'";
            $rs_income  = mysqli_query($connection, $sql_income);
            $row_income = mysqli_fetch_array($rs_income);

            $total_income += ($row_income['income_amount'] * $row_income['quantity']);

            $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '{$row_group['brand_id']}'";
            $result_brand  = mysqli_query($connection, $sql_brand);
            $row_brand = mysqli_fetch_array($result_brand);

            $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '{$row_group['model_id']}'";
            $result_model  = mysqli_query($connection, $sql_model);
            $row_model = mysqli_fetch_array($result_model);

            $product .= "ยี่ห้อ: " . $row_brand['brand_name'] . " รุ่น: " . $row_model['model_name'] . ", ";

            ////////////////////ประกัน
            $now = strtotime("today");
            $expire_date = strtotime($row_group['warranty_expire_date']);
            $datediff = $expire_date - $now;

            $days_remain = round($datediff / (60 * 60 * 24));
            if ($days_remain <= 0) {
                $warranty_remain .= "หมดประกัน" . ', ';
            } else {
                $warranty_remain .= "ในประกัน" . ', ';
            }

            array_push($array_product1, $row_group['product_id']);

            
        }

        $cash = 0;
        $transfer = 0;
        $bill = 0;
        $sql_payment = "SELECT cash_amount,transfer_amount,customer_cost FROM tbl_job_payment_file WHERE job_id = '{$row_chk['group_pm_id']}'";
        $rs_payment  = mysqli_query($connection, $sql_payment);
        while ($row_payment = mysqli_fetch_array($rs_payment)) {

            $cash += $row_payment['cash_amount'];
            $transfer += $row_payment['transfer_amount'];
            $bill += $row_payment['customer_cost'];
        }


        $datetime1 = strtotime($row_chk['group_date']);
        $datetime2 = strtotime($row_chk['finish_service_time']);
        $interval  = abs($datetime2 - $datetime1);
        $minutes   = round($interval / 60);
        $sla_status = "";
        if ($datetime2 != NULL) {
            if ($minutes > 2880) {
                $sla_status = $minutes . "  (inactive)";
            } else {
                $sla_status = $minutes . "  (active)";
            }
        }



        $temp_array = array(
            "job_no" => $job_no,
            "job_type" => "PM group",
            "sub_type_name" => $sub_type_name,
            "customer_name" => $customer_name,
            "customer_code" => $customer_code,
            "branch_name" => $branch_name,
            "branch_code" => $branch_code,
            "create_datetime" => $row_chk['create_group_datetime'],
            "fullname" => $row_chk['fullname'],
            "responsible_name" => $row_chk['responsible_name'],
            "responsible_branch" => $row_chk['responsible_branch'],
            "serial_no" => $serial_no,
            "appointment_date" => (($row_chk['group_date'] == "") ? "" : date("d/m/Y", strtotime($row_chk['group_date']))),
            "appointment_time_start" => (($appointment_time_start == "") ? "" : date("H:i", strtotime($appointment_time_start))),
            "appointment_time_end" => (($appointment_time_end == "") ? "" : date("H:i", strtotime($appointment_time_end))),
            "start_service_time" => (($row_chk['start_service_time'] == "") ? "" : date("d/m/Y H:i", strtotime($row_chk['start_service_time']))),
            "finish_service_time" => (($row_chk['finish_service_time'] == "") ? "" : date("d/m/Y H:i", strtotime($row_chk['finish_service_time']))),
            "close_datetime" => (($row_chk['close_datetime'] == "") ? "" : date("d/m/Y H:i", strtotime($row_chk['close_datetime']))),
            "close_name" => $row_chk['close_name'],
            "cancel_datetime" => $cancel_datetime,
            "working_time" => $working_time,
            "late_time" => $late_time,
            "type" => '2',
            "total_income" => $total_income,
            "cash" => $cash,
            "transfer" => $transfer,
            "bill" => $bill,
            "district_id" => $row_group['district_id'],
            "product_type" => $product_type,
            "warranty_check" => $warranty_remain,
            "product" => $array_product1,
            "job_status" => $job_status,
            "sla_status" => $sla_status,
            "so_no" => $row_group['so_no']


        );
        // var_dump($temp_array);
        // echo "<br/>";
        array_push($work_list, $temp_array);
    }
}

$work_data = array();
foreach ($work_list as $key => $row) {
    $work_data[$key] = $row['appointment_date'];
}
array_multisort($work_data, SORT_ASC, $work_list);

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
$rowCell = 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'เลขที่งาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'ประเภทงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'ประเภทงานย่อย');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(25);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'รหัสสาขา');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(25);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'ลูกค้า');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(25);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'ชื่อร้าน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(35);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'เขตพื้นที่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(35);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'ในประกัน/นอกประกัน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(35);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'วันที่เปิดงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, 'วันที่นัดหมาย');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[9])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, 'check in');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[10])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, 'check out');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[11])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, 'SLA');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[12])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, 'ประเภทเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[13])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, 'หมายเลขเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[14])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, 'เครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[15])->setWidth(40);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, 'อาการแจ้งซ่อม');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[16])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, 'วิธีแก้ไข');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[17])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, 'ทีมที่ดูแล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[18])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, 'ช่างผู้ดูแล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[19])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[20] . $rowCell, 'สถานะ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[20] . $rowCell . ':' . $columnCharacter[20] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[20])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[21] . $rowCell, 'รายได้');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[21] . $rowCell . ':' . $columnCharacter[21] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[21])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[22] . $rowCell, 'เงินสด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[22] . $rowCell . ':' . $columnCharacter[22] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[22])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[23] . $rowCell, 'เงินโอน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[23] . $rowCell . ':' . $columnCharacter[23] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[23])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[24] . $rowCell, 'วางบิล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[24] . $rowCell . ':' . $columnCharacter[24] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[24])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[25] . $rowCell, 'so_no');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[25] . $rowCell . ':' . $columnCharacter[25] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[25])->setWidth(16);




$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(11);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[25] . ($rowCell))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[25] . ($rowCell))->applyFromArray($styleHeader);



$rowCell = 2;

foreach ($work_list as $row) {

    $sql_district = "SELECT c.province_name_th FROM tbl_district a 
    LEFT JOIN tbl_amphoe b ON a.ref_amphoe = b.amphoe_id
    LEFT JOIN tbl_province c ON b.ref_province = c.province_id
    WHERE a.district_id = '{$row['district_id']}'";
    $rs_district  = mysqli_query($connection, $sql_district);
    $row_district = mysqli_fetch_array($rs_district);

    $reason = "";
    $symptom = "";

    $sql_fixed = "SELECT b.type_name as sym_name , c.type_name as rea_name FROM tbl_fixed a
    LEFT JOIN tbl_symptom_type b ON a.symptom_type_id = b.symptom_type_id
    LEFT JOIN tbl_reason_type c ON a.reason_type_id = c.reason_type_id
    WHERE a.job_id = '{$row['job_id']}'";
    $rs_fixed  = mysqli_query($connection, $sql_fixed);
    while ($row_fixed = mysqli_fetch_array($rs_fixed)) {

        $reason .= $row_fixed['rea_name'] . ", ";
        $symptom .= $row_fixed['sym_name'] . ", ";
    }

    // echo $sql_district;

    //order_no
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row['job_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));

    //ประเภทงาน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['job_type']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));

    //ลูกค้า
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $row['sub_type_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));

    //ลูกค้า
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $row['branch_code']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

    //ลูกค้า
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $row['customer_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

    //ชื่อร้าน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $row['branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

    //ที่อยู่ร้าน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, $row_district['province_name_th']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));

    //////////////ประกัน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, $row['warranty_check']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));

    //  วันที่เปิดงาน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, ($row['create_datetime'] == "") ? "-" : date("d/m/Y", strtotime($row['create_datetime'])));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));

    //วันที่นัดหมาย
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, ($row['appointment_date'] == "") ? "-" : $row['appointment_date']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));



    //check_in
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, $row['start_service_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));


    //check_out
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, $row['finish_service_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));


    //SLA
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, $row['sla_status']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));

    // echo $row['job_no'];
    // echo "</br>";
    $ex_rows = 0;
    foreach ($row['product'] as $key => $value) {



        $sql_product = "SELECT a.*,b.type_code,b.type_name,c.brand_name,d.model_name FROM tbl_product a 
        LEFT JOIN tbl_product_type b ON b.type_id = a.product_type
        LEFT JOIN tbl_product_brand c ON c.brand_id = a.brand_id
        LEFT JOIN tbl_product_model d ON d.model_id = a.model_id
        WHERE a.product_id = '$value'";
        // echo "</br>";
        $rs_product = mysqli_query($connection, $sql_product);
        $row_product = mysqli_fetch_assoc($rs_product);

        // echo $row_product['serial_no'];
        // echo "</br>";
        // echo $row_product['type_code'] . " " . $row_product['type_name'];
        // echo "</br>";
        //ประเภทเครื่อง
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . ($rowCell + $ex_rows), $row_product['type_code'] . " " . $row_product['type_name']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . ($rowCell + $ex_rows) . ':' . $columnCharacter[13] . ($rowCell + $ex_rows));

        //หมายเลขเครื่อง
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . ($rowCell + $ex_rows), $row_product['serial_no']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . ($rowCell + $ex_rows) . ':' . $columnCharacter[14] . ($rowCell + $ex_rows));

        //เครื่อง
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . ($rowCell + $ex_rows), "ยี่ห้อ: " . $row_product['brand_name'] . " รุ่น: " . $row_product['model_name']);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . ($rowCell + $ex_rows) . ':' . $columnCharacter[15] . ($rowCell + $ex_rows));

        $ex_rows++;
        // echo "</br>";
    }



    //อาการเสีย
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, $symptom);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));

    //วิธีแก้
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, $reason);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));



    //ทีมงาน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, $row['responsible_branch']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));

    //ชาสงดูแล
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, $row['responsible_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[20] . $rowCell, $row['job_status']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[20] . $rowCell . ':' . $columnCharacter[20] . ($rowCell));


    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[21] . $rowCell, number_format($row['total_income'], 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[21] . $rowCell . ':' . $columnCharacter[21] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[22] . $rowCell, number_format($row['cash'], 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[22] . $rowCell . ':' . $columnCharacter[22] . ($rowCell));
    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[23] . $rowCell, number_format($row['transfer'], 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[23] . $rowCell . ':' . $columnCharacter[23] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[24] . $rowCell, number_format($row['bill'], 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[24] . $rowCell . ':' . $columnCharacter[24] . ($rowCell));


    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[25] . $rowCell, $row['so_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[25] . $rowCell . ':' . $columnCharacter[25] . ($rowCell));



    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[25] . ($rowCell + $ex_rows))->applyFromArray($styleTextCenter)->getAlignment()->setWrapText(true);

    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[1] . ($rowCell))->applyFromArray($styleTextCenter);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell))->applyFromArray($styleTextLeft);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[3] . $rowCell . ':' . $columnCharacter[7] . ($rowCell))->applyFromArray($styleTextCenter);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[8] . $rowCell . ':' . $columnCharacter[9] . ($rowCell))->applyFromArray($styleTextLeft);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[10] . $rowCell . ':' . $columnCharacter[16] . ($rowCell))->applyFromArray($styleTextCenter);



    $rowCell =  $rowCell + $ex_rows;
}

/*-------------------------------------------------------------------------------------------------------------------------------*/

$objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
$file_name = "ReportOverall" . "_" . date("d-m-Y H:i:s");
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

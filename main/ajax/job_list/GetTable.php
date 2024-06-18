<?php

session_start();

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$starttime = microtime(true);



$search_status = $_POST['search_status'];

$start_date = $_POST['start_date'];

$end_date = $_POST['end_date'];

$branch = $_POST['branch'];

$job_type = $_POST['job_type'];

$insurance_status = $_POST['insurance_status'];

$user_id = $_SESSION['user_id'];

$user_level = $_SESSION['user_level'];

$admin_status = $_SESSION['admin_status'];

$job_status = $_POST['job_status'];

$session_id = $_SESSION['user_id'];

$user_point = $_POST['user_point'];

$team_id = $_POST['team_id'];

$sub_title = $_POST['sub_title'];

$job_no = $_POST['search_text'];

$create_user = $_POST['create_user'];

$brand_id = $_POST['brand_id'];

$model_id = $_POST['model_id'];

//////////////////////////////////job ปกติ /////////////////////////////////////////////////////////////////////////////

$customer_branch = $_POST['customer_branch_text'];

///////////////job_no

$condition_job = "";

if ($job_no != "") {

    $condition_job .= "AND a.job_no LIKE '%$job_no%'";
}

if ($create_user != "x") {

    $condition_job .= "AND a.create_user_id = '$create_user'";
}

///////////////////sub_job

$condition4  = "";

if ($sub_title != 'x') {

    $condition4  .= "AND a.sub_job_type_id = '$sub_title'";
}



if ($customer_branch != "") {

    $condition4 .= "AND (b.branch_code LIKE '%$customer_branch%' or b.branch_name LIKE '%$customer_branch%')";
}



///////////////team

if ($team_id == 'x') {

    $con_team = "";
} else {

    $con_team = "AND e.branch_id = '$team_id'";
}



///////////user

if ($user_point == 'x') {

    $con_user_status  = "";
} else {

    $con_user_status   = "AND a.responsible_user_id = '$user_point'";
}



///////////////////////////time

if ($job_status == 'x') {

    $conn_status = '';
} else if ($job_status == '5') {

    $conn_status = 'AND a.cancel_datetime IS NOT NULL ';
} else if ($job_status == '4') {

    $conn_status = 'AND a.close_datetime IS NOT NULL ';
} else if ($job_status == '3') {

    $conn_status = 'AND a.finish_service_time IS NOT NULL and a.close_datetime IS NULL';
} else if ($job_status == '2') {

    $conn_status = 'AND a.start_service_time IS NOT NULL and a.finish_service_time IS NULL and a.close_datetime IS NULL';
} else if ($job_status == '1') {

    $conn_status = 'AND a.start_service_time IS NULL AND a.close_datetime IS NULL';
}



////////////////////group pm

$condition_group = "AND a.job_id NOT in(select job_id from  tbl_group_pm_detail)";



if ($user_level == 1) {

    $condition3 = " AND a.responsible_user_id = '$user_id'";
} else if ($user_level == 2) {

    $sql_cf = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";

    $result_cf  = mysqli_query($connect_db, $sql_cf);

    $row_cf = mysqli_fetch_array($result_cf);

    $cf_care = $row_cf['branch_id'];

    $con_chief = "e.branch_id = '$cf_care'";
}



$start_date = explode('/', $_POST['start_date']);

$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));



$end_date = explode('/', $_POST['end_date']);

$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));



//////////////////////not time check

if ($insurance_status == 0) {

    $time = "BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
} else {



    $time = "";
}



////////////////////////choose time type

$search_condition = "";

if ($search_status == "1") {

    $search_condition .= "a.appointment_date";
} else if ($search_status == "2") {

    $search_condition .= "a.create_datetime ";
} else {

    $search_condition .= "a.start_service_time ";
}



///////////////////////////branch

$condition = "";

if ($branch != "x" && $branch != "") {

    $condition .= "AND e.branch_id = '$branch'";
}

////////////job_type

$condition2 = "";

if ($job_type != "x") {

    $condition2 .= "AND a.job_type = '$job_type'";
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//// brand
$condition_brand = "";
if ($brand_id != "x") {
    $condition_brand .= "AND y.brand_id = '$brand_id'";
}

//// model
$condition_model = "";
if ($model_id != "x") {
    $condition_model .= "AND z.model_id = '$model_id'";
}





///////////////////////////////////////////////job กลุ่ม//////////////////////////////////////////////////////////

$condition_jobgroup = "";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ($admin_status == 9) {

    $sql_ref = "SELECT a.*,
    b.branch_name AS cus_branch,
    c.customer_name as cus_name,
    d.fullname,
    d.mobile_phone,
    e.branch_name,
    f.sub_type_name,
    a.create_datetime AS job_create,
    b.branch_code AS cus_branch_code,
    c.customer_code,
    x.brand_id,
    z.model_id

    FROM tbl_job a 

    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id

    LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id

    LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id

    LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id

    LEFT JOIN tbl_sub_job_type f ON a.sub_job_type_id = f.sub_job_type_id

    LEFT JOIN tbl_user g ON a.create_user_id = g.user_id
    
    LEFT JOIN tbl_product x ON a.product_id = x.product_id

    LEFT JOIN tbl_product_brand y ON y.brand_id = x.brand_id

    LEFT JOIN tbl_product_model z ON z.model_id = x.model_id

    WHERE $search_condition $time  $condition $condition2  $condition3 $condition_group $conn_status  $con_team $con_user_status  $condition4 $condition_job $condition_brand $condition_model

    ORDER BY a.create_datetime DESC";

    $result_ref  = mysqli_query($connect_db, $sql_ref);



    $sql_chk = "SELECT * FROM tbl_group_pm a

    LEFT JOIN tbl_user g ON a.create_user_id = g.user_id

    WHERE a.group_pm_id IN (select group_pm_id from tbl_group_pm_detail c 

    LEFT JOIN tbl_job a ON a.job_id = c.job_id 

    LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id 

    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
    
    LEFT JOIN tbl_product x ON a.product_id = x.product_id

    LEFT JOIN tbl_product_brand y ON y.brand_id = x.brand_id

    LEFT JOIN tbl_product_model z ON z.model_id = x.model_id

    WHERE  $search_condition $time $condition_job $condition2 $conn_status $condition4 $con_team $con_user_status $condition_brand $condition_model)  ";

    $result_chk  = mysqli_query($connect_db, $sql_chk);
} else {

    if ($user_level == 1) {

        $sql_ref = "SELECT a.*,b.branch_name AS cus_branch,
        c.customer_name as cus_name,
        d.fullname,d.mobile_phone,
        e.branch_name,
        f.sub_type_name,
        a.create_datetime AS job_create,
        b.branch_code AS cus_branch_code,
        c.customer_code,
        x.brand_id,
        z.model_id

        FROM tbl_job a

        LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id

        LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id

        LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id

        LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id

        LEFT JOIN tbl_sub_job_type f ON a.sub_job_type_id = f.sub_job_type_id

        LEFT JOIN tbl_product x ON a.product_id = x.product_id

        LEFT JOIN tbl_product_brand y ON y.brand_id = x.brand_id

        LEFT JOIN tbl_product_model z ON z.model_id = x.model_id

        WHERE  (a.responsible_user_id = '$user_id' AND $search_condition $time $condition2  $conn_status $con_team  $condition4 $condition_job $condition_group $condition_brand $condition_model)

        OR (a.get_oh_user = '$user_id' AND a.get_oh_datetime $time $condition2  $conn_status $con_team  $condition4 $condition_job $condition_group $condition_brand $condition_model)

        OR (a.send_oh_user = '$user_id' AND a.send_oh_datetime $time $condition2  $conn_status $con_team  $condition4 $condition_job $condition_group $condition_brand $condition_model)

        OR (a.get_qcoh_user = '$user_id' AND a.get_qcoh_datetime $time $condition2  $conn_status $con_team  $condition4 $condition_job $condition_group $condition_brand $condition_model)

        OR (a.send_qcoh_user = '$user_id' AND a.send_qcoh_datetime $time $condition2  $conn_status $con_team  $condition4 $condition_job $condition_group $condition_brand $condition_model)

        OR (a.pay_oh_user = '$user_id' AND a.pay_oh_datetime $time $condition2  $conn_status $con_team  $condition4 $condition_job $condition_group $condition_brand $condition_model)

        OR (a.return_oh_user = '$user_id' AND a.return_datetime $time $condition2  $conn_status $con_team  $condition4 $condition_job $condition_group $condition_brand $condition_model)

        OR (a.job_id IN(SELECT job_id FROM tbl_job_staff WHERE staff_id = '$user_id' ) AND $search_condition $time $condition2  $conn_status $con_team  $condition4 $condition_job $condition_group $condition_brand $condition_model)";

        $result_ref  = mysqli_query($connect_db, $sql_ref);

        $sql_chk = "SELECT * FROM tbl_group_pm a

        LEFT JOIN tbl_user g ON a.create_user_id = g.user_id

        WHERE a.group_pm_id IN (select group_pm_id from tbl_group_pm_detail c 

        LEFT JOIN tbl_job a ON a.job_id = c.job_id 

        LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id 

        LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id

        LEFT JOIN tbl_product x ON a.product_id = x.product_id
        
        LEFT JOIN tbl_product_brand y ON y.brand_id = x.brand_id

        LEFT JOIN tbl_product_model z ON z.model_id = x.model_id

        WHERE  $search_condition $time and a.responsible_user_id = '$user_id' $condition $condition2  $conn_status  $con_team   $condition4 $condition_job $condition_brand $condition_model

        OR a.job_id IN(SELECT job_id FROM tbl_job_staff WHERE staff_id = '$user_id' ) AND $search_condition $time $condition2  $conn_status $con_team  $condition4 $condition_job $condition_brand $condition_model)";

        $result_chk  = mysqli_query($connect_db, $sql_chk);
    } else if ($user_level == 2) {

        $sql_ref = "SELECT a.*,b.branch_name AS cus_branch,c.customer_name as cus_name,d.fullname,d.mobile_phone,e.branch_name,f.sub_type_name,a.create_datetime AS job_create,b.branch_code AS cus_branch_code,c.customer_code,x.brand_id,z.model_id
        
        FROM tbl_job a

        LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id

        LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id

        LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id

        LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id

        LEFT JOIN tbl_sub_job_type f ON a.sub_job_type_id = f.sub_job_type_id

        
        LEFT JOIN tbl_product x ON a.product_id = x.product_id
        
        LEFT JOIN tbl_product_brand y ON y.brand_id = x.brand_id

        LEFT JOIN tbl_product_model z ON z.model_id = x.model_id

        WHERE  (a.responsible_user_id = '$user_id' AND $search_condition $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.get_oh_user = '$user_id' AND a.get_oh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.send_oh_user = '$user_id' AND a.send_oh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.get_qcoh_user = '$user_id' AND a.get_qcoh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.send_qcoh_user = '$user_id' AND a.send_qcoh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.pay_oh_user = '$user_id' AND a.pay_oh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.return_oh_user = '$user_id' AND a.return_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.job_id IN(SELECT job_id FROM tbl_job_staff WHERE staff_id = '$user_id') AND $search_condition $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.job_id IN(SELECT c.job_id FROM tbl_user a  

        LEFT JOIN tbl_user b ON a.branch_id = b.branch_id 

        LEFT JOIN tbl_job c ON b.user_id = c.responsible_user_id

        WHERE a.user_id = '$user_id' and b.user_level = 1) AND $search_condition $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        ";

        $result_ref  = mysqli_query($connect_db, $sql_ref);


        $sql_chk = "SELECT * FROM tbl_group_pm

            WHERE group_pm_id IN (select group_pm_id from tbl_group_pm_detail c 

            LEFT JOIN tbl_job a ON a.job_id = c.job_id 

            LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id 

            LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
                    
            LEFT JOIN tbl_product x ON a.product_id = x.product_id
        
            LEFT JOIN tbl_product_brand y ON y.brand_id = x.brand_id

            LEFT JOIN tbl_product_model z ON z.model_id = x.model_id

            WHERE $con_chief and $search_condition $time $condition $condition2  $condition3 $conn_status  $con_team $con_user_status  $condition4 $condition_job $condition_brand $condition_model)";

        $result_chk  = mysqli_query($connect_db, $sql_chk);
    } else {

        $sql_user = "SELECT zone_id FROM tbl_user WHERE user_id = '$user_id'";

        $result_user  = mysqli_query($connect_db, $sql_user);

        $row_user = mysqli_fetch_array($result_user);

        $zone_id = $row_user['zone_id'];

        $sql_ref = "SELECT a.*,b.branch_name AS cus_branch,c.customer_name as cus_name,d.fullname,d.mobile_phone,e.branch_name,f.sub_type_name,a.create_datetime AS job_create,b.branch_code AS cus_branch_code,c.customer_code,x.brand_id,z.model_id
        
        FROM tbl_job a

        LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id

        LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id

        LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id

        LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id

        LEFT JOIN tbl_sub_job_type f ON a.sub_job_type_id = f.sub_job_type_id

        LEFT JOIN tbl_product x ON a.product_id = x.product_id

        LEFT JOIN tbl_product_brand y ON y.brand_id = x.brand_id

        LEFT JOIN tbl_product_model z ON z.model_id = x.model_id

        WHERE  (a.responsible_user_id = '$user_id' AND $search_condition $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.get_oh_user = '$user_id' AND a.get_oh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.send_oh_user = '$user_id' AND a.send_oh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.get_qcoh_user = '$user_id' AND a.get_qcoh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.send_qcoh_user = '$user_id' AND a.send_qcoh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.pay_oh_user = '$user_id' AND a.pay_oh_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.return_oh_user = '$user_id' AND a.return_datetime $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.job_id IN(SELECT job_id FROM tbl_job_staff WHERE staff_id = '$user_id') AND $search_condition $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job $condition_brand $condition_model)

        OR (a.job_id IN(SELECT d.job_id FROM tbl_user a  

        LEFT JOIN tbl_branch b ON a.zone_id = b.zone_id 

        LEFT JOIN tbl_user c ON b.branch_id = c.branch_id 

        LEFT JOIN tbl_job d ON c.user_id = d.responsible_user_id

        WHERE a.user_id = '$user_id' and b.zone_id = '$zone_id') AND $search_condition $time $condition2 $condition_group $conn_status $con_team $con_user_status $condition4 $condition_job)

        ";

        $result_ref  = mysqli_query($connect_db, $sql_ref);



        $sql_chk = "SELECT * FROM tbl_group_pm

        WHERE group_pm_id IN (select group_pm_id from tbl_group_pm_detail b 

        LEFT JOIN tbl_job a ON a.job_id = b.job_id 

        LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id 

        LEFT JOIN tbl_product x ON a.product_id = x.product_id
        
        LEFT JOIN tbl_product_brand y ON y.brand_id = x.brand_id

        LEFT JOIN tbl_product_model z ON z.model_id = x.model_id

        WHERE $search_condition $time  and e.zone_id = '$zone_id' $condition $condition2  $condition3  $conn_status  $con_team $con_user_status  $condition4 $condition_job $condition4 $condition_job)";

        $result_chk  = mysqli_query($connect_db, $sql_chk);
    }
}



// echo $sql_chk;

//  

$work_list = array();

while ($row = mysqli_fetch_array($result_ref)) {


    $sql_sub_job = "SELECT * FROM tbl_sub_job_type WHERE sub_job_type_id = '{$row['sub_job_type_id']}'";

    $result_sub_job  = mysqli_query($connect_db, $sql_sub_job);

    $row_sub_job = mysqli_fetch_array($result_sub_job);



    $sql_create = "SELECT * FROM tbl_user WHERE user_id = '{$row['create_user_id']}'";

    $result_create  = mysqli_query($connect_db, $sql_create);

    $row_create = mysqli_fetch_array($result_create);





    $new_customer = $row['customer_code'] . " - " . $row['cus_name'] . "<br>" . $row['cus_branch_code'] . " - " . $row['cus_branch'];

    if ($row['customer_branch_id'] == "" && $row['job_customer_type'] == 2) {



        $new_customer = "ลูกค้าใหม่" . "<font color='red'>***</font>";
    }





    if ($row['job_type'] == 1) {

        $job_type = "CM";

        $sub_title = $row_sub_job['sub_type_name'];
    } elseif ($row['job_type'] == 2) {

        $job_type = "PM";

        $sub_title = $row_sub_job['sub_type_name'];
    } else if ($row['job_type'] == 3) {

        $job_type = "INSTALLATION";

        $sub_title = $row_sub_job['sub_type_name'];
    } else if ($row['job_type'] == 5) {

        $job_type = "งานอื่นๆ" . "</br>" . $row['sub_type_name'];

        $sub_title = $row_sub_job['sub_type_name'];
    } else if ($row['job_type'] == 4) {

        $job_type = 'OVERHAUL';

        $sub_title = "งานย่อยปกติ";
    } else if ($row['job_type'] == 6) {

        $job_type = 'เสนอราคา';

        $sub_title = $row_sub_job['sub_type_name'];
    }



    if ($row['cancel_datetime'] != null) {

        $status = "ยกเลิกงาน";
    } else if ($row['close_user_id'] != null) {

        $status = "ปิดงาน" . "<br/>" .  "<font color='red'>" . strip_tags(str_replace(" ", "", $row['close_note'])) . "</font>";
    } else if ($row['finish_service_time'] != null) {

        $status = "รอปิดงาน";
    } else if ($row['start_service_time'] != null) {

        $h = date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time']));

        $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;

        $status =  "กำลังดำเนินการ" . "<br>" . $h . "." . number_format(abs($m));
    } else if ($row['start_service_time'] == null) {

        $status = "เปิดงาน";
    }





    $status_oh = '';

    if ($row['job_type'] == 4) {

        if ($row['pay_oh_datetime'] != null) {

            $status_oh = '(ชำระแล้ว)';
        } else if ($row['send_qcoh_datetime'] != null) {

            $status_oh = '(ส่ง QC แล้ว)';
        } else if ($row['get_qcoh_datetime'] != null) {

            $status_oh = '(เปิด QC แล้ว)';
        } else if ($row['send_oh_datetime'] != null) {

            $status_oh = '(ล้างเครื่องเสร็จแล้ว)';
        } else if ($row['get_oh_datetime'] != null) {

            $status_oh = '(เปิดล้างเครื่องแล้ว)';
        }
    }





    $temp_array = array(



        "sub_job_type_id" => $row['sub_job_type_id'],

        "create_user_id" => $row['create_user_id'],

        "job_type" => $job_type,

        "sub_title" => $sub_title,

        "new_customer" => $new_customer,

        "create_user_name" => $row_create['fullname'],

        "status" => $status,

        "status_oh" => $status_oh,

        "job_id" => $row['job_id'],

        "job_no" => $row['job_no'],

        "job_create" => $row['job_create'],

        "contact_name" => $row['contact_name'],

        "contact_phone" => $row['contact_phone'],

        "fullname" => $row['fullname'],

        "mobile_phone" => $row['mobile_phone'],

        "branch_name" => $row['branch_name'],
        "receipt_no" => $row['receipt_no'],

        "appointment_date" => $row['appointment_date'],

        "appointment_time" => $row['appointment_time'],

        "type" => '1',

        "start_service_time" => $row['start_service_time'],

        "row_job_type" => $row['job_type'],

        "button_group" => 1,
        "so_no" => $row['so_no'],
        "list_pm_job" => $row['list_pm_job']

    );



    array_push($work_list, $temp_array);
}



$i = 0;

while ($row_chk = mysqli_fetch_array($result_chk)) {







    $group_pm_id = $row_chk['group_pm_id'];



    $sql_pm = "SELECT a.*,b.branch_name AS cus_branch,c.customer_name as cus_name,d.fullname,d.mobile_phone,e.branch_name,f.sub_type_name,a.create_datetime AS job_create,b.branch_code AS cus_branch_code,c.customer_code FROM tbl_group_pm_detail g

LEFT JOIN tbl_job a ON g.job_id = a.job_id

    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id

    LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id

    LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id

    LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id

    LEFT JOIN tbl_sub_job_type f ON a.sub_job_type_id = f.sub_job_type_id

 WHERE g.group_pm_id = '$group_pm_id'  ";

    $result_pm  = mysqli_query($connect_db, $sql_pm);

    $row_pm = mysqli_fetch_array($result_pm);



    $sql_sub_job = "SELECT * FROM tbl_sub_job_type WHERE sub_job_type_id = '{$row_pm['sub_job_type_id']}'";

    $result_sub_job  = mysqli_query($connect_db, $sql_sub_job);

    $row_sub_job = mysqli_fetch_array($result_sub_job);



    $sql_create = "SELECT * FROM tbl_user WHERE user_id = '{$row_chk['create_user_id']}'";

    $result_create  = mysqli_query($connect_db, $sql_create);

    $row_create = mysqli_fetch_array($result_create);





    $new_customer = $row_pm['customer_code'] . " - " . $row_pm['cus_name'] . "<br>" . $row_pm['cus_branch_code'] . " - " . $row_pm['cus_branch'];

    if ($row_pm['customer_branch_id'] == "" && $row_pm['job_customer_type'] == 2) {

        $new_customer = "ลูกค้าใหม่" . "<font color='red'>***</font>";
    }

    if ($row_pm['job_type'] == 1) {

        $job_type = "CM";

        $sub_title = $row_sub_job['sub_type_name'];
    } elseif ($row_pm['job_type'] == 2) {

        $job_type = "PM";

        $sub_title = $row_sub_job['sub_type_name'];
    } else if ($row_pm['job_type'] == 3) {

        $job_type = "INSTALLATION";

        $sub_title = $row_sub_job['sub_type_name'];
    } else if ($row_pm['job_type'] == 5) {

        $job_type = "งานอื่นๆ" . "</br>" . $row_pm['sub_type_name'];

        $sub_title = $row_sub_job['sub_type_name'];
    } else if ($row_pm['job_type'] == 4) {

        $job_type = 'OVERHAUL';

        $sub_title = "งานย่อยปกติ";
    } else if ($row_pm['job_type'] == 6) {

        $job_type = 'เสนอราคา';

        $sub_title = $row_sub_job['sub_type_name'];
    }



    if ($row_pm['cancel_datetime'] != null) {

        $status = "ยกเลิกงาน";
    } else if ($row_pm['close_user_id'] != null) {

        $status = "ปิดงาน" . "<br/>" . "<font color='red'>" . strip_tags(str_replace(" ", "", $row_pm['close_note'])) . "</font>";
    } else if ($row_pm['finish_service_time'] != null) {

        $status = "รอปิดงาน";
    } else if ($row_pm['start_service_time'] != null) {

        $h = date('H', strtotime('NOW')) - date('H', strtotime($row_pm['start_service_time']));

        $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row_pm['start_service_time']))) / 60) * 10;

        $status =  "กำลังดำเนินการ" . "<br>" . $h . "." . number_format(abs($m));
    } else if ($row_pm['start_service_time'] == null) {

        $status = "เปิดงาน";
    }





    $status_oh = '';





    $temp_array = array(



        "sub_job_type_id" => "",

        "create_user_id" => $row_chk['create_user_id'],

        "job_type" => 'กลุ่มงาน PM',

        "sub_title" => $sub_title,

        "new_customer" => $new_customer,

        "create_user_name" => $row_create['fullname'],

        "status" => $status,

        "status_oh" => $status_oh,

        "job_id" => $group_pm_id,

        "job_no" => $row_pm['job_no'],

        "job_create" => $row_pm['job_create'],

        "contact_name" => $row_pm['contact_name'],

        "contact_phone" => $row_pm['contact_phone'],

        "fullname" => $row_pm['fullname'],

        "mobile_phone" => $row_pm['mobile_phone'],

        "branch_name" => $row_pm['branch_name'],

        "appointment_date" => $row_chk['group_date'],

        "appointment_time" => $row_pm['appointment_time'],

        "type" => '2',

        "start_service_time" => $row['start_service_time'],

        "row_job_type" => "",

        "button_group" => 0,
        "receipt_no" => $row_pm['receipt_no'],
        "so_no" => $row_chk['so_no'],
        "list_pm_job" => $row['list_pm_job']



    );



    array_push($work_list, $temp_array);
}







// echo $sql_ref;  





//array_sort 

array_multisort(array_column($work_list, 'appointment_date'), SORT_DESC, $work_list);

// var_dump($work_list) . "<br/>";

// echo $sql_ref;



$endtime = microtime(true);

echo $duration = $endtime - $starttime; //calculates total time taken

echo "<br/>";

$mem_usage = memory_get_usage();

echo ($mem_usage / 1024);



mysqli_close($connect_db);

?>



<table class="table table-striped table-bordered table-hover" id="table_job1">

    <thead>

        <tr>

            <th class="text-center" style="width: 200px;">ชนิดงาน</th>

            <th class="text-center" style="width: 270px;">ชื่องาน</th>

            <th class="text-center" style="width: 230px;">เลขที่งาน</th>

            <th class="text-left" style="width: 500px;">ลูกค้า</th>

            <th class="text-left" style="width: 100px;">ผู้ติดต่อ</th>

            <th class="text-center" style="width: 300px;">ผู้รับผิดชอบ</th>

            <th class="text-center" style="width: 220px;">ผู้ทำรายการ</th>

            <th class="text-left" style="width: 200px;">สถานะ</th>


        </tr>

    </thead>

    <tbody>

        <?php

        $i = 0;

        $pmgroup_id = array();

        foreach ($work_list as $row) {



        ?>



            <tr>



                <td class="text-center" style="width: 200px;"><?php echo $row['job_type'] . "<br/>" . $row['status_oh']; ?>
                </td>

                <td class="text-center" style="width: 270px;"><?php echo $row['sub_title'] ?></td>

                <td class="text-center" style="width: 230px;">

                    <a href="view_cm.php?id=<?php echo $row['job_id']; ?>&&type=<?php echo $row['type']; ?>" target="_blank"><?php echo $row['job_no']; ?></a>
                    <?php echo "</br>" . date("d-m-Y", strtotime($row['job_create'])) ?>
                    <?php echo ($row['list_pm_job'] != "") ? "</br>" . "รอบ PM " . $row['list_pm_job'] . " / " . date("Y", strtotime($row['job_create'])) : "" ?>
                    <?php echo ($row['receipt_no'] != "") ? "<br/>" . $row['receipt_no'] : "" ?>

                </td>



                <td class="text-left" style="width: 500px;"><?php echo $row['new_customer'] ?></td>

                <td class="text-left" style="width: 100px;">
                    <?php echo $row['contact_name']; ?><br><?php echo $row['contact_phone']; ?></td>

                <td class="text-center" style="width: 250px;">
                    <?php echo $row['fullname']; ?><br><?php echo $row['branch_name']; ?><br>

                    <font style="color: green;"><?php if ($row['appointment_date'] != null) {

                                                    echo date('d-M-Y', strtotime($row['appointment_date']));

                                                ?> <br> <?php echo date('H:i', strtotime($row['appointment_time']));
                                                    } ?></font>

                </td>



                <td class="text-center" style="width: 220px;"><?php echo $row['create_user_name'] ?>

                    <?php if ($row['so_no'] == "") { ?>
                        <br><button class="btn btn-xs btn-success " onclick="So_modal('<?PHP echo $row['job_id'] ?>')">เพิ่ม So No</button>
                    <?php } else {
                        echo "</br> [" . $row['so_no'] . "]";
                    } ?>
                </td>

                <td class="text-left" style="width: 200px;"><?php echo $row['status'] ?><br>

                    <div class="form-group">

                        <?php if ($row['row_job_type'] == 2 && $row['button_group'] == 1) { ?>

                            <button class="btn btn-xs btn-success " onclick="Group_pm('<?PHP echo $row['job_id'] ?>')">รวมงาน</button>

                        <?php } else {

                            echo "  ";
                        } ?>

                    </div>
                    <div class="form-group">
                        <?php if ($row['create_user_id'] == $session_id) { ?>
                            <button class="btn btn-xs btn-danger " onclick="delete_job('<?php echo $row['job_id']; ?>','<?php echo $row['type']; ?>');">ลบงาน</button>

                        <?php } else {

                            echo "  ";
                        } ?>

                    </div>
                </td>
                </td>
            </tr>

        <?php

        }

        ?>

    </tbody>

</table>
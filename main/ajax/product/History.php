<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$product_id = $_POST['product_id'];


$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));

$status = $_POST['status'];
$chk_date = $_POST['chk'];
$date_order_by = $_POST['date_order_by'];

if ($status == '1') {
    $conn_status = '';
} else if ($status == '6') {
    $conn_status = 'AND a.cancel_datetime IS NOT NULL ';
} else if ($status == '5') {
    $conn_status = 'AND a.close_datetime IS NOT NULL ';
} else if ($status == '4') {
    $conn_status = 'AND a.finish_service_time IS NOT NULL and a.close_datetime IS NULL';
} else if ($status == '3') {
    $conn_status = 'AND a.start_service_time IS NOT NULL and a.finish_service_time IS NULL';
} else if ($status == '2') {
    $conn_status = 'AND a.start_service_time IS NULL AND a.close_datetime IS NULL';
}


if ($chk_date == 0) {

    $time = "BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
} else {
    $time = "";
}


$search_condition = "";
$search_condition1 = "";
if ($date_order_by == "2") {
    $search_condition .= "AND a.appointment_date";
    $search_condition1 .= "AND a.group_date";
} else if ($date_order_by == "1") {
    $search_condition .= "AND a.create_datetime ";
    $search_condition1 .= "AND a.create_group_datetime";
} else {
    $search_condition .= "AND a.start_service_time ";
    $search_condition1 .= "AND a.start_service_time";
}

$condition = "";
$condition1 = "";
if ($branch != "x" && $branch != "") {
    $condition .= "AND e.branch_id = '$branch'";
    $condition1 .= "AND e.branch_id = '$branch'";
}


if ($job_type != "x") {
    $condition .= "AND a.job_type = '$job_type'";
    $condition1 .= "AND a.job_type = '$job_type'";
}


$job_list = array();


$sql = "SELECT a.*,f.sub_type_name FROM tbl_job a
LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id
LEFT JOIN tbl_sub_job_type f ON a.sub_job_type_id = f.sub_job_type_id
WHERE product_id = '$product_id' $search_condition $time $conn_status AND job_id NOT in(select job_id from  tbl_group_pm_detail) AND a.qc_status = '0'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
while ($row = mysqli_fetch_assoc($rs)) {

    $i++;
    $job_id = $row['job_id'];
    $customer_branch_id = $row['customer_branch_id'];
    $branch_id = $row['care_branch_id'];
    $responsible_user_id = $row['responsible_user_id'];

    $sql_fixed = "SELECT *,b.type_name AS sym_name,c.type_name AS rea_name FROM tbl_fixed a
    LEFT JOIN tbl_symptom_type b ON a.symptom_type_id = b.symptom_type_id
    LEFT JOIN tbl_reason_type c ON a.reason_type_id = c.reason_type_id
     WHERE a.job_id = '$job_id'";
    $rs_fixed = mysqli_query($connect_db, $sql_fixed) or die($connect_db->error);
    $row_fixed = mysqli_fetch_assoc($rs_fixed);


    $sql_team = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id'";
    $rs_team = mysqli_query($connect_db, $sql_team) or die($connect_db->error);
    $row_team = mysqli_fetch_assoc($rs_team);

    $sql_user = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id'";
    $rs_user = mysqli_query($connect_db, $sql_user) or die($connect_db->error);
    $row_user = mysqli_fetch_assoc($rs_user);

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
    $contact = "ผู้ติดต่อ : ".$row['contact_name'] . "</br>" .
        "ตำแหน่ง : " . $row['contact_position'] . "</br>" .
        "เบอร์ : " . $row['contact_phone'] . "</br>";
    $team = "ทีม : " . $row_team['branch_name'] . "</br>" . "ช่างผู้ดูแล : " . $row_user['fullname'];
    if ($row['start_service_time'] != null) {
        $start_time = "เริ่ม: " . date("d-m-Y H:i", strtotime($row['start_service_time'])) . "</br>";
    } else {
        if ($row['appointment_time_start'] != null) {
            $app_start = date("H:i", strtotime($row['appointment_time_start']));
        }
        if ($row['appointment_time_end'] != null) {
            $app_end = " - " . date("H:i", strtotime($row['appointment_time_end']));
        } else {
            $app_end = "ไม่ระบุ";
        }
        $start_time = "<font color='blue'>" . date("d-m-Y", strtotime($row['appointment_date'])) . " " . $app_start .  $app_end . "</font>";
    }
    if ($row['finish_service_time'] != null) {
        $finish_time = "สิ้นสุด: " . date("d-m-Y H:i", strtotime($row['finish_service_time']));
    }


    if ($row['cancel_datetime'] != null) {
        $status = "ยกเลิกงาน";
    } else if ($row['close_approve_id'] != '') {
        $status = "ปิดงาน";
    } else if ($row['finish_service_time'] != null) {
        $status = "รอปิดงาน";
    } else if ($row['start_service_time'] != null) {
        $h = date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time']));
        $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;
        $status =  "กำลังดำเนินการ" . "<br>" . $h . "." . number_format(abs($m));
    } else if ($row['start_service_time'] == null) {
        $status = "เปิดงาน";
    }


    $temp = array(

        "job_id" => $row['job_id'],
        "job_no" => $row['job_no'],
        "sub_type_name" => $row['sub_type_name'],
        "appointment_date" => $row['appointment_date'],
        "time" => $start_time . $finish_time,
        "job_create" => $row['create_datetime'],
        "team" => $team,
        "sym_name" => $row_fixed['sym_name'],
        "rea_name" => $row_fixed['rea_name'],
        "type" => 1,
        "job_type" => $job_type,
        "status" => $status,
        "contact" => "ผู้ติดต่อ : ".$row['contact_name']."<br/> ตำแหน่ง : ".$row['contact_position']."<br/> เบอร์  : ".$row['contact_phone']
    );

    array_push($job_list, $temp);
}


$sql_chk = "SELECT * FROM tbl_group_pm a
LEFT JOIN tbl_user g ON a.responsible_user_id = g.user_id
WHERE a.group_pm_id IN (select group_pm_id from tbl_group_pm_detail c 
LEFT JOIN tbl_job a ON a.job_id = c.job_id
LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id 
WHERE  a.product_id = '$product_id' )   $search_condition1 $time $conn_status";
$rs_chk = mysqli_query($connect_db, $sql_chk) or die($connect_db->error);
while ($row_chk = mysqli_fetch_assoc($rs_chk)) {

    $branch_id = $row_chk['branch_id'];
    $responsible_user_id = $row_chk['responsible_user_id'];

    $sql_detail = "SELECT b.* FROM tbl_group_pm_detail a 
    LEFT JOIN tbl_job b ON a.job_id = b.job_id
    WHERE a.group_pm_id = '{$row_chk['group_pm_id']}' ORDER BY job_no LIMIT 1 ";
    $rs_detail = mysqli_query($connect_db, $sql_detail);
    while ($row_detail = mysqli_fetch_assoc($rs_detail)) {
        $job_no = $row_detail['job_no'];
        $contact = "ผู้ติดต่อ : ".$row_detail['contact_name'] . "</br>" .
        "ตำแหน่ง : " . $row_detail['contact_position'] . "</br>" .
        "เบอร์ : " . $row_detail['contact_phone'] . "</br>";

        if ($row_detail['start_service_time'] != null) {
            $start_time = "เริ่ม: " . date("d-m-Y H:i", strtotime($row_detail['start_service_time'])) . "</br>";
        } else {
            if ($row_detail['appointment_time_start'] != null) {
                $app_start = date("H:i", strtotime($row_detail['appointment_time_start']));
            }
            if ($row_detail['appointment_time_end'] != null) {
                $app_end = " - " . date("H:i", strtotime($row_detail['appointment_time_end']));
            } else {
                $app_end = "ไม่ระบุ";
            }
            $start_time = "<font color='blue'>" . date("d-m-Y", strtotime($row_detail['appointment_date'])) . " " . $app_start .  $app_end . "</font>" . "</br>";
        }
        if ($row_detail['finish_service_time'] != null) {
            $finish_time = "สิ้นสุด: " . date("d-m-Y H:i", strtotime($row_detail['finish_service_time']));
        }


    }


    $sql_team = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id'";
    $rs_team = mysqli_query($connect_db, $sql_team) or die($connect_db->error);
    $row_team = mysqli_fetch_assoc($rs_team);

    $sql_user = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id'";
    $rs_user = mysqli_query($connect_db, $sql_user) or die($connect_db->error);
    $row_user = mysqli_fetch_assoc($rs_user);


    $team = "ทีม : " . $row_team['branch_name'] . "</br>" . "ช่างผู้ดูแล : " . $row_user['fullname'];


    if ($row_chk['cancel_datetime'] != null) {
        $status = "ยกเลิกงาน";
    } else if ($row_chk['close_approve_id'] != '') {
        $status = "ปิดงาน";
    } else if ($row_chk['finish_service_time'] != null) {
        $status = "รอปิดงาน";
    } else if ($row_chk['start_service_time'] != null) {
        $h = date('H', strtotime('NOW')) - date('H', strtotime($row_chk['start_service_time']));
        $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row_chk['start_service_time']))) / 60) * 10;
        $status =  "กำลังดำเนินการ" . "<br>" . $h . "." . number_format(abs($m));
    } else if ($row_chk['start_service_time'] == null) {
        $status = "เปิดงาน";
    }


    $temp = array(

        "job_id" => $row_chk['group_pm_id'],
        "job_no" => $job_no,
        "time" => $start_time . $finish_time,
        "sub_type_name" => "กลุ่มงาน",
        "appointment_date" => $row_chk['group_date'],
        "job_create" => $row_chk['create_group_datetime'],
        "team" => $team,
        "sym_name" => $row_fixed['sym_name'],
        "rea_name" => $row_fixed['rea_name'],
        "type" => 2,
        "job_type" => "PM Group",
        "status" => $status,
        "contact" => $contact
    );

    array_push($job_list, $temp);
}
array_multisort(array_column($work_list, 'appointment_date'), SORT_DESC, $work_list);
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" style="width:10%;">ชนิดงาน</th>
            <th class="text-center">ประเภทงาน</th>
            <th class="text-center" style="width:12%;">เลขที่งาน</th>
            <th class="text-center" style="width:15%;">วันที่นัดหมาย</th>
            <!-- <th class="text-left" style="width:20%;">ลูกค้า</th> -->
            <th class="text-left">ผู้ติดต่อ</th>
            <th class="text-left">ผู้รับผิดชอบ</th>
            <th class="text-left">สถานะ</th>


        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        foreach ($job_list as $row) {



        ?>
            <tr>

                <td class="text-center"><?php echo $row['job_type']; ?></td>
                <td class="text-center"><?php echo $row['sub_type_name'] ?></td>
                <td class="text-center"><?php echo "<a href='view_cm.php?id=" . $row['job_id'] . "&&type=" . $row['type'] . "'  target='_blank'>" . $row['job_no'] . "</a>" ?><?php echo "</br>" . date("d-m-Y", strtotime($row['job_create'])) ?></td>
                <td class="text-center"><?php echo $row['appointment_date'] ?><br><?php echo $row['time'] ?></td>
                
                <td class="text-left"><?php echo $row['contact']; ?></td>
                <td class="text-left"><?php echo $row['team']; ?></td>
                <td class="text-left"><?php echo $row['status'] ?></td>
                

            </tr>
        <?php } ?>
    </tbody>
</table>
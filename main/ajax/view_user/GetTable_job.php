<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$search_status = $_POST['search_status'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$branch = $_POST['branch'];
$job_type = $_POST['job_type'];
$insurance_status = $_POST['insurance_status'];
$user_id = $_POST['user_id'];

if ($user_level == 1) {

    $condition3 = " AND a.responsible_user_id = '$user_id'";
} else if ($user_level == 2) {

    $sql_cf = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
    $result_cf  = mysqli_query($connect_db, $sql_cf);
    $row_cf = mysqli_fetch_array($result_cf);

    $cf_care = $row_cf['branch_id'];

    $con_chief = "OR e.branch_id = '$cf_care'";
}

$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));


if ($insurance_status == 0) {

    $time = "BETWEEN '$start_date 00:00:00' AND  '$end_date 23:59:59'";
} else {

    $time = "";
}


$search_condition = "";
if ($search_status == "1") {
    $search_condition .= "a.appointment_date";
} else if ($search_status == "2") {
    $search_condition .= "a.create_datetime ";
} else {
    $search_condition .= "a.start_service_time ";
}

$condition = "";
if ($branch != "x" && $branch != "") {
    $condition .= "AND e.branch_id = '$branch'";
}

$condition2 = "";
if ($job_type != "x") {
    $condition2 .= "AND a.job_type = '$job_type'";
}

$sql_ref = "SELECT a.*,b.branch_name AS cus_branch,c.customer_name as cus_name,d.fullname,d.mobile_phone,e.branch_name,f.sub_type_name,a.create_datetime AS job_create FROM tbl_job a
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id
LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id
LEFT JOIN tbl_sub_job_type f ON a.sub_job_type_id = f.sub_job_type_id
LEFT JOIN tbl_job_staff g ON a.job_id = g.job_id
WHERE  a.responsible_user_id = '$user_id' OR a.get_oh_user = '$user_id' OR a.send_oh_user = '$user_id' OR a.qc_oh_user = '$user_id' OR a.create_user_id = '$user_id' OR g.staff_id = '$user_id'  OR a.job_id IN(SELECT ref_job_id FROM tbl_job_ref a RIGHT JOIN tbl_job b ON a.ref_job_id = b.job_id WHERE b.job_id IN (SELECT job_id FROM tbl_job_staff WHERE staff_id = '$user_id'))";
$result_ref  = mysqli_query($connect_db, $sql_ref);


// echo $sql_ref;
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" style="width:10%;">ชนิดงาน</th>
            <th class="text-center">ชื่องาน</th>
            <th class="text-center" style="width:12%;">เลขที่งาน</th>
            <th class="text-center" style="width:15%;">วันที่นัดหมาย</th>
            <th class="text-left" style="width:20%;">ลูกค้า</th>
            <th class="text-left">ผู้ติดต่อ</th>
            <th class="text-left">ผู้รับผิดชอบ</th>
            <th class="text-left">สถานะ</th>


        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        while ($row = mysqli_fetch_array($result_ref)) {

            $sub_job_type_id = $row['sub_job_type_id'];

            $sql_sub_job = "SELECT * FROM tbl_sub_job_type WHERE sub_job_type_id = '$sub_job_type_id'";
            $result_sub_job  = mysqli_query($connect_db, $sql_sub_job);
            $row_sub_job = mysqli_fetch_array($result_sub_job);

            $i++;

            if ($row['customer_branch_id'] == "" && $row['job_customer_type'] == 2) {

                $new_customer = "ลูกค้าใหม่" . "<font color='red'>***</font>";
            } else {
                $new_customer = $row['cus_name'] . "<br>" . $row['cus_branch'];
            }

            if ($row['job_type'] == 1) {
                $job_type = "CM";
            } elseif ($row['job_type'] == 2) {
                $job_type = "PM";
            } else if ($row['job_type'] == 3) {
                $job_type = "INSTALLATION";
            } else if ($row['job_type'] == 5) {
                $job_type = "งานอื่นๆ" . "</br>" . $row['sub_type_name'];
            } else if ($row['job_type'] == 4) {
                $job_type = 'OVERHAUL';
            } else if ($row['job_type'] == 6) {
                $job_type = 'เสนอราคา';
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

        ?>
            <tr>

                <td class="text-center"><?php echo $job_type; ?></td>
                <td class="text-center"><?php echo $row_sub_job['sub_type_name'] ?></td>
                <td class="text-center"><a href="view_cm.php?id=<?php echo $row['job_id']; ?>"><?php echo $row['job_no']; ?></a><?php echo "</br>" . date("d-m-Y", strtotime($row['job_create'])) ?></td>
                <td class="text-center"><?php if ($row['appointment_date'] != null) {
                                            echo date('d-M-Y', strtotime($row['appointment_date']));
                                        ?> <br> <?php echo date('H:i', strtotime($row['appointment_time']));
                                            } ?></td>
                <td class="text-left"><?php echo $new_customer ?></td>
                <td class="text-left"><?php echo $row['contact_name']; ?><br><?php echo $row['contact_phone']; ?></td>
                <td class="text-left"><?php echo $row['fullname']; ?><br><?php echo $row['mobile_phone']; ?><br><?php echo $row['branch_name']; ?></td>
                <td class="text-left"><?php echo $status ?></td>
                <!-- <td>
                    <a href="from_edit_job.php?id=<?php echo $row['job_id']; ?>" class="btn btn-xs btn-warning btn-block">แก้ไข</a>
                </td> -->

            </tr>
        <?php }

        ?>
    </tbody>
</table>
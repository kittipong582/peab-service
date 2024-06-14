<?php

session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$year = mysqli_real_escape_string($connection, $_POST['year']);
$month = mysqli_real_escape_string($connection, $_POST['month']);
$type = mysqli_real_escape_string($connection, $_POST['type']);

$sql = "SELECT job.job_no 
,job.job_type 
,cm_b.branch_code
,cm_b.branch_name
,u.fullname
,job.create_datetime
,job.appointment_date
,job.open_datetime
,job.start_service_time
,job.finish_service_time
,job.close_datetime
,job.cancel_datetime
,job.close_user_id
FROM tbl_job job
JOIN tbl_customer_branch cm_b ON job.customer_branch_id = cm_b.customer_branch_id
JOIN tbl_user u ON job.responsible_user_id = u.user_id
WHERE YEAR(job.appointment_date) = '$year' 
AND MONTH(job.appointment_date) = '$month' 
AND job.start_service_time IS NOT NULL 
AND job.finish_service_time IS NULL 
AND job.cancel_datetime IS NULL 
AND job.close_datetime IS NULL
AND job.job_type = '$type'
;";
$res = mysqli_query($connection, $sql);

$style_job = "";
if ($row['cancel_datetime'] != null) {
    $status = "ยกเลิกงาน";
} else if ($row['close_user_id'] != null) {
    $status = "ปิดงาน";
    $style_job = "style='color: red;'";
} else if ($row['finish_service_time'] != null) {
    $status = "รอปิดงาน";
} else if ($row['start_service_time'] != null) {
    $h = date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time']));
    $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;
    $status =  "กำลังดำเนินการ" . "  " . $h . "." . number_format(abs($m));
} else if ($row['start_service_time'] == null) {
    $status = "เปิดงาน";
}


?>
<table class="table">
    <thead>
        <tr>
            <td>หมายเลขงาน</td>
            <td>รหัสสาขา</td>
            <td>ประเภทงาน</td>
            <td>ผู้รับผิดชอบ</td>
            <td>วันที่แจ้ง</td>
            <td>จำนวนวันที่ค้าง</td>
            <td>สถานะ</td>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) {


            $DateStart = date('d', strtotime($row['appointment_date'])); //วันเริ่มต้น
            $MonthStart = date('m', strtotime($row['appointment_date'])); //วันเริ่มต้น
            $YearStart = date('Y', strtotime($row['appointment_date'])); //วันเริ่มต้น

            $DateEnd = date('d'); //วันสิ้นสุด
            $MonthEnd = date('m'); //วันสิ้นสุด
            $YearEnd = date('Y'); //วันสิ้นสุด

            $End = mktime(0, 0, 0, $MonthEnd, $DateEnd, $YearEnd);
            $Start = mktime(0, 0, 0, $MonthStart, $DateStart, $YearStart);

            $DateNum = ceil(($End - $Start) / 86400); // 28
        ?>
            <tr>
                <td><?php echo $row['job_no']; ?></td>
                <td>
                    <?php echo $row['branch_code']; ?><br>
                    <?php echo $row['branch_name']; ?>
                </td>
                <td><?php echo $row['job_type']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo date("d/m/Y", strtotime($row['create_datetime'])); ?></td>
                <td><?php echo $DateNum; ?></td>
                <td><?php echo $status ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
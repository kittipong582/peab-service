<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$sql = "SELECT a.*,b.branch_name AS cus_branch,c.customer_name as cus_name,d.fullname,d.mobile_phone,e.branch_name FROM tbl_job a 
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id
LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id
LEFT JOIN tbl_job_close_approve f ON a.job_id = f.job_id
WHERE a.job_type = 3 AND f.approve_result = 1  and IN_PM_check is null
ORDER BY a.create_datetime DESC";
$result  = mysqli_query($connect_db, $sql);


?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" style="width:10%;">ชนิดงาน</th>
            <th class="text-center" style="width:12%;">เลขที่งาน</th>
            <th class="text-center" style="width:15%;">วันที่นัดหมาย</th>
            <th class="text-left" style="width:20%;">ลูกค้า</th>
            <th class="text-left">ผู้ติดต่อ</th>
            <th class="text-left">ผู้รับผิดชอบ</th>
            <!-- <th class="text-left">สถานะ</th> -->
            <th class="text-center"></th>

        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        while ($row = mysqli_fetch_array($result)) {

            $i++;

            if ($row['job_type'] == 1) {
                $job_type = "CM";
            } elseif ($row['job_type'] == 2) {
                $job_type = "PM";
            } else {
                $job_type = "INSTALLATION";
            }

            if ($row['close_approve_id'] != '') {
                $status = "ปิดงาน";
            } else if ($row['finish_service_time'] != null) {
                $status = "รอปิดงาน";
            } else if ($row['start_service_time'] != null) {
                $h = date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time']));
                $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;
                $status =  "เริ่มงาน" . "<br>" . $h . "." . number_format(abs($m));
            }

        ?>
            <tr>

                <td class="text-center"><?php echo $job_type; ?></td>
                <td class="text-center"><?php echo $row['job_no']; ?></td>
                <td class="text-center"><?php echo date('d-M-Y', strtotime($row['appointment_date'])); ?> <br> <?php echo date('H:i', strtotime($row['appointment_time'])); ?></td>
                <td class="text-left"><?php echo $row['cus_name']; ?><br><?php echo $row['cus_branch']; ?></td>
                <td class="text-left"><?php echo $row['contact_name']; ?><br><?php echo $row['contact_phone']; ?></td>
                <td class="text-left"><?php echo $row['fullname']; ?><br><?php echo $row['mobile_phone']; ?><br><?php echo $row['branch_name']; ?></td>
                <!-- <td class="text-left"><?php echo $status ?></td> -->
                <td>

                    <div class="form-groups">
                        <button type="button" onclick="ConfirmStatus('<?php echo $row['job_id'] ?>','1')" class="btn btn-xs btn-info btn-block">เริ่มงาน PM</button>
                        <button type="button" onclick="ConfirmStatus('<?php echo $row['job_id'] ?>','2')" class="btn btn-xs btn-danger btn-block">ไม่เริ่มงาน PM</button>
                    </div>
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>
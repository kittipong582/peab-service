<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$temp_start_date = explode("/", $_POST['start_date']);
$start_date = date("Y-m-d", strtotime($temp_start_date[0] . "-" . $temp_start_date[1] . "-" . $temp_start_date[2]));

$temp_end_date = explode("/", $_POST['end_date']);
$end_date = date("Y-m-d", strtotime($temp_end_date[0] . "-" . $temp_end_date[1] . "-" . $temp_end_date[2]));

$sql = "SELECT a.*,b.branch_name,b.branch_code,c.customer_name,c.phone,d.fullname,d.mobile_phone,e.start_datetime,e.close_datetime,e.group_id
FROM tbl_job_audit a 
LEFT JOIN tbl_customer_branch b ON a.branch_id = b.customer_branch_id 
LEFT JOIN tbl_customer c ON c.customer_id = a.customer_id 
LEFT JOIN tbl_user d ON d.user_id = a.create_user_id
LEFT JOIN tbl_job_audit_group e ON a.group_id = e.group_id
WHERE e.start_datetime BETWEEN '$start_date' AND '$end_date'
GROUP BY a.group_id";

$res = mysqli_query($connect_db, $sql);

?>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:10%;" class="text-center">วันที่ทำรายการ</th>
                <th style="width:10%;" class="text-center">ผู้ทำรายการ</th>
                <th style="width:10%;" class="text-center">สาขา</th>
                <th style="width:5%;" class="text-center">สถานะ</th>
                <th style="width:5%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($res)) {
                if ($row['start_datetime'] == '') {
                    $status = '<span class="badge bg-primary">รอเปิดงาน</span>';
                } else if ($row['start_datetime'] != '' && $row['close_datetime'] == '') {
                    $status = '<span class="badge bg-warning">กำลังดำเนินการ</span>';
                } else if ($row['start_datetime'] != '' && $row['close_datetime'] != '') {
                    $status = '<span class="badge bg-danger">ปิดงาน</span>';
                }
            ?>
                <tr>
                    <td>
                        <?php echo date("d/m/Y", strtotime($row['appointment_date'])) ?>
                    </td>
                    <td>
                        <b> ชื่อผู้ตรวจ : </b>
                        <?php echo (strtolower($row['fullname']) != 'null' || $row['fullname'] != '') ? $row['fullname'] : '-' ?>
                        <br>
                        <b>เบอร์ : </b>
                        <?php echo (strtolower($row['mobile_phone']) != 'null' || $row['mobile_phone'] != '') ? $row['mobile_phone'] : '-' ?>
                    </td>
                    <td>
                        <b> ชื่อลูกค้า : </b>
                        <?php echo (strtolower($row['customer_name']) != 'null' || $row['customer_name'] != '') ? $row['customer_name'] : '-' ?>
                        <br>
                        <b>เบอร์ : </b>
                        <?php echo (strtolower($row['phone']) != 'null' || $row['phone'] != '') ? $row['phone'] : '-' ?>
                        <br>
                        <b>สาขา : </b>
                        <?php echo (strtolower($row['branch_code']) != 'null' || $row['branch_code'] != '') ? $row['branch_code'] : '-' ?>
                        <?php echo (strtolower($row['branch_name']) != 'null' || $row['branch_name'] != '') ? $row['branch_name'] : '-' ?>
                    </td>
                    <td class="text-center">
                        <?php echo $status; ?>
                    </td>
                    <td>
                        <a href="audit_work_detail.php?group_id=<?php echo $row['group_id']; ?>" type="button" class="btn btn-info w-100 text-white">รายละเอียด</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
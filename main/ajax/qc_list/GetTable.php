<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$status = mysqli_real_escape_string($connection, $_POST['status']);

$lot_id = mysqli_real_escape_string($connection, $_POST['lot_id']);

$temp_start_date = explode("/", $_POST['start_date']);
$start_date = date("Y-m-d", strtotime($temp_start_date[0] . "-" . $temp_start_date[1] . "-" . $temp_start_date[2]));

$temp_end_date = explode("/", $_POST['end_date']);
$end_date = date("Y-m-d", strtotime($temp_end_date[0] . "-" . $temp_end_date[1] . "-" . $temp_end_date[2]));

$condition = "";
if ($status != '0') {
    $condition .= "AND active_status = '1' ";
} else if ($status == '0') {
    $condition;
}

$sql = "SELECT * FROM tbl_job_qc WHERE start_qc  BETWEEN '$start_date' AND '$end_date'ORDER BY start_qc ASC";
$res = mysqli_query($connection, $sql);

?>
<table class="table table-striped table-bordered table-hover">
    <thead>

        <tr>
            <th class="text-center" style="width:10%;">วันที่</th>
            <th class="text-center">เครื่อง</th>
            <th class="text-center" style="width:20%;">ช่าง</th>
            <th style="width:5%;" class="text-center">สถานะ</th>
            <th style="width:5%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) {

            if ($row['start_qc'] == '') {
                $status = '<span class="badge bg-primary">รอเปิดงาน</span>';
            } else if ($row['start_qc'] != '' && $row['close_qc'] == '') {
                $status = '<span class="badge bg-warning">กำลังดำเนินการ</span>';
            } else if ($row['start_qc'] != '' && $row['close_qc'] != '') {
                $status = '<span class="badge bg-danger">ปิดงาน</span>';
            }

        ?>
            <tr>
                <td>
                    <?php echo date("d/m/Y", strtotime($row['start_qc'])) ?>
                </td>
                <?php $sql_product = "SELECT a.*,b.model_code,model_name FROM tbl_product_waiting a LEFT JOIN tbl_product_model b ON a.model_code = b.model_code
                WHERE a.lot_id = '{$row['lot_id']}' ";
                $rs_product = mysqli_query($connection, $sql_product) or die($connection->error);
                $row_product = mysqli_fetch_assoc($rs_product);
                ?>
                <td>      
                        <?php echo $row_product['model_code'] . '-' . $row_product['model_name'] ?>
                        <br>

                </td>
                <?php $sql_staff = "SELECT a.*,b.fullname,c.branch_name FROM tbl_staff_qc a LEFT JOIN tbl_user b ON a.staff_id = b.user_id LEFT JOIN tbl_branch c ON b.branch_id = c.branch_id WHERE job_qc_id  = '{$row['job_qc_id']}'";
                $res_staff = mysqli_query($connection, $sql_staff);
                ?>
                <td>

                    <?php while ($row_staff = mysqli_fetch_assoc($res_staff)) { ?>
                        <?php echo $row_staff['fullname'] ?>
                        <br>

                    <?php } ?>
                </td>
                <td class="text-center">
                    <?php echo $status; ?>
                </td>
                <td>
                    <a href="qc_work_detail.php?work=<?php echo $row['job_qc_id']; ?>" type="button" class="btn btn-info w-100 text-white">รายละเอียด</a>
                <!-- <input type="text" name="job_qc_id" id="job_qc_id" value="<?php echo $row['job_qc_id']; ?>"> -->
                </td>
                <!-- <td></td> -->
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(".select2").select2();
</script>
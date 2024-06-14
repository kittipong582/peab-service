<?php
include("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = mysqli_real_escape_string($connection, $_POST['user_id']);

$start_date = $_POST['start_date'];
$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = $_POST['end_date'];
$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));

$check_all = mysqli_real_escape_string($connection, $_POST['check_all']);
$search = mysqli_real_escape_string($connection, $_POST['search']);

$condition_search = '';
if ($check_all != "") {
    $condition_all = '';
} else {
    $condition_all = "AND a.appointment_date BETWEEN '$start_date' AND '$end_date'";
}

if ($search != "") {
    $condition_search = "AND b.branch_code ='$search'";
}


$sql = "SELECT a.* , b.branch_code ,c.close_datetime
FROM tbl_job_audit a 
JOIN tbl_customer_branch b ON b.customer_branch_id = a.branch_id
JOIN tbl_job_audit_group c ON a.group_id = c.group_id
WHERE a.create_user_id = '$user_id' $condition_all $condition_search GROUP BY a.group_id";
$res = mysqli_query($connection, $sql);

?>
<?php while ($row = mysqli_fetch_assoc($res)) { ?>
    <div class="ibox mb-3 d-block ">
        <div class="ibox-title">
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id ?>">
            <?php
            $sql_branch = "SELECT a.branch_name,a.branch_code,a.customer_branch_id,a.customer_id,a.address FROM tbl_customer_branch a WHERE a.customer_id = '{$row['customer_id']}'";
            $res_branch = mysqli_query($connection, $sql_branch);
            $row_branch = mysqli_fetch_assoc($res_branch); ?>

            <?php echo $row_branch['branch_code'] . "-" . $row_branch['branch_name'] ?>
            <br>
            <div class="ibox-tools">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#" class="dropdown-item">Config option 1</a>
                    </li>
                    <li><a href="#" class="dropdown-item">Config option 2</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ibox-content">
            <table class="w-90">
                <tr>
                    <td>สาขา</td>
                    <?php
                    $sql_product = "SELECT a.serial_no,a.current_branch_id FROM tbl_product a WHERE a.current_branch_id = '{$row['branch_id']}';";
                    $res_product = mysqli_query($connection, $sql_product);
                    $row_product = mysqli_fetch_assoc($res_product); ?>
                    <td>: <?php echo $row_branch['branch_name'] ?></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td>ที่อยู่</td>
                    <td>: <?php echo $row_branch['address'] ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>เวลานัดหมาย</td>
                    <td>: <?php echo date('d-M-Y', strtotime($row['appointment_date'])) ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div class="text-center mt-3">
                <div class="btn-group">
                    <?php if ($row['close_datetime'] != '') { ?>
                        <a href="audit_work_detail.php?group_id=<?php echo $row['group_id']; ?>" type="button" class="btn btn-info w-100 text-white">รายละเอียด</a>
                    <?php } else { ?>
                        <button type="button" class="btn btn-primary w-100" onclick="GetModalStart('<?php echo $row['group_id']; ?>')">เริ่ม
                            Audit</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
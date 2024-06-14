<?php
include ("../../../../config/main_function.php");
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



$sql = "SELECT a.*,c.model_code,c.model_name FROM  tbl_staff_qc s_qc
LEFT JOIN tbl_job_qc a ON s_qc.job_qc_id = a.job_qc_id
LEFT JOIN tbl_product_waiting b ON a.lot_id = b.lot_id 
LEFT JOIN tbl_product_model c ON b.model_code = c.model_code
WHERE s_qc.staff_id = '$user_id' $condition_all $condition_search";
$res = mysqli_query($connection, $sql);

?>
<?php while ($row = mysqli_fetch_assoc($res)) { ?>
    <div class="ibox mb-3 d-block ">
        <div class="ibox-title">
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id ?>">

            <?php echo $row['model_code'] . ' - ' . $row['model_name'] ?>
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

                <?php
                $sql_series = "SELECT * FROM tbl_product_qc  WHERE job_qc_id = '{$row['job_qc_id']}'";
                $res_series = mysqli_query($connection, $sql_series);
                $row_series = mysqli_fetch_assoc($res_series);
                ?>
                <tr>
                    <td>serial_no</td>
                    <td>:
                        <?php echo $row_series['series_no'] ?>
                    </td>
                    <td></td>
                    <td></td>

                    <?php
                    $sql_staff = "SELECT a.*,b.fullname FROM tbl_staff_qc a LEFT JOIN tbl_user b ON a.staff_id = b.user_id WHERE job_qc_id = '{$row['job_qc_id']}'";
                    $res_staff = mysqli_query($connection, $sql_staff);

                    ?>
                    <?php while ($row_staff = mysqli_fetch_assoc($res_staff)) { ?>

                    <tr>
                        <td>ราชื่อช่าง</td>
                        <td>:
                            <?php echo $row_staff['fullname'] ?>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>
                <!-- <tr>
                    <td>ที่อยู่</td>
                    <td>: <//?php echo $row_branch['address'] ?></td>
                    <td></td>
                    <td></td>
                </tr> -->
                <tr>
                    <td>เวลานัดหมาย</td>
                    <td>:
                        <?php echo date('d-M-Y', strtotime($row['appointment_date'])) ?>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div class="text-center mt-3">
                <div class="btn-group">
                    <div>
                        <?php if ($row['close_qc'] != '') { ?>
                            <!-- <a href="qc_work_detail.php?job=<?php echo $row['job_qc_id'] ?>" type="button"
                            class="btn btn-info w-100 text-white">รายละเอียด</a> -->
                            <a href="qc_work_detail.php?job=<?php echo $row['job_qc_id'] ?>&type=<?php echo $row['product_type_id']; ?>"
                                type="button" class="btn btn-info w-100 text-white">รายละเอียด</a>

                        <?php } else { ?>
                            <button type="button" class="btn btn-primary w-100"
                                onclick="Start_Qc('<?php echo $row['job_qc_id'] ?>','<?php echo $row['product_type_id']; ?>')">เริ่ม
                                QC</button>
                        <?php } ?>
                    </div>

                </div>
                <div class="btn-group">

                    <div class="">
                        <?php
                        $sql_p_all = "SELECT COUNT(CASE WHEN a.score = 1 THEN 1 END) AS pass ,COUNT(CASE WHEN a.score = 0 THEN 1 END) AS fail FROM tbl_qc_record a 
                    LEFT JOIN tbl_qc_checklist b ON a.checklist_id = b.checklist_id
                    LEFT JOIN tbl_qc_topic c ON b.topic_qc_id =c.topic_qc_id 
                    WHERE a.job_qc_id = '{$row['job_qc_id']}'";
                        $res_p_all = mysqli_query($connection, $sql_p_all);
                        $row_p_all = mysqli_fetch_assoc($res_p_all);
                        ?>
                        <?php
                        if ($row_p_all['fail'] != '0') {
                            echo '<a href="" type="button" class="btn btn-warning w-100 text-white">ส่งซ่อม</a>';
                        }

                        ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
<?php } ?>
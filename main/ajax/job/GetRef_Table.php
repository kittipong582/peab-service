<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$check = $_POST['check'];
$customer_id = $_POST['customer_id'];
$appointment_date = date("Y-m-d", strtotime($_POST['appointment_date']));
$customer_branch_id = $_POST['customer_branch_id'];
$job_no = $_POST['job_no'];


if ($check == 1) {

    $sql = "SELECT * FROM tbl_job a
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
    WHERE a.appointment_date = '$appointment_date' and a.customer_branch_id = '$customer_branch_id' ORDER BY a.create_datetime";
    $result  = mysqli_query($connect_db, $sql);
} else if ($check == 2) {

    $sql = "SELECT * FROM tbl_job a
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
    WHERE  a.appointment_date = '$appointment_date' and b.customer_id = '$customer_id' ORDER BY create_datetime";
    $result  = mysqli_query($connect_db, $sql);
} else {

    $sql = "SELECT * FROM  tbl_job WHERE job_no = '$job_no'";
    $result  = mysqli_query($connect_db, $sql);
}


// echo $sql;


?>


<table id="tbl_ref" class="table table-striped table-bordered table-hover">

    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th class="text-center">ประเภทงาน</th>
            <th class="text-center">เลขที่งาน</th>
            <th class="text-center">ผู้รับผิดชอบ</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($result)) {
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

            $branch_id = $row['care_branch_id'];
            $responsible_user_id = $row['responsible_user_id'];

            $sql_team = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id'";
            $rs_team = mysqli_query($connect_db, $sql_team) or die($connect_db->error);
            $row_team = mysqli_fetch_assoc($rs_team);

            $sql_user = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id'";
            $rs_user = mysqli_query($connect_db, $sql_user) or die($connect_db->error);
            $row_user = mysqli_fetch_assoc($rs_user);

            $team = "ทีม : " . $row_team['branch_name'] . "</br>" . "ช่างผู้ดูแล : " . $row_user['fullname'];

        ?>
            <tr>
                <td><?php echo ++$i; ?></td>

                <td class="text-center"><?php echo $job_type ?></td>
                <td class="text-center"><?php echo $row['job_no'] ?></td>
                <td class="text-center"><?php echo $team; ?></td>

                <td>
                    <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_job_ref('<?php echo $row['job_id'] ?>');">เลือก</button>
                </td>

            </tr>
        <?php } ?>
    </tbody>

</table>
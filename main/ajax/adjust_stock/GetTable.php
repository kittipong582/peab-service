<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$spare_part = $_POST['spare_part'];
$spare_type = $_POST['spare_type'];
$branch = $_POST['branch'];
$user = $_POST['user'];
$branch_id = $_SESSION['branch_id'];

$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];

$start_date = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['start_date'])));
$end_date = date("Y-m-d", strtotime(str_replace("/", "-", $_POST["end_date"])));


$condition = "";
if ($spare_part != "x") {
    $condition .= "AND c.spare_part_id = '$spare_part' ";
}

$condition2 = "";
if ($spare_type != "x") {
    $condition2 .= "AND d.spare_type_id = '$spare_type' ";
}

$condition3 = " ";

$condition4 = " AND (DATE(a.create_datetime) BETWEEN '$start_date' and '$end_date' )";


if ($admin_status == 9 || $user_level == 4) {

    if ($branch != "x") {
        $condition3 = "and f.branch_id = '$branch' ";
    }

    $sql = "SELECT a.*,f.branch_name,b.fullname FROM tbl_adjust_head a 
LEFT JOIN tbl_branch f ON a.receive_branch_id = f.branch_id
LEFT JOIN tbl_user b ON b.user_id = a.approve_user_id 
 WHERE 1 $condition3 $condition4
ORDER BY a.create_datetime DESC;";
} else {
    if ($user_level == 1 || $user_level == 2) {

        if ($branch != "x") {
            $condition3 = "AND f.branch_id = '$branch' ";
        }

        $sql = "SELECT a.*,f.branch_name,b.fullname FROM tbl_adjust_head a 
        LEFT JOIN tbl_branch f ON a.receive_branch_id = f.branch_id  
        LEFT JOIN tbl_user b ON b.user_id = a.approve_user_id 
        WHERE f.branch_id = '$branch_id' $condition4
        ORDER BY a.create_datetime DESC;";
    } else if ($user_level == 3) {

        $sql_branch = "SELECT zone_id FROM tbl_user WHERE user_id = '$user_id'";
        $result_branch  = mysqli_query($connect_db, $sql_branch);
        $row_branch = mysqli_fetch_array($result_branch);

        $zone_id = $row_branch['zone_id'];


        $sql = "SELECT a.*,f.branch_name,b.fullname FROM tbl_adjust_head a 
        LEFT JOIN tbl_branch f ON a.receive_branch_id = f.branch_id 
        LEFT JOIN tbl_user b ON b.user_id = a.approve_user_id 
        WHERE f.zone_id = '$zone_id'   $condition3 $condition4
        ORDER BY a.create_datetime DESC;";
    }
}

$result  = mysqli_query($connect_db, $sql);


?>

<table class="table table-striped table-bordered table-hover" id="table_adjust">
    <thead>
        <tr>
            <!-- <th style="width:5%;" class="text-center">#</th> -->
            <th class="text-center" style="width:11%;">อ้างอิง AX</th>
            <th class="text-left" style="width:25%;">รายการอะไหล่</th>
            <th class="text-center" style="width:15%;">ทีม</th>
            <th class="text-center" style="width:10%;">ประเภท</th>
            <th class="text-center" style="width:20%;">ผู้ทำรายการ</th>
            <th class="text-center" style="width:10%;">การอนุมัติ</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        while ($row = mysqli_fetch_array($result)) {
            $spare_array = [];
            $i++;

            $sql_r = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['create_user_id']}' ;";
            $rs_r  = mysqli_query($connect_db, $sql_r) or die($connection->error);
            $row_r = mysqli_fetch_assoc($rs_r);

            $spare_text = "";
            $sql_detail = "SELECT b.*,c.spare_part_name,c.spare_part_code,d.spare_type_name FROM tbl_adjust_detail b 
            LEFT JOIN tbl_spare_part c ON b.spare_part_id = c.spare_part_id 
            LEFT JOIN tbl_spare_type d ON c.spare_type_id = d.spare_type_id 
            WHERE adjust_id = '{$row['adjust_id']}' AND c.active_status = 1 ";
            $result_detail  = mysqli_query($connect_db, $sql_detail);
            while ($row_detail = mysqli_fetch_array($result_detail)) {

                $spare_text = "[" . $row_detail['spare_part_code'] . "] " . $row_detail['spare_part_name'] . " x " . $row_detail['quantity'];
                array_push($spare_array, $spare_text);
            }
            // echo $sql_detail;
        ?>
            <tr>
                <!-- <td class="text-center"><?php echo $i; ?></td> -->
                <td class="text-center">
                    <?php echo $row['ax_ref_no']; ?><br>
                    <?php echo ($row['ax_withdraw_date'] == '1970-01-01') ? ' - ' : date("d-m-Y", strtotime($row['ax_withdraw_date'])); ?>
                </td>

                <td class="text-left">

                    <?php foreach ($spare_array as $spare) {
                        echo $spare . "</br>";
                    }; ?>

                </td>


                <td class="text-center"><?php echo $row['branch_name']; ?></td>

                <td class="text-center">
                    <?php
                    switch ($row['adjust_type']) {
                        case "1":
                            echo '<span class="badge badge-danger">หักออก</span>';
                            break;
                        case "2":
                            echo '<span class="badge badge-primary">เพิ่ม</span>';
                            break;
                    }
                    ?>
                </td>
                <td class="text-center">
                    <?php echo $row_r['fullname']; ?>
                    <br>
                    <?php echo date("d-m-Y", strtotime($row['create_datetime'])); ?>
                </td>
                <td class="text-center">
                    <?php
                    echo $row['fullname'];
                    echo "<br/>";
                    switch ($row['approve_result']) {
                        case NULL:
                            echo '<span class="badge badge-success">รออนุมัติ</span>';
                            break;
                        case "1":
                            echo '<span class="badge badge-primary">ผ่านอนุมัติ</span>';
                            break;
                        case "2":
                            echo '<span class="badge badge-danger">ไม่ผ่านอนุมัติ</span>';
                            break;
                    }
                    ?>
                </td>

                <td class="text-center">

                    <button class="btn btn-success btn-block btn-xs" onclick="modal_detail('<?php echo $row['adjust_id']; ?>');">
                        ดูข้อมูล</button>

                    <?php if ($row['approve_result'] == NULL && $admin_status == 9 || $row['approve_result'] == NULL && $admin_status == 9) { ?>
                        <button class="btn btn-success btn-block btn-xs" onclick="modal_approve('<?php echo $row['adjust_id']; ?>','1');"><i class="fa fa-check"></i>
                            อนุมัติ</button>
                        <button class="btn btn-danger btn-block btn-xs" onclick="modal_approve('<?php echo $row['adjust_id']; ?>','0');"><i class="fa fa-times"></i>
                            ปฏิเสธ</button>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
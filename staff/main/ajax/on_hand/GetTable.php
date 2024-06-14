<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();


$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$branch_id = $_SESSION['branch_id'];
$admin_status = $_SESSION['admin_status'];
$spare_type = $_POST['spare_type'];
$user = $_POST['user'];

$condition = "";
if ($spare_type != "x") {
    $condition .= "AND b.spare_type_id = '$spare_type'";
}


if ($user_level == 1 || $user_level == 2) {

    $sql = "SELECT a.*,b.spare_type_name,c.remain_stock,e.branch_name FROM tbl_spare_part a 
    LEFT JOIN tbl_spare_type b ON a.spare_type_id = b.spare_type_id
    LEFT JOIN tbl_branch_stock c ON a.spare_part_id = c.spare_part_id
    LEFT JOIN tbl_branch e ON c.branch_id = e.branch_id
    WHERE a.active_status = 1 $condition  And e.branch_id = '$branch_id'
    ORDER BY a.spare_part_code ASC
    ;";
    $result  = mysqli_query($connect_db, $sql);
}

// echo $sql;
?>

<div class="table-responsive" >
    <table class="table table-striped table-bordered table-hover dataTables-example" style="width: 150%;">
        <thead>
            <tr>
                <!-- <th class="text-center" style="width:5%;">#</th> -->
                <th class="text-center" style="width:12%;">รหัส</th>
                <th class="text-left" style="width:45%;">อะไหล่</th>
                <th class="text-center" style="width:30%;">ประเภท</th>

                <th class="text-center" style="width:9%;">จำนวน</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;

            while ($row = mysqli_fetch_array($result)) {

                $i++;

                $sql_r = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['receive_user_id']}' ;";
                $rs_r  = mysqli_query($connect_db, $sql_r) or die($connection->error);
                $row_r = mysqli_fetch_assoc($rs_r);


            ?>
                <tr>
                    <!-- <td class="text-center"><?php echo $i; ?></td> -->
                    <td class="text-center"><?php echo $row['spare_part_code']; ?></td>
                    <td class="text-left"><?php echo $row['spare_part_name']; ?></td>
                    <td class="text-center"><?php echo $row['spare_type_name']; ?></td>

                    <td class="text-center"><?php echo $row['remain_stock']; ?></td>


                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
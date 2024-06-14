<?php

session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];
$branch_id = $_SESSION['branch_id'];

$spare_type = $_POST['spare_type'];
$spare_part = $_POST['spare_part'];
$branch = $_POST['branch'];
$user = $_POST['user'];

// echo $user_level;
$condition = "";
if ($spare_type != "x") {
    $condition .= "AND b.spare_type_id = '$spare_type'";
}

$condition2 = "";
if ($spare_part != "x") {
    $condition2 .= "AND a.spare_part_id = '$spare_part'";
}

$condition3 = "";
if ($branch != "x") {
    $condition3 .= "AND e.branch_id = '$branch'";
}

if ($admin_status == 9 || $user_level == 4) {
    $sql = "SELECT a.*,b.spare_type_name,c.default_quantity,c.branch_id,e.branch_name FROM tbl_spare_part a 
JOIN tbl_spare_type b ON a.spare_type_id = b.spare_type_id
JOIN tbl_branch_stock_setting c ON a.spare_part_id = c.spare_part_id
JOIN tbl_branch e ON c.branch_id = e.branch_id
WHERE a.active_status = 1 $condition $condition2 $condition3 
ORDER BY a.spare_part_code ASC
;";
    $result  = mysqli_query($connect_db, $sql);
} else {

    if ($user_level == 1 || $user_level == 2) {

        $sql = "SELECT a.*,b.spare_type_name,c.default_quantity,c.branch_id,e.branch_name FROM tbl_spare_part a 
        JOIN tbl_spare_type b ON a.spare_type_id = b.spare_type_id
        JOIN tbl_branch_stock_setting c ON a.spare_part_id = c.spare_part_id
        JOIN tbl_branch e ON c.branch_id = e.branch_id
        WHERE a.active_status = 1 and c.branch_id = '$branch_id' $condition $condition2  
        ORDER BY a.spare_part_code ASC
        ;";
        $result  = mysqli_query($connect_db, $sql);
    }  else if ($user_level == 3) {

        $sql_user = "SELECT zone_id FROM tbl_user WHERE user_id = '$user_id'";
        $result_user  = mysqli_query($connect_db, $sql_user);
        $row_user = mysqli_fetch_array($result_user);

        $zone_id = $row_user['zone_id'];

        $sql = "SELECT a.*,b.spare_type_name,c.default_quantity,c.branch_id,e.branch_name FROM tbl_spare_part a 
        JOIN tbl_spare_type b ON a.spare_type_id = b.spare_type_id
        JOIN tbl_branch_stock_setting c ON a.spare_part_id = c.spare_part_id
        
        JOIN tbl_branch e ON c.branch_id = e.branch_id
        JOIN tbl_zone f ON e.zone_id = f.zone_id
        WHERE a.active_status = 1 $condition $condition2  $condition3 And e.zone_id = '$zone_id'


        ORDER BY spare_part_code ASC
        ;";
        $result  = mysqli_query($connect_db, $sql);
    }
}
// echo $sql;

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" style="width:5%;">#</th>
            <th class="text-center" style="width:12%;">รหัสอะไหล่</th>
            <th class="text-left" style="width:30%;">ชื่ออะไหล่</th>
            <th class="text-center" style="width:12%;">ประเภท</th>
            <th class="text-center" style="width:13%;">ทีม</th>
            <th class="text-center" style="width:10%;">REQ</th>
            <th class="text-left" style="width:10%;"></th>
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
                <td class="text-center"><?php echo $i; ?></td>
                <td class="text-center"><?php echo $row['spare_part_code']; ?></td>
                <td class="text-left"><?php echo $row['spare_part_name']; ?></td>
                <td class="text-center"><?php echo $row['spare_type_name']; ?></td>
                <td class="text-center"><?php echo $row['branch_name']; ?></td>
                <td class="text-center"><?php echo $row['default_quantity']; ?></td>
                <td>
                    <button class="btn btn-xs btn-warning btn-block"
                        onclick="ModalEdit('<?php echo $row['branch_id'] ?>','<?php echo $row['spare_part_id'] ?>');">แก้ไข
                    </button>
                    <button class="btn btn-xs btn-danger btn-block" 
                        onclick="Delete('<?php echo $row['branch_id'] ?>','<?php echo $row['spare_part_id'] ?>');">ลบ
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
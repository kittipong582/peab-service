<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$spare_part = $_POST['spare_part'];
$spare_type = $_POST['spare_type'];
$branch = $_POST['branch'];
$user = $_POST['user'];

$condition = "";
if($spare_part != "x"){
    $condition .="AND c.spare_part_id = '$spare_part' ";
}

$condition2 = "";
if($spare_type != "x"){
    $condition2 .="AND d.spare_type_id = '$spare_type' ";
}

$condition3 = "";
if($branch != "x"){
    $condition3 .="AND f.branch_id = '$branch' ";
}

$condition4 = "";
if($user != "x"){
    $condition4 .="AND e.user_id = '$user' ";
}


$sql = "SELECT a.*,b.*,c.spare_part_name,c.spare_part_code,d.spare_type_name,e.fullname,f.branch_name FROM tbl_withdraw_detail a 
JOIN tbl_withdraw_head b ON a.withdraw_id = b.withdraw_id 
JOIN tbl_spare_part c ON a.spare_part_id = c.spare_part_id 
JOIN tbl_spare_type d ON c.spare_type_id = d.spare_type_id 
JOIN tbl_user e ON b.receive_user_id = e.user_id 
JOIN tbl_branch f ON e.branch_id = f.branch_id 

WHERE c.active_status = 1 $condition $condition2 $condition3 $condition4
ORDER BY c.spare_part_code DESC;";
$result  = mysqli_query($connect_db, $sql);
// echo $sql;

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <!-- <th style="width:5%;" class="text-center">#</th> -->
            <th class="text-center" style="width:15%;">รหัสอะไหล่</th>
            <th class="text-center" style="width:15%;">ชื่ออะไหล่</th>
            <th class="text-center" style="width:15%;">ประเภท</th>
            <th class="text-center" style="width:21%;">พนักงาน</th>
            <th class="text-center" style="width:15%;">สาขา</th>
            <th class="text-center">จำนวน</th>
            <!-- <th class="text-center">ผู้รับ</th> -->
            <!-- <th class="text-center" style="width:18%;">เอกสารประกอบการบันทึก</th> -->
            <!-- <th style="width:10%;"></th> -->
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
            <td class="text-center"><?php echo $row['spare_part_name']; ?></td>
            <td class="text-center"><?php echo $row['spare_type_name']; ?></td>
            <td class="text-center"><?php echo $row['fullname']; ?></td>
            <td class="text-center"><?php echo $row['branch_name']; ?></td>
            <td class="text-center"><?php echo $row['quantity']; ?></td>
           
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user = $_POST['user_id'];


$condition4 = "";
if ($user != "x") {
    $condition4 .= "AND a.user_id = '$user'";
}


$sql = "SELECT * FROM tbl_user_stock a 
JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id
JOIN tbl_spare_type c ON b.spare_type_id =c.spare_type_id
WHERE b.active_status = 1  $condition4
ORDER BY b.spare_part_code ASC
;";
$result  = mysqli_query($connect_db, $sql);
// echo $sql;

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" style="width:5%;">#</th>
            <th class="text-center" style="width:12%;">รหัสอะไหล่</th>
            <th class="text-left" style="width:30%;">ชื่ออะไหล่</th>
            <th class="text-center" style="width:12%;">ประเภท</th>
            <!-- <th class="text-center" style="width:13%;">พนักงาน</th>
            <th class="text-center" style="width:13%;">สาขา</th> -->
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
                <td class="text-center"><?php echo $i; ?></td>
                <td class="text-center"><?php echo $row['spare_part_code']; ?></td>
                <td class="text-left"><?php echo $row['spare_part_name']; ?></td>
                <td class="text-center"><?php echo $row['spare_type_name']; ?></td>
                <!-- <td class="text-center"><?php echo $row['fullname']; ?></td>
                <td class="text-center"><?php echo $row['branch_name']; ?></td> -->
                <td class="text-center"><?php echo $row['remain_stock']; ?></td>


            </tr>
        <?php } ?>
    </tbody>
</table>
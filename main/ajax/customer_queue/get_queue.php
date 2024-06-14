<?php
@include ("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];

$search_type_filter = $_POST['search_type_filter'];
$zone = $_POST['zone'];
$search_filter = $_POST['search_filter'];






$con = "";
if ($search_type_filter == "2" || $search_filter != "") {
    $con .= "WHERE (c.customer_name LIKE '%$search_filter%' OR c.phone LIKE '%$search_filter%')";

} elseif ($search_type_filter == "3") {
    $con .= "WHERE (b.branch_code LIKE '%$search_filter%' OR b.branch_name LIKE '%$search_filter%')";
} elseif ($search_type_filter == "x") {
    $con .= "";
}

$con2 = "";
if ($zone != "") {
    $con2 .= "AND a.area_id = '$zone'";
}

$sql = "SELECT a.*,b.branch_name,b.customer_branch_id,b.customer_id,c.customer_name,c.customer_id,c.customer_id,c.phone FROM tbl_customer_queue a LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id $con $con2 ORDER BY a.queue_no ASC;";
$res = mysqli_query($connect_db, $sql);
?>
<div class="table-responsive">
    <table id="tbl_queue" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:10%;">คิวงาน</th>
                <th class="">สาขา</th>
                <th class="">ภาค</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($res)) {
                // echo $sql_customer = "SELECT * FROM tbl_customer_branch a
                // LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id 
                // WHERE a.customer_branch_id  = '{$row['customer_branch_id']}'";
                // $res_customer = mysqli_query($connect_db, $sql_customer);
                // $row = mysqli_fetch_array($res_customer);
            
                ?>
                <tr>
                    <td>
                        <?php echo $row['queue_no'] ?>
                    </td>
                    <td class="">
                        <b>ชื่อลูกค้า : </b>
                        <?php echo ($row['customer_name']) != NULL || ($row['customer_name'] != '') ? $row['customer_name'] : '-' ?>
                        <br>
                        <b>เบอร์ : </b>
                        <?php echo ($row['phone']) != NULL || ($row['phone'] != '') ? $row['phone'] : '-' ?>
                        <br>
                        <b>สาขา : </b>
                        <?php echo ($row['branch_code']) != NULL || ($row['branch_code'] != '') ? $row['branch_code'] : '-' ?>
                        <?php echo ($row['branch_name']) != NULL || ($row['branch_name'] != '') ? $row['branch_name'] : '-' ?>
                        <br>
                    </td>
                    <?php

                    $sql_area = "SELECT * FROM tbl_zone_oh WHERE area_id = '{$row['area_id']}' AND active_status = 1";
                    $res_area = mysqli_query($connect_db, $sql_area) or die($connection->error);
                    $row_area = mysqli_fetch_assoc($res_area);
                    ?>
                    <td>
                        <?php echo $row_area['area_name'] ?>
                    </td>
                    <td>
                        <a href="form_add_job.php?code=<?php echo $row['branch_code'] ?>&id=<?php echo $row['customer_branch_id'] ?>&job_type=4"
                            class="btn btn-xs btn-primary btn-block">เปิดงาน
                        </a>
                        <button class="btn btn-xs btn-warning btn-block" type="button"
                            onclick="Modal_edit('<?php echo $row['queue_id'] ?>');">แก้ไข</button>
                        <button class="btn btn-xs btn-danger btn-block" type="button"
                            onclick="Delete_queue('<?php echo $row['customer_branch_id'] ?>');">ลบคิวงาน</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];
$job_type = $_POST['job_type'];


if ($search_type == 1) {
    $active = "AND c.active_status = 1";
    $sql = "SELECT * FROM tbl_product c
    LEFT JOIN tbl_product_type e ON e.type_id = c.product_type
    WHERE c.serial_no LIKE '%$search_value%' $active";
    $result  = mysqli_query($connect_db, $sql);
} else if ($search_type == 2) {
    if (is_numeric($search_value) == true) {
        $condition = "WHERE d.phone LIKE '%$search_value%'";
    } else {
        $condition = "WHERE d.customer_name LIKE '%$search_value%'";
    }
    $sql = "SELECT * FROM  tbl_customer_branch b 
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    $condition";
    $result  = mysqli_query($connect_db, $sql);
} else if ($search_type == 3) {
    $sql = "SELECT * FROM  tbl_customer_branch b 
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    WHERE b.branch_code LIKE '%$search_value%'  OR b.branch_name LIKE '%$search_value%'";
    $result  = mysqli_query($connect_db, $sql);
}

// echo $sql;

?>

<table id="tbl_PM" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:80%;" class="text-center">ชื่อร้าน</th>
            <th style="width:50%;" class="text-center">ลูกค้า</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($result)) {

        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td class="text-center"><?php echo "[ " . $row['branch_code'] . " ] - " . $row['branch_name'] ?></td>
                <td class="text-center"><?php echo $row['customer_name'] . " tel:" . $row['phone'] ?></td>
                <!-- <td class="text-center"><?php echo $row['phone'] ?></td> -->
                <td>
                    <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_PM_Product('<?php echo $row['product_id'] ?>','<?php echo $row['customer_branch_id'] ?>');">เลือก</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
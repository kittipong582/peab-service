<?php
@include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];

if ($search_type == 1) {
    $active = "AND c.active_status = 1";
    if (is_numeric($search_value) == true) {
        $condition = "WHERE d.phone LIKE '%$search_value%' AND product_id is NOT NULL $active ";
    } else {
        $condition = "WHERE d.customer_name LIKE '%$search_value%' AND product_id is NOT NULL $active ";
    }
    $sql = "SELECT * FROM  tbl_customer_branch b 
    LEFT JOIN tbl_product c ON c.current_branch_id = b.customer_branch_id
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    LEFT JOIN tbl_product_type e ON e.type_id = c.product_type
    $condition GROUP BY d.customer_id";
    $result  = mysqli_query($connect_db, $sql);
} else if ($search_type == 2) {
    $active = "AND c.active_status = 1";
    $sql = "SELECT b.customer_branch_id, b.branch_name, b.branch_code, d.customer_name FROM  tbl_customer_branch b 
    LEFT JOIN tbl_product c ON c.current_branch_id = b.customer_branch_id
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    LEFT JOIN tbl_product_type e ON e.type_id = c.product_type
    WHERE b.branch_code LIKE '%$search_value%' AND product_id is NOT NULL OR b.branch_name LIKE '%$search_value%' AND product_id is NOT NULL $active GROUP BY d.customer_id";
    $result  = mysqli_query($connect_db, $sql);
}

?>
<div class="table-responsive">
    <table id="tbl_PM" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th class="text-center">ชื่อร้าน</th>
                <th class="text-center">ลูกค้า</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td class="text-center"><b><?php echo ($row['branch_code'] != 'null') ? $row['branch_code'] : "-" ?></b> : <?php echo $row['branch_name'] ?></td>
                    <td class="text-center"><?php echo $row['customer_name'] ?></td>
                    <td>
                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="ChooseCustomer('<?php echo $row['customer_branch_id'] ?>');">เลือก</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];


$active = "AND c.active_status = 1";
if ($search_type == 1) {
    $sql = "SELECT * FROM tbl_product c
    LEFT JOIN tbl_product_type e ON e.type_id = c.product_type
    WHERE c.serial_no LIKE '%$search_value%' $active";
    $result  = mysqli_query($connect_db, $sql);
} else if ($search_type == 2) {

    if (is_numeric($search_value) == true) {
        $condition = "WHERE a.customer_code LIKE '%$search_value%'";
    } else {
        $condition = "WHERE a.customer_name LIKE '%$search_value%' ";
    }
    $sql = "SELECT b.*,a.customer_id AS cus_id,a.customer_name,a.phone FROM tbl_customer_branch b 
    LEFT JOIN tbl_customer a ON a.customer_id = b.customer_id 
    LEFT JOIN tbl_customer_contact d ON d.customer_branch_id = b.customer_branch_id
    $condition";
    $result  = mysqli_query($connect_db, $sql);
} else if ($search_type == 3) {

    $condition = "WHERE b.branch_name LIKE '%$search_value%' OR b.branch_code LIKE '%$search_value%' ";

    $sql = "SELECT b.*,a.customer_id AS cus_id,a.customer_name,a.phone FROM tbl_customer_branch b 
    LEFT JOIN tbl_customer a ON a.customer_id = b.customer_id 
    LEFT JOIN tbl_customer_contact d ON d.customer_branch_id = b.customer_branch_id
    $condition";
    $result  = mysqli_query($connect_db, $sql);
}
// echo $sql;
?>


<table id="tbl_CM" class="table table-striped table-bordered table-hover">
    <?php if ($search_type == 1) { ?>
        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th class="text-left">Serial No</th>
                <th class="text-center" style="width:15%;">ชื่อร้าน</th>
                <th class="text-center">ลูกค้า</th>
                <th class="text-center">ประเภท</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {

                $branch_id = $row['current_branch_id'];


                $sql_branch = "SELECT * FROM tbl_customer_branch a
                LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id WHERE a.customer_branch_id = '$branch_id'";
                $result_branch = mysqli_query($connect_db, $sql_branch);
                $row_branch = mysqli_fetch_array($result_branch);
                $product_type = $row['type_code'] . " - " . $row['type_name'];
            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td class="text-left"><?php echo $row['serial_no'] ?></td>
                    <td class="text-center"><?php echo $row_branch['branch_name'] ?></td>
                    <td class="text-center"><?php echo $row_branch['customer_name'] ?></td>
                    <td class="text-center"><?php echo $product_type ?></td>

                    <td>

                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_Product('<?php echo $row['product_id'] ?>','<?php echo $row_branch['customer_branch_id'] ?>');">เลือก</button>

                    </td>

                </tr>
            <?php } ?>
        </tbody>
    <?php } elseif ($search_type == 2 || $search_type == 3) { ?>

        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th class="text-center" style="width:15%;">ชื่อร้าน</th>
                <th class="text-center">ลูกค้า</th>
                <th class="text-center">เบอร์</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {

            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td class="text-center"><?php echo $row['branch_name'] ?></td>
                    <td class="text-center"><?php echo $row['customer_name'] ?></td>
                    <td class="text-center"><?php echo ($row['phone'] != null && $row['phone'] != "null" && $row['phone'] != "") ? $row['phone'] : "" ?></td>
                    <td>

                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_customer('<?php echo $row['customer_branch_id'] ?>');">เลือก</button>

                    </td>

                </tr>
            <?php } ?>
        </tbody>

    <?php } ?>
</table>
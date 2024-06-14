<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];



if (is_numeric($search_value) == true) {
    $condition = "WHERE phone LIKE '%$search_value%' GROUP BY b.customer_branch_id";
} else {
    $condition = "WHERE customer_name LIKE '%$search_value%'  GROUP BY b.customer_branch_id";
}
$sql = "SELECT * FROM tbl_customer_contact a 
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    $condition";
$result  = mysqli_query($connect_db, $sql);


?>


<table id="tbl_CM" class="table table-striped table-bordered table-hover">


    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th class="text-center">ชื่อร้าน</th>
            <th class="text-center">ลูกค้า</th>
            <th class="text-center">เบอร์</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            if ($search_type == 1) {
                $branch_id = $row['current_branch_id'];
            } else {
                $branch_id = $row['branch_care_id'];
            } ?>
            <tr>
                <td><?php echo ++$i; ?></td>

                <td class="text-center"><?php echo $row['branch_name'] ?></td>
                <td class="text-center"><?php echo $row['customer_name'] ?></td>
                <td class="text-center"><?php echo $row['phone'] ?></td>

                <td>
                    <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_customer('<?php echo $row['customer_id'] ?>');">เลือก</button>
                    <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->
                </td>

            </tr>
        <?php } ?>
    </tbody>



</table>
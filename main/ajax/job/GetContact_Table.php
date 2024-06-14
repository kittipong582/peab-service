<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];

$sql = "SELECT * FROM tbl_customer_contact WHERE customer_branch_id = '$customer_branch_id'";
$result  = mysqli_query($connect_db, $sql);

?>

<table id="tbl_contact" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th class="text-center">ชื่อผู้ติดด่อ</th>
            <th class="text-center">เบอร์โทร</th>
            <th class="text-center">ตำแหน่ง</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($result)) {
         
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td class="text-left"><?php echo $row['contact_name'] ?></td>
                <td class="text-center"><?php echo $row['contact_phone'] ?></td>
                <td class="text-center"><?php echo $row['contact_position'] ?></td>
                <td>
                    <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_Contact('<?php echo $row['contact_id'] ?>');">เลือก</button>
                    <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->
                </td>

            </tr>
        <?php } ?>
    </tbody>
</table>
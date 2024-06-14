<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$search_type = $_POST['search_type'];
$search_text_customer = $_POST['search_text_customer'];

if ($search_type == 1) {

    $con = "AND customer_code LIKE '%$search_text_customer%'";
} else {
    $con = "AND customer_name LIKE '%$search_text_customer%'";
}

$sql = "SELECT customer_code,customer_name,customer_id FROM tbl_customer WHERE active_status = 1 $con";
$result  = mysqli_query($connect_db, $sql);

?>

<table id="tbl_get_customer" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th class="text-center" style="width:20%;">รหัสลูกค้า</th>
            <th class="text-center" style="width:30%;">ชื่อลูกค้า</th>
            <th class="text-center" style="width:30%;">ที่อยู่</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($result)) {

        ?>
            <tr>
                <td><?php echo ++$i; ?></td>

                <td class="text-center"><?php echo $row['customer_code'] ?></td>
                <td class="text-center"><?php echo $row['customer_name'] ?></td>
                <td class="text-center"><?php echo $row['address'] ?></td>

                <td>
                    <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_customer_edit('<?php echo $row['customer_id'] ?>');">เลือก</button>
                </td>

            </tr>
        <?php } ?>
    </tbody>

</table>
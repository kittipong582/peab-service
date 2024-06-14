<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_group_id = $_POST['customer_group_id'];

$list = array();

$sql = "SELECT *,b.spare_part_id AS spare_id FROM tbl_customer_group_part_price a
LEFT JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id
 WHERE a.customer_group_id = '$customer_group_id' ORDER BY spare_part_code";
$result  = mysqli_query($connect_db, $sql);
// echo $sql;
while ($row = mysqli_fetch_array($result)) {

    $temp_array = array(
        "spare_part" => $row['spare_part_name'],
        "unit_price" => $row['unit_price'],
        "spare_part_id" => $row['spare_id'],
        "spare_code" => $row['spare_part_code']
    );

    array_push($list, $temp_array);
}

?>

<table class="table table-striped table-bordered table-hover" id="table_spare">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:20%;">รหัสอะไหล่</th>
            <th style="width:50%;">อะไหล่</th>
            <th style="width:20%;">ราคา</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $row) {
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $row['spare_code']; ?></td>
                <td><?php echo $row['spare_part']; ?></td>
                <td><?php echo number_format($row['unit_price'],2); ?></td>
                <td>

                    <button class="btn btn-xs btn-warning btn-block" onclick="edit_spare('<?php echo  $customer_group_id ?>','<?php echo $row['spare_part_id'] ?>');" type="button">
                        แก้ไข
                    </button>
                    <button class="btn btn-xs btn-danger btn-block" onclick="delete_spare('<?php echo  $customer_group_id ?>','<?php echo $row['spare_part_id'] ?>');" type="button">
                        ลบ
                    </button>

                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
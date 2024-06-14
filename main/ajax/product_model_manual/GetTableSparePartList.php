<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$model_id = $_POST['model_id'];

$sql = "SELECT a.*,
b.spare_part_name,b.spare_part_code
FROM tbl_product_model_sparepart a 
LEFT JOIN tbl_spare_part b ON b.spare_part_id = a.spare_part_id
WHERE model_id ='$model_id' ORDER BY list_order";
$res = mysqli_query($connect_db, $sql);

?>

<table class="table table-striped table-bordered table-hover" id="table_part">
    <thead>
        <tr>
            <th style="width:5%;">#</th>
            <th>รหัส</th>
            <th>ชื่อ</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        while ($row = mysqli_fetch_assoc($res)) {
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $row['spare_part_code']; ?></td>
                <td><?php echo $row['spare_part_name']; ?></td>
                <td>
                    <!-- <button class="btn btn-xs btn-block mb-2 <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['product_part_id']; ?>',2)">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button> -->
                    <button class="btn btn-xs btn-danger btn-block mb-2" onclick="DeletePart('<?php echo $row['product_part_id']; ?>')">ลบ</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
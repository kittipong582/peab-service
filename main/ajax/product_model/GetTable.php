<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$brand_id = $_POST['brand_id'];

$sql = "SELECT * FROM tbl_product_model WHERE brand_id='$brand_id' ";
$result  = mysqli_query($connect_db, $sql); {

    $temp_array = array(
        "model_id" => $row['model_id'],
        "model_name" => $row['model_name'],
        "active_status" => $row['active_status'],
    );

    array_push($list, $temp_array);
}
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th style="width:40%;">รหัสรุ่น</th>
                <th style="width:40%;">ชื่อรุ่น</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $row['model_code']; ?></td>
                    <td><?php echo $row['model_name']; ?></td>
                    <td>
                        <a href="Product_model_manual.php?id=<?php echo $row['model_id']; ?>" class="btn btn-xs btn-block btn-success">รายละเอียด</a>
                        <button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['brand_id']; ?>')">
                            <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                        </button>
                        <button class="btn btn-xs btn-warning btn-block" type="button" onclick="ModalEdit('<?php echo $row['model_id']; ?>')">
                            แก้ไขข้อมูล
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
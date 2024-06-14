<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$list = array();

$sql = "SELECT * FROM tbl_product_brand";
$result  = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    $brand_id = $row['brand_id'];
    $sql_2 = "SELECT COUNT(*) AS num FROM `tbl_product` WHERE brand_id='$brand_id'";
    $rs_2  = mysqli_query($connect_db, $sql_2);
    $row_2 = mysqli_fetch_array($rs_2);


    $temp_array = array(
        "brand_id" => $row['brand_id'],
        "brand_name" => $row['brand_name'],
        "active_status" => $row['active_status'],
        "num" => $row_2['num'],
    );

    array_push($list, $temp_array);
}





?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:30%;">#</th>
                <th style="width:30%;">ชื่อยี่ห้อ</th>
                <th style="width:30%;">จำนวนเครื่อง</th>
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
                    <td><?php echo $row['brand_name']; ?></td>
                    <td><?php echo $row['num']; ?></td>



                    <td>

                        <a href="product_model.php?id=<?php echo $row['brand_id']; ?>" button class="btn btn-xs btn-success btn-block" type="button"> รายการรุ่น
                        </a>
                        <button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['brand_id']; ?>')">
                            <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                        </button>
                        <button class="btn btn-xs btn-warning btn-block" type="button" onclick="ModalEdit('<?php echo $row['brand_id']; ?>')">
                            แก้ไขข้อมูล
                        </button>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
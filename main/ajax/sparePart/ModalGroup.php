<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$spare_part_id = mysqli_real_escape_string($connect_db, $_POST['spare_part_id']);

$sql = "SELECT * FROM tbl_customer_group a 
LEFT JOIN tbl_customer_group_part_price b ON a.customer_group_id = b.customer_group_id
WHERE b.spare_part_id IN (SELECT spare_part_id FROM tbl_customer_group_part_price WHERE spare_part_id = '$spare_part_id') ORDER BY customer_group_name";
$result  = mysqli_query($connect_db, $sql);

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">รายการราคาอะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <table class="table table-striped table-bordered table-hover " id="table_price">
            <thead>
                <tr>
                    <th style="width:10%;" class="text-center">#</th>
                    <th class="text-center">กลุ่ม</th>
                    <th class="text-center">ราคา</th>
                    <th class="text-center">วันหมดอายุ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td class="text-center"><?php echo ++$i; ?></td>
                        <td class="text-center"><?php echo $row['customer_group_name']; ?></td>
                        <td class="text-center"><?php echo number_format($row['unit_price'], 2); ?></td>
                        <td class="text-center"><?php echo date("d-m-Y", strtotime($row['expire_date'])); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
    </div>
</form>
<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_group_id = $_POST['customer_group_id'];
$sql_spare = "SELECT * FROM tbl_spare_part a 
LEFT JOIN tbl_spare_type b ON a.spare_type_id = b.spare_type_id 
WHERE spare_part_id NOT IN (SELECT spare_part_id FROM tbl_customer_group_part_price WHERE customer_group_id = '$customer_group_id') ORDER BY spare_part_code";
$result_spare  = mysqli_query($connect_db, $sql_spare);

// echo $sql_spare;
?>

<form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มอะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="customer_group_id" name="customer_group_id" value="<?php echo $customer_group_id ?>">
        <div class="row">
            <div class="col-7 mb-3">
                <label for="spare_part">
                    อะไหล่
                </label>
                <select class="form-control select2" id="spare_part" name="spare_part" style="width: 100%;">
                    <option value="">กรุณาเลือกอะไหล่</option>
                    <?php while ($row_spare = mysqli_fetch_array($result_spare)) { ?>
                        <option value="<?php echo $row_spare['spare_part_id'] ?>"><?php echo $row_spare['spare_part_code'] . " " . $row_spare['spare_part_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-5 mb-3">
                <label for="unit_price">
                    ราคา
                </label>
                <input type="text" class="form-control mb-3" id="unit_price" name="unit_price">
            </div>

           
        </div>


    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-success btn-sm" onclick="Add_spare();">บันทึกอะไหล่</button>
    </div>
</form>
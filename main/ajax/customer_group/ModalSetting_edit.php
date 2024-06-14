<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_group_id = $_POST['customer_group_id'];
$spare_part_id = $_POST['spare_part_id'];

$sql_spare = "SELECT * FROM tbl_customer_group_part_price a
LEFT JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id
LEFT JOIN tbl_spare_type c ON c.spare_type_id = b.spare_type_id 
WHERE a.customer_group_id = '$customer_group_id' AND a.spare_part_id = '$spare_part_id'";
$result_spare  = mysqli_query($connect_db, $sql_spare);
$row_spare = mysqli_fetch_array($result_spare);
// echo $sql_spare;
?>

<form action="" method="post" id="form-edit_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มอะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="customer_group_id" name="customer_group_id" value="<?php echo $customer_group_id ?>">
        <input type="hidden" id="spare_part_id" name="spare_part_id" value="<?php echo $spare_part_id ?>">
        <div class="row">
            <div class="col-7 mb-3">
                <label for="spare_part">
                    อะไหล่
                </label>

                <input type="text" readonly class="form-control" value="<?php echo $row_spare['spare_part_code'] . " " . $row_spare['spare_part_name'] ?>">

            </div>

            <div class="col-5 mb-3">
                <label for="unit_price">
                    ราคา
                </label>
                <input type="text" class="form-control mb-3" id="unit_price" value="<?php echo $row_spare['unit_price'] ?>" name="unit_price">
            </div>

            
        </div>


    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-success btn-sm" onclick="Update_spare();">บันทึกอะไหล่</button>
    </div>
</form>
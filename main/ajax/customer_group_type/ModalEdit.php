<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_group_type_id = $_POST['customer_group_type_id'];
$sql = "SELECT * FROM tbl_customer_group_type WHERE customer_group_type_id = '$customer_group_type_id'";
$result = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>

<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขกลุ่ม</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="customer_group_type_id" name="customer_group_type_id"
            value="<?php echo $customer_group_type_id ?>">
        <div class="row">
            <div class="col-12 mb-3">
                <label for="customer_group_type_name">
                    ชื่อกลุ่ม
                </label>
                <input type="text" class="form-control mb-3" id="customer_group_type_name"
                    value="<?php echo $row['customer_group_type_name'] ?>" name="customer_group_type_name">
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>
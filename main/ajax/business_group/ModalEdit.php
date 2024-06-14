<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$business_group_id = $_POST['business_group_id'];

$sql = "SELECT *FROM tbl_business_group 
WHERE group_id = '$business_group_id'";
$result  = mysqli_query($connect_db, $sql);
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
        <input type="hidden" id="group_id" name="group_id" value="<?php echo $row['group_id'] ?>">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="group_name">
                    ชื่อกลุ่มธุรกิจ
                </label>
                <input type="text" class="form-control " value="<?php echo $row['group_name'] ?>" id="group_name" name="group_name">
            </div>

            <div class="col-6 mb-3">
                <label for="spare_price">
                    ชื่อผู้เสียภาษี
                </label>
                <input type="text" class="form-control " value="<?php echo $row['invoice_name'] ?>" id="invoice_name" name="invoice_name">
            </div>

            <div class="col-4 mb-3">
                <label for="spare_price">
                    หมายเลขผู้เสียภาษี
                </label>
                <input type="text" class="form-control " value="<?php echo $row['tax_no'] ?>" id="tax_no" name="tax_no">
            </div>

            <div class="col-4 mb-3">
                <label for="spare_price">
                    เบอร์โทร
                </label>
                <input type="text" class="form-control " value="<?php echo $row['phone'] ?>" id="phone" name="phone">
            </div>

            <div class="col-4 mb-3">
                <label for="spare_price">
                    อีเมล
                </label>
                <input type="text" class="form-control " value="<?php echo $row['email'] ?>" id="email" name="email">
            </div>


            <div class="col-12 mb-3">
                <label for="spare_price">
                    ที่อยู่ผู้เสียภาษี
                </label>
                <textarea class="summernote" id="invoice_address"  name="invoice_address"><?php echo $row['invoice_address'] ?></textarea>
            </div>


        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>
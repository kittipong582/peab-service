<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");



?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มกลุ่ม</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="group_id" name="group_id" value="<?php echo getRandomID(10, 'tbl_business_group', 'group_id') ?>">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="group_name">
                    ชื่อกลุ่มธุรกิจ
                </label>
                <input type="text" class="form-control " id="group_name" name="group_name">
            </div>

            <div class="col-6 mb-3">
                <label for="spare_price">
                    ชื่อผู้เสียภาษี
                </label>
                <input type="text" class="form-control " id="invoice_name" name="invoice_name">
            </div>

            <div class="col-4 mb-3">
                <label for="spare_price">
                    หมายเลขผู้เสียภาษี
                </label>
                <input type="text" class="form-control " id="tax_no" name="tax_no">
            </div>

            <div class="col-4 mb-3">
                <label for="spare_price">
                    เบอร์โทร
                </label>
                <input type="text" class="form-control " id="phone" name="phone">
            </div>

            <div class="col-4 mb-3">
                <label for="spare_price">
                    อีเมล
                </label>
                <input type="text" class="form-control " id="email" name="email">
            </div>


            <div class="col-12 mb-3">
                <label for="spare_price">
                    ที่อยู่ผู้เสียภาษี
                </label>
                <textarea class="summernote" id="invoice_address" name="invoice_address"></textarea>
            </div>


        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>
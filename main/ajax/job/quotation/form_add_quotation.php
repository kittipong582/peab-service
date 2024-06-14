<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
?>
<style>

</style>


<div class="row mb-3" id="part1">

    <div class="mb-3 col-12">
        <strong>
            <h4>1.ข้อมูลลูกค้า</h4>
        </strong>
    </div>

    <div class="col-mb-3 col-3">
        <label>ชื่อลูกค้า</label>
        <font color="red">**</font>
        <input type="text" readonly id="customer_name" value="" name="customer_name" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ชื่อร้าน</label>
        <input type="text" readonly id="branch_name" value="" name="branch_name" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>งานที่เกี่ยวข้อง</label>
        <div class="input-group">
            <input type="text" id="ref_no" readonly name="ref_no" class="form-control">
            <span class="input-group-append"><button type="button" id="btn_ref" onclick="Modal_refjob();" name="btn_ref" class="btn btn-primary">อ้างอิงงาน</button></span>
        </div>
        <input type="hidden" id="job_ref" name="job_ref" class="form-control">

    </div>


    <div class="mb-3 col-3">
        <label>อัพโหลดใบเสนอราคา</label>
        <div class="custom-file" id="upload">
            <input id="logo" type="file" class="custom-file-input">
            <label for="logo" class="custom-file-label">กรุณาเลือกไฟล์...</label>
        </div>

    </div>

    <input type="hidden" id="customer_branch_id" name="customer_branch_id">
    <div class="mb-3 col-3">
        <label>ผู้ติดต่อ</label>

        <input type="text" id="contact_name" value="" name="contact_name" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>ตำแหน่ง</label>

        <input type="text" id="contact_position" value="" name="contact_position" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>เบอร์โทรติดต่อ</label>

        <div class="input-group">
            <input type="text" id="contact_phone" name="contact_phone" class="form-control">
            <span class="input-group-append"><button type="button" onclick="other_contact();" id="btn_ref" name="btn_ref" class="btn btn-primary">เลือกผู้ติดต่ออื่น</button></span>
        </div>

    </div>

    <input type="hidden" readonly id="branch_care_id" value="" name="branch_care_id" class="form-control">
    <div class="col-mb-3 col-3">
        <label>ทีมดูแล</label>
        <div class="input-group">
            <input type="text" id="branch_care" readonly name="branch_care" class="form-control branch_care">
            <span class="input-group-append"><button type="button" id="btn_branch" name="btn_branch" onclick="Other_care()" class="btn btn-primary">เลือกทีมอื่น</button></span>
        </div>
    </div>
    <hr>
    <?php include("../form_add_staff.php"); ?>
    <hr>

</div>


<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>2.เครื่อง</h4>
        </strong>
    </div>
    <input type="hidden" readonly id="product_id" value="" name="product_id" class="form-control">
    <div class="mb-3 col-4" id="product_point">
        <select class="form-control select2">
            <option value="">เลือกเครื่อง</option>

        </select>
    </div>
    <div class="col-12 mb-3" id="product_detail">


    </div>

</div>


<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>3.ค่าใช้จ่าย</h4>
        </strong>
    </div>
    <div class="col-md-12 mb-3">
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row_list();"><i class="fa fa-plus"></i>
            เพิ่มรายการ
        </button>
    </div>
    <div class="col-mb-3 col-12">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width:5%;"></th>
                    <th style="width:20%;">รายการ</th>
                    <th style="width:10%;">ราคา</th>
                    <th style="width:10%;">จำนวน</th>
                    <th style="width:10%;">ราคารวม (โดยประมาณ)</th>
                </tr>
            </thead>
            <tbody id="Addform" name="Addform">
                <div id="counter" hidden>0</div>

            </tbody>
        </table>
    </div>

    <div class="col-9 mb-3 text-right">
        <label> <b>ราคารวม : </b> </label>
    </div>
    <div class="mb-3 col-3">
        <input type="text" id="total" readonly style="width: 80%;" class="form-control text-right" name="total" value="">
    </div>

    <div class="col-9 mb-3 text-right">
        <label> <b>ส่วนลด : </b> </label>
    </div>
    <div class="mb-3 col-3">
        <input type="text" id="discounts" onchange="cal_discount();" class="form-control text-right" style="width: 80%;" style="float: right;" name="discounts" value="">
    </div>

    <div class="col-9 mb-3 text-right">
        <label> <b>หลังหักส่วนลด : </b> </label>
    </div>
    <div class="mb-3 col-3">
        <input type="text" id="after_discounts" readonly style="width: 80%;" class="form-control text-right" name="after_discounts" value="">
    </div>

    <div class="col-9 mb-3 text-right">
        <label> <b>ราคารวมสุทธิ : </b> </label>
    </div>
    <div class="mb-3 col-3">
        <input type="text" id="last_total" readonly style="width: 80%;" class="form-control text-right" style="float: right;" name="last_total" value="">
    </div>

</div>



<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>3.หมายเหตุ</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-12">

        <textarea type="text" id="note" value="" name="note" class="summernote"></textarea>
    </div>

</div>

<div class="text-center">
    <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_QT()">บันทึก</button>
</div>

<script>
    var check = 0;
    $('.custom-file-input').on('change', function() {

        let fileName = $(this).val().split('\\').pop();
        let type = fileName.split('.')[1].trim();
        if (type == 'jpg' || type == 'jpeg' || type == 'gif' || type == 'png' || type == 'JPG' || type == 'JPEG' || type == 'GIF' || type == 'PNG' || type == 'PDF' || type == 'pdf') {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
            check = 1;
        } else {
            swal({
                title: 'ไฟล์ไม่ถูกต้อง',
                // title: 'Invalid file',
                // text: 'Only xlsx files can be uploaded',
                text: 'Upload ใช้เฉพาะไฟล์รูปภาพและ PDF เท่านั้น ',
                type: 'error'
            });
            check = 0;
        }
    });



    function Select_product_QT(product_id) {
        $.ajax({
            type: "POST",
            url: "ajax/job/quotation/product_detail.php",
            data: {
                product_id: product_id,
            },
            dataType: "html",
            success: function(response) {
                $("#product_id").val(product_id);
                $("#product_detail").html(response);

            }
        });

    }
</script>
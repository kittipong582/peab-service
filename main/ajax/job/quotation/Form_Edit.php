<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$job_type = $_POST['job_type'];


$sql = "SELECT a.*,e.customer_name,d.branch_name,d.branch_care_id,i.team_number,i.branch_name,f.current_branch_id FROM tbl_job a 
LEFT JOIN tbl_branch b ON a.care_branch_id = b.branch_id 
LEFT JOIN tbl_user c ON a.responsible_user_id = c.user_id
LEFT JOIN tbl_customer_branch d ON d.customer_branch_id = a.customer_branch_id
LEFT JOIN tbl_customer e ON d.customer_id = e.customer_id
LEFT JOIN tbl_product f ON a.product_id = f.product_id
LEFT JOIN tbl_branch i ON d.branch_care_id = i.branch_id
WHERE a.job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


$sql_contact = "SELECT contact_name,contact_phone,contact_position FROM tbl_customer_contact WHERE customer_branch_id = '{$row['customer_branch_id']}' AND main_contact_status = 1";
$result_contact  = mysqli_query($connect_db, $sql_contact);
$row_contact = mysqli_fetch_array($result_contact);


$customer_name = ($row['job_customer_type'] == 2) ? "ลูกค้าใหม่" : $row['customer_name'];
$customer_branch_name = ($row['branch_name'] == null) ? "-" : $row['branch_name'];



////////////////////////////////query refjob///////////////////
$sql_ref = "SELECT *,b.job_id AS ref_id,b.job_no as refjob_no FROM tbl_job_ref a
    LEFT JOIN tbl_job b ON a.ref_job_id = b.job_id
     WHERE a.job_id = '$job_id'";
$result_ref  = mysqli_query($connect_db, $sql_ref);
$row_ref = mysqli_fetch_array($result_ref);


$sql_qt_head = "SELECT quotation_id,discounts FROM tbl_quotation_head WHERE job_id = '$job_id'";
$result_qt_head  = mysqli_query($connect_db, $sql_qt_head);
$row_qt_head = mysqli_fetch_array($result_qt_head);


$sql_qt_detail = "SELECT * FROM tbl_quotation_detail WHERE quotation_id = '{$row_qt_head['quotation_id']}'";
$result_qt_detail  = mysqli_query($connect_db, $sql_qt_detail);

$num_qt_detail = mysqli_num_rows($result_qt_detail);

//////////////////////////////product
$sql_product = "SELECT a.serial_no,d.type_code,d.type_name,b.brand_name,c.model_name,a.product_id FROM tbl_product a 
    LEFT JOIN tbl_product_brand b ON a.brand_id = b.brand_id
    LEFT JOIN tbl_product_model c ON a.model_id = c.model_id
    LEFT JOIN tbl_product_type d ON a.product_type = d.type_id
    WHERE  a.active_status = 1 and a.current_branch_id = '{$row['current_branch_id']}'";
$result_product  = mysqli_query($connect_db, $sql_product);
?>
<div class="row mb-3">
    <div class="mb-3 col-3">
        <strong>ประเภทลูกค้า</strong>
        <br>
        <select id="job_customer_type" onchange="customer_type(this.value)" name="job_customer_type" class="form-control select2">
            <option value="1">ลูกค้าเดิม</option>
            <option value="2">ลูกค้าทั่วไป</option>
        </select>
    </div>

    <div class="col-4 mb-3" id="type_box">
        <strong>ค้นหาจาก</strong>
        <br>
        <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 ">
            <option value="2">รหัส/ชื่อลูกค้า </option>
            <option value="1">หมายเลข Serial No</option>
            <option value="3">รหัสสาขา/ชื่อสาขา </option>
        </select>
    </div>

    <div class="col-4 mb-3" id="type_search">
        <strong></strong><br>
        <div class="input-group">
            <input type="text" id="searchqt_box" name="search_box" class="form-control">
            <span class="input-group-append"><button type="button" id="btn_search_qt" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
        </div>
    </div>

</div>

<div class="row mb-3" id="part1">
    <input type="hidden" id="quotation_id" name="quotation_id" value="<?php echo $row_qt_head['quotation_id']; ?>">
    <div class="mb-3 col-12">
        <strong>
            <h4>1.ข้อมูลลูกค้า</h4>
        </strong>
    </div>

    <div class="col-mb-3 col-3">
        <label>ชื่อลูกค้า</label>
        <font color="red">**</font>
        <input type="text" readonly id="customer_name" value="<?php echo $customer_name;  ?>" name="customer_name" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ชื่อร้าน</label>
        <input type="text" readonly id="branch_name" value="<?php echo $customer_branch_name ?>" name="branch_name" class="form-control">
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

        <input type="text" id="contact_name" value="<?php echo $row_contact['contact_name'] ?>" name="contact_name" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>ตำแหน่ง</label>

        <input type="text" id="contact_position" value="<?php echo $row_contact['contact_position'] ?>" name="contact_position" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>เบอร์โทรติดต่อ</label>

        <div class="input-group">
            <input type="text" id="contact_phone" value="<?php echo $row_contact['contact_phone'] ?>" name="contact_phone" class="form-control">
            <span class="input-group-append"><button type="button" onclick="other_contact();" id="btn_ref" name="btn_ref" class="btn btn-primary">เลือกผู้ติดต่ออื่น</button></span>
        </div>

    </div>

    <input type="hidden" readonly id="branch_care_id" value="<?php echo $row['branch_care_id'] ?>" name="branch_care_id" class="form-control">
    <div class="col-mb-3 col-3">
        <label>ทีมดูแล</label>
        <div class="input-group">
            <input type="text" id="branch_care" readonly name="branch_care" value="<?php echo $row['team_number'] . " - " . $row['branch_name'] ?>" class="form-control branch_care">
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
    <input type="hidden" readonly id="product_id" value="<?php echo $row['product_id'] ?>" name="product_id" class="form-control">
    <div class="mb-3 col-4" id="product_point">
        <select class="form-control select2 mb-3" style="width: 100%;" onchange="Select_product_QT(this.value)" name="product_select" id="product_select">
            <option value="">เลือกเครื่อง</option>
            <?php while ($row_product = mysqli_fetch_array($result_product)) { ?>
                <option value="<?php echo $row_product['product_id'] ?>" <?php if ($row['product_id'] == $row_product['product_id']) {
                                                                                echo "SELECTED";
                                                                            } ?>><?php echo $row_product['serial_no'] . " - " . $row_product['type_name'] . " " . $row_product['brand_name'] . " " . $row_product['model_name'] ?></option>
            <?php  } ?>
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
                <div id="counter" hidden><?php echo $num_qt_detail ?></div>
                <?php $i = 1;
                while ($row_qt_detail = mysqli_fetch_array($result_qt_detail)) { ?>

                    <tr name="tr_qs[]" id="tr_<?php echo $i; ?>" value="<?php echo $i; ?>">
                        <td> <button type="button" class="btn btn-danger btn-block" name="button" onclick="desty_list('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </td>
                        <td><select name="qs_id[]" id="qs_id_<?php echo $i; ?>" style="width: 100%;" class="form-control select2">
                                <option value="">กรุณาเลือกบริการ</option>
                                <?php
                                $sql_setting = "SELECT * FROM tbl_quotation_setting WHERE active_status = 1";
                                $result_setting  = mysqli_query($connect_db, $sql_setting);
                                while ($row_setting = mysqli_fetch_array($result_setting)) { ?>
                                    <option value="<?php echo $row_setting['qs_id'] ?>" <?php if ($row_qt_detail['qs_id'] == $row_setting['qs_id']) {
                                                                                            echo "SELECTED";
                                                                                        } ?>><?php echo $row_setting['qs_name'] ?></option>

                                <?php } ?>
                            </select></td>
                        <td><input type="text" class="form-control text-right" onchange="Cal_Qs('<?php echo $i; ?>');" name="unit[]" id="unit_<?php echo $i; ?>" value="<?php echo $row_qt_detail['price'] ?>"></td>
                        <td><input type="text" class="form-control text-right" onchange="Cal_Qs('<?php echo $i; ?>');" name="quantity[]" id="quantity_<?php echo $i; ?>" value="<?php echo $row_qt_detail['quantity'] ?>"></td>


                        <td><input type="text" readonly class="form-control unit_price text-right" name="unit_price[]" id="unit_price_<?php echo $i; ?>" value="<?php echo $row_qt_detail['price'] * $row_qt_detail['quantity'] ?>"></td>
                    </tr>

                <?php $i++;
                } ?>

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
        <input type="text" id="discounts" onchange="cal_discount();" class="form-control text-right" style="width: 80%;" style="float: right;" name="discounts" value="<?php echo $row_qt_head['discounts'] ?>">
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
            <h4>4.หมายเหตุ</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-12">

        <textarea type="text" id="note" value="" name="note" class="summernote"></textarea>
    </div>

</div>
<div class="text-center">
    <button class="btn btn-primary px-5" type="button" id="submit" onclick="Update_job()">บันทึก</button>
</div>

<script>
    $(document).ready(function() {
        var num = $("#counter").html();
        Cal_Qs(num);
        Select_product_QT()
    });


    function Select_product_QT() {
        var product_id = $('#product_select').val();
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
    $('#searchqt_box').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13' && $('#searchqt_box').val() != "") {
                Searchqt();
            }
        });

        $('#btn_search_qt').on('click', function() {
            if ($('#searchqt_box').val() != "") {
                Searchqt();
            }
        });
</script>
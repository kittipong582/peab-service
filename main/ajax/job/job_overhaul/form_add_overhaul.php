<?php

session_start();


include('header.php');
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_level = $_SESSION['user_level'];
$sql_overhaul = "SELECT * FROM tbl_overhaul WHERE active_status = 1";
$result_overhaul  = mysqli_query($connect_db, $sql_overhaul);




?>
<style>
    .box-input {
        min-height: 90px;
    }

    .modal-dialog {
        max-width: 1200px;
        margin: auto;
    }
</style>



<div class="row mb-3">

    <div class="mb-3 col-12">
        <strong>
            <h4>1.ข้อมูลลูกค้า</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-3">
        <label>ชื่อลูกค้า</label>
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
    </div>

    <div class="mb-3 col-3">
        <input type="hidden" id="job_ref" name="job_ref" class="form-control">
    </div>

    <input type="hidden" id="customer_branch_id" name="customer_branch_id">
    <div class="mb-3 col-3">
        <label>ผู้ติดต่อ</label>
        <font color="red">**</font>
        <input type="text" id="contact_name" value="" name="contact_name" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>ตำแหน่ง</label>

        <input type="text" id="contact_position" value="" name="contact_position" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>เบอร์โทรติดต่อ</label>
        <font color="red">**</font>
        <div class="input-group">
            <input type="text" id="contact_phone" name="contact_phone" class="form-control">
            <span class="input-group-append"><button type="button" onclick="other_contact();" id="btn_ref" name="btn_ref" class="btn btn-primary">เลือกผู้ติดต่ออื่น</button></span>
        </div>

    </div>

</div>

<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>2.ข้อมูลสินค้า</h4>
        </strong>
    </div>
    <input type="hidden" id="product_id" name="product_id">

    <div class="mb-3 col-4" id="productpoint">
    </div>
    <div class="mb-3 col-4">

    </div>
    <div class="mb-3 col-4">

    </div>
    <div class="mb-3 col-3">
        <label>Serial No</label>
        <input type="text" readonly id="serial_no" value="" name="serial_no" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ประเภทเครื่อง</label>
        <input type="text" readonly id="product_type" value="" name="product_type" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ยี่ห้อ</label>
        <input type="text" readonly id="brand" value="" name="brand" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>รุ่น</label>
        <input type="text" readonly id="model" value="" name="model" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่เริ่มประกัน</label>
        <input type="text" readonly id="warranty_start_date" value="" name="warranty_start_date" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่หมดประกัน</label>
        <input type="text" readonly id="warranty_expire_date" value="" name="warranty_expire_date" class="form-control">
    </div>
</div>


<!-- <div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>3.ข้อมูลเครื่องทดแทน</h4>
        </strong>
    </div>

    <div class="mb-3 col-4">
        <label>เครื่องทดแทน</label>
        <select id="overhaul_id" onchange="select_overhaul(this.value)" name="overhaul_id" class="form-control select2 mb-3">
            <option value="">กรุณาเลือกเครื่อง</option>
            <?php while ($row_overhaul = mysqli_fetch_array($result_overhaul)) {

                if ($row['product_type'] == 1) {
                    $product_type = 'เครื่องชง';
                } else if ($row['product_type'] == 2) {
                    $product_type = 'เครื่องบด';
                } else if ($row['product_type'] == 3) {
                    $product_type = 'เครื่องปั่น';
                }

                $brand_id = $row_overhaul['brand_id'];
                $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
                $result_brand  = mysqli_query($connect_db, $sql_brand);
                $row_brand = mysqli_fetch_array($result_brand);

                $model_id = $row_overhaul['model_id'];
                $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
                $result_model  = mysqli_query($connect_db, $sql_model);
                $row_model = mysqli_fetch_array($result_model);

            ?>


                <option value="<?php echo $row_overhaul['overhaul_id'] ?>"><?php echo $row_overhaul['serial_no'] . " - " . $row_brand['brand_name'] . " - " . $row_model['model_name'] ?></option>

            <?php } ?>
        </select>
    </div>
    <div class="mb-3 col-4">

    </div>
    <div class="mb-3 col-4">

    </div>
    <div class="mb-3 col-3">
        <label>Serial No</label>
        <input type="text" readonly id="o_serial_no" value="" name="o_serial_no" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ประเภทเครื่อง</label>
        <input type="text" readonly id="o_product_type" value="" name="o_product_type" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ยี่ห้อ</label>
        <input type="text" readonly id="o_brand" value="" name="o_brand" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>รุ่น</label>
        <input type="text" readonly id="o_model" value="" name="o_model" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่เริ่มประกัน</label>
        <input type="text" readonly id="o_warranty_start_date" value="" name="o_warranty_start_date" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่หมดประกัน</label>
        <input type="text" readonly id="o_warranty_expire_date" value="" name="o_warranty_expire_date" class="form-control">
    </div>
</div> -->



<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>3.การนัดหมาย</h4>
        </strong>
    </div>
    <input type="hidden" readonly id="branch_care_id" value="" name="branch_care_id" class="form-control">
    <div class="col-mb-3 col-3">
        <label>ทีมดูแล</label>
        <font color="red">**</font>
        <div class="input-group">
            <input type="text" id="branch_care" readonly name="branch_care" class="form-control branch_care">
            <?php if ($user_level != 1 && $user_level != 2) { ?>
                <span class="input-group-append"><button type="button" id="btn_branch" name="btn_branch" onclick="Other_care_OH()" class="btn btn-primary">เลือกทีมอื่น</button></span>
            <?php } ?>
        </div>
    </div>
    <div class="mb-3 col-3 user_list" id="user_list">
        <label>ช่างผู้รับผิดชอบ</label>
        <font color="red">**</font>
        <select class="form-control select2 mb-3" style="width: 100%;" name="" id="">
            <option value="">กรุณาเลือกช่าง</option>
        </select>
    </div>
    <div class="mb-3 col-3">
        <label>วันที่นัดหมาย</label>
        <font color="red">**</font>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="appointment_date" readonly name="appointment_date" class="form-control datepicker" value="" autocomplete="off">
        </div>
    </div>

    <!-- <div class="mb-3 col-3">
        <label>วันที่เปิดงาน</label>
        <font color="red">**</font>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="open_datetime" readonly name="open_datetime" class="form-control datepicker" value="" autocomplete="off">
        </div>
    </div> -->
    <div class="mb-3 col-2">
        <label>เวลาเริ่ม</label>

        <!-- <input type="text" id="time" value="" name="time" class="form-control"> -->
        <select name="hours" id="hours" style="width: 100%;" class="form-control select2 mb-3 ">
            <?php $i = 0;
            $h = 2;
            while ($i <= 23) {
                $time = sprintf("%0" . $h . "d", $i); ?>
                <option value="<?php echo $time ?>"><?php echo $time ?></option>

            <?php $i++;
            } ?>
        </select>

    </div>

    <div class="mb-3 col-1">
        <label>นาที</label>
        <!-- <input type="text" id="time" value="" name="time" class="form-control"> -->
        <select name="minutes" id="minutes" style="width: 100%;" class="form-control select2 mb-3 ">
            <?php $i = 0;
            $h = 2;
            while ($i <= 59) {
                $time = sprintf("%0" . $h . "d", $i); ?>
                <option value="<?php echo $time ?>"><?php echo $time ?></option>

            <?php $i++;
            } ?>
        </select>

    </div>

    <div class="mb-3 col-2">
        <label>เวลาสิ้นสุด</label>

        <!-- <input type="text" id="time" value="" name="time" class="form-control"> -->
        <select name="houre" id="houre" style="width: 100%;" class="form-control select2 mb-3 ">

            <?php $i = 0;
            $h = 2;
            while ($i <= 23) {
                $time = sprintf("%0" . $h . "d", $i); ?>
                <option value="<?php echo $time ?>"><?php echo $time ?></option>

            <?php $i++;
            } ?>
        </select>

    </div>

    <div class="mb-3 col-1">
        <label>นาที</label>
        <!-- <input type="text" id="time" value="" name="time" class="form-control"> -->
        <select name="minutee" id="minutee" style="width: 100%;" class="form-control select2 mb-3 ">
            <?php $i = 0;
            $h = 2;
            while ($i <= 59) {
                $time = sprintf("%0" . $h . "d", $i); ?>
                <option value="<?php echo $time ?>"><?php echo $time ?></option>

            <?php $i++;
            } ?>
        </select>

    </div>

    <div class="mb-3 col-9">
    </div>

    <div class="col-3 mb-2">
        <label>วันที่ส่งคืน</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="return_datetime" readonly name="return_datetime" class="form-control datepicker" value="" autocomplete="off">
        </div>

    </div>

    <div class="col-3 mb-2 user_list">

        <label>ทีมงาน</label>


        <select class="form-control select2 mb-2" style="width: 100%;" onchange="Get_oh_return(this.value)">
            <option value="">กรุณาเลือกทีม</option>
            <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = 1";
            $result_user  = mysqli_query($connect_db, $sql_user);
            while ($row_user = mysqli_fetch_array($result_user)) {
            ?>
                <option value="<?php echo $row_user['branch_id'] ?>"><?php echo $row_user['branch_name'] ?></option>
            <?php  } ?>
        </select>


    </div>

    <div class="col-3 mb-2 user_list" id="return_user_point">

        <label>ช่างผู้รับผิดชอบ</label>
        <select class="form-control select2 mb-2" style="width: 100%;" name="return_oh_user" id="return_oh_user">
            <option value="">กรุณาเลือกช่าง</option>
        </select>


    </div>

    <?php include("../form_add_staff.php"); ?>
</div>


<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>4.เครื่องทดแทน</h4>
        </strong>
    </div>

    <div class="mb-3 col-4">
        <label>เครื่องทีม</label>
        <select id="" name="" onchange="get_oh_product(this.value)" class="form-control select2 mb-3">
            <?php $sql_branch = "SELECT * FROM tbl_branch WHERE active_status = 1";
            $rs_branch = mysqli_query($connect_db, $sql_branch) or die($connect_db->error);
            ?>
            <option value="">กรุณาเลือกทีม</option>
            <?php while ($row_branch = mysqli_fetch_assoc($rs_branch)) { ?>
                <option value="<?php echo $row_branch['branch_id'] ?>"><?php echo $row_branch['team_number'] . " - " . $row_branch['branch_name'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3 col-4" id="overhaul_point">
        <label>เครื่องทดแทน</label>
        <select id="" name="" class="form-control select2 mb-3">
            <option value="">กรุณาเลือกเครื่อง</option>
        </select>
    </div>

    <div class="mb-3 col-4">

    </div>
    <div class="mb-3 col-3">
        <label>Serial No</label>
        <input type="text" readonly id="o_serial_no" value="" name="o_serial_no" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ประเภทเครื่อง</label>
        <input type="text" readonly id="o_product_type" value="" name="o_product_type" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ยี่ห้อ</label>
        <input type="text" readonly id="o_brand" value="" name="o_brand" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>รุ่น</label>
        <input type="text" readonly id="o_model" value="" name="o_model" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่เริ่มประกัน</label>
        <input type="text" readonly id="o_warranty_start_date" value="" name="o_warranty_start_date" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่หมดประกัน</label>
        <input type="text" readonly id="o_warranty_expire_date" value="" name="o_warranty_expire_date" class="form-control">
    </div>
</div>

<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>5.ค่าบริการ</h4>
        </strong>
    </div>
    <div class="col-md-12 mb-3">
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row();"><i class="fa fa-plus"></i>
            เพิ่มรายการ
        </button>
    </div>
    <div class="col-mb-3 col-12">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width:5%;"></th>
                    <th style="width:20%;">รายการ</th>
                    <th style="width:10%;">จำนวน</th>
                    <th style="width:10%;">หน่วย</th>
                    <th style="width:10%;">ราคาต่อหน่วย</th>
                    <th style="width:10%;">ราคารวม (โดยประมาณ)</th>
                </tr>
            </thead>
            <tbody id="Addform" name="Addform">
                <div id="counter" hidden>0</div>

            </tbody>
        </table>
    </div>

</div>

<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>6.หมายเหตุ</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-12">

        <textarea type="text" id="note" value="" name="note" class="summernote"></textarea>
    </div>

</div>

<div class="text-center">
    <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_OH()">บันทึก</button>
</div>



<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>

<script>
    $(document).ready(function() {

        $('.summernote').summernote({
            toolbar: false,
            height: 100,
        });

        $(".select2").select2({});


        $(".datepicker").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            format: 'dd-mm-yyyy',
            autoclose: true,
        });


    });
</script>
<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_level = $_SESSION['user_level'];

$sql_team = "SELECT * FROM tbl_branch WHERE active_status = 1 order by branch_name";
$rs_team = mysqli_query($connect_db, $sql_team);


?>



<div class="row mb-3">

    <div class="mb-3 col-12">
        <strong>
            <h4>1.ข้อมูลลูกค้า</h4>
        </strong>
    </div>
    <div class="mb-3 col-3">
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
            <span class="input-group-append"><button type="button" id="btn_ref" onclick="Modal_refjob();" name="btn_ref"
                    class="btn btn-primary">อ้างอิงงาน</button></span>
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
            <span class="input-group-append"><button type="button" onclick="other_contact();" id="btn_ref"
                    name="btn_ref" class="btn btn-primary">เลือกผู้ติดต่ออื่น</button></span>
        </div>

    </div>
    <div class="mb-3 col-12">

        <input class="icheckbox_square-green" type="checkbox" name="chkbox" id="chkbox" value="chkbox"><label
            class="ml-2"> ไม่ระบุลูกค้า</label>
        <input type="hidden" id="non_customer" name="non_customer" value="0" style="position: absolute; opacity: 0;">
    </div>


</div>

<strong>
    <h4>2.ข้อมูลสินค้า</h4>
</strong>

<div class="row mb-3 mt-3">
    <div id="product_counter" hidden>0</div>
    <div class="col-12" id="add_product_row" name="add_product_row">
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_product_row();"><i
                class="fa fa-plus"></i>
            เพิ่มรายการ
        </button>
    </div>
</div>

<div class="row mb-3">
    <input type="hidden" readonly id="branch_care_id" value="" name="branch_care_id" class="form-control">

    <div class="mb-3 col-12">
        <strong>
            <h4>3.แผนงาน</h4>
        </strong>
    </div>
    <div id="PMcounter" hidden>1</div>
    <div class="mb-3 col-12">
        <div class="row mb-3">
            <div class="mb-3 col-3">
                <label>วันที่นัดหมาย</label>

                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="appointment_date" name="appointment_date" class="form-control datepicker"
                        readonly value="" autocomplete="off">
                </div>
            </div>

            <!-- <div class="mb-3 col-3">
                <label>วันที่เปิดงาน</label>
                
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="open_datetime" readonly name="open_datetime" class="form-control datepicker" value="" autocomplete="off">
                </div>
            </div> -->

            <div class="mb-3 col-3">
                <label>ทีมดูแล</label>

                <div class="input-group">
                    <input type="text" id="branch_care" readonly name="branch_care" class="form-control branch_care">
                    <?php if ($user_level != 1 && $user_level != 2) { ?>
                        <span class="input-group-append"><button type="button" id="btn_branch" name="btn_branch"
                                onclick="Other_care()" class="btn btn-primary">เลือกทีมอื่น</button></span>
                    <?php } ?>
                </div>

            </div>

            <div class="mb-3 col-3" id="user_list">
                <label>ช่างผู้ดูแล</label>

                <select class="form-control select2">
                    <option value="">ไม่ระบุ</option>
                </select>
            </div>

            <!-- <div class="mb-3 col-3" id="alert_text_1">

            </div> -->

            <div class="mb-3 col-2">
                <label>เวลาเริ่มดำเนินการ</label>
                <select name="hours" id="hours" style="width: 100%;" class="form-control select2 mb-3 ">
                    <option value="">--</option>
                    <?php $i = 0;
                    $h = 2;
                    while ($i <= 23) {
                        $time = sprintf("%0" . $h . "d", $i); ?>
                        <option value="<?php echo $time ?>">
                            <?php echo $time ?>
                        </option>

                        <?php $i++;
                    } ?>
                </select>
            </div>
            <div class="mb-3 col-1">
                <label>นาที</label>
                <select name="minutes" id="minutes" style="width: 100%;" class="form-control select2 mb-3 ">
                    <option value="">--</option>
                    <?php $i = 0;
                    $h = 2;
                    while ($i <= 59) {
                        $time = sprintf("%0" . $h . "d", $i); ?>
                        <option value="<?php echo $time ?>">
                            <?php echo $time ?>
                        </option>

                        <?php $i++;
                    } ?>
                </select>
            </div>

            <div class="mb-3 col-2">
                <label>เวลาดำเนินการเสร็จ</label>
                <select name="houre" id="houre" style="width: 100%;" class="form-control select2 mb-3 ">
                    <option value="">--</option>
                    <?php $i = 0;
                    $h = 2;
                    while ($i <= 23) {
                        $time = sprintf("%0" . $h . "d", $i); ?>
                        <option value="<?php echo $time ?>">
                            <?php echo $time ?>
                        </option>

                        <?php $i++;
                    } ?>
                </select>
            </div>
            <div class="mb-3 col-1">
                <label>นาที</label>
                <select name="minutee" id="minutee" style="width: 100%;" class="form-control select2 mb-3 ">
                    <option value="">--</option>
                    <?php $i = 0;
                    $h = 2;
                    while ($i <= 59) {
                        $time = sprintf("%0" . $h . "d", $i); ?>
                        <option value="<?php echo $time ?>">
                            <?php echo $time ?>
                        </option>

                        <?php $i++;
                    } ?>
                </select>
            </div>
        </div>
        <div id="form_contact"></div>

        <?php include("../form_add_staff.php"); ?>
    </div>

</div>
<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>4.ค่าบริการ</h4>
        </strong>
    </div>

    <div class="mb-3 col-12">
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

    <div class="col-md-12 mb-3">
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row();"><i class="fa fa-plus"></i>
            เพิ่มรายการ
        </button>
    </div>



</div>

<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>5.หมายเหตุ</h4>
        </strong>
    </div>
    <div class="mb-3 col-12">

        <textarea type="text" id="note" value="" name="note" class="summernote"></textarea>
    </div>

</div>

<div class="text-center">
    <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_IN()">บันทึก</button>
</div>
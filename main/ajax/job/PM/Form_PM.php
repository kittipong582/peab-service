<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sql_team = "SELECT * FROM tbl_branch WHERE active_status = 1 order by branch_name";
$rs_team  = mysqli_query($connect_db, $sql_team);

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
    <input type="hidden" id="choose_product_id" name="choose_product_id">
    <div class="mb-3 col-12">
        <strong>
            <h4>2.ข้อมูลสินค้า</h4>
        </strong>
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
        <label>ประเภทการรับประกัน</label>
        <input type="text" readonly id="warranty_type" value="" name="warranty_type" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่ติดตั้ง</label>
        <input type="text" readonly id="install_date" value="" name="install_date" class="form-control">
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

<div class="row mb-3">

    <div class="mb-3 col-12">
        <strong>
            <h4>3.แผนงาน</h4>
        </strong>
    </div>

    <div class="mb-3 col-12">

        <input type="hidden" readonly id="current_branch_care" value="" name="current_branch_care" class="form-control branch_care_id">

        <div class="text-left mb-3">
            <div class="from-group">
                <button class="btn btn-sm btn-outline-primary" type="button" onclick="addPMForm()">
                    <i class="fa fa-plus"></i> เพิ่มแผนงาน
                </button>

                <button class="btn btn-sm btn-outline-info" type="button" id="helpbtn" onclick="addHelpForm()">
                    ตัวช่วยการเลือก
                </button>
            </div>
        </div>

        <div id="form_help" style="display: none;">
            <input type="hidden" id="check_help" name="check_help" value="0">
            <div class="row">
                <div class="mb-3 col-3">
                    <label>วันที่</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" id="start_help_date" name="start_help_date" class="form-control datepicker" readonly value="" autocomplete="off">
                    </div>
                </div>

                <div class="mb-3 col-3">
                    <label>จำนวนครั้ง</label>
                    <div class="input-group">
                        <input type="text" id="plan_times" name="plan_times" class="form-control ">
                    </div>
                </div>

                <div class="mb-3 col-3">
                    <label>ระยะห่าง (วัน)</label>

                    <input type="text" id="distance_date" name="distance_date" class="form-control">
                </div>
                <div class="mb-3 col-3">
                    <label></label><br>
                    <button class="btn btn-sm btn-primary" type="button" onclick="create_plan()">
                        สร้างแผนงาน
                    </button>
                </div>
            </div>
        </div>
        <div>
            <input type="hidden" id="check_plan" name="check_plan">
        </div>

        <div id="PMcounter" hidden>1</div>


        <div id="form_contact"></div>
        <hr>
        <?php include("../form_add_staff.php"); ?>
        <hr>

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
    <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit_PM()">บันทึก</button>
</div>
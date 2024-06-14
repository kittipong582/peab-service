<?php
include('header.php');

$list_province = array();

$sql_province = "SELECT * FROM tbl_province ORDER BY province_name_th ASC";
$rs_province = mysqli_query($connection, $sql_province);
while ($row_province = mysqli_fetch_array($rs_province)) {

    $temp_array_province = array(
        "province_id" => $row_province['province_id'],
        "province_name_th" => $row_province['province_name_th'],
    );

    array_push($list_province, $temp_array_province);
}

$list_branch = array();

$sql_branch = "SELECT * FROM tbl_branch WHERE active_status = '1' ORDER BY branch_name ASC";
$rs_branch = mysqli_query($connection, $sql_branch);
while ($row_branch = mysqli_fetch_array($rs_branch)) {

    $temp_array_branch = array(
        "branch_id" => $row_branch['branch_id'],
        "branch_name" => $row_branch['branch_name'],
    );

    array_push($list_branch, $temp_array_branch);
}

$sql_cus_group = "SELECT * FROM tbl_customer_group WHERE active_status = 1";
$rs_cus_group = mysqli_query($connection, $sql_cus_group);


$list_cusgroup = array();
$sql_cus_group_type = "SELECT * FROM tbl_customer_group_type WHERE active_status = 1";
$rs_cus_group_type = mysqli_query($connection, $sql_cus_group_type);
while ($row_cus_group_type = mysqli_fetch_array($rs_cus_group_type)) {

    $temp_array_group = array(
        "customer_group_type_id" => $row_cus_group_type['customer_group_type_id'],
        "customer_group_type_name" => $row_cus_group_type['customer_group_type_name'],
    );

    array_push($list_cusgroup, $temp_array_group);

}

?>



<style>
    .box-input {
        height: 90px;
    }

    .select2-container .select2-selection--single {
        height: 35.59px;
    }

    .select2-container--default .select2-selection--single {
        border-radius: 0px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 5px;
        right: 5px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>เพิ่มข้อมูลลูกค้า</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_list.php">ข้อมูลลูกค้า</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>เพิ่มข้อมูลลูกค้า</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <form action="" method="post" id="form_customer" enctype="multipart/form-data">
        <input type="text" hidden name="customer_id"
            value="<?php echo getRandomID(10, 'tbl_customer', 'customer_id'); ?>">
        <div class="ibox">
            <div class="ibox-title">
                <h5>ข้อมูลลูกค้า</h5>
            </div>
            <div class="ibox-content">
                <div class="row">

                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัสลูกค้า <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="customer_code" id="customer_code">
                    </div>
                    <div class="col-md-6 col-12 box-input">
                        <label for="">ชื่อลูกค้า <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="customer_name" id="customer_name">
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">ประเภทลูกค้า <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="customer_type" id="customer_type">
                            <option value="">โปรดระบุ</option>
                            <option value="1">นิติบุคคล</option>
                            <option value="2">บุคคลธรรมดา</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">ชื่อสำหรับออกใบกำกับภาษี <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="invoice_name" id="invoice_name">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">เลขประจำตัวผู้เสียภาษี</label>
                        <input type="text" class="form-control" name="tax_no" id="tax_no">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">อีเมล์</label>
                        <input type="text" class="form-control" name="email" id="email">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">เบอร์โทร</label>
                        <input type="text" class="form-control" name="phone" id="phone">
                    </div>
                    <div class="col-md-6 col-12 box-input">
                        <label for="">ที่อยู่สำหรับออกใบกำกับภาษี</label>
                        <input type="text" class="form-control" name="invoice_address" id="invoice_address">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">รูปแบบการวางบิล</label>
                        <select class="form-control select2" id="bill_type" name="bill_type"
                            onchange="bill_change(this.value)">
                            <option value="1">วางบิลแบบปกติ</option>
                            <option value="2">วางบิลแบบกลุ่ม</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">กลุ่มราคา</label>
                        <select class="form-control select2" id="customer_group" name="customer_group">
                            <option value="">เลือกกลุ่มราคา</option>
                            <?php while ($row_cus_group = mysqli_fetch_array($rs_cus_group)) { ?>
                                <option value="<?php echo $row_cus_group['customer_group_id'] ?>">
                                    <?php echo $row_cus_group['customer_group_name'] ?>
                                </option>

                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">ประเภทกลุ่มลูกค้า <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="customer_group_type_id" name="customer_group_type_id">
                            <option value="">เลือกกลุ่มลูกค้า</option>
                            <?php


                            foreach ($list_cusgroup as $row_cus_group) {
                                ?>
                                <option value="<?php echo $row_cus_group['customer_group_type_id'] ?>">
                                    <?php echo $row_cus_group['customer_group_type_name'] ?>
                                </option>

                            <?php } ?>
                        </select>


                    </div>

                    <div class="col-md-3 col-12 box-input" id="bill_point">

                    </div>
                </div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>วิธีการชำระเงิน</h5>
            </div>
            <div class="ibox-content">
                <div class="row">

                    <div class="col-md-4 col-12 box-input">
                        <label for="">ประเภทงาน </label><br>
                        <label for="">CM</label>
                        <input type="hidden" class="form-control" name="job_type[]" value="1" id="job_type">
                    </div>
                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าอะไหล่ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="spare_cost_1" name="spare_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="service_cost_1" name="service_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">ประเภทงาน </label><br>
                        <label for="">PM</label>
                        <input type="hidden" class="form-control" name="job_type[]" value="2" id="job_type">
                    </div>
                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าอะไหล่ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="spare_cost_2" name="spare_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="service_cost_2" name="service_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">ประเภทงาน </label><br>
                        <label for="">IN</label>
                        <input type="hidden" class="form-control" name="job_type[]" value="3" id="job_type">
                    </div>
                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าอะไหล่ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="spare_cost_3" name="spare_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="service_cost_3" name="service_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">ประเภทงาน </label><br>
                        <label for="">OH</label>
                        <input type="hidden" class="form-control" name="job_type[]" value="4" id="job_type">
                    </div>
                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าอะไหล่ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="spare_cost_4" name="spare_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="service_cost_4" name="service_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">ประเภทงาน </label><br>
                        <label for="">OTH</label>
                        <input type="hidden" class="form-control" name="job_type[]" value="5" id="job_type">
                    </div>
                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าอะไหล่ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="spare_cost_5" name="spare_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="service_cost_5" name="service_cost[]">

                            <option value="1">เก็บเงินจากลูกค้า</option>
                            <option value="2">เก็บเงินจากร้านค้า</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>ข้อมูลสาขา</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-6 col-12 box-input">
                        <label for="">ชื่อสาขา (ชื่อร้าน)<font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="branch_name" id="branch_name">
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัสสาขา</label>
                        <input type="text" class="form-control" name="branch_code" id="branch_code">
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัส AX </label>
                        <input type="text" class="form-control" name="ax_code" id="ax_code">
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัสสาขาทางภาษี </label>
                        <input type="text" class="form-control" name="tax_branch_code" id="tax_branch_code">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">ประเภทลูกค้า <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="billing_type" id="billing_type">
                            <option value="">โปรดระบุ</option>
                            <option value="1">นิติบุคคล</option>
                            <option value="2">บุคคลธรรมดา</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">ชื่อสำหรับออกใบกำกับภาษี <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="branch_invoice_name" id="branch_invoice_name">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">เลขประจำตัวผู้เสียภาษี</label>
                        <input type="text" class="form-control" name="branch_tax_no" id="branch_tax_no">
                    </div>


                    <div class="col-md-6 col-12 box-input">
                        <label for="">ที่อยู่สำหรับออกใบกำกับภาษี</label>
                        <input type="text" class="form-control" name="branch_invoice_address"
                            id="branch_invoice_address">
                    </div>

                    <!-- <div class="col-md-5 col-12 box-input">
                        <label for="">ที่อยู่สำหรับออกใบกำกับภาษี 2</label>
                        <input type="text" class="form-control" name="branch_invoice_address2" id="branch_invoice_address2">
                    </div> -->

                    <div class="col-md-3 col-12 box-input">
                        <label><br></label>
                        <br>
                        <label> <input class="icheckbox_square-green" type="checkbox" name="chkbox" id="chkbox"
                                value="chkbox"> ใช้ข้อมูลทางภาษีเดียวกับลูกค้า</label>

                    </div>

                    <div class="col-md-6 col-12 box-input">
                        <label for="">ที่อยู่ร้านค้า</label>
                        <input type="text" class="form-control" name="address" id="address">
                    </div>
                    <!-- <div class="col-md-6 col-12 box-input">
                        <label for="">ที่อยู่ 2</label>
                        <input type="text" class="form-control" name="address2" id="address2">
                    </div> -->

                    <div class="col-md-3 col-12 box-input">
                        <label for="">จังหวัด <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="province_id" id="province_id">
                            <option value="">โปรดระบุ</option>
                            <option value="0">ไม่ระบุ</option>
                            <?php foreach ($list_province as $row_province) { ?>
                                <option value="<?php echo $row_province['province_id']; ?>">
                                    <?php echo $row_province['province_name_th']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class=" col-md-3 col-12 box-input">
                        <label for="">อำเภอ/เขต <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="amphoe_id" id="amphoe_id">
                            <option value="">โปรดระบุ</option>
                            <option value="0">ไม่ระบุ</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">ตำบล/แขวง <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="district_id" id="district_id">
                            <option value="">โปรดระบุ</option>
                            <option value="0">ไม่ระบุ</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัสไปรษณีย์</label>
                        <input type="text" class="form-control" name="district_zipcode" id="district_zipcode" readonly>
                    </div>

                    <div class="col-md-4 col-12 box-input">
                        <label for="">ทีมงานที่ดูแล <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="branch_care_id" id="branch_care_id">
                            <option value="">โปรดระบุ</option>
                            <?php foreach ($list_branch as $data_branch) { ?>
                                <option value="<?php echo $data_branch['branch_id']; ?>">
                                    <?php echo $data_branch['branch_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class=" col-md-8 col-12 box-input">
                        <label for="">Google Map Link</label>
                        <input type="text" class="form-control" name="google_map_link" id="google_map_link">
                    </div>

                </div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>การติดต่อ</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-12 ">
                        <p><strong>ผู้ติดต่อหลัก</strong></p>
                    </div>
                    <div class="col-md-8 col-12 box-input">
                        <label for="">ชื่อผู้ติดต่อ <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="contact_name[]" id="contact_name">
                    </div>
                    <div class="col-md-4 col-12 box-input">
                        <label for="">ตำแหน่ง</label>
                        <input type="text" class="form-control" name="contact_position[]">
                    </div>
                    <div class="col-md-4 col-12 box-input">
                        <label for="">เบอร์โทรศัพท์ <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="contact_phone[]" id="contact_phone">
                    </div>
                    <div class="col-md-4 col-12 box-input">
                        <label for="">อีเมล์</label>
                        <input type="text" class="form-control" name="contact_email[]">
                    </div>
                    <div class="col-md-4 col-12 box-input">
                        <label for="">Line ID</label>
                        <input type="text" class="form-control" name="contact_line_id[]">
                    </div>
                </div>
                <div id="form_contact"></div>
                <hr>
                <div class="text-right">
                    <button class="btn btn-success" type="button" onclick="addContactForm()">
                        เพิ่มผู้ติดต่อ
                    </button>
                </div>
            </div>
        </div>
    </form>

    <div class="text-center">
        <button class="btn btn-primary px-5" type="button" onclick="Submit()">
            บันทึกข้อมูลลูกค้า
        </button>
    </div>

</div>

<?php include('footer.php'); ?>
<script>
    $('#chkbox').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    }).on('ifChanged', function (e) {
        var invoice_address = $('#invoice_address').val();
        var invoice_name = $('#invoice_name').val();
        var tax_no = $('#tax_no').val();

        if ($('#chkbox').is(':checked') == true) {
            $('#branch_invoice_address').val(invoice_address);
            $('#branch_invoice_name').val(invoice_name);
            $('#branch_tax_no').val(tax_no);

        } else {
            $('#branch_invoice_address').val('');
            $('#branch_invoice_name').val('');
            $('#branch_tax_no').val('');
        }
    });


    $(".select2").select2({
        width: '100%'
    });
    $("#customer_type").change(function (e) {
        const customer_type = $(this).val();
        $("#billing_type").val(customer_type);
    });
    $("#code_alert").hide();
    $("#province_id").change(function (e) {
        const province_id = $(this).val();
        var null_option = '<option value="" selected>โปรดระบุ</option>';
        var zero_option = '<option value="0" >ไม่ระบุ</option>';

        $("#amphoe_id option").remove();
        $("#district_id option").remove();
        $("#district_zipcode").val('');

        $("#amphoe_id").select2('destroy');
        $("#district_id").select2('destroy');

        $("#amphoe_id").append(null_option);
        $("#district_id").append(null_option);

        $("#amphoe_id").append(zero_option);
        $("#district_id").append(zero_option);

        $.ajax({
            type: "post",
            url: "ajax/addressJson/getAmphoe.php",
            data: {
                province_id: province_id
            },
            dataType: "json",
            success: function (response) {

                for (let index = 0; index < response.length; index++) {
                    const option_value = response[index].amphoe_id;
                    const option_name = response[index].amphoe_name_th;
                    const option_select = '<option value="' + option_value + '">' + option_name +
                        '</option>';
                    $("#amphoe_id").append(option_select);
                }

                $("#amphoe_id").select2();
                $("#district_id").select2();
            }
        });
    });
    $("#amphoe_id").change(function (e) {
        const amphoe_id = $(this).val();
        var null_option = '<option value="" selected>โปรดระบุ</option>';
        var zero_option = '<option value="0" >ไม่ระบุ</option>';

        $("#district_id option").remove();
        $("#district_zipcode").val('');

        $("#district_id").select2('destroy');

        $("#district_id").append(null_option);
        $("#district_id").append(zero_option);

        $.ajax({
            type: "post",
            url: "ajax/addressJson/getDistrict.php",
            data: {
                amphoe_id: amphoe_id
            },
            dataType: "json",
            success: function (response) {
                for (let index = 0; index < response.length; index++) {
                    const option_value = response[index].district_id;
                    const option_name = response[index].district_name_th;
                    const option_zipcode = response[index].district_zipcode;
                    const option_select = '<option value="' + option_value + '"  data-id="' +
                        option_zipcode + '">' + option_name + '</option>';
                    $("#district_id").append(option_select);
                }
                $("#district_id").select2();
            }
        });

        $.ajax({
            type: "post",
            url: "ajax/customer/getBranceCare.php",
            data: {
                amphoe_id: amphoe_id
            },
            dataType: "json",
            success: function (response) {
                if (response != "") {
                    $("#branch_care_id").select2('destroy');
                    $("#branch_care_id").val(response);
                    $("#branch_care_id").select2({
                        width: '100%'
                    });
                }
            }
        });


    });
    $("#district_id").change(function (e) {
        $("#district_zipcode").val($(this).find(':selected').data('id'));
    });

    function addContactForm() {
        $.ajax({
            url: "ajax/customer/addContactForm.php",
            dataType: "html",
            success: function (response) {
                $("#form_contact").append(response);
                $(".delete-contact").click(function (e) {
                    $(this).parents('.row').remove();
                });
            }
        });
    }
    $("#customer_code").change(function (e) {
        const customer_code = $(this).val();
        if (customer_code == "") {
            $("#code_alert").hide();
            $("#check_code").val(0);
        } else {
            $.ajax({
                type: "post",
                url: "ajax/customer/checkCode.php",
                data: {
                    customer_code: customer_code
                },
                dataType: "json",
                success: function (response) {
                    $("#check_code").val(response);
                    if (response == 1) {
                        $("#code_alert").hide();
                    } else {
                        $("#code_alert").show();
                    }
                }
            });
        }

    });
    $("#customer_name").change(function (e) {
        const customer_name = $(this).val();
        $("#contact_name").val(customer_name);
    });
    $("#phone").change(function (e) {
        const phone = $(this).val();
        $("#contact_phone").val(phone);
    });



    function bill_change(type_value) {
        if (type_value == 2) {
            $.ajax({
                type: 'POST',
                url: "ajax/customer/getBusiness_group.php",
                data: {
                    type_value: type_value
                },
                dataType: "html",
                success: function (response) {
                    $("#bill_point").html(response);
                    $(".select2").select2({
                        width: '100%'
                    });
                }
            });
        } else {

            $("#bill_point").html('');

        }

    }

    function Submit() {

        var formData = new FormData($("#form_customer")[0]);

        const customer_name = $("#customer_name").val();
        const customer_code = $("#customer_code").val();
        const check_code = $("#check_code").val();
        const customer_type = $("#customer_type").val();
        const branch_name = $("#branch_name").val();
        const branch_code = $("#branch_code").val();
        const billing_type = $("#billing_type").val();
        const district_zipcode = $("#district_zipcode").val();
        const branch_care_id = $("#branch_care_id").val();
        const contact_name = $("#contact_name").val();
        const contact_phone = $("#contact_phone").val();
        const invoice_name = $("#invoice_name").val();

        var customer_group_type_id = $("#customer_group_type_id").val();


        if (invoice_name == "" || customer_name == "" || customer_code == "" || check_code == 0 || customer_type == "" ||
            branch_name == "" || billing_type == "" || district_zipcode == "" || branch_care_id == "" || contact_name ==
            "" || contact_phone == "" || customer_group_type_id == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }


        const spare_cost_1 = $("#spare_cost_1").val();
        const spare_cost_2 = $("#spare_cost_2").val();
        const spare_cost_3 = $("#spare_cost_3").val();
        const spare_cost_4 = $("#spare_cost_4").val();
        const spare_cost_5 = $("#spare_cost_5").val();
        const service_cost_1 = $("#service_cost_1").val();
        const service_cost_2 = $("#service_cost_2").val();
        const service_cost_3 = $("#service_cost_3").val();
        const service_cost_4 = $("#service_cost_4").val();
        const service_cost_5 = $("#service_cost_5").val();


        if (spare_cost_1 == "0" || spare_cost_2 == "0" || spare_cost_3 == "0" || spare_cost_4 == "0" || spare_cost_5 ==
            "0" || service_cost_1 == "0" || service_cost_2 == "0" || service_cost_3 == "0" || service_cost_4 == "0" ||
            service_cost_5 == "0") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }


        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function () {

            $.ajax({
                type: 'POST',
                url: 'ajax/customer/Add.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });
                        setTimeout(() => {
                            location.href = "customer_list.php";
                        }, 3000);
                    } else if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: ' กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    } else if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อลูกค้าซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    } else if (data.result == 3) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อสาขาซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }
</script>
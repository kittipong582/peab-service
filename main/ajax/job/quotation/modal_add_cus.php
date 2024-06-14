<?php
include("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$list_province = array();
$job_id = $_POST['job_id'];

$sql_province = "SELECT * FROM tbl_province ORDER BY province_name_th ASC";
$rs_province  = mysqli_query($connection, $sql_province);
while ($row_province = mysqli_fetch_array($rs_province)) {

    $temp_array_province = array(
        "province_id" => $row_province['province_id'],
        "province_name_th" => $row_province['province_name_th'],
    );

    array_push($list_province, $temp_array_province);
}

$list_branch = array();

$sql_branch = "SELECT * FROM tbl_branch WHERE active_status = '1' ORDER BY branch_name ASC";
$rs_branch  = mysqli_query($connection, $sql_branch);
while ($row_branch = mysqli_fetch_array($rs_branch)) {

    $temp_array_branch = array(
        "branch_id" => $row_branch['branch_id'],
        "branch_name" => $row_branch['branch_name'],
    );

    array_push($list_branch, $temp_array_branch);
}

?>
<form action="" method="post" id="form-add_cus" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>เพิ่มลูกค้าใหม่</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>">
        <h4><b>1.ลูกค้า</b></h4>
        <div class="row">
            <input type="hidden" id="add_customer_id" name="add_customer_id" value="<?php echo getRandomID(10, 'tbl_customer', 'customer_id'); ?>">
            <div class="col-md-3 col-12 box-input">
                <label for="">รหัสลูกค้า <font class="text-danger">*</font></label>
                <input type="text" class="form-control" name="add_customer_code" id="add_customer_code">
            </div>
            <div class="col-md-6 col-12 box-input">
                <label for="">ชื่อลูกค้า <font class="text-danger">*</font></label>
                <input type="text" class="form-control" name="add_customer_name" id="add_customer_name">
            </div>

            <div class="col-md-3 col-12 box-input">
                <label for="">ประเภทลูกค้า <font class="text-danger">*</font></label>
                <select class="form-control select2" style="width: 100%;" name="add_customer_type" id="add_customer_type">
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
                <label for="">เลขประจำตัวผู้เสียภาษี <font class="text-danger">*</font></label>
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
                <label for="">ที่อยู่สำหรับออกใบกำกับภาษี <font class="text-danger">*</font></label>
                <input type="text" class="form-control" name="invoice_address" id="invoice_address">
            </div>
            <div class="col-md-6 col-12 box-input">
                <label for="">ที่อยู่สำหรับออกใบกำกับภาษี 2</label>
                <input type="text" class="form-control" name="invoice_address2" id="invoice_address2">
            </div>


        </div>
        <hr>

        <h4><b>2.สาขา</b></h4>
        <div class="row">
            <div class="col-md-6 col-12 box-input">
                <label for="">ชื่อสาขา <font class="text-danger">*</font></label>
                <input type="text" class="form-control" name="add_branch_name" id="add_branch_name">
            </div>

            <div class="col-md-3 col-12 box-input">
                <label for="">รหัสสาขา<font class="text-danger">*</font></label>
                <input type="text" class="form-control" name="add_branch_code" id="add_branch_code">
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
                <select class="form-control select2" style="width: 100%;" name="billing_type" id="billing_type">
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
                <input type="text" class="form-control" name="branch_invoice_address" id="branch_invoice_address">
            </div>

            <div class="col-md-6 col-12 box-input">
                <label for="">ที่อยู่สำหรับออกใบกำกับภาษี 2</label>
                <input type="text" class="form-control" name="branch_invoice_address2" id="branch_invoice_address2">
            </div>

            <div class="col-md-6 col-12 box-input">
                <label for="">ที่อยู่</label>
                <input type="text" class="form-control" name="address" id="address">
            </div>
            <div class="col-md-6 col-12 box-input">
                <label for="">ที่อยู่ 2</label>
                <input type="text" class="form-control" name="address2" id="address2">
            </div>

            <div class="col-md-3 col-12 box-input">
                <label for="">จังหวัด <font class="text-danger">*</font></label>
                <select class="form-control select2" style="width: 100%;" name="province_id" id="province_id">
                    <option value="">โปรดระบุ</option>
                    <?php foreach ($list_province as $row_province) { ?>
                        <option value="<?php echo $row_province['province_id']; ?>"><?php echo $row_province['province_name_th']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3 col-12 box-input">
                <label for="">อำเภอ/เขต <font class="text-danger">*</font></label>
                <select class="form-control select2" style="width: 100%;" name="amphoe_id" id="amphoe_id">
                    <option value="">โปรดระบุ</option>
                </select>
            </div>
            <div class="col-md-3 col-12 box-input">
                <label for="">ตำบล/แขวง <font class="text-danger">*</font></label>
                <select class="form-control select2" style="width: 100%;" name="district_id" id="district_id">
                    <option value="">โปรดระบุ</option>
                </select>
            </div>
            <div class="col-md-3 col-12 box-input">
                <label for="">รหัสไปรษณีย์</label>
                <input type="text" class="form-control" name="district_zipcode" id="district_zipcode" readonly>
            </div>

            <div class="col-md-4 col-12 box-input">
                <label for="">ทีมงานที่ดูแล <font class="text-danger">*</font></label>
                <select class="form-control select2" style="width: 100%;" name="branch_care_id" id="branch_care_id">
                    <option value="">โปรดระบุ</option>
                    <?php foreach ($list_branch as $data_branch) { ?>
                        <option value="<?php echo $data_branch['branch_id']; ?>"><?php echo $data_branch['branch_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-8 col-12 box-input">
                <label for="">Google Map Link</label>
                <input type="text" class="form-control" name="google_map_link" id="google_map_link">
            </div>

        </div>
        <hr>
        <h4><b>3.ผู้ติดต่อ</b></h4>
        <div class="row">

            <div class="col-md-8 col-12 box-input">
                <label for="">ชื่อผู้ติดต่อ <font class="text-danger">*</font></label>
                <input type="text" class="form-control" name="contact_name" id="contact_name">
            </div>
            <div class="col-md-4 col-12 box-input">
                <label for="">ตำแหน่ง</label>
                <input type="text" class="form-control" name="contact_position">
            </div>
            <div class="col-md-4 col-12 box-input">
                <label for="">เบอร์โทรศัพท์ <font class="text-danger">*</font></label>
                <input type="text" class="form-control" name="contact_phone" id="contact_phone">
            </div>
            <div class="col-md-4 col-12 box-input">
                <label for="">อีเมล์</label>
                <input type="text" class="form-control" name="contact_email">
            </div>
            <div class="col-md-4 col-12 box-input">
                <label for="">Line ID</label>
                <input type="text" class="form-control" name="contact_line_id">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button class="btn btn-primary btn-sm" type="button" id="submit" onclick="add_cus()">บันทึก</button>
    </div>
</form>

<?php include('footer.php'); ?>

<script>
    $(document).ready(function() {

    });


    $(".select2").select2({
        width: '100%'
    });
    $("#customer_type").change(function(e) {
        const customer_type = $(this).val();
        $("#billing_type").val(customer_type);
    });
    $("#code_alert").hide();
    $("#province_id").change(function(e) {
        const province_id = $(this).val();
        var null_option = '<option value="" selected>โปรดระบุ</option>';

        $("#amphoe_id option").remove();
        $("#district_id option").remove();
        $("#district_zipcode").val('');

        $("#amphoe_id").select2('destroy');
        $("#district_id").select2('destroy');

        $("#amphoe_id").append(null_option);
        $("#district_id").append(null_option);

        $.ajax({
            type: "post",
            url: "ajax/addressJson/getAmphoe.php",
            data: {
                province_id: province_id
            },
            dataType: "json",
            success: function(response) {

                for (let index = 0; index < response.length; index++) {
                    const option_value = response[index].amphoe_id;
                    const option_name = response[index].amphoe_name_th;
                    const option_select = '<option value="' + option_value + '">' + option_name + '</option>';
                    $("#amphoe_id").append(option_select);
                }

                $("#amphoe_id").select2();
                $("#district_id").select2();
            }
        });
    });
    $("#amphoe_id").change(function(e) {
        const amphoe_id = $(this).val();
        var null_option = '<option value="" selected>โปรดระบุ</option>';

        $("#district_id option").remove();
        $("#district_zipcode").val('');

        $("#district_id").select2('destroy');

        $("#district_id").append(null_option);

        $.ajax({
            type: "post",
            url: "ajax/addressJson/getDistrict.php",
            data: {
                amphoe_id: amphoe_id
            },
            dataType: "json",
            success: function(response) {
                for (let index = 0; index < response.length; index++) {
                    const option_value = response[index].district_id;
                    const option_name = response[index].district_name_th;
                    const option_zipcode = response[index].district_zipcode;
                    const option_select = '<option value="' + option_value + '"  data-id="' + option_zipcode + '">' + option_name + '</option>';
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
            success: function(response) {
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
    $("#district_id").change(function(e) {
        $("#district_zipcode").val($(this).find(':selected').data('id'));
    });

    // function addContactForm() {
    //     $.ajax({
    //         url: "ajax/customer/addContactForm.php",
    //         dataType: "html",
    //         success: function(response) {
    //             $("#form_contact").append(response);
    //             $(".delete-contact").click(function(e) {
    //                 $(this).parents('.row').remove();
    //             });
    //         }
    //     });
    // }
    // $("#customer_code").change(function(e) {
    //     const customer_code = $(this).val();
    //     if (customer_code == "") {
    //         $("#code_alert").hide();
    //         $("#check_code").val(0);
    //     } else {
    //         $.ajax({
    //             type: "post",
    //             url: "ajax/customer/checkCode.php",
    //             data: {
    //                 customer_code: customer_code
    //             },
    //             dataType: "json",
    //             success: function(response) {
    //                 $("#check_code").val(response);
    //                 if (response == 1) {
    //                     $("#code_alert").hide();
    //                 } else {
    //                     $("#code_alert").show();
    //                 }
    //             }
    //         });
    //     }

    // });
    // $("#customer_name").change(function(e) {
    //     const customer_name = $(this).val();
    //     $("#contact_name").val(customer_name);
    // });
    // $("#phone").change(function(e) {
    //     const phone = $(this).val();
    //     $("#contact_phone").val(phone);
    // });

    function add_cus() {

        var customer_code = $('#add_customer_code').val();
        var customer_name = $('#add_customer_name').val();
        var customer_type = $('#add_customer_type').val();
        var invoice_name = $('#invoice_name').val();
        var invoice_address = $('#invoice_address').val();
        var tax_no = $('#tax_no').val();
        var customer_id = $('#add_customer_id').val();

        var branch_name = $('#add_branch_name').val();
        var branch_code = $('#add_branch_code').val();
        var billing_type = $('#billing_type').val();
        var branch_invoice_name = $('#branch_invoice_name').val();
        var province_id = $('#province_id').val();
        var amphoe_id = $('#amphoe_id').val();
        var district_id = $('#district_id').val();
        var branch_care_id = $('#branch_care_id').val();
        var contact_name = $('#contact_name').val();
        var contact_phone = $('#contact_phone').val();

        var formData = new FormData($("#form-add_cus")[0]);



        if (customer_name == "" || customer_code == "" || customer_type == "" || invoice_name == "" || invoice_address == "" || tax_no == "" ||
            customer_id == "" || branch_name == "" || branch_code == "" || billing_type == "" || branch_invoice_name == "" || province_id == "" ||
            amphoe_id == "" || amphoe_id == "" || district_id == "" || branch_care_id == "" || contact_name == "" || contact_phone == "") {
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
        }, function() {

            $.ajax({
                type: 'POST',
                url: 'ajax/job/quotation/Add_cus.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });
                        setTimeout(() => {
                            window.location.reload();

                        }, 3000);
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });
    }
</script>
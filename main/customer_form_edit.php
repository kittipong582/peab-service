<?php
include('header.php');
$customer_id = $_GET['id'];


$sql = "SELECT * FROM tbl_customer WHERE customer_id = '$customer_id'";
$rs  = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($rs);

$list_province = array();

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


$sql_cus_group = "SELECT * FROM tbl_customer_group WHERE active_status = 1";
$rs_cus_group = mysqli_query($connection, $sql_cus_group);
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
        <h2>เเก้ไขข้อมูลลูกค้า</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_list.php">ข้อมูลลูกค้า</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>เเก้ไขข้อมูลลูกค้า</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <form action="" method="post" id="form_edit_customer" enctype="multipart/form-data">
        <input type="text" hidden name="customer_id" value="<?php echo $customer_id; ?>">
        <div class="ibox">
            <div class="ibox-title">
                <h5>ข้อมูลลูกค้า</h5>
            </div>
            <div class="ibox-content">
                <div class="row">

                    <div class="col-md-3 col-12 box-input">
                        <label for="">รหัสลูกค้า <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="customer_code" id="customer_code"
                            value="<?php echo $row['customer_code']; ?>">
                    </div>
                    <div class="col-md-6 col-12 box-input">
                        <label for="">ชื่อลูกค้า <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="customer_name" id="customer_name"
                            value="<?php echo $row['customer_name']; ?>">
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">ประเภทลูกค้า <font class="text-danger">*</font></label>
                        <select class="form-control select2" name="customer_type" id="customer_type">
                            <option value="" <?php echo ($row['customer_type'] == "") ? '' : 'SELECTED' ?>>โปรดระบุ
                            </option>
                            <option value="1" <?php echo ($row['customer_type'] == "1") ? '' : 'SELECTED' ?>>นิติบุคคล
                            </option>
                            <option value="2" <?php echo ($row['customer_type'] == "2") ? '' : 'SELECTED' ?>>บุคคลธรรมดา
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">ชื่อสำหรับออกใบกำกับภาษี <font class="text-danger">*</font></label>
                        <input type="text" class="form-control" name="invoice_name" id="invoice_name"
                            value="<?php echo $row['invoice_name']; ?>">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">เลขประจำตัวผู้เสียภาษี</label>
                        <input type="text" class="form-control" name="tax_no" id="tax_no"
                            value="<?php echo $row['tax_no']; ?>">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">อีเมล์</label>
                        <input type="text" class="form-control" name="email" id="email"
                            value="<?php echo $row['email']; ?>">
                    </div>
                    <div class="col-md-3 col-12 box-input">
                        <label for="">เบอร์โทร</label>
                        <input type="text" class="form-control" name="phone" id="phone"
                            value="<?php echo $row['phone']; ?>">
                    </div>
                    <div class="col-md-6 col-12 box-input">
                        <label for="">ที่อยู่สำหรับออกใบกำกับภาษี</label>
                        <input type="text" class="form-control" name="invoice_address" id="invoice_address"
                            value="<?php echo $row['invoice_address']; ?>">
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">รูปแบบการวางบิล</label>
                        <select class="form-control select2" id="bill_type" name="bill_type" onchange="bill_change()">
                            <option value="1" <?php if ($row['bill_type'] == 1) {
                                                    echo "SELECTED";
                                                } ?>>วางบิลแบบปกติ</option>
                            <option value="2" <?php if ($row['bill_type'] == 2) {
                                                    echo "SELECTED";
                                                } ?>>วางบิลแบบกลุ่ม</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-12 box-input">
                        <label for="">กลุ่มราคา <font class="text-danger">*</font></label>
                        <select class="form-control select2" id="customer_group" name="customer_group">
                            <option value="">เลือกกลุ่มราคา</option>
                            <?php while ($row_cus_group = mysqli_fetch_array($rs_cus_group)) { ?>
                            <option value="<?php echo $row_cus_group['customer_group_id'] ?>"
                                <?php echo ($row['customer_group'] == $row_cus_group['customer_group_id'])? "SELECTED" : "" ?>>
                                <?php echo $row_cus_group['customer_group_name'] ?>
                            </option>

                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 box-input" id="bill_point">

                    </div>

                </div>
            </div>
        </div>

    </form>

    <div class="text-center">
        <button class="btn btn-primary px-5" type="button" onclick="Update()">
            บันทึกข้อมูลลูกค้า
        </button>
    </div>

</div>

<?php include('footer.php'); ?>
<script>
$(document).ready(function() {

    bill_change();

});

$(".select2").select2({
    width: '100%'
});


function Update() {

    var formData = new FormData($("#form_edit_customer")[0]);

    const customer_name = $("#customer_name").val();
    const customer_code = $("#customer_code").val();
    const customer_type = $("#customer_type").val();
    const invoice_name = $("#invoice_name").val();
    const customer_group = $("#customer_group").val

    if (customer_name == "" || customer_code == "" || customer_type == "" || invoice_name == "" || customer_group ==
        "") {
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
            url: 'ajax/customer/Update.php',
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
                        location.href = "customer_list.php";
                    }, 3000);
                } else if (data.result == 0) {
                    swal({
                        title: 'ผิดพลาด!',
                        text: ' กรุณากรอกใหม่ !!',
                        type: 'warning'
                    });
                    return false;
                }

            }
        })
    });

}


function bill_change() {
    var type_value = $('#bill_type').val();
    var customer_id = $('#customer_id').val();
    if (type_value == 2) {
        $.ajax({
            type: 'POST',
            url: "ajax/customer/getBusiness_group.php",
            data: {
                type_value: type_value,
                customer_id: customer_id
            },
            dataType: "html",
            success: function(response) {
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
</script>
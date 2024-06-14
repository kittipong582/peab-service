<?php
include('header.php');
$customer_id = $_GET['id'];

///////////////////////////For Manu
$sql = "SELECT * FROM tbl_customer WHERE customer_id = '$customer_id'";
$result  = mysqli_query($connection, $sql);
$row_detail = mysqli_fetch_array($result);


///////////////////////////1
$sql_1 = "SELECT * FROM tbl_customer_payment WHERE customer_id = '$customer_id' and job_type = '1' ";
$result_1  = mysqli_query($connection, $sql_1);
$row_1 = mysqli_fetch_array($result_1);

///////////////////////////2
$sql_2 = "SELECT * FROM tbl_customer_payment WHERE customer_id = '$customer_id' and job_type = '2' ";
$result_2  = mysqli_query($connection, $sql_2);
$row_2 = mysqli_fetch_array($result_2);

///////////////////////////3
$sql_3 = "SELECT * FROM tbl_customer_payment WHERE customer_id = '$customer_id' and job_type = '3' ";
$result_3  = mysqli_query($connection, $sql_3);
$row_3 = mysqli_fetch_array($result_3);

///////////////////////////4
$sql_4 = "SELECT * FROM tbl_customer_payment WHERE customer_id = '$customer_id' and job_type = '4' ";
$result_4  = mysqli_query($connection, $sql_4);
$row_4 = mysqli_fetch_array($result_4);

///////////////////////////5
$sql_5 = "SELECT * FROM tbl_customer_payment WHERE customer_id = '$customer_id' and job_type = '5' ";
$result_5  = mysqli_query($connection, $sql_5);
$row_5 = mysqli_fetch_array($result_5);
?>
<style>
    .box-input {
        min-height: 90px;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ตั้งค่าการชำระเงิน</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_list.php">ข้อมูลลูกค้า</a>
            </li>
            <li class="breadcrumb-item active">
                <strong><label>ตั้งค่าการชำระเงิน</label></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <!-- <h5>ข้อมูลลูกค้า</h5> -->
                </div>
                <form action="" method="post" id="form_edit_payment" enctype="multipart/form-data">
                    <div class="ibox-content">
                        <div class="row">
                            <input type="hidden" class="form-control" name="customer_id" value="<?php echo $customer_id ?>" id="customer_id">
                            <div class="col-md-4 col-12 box-input">
                                <label for="">ประเภทงาน </label><br>
                                <label for="">CM</label>
                                <input type="hidden" class="form-control" name="job_type[]" value="1" id="job_type">
                            </div>
                            <div class="col-md-4 col-12 box-input">
                                <label for="">การเก็บเงินค่าอะไหล่ <font class="text-danger">*</font></label>
                                <select class="form-control select2" id="spare_cost_1" name="spare_cost[]">
                                    <option value="0" <?php echo ($row_1['spare_cost'] == '') ? '' : 'SELECTED' ?>>กรุณาเลือก</option>
                                    <option value="1" <?php if ($row_1['spare_cost'] == '1') {
                                                            echo "SELECTED";
                                                        } ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php if ($row_1['spare_cost'] == '2') {
                                                            echo "SELECTED";
                                                        } ?>>เก็บเงินจากร้านค้า</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-12 box-input">
                                <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                                <select class="form-control select2" id="service_cost_1" name="service_cost[]">
                                    <option value="0" <?php if ($row_1['service_cost'] == '0') {
                                                            echo "SELECTED";
                                                        } ?>>กรุณาเลือก</option>
                                    <option value="1" <?php if ($row_1['service_cost'] == '1') {
                                                            echo "SELECTED";
                                                        } ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php if ($row_1['service_cost'] == '2') {
                                                            echo "SELECTED";
                                                        } ?>>เก็บเงินจากร้านค้า</option>
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
                                    <option value="0" <?php if ($row_2['spare_cost'] == '0') {
                                                            echo "SELECTED";
                                                        } ?>>กรุณาเลือก</option>
                                    <option value="1" <?php if ($row_2['spare_cost'] == '1') {
                                                            echo "SELECTED";
                                                        } ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php if ($row_2['spare_cost'] == '2') {
                                                            echo "SELECTED";
                                                        } ?>>เก็บเงินจากร้านค้า</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-12 box-input">
                                <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                                <select class="form-control select2" id="service_cost_2" name="service_cost[]">
                                    <option value="0" <?php if ($row_2['service_cost'] == '0') {
                                                            echo "SELECTED";
                                                        } ?>>กรุณาเลือก</option>
                                    <option value="1" <?php if ($row_2['service_cost'] == '1') {
                                                            echo "SELECTED";
                                                        } ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php if ($row_2['service_cost'] == '2') {
                                                            echo "SELECTED";
                                                        } ?>>เก็บเงินจากร้านค้า</option>
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
                                    <option value="0" <?php echo ($row_3['spare_cost'] == '') ? 'SELECTED' : '' ?>>กรุณาเลือก</option>
                                    <option value="1" <?php echo ($row_3['spare_cost'] == '1') ? 'SELECTED' : '' ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php echo ($row_3['spare_cost'] == '2') ? 'SELECTED' : '' ?>>เก็บเงินจากร้านค้า</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-12 box-input">
                                <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                                <select class="form-control select2" id="service_cost_3" name="service_cost[]">
                                    <option value="0" <?php echo ($row_3['service_cost'] == '') ? 'SELECTED' : '' ?>>กรุณาเลือก</option>
                                    <option value="1" <?php echo ($row_3['service_cost'] == '1') ? 'SELECTED' : '' ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php echo ($row_3['service_cost'] == '2') ? 'SELECTED' : '' ?>>เก็บเงินจากร้านค้า</option>
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
                                    <option value="0" <?php echo ($row_4['spare_cost'] == '') ? 'SELECTED' : '' ?>>กรุณาเลือก</option>
                                    <option value="1" <?php echo ($row_4['spare_cost'] == '1') ? 'SELECTED' : '' ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php echo ($row_4['spare_cost'] == '2') ? 'SELECTED' : '' ?>>เก็บเงินจากร้านค้า</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-12 box-input">
                                <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                                <select class="form-control select2" id="service_cost_4" name="service_cost[]">
                                    <option value="0" <?php echo ($row_4['service_cost'] == '') ? 'SELECTED' : '' ?>>กรุณาเลือก</option>
                                    <option value="1" <?php echo ($row_4['service_cost'] == '1') ? 'SELECTED' : '' ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php echo ($row_4['service_cost'] == '2') ? 'SELECTED' : '' ?>>เก็บเงินจากร้านค้า</option>
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
                                    <option value="0" <?php echo ($row_5['spare_cost'] == '') ? 'SELECTED' : '' ?>>กรุณาเลือก</option>
                                    <option value="1" <?php echo ($row_5['spare_cost'] == '1') ? 'SELECTED' : '' ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php echo ($row_5['spare_cost'] == '2') ? 'SELECTED' : '' ?>>เก็บเงินจากร้านค้า</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-12 box-input">
                                <label for="">การเก็บเงินค่าบริการ <font class="text-danger">*</font></label>
                                <select class="form-control select2" id="service_cost_5" name="service_cost[]">
                                    <option value="0" <?php echo ($row_5['service_cost'] == '') ? 'SELECTED' : '' ?>>กรุณาเลือก</option>
                                    <option value="1" <?php echo ($row_5['service_cost'] == '1') ? 'SELECTED' : '' ?>>เก็บเงินจากลูกค้า</option>
                                    <option value="2" <?php echo ($row_5['service_cost'] == '2') ? 'SELECTED' : '' ?>>เก็บเงินจากร้านค้า</option>
                                </select>
                            </div>
                            <div class="col-12 text-right">
                                <button class="btn btn-primary px-5" type="button" onclick="Submit()">
                                    บันทึกข้อมูลลูกค้า
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
            <?php include 'customer_menu.php'; ?>
        </div>
    </div>

</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>

<script>
    $(document).ready(function() {
        $(".select2").select2({
            width: '100%'
        });
    });



    function Submit() {

        var formData = new FormData($("#form_edit_payment")[0]);
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
        var customer_id = $("#customer_id").val();


        if (spare_cost_1 == "0" || spare_cost_2 == "0" || spare_cost_3 == "0" || spare_cost_4 == "0" || spare_cost_5 == "0" || service_cost_1 == "0" || service_cost_2 == "0" || service_cost_3 == "0" || service_cost_4 == "0" || service_cost_5 == "0") {
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
                url: 'ajax/customer/edit_payment.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == '1') {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: true
                        });
                        setTimeout(() => {
                            location.href = "customer_view_detail.php?id=" + customer_id;
                        }, 1000);
                    } else if (data.result == '') {
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
</script>
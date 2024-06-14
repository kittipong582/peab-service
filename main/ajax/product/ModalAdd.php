<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$branch_id = $_POST['branch_id'];


$sql_type = "SELECT * FROM tbl_product_type WHERE active_status = 1 ORDER BY type_code";
$result_type  = mysqli_query($connect_db, $sql_type);

?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มสินค้า</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" value="<?php echo $branch_id  ?>" id="branch_id" name="branch_id">
            <div class="col-4 mb-3">
                <label for="brand_id">
                    แบรนด์
                </label>
                <font color="red">**</font>
                <select class="form-control select2 mb-3" style="width: 100%;" name="brand_id" id="brand_id" onchange="setModel(value)">
                    <option value="">กรุณาเลือกแบรนด์</option>
                    <?php $sql_brand = "SELECT * FROM tbl_product_brand WHERE active_status = '1'";
                    $result_brand  = mysqli_query($connect_db, $sql_brand);
                    while ($row_brand = mysqli_fetch_array($result_brand)) { ?>

                        <option value="<?php echo $row_brand['brand_id'] ?>"><?php echo $row_brand['brand_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-4 mb-3">
                <label for="model_id">
                    รุ่น
                </label>
                <font color="red">**</font>
                <div class="" id="getmodel">
                    <select class="form-control select2 mb-3" style="width: 100%;" name="model_id" id="model_id">
                        <option value="">กรุณาเลือกรุ่น</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mb-3">
                <div>
                    <label for="product_type">
                        ประเภทเครื่อง
                    </label>
                    <font color="red">**</font>
                    <select name="product_type" id="product_type" style="width: 100%;" class="form-control select2 mb-3 ">
                        <option value="">กรุณาเลือกเครื่อง</option>
                        <?php

                        while ($row_type = mysqli_fetch_array($result_type)) { ?>

                            <option value="<?php echo $row_type['type_id'] ?>"><?php echo $row_type['type_code']." - ".$row_type['type_name'] ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="serial_no">
                    serial no
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="serial_no" name="serial_no">
            </div>

            <div class="col-4 mb-3">
                <div>
                    <label for="warranty_type">
                        ประเภทการรับประกัน
                    </label>
                    <font color="red">**</font>
                    <select name="warranty_type" id="warranty_type" class="form-control select2 mb-3" style="width: 100%;" onchange="setwarranty(this.value);">
                        <option value="">กรุณาเลือกประเภทประกัน</option>
                        <option value="1">ซื้อจากบริษัท</option>
                        <option value="2">ไม่ได้ซื้อจากบริษัท</option>
                        <option value="3">สัญญาบริการ</option>

                    </select>
                </div>
            </div>

            <div class="col-4 mb-3">
            </div>

            <div class="col-4 mb-3">
            </div>

            <div class="col-6 mb-3" id="div_install" style="display:none">
                <label for="install_date">
                    วันที่ติดตั้ง
                </label>
                <font color="red" id="alert" style="display:none">**</font>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="install_date" name="install_date" class="form-control datepicker" value="" autocomplete="off">
                </div>
            </div>

            <div class="col-6 mb-3" id="div_buy" style="display:none">

                <label for="buy_date">
                    วันที่ซื้อ
                </label>
                <font color="red" id="alert1" style="display:none">**</font>

                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="buy_date" name="buy_date" class="form-control datepicker" value="" autocomplete="off">
                </div>
            </div>

            <div class="col-6 mb-3" id="div_start" style="display:none">
                <label for="warranty_start_date">
                    วันที่เริ่มประกัน
                </label>
                <font color="red" id="alert2" style="display:none">**</font>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="warranty_start_date" name="warranty_start_date" class="form-control datepicker" value="" autocomplete="off">
                </div>
            </div>

            <div class="col-6 mb-3" id="div_end" style="display:none">

                <label for="warranty_end_date">
                    วันที่หมดประกัน
                </label>
                <font color="red" id="alert3" style="display:none">**</font>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="warranty_end_date" name="warranty_end_date" class="form-control datepicker" value="" autocomplete="off">
                </div>
            </div>

            <div class="col-12 mb-3">

                <label for="note">
                    หมายเหตุ
                </label>
                <textarea class="summernote" name="note" style="outline: 1px;" id="note"></textarea>
            </div>

            <div class="col-4 mb-3">
            </div>
        </div>







    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>
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


    function setwarranty(warranty_val) {
        $("#div_install").hide();
        $("#div_buy").hide();
        $("#div_start").hide();
        $("#div_end").hide();
        $("#alert").hide();
        $("#alert1").hide();
        $("#alert2").hide();
        $("#alert3").hide();

        if (warranty_val == "1") {
            $("#div_install").show();
            $("#div_buy").show();
            $("#div_start").show();
            $("#div_end").show();
            $("#alert").show();
            $("#alert1").show();
            $("#alert2").show();
            $("#alert3").show();

        } else if (warranty_val == "2") {
            $("#div_install").show();
            $("#div_buy").show();
            $("#div_start").show();
            $("#div_end").show();
        } else if (warranty_val == "3") {
            $("#div_install").show();
            $("#div_start").show();
            $("#div_end").show();

            $("#alert").show();
            $("#alert2").show();
            $("#alert3").show();
        }
    }

    function setModel(brand_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/product/getModel.php',
            data: {
                brand_id: brand_id,
            },
            dataType: 'html',
            success: function(response) {
                $('#getmodel').html(response);
                $(".select2").select2({});
            }
        });

    }


    function Add() {

        var product_type = $('#product_type').val();
        var brand_id = $('#brand_id').val();
        var model_id = $('#model_id').val();
        var serial_no = $('#serial_no').val();
        var div_install = $("#install_date").val();
        var div_buy = $("#buy_date").val();
        var div_start = $("#warranty_start_date").val();
        var div_end = $("#warranty_end_date").val();
        var branch_id = $('#branch_id').val();
        var warranty_type = $("#warranty_type").val();

        if (warranty_type == 1) {

            if (product_type == "" || model_id == "" || serial_no == "" || brand_id == "" || div_install == "" || div_buy == "" || div_start == "" || div_end == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
        } else if (warranty_type == 2) {

            if (product_type == "" || model_id == "" || serial_no == "" || brand_id == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
        } else if (warranty_type == 3) {
            if (product_type == "" || model_id == "" || serial_no == "" || brand_id == "" || div_install == "" || div_start == "" || div_end == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
        }
        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00FF00",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function() {

            let myForm = document.getElementById('form-add');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/product/Add.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            swal.close();
                            $("#modal").modal('hide');
                            GetTable(branch_id);

                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้ serial no ซ้ำ", "error");
                    }

                }
            });

        });
    }
</script>
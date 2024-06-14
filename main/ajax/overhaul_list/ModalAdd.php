<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มสินค้า</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" value="<?php echo getRandomID(10, 'tbl_overhaul', 'overhaul_id'); ?>" id="overhaul_id" name="overhaul_id">
        <div class="row">
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
                        เครื่อง
                    </label>
                    <font color="red">**</font>
                    <select name="product_type" id="product_type" style="width: 100%;" class="form-control select2 mb-3 ">
                        <option value="">กรุณาเลือกเครื่อง</option>
                        <option value="1">เครื่องชง</option>
                        <option value="2">เครื่องบด</option>
                        <option value="3">เครื่องปั่น</option>

                    </select>
                </div>
            </div>
            <div class="col-4 mb-3">
                <label for="serial_no">
                    serial no
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="serial_no" name="serial_no">
            </div>

            <div class="col-4 mb-3">
                <label for="serial_no">
                รหัสทรัพย์สิน
                </label>

                <input type="text" class="form-control mb-3" id="ax_no" name="ax_no">
            </div>


            <div class="col-4 mb-3">
                <label for="serial_no">
                    ทีมดูแล
                </label>
                <font color="red">**</font>
                <select name="current_branch_id" id="current_branch_id" style="width: 100%;" class="form-control select2 mb-3 ">
                    <option value="">กรุณาเลือกทีม</option>
                    <?php $sql_team = "SELECT * FROM tbl_branch WHERE active_status = 1";
                    $result_team  = mysqli_query($connect_db, $sql_team);
                    while ($row_team = mysqli_fetch_array($result_team)) { ?>

                        <option value="<?php echo $row_team['branch_id'] ?>"><?php echo $row_team['branch_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-4 mb-3">
            </div>

            <div class="col-4 mb-3">
            </div>


            <div class="col-6 mb-3">

                <label for="overhaul_owner">
                    ประเภทเครื่อง
                </label>
                <select name="overhaul_owner" id="overhaul_owner" style="width: 100%;" class="form-control select2 mb-3 ">
                    <option value="">กรุณาเลือกประเภท</option>
                    <option value="1">เครื่องบริษัท</option>
                    <option value="2">ไม่ใช่เครื่องบริษัท</option>

                </select>
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


    function setModel(brand_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/overhaul_list/getModel.php',
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
        var div_buy = $("#buy_date").val();
        var div_start = $("#warranty_start_date").val();
        var div_end = $("#warranty_end_date").val();
        var warranty_type = $("#warranty_type").val();
        var overhaul_owner = $('#overhaul_owner').val();
        var current_branch_id = $('#current_branch_id').val();


        if (product_type == "" || model_id == "" || current_branch_id == "" || serial_no == "" || overhaul_owner == "" || brand_id == "" || div_start == "" || div_end == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
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
                url: "ajax/overhaul_list/Add.php",
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
                            GetTable();

                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้ serial no ซ้ำ", "error");
                    }

                }
            });

        });
    }
</script>
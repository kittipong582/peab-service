<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$product_id = $_POST['product_id'];

$sql = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
$branch_id = $row['current_branch_id'];



?>
<form action="" method="post" id="form-transfer" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">โอนย้าย</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" id="transfer_id" name="transfer_id" value="<?php echo getRandomID(10, 'tbl_product_transfer', 'transfer_id') ?>">
            <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id ?>">
            <div class="col-4 mb-6" id="div_install">
                <label for="install_date">
                    วันที่ติดตั้ง
                </label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="install_date" name="install_date" class="form-control datepicker" value="" autocomplete="off">
                </div>
            </div>

            <div class="col-4 mb-6">
                <label>
                    ค้นหา
                </label>
                <font color="red">**</font>
                <div class="input-group">
                    <input type="text" class="form-control" id="search_text" name="search_text" placeholder="(รหัสร้าน , ชื่อร้าน)">
                    <span class="input-group-append">
                        <button type="button" onclick="Get_branch();" class="btn btn-primary">ค้นหา
                        </button>
                    </span>
                </div>

            </div>

            <div class="col-4 mb-3" id="select_point">
               
            </div>


            <div class="col-12 mb-3">
                <label for="note">
                    หมายเหตุ
                </label>
                <textarea class="summernote" id="note" name="note"></textarea>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" onclick="Transfer('<?php echo $row['overhaul_id'];  ?>');">ยืนยัน</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
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

   


    function Transfer() {

        var product_id = $('#product_id').val();
        var branch_id = $('#to_branch_id').val();


        if (product_id == "" || branch_id == "") {
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

            let myForm = document.getElementById('form-transfer');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/product_transfer/Transfer.php",
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
                            GetTable(product_id);

                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้", "error");
                    }

                }
            });

        });
    }
</script>
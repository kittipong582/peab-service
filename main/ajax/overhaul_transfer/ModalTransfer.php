<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$overhaul_id = $_POST['overhaul_id'];
$sql = "SELECT * FROM tbl_overhaul WHERE overhaul_id = '$overhaul_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
$branch_id = $row['current_branch_id'];
$brand_id = $row['brand_id'];
$sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result_brand  = mysqli_query($connect_db, $sql_brand);
$row_brand = mysqli_fetch_array($result_brand);

$model_id = $row['model_id'];
$sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result_model  = mysqli_query($connect_db, $sql_model);
$row_model = mysqli_fetch_array($result_model);

?>
<form action="" method="post" id="form-transfer" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">ข้อมูล</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" id="oh_transfer_id" name="oh_transfer_id" value="<?php echo getRandomID(10, 'tbl_overhaul_transfer', 'oh_transfer_id') ?>">
            <input type="hidden" id="overhaul_id" name="overhaul_id" value="<?php echo $overhaul_id ?>">
            <div class="col-4 mb-3">
                <label>
                    AX Ref no
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control" id="ax_ref_no" name="ax_ref_no">
            </div>

            <div class="col-6 mb-3">
                <label>
                    ทีมงาน (ผู้รับ)
                </label>
                <font color="red">**</font>

                <select class="form-control select2 mb-3 " style="width: 100%;" name="to_branch_id" id="to_branch_id">
                    <option value="">กรุณาเลือกทีมงาน</option>
                    <?php $sql_team = "SELECT * FROM tbl_branch WHERE NOT branch_id = '$branch_id' and active_status = '1'";
                    $result_team  = mysqli_query($connect_db, $sql_team);
                    echo $sql_team;
                    while ($row_team = mysqli_fetch_array($result_team)) { ?>

                        <option value="<?php echo $row_team['branch_id'] ?>"><?php echo $row_team['branch_name'] ?></option>
                    <?php } ?>
                </select>
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

        var overhaul_id = $('#overhaul_id').val();
        var branch_id = $('#to_branch_id').val();


        if (overhaul_id == "" || branch_id == "") {
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
                url: "ajax/overhaul_transfer/Transfer.php",
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
                            GetTable(overhaul_id);

                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้", "error");
                    }

                }
            });

        });
    }
</script>
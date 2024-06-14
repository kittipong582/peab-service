<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$oh_transfer_id = $_POST['oh_transfer_id'];
$sql = "SELECT * FROM tbl_overhaul_transfer WHERE oh_transfer_id = '$oh_transfer_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

// echo $sql;
?>
<form action="" method="post" id="form-transfer" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">การอนุมัติ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" id="oh_transfer_id" name="oh_transfer_id" value="<?php echo $row['oh_transfer_id'] ?>">
            <input type="hidden" id="overhaul_id" name="overhaul_id" value="<?php echo $row['overhaul_id'] ?>">
            <input type="hidden" id="to_branch_id" name="to_branch_id" value="<?php echo $row['to_branch_id'] ?>">
            <div class="col-4 mb-3">
                <div class="button-groups">
                      <input type="radio" id="apply" name="apply" onclick="checked_radio()" value="1"><label style="font-size: 14px;">ยืนยัน</label><br>
                      <input type="radio" id="apply" name="apply" onclick="checked_radio()" value="2"><label style="font-size: 14px;">ไม่ยืนยัน</label><br>
                </div>
                <input type="hidden" class="form-control" id="receive_result" value="" name="receive_result">
            </div>

            <div class="col-12 mb-3">
                <label for="receive_remark">
                    หมายเหตุ
                </label>
                <textarea class="summernote" id="receive_remark" name="receive_remark"></textarea>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" onclick="Transfer('<?php echo $row['overhaul_id']; ?>');">ยืนยัน</button>
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

    function checked_radio() {
        var checked = document.querySelector('input[name="apply"]:checked').value;

        $('#receive_result').val(checked);
    }

    function Transfer() {

        var receive_result = $('#receive_result').val();
        var overhaul_id = $('#overhaul_id').val();


        if (receive_result == "") {
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
                url: "ajax/overhaul_transfer/Receive.php",
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
                        swal("", "ไม่สามารถทำรายการได้", "error");
                    }

                }
            });

        });
    }
</script>
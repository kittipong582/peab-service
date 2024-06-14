<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql_job = "SELECT * FROM tbl_group_pm_detail WHERE group_pm_id = '$job_id'";
$rs = mysqli_query($connect_db, $sql_job);
$row = mysqli_fetch_assoc($rs);

if (mysqli_num_rows($rs) > 0) {
    $group_type = 2;
} else {
    $group_type = 1;
}

?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">
            เพิ่ม
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" value="<?php echo $job_id ?>" id="mainjob_id" name="mainjob_id">
            <input type="hidden" value="<?php echo $group_type ?>" id="group_type" name="group_type">

            <div class="col-12">
                <label><b>so no</b></label>
                <input type="text" name="so_no" id="so_no" class="form-control">
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


    });



    function Add() {
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

            swal({
                title: "Loading",
                text: "Loading...",
                showCancelButton: false,
                showConfirmButton: false
                //icon: "success"
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/job_list/Add_so.php",
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
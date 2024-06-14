<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$group_type = $_POST['group_type'];
if ($group_type == 1) {
    $sql = "SELECT so_no FROM tbl_job WHERE job_id = '$job_id'";
    $result  = mysqli_query($connect_db, $sql);
    $row = mysqli_fetch_array($result);
} else {

    $sql = "SELECT so_no FROM tbl_group_pm WHERE group_pm_id = '$job_id'";
    $result  = mysqli_query($connect_db, $sql);
    $row = mysqli_fetch_array($result);
}

?>
<form action="" method="post" id="form-add_so" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการดำเนินการ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <?php if ($row['so_no'] == null) {  ?>
        <div class="row ">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <input id="group_type" name="group_type" value="<?php echo $group_type ?>" type="hidden">
            <div class="col-3 mb-3">

            </div>
            <div class="col-6 mb-3">
                <label for="expend_type">
                    เลข SO
                </label>
                <input type="text" id="so_no" name="so_no" class="form-control">
            </div>
            <div class="col-3 mb-3">

            </div>

        </div>
        <?php } else { ?>

        <div class="row ">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <input id="group_type" name="group_type" value="<?php echo $group_type ?>" type="hidden">

            <div class="col-3 mb-3">

            </div>
            <div class="col-6 mb-3">
                <label for="expend_type">
                    เลข SO
                </label>
                <input type="text" id="so_no" name="so_no" value="<?php echo $row['so_no'] ?>" class="form-control">
            </div>
            <div class="col-3 mb-3">

            </div>

        </div>

        <?php } ?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
$(document).ready(function() {

    $(".select2").select2({});
});

function Submit() {

    var so_no = $('#so_no').val();



    var formData = new FormData($("#form-add_so")[0]);

    if (so_no == "") {
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
            url: 'ajax/CM_view/SO/Add.php',
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
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        swal.close();
                    }, 500);
                    $("#modal").modal('hide');
                    load_Getdata($('#get11').val());

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
<?php
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$sql_expend = "SELECT * FROM tbl_expend_type WHERE active_status = 1";
$result_expend  = mysqli_query($connect_db, $sql_expend);

?>
<style>
.select2-dropdown {
    z-index: 9999999;
}
</style>
<form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการดำเนินการ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <div class="col-6 mb-3">
                <label for="expend_type">
                    ประเภทค่าใช้จ่าย
                </label>
                <select class="form-control select2" style="width: 100%;" id="expend_type_id" onchange="get_des_expend(this.value)" name="expend_type_id">
                    <option value="">กรุณาเลือกประเภท</option>
                    <?php while ($row_expend = mysqli_fetch_array($result_expend)) { ?>
                        <option value="<?php echo $row_expend['expend_type_id'] ?>"><?php echo $row_expend['expend_type_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-6 mb-3" id="show_des">

            </div>

            <div class="col-6 mb-3">
                <label for="amount">
                    ยอดรวม
                </label>
                <input type="text" class="form-control" id="amount" name="amount">
            </div>

            <div class="col-6 mb-3" id="show_des">

            </div>

        </div>
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

    function get_des_expend(expend_id) {
        $.ajax({
            url: 'ajax/mywork/expend/Get_des.php',
            type: 'POST',
            dataType: 'html',
            data: {
                expend_id: expend_id,

            },
            success: function(data) {


                $('#show_des').html(data);

            }
        });

    }

    function Submit() {

        var expend_type_id = $('.expend_type_id').val();
        var amount = $('.amount').val();

        var formData = new FormData($("#form-add_spare")[0]);

        if (expend_type_id == "" || amount == "") {
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
                url: 'ajax/mywork/expend/Add_job_expend.php',
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

                        Getdata();
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
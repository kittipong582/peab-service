<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$type_id = $_POST['type_id'];


$sql = "SELECT * FROM tbl_product_type
WHERE type_id = '$type_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
// echo $sql;
?>
<form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการดำเนินการ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
    <input type="hidden" class="form-control" value="<?php echo $type_id ?>" id="type_id" name="type_id">
        <div class="row">
            <div class="col-6 mb-3">
                <label>รหัสประเภท</label>
                <input type="text" class="form-control" value="<?php echo $row['type_code'] ?>" id="type_code" name="type_code">
            </div>

            <div class="col-6 mb-3">
                <label>ชื่อประเภท</label>
                <input type="text" class="form-control" value="<?php echo $row['type_name'] ?>" id="type_name" name="type_name">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Update()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

    });



    function Update() {

        var type_code = $('#type_code').val();
        var type_name = $('#type_name').val();


        var formData = new FormData($("#form-add_spare")[0]);

        if (type_code == "" || type_name == "") {
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
                url: 'ajax/product_type/Update.php',
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
                        GetTable();
                    } else if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'จำนวนอะไหล่ไม่พอ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }
</script>
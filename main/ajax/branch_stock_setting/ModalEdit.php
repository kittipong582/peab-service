<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];

$branch_id = $_POST['branch_id'];
$spare_part_id = $_POST['spare_part_id'];

$sql_b = "SELECT a.branch_id,c.branch_name,a.spare_part_id,a.default_quantity,b.spare_part_code,b.spare_part_name,b.spare_part_unit 
FROM tbl_branch_stock_setting a 
LEFT JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id
LEFT JOIN tbl_branch c ON a.branch_id = c.branch_id
WHERE a.branch_id = '$branch_id' AND a.spare_part_id = '$spare_part_id';";
$rs_b = mysqli_query($connect_db, $sql_b);
$row_c = mysqli_fetch_assoc($rs_b);
?>

<div class="modal-header">
    <h3>แก้ไขรายการตั้งค่าอะไหล่เริ่มต้น</h3>
</div>
<div class="col-lg-12">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
                    <div class="col-lg-12">
                        <form id="form-edit" method="POST" enctype="multipart/form-data">
                            <div class="col-lg-12 col-xs-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-3 col-xs-3 col-sm-3">
                                            <div class="form-group">
                                                <label>ทีม</label>
                                                <input type="hidden" id="branch_id_new" name="branch_id_new" value="<?php echo $row_c['branch_id'] ?>">
                                                <input type="text" id="branch_name" class="form-control" placeholder="" autocomplete="off" value="<?php echo $row_c['branch_name'] ?>" readonly>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-mb-6 col-xs-6 col-sm-6 text-center"><label>รายการอะไหล่</label></div>
                                        <div class="col-md-2 col-xs-2 col-sm-2 text-center"><label>หน่วย</label></div>
                                        <div class="col-mb-4 col-xs-4 col-sm-4 text-center"><label>จำนวนเริ่มต้น</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-mb-6 col-xs-6 col-sm-6">
                                            <div class="form-group">
                                                <input type="hidden" id="spare_part_id_new" name="spare_part_id_new" value="<?php echo $row_c['spare_part_id'] ?>">
                                                <input type="text" class="form-control" placeholder="" autocomplete="off" value="<?php echo $row_c['spare_part_code'] ?> - <?php echo $row_c['spare_part_name'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-2 col-sm-2">
                                            <div class="form-group">
                                                <input type="text" id="unit" name="unit" class="form-control" placeholder="" autocomplete="off" value="<?php echo $row_c['spare_part_unit'] ?> " readonly>
                                            </div>
                                        </div>

                                        <div class="col-mb-4 col-xs-4 col-sm-4">
                                            <!-- <label>จำนวน</label> -->
                                            <div class="form-group">
                                                <input type="text" id="quantity_new" name="quantity_new" class="form-control" placeholder="" value="<?php echo $row_c['default_quantity'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
</div>

<script>
    $(".select2").select2({
        width: "100%"
    });

    function Update() {
        var quantity = $('#quantity_new').val();

        if (quantity == "") {
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
            let myForm = document.getElementById('form-edit');
            let formData = new FormData(myForm);
            $.ajax({
                type: 'POST',
                url: 'ajax/branch_stock_setting/Update.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
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
                            GetTable();
                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                    }

                }
            })
        });
    }

</script>
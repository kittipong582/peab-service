<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$job_id = $_POST['job_id'];

$sql = "SELECT * FROM tbl_job WHERE job_id = '$job_id' ;";
$rs  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($rs);

$customer_branch_id = $row['customer_branch_id'];

$user_id = $_SESSION['user_id'];

$sql_user = "SELECT * FROM tbl_user WHERE user_id = '$user_id' ;";
$rs_user  = mysqli_query($connect_db, $sql_user);
$row_user = mysqli_fetch_array($rs_user);

$branch_id = $row_user['branch_id'];



?>
<style>
.select2-dropdown {
    z-index: 9999999;
}
</style>
<form action="" method="post" id="form_overhaul" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>เครื่องทดแทน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <input id="customer_branch_id" name="customer_branch_id" value="<?php echo $customer_branch_id ?>"
                type="hidden">

            <div class="col-12">
                <div class="form-group">
                    <label>เครื่องทดแทน</label>
                    <select class="form-control select2" id="overhaul" name="overhaul" data-width="100%">
                        <option value="x" selected>กรุณาเลือก </option>

                        <?php 
                                                        
                        $sql_oh = "SELECT a.overhaul_id,b.brand_name,c.model_name FROM tbl_overhaul a
                        LEFT JOIN tbl_product_brand b ON a.brand_id = b.brand_id
                        LEFT JOIN tbl_product_model c ON a.model_id = c.model_id
                        WHERE a.current_branch_id = '$branch_id' AND a.current_customer_branch_id IS NULL ;";
                        // echo $sql_oh;
                        $rs_oh = mysqli_query($connect_db, $sql_oh);

                        while($row_oh = mysqli_fetch_assoc($rs_oh)){
                            
                                                        
                        ?>

                        <option value="<?php echo $row_oh['overhaul_id'] ?>">
                            [<?php echo $row_oh['brand_name'] ?>] <?php echo $row_oh['model_name'] ?></option>


                        <?php } ?>

                    </select>
                </div>
            </div>


        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
        <button class="btn btn-success btn-sm" type="button" id="submit" onclick="Submit_add_overhaul()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
$(".select2").select2({});

$('.date').datepicker({
    // startView: 0,
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    format: "dd/mm/yyyy",

})

function Submit_add_overhaul() {

    var job_id = $('#job_id').val();
    var overhaul = $('#overhaul').val();
    var formData = new FormData($("#form_overhaul")[0]);

    if (overhaul == "x") {
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
            url: 'ajax/mywork/overhaul/add_overhaul.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.result == 1) {
                    $('#modal').modal('hide');
                    swal({
                        title: "ดำเนินการสำเร็จ!",
                        text: "ทำการบันทึกรายการ เรียบร้อย",
                        type: "success",
                    }, function() {
                        Getdata();
                    });
                }
                if (data.result == 0) {
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        text: "บันทึกผิดพลาด",
                        type: "error",
                    });
                }
            }

        })
    });
}
</script>
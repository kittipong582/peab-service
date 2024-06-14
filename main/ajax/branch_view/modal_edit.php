<?php 
 session_start(); 
 include("../../../config/main_function.php");
 $secure = "LM=VjfQ{6rsm&/h`";
 $connection = connectDB($secure);

 $contact_id = $_POST['contact_id'];

    $sql_contact = "SELECT * FROM tbl_customer_contact WHERE contact_id = '$contact_id';";
    $result_contact  = mysqli_query($connection, $sql_contact);
    $row_contact = mysqli_fetch_array($result_contact);

    $chk = "";
    if($row_contact['main_contact_status'] == "1"){
        $chk = "checked" ;
    }

?>

<style>
.hide {
    display: none;
}
</style>

<div class="modal-header">
    <h3>แก้ไขรายชื่อผู้ติดต่อ</h3>
</div>
<form id="frm_detail" method="POST" enctype="multipart/form-data">
    <div class="modal-body">

    <input type="hidden" id="customer_branch_id" name="contact_id" value="<?php echo $contact_id ?>">
    <input type="hidden" id="customer_branch_id" name="customer_branch_id" value="<?php echo $customer_branch_id ?>">

        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="row">

                <div class="col-md-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                        <label>ชื่อ</label>
                        <font color="red">**</font>
                        <input type="text" id="name" name="name" class="form-control" placeholder="" value="<?php echo $row_contact['contact_name'] ?>" autocomplete="off">
                    </div>
                </div>

                <div class="col-md-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                        <label>ตำแหน่ง</label>
                        <!-- <font color="red">**</font> -->
                        <input type="text" id="position" name="position" class="form-control" placeholder=""
                            autocomplete="off" value="<?php echo $row_contact['contact_position'] ?>">
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-4 col-xs-4 col-sm-4">
                    <div class="form-group">
                        <label>เบอร์โทรศัพท์</label>
                        <font color="red">**</font>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder=""
                            autocomplete="off" value="<?php echo $row_contact['contact_phone'] ?>">
                    </div>
                </div>

                <div class="col-md-4 col-xs-4 col-sm-4">
                    <div class="form-group">
                        <label>E-mail</label>
                        <!-- <font color="red">**</font> -->
                        <input type="text" id="email" name="email" class="form-control" placeholder=""
                            autocomplete="off" value="<?php echo $row_contact['contact_email'] ?>">
                    </div>
                </div>

                <div class="col-md-4 col-xs-4 col-sm-4">
                    <div class="form-group">
                        <label>Line ID</label>
                        <!-- <font color="red">**</font> -->
                        <input type="text" id="contact_line_id" name="contact_line_id" class="form-control" placeholder=""
                            autocomplete="off" value="<?php echo $row_contact['contact_line_id'] ?>">
                    </div>
                </div>



            </div>

            <div class="row">
                <div class="col-md-3 col-xs-6 col-sm-6">
                    <label> <input type="checkbox" class="i-checks" id="chk" name="chk" value="1" <?php echo $chk ?>> ผู้ติดต่อหลัก
                    </label>
                </div>
            </div>

        </div>




    </div>
</form>

<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success btn-md" onclick="submit_edit();">ยืนยัน </button>
</div>


<script>
$(document).ready(function() {

});

$(".select2").select2({
    width: "100%"
});

function submit_edit() {

    var name = $('#name').val();
    var phone = $('#phone').val();
    var position = $('#position').val();
    var email = $('#email').val();
    var contact_id = $('#contact_id').val();

    var chk = $('#chk').val();
    
    // let values = $("input[name='chk']:checked").map(function() {
    //     return $(this).val();
    // }).get();


    var formData = new FormData($("#frm_detail")[0]);

    if (name == "") {
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
            url: 'ajax/branch_view/edit.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.result == 0) {
                    swal({
                        title: 'ผิดพลาด!',
                        text: 'กรุณาลองใหม่อีกครั้ง',
                        type: 'warning'
                    });
                    return false;
                }
                if (data.result == 1) {
                    $('#modal').modal('hide');
                    swal({
                        title: "ดำเนินการสำเร็จ!",
                        text: "ทำการบันทึกรายการ เรียบร้อย",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                    });
                    location.reload();
                }
            }
        })
    });
}
</script>
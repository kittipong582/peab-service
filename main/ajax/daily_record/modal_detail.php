<?php 
 session_start(); 
 include("../../../config/main_function.php");
 $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$daily_id = $_POST['daily_id'];

$sql = "SELECT a.*,b.fullname FROM tbl_customer_daily_record a LEFT JOIN tbl_user b ON a.create_user_id = b.user_id WHERE a.daily_id = '$daily_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>

<style>
.hide {
    display: none;
}
</style>

<div class="modal-header">
    <h3>รายละเอียดบันทึก</h3>
</div>
<form id="frm_record" method="POST" enctype="multipart/form-data">
    <div class="modal-body">

        <input type="hidden" id="daily_id" name="daily_id" value="<?php echo $daily_id ?>">


        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="row">

                <div class="col-md-6 col-xs-6 col-sm-6">
                    <div class="form-group">
                        <h4><label>รายละเอียดการบันทึก : <?php echo $row['record_title'] ?></label></h4>
                        <?php echo $row['record_text'] ?>
                    </div>
                </div>




            </div>

            <div class="row">

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <?php if($row['record_file'] != ""){ ?>
                    <a href='upload/<?php echo $row['record_file']?>' target="_blank" class="btn btn-primary btn-md"><i
                            class="fa fa-book"></i> เอกสารประกอบการบันทึก</a>
                    <?php } ?>
                </div>
            </div>


        </div>




    </div>
</form>

<div class="modal-footer">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="row">

            <div class="col-md-11 col-xs-12 col-sm-4">
            <label>ผู้บันทึก : <?php echo $row['fullname']?></label> 
            <label>วันที่ : <?php echo date('d-m-Y H:i',strtotime($row['create_datetime'])); ?></label>
            </div>

            <div class="col-md-1 col-xs-12 col-sm-4">
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">ปิด</button>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function() {

});

$(".select2").select2({
    width: "100%"
});

$('#summernote').summernote({
    toolbar: false,
});

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader2 = new FileReader();

        reader2.onload = function(e) {
            $('#file_name').attr('src', e.target.result);
        }

        reader2.readAsDataURL(input.files[0]);
    }
}
</script>
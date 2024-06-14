<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$payment_id = $_POST['payment_id'];


?>
<form action="" method="post" id="form-edit_payment" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รูปการจ่ายเงิน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
    
        <div class="row">
            
            <div class="col-12 mb-3">
                <label>รูปภาพ</label>
                <div class="row">

                    <?php $sql_img = "SELECT * FROM tbl_job_payment_img WHERE payment_id = '$payment_id'";
                    $result_img  = mysqli_query($connect_db, $sql_img);
                    while ($row_img = mysqli_fetch_array($result_img)) { ?>
                        <div class="col-4">
                            <label>
                                <a  target="_blank" href="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row_img['img_id']; ?>" data-lity>
                                    <img id="blah" src="https://peabery-upload.s3.ap-southeast-1.amazonaws.com/<?php echo $row_img['img_id']; ?>" width="250" height="350" />
                                </a>
                            </label>
                        </div>
                    <?php } ?>
                </div>
            </div>

          

        </div>
    </div>
    <div class="modal-footer">
        <!-- <button class="btn btn-primary px-5" type="button" id="submit" onclick="Update_pay()">บันทึก</button> -->
    </div>
</form>

<?php include('import_script.php'); ?>

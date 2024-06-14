<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$image_id = $_POST['image_id'];

$sql = "SELECT * FROM tbl_job_process_image WHERE image_id = '$image_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);
?>
<form action="" method="post" id="form-des_img" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">
            <input type="hidden" id="image_id" name="image_id" value="<?php echo $image_id ?>">

            <div class=" col-md-12 mb-3  text-center">
                <div class="form-group text-center">
                    <a target="_blank" href="upload/repair_image/<?php echo $row['image_path']; ?>" data-lity>
                        <img class="mb-3" loading="lazy" src="upload/<?php echo ($row['image_path'] == "") ? "No-Image.png" : "repair_image/" . $row['image_path']; ?>" width="200px" height="200px" />
                    </a>
                </div>
            </div>
            <div class=" col-md-12 mb-3  text-center">

                <input type="text" class="form-control" id="des" name="des" value="<?php echo $row['description'] ?>">
            </div>


        </div>

    </div>
    <div class="modal-footer">
        <button class="btn btn-primary btn-sm" type="button" id="submit" onclick="Submit_des()">บันทึก</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>

    </div>
</form>
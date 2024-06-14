<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
$record_id = mysqli_real_escape_string($connection, $_POST['record_id']);

$sql = "SELECT * FROM tbl_audit_record_img a WHERE a.record_id = '$record_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);
?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 col-sm-12" style="text-align:center;">
            <div class="form-group">
                <div class="BroweForFile">
                    <label><strong>รูปโล้โก บริษัท</strong></label>
                    <div id="show_image"><label for="upload_file">
                            <a><img id="pic"
                                    src="<?php echo ($row['file_part'] != "") ? "image/company_logo/" . $row['file_part'] : "upload/No-Image.png"; ?>"
                                    width="200px" height="200px" /></a></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
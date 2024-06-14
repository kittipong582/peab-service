<?php
include ("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$record_id = mysqli_real_escape_string($connect_db, $_POST['record_id']);


$sql = "SELECT * FROM tbl_qc_record_img WHERE record_id = '$record_id' ORDER BY list_order ASC";
$res = mysqli_query($connect_db, $sql);
$num_row = mysqli_num_rows($res);


$sql_detail = "SELECT detail_checklist FROM tbl_qc_record WHERE record_id = '$record_id'";
$res_detail = mysqli_query($connect_db, $sql_detail) or die($connect_db->error);
$row_detail = mysqli_fetch_assoc($res_detail); 
?>

<div class="modal-header">
    <h4>หมายเหตุ : <?php echo $row_detail['detail_checklist'] ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <?php if ($num_row > 0) { ?>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                <div class="col-12 mb-3">
                    <img id="blah<?php echo $i; ?>"
                        src="<?php echo ($row['file_part'] != '') ? 'https://peabery-upload.s3.ap-southeast-1.amazonaws.com/' . $row['file_part'] : 'upload/no-img.png' ?>"
                        width="100%" />
                </div>
            <?php } ?>
        </div>
        <?php
    } else {
        echo "ไม่มีรูปภาพ";
    }
    ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
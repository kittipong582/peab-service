<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];
$topic_id = mysqli_real_escape_string($connection, $_POST['topic_id']);

$sql = "SELECT * FROM tbl_audit_topic WHERE   active_status = 1";
$result  = mysqli_query($connection, $sql);

?>
<div class="row" id="row_topic_<?php echo $i ?>">
    <div class="col-1 mb-3">
        <button type="button" class="btn btn-danger btn-block" name="button" onclick="desty_audit('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
    </div>
    <div class="col-9 mb-3">
        <select class="form-control select2 mb-3" id="topic<?php echo $i ?>" name="topic[]">
            <option value="">กรุณาเลือกหัวข้อ</option>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <option value="<?php echo $row['topic_id'] ?>"><?php echo $row['topic_datail'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>

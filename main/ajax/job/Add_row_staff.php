<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];
$branch_care_id  = $_POST['branch_care_id'];

$sql = "SELECT a.*,b.branch_name FROM tbl_user a
LEFT JOIN tbl_branch b ON b.branch_id = a.branch_id 
WHERE a.active_status = 1 ORDER BY branch_name";
$result  = mysqli_query($connection, $sql);

?>
<div class="row" id="row_staff_<?php echo $i ?>">
    <div class="col-1 mb-3">
        <button type="button" class="btn btn-danger btn-block" name="button" onclick="desty_staff('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
    </div>
    <div class="col-9 mb-3">
        <select class="form-control select2 mb-3" id="staff_<?php echo $i ?>" name="staff[]">
            <option value="">กรุณาเลือกช่าง</option>
            <?php while ($row = mysqli_fetch_array($result)) { ?>

                <option value="<?php echo $row['user_id'] ?>"><?php echo $row['branch_name']." - ".$row['fullname'] ?></option>
            <?php } ?>
        </select>
    </div>
</div>
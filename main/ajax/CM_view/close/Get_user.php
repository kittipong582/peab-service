<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$branch_id = $_POST['branch_id'];


?>


<label>ช่างผู้รับผิดชอบ</label>
<font color="red">**</font>
<select class="form-control select2 mb-3" style="width: 100%;" name="responsible_user_id[]" id="responsible_user_id">
    <?php $sql = "SELECT * FROM tbl_user WHERE branch_id = '$branch_id'  AND active_status = 1";
    $result = mysqli_query($connect_db, $sql); ?>

    <option value="">กรุณาเลือกช่าง</option>
    <?php while ($row = mysqli_fetch_array($result)) {
        ?>
        <option value="<?php echo $row['user_id'] ?>">
            <?php echo $row['fullname'] ?>
        </option>
    <?php } ?>
</select>
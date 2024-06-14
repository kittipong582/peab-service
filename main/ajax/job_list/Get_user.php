<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$team_id = $_POST['team_id'];

?>



<label>ผู้ใช้</label>
<select class="form-control select2 mb-3" style="width: 100%;" name="user_point" id="user_point">
    <option value="x">ทั้งหมด</option>
    <?php $sql = "SELECT * FROM tbl_user WHERE  branch_id = '$team_id' and active_status = 1";
    $result  = mysqli_query($connect_db, $sql);
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <option value="<?php echo $row['user_id'] ?>"><?php echo $row['fullname'] ?></option>
    <?php  } ?>
</select>
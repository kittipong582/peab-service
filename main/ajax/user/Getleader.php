<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_level = $_POST['user_level'];
$branch_id = $_POST['branch_id'];

if ($user_level == 1) { ?>

    <label>หัวหน้าทีม</label>
    <font color="red">**</font>
    <select class="form-control select2 mb-3" style="width: 100%;" name="leader_user_id" id="leader_user_id">
        <option value="">กรุณาเลือกหัวหน้าทีม</option>
        <?php $sql = "SELECT * FROM tbl_user WHERE user_level = 2 and branch_id = '$branch_id'";
        $result  = mysqli_query($connect_db, $sql);

        while ($row = mysqli_fetch_array($result)) {
        ?>
            <option value="<?php echo $row['user_id'] ?>"><?php echo $row['fullname'] ?></option>
        <?php  } ?>
    </select>
<?php } ?>
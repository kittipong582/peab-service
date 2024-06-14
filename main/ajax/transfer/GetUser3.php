<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$user_id = $_SESSION['user_id'];
$branch_id = $_POST['branch_id'];

$condition = "";
if ($branch_id != "x") {

    $condition .= "AND branch_id = '$branch_id'";
}

?>

<div class="form-group">
    <label>ผู้รับ</label>
    <font color="red">**</font>
    <select class="form-control select2" id="user2" name="user2" data-width="100%">
        <option value="x" selected>กรุณาเลือก </option>

        <?php

        $sql_u = "SELECT user_id,fullname  FROM tbl_user 
        WHERE user_id != '$user_id' and active_status = 1 $condition ;";

        $rs_u = mysqli_query($connection, $sql_u);
        while ($row_u = mysqli_fetch_assoc($rs_u)) {

        ?>

            <option value="<?php echo $row_u['user_id'] ?>">
                <?php echo $row_u['fullname'] ?></option>


        <?php } ?>

    </select>
</div>
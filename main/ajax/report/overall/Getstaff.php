<?php
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$team = $_POST['team'];

$condition = "";
if ($team != "x") {

    $condition .= "WHERE branch_id = '$team'";
}

?>

<div class="form-group">
    <label>ช่าง</label>
    <select class="form-control select2" id="staff" name="staff" data-width="100%">
        <option value="x" selected>ทั้งหมด </option>

        <?php

        $sql_u = "SELECT user_id,fullname  FROM tbl_user 
        $condition ;";

        $rs_u = mysqli_query($connection, $sql_u);
        while ($row_u = mysqli_fetch_assoc($rs_u)) {

        ?>

            <option value="<?php echo $row_u['user_id'] ?>">
                <?php echo $row_u['fullname'] ?></option>


        <?php } ?>

    </select>
</div>
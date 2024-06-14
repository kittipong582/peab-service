<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$user_level = $_SESSION['user_level'];
$user_id = $_SESSION['user_id'];
$branch_id = $_POST['branch_id'];

$condition = "";
$condition1 = "";
if ($branch_id != "x") {

    $condition .= "AND branch_id = '$branch_id'";
}

if ($user_level == 1) {
    $condition1 .= "AND user_id = '$user_id'";
}
?>

<div class="form-group">
    <label>ผู้โอน</label>
    <font color="red">**</font>
    <select class="form-control select2" id="user" name="user" data-width="100%" onchange="GetDetail(this.value)">
        <option value="x" selected>กรุณาเลือก </option>

        <?php
        if ($branch_id != "x") {
            $sql_u = "SELECT user_id,fullname  FROM tbl_user 
        WHERE active_status = 1 $condition1 $condition ;";

            $rs_u = mysqli_query($connection, $sql_u);
            while ($row_u = mysqli_fetch_assoc($rs_u)) {

        ?>

                <option value="<?php echo $row_u['user_id'] ?>">
                    <?php echo $row_u['fullname'] ?></option>


        <?php }
        } ?>

    </select>
</div>
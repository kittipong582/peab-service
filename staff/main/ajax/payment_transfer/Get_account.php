<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$account_type = $_POST['account_type'];
$sql_acc = "SELECT * FROM tbl_account WHERE account_type = '$account_type'";
$rs_acc  = mysqli_query($connect_db, $sql_acc);

?>


<label for="">บัญชี</label><br>
<select class="form-control select2" id="account_id" name="account_id" data-width="100%">
    <option value="">กรุณาเลือกบัญชี</option>
    <?php while ($row_acc = mysqli_fetch_array($rs_acc)) { ?>
        <option value="<?php echo $row_acc['account_id'] ?>"><?php echo $row_acc['account_no'] . " - " . $row_acc['account_name'] . " ( " . $row_acc['bank_branch_name'] . " )" ?></option>
    <?php  } ?>
</select>
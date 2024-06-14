<?php

include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_id = mysqli_real_escape_string($connect_db, $_POST['customer_id']);

$sql_branch = "SELECT * FROM tbl_customer_branch WHERE active_status = '1' AND customer_id = '$customer_id'";
$res_branch = mysqli_query($connect_db, $sql_branch);

?>
<option value="" selected disabled></option>
<?php while ($row_branch = mysqli_fetch_assoc($res_branch)) { ?>
    <option value="<?php echo $row_branch['customer_branch_id']; ?>"><?php echo $row_branch['branch_name']; ?></option>
<?php } ?>
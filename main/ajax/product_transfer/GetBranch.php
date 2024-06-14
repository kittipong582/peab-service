<?php
include("../../../config/main_function.php");
session_start();
$product_id = $_POST['product_id'];
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_text = $_POST['search_text'];
?>

<label>
    สาขา (ผู้รับ)
</label>
<font color="red">**</font>

<select class="form-control select2 mb-3 " style="width: 100%;" name="to_branch_id" id="to_branch_id">
    <option value="">กรุณาเลือกสาขา</option>
    <?php $sql_team = "SELECT * FROM tbl_customer_branch WHERE NOT customer_branch_id = '$branch_id' and active_status = '1' AND (branch_code LIKE '%$search_text%' OR branch_name LIKE '%$search_text%')";
    $result_team  = mysqli_query($connect_db, $sql_team);
    // echo $sql_team;
    while ($row_team = mysqli_fetch_array($result_team)) { ?>

        <option value="<?php echo $row_team['customer_branch_id'] ?>"><?php echo $row_team['branch_code'] . " - " . $row_team['branch_name'] ?></option>
    <?php } ?>
</select>
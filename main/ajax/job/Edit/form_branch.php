<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_id = $_POST['customer_id'];

$sql_customer = "SELECT customer_branch_id,branch_name,branch_code FROM tbl_customer_branch WHERE customer_id = '$customer_id' ORDER BY branch_code";
$result_customer  = mysqli_query($connect_db, $sql_customer);
?>


<label>รายการสาขา</label><br>
<select id="search_type" name="search_type" style="width: 100%;" class="form-control select2" onchange="Get_customer_branch(this.value);">

    <option value="">กรุณาเลือกสาขา</option>
    <?php while ($row_customer = mysqli_fetch_array($result_customer)) { ?>
        <option value="<?php echo $row_customer['customer_branch_id'] ?>"><?php echo $row_customer['branch_code']." - ".$row_customer['branch_name'] ?></option>
    <?php } ?>
   


</select>
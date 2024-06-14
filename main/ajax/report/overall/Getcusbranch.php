<?php
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$customer_id = $_POST['customer_id'];

$condition = "";
if($customer_id != "x"){

    $condition .="WHERE customer_id = '$customer_id'";
}

?>

<div class="form-group">
    <label>สาขา</label>
    <select class="form-control select2" id="cus_branch" name="cus_branch" data-width="100%" onchange="Getteam(this.value)">
        <option value="x" selected>ทั้งหมด </option>

        <?php 
                                                        
        $sql_cb = "SELECT customer_branch_id,branch_name  FROM tbl_customer_branch 
        $condition ;";

        $rs_cb = mysqli_query($connection, $sql_cb);
        while($row_cb = mysqli_fetch_assoc($rs_cb)){
                                                                
        ?>

        <option value="<?php echo $row_cb['customer_branch_id'] ?>">
            <?php echo $row_cb['branch_name'] ?></option>


        <?php } ?>

    </select>
</div>
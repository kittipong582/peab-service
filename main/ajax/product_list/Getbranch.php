<?php
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$customer_id = $_POST['customer_id'];

$condition = "";
if($branch_id != "x"){

    $condition .="AND customer_id = '$customer_id'";
}

?>

<div class="form-group">
    <label>สาขา</label>
    <select class="form-control select2" id="branch_product" name="branch_product" data-width="100%" >
        <option value="x" selected>กรุณาเลือกช่าง </option>

        <?php 
                                                        
        $sql_u = "SELECT branch_name,branch_code  FROM tbl_user 
        WHERE active_status = 1 $condition ;";

        $rs_u = mysqli_query($connection, $sql_u);
        while($row_u = mysqli_fetch_assoc($rs_u)){
                                                                
        ?>

        <option value="<?php echo $row_u['customer_branch_id'] ?>">
            <?php echo " [ ".$row_u['branch_code']." ] ".$row_u['branch_name'] ?></option>


        <?php } ?>

    </select>
</div>
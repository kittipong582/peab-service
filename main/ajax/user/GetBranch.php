<?php
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$zone_id = $_POST['zone_id'];

$condition = "";
if($zone_id != "x"){

    $condition .="AND zone_id = '$zone_id'";
}

?>

<div class="form-group">
    <label>ทีม</label>
    <select class="form-control select2" id="branch" name="branch" data-width="100%">
        <option value="x" selected>ทั้งหมด </option>

        <?php 
                                                        
        $sql_b = "SELECT branch_id,branch_name FROM tbl_branch WHERE active_status = 1 $condition ;";
        $rs_b = mysqli_query($connection, $sql_b);
        while($row_b = mysqli_fetch_assoc($rs_b)){
                                                        
        ?>

        <option value="<?php echo $row_b['branch_id'] ?>">
            <?php echo $row_b['branch_name'] ?></option>


        <?php } ?>

    </select>
</div>
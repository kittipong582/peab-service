<?php
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$cus_branch = $_POST['cus_branch'];

$condition = "";
if($cus_branch != "x"){
    $condition .="AND c.customer_branch_id = '$cus_branch'";
}

$condition2 = "";
if($customer != "x"){
    $condition2 .="AND d.customer_id = '$customer'";
}

// $sql_sj = "SELECT branch_customer_id FROM tbl_customer_branch WHERE active_status = 1 $condition ORDER BY job_type ASC;";
// $rs_sj = mysqli_query($connection, $sql_sj);
// $row_sj = mysqli_fetch_assoc($rs_sj);

?>

<div class="form-group">
    <label>ทีมงาน</label>
    <select class="form-control select2" id="team" name="team" data-width="100%" onchange="Getstaff(this.value)">
        <option value="x" selected>ทั้งหมด </option>

        <?php 
                                                        
        $sql_b = "SELECT DISTINCT a.branch_id,a.branch_name FROM tbl_branch a  
        JOIN tbl_job b ON a.branch_id = b.care_branch_id 
        JOIN tbl_customer_branch c ON b.customer_branch_id = c.customer_branch_id
        WHERE a.branch_id IS NOT NULL $condition $condition2 ORDER BY job_type ASC;";

        $rs_b = mysqli_query($connection, $sql_b);
        while($row_b = mysqli_fetch_assoc($rs_b)){
                                                                
        ?>

        <option value="<?php echo $row_b['branch_id'] ?>">
            <?php echo $row_b['branch_name'] ?></option>


        <?php } ?>

    </select>
</div>
<?php
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$job_type = $_POST['job_type'];

$condition = "";
if($job_type != "x"){

    $condition .="AND job_type = '$job_type'";
}

?>

<div class="form-group">
    <label>ประเภทงานย่อย</label>
    <select class="form-control select2" id="subjob_type" name="subjob_type" data-width="100%">
        <option value="x" selected>ทั้งหมด </option>

        <?php 
                                                        
        $sql_sj = "SELECT sub_job_type_id,sub_type_name FROM tbl_sub_job_type 
        WHERE active_status = 1 $condition ORDER BY job_type ASC;";

        $rs_sj = mysqli_query($connection, $sql_sj);
        while($row_sj = mysqli_fetch_assoc($rs_sj)){
                                                                
        ?>

        <option value="<?php echo $row_sj['sub_job_type_id'] ?>">
            <?php echo $row_sj['sub_type_name'] ?></option>


        <?php } ?>

    </select>
</div>
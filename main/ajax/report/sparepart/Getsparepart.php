<?php
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$spare_type_id = $_POST['spare_type_id'];

$condition = "";
if($spare_type_id != "x"){
    $condition .="AND spare_type_id = '$spare_type_id'";
}

?>

<div class="form-group">
    <label>ชนิดอะไหล่</label>
    <select class="form-control select2" id="spare_part" name="spare_part" data-width="100%">
        <option value="x" selected>ทั้งหมด </option>

        <?php 
                                                        
        $sql_sp = "SELECT spare_part_id,spare_part_name FROM tbl_spare_part WHERE active_status = 1 $condition ;";
        $rs_sp = mysqli_query($connection, $sql_sp);
        while($row_sp = mysqli_fetch_assoc($rs_sp)){
                                                        
        ?>
        <option value="<?php echo $row_sp['spare_part_id'] ?>">
            <?php echo $row_sp['spare_part_name'] ?></option>


        <?php } ?>

    </select>
</div>
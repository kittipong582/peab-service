<?php

include('../../../config/main_function.php');

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$province_id = $_POST['province_id'];

$i = 1;
$sql_type = "SELECT * FROM tbl_amphoe WHERE ref_province = '$province_id'";
$rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
while ($row_type = mysqli_fetch_assoc($rs_type)) {

    $amphoe_id = $row_type['amphoe_id'];

    $sql_check = "SELECT * FROM tbl_branch_care a 
    LEFT JOIN tbl_branch b ON a.branch_id = b.branch_id
    WHERE a.amphoe_id = '$amphoe_id'";
    $rs_check = mysqli_query($connection, $sql_check) or die($connection->error);
    $row_check = mysqli_fetch_assoc($rs_check);
?>


    <div class="col-4" style="margin-bottom: 10px;">
        <label>แขวง/อำเภอ</label><br>
        <input type="text" name="name_amphoe" class="form-control" id="name_amphoe" readonly placeholder="" value="<?php echo $row_type['amphoe_name_th'] ?>" autocomplete="off">
        <input type="hidden" name="amphoe_id" class="form-control" id="amphoe_id" placeholder="" value="<?php echo $row_type['amphoe_id'] ?>" autocomplete="off">

    </div>
    <div class="col-3" style="margin-bottom: 10px;">
        <label>สาขา</label>
        <select class="form-control select2" name="branch" id="branch" onchange="save_amphoe1(this.value,<?php echo $row_type['amphoe_id'] ?>)">

            <option value="all">ทั้งหมด</option>
            <?php $sql_branch = "SELECT * FROM tbl_branch ORDER BY active_status = 1";
            $rs_branch = mysqli_query($connection, $sql_branch) or die($connection->error);
            while ($row_branch = mysqli_fetch_assoc($rs_branch)) { ?>

                <option value="<?php echo $row_branch['branch_id'] ?>" <?php if ($row_branch['branch_id'] == $row_check['branch_id']) {
                                                                            echo 'SELECTED';
                                                                        } ?>><?php echo $row_branch['branch_name'] ?></option>

            <?php } ?>


        </select>

    </div>
    <div class="col-2" style="margin-bottom: 10px;">

    </div>
    <div class="col-3" style="margin-bottom: 10px;">


    </div>



<?php $i++;
} ?>
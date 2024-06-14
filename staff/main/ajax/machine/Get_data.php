<?php
include ("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$model_id = mysqli_real_escape_string($connection, $_POST['model_id']);
$condition = "";
if ($model_id != "") {
    $condition .= "WHERE model_id = '$model_id'";
} else {

}

$sql_manual = "SELECT * FROM tbl_spare_part_manual  $condition LIMIT 10";
$rs_manual = mysqli_query($connection, $sql_manual) or die($connection->error);




?>
<style>
    .img-size {
        width: 200px;
        height: 250px;
        object-fit: contain;
     
    }
</style>
<?php while ($row_manual = mysqli_fetch_assoc($rs_manual)) { ?>
    <div class="ibox mb-1 d-block border">
        <div class="ibox-content">
            <?php
            $sql_model = "SELECT * FROM tbl_product_model WHERE model_id ='{$row_manual['model_id']}'";
            $res_model = mysqli_query($connection, $sql_model);
            $row_model = mysqli_fetch_assoc($res_model);

            ?>
            <div>
                <h3><?php echo $row_model['model_name'] ?></h3>
            </div>
            <div class="d-flex align-items-center m-0 p-1">
                <div class="p-2" style="width:250px">
                    <img alt="" class="border border-dark img-size"
                        src="<?php echo ($row_model['file_name'] != '') ? 'https://peabery-upload.s3.ap-southeast-1.amazonaws.com/' . $row_model['file_name'] : 'upload/No-Image.png' ?>">
                </div>

                <div class="p-2 d-flex flex-column justify-content-flex-end">
                    <a href="manual_machine.php?manual_id=<?php echo $row_manual['manual_id']; ?>&model=<?php echo $row_model['model_id'] ?>"
                        class="btn btn-warning mb-2 text-left"><i class="fa fa-gear"></i> คู่มือ</a>

                    <a href="manual_basic.php?manual_id=<?php echo $row_manual['manual_id']; ?>&model=<?php echo $row_model['model_id'] ?>"
                        class=" mb-2 btn btn-warning text-left"><i class="fa fa-gear"></i> การแก้ไขเบื้องต้น</a>

                    <a href="spare_manual.php?manual_id=<?php echo $row_manual['manual_id']; ?>&model=<?php echo $row_model['model_id'] ?>"
                        class="btn btn-warning text-left"><i class="fa fa-gear"></i> จับคู่อาการเสียกับอะไหล่</a>

                </div>
            </div>
        </div>
    </div>
<?php } ?>
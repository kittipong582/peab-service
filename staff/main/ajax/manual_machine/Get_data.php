<?php
include ("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$manual_id = mysqli_real_escape_string($connection, $_POST['manual_id']);
$model = mysqli_real_escape_string($connection, $_POST['model']);

$sql_manual = "SELECT * FROM tbl_spare_part_manual WHERE model_id = '$model'";
$rs_manual = mysqli_query($connection, $sql_manual) or die($connection->error);

// $sql_manual_h = "SELECT * FROM tbl_spare_part_manual WHERE model_id = '$model_id'";
// $rs_manual_h = mysqli_query($connection, $sql_manual) or die($connection->error);
// $row_manual_h = mysqli_fetch_assoc($rs_manual_h);
?>
<style>
    .text-font{
        font-size: 24px;
        text-align: center;
    }
</style>

    <?php
    if (mysqli_num_rows($rs_manual) > 0) {
        while ($row_manual = mysqli_fetch_assoc($rs_manual)) {
            ?>

            <div class="ibox mb-1 d-block border">
                <div class="ibox-title">
                    <b>
                        <?php echo $row_manual['manual_name'] ?>
                    </b>
                    <br>
                </div>
                <div class="ibox-content">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <td><b>เหตุผล</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo $row_manual['remark'] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-3">
                        <div class="btn-group">
                            <a href="manual_machine_sub.php?manual_id=<?php echo $row_manual['manual_id']; ?>"
                                class="btn btn-white btn-sm">ดูเพิ่มเติม</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
    } else {
        echo '<br>';
        echo '<div class="text-font">ไม่พบข้อมูล</div>';

    }
    ?>
</div>
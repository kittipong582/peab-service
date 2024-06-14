<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$branch_id = $_POST['branch_id'];


?>

<label>ช่างผู้รับผิดชอบ</label>
<select class="form-control select2 mb-3" style="width: 100%;" name="send_qcoh_user" id="send_qcoh_user">

    <option value="">กรุณาเลือกช่าง</option>
    <?php $sql_user = "SELECT * FROM tbl_user WHERE branch_id = '$branch_id'";
    $result_user  = mysqli_query($connect_db, $sql_user);
    while ($row_user = mysqli_fetch_array($result_user)) {
    ?>
        <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row['send_qcoh_user'] == $row_user['user_id']) {
                                                                echo "SELECTED";
                                                            } ?>><?php echo $row_user['fullname'] ?></option>
    <?php  } ?>
</select>
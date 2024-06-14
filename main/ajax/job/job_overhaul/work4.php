<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$branch_id = $_POST['branch_id'];

$user_level = $_SESSION['user_level'];
$user_id = $_SESSION['user_id'];
?>


<div class="row">

    <div class="col-12">
        <label>เข้ารับเครื่อง</label>
    </div>
    <div class="col-4 mb-3">

        <label>วันที่นัดหมาย</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="get_oh_datetime" readonly name="get_oh_datetime" class="form-control datepicker" value="" autocomplete="off">
        </div>

    </div>
    <div class="col-4 mb-3 user_list" id="get_user_list">

        <label>ช่างผู้รับผิดชอบ</label>
        <?php if ($user_level == 1) { ?>

            <select class="form-control select2 mb-3" style="width: 100%;" name="get_oh_user" id="get_oh_user">
                <?php $sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id' and branch_id = '$branch_id'";
                $result  = mysqli_query($connect_db, $sql);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['fullname'] ?></option>
                <?php  } ?>
            </select>

        <?php } else { ?>

            <select class="form-control select2 mb-3" style="width: 100%;" name="get_oh_user" id="get_oh_user">
                <option value="">กรุณาเลือกช่าง</option>
                <?php $sql = "SELECT * FROM tbl_user WHERE branch_id = '$branch_id'";
                $result  = mysqli_query($connect_db, $sql);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['fullname'] ?></option>
                <?php  } ?>
            </select>


        <?php } ?>
    </div>
    <div class="col-4 mb-3">
    </div>

    <div class="col-12">
        <label>QC</label>
    </div>

    <div class="col-4 mb-3">

        <label>วันที่นัดหมาย</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="qc_oh_datetime" readonly name="qc_oh_datetime" class="form-control datepicker" value="" autocomplete="off">
        </div>

    </div>
    <div class="col-4 mb-3 user_list" id="qc_user_list">

        <label>ช่างผู้รับผิดชอบ</label>

        <?php if ($user_level == 1) { ?>

            <select class="form-control select2 mb-3" style="width: 100%;" name="qc_oh_user" id="qc_oh_user">
                <?php $sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id' and branch_id = '$branch_id'";
                $result  = mysqli_query($connect_db, $sql);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['fullname'] ?></option>
                <?php  } ?>
            </select>

        <?php } else { ?>

            <select class="form-control select2 mb-3" style="width: 100%;" name="qc_oh_user" id="qc_oh_user">
                <option value="">กรุณาเลือกช่าง</option>
                <?php $sql = "SELECT * FROM tbl_user WHERE branch_id = '$branch_id'";
                $result  = mysqli_query($connect_db, $sql);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['fullname'] ?></option>
                <?php  } ?>
            </select>


        <?php } ?>
    </div>
    <div class="col-4 mb-3">
    </div>

    <div class="col-12">
        <label>ส่งเครื่อง</label>
    </div>

    <div class="col-4 mb-3">

        <label>วันที่นัดหมาย</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="send_oh_datetime" readonly name="send_oh_datetime" class="form-control datepicker" value="" autocomplete="off">
        </div>

    </div>
    <div class="col-4 mb-3 user_list" id="send_user_list">

        <label>ช่างผู้รับผิดชอบ</label>

        <?php if ($user_level == 1) { ?>

            <select class="form-control select2 mb-3" style="width: 100%;" name="send_oh_user" id="send_oh_user">
                <?php $sql = "SELECT * FROM tbl_user WHERE user_id = '$user_id' and branch_id = '$branch_id'";
                $result  = mysqli_query($connect_db, $sql);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['fullname'] ?></option>
                <?php  } ?>
            </select>

        <?php } else { ?>

            <select class="form-control select2 mb-3" style="width: 100%;" name="send_oh_user" id="send_oh_user">
                <option value="">กรุณาเลือกช่าง</option>
                <?php $sql = "SELECT * FROM tbl_user WHERE  branch_id = '$branch_id'";
                $result  = mysqli_query($connect_db, $sql);
                while ($row = mysqli_fetch_array($result)) {
                ?>
                    <option value="<?php echo $row['user_id'] ?>"><?php echo $row['fullname'] ?></option>
                <?php  } ?>
            </select>


        <?php } ?>
    </div>
    <div class="col-4 mb-3">
    </div>


</div>
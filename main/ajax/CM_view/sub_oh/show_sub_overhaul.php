<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql = "SELECT * FROM tbl_job a 
LEFT JOIN tbl_customer_branch e ON a.customer_branch_id = e.customer_branch_id
LEFT JOIN tbl_customer f ON e.customer_id = f.customer_id
LEFT JOIN tbl_branch b ON e.branch_care_id = b.branch_id
WHERE a.job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$branch_id = $row['branch_id'];

if ($row['appointment_date'] != NULL) {
    $appointment_date = date("d-m-Y", strtotime($row['appointment_date']));


    if ($row['responsible_user_id'] != NULL) {
        $result_appo = mysqli_query($connect_db, "SELECT fullname FROM tbl_user WHERE user_id = '{$row['responsible_user_id']}'");
        $row_appo = mysqli_fetch_assoc($result_appo);

        $user_appo = $row_appo['fullname'];
    }
}

if ($row['send_oh_datetime'] != NULL) {
    $send_oh_datetime = date("d-m-Y", strtotime($row['send_oh_datetime']));

    if ($row['send_oh_user'] != NULL) {
        $result_send_oh = mysqli_query($connect_db, "SELECT fullname FROM tbl_user WHERE user_id = '{$row['send_oh_user']}'");
        $row_send_oh = mysqli_fetch_assoc($result_send_oh);

        $user_send_oh = $row_send_oh['fullname'];
    }
}

if ($row['get_qcoh_datetime'] != NULL) {
    $get_qcoh_datetime = date("d-m-Y", strtotime($row['get_qcoh_datetime']));

    if ($row['get_qcoh_user'] != NULL) {
        $result_get_qc = mysqli_query($connect_db, "SELECT fullname FROM tbl_user WHERE user_id = '{$row['get_qcoh_user']}'");
        $row_get_qc = mysqli_fetch_assoc($result_get_qc);

        $user_get_qc = $row_get_qc['fullname'];
    }
}

if ($row['send_qcoh_datetime'] != NULL) {
    $send_qcoh_datetime = date("d-m-Y", strtotime($row['send_qcoh_datetime']));

    if ($row['send_qcoh_user'] != NULL) {
        $result_send_qc = mysqli_query($connect_db, "SELECT fullname FROM tbl_user WHERE user_id = '{$row['send_qcoh_user']}'");
        $row_send_qc = mysqli_fetch_assoc($result_send_qc);

        $user_send_qc = $row_send_qc['fullname'];
    }
}

if ($row['pay_oh_datetime'] != NULL) {
    $pay_oh_datetime = date("d-m-Y", strtotime($row['pay_oh_datetime']));

    if ($row['pay_oh_user'] != NULL) {
        $result_pay_oh = mysqli_query($connect_db, "SELECT fullname FROM tbl_user WHERE user_id = '{$row['pay_oh_user']}'");
        $row_pay_oh = mysqli_fetch_assoc($result_pay_oh);

        $user_pay_oh = $row_pay_oh['fullname'];
    }
}

if ($row['return_datetime'] != NULL) {
    $return_datetime = date("d-m-Y", strtotime($row['return_datetime']));

    if ($row['return_oh_user'] != NULL) {
        $result_return_oh = mysqli_query($connect_db, "SELECT fullname FROM tbl_user WHERE user_id = '{$row['return_oh_user']}'");
        $row_return_oh = mysqli_fetch_assoc($result_return_oh);

        $user_return_oh = $row_return_oh['fullname'];
    }
}

if ($row['get_oh_datetime'] != NULL) {
    $get_oh_datetime = date("d-m-Y", strtotime($row['get_oh_datetime']));

    if ($row['get_oh_user'] != NULL) {
        $result_get_oh = mysqli_query($connect_db, "SELECT fullname FROM tbl_user WHERE user_id = '{$row['get_oh_user']}'");
        $row_get_oh = mysqli_fetch_assoc($result_get_oh);

        $user_get_oh = $row_get_oh['fullname'];
    }
}
?>


<div class="row">
    <div class="col-12 mb-3">
        <h4><b>รายการงานย่อย</b></h4>
    </div>

    <div class="col-3 mb-3">
        <label>รับเครื่อง</label>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $user_appo ?>" autocomplete="off"><br>

        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $appointment_date ?>" autocomplete="off">

        <button class="btn btn-sm btn-success mt-2" onclick="modal_image('<?php echo $job_id ?>','6');"><i class="fa fa-image"></i></button>
    </div>
    <div class="col-3 mb-3">
        <label>วันเปิดล้างเครื่อง</label>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $user_get_oh ?>" autocomplete="off">
        <br>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $get_oh_datetime ?>" autocomplete="off">

        <button class="btn btn-sm btn-success mt-2" onclick="modal_image('<?php echo $job_id ?>','1');"><i class="fa fa-image"></i></button>
    </div>
    <div class="col-3 mb-3">
        <label>วันที่แล้วเสร็จ</label>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $user_send_oh ?>" autocomplete="off">
        <br>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $send_oh_datetime ?>" autocomplete="off">

        <button class="btn btn-sm btn-success mt-2" onclick="modal_image('<?php echo $job_id ?>','2');"><i class="fa fa-image"></i></button>
    </div>
    <div class="col-3 mb-3">
        <label>วันที่เปิด QC</label>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $user_get_qc ?>" autocomplete="off">
        <br>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $get_qcoh_datetime ?>" autocomplete="off">

        <button class="btn btn-sm btn-success mt-2" onclick="modal_image('<?php echo $job_id ?>','3');"><i class="fa fa-image"></i></button>
    </div>

    <div class="col-3 mb-3">
        <label>วันที่ปิด QC</label>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $user_send_qc ?>" autocomplete="off">
        <br>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $send_qcoh_datetime ?>" autocomplete="off">
        <button class="btn btn-sm btn-success mt-2" onclick="modal_image('<?php echo $job_id ?>','4');"><i class="fa fa-image"></i></button>
    </div>

    <div class="col-3 mb-3">
        <label>วันที่ส่งคืน</label>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $user_return_oh ?>" autocomplete="off">
        <br>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $return_datetime ?>" autocomplete="off">
        <button class="btn btn-sm btn-success mt-2" onclick="modal_image('<?php echo $job_id ?>','5');"><i class="fa fa-image"></i></button>
    </div>

    <div class="col-3 mb-3">
        <label>วันที่โอนชำระ</label>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $user_pay_oh ?>" autocomplete="off">
        <br>
        <input type="text" id="" readonly name="" class="form-control" value="<?php echo $pay_oh_datetime ?>" autocomplete="off">
        <button class="btn btn-sm btn-success mt-2" onclick="modal_image('<?php echo $job_id ?>','7');"><i class="fa fa-image"></i></button>
    </div>


</div>
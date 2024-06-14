<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];


$sql = "SELECT * FROM tbl_job a 
LEFT JOIN tbl_customer_branch e ON a.customer_branch_id = e.customer_branch_id
LEFT JOIN tbl_customer f ON e.customer_id = f.customer_id
LEFT JOIN tbl_user c ON a.responsible_user_id = c.user_id 
LEFT JOIN tbl_branch b ON c.branch_id = b.branch_id
WHERE a.job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

// $branch_id = $row['branch_id'];

if ($row['get_oh_datetime'] != NULL) {
    $get_oh_datetime = date("d-m-Y", strtotime($row['get_oh_datetime']));
}

if ($row['send_oh_datetime'] != NULL) {
    $send_oh_datetime = date("d-m-Y", strtotime($row['send_oh_datetime']));
}

if ($row['get_qcoh_datetime'] != NULL) {
    $get_qcoh_datetime = date("d-m-Y", strtotime($row['get_qcoh_datetime']));
}

if ($row['send_qcoh_datetime'] != NULL) {
    $send_qcoh_datetime = date("d-m-Y", strtotime($row['send_qcoh_datetime']));
}

if ($row['pay_oh_datetime'] != NULL) {
    $pay_oh_datetime = date("d-m-Y", strtotime($row['pay_oh_datetime']));
}

if ($row['return_datetime'] != NULL) {
    $return_datetime = date("d-m-Y", strtotime($row['return_datetime']));
}

if ($row['appointment_date'] != NULL) {
    $appointment_date = date("d-m-Y", strtotime($row['appointment_date']));
}


$branch_care_id = $row['branch_id'];

// $overhaul_id = $row['overhaul_id'];

$sql1 = "SELECT * FROM tbl_job_oh_form_head WHERE job_id = '$job_id' and oh_type = '1'";
$rs1 = mysqli_query($connect_db, $sql1) or die($connect_db->error);
$row1 = mysqli_fetch_array($rs1);
$num_row1 = mysqli_num_rows($rs1);

$sql2 = "SELECT * FROM tbl_job_oh_form_head WHERE job_id = '$job_id' and oh_type = '2'";
$rs2 = mysqli_query($connect_db, $sql2) or die($connect_db->error);
$row2 = mysqli_fetch_array($rs2);
$num_row2 = mysqli_num_rows($rs2);

$sql3 = "SELECT * FROM tbl_job_oh_form_head WHERE job_id = '$job_id' and oh_type = '3'";
$rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);
$row3 = mysqli_fetch_array($rs3);
$num_row3 = mysqli_num_rows($rs3);

$sql4 = "SELECT * FROM tbl_job_oh_form_head WHERE job_id = '$job_id' and oh_type = '4'";
$rs4 = mysqli_query($connect_db, $sql4) or die($connect_db->error);
$row4 = mysqli_fetch_array($rs4);
$num_row4 = mysqli_num_rows($rs4);


$sql5 = "SELECT * FROM tbl_job_oh_form_head WHERE job_id = '$job_id' and oh_type = '5'";
$rs5 = mysqli_query($connect_db, $sql5) or die($connect_db->error);
$row5 = mysqli_fetch_array($rs5);
$num_row5 = mysqli_num_rows($rs5);

$sql6 = "SELECT * FROM tbl_job_oh_form_head WHERE job_id = '$job_id' and oh_type = '6'";
$rs6 = mysqli_query($connect_db, $sql6) or die($connect_db->error);
$row6 = mysqli_fetch_array($rs6);
$num_row6 = mysqli_num_rows($rs6);

$sql_job = "SELECT close_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
$row_job = mysqli_fetch_array($rs_job);

?>
<style>
    .border-black {
        border: 1px solid black;
    }
</style>

<form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
    <div class="wrapper wrapper-content" style="padding: 15px 0px 0px 0px;">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>">

                        <div class="ibox-content">

                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label><b>วันที่เข้ารับ</b></label>
                                </div>

                                <div class="col-12 mb-2">
                                    <label>วันเปิดล้างเครื่อง</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text"  readonly  class="form-control " value="<?php echo $appointment_date ?>"  autocomplete="off">
                                    </div>
                                </div>


                                <div class="col-12 mb-2">
                                    <label>ทีมผู้รับผิดชอบ</label>
                                    <input type="text" id="" readonly name="" class="form-control " value="<?php echo $get_oh_datetime ?>"  autocomplete="off">

                                </div>

                                <div class="col-12 mb-2" id="point_get_oh">
                                    <label>ช่างผู้รับผิดชอบ</label>
                                    <input type="text" id="" readonly name="" class="form-control " value="<?php echo $get_oh_datetime ?>" autocomplete="off">

                                </div>

                                <div class="col-12 mb-3">

                                    <?php if ($num_row6 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('6','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php  } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('6','<?php echo $row2['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?>

                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('6');">รูป</button>

                                </div>

                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label><b>วันที่ล้าง</b></label>
                                </div>
                                <div class="col-12 mb-2">
                                    <label>วันเปิดล้างเครื่อง</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="get_oh_datetime" readonly name="get_oh_datetime" class="form-control datepicker" value="<?php echo $get_oh_datetime ?>" onchange="get_distance('1');" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-12 mb-2">

                                    <label>ทีมผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-3" style="width: 100%;" onchange="Get_open_oh_user(this.value)">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = '1' ORDER BY team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>"><?php echo $row_user['team_number'] . " - " . $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>


                                <div class="col-12 mb-2" id="point_get_oh">

                                    <label>ช่างผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" name="get_oh_user" id="get_oh_user">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user WHERE active_status = 1";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row['get_oh_user'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>

                                <div class="col-12 mb-3">

                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('1');">รีเซ็ท</button>

                                    <!-- <?php if ($num_row1 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('1','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('1','<?php echo $row1['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?> -->
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('1');">รูป</button>

                                </div>


                                <div class="col-12 mb-2">
                                    <label>วันที่แล้วเสร็จ</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="send_oh_datetime" readonly name="send_oh_datetime" class="form-control datepicker" value="<?php echo $send_oh_datetime ?>" onchange="get_distance('1');" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-12 mb-2">

                                    <label>ทีมผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-3" style="width: 100%;" onchange="Get_close_oh_user(this.value)">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = '1' ORDER BY team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>"><?php echo $row_user['team_number'] . " - " . $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>

                                <div class="col-12 mb-2" id="point_sent_oh">

                                    <label>ช่างผู้รับผิดชอบ</label>

                                    <select class="form-control select2 mb-2" style="width: 100%;" name="sent_oh_user" id="sent_oh_user">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user WHERE active_status = 1";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row['send_oh_user'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>

                                    </select>

                                </div>

                                <div class="col-12 mb-2" id="open_date_distance">
                                </div>

                                <div class="col-12 mb-3">
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('2');"> รีเซ็ท </button>
                                    <?php if ($num_row2 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('2','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php  } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('2','<?php echo $row2['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('2');">รูป</button>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label><b>งาน QC</b></label>
                                </div>
                                <div class="col-12 mb-2">
                                    <label>วันที่เปิด QC</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="get_qcoh_datetime" readonly name="get_qcoh_datetime" class="form-control datepicker" value="<?php echo $get_qcoh_datetime ?>" onchange="get_distance('2');" autocomplete="off">
                                    </div>

                                </div>


                                <div class="col-12 mb-2">

                                    <label>ทีมผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-3" style="width: 100%;" onchange="Get_open_user(this.value)">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = '1' ORDER BY team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>"><?php echo $row_user['team_number'] . " - " . $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>

                                <div class="col-12 mb-2" id="point_open_qc">

                                    <label>ช่างผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" name="get_qcoh_user" id="get_qcoh_user">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row['get_qcoh_user'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>

                                <div class="col-12 mb-3">
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('3');">รีเซ็ท</button>

                                    <!-- <?php if ($num_row3 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('3','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('3','<?php echo $row3['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?> -->
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('3');">รูป</button>


                                </div>

                                <div class="col-12 mb-2">
                                    <label>วันที่ปิด QC</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="send_qcoh_datetime" readonly name="send_qcoh_datetime" class="form-control datepicker" value="<?php echo $send_qcoh_datetime ?>" onchange="get_distance('2');" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-12 mb-2">

                                    <label>ทีมผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" name="send_qcoh_user" id="send_qcoh_user">

                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row['send_qcoh_user'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>
                                <div class="col-12 mb-2" id="point_close_qc">

                                    <label>ช่างผู้รับผิดชอบ</label>

                                    <select class="form-control select2 mb-3" disabled style="width: 100%;">

                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user WHERE user_id = '{$row['send_qcoh_user']}'";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row['send_qcoh_user'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>
                                <div class="col-12 mb-3" id="qc_date_distance">
                                </div>
                                <div class="col-12 mb-3">
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('4');">รีเซ็ท</button>
                                    <?php if ($num_row4 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('4','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('4','<?php echo $row4['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('4');">รูป</button>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label><b>ส่งคืน</b></label>
                                </div>
                                <div class="col-12 mb-2">
                                    <label>วันที่ส่งคืนเครื่อง</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="return_datetime" readonly name="return_datetime" class="form-control datepicker" value="<?php echo $return_datetime ?>" onchange="get_distance('2');" autocomplete="off">
                                    </div>

                                </div>

                                <div class="col-12 mb-2">

                                    <label>ทีมผู้รับผิดชอบ</label>



                                    <select class="form-control select2 mb-2" style="width: 100%;" onchange="Get_oh_return(this.value)">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = 1";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>"><?php echo $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>

                                <div class="col-12 mb-2" id="point_return">

                                    <label>ช่างผู้รับผิดชอบ</label>

                                    <select class="form-control select2 mb-2" style="width: 100%;" name="return_oh_user" id="return_oh_user">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row['return_oh_user'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>

                                <div class="col-12 mb-3">
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('5');">รีเซ็ท</button>

                                    <?php if ($num_row3 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('5','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('5','<?php echo $row3['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?>

                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('5');">รูป</button>


                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label><b>โอนชำระ</b></label>
                                </div>
                                <div class="col-12 mb-2">
                                    <label>วันที่โอนชำระ</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="pay_oh_datetime" readonly name="pay_oh_datetime" class="form-control datepicker" value="<?php echo $pay_oh_datetime ?>" onchange="get_distance('3');" autocomplete="off">
                                    </div>

                                </div>
                                <div class="col-12 mb-2">

                                    <label>ช่างผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-3" style="width: 100%;" name="pay_oh_user" id="pay_oh_user">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user WHERE  branch_id = '$branch_care_id'";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row['pay_oh_user'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>

                                <div class="col-12 mb-3" id="pay_date_distance">
                                </div>
                                <div class="col-12 mb-3">
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('6');">รีเซ็ท</button>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('6');">รูป</button>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block" type="button" id="submit" onclick="Submit()">บันทึก</button>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd-mm-yyyy",

    })

    $('table').DataTable({
        pageLength: 10,
        responsive: true,
        // sorting: disable
    });



    function reset_date(check) {

        // alert(check);

        if (check == 1) {
            $('#get_oh_datetime').val('');

        } else if (check == 2) {
            $('#send_oh_datetime').val('');

        } else if (check == 3) {
            $('#get_qcoh_datetime').val('');

        } else if (check == 4) {
            $('#send_qcoh_datetime').val('');

        } else if (check == 5) {
            $('#return_datetime').val('');

        } else if (check == 6) {
            $('#pay_oh_datetime').val('');
        }

    };


    function get_distance(point) {
        var start_date = '';
        var end_date = '';
        if (point == 1) {
            start_date = $('#get_oh_datetime').val();
            end_date = $('#send_oh_datetime').val();
            $('#open_date_distance').html('');
        } else if (point == 2) {

            start_date = $('#get_qcoh_datetime').val();
            end_date = $('#send_qcoh_datetime').val();
            $('#qc_date_distance').html('');

        } else {
            start_date = $('#send_qcoh_datetime').val();
            end_date = $('#pay_oh_datetime').val();
            $('#pay_date_distance').html('');
        }

        $.ajax({
            url: 'ajax/mywork/Get_sub_oh_date.php',
            type: 'POST',
            dataType: 'json',
            data: {
                start_date: start_date,
                end_date: end_date,

            },
            success: function(data) {
                // console.log(data.text);
                if (point == 1) {

                    $('#open_date_distance').html(data.text);

                } else if (point == 2) {

                    $('#qc_date_distance').html(data.text);

                } else {

                    $('#pay_date_distance').html(data.text);
                }

            }
        });
    }




    function Get_open_oh_user(branch_id) {

        $.ajax({
            url: 'ajax/mywork/record_qc/get_user_oh_open.php',
            type: 'POST',
            dataType: 'html',
            data: {
                branch_id: branch_id,

            },
            success: function(response) {
                // console.log(data.text);
                $('#point_get_oh').html(response);
                $(".select2").select2({});
            }
        });
    }


    function Get_close_oh_user(branch_id) {

        $.ajax({
            url: 'ajax/mywork/record_qc/get_user_oh_close.php',
            type: 'POST',
            dataType: 'html',
            data: {
                branch_id: branch_id,

            },
            success: function(response) {
                // console.log(data.text);
                $('#point_sent_oh').html(response);
                $(".select2").select2({});
            }
        });
    }

    function Get_open_user(branch_id) {

        $.ajax({
            url: 'ajax/mywork/record_qc/get_user_qc_open.php',
            type: 'POST',
            dataType: 'html',
            data: {
                branch_id: branch_id,

            },
            success: function(response) {
                // console.log(data.text);
                $('#point_open_qc').html(response);
                $(".select2").select2({});
            }
        });
    }

    function Get_close_user(branch_id) {

        $.ajax({
            url: 'ajax/mywork/record_qc/get_user_qc_close.php',
            type: 'POST',
            dataType: 'html',
            data: {
                branch_id: branch_id,

            },
            success: function(response) {
                // console.log(data.text);
                $('#point_close_qc').html(response);
                $(".select2").select2({});
            }
        });
    }

    function Get_oh_return(branch_id) {

        $.ajax({
            url: 'ajax/mywork/record_qc/get_user_return.php',
            type: 'POST',
            dataType: 'html',
            data: {
                branch_id: branch_id,

            },
            success: function(response) {
                // console.log(data.text);
                $('#point_return').html(response);
                $(".select2").select2({});
            }
        });
    }



    function Modal_record(type, job_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/record_qc/modal_qc.php",
            data: {
                job_id: job_id,
                type: type
            },
            dataType: "html",
            success: function(response) {
                $('#modal .modal-content').html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
                $('.iradio_square-green').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            }
        });
    }


    function modal_image(sub_job_id) {

        var job_id = $('#job_id').val();

        $.ajax({
            type: "post",
            url: "ajax/mywork/sub_oh/Modal_image.php",
            data: {
                job_id: job_id,
                sub_job_id: sub_job_id
            },
            dataType: "html",
            success: function(response) {
                $("#modal .modal-content").html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });

            }
        });
    }


    function Modal_edit_record(type, oh_form_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/record_qc/modal_edit_qc.php",
            data: {
                oh_form_id: oh_form_id,
                type: type
            },
            dataType: "html",
            success: function(response) {
                $('#modal .modal-content').html(response);
                $("#modal").modal('show');
                $('.summernote').summernote({
                    toolbar: false,
                    height: 100,
                });
                $(".select2").select2({});
                $(".datepicker").datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                });
                $('.iradio_square-green').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            }
        });
    }



    function Submit() {

        var formData = new FormData($("#form-add_spare")[0]);


        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function() {

            $.ajax({
                type: 'POST',
                url: 'ajax/mywork/sub_oh/Add_sub_oh.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            swal.close();
                            $("#modal").modal('hide');
                        }, 500);
                        Getdata();
                    } else if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'กรุณาทำรายการใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }
</script>
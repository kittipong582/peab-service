<?php include('header.php');
session_start();
include("../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connect_db = connectDB($secure);


$job_id = $_GET['id'];
$sql = "SELECT * FROM tbl_job a 
LEFT JOIN tbl_customer_branch e ON a.customer_branch_id = e.customer_branch_id
LEFT JOIN tbl_customer f ON e.customer_id = f.customer_id
LEFT JOIN tbl_branch b ON e.branch_care_id = b.branch_id
WHERE a.job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$branch_id = $row['branch_id'];


$sql_oh1 = "SELECT * FROM tbl_job_oh a 
LEFT JOIN tbl_user b ON b.user_id = a.user_id 
LEFT JOIN tbl_branch c ON c.branch_id = b.branch_id
WHERE oh_type = 1 AND job_id = '$job_id'";
$rs_oh1 = mysqli_query($connect_db, $sql_oh1) or die($connect_db->error);
$row_oh1 = mysqli_fetch_array($rs_oh1);

$sql_oh2 = "SELECT * FROM tbl_job_oh a 
LEFT JOIN tbl_user b ON b.user_id = a.user_id 
LEFT JOIN tbl_branch c ON c.branch_id = b.branch_id 
WHERE oh_type = 2 AND job_id = '$job_id'";
$rs_oh2 = mysqli_query($connect_db, $sql_oh2) or die($connect_db->error);
$row_oh2 = mysqli_fetch_array($rs_oh2);

$sql_oh3 = "SELECT * FROM tbl_job_oh a 
LEFT JOIN tbl_user b ON b.user_id = a.user_id 
LEFT JOIN tbl_branch c ON c.branch_id = b.branch_id
WHERE oh_type = 3 AND job_id = '$job_id'";
$rs_oh3 = mysqli_query($connect_db, $sql_oh3) or die($connect_db->error);
$row_oh3 = mysqli_fetch_array($rs_oh3);

$sql_oh4 = "SELECT * FROM tbl_job_oh a 
LEFT JOIN tbl_user b ON b.user_id = a.user_id 
LEFT JOIN tbl_branch c ON c.branch_id = b.branch_id 
WHERE oh_type = 4 AND job_id = '$job_id'";
$rs_oh4 = mysqli_query($connect_db, $sql_oh4) or die($connect_db->error);
$row_oh4 = mysqli_fetch_array($rs_oh4);

$sql_oh5 = "SELECT * FROM tbl_job_oh a 
LEFT JOIN tbl_user b ON b.user_id = a.user_id 
LEFT JOIN tbl_branch c ON c.branch_id = b.branch_id 
WHERE oh_type = 5 AND job_id = '$job_id'";
$rs_oh5 = mysqli_query($connect_db, $sql_oh5) or die($connect_db->error);
$row_oh5 = mysqli_fetch_array($rs_oh5);

$sql_oh6 = "SELECT * FROM tbl_job_oh a 
LEFT JOIN tbl_user b ON b.user_id = a.user_id 
LEFT JOIN tbl_branch c ON c.branch_id = b.branch_id 
WHERE oh_type = 6 AND job_id = '$job_id'";
$rs_oh6 = mysqli_query($connect_db, $sql_oh6) or die($connect_db->error);
$row_oh6 = mysqli_fetch_array($rs_oh6);

$sql_oh7 = "SELECT * FROM tbl_job_oh a 
LEFT JOIN tbl_user b ON b.user_id = a.user_id 
LEFT JOIN tbl_branch c ON c.branch_id = b.branch_id 
WHERE oh_type = 7 AND job_id = '$job_id'";
$rs_oh7 = mysqli_query($connect_db, $sql_oh7) or die($connect_db->error);
$row_oh7 = mysqli_fetch_array($rs_oh7);

$sql_oh8 = "SELECT * FROM tbl_job_oh a 
LEFT JOIN tbl_user b ON b.user_id = a.user_id 
LEFT JOIN tbl_branch c ON c.branch_id = b.branch_id 
WHERE oh_type = 8 AND job_id = '$job_id'";
$rs_oh8 = mysqli_query($connect_db, $sql_oh8) or die($connect_db->error);
$row_oh8 = mysqli_fetch_array($rs_oh8);


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


?>
<style>
    .box-input {
        min-height: 90px;
    }

    /* tr {
        color: #676a6c;
    } */
    .classmodal1 {
        max-width: 1200px;
        margin: auto;

    }


    .classmodal2 {
        max-width: 800px;
        margin: auto;

    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $row['job_no'] ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="job_list.php">รายการงาน</a>
            </li>
            <li class="breadcrumb-item">
                <a href="view_cm.php?id=<?php echo $job_id; ?>&&type=<?php echo '1'; ?>"><?php echo $row['job_no'] ?></a>
            </li>
            <!-- <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li> -->
            <li class="breadcrumb-item active">
                <strong>รายละเอียดงาน</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">

                <div class="ibox">

                    <div class="ibox-content">
                        <form action="" method="post" id="form-add_spare" enctype="multipart/form-data">
                            <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>">
                            <div class="row">

                                <div class="col-12">
                                </div>

                                <div class="col-3 mb-2">
                                    <label>วันรับเครื่อง</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="" readonly name="" class="form-control" value="<?php echo ($row_oh1['appointment_datetime'] != "") ? date('d-m-Y', strtotime($row_oh1['appointment_datetime'])) : "" ?>" onchange="get_distance('1');" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-3 mb-2 user_list">
                                    <label>ทีมงาน</label>
                                    <select class="form-control select2 mb-2" style="width: 100%;" disabled>
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = 1 ORDER BY  team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>" <?php echo ($row_user['branch_id'] == $row_oh1['branch_id']) ? 'SELECTED' : '' ?>><?php echo $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>

                                <div class="col-3 mb-2 user_list">
                                    <label>ช่างผู้รับผิดชอบ</label>
                                    <select class="form-control select2 mb-2" disabled style="width: 100%;">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user WHERE active_status = 1";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row_oh1['user_id'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>

                                <div class="col-3 mb-2 user_list">
                                    <label><br></label><br>
                                    <?php if ($num_row6 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('1','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php  } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('1','<?php echo $row6['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('1');"> รูป </button>
                                </div>

                                <div class="col-3 mb-2">

                                    <label>วันเปิดล้างเครื่อง</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="oh_type2" readonly name="oh_type2" class="form-control datepicker" value="<?php echo ($row_oh2['appointment_datetime'] != "") ? date('d-m-Y', strtotime($row_oh2['appointment_datetime'])) : "" ?>" onchange="get_distance('1');" autocomplete="off">
                                    </div>

                                </div>

                                <div class="col-3 mb-2 user_list">

                                    <label>ทีมงาน</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" onchange="Get_user(this.value,'2')">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = 1 ORDER BY  team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>" <?php echo ($row_user['branch_id'] == $row_oh2['branch_id']) ? 'SELECTED' : '' ?>><?php echo $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>
                                <div class="col-3 mb-2 user_list" id="oh_point2">

                                    <label>ช่างผู้รับผิดชอบ</label>

                                    <select class="form-control select2 mb-2" style="width: 100%;" name="user_oh_type2" id="user_oh_type2">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user WHERE active_status = 1";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row_oh2['user_id'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>

                                <div class="col-3 mb-2 user_list">

                                    <label><br></label><br>
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('2');"> รีเซ็ท </button>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('2');"> รูป </button>
                                </div>

                                <div class="col-3 mb-2">

                                    <label>วันที่ตรวจสภาพก่อนถอด</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="oh_type3" readonly name="oh_type3" class="form-control datepicker" value="<?php echo ($row_oh3['appointment_datetime'] != "") ? date('d-m-Y', strtotime($row_oh3['appointment_datetime'])) : "" ?>" onchange="get_distance('1');" autocomplete="off">
                                    </div>

                                </div>
                                <div class="col-3 mb-2 user_list">

                                    <label>ทีมงาน</label>

                                    <select class="form-control select2 mb-2" style="width: 100%;" onchange="Get_user(this.value,'3')">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = 1 ORDER BY  team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>" <?php echo ($row_user['branch_id'] == $row_oh3['branch_id']) ? 'SELECTED' : '' ?>><?php echo $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>
                                <div class="col-3 mb-2 user_list" id="oh_point3">

                                    <label>ช่างผู้รับผิดชอบ</label>

                                    <select class="form-control select2 mb-2" style="width: 100%;" name="user_oh_type3" id="user_oh_type3">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user WHERE active_status = 1";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row_oh3['send_oh_user'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>

                                    </select>


                                </div>

                                <div class="col-3 mb-2">
                                    <label><br></label><br>
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('3');"> รีเซ็ท </button>
                                    <?php if ($num_row2 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('3','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php  } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('3','<?php echo $row2['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('3');"> รูป </button>

                                </div>

                                <div class="col-2 mb-2" id="open_date_distance">
                                    <label><br></label>
                                </div>


                                <div class="col-12">

                                </div>

                                <div class="col-3 mb-2">
                                    <label>วันที่แยกชิ้นส่วน</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="oh_type4" readonly name="oh_type4" class="form-control datepicker" value="<?php echo ($row_oh4['appointment_datetime'] != "") ? date('d-m-Y', strtotime($row_oh4['appointment_datetime'])) : "" ?>" onchange="get_distance('2');" autocomplete="off">
                                    </div>

                                </div>

                                <div class="col-3 mb-2 user_list">

                                    <label>ทีมงาน</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" onchange="Get_user(this.value,'4')">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = 1 ORDER BY  team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>" <?php echo ($row_user['branch_id'] == $row_oh4['branch_id']) ? 'SELECTED' : '' ?>><?php echo $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>

                                <div class="col-3 mb-2 user_list" id="oh_point4">

                                    <label>ช่างผู้รับผิดชอบ</label>

                                    <select class="form-control select2 mb-2" style="width: 100%;" name="user_oh_type4" id="user_oh_type4">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row_oh4['user_id'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>


                                <div class="col-3 mb-2">
                                    <label><br></label><br>
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('4');"> รีเซ็ท </button>

                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('4');"> รูป </button>

                                </div>


                                <div class="col-3 mb-2">
                                    <label>วันที่แช่ล้าง</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="oh_type5" readonly name="oh_type5" class="form-control datepicker" value="<?php echo ($row_oh5['appointment_datetime'] != "") ? date('d-m-Y', strtotime($row_oh5['appointment_datetime'])) : "" ?>" onchange="get_distance('2');" autocomplete="off">
                                    </div>

                                </div>

                                <div class="col-3 mb-2 user_list">

                                    <label>ทีมงาน</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" onchange="Get_user(this.value,'5')">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = 1 ORDER BY  team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>" <?php echo ($row_user['branch_id'] == $row_oh5['branch_id']) ? 'SELECTED' : '' ?>><?php echo $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>


                                <div class="col-3 mb-2 user_list" id="oh_point5">

                                    <label>ช่างผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" name="user_oh_type5" id="user_oh_type5">

                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row_oh5['user_id'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>

                                </div>

                                <div class="col-3 mb-2">
                                    <label><br></label><br>
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('5');">รีเซ็ท</button>
                                    <?php if ($num_row4 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('5','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php  } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('5','<?php echo $row4['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('5');"> รูป </button>

                                </div>
                                <div class="col-2 mb-2" id="qc_date_distance">
                                    <label><br></label>
                                </div>


                                <div class="col-12">

                                </div>

                                <div class="col-3 mb-2">
                                    <label>ประกอบชิ้นส่วนพร้อมทดสอบ</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="oh_type6" readonly name="oh_type6" class="form-control datepicker" value="<?php echo ($row_oh6['appointment_datetime'] != "") ? date('d-m-Y', strtotime($row_oh6['appointment_datetime'])) : "" ?>" autocomplete="off">
                                    </div>

                                </div>

                                <div class="col-3 mb-2 user_list">

                                    <label>ทีมงาน</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" onchange="Get_user(this.value,'6')">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = 1 ORDER BY  team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>" <?php echo ($row_user['branch_id'] == $row_oh6['branch_id']) ? 'SELECTED' : '' ?>><?php echo $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>

                                <div class="col-3 mb-2 user_list" id="oh_point6">

                                    <label>ช่างผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" name="user_oh_type6" id="user_oh_type6">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row_oh6['user_id'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>
                                <div class="col-3 mb-2">
                                    <label><br></label><br>
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('6');">รีเซ็ท</button>

                                    <?php if ($num_row5 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('6','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php  } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('6','<?php echo $row5['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('6');"> รูป </button>

                                </div>

                                <div class="col-3 mb-2">
                                    <label>QC</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="oh_type7" readonly name="oh_type7" class="form-control datepicker" value="<?php echo ($row_oh7['appointment_datetime'] != "") ? date('d-m-Y', strtotime($row_oh7['appointment_datetime'])) : "" ?>" autocomplete="off">
                                    </div>

                                </div>

                                <div class="col-3 mb-2 user_list">

                                    <label>ทีมงาน</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" onchange="Get_user(this.value,'7')">
                                        <option value="">กรุณาเลือกทีม</option>
                                        <?php $sql_user = "SELECT * FROM tbl_branch WHERE  active_status = 1 ORDER BY  team_number";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['branch_id'] ?>" <?php echo ($row_user['branch_id'] == $row_oh7['branch_id']) ? 'SELECTED' : '' ?>><?php echo $row_user['branch_name'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>

                                <div class="col-3 mb-2 user_list" id="oh_point7">

                                    <label>ช่างผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" name="user_oh_type7" id="user_oh_type7">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row_oh7['user_id'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>
                                <div class="col-3 mb-2">
                                    <label><br></label><br>
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('7');">รีเซ็ท</button>

                                    <?php if ($num_row5 == 0) { ?>
                                        <button class="btn btn-success px-2" type="button" onclick="Modal_record('7','<?php echo $job_id ?>');"> บันทึกการตรวจเช็ค </button>
                                    <?php  } else { ?>
                                        <button class="btn btn-warning px-2" type="button" onclick="Modal_edit_record('7','<?php echo $row5['oh_form_id'] ?>');"> แก้ไขบันทึกการตรวจเช็ค </button>

                                    <?php   } ?>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('7');"> รูป </button>

                                </div>




                                <div class="col-12">

                                </div>

                                <div class="col-3 mb-2">
                                    <label>โอนชำระ</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="oh_type8" readonly name="oh_type8" class="form-control datepicker" value="<?php echo ($row_oh8['appointment_datetime'] != "") ? date('d-m-Y', strtotime($row_oh8['appointment_datetime'])) : "" ?>" onchange="get_distance('3');" autocomplete="off">
                                    </div>

                                </div>

                                <div class="col-3 mb-5 user_list">

                                    <label>ช่างผู้รับผิดชอบ</label>


                                    <select class="form-control select2 mb-2" style="width: 100%;" name="user_oh_type8" id="user_oh_type8">
                                        <option value="">กรุณาเลือกช่าง</option>
                                        <?php $sql_user = "SELECT * FROM tbl_user ";
                                        $result_user  = mysqli_query($connect_db, $sql_user);
                                        while ($row_user = mysqli_fetch_array($result_user)) {
                                        ?>
                                            <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row_oh8['user_id'] == $row_user['user_id']) {
                                                                                                    echo "SELECTED";
                                                                                                } ?>><?php echo $row_user['fullname'] ?></option>
                                        <?php  } ?>
                                    </select>


                                </div>
                                <div class="col-3 mb-5">
                                    <label><br></label><br>
                                    <button class="btn btn-info px-2" type="button" onclick="reset_date('8');">รีเซ็ท</button>
                                    <button class="btn btn-warning px-2" type="button" onclick="modal_image('8');"> รูป </button>

                                </div>

                                <div class="col-2 mb-5" id="pay_date_distance">
                                </div>
                                <br>
                                <div class="col-12">
                                    <button class="btn btn-primary px-2 btn-block" type="button" id="submit" onclick="Submit()">บันทึก</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <div class="modal fade" id="modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered classmodal1" id="modal1" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered classmodal2" id="modal2" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>



    <?php include('import_script.php'); ?>
    <script>
        $(document).ready(function() {
            $(".select2").select2({});
            $(".datepicker").datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                format: 'dd-mm-yyyy',
                autoclose: true,
            });
        });

        function reset_date(check) {

            // alert(check);

            if (check == 1) {
                $('#oh_type1').val('');

            } else if (check == 2) {
                $('#oh_type2').val('');

            } else if (check == 3) {
                $('#oh_type3').val('');

            } else if (check == 4) {
                $('#oh_type4').val('');

            } else if (check == 5) {
                $('#oh_type5').val('');

            } else if (check == 6) {
                $('#oh_type6').val('');

            } else if (check == 7) {
                $('#oh_type7').val('');

            } else if (check == 8) {
                $('#oh_type8').val('');
            }

        };


        function get_distance(point) {
            var start_date = '';
            var end_date = '';
            if (point == 1) {
                start_date = $('#oh_type2').val();
                end_date = $('#oh_type3').val();
                $('#open_date_distance').html('');
            } else if (point == 2) {

                start_date = $('#oh_type4').val();
                end_date = $('#oh_type5').val();
                $('#qc_date_distance').html('');

            } else {
                start_date = $('#oh_type5').val();
                end_date = $('#oh_type8').val();
                $('#pay_date_distance').html('');
            }

            $.ajax({
                url: 'ajax/CM_view/Get_sub_oh_date.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    start_date: start_date,
                    end_date: end_date,

                },
                success: function(data) {

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


        function Get_user(branch_id, point) {

            $.ajax({
                url: 'ajax/CM_view/sub_oh/get_user_data.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    branch_id: branch_id,
                    point: point

                },
                success: function(response) {
                    // console.log(data.text);
                    $('#oh_point' + point).html(response);
                    $(".select2").select2({});
                }
            });
        }


        function Get_open_user(branch_id) {

            $.ajax({
                url: 'ajax/CM_view/sub_oh/get_user_qc_open.php',
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


        function Get_sent_user(branch_id) {

            $.ajax({
                url: 'ajax/CM_view/sub_oh/get_user_qc_sent.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    branch_id: branch_id,

                },
                success: function(response) {
                    // console.log(data.text);
                    $('#sent_oh_point').html(response);
                    $(".select2").select2({});
                }
            });
        }

        function Get_qc_open(branch_id) {

            $.ajax({
                url: 'ajax/CM_view/sub_oh/get_qc_open.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    branch_id: branch_id,

                },
                success: function(response) {
                    // console.log(data.text);
                    $('#get_qcoh_point').html(response);
                    $(".select2").select2({});
                }
            });
        }

        function Get_qc_sent(branch_id) {

            $.ajax({
                url: 'ajax/CM_view/sub_oh/get_qc_sent.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    branch_id: branch_id,

                },
                success: function(response) {
                    // console.log(data.text);
                    $('#send_qcoh_point').html(response);
                    $(".select2").select2({});
                }
            });
        }


        function Get_oh_return(branch_id) {

            $.ajax({
                url: 'ajax/CM_view/sub_oh/get_user_return.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    branch_id: branch_id,

                },
                success: function(response) {
                    // console.log(data.text);
                    $('#return_user_point').html(response);
                    $(".select2").select2({});
                }
            });
        }

        function Modal_record(type, job_id) {
            $.ajax({
                type: "post",
                url: "ajax/CM_view/sub_oh/modal_qc.php",
                data: {
                    job_id: job_id,
                    type: type
                },
                dataType: "html",
                success: function(response) {
                    $("#modal1 .modal-content").html(response);
                    $("#modal1").modal('show');
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


        function Modal_edit_record(type, oh_form_id) {
            $.ajax({
                type: "post",
                url: "ajax/CM_view/sub_oh/modal_edit_qc.php",
                data: {
                    oh_form_id: oh_form_id,
                    type: type
                },
                dataType: "html",
                success: function(response) {
                    $('#modal1 .modal-content').html(response);
                    $("#modal1").modal('show');
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
                    url: 'ajax/CM_view/overhaul/Add_sub_oh.php',
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
                                $("#modal1").modal('hide');
                            }, 500);
                            window.location.reload();
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



        function modal_image(sub_job_id) {

            var job_id = $('#job_id').val();

            $.ajax({
                type: "post",
                url: "ajax/CM_view/sub_oh/Modal_image.php",
                data: {
                    job_id: job_id,
                    sub_job_id: sub_job_id
                },
                dataType: "html",
                success: function(response) {
                    $("#modal2 .modal-content").html(response);
                    $("#modal2").modal('show');
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
    </script>
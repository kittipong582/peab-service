<?php
session_start();
include ("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$sql = "SELECT * FROM tbl_job 
WHERE job_id = '$job_id'";
$result = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


$sql_form = "SELECT * FROM tbl_job_form WHERE job_id = '$job_id'";
$result_form = mysqli_query($connect_db, $sql_form);
$row_form = mysqli_fetch_array($result_form);
$num_rows = mysqli_num_rows($result_form);


$sql_qc = "SELECT * FROM tbl_oh_form WHERE oh_job_type = 1 AND job_id = '$job_id'";
$result_qc = mysqli_query($connect_db, $sql_qc);
$row_qc = mysqli_fetch_array($result_qc);

$sql_gs = "SELECT * FROM tbl_oh_form WHERE oh_job_type = 2 AND job_id = '$job_id'";
$result_gs = mysqli_query($connect_db, $sql_gs);
$row_gs = mysqli_fetch_array($result_gs);


$num_oh_1 = "SELECT COUNT(*) as num1 FROM tbl_oh_form WHERE oh_job_type = 1";
$result_oh_1 = mysqli_query($connect_db, $num_oh_1);
$row_oh_1 = mysqli_fetch_array($result_oh_1);

$num_oh_2 = "SELECT COUNT(*) as num2 FROM tbl_oh_form WHERE oh_job_type = 2";
$result_oh_2 = mysqli_query($connect_db, $num_oh_2);
$row_oh_2 = mysqli_fetch_array($result_oh_2);

// echo $num_oh_2;


$sql_pm_group = "SELECT * FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
$result_pm_group = mysqli_query($connect_db, $sql_pm_group);
$row_pm_group = mysqli_fetch_array($result_pm_group);
$num_pm_group = mysqli_num_rows($result_pm_group);

if ($num_pm_group > 0) {
    $cancel_job_id = $row_pm_group['group_pm_id'];
    $group_type = 2;

    $sql_last_job = "SELECT group_pm_id FROM tbl_group_pm_detail WHERE job_id IN (SELECT job_id FROM tbl_job WHERE customer_branch_id = '{$row['customer_branch_id']}' AND job_type = 2 ORDER BY appointment_date DESC) LIMIT 1 ";
    $result_last_job = mysqli_query($connect_db, $sql_last_job);
    $row_last_job = mysqli_fetch_array($result_last_job);

    $last_job_id = $row_last_job['group_pm_id'];
} else {
    $cancel_job_id = $job_id;
    $group_type = 1;


    $sql_last_job = "SELECT job_id FROM tbl_job WHERE customer_branch_id = '{$row['customer_branch_id']}' AND job_type = 2 ORDER BY appointment_date DESC LIMIT 1";
    $result_last_job = mysqli_query($connect_db, $sql_last_job);
    $row_last_job = mysqli_fetch_array($result_last_job);

    $last_job_id = $row_last_job['job_id'];
}



?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>รายการดำเนินการ</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <?php if ($row['close_user_id'] == NULL && $row['cancel_user_id'] == NULL) { ?>

            <?php if ($row['qc_oh_user'] != $user_id) { ?>
                <div class="row">
                    <div class="col-3 mb-3 text-center">
                        <button class="btn btn-w-m btn-primary" type="button"
                            onclick="Modal_spare_part('<?php echo $job_id ?>');"> บันทึกอะไหล่ </button>
                    </div>

                    <div class=" col-3 mb-3 text-center">
                        <button class="btn btn-w-m btn-primary" type="button"
                            onclick="Modal_record_income('<?php echo $job_id ?>');"> บันทึกค่าบริการ </button>
                    </div>

                    <div class=" col-3 mb-3 text-center">
                        <button class="btn btn-w-m btn-primary" type="button"
                            onclick="Modal_record_expend('<?php echo $job_id ?>');"> บันทึกค่าใช้จ่าย </button>
                    </div>

                    <div class=" col-3 mb-3 text-center">
                        <button class="btn btn-w-m btn-primary" type="button"
                            onclick="Modal_record_payment('<?php echo $job_id ?>');"> บันทึกการจ่ายเงิน </button>
                    </div>

                    <?php if ($row['job_type'] == 1) { ?>
                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-primary" type="button" onclick="modal_fixed('<?php echo $job_id ?>');">
                                บันทึกการซ่อม </button>
                        </div>
                    <?php }
                    if ($row['job_type'] == 2 || $row['job_type'] == 3 || $row['job_type'] == 4 || $row['job_type'] == 5) { ?>
                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-primary" type="button" onclick="modal_Pm('<?php echo $job_id ?>');">
                                บันทึกรูป </button>
                        </div>
                    <?php } ?>

                    <div class=" col-3 mb-3 text-center">
                        <button class="btn btn-w-m btn-primary"> บันทึกประจำวัน </button>
                    </div>
                    <?php if ($row['job_type'] == 4 || $row['job_type'] == 1 && $row['overhaul_id'] == null) { ?>
                        <div class="col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-primary" type="button" onclick="Modal_add_OH('<?php echo $job_id ?>');">
                                เครื่องทดแทน </button>
                        </div>
                    <?php } ?>

                    <?php if ($row['job_type'] == 4) { ?>
                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-primary" type="button"
                                onclick="Modal_expire_date('<?php echo $job_id ?>');"> ประกันเครื่อง </button>
                        </div>
                    <?php } ?>

                    <?php if ($num_rows == 0) { ?>
                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-primary" type="button"
                                onclick="Modal_close_record('<?php echo $job_id ?>');"> บันทึกปฏิบัติงาน </button>
                        </div>
                    <?php }
                    if ($num_rows > 1) { ?>
                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-warning" type="button"
                                onclick="Modal_Editclose_record('<?php echo $job_id ?>');"> แก้ไขปฏิบัติงาน </button>
                        </div>
                    <?php } ?>


                    <?php if ($row['check_out_img'] != null && $row['close_user_id'] == NULL && $_SESSION['admin_status'] == 9) { ?>
                        <?php if ($row['job_type'] != 2) { ?>
                            <div class=" col-3 mb-3 text-center">
                                <button class="btn btn-w-m btn-danger" type="button" onclick="close_job('<?php echo $job_id ?>');">
                                    ปิดงาน </button>
                            </div>
                        <?php } else { ?>

                            <?php if ($last_job_id == $cancel_job_id) { ?>
                                <div class=" col-3 mb-3 text-center">
                                    <button class="btn btn-w-m btn-danger" type="button" onclick="close_job_PM('<?php echo $job_id ?>');">
                                        ปิดงาน </button>
                                </div>
                            <?php } else { ?>
                                <div class=" col-3 mb-3 text-center">
                                    <button class="btn btn-w-m btn-danger" type="button" onclick="close_job('<?php echo $job_id ?>');">
                                        ปิดงาน </button>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>


                    <?php if ($row['close_user_id'] == NULL) { ?>
                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-success" type="button"
                                onclick="Modal_close_remark('<?php echo $job_id ?>')"> ปิดงานแบบระบุ </button>
                        </div>
                    <?php } ?>
                    <div class=" col-3 mb-3 text-center">
                        <button type="button" class="btn btn-w-m btn-success"
                            onclick="Modal_set_SO('<?php echo $cancel_job_id; ?>','<?php echo $group_type; ?>');"> เลข SO
                        </button>
                    </div>



                    <?php if ($row['customer_branch_id'] == null && $row['job_type'] == 6 && $row['quotation_approve_result'] == 1) { ?>
                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-info" type="button" onclick="modal_new_cus('<?php echo $job_id ?>');">
                                เพิ่มลูกค้าใหม่ </button>
                        </div>
                    <?php } ?>

                    <?php if ($row['job_type'] == 6 && $row['quotation_approve_result'] == null) { ?>
                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-info" type="button"
                                onclick="confirm_approve('<?php echo $job_id ?>',1);">
                                อนุมัติเสนอราคา </button>
                        </div>
                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-danger" type="button"
                                onclick="confirm_approve('<?php echo $job_id ?>',0);">
                                ไม่อนุมัติ </button>
                        </div>
                    <?php } ?>

                    <div class=" col-3 mb-3 text-center">
                        <button class="btn btn-w-m btn-danger" type="button" onclick="Modal_cancel('<?php echo $job_id ?>')">
                            ยกเลิกงาน </button>
                    </div>


                    <?php if ($num_pm_group > 0) { ?>

                        <div class=" col-3 mb-3 text-center">
                            <button class="btn btn-w-m btn-success" type="button"
                                onclick="Modal_group_pm_price('<?php echo $row_pm_group['group_pm_id'] ?>');"> รวมยอดงาน </button>
                        </div>
                    <?php } ?>

                    <div class=" col-3 mb-3 text-center">
                        <a href="form_edit_job.php?id=<?php echo $job_id ?>&job_type=<?php echo $row['job_type'] ?>"><button
                                type="button" class="btn btn-w-m btn-warning"> แก้ไข </button></a>
                    </div>

                    <?php if ($row['job_type'] == 4) { ?>
                        <div class="col-3 mb-3 text-center">
                            <a href="record_sub_oh.php?id=<?php echo $job_id ?>" target="_blank"><button
                                    class="btn btn-w-m btn-warning" type="button"> งานย่อย overhaul </button></a>
                        </div>
                    <?php } ?>

                    <?php if ($num_rows > 1) { ?>
                        <div class="col-3 mb-3 text-center">
                            <!-- <a href="../../../print/Receipt _CRM.php?job_id=<?php echo $job_id ?>" target="_blank"><button type="button" class="btn btn-w-m btn-info ">
                                    พิมพ์ใบปฏิบัติงาน</button></a> -->
                        </div>
                    <?php } ?>
                    <div class="col-3 mb-3 text-center">
                        <a href="../../../print/print_peaberey_pm.php?job_id=<?php echo $job_id ?>" target="_blank"><button
                                type="button" class="btn btn-w-m btn-info ">
                                พิมพ์</button></a>
                    </div>

                </div>
            <?php } else { ?>

                <?php if ($row['job_type'] == 4 && $row['qc_active_datetime'] == null) { ?>
                    <div class="col-12 mb-3 text-center">
                        <button class="btn btn-w-m btn-success" type="button" onclick="confirm_qc('<?php echo $job_id ?>');"> QC
                        </button>
                    </div>
                <?php } ?>

            <?php } ?>
        <?php } else { ?>
            <div class=" row">
                <div class="col-12 mb-3 text-center">
                    <button class="btn btn-w-m btn-info" type="button" onclick="reset_close('<?php echo $job_id ?>')">
                        รีเซ็ท (IP) </button>
                    <button type="button" class="btn btn-w-m btn-success"
                        onclick="Modal_set_SO('<?php echo $cancel_job_id; ?>','<?php echo $group_type; ?>');"> เลข SO
                    </button>
                    <a href="../../../print/print_peaberey_pm.php?job_id=<?php echo $job_id ?>" target="_blank"><button
                                type="button" class="btn btn-w-m btn-info ">
                                พิมพ์</button></a>
                </div>
            </div>


        <?php } ?>
    </div>
    <div class=" modal-footer">
    </div>
</form>


<script>
    // function Modal_sub_oh(job_id) {
    //     $.ajax({
    //         type: "post",
    //         url: "ajax/CM_view/Modal_record_sub_oh.php",
    //         data: {
    //             job_id: job_id
    //         },
    //         dataType: "html",
    //         success: function(response) {

    //             $("#modal1 .modal-content").html(response);
    //             $("#modal1").modal('show');

    //             $('.summernote').summernote({
    //                 toolbar: false,
    //                 height: 100,
    //             });
    //             $(".select2").select2({});
    //             $(".datepicker").datepicker({
    //                 todayBtn: "linked",
    //                 keyboardNavigation: false,
    //                 format: 'dd-mm-yyyy',
    //                 autoclose: true,
    //             });
    //         }
    //     });
    // }
</script>
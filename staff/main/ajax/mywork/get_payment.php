<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql_chk = "SELECT * FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
$rs_chk = mysqli_query($connect_db, $sql_chk) or die($connect_db->error);
$row_chk = mysqli_fetch_assoc($rs_chk);
$num_chk = mysqli_num_rows($rs_chk);

if ($num_chk == 1) {

    $condition = "AND ref_type = '2'";

    $job_id = $row_chk['group_pm_id'];
    $ref_type = '2';
    $close_user = $row_chk['close_user_id'];
} else {
    $condition = "AND ref_type = '1'";
    $ref_type = '1';

    $sql_job = "SELECT close_user_id FROM tbl_job WHERE job_id = '$job_id'";
    $rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
    $row_job = mysqli_fetch_array($rs_job);
    $close_user = $row_job['close_user_id'];
}


$sql = "SELECT *,a.remark AS payment_remark FROM tbl_job_payment_file a
            LEFT JOIN  tbl_job b ON a.job_id = b.job_id
            LEFT JOIN tbl_account c ON a.account_id = c.account_id
            LEFT JOIN tbl_bank d ON c.bank_id = d.bank_id
            LEFT JOIN tbl_user e ON a.create_user_id = e.user_id
             WHERE a.job_id = '$job_id' $condition ORDER BY a.create_datetime DESC";

$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

?>
<style>
    .border-black {
        border: 1px solid black;
    }
</style>

<div class="wrapper wrapper-content" style="padding: 15px 0px 0px 0px;">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <div class="ibox-content">
                        <div class="row">
                            <?php if ($close_user == "") { ?>
                                <div class="col-4 text-right">
                                    <button class="btn btn-success btn-md " type="button" id="check" onclick="modal_add_payment('<?php echo $job_id ?>','<?php echo $ref_type ?>')">บันทึกการเก็บเงิน</button>
                                </div>
                            <?php  } ?>
                        </div>
                    </div>


                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" style="width: 300%;">
                                <thead>
                                    <tr>

                                        <th width="2%">#</th>

                                        <th width="15%" class="text-center">ผู้ทำรายการ</th>

                                        <th width="10%" class="text-right">เงินสด</th>

                                        <th width="10%" class="text-right">เงินโอน</th>

                                        <th width="10%" class="text-right">วางบิล</th>

                                        <th width="15%" class="text-center">จำนวนที่ชำระ</th>

                                        <th width="10%" class="text-center">หมายเหตุ</th>

                                        <th width="10%" class="text-center"></th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;

                                    while ($row = mysqli_fetch_assoc($rs)) {


                                        // if ($row['payment_type'] == 1) {
                                        //     $payment_type = "ชำระเงินแบบปกติ";
                                        // } else if ($row['payment_type'] == 2) {
                                        //     $payment_type = "ชำระเงินแบบวางบิล";
                                        // }


                                        $total = $row['cash_amount'] + $row['transfer_amount'];

                                        $all_amount = $total + $row['customer_cost'];
                                        $i++;

                                    ?>


                                        <tr id="tr_<?php echo $row['payment_id']; ?>">

                                            <td><?php echo $i; ?></td>

                                            <td class="text-center">

                                                <?php echo $row['fullname']; ?>
                                                <br>
                                                <?php echo date('d-m-Y H:i', strtotime($row['create_datetime'])); ?>

                                            </td>


                                            <td class="text-right">

                                                <?php echo number_format($row['cash_amount']); ?>

                                            </td>

                                            <td class="text-right">

                                                <?php echo number_format($row['transfer_amount']); ?>

                                            </td>

                                            <td class="text-right">
                                                <?php echo number_format($row['customer_cost']); ?>
                                            </td>

                                            <td class="text-center">

                                                <?php echo number_format($all_amount); ?>

                                            </td>


                                            <td class="text-center">

                                                <?php echo $row['payment_remark']; ?>

                                            </td>

                                            <td class="text-center">

                                                <div class="form-group">
                                                    <?php if ($close_user == "") { ?>
                                                        <button class="btn btn-sm btn-warning " onclick="edit_payment('<?php echo $row['payment_id']; ?>');">แก้ไข</button>
                                                        <button class="btn btn-sm btn-danger " onclick="delete_payment('<?php echo $row['payment_id']; ?>');">ลบ</button>
                                                    <?php } ?>
                                                </div>

                                            </td>


                                        </tr>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })

    $('table').DataTable({
        pageLength: 10,
        responsive: true,
        // sorting: disable
    });


    function modal_add_payment(job_id, ref_type) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/payment/Modal_record_payment.php",
            data: {
                job_id: job_id,
                ref_type: ref_type
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
            }
        });

    }


    function edit_payment(payment_id) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/payment/Modal_edit.php",
            data: {
                payment_id: payment_id
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
            }
        });

    }


    function submit_return(job_id) {

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
                url: 'ajax/mywork/overhaul/return_overhaul.php',
                data: {
                    job_id: job_id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                        }, function() {
                            Getdata();
                        });
                    }
                    if (data.result == 0) {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            text: "บันทึกผิดพลาด",
                            type: "error",
                        });
                    }
                }

            })
        });
    }


    function delete_payment(payment_id)

    {

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

                url: 'ajax/mywork/payment/delete_item.php',

                data: {

                    payment_id: payment_id

                },

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
                        }, 500);
                        $("#modal").modal('hide');
                        Getdata();
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: '',
                            type: 'warning'
                        });
                        return false;
                    }
                }

            });
        });

    }

    function Update_payment() {

        var payment_type = $('#payment_type').val();
        var formData = new FormData($("#form-edit_payment")[0]);
        if (payment_type == '') {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
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
                url: 'ajax/mywork/payment/update_job_payment.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                        }, function() {
                            Getdata();
                        });

                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });
    }
</script>
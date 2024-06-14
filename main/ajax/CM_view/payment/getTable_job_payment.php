<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$type = $_POST['type'];
$sql_chk = "SELECT * FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
$rs_chk = mysqli_query($connect_db, $sql_chk) or die($connect_db->error);
$row_chk = mysqli_fetch_assoc($rs_chk);
$num_chk = mysqli_num_rows($rs_chk);


$current_user_id = $_SESSION['user_id'];
$admin_status = $_SESSION['admin_status'];
$sql_current = "SELECT responsible_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_current = mysqli_query($connect_db, $sql_current) or die($connect_db->error);
$row_current = mysqli_fetch_assoc($rs_current);

if ($num_chk == 1) {

    $condition = "AND ref_type = '2'";
    $job_id = $row_chk['group_pm_id'];
} else {
    $condition = "AND ref_type = '1'";
}
?>

<div class="table-responsive">

    <table class="table table-striped table-hover table-bordered dataTables-example payment_tbl">

        <thead>

            <tr>

                <th width="2%">#</th>

                <th width="10%" class="text-center">ผู้ทำรายการ</th>

                <th width="10%" class="text-right">เงินสด</th>

                <th width="10%" class="text-right">เงินโอน</th>

                <th width="10%" class="text-right">วางบิล</th>

                <th width="10%" class="text-right">จำนวนที่ชำระ</th>

                <th width="10%" class="text-center">หมายเหตุ</th>

                <th width="5%"></th>

            </tr>

        </thead>

        <tbody>

            <?php

            $sql = "SELECT a.*,b.*,c.*,d.fullname FROM tbl_job_payment_file a
            LEFT JOIN tbl_account b ON a.account_id = b.account_id
            LEFT JOIN tbl_bank c ON c.bank_id = b.bank_id
            LEFT JOIN tbl_user d ON d.user_id = a.create_user_id
             WHERE a.job_id = '$job_id' $condition ORDER BY a.create_datetime DESC";

            $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

            $i = 0;

            // echo $sql;
            while ($row = mysqli_fetch_assoc($rs)) {


                $total = $row['cash_amount'] + $row['transfer_amount'] + $row['customer_cost'];

                $i++;
            ?>
                <tr id="tr_<?php echo $row['job_id']; ?>">

                    <td><?php echo $i; ?></td>

                    <td class="text-center">

                        <?php echo $row['fullname']; ?>
                        <br>
                        <?php echo date('d-m-Y H:i', strtotime($row['create_datetime'])); ?>

                    </td>

                    <td class="text-right">

                        <?php echo number_format($row['cash_amount'], 2); ?>

                    </td>

                    <td class="text-right">

                        <?php echo number_format($row['transfer_amount'], 2); ?>

                    </td>

                    <td class="text-right">

                        <?php echo number_format($row['customer_cost'], 2); ?>

                    </td>

                    <td class="text-center">

                        <?php echo number_format($total, 2); ?>

                    </td>

                    <td class="text-center">

                        <?php echo $row['remark']; ?>

                    </td>

                    <td class="text-center">
                        <?php if ($current_user_id == $row['responsible_user_id'] || $admin_status == 9) { ?>

                            <button class="btn btn-sm btn-info mb-1" onclick="Img_payment('<?php echo $row['payment_id']; ?>');">ดูรูป</button>

                            <button class="btn btn-sm btn-warning mb-1" onclick="edit_payment('<?php echo $row['payment_id']; ?>');">แก้ไข</button>
                            <button class="btn btn-sm btn-danger mb-1" onclick="delete_payment('<?php echo $row['payment_id']; ?>');">ลบ</button>


                        <?php } ?>
                    </td>



                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

<script>
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

                url: 'ajax/CM_view/payment/delete_item.php',

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
                        load_table_job_payment();



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


    function Img_payment(payment_id) {
        $.ajax({
            type: "post",
            url: "ajax/CM_view/payment/Modal_img.php",
            data: {
                payment_id: payment_id
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




    function edit_payment(payment_id)

    {

        $.ajax({
            type: "post",
            url: "ajax/CM_view/payment/Modal_edit.php",
            data: {
                payment_id: payment_id
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
</script>
<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$current_user_id = $_SESSION['user_id'];
$admin_status = $_SESSION['admin_status'];
$sql_current = "SELECT responsible_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_current = mysqli_query($connect_db, $sql_current) or die($connect_db->error);
$row_current = mysqli_fetch_assoc($rs_current);
?>

<div class="table-responsive">

    <table class="table table-striped table-hover table-bordered dataTables-example expend_tbl">

        <thead>

            <tr>

                <th width="2%">#</th>

                <th width="35%" class="text-center">ประเภทค่าใช้จ่าย</th>

                <th width="30%" class="text-center">ค่าใช้จ่าย</th>

                <th width="20%" class="text-center">ผู้ทำรายการ</th>

                <th width="15%"></th>

            </tr>

        </thead>

        <tbody>

            <?php

            $sql = "SELECT * FROM tbl_job_expend a
            LEFT JOIN tbl_expend_type b ON a.expend_type_id = b.expend_type_id
            LEFT JOIN tbl_user c ON a.create_user_id = c.user_id
             WHERE a.job_id = '$job_id'";

            $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

            $i = 0;

            while ($row = mysqli_fetch_assoc($rs)) {

                $i++;

            ?>
                <tr id="tr_<?php echo $row['job_expend_id']; ?>">

                    <td><?php echo $i; ?></td>

                    <td>

                        <?php echo $row['expend_type_name']; ?>

                    </td>

                    <td class="text_right">

                        <?php echo $row['expend_amount']; ?>

                    </td>

                    <td class="text_right">

                        <?php echo $row['fullname']; ?>

                    </td>

                    <td class="text-center">
                        <?php if ($current_user_id == $row['responsible_user_id'] || $admin_status == 9) { ?>
                            <div class="form-group">
                                <button class="btn btn-sm btn-warning btn-block " onclick="edit_item_expend('<?php echo $row['job_expend_id']; ?>');">แก้ไข</button>

                                <button class="btn btn-sm btn-danger btn-block" onclick="delete_item('<?php echo $row['job_expend_id']; ?>');">ลบ</button>
                            </div>
                        <?php } ?>
                    </td>



                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

<script>
    function delete_item(job_expend_id)

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

                url: 'ajax/CM_view/expend/delete_item.php',

                data: {

                    job_expend_id: job_expend_id

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
                        load_table_expend();
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



    function edit_item_expend(job_expend_id)

    {

        $.ajax({
            type: "post",
            url: "ajax/CM_view/expend/Modal_edit.php",
            data: {
                job_expend_id: job_expend_id
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
                get_des(expend_id);
            }
        });

    }
</script>
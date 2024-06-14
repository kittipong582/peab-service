<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$sql_symp = "SELECT * FROM tbl_symptom_type WHERE active_status = 1";
$rs_symp = mysqli_query($connect_db, $sql_symp) or die($connect_db->error);

$sql_rea = "SELECT * FROM tbl_reason_type WHERE active_status = 1";
$rs_rea = mysqli_query($connect_db, $sql_rea) or die($connect_db->error);

$sql_check = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$rs_check = mysqli_query($connect_db, $sql_check) or die($connect_db->error);
$row_check = mysqli_fetch_assoc($rs_check);



$current_user_id = $_SESSION['user_id'];
$admin_status = $_SESSION['admin_status'];
$sql_current = "SELECT responsible_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_current = mysqli_query($connect_db, $sql_current) or die($connect_db->error);
$row_current = mysqli_fetch_assoc($rs_current);

?>



<div class="table-responsive">

    <table class="table table-striped table-hover table-bordered dataTables-example fixed_tbl">

        <thead>

            <tr>

                <th width="2%">#</th>

                <th width="20%" class="text-center">ผู้ทำรายการ</th>

                <th width="20%" class="text-center">อาการ</th>

                <th width="20%" class="text-center">ปัญหา</th>

                <th width="35%" class="">หมายเหตุ</th>

                <th width="10%"></th>

            </tr>

        </thead>

        <tbody>

            <?php

            $sql = "SELECT *,b.type_name as symp_name,c.type_name as rea_name FROM tbl_fixed a
            LEFT JOIN tbl_symptom_type b ON a.symptom_type_id = b.symptom_type_id
            LEFT JOIN tbl_reason_type c ON a.reason_type_id = c.reason_type_id
            LEFT JOIN tbl_user d ON a.create_user_id = d.user_id
             WHERE a.job_id = '$job_id'";

            $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

            $i = 0;

            while ($row = mysqli_fetch_assoc($rs)) {

                $i++;

            ?>
                <tr id="tr_<?php echo $row['fixed_id']; ?>">

                    <td><?php echo $i; ?></td>

                    <td class="text-center">

                        <?php echo $row['fullname']; ?><br>
                        <?php echo date("d-m-Y", strtotime($row['create_datetime'])); ?>

                    </td>

                    <td class="text-center">

                        <?php echo $row['symp_name']; ?>

                    </td>

                    <td class="text-center">

                        <?php echo $row['rea_name']; ?>

                    </td>

                    <td class="">

                        <?php echo $row['remark']; ?>

                    </td>

                    <td class="text-center">

                        <div class="form-group">
                            <button class="btn btn-sm btn-success btn-block" onclick="view_detail('<?php echo $row['fixed_id']; ?>');">ดูรูป</button>
                            <?php if ($current_user_id == $row['responsible_user_id'] || $admin_status == 9) { ?>
                                <button class="btn btn-sm btn-warning btn-block" onclick="edit_fixed('<?php echo $row['fixed_id']; ?>');">แก้ไข</button>
                                <button class="btn btn-sm btn-danger btn-block" onclick="delete_fixed('<?php echo $row['fixed_id']; ?>');">ลบ</button>
                            <?php } ?>
                        </div>
                    </td>



                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

<script>
    function delete_fixed(fixed_id)

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

                url: 'ajax/CM_view/fixed_detail/delete_item.php',

                data: {

                    fixed_id: fixed_id

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
                        load_fixed_detail();
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

    function view_detail(fixed_id)

    {

        $.ajax({
            type: "post",
            url: "ajax/CM_view/fixed_detail/Modal_view.php",
            data: {
                fixed_id: fixed_id
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



    function edit_fixed(fixed_id)

    {

        $.ajax({
            type: "post",
            url: "ajax/CM_view/fixed_detail/Modal_edit.php",
            data: {
                fixed_id: fixed_id
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

    function delete_img(image_id, fixed_id)

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

                url: 'ajax/CM_view/repair_detail/delete_image.php',

                data: {

                    image_id: image_id

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
                        view_detail(fixed_id);

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
</script>
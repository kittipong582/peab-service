<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql_symp = "SELECT * FROM tbl_symptom_type WHERE active_status = 1";
$rs_symp = mysqli_query($connect_db, $sql_symp) or die($connect_db->error);

$sql_rea = "SELECT * FROM tbl_reason_type WHERE active_status = 1";
$rs_rea = mysqli_query($connect_db, $sql_rea) or die($connect_db->error);

$sql_check = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$rs_check = mysqli_query($connect_db, $sql_check) or die($connect_db->error);
$row_check = mysqli_fetch_assoc($rs_check);

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
                            <div class="col-4 text-right">
                                <?php if ($row_check['close_user_id'] == NULL) { ?>
                                    <button class="btn btn-success btn-md " type="button" id="check" onclick="modal_fixed('<?php echo $job_id ?>');">บันทึกการซ่อม</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>


                    <div class="ibox-content">
                        <div class="table-responsive">

                            <table class="table table-striped table-hover table-bordered dataTables-example fixed_tbl" style="width: 250%;">

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
                                                    <button class="btn btn-sm btn-warning btn-block" onclick="edit_fixed('<?php echo $row['fixed_id']; ?>');">แก้ไข</button>
                                                    <button class="btn btn-sm btn-danger btn-block" onclick="delete_fixed('<?php echo $row['fixed_id']; ?>');">ลบ</button>
                                                </div>
                                            </td>



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


    function modal_fixed(job_id) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/repair/Modal_repair.php",
            data: {
                job_id: job_id
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


    /////////////edit////////////////
    function Update_fixed() {

        var symptom_type_id = $('.symptom_type_id').val();
        var reason_type_id = $('.reason_type_id').val();

        var formData = new FormData($("#form-edit_fiexd")[0]);

        if (symptom_type_id == "" || reason_type_id == "") {
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
                url: 'ajax/mywork/repair/update.php',
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
                        }, 500);
                        $("#modal").modal('hide');

                        Getdata();
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

                url: 'ajax/mywork/repair/delete_item.php',

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


    function view_detail(fixed_id)

    {

        $.ajax({
            type: "post",
            url: "ajax/mywork/repair/Modal_view.php",
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
            url: "ajax/mywork/repair/Modal_edit.php",
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
</script>
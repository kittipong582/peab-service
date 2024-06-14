<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql = "SELECT * FROM tbl_job_expend a
LEFT JOIN tbl_expend_type b ON a.expend_type_id = b.expend_type_id
LEFT JOIN tbl_user c ON a.create_user_id = c.user_id
 WHERE a.job_id = '$job_id'";
$rs = mysqli_query($connect_db, $sql);

$sql_job = "SELECT close_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
$row_job = mysqli_fetch_array($rs_job);

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
                            <?php if ($row_job['close_user_id'] == NULL) { ?>
                                <div class="col-4 text-right">
                                    <button class="btn btn-success btn-md " type="button" id="check" onclick="modal_add_expend('<?php echo $job_id ?>')">บันทึกค่าใช้จ่าย</button>
                                </div>
                            <?php } ?>
                        </div>
                    </div>


                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>

                                        <th width="2%">#</th>

                                        <th style="width:35%;" class="text-center">ประเภทค่าใช้จ่าย</th>

                                        <th style="width:10%;" class="text-center">ค่าใช้จ่าย</th>

                                        <th style="width:15%;" class="text-center">ผู้ทำรายการ</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;

                                    while ($row = mysqli_fetch_assoc($rs)) {

                                        $i++;

                                    ?>


                                        <tr id="tr_<?php echo $row['job_expend_id']; ?>">

                                            <td class="text-center">

                                                <div class="form-group">
                                                    <?php if ($row_job['close_user_id'] == NULL) { ?>
                                                        <button class="btn btn-sm btn-danger " onclick="delete_item('<?php echo $row['job_expend_id']; ?>');">ลบ</button>
                                                    <?php } ?>
                                                </div>
                                            </td>

                                            <td class="text-center">

                                                <?php echo $row['expend_type_name']; ?>

                                            </td>

                                            <td class="text-center">

                                                <?php echo $row['expend_amount']; ?>

                                            </td>

                                            <td class="text-center">

                                                <?php echo $row['fullname']; ?>

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


    function modal_add_expend(job_id) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/expend/modal_expend.php",
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

                url: 'ajax/mywork/expend/delete_item.php',

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
</script>
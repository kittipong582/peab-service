<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql = "SELECT a.*,.b.fullname FROM tbl_job_daily a
LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
 WHERE job_id = '$job_id' ORDER BY create_datetime";

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
                            <div class="col-4">
                                
                                    <button class="btn btn-mb btn-success " onclick="Modal_daily_detail('<?php echo $job_id ?>')">เพิ่ม</button>
                              
                            </div>
                        </div>
                    </div>


                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" style="width: 300%;">
                                <thead>
                                    <tr>

                                        <th width="2%">#</th>

                                        <th width="15%" class="text-center">วันที่</th>

                                        <th width="10%" class="text-center">รายละเอียด</th>

                                        <th width="10%" class="text-center">ผู้ทำรายการ</th>

                                        <th width="10%" class="text-center"></th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;

                                    while ($row = mysqli_fetch_assoc($rs)) {
                                        $i++;

                                    ?>


                                        <tr id="tr_<?php echo $row['daily_id']; ?>">

                                            <td><?php echo $i; ?></td>

                                            <td class="text-center">

                                                <?php echo date('d-m-Y H:i', strtotime($row['create_datetime'])); ?>

                                            </td>


                                            <td class="text-center">

                                                <?php echo $row['daily_detail']; ?>

                                            </td>

                                            <td class="text-center">

                                                <?php echo $row['fullname']; ?>

                                            </td>

                                            <td class="text-center">

                                                <div class="form-group">
                                                    <!-- <button class="btn btn-sm btn-warning btn-block" onclick="Modal_Edit_daily('<?php echo $row['daily_id'] ?>')">แก้ไข</button> -->
                                                    <button class="btn btn-sm btn-danger btn-block" onclick="Delete_daily('<?php echo $row['daily_id'] ?>')">ลบ</button>

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


    function Modal_daily_detail(job_id) {

        $.ajax({
            type: "post",
            url: "ajax/mywork/daily/Modal_daily_detail.php",
            data: {
                job_id: job_id,
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


    function Delete_daily(daily_id)

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

                url: 'ajax/mywork/daily/delete_daily.php',

                data: {

                    daily_id: daily_id

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
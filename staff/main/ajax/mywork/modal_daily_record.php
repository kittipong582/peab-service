<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];
$type = $_POST['type'];
if($type == 2){
     $sql_job = "SELECT * FROM tbl_group_pm_detail a 
    LEFT JOIN tbl_job b ON b.job_id = a.job_id 
    WHERE a.group_pm_id = '$job_id' ORDER BY b.job_no ASC LIMIT 1";
    $rs_job = mysqli_query($connect_db,$sql_job);
    $row_job = mysqli_fetch_assoc($rs_job);

    $job_id = $row_job['job_id'];
}
?>

<div class="modal-header">
    <h4 class="modal-title" id="exampleModalLabel">บันทึกประจำวัน</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>


<div class="modal-body" style="padding-bottom: 0;">
    <form action="" method="post" id="form-add_daily" enctype="multipart/form-data">
        <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
        <input id="type" name="type" value="<?php echo $type ?>" type="hidden">

        <div class="row mb-3">

            <div class="col-12">
                <textarea class="summernote" id="daily_detail" name="daily_detail"></textarea>
            </div>
        </div>
    </form>
    <div class="row">

        <div class="col-12 mb-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered dataTables-example daily_tbl" id="daily_tbl">
                    <thead>
                        <tr>
                            <!-- <th width="2%">#</th> -->
                            <th width="20%" class="text-center">เวลา</th>
                            <th width="50%" class="text-center">รายละเอียดงาน</th>
                            <th width="20%" class="text-center">ผู้บันทึก</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT a.*,.b.fullname FROM tbl_job_daily a
            LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
             WHERE job_id = '$job_id' ORDER BY create_datetime DESC";
                        $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
                        $i = 0;
                        while ($row = mysqli_fetch_assoc($rs)) {
                            $i++;
                        ?>
                            <tr id="tr_<?php echo $row['fixed_id']; ?>">
                                <!-- <td><?php echo $i; ?></td> -->
                                <td class="text-center">
                                    <?php echo date("d-m-Y H:i", strtotime($row['create_datetime'])); ?>
                                </td>
                                <td class="text-center" width="50%">
                                    <?php echo $row['daily_detail']; ?>

                                </td>
                                <td class="text-center">
                                    <?php echo $row['fullname']; ?>
                                </td>
                                <td class="text-center">
                                    <div class="form-group">
                                        <!-- <button class="btn btn-sm btn-warning btn-block" onclick="Modal_Edit_daily('<?php echo $row['daily_id'] ?>')">แก้ไข</button> -->
                                        <button class="btn btn-sm btn-danger btn-block" onclick="Delete_daily1('<?php echo $row['daily_id'] ?>','<?php echo $job_id ?>','<?php echo $type ?>')">ลบ</button>

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




<div class="modal-footer">
    <button type="button" class="btn btn-danger  btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> ปิด</button>
    <button class="btn btn-primary btn-sm" type="button" id="submit" onclick="Submit_daily1()">บันทึก</button>
</div>

<script>
    $(".select2").select2({
        width: "100%"
    });


    // $('#daily_tbl').DataTable({
    //     pageLength: 10,
    //     responsive: true,
    //     // sorting: disable
    // });


    // $('table').DataTable({
    //     pageLength: 10,
    //     responsive: true,
    //     // sorting: disable
    // });

    function Submit_daily1() {

        var daily_detail = $('#daily_detail').val();
        var job_id = $('#job_id').val();
        var type = $('#type').val();

        var formData = new FormData($("#form-add_daily")[0]);

        if (daily_detail == "") {
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
                url: 'ajax/mywork/daily/Add.php',
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
                            modal_daily_record(job_id, 1);
                        });
                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ไม่สามารถเพิ่มข้อมูลได้',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }



    function Delete_daily1(daily_id, job_id, type)

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
                    daily_id: daily_id,
                    job_id: job_id,
                    type: type
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
                        modal_daily_record(job_id, 1);
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
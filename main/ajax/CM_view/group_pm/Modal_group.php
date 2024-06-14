<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];
$job_id = $_POST['job_id'];
$have_data = $_POST['have_data'];
if ($have_data == 1) {
    $group_id = getRandomID(10, 'tbl_group_pm', 'group_pm_id');

    $sql_check = "SELECT start_service_time FROM tbl_job 
    WHERE job_id = '$job_id'";
    $result_check  = mysqli_query($connect_db, $sql_check);
    $row_check = mysqli_fetch_array($result_check);
} else {

    $sql_get = "SELECT group_pm_id FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
    $result_get  = mysqli_query($connect_db, $sql_get);
    $row_get = mysqli_fetch_array($result_get);

    $group_id = $row_get['group_pm_id'];

    $sql_check = "SELECT start_service_time FROM tbl_group_pm 
    WHERE group_pm_id = '$group_id'";
    $result_check  = mysqli_query($connect_db, $sql_check);
    $row_check = mysqli_fetch_array($result_check);
}

$sql = "SELECT job_id,job_no FROM tbl_job WHERE job_id IN (SELECT job_id FROM tbl_job WHERE job_id != '$job_id' and customer_branch_id = '$customer_branch_id' AND job_type = '2' AND close_user_id IS NULL) and job_id NOT in (SELECT job_id FROM tbl_group_pm_detail)";
$result  = mysqli_query($connect_db, $sql);

// echo $sql;
$start_datetime = $row_check['start_service_time'];

// echo $row_check['num_chk'];
?>

<form method="post" id="form-add_group" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
            <strong]>รวมงาน</strong>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        <div class="row">


            <input type="hidden" id="group_pm_id" name="group_pm_id" value="<?php echo $group_id; ?>">
            <input type="hidden" id="have_data" name="have_data" value="<?php echo $have_data; ?>">
            <input type="hidden" id="start_datetime" name="start_datetime" value="<?php echo $start_datetime; ?>">
            <div class="col-5 mb-3">
                <label><strong>งาน</strong></label><br>
                <select multiple class="form-control select2" style="width: 100%;" id="job_select" name="job_select[]">
                    <option value="" disabled="disabled">กรุณาเลือกงาน</option>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <option value="<?php echo $row['job_id'] ?>"><?php echo $row['job_no'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class=" col-4 mb-3">
                <label><strong>วันที่เข้างาน</strong></label><br>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="pm_date" readonly name="pm_date" class="form-control datepicker2" value="" autocomplete="off">
                </div>

            </div>

            <div class=" col-3 mb-3">
                <label><br></label><br>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" onclick="add();" id="btn_submit">เพิ่ม</button>
                    <button type="button" class="btn btn-warning" onclick="changedate();" id="btn_submit">เปลี่ยนวันที่</button>
                </div>
            </div>

        </div>

        <div class="row">
            <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>">
            <div class="col-mb-3 col-12" id="Loading_job">
                <div class="spiner-example">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div>
            <div class="col-mb-3 col-12" id="show_table_job">
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <!-- <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit()">บันทึก</button> -->
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        load_table_job();

        $(".datepicker2").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            format: 'dd-mm-yyyy',
            autoclose: true,
        });
    });

    function load_table_job() {

        var job_id = $('#job_id').val();

        $.ajax({
            type: 'POST',
            url: 'ajax/CM_view/group_pm/getTable_job.php',
            data: {
                job_id: job_id
            },
            dataType: 'html',
            success: function(response) {
                $('#show_table_job').html(response);
                // $('.spare_part_tbl').DataTable({
                //     pageLength: 25,
                //     responsive: true,
                // });
                $('#Loading_job').hide();
            }
        });
    }


    function add() {

        var job_select = $('#job_select').val();
        var have_data = $('#have_data').val();
        var pm_date = $('#pm_date').val();

        var formData = new FormData($("#form-add_group")[0]);
        if (have_data == 1) {
            if (job_select == "" || pm_date == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ถูกต้อง',
                    type: 'error'
                });
                return false;
            }
        } else {
            if (job_select == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ถูกต้อง',
                    type: 'error'
                });
                return false;
            }


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
                url: 'ajax/CM_view/group_pm/Add.php',
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

                        window.location.href = 'job_list.php';

                    } else {
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



    function changedate() {


        var group_pm_id = $('#group_pm_id').val();
        var pm_date = $('#pm_date').val();

        if (group_pm_id == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่มีงานในกลุ่มงานนี้',
                type: 'error'
            });
            return false;
        }


        if (pm_date == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาเลือกวันที่',
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
                url: 'ajax/CM_view/group_pm/Change_date.php',
                data: {
                    pm_date: pm_date,
                    group_pm_id: group_pm_id
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

                    } else {
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

    function clear_all() {

        var formData = new FormData($("#form-add_group")[0]);
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
                url: 'ajax/CM_view/group_pm/clear_all.php',
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

                    } else {
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
</script>
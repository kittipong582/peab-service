<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql_job = "SELECT customer_branch_id,appointment_date FROM tbl_job WHERE job_id = '$job_id'";
$rs = mysqli_query($connect_db, $sql_job);
$row = mysqli_fetch_assoc($rs);

$customer_branch_id = $row['customer_branch_id'];
$appointment_date = $row['appointment_date'];
$start_date = date("Y-m-d", strtotime($row['appointment_date'] . "-15 days"));
$last_date = date("Y-m-d", strtotime($row['appointment_date'] . "+15 days"));

$job_list = array();

$sql_search = "SELECT a.job_id,a.job_no,a.appointment_date,
b.branch_name,
c.fullname,
d.team_number,d.branch_name as team_name,
f.model_name,
e.serial_no
FROM tbl_job a
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_user c ON a.responsible_user_id = c.user_id
LEFT JOIN tbl_branch d ON a.care_branch_id = d.branch_id
LEFT JOIN tbl_product e ON e.product_id = a.product_id
LEFT JOIN tbl_product_model f ON f.model_id = e.model_id
WHERE a.appointment_date BETWEEN '$start_date' and '$last_date' And a.customer_branch_id = '$customer_branch_id' AND a.job_type = 2 
AND a.job_id NOT in(select job_id from  tbl_group_pm_detail) AND a.start_service_time is NULL and job_id != '$job_id'";

$rs_search = mysqli_query($connect_db, $sql_search);
while ($row_search = mysqli_fetch_assoc($rs_search)) {

    $temp = array(
        "job_id" => $row_search['job_id'],
        "job_no" => $row_search['job_no'],
        "type" => '1',
        "appointment_date" => $row_search['appointment_date'],
        "customer_branch" => $row_search['branch_name'],
        "worker_user" => $row_search['fullname'],
        "team_user" => $row_search['team_number'] . " - " . $row_search['team_name'],
        "product" => $row_search['serial_no'] . " - " . $row_search['model_name']
    );
    array_push($job_list, $temp);
}



$sql_pm = "SELECT a.group_pm_id,a.group_date,d.fullname,e.team_number,e.branch_name FROM tbl_group_pm a
LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id
LEFT JOIN tbl_branch e ON d.branch_id = e.branch_id
WHERE a.group_pm_id IN (SELECT group_pm_id FROM tbl_group_pm_detail a
LEFT JOIN tbl_job b ON a.job_id = b.job_id
WHERE a.group_date BETWEEN '$start_date' and '$last_date' And b.customer_branch_id = '$customer_branch_id'
) AND a.start_service_time is NULL";

$rs_pm = mysqli_query($connect_db, $sql_pm);

while ($row_pm = mysqli_fetch_assoc($rs_pm)) {

    $sql_detail = "SELECT branch_name FROM  tbl_customer_branch 
    WHERE customer_branch_id = '$customer_branch_id' ";
    $rs_detail = mysqli_query($connect_db, $sql_detail);
    $row_detail = mysqli_fetch_assoc($rs_detail);

    $temp = array(
        "job_id" => $row_pm['group_pm_id'],
        "job_no" => "กลุ่มงาน PM",
        "type" => '2',
        "appointment_date" => $row_pm['group_date'],
        "customer_branch" => $row_detail['branch_name'],
        "worker_user" => $row_pm['fullname'],
        "team_user" => $row_pm['team_number'] . " - " . $row_pm['branch_name'],
        "product" => ""
    );
    array_push($job_list, $temp);
}
array_multisort(array_column($job_list, 'appointment_date'), SORT_DESC, $job_list);


?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
            รวมงาน PM
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" value="<?php echo $job_id ?>" id="mainjob_id" name="mainjob_id">
            <p><b>รายการงาน</b></p>
            <?php foreach ($job_list as $row) { ?>
                <input type="hidden" value="<?php echo $row['job_id'] ?>" id=" job_id" name="job_id[]">
                <input type="hidden" value="<?php echo $row['type'] ?>" id=" type" name="type[]">
                <div class="col-12">
                    <dl class="row mb-0">
                        <div class="col-sm-1 text-sm-left">
                            <dt>งาน :</dt>
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <dd class="mb-1">
                                <?php echo $row['job_no'] ?>
                            </dd>
                        </div>
                        <div class="col-sm-1 text-sm-left">
                            <dt>ร้าน :</dt>
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <dd class="mb-1">
                                <?php echo $row['customer_branch'] ?>
                            </dd>
                        </div>
                        <div class="col-sm-1 text-sm-left">
                            <dt>วันที่ :</dt>
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <dd class="mb-1">
                                <?php echo $row['appointment_date'] ?>
                            </dd>
                        </div>
                        <div class="col-sm-1 text-sm-left">
                            <dt>ช่าง :</dt>
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <dd class="mb-1">
                                <?php echo $row['worker_user'] ?>
                            </dd>
                        </div>
                        <div class="col-sm-1 text-sm-left">
                            <dt>ทีม :</dt>
                        </div>
                        <div class="col-sm-3 text-sm-left">
                            <dd class="mb-1">
                                <?php echo $row['team_user'] ?>
                            </dd>
                        </div>

                        <div class="col-sm-1 text-sm-left">

                        </div>
                        <div class="col-sm-3 text-sm-left">

                        </div>

                        <div class="col-sm-4 text-sm-left mt-2">
                            <dd class="mb-1">
                                <?php echo "<b style='padding-right:16px;'>เครื่อง :  </b>" . $row['product'] ?>
                            </dd>
                        </div>



                    </dl>
                    <hr>
                </div>


            <?php } ?>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">รวม</button>
    </div>
</form>
<?php include('import_script.php'); ?>
<script>
    $(document).ready(function () {


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

    });



    function Add() {


        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00FF00",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function () {

            let myForm = document.getElementById('form-add');
            let formData = new FormData(myForm);

            swal({
                title: "Loading",
                text: "Loading...",
                showCancelButton: false,
                showConfirmButton: false
                //icon: "success"
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/job_list/Add_Group.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function () {
                            swal.close();
                            $("#modal").modal('hide');
                            GetTable();

                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้", "error");
                    }

                }
            });

        });
    }
</script>
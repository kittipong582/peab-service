<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql_group = "SELECT group_pm_id FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
$rs_group = mysqli_query($connect_db, $sql_group);
$row_group = mysqli_fetch_array($rs_group);

$all_job = array();
$sql_job = "SELECT * FROM tbl_group_pm a
LEFT JOIN tbl_group_pm_detail b ON a.group_pm_id = b.group_pm_id  WHERE a.group_pm_id = '{$row_group['group_pm_id']}'";
$rs_job = mysqli_query($connect_db, $sql_job);
while ($row_job = mysqli_fetch_array($rs_job)) {
    array_push($all_job, $row_job['job_id']);
}



$num_chk = mysqli_num_rows($rs_job);

// array_push($all_job, $row_job['']);
// echo $sql_job;


?>

<?php if ($num_chk >= 1) { ?>
    <div class="table-responsive">

        <table class="table table-striped table-hover table-bordered dataTables-example income_tbl">

            <thead>

                <tr>

                    <th width="5%">#</th>

                    <th width="20%" class="text-center">รายการงาน</th>

                    <th width="25%" class="text-center">เครื่อง</th>

                    <th width="25%" class="text-center">ช่าง</th>

                    <th width="15%" class="text-center">วันที่</th>

                </tr>

            </thead>

            <tbody>

                <?php


                foreach ($all_job as $r) {
                    $temp_job_id = $r;

                    $sql = "SELECT * FROM tbl_job a 
                LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id
                LEFT JOIN tbl_product c ON a.product_id = c.product_id 
                LEFT JOIN tbl_product_brand d ON c.brand_id = d.brand_id
                LEFT JOIN tbl_product_model e ON c.model_id = e.model_id
                LEFT JOIN tbl_branch f ON b.branch_id = f.branch_id
                LEFT JOIN tbl_product_type g ON c.product_type = g.type_id
                WHERE job_id = '$temp_job_id'";
                    $rs = mysqli_query($connect_db, $sql);
                    $row = mysqli_fetch_array($rs);

                    $i++;
                    // echo $sql;

                ?>
                    <tr>

                        <td>
                            <div class="form-group">
                                <button class="btn btn-sm btn-danger " type="button" onclick="remove_job('<?php echo $temp_job_id ?>')">X</button>
                            </div>
                        </td>

                        <td class="text-center">

                            <?php echo $row['job_no']; ?>

                        </td>

                        <td class="text_right">

                            <?php echo "(" . $row['serial_no'] . ") <br/> ยี่ห้อ " . $row['brand_name'] . " รุ่น " . $row['model_name']; ?><br>
                            <?php echo "ประเภท " . $row['type_name'] ?>

                        </td>

                        <td class="text_right">

                            <?php echo $row['fullname'] . "<br/> สาขา " . $row['branch_name']; ?>

                        </td>

                        <td class="text_right">

                            <?php echo date("d-m-Y", strtotime($row['appointment_date'])); ?>

                        </td>


                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>
<?php } ?>

<script>
    function remove_job(job_id)

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

                url: 'ajax/CM_view/group_pm/remove_job.php',

                data: {

                    job_id: job_id

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
                            if (data.type_chk == 1) {
                                window.location.reload();
                            } else if (data.type_chk == 2) {
                                window.location.href = 'job_list.php';
                            }
                        }, 500);


                        // document.getElementById("total_service").innerHTML = data.total_service
                        // document.getElementById("total_spare").innerHTML = data.total_spare

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
<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$group_pm_id = $_POST['group_pm_id'];

$all_job = array();
$sql_job = "SELECT * FROM tbl_group_pm_detail WHERE group_pm_id = '$group_pm_id'";
$rs_job = mysqli_query($connect_db, $sql_job);



// $temp = explode(",", $row_job['job_id']);
$num_chk = mysqli_num_rows($rs_job);

// array_push($all_job, $row_job['']);
// echo $sql_job;


?>

<?php if ($num_chk >= 1) { ?>
    <div class="table-responsive">

        <table class="table table-striped table-hover table-bordered dataTables-example" id="tbl_group_payment">

            <thead>

                <tr>

                    <th width="2%">#</th>

                    <th width="20%" class="text-center">รายการงาน</th>

                    <th width="25%" class="text-center">เครื่อง</th>

                    <th width="25%" class="text-center">ค่าอะไหล่</th>

                    <th width="15%" class="text-center">ค่าบริการ</th>

                </tr>

            </thead>

            <tbody>

                <?php


                while ($row_job = mysqli_fetch_array($rs_job)) {
                    
                    $income_total = 0;
                    $sql = "SELECT * FROM tbl_job a 
                LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id
                LEFT JOIN tbl_product c ON a.product_id = c.product_id 
                LEFT JOIN tbl_product_brand d ON c.brand_id = d.brand_id
                LEFT JOIN tbl_product_model e ON c.model_id = e.model_id
                LEFT JOIN tbl_branch f ON b.branch_id = f.branch_id
                LEFT JOIN tbl_product_type g ON c.product_type = g.type_id
                WHERE job_id = '{$row_job['job_id']}'";
                    $rs = mysqli_query($connect_db, $sql);
                    $row = mysqli_fetch_array($rs);

                    $i++;
                    // echo $sql;

                    $sql_spare = "SELECT IFNULL(SUM(unit_price),0) AS totall,IFNULL(SUM(quantity),0) AS sum_spare FROM tbl_job_spare_used WHERE job_id = '{$row_job['job_id']}'";
                    $result_spare  = mysqli_query($connect_db, $sql_spare);
                    $row_spare = mysqli_fetch_array($result_spare);
                    $sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '{$row_job['job_id']}'";
                    $result_income  = mysqli_query($connect_db, $sql_income);
                    while ($row_income = mysqli_fetch_array($result_income)) {

                        $income_total += $row_income['quantity'] * $row_income['income_amount'];
                    }


                ?>
                    <tr>

                        <td><?php echo $i; ?></td>

                        <td class="text-center">

                            <?php echo $row['job_no']; ?>

                        </td>

                        <td class="text_right">

                            <?php echo "(" . $row['serial_no'] . ") <br/> ยี่ห้อ " . $row['brand_name'] . " รุ่น " . $row['model_name']; ?><br>
                            <?php echo "ประเภท " . $row['type_name'] ?>

                        </td>

                        <td class="text_right">

                            <?php echo  number_format($row_spare['totall']); ?>

                        </td>

                        <td class="text_right">

                            <?php echo  number_format($income_total); ?>

                        </td>




                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>
<?php } ?>

<script>
    function delete_item_income(job_income_id)

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

                url: 'ajax/CM_view/income/delete_item.php',

                data: {

                    job_income_id: job_income_id

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

                        load_table_total_service();
                        document.getElementById("total_service").innerHTML = data.total_service
                        document.getElementById("td_total").innerHTML = data.total_service

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
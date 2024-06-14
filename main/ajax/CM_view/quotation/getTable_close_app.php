<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql = "SELECT *,b.fullname AS create_name,c.fullname AS appname FROM tbl_job_close_approve a 
LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
LEFT JOIN tbl_user c ON a.approve_user_id = c.user_id
WHERE a.job_id = '$job_id' ORDER BY a.create_datetime DESC";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

// echo $sql;
?>

<div class="table-responsive">

    <table class="table table-striped table-hover table-bordered dataTables-example income_tbl">

        <thead>

            <tr>

                <th width="5%">#</th>

                <th width="10%" class="text-center">วันที่ส่งอนุมัติ</th>

                <th width="10%" class="text-center">ผู้ส่งอนุมัติ</th>

                <th width="15%" class="text-center">หมายเหตุการส่ง</th>

                <th width="10%" class="text-center">ผู้อนุมัติ</th>

                <th width="15%" class="text-center">หมายเหตุการอนุมัติ</th>

                <th width="10%" class="text-center">ผลการอนุมัติ</th>

                <th width="5%"></th>

            </tr>

        </thead>

        <tbody>

            <?php

            $i = 0;

            while ($row = mysqli_fetch_assoc($rs)) {

                $i++;
            ?>
                <tr id="tr_<?php echo $row['close_approve_id']; ?>">

                    <td><?php echo $i; ?></td>

                    <td class="text-center">

                        <?php echo date("d-m-Y", strtotime($row['create_datetime'])); ?><br>
                        <?php echo "เวลา " . date("H:i:s", strtotime($row['create_datetime'])) ?>

                    </td>

                    <td class="text-center">

                        <?php echo $row['create_name']; ?>

                    </td>

                    <td class="text-center">

                        <?php echo $row['send_remark']; ?>

                    </td>

                    <td class="text-center">

                        <?php echo $row['appname']; ?>

                    </td>

                    <td class="text-center">

                        <?php echo $row['approve_remark']; ?>

                    </td>

                    <td class="text-center">

                        <?php if ($row['approve_result'] == 1) {
                            echo "ผ่านการอนุมัติ";
                        } else if ($row['approve_result'] == 2) {
                            echo "<font color='red'>" . "ไม่ผ่านการอนุมัติ" . "</font>";
                        } elseif ($row['approve_result'] == 3) {
                            echo "<font color='red'>" . "ยกเลิก" . "</font>";
                        } else {
                            echo "รอการอนุมัติ";
                        } ?>

                    </td>

                    <td class="text-center">

                        <!-- <div class="form-group">
                            <button class="btn btn-sm btn-danger " onclick="delete_item_income('<?php echo $row['job_income_id']; ?>');">ลบ</button>
                        </div> -->
                    </td>



                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

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
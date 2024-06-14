<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
?>

<div class="table-responsive">

    <table class="table table-striped table-hover table-bordered dataTables-example spare_part_tbl">

        <thead>

            <tr>

                <th width="2%">#</th>

                <th width="40%" class="text-center">รายการ</th>

                <th width="10%" class="text-center">จำนวน</th>

                <th width="10%" class="text-center">บันทึกแล้ว</th>

                <th width="10%" class="text-center">ยังไม่บันทึก</th>

                <th width="5%"></th>

            </tr>

        </thead>

        <tbody>

            <?php

            $sql = "SELECT *,a.quantity AS aquan,a.spare_used_id AS aspare_id FROM tbl_job_spare_used a
            LEFT JOIN tbl_spare_part c ON a.spare_part_id = c.spare_part_id
            LEFT JOIN tbl_spare_type d ON c.spare_type_id = d.spare_type_id
            
             WHERE a.job_id = '$job_id'";

            $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);



            $i = 0;


            while ($row = mysqli_fetch_assoc($rs)) {

                $i++;

                $spare_used_id = $row['spare_used_id'];


                $sql_ax = "SELECT SUM(quantity) as total_ax FROM tbl_spare_used_ax WHERE spare_used_id = '$spare_used_id'";
                $result_ax  = mysqli_query($connect_db, $sql_ax);
                $row_ax = mysqli_fetch_array($result_ax);

                $not_record =  $row['aquan'] - $row_ax['total_ax'];





                if ($not_record > 0) {
                    $remain_ax = "<font color=red>" . number_format($not_record) . "</font>";
                } else {

                    $remain_ax = number_format($not_record);
                }

            ?>
                <tr id="tr_<?php echo $row['spare_used_id']; ?>">

                    <td><?php echo $i; ?></td>


                    <td>

                        <?php echo " [ " . $row['spare_type_name'] . " ] " . "<br>" . $row['spare_part_name'] . " ( " . $row['spare_part_code'] . " )"; ?>


                    </td>

                    <td class="text-right">
                        <?php echo number_format($row['aquan']); ?>
                    </td>

                    <td class="text-right">
                        <?php echo number_format($row_ax['total_ax']); ?>
                    </td>

                    <td class="text-right">
                        <?php echo $remain_ax; ?>
                    </td>

                    <td class="text-center">

                        <div class="form-group">
                            <button class="btn btn-sm btn-success " onclick="view_spare_used('<?php echo $row['aspare_id']; ?>');">ดูข้อมูล</button>
                        </div>
                    </td>



                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

<script>
    function delete_item_spare(spare_used_id)

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

                url: 'ajax/CM_view/delete_item.php',

                data: {

                    spare_used_id: spare_used_id

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
                        load_table_spare();
                        document.getElementById("total_spare").innerHTML = data.total_spare
                        document.getElementById("td_total").innerHTML = data.td_total
                        document.getElementById("spare_quantity").innerHTML = data.spare_quantity


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



    function view_spare_used(spare_used_id) {
        $.ajax({
            type: "post",
            url: "ajax/CM_view/Modal_view_spare_used.php",
            data: {
                spare_used_id: spare_used_id
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



    function edit_item_spare(spare_used_id, job_id)

    {

        $.ajax({
            type: "post",
            url: "ajax/CM_view/Modal_edit_spare_used.php",
            data: {
                spare_used_id: spare_used_id,
                job_id: job_id
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
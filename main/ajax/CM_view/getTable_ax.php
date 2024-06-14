<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$spare_used_id = $_POST['spare_used_id'];
?>

<div class="table-responsive">

    <table class="table table-striped table-hover table-bordered  tbl_Ax">

        <thead>

            <tr>

                <th width="10%"></th>

                <th width="20%" class="text-center">เลขที่อ้างอิง AX</th>

                <th width="20%" class="text-center">วันที่เบิก</th>

                <th width="20%" class="text-center">ผู้บันทึก</th>

                <th width="10%" class="text-center">จำนวน</th>



            </tr>

        </thead>

        <tbody>

            <?php

            $sql = "SELECT *FROM tbl_spare_used_ax a
            LEFT JOIN tbl_user b ON a.record_user_id = b.user_id
             WHERE a.spare_used_id = '$spare_used_id'";

            $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

            $i = 0;


            while ($row = mysqli_fetch_assoc($rs)) {

                $i++;

            ?>
                <tr id="tr_<?php echo $row['spare_used_id']; ?>">

                    <td class="text-center">
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger" type="button" onclick="delete_item_ax('<?php echo $row['id']; ?>');">ลบ</button>
                        </div>

                    </td>


                    <td class="text-center">
                        <?php echo $row['ax_ref_no']; ?>
                    </td>

                    <td class="text-center">
                        <?php echo date("d-m-Y", strtotime($row['ax_date'])); ?>
                    </td>

                    <td class="text-center">
                        <?php echo $row['fullname']; ?><br>
                        <?php echo  date("d-m-Y H:i:s", strtotime($row['create_datetime'])) ?>
                    </td>

                    <td class="text-center">
                        <?php echo number_format($row['quantity']); ?>
                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

<script>
    function delete_item_ax(id)

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

                url: 'ajax/CM_view/delete_item_ax.php',

                data: {

                    id: id

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
                        view_spare_used(data.spare_used_id);
                        load_table_spare();

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
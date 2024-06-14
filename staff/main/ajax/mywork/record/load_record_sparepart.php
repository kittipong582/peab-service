<?php

include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];

$sql_count = "SELECT COUNT(*) AS num FROM tbl_job_spare_used b 
LEFT JOIN tbl_spare_part c ON b.spare_part_id = c.spare_part_id
WHERE b.job_id = '$job_id'";
$rs_count = mysqli_query($connect_db, $sql_count) or die($connect_db->error);
$row_count = mysqli_fetch_assoc($rs_count);



?>
<style>
    .border-black {
        border: 1px solid black;
    }
</style>

<?php



$i = 0;

if ($row_count['num'] > 0) {

    $sql = "SELECT * FROM tbl_job a
LEFT JOIN tbl_job_spare_used b ON b.job_id = a.job_id
LEFT JOIN tbl_spare_part c ON b.spare_part_id = c.spare_part_id
LEFT JOIN tbl_warranty_type d ON b.insurance_type = d.warranty_type_id
LEFT JOIN tbl_customer_branch e ON e.customer_branch_id = a.customer_branch_id
LEFT JOIN tbl_customer f ON f.customer_id = e.customer_id
WHERE a.job_id = '$job_id'";
    // echo $sql;
    $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
    while ($row = mysqli_fetch_assoc($rs)) {
        $insurance = $row['warranty_type_name'];
        $i++;
        if ($row['insurance_status'] == 1) {
            $unit_price = 0;

            $cost = 0;
        } else {

            $unit_price = $row['unit_price'];

            $cost = $unit_price / $row['quantity'];
        }
?>



        <div class="ibox mb-3 d-block border-black">
            <div class="ibox-title">
                <b><?php echo $row['transfer_no'] ?></b>
                <?php if ($row['close_user_id'] == NULL) { ?>
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-xs btn-warning" onclick="edit_sparepart('<?php echo $row['spare_used_id']; ?>');"><i class="fa fa-plus"></i>
                                แก้ไขบันทึกอะไหล่</button>
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-xs btn-danger" onclick="remove_sparepart('<?php echo $row['spare_used_id']; ?>');"><i class="fa fa-plus"></i>
                                ลบบันทึกอะไหล่</button>
                        </div>
                    </div>
                <?php } ?>
                <div class="ibox-tools">

                </div>
            </div>
            <div class="ibox-content">
                <div class="row">


                    <div class="col-12">
                        <label><b>รายการอะไหล่</b></label><br> <?php echo " ( " . $row['spare_part_code'] . " ) " . "<br>" . $row['spare_part_name']; ?> x <?php echo number_format($row['quantity']); ?>
                        <br><label><?php echo $insurance; ?></label>
                    </div>

                </div>

                <br>

                <div class="row">
                    <br>
                    <div class="col-6">
                        <label><b>ราคาต่อหน่วย</b></label><br><?php echo number_format($cost, 2); ?>
                    </div>

                    <div class="col-6">
                        <label><b>ราคารวม</b></label><br><?php echo number_format($unit_price, 2); ?>
                    </div>

                </div>
                <br>
            </div>
        </div>

    <?php
    }
} else {
    ?>

    <br>
    <center>
        <h1> ไม่พบข้อมูลอะไหล่ </h1>
    </center>


<?php } ?>


<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {

    });

    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })

    function remove_sparepart(spare_used_id)

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
                url: 'ajax/mywork/record/delete_sparepart.php',
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
                        record_sparepart();
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


    function edit_sparepart(spare_used_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/sparepart/modal_edit_sparepart.php",
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
                $('#chkbox_edit').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            }
        });
    }
</script>
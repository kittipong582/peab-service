<?php

include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];


$sql_count_id = "SELECT count(*) as num_in FROM tbl_job_income b 
LEFT JOIN tbl_income_type c ON b.income_type_id = c.income_type_id
 WHERE b.job_id = '$job_id'";
$rs_count_id = mysqli_query($connect_db, $sql_count_id) or die($connect_db->error);
$row_count_in = mysqli_fetch_assoc($rs_count_id);

?>
<style>
    .border-black {
        border: 1px solid black;
    }
</style>

<?php

if ($row_count_in['num_in'] > 0) {

    $sql_income = "SELECT * FROM tbl_job a
LEFT JOIN tbl_job_income b ON b.job_id = a.job_id
LEFT JOIN tbl_income_type c ON b.income_type_id = c.income_type_id
WHERE a.job_id = '$job_id'";

    $rs_income = mysqli_query($connect_db, $sql_income) or die($connect_db->error);

    while ($row = mysqli_fetch_assoc($rs_income)) {

        $i++;

        $total_service = $row['quantity'] * $row['income_amount']

?>

        <div class="ibox mb-3 d-block border-black">
            <div class="ibox-title">
                <b><?php echo $row['transfer_no'] ?></b>
                <?php if ($row['close_user_id'] == NULL) { ?>
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-xs btn-warning" onclick="edit_item_service('<?php echo $row['job_income_id']; ?>');"><i class="fa fa-plus"></i> แก้ไขบันทึกบริการ</button>
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-xs btn-danger" onclick="delete_item_income('<?php echo $row['job_income_id']; ?>');"><i class="fa fa-plus"></i> ลบบันทึกบริการ</button>
                        </div>

                    </div>
                <?php } ?>
            </div>
            <div class="ibox-content">
                <div class="row">

                    <div class="col-12">
                        <label><b>รายการ</b></label><br><?php echo $row['income_type_name']; ?> x <?php echo number_format($row['quantity']); ?>
                    </div>

                </div>

                <br>

                <div class="row">
                    <br>
                    <div class="col-6">
                        <label><b>ราคาต่อหน่วย</b></label><br><?php echo number_format($row['income_amount'],2); ?>
                    </div>

                    <div class="col-6">
                        <label><b>ราคารวม</b></label><br><?php echo number_format($total_service,2) ?>
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
        <h1> ไม่พบข้อมูลบริการ </h1>
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

                url: 'ajax/mywork/service/delete_item.php',

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

                        record_service();

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



    function edit_item_service(job_income_id) {
        $.ajax({
            type: "post",
            url: "ajax/mywork/service/modal_edit_service.php",
            data: {
                job_income_id: job_income_id
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
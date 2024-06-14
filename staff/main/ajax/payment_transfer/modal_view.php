<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$deposit_id = $_POST['deposit_id'];


$sql = "SELECT a.*,c.account_no,c.account_name FROM tbl_bank_deposit a 
LEFT JOIN tbl_bank_deposit_detail b ON a.deposit_id = b.deposit_id
LEFT JOIN tbl_account c ON a.account_id = c.account_id
WHERE a.deposit_id = '$deposit_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);

// echo $sql;

?>
<style>
    .select2-dropdown {
        z-index: 9999999;
    }
</style>
<form action="" method="post" id="form_deposit" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>การเงินฝากเลขที่ <?php echo $row['deposit_no'] ?></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body" style="padding-bottom: 0;">

        <div class="row mb-3">



            <div class="mb-3 col-8">
                <label for=""><b>วันที่ฝาก</b></label><br>
                <label for=""><?php echo date("d-M-Y", strtotime($row['deposit_date'])); ?></label><br>
            </div>

            <div class="mb-3 col-4">

                <label for=""><b>เวลาที่ฝาก</b></label><br>
                <?php echo date("H:i", strtotime($row['deposit_hour'] . $row['deposit_min'])) ?>
            </div>


            <div class="mb-3 col-8">
                <label for=""><b>วันที่ทำรายการ</b></label><br>
                <label for=""><?php echo date("d-M-Y H:i", strtotime($row['create_datetime'])); ?></label><br>
            </div>

            <div class="mb-3 col-4" id="acc_point">
                <label for=""><b>ยอดเงินฝาก</b></label><br>
                <label for=""><?php echo number_format($row['deposit_amount'], 2); ?></label><br>
            </div>


            <div class="mb-3 col-8">
                <label for=""><b>บัญชีที่รับเงิน</b></label><br>
                <?php echo  $row['account_name'] ?><br>
                <?php echo substr($row['account_no'], 0, 3) . '-' . substr($row['account_no'], 3, 5) . '-' . substr($row['account_no'], 8, 2); ?><br>
            </div>

            <div class="mb-3 col-4">
                <label for=""><b>หลักฐาน</b></label><br>
                <?php if ($row['deposit_file'] != null) { ?>
                    <a target="_blank" href="../../../main/upload/payment_img/<?php echo $row['deposit_file']; ?>" data-lity>
                        คลิก
                    </a>
                <?php } else {
                    echo "-";
                } ?>
            </div>

            <div class="mb-1 col-8">
                <label for=""><b>รายการ</b></label><br>
            </div>

            <div class="mb-1 col-4">
                <label for=""><b>ยอดโอน</b></label><br>
            </div>

            <?php
            $job_no_array = array();
            $sql_detail = "SELECT a.deposit_amount,b.ref_type,b.job_id FROM tbl_bank_deposit_detail a 
            LEFT JOIN tbl_job_payment_file b ON a.payment_id = b.payment_id
             WHERE a.deposit_id = '{$row['deposit_id']}'";

            $rs_detail = mysqli_query($connect_db, $sql_detail) or die($connect_db->error);
            while ($row_detail = mysqli_fetch_assoc($rs_detail)) {


                if ($row_detail['ref_type'] == 1) {
                    $sql_job = "SELECT job_no FROM tbl_job WHERE job_id = '{$row_detail['job_id']}'";
                    $rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
                    $row_job = mysqli_fetch_assoc($rs_job);

                    $temp = array(
                        "job_no" => $row_job['job_no'],
                        "deposit_amount" => $row_detail['deposit_amount']
                    );


                    array_push($job_no_array, $temp);
                } else if ($row_detail['ref_type'] == 2) {

                    $comma = '';
                    $sql_job = "SELECT b.job_no FROM tbl_group_pm_detail a 
                    LEFT JOIN tbl_job b ON a.job_id = b.job_id 
                    WHERE a.group_pm_id = '{$row_detail['job_id']}'";
                    $rs_job = mysqli_query($connect_db, $sql_job) or die($connect_db->error);
                    while ($row_job = mysqli_fetch_assoc($rs_job)) {

                        $no_job .= $comma . $row_job['job_no'];
                        $comma = ',';
                    }
                    $temp = array(
                        "job_no" => "กลุ่มงาน PM  <br/> ( " . $no_job . " )",
                        "deposit_amount" => $row_detail['deposit_amount']
                    );

                    array_push($job_no_array, $temp);
                }
            }
            ?>

            <?php foreach ($job_no_array as $job_no) { ?>
                <div class="mb-1 col-8">
                    <label for=""><?php echo $job_no['job_no'] ?></label><br>
                </div>

                <div class="mb-1 col-4">
                    <label for=""><?php echo number_format($job_no['deposit_amount']) ?></label><br>
                </div>


            <?php }
            ?>



        </div>
        <!-- <hr> -->

    </div>


</form>
<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
    <!-- <button class="btn btn-success btn-sm" type="button" id="submit" onclick="Submit_desorit()">บันทึก</button> -->
</div>


<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {



        $('.summernote').summernote({
            toolbar: false,
            height: 100,
        });

        $(".select2").select2({});
    });



    $('.chkall').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    }).on('ifChanged', function(e) {
        if (this.checked) {
            $('.chkbox').each(function() {
                $(this).iCheck('check');
            })
        } else {
            $('.chkbox').each(function() {
                $(this).iCheck('uncheck');
            })
        }
    });



    $('.chkbox').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    }).on('ifChanged', function(e) {


        $("input[name=select_status]:checked").each(function() {
            var S_order = $(this).val();
            array.push(S_order);
        });

    });


    function GetAcc(account_type) {


        $.ajax({
            type: "post",
            url: "ajax/payment_transfer/Get_account.php",
            data: {
                account_type: account_type
            },
            dataType: "html",
            success: function(response) {
                $('#acc_point').html(response);

                $(".select2").select2({});
            }
        });
    }


    function ImageReadURL(input, value, show_position) {
        var fty = ["jpg", "jpeg", "png", "JPG", "JPEG", "PNG"];
        var permiss = 0;
        var file_type = value.split('.');
        file_type = file_type[file_type.length - 1];
        if (jQuery.inArray(file_type, fty) !== -1) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else if (value == "") {
            $('#blah').attr('src', 'uploads/upload.png');
            $(input).val("");
        } else {
            swal({
                title: "เกิดข้อผิดพลาด!",
                text: "อัพโหลดได้เฉพาะไฟล์นามสกุล (.jpg .jpeg .png) เท่านั้น!",
                type: "warning"
            });
            $('#blah').attr('src', 'uploads/upload.png');
            $(input).val("");
            return false;
        }
    }


    function Submit_desorit() {
        // var job_id = $('#job_id').val();
        // var form_id = $('#form_id').val();
        var formData = new FormData($("#form_deposit")[0]);

        // if (job_id == "") {
        //     swal({
        //         title: 'เกิดข้อผิดพลาด',
        //         text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
        //         type: 'error'
        //     });
        //     return false;
        // }

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
                url: 'ajax/payment_transfer/Insert_deposit.php',
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
                            Getdata();
                        });
                    }
                    if (data.result == 0) {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            text: "บันทึกผิดพลาด",
                            type: "error",
                        });
                    }
                }

            })
        });
    }
</script>
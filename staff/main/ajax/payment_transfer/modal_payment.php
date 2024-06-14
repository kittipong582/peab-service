<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = $_SESSION['user_id'];
$work_list = array();

$sql = "SELECT a.*,b.responsible_user_id,b.job_no,d.customer_name,a.job_id FROM tbl_job_payment_file a
LEFT JOIN tbl_job b ON a.job_id = b.job_id
LEFT JOIN tbl_customer_branch c ON b.customer_branch_id = c.customer_branch_id
LEFT JOIN tbl_customer d ON c.customer_id = d.customer_id
WHERE a.ref_type = 1 AND b.responsible_user_id = '$user_id' AND cash_amount > 0  AND b.job_id NOT in(select b.job_id from tbl_group_pm a LEFT JOIN tbl_group_pm_detail b ON a.group_pm_id = b.group_pm_id)";
$rs  = mysqli_query($connect_db, $sql);
// echo $sql;
while ($row = mysqli_fetch_array($rs)) {
    $temp_array = array(

        "create_datetime" => $row['create_datetime'],
        "job_no" => $row['job_no'],
        "customer_name" => $row['customer_name'],
        "ref_type" => $row['ref_type'],
        "job_id" => $row['job_id'],
        "responsible_user_id" => $row['responsible_user_id'],
        "payment_id" => $row['payment_id'],
        "cash_amount" => $row['cash_amount']
    );

    array_push($work_list, $temp_array);
}


$sql_chk = "SELECT b.*,a.responsible_user_id FROM tbl_group_pm a
LEFT JOIN tbl_job_payment_file b ON a.group_pm_id = b.job_id 
WHERE b.ref_type = 2  AND a.responsible_user_id = '$user_id'";
$result_chk  = mysqli_query($connect_db, $sql_chk);


while ($row_chk = mysqli_fetch_array($result_chk)) {

    $job_no = "";

    $sql_detail = "SELECT b.job_no,e.customer_name FROM tbl_group_pm_detail a 
    LEFT JOIN tbl_job b ON a.job_id = b.job_id 
LEFT JOIN tbl_customer_branch d ON b.customer_branch_id = d.customer_branch_id
LEFT JOIN tbl_customer e ON d.customer_id = e.customer_id
    WHERE a.group_pm_id = '{$row_chk['job_id']}'";
    $rs_detail = mysqli_query($connect_db, $sql_detail) or die($connect_db->error);
    while ($row_detail = mysqli_fetch_assoc($rs_detail)) {

        $job_no .=  $row_detail['job_no'] . '<br/>';
        $customer_name = $row_detail['customer_name'];
    }

    $temp_array = array(

        "create_datetime" => $row_chk['create_datetime'],
        "job_no" => "PM กลุ่ม " . "<br/>" . $job_no,
        "customer_name" => $customer_name,
        "ref_type" => $row_chk['ref_type'],
        "job_id" => $row_chk['job_id'],
        "responsible_user_id" => $row_chk['responsible_user_id'],
        "payment_id" => $row_chk['payment_id'],
        "cash_amount" => $row_chk['cash_amount']
    );

    array_push($work_list, $temp_array);
}

// var_dump($work_list);
?>
<style>
    .select2-dropdown {
        z-index: 9999999;
    }
</style>
<form action="" method="post" id="form_deposit" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>บันทึกฝากเงิน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body" style="padding-bottom: 0;">


        <input type="hidden" id="payment_list" name="payment_list[]" value=""></input>
        <div class="row mb-3">

            <div class="col-12">
                <div class="table-responsive">
                    <table class="w-100 table-striped" style="width: 100%;">

                        <thead>

                            <tr>

                                <!-- <th width="20%"><input type="checkbox" class="icheckbox_square-green chkall" name="chkall" id="chkall"> </th> -->

                                <th width="20%" class="text-center">เลขที่งาน</th>

                                <th width="20%" class="text-center">ลูกค้า</th>

                                <th width="20%" class="text-center">ยอดรวม</th>

                                <!-- <th width="20%" class="text-center"></th> -->

                                <th width="20%" class="text-center">ยอดโอน</th>


                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $i = 0;
                            // echo $sql;
                            foreach ($work_list as $row) {


                                $create_datetime = date("d-m-Y H:i", strtotime($row['create_datetime']));
                                $job_no = $row['job_no'];
                                $customer_name = $row['customer_name'];
                                $array_job = array();


                                $sql_user = "SELECT fullname FROM tbl_user WHERE user_id = '{$row['responsible_user_id']}'";
                                $rs_user = mysqli_query($connect_db, $sql_user) or die($connect_db->error);
                                $row_user = mysqli_fetch_assoc($rs_user);

                                // echo $sql_user;

                                $old_amount = 0;
                                $sql_chk = "SELECT deposit_amount FROM tbl_bank_deposit_detail WHERE payment_id = '{$row['payment_id']}'";
                                $rs_chk = mysqli_query($connect_db, $sql_chk) or die($connect_db->error);

                                $num_chk = mysqli_num_rows($rs_chk);

                                if ($num_chk > 0) {
                                    while ($row_chk = mysqli_fetch_assoc($rs_chk)) {

                                        $old_amount += $row_chk['deposit_amount'];
                                    }
                                }

                                $i++;

                            ?>
                                <tr id="tr_<?php echo $row['payment_id']; ?>" class="mb-3">

                                    <!-- <td class=" mb-2">
                                    <input type="checkbox" class="icheckbox_square-green chkbox" value="<?php echo $row['payment_id']; ?>" name="select_status[]" id="select_status">
                                </td> -->

                                    <td class="text-center mb-2">

                                        <?php echo $job_no; ?><br>
                                        <?php echo $create_datetime; ?>
                                    </td>

                                    <td class="text-center mb-2">

                                        <?php echo $customer_name; ?><br>

                                    </td>

                                    <td class="text-right mb-2">

                                        <?php echo number_format($row['cash_amount'] - $old_amount) ?>
                                        <input type="hidden" id="amount_for_cal_<?php echo $i ?>" value="<?php echo ($row['cash_amount'] - $old_amount) ?>">

                                    </td>



                                    <!-- <td class="text-right mb-2">
                                    </td> -->


                                    <td class="text-right mb-2">

                                        <input type="text" style="text-align:right;" onchange="cal_total('<?php echo $i ?>');" class="form-control input_amount" id="input_amount_<?php echo $i ?>" name="amount[]" value="0">


                                        <input type="hidden" style="text-align:right;" class="form-control " id="payment_<?php echo $i ?>" name="payment" value="<?php echo $row['payment_id']; ?>">
                                    </td>



                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>
                </div>
            </div>


        </div>

        <div class="row mb-3">

            <input type="hidden" id="all_payment_id" value="" readonly name="all_payment_id" class="form-control">

            <div class="mb-3 col-6">
                <label for="">ยอดโอนทั้งหมด</label><br>
                <input type="text" id="total_amount" value="" readonly name="total_amount" class="form-control">
            </div>

            <div class="mb-3 col-6">

                <label for="">ค่าธรรมเนียม (บาท)</label><br>
                <input type="text" id="fee" value="" name="fee" class="form-control">

            </div>


            <div class="mb-3 col-12">
                <label for="">ประเภทบัญชี</label><br>
                <select class="form-control select2" id="account_type" name="account_type" onchange="GetAcc(this.value)" data-width="100%">
                    <option value="">กรุณาเลือกประเภทบัญชี</option>
                    <option value="1">บัญชี ptt</option>
                    <option value="2">บัญชีทั่วไป</option>
                </select>
            </div>

            <div class="mb-3 col-12" id="acc_point">
                <label for="">บัญชี</label><br>
                <select class="form-control select2" id="account_id" name="account_id" data-width="100%">
                    <option value="">กรุณาเลือกบัญชี</option>

                </select>
            </div>


            <div class="mb-3 col-12">
                <label for="">วันที่โอน</label><br>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="deposit_date" readonly name="deposit_date" class="form-control datepicker" value="" autocomplete="off">
                </div>
            </div>

            <div class="mb-3 col-6">
                <label for="">เวลาโอน</label><br>
                <select class="form-control select2" id="deposit_hour" name="deposit_hour" data-width="100%">
                    <option value="">กรุณาเลือกชั่วโมง</option>
                    <?php $i = 0;
                    $h = 2;
                    while ($i <= 23) {
                        $time = sprintf("%0" . $h . "d", $i); ?>
                        <option value="<?php echo $time ?>"><?php echo $time ?></option>

                    <?php $i++;
                    } ?>
                </select>
            </div>

            <div class="mb-3 col-6">
                <label for=""><br></label><br>
                <select class="form-control select2" id="deposit_min" name="deposit_min" data-width="100%">
                    <option value="">กรุณาเลือกนาที</option>
                    <?php $i = 0;
                    $h = 2;
                    while ($i <= 59) {
                        $time = sprintf("%0" . $h . "d", $i); ?>
                        <option value="<?php echo $time ?>"><?php echo $time ?></option>

                    <?php $i++;
                    } ?>
                </select>
            </div>


            <div class="mb-3 col-12 ">
                <label for="">หมายเหตุ</label><br>
                <textarea class="summernote" id="note" name="note"></textarea>
            </div>
            <div class="col-12 mb-3" id="img">
                <div class="BroweForFile1">
                    <div id="show_image">
                        <label for="upload_file">
                            <a>
                                <img id="blah" src="upload/No-Image.png" width="100" height="150" />
                            </a>
                        </label>
                    </div><br />
                    <input type="file" id="upload_file" style="width:225px;" name="image1" onchange="ImageReadURL(this,value);">
                </div>
            </div>


        </div>
        <!-- <hr> -->

    </div>


</form>
<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"> ปิด</button>
    <button class="btn btn-success btn-sm" type="button" id="submit" onclick="Submit_desorit()">บันทึก</button>
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



    function cal_total(i, payment_id) {

        var final = 0;
        var newArray = [];
        var num = 1;


        var amount_cal = $('#amount_for_cal_' + i).val();
        var input_amount = $('#input_amount_' + i).val();
        // alert(input_amount > amount_cal);
        if (parseFloat(input_amount) > parseFloat(amount_cal)) {

            // alert("test");
            swal({
                title: "เกิดข้อผิดพลาด",
                text: "ไม่สามารถใส่จำนวนเกินได้",
                type: "error",
            });

            $('#input_amount_' + i).val('0');
            $('#total_amount').val('0');

        } else {


            $(".input_amount").each(function(index) {

                if ($(this).val() != 0) {
                    final += parseFloat($(this).val() || 0);
                }

                if ($(this).val() != 0 && $(this).val() != "") {

                    var payment_id = $("#payment_" + num).val();

                    newArray.push(payment_id);


                }
                num++;

            });



            $('#all_payment_id').val(newArray);
            $('#total_amount').val(final);
        }
    }


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
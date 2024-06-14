<?php
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql = "SELECT a.*,c.customer_id FROM tbl_job a
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
 WHERE a.job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$sql_chk = "SELECT * FROM tbl_customer_payment WHERE customer_id = '{$row['customer_id']}' AND job_type = '{$row['job_type']}'";
$result_chk  = mysqli_query($connect_db, $sql_chk);
$row_chk = mysqli_fetch_array($result_chk);
// echo $sql_chk;

///////////////sql อะไหล่
$sql_spare = "SELECT SUM(unit_price) AS total FROM tbl_job_spare_used WHERE job_id = '$job_id'";
$result_spare  = mysqli_query($connect_db, $sql_spare);
$row_spare = mysqli_fetch_array($result_spare);

////////////////////////sql ค่าบริการ
$sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$job_id'";
$result_income  = mysqli_query($connect_db, $sql_income);
while ($row_income = mysqli_fetch_array($result_income)) {

    $service_total += $row_income['quantity'] * $row_income['income_amount'];
}
/////ทั้งหมด///ค่าบริการทั้งหมด////ค่าอะไหล่ทั้งหมด////////////////////
$all_total = $service_total + $row_spare['total'];


$customer_cost = 0;
$branch_cost = 0;

if ($row_chk['spare_cost'] == 1 && $row_chk['service_cost'] == 1) {
    $customer_cost = $all_total;
} else if ($row_chk['spare_cost'] == 2 && $row_chk['service_cost'] == 2) {
    $branch_cost = $all_total;
} else {
    if ($row_chk['spare_cost'] == 1) {
        $customer_cost = $row_spare['total'];
    } else {
        $branch_cost = $row_spare['total'];
    }

    if ($row_chk['service_cost'] == 1) {
        $customer_cost = $service_total;
    } else {
        $branch_cost = $service_total;
    }
}
?>
<style>
    .select2-dropdown {
        z-index: 9999999;
    }
</style>
<form action="" method="post" id="form-add_payment" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>บันทึกการจ่ายเงิน</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" class="form-control" id="main_customer_cost" value="<?php echo number_format($customer_cost) ?>">

        <input type="hidden" class="form-control" id="main_branch_cost" value="<?php echo number_format($branch_cost) ?>">

        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
            <div class="col-12 mb-3">
                <strong><label for="">
                        ค่าอะไหล่
                    </label></strong><br>
                <input type="text" readonly class="form-control" name="spare_total" id="spare_total" value="<?php echo number_format($row_spare['total']) ?>">
            </div>
            <div class="col-12 mb-3">
                <strong><label for="">
                        ค่าบริการ
                    </label></strong><br>
                <input type="text" readonly class="form-control" name="service_total" value="<?php echo number_format($service_total) ?>">
            </div>
            <div class="col-12 mb-3">
                <strong><label for="">
                        ยอดรวมทั้งสิ้น test
                    </label></strong><br>
                <input type="text" readonly class="form-control" name="all_total" id="all_total" value="<?php echo number_format($all_total) ?>">
            </div>

            <div class="col-12 mb-3" id="transfer">
                <label for="quantity">
                    วางบิล
                </label>
                <font color="red">**</font><br>
                <input type="text" id="customer_cost" onchange="chk_total()" name="customer_cost" value="<?php echo $customer_cost ?>" class="form-control">
            </div>

            <div class="col-12 mb-3" id="cash">
                <label for="quantity">
                    เก็บจากหน้าร้าน
                </label>
                <font color="red">**</font><br>
                <input type="text" id="branch_cost" onchange="chk_total()" name="branch_cost" value="<?php echo $branch_cost ?>" class="form-control">
            </div>

            <div class="col-12 mb-3" id="cash">
                <label for="quantity">
                    เงินสด
                </label>
                <font color="red">**</font><br>
                <input type="text" id="cash_amount" onchange="check_amount()" name="cash_amount" value="0" class="form-control">
            </div>
            <div class="col-12 mb-3" id="transfer">
                <label for="quantity">
                    เงินโอน
                </label>
                <font color="red">**</font><br>
                <input type="text" id="transfer_amount" onchange="check_amount()" name="transfer_amount" value="0" class="form-control">
            </div>

            <div class="col-12 mb-3" id="bank">
                <label for="quantity">
                    บัญชีโอนเงิน
                </label>
                <font color="red">**</font><br>
                <select class="form-control select2" style="width: 100%;" id="account_id" name="account_id">
                    <option value="">กรุณาเลือกบัญชี</option>
                    <?php $sql_acc = "SELECT * FROM tbl_account a LEFT JOIN tbl_bank b ON a.bank_id = b.bank_id";
                    $result_acc  = mysqli_query($connect_db, $sql_acc);
                    while ($row_acc = mysqli_fetch_array($result_acc))
                      { ?>
                        <option value="<?php echo $row_acc['account_id'] ?>"><?php echo "(" . $row_acc['bank_name'] . ") ชื่อ " . $row_acc['account_name'] . " สาขา " . $row_acc['bank_branch_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-12 mb-3" id="transfer">
                <label for="quantity">
                    วางบิล
                </label>
                <font color="red">**</font><br>
                <input type="text" id="customer_cost" onchange="chk_total()" name="customer_cost" value="<?php echo $customer_cost ?>" class="form-control">
            </div>

            <div class="col-12 mb-3" id="note">
                <label for="quantity">
                    หมายเหตุ
                </label><br>
                <textarea type="text" id="payment_note" name="payment_note" class="form-control summernote"></textarea>
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
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $(".select2").select2({});

        $('.summernote').summernote({
            toolbar: false,
            height: 100,
        });



    });


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


    function chk_total() {

        var branch_cost = $('#branch_cost').val();
        var customer_cost = $('#customer_cost').val();
        var chk_price = parseInt(branch_cost) + parseInt(customer_cost);
        var all_total = $('#all_total').val();

        console.log(parseInt(chk_price));
        if (parseInt(chk_price) > parseInt(all_total.replace(",", ""))) {


            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถกรอกตัวเลขเกินยอดรวม',
                type: 'error'
            });
            var main_branch_cost = $('#main_branch_cost').val();
            var main_customer_cost = $('#main_customer_cost').val();
            $('#branch_cost').val(main_branch_cost);
            $('#customer_cost').val(main_customer_cost);
            return false;
        }

    }



    function check_amount() {

        var branch_cost = $('#branch_cost').val();
        var cash_amount = $('#cash_amount').val();
        var transfer_amount = $('#transfer_amount').val();
        var branch_amount = parseInt(transfer_amount) + parseInt(cash_amount);

        if (parseInt(branch_amount) > parseInt(branch_cost.replace(",", ""))) {

            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถกรอกตัวเลขเกินยอดร้านได้',
                type: 'error'
            });
            $('#cash_amount').val('0');
            $('#transfer_amount').val('0');
            return false;
        }

    }

    function Submit() {

        var payment_type = $('#payment_type').val();
        var formData = new FormData($("#form-add_payment")[0]);
        if (payment_type == '') {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
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
                url: 'ajax/mywork/payment/Add_job_payment.php',
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




                    } else {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'ชื่อผู้ใช้ซ้ำ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });




    }
</script>
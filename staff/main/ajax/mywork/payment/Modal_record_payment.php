<?php
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$ref_type = $_POST['ref_type'];

$sql_group = "SELECT * FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
$result_group  = mysqli_query($connect_db, $sql_group);
$num_group = mysqli_num_rows($result_group);


if ($ref_type == 2) {
    $service_total = 0;
    $spare_total = 0;
    $sql_detail = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '$job_id'";
    $rs_detail = mysqli_query($connect_db, $sql_detail) or die($connect_db->error);
    while ($row_detail = mysqli_fetch_assoc($rs_detail)) {


        $sql = "SELECT a.*,c.customer_id,c.bill_type,c.business_group_id FROM tbl_job a
        LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
        LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
        WHERE a.job_id = '{$row_detail['job_id']}'";
        $result  = mysqli_query($connect_db, $sql);
        $row = mysqli_fetch_array($result);


        ///////////////sql อะไหล่
        $sql_spare = "SELECT SUM(unit_price) AS total FROM tbl_job_spare_used WHERE job_id = '{$row['job_id']}'";
        $result_spare  = mysqli_query($connect_db, $sql_spare);
        $row_spare = mysqli_fetch_array($result_spare);

        ////////////////////////sql ค่าบริการ
        $sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '{$row['job_id']}'";
        $result_income  = mysqli_query($connect_db, $sql_income);
        $row_income = mysqli_fetch_array($result_income);

        $service = $row_income['quantity'] * $row_income['income_amount'];

        /////ทั้งหมด///ค่าบริการทั้งหมด////ค่าอะไหล่ทั้งหมด////////////////////

        $service_total += $service;
        $spare_total += $row_spare['total'];
    }


    $all_total = $service_total + $spare_total; //////////////////ราคารวม

    $percent_service = round(($service_total / $all_total) * 100); ///////////////// %ของบริการ
    $percent_spare = round(($spare_total / $all_total) * 100); ///////////////// %ของอะไหล่

    $vat_total = ($all_total / 100) * 7; ////////////// ยอดvat
    // $service_total = ($service_total != 0) ? round(($service_total + (($vat_total / 100) * $percent_service)), 2) : 0; ///////////////////////////บริการแยกvat
    // $spare_total = ($spare_total != 0) ? round(($spare_total + (($vat_total / 100) * $percent_spare)), 2) : 0; ///////////////////////////บริการแยกvat


    $all_total = ($all_total +  $vat_total);
} else {
    $sql = "SELECT a.*,c.customer_id,c.bill_type,c.business_group_id FROM tbl_job a
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
    LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
    WHERE a.job_id = '$job_id'";
    $result  = mysqli_query($connect_db, $sql);
    $row = mysqli_fetch_array($result);

    ///////////////sql อะไหล่
    $sql_spare = "SELECT SUM(unit_price) AS total FROM tbl_job_spare_used WHERE job_id = '$job_id'";
    $result_spare  = mysqli_query($connect_db, $sql_spare);
    $row_spare = mysqli_fetch_array($result_spare);

    $spare_total = $row_spare['total'];
    ////////////////////////sql ค่าบริการ
    $sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$job_id'";
    $result_income  = mysqli_query($connect_db, $sql_income);

    while ($row_income = mysqli_fetch_array($result_income)) {

        $service_total += $row_income['quantity'] * $row_income['income_amount'];
    }


    /////ทั้งหมด///ค่าบริการทั้งหมด////ค่าอะไหล่ทั้งหมด////////////////////
    $all_total = $service_total + $spare_total; //////////////////ราคารวม

    $percent_service = round(($service_total / $all_total) * 100); ///////////////// %ของบริการ
    $percent_spare = round(($spare_total / $all_total) * 100); ///////////////// %ของอะไหล่

    $vat_total = ($all_total / 100) * 7; ////////////// ยอดvat
    // $service_total = ($service_total != 0) ? round(($service_total + (($vat_total / 100) * $percent_service)), 2) : 0; ///////////////////////////บริการแยกvat
    // $spare_total = ($spare_total != 0) ? round(($spare_total + (($vat_total / 100) * $percent_spare)), 2) : 0; ///////////////////////////บริการแยกvat

    $all_total = ($all_total +  $vat_total);
    // echo $service_total;
    // echo "<br/>";
    // echo $spare_total;
}



$sql_chk = "SELECT * FROM tbl_customer_payment WHERE customer_id = '{$row['customer_id']}' AND job_type = '$ref_type'";
$result_chk  = mysqli_query($connect_db, $sql_chk);
$row_chk = mysqli_fetch_array($result_chk);
// echo $sql_chk;



$customer_cost = 0;
$branch_cost = 0;
$only = '';
$business_id = '';
if ($row['bill_type'] == 1) {
    if ($row_chk['spare_cost'] == 1 && $row_chk['service_cost'] == 1) {
        $customer_cost = $all_total;
    } else if ($row_chk['spare_cost'] == 2 && $row_chk['service_cost'] == 2) {
        $branch_cost = $all_total;
    } else {
        if ($row_chk['spare_cost'] == 1) {
            $customer_cost = $spare_total;
        } else {
            $branch_cost = $spare_total;
        }

        if ($row_chk['service_cost'] == 1) {
            $customer_cost = $service_total;
        } else {
            $branch_cost = $service_total;
        }
    }
} else if ($row['bill_type'] == 2) {
    if ($row['job_type'] == 2) {
        $customer_cost = $all_total;
        $branch_cost = '0';

        $only = 'readonly';

        $business_id = $row['business_group_id'];
    } else {
        if ($row_chk['spare_cost'] == 1 && $row_chk['service_cost'] == 1) {
            $customer_cost = $all_total;
        } else if ($row_chk['spare_cost'] == 2 && $row_chk['service_cost'] == 2) {
            $branch_cost = $all_total;
        } else {
            if ($row_chk['spare_cost'] == 1) {
                $customer_cost = $spare_total;
            } else {
                $branch_cost = $spare_total;
            }

            if ($row_chk['service_cost'] == 1) {
                $customer_cost = $service_total;
            } else {
                $branch_cost = $service_total;
            }
        }
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
        <input type="hidden" class="form-control" id="main_customer_cost" value="<?php echo number_format($customer_cost, 2) ?>">
        <input id="business_group_id" name="business_group_id" value="<?php echo $business_id ?>" type="hidden">
        <input id="customer_id" name="customer_id" value="<?php echo $row['customer_id'] ?>" type="hidden">
        <input type="hidden" class="form-control" id="main_branch_cost" value="<?php echo number_format($branch_cost, 2) ?>">
        <input id="ref_type" name="ref_type" value="<?php echo $ref_type ?>" type="hidden">

        <div class="row">
            <input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">

            <div class="col-12 mb-3">
                <strong><label for="">
                        ค่าอะไหล่
                    </label></strong><br>
                <input type="text" readonly class="form-control" name="total_spare" id="total_spare" value="<?php echo number_format($spare_total, 2) ?>">
            </div>
            <div class="col-12 mb-3">
                <strong><label for="">
                        ค่าบริการ
                    </label></strong><br>
                <input type="text" readonly class="form-control" name="service_total" value="<?php echo number_format($service_total, 2) ?>">
            </div>

            <div class="col-12 mb-3">
                <strong><label for="">
                        ยอดรวมทั้งสิ้น (+vat 7%)
                    </label></strong><br>
                <input type="text" readonly class="form-control" name="all_total" id="all_total" value="<?php echo number_format($all_total, 2) ?>">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 mb-3" id="transfer">
                <label for="quantity">
                    วางบิล
                </label>
                <font color="red">**</font><br>
                <input type="text" id="customer_cost" <?php echo $only ?> onchange="chk_total()" name="customer_cost" value="<?php echo $customer_cost ?>" class="form-control">
            </div>

            <div class="col-12 mb-3" id="cash">
                <label for="quantity">
                    เก็บจากหน้าร้าน
                </label>
                <font color="red">**</font><br>
                <input type="text" id="branch_cost" <?php echo $only ?> onchange="chk_total()" name="branch_cost" value="<?php echo $branch_cost ?>" class="form-control">
            </div>

            <div class="col-12 mb-3" id="cash">
                <label for="quantity">
                    เงินสด
                </label>
                <font color="red">**</font><br>
                <input type="text" id="cash_amount" <?php echo $only ?> onchange="check_amount()" name="cash_amount" value="0" class="form-control">
            </div>
            <div class="col-12 mb-3" id="transfer">
                <label for="quantity">
                    เงินโอน
                </label>
                <font color="red">**</font><br>
                <input type="text" id="transfer_amount" <?php echo $only ?> onchange="check_amount()" name="transfer_amount" value="0" class="form-control">
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
                    while ($row_acc = mysqli_fetch_array($result_acc)) { ?>
                        <option value="<?php echo $row_acc['account_id'] ?>"><?php echo "(" . $row_acc['bank_name'] . ") ชื่อ " . $row_acc['account_name'] . " สาขา " . $row_acc['bank_branch_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <!-- 
            <div class="col-12 mb-3" id="transfer">
                <label for="quantity">
                    วางบิล
                </label>
                <font color="red">**</font><br>
                <input type="text" id="customer_cost" onchange="chk_total()" name="customer_cost" value="<?php echo $customer_cost ?>" class="form-control">
            </div> -->

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
                    <input type="file" id="upload_file" style="width:225px;" name="image1[]" multiple onchange="ImageReadURL(this,value);">
                </div>
            </div>







        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit1()">บันทึก</button>
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




    
</script>
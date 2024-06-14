<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];
$group_pm_id = $_POST['group_pm_id'];


// echo $sql;
$sql_check = "SELECT * FROM tbl_group_pm WHERE group_pm_id = '$group_pm_id'";
$result_check  = mysqli_query($connect_db, $sql_check);
$row_check = mysqli_fetch_array($result_check);
$num_chk = mysqli_num_rows($result_check);
// echo $row_check['num_chk'];
?>

<form method="post" id="form-add_group" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">
            <strong>รวมยอดงาน</strong>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">


        <div class="row">
            <input type="hidden" id="group_pm_id" name="group_pm_id" value="<?php echo $group_pm_id ?>">
            <div class="col-mb-3 col-12" id="Loading_job">
                <div class="spiner-example">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div>
            <div class="col-mb-3 col-12" id="show_table_pm_payment">
            </div>

        </div>

        <?php



        $sql_job = "SELECT * FROM tbl_group_pm_detail WHERE group_pm_id = '$group_pm_id'";
        $rs_job = mysqli_query($connect_db, $sql_job);





        while ($row_job = mysqli_fetch_array($rs_job)) {

            $sql_job1 = "SELECT a.*,b.*,c.bill_type,c.business_group_id FROM tbl_job a 
            LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
            LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
            WHERE job_id = '{$row_job['job_id']}'";
            $result_job1  = mysqli_query($connect_db, $sql_job1);
            $row_job1 = mysqli_fetch_array($result_job1);

            $sql_spare = "SELECT IFNULL(SUM(unit_price),0) AS totall,IFNULL(SUM(quantity),0) AS sum_spare FROM tbl_job_spare_used WHERE job_id = '{$row_job['job_id']}'";
            $result_spare  = mysqli_query($connect_db, $sql_spare);
            $row_spare = mysqli_fetch_array($result_spare);
            $sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '{$row_job['job_id']}'";
            $result_income  = mysqli_query($connect_db, $sql_income);
            while ($row_income = mysqli_fetch_array($result_income)) {

                $income_total += $row_income['quantity'] * $row_income['income_amount'];
            }
            $total_spare += $row_spare['totall'];
        }
        $all_total += $income_total + $total_spare;
        $sql_chk = "SELECT * FROM tbl_customer_payment WHERE customer_id = '{$row_job1['customer_id']}' AND job_type = '2'";
        $result_chk  = mysqli_query($connect_db, $sql_chk);
        $row_chk = mysqli_fetch_array($result_chk);

        $business_id = '';
        
        if ($row_job1['bill_type'] == 1) {
            if ($row_chk['spare_cost'] == 1 && $row_chk['service_cost'] == 1) {
                $customer_cost = $all_total;
            } else if ($row_chk['spare_cost'] == 2 && $row_chk['service_cost'] == 2) {
                $branch_cost = $all_total;
            } else {
                if ($row_chk['spare_cost'] == 1) {
                    $customer_cost = $total_spare;
                } else {
                    $branch_cost = $total_spare;
                }

                if ($row_chk['service_cost'] == 1) {
                    $customer_cost = $income_total;
                } else {
                    $branch_cost = $income_total;
                }
            }
        } else {

            $customer_cost = $all_total;
            $branch_cost = '0';

            $only = 'readonly';

            $business_id = $row_job1['business_group_id'];
        }

        // if ($row_chk['spare_cost'] == 1 && $row_chk['service_cost'] == 1) {
        //     $customer_cost = $all_total;
        // } else if ($row_chk['spare_cost'] == 2 && $row_chk['service_cost'] == 2) {
        //     $branch_cost = $all_total;
        // } else {
        //     if ($row_chk['spare_cost'] == 1) {
        //         $customer_cost = $total_spare;
        //     } else {
        //         $branch_cost = $total_spare;
        //     }

        //     if ($row_chk['service_cost'] == 1) {
        //         $customer_cost = $income_total;
        //     } else {
        //         $branch_cost = $income_total;
        //     }
        // }

        ?>
        <div class="row">
            <input id="ref_type" name="ref_type" value="2" type="hidden">
            <input id="business_group_id" name="business_group_id" value="<?php echo $business_id ?>" type="hidden">
        <input id="customer_id" name="customer_id" value="<?php echo $row_job1['customer_id'] ?>" type="hidden">
            <div class="col-4 mb-3">
                <strong><label for="">
                        ค่าอะไหล่
                    </label></strong><br>
                <input type="text" readonly class="form-control" name="spare_total" id="spare_total" value="<?php echo number_format($total_spare) ?>">
            </div>
            <div class="col-4 mb-3">
                <strong><label for="">
                        ค่าบริการ
                    </label></strong><br>
                <input type="text" readonly class="form-control" name="service_total" value="<?php echo number_format($income_total) ?>">
            </div>
            <div class="col-4 mb-3">
                <strong><label for="">
                        ยอดรวมทั้งสิ้น
                    </label></strong><br>
                <input type="text" readonly class="form-control" name="all_total" id="all_total" value="<?php echo number_format($all_total) ?>">
            </div>

            <div class="col-4 mb-3" id="transfer">
                <label for="quantity">
                    วางบิล
                </label>
                <font color="red">**</font><br>
                <input type="text" id="customer_cost" onchange="chk_total()" <?php echo $only ?> name="customer_cost" value="<?php echo $customer_cost ?>" class="form-control">
            </div>

            <div class="col-8 mb-3" id="transfer">

            </div>

            <div class="col-8">
                <div class="row">
                    <div class="col-6 mb-3" id="cash">
                        <label for="quantity">
                            ร้านชำระ
                        </label>
                        <font color="red">**</font><br>
                        <input type="text" id="branch_cost" onchange="chk_total()" <?php echo $only ?> name="branch_cost" value="<?php echo $branch_cost ?>" class="form-control">
                    </div>


                    <div class="col-6 mb-3" id="cash">
                        <label for="quantity">
                            เงินสด
                        </label>
                        <font color="red">**</font><br>
                        <input type="text" id="cash_amount" onchange="check_amount()" <?php echo $only ?> name="cash_amount" value="0" class="form-control">
                    </div>
                    <div class="col-6 mb-3" id="transfer">
                        <label for="quantity">
                            เงินโอน
                        </label>
                        <font color="red">**</font><br>
                        <input type="text" id="transfer_amount" onchange="check_amount()" <?php echo $only ?> name="transfer_amount" value="0" class="form-control">
                    </div>

                    <div class="col-6 mb-3" id="bank">
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

                </div>
            </div>


            <div class="col-4 mb-3" id="img">
                <div class="BroweForFile1">
                    <div id="show_image">
                        <label for="upload_file">
                            <a>
                                <img id="blah" src="upload/No-Image.png" width="100" height="150" />
                            </a>
                        </label>
                    </div><br />
                    <input type="file" id="upload_file" multiple style="width:225px;" name="image1[]" onchange="ImageReadURL(this,value);">
                </div>
            </div>
            <div class="col-12 mb-3" id="note">
                <label for="quantity">
                    หมายเหตุ
                </label><br>
                <textarea type="text" id="payment_note" name="payment_note" class="form-control summernote"></textarea>
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
        load_table_job_payment1();

        $(".datepicker2").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            format: 'dd-mm-yyyy',
            autoclose: true,
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

    function load_table_job_payment1() {

        var group_pm_id = $('#group_pm_id').val();

        $.ajax({
            type: 'POST',
            url: 'ajax/CM_view/group_pm/getTable_job_payment.php',
            data: {
                group_pm_id: group_pm_id
            },
            dataType: 'html',
            success: function(response) {
                $('#show_table_pm_payment').html(response);
                $('#tbl_group_payment').DataTable({
                    pageLength: 25,
                    responsive: true,
                });
                $('#Loading_job').hide();
            }
        });
    }


    function chk_total() {

        var branch_cost = $('#branch_cost').val();
        var customer_cost = $('#customer_cost').val();
        var chk_price = parseInt(branch_cost) + parseInt(customer_cost);
        var all_total = $('#all_total').val();

        // console.log(parseInt(chk_price));
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

        var branch_cost = $('#branch_cost').val();
        var account_id = $('#account_id').val();
        var customer_cost = $('#customer_cost').val();
        var formData = new FormData($("#form-add_group")[0]);

        if (branch_cost == '' || customer_cost == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }
        if (parseInt(branch_cost) > 0) {
            if (account_id == '') {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณาเลือกบัญชี',
                    type: 'error'
                });
                return false;
            }
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
                url: 'ajax/CM_view/payment/Add_job_payment.php',
                data: formData,
                processData: false,
                contentType: false,
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


                        $(".tab_head").removeClass("active");
                        $(".tab_head h4").removeClass("font-weight-bold");
                        $(".tab_head h4").addClass("text-muted");
                        $(".tab-pane").removeClass("show");
                        $(".tab-pane").removeClass("active");
                        $("#tab_head_7").children("h4").removeClass("text-muted");
                        $("#tab_head_7").children("h4").addClass("font-weight-bold");
                        $("#tab_head_7").addClass("active");

                        current_fs = $(".active");

                        // next_fs = $(this).attr('id');
                        // next_fs = "#" + next_fs + "1";


                        $('#tab-7').addClass("active");

                        current_fs.animate({}, {
                            step: function() {
                                current_fs.css({
                                    'display': 'none',
                                    'position': 'relative'
                                });
                                next_fs.css({
                                    'display': 'block'
                                });
                            }
                        });
                        load_table_job_payment();


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
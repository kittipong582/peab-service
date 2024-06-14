<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$product_id = $_GET['id'];

$sql = "SELECT * FROM tbl_product a
    LEFT JOIN tbl_product_type b ON a.product_type = b.type_id
     WHERE a.product_id = '$product_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);


$brand_id = $row['brand_id'];
$model_id = $row['model_id'];
$serial_no = $row['serial_no'];


$product_type = $row['type_code'] . " " . $row['type_name'];





$sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result_brand  = mysqli_query($connect_db, $sql_brand);
$row_brand = mysqli_fetch_array($result_brand);

$sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result_model  = mysqli_query($connect_db, $sql_model);
$row_model = mysqli_fetch_array($result_model);

$current_branch_id = $row['current_branch_id'];
$sql_cus_branch = "SELECT * FROM tbl_customer_branch 
 WHERE customer_branch_id = '$current_branch_id'";
$result_cus_branch  = mysqli_query($connect_db, $sql_cus_branch);
$row_cus_branch = mysqli_fetch_array($result_cus_branch);


$customer_id = $row_cus_branch['customer_id'];
$customer_branch_id = $row_cus_branch['customer_branch_id'];

$sql_customer = "SELECT * FROM tbl_customer WHERE customer_id = '$customer_id'";
$result_customer  = mysqli_query($connect_db, $sql_customer);
$row_customer = mysqli_fetch_array($result_customer);
?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo "[ " . $serial_no . " ] - " . $row['type_code'] ." ". $row['type_name']; ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="product.php?id=<?php echo $customer_branch_id ?>">รายการสินค้า</a>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo "[ " . $serial_no . " ] - " . $product_type ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">

    <div class="col-lg-12">
        <div class="row">
            <?php include('ajax/menu/product_customer_menu.php'); ?>
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
                        <div class="row">
                            <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id ?>">


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>สถานะ</label>
                                    <select class="form-control select2" id="status" name="status" data-width="100%" onchange="GetTable();">
                                        <option value="1" selected>ทั้งหมด </option>
                                        <option value="2">เปิดงาน </option>
                                        <option value="3">อยู่ระหว่างการนำเนินการ </option>
                                        <option value="4">รอปิดงาน </option>
                                        <option value="5">ปิดงานแล้ว </option>
                                        <option value="6">ยกเลิก </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <h4><label></label></h4>
                                <label> <input type="checkbox" class="i-checks" id="chk" name="chk" value="x" onchange="Getdate(),GetTable();">
                                    ไม่ระบุช่วงเวลา
                                </label>
                            </div>

                            <div class="col-md-2" id="sorting_by">
                                <div class="form-group">
                                    <label>อ้างอิงจาก</label>
                                    <select class="form-control select2" id="date_order_by" name="date_order_by" data-width="100%" onchange="GetTable();">
                                        <option value="1" selected>วันที่สร้างรายการ </option>
                                        <option value="2">วันที่นัดหมาย </option>
                                        <option value="3">วันที่ดำเนินการ </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2" id="get_start_date">
                                <label>วันที่</label>

                                <div class="input-group date">

                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo date('d/m/Y', strtotime('-1 month')); ?>" onchange="GetTable();">
                                </div>

                            </div>

                            <div class="col-md-2" id="get_end_date">
                                <label> ถึงวันที่</label>
                                <div class="input-group date">

                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control datepicker" type="text" name="end_date" id="end_date" value="<?php echo date('d/m/Y'); ?>" onchange="GetTable();">
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="ibox-content">
                        <div id="Loading">
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
                        <br>
                        <div id="show_data"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- addmodal -->
    <div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="show_modal"></div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        $(document).ready(function() {
            $('#sorting_by').hide();
            $('#get_start_date').hide();
            $('#get_end_date').hide();
            Getdate();
            GetTable();
        });

        $(".datepicker").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: false,
            format: 'dd/mm/yyyy',
            thaiyear: false,
            language: 'th', //Set เป็นปี พ.ศ.
            autoclose: true
        });


        $(".select2").select2({
            width: "75%"
        });

        $('.summernote').summernote({
            toolbar: false,
            height: 100,
        });

        function Getdate() {

            $("#chk").val(function() {
                if (this.checked) {
                    $('#get_start_date').hide();
                    $('#get_end_date').hide();
                    $('#sorting_by').hide();
                } else {
                    $('#get_start_date').show();
                    $('#get_end_date').show();
                    $('#sorting_by').show();
                }
            });

        }

        function GetTable() {

            var product_id = $('#product_id').val();
            var status = $("#status").val();
            var date_order_by = $("#date_order_by").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            num_chk = 0;
            $("#chk").change(function() {
                if (this.checked) {
                    num_chk = 1;
                } else {
                    num_chk = 0;
                }
                $("#chk").val(num_chk);
            });

            var chk = $("#chk").val();

            $.ajax({
                type: 'POST',
                url: "ajax/product/History.php",
                data: {
                    status: status,
                    date_order_by: date_order_by,
                    start_date: start_date,
                    end_date: end_date,
                    product_id: product_id,
                    chk: chk
                },
                dataType: "html",
                success: function(response) {
                    $("#show_data").html(response);
                    $('table').DataTable({
                        pageLength: 25,
                        responsive: true,
                        "ordering": false,
                    });
                    $('#Loading').hide();
                }
            });
        }
    </script>
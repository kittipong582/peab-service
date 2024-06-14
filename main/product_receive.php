<?php
include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_branch_id = $_GET['id'];
$sql = "SELECT * FROM tbl_product_transfer a
LEFT JOIN tbl_product b ON a.product_id = b.product_id
 WHERE a.to_branch_id = '$customer_branch_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$brand_id = $row['brand_id'];
$model_id = $row['model_id'];
$serial_no = $row['serial_no'];


if ($row['product_type'] == 1) {
    $product_type = 'เครื่องชง';
} else if ($row['product_type'] == 2) {
    $product_type = 'เครื่องบด';
} else if ($row['product_type'] == 3) {
    $product_type = 'เครื่องปั่น';
}

$sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result_brand  = mysqli_query($connect_db, $sql_brand);
$row_brand = mysqli_fetch_array($result_brand);

$sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result_model  = mysqli_query($connect_db, $sql_model);
$row_model = mysqli_fetch_array($result_model);

$current_branch_id = $row['to_branch_id'];
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
        <h2><?php echo $row_cus_branch['branch_name'] ?> - <?php echo $row_customer['customer_name'] ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_branch_list.php">รายการลูกค้า</a>
            </li>
            <li class="breadcrumb-item">
                <a href="branch_view_detail.php?id=<?php echo $customer_branch_id ?>"><?php echo $row_cus_branch['branch_name'] ?></a>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo "รายการรับโอน" ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">

    <div class="col-lg-12">
        <div class="row">
            <?php include('ajax/menu/branch_customer_menu.php'); ?>
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
                        <div class="row">
                            <input type="hidden" id="to_branch_id" name="to_branch_id" value="<?php echo $current_branch_id ?>">
                            <div class="col-12 mb-3">
                                <!-- <button class="btn btn-sm btn-info " style="float: right;" onclick="ModalTransfer('<?php echo $product_id ?>');">โอนย้าย</button> -->
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



        function GetTable() {

            var to_branch_id = $('#to_branch_id').val();

            $.ajax({
                type: 'POST',
                url: "ajax/product_receive/GetTable.php",
                data: {
                    to_branch_id: to_branch_id
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


        function ModalTransfer(product_id) {

            $.ajax({
                type: "post",
                url: "ajax/product_receive/ModalTransfer.php",
                data: {
                    product_id: product_id
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


        function ModalReceive(transfer_id) {

            $.ajax({
                type: "post",
                url: "ajax/product_receive/ModalReceive.php",
                data: {
                    transfer_id: transfer_id
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
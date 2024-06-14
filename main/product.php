<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_GET['id'];

$sql = "SELECT a.*, (a.branch_id) AS id,b.*,(b.branch_name) AS b_name  FROM tbl_branch a 
LEFT JOIN tbl_customer_branch b ON a.branch_id = b.branch_care_id WHERE b.customer_branch_id = '$customer_branch_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$customer_id = $row['customer_id'];

$sql_customer = "SELECT * FROM tbl_customer WHERE customer_id = '$customer_id'";
$result_customer  = mysqli_query($connect_db, $sql_customer);
$row_customer = mysqli_fetch_array($result_customer);

$branch_id = $row['id'];
/////////////////////////นับเครื่องชง///////////////////////////////////////
$sql_product1 = "SELECT COUNT(product_id) AS num_1 FROM tbl_product WHERE branch_id = '$branch_id' and product_type = 1";
$result_product1  = mysqli_query($connect_db, $sql_product1);
$row_product1 = mysqli_fetch_array($result_product1);

/////////////////////////นับเครื่องบด///////////////////////////////////////
$sql_product2 = "SELECT COUNT(product_id) AS num_2 FROM tbl_product WHERE branch_id = '$branch_id' and product_type = 2";
$result_product2  = mysqli_query($connect_db, $sql_product2);
$row_product2 = mysqli_fetch_array($result_product2);

/////////////////////////นับเครื่องปั่น///////////////////////////////////////
$sql_product3 = "SELECT COUNT(product_id) AS num_3 FROM tbl_product WHERE branch_id = '$branch_id' and product_type = 3";
$result_product3 = mysqli_query($connect_db, $sql_product3);
$row_product3 = mysqli_fetch_array($result_product3);
?>
<style>
    .box-input {
        min-height: 90px;
    }
</style>

<style>
    .line-vertical {
        border-left: 1px solid rgba(0, 0, 0, .1);
        ;
        height: 90%;
        position: absolute;
        left: 50%;

    }

    .hidden-color {
        display: none;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo $row['branch_name'] ?> - <?php echo $row_customer['customer_name'] ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_branch_list.php">รายการลูกค้า</a>
            </li>
            <li class="breadcrumb-item">
                <a href="branch_view_detail.php?id=<?php echo $customer_branch_id ?>"><?php echo $row['b_name'] ?></a>
            </li>
            <li class="breadcrumb-item active">
                <strong>รายการสินค้า</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <?php include('ajax/menu/branch_customer_menu.php'); ?>
    </div>
    <div class="ibox">
        <div class="ibox-title" style="padding: 15px 15px 8px 15px;">
            <div class="row">
                <div class="col-6">
                    <button class="btn btn-primary btn-xs" onclick=" ModalAdd('<?php echo $row['customer_branch_id'] ?>')" type="button">
                        <i class="fa fa-plus">เพิ่มสินค้า</i>
                    </button>
                </div>

            </div>
        </div>
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
        <div class="ibox-content" id="show_data">

        </div>
    </div>
</div>
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {
        GetTable('<?php echo $customer_branch_id ?>');
    });

    function GetTable(customer_branch_id) {
        $.ajax({
            type: "post",
            url: "ajax/product/GetTable.php",
            data: {
                customer_branch_id: customer_branch_id
            },
            dataType: "html",
            success: function(response) {
                $("#show_data").html(response);
                $('table').DataTable({
                    pageLength: 25,
                    responsive: true
                });
                $('#Loading').hide();
            }
        });
    }

    function ModalAdd(branch_id) {
        $.ajax({
            type: "post",
            url: "ajax/product/ModalAdd.php",
            data: {
                branch_id: branch_id
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


    function ModalEdit(product_id) {


        $.ajax({
            type: "post",
            url: "ajax/product/ModalEdit.php",
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
                setwarranty();
            }
        });
    }

    function ChangeStatus(button, product_id) {
        $.ajax({
            type: "post",
            url: "ajax/product/ChangeStatus.php",
            data: {
                product_id: product_id
            },
            dataType: "json",
            success: function(response) {

                if (response.result == 1) {

                    if (response.status == 1) {
                        $(button).addClass('btn-info').removeClass('btn-danger').html('กำลังใช้งาน');
                    } else if (response.status == 0) {
                        $(button).addClass('btn-danger').removeClass('btn-info').html('ยกเลิกใช้งาน');
                    }

                } else {
                    swal("", "ไม่สามารถทำรายการได้กรุณาติดต่อเจ้าหน้าที่", "error");
                }

            }
        });
    }


    function clear_date() {

        $(".datepicker").val('');
    };


    function setwarranty() {

        warranty_val = $('#warranty_type').val();

        $("#div_install").hide();
        $("#div_buy").hide();
        $("#div_start").hide();
        $("#div_end").hide();
        $("#alert").hide();
        $("#alert1").hide();
        $("#alert2").hide();
        $("#alert3").hide();

        if (warranty_val == "1") {
            $("#div_install").show();
            $("#div_buy").show();
            $("#div_start").show();
            $("#div_end").show();
            $("#alert").show();
            $("#alert1").show();
            $("#alert2").show();
            $("#alert3").show();



        } else if (warranty_val == "2") {
            $("#div_install").show();
            $("#div_buy").show();
            $("#div_start").show();
            $("#div_end").show();

        } else if (warranty_val == "3") {
            $("#div_install").show();
            $("#div_start").show();
            $("#div_end").show();

            $("#alert").show();
            $("#alert2").show();
            $("#alert3").show();

        }
    }

    function setModel(brand_id) {

        $.ajax({
            type: 'POST',
            url: 'ajax/product/getModel.php',
            data: {
                brand_id: brand_id,
            },
            dataType: 'html',
            success: function(response) {
                $('#getmodel').html(response);
                $(".select2").select2({});
            }
        });

    }


    function update_product() {

        var product_type = $('#product_type').val();
        var brand_id = $('#brand_id').val();
        var model_id = $('#model_id').val();
        var serial_no = $('#serial_no').val();
        var div_install = $("#install_date").val();
        var div_buy = $("#buy_date").val();
        var div_start = $("#warranty_start_date").val();
        var div_end = $("#warranty_end_date").val();

        var warranty_type = $("#warranty_type").val();

        if (warranty_type == 1) {

            if (product_type == "" || model_id == "" || serial_no == "" || brand_id == "" || div_install == "" || div_buy == "" || div_start == "" || div_end == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
        } else if (warranty_type == 2) {

            if (product_type == "" || model_id == "" || serial_no == "" || brand_id == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
        } else if (warranty_type == 3) {
            if (product_type == "" || model_id == "" || serial_no == "" || brand_id == "" || div_install == "" || div_start == "" || div_end == "") {
                swal({
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    type: 'error'
                });
                return false;
            }
        }
        swal({
            title: "",
            text: "กรุณายืนยันการทำรายการ",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00FF00",
            confirmButtonText: "ยืนยัน",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function() {

            let myForm = document.getElementById('form-edit');
            let formData = new FormData(myForm);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax/product/Update.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.result == 1) {
                        swal({
                            title: "",
                            text: "ดำเนินการสำเร็จ",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        }, function() {
                            swal.close();
                            $("#modal").modal('hide');
                            GetTable(response.customer_branch_id);

                        });
                    } else {
                        swal("", "ไม่สามารถทำรายการได้ serial no ซ้ำ", "error");
                    }

                }
            });

        });
    }
</script>
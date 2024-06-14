<?php

include('header.php');
include("../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$sql_customer = "SELECT * FROM tbl_customer WHERE active_status = '1' ";
$res_customer = mysqli_query($connect_db, $sql_customer);
?>


<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>ลงทะเบียน QR Code</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="qrcode_register.php">ลงทะเบียน QR Code</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox">
        <div class="ibox-title">

        </div>

        <div class="ibox-content item-center" id="form-register">

            <center>
                <div class="mb-3">
                    <label for="">QR Code</label>
                    <input type="text" class="form-control w-50" id="qr_register" name="qr_register" style="align-items: absolute;">
                </div>
            </center>

            <div class="row">
                <div class="col-1"></div>
                <div class="col-4">
                    <div id="customer_div" hidden>
                        <div class="form-group">
                            <label>ลูกค้า</label>
                            <select class="form-control select2" id="customer" name="customer" data-width="100%" onchange="GetBranch()">
                                <?php while ($row_customer = mysqli_fetch_assoc($res_customer)) { ?>
                                    <option value="<?php echo $row_customer['customer_id']; ?>"><?php echo $row_customer['customer_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div id="branch_div" hidden>
                        <div class="form-group">
                            <label>สาขา</label>
                            <select class="form-control select2" id="branch" name="branch" data-width="100%">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div id="register_btn" hidden>
                        <button class="btn btn-primary btn-sm mt-4" onclick="QRRegister()">ลงทะเบียน</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- addmodal -->
<div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
    $(document).ready(function() {

    });

    function GetForm() {
        $("#form-register").load("ajax/qrcode_register/form_register.php", "data", function(response, status, request) {
            this; // dom element

        });
    }

    $("#qr_register").on("keydown", function(e) {
        if (e.which == 13) {
            let qr_register = $("#qr_register").val();
            if (qr_register != "") {

                $.ajax({
                    type: "POST",
                    url: "ajax/qrcode_register/check_qr.php",
                    data: {
                        qr_register: qr_register
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        if (data.result == 1) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: 'QR Code มีการใช้งานแล้ว',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (data.result == 0) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: 'ไม่พบ QR Code',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (data.result == 9) {
                            swal({
                                title: 'แจ้งเตือน',
                                text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                                type: 'warning',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (data.result == 'ok') {
                            GetBranch()
                            $("#customer_div").attr("hidden", false);
                            $("#branch_div").attr("hidden", false);
                            $("#register_btn").attr("hidden", false);
                        }
                    }
                });


            }
        }

    })

    $(".select2").select2({
        width: "75%"
    });

    function GetBranch() {
        let customer_id = $("#customer").val();

        $.ajax({
            type: "POST",
            url: "ajax/qrcode_register/get_branch.php",
            data: {
                customer_id: customer_id
            },
            dataType: "html",
            success: function(response) {
                $("#branch").html(response);
            }
        });
    }

    function QRRegister() {
        let qr_register = $("#qr_register").val();
        let customer_id = $("#customer").val();
        let branch = $("#branch").val();
        $.ajax({
            type: "POST",
            url: "ajax/qrcode_register/qr_update.php",
            data: {
                qr_register: qr_register,
                customer_id: customer_id,
                branch: branch
            },
            dataType: "json",
            success: function(data) {
                if (data.result == 1) {
                    swal({
                        title: 'ลงทะเบียนเรียบร้อย',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }, function() {
                        swal.close();
                        $("#qr_register").val('');
                        $("#customer_div").attr("hidden", true);
                        $("#branch_div").attr("hidden", true);
                        $("#register_btn").attr("hidden", true);
                    });
                } else if (data.result == 0) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: '',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if (data.result == 9) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });

    }
</script>